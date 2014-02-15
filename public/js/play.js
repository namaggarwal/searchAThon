	var map,
	mapSmall,
	panaroma,
	autocomplete,
	min=5,
	sec=0,
	minObj = $("#min"),
	secObj = $("#sec"),
	marker = [],
	score = 10,
	tempMarkers = [];
      
      function initializeMap(lat,lng) {
      	
      	var location = new google.maps.LatLng(lat,lng);
        var mapOptions = {
          	center: location,
           zoom: 18,
           panControl: false,
           scrollwheel: false,
           zoomControl: false,
           scaleControl: false,
           streetViewControl: true,
           streetViewControlOptions: {
           mapTypeControl: false,
           mapTypeId: google.maps.MapTypeId.ROADMAP
   			}
        };

        var mapOptionsSmall = {
          	center: location,
           zoom: 13,
           panControl: false,
           scrollwheel: false,
           zoomControl: true,
           scaleControl: false,
           streetViewControl: false           
        };


        
        map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
        mapSmall = new google.maps.Map(document.getElementById("map-small"),mapOptionsSmall);
		
		panaroma = map.getStreetView();
		
		var astorPlace = new google.maps.LatLng(lat,lng);
		panaroma.setPosition(astorPlace);
		panaroma.setPov(({
			heading: 265,
    		pitch: 0}
    	));
		panaroma.setVisible(true);

		google.maps.event.addListener(panaroma, 'position_changed',onPanaromaChange);

		var input = document.getElementById('search_place');
		var options = {
			 	
		};

		autocomplete = new google.maps.places.Autocomplete(input, options);
		google.maps.event.addListener(autocomplete, 'place_changed',onPlacesChanged);


      }      

      $(document).ready(function(){      
      	createInitialMaps();
      	$("#hint_button").on("click",onHintClick);
      });

	  function createInitialMaps(){
	  	
	  	$.ajax({

	  		url:$("#base-url").val()+"/play?info=getLocation",
	  		type:"GET",
	  		success:function(data){
	  			var loc = $.parseJSON(data);
	  			initializeMap(loc.LAT,loc.LONG);
	  			getFriendLocations();




	  		},
	  		error:function(err){
	  			console.log(err);
	  		}

	  	});

	  }

	  function getFriendLocations(){

	  	$.ajax({

	  		url:$("#base-url").val()+"/play?info=getFriendsLocation",
	  		type:"GET",
	  		success:function(data){

	  			var friendsData = $.parseJSON(data);

	  			createFriendsMarkers(friendsData);
	  			updateTimer();

	  		},
	  		error:function(err){
	  			console.log(err);
	  		}

	  	});


	  }

	  function updateTimer(){

	  	if(sec == 0){
	  		if(min == 0){
	  			alert("end");
	  			return;
	  		}else{

	  			min--;
	  			sec=59;
	  		}

	
	  	}else{
			sec--;	  		

	  	}

	  	minObj.html(formatTime(min));
	  	secObj.html(formatTime(sec));

	  	setTimeout(updateTimer,1000);
	
	  }

	  function formatTime(t){

	  	if(t<10){
	  		return "0"+t;
	  	}
	  	return t;
	  }


	  function createFriendsMarkers(fData){

	  	for(var i in fData){

	  		marker[i] = new google.maps.Marker({
			    position: new google.maps.LatLng(fData[i]["LAT"],fData[i]["LONG"]),
		        map: map,
		        //Change this
		        icon: 'https://cdn1.iconfinder.com/data/icons/perfect-flat-icons-2/512/Location_marker_pin_map_gps.png',
		        title: fData[i]["NAME"]
		  	});

	  		(function(mData,mark){
	  			google.maps.event.addListener(mark, 'click', function() {
			    	markerFound(mData);
				});
			})(fData[i],marker[i]);
		  	var str = '<div class="names" data-id="'+i+'">'+fData[i]["NAME"]+'<div>';
		  	$("#name-data").append(str);
	  	}

	  	 
	  }

	  function markerFound(data){

	  	 alert(data["NAME"]);
	  	 marker[data["KEY"]].setMap(null);
	  }

	  function onPanaromaChange(){

	  	console.log(panaroma.getPosition());
	  }
		
	  function onPlacesChanged(){
	  	
	  	var location = autocomplete.getPlace().geometry.location;
	  	var latlng = new google.maps.LatLng(location.d,location.e);
	  	mapSmall.setCenter(latlng);
	  	panaroma.setPosition(latlng);

	  }		
	   
	   function onHintClick(){
	   	score = score-5;
	   	$("#score-card").html(formatTime(score));
	   }


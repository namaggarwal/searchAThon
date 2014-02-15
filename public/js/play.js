	var map,
	mapSmall,
	panaroma,
	autocomplete,
	min=5,
	sec=10,
	city = '',
	minObj = $("#min"),
	secObj = $("#sec"),
	marker = [],
	score = 5,
	mymarker='',
	currentmarker,
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
		var webService = new google.maps.StreetViewService();	  	
	  	var checkaround = 5000;
	  	webService.getPanoramaByLocation(astorPlace,checkaround ,gotoNearestStreetView);
		

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
      	$("#start-button").on("click",startGame);
      });

	  function createInitialMaps(){
	  	$("#message").html("Getting your location....");
	  	$.ajax({

	  		url:$("#base-url").val()+"/play?info=getLocation",
	  		type:"GET",
	  		success:function(data){
	  			var loc = $.parseJSON(data);
	  			initializeMap(loc.LAT,loc.LONG);	  			
	  			getFriendLocations();	  			


	  		},
	  		error:function(err){
	  			$("#message").html("Oops something is wrong....");
	  		}

	  	});

	  }

	  function getFriendLocations(){
	  	$("#message").html("Hiding your friends....");
	  	$.ajax({

	  		url:$("#base-url").val()+"/play?info=getFriendsLocation",
	  		type:"GET",
	  		success:function(data){

	  			var friendsData = $.parseJSON(data);

	  			createFriendsMarkers(friendsData);
	  			$("#message").html("Click start to begin....");
	  			showStart();	  			
	  		},
	  		error:function(err){
	  			$("#message").html("Oops something is wrong....");
	  			console.log(err);
	  		}

	  	});


	  }

	  function updateTimer(){

	  	if(sec == 0){
	  		if(min == 0){
	  			$("#myScore").val(score);
	  			$("#submitScore").submit();
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
	  		//console.log(fData);
	  		marker[i] = new google.maps.Marker({
			    position: new google.maps.LatLng(fData[i]["LAT"],fData[i]["LONG"]),
		        map: map,
		        //Change this
		        icon: fData[i]["URL"],
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
	  	 
	  	 marker[data["KEY"]].setMap(null);
	  	 $(".names[data-id='"+data["KEY"]+"']").remove();
	  	 score+=10;
	  	 updateScore();
	  	 delete marker[data["KEY"]];
	  }

	  function onPanaromaChange(){

	  	if(currentmarker){
	  		currentmarker.setPosition(panaroma.getPosition());
	  	}else{
  			currentmarker  = new google.maps.Marker({
			    position: panaroma.getPosition(),
		        map: mapSmall,
		        //Change this
		        icon: ' http://maps.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png'		        
		  	});
	  	}
	  	

	  }
		
	  function onPlacesChanged(){
	  	
	  	var location = autocomplete.getPlace().geometry.location;
	  	var latlng = new google.maps.LatLng(location.d,location.e);
	  	mapSmall.setCenter(latlng);
	  	var webService = new google.maps.StreetViewService();	  	
	  	var checkaround = 5000;
	  	webService.getPanoramaByLocation(latlng,checkaround ,gotoNearestStreetView);

	  	

	  }		

	  function gotoNearestStreetView(panoData){	  	
		    if(panoData){

		         if(panoData.location){

		            if(panoData.location.latLng){
		                /**Well done you can use a nearest existing street view coordinates**/
		                panaroma.setPosition(panoData.location.latLng);
		                panaroma.setPov(({
							heading: 265,
    					pitch: 0}
    					));
						panaroma.setVisible(true);
		            }
		        }
		    }
		    /** Else do something... **/
		}

	   
	   function onHintClick(){
	   	if(score<= 0){
	   		alert("Sorry you cannot take more hint");
	   		return;
	   	}
	   	score -= 5;
	   	for(var i in marker){
	   		
	   		tempMarkers[i]   = new google.maps.Marker({
			    position: new google.maps.LatLng(marker[i].position.d,marker[i].position.e),
		        map: mapSmall,
		        //Change this
		        icon: ' http://maps.google.com/intl/en_us/mapfiles/ms/micons/green-dot.png'		        
		  	});
	   	}
	   	
	   	

	   	updateScore();
	   	setTimeout(clearTemporaryMarkers,5000);
	   }

	   function updateScore(){
	   	$("#score-card").html(formatTime(score));
	   }

	   function clearTemporaryMarkers(){

	   		for(var i in tempMarkers){
				tempMarkers[i].setMap(null);
				delete tempMarkers[i];
	   		}

	   }

	   function showStart(){

	   		$("#start-button").css("display","inline-block");

	   }

	   function removeMask(){

	   		$("#mask").hide();
	   		$("#messageBox").hide();
	   		
	   }

	   function startGame(){
	   	removeMask();
	   	updateTimer();
	   }


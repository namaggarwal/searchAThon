	var map,
	panaroma,
	marker = [];
      
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
           mapTypeControl: true,
           mapTypeId: google.maps.MapTypeId.ROADMAP
   			}
        };
        
        map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
		
		panaroma = map.getStreetView();
		
		var astorPlace = new google.maps.LatLng(lat,lng);
		panaroma.setPosition(astorPlace);
		panaroma.setPov(({
			heading: 265,
    		pitch: 0}
    	));
		panaroma.setVisible(true);

		google.maps.event.addListener(panaroma, 'position_changed',onPanaromaChange);


      }      

      $(document).ready(function(){      
      	createInitialMaps();
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

	  		},
	  		error:function(err){
	  			console.log(err);
	  		}

	  	});


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
		  	
	  	}

	  	 
	  }

	  function markerFound(data){

	  	 alert(data["NAME"]);
	  	 marker[data["KEY"]].setMap(null);
	  }

	  function onPanaromaChange(){

	  	console.log(panaroma.getPosition());
	  }
			
	   


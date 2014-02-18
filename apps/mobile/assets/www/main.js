var imageBaseDomain = 'http://$host/uploads/thumbnail/';
var bigImageBaseDomain = 'http://$host/uploads/photos/';
var uploadURL = 'http://$host/uploads/photo/upload';
var overviewURL = 'http://$host/frontend_dev.php/photo/browse';
var loginURL = 'http://$host/frontend_dev.php/user/login';
var registerURL = 'http://$host/frontend_dev.php/user/register';
var getThemeURL = 'http://$host/frontend_dev.php/theme/index';

var home = (function(){
	return {
		initLocation: function(){
			var suc = function(p){
				home.setLocationByLatLon(p.coords.latitude, p.coords.longitude);
			};
			var fail = function(){};
			navigator.geolocation.getCurrentPosition(suc, fail);
		},
		
		setLocationByLatLon: function(lat, lon){
			$.ajax({
			  url: 'https://maps.googleapis.com/maps/api/geocode/json',
				data: 'latlng='+lat+','+lon+'&sensor=true',
				async: false,
			  success: function(JSONResult) {
					if(JSONResult.results[0].formatted_address) {
						$('#location').text(JSONResult.results[0].formatted_address);
					}
			  },
				error: function(){
				},
				dataType: "json"
			});
		},
		
		
		index: function(){
			home.load();
			$.mobile.changePage("index.html#home", "slideup", true, true );
		},
		
		addPhoto: function(name, createdAt){
			var anchor = $('<a></a>');
			anchor.attr('href', '#photoDetail');
			anchor.attr('class', 'photo');
			var img = $('<img></img>').attr('src', imageBaseDomain+name);
			anchor.append(img);
			
			anchor.bind('click', function() {
			  $("#big-photo").attr("src", bigImageBaseDomain+name); 
			  window.location="#photoDetail";
			  return false;
			});
			
			return anchor;
		},
		
		resetForm: function(id){
			document.getElementById(id).reset(); 
		},
		
		saveUser: function(name){
			window.localStorage.setItem("userName", name);
		},
		
		loadTheme: function(){
			$.ajax({
			  url: getThemeURL,
				type: 'POST',
				error: function(){
					navigator.notification.alert('Server is busy, please try it again later.');
				},
			  success: function(data) {
					if(data){
						$('#theme-id').val(data.id);
						$('.theme-title').text(data.t);
						$('#theme-description').html(data.d);
					}
			  },
				dataType: "json"
			});	
		},
		
		load : function(){
			$.ajax({
			  url: overviewURL,
				type: 'POST',
				error: function(){
					navigator.notification.alert('Server is busy, please try it again later.');
				},
				beforeSend: function(){
					// $('#loading').show();
				},
			  success: function(data) {
					if(data.length > 0){
						$('#overview').html('');
						for(var i = 0 ; i < data.length; i++){
					    $('#overview').append( home.addPhoto(data[i].title, data[i].createdAt) );
						}
					}else{
						
					}
			  },
				dataType: "json"
			});
		},
		
		registerListeners: function(){
			$("#loginSubmit").click(function(){
       	var formData = $("#loginForm").serialize();
        $.ajax({
            type: "POST",
            url: loginURL,
						dataType: "json",
            cache: false,
            data: formData,
            success: function(data, status){
							navigator.notification.alert('Opening the camera.');
							if(data.success){
								home.saveUser(data.name);
								user.loadMyName();
								home.resetForm("loginForm");
								camara.capturePhoto();
							}else{
								navigator.notification.alert('Login Failed.');
								home.resetForm("loginForm");
								home.index();
							}
						},
            error: function(data, status){
							home.resetForm("loginForm");
							navigator.notification.alert('Login Failed.');
							home.index();
					  }
        });
        return false;
     });


			$("#registerSubmit").click(function(){
				var formData = $("#registerForm").serialize();
				$.ajax({
					type: "POST",
					url: registerURL,
					dataType: "json",
					cache: false,
					data: formData,
					success: function(data, status){
						if(data.success == 1){
							home.saveUser(data.name);
							user.loadMyName();
							home.resetForm("registerForm");
							camara.capturePhoto();
						}else if(data.success == 2){ //duplicated user name	
							home.resetForm("registerForm");
							navigator.notification.alert('This user name is already registered, please choose another one.');
						}else{	
							home.resetForm("registerForm");
							navigator.notification.alert('Registration Failed.');
							home.index();
						}
					},
					error: function(data, status){
						navigator.notification.alert('Registration Failed.');
						home.index();
					}
				});
				return false;
    });


		},
		
		init: function(){
			this.initLocation();
			this.loadTheme();
			this.load();
			this.registerListeners();
			user.loadMyName();
		}
	}
})();

var user =  (function(){
	return {
		loadMyName : function(){
			if(window.localStorage.getItem("userName")){
				$('#myName').html(window.localStorage.getItem("userName"));
			}
		},
		
		isLogin: function(){
			if(window.localStorage.getItem("userName")){
				return true;
			}
			
			return false;
		}
	}
})();

var camara = (function(){
	return {		
		onFail: function(message){
      alert('Failed because: ' + message);
    },

		saveTmpPhotoURI: function(imageURI){
			window.localStorage.setItem("tmpImageURI", imageURI);
		},
		
		getTmpPhotoURI: function(){
			return window.localStorage.getItem("tmpImageURI");
		},
		
		clearTmpPhotoURI: function(){
			window.localStorage.setItem("tmpImageURI", '');
		},
		
		onPhotoURISuccess: function (imageURI) {
      // Uncomment to view the image file URI 
      // console.log(imageURI);
			$.mobile.changePage("index.html#upload", "fade", true, true);
      // Get image handle
      var largeImage = document.getElementById('previewImage');

      // Unhide image elements
      largeImage.style.display = 'block';

      // Show the captured photo
      // The inline CSS rules are used to resize the image
      largeImage.src = imageURI;
			camara.saveTmpPhotoURI(imageURI);
    },

		upload: function() {
			$.mobile.showPageLoadingMsg('is uploading...');
			
			imageURI = camara.getTmpPhotoURI();
			if(imageURI == undefined){
				navigator.notification.alert('Upload Failed.');
				home.index();
				return false;
			}
			var ft = new FileTransfer();
			
			var options = new FileUploadOptions();
			options.fileKey="file";
			options.fileName=imageURI.substr(imageURI.lastIndexOf('/')+1);
			options.mimeType="image/jpeg";
			
			var params = new Object();
			params.userName = window.localStorage.getItem("userName");
			params.userPwd = window.localStorage.getItem("userPwd");
			params.photoDesc = $('#photoDesc').val();
			params.photoLocation = $('#location').text();
			params.themeId = $('#theme-id').val();
			options.params = params;
			
			ft.upload(imageURI, uploadURL, 
				function(r) {
					console.log('-----upload success--');
					navigator.notification.alert('Upload Successful!');
					home.index();
					$.mobile.hidePageLoadingMsg();
				},
				function(message) {
					console.log('----- Failed because: ' + message);
					navigator.notification.alert('Upload Failed!');
					home.index();
					$.mobile.hidePageLoadingMsg();
				},
				options);
		},
		
		capturePhoto: function(){
			if(!user.isLogin()){
				$.mobile.changePage("index.html#login", "pop", true, true );
				return;
			}
			camara.clearTmpPhotoURI();
			$.mobile.changePage("index.html#upload",  "fade", true, true);
			// Take picture using device camera and retrieve image as base64-encoded string
      navigator.camera.getPicture(
				this.onPhotoURISuccess, 
				this.onFail,
				{ quality: 50, destinationType: Camera.DestinationType.FILE_URI, targetWidth: 800, targetHeight: 800 }
			);
		},
		
		capturePhotoEdit : function(){
			// Take picture using device camera, allow edit, and retrieve image as base64-encoded string 
			navigator.camera.getPicture(this.onPhotoURISuccess, this.onFail, { quality: 20, allowEdit: true, destinationType: Camera.DestinationType.FILE_URI  }); 
		},
		
		getPhoto: function(source) {
      // Retrieve image file location from specified source
      navigator.camera.getPicture(this.onPhotoURISuccess, this.onFail, 
				{
					quality: 50, 
        	destinationType: destinationType.FILE_URI,
        	sourceType: source 
				}
			);
    },
		
		onDeviceReady: function(){
      pictureSource=navigator.camera.PictureSourceType;
      destinationType=navigator.camera.DestinationType;
    }
	}
})();

function init(){
  camara.onDeviceReady();
	home.init();
}

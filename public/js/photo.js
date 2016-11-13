(function(){
  var video = document
                .getElementById('video'),
      canvas = document
                .getElementById('canvas'),
      context = canvas
                .getContext('2d'),
      photo = document
                .getElementById('photo'),
      vendorUrl = window.URL ||
                  window.webkitURL;
  var capture_video = function() {
    navigator.getMedia =      navigator
                                .getUserMedia
                          ||  navigator
                                .webkitGetUserMedia
                          ||  navigator
                                .mozGetUserMedia
                          || navigator
                                .msGetUserMedia;
    navigator.getMedia({
      video: true,
      audio: false,
    }, function(stream) {
      // success callback
      document.track = stream.getTracks()[0];
      if(navigator.mozGetUserMedia)
      {
          // @info: if it's a mozilla navigator,
          // use mozilla simplified function to deal with stream
          video.mozSrcObject = stream;
      } else {
        video.src = vendorUrl
                      .createObjectURL(stream);
      }
      video.play();
    }, function(err) {
      // An error occured
      // err.code
      console.log("An error occured: " + err);
    });
  }

  //send ajax request
  function makeAjaxReq(method, url, data)
   {
     var httpRequest = false;
     if (window.XMLHttpRequest)
     {
       // Mozilla, Safari,...
       httpRequest = new XMLHttpRequest();
       if (httpRequest.overrideMimeType)
       {
         httpRequest
          .overrideMimeType('text/xml');
       }
     } else if (window.ActiveXObject) {
       // IE
       try
       {
         httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {
         try
         {
           httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
         } catch (e) {
           console.log("XHR error : "+e);
         }
       }
     }

     if (!httpRequest)
     {
         console.log('Abandon ! Impossible de créer une instance XMLHTTP');
         return false;
     }

     httpRequest.onreadystatechange = function() {
        console.log(httpRequest.statusText);
     };

     httpRequest.open(method, url, true);
     //httpRequest.send(null);
     if(method == 'POST')
     {
       httpRequest
        .setRequestHeader(
          'Content-Type',
          'application/x-www-form-urlencoded');
     }
       httpRequest
        .send('data='+data);
     };

  // attach an action to a button || for testing stuff
  document.getElementById('capture').addEventListener('click', function() {
    // save the captured image after 1200000 seconds (=20 minutes).
    document.getElementById('stop-capture')
            .style.pointerEvents = 'auto';
    this.style.pointerEvents = 'none';
    var capture_date = new Date();
    console.log('Capture start at: ', capture_date.toGMTString());

    capture_video();

    document.setIntervalVar = setInterval(function() {
      context
        .drawImage(
          video, 0, 0, 400, 300);
      makeAjaxReq(
        'POST',
        '/save_img',
        canvas
          .toDataURL('image/png'));
    }, /*400000*/ 3000);
  });
  document.getElementById('stop-capture').addEventListener('click', function() {
    var stop_capture_date = new Date();
    clearInterval(document.setIntervalVar);
    console.log('Capture end at: ', stop_capture_date.toGMTString());
    document.track.stop();
    video.src = '';
    document.getElementById('capture')
            .style.pointerEvents = 'auto';
  })
  /*document.getElementById('capture')
          .addEventListener(
              'click',
              function() {
                context
                  .drawImage(
                    video, 0, 0, 400, 300);
                    //xhr stuff
                    makeAjaxReq(
                      'POST',
                      '/save_img',
                      canvas
                        .toDataURL('image/png'));
                photo.setAttribute(
                      'src',
                      canvas
                        .toDataURL('image/png')
                  );
              });*/
})();

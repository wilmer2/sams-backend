<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style type="text/css">
        .container{ width: 350px; float: left;}
        .titulo{ font-size: 12pt; font-weight: bold;}
        #camara, #foto{
            width: 320px;
            min-height: 240px;
            border: 1px solid #008000;
        }
    </style>
</head>
<body>
    <button id="initialize">Iniciar</button>
    <button id="pick">Foto</button>
    <button id="stop">Detener</button>
    <input type="time">
  <div id="container">
    <video id="camera" autoplay></video>
  </div>
  <div id="container">
     <canvas id="photo"></canvas>
  </div>

   <form id="files">
      <!-- <input type="text" id="location">
      <input type="text" id="case_situation"> -->
      <input type="time" id="time">
      <input type="time" id="timeH">
      <button type="submit">Subir imagen</button>
   </form>
   <figure id="content" value="">
       
   </figure>

   
  
<input type="text" id="field">

{{HTML::script('js/jquery-1.11.3.min.js')}}
 <script>




    window.URL = window.URL || window.webkitURL;
    
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||
                            navigator.mozGetUserMedia || navigator.msGetUserMedia || 
                            function(){alert('Su navegador no soporta navigator.getUserMedia().');};

  $(function () {
    
    // Upload File

   // var fileImg  = document.getElementById('fileImage');
   var formData = new FormData();
   var photo    = $('#photo');
   var ctx      = photo[0].getContext('2d');
  
  

   function showUploadedImage(source) {
        // var $content = $('#content');
        var imgShow  = document.createElement('img');

        imgShow.src = source;
        var width = imgShow.width;
        var height = imgShow.height;

        photo.attr({'width': 1200, 'height': 800});
        
        ctx.drawImage(imgShow, 0, 0, 1200, 800);
        $content.html(imgShow);

   }

   fileImg.addEventListener('change', function (e) {
        var file   = e.target.files;
        var reader = new FileReader();

        reader.onloadend = function (e) {
            console.log(formData);
            formData.append('photo', file[0]);
            showUploadedImage(e.target.result);

        }

        reader.readAsDataURL(file[0]);
        
   });

   $('#files').on("submit", function (e) {
        e.preventDefault();

        // var time = $('#time').val();
        // var timeH = $('#timeH').val();

        // formData.append('time', time);
        // formData.append('timeH', timeH);
/*
        var case_situation = $('#case_situation').val();
        var location = $('#location').val();

        formData.append('case_situation', case_situation);
        formData.append('location', location);
       */
        $.ajax({
               url: 'register/img/record/1',
               type: 'POST',
               data: formData,
               processData : false, 
              contentType : false,
              success: function (e) {
               console.log('funciono');
            }
       })

   })

   
 // Pick life
    window.dataVideo = {
        'StreamVideo' : null,
        'url' : null
    };


    var btnInitialize = document.getElementById('initialize');
    var btnStop       = document.getElementById('stop');
    var btnPick       = document.getElementById('pick');
    var dataUrl;
    var fileSubmit;

    btnInitialize.addEventListener('click', function () {
        navigator.getUserMedia({audio: false, video: true}, function (streamVideo) {
            dataVideo.StreamVideo = streamVideo;
            dataVideo.url = window.URL.createObjectURL(streamVideo);
            $('#camera').attr('src', dataVideo.url);
        },function () {alert('no se pudo realizar conexion con la camara')})
    });

    btnStop.addEventListener('click', function () {
        if (dataVideo.StreamVideo)  {
            dataVideo.StreamVideo.stop();
            window.URL.revokeObjectURL(dataVideo.url);
        }
    });

    btnPick.addEventListener('click', function () {
            var camera = $('#camera');
            var width  = camera.width();
            var height = camera.height();
            photo.attr({'width' : width, 'height': height});
            ctx.drawImage(camera[0], 0, 0, width, height);

            dataUrl = photo[0].toDataURL('image/png');
            $('#content').html(camera[0]);
            formData.append('photo', dataUrl);
    });

  })//jquery ready
 </script>
</body>
</html>



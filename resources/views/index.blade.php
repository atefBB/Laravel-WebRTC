<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="utf-8">
  <title>Take Photos WebRTC</title>

  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>
  <div class="booth">
    <video id="video"
            width="400"
            height="300"></video>
    <!--a href="#" id="capture"
        class="booth-capture-btn">
      Take photo
    </a-->
    <canvas id="canvas"
            width="400"
            height="300"></canvas>
    <img id="photo"/>
  </div>
  <script src="{{ asset('js/photo.js') }}"></script>
</body>
</html>

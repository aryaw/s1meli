<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <!-- <img src="{{ asset('img/ig-template.png') }}" alt=""> -->
  <h2>hello word</h2>
  <canvas id="mycanvas" style="display: block;"></canvas>  

  <!-- <button id="download" onclick="download(this)">Download</button> -->
  <a id="download" download="myImage.png" href="" onclick="download_img(this);">Download to myImage.jpg</a>

  <script>
    
    var imageTemplate = "{{ asset('img/ig-template.png') }}";
    var imageLocation = "{{ asset('img/icon-2.png') }}";
    var imageTime = "{{ asset('img/icon-1.png') }}";
    var imageActivity = "{{ asset('img/icon-3.png') }}";

    var canvas = document.getElementById("mycanvas");
    var ctx = canvas.getContext("2d");  
    var wwwWidth = 250;  
    canvas.width = 1080;
    canvas.height = 1920;

    var background = new Image();
    background.src = imageTemplate;
    
    background.onload = function(){
      ctx.drawImage(background,0,0);    
      ctx.save();
      changeText(650);
      addTime();
      addLocation();
      addActivity();
    }

    function changeText(y){
      ctx.restore();
      var width = canvas.width - 80;
      var x = canvas.width / 2;
      var text = "Take your Valentine,s to Rice Fields in the Brunch for a Netflix and chill";
      ctx.font = "65px filson-soft";    
      ctx.fillStyle = "white";  
      ctx.textAlign = "center";
      var lines = getLines(ctx, text, width);      
      for (var index in lines) {        
        ctx.fillText(lines[index], x, y+index*65 );
      }
    }

    function addTime(){
      var width = (canvas.width / 2) - 250;
      var image = new Image();
      image.src = imageTime;
      image.onload = function(){
        ctx.drawImage(image, width, 870, wwwWidth, wwwWidth);
      }      
    }

    function addLocation(){
      var width = (canvas.width / 2);
      var image = new Image();
      image.src = imageLocation;
      image.onload = function(){
        ctx.drawImage(image, width, 870, wwwWidth, wwwWidth);
      }      
    }


    function addActivity(){
      var width = (canvas.width / 2) - (wwwWidth/2);
      var image = new Image();
      image.src = imageActivity;
      image.onload = function(){
        ctx.drawImage(image, width, 1100, wwwWidth, wwwWidth);
      }      
    }

    function getLines(ctx, text, maxWidth) {
      var words = text.split(" ");
      var lines = [];
      var currentLine = words[0];

      for (var i = 1; i < words.length; i++) {
        var word = words[i];
        var width = ctx.measureText(currentLine + " " + word).width;
        if (width < maxWidth) {
          currentLine += " " + word;
        } else {
          lines.push(currentLine);
          currentLine = word;
        }
      }
      lines.push(currentLine);
      return lines;
    }

    function download_img(el){
      var image = canvas.toDataURL('image/png');
      el.href = image;
    }

  </script>

</body>
</html>
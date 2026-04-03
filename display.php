<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interplex Digital Signage</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    </head>

<body onload="onload(); initClock();">
  <div class="content">
  <header>
    <a href="index.php">
      <h1>Interplex Digital Signage<h1>
    </a>
  </header><br>
    <!-- VIDEO -->
    <div class="video">
      <video id="idle_video" width="750" height="auto" onended="onVideoEnded();" controls autoplay></video>
    </div> 
  <!-- DATE/TIME -->
    <div class="datetime">
          <div class="date">
            <span id="dayname">Day</span>,
            <span id="month">Month</span>
            <span id="daynum">00</span>,
            <span id="year">Year</span>
          </div>
          <div class="time">
            <span id="hour">00</span>:
            <span id="minute">00</span>:
            <span id="seconds">00</span>
            <span id="period">AM</span>
          </div>
    </div><br><br>
  <!-- IMAGE -->
    <!-- <center><h2>Image in slideshow</h2></center> -->
      <div class="slideshow-container">
        <div class="mySlides fade">
          <img src="display1/images/a.png" style="width:100%">
        </div>
        <div class="mySlides fade">
          <img src="display1/images/b.png" style="width:100%">
        </div>
        <div class="mySlides fade">
          <img src="display1/images/c.png" style="width:100%">
        </div>
        <div style="text-align:center">
          <span class="dot"></span> 
          <span class="dot"></span> 
          <span class="dot"></span> 
        </div>
      </div>



  <!-- Digital Clock -->
      <script >
        function updateClock(){
          var now = new Date();
          var dname = now.getDay(),
              mo = now.getMonth(),
              dnum = now.getDate(),
              yr = now.getFullYear(),
              hou = now.getHours(),
              min= now.getMinutes(),
              sec = now.getSeconds(),
              pe = "AM";

              if(hou == 0){
                hou = 12;
              }
              
              if(hou > 12){
                hou = hou - 12;
                pe ="PM";
              }

              Number.prototype.pad = function(digits){
                for(var n = this.toString(); n.length < digits; n = 0 + n);
                return n;

              }
              var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
              var week = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
              var ids = ["dayname","month","daynum","year","hour","minute","seconds","period"];
              var values = [week[dname],months[mo],dnum.pad(2),yr,hou.pad(2),min.pad(2),sec.pad(2),pe];
                for(var i = 0; i < ids.length; i++)
                document.getElementById(ids[i]).firstChild.nodeValue = values[i];
        }
        function initClock(){
          updateClock();
          window.setInterval("updateClock()", 1);
        }
        
      </script>  

  <!-- image slideshow -->
      <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
          let i;
          let slides = document.getElementsByClassName("mySlides");
          let dots = document.getElementsByClassName("dot");
          for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
          }
          slideIndex++;
          if (slideIndex > slides.length) {slideIndex = 1}    
          for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
          }
          slides[slideIndex-1].style.display = "block";  
          dots[slideIndex-1].className += " active";
          setTimeout(showSlides, 3500);
        }
      </script>

  <!-- video play reapetedly -->
    <script>
        var video_list = ["Display1/video/a.mp4"];
        var video_index = 0;
        var video_player = null;

        function onload(){
            console.log("body loaded");
            video_player = document.getElementById("idle_video");
            video_player.setAttribute("src", video_list[video_index]);
            video_player.play();
        }

        function onVideoEnded(){
            console.log("video ended");
            if(video_index < video_list.length - 1){
                video_index++;
            }
            else{
                video_index = 0;
            }
            video_player.setAttribute("src", video_list[video_index]);
            video_player.play();
        }
    </script>
  </div>
</body>
</html>
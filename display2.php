<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interplex Digital Signage</title>
    <link rel="stylesheet" type="text/css" href="style2.css" />
</head>

<body onload="onload(); initClock();">
  <div class="content">
    <header>
        <div class="logo">
            <a href="usermain.php">
                <img src="logo.png" style="width:20%">
            </a>
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
            <br>
            <h1>Interplex Digital Signage</h1>
        </div>
    </header>
    <br>
    <!-- VIDEO -->
    <div class="video">
        <video id="idle_video" width="950" height="auto" onended="onVideoEnded();" controls autoplay></video>
    </div>
  </div>
  <br><br>

  <!-- Digital Clock -->
  <script>
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
                pe = "PM";
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

  <!-- Video playback logic -->
  <script>
      var video_list = [];
      var video_index = 0;
      var video_player = null;

      function onload(){
          console.log("body loaded");
          video_player = document.getElementById("idle_video");
          fetchVideoList();
      }

      function fetchVideoList() {
          var xhr = new XMLHttpRequest();
          xhr.open('GET', 'get_video_list2.php', true); // Path to the PHP script
          xhr.onload = function () {
              if (xhr.status === 200) {
                  video_list = JSON.parse(xhr.responseText);
                  video_list.sort((a, b) => {
                      // Extract the numeric part from the filenames for sorting
                      let numA = parseInt(a.match(/(\d+)-/)[1]);
                      let numB = parseInt(b.match(/(\d+)-/)[1]);
                      return numA - numB; // Sort numerically
                  });
                  if (video_list.length > 0) {
                      video_player.setAttribute("src", video_list[video_index]);
                      video_player.play();
                  }
              } else {
                  console.error("Failed to fetch video list");
              }
          };
          xhr.send();
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

</body>
</html>

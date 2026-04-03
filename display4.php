<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interplex Digital Signage</title>
    <style>
        /* Ensure the video player takes up the full screen */
        body {
            margin: 0;
            overflow: hidden;
        }
        video {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
        }
    </style>
</head>

<body onload="onload();">
  <!-- VIDEO -->
  <video id="idle_video" muted controls autoplay></video>

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
          xhr.open('GET', 'get_video_list4.php', true); // Path to the PHP script
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
                      video_player.addEventListener('ended', onVideoEnded);
                      enterFullscreen();
                  }
              } else {
                  console.error("Failed to fetch video list");
              }
          };
          xhr.send();
      }

      function onVideoEnded(){
          console.log("video ended");
          video_index = (video_index + 1) % video_list.length;
          video_player.setAttribute("src", video_list[video_index]);
          video_player.play();
          enterFullscreen(); // Ensure fullscreen mode is re-entered
      }

      function enterFullscreen() {
          if (video_player.requestFullscreen) {
              video_player.requestFullscreen();
          } else if (video_player.mozRequestFullScreen) { // Firefox
              video_player.mozRequestFullScreen();
          } else if (video_player.webkitRequestFullscreen) { // Chrome, Safari and Opera
              video_player.webkitRequestFullscreen();
          } else if (video_player.msRequestFullscreen) { // IE/Edge
              video_player.msRequestFullscreen();
          }
      }
  </script>
</body>
</html>

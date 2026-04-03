<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interplex Digital Signage</title>
    <style>
        /* Ensure the video player takes up the full screen */
        body {
            margin: 0;
            overflow: hidden;
            position: relative; /* Ensure body is positioned for absolute children */
        }
        video {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
        }
        /* Style for the refresh button and link */
        .refresh-btn {
            background: #000000; /* Button color */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            font-family: Arial, sans-serif;
            font-size: 14px;
            text-decoration: none; /* Remove underline from link */
            display: inline-block; /* Allow padding on links */
            margin-bottom: 5px; /* Space between buttons */
        }
        .refresh-btn:hover {
            background: #FF4500; /* Darker color on hover */
        }
        /* Position the container at the left center */
        .top-left-container {
            position: fixed; /* Use fixed positioning to keep it in view */
            top: 5%; /* Position near the top */
            left: 20px; /* Adjust as needed */
            z-index: 1000; /* Ensure it appears above the video */
            color: white; /* Make the text visible on video */
            font-family: Arial, sans-serif;
            background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
            padding: 10px; /* Padding for aesthetics */
            border-radius: 5px; /* Rounded corners */
            transition: opacity 0.3s; /* Smooth transition for visibility */
        }
        .hidden {
            opacity: 0; /* Hide the container */
            pointer-events: none; /* Prevent interaction when hidden */
        }
    </style>
</head>

<body onload="onload();">
    <!-- VIDEO -->
    <video id="idle_video" muted controls autoplay></video>

    <div id="button-container" class="top-left-container">
        <div class="line-name">Canteen TV</div>
        <button class="refresh-btn" onclick="refreshPage()">Refresh</button>
       <!--  <a href="http://10.60.21.19/digital_signage1/display1_F.php" class="refresh-btn">Lobby-Welcome</a> -->
    </div>

    <!-- Video playback logic -->
    <script>
        var video_list = [];
        var video_index = 0;
        var video_player = null;
        var buttonContainer = document.getElementById("button-container");

        function onload() {
            console.log("body loaded");
            video_player = document.getElementById("idle_video");
            fetchVideoList();

            // Add event listeners for mouse movement
            document.addEventListener('mousemove', () => {
                buttonContainer.classList.remove('hidden'); // Show the button container
                clearTimeout(hideTimeout); // Clear any existing timeout
                hideTimeout = setTimeout(() => {
                    buttonContainer.classList.add('hidden'); // Hide after 2 seconds
                }, 2000); // Adjust time as needed
            });

            // Initially hide the button container
            buttonContainer.classList.add('hidden');
        }

        let hideTimeout;

        function fetchVideoList() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_video_list3.php', true); // Path to the PHP script
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

        function onVideoEnded() {
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
            } else if (video_player.webkitRequestFullscreen) { // Chrome, Safari, and Opera
                video_player.webkitRequestFullscreen();
            } else if (video_player.msRequestFullscreen) { // IE/Edge
                video_player.msRequestFullscreen();
            }
        }

        function refreshPage() {
            location.reload();
        }
    </script>
</body>
</html>

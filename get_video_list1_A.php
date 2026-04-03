<?php
$video_dir = "Display1_A/video/";
$video_files = array();

// Open the video directory
if ($handle = opendir($video_dir)) {
    // Loop through the files
    while (false !== ($entry = readdir($handle))) {
        // Check if the file is a video (you can add more extensions as needed)
        if ($entry != "." && $entry != ".." && preg_match('/\.(mp4|avi|mov|wmv)$/i', $entry)) {
            $video_files[] = $video_dir . $entry; // Add the full path to the array
        }
    }
    closedir($handle);
}

// Return the video files as a JSON array
header('Content-Type: application/json');
echo json_encode($video_files);
?>

<?php
$directory = 'Display2/documents/'; // Set the directory where PDFs are stored
$documents = array();

// Check if the directory exists
if (is_dir($directory)) {
    // Open the directory and read its contents
    if ($handle = opendir($directory)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $file_extension = pathinfo($entry, PATHINFO_EXTENSION);
                // Check if the file is a PDF
                if (strtolower($file_extension) == 'pdf') {
                    $documents[] = $directory . $entry; // Add the PDF file to the list
                }
            }
        }
        closedir($handle);
    }
}

// Return the document list as a JSON response
header('Content-Type: application/json');
echo json_encode($documents);
?>

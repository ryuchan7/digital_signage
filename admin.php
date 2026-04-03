<!DOCTYPE html>
<html>
<head>
    <title>Ael Engineering</title>
    <style>
        .btn {
            font-family: "Roboto", sans-serif;
            font-size: 18px;
            font-weight: bold;
            background: #1E90FF;
            width: 120px;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s, transform 0.3s;
        }
        .btn:hover, .btn:focus, .btn:active {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            transform: scale(1.1);
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .preview {
            width: 100px;
            height: auto;
            display: block;
            margin: 10px auto;
        }
        video {
            width: 100px;
            height: auto;
            display: block;
            margin: 10px auto;
        }
        .pdf-preview {
            width: 300px; /* Adjust width as needed */
            height: 200px; /* Adjust height as needed */
            border: 1px solid #ddd;
            margin: 10px auto;
        }
    </style>
</head>
<body>
<center>
    <h1>Interplex Digital Signage</h1>

    <?php
    // Define the directories
    $image_dir = "Display1/images/";
    $video_dir = "Display1/video/";
    $documents_dir = "Display1/documents/";

    // Handle file uploads
    if (isset($_POST['upload-img']) || isset($_POST['upload-vd']) || isset($_POST['upload-doc'])) {
        $filename = $_FILES['file']['name'];
        $tmpname = $_FILES['file']['tmp_name'];
        $file_folder = isset($_POST['upload-img']) ? $image_dir : (isset($_POST['upload-vd']) ? $video_dir : $documents_dir);

        if (move_uploaded_file($tmpname, $file_folder . $filename)) {
            echo "<script>alert('File Successfully Saved');</script>";
        } else {
            echo "<script>alert('Something went Wrong');</script>";
        }
    }

    // Handle file deletion
    if (isset($_POST['delete'])) {
        $file_to_delete = $_POST['file_to_delete'];
        if (unlink($file_to_delete)) {
            echo "<script>alert('File Deleted Successfully');</script>";
        } else {
            echo "<script>alert('Error deleting file');</script>";
        }
    }

    // Handle file renaming
    if (isset($_POST['rename'])) {
        $old_name = $_POST['old_name'];
        $new_name = $_POST['new_name'];
        if (rename($old_name, dirname($old_name) . '/' . $new_name)) {
            echo "<script>alert('File Renamed Successfully');</script>";
        } else {
            echo "<script>alert('Error renaming file');</script>";
        }
    }
    ?>

    <form method="post" enctype="multipart/form-data">
        <h2>Upload File</h2>
        <input type="file" name="file" required>
        <input type="submit" name="upload-img" value="Upload image" class="btn">
        <input type="submit" name="upload-vd" value="Upload video" class="btn">
        <input type="submit" name="upload-doc" value="Upload document" class="btn">
    </form>

    <h2>Manage Files</h2>
    <h3>Images</h3>
    <table>
        <tr>
            <th>Filename</th>
            <th>Preview</th>
            <th>Action</th>
        </tr>
        <?php
        // Display existing image files
        if ($handle = opendir($image_dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $file_path = htmlspecialchars($image_dir . $entry);
                    echo "<tr>
                        <td>" . htmlspecialchars($entry) . "</td>
                        <td><img src='$file_path' alt='Image Preview' class='preview'></td>
                        <td>
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='file_to_delete' value='$file_path'>
                                <input type='submit' name='delete' value='Delete' class='btn'>
                            </form>
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='old_name' value='$file_path'>
                                <input type='text' name='new_name' placeholder='New name' required>
                                <input type='submit' name='rename' value='Rename' class='btn'>
                            </form>
                        </td>
                    </tr>";
                }
            }
            closedir($handle);
        }
        ?>
    </table>

    <h3>Videos</h3>
    <table>
        <tr>
            <th>Filename</th>
            <th>Preview</th>
            <th>Action</th>
        </tr>
        <?php
        // Display existing video files
        if ($handle = opendir($video_dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $file_path = htmlspecialchars($video_dir . $entry);
                    echo "<tr>
                        <td>" . htmlspecialchars($entry) . "</td>
                        <td><video src='$file_path' controls class='preview'></video></td>
                        <td>
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='file_to_delete' value='$file_path'>
                                <input type='submit' name='delete' value='Delete' class='btn'>
                            </form>
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='old_name' value='$file_path'>
                                <input type='text' name='new_name' placeholder='New name' required>
                                <input type='submit' name='rename' value='Rename' class='btn'>
                            </form>
                        </td>
                    </tr>";
                }
            }
            closedir($handle);
        }
        ?>
    </table>

    <h3>Documents</h3>
    <table>
        <tr>
            <th>Filename</th>
            <th>Preview</th>
            <th>Action</th>
        </tr>
        <?php
        // Display existing document files
        if ($handle = opendir($documents_dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $file_path = htmlspecialchars($documents_dir . $entry);
                    $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
                    echo "<tr>
                        <td>" . htmlspecialchars($entry) . "</td>
                        <td>";
                    // Check if the file is a PDF for previewing
                    if ($file_extension === 'pdf') {
                        echo "<iframe src='$file_path' class='pdf-preview'></iframe>";
                    } else {
                        echo "No preview available";
                    }
                    echo "</td>
                        <td>
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='file_to_delete' value='$file_path'>
                                <input type='submit' name='delete' value='Delete' class='btn'>
                            </form>
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='old_name' value='$file_path'>
                                <input type='text' name='new_name' placeholder='New name' required>
                                <input type='submit' name='rename' value='Rename' class='btn'>
                            </form>
                        </td>
                    </tr>";
                }
            }
            closedir($handle);
        }
        ?>
    </table>

</center>
</body>
</html>

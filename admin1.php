<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to login page with a message
    header("Location: defaultlogin.php?message=Please+Login+1st");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Ael Engineering</title>
    <style>
        .btn {
            font-family: "Roboto", sans-serif;
            font-size: 10px;
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
    <h1>Interplex Digital Signage Admin Page</h1>
    <td><a href="adminmain.php" class="btn">Back To Main</a></td>
    <?php
    // Define the directories
    $directories = [
        "Display1" => [
            "images" => "Display1/images/",
            "video" => "Display1/video/",
            "documents" => "Display1/documents/"
        ],
        "Display1_A" => [
            "images" => "Display1_A/images/",
            "video" => "Display1_A/video/",
            "documents" => "Display1_A/documents/"
        ],
        "Display2" => [
            "images" => "Display2/images/",
            "video" => "Display2/video/",
            "documents" => "Display2/documents/"
        ],
        "Display3" => [
            "images" => "Display3/images/",
            "video" => "Display3/video/",
            "documents" => "Display3/documents/"
        ]
    ];

    // Initialize selected directory
    $selected_directory = isset($_POST['directory']) ? $_POST['directory'] : '';

    // Handle file uploads
    if (isset($_POST['upload-img']) || isset($_POST['upload-vd']) || isset($_POST['upload-doc'])) {
        $filename = $_FILES['file']['name'];
        $tmpname = $_FILES['file']['tmp_name'];
        $file_folder = isset($_POST['upload-img']) ? $directories[$selected_directory]['images'] :
            (isset($_POST['upload-vd']) ? $directories[$selected_directory]['video'] : $directories[$selected_directory]['documents']);

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
        <select name="directory" required onchange="this.form.submit()">
            <option value="">Select Display</option>
            <option value="Display1" <?php echo $selected_directory === 'Display1' ? 'selected' : ''; ?>>Display 1-Lobby Welcome</option>
            <option value="Display1_A" <?php echo $selected_directory === 'Display1_A' ? 'selected' : ''; ?>>Display 1-Lobby Vid AEL</option>
            <option value="Display2" <?php echo $selected_directory === 'Display2' ? 'selected' : ''; ?>>Display 2-Lobby Vid Corporate</option>
            <option value="Display3" <?php echo $selected_directory === 'Display3' ? 'selected' : ''; ?>>Display 3-Canteen Vid</option>
        </select>
        <input type="file" name="file" required>
       <!--  <input type="submit" name="upload-img" value="Upload image" class="btn"> -->
        <input type="submit" name="upload-vd" value="Upload video" class="btn">
        <input type="submit" name="upload-doc" value="Upload document" class="btn">
    </form>

    <?php if ($selected_directory): ?>
        <h2>Manage Files in <?php echo htmlspecialchars($selected_directory); ?></h2>

       <!--  <h3>Images</h3>
        <table>
            <tr>
                <th>Filename</th>
                <th>Preview</th>
                <th>Action</th>
            </tr>
            <?php
            // Display existing image files
            if ($handle = opendir($directories[$selected_directory]['images'])) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        $file_path = htmlspecialchars($directories[$selected_directory]['images'] . $entry);
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
        </table> -->

        <h3>Videos</h3>
        <table>
            <tr>
                <th>Filename</th>
                <th>Preview</th>
                <th>Action</th>
            </tr>
            <?php
            // Display existing video files
            if ($handle = opendir($directories[$selected_directory]['video'])) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        $file_path = htmlspecialchars($directories[$selected_directory]['video'] . $entry);
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
            if ($handle = opendir($directories[$selected_directory]['documents'])) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        $file_path = htmlspecialchars($directories[$selected_directory]['documents'] . $entry);
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
    <?php endif; ?>
</center>
</body>
</html>

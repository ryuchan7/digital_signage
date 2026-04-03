<?php
session_start();
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

// Include the database connection file
include("db-connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

     // Use prepared statements to avoid SQL injection
    $sql = "SELECT * FROM login WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $row = mysqli_fetch_array($result);

    if ($row) {
        if ($row["usertype"] == "user") {
            $_SESSION["username"] = $username;
            header("location:usermain.php");
        } elseif ($row["usertype"] == "admin") {
            $_SESSION["username"] = $username;
            header("location:adminmain.php");
        }
    } else {
        $_SESSION['errors'] = array("Your username or password was incorrect.");
        header("location:defaultlogin.php");
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
   <!--  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<script>
        window.onload = function() {
            const message = "<?php echo $message; ?>";
            if (message) {
                alert(message);
            }
        };
    </script>

<body>
    <div class="container-fluid p-3 bg-light text-black">
        <center>
            <br>
            <img src="img/interplex.png">
            <br><br>
            <h1>IEPB Digital Signage 1</h1>
            <p>This portal is accessible by Admin & User.</p>
            <p>Please enter your username and password.</p>
        </center>
    </div>
    <div class="jumbotron jumbotron-fluid p-4">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-md-4">
                <form action="#" method="POST">
                    <br>
                    <div class="form-group">
                        <dt>Username :</dt>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <dt>Password :</dt>
                        <input type="password" name="password" class="form-control" required>
                        <br>
                        <?php if (isset($_SESSION['errors'])): ?>
                            <div class="form-errors text-danger">
                                <?php foreach ($_SESSION['errors'] as $error): ?>
                                    <p><?php echo $error ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="Login" value="Login" class="btn btn-primary">
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <div>
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>

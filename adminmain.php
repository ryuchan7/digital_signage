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
    </head>
    <style>
        h1{
            color:white;
        }
        a{
            text-decoration:none;
        }
        
        body{
            background-image: url('Slide6.JPG');
            background-size: cover;
        }
        .btn{
            font-family: "Roboto", sans-serif;
            font-size: 18px;
            font-weight: bold;
            background: #1E90FF;
            width: 120px;
            padding:10px;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
            color: #fff;
            border-radius: 5px;
            cursor:pointer;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            -webkit-transition-duration: 0.3s;
            transition-duration: 0.3s;
            -webkit-transition-property: box-shadow,transform;
            transition-property: box-shadow,transform;
        }
        .btn:hover, .btn:focus, .btn:active{
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }
    </style>
<body>

<div class="container">
        <div class="row">
            <div class="col text-center">
                <h1>Hello Admin</h1>
                <?php if (isset($_SESSION["username"])): ?>
                    <p>Welcome <?php echo htmlspecialchars($_SESSION["username"]); ?>.</p>
                    <p>Click here to <a href="logout.php" title="Logout">Logout</a>.</p>
                <?php else: ?>
                    <h2>Please log in first.</h2>
                <?php endif; ?>
            </div>
        </div>

    <center>
        <h1>Interplex Digital Signage</h1>
            <table>
                <tr>             
                    <td><a href="admin1.php" class="btn">Admin</a></td>
                     <!-- <td><a href="admin1.php" class="btn">Admin</a></td> -->
                     <td><a href="display1_F_A.php" class="btn">Display 1-Lobby Vid AEL</a></td>
                     <td><a href="display1_F.php" class="btn">Display 1-Lobby Welcome</a></td>
                    <td><a href="http://10.60.21.19:4000/public-dashboards/5be0e7cb79fd4cde87b88cbd3a036685?orgId=1&refresh=10s" class="btn">Display 1-Lobby Dashboard 1</a></td>
                    <!-- <td><a href="display1_D.php" class="btn">Lobby Display 1-Doc</a></td> -->
                    <td><a href="display2_F.php" class="btn">Display 2-Lobby Vid Corporate</a></td>
                    <!-- <td><a href="display2_D.php" class="btn">Lobby Display 2-Doc</a></td> -->
                    <td><a href="display3_F.php" class="btn">Display 3-Canteen Vid All</a></td>
                    <!-- <td><a href="display3_D.php" class="btn">Canteen Display 3-Doc</a></td> -->
                    
                
                </tr>
            </table>
        </form>
    </center>
</body>
</html>

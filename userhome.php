<?php
session_start();
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
                <h1>Hey USER</h1>
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
                   <!--  <td><a href="admin1.php" class="btn">Admin</a></td> -->
                    <td><a href="display1.php" class="btn">Lobby Display 1-Vid</a></td>
                    <td><a href="display1_1.php" class="btn">Lobby Display 1-Doc</a></td>
                    <td><a href="display2.php" class="btn">Lobby Display 2-Vid</a></td>
                    <td><a href="display2_1.php" class="btn">Lobby Display 1-Doc</a></td>
                  <!--   <td><a href="display3.php" class="btn">Display 3</a></td> -->
                </tr>
            </table>
        </form>
    </center>
</body>
</html>

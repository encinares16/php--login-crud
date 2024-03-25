<?php 
    session_start();
    
    $_SESSION["user"] = "";
    
    if($_SESSION["user"]){
        header("Location: http://localhost/login-crud-php/index.php");
    }
    print_r($_SESSION["user"])
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/index.css">
    <title>Login</title>
</head>
<body>

    <?php
        spl_autoload_register(function () {
            include './models/catchError.php';
        });

        $error = new catchError();
        
        
        include ('./connectDB.php');
        $connect = new ConnectDB();
        $connect->__connect(mysqli_connect("localhost", "root", "", 'login-crud-php'));

        if(isset($_POST["submit"])){

            try {
                $email = $_POST["email"];
                $password = $_POST["password"];

                $prep_statement = "SELECT * FROM users WHERE email ='$email'";
                $result = mysqli_query($connect->connect, $prep_statement);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                

                ($_POST["email"] = $_POST["password"] === "") ? $error->set_error("Please fill all blank fields") : null;


                if($user){  

                    if($user["password"] === $password){
                        $_SESSION["user"] = "yes";
                        header("Location: http://localhost/login-crud-php/index.php");
                        die();
                    }

                } else {
                    // echo "<div> Email doesnt match";
                }

            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    ?>


    <main>
        <form class="form login" action="login.php" method="post">
            <div class="title">
                <h2>Login</h2>
                <p>Welcome Back!</p>
            </div>
            <div class="register">
                <div class="field">
                    <p>Email</p>
                    <input type="email" name="email"> <br>
                    <p class="field_name">email</p>

                    <div class="password login">
                        <p>Password</p>
                        <input type="password" class="input_password" name="password" id="password">
                        <p class="field_name">Password</p>
                    </div>
                </div>
            </div>
            <div class="button">
                <a href="register.php" >Create an account</a>
                <input type="submit" class="input_login" value="Login" name="submit">
            </div>
        </form>
    </main>

    <div>
        <?php echo ($error->get_error() != null) ? "<p class='error' >{$error->get_error()}</p>" : '' ?>
    </div>

</body>
</html>
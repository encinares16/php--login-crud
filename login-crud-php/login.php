<?php 
    session_start();

    // $_SESSION["user"] = "session";
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
    <link href="./styles/index.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <title>Login</title>
</head>
<body>

    <?php
        spl_autoload_register(function () {
            include './models/catchError.php';
        });

        $error = new catchError();
        $error_message2 = new catchError();
        $error_message3 = new catchError();
        
        
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
                    } else {
                        $error_message3->set_error("Credential not matched");
                    }
                } else {
                    $error_message2->set_error("Email doesn't exist");
                }
            } catch (\Throwable $th) {
                $error->set_error($th);
            }
        }
    ?>

    <main>
        <form class="form login" action="login.php" method="post">
            
            <div class="title">
                <h2>Login</h2>
                <p>Welcome Back!</p>
            </div>
            
            <div class="field">
                <div class="input_field">
                    <p>Email</p>
                    <input type="email" name="email" placeholder="Enter your email"> <br>
                </div>
                <div class="input_field">
                    <p>Password</p>
                    <input type="password" name="password" placeholder="Enter your Password"> <br>
                </div>
            </div>
          
            <div class="button">
                <a href="register.php" >Create an account</a>
                <input type="submit" class="input_login" value="Login" name="submit">
            </div>
        </form>
    </main>

    <div>
        <?php echo ($error->get_error() != null) ? "<p class='error login' >{$error->get_error()}</p>" : '' ?>
    </div>

    <div>
        <?php echo ($error_message2->get_error() != null) ? "<p class='error login' >{$error_message2->get_error()}</p>" : '' ?>
    </div>

    <div>
        <?php echo ($error_message3->get_error() != null) ? "<p class='error login' >{$error_message3->get_error()}</p>" : '' ?>
    </div>

</body>
</html>
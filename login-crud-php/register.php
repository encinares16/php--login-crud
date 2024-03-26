<?php 
    session_start();
    if($_SESSION["user"]){
        header("Location: http://localhost/login-crud-php/index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./styles/index.css"> -->
    
    <!-- <link rel="stylesheet" href="./styles/index.css">\ -->
    <link href="./styles/index.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    
    <title>Register</title>
</head>
<body>

<?php
    spl_autoload_register(function () {
        include './models/catchError.php';
    });

    spl_autoload_register(function () {
        include './models/User.php';
    });

    class ConnectDB {
        public $connect;
        function __connect($connect){
            $this->connect = $connect;
            if (!$connect) {
                die("Database connected failed: " . mysqli_connect_error());
            }
        }
    }

    $user = new User();
    $error = new catchError();
    $error2 = new catchError();

    $error->set_error(null);

    $connect = new ConnectDB();
    $connect->__connect(mysqli_connect("localhost", "root", "", 'login-crud-php'));

    if(isset($_POST["submit"])){
        $user->set_name($_POST["name"]);
        $user->set_email($_POST["email"]);
        $user->set_password($_POST["password"]);
        $user->set_confirmPassword($_POST["confirm_password"]);
    }

    $name = $user->get_name();
    $email = $user->get_email();
    $password = $user->get_password();
    $confirm_password = $user->get_confirmPassword();

    if(!empty($name) && !empty($email) && !empty($password) && !empty($confirm_password)){
        
        if ($password === $confirm_password) {
            try {
                $prep_statement = "INSERT INTO `users` (`id`,`name`, `email`, `password`) VALUES (NULL, '".$user->get_name()."', '".$user->get_email()."', '".$user->get_password()."')";
                if ($connect->connect->query($prep_statement) === TRUE) {
                    $error->set_sucessMessage("Your registration was successful!");
                } else {
                    echo " <div " . $prep_statement . "<br>" . $connect->connect->error;
                }
            } catch (mysqli_sql_exception) {
               $error->set_error($email ."  already taken ");
            } 
            $username = $name = $email = $password = $confirm_password = "";
        } else {
            $error2->set_error("Password is not matched");
        }
    } else {
        $error->set_error("Please fill up all fields");
    }
?>
    <main>
        <form class="form register" action="register.php" method="post">

            <div class="title">
                <h2>Create an Account</h2>
                <p>Please fill up the form correctly</p>
            </div>

            <div class="field">
                <div class="input_field">
                    <p>Full Name</p>
                    <input type="text" name="name"placeholder="Enter your full name"> <br>
                </div>

                <div class="input_field">
                    <p>Email</p>
                    <input type="email" name="email" placeholder="Enter your email"> <br>
                </div>

                <div class="password_field">
                    <div class="input_field password">
                        <p>Password</p>
                        <input type="password" name="password" id="password" placeholder="Password"> <br>
                    </div>

                    <div class="input_field password">
                        <p>Confirm Password</p>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"> <br>
                    </div>
                </div>
                  
            </div>
            
            <div class="button">
                <a href="login.php" >Already have an account</a>
                <input type="submit" value="Register" name="submit">
            </div>
        </form>
    </main>

    <div>
        <?php echo ($error->get_error() != null) ? "<p class='error register' >{$error->get_error()}</p>" : '' ?>
    </div>

    <div> 
        <?php echo ($error->get_successMessage() != "") ? "<p class='success register' >{$error->get_successMessage()}</p>" : '' ?>
    </div>

    <div> 
        <?php echo ($error2->get_error() != null) ? "<p class='error register' >{$error2->get_error()}</p>" : '' ?>
    </div>

    <script>
        let password = document.getElementById("password");
        let confirmPassword = document.getElementById("confirm_password");
        confirmPassword.addEventListener('change', e => {
            // console.log(password.value)
            if(password.value == e.target.value){
                password.style.border = "2px solid #65ee65";
                password.style.borderRadius = "6px";
                confirmPassword.style.border = "2px solid #65ee65";
                confirmPassword.style.borderRadius = "6px";
            } else {
                confirmPassword.style.border = "2px solid #ee5565";
            }
        })
    </script>
</body>
</html>

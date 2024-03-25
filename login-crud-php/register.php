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
    <link rel="stylesheet" href="./styles/index.css">
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
        try {
            $prep_statement = "INSERT INTO `users` (`id`,`name`, `email`, `password`) VALUES (NULL, '".$user->get_name()."', '".$user->get_email()."', '".$user->get_password()."')";
            if ($connect->connect->query($prep_statement) === TRUE) {
                $error->set_sucessMessage("New record created successfully");
            } else {
                echo " <div " . $prep_statement . "<br>" . $connect->connect->error;
            }
        } catch (mysqli_sql_exception) {
           $error->set_error($email ."  already taken ");
        } 
        $username = $name = $email = $password = $confirm_password = "";
    } else {
        $error->set_error("Please fill up all fields");
    }

?>
    <main>
        <form class="form register" action="register.php" method="post">

            <div class="title">
                <h2>Registration Form</h2>
                <p>Please fill up the form correctly</p>
            </div>
            <div class="register">

                <div class="field">
                    <p>Full Name</p>
                    <input type="text" name="name"> <br>
                    <p class="field_name">Full Name</p>
                </div>

                <div class="field pass">
                    <p>Email & Password</p>
                    <input type="email" name="email"> <br>
                    <p class="field_name">Email</p>

                    <div class="password_field">
                        <div class="password">
                            <input type="password" name="password" id="password" placeholder="Password"> <br>
                            <p class="field_name">Password</p>
                        </div>
                        <div class="password">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password"> <br>
                            <p class="field_name">Confirm Password</p>
                        </div>
                        
                    </div>
                </div>
                
            </div>
            <div class="button">
                <p></p>
                <input type="submit" value="Register" name="submit">
            </div>
        </form>
    </main>

    <div>
        <?php echo ($error->get_error() != null) ? "<p class='error' >{$error->get_error()}</p>" : '' ?>
    </div>

    <div> 
        <?php echo ($error->get_successMessage() != "") ? "<p class='success' >{$error->get_successMessage()}</p>" : '' ?>
    </div>


    <script>
        let password = document.getElementById("password");
        let confirmPassword = document.getElementById("confirm_password");
        confirmPassword.addEventListener('change', e => {
            console.log(password.value)
            console.log(password.value == e.target.value)
            password.style.border = "2px solid green";
            confirmPassword.style.border = "2px solid green";
        })
    </script>
</body>
</html>

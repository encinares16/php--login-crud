<?php
    session_start();
    if(!$_SESSION["user"]){
        header("Location: http://localhost/login-crud-php/login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/index.css">
    <title>Dashboard</title>
</head>
<body>
    <?php include('templates/nav.php'); ?>
    
    <h2>Dashboard</h2>

    <?php 
        if(isset($_POST["logout"])){
            $_SESSION["user"] = "";
        }
    ?>

</body>
</html>
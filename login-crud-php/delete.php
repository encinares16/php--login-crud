<?php
    session_start();
    if(!$_SESSION["user"]){
        header("Location: http://localhost/login-crud-php/login.php");
    }

    if(isset($_POST["logout"])){
        $_SESSION["user"] = "";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/index.css">
    <title>Delete Employee</title>
</head>
<body>
    <?php
        include('templates/nav.php');
        
        include ('./connectDB.php');
        $connect = new ConnectDB();
        $connect->__connect(mysqli_connect("localhost", "root", "", 'login-crud-php'));
        $datas = array();


        spl_autoload_register(function () {
            include './models/catchError.php';
        });

        $error_message = new catchError();

        if(isset($_GET["submit"])){
            $record_id = $_GET["recid"];

            if(!empty($record_id)){
                try {
                    $prep_statement = "SELECT * FROM `employeefile` WHERE recid = '$record_id'";
                    $result = mysqli_query($connect->connect, $prep_statement);
                    $datas = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    mysqli_free_result($result);
                    mysqli_close($connect->connect);
                    
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }

        if(isset($_GET["delete"])){
            $record_id = $_GET["recid"];
            if(!empty($record_id)){
                try {
                    $prep_statement = "DELETE FROM `employeefile` WHERE `employeefile`.`recid` = '$record_id'";
                    $result = mysqli_query($connect->connect, $prep_statement);
                    $error_message->set_sucessMessage('Record delete successfully');
                    $datas = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    mysqli_free_result($result);
                    mysqli_close($connect->connect);
    
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }
       
    ?>

    <?php 
        foreach($datas as $data){ ?>
    <?php } ?> 

    <main>
        <form class="form create" action="delete.php" method="GET">

        <div class="title">
            <h2>Delete Record</h2>
            <p>Delete Employee Record</p>
        </div>

        <div class="field">
            <div class="input_field">
                <p>Record Id</p>
                <input type="text" name="recid" value="<?php echo (!$datas == array()) ? htmlspecialchars($data['recid']) : "No records for this ID";?>">
            </div>
       
            <div class="input_container">
                <div class="input_field update">
                    <input type="submit" name="submit" value="Find Record ID"> 
                </div>
                <div class="input_field delete">
                    <input type="submit" class="input_delete" name="delete" value="Delete Record"> 
                </div>
            </div>
            
            <div class="input_field">
                <p>Full Name</p>
                <input type="text" name="name" disabled value="<?php echo (!$datas == array()) ? htmlspecialchars($data['fullname']) : "No data";?>"><br>
            </div>

            <div class="input_field">
                <p>Address</p>
                <input type="text" name="address" disabled value="<?php echo (!$datas == array()) ? htmlspecialchars($data['address']) : "No data";?>"><br>
            </div>
        

            <div class="input_container"> 
                <div class="input_field">
                    <p>Birthdate</p>
                    <input type="text" name="birthdate" disabled value="<?php echo (!$datas == array()) ? htmlspecialchars($data['birthdate']) : "No data";?>"><br>
                </div>

                <div class="input_field">
                    <p>Age</p>
                    <input type="text" name="age" disabled value="<?php echo (!$datas == array()) ? htmlspecialchars($data['age']) : "No data";?>"><br>
                </div>
            </div>

            <div class="input_container"> 
                <div class="input_field"> 
                    <p>Gender</p>
                    <input type="text" name="gender" disabled value="<?php echo (!$datas == array()) ? htmlspecialchars($data['gender']) : "No data";?>"><br>
                </div>
                <div class="input_field"> 
                    <p>Status</p>
                    <input type="text" name="status" disabled value="<?php echo (!$datas == array()) ? htmlspecialchars($data['civilstat']) : "No data";?>"><br>
                </div>
            </div>

            <div class="input_field"> 
                <p>Contact</p>
                <input type="text" name="contact" disabled value="<?php echo (!$datas == array()) ? htmlspecialchars($data['contactnum']) : "No data";?>"><br>
            </div>

            <div class="input_container"> 
                <div class="input_field"> 
                    <p>Salary</p>
                    <input type="text" name="salary" disabled value="₱ <?php echo (!$datas == array()) ? htmlspecialchars($data['salary']) : "No data";?>"><br>
                </div>

                <div class="input_field active_status"> 
                <p>Employee Active Status</p>
                <div>
                    <p>Status</p>
                    <?php echo (!$datas == array())  && ($data['isactive'] == 1) ? '<input type="checkbox" name="isActive" disabled checked > <br>' : '<input type="checkbox" name="isActive" disabled > <br>' ?>
                </div>
                <p></p>
            </div>

        </div>
        </form>
    </main>

    <div> 
        <?php echo ($error_message->get_successMessage() != "") ? "<p class='success register' >{$error_message->get_successMessage()}</p>" : '' ?>
    </div>

</body>
</html>
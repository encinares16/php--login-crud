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
    <link href="./styles/index.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <title>Find Employee By ID</title>
</head>
<body>
    <?php
        include('templates/nav.php');
        
        include ('./connectDB.php');
        
        $connect = new ConnectDB();
        $connect->__connect(mysqli_connect("localhost", "root", "", 'login-crud-php'));
        $datas = array();
    
        if(isset($_POST["submit"])){
            $record_id = $_POST["recid"];

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

        if(isset($_POST["submit"])){
            $record_id = $_POST["recid"];

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
    ?>

    <?php 
        foreach($datas as $data){ ?>
    <?php } ?> 

    <main>
        <form class="form read" action="read.php" method="post">

        <div class="title">
            <h2>Search Record</h2>
            <p>Find Employee by ID</p>
        </div>

        <div class="field">
            <div class="input_field">
                <p>Record Id</p>
                <input type="text" name="recid"value="<?php echo (!$datas == array()) ? htmlspecialchars($data['recid']) : "No records for this ID";?>">
            </div>
            <input type="submit" class="input_find" name="submit" value="Find"> <br><br>

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
        </div>
        </form>
    </main>
</body>
</html>
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
    <title>Update Record</title>
</head>
<body>
    <?php
        spl_autoload_register(function () {
            include './models/Employee.php';
            include './models/catchError.php';
        });

        include('templates/nav.php');
        
        include ('./connectDB.php');
        $connect = new ConnectDB();
        $connect->__connect(mysqli_connect("localhost", "root", "", 'login-crud-php'));
        $datas = array();

        $update_employee = new Employee();
        $error_message = new catchError();

        if(isset($_GET["submit"])){
            $update_employee->set_fullname($_GET["name"]);
            $update_employee->set_address($_GET["address"]);
            $update_employee->set_birthdate($_GET["birthdate"]);
            $update_employee->set_age($_GET["age"]);
            $update_employee->set_gender($_GET["gender"]);
            $update_employee->set_status($_GET["status"]);
            $update_employee->set_contact($_GET["contact"]);
            $update_employee->set_salary($_GET["salary"]);
            $update_employee->set_isActive($_GET["isActive"]);

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

        if(isset($_GET["update"])){
            $record_id = $_GET["recid"];

            $update_employee->set_fullname($_GET["name"]);
            $update_employee->set_address($_GET["address"]);
            $update_employee->set_birthdate($_GET["birthdate"]);
            $update_employee->set_age($_GET["age"]);
            $update_employee->set_gender($_GET["gender"]);
            $update_employee->set_status($_GET["status"]);
            $update_employee->set_contact($_GET["contact"]);
            $update_employee->set_salary($_GET["salary"]);
            $update_employee->set_isActive($_GET["isActive"]);

            $employee_fullname = $update_employee->get_fullname();
            $employee_address = $update_employee->get_address();
            $employee_birthday = $update_employee->get_birthdate();
            $employee_age = $update_employee->get_age();
            $employee_gender = $update_employee->get_gender();
            $employee_status = $update_employee->get_status();
            $employee_contact = $update_employee->get_contact();
            $employee_salary = $update_employee->get_salary();
            $employee_isActive = $update_employee->get_isActive();

            if(!empty($record_id)){
                try {
                    $prep_statement = "UPDATE `employeefile` 
                                     SET `fullname`='$employee_fullname',`address`='$employee_address',`birthdate`='$employee_birthday',`age`='$employee_age',`gender`='$employee_gender',`civilstat`='$employee_status',`contactnum`='$employee_contact',`salary`='$employee_salary',`isactive`='$employee_isActive' 
                                     WHERE employeefile.recid = '$record_id'";
                    $error_message->set_sucessMessage($employee_fullname .' updated successfully');
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
        <form class="form update " action="update.php" method="GET">

        <div class="title">
            <h2>Update Record</h2>
            <p>Update Employee by ID</p>
        </div>

        <div class="input_field">
            <p>Record Id</p>
            <input type="text" name="recid" value="<?php echo (!$datas == array()) ? htmlspecialchars($data['recid']) : "No records for this ID";?>">
        </div>
        
        <div class="input_container">
            <div class="input_field update">
                <input type="submit" name="submit" id="find" value="Find Record ID"> 
            </div>
            <div class="input_field update">
                <input type="submit" class="input_update" name="update" value="Update Record"> <br><br>
            </div>
        </div>

        <div class="input_field">
            <p>Full Name</p>
            <input type="text" name="name" value="<?php echo (!$datas == array()) ? htmlspecialchars($data['fullname']) : "No data";?>"><br>
        </div>
        
        <div class="input_field">
            <p>Address</p>
            <input type="text" name="address" value="<?php echo (!$datas == array()) ? htmlspecialchars($data['address']) : "No data";?>"><br>
        </div>
        
        <div class="input_container">
            <div class="input_field">
                <p>Birthdate</p>
                <input type="text" name="birthdate" value="<?php echo (!$datas == array()) ? htmlspecialchars($data['birthdate']) : "No data";?>"><br>
            </div>
            
            <div class="input_field">
                <p>Age</p>
                <input type="text" name="age" value="<?php echo (!$datas == array()) ? htmlspecialchars($data['age']) : "No data";?>"><br>
            </div>
        </div>

        <div class="input_container">
            <div class="input_field gender">
                <p>Gender</p>
                <div class="radio_field">
                    <label>Male: </label>
                    <?php echo (!$datas == array()) && $data['gender'] == "Male" ? "<input type='radio' checked name='gender' id='gender' value='Male'>" : "<input type='radio' name='gender' id='gender' value='Male'>" ?>
                    <label>Female: </label>
                    <?php echo (!$datas == array()) && $data['gender'] == "Female" ? "<input type='radio' checked name='gender' id='gender'  value='Female'>" : "<input type='radio' name='gender' id='gender' value='Female'>" ?>
                    <label>Other: </label>
                    <?php echo (!$datas == array()) && $data['gender'] == "Other" ? "<input type='radio' checked name='gender' id='gender' value='Other'>" : "<input type='radio' name='gender' id='gender' value='Other'>" ?>
                </div>
            </div>

            <div class="input_field">
                <p>Civil Status</p>
                <input type="text" name="status" value="<?php echo (!$datas == array()) ? htmlspecialchars($data['civilstat']) : "No data";?>"><br>
            </div>
        </div>


        <!-- <div class="radio_field">
            <label>Male: </label>
            <?php echo (!$datas == array()) && $data['gender'] == "Male" ? "<input type='radio' checked name='gender' value='Male'>" : "<input type='radio' name='gender' value='Male'>" ?>
            <label>Female: </label>
            <?php echo (!$datas == array()) && $data['gender'] == "Female" ? "<input type='radio' checked name='gender' value='Female'>" : "<input type='radio' name='gender' value='Female'>" ?>
            <label>Other: </label>
            <?php echo (!$datas == array()) && $data['gender'] == "Other" ? "<input type='radio' checked name='gender' value='Other'>" : "<input type='radio' name='gender' value='Other'>" ?>
        </div> -->

        <!-- <?php echo (!$datas == array()) && $data['gender'] == "Male" ? "Male" : null; ?>
        <?php echo (!$datas == array()) && $data['gender'] == "Female" ? "Female" : null; ?>
        <?php echo (!$datas == array()) && $data['gender'] == "Other" ? "Other" : null; ?> -->


        <div class="input_container">
            <div class="input_field">
                <p>Phone</p>
                <input type="text" name="contact" value="<?php echo (!$datas == array()) ? htmlspecialchars($data['contactnum']) : "No data";?>"><br>
            </div>
            <div class="input_field">
                <p>Salary</p>
                <input type="text" name="salary" value="<?php echo (!$datas == array()) ? htmlspecialchars($data['salary']) : "No data";?>"><br>
            </div>
        </div>


        <div class="input_container"> 
            <div class="input_field active_status"> 
            <p>Employee Active Status</p>
            <div>
                <p>Status</p>

                <!-- <input type="checkbox" name="isActive" value="<?php echo (!$datas == array()) ? htmlspecialchars($data['isactive']) :  null ?>"><br> -->
                <?php echo (!$datas == array()) && ($data['isactive'] == 1) ? "<input type='checkbox' name='isActive' id='checkbox' value='{$data['isactive']}' checked>" : "<input type='checkbox' id='checkbox' name='isActive'>" ?>
            </div>
            <p></p>
        </div>

        <input type="text" name="isActive" id="isActive" value = "1" style="display: none;"><br>
        <input type="text" name="gender" id="gender" value = "" style="display: none"><br>
        
        <script>
            let checkbox = document.getElementById("checkbox");

            if (checkbox.checked || gender.checked) {
                document.getElementById('gender').value = document.getElementById('');;
                document.getElementById('isActive').value = "1";
            } else {
                document.getElementById('isActive').value = "0";
            }

            checkbox.addEventListener('change', (event) => {
                if (event.currentTarget.checked) {
                    document.getElementById('isActive').value = "1";
                } else {
                    document.getElementById('isActive').value = "0";
                }
            })
        </script>

        </form>
    </main>

    <div> 
        <?php echo ($error_message->get_successMessage() != "") ? "<p class='success register' >{$error_message->get_successMessage()}</p>" : '' ?>
    </div>


</body>
</html>
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
    <title>Create New Employee</title>
</head>
<body>
    <?php include('templates/nav.php'); ?>
    
    <?php
    
        spl_autoload_register(function () {
            include './models/Employee.php';
        });

        include ('./connectDB.php');

        $connect = new ConnectDB();
        $connect->__connect(mysqli_connect("localhost", "root", "", 'login-crud-php'));
    
        $employee = new Employee();
        
        if(isset($_POST["submit"])){
            $employee->set_fullname($_POST["name"]);
            $employee->set_address($_POST["address"]);
            $employee->set_birthdate($_POST["birthdate"]);
            $employee->set_age($_POST["age"]);
            $employee->set_gender($_POST["gender"]);
            $employee->set_status($_POST["status"]);
            $employee->set_contact($_POST["contact"]);
            $employee->set_salary($_POST["salary"]);
        }

        $name = $employee->get_fullname();
        $address = $employee->get_address();
        $birthdate = $employee->get_birthdate();
        $age = $employee->get_age();
        $gender = $employee->get_gender();
        $status = $employee->get_status();
        $contact = $employee->get_contact();
        $salary = $employee->get_salary();

        if($name || $address || $birthdate || $age || $gender || $status || $contact || $salary != ""){
            try {
                $prep_statement = "INSERT INTO `employeefile` (`recid`, `fullname`, `address`, `birthdate`, `age`, `gender`, `civilstat`, `contactnum`, `salary`, `isactive`) VALUES (NULL, '$name', '$address', '$birthdate', '$age', '$gender', '$status', '$contact', '$salary', '1');";
                if ($connect->connect->query($prep_statement) === TRUE) {
                    // echo " <div New record created successfully";
                } else {
                    // echo " <div " . $prep_statement . "<br>" . $connect->connect->error;
                }
            } catch (mysqli_sql_exception) {
                // 
            } 
        } else {
            // echo " <div class='exceptions'> Please fill up all fields.";
        }
        $datas = array();
    ?>

    <main>
        <form class="form create" action="create.php" method="post">
        <h2>Add New Employee</h2>
        
        <div class="field">
            <p>Full Name</p>
            <input type="text" name="name"> <br>
            <p class="field_name">Full Name</p>

            <p>Address</p>
            <input type="text" name="address"> <br>
            <p class="field_name">Address</p>

            <p>Birthdate</p>
            <input type="date" name="birthdate" id="birthdate"> <br>
            <p class="field_name">Birthdate</p> 

            <p>Age</p>
            <input type="text" name="age"> <br>
            <p class="field_name">Age</p> 

            <!-- <p>Gender</p>
            <input type="text" name="gender"> <br>
            <p class="field_name">Gender</p>  -->

            <!-- <p>Status</p>
            <input type="text" name="status"> <br>
            <p class="field_name">Status</p>  -->

            <p>Contact</p>
            <input type="text" name="contact"> <br>
            <p class="field_name">Contact</p>

            <p>Gender</p>
            <div class="radio_gender">
                <div>
                    <label>Male: </label>
                    <input type="radio" name="gender" value="Male">
                </div>
                <div>
                    <label>Female: </label>
                    <input type="radio" name="gender" value="Female">
                </div>
                <div>
                    <label>Prefer not to say: </label>
                    <input type="radio" name="gender" value="Other">
                </div>
            </div>

            <p>Civil Status</p>
            <select name="status" id="category_item"> 
                    <option className="category_option" value="Single">Single</option>
                    <option className="category_option" value="Married">Married</option>
                    <option className="category_option" value="Separated">Separated</option>
                    <option className="category_option" value="Widowed">Widowed</option>
            </select>

            <p>Salary</p>
            <input type="text" name="salary"> <br>
            <p class="field_name">Salary</p> 

            <p>Active Status</p>
            <div class="status_field">
                <input type="checkbox" name="isActive" disabled checked>
                <p class="label_status">Active Status</p>
                <!-- <p class="field_name">Active Status</p>  -->
            </div>

        </div>

        <div class="button">
                <p></p>
                <input type="submit" name="submit" value="Add">
        </div>
        </form>
    </main>

</body>
</html>
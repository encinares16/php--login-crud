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
    <link href="./styles/index.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <title>New Employee</title>
</head>
<body>
    <?php include('templates/nav.php'); ?>
    
    <?php
    
        spl_autoload_register(function () {
            include './models/catchError.php';
            include './models/Employee.php';
        });


        include ('./connectDB.php');

        $connect = new ConnectDB();
        $connect->__connect(mysqli_connect("localhost", "root", "", 'login-crud-php'));
    
        $employee = new Employee();
        $error_message = new catchError();

        if(isset($_POST["submit"])){
            $employee->set_fullname($_POST["name"]);
            $employee->set_address($_POST["address"]);
            $employee->set_birthdate($_POST["birthdate"]);
            $employee->set_age($_POST["age"]);
            $employee->set_status($_POST["status"]);
            $employee->set_contact($_POST["contact"]);
            $employee->set_salary($_POST["salary"]);
        }

        $name = $employee->get_fullname();
        $address = $employee->get_address();
        $birthdate = $employee->get_birthdate();
        $age = $employee->get_age();

        $status = $employee->get_status();
        $contact = $employee->get_contact();
        $salary = $employee->get_salary();

        if (!empty($name) && !empty($address) && !empty($birthdate) && !empty($status) && !empty($contact) && !empty($salary)){
            try {
                $employee->set_gender($_POST["gender"]);
                $gender = $employee->get_gender();

                $prep_statement = "INSERT INTO `employeefile` (`recid`, `fullname`, `address`, `birthdate`, `age`, `gender`, `civilstat`, `contactnum`, `salary`, `isactive`) VALUES (NULL, '$name', '$address', '$birthdate', '$age', '$gender', '$status', '$contact', '$salary', '1');";
                if ($connect->connect->query($prep_statement) === TRUE) {
                    $error_message->set_sucessMessage("New record created successfully");
                } else {
                    echo " <div " . $prep_statement . "<br>" . $connect->connect->error;
                }
            } catch (mysqli_sql_exception) {
                // 
            } 
        } else {
            $error_message->set_error("Please input all fields");
        }
        $datas = array();
    ?>

    <main>
        <form class="form create" action="create.php" method="post">
        
        <div class="title">
            <h2>Create</h2>
            <p>Add New Employee</p>
        </div>

        <div class="field">
            <div class="input_field">
                <p>Full Name</p>
                <input type="text" name="name" placeholder="Enter employee name"> <br>
            </div>
            <div class="input_field">
                <p>Address</p>
                <input type="text" name="address" placeholder="Enter employee address"> <br>
            </div>

            <div class="input_container">
                <div class="input_field">
                    <p>Birthdate</p>
                    <input type="date" name="birthdate" id="birthdate"> <br>
                </div>
                <div class="input_field">
                    <p>Age</p>
                    <input type="text" name="age" placeholder="Enter employee age"> <br>
                </div>
            </div>
            
            <div class="input_container">
                <div class="input_field gender">
                    <p>Gender</p>
                    <div class="radio_field">
                        <label>Male: </label>
                        <input type="radio" name="gender" value="Male">
                        <label>Female: </label>
                        <input type="radio" name="gender" value="Female">
                        <label>Other: </label>
                        <input type="radio" name="gender" value="Other">
                    </div>
                </div>

                <div class="input_field">
                    <p>Civil Status</p>
                    <select name="status" id="category_item"> 
                        <option className="category_option" value="Single">Single</option>
                        <option className="category_option" value="Married">Married</option>
                        <option className="category_option" value="Separated">Separated</option>
                        <option className="category_option" value="Widowed">Widowed</option>
                    </select>
                </div>
            </div>

            <div class="input_container">
                <div class="input_field">
                    <p>Phone</p>
                    <input type="text" name="contact" placeholder="Enter employee phone"> <br>
                </div>
                <div class="input_field">
                    <p>Salary</p>
                    <input type="text" name="salary" placeholder="Enter employee salary"> <br>
                </div>
            </div>
           
        </div>

        <div class="button">
            <p></p>
            <input type="submit" name="submit" value="Add">
        </div>
        </form>
    </main>

    <div>
        <?php echo ($error_message->get_error() != null) ? "<p class='error register' >{$error_message->get_error()}</p>" : '' ?>
    </div>
        
    <div> 
        <?php echo ($error_message->get_successMessage() != "") ? "<p class='success register' >{$error_message->get_successMessage()}</p>" : '' ?>
    </div>


</body>
</html>
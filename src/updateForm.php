<?php
require('isLoggedIn.php');
checkIfLoggedIn();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Employee Info</title>
    <link rel="stylesheet" href="styles.css">
    <script src="formValidate.js" type="text/javascript"></script>
</head>
<body>
<?php
    $empNoToUpdate = "";
    $empBday = "";
    $empfName = "";
    $emplName = "";
    $empGender = "";
    $empHDate = "";

    if(isset($_POST['emp_no'])) {

        $empNoToUpdate = (string)((int)$_POST['emp_no']);
        $empBday = $_POST['birth_date'];
        $empfName = $_POST['first_name'];
        $emplName = $_POST['last_name'];
        $empGender = $_POST['gender'];
        $empHDate = $_POST['hire_date'];
    }
?>
<header>
    <h3 style="color: blue">Employee Info Update</h3>
    <p>Logged in as: <?php echo $_SESSION['LoggedInUser'] ?></p>
    <form action="logOut.php" method="post" name="LogoutForm">
        <input name="logoutBtn" type="submit" value="Log Out"/>
    </form>
</header>

<form action="./updateEmp.php" method="post" name="myForm" onsubmit="return validateDataUpdate()">
    <fieldset style="width: 630px; height: 280px; border-color: blue">
        <legend style="font-weight: bold; color: orangered">Employee Number: <span style="color: blue"><?php echo $empNoToUpdate?></span></legend>
        <p><input name='emp_no' type="hidden" value="<?php echo $empNoToUpdate?>"/></p>
        <p>Birth Date: <input name="birth_date" type="text" size="20" value="<?php echo $empBday?>"/>
            <span id="txtWarningBD"></span></p></p>
        <p>First Name: <input name="first_name" type="text" size="20" value="<?php echo $empfName?>"/>
            <span id="txtWarningFN"></span></p>
        <p>Last Name: <input name="last_name" type="text" size="20" value="<?php echo $emplName?>"/>
            <span id="txtWarningLN"></span></p>
        <p>Gender: <input name="gender" type="text" size="20"value="<?php echo $empGender?>"/>
            <span id="txtWarningGD"></span></p>
        <p>Hire Date: <input name="hire_date" type="text" size="20" value="<?php echo $empHDate?>"/>
            <span id="txtWarningHD"></span></p>
        <p><input name="btnUpdate" type="submit" value="Update"
                  style="background-color: blue; border: none; color: white; height: 30px; width: 60px;"/></p>
    </fieldset>
</form>

<br>
<form action="pagingEmp.php">
    <input name="btnQuit" type="submit" value="Back To The Dash Board" style="height:25px; width:180px; background-color: blue; color: white" />
</form>
</body>
</html>
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
<header>
    <h3 style="color: blue">Employee Info Update</h3>
    <p>Logged in as: <?php echo $_SESSION['LoggedInUser'] ?></p>
    <form action="logOut.php" method="post" name="LogoutForm">
        <input name="logoutBtn" type="submit" value="Log Out"/>
    </form>
</header>

<?php
    try {
        // establish a connection -> handle unable to connect
        require_once("/var/www/html/dbConn.php");
        $conn = getDbConnection();

        $empNoToUpdate = (string)((int)$_POST['emp_no']);
        $empBday = $_POST['birth_date'];
        $empfName = $_POST['first_name'];
        $emplName = $_POST['last_name'];
        $empGender = $_POST['gender'];
        $empHDate = $_POST['hire_date'];

        // build your statement
        $sql = "UPDATE employees SET birth_date = '$empBday', first_name = '$empfName', last_name = '$emplName',
                     gender = '$empGender', hire_date = '$empHDate' WHERE emp_no = '$empNoToUpdate';";
        $statement = $conn->prepare($sql);

        // execute the statement
        $statement->execute();

        echo "Successfully updated " . $statement->rowCount() . " record(s).<br><br>";
        echo "<a href='pagingEmp.php' style='font-weight: bold'> Back To The Dash Board </a>";

    } catch (PDOException $ex) {

    } finally {
        // close the connection
        $conn = null;
    }
?>

</body>
</html>


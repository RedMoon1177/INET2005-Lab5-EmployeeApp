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
    <h3 style="color: blue">Employee Deletion</h3>
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

        if (isset($_POST['emp_no'])) {

            $empNoToDel = (string)((int)$_POST['emp_no']);
            // build your statement
            $sql = "DELETE FROM employees WHERE emp_no = $empNoToDel;";
            $statement = $conn->prepare($sql);

            // execute the statement
            $statement->execute();

            echo "Successfully deleted " . $statement->rowCount() . " record(s).<br><br>";
            echo "<a href='pagingEmp.php' style='font-weight: bold'> Back To The Dash Board </a>";
        }
    }catch (PDOException $ex) {

    } finally {
        // close the connection
        $conn = null;
    }
?>

</body>
</html>

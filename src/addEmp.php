<?php
require('isLoggedIn.php');
checkIfLoggedIn();
?>



<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Add New Employees</title>
    <link rel="stylesheet" href="styles.css">
    <script src="formValidate.js" type="text/javascript"></script>
</head>
<body>
    <?php
        $empBday = "";
        $empfName = "";
        $emplName = "";
        $empGender = "";
        $empHDate = "";
    ?>
<header>
    <h3 style="color: blue">New Employees Registration</h3>
    <p>Logged in as: <?php echo $_SESSION['LoggedInUser'] ?></p>
    <form action="logOut.php" method="post" name="LogoutForm">
        <input name="logoutBtn" type="submit" value="Log Out"/>
    </form>
</header>

    <form action="<?php $_SERVER['PHP_SELF']?>" method="post" name="myForm" onsubmit="return validateDataEntry()">
        <fieldset style="width: 630px; height: 250px; border-color: blue">
            <legend style="font-weight: bold; color: orangered">Fill out info for the new employee</legend>
            <p>Birth Date: &nbsp;<input name="birth_date" type="date" size="20" value="<?php echo $empBday?>"/>&nbsp;
                <span id="txtWarningBD"></span></p>
            <p>First Name: <input name="first_name" type="text" size="20" value="<?php echo $empfName?>"/>&nbsp;
                <span id="txtWarningFN"></span></p>
            <p>Last Name: <input name="last_name" type="text" size="20" value="<?php echo $emplName?>" />&nbsp;
                <span id="txtWarningLN"></span></p>
            <p>Gender: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="gender">
                    <option value="M">M</option>
                    <option value="F">F</option>
                    <option value="T">T</option>
                    <option value="O">O</option>
                </select>
                &nbsp;&nbsp;&nbsp; <span style="color: darkgrey; font-size: 14px;">( M: male; F: Female; T: Transgender; O: Others )</span>
            </p>
            <p>Hire Date: &nbsp;<input name="hire_date" type="date" size="20" value="<?php echo $empHDate?>" />&nbsp;
                <span id="txtWarningHD"></span></p>
            <input name="btnAdd" type="submit" value="Add" style="height:25px; width:50px" />
        </fieldset>
    </form>

    <br>
    <form action="pagingEmp.php">
        <input name="btnQuit" type="submit" value="Back To The Dash Board" style="height:25px; width:180px; background-color: blue; color: white" />
    </form>
    <br>

    <?php
        try {
            // establish a connection -> handle unable to connect
            require_once("/var/www/html/dbConn.php");
            if (isset($_POST['btnAdd'])) {

                $conn = getDbConnection();

                $empBday = $_POST['birth_date'];
                $empfName = $_POST['first_name'];
                $emplName = $_POST['last_name'];
                $empGender = $_POST['gender'];
                $empHDate = $_POST['hire_date'];

                // build your statement
                $sql = "INSERT INTO employees (`birth_date`, `first_name`, `last_name`, `gender`, `hire_date`)
                        VALUES ('$empBday', '$empfName', '$emplName', '$empGender', '$empHDate');";
                $statement = $conn->prepare($sql);

                // execute the statement
                $statement->execute();

                // Get the number of affected rows
                $affectedRows = $statement->rowCount();
                $msgResult = "Successfully added " . $affectedRows . " record(s)";
    ?>

    <p id="info-message" style="color: orangered; font-weight: bold"><?php echo $msgResult?></p>

    <?php
                echo "
                                    <script>
                                    setTimeout(function(){
                                        document.getElementById('info-message').style.display = 'none';
                                    }, 2000);
                                    </script>
                                  ";

           }
        } catch (PDOException $ex) {

        } finally {
            // close the connection
            $conn = null;
        }
    ?>

</body>
</html>

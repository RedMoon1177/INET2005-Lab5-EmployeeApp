<?php
require('isLoggedIn.php');
checkIfLoggedIn();
?>



<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Search Employees</title>
    <link rel="stylesheet" href="styles.css">
    <script src="formValidate.js" type="text/javascript"></script>
</head>
<body>
<header>
    <h3 style="color: blue">Search Employees By First & Last Name</h3>
    <p>Logged in as: <?php echo $_SESSION['LoggedInUser'] ?></p>
    <form action="logOut.php" method="post" name="LogoutForm">
        <input name="logoutBtn" type="submit" value="Log Out"/>
    </form>
</header>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="myForm" onsubmit="return validateSearchForm()">
    <p>
        Search: <input name="txtSearch" type="text" value="<?php if(isset($_POST['txtSearch'])) {echo $_POST['txtSearch'];} ?>"/>
        &nbsp;&nbsp;<span id="txtWarning"></span>
    </p>
    <p><input name="submit" type="submit" value="Submit Query" /></p>
</form>
<form action="pagingEmp.php">
    <input name="btnQuit" type="submit" value="Back To The Dash Board" style="height:25px; width:180px; background-color: blue; color: white" />
</form>
<br>
<table border="1">
    <tr>
        <th>Emp.No</th>
        <th>Birth Date</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Hire Date</th>
    </tr>
    <?php
        try {
            // establish a connection -> handle unable to connect
            require_once("/var/www/html/dbConn.php");
            $conn = getDbConnection();

            if (isset($_POST['txtSearch'])) {

                $myString = $_POST['txtSearch'];

                // build your statement
                $sql = "SELECT * FROM `employees` WHERE `first_name` LIKE '%$myString%' OR `last_name` LIKE '%$myString%';";
                $statement = $conn->prepare($sql);

                // execute the statement
                $statement->execute();
                $results = $statement->fetchAll();

                foreach ($results as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['emp_no'] . "</td>";
                    echo "<td>" . $row['birth_date'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['hire_date'] . "</td>";
                    echo "</tr>";
                }

            } else { // for the first time loading searchEmp.php (no string for searching, just show all employees)

                // build your statement
                $sql = "SELECT * FROM `employees` LIMIT 0,25;";
                $statement = $conn->prepare($sql);

                // execute the statement
                $statement->execute();
                $results = $statement->fetchAll();

                foreach ($results as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['emp_no'] . "</td>";
                    echo "<td>" . $row['birth_date'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['hire_date'] . "</td>";
                    echo "</tr>";
                }
            }
        }catch (PDOException $ex) {

        } finally {
            // close the connection
            $conn = null;
        }
    ?>

</table>

</body>
</html>

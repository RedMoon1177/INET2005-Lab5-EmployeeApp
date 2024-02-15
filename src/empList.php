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
    <title>Employees List</title>
    <link rel="stylesheet" href="styles.css">
    <script src="formValidate.js" type="text/javascript"></script>
</head>
<body>
<!--------------------- loading list of departments ----------------------->
<?php
    try {
        // establish a connection -> handle unable to connect
        require_once("/var/www/html/dbConn.php");
        $conn = getDbConnection();

        // build your statement
        $sql = "SELECT * FROM `departments`";
        $statement = $conn->prepare($sql);

        // execute the statement
        $statement->execute();
        $results = $statement->fetchAll();

        $dept = array();
        $key = -1;
        $len = 0;

        foreach($results as $row)
        {
            $key++;
            $dept[$key] = $row['dept_no']." - ".$row['dept_name'];
            $len++;
        }

    } catch (PDOException $ex) {

    } finally {
        // close the connection
        $conn = null;
    }
?>
<!-------------------------------------------------------------------------->

<header>
    <h3 style="color: blue">Department-Wise Employee List</h3>
    <p>Logged in as: <?php echo $_SESSION['LoggedInUser'] ?></p>
    <form action="logOut.php" method="post" name="LogoutForm">
        <input name="logoutBtn" type="submit" value="Log Out"/>
    </form>
</header>

<div id="p-forms">
    <form action="<?php $_SERVER['PHP_SELF']?>" id="deptForm" name="deptForm" method="post" >
            <p>Select Department:&nbsp;
                <select id="deptSelect" name="deptSelect" style="width: 200px;">
                    <option></option>
                    <?php
                        for($i = 0; $i < $len; $i++)
                        {
                            echo "<option>".$dept[$i]."</option>";
                        }
                    ?>
                </select>
            </p>&nbsp;&nbsp;&nbsp;&nbsp;
            <p><input name="extractBtn" type="submit" value="Extract" style="height:25px; width:100px"/></p>
    </form>

    <form action="pagingEmp.php">
        <input name="btnQuit" type="submit" value="Back To The Dash Board" style="height:25px; width:180px; background-color: blue; color: white" />
    </form>
</div>


<!----------------- query employees from the selected department ---------------------->

<?php
    try {
        // establish a connection -> handle unable to connect
        require_once("/var/www/html/dbConn.php");

        if (isset($_POST['extractBtn'])) {

            // get the selected dept_no from post
            $myArray = $_POST['deptSelect'];
            $selectedDept_No = $myArray[0].$myArray[1].$myArray[2].$myArray[3];
            echo "<h4>DEPARTMENT: ".$myArray."</h4>";
?>
        <table border="1">
            <tr>
                <th>Emp.No</th>
                <th>Birth Date</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>From Date</th>
                <th>To Date</th>
            </tr>
<?php
            $conn = getDbConnection();

            // build your statement
            $sql = "SELECT employees.emp_no as 'emp_no', employees.birth_date as 'birth_date',
                        employees.first_name as 'first_name', employees.last_name as 'last_name', employees.gender as 'gender',
                        dept_emp.from_date as 'from_date', dept_emp.to_date as 'to_date'
                        FROM employees
                        INNER JOIN dept_emp ON employees.emp_no = dept_emp.emp_no AND dept_emp.dept_no = '$selectedDept_No'
                        LIMIT 0,200;";

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
                echo "<td>" . $row['from_date'] . "</td>";
                echo "<td>" . $row['to_date'] . "</td>";
                echo "</tr>";
            }
        }

    } catch (PDOException $ex) {

    } finally {
        // close the connection
        $conn = null;
    }
?>

</table>

</body>
</html>

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
    <title>Paging Employees</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    /*
     * get the post inputs from pagingEmp.php
     */
    $MAX_RECORDS_PER_PAGE = 25;

    $pageIndex = $_POST['index'];
    $maxPageIndex = $_POST['maxIndex'];

    // if btn Prev is clicked
    if (isset($_POST['btnPrev'])) {

        $pageIndex -= $MAX_RECORDS_PER_PAGE;
        if ($pageIndex < 0) $pageIndex = 0;
    }
    // if btn Next is clicked
    else if (isset($_POST['btnNxt'])) {

        $pageIndex += $MAX_RECORDS_PER_PAGE;
        if ($pageIndex > $maxPageIndex) $pageIndex = $maxPageIndex;
    }
    ?>

    <header>
        <h3 style="color: blue">Human Resource Management</h3>
        <p>Logged in as: <?php echo $_SESSION['LoggedInUser'] ?></p>
        <form action="logOut.php" method="post" name="LogoutForm">
            <input name="logoutBtn" type="submit" value="Log Out"/>
        </form>
    </header>

    <div id="p-content">
        <div id="section-records">
            <table border="1">
                <tr>
                    <th>Emp.No</th>
                    <th>Birth Date</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Hire Date</th>
                <th></th>
                <th></th>
            </tr>
                <?php
                    try {
                        // establish a connection -> handle unable to connect
                        require_once("/var/www/html/dbConn.php");
                        $conn = getDbConnection();

                        // build your statement
                        $sql = "SELECT * FROM employees ORDER BY emp_no DESC LIMIT $pageIndex,$MAX_RECORDS_PER_PAGE;";
                        $statement = $conn->prepare($sql);

                        // execute the statement
                        $statement->execute();
                        $results = $statement->fetchAll();

                        foreach($results as $row)
                        {
                            echo "<tr>";
                            echo "<td>" . $row['emp_no'] . "</td>";
                            echo "<td>". $row['birth_date'] . "</td>";
                            echo "<td>". $row['first_name'] . "</td>";
                            echo "<td>". $row['last_name'] . "</td>";
                            echo "<td>". $row['gender'] . "</td>";
                            echo "<td>". $row['hire_date'] . "</td>";
                            echo "<td>
                                                  <form action='updateForm.php' method='post'>
                                                    <input name='btnEdit' type='submit' value='Edit'/>
                                                    <input name='emp_no' type='hidden' value= {$row['emp_no']}/>
                                                    <input name='birth_date' type='hidden' value=' {$row['birth_date']}'/>
                                                    <input name='first_name' type='hidden' value='{$row['first_name']}'/>
                                                    <input name='last_name'type='hidden' value='{$row['last_name']}'/>
                                                    <input name='gender' type='hidden' value='{$row['gender']}'/>
                                                    <input name='hire_date'type='hidden' value='{$row['hire_date']}'/>
                                                  </form>
                                             </td>";
                            echo "<td>
                                                  <form action='deleteEmp.php' method='post'>
                                                    <input name='btnDelete' type='submit' value='Delete'/>
                                                    <input name='emp_no' type='hidden' value= {$row['emp_no']}/>
                                                  </form>
                                             </td>";
                            echo "</tr>";
                        }

                    } catch (PDOException $ex) {

                    } finally {
                        // close the connection
                        $conn = null;
                    }
                ?>

            </table>

            <br>
            <form action="./nextPaging.php" method="post" name="navButtons">
                <input name="btnPrev" type="submit" value="Previous"/> &nbsp;&nbsp;
                <input name="btnNxt" type="submit" value="Next"/>
                <input name="index" type="hidden" value="<?php echo $pageIndex ?>"/>
                <input name="maxIndex" type="hidden" value="<?php echo $maxPageIndex ?>"/>
            </form>

            <br>
        </div>

        <div id="section-controls">
                <fieldset style="width: 200px; height: 200px; border-color: blue">
                    <legend style="font-weight: bold; color: orangered">Employee Dash Board</legend>
                    <form action="addEmp.php">
                        <input name="btnAddNewEmps" type="submit" value="Add New Employees" style="height: 40px; width:210px"/>
                    </form>
                    <br>
                    <form action="searchEmp.php">
                        <input name="btnSearchEmps" type="submit" value="Search Employees" style="height: 40px; width:210px"/>
                    </form>
                    <br>
                    <form action="empList.php">
                        <input name="btnReportSal" type="submit" value="Extract Dept-Wise Employee List" style="height: 40px; width:210px"/>
                    </form>
                </fieldset>
        </div>

    </div>

</body>
</html>


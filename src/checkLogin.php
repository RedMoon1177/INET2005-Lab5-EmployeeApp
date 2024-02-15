<?php
    session_start();

try {
    // establish a connection -> handle unable to connect
    require_once("/var/www/html/dbConn.php");
    $conn = getDbConnection();

    $username = $_POST['loginUser'];
    $pwd = $_POST['loginPwd'];

    // build your statement
    $sql = "SELECT * FROM `WebUsers` WHERE user_name = '$username'";
    $statement = $conn->prepare($sql);

    // execute the statement
    $statement->execute();
    $count = $statement->rowCount();
    $rows = $statement->fetchAll();

    if($count == 1) {
        //get the hashed value from the user_pwd
        $hash = $rows[0]['user_pwd'];

        if(password_verify($pwd, $hash)){
            //password matches, grant access
            $_SESSION['LoggedInUser'] = $username;
            header("location:pagingEmp.php");
        }
    }

} catch (PDOException $ex) {

} finally {
    // close the connection
    $conn = null;
}

echo "Incorrect Login<br/>";
echo "<a href='index.html'>Try Again</a>";
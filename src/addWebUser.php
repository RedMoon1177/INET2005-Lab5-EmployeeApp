<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Web User Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h3 style="color: blue">Web User Sign-Up</h3>
<form name="signUpForm" action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <p>User Name: <input name="username" type="text" value="<?php if(isset($_POST['username'])) {echo $_POST['username'];} ?>" /></p>
    <p>Password: <input name="pwd" type="password" /></p>
    <p><input name="submit" type="submit" value="Sign Up"/></p>
</form>

<?php
/*
 * function: validate password strength in PHP - reference: codexworld.com
 * params: a string of password from user input
 * return: 0 = weak password | 1 = strong password
 * */
function checkIsStrongPassword($myPwd)
{
    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $myPwd);
    $lowercase = preg_match('@[a-z]@', $myPwd);
    $number    = preg_match('@[0-9]@', $myPwd);
    $specialChars = preg_match('@[^\w]@', $myPwd);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($myPwd) < 8) {
//        echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
        return 0;
    }else{
//        echo 'Strong password.';
        return 1;
    }
}
?>

<?php
    if(isset($_POST['submit'])) {
        if (!empty($_POST['username']) && !empty($_POST['pwd'])) {
            //        check if the username exists
            $username = $_POST['username'];
            try {
                // establish a connection -> handle unable to connect
                require_once("/var/www/html/dbConn.php");
                $conn = getDbConnection();

                // build your statement
                $sql = "SELECT
                                CASE
                                    WHEN EXISTS (SELECT 1 FROM `WebUsers` WHERE user_name='$username')
                                    THEN 1
                                    ELSE 0
                                END AS record_exists_count;";
                $statement = $conn->prepare($sql);

                // execute the statement
                $statement->execute();
                $results = $statement->fetchAll();

                $record_exists_count = $results[0]['record_exists_count'];

                if($record_exists_count == 1) {
                    echo "The username is already in use.";
                } else {

                    $pwd = $_POST['pwd'];
                    // check password strength
                    $passStrChk = checkIsStrongPassword($pwd);
                    if($passStrChk == 0)
                    {
                        echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                    } else
                    {
                        $hash = password_hash($pwd, PASSWORD_DEFAULT );

                        $sql ="INSERT INTO `WebUsers`(user_name, user_pwd) VALUES('$username','$hash');";
                        $statement = $conn->prepare($sql);
                        $statement->execute();
?>
                            <!-- hide sign up form and show a success notification & a link to the login page -->
                            <script>
                                document.forms['signUpForm'].style.display = "none";
                            </script>
<?php
                            echo "<h4>Successfully created a new user account!</h4>";
                            echo "<h4><a href='index.html'>Back To Log In!</a></h4>";
                     }
                }
            } catch (PDOException $ex) {

            } finally {
                // close the connection
                $conn = null;
            }
        } else {
            echo "Notice: To register an account, user name and password are required!";
        }
    }
?>

</body>
</html>


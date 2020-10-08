<?php
require_once "configure.php";

$_username = $_POST['username'];
//$_email = $_POST['email'];
$_password = $_POST['password'];

if(empty($_username) || empty($_password))
{
    header("Location: index2.html?error=emptyfields");
    exit();

}

else if(!preg_match("/^[a-zA-Z0-9]*$/", $_username))
{
    header("Location: index2.html?error=invalidusername"); // sends user back to login if there's an invalid username.
    exit();
}

/*
else if(!filter_var($_email, FILTER_VALIDATE_EMAIL))
{
    header("Location: index2.html?error=invalidemail"); // sends user back to login if there's an invalid email.
    exit();
}
*/


else
{
    $sql = "SELECT password FROM user_table WHERE username=?";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt,$sql)) // checks if connections works.
    {
        header("Location: index2.html?error=sqlfailure"); // sends user back to login if there's an sql issue.
        exit();
    }

    else
    {
        mysqli_stmt_bind_param($stmt,"s", $_username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if($resultCheck == 0)
        {
            header("Location: ../user_search.html?error=nouserfound"); // no user exists.
            exit();
        }

        else
        {
            $sql = "SELECT password FROM user_table WHERE username='$_username'";
            $result = $conn -> query($sql);
            $row = $result->fetch_assoc();

            if(password_verify($_password,$row["password"]))
            {
                $_SESSION['id'] = $user['id'];
                $_SESSION['u_name'] = $user['username'];
                $_SESSION['u_email'] = $user['email'];
                header('location: home.html');
                exit();
            }

            else
            {
                header("Location: index2.html?error=passwordfailed"); // no user exists.
                exit();
            }


        }


    }


}
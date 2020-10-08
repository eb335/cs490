<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('scream.enabled', false);

session_start();
require 'configure.php';

$username = "";
$email = "";

if(isset($_POST['login-submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!preg_match("/^[a-zA-Z0-9]*$/", $username))
    {
    header("Location: index2.html?error=invalidusername"); // sends user back to login if there's an invalid username.
    exit();
    }

    $sql = "SELECT * FROM user_table WHERE email=? OR username=? LIMIT 1";
    $stmt = $conn->prepare($sql);

    $stmt-> bind_param('ss', $username, $username);
    $stmt-> execute();
    $result =$stmt->get_result(); //if stmt brings back any user from database
    $user =$result->fetch_assoc(); //fetch user from database

    if (password_verify($password, $user['password'])){
            $_SESSION['id'] = $user['id'];
            $_SESSION['u_name'] = $user['username'];
            $_SESSION['u_email'] = $user['email'];
            header('location: home.html');
            exit();
        }
    
    else {
        header("location: index2.html?error=wrongpassword");
        exit();
    }

}

if(!mysqli_stmt_prepare($stmt,$sql)) // checks if connections works.
{
    header("Location: ../index.html?error=sqlfailure"); // sends user back to login if there's an sql issue.
    exit();
}
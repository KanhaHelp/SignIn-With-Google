<?php
/*
* Author - Mr. Kanha
* Date - 26-12-2021
* Github - https://github.com/KanhaHelp 
*/

session_start();
include_once 'config.php';

/*
* Get User data by email.. 
*/
$user_id = mysqli_real_escape_string($conn , $_POST['id']);
$name = mysqli_real_escape_string($conn , $_POST['name']);
$image = mysqli_real_escape_string($conn , $_POST['image']);
$email = mysqli_real_escape_string($conn , $_POST['email']);


$_SESSION['USER_ID']= $user_id;

/*
* Fetch user id exist or not.. 
*/
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);
$checkExist = mysqli_num_rows($result);

/*
* User Already Exist.. 
*/
if($checkExist){
    $rows = mysqli_fetch_assoc($result);
    $_SESSION['USER_NAME']= $rows['user_name'];
    $_SESSION['USER_EMAIL']= $rows['user_email'];
}
else
{
    $sql = "INSERT INTO users (user_id,user_name,user_image,user_email) VALUES ('$user_id','$name', '$image', '$email')  ";
    mysqli_query($conn, $sql);
    $_SESSION['USER_NAME']= $name;
    $_SESSION['USER_EMAIL']= $email;
}
?>
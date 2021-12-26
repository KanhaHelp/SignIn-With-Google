<?php
/*
* Author - Mr. Kanha
* Date - 26-12-2021
* Github - https://github.com/KanhaHelp 
*/

session_start();
include_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"  crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
    <meta name="google-signin-client_id" content="214123156172-no6pniukt2sip7j0lrra3518gfcici45.apps.googleusercontent.com">
    <title>Google Signup Process By Kanha</title>
    <style>
    .googleSignIn>div {
        margin: 0 auto;
    }
    </style>
</head>

<body>
    <div class="row justify-content-center text-center mt-2">
    <?php if(isset($_SESSION['USER_ID'])){
        $user_id = $_SESSION['USER_ID'];
        $sql = "SELECT * FROM users WHERE user_id = $user_id";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_assoc($result);
    ?>   
        <div class="card " style="width: 18rem;">
            <div class="mt-1">
                <img src="<?php echo $rows['user_image']; ?>" width="96px" height="96px" alt="...">
            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo $rows['user_name']; ?></h5>
                <p class="card-text"><?php echo $rows['user_email']; ?></p>
                <a href="javascript:void(0)" onclick="logOut()" class="btn btn-primary">Logout</a>
            </div>
        </div>

    <?php } else  {  ?>
       
        <div id="my-signin2" class="googleSignIn"></div>
       
    <?php } ?>

    </div>


    <script>
    function onLoad() {
        gapi.load('auth2', function() {
            gapi.auth2.init();
            gapi.signin2.render('my-signin2', {
                'scope': 'profile email',
                'width': 240,
                'height': 50,
                'longtitle': true,
                'theme': 'dark',
                'onsuccess': loginSuccess,
            });
        });
    }

    //get user data 
    function loginSuccess(userInfo) {
        var data = userInfo.getBasicProfile();

        //ajax call update data in database
        $.ajax({
            type: "POST",
            url: "update_data.php",
            data: {
                'id': data.getId(),
                'name': data.getName(),
                'image': data.getImageUrl(),
                'email': data.getEmail(),
            },
            success: function(result) {
                window.location.href = "index.php";
            }
        });
    }

    //logout function
    function logOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function() {

            //ajax call for logout
            $.ajax({
                url: "logout.php",
                success: function(result) {
                    window.location.href = "index.php";
                }
            });
        });
        auth2.disconnect();
    }
    </script>

</body>

</html>
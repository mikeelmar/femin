<?php
    session_start();
    require_once 'private\includes\connection.php';
    include 'private\includes\database.php';
?>

<?php
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: private/homepage.php");
        exit;
    }

    mysqli_select_db($conn, $db_name);
    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $password = sha1($_POST['password']);
                
        $sql = "SELECT * FROM tbl_accounts WHERE username = '$username' AND password = '$password' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows > 0) {
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
            header('location:private/homepage.php');  
        }
        else{
            header('location:index.php?message=invalidLogin');
        }
    }
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\login-page-style.css">
    <script src="js/jquery/jquery-3.6.0.min.js"></script>
    <script src="js/jquery/jquery-ui.js"></script>
    <link rel="icon" href="imgs/icon.png" type="image/x-icon">
    <title>femin | Login</title>
</head>
<body>
    <div class="vali-modal-container-inactive" id="validation-container">
        <div class="vali-modal">
            <div class="close-button-container">
                <button type="button" class="close-button">
                    <svg xmlns="imgs\x-circle-fill.svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                    </svg>
                </button>
            </div>
            <p id="validation-message"></p>
        </div>
    </div>
    <div class="main-container">
        <div class="account-icon-container">
            <div class="account-icon">
                <img src="imgs\acount-icon.png" alt="account-icon">
            </div>
        </div>
        <div class="login-container">
            <div class="form-title-container">
                <h4 class="title">Login</h4>
            </div>
            <div class="form-container">
                <form action="#" name="login-form" class="login-form" id="login-form" method="POST">
                    <div class="input-field">
                        <input name="username" type="text" id="username" autocomplete="off" autofocus required>
                        <label class="floating-label">Username</label>
                    </div>
                    <div class="input-field">
                        <input name="password" type="password" id="password" autocomplete="off" autofocus required>
                        <label class="floating-label">Password</label>
                    </div>
                    <div class="login-functions">
                        <div>
                            <input type="checkbox" name="remember-login" id="remember-login" checked>
                            <label for="remember-login">Remember me</label>
                        </div>
                        <div>
                            <a id="forgot-password" href="#">Forgot password?</a>
                        </div>
                    </div>
            </div>
            <div class="bottom-part">
                <div class="form-button-container">
                    <button type="submit" class="form-button" id="signin-button" form="login-form">Sign-in</button>
                </div>
                <div id="form-division">
                    <div></div>
                    <div>
                        <h6>OR</h6>
                    </div>
                </div>
                <div class="form-button-container">
                    <a href="public/register-page.php" class="form-button" id="signup-button">Sign-up</a>
                </div>
            </div>
        </div>
        <div class="image-container">
            <img src="imgs/login-memphis.png" alt="background-image">
        </div>
    </div>

    <?php
        if(isset($_GET['message'])): ?>
        <?php
            if($_GET['message']=="invalidLogin"){
                echo '<script>jQuery(function(){
                    $("#validation-message").html("Incorrect login. If you are not registered yet, click Sign up.");
                    $("#validation-container").removeClass("vali-modal-container-inactive");
                    $("#validation-container").addClass("vali-modal-container-active");
                    $("#validation-container").effect( "shake" );
                    setTimeout(function(){
                    $("#validation-container").removeClass("vali-modal-container-active");
                    $("#validation-container").addClass("vali-modal-container-inactive");
                    }, 8000);
                    })</script>';
            }
        ?>     
    <?php endif ?>

    <!-- form validation with JQuery -->
    <script>
        $(document).ready(function(){
            var alertModal = $('#validation-container');

            $('#forgot-password').click(function(){
                $('#validation-message').html("Feature unavailable");
                alertModal.removeClass("vali-modal-container-inactive");
                alertModal.addClass("vali-modal-container-active");
                alertModal.effect( "shake" );

                setTimeout(function(){
                    alertModal.removeClass("vali-modal-container-active");
                    alertModal.addClass("vali-modal-container-inactive");
                }, 8000);
            });

            $('.close-button').click(function(){
                alertModal.removeClass("vali-modal-container-active");
                alertModal.addClass("vali-modal-container-inactive");
            });

            // $('#login-form').submit(function(){
            //    let userInput = $('#username').val();
            //    let passInput = $('#password').val();

            //    if(userInput == dummyAcc.username && passInput == dummyAcc.password){
            //         return true;
            //    }
            //    else{
                    // $('#validation-message').html("Incorrect login. To enter, try using the dummy account.");
                    // alertModal.removeClass("vali-modal-container-inactive");
                    // alertModal.addClass("vali-modal-container-active");
                    // alertModal.effect( "shake" );

            //         setTimeout(function(){
            //             alertModal.removeClass("vali-modal-container-active");
            //             alertModal.addClass("vali-modal-container-inactive");
            //         }, 8000);

            //         return false;
            //    }
            // });  
        })
    </script>

</body>
</html>
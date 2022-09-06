<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../index.php");
    exit;
}
require_once 'includes/connection.php';
mysqli_select_db($conn, $db_name);

if (isset($_POST['btnUpdate'])) {
    $currentPassword = sha1($_POST['currentPassword']);
    $newPassword = sha1($_POST['newPassword']);
    $username = $_SESSION['username'];
    $select_data = mysqli_query($conn, "SELECT `password` FROM tbl_accounts WHERE username = '$username'");
    $user = mysqli_fetch_array($select_data);
    $userPassword = $user['password'];

    if ($currentPassword === $userPassword) {
        $update_data = mysqli_query($conn, "UPDATE tbl_accounts 
            SET 
                `password` = '$newPassword'
            WHERE 
                username = '$username'");
        if ($update_data) {
            header('location:homepage.php?message=successUpdate');
            exit;
        } else {
            echo "Failed to Update Information" . mysqli_connect_errno();
        }
    } else {
        header('location: change-password.php?valid=0');
        echo $userPassword;
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imgs/icon.png" type="image/x-icon">
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/change-password-styles.css">
    <script src="../js/bootstrap/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="../js/bootstrap/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="../js/jquery/jquery-3.6.0.min.js"></script>
    <script src="../js/jquery/jquery-ui.js"></script>
    <title>femin | Change Password</title>
</head>

<body>
    <div class="vali-modal-container-inactive" id="validation-container">
        <div class="vali-modal">
            <div class="close-button-container">
                <button type="button" class="close-button" id="close-button">
                    <svg xmlns="..\imgs\x-circle-fill.svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                    </svg>
                </button>
            </div>
            <p id="validation-message">Passwords don't match</p>
        </div>
    </div>
    <div class="container password-form-container">
        <div class="background-bg-container">
            <img src="../imgs/password-change.png" alt="Background Photo">
        </div>
        <div class="change-password-content">
            <h5 class="title">Change Password</h5>
            <form action="#" method="post" class="password-form" id="password-form">
                <div class="input-field">
                    <label>Current Password</label>
                    <input type="password" placeholder="●●●●●●●●" name="currentPassword" title="Dating Password" id="currentPassword">
                </div>
                <div class="input-field">
                    <label>New Password</label>
                    <input type="password" placeholder="●●●●●●●●" name="newPassword" title="Bagong Password" id="newPassword">
                </div>
                <div id="password-strength-container">
                    <span id="password-strength" class="password-strength-inactive"></span>
                </div>
                <div class="input-field">
                    <label>Confirm New Password</label>
                    <input type="password" placeholder="●●●●●●●●" name="confirmNewPassword" title="Ulitin ang bagong password" id="confirmNewPassword">
                </div>
                <div class="button-container">
                    <a href="../private/homepage.php">Cancel</a>
                    <button class="btn btn-success" name="btnUpdate" id="btnUpdate" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
    <?php
    if (isset($_GET['valid'])) : ?>
        <?php
        if ($_GET['valid'] == "0") {
            echo '<script>jQuery(function(){
                    $("#validation-message").html("Wrong current password, please try again.");
                    $("#validation-container").removeClass("vali-modal-container-inactive");
                    $("#validation-container").addClass("vali-modal-container-active");
                    $("#validation-container").effect( "shake" );
                    setTimeout(function(){
                      $("#validation-container").removeClass("vali-modal-container-active");
                      $("#validation-container").addClass("vali-modal-container-inactive");
                  }, 5000);})</script>';
        }
        ?>
    <?php endif ?>
    <script>
        $(document).ready(function() {
            var form = $('#password-form');
            var validPass = false;
            var validConfirmPass = false;

            var number = /([0-9])/;
            var alphabets = /([a-zA-Z])/;
            var specialChar = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;

            form.submit(function() {
                validPass = false;
                validConfirmPass = false;
                checkConfirmPass();
                checkPass();

                if (validPass == true && validConfirmPass == true) {
                    return true;
                } else {
                    return false;
                }

                function checkConfirmPass() {
                    if ($("#newPassword").val() === $('#confirmNewPassword').val()) {
                        validConfirmPass = true;
                    } else {
                        showAlert("Passwords don't match. Try again");
                        $("#confirmNewPassword").val("");
                        validConfirmPass = false;
                    }
                }

                function checkPass() {
                    var password = $('#newPassword').val();

                    if (password.length > 7 && password.match(alphabets) && password.match(number) && password.match(specialChar)) {
                        validPass = true;
                    } else {
                        showAlert("Invalid password. A strong password must contain at least 8 characters, combination of uppercase, lowercase, special characters, and numeric characters")
                        $("#confirmNewPassword").val("");
                        validPass = false;
                    }
                }

                $('#close-button').click(function() {
                    $('#validation-container').removeClass("vali-modal-container-active");
                    $('#validation-container').addClass("vali-modal-container-inactive");
                });

                function showAlert(message) {
                    $('#validation-message').html(message);
                    $('#validation-container').removeClass("vali-modal-container-inactive");
                    $('#validation-container').addClass("vali-modal-container-active");
                    $('#validation-container').effect("shake");

                    setTimeout(function() {
                        document.getElementById('validation-container').classList.remove("vali-modal-container-active");
                        document.getElementById('validation-container').classList.add("vali-modal-container-inactive");
                    }, 8000);
                }
            });

            $('#close-button').click(function() {
                $('#validation-container').removeClass("vali-modal-container-active");
                $('#validation-container').addClass("vali-modal-container-inactive");
            });

            $('#newPassword').keyup(function() {
                var password = $('#newPassword').val();
                if (password.length < 7) {
                    $('#password-strength').removeClass('password-strength-inactive');
                    $('#password-strength').addClass('password-strength-active');
                    $('#password-strength').html("Weak");

                    if (password == "") {
                        $('#password-strength').removeClass('password-strength-active');
                        $('#password-strength').addClass('password-strength-inactive');
                    }
                } else {
                    if (password.match(alphabets) && password.match(number) && password.match(specialChar)) {
                        $('#password-strength').html("Strong");
                    } else {
                        $('#password-strength').html("Average");
                    }
                }
            });
        })
    </script>
</body>

</html>
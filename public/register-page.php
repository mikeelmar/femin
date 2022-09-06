<?php
include '..\private\includes\connection.php';
include '..\private\includes\database.php';
?>

<?php
// insert new account into the tbl_accounts
if (isset($_POST['btnSave'])) {
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $civilStatus = $_POST['civilStatus'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = sha1($_POST['password']);

    if (mysqli_num_rows(mysqli_query($conn, "SELECT username FROM tbl_accounts WHERE username = '$username'"))) {
        header('location:register-page.php?message=accountExists');
    } else {
        $insert_data = mysqli_query($conn, "INSERT INTO tbl_accounts (last_name, first_name, middle_name, birthday, address, gender, civil_status, phone_number, email, username, password) 
            VALUES(
                '$lastName', 
                '$firstName', 
                '$middleName', 
                '$birthday', 
                '$address', 
                '$gender', 
                '$civilStatus', 
                '$phoneNumber', 
                '$email', 
                '$username', 
                '$password'
                )");

        if ($insert_data) {
            header('location:register-page.php?message=accountSuccessfullyAdded');
        } else {
            echo "Error creating an account";
            echo "Failed to Save Student Details" . mysqli_connect_errno();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css" integrity="sha384-7ynz3n3tAGNUYFZD3cWe5PDcE36xj85vyFkawcF6tIwxvIecqKvfwLiaFdizhPpN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/register-page-styles.css">
    <script src="../js/jquery/jquery-3.6.0.min.js"></script>
    <script src="../js/jquery/jquery-ui.js"></script>
    <link rel="icon" href="../imgs/icon.png" type="image/x-icon">
    <title>femin | Register</title>
</head>

<body>
    <div class="vali-modal-container-inactive" id="validation-container">
        <div class="vali-modal">
            <div class="close-button-container">
                <button type="button" class="close-button">
                    <svg xmlns="..\imgs\x-circle-fill.svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                    </svg>
                </button>
            </div>
            <p id="validation-message"></p>
        </div>
    </div>
    <div class="main-container">
        <div class="image-container">
            <img src="../imgs/register-form-background.png">
        </div>
        <div class="register-container">
            <div class="form-title-container">
                <h4 class="title">Register</h4>
            </div>
            <div class="form-container">
                <button type="button" class="scroll-button" id="scroll-up" onclick="scrollUp()">
                    <i class="bi bi-chevron-up"></i>
                </button>
                <form action="#" method="POST" class="registration-form" name="registration-form" id="registration-form">
                    <div class="input-field">
                        <input type="text" name="lastName" title="Apelyido" autocomplete="off" autofocus required>
                        <label class="floating-label">Last Name</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="firstName" title="Pangalan" autocomplete="off" autofocus required>
                        <label class="floating-label">First Name</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="middleName" title="Gitnang Pangalan" autocomplete="off" autofocus required>
                        <label class="floating-label">Middle Name</label>
                    </div>
                    <div class="input-field">
                        <input type="date" name="birthday" title="Kaarawan" autocomplete="off" autofocus required>
                        <label class="floating-label">Birthday</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="address" title="Lugar ng Tirahan" autocomplete="off" autofocus required>
                        <label class="floating-label">Address</label>
                    </div>
                    <div class="input-field">
                        <select name="gender" title="Kasarian" id="gender-options" required>
                            <option value="" disabled selected></option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="rather not to say">Rather not to say</option>
                        </select>
                        <label class="floating-label">Gender</label>
                    </div>
                    <div class="input-field">
                        <select name="civilStatus" title="Civil Status" id="civil-status-options" required>
                            <option value="" disabled selected></option>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="separated">Separated</option>
                            <option value="widow">Widowed</option>
                        </select>
                        <label class="floating-label">Civil Status</label>
                    </div>
                    <div class="input-field">
                        <input type="number" name="phoneNumber" id="phone-number" title="Numero ng Telepono" autocomplete="off" autofocus required>
                        <label class="floating-label">Phone Number</label>
                    </div>
                    <div class="input-field">
                        <input type="email" name="email" title="Address ng Email" autocomplete="off" id="email-field" autofocus required placeholder=" ">
                        <label id="email-label" class="floating-label">Email Address</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="username" title="Username" autocomplete="off" autofocus required>
                        <label class="floating-label">Username</label>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" id="password-field" title="Password" autocomplete="off" autofocus required>
                        <label class="floating-label">Password</label>
                        <br />
                        <div id="password-strength-container">
                            <span id="password-strength" class="password-strength-inactive"></span>
                        </div>
                    </div>
                    <div class="input-field">
                        <input type="password" id="confirm-password-field" title="Ulitin ang Password" autocomplete="off" autofocus required>
                        <label class="floating-label">Confirm Password</label>
                    </div>
                </form>
                <button type="button" class="scroll-button" id="scroll-down" onclick="scrollDown()">
                    <i class="bi bi-chevron-down"></i>
                </button>
            </div>
            <div class="save-button-container">
                <button form="registration-form" action="submit" name="btnSave" class="button-save" id="save-button">Save</button>
            </div>
            <div class="registered-link-container">
                <p class="registered-link">Already have an account? <a href="../index.php">Sign in here</a></p>
            </div>
        </div>
    </div>

    <!-- ALERT MESSAGES -->
    <?php
    if (isset($_GET['message'])) : ?>
        <?php
        if ($_GET['message'] == "accountSuccessfullyAdded") {
            echo '<script>jQuery(function(){
                    $("#validation-message").html("Account was successfully registered! To sign in, click Sign in here");
                    $("#validation-container").removeClass("vali-modal-container-inactive");
                    $("#validation-container").addClass("vali-modal-container-active");
                    $("#validation-container").effect( "shake" );
                    })</script>';
        }
        if ($_GET['message'] == "accountExists") {
            echo '<script>jQuery(function(){
                    $("#validation-message").html("The username already exists. To sign in, click the link down below the form");
                    $("#validation-container").removeClass("vali-modal-container-inactive");
                    $("#validation-container").addClass("vali-modal-container-active");
                    $("#validation-container").effect( "shake" );
                    })</script>';
        }
        ?>
    <?php endif ?>

    <script type="text/javascript">
        const form = document.getElementById("registration-form");

        function scrollDown() {
            form.scrollBy(0, 238);
        }

        function scrollUp() {
            form.scrollBy(0, -235);
        }

        setTimeout(function() {
            document.getElementById('validation-container').classList.remove("vali-modal-container-active");
            document.getElementById('validation-container').classList.add("vali-modal-container-inactive");
        }, 8000);

        $(document).ready(function() {
            var form = $('#registration-form');
            var validPass = false;
            var validConfirmPass = false;

            var number = /([0-9])/;
            var alphabets = /([a-zA-Z])/;
            var specialChar = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;

            form.scroll(function() {
                if (form.scrollTop() <= 5) {
                    $('#scroll-up').css({
                        "visibility": "hidden"
                    });
                }
                if (form.scrollTop() > 5) {
                    $('#scroll-up').css({
                        "visibility": "visible"
                    });
                }
                if (form.scrollTop() > 680) {
                    $('#scroll-down').css({
                        "visibility": "hidden"
                    });
                }
                if (form.scrollTop() < 680) {
                    $('#scroll-down').css({
                        "visibility": "visible"
                    });
                }
            });

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

            function checkPass() {
                var password = $('#password-field').val();

                if (password.length > 7 && password.match(alphabets) && password.match(number) && password.match(specialChar)) {
                    validPass = true;
                } else {
                    showAlert("Invalid password. A strong password must contain at least 8 characters, combination of uppercase, lowercase, special characters, and numeric characters")
                    $("#confirm-password-field").val("");
                    validPass = false;
                }
            }

            function checkConfirmPass() {
                if ($("#confirm-password-field").val() === $('#password-field').val()) {
                    validConfirmPass = true;
                } else {
                    showAlert("Passwords don't match. Try again");
                    $("#confirm-password-field").val("");
                    validConfirmPass = false;
                }
            }

            $('.close-button').click(function() {
                $('#validation-container').removeClass("vali-modal-container-active");
                $('#validation-container').addClass("vali-modal-container-inactive");
            });

            $('#password-field').keyup(function() {
                var password = $('#password-field').val();
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
<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../index.php");
    exit;
}

include '../private/includes/connection.php';
?>

<?php
mysqli_select_db($conn, $db_name);
$username = $_SESSION['username'];
?>

<!-- UPDATE ACCOUNT INFORMATION -->
<?php
if (isset($_POST['updateBtn'])) {
    $username = $_POST['username'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $civilStatus = $_POST['civilStatus'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];

    $update_data = mysqli_query($conn, "UPDATE tbl_accounts 
      SET 
        username = '$username',
        first_name = '$firstName',
        middle_name = '$middleName',
        last_name = '$lastName',
        birthday = '$birthday',
        address = '$address',
        gender = '$gender',
        civil_status = '$civilStatus',
        phone_number = '$phoneNumber',
        email = '$email'
      WHERE 
        username = '$username'");

    if ($update_data) {
        header('location:about.php?message=successUpdate');
        exit;
    } else {
        echo "Failed to Update Information" . mysqli_connect_errno();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/homepagess.css">
    <link rel="stylesheet" href="../css/about-style.css">
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="../js/bootstrap/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="../js/bootstrap/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <link rel="icon" href="../imgs/icon.png" type="image/x-icon">
    <script src="../js/jquery/jquery-3.6.0.min.js"></script>
    <script src="../js/jquery/jquery-ui.js"></script>
    <title>femin | About</title>
</head>

<body>
    <div class="container fixed-top nav-container">
        <nav class="navbar navbar-expand-md navbar-light">
            <a href="#" class="navbar-brand logo-name">femin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#toggleMobileMenu" aria-controls="toggleMobileMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="toggleMobileMenu">
                <ul class="navbar-nav ms-auto text-center">
                    <li>
                        <a href="#" class="nav-link a-link">About</a>
                    </li>
                    <li>
                        <a href="homepage.php" class="nav-link a-link">Home</a>
                    </li>
                    <li>
                        <a href="https://join.globalfundforwomen.org/a/donate" class="nav-link a-link">Donate</a>
                    </li>
                    <li class="nav-item dropdown account-dropdown">
                        <a class="nav-link dropdown-toggle d-inline-flex" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <?php
                            $select_data = mysqli_query($conn, "SELECT CONCAT(first_name, ' ', last_name) as full_name FROM tbl_accounts WHERE username='$username'");
                            if ($user = mysqli_fetch_array($select_data)) {
                            ?>
                                <span class="account-name"><?php echo $user['full_name']; ?></span>
                            <?php } ?>
                        </a>
                        <ul class="dropdown-menu account-dropdown-menu" aria-labelledby="navbarLightDropdownMenuLink">
                            <li>
                                <i class="bi bi-sliders"></i>
                                <a class="dropdown-item account-dropdown-item" href="#info-modal" data-bs-toggle="modal">Profile</a>
                            </li>
                            <li>
                                <i class="bi bi-box-arrow-left"></i>
                                <a class="dropdown-item account-dropdown-item" href="includes/signout.php">Sign out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- MODALS AND ALERTS -->
    <!-- Account info modal -->
    <div class="modal fade account-modal" id="info-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container btn-close-container">
                    <button class="btn-close info-modal-close-btn" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body account-modal-body">
                    <div class="container account-modal-header">
                        <h5>Account Information</h5>
                        <a href="#info-edit-modal" data-bs-dismiss="modal" data-bs-toggle="modal" class="edit" id="btnEditmodal" name="btnEditmodal" title="Edit Information">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </div>
                    <?php
                    $select_data = mysqli_query($conn, "SELECT * FROM tbl_accounts WHERE username = '$username'");
                    if ($user = mysqli_fetch_array($select_data)) {
                    ?>
                        <form action="#" method="POST">
                            <div class="form-group account-modal-form">
                                <label>Username</label>
                                <input type="text" id="username" class="form-control input-field" required disabled value="<?php echo $user['username']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>First Name</label>
                                <input type="text" id="firstName" class="form-control input-field" required disabled value="<?php echo $user['first_name']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Middle Name</label>
                                <input type="text" id="middleName" class="form-control input-field" required disabled value="<?php echo $user['middle_name']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Last Name</label>
                                <input type="text" id="lastName" class="form-control input-field" required disabled value="<?php echo $user['last_name']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Birthday</label>
                                <input type="date" id="birthday" class="form-control input-field" required disabled value="<?php echo $user['birthday']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Address</label>
                                <input type="text" id="address" class="form-control input-field" required disabled value="<?php echo $user['address']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Gender</label>
                                <select class="input-field" id="gender-options" required disabled>
                                    <option value="" disabled selected><?php echo ucfirst($user['gender']); ?></option>
                                </select>
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Civil Status</label>
                                <select class="input-field" id="civilStatus" required disabled>
                                    <option value="" disabled selected><?php echo ucfirst($user['civil_status']); ?></option>
                                </select>
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Phone Number</label>
                                <input type="number" id="phoneNumber" class="form-control input-field" required disabled value="<?php echo $user['phone_number']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Email</label>
                                <input type="email" id="email" class="form-control input-field" required disabled value="<?php echo $user['email']; ?>">
                            </div>
                        <?php } ?>
                        <div class="form-group account-modal-form">
                            <label id="password-label">Password</label>
                            <a href="change-password.php" class="account-link-update">Change Password</a>
                        </div>
                        </form>
                        <div class="container delete-button-container">
                            <a href="#delete-account-modal" data-bs-toggle="modal" data-bs-dismiss="modal" class="account-link-update delete-account">Delete Account</a>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary update-btn" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Account Modal -->
    <div class="modal fade account-modal" id="info-edit-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="container btn-close-container">
                    <button class="btn-close info-modal-close-btn" type="button" data-bs-dismiss="modal" data-bs-target="#info-modal" data-bs-toggle="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body account-modal-body">
                    <div class="container account-modal-header">
                        <h5>Edit Account Information</h5>
                    </div>
                    <?php
                    $select_data = mysqli_query($conn, "SELECT * FROM tbl_accounts WHERE username = '$username'");
                    if ($user = mysqli_fetch_array($select_data)) {
                    ?>
                        <form action="#" method="POST" id="updateForm" name="updateForm">
                            <div class="form-group account-modal-form">
                                <label>Username</label>
                                <input type="text" id="username" name="username" class="form-control input-field" value="<?php echo $user['username']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>First Name</label>
                                <input type="text" id="firstName" name="firstName" class="form-control input-field" value="<?php echo $user['first_name']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Middle Name</label>
                                <input type="text" id="middleName" name="middleName" class="form-control input-field" value="<?php echo $user['middle_name']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Last Name</label>
                                <input type="text" id="lastName" name="lastName" class="form-control input-field" value="<?php echo $user['last_name']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Birthday</label>
                                <input type="date" id="birthday" name="birthday" class="form-control input-field" value="<?php echo $user['birthday']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Address</label>
                                <input type="text" id="address" name="address" class="form-control input-field" value="<?php echo $user['address']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Gender</label>
                                <select class="input-field" name="gender" id="gender-options">
                                    <option hidden value="<?php echo $user['gender']; ?>" selected><?php echo ucfirst($user['gender']); ?></option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="rather not to say">Rather not to say</option>
                                </select>
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Civil Status</label>
                                <select class="input-field" name="civilStatus" id="civilStatus">
                                    <option hidden value="<?php echo $user['civil_status']; ?>" selected><?php echo ucfirst($user['civil_status']); ?></option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="separated">Separated</option>
                                    <option value="widow">Widowed</option>
                                </select>
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Phone Number</label>
                                <input type="number" id="phone-number" name="phoneNumber" class="form-control input-field" value="<?php echo $user['phone_number']; ?>">
                            </div>
                            <div class="form-group account-modal-form">
                                <label>Email</label>
                                <input type="email" id="email" name="email" class="form-control input-field" value="<?php echo $user['email']; ?>">
                            </div>
                        <?php } ?>
                        </form>
                </div>
                <div class="modal-footer">
                    <a href="#" class="cancel-update" data-bs-dismiss="modal" data-bs-target="#info-modal" data-bs-toggle="modal">Cancel</a>
                    <button class="btn btn-success update-btn" type="submit" name="updateBtn" id="updateBtn" form="updateForm">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Account deletion confirmation -->
    <div class="modal fade" id="delete-account-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body delete-modal">
                    <h1>🥺</h1>
                    <h6>Are you sure you want to delete this account?</h6>
                    <div class="container delete-confirmation-btn">
                        <a href="#" data-bs-dismiss="modal" class="delete-btn">Cancel</a>
                        <a href="../private/includes/delete-account.php" class="delete-btn">Confirm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Alert Modal -->
    <div class="vali-modal-container-inactive" id="validation-container">
        <div class="vali-modal">
            <div class="close-button-container">
                <button type="button" class="close-button">
                    <svg xmlns="../imgs/x-circle-fill.svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                    </svg>
                </button>
            </div>
            <p id="validation-message"></p>
        </div>
    </div>
    <!-- MAIN SECTION -->
    <main class="about-main container">
        <div class="logo-container container">
            <a href="#" class="navbar-brand logo-name about-logo">femin</a>
        </div>
        <div class="about-content-container container">
            <p class="about-content">The website entitled "femin" is inspired by Women's International Month where it empowers every girl, woman, and all who act as mothers around the world that cares, protect, and nurture. This wants to invoke involvement through a consolidated movement where everyone sparks to embody respect and acceptance of anyone's feelings and opinions. All are valid and deemed worthy whatever their state in life. This website reminds us that the next big achievement in human history may come from a little girl in the corner hoping to be empowered with utmost recognition.
            </p>
            <p class="about-content">The images, news, and any information sources contained inside the website belong to their respective owners. In no event shall the names indicated below be held liable for any direct, indirect, and incidental consequential damages. This website is made intended for educational purposes only serving as a final requirement of the course.</p>
        </div>
        <div class="divider container">
            <h4 class="developers-text">DEVELOPERS</h4>
        </div>
        <div class="container dev-profile-container">
            <div class="dev-profile-content">
                <div class="dev-profile">
                    <div class="profile-picture">
                        <img src="../imgs/developers-profile/mike-profile.jpg" alt="profile picture">
                    </div>
                    <div class="profile-details">
                        <p class="name">Mike Elmar E. Lipata</p>
                        <p class="degree">BSIT - 3A</p>
                        <p class="uep">University of Eastern Philippines</p>
                        <div class="socials">
                            <div class="facebook">
                                <a href="https://facebook.com/mike.elmar.e.lipata/"><i class="bi bi-facebook"></i></a>
                            </div>
                            <div class="instagram">
                                <a href="https://www.instagram.com/mikeelmar/"><i class="bi bi-instagram"></i></a>
                            </div>
                            <div class="github">
                                <a href="https://github.com/mikeelmar"><i class="bi bi-github"></i></a>
                            </div>
                            <div class="mail">
                                <a href="mailto:lipatamikeelmar@gmail.com?subject=femin Report"><i class="bi bi-envelope-fill"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dev-profile-content">
                <div class="dev-profile">
                    <div class="profile-picture">
                        <img src="../imgs/developers-profile/jerwyn-profile.jpg" alt="profile picture">
                    </div>
                    <div class="profile-details">
                        <p class="name">Jerwyn G. Esteria</p>
                        <p class="degree">BSIT - 3A</p>
                        <p class="uep">University of Eastern Philippines</p>
                        <div class="socials">
                            <div class="facebook">
                                <a href="https://web.facebook.com/sebense.esteria"><i class="bi bi-facebook"></i></a>
                            </div>
                            <div class="instagram">
                                <a href="https://www.instagram.com/gagi_ge/"><i class="bi bi-instagram"></i></a>
                            </div>
                            <div class="mail">
                                <a href="mailto:garzongie@gmail.com@gmail.com?subject=femin Report"><i class="bi bi-envelope-fill"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    if (isset($_GET['message'])) : ?>
        <?php
        if ($_GET['message'] == "successUpdate") {
            echo '<script>jQuery(function(){
                    $("#validation-message").html("Account Information successfully updated!");
                    $("#validation-container").removeClass("vali-modal-container-inactive");
                    $("#validation-container").addClass("vali-modal-container-active");
                    $("#validation-container").effect( "shake" );
                    setTimeout(function(){
                      $("#validation-container").removeClass("vali-modal-container-active");
                      $("#validation-container").addClass("vali-modal-container-inactive");
                      window.location.replace("about.php");
                  }, 3000);})</script>';
        }
        ?>
    <?php endif ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var alertModal = $('#validation-container');
            $('.close-button').click(function() {
                alertModal.removeClass("vali-modal-container-active");
                alertModal.addClass("vali-modal-container-inactive");
            });
        });
    </script>
</body>

</html>
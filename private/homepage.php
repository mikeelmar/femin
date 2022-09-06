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
    header('location:homepage.php?message=successUpdate');
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
  <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="../js/bootstrap/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="../js/bootstrap/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
  <link rel="icon" href="../imgs/icon.png" type="image/x-icon">
  <script src="../js/jquery/jquery-3.6.0.min.js"></script>
  <script src="../js/jquery/jquery-ui.js"></script>
  <link rel="stylesheet" href="../css/locomotive/locomotive-scroll.css">
  <script src="../js/locomotive/locomotive-scroll.min.js"></script>
  <title>femin | Women's Month Celebration</title>
</head>

<body data-scroll-container>
  <div class="container fixed-top nav-container">
    <nav class="navbar navbar-expand-md navbar-light">
      <a href="#" class="navbar-brand logo-name">femin</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#toggleMobileMenu" aria-controls="toggleMobileMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="toggleMobileMenu">
        <ul class="navbar-nav ms-auto text-center">
          <li>
            <a href="about.php" class="nav-link a-link">About</a>
          </li>
          <li>
            <a href="#" class="nav-link a-link">Home</a>
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
  <header data-scroll-container>
    <div class="header-content-container" data-scroll-section>
      <div class="header-content">
        <p>Celebrate Women's History Month</p>
        <p>Empower this March 2022</p>
      </div>
      <div class="header-buttons-container">
        <a href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=&cad=rja&uact=8&ved=2ahUKEwjQ0Y2Q_r32AhUGrlYBHVftByIQFnoECBIQAQ&url=https%3A%2F%2Fwomenshistorymonth.gov%2Fabout%2F&usg=AOvVaw0nxo_MhyB6x_SaGT8TaiWe" class="header-button" id="learn-more-button">Learn More</button>
          <a href="https://twitter.com/VP/status/1499450784974458897?s=20&t=8nQrjGJZPz7lshaC9howJA" class="header-button" id="watch-button">Watch</a>
      </div>
    </div>
    <div class="bgphoto-container">
      <img src="../imgs/cover-img2.png" alt="bgphoto">
    </div>
  </header>
  <!-- main body -->
  <main data-scroll-section>
    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="container row-container">
        <div class="row row-highlight">
          <div class="col-lg-4 row-highlight-content">
            <img src="../imgs/row-highlight/ariana-debose.jpg" alt="ariana-debose" class="bd-placeholder-img rounded-circle" width="140" height="140" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false">
            <h2>Ariana DeBose</h2>
            <p>An Afro-Latina actress as the first openly queer woman of color to be nominated for — and to win— an Academy Award in an acting category.</p>
            <p><a class="btn btn-primary row-button first-row-btn" href="https://www.them.us/story/ariana-debose-oscars-history-first-queer-woman-of-color">View details »</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4 row-highlight-content">
            <img src="../imgs/row-highlight/ketanji-brown.jpg" alt="ariana-debose" class="bd-placeholder-img rounded-circle" width="140" height="140" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false">
            <h2>Ketanji Brown Jackson</h2>
            <p>Ketanji Brown Jackson has been confirmed as the first African-American woman to serve as a justice of the United States Supreme Court.</p>
            <p><a class="btn btn-primary row-button" href="https://deathpenaltyinfo.org/news/senate-confirms-ketanji-brown-jackson-as-first-black-woman-to-serve-on-u-s-supreme-court">View details »</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4 row-highlight-content">
            <img src="../imgs/row-highlight/leena-nair.jpg" alt="ariana-debose" class="bd-placeholder-img rounded-circle" width="140" height="140" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false">
            <h2>Leena Nair</h2>
            <p>Chanel has appointed Leena Nair as global chief executive officer, grabbing the company’s youngest and first female CEO after her 30-year tenure at consumer goods group Unilever.</p>
            <p><a class="btn btn-primary row-button third-row-btn" href="https://www.pymnts.com/news/retail/2021/chanel-hires-leena-nair-as-youngest-first-female-ceo/#:~:text=Chanel%20has%20appointed%20Leena%20Nair,2022%2C%20the%20Financial%20Times%20reported">View details »</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
      </div>


      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      <div class="row featurette first-headline">
        <div class="col-md-7 ">
          <h2 class="featurette-heading">Taylor Swift receives honorary degree from NYU, delivers address to Class of 2022. <span class="text-muted">Genius.</span></h2>
          <p class="lead">Taylor Swift received an honorary degree from New York University on Wednesday and delivered a commencement address to the Class of 2022. The 11-time Grammy winner received a Doctor of Fine Arts, honoris causa, during the university's morning ceremony, which was held at Yankee Stadium.</p>
          <a href="https://abcnews.go.com/amp/GMA/Culture/taylor-swift-receives-honorary-degree-nyu-delivers-address/story?id=84803637" class="learn-more-button">Learn More</a>
        </div>
        <div class="col-md-5">
          <img src="../imgs/featurette/taylor-swift.jpg" id="woman-photo-1" alt="featurette" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette second-headline">
        <div class="col-md-7 order-md-2">
          <h2 class="featurette-heading">Rappler’s Maria Ressa makes history, receives Nobel Peace Prize in Oslo. <span class="text-muted">Brave.</span></h2>
          <p class="lead">Rappler CEO Maria Ressa is the first Filipino to receive the Nobel Peace Prize and, along with Dmitry Muratov, is the first working journalist to win this award since the 1930s.</p>
          <a href="https://www.rappler.com/world/global-affairs/maria-ressa-makes-history-receives-nobel-peace-prize-oslo-norway/" class="learn-more-button">Learn More</a>
        </div>
        <div class="col-md-5 order-md-1">
          <img src="../imgs/featurette/maria-ressa.jpg" id="woman-photo-2" alt="featurette" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
        </div>
      </div>
      <hr class="featurette-divider">

      <div class="row featurette third-headline">
        <div class="col-md-7">
          <h2 class="featurette-heading">Celeste Cortesi of Pasay is Miss Universe PH 2022.<span class="text-muted"> Advocate.</span></h2>
          <p class="lead">Celeste Cortesi is now one step closer to a global crown after capturing the Miss Universe Philippines title in ceremonies staged at the Mall of Asia Arena in Pasay City on Saturday, April 30.</p>
          <a href="https://entertainment.inquirer.net/447160/celeste-cortesi-of-pasay-is-miss-universe-ph" class="learn-more-button">Learn More</a>
        </div>
        <div class="col-md-5">
          <img src="../imgs/featurette/celeste-cortesi.jpg" id="woman-photo-3" alt="featurette" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
        </div>
      </div>
    </div>

    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1" aria-current="true"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class=""></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="../imgs/carousel/angat-buhay.jpg" alt="carousel-photo" class="bd-placeholder-img" width="100%" height="100%"  aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
          <div class="container">
            <div class="carousel-caption text-start">
              <h1 class="carousel-text">Leni Robredo to launch Angat Buhay NGO in July</h1>
              <p class="carousel-text">Following the widespread volunteerism spirit that her office and campaign have initiated, Vice President Leni Robredo bared her plans in launching the 'widest' volunteer center in the country.</p>
              <p><a class="btn btn-lg btn-primary read-more-button" href="https://www.cnnphilippines.com/news/2022/5/13/Robredo-Angat-Buhay-NGO-in-July.html">Read More</a></p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
        <img src="../imgs/carousel/gina-lopez-pass.jpg" alt="carousel-photo" class="bd-placeholder-img" width="100%" height="100%"  aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
          <div class="container">
            <div class="carousel-caption">
              <h1 >Gina Lopez, Philippine anti-mining advocate, dies aged 65</h1>
              <p >Staunch eco-campaigner and former Philippine Environment Minister Gina Lopez has died at the age of 65.</p>
              <p><a class="btn btn-lg btn-primary read-more-button" href="https://www.bbc.com/news/world-asia-49399205">Read More</a></p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
        <img src="../imgs/carousel/hidilyn-diaz.jpg" alt="carousel-photo" class="bd-placeholder-img" width="100%" height="100%"  aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
          <div class="container">
            <div class="carousel-caption text-end">
              <h1>Weightlifter Hidilyn Diaz wins first-ever Olympic gold for Philippines</h1>
              <p>Hidilyn Diaz has become the first Olympic gold medalist from the Philippines after winning the women’s 55-kilogram weightlifting category.</p>
              <p><a class="btn btn-lg btn-primary read-more-button" href="https://olympics.com/en/news/weightlifter-hidilyn-diaz-wins-first-ever-olympic-gold-for-philippines">Read More</a></p>
            </div>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
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
                      window.location.replace("homepage.php");
                  }, 3000);})</script>';
    }
    ?>
  <?php endif ?>
  <script type="text/javascript">
    const scroller = new LocomotiveScroll({
      el: document.querySelector('[data-scroll-container]'),
      smooth: true
    });

    $(document).ready(function() {
      var alertModal = $('#validation-container');
      $('.close-button').click(function() {
        alertModal.removeClass("vali-modal-container-active");
        alertModal.addClass("vali-modal-container-inactive");
      });

      $('.modal').on('shown.bs.modal', function(e) {
        scroller.stop();
      });

      $('.modal').on('hidden.bs.modal', function(e) {
        scroller.start();
      });
    });
  </script>
</body>

</html>
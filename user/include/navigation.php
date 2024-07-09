<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include('../include/db_connect.php'); // Include the database connection file

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$donorName = '';

if ($isLoggedIn) {
  // Fetch the logged-in user's name
  $user_id = $_SESSION['user_id'];
  try {
    $stmt = $conn->prepare("SELECT name FROM donors WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    // Fetch the user information
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $donorName = $user['name'];
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $isLoggedIn = false; // Treat as not logged in if there's an error
  }

  $conn = null; // Close the connection
}
?>


<nav id="mainNav" class="navbar fixed-top navbar-default navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="../index.php">DONATETHEBLOOD</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">

    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

    </ul>

    <ul class="navbar-nav form-inline my-2 my-lg-0">

      <li class="nav-item">
        <a class="nav-link" href="../index.php">Home</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../donor.php">Donors</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../search.php">Search</a>
      </li>

      <?php if (!$isLoggedIn) : ?>
        <li class="nav-item">
          <a class="nav-link" href="../signin.php">Signin</a>
        </li>
      <?php endif; ?>

      <li class="nav-item">
        <a class="nav-link" href="../about.php">About Us</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../donate.php"> donate</a>


      
      <li class="nav-item">
        <a href="nav-link" href="user notice">User Notification</a>
      </li>
      


      <?php if ($isLoggedIn) : ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo htmlspecialchars($user['name']); ?><!-- Donor Name -->
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

            <a class="dropdown-item" href="./index.php"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>

            <a class="dropdown-item" href="./update.php"><i class="fa fa-edit" aria-hidden="true"></i>
              Update Profile</a>

            <a class="dropdown-item" href="../logout.php">
              <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>

              Logout</a>
          </div>
        </li>

      <?php endif; ?>


    </ul>
  </div>
</nav>
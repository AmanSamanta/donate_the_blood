<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

include 'include/header.php';

// include 'include/sidebar.php';

// Include database connection
include('../include/db_connect.php');

?>

<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch user data based on user ID (assumed to be passed via GET request)
// $user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
	echo "You must log in first.";
	$_SESSION['message'] = "You must log in first.";
	$_SESSION['message_type'] = "danger";
	exit();
}


$user_id = $_SESSION['user_id'];

// echo "Retrieved ID: " . htmlspecialchars($user_id) . "<br>";

if ($user_id > 0) {
	$sql = "SELECT name, blood_group, gender, email, contact_no, city FROM donors WHERE id = :id";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	// Check if user data is found
	if (!$user) {
		echo "User not found.";
		$_SESSION['message'] = "User not found.";
		$_SESSION['message_type'] = "danger";
		exit;
	}
} else {
	echo "Invalid user ID.";
	$_SESSION['message'] = "Invalid user ID.";
	$_SESSION['message_type'] = "danger";
	exit;
}

// Update user data

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_details']))  {
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_details']) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	$name = $_POST['name'];
	$blood_group = $_POST['blood_group'];
//	$gender = $_POST['gender'];
	$email = $_POST['email'];
	$contact_no = $_POST['contact_no'];
	$city = $_POST['city'];

	$sql = "UPDATE donors SET name = :name, blood_group = :blood_group, email = :email, contact_no = :contact_no, city = :city WHERE id = :id";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':blood_group', $blood_group, PDO::PARAM_STR);
	//$stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	$stmt->bindParam(':contact_no', $contact_no, PDO::PARAM_STR);
	$stmt->bindParam(':city', $city, PDO::PARAM_STR);
	$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

	if ($stmt->execute()) {
				
			$_SESSION['message'] = "User updated successfully.";
			$_SESSION['message_type'] = "success";
	} else {

			$_SESSION['message'] = "Error updating user.";
			$_SESSION['message_type'] = "danger";
	}

}
?>

<?php
					// Check if the form is submitted
					if (isset($_POST['update_pass'])) {
							// Get the form data
							$old_password = $_POST['old_password'];
							$new_password = $_POST['new_password'];
							$c_password = $_POST['c_password'];

							// Get the logged-in user's ID (assuming you have a way to identify the logged-in user)
							// For example, using session (this is just an example, adjust as per your actual logic)
							// session_start();
							$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session during login

							// Validate form inputs
							if ($new_password !== $c_password) {
									echo "New password and confirm password do not match.";
									$_SESSION['message'] = "New password and confirm password do not match.";
        					$_SESSION['message_type'] = "danger";
							} else {
									// Fetch the current password from the database
									$stmt = $conn->prepare("SELECT password FROM donors WHERE id = :user_id");
									$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
									$stmt->execute();
									$result = $stmt->fetch(PDO::FETCH_ASSOC);

									if ($result && $result['password'] === $old_password) {
											// Update the password in the database
											$stmt = $conn->prepare("UPDATE donors SET password = :new_password WHERE id = :user_id");
											$stmt->bindParam(':new_password', $new_password, PDO::PARAM_STR);
											$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

											if ($stmt->execute()) {
													echo "Password updated successfully.";
													$_SESSION['message'] = "Password updated successfully.";
													$_SESSION['message_type'] = "success";
											} else {
													echo "Error updating password.";
													$_SESSION['message'] = "Error updating password.";
                					$_SESSION['message_type'] = "danger";
											}
									} else {
											echo "Current password is incorrect.";
											$_SESSION['message'] = "Current password is incorrect.";
            					$_SESSION['message_type'] = "danger";
									}
							}

							header("Location: update.php");
    					exit;
					}
?>


<?php
		// Process form submission for deleting account
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_account'])) {

			$user_id = $_SESSION['user_id'];
			// Fetch the current password from the database
			$stmt = $conn->prepare("SELECT password FROM donors WHERE id = :user_id");
			$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			// Validate password
			$password = $_POST['account_password'];

			echo $password;
			echo $result['password'];

			if ($password === $result['password']) {
					// Password is correct, proceed with deletion
					$sql_delete = "DELETE FROM donors WHERE id = :id";
					$stmt_delete = $conn->prepare($sql_delete);
					$stmt_delete->bindParam(':id', $user_id, PDO::PARAM_INT);

					if ($stmt_delete->execute()) {
							// Delete successful
							// Optionally, you can also perform additional cleanup or logging here

							// Clear session and redirect to a logged-out or confirmation page
							session_destroy(); // Destroy all sessions
							header("Location: ../donate.php"); // Redirect to login page or any other appropriate page
							exit();
					} else {
							// Delete failed
							$_SESSION['message'] = "Failed to delete user.";
							$_SESSION['message_type'] = "danger";
							// Optionally, handle error logging or additional actions
					}
			} else {
					// Password incorrect
					$_SESSION['message'] = "Incorrect password. Please try again.";
					$_SESSION['message_type'] = "danger";
					// Optionally, handle further actions or error messaging
			}
		}
?>


<style>
	.form-group {
		text-align: left;
	}

	.form-container {

		padding: 20px 10px 20px 30px;

	}
	/* .notification {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: none;
            z-index: 1000;
  } */
</style>

<div class="container" style="padding: 60px 0;">
	<div class="row">

		<div class="col-md-6 offset-md-3 container">
					<?php
								if (isset($_SESSION['message'])) {
										echo '<div class="alert alert-' . $_SESSION['message_type'] . ' alert-dismissible fade show" role="alert" id="messageAlert">';
										echo $_SESSION['message'];
										echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
										echo '<span aria-hidden="true">&times;</span>';
										echo '</button>';
										echo '</div>';
										unset($_SESSION['message']);
										unset($_SESSION['message_type']);
								}
					?>
		</div>

		<div class=" card col-md-6 offset-md-3">
			<div class="panel panel-default" style="padding: 20px;">

				<!-- Error Messages -->


				<form action="" method="post" class="form-group form-container" id="updateForm">
					<input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">

					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" required name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>">
					</div>

					<div class="form-group">
						<label for="blood_group">Blood Group</label><br>
						<select class="form-control demo-default" required id="blood_group" name="blood_group">
							<option value=""> </option>
							<option value="A+" <?php echo ($user['blood_group'] == 'A+' ? 'selected' : ''); ?>>A+</option>
							<option value="A-" <?php echo ($user['blood_group'] == 'A-' ? 'selected' : ''); ?>>A-</option>
							<option value="B+" <?php echo ($user['blood_group'] == 'B+' ? 'selected' : ''); ?>>B+</option>
							<option value="B-" <?php echo ($user['blood_group'] == 'B-' ? 'selected' : ''); ?>>B-</option>
							<option value="O+" <?php echo ($user['blood_group'] == 'O+' ? 'selected' : ''); ?>>O+</option>
							<option value="O-" <?php echo ($user['blood_group'] == 'O-' ? 'selected' : ''); ?>>O-</option>
							<option value="AB+" <?php echo ($user['blood_group'] == 'AB+' ? 'selected' : ''); ?>>AB+</option>
							<option value="AB-" <?php echo ($user['blood_group'] == 'AB-' ? 'selected' : ''); ?>>AB-</option>
						</select>
					</div>

					<div class="form-group">
						<label for="gender">Gender</label><br>
						<input type="text" id="gender" class="form-control" value="<?php echo htmlspecialchars($user['gender']); ?>" readonly>
					</div>

					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,4}" name="email" class="form-control" required value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
					</div>

					<div class="form-group">
						<label for="contact_no">Contact No</label>
						<input type="text" name="contact_no" value="<?php echo htmlspecialchars($user['contact_no']); ?>" class="form-control" required pattern="^\d{10}$" title="10 numeric characters only" maxlength="10">
					</div>

					<div class="form-group">
						<label for="city">City</label>
						<select name="city" id="city" class="form-control demo-default" required>
							<option value=""> </option>
							<option value="ghatal" <?php echo ($user['city'] == 'ghatal' ? 'selected' : ''); ?>>Ghatal</option>

							<option value="daspur" <?php echo ($user['city'] == 'daspur' ? 'selected' : ''); ?>>daspur</option>

							<option value="chondrokona" <?php echo ($user['city'] == 'chondrokona' ? 'selected' : ''); ?>>chondrokona</option>

							<option value="keshpur" <?php echo ($user['city'] == 'keshpur' ? 'selected' : ''); ?>>keshpur</option>

							<option value="arambag" <?php echo ($user['city'] == 'arambag' ? 'selected' : ''); ?>>arambag</option>
							<option value="medinipur" <?php echo ($user['city'] == 'medinipur' ? 'selected' : ''); ?>>medinipur</option>

							<option value="panskura" <?php echo ($user['city'] == 'panskura' ? 'selected' : ''); ?>>panskura</option>

							<option value="tamluk" <?php echo ($user['city'] == 'South tamluk ' ? 'selected' : ''); ?>>Tamluk</option>

							
							<option value="haldia" <?php echo ($user['city'] == 'haldia' ? 'selected' : ''); ?>>Haldia</option>
							<option value="harirampur" <?php echo ($user['city'] == 'harirampur' ? 'selected' : ''); ?>>Harirampur</option>
							
							<option value="nandigram" <?php echo ($user['city'] == 'nandigram' ? 'selected' : ''); ?>>Nandigram</option>
							

							<option value="howra" <?php echo ($user['city'] == 'howra' ? 'selected' : ''); ?>>Howra</option>
						</select>
					</div>

					<div class="form-group">
						<button class="btn btn-lg btn-danger center-aligned" type="submit" name="update_details">Update</button>
					</div>
				</form>

			</div>
		</div>
		<div class="card col-md-6 offset-md-3">
			<div class="panel panel-default" style="padding: 20px;">

			


				<!-- Messages -->

				<form action="" method="post" class="form-group form-container">
        <div class="form-group">
            <label for="oldpassword">Current Password</label>
            <input type="password" required name="old_password" placeholder="Current Password" class="form-control">
        </div>
        <div class="form-group">
            <label for="newpassword">New Password</label>
            <input type="password" required name="new_password" placeholder="New Password" class="form-control">
        </div>
        <div class="form-group">
            <label for="c_password">Confirm Password</label>
            <input type="password" required name="c_password" placeholder="Confirm Password" class="form-control">
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-danger center-aligned" type="submit" name="update_pass">Update Password</button>
        </div>
    		</form>

				<script>
						$(document).ready(function() {
								var message = $('#messageAlert');
								if (message.length) {
										// Show the alert message
										message.fadeIn();

										// Auto-dismiss the alert after 5 seconds
										setTimeout(function() {
												message.fadeOut('slow', function() {
														$(this).remove();
												});
										}, 5000); // 5000ms = 5 seconds
								}
						});
				</script>

				
			</div>
		</div>


		<div class="card col-md-6 offset-md-3">

			<!-- Display Message -->

			<div class="panel panel-default" style="padding: 20px;">
				<form action="" method="post" class="form-group form-container">

					<div class="form-group">
						<label for="oldpassword">Password</label>
						<input type="password" required name="account_password" placeholder="Current Password" class="form-control">
					</div>

					<div class="form-group">
						<button class="btn btn-lg btn-danger center-aligned" type="submit" name="delete_account">Delete Account</button>
					</div>

				</form>
			</div>
		</div>

	</div>
</div>




<?php
include 'include/footer.php';
?>
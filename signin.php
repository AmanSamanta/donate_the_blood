<?php

//include header file
include('include/header.php');

?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('include/db_connect.php'); // Include the database connection file

// Initialize variables
$email = '';
$password = '';
$login_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Get form data
	$email = $_POST['email'];
	$password = $_POST['password'];

	try {
		// Prepare the SQL statement
		$stmt = $conn->prepare("SELECT id, password FROM donors WHERE email = :email");
		$stmt->bindParam(':email', $email);

		// Execute the statement
		$stmt->execute();

		// Fetch the result
		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$stored_password = $row['password'];

			// Verify the password
			if ($password === $stored_password) {
				// Password is correct, start the session and redirect to the dashboard or welcome page
				$_SESSION['user_id'] = $id;
				$_SESSION['email'] = $email;
				header("Location: user/index.php"); // Change this to your dashboard or welcome page
				exit();
			} else {
				// Invalid password
				$login_error = "Invalid password.";
			}
		} else {
			// No user found with that email
			$login_error = "No user found with that email.";
		}
	} catch (PDOException $e) {
		$login_error = "Error: " . $e->getMessage();
	}

	// Close the connection
	$conn = null;
}
?>

<style>
	.size {
		min-height: 0px;
		padding: 60px 0 60px 0;

	}

	h1 {
		color: white;
	}

	.form-group {
		text-align: left;
	}

	h3 {
		color: #e74c3c;
		text-align: center;
	}

	.red-bar {
		width: 25%;
	}

	.form-container {
		background-color: white;
		border: .5px solid #eee;
		border-radius: 5px;
		padding: 20px 10px 20px 30px;
		-webkit-box-shadow: 0px 2px 5px -2px rgba(89, 89, 89, 0.95);
		-moz-box-shadow: 0px 2px 5px -2px rgba(89, 89, 89, 0.95);
		box-shadow: 0px 2px 5px -2px rgba(89, 89, 89, 0.95);
	}
</style>
<div class="container-fluid red-background size">
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<h1 class="text-center">SignIn</h1>
			<hr class="white-bar">
		</div>
	</div>
</div>
<div class="conatiner size ">
	<div class="row">
		<div class="col-md-6 offset-md-3 form-container">
			<h3>SignIn</h3>
			<hr class="red-bar">

			<!-- Erorr Messages -->

			<form action="" method="post">
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email" class="form-control" placeholder="Email" required value="<?php echo htmlspecialchars($email); ?>">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="Password" required class="form-control">
				</div>
				<div class="form-group">
					<button class="btn btn-danger btn-lg center-aligned" type="submit" name="SignIn">SignIn</button>
				</div>
				<div class="form-group">
					<p >Don't Have Account? <a href="donate.php" style="font-weight: 'bold';">SignUp</a></p>
				</div>
			</form>
			<?php
			if ($login_error) {
				echo '<p style="color:red;">' . htmlspecialchars($login_error) . '</p>';
			}
			?>
		</div>
	</div>
</div>
<?php include 'include/footer.php' ?>
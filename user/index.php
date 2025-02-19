
<?php 

	include 'include/header.php'; 
	

?>

<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
include('../include/db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Fetch logged-in user information
$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT name, email, blood_group, gender, date_of_birth, city, contact_no FROM donors WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    // Fetch the user information
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $user = null;
}

$conn = null; // Close the connection
?>


<style>
	h1,h3{
		display: inline-block;
		padding: 10px;
	}
</style>

			<div class="container" style="padding: 60px 0;">
			<div class="row">
				<div class="col-md-12 col-md-push-1">
					<div class="panel panel-default" style="padding: 20px;">
						<div class="panel-body">
							
								<div class="alert alert-danger alert-dismissable" style="font-size: 18px; display: none;">
    						
    								<strong>Warning!</strong> Are you sure you want a save the life if you press yes, then you will not be able to show before 3 months.
    							
    							<div class="buttons" style="padding: 20px 10px;">
    								<input type="text" value="" hidden="true" name="today">
    								<button class="btn btn-primary" id="yes" name="yes" type="submit">Yes</button>
    								<button class="btn btn-info" id="no" name="no">No</button>
    							</div>
  							</div>
							<div class="heading text-center">
								<h3>Welcome </h3> <h1><?php echo htmlspecialchars($user['name']); ?>!</h1>
							</div>
							<p class="text-center">Here you can mennage your account update your profile</p>
							<button style="margin-top: 20px;" name="date" id="save_the_life" class="btn btn-lg btn-danger center-aligned ">Save The Life</button>
							<div class="test-success text-center" id="data" style="margin-top: 20px;"><!-- Display Message here--></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
<?php

include 'include/footer.php'; 
?>
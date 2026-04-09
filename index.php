<?php

//include header file
include('include/header.php');
?>
<div class="container-fluid" style="width: 100%; background: url(img/max.jpg) no-repeat center center fixed;">
	<div class="row">
		<div class="col-md-6 offset-md-3" style="width: 100%">
			<!-- <div class="ghatalhos-img"> -->
			<div style="-webkit-background-size: cover; -moz-background-size: cover; background-size: cover; -o-background-size: cover; height: 100vh; width: 100%; padding: 9px; color: white; font-weight: 700; display: flex; flex-direction: column;justify-content: center; align-items: center; text-align: center; box-sizing: border-box;">
				<div class="mb-2">
				<h1 class='text-center' style='font-size: 40px; color: red; margin-bottom: 10px;'>Donate The Blood, Save the Life</h1>
					<h1 style='font-size: 50px; color: yellow; font-weight:bold'>ঘাটাল সুপার স্পেশালিস্ট হাসপাতাল
					</h1>";
				</div>
				<div>
					<h1 class="text-center" style="font-size: 1.7rem;">Search The Donor Location</h1>
					<hr class="white-bar text-center">

					<form action="index.php" method="post" class="form-inline text-center" style="padding: 10px 0px 0px 5px;">

						<div class="form-group text-center justify-content-center">

							<select style="width: 220px; height: 45px;" name="city" id="city" class="form-control demo-default" required>

								<option value="">-- Select --</option>
								<optgroup title="purba medinipur" label="&raquo; purba medinipur">purba medinipur</optgroup>
								<option value="haldia">haldia</option>
								<option value="panskura">Panskura</option>
								<option value="panskura"></option>
								<option value="panskura">Tamluk</option>
								<option value="panskura">Digha</option>
								<option value="panskura">nandigram</option>

								<optgroup title="paschim medinipur" label="&raquo; paschim medinipur"></optgroup>
								<option value="kharagpur">kharagpur</option>
								<option value="keshpur">keshpur</option>
								<option value="ghatal">ghatal</option>
								<option value="chondrokona">chondrokona</option>
								<option value="Daspur">Daspur</option>
								<option value="narajole">narajole</option>
								<option value="harirampur">harirampur</option>

								<option value="Rajnagor">Rajnagor</option>

								<option value="khirpai">khirpai</option>
								<option value="howra">howra</option>
								<option value="ulberia">ulberia</option>
							</select>
						</div>
						<div class="form-group center-aligned">
							<select name="blood_group" id="blood_group" style="padding: 0 20px; width: 220px; height: 45px;" class="form-control demo-default text-center margin10px">

								<option value="A+">A+</option>
								<option value="A-">A-</option>
								<option value="B+">B+</option>
								<option value="B-">B-</option>
								<option value="AB+">AB+</option>
								<option value="AB-">AB-</option>
								<option value="O+">O+</option>
								<option value="O-">O-</option>
							</select>
						</div>
						<div class="form-group center-aligned">
							<button type="submit" value="Search" class="btn btn-lg btn-danger">Search</button>
						</div>
					</form>
				</div>
			</div>

			<?php
			// Include database connection
			include('include/db_connect.php');


			// Check if form is submitted
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				// Get the selected values
				$city = trim($_POST["city"]);
				$blood_group = trim($_POST["blood_group"]);

				// Prepare the SQL query
				$query = "SELECT * FROM donors WHERE 1=1";
				if (!empty($city)) {
					$query .= " AND city = :city";
				}
				if (!empty($blood_group)) {
					$query .= " AND blood_group = :blood_group";
				}

				try {
					// Prepare and execute the query
					$stmt = $conn->prepare($query);

					if (!empty($city)) {
						$stmt->bindParam(':city', $city);
					}
					if (!empty($blood_group)) {
						$stmt->bindParam(':blood_group', $blood_group);
					}

					$stmt->execute();
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

					// Check if any donors found
					if ($stmt->rowCount() > 0) {
						echo "<h3 style='color: white;'>Donors List</h3>";
						echo "<table border='1' style='color: white; border-color: white; margin-bottom: 1rem;'>
                        <tr style='color: white;'>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Blood Group</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Email</th>
                            // <th>Contact No</th>
                            <th>City</th>
                        </tr>";
						foreach ($result as $row) {
							echo "<tr style='color: white;'>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['blood_group'] . "</td>
                            <td>" . $row['gender'] . "</td>
                            <td>" . $row['date_of_birth'] . "</td>
                            <td>" . $row['email'] . "</td>
                            // <td>" . $row['contact_no'] . "</td>
                            <td>" . $row['city'] . "</td>
                          </tr>";
						}
						echo "</table>";
					} else {
						echo "<p style='color: blue; font-weight: bold; font-size:50px;'>No donors found.</p>";
					}
				} catch (PDOException $e) {
					echo "Error: " . $e->getMessage();
				}
			}
			?>
		</div>
	</div>
</div>
<!-- header ends -->

<!-- donate section -->
<div class="container-fluid">
	<div class="row red-background">
		<div class="col-md-12">
			<h1 class="text-center" style="color: white; font-weight: 700;padding: 10px 0 0 0;">Donate The Blood</h1>
			<hr class="white-bar">
			<p class="text-center pera-text">
				We are a group of exceptional programmers; our aim is to promote education. If you are a student, then contact us to secure your future. We deliver free international standard video lectures and content. We are also providing services in Web & Software Development.

				We are a group of exceptional programmers; our aim is to promote education. If you are a student, then contact us to secure your future. We deliver free international standard video lectures and content. We are also providing services in Web & Software Development.
			</p>
			<a href="#" class="btn btn-default btn-lg text-center center-aligned">Become a Life Saver!</a>
		</div>
	</div>
</div>
<!-- end doante section -->

<!-- registered donors section -->
<div class="container-fluid" style="padding: 30px 15px; background-color: #f1f3f6;">
	<div class="row">
		<div class="col-md-10 offset-md-1">
			<h2 class="text-center" style="color: #c82333; font-weight: 700;">List All Patients</h2>
			<hr class="white-bar" style="border-color: #c82333;">

			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Blood Group</th>
							<th>Gender</th>
							<th>City</th>
						</tr>
					</thead>
					<tbody>
						<?php
						try {
							$allDonorsStmt = $conn->prepare("SELECT id, name, blood_group, gender, city FROM donors ORDER BY id DESC");
							$allDonorsStmt->execute();
							$allDonors = $allDonorsStmt->fetchAll(PDO::FETCH_ASSOC);

							if (!empty($allDonors)) {
								foreach ($allDonors as $donor) {
									echo "<tr>";
									echo "<td>" . htmlspecialchars($donor['id']) . "</td>";
									echo "<td>" . htmlspecialchars($donor['name']) . "</td>";
									echo "<td>" . htmlspecialchars($donor['blood_group']) . "</td>";
									echo "<td>" . htmlspecialchars($donor['gender']) . "</td>";
									echo "<td>" . htmlspecialchars($donor['city']) . "</td>";
									echo "</tr>";
								}
							} else {
								echo "<tr><td colspan='5' class='text-center'>No registered donors found.</td></tr>";
							}
						} catch (PDOException $e) {
							echo "<tr><td colspan='5' class='text-center text-danger'>Unable to load donor data.</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- end registered donors section -->

<div class="container">
	<div class="row">
		<div class="col">
			<div class="card">
				<h3 class="text-center red">Our Vission</h3>
				<img src="img/binoculars.png" alt="Our Vission" class="img img-responsive" width="168" height="168">
				<p class="text-center">
					We are a group of exceptional programmers; our aim is to promote education. If you are a student, then contact us to secure your future. We deliver free international standard video lectures and content. We are also providing services in Web & Software Development.
				</p>
			</div>
		</div>

		<div class="col">
			<div class="card">
				<h3 class="text-center red">Our Goal</h3>
				<img src="img/target.png" alt="Our Vission" class="img img-responsive" width="168" height="168">
				<p class="text-center">
					We are a group of exceptional programmers;
					our aim is to promote education.
					If you are a student, then contact us to secure your future.
					We deliver free international standard video lectures and content.
					We are also providing services in Web & Software Development.
				</p>
			</div>
		</div>

		<div class="col">
			<div class="card">
				<h3 class="text-center red">Our Mission</h3>
				<img src="img/goal.png" alt="Our Vission" class="img img-responsive" width="168" height="168">
				<p class="text-center">
					our aim is to promote education.<span>If you are a student, then contact us to secure your future.</span>
					We deliver free international standard video lectures and content.
					We are also providing services in Web & Software Development.
				</p>
			</div>
		</div>
	</div>
</div>

<!-- end aboutus section -->
<?php
//include footer file
include('include/footer.php');
?>
<?php 

	//include header file
	include ('include/header.php');

?>
<style>
	.size{
		min-height: 0px;
		padding: 60px 0 40px 0;

	}
	.loader{
		display:none;
		width:69px;
		height:89px;
		position:absolute;
		top:25%;
		left:50%;
		padding:2px;
		z-index: 1;
	}
	.loader .fa{
		color: #e74c3c;
		font-size: 52px !important;
	}
	.form-group{
		text-align: left;
	}
	h1{
		color: white;
	}
	h3{
		color: #e74c3c;
		text-align: center;
	}
	.red-bar{
		width: 25%;
	}
	span{
		display: block;
	}
	.name{
		color: #e74c3c;
		font-size: 22px;
		font-weight: 700;
	}
	.donors_data{
		background-color: pink;
		border-radius: 5px;
		margin: 25px;
		-webkit-box-shadow: 0px 2px 5px -2px rgba(89,89,89,0.95);
		-moz-box-shadow: 0px 2px 5px -2px rgba(89,89,89,0.95);
		box-shadow: 0px 2px 5px -2px rgba(89,89,89,0.95);
		padding: 20px 10px 20px 30px;
	}
</style>
<div class="container-fluid red-background size">
	<div class="row">
		<div class="ccol-md-6 offset-md-3">
			<h1 class="text-center">Search Donors</h1>
			<hr class="white-bar">
			<br>
			<div class="form-inline text-center" style="padding: 40px 0px 0px 5px;">
			<form action="index.php" method="post" class="form-inline 
			text-center" style="padding: 40px 0px 0px 5px;">
							<div class="form-group text-center center-aligned">
								<select style="width: 220px; height: 45px;" name="city" id="city" class="form-control demo-default" required>


	<option value="">-- Select --</option><optgroup title="purba medinipur" label="&raquo; purba medinipur"></optgroup><option value="Bagh" >Panskura</option><option value="Bhimber" >Tamluk</option><option value="Kotli" >Haldia</option><option value="Muzaffarabad" >Digha</option><option value="Khuzdar" >nandigram</<option value="Sibi" >Sibi</option><option value="Zhob" >Zhob</option>
	
	<optgroup title="paschim medinipur" label="&raquo; paschim medinipur"></optgroup>
	
	<option value="Alipur" >ghatal</option><option value="Attock" >kharagpur</option><option value="Shekhupura" >harirampur</option><option value="Sialkot" >daspur</option><option value="Toba Tek Singh" >narajole</option><option value="Vehari" >khirpai</option>
	
	<optgroup title="Howra" label="&raquo; howra"></optgroup><option value="Badin" >Badin</option><option value="Dadu" >Dadu</option><option value="Ghotki" >Ghotki</option><option value="Hyderabad" >Hyderabad</option><option value="Umerkot" >Umerkot</option></select>
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
								<button type="button" value="Search" class="btn btn-lg btn-default" id="search">Search</button>
							</div>
							</form>

							<?php
// Include database connection
include ('include/db_connect.php');

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
            echo "<h3>Donors List</h3>";
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Blood Group</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th>City</th>
                    </tr>";
            foreach ($result as $row) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>" . $row['blood_group'] . "</td>
                        <td>" . $row['gender'] . "</td>
                        <td>" . $row['date_of_birth'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['contact_no'] . "</td>
                        <td>" . $row['city'] . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No donors found.</p>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
                     
			<!-- </div> -->
		</div>
	</div>
</div>
<div class="container" style="padding: 60px 0 60px 0;">
	<div class="row " id="data">

		<!-- Display The Search Result -->

</div>
</div>
<div class="loader" id="wait">
	<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
</div>
<?php 

	//include footer file
	include ('include/footer.php');

?>

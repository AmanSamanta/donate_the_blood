<?php
//include header file//
include('include/header.php');

// Include database connection
include('include/db_connect.php');

// Define variables and initialize with empty values
$name = $blood_group = $gender = $date_of_birth = $email = $contact_no = $city = $password = "";
$name_err = $blood_group_err = $gender_err = $date_of_birth_err = $email_err = $contact_no_err = $city_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate blood group
    if (empty(trim($_POST["blood_group"]))) {
        $blood_group_err = "Please enter a blood group.";
    } else {
        $blood_group = trim($_POST["blood_group"]);
    }

    // Validate gender
    if (empty(trim($_POST["gender"]))) {
        $gender_err = "Please select a gender.";
    } else {
        $gender = trim($_POST["gender"]);
    }

    // Validate date of birth
    if (empty(trim($_POST["date"])) || empty(trim($_POST["month"])) || empty(trim($_POST["year"]))) {
        $date_of_birth_err = "Please enter a valid date of birth.";
    } else {
        $day = trim($_POST["date"]);
        $month = trim($_POST["month"]);
        $year = trim($_POST["year"]);
        $date_of_birth = $year . '-' . $month . '-' . $day;
    }


    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate contact number
    if (empty(trim($_POST["contact_no"]))) {
        $contact_no_err = "Please enter a contact number.";
    } else {
        $contact_no = trim($_POST["contact_no"]);
    }

    // Validate city
    if (empty(trim($_POST["city"]))) {
        $city_err = "Please enter a city.";
    } else {
        $city = trim($_POST["city"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($blood_group_err) && empty($gender_err) && empty($date_of_birth_err) && empty($email_err) && empty($contact_no_err) && empty($city_err) && empty($password_err)) {
        try {
            // Prepare an SQL statement
            $stmt = $conn->prepare("INSERT INTO donors (name, blood_group, gender, date_of_birth, email, contact_no, city, password) VALUES (:name, :blood_group, :gender, :date_of_birth, :email, :contact_no, :city, :password)");

            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':blood_group', $blood_group);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':date_of_birth', $date_of_birth);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contact_no', $contact_no);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':password', $password);

            // Insert a row
            $stmt->execute();

            echo "New record created successfully";
				header("Location: signin.php"); // Change this to your dashboard or welcome page
				exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

?>

<style>
    .size {
        min-height: 0px;
        padding: 60px 0 40px 0;

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

    .form-group {
        text-align: left;
    }

    h1 {
        color: white;
    }

    h3 {
        color: #e74c3c;
        text-align: center;
    }

    .red-bar {
        width: 25%;
    }
</style>
<div class="container-fluid red-background size">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="text-center">Donate</h1>
            <hr class="white-bar">
        </div>
    </div>
</div>
<div class="container size">
    <div class="row">
        <div class="col-md-6 offset-md-3 form-container">
            <h3>SignUp</h3>

            <hr class="red-bar">
            <?php if (isset($_termError)) echo $_termError; ?>
            <!-- Error Messages -->

            <form class="form-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate="">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" name="name" value="<?php echo $name; ?>" id="fullname" placeholder="Full Name" required pattern="[A-Za-z/\s]+" title="Only lower and upper case and space" class="form-control">
                </div>
                <!--full name-->

                <div class="form-group">
                    <label for="blood_group">Blood Group</label><br>
                    <select class="form-control demo-default" id="blood_group" name="blood_group" required>
                        <option value="">---Select Your Blood Group---</option>
                        <option value="A+" <?php if ($blood_group == "A+") echo "selected"; ?>>A+</option>
                        <option value="A-" <?php if ($blood_group == "A-") echo "selected"; ?>>A-</option>
                        <option value="B+" <?php if ($blood_group == "B+") echo "selected"; ?>>B+</option>
                        <option value="B-" <?php if ($blood_group == "B-") echo "selected"; ?>>B-</option>
                        <option value="O+" <?php if ($blood_group == "O+") echo "selected"; ?>>O+</option>
                        <option value="O-" <?php if ($blood_group == "O-") echo "selected"; ?>>O-</option>
                        <option value="AB+" <?php if ($blood_group == "AB+") echo "selected"; ?>>AB+</option>
                        <option value="AB-" <?php if ($blood_group == "AB-") echo "selected"; ?>>AB-</option>
                    </select>




                </div><!--End form-group-->


                <div class="form-group">
                    <label for="gender">Gender</label><br>
                    Male<input type="radio" name="gender" id="gender_male" value="Male" style="margin-left:10px; margin-right:10px;" <?php if ($gender == "Male") echo "checked"; ?>>
                    Fe-male<input type="radio" name="gender" id="gender_female" value="Fe-male" style="margin-left:10px;" <?php if ($gender == "Fe-male") echo "checked"; ?>>
                    others<input type="radio" name="gender" id="gender_other" value="other" style="margin-left:10px;" <?php if ($gender == "other") echo "checked"; ?>>



                </div><!--gender-->

                <div class="form-inline">
                    <label for="date_of_birth">Date of Birth</label><br>

                    <!-- Day Select -->
                    <select class="form-control demo-default" id="date" name="date" style="margin-bottom:10px;" required>
                        <option value="">---Date---</option>
                        <option value="01" <?php if (isset($day) && $day == "01") echo "selected"; ?>>01</option>
                        <option value="02" <?php if (isset($day) && $day == "02") echo "selected"; ?>>02</option>
                        <option value="03" <?php if (isset($day) && $day == "03") echo "selected"; ?>>03</option>
                        <option value="04" <?php if (isset($day) && $day == "04") echo "selected"; ?>>04</option>
                        <option value="05" <?php if (isset($day) && $day == "05") echo "selected"; ?>>05</option>
                        <option value="06" <?php if (isset($day) && $day == "06") echo "selected"; ?>>06</option>
                        <option value="07" <?php if (isset($day) && $day == "07") echo "selected"; ?>>07</option>
                        <option value="08" <?php if (isset($day) && $day == "08") echo "selected"; ?>>08</option>
                        <option value="09" <?php if (isset($day) && $day == "09") echo "selected"; ?>>09</option>
                        <option value="10" <?php if (isset($day) && $day == "10") echo "selected"; ?>>10</option>
                        <!-- Add the remaining days -->
                    </select>

                    <!-- Month Select -->
                    <select class="form-control demo-default" name="month" id="month" style="margin-bottom:10px;" required>
                        <option value="">---Month---</option>
                        <option value="01" <?php if (isset($month) && $month == "01") echo "selected"; ?>>January</option>
                        <option value="02" <?php if (isset($month) && $month == "02") echo "selected"; ?>>February</option>
                        <option value="03" <?php if (isset($month) && $month == "03") echo "selected"; ?>>March</option>
                        <option value="04" <?php if (isset($month) && $month == "04") echo "selected"; ?>>April</option>
                        <option value="05" <?php if (isset($month) && $month == "05") echo "selected"; ?>>May</option>
                        <option value="06" <?php if (isset($month) && $month == "06") echo "selected"; ?>>June</option>
                        <option value="07" <?php if (isset($month) && $month == "07") echo "selected"; ?>>July>
                        <option>
                        <option value="08" <?php if (isset($month) && $month == "08") echo "selected"; ?>>August</option>
                        <option value="09" <?php if (isset($month) && $month == "09") echo "selected"; ?>>September</option>
                        <option value="10" <?php if (isset($month) && $month == "10") echo "selected"; ?>>October</option>
                        <option value="11" <?php if (isset($month) && $month == "11") echo "selected"; ?>>November</option>
                        <option value="12" <?php if (isset($month) && $month == "12") echo "selected"; ?>>December</option>
                    </select>

                    <!-- Year Select -->
                    <select class="form-control demo-default" id="year" name="year" style="margin-bottom:10px;" required>
                        <option value="">---Year---</option>
                        <option value="1995" <?php if (isset($year) && $year == "1957") echo "selected"; ?>>1995</option>
                        <option value="1996" <?php if (isset($year) && $year == "1958") echo "selected"; ?>>1996</option>
                        <option value="1997" <?php if (isset($year) && $year == "1959") echo "selected"; ?>>1997</option>
                        <option value="1998" <?php if (isset($year) && $year == "1960") echo "selected"; ?>>1998</option>
                        <option value="1999" <?php if (isset($year) && $year == "1961") echo "selected"; ?>>1999</option>
                        <option value="2000" <?php if (isset($year) && $year == "1962") echo "selected"; ?>>2000</option>
                        <option value="2001" <?php if (isset($year) && $year == "1963") echo "selected"; ?>>2001</option>
                        <option value="2002" <?php if (isset($year) && $year == "2002") echo "selected"; ?>>2002
                        </option>
                        <option value="2003" <?php if (isset($year) && $year == "2003") echo "selected"; ?>>"2003"
                        </option>
                        <option value="2004" <?php if (isset($year) && $year == "2004") echo "selected"; ?>>2004
                        </option>
                        <option value="2005" <?php if (isset($year) && $year == "2005") echo "selected"; ?>>2005
                        </option>
                        <option value="2006" <?php if (isset($year) && $year == "2006") echo "selected"; ?>>2006
                        </option>
                        <option value="2007" <?php if (isset($year) && $year == "2007") echo "selected"; ?>>2007
                        </option>
                        <option value="2008" <?php if (isset($year) && $year == "2008") echo "selected"; ?>>2008
                        </option>
                        <option value="2009" <?php if (isset($year) && $year == "2009") echo "selected"; ?>>2009
                        </option>
                        <option value="2010" <?php if (isset($year) && $year == "2010") echo "selected"; ?>>2010
                        </option>


                        <!-- Add the remaining years -->
                    </select>



                </div><!--End form-group-->


                <div class="form-group">
                    <label for="fullname">Email</label>
                    <input type="text" name="email" value="<?php echo $email; ?>" id="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Please write correct email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="contact_no">Contact No</label>
                    <input type="text" name="contact_no" value="<?php echo $contact_no; ?>" placeholder="03********" class="form-control" required pattern="^\d{11}$" title="11 numeric characters only" maxlength="11">
                </div><!--End form-group-->

                <div class="form-group">
                    <label for="city">City</label>
                    <select name="city" id="city" class="form-control demo-default" required>
                        <option value="">-- Select --</option>
                        <optgroup title="PASCHIM MEDINIPUR(WB)" label="&raquo; paschim medinipur"></optgroup>
                        <option value="kharagpur" <?php if ($city == "kharagpur") echo "selected"; ?>>kharagpur</option>
                        <option value="harirampur" <?php if ($city == "harirampur") echo "selected"; ?>>Harirampur</option>
                        <option value="keshpur" <?php if ($city == "keshpur") echo "selected"; ?>>keshpur</option>
                        <option value="Mirpur" <?php if ($city == "Mirpur") echo "selected"; ?>>daspur</option>
                        <option value="medinipur" <?php if ($city == "medinipur") echo "selected"; ?>>Medinipur</option>
                        <option value="chondrokona" <?php if ($city == "chondrokona") echo "selected"; ?>>chondrokona</option>
                        <option value="ghatal" <?php if ($city == "ghatal") echo "selected"; ?>>Ghatal</option>
                        
                        <optgroup title="purba meinipur(WB)" label="&raquo; paschim medinipur"></optgroup>

                        <option value="panskura" <?php if ($city == "panskura") echo "selected"; ?>>panskura</option>
                        <option value="tamluk" <?php if ($city == "tamluk") echo "selected"; ?>>Tamluk</option>
                        <option value="haldia" <?php if ($city == "haldia") echo "selected"; ?>>Haldia</option>
                        <option value="nandigram" <?php if ($city == "nandigram") echo "selected"; ?>>Nandigram</option>
                        <option value="howra" <?php if ($city == "howra") echo "selected"; ?>>Howra</option>
                        <option value="ghatal" <?php if ($city == "ghatal") echo "selected"; ?>>Ghatal</option>
                    </select>


                </div>

                <!--city end-->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="<?php echo $password; ?>" placeholder="Password" class="form-control" required pattern="{6,}">
                </div><!--End form-group-->
                <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" name="c_password" value="" placeholder="Confirm Password" class="form-control" required pattern="{6,}">
                </div><!--End form-group-->
                <div class="form-inline">
                    <input type="checkbox" name="term" value="true" required style="margin-left:10px;">
                    <span style="margin-left:10px;"><b>I am agree to donate my blood and show my Name, Contact Nos. and E-Mail in Blood donors List</b></span>
                </div><!--End form-group-->

                <div class="form-group">
                    <button id="submit" name="submit" value="Submit" type="submit" class="btn btn-lg btn-danger center-aligned" style="margin-top: 20px;">SignUp</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
//include footer file
include('include/footer.php');
?>
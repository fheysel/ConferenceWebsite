<?php
  if(isset($_POST["attendeeSubmit"])){ //if a new attendee is registered
    $fname = $_POST["firstname"];
    $lname = $_POST["lastname"];
    $email = $_POST["email"];
    $companyName = $_POST["companyName"];
    $studentNum = $_POST["studentNum"];
    $schoolName = $_POST["schoolName"];
    $attendee = $_POST["attendee"];
    $message = "Success! Welcome to the conference ".$fname." ".$lname.". You have purchased a ".$attendee." ticket, your ticket has been emailed to ".$email;
    $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");


    if($attendee == "professional"){//PROFESSIONAL REGISTRATION
      $sql = "INSERT INTO professional(email, fname, lname) VALUES ('$email', '$fname', '$lname')";
    }
    elseif($attendee == "sponsor"){
      $sql = "INSERT INTO sponsor(email, fname, lname, companyName) VALUES ('$email', '$fname', '$lname', '$companyName')";
    }
    elseif($attendee = "student"){
      $sql = "INSERT INTO student(email, fname, lname, studentNum, schoolName) VALUES ('$email', '$fname', '$lname', '$studentNum', '$schoolName')";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // redirect to the same page without the POST data
    header("Location: ".$_SERVER['PHP_SELF']);
    die;
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
  if (isset($_POST["donateSubmit"])) {
    $companyName = $_POST["registeringCompanyName"];
    $donationAmount = $_POST["donation"];

    $message = "Thank you kindly for your generous donation".$companyName;
    $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");

    if($donationAmount >= 10000){
      $sponsorLevel = "Platinum";
    }
    elseif ($donationAmount >= 5000) {
      $sponsorLevel = "Gold";
    }
    elseif ($donationAmount >= 3000) {
      $sponsorLevel = "Silver";
    }
    else{
      $sponsorLevel = "Bronze";
    }

    $sql = "INSERT INTO company(name, sponsorship, emailsSent) VALUES ('$companyName', '$sponsorLevel', 0)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // redirect to the same page without the POST data
    header("Location: ".$_SERVER['PHP_SELF']);
    die;
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
  if(isset($_POST["deleteSponsor"])){
    $companyName = $_POST["cNameDelete"];

    $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");
    $sql = "DELETE FROM company WHERE name = '$companyName'; DELETE FROM sponsor WHERE companyName = '$companyName'";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // redirect to the same page without the POST data
    header("Location: ".$_SERVER['PHP_SELF']);
    die;
  }
 ?>
<!DOCTYPE html>
<html>
<head>
<link href="conStyle.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
  <nav class="navbar nabar-default">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">Home</a>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="#">Schedule</a></li>
        <li><a href="#">Job Board</a></li>
        <li><a href="#">Housing</a></li>
      </ul>
    </div>
  </nav>

  <div class="container homePageDivWhite" id="attendeeSignup">
    <form action="" method="post">
      <div class="row">
        <div class="col-lg-4">
          <div class="row">
            <div class="col">
                <h1>Sign Up</h1>
            </div>
            <!-- SIGN UP DROP DOWN -->
            <div class="col" id="signupParent">
              <select class="form-control" id="attendeeTypeDropdown" name="attendee">
                <option value="professional" selected>Professional</option>
                <option value="student">Student</option>
                <option value="sponsor">Sponsor</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="attendeeSignupBuckets" id="generalInfo">
            <div class="row">
              <h3>General Info</h3>
            </div>
            <div class="row">
              <div class="col">
                <input class="form-control" type="text" name="firstname" placeholder="First Name">
              </div>
              <div class="col">
                <input class="form-control" type="text" name="lastname" placeholder="Last Name">
              </div>
              <div class="col">
                <input class="form-control" type="text" name="email" placeholder="email">
              </div>
            </div>
          </div>
          <div class="attendeeSignupBuckets" id="studentBucket">
            <div class="row">
              <h3>Students</h3>
            </div>
            <div class="row">
              <div class="col">
                <input class="form-control" id="schoolNameInput" type="text" name="schoolName" placeholder="School Name">
              </div>
              <div class="col">
                <input class="form-control" id="studentNumInput" type="text" name="studentNum" placeholder="Student Number">
              </div>
              <div class="col">
                <input class="form-control" id="roomNumInput" type="text" name="roomNum" placeholder="Room Num (Optional)">
              </div>
            </div>
          </div>
          <div class="attendeeSignupBuckets" id="sponsorBucket">
            <div class="row">
              <h3>Sponsors</h3>
            </div>
            <div class="row">
              <div class="col">
                <input class="form-control" id="companyNameInput" type="text" name="companyName" placeholder="Company Name">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col centered">
              <input class="btn btn-square btn-primary" name="attendeeSubmit" type="submit" value="Sign Up">
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="container homePageDivWhite" id="companySignUp">
    <div class="row">
      <div class="col">
        <form action="" method="post">
          <div class="row">
            <div class="col">
              <input class="form-control" type="text" name="registeringCompanyName" placeholder="Company Name">
            </div>
            <div class="col">
              <input class="form-control" type="text" name="donation" placeholder="Donation Amount">
            </div>
            <div class="col">
              <input class="btn btn-square btn-primary" name="donateSubmit" type="submit" value="Donate">
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col">
              <p>If you wish to delete a company from the database enter the company name in the textbox below.</p>
          </div>
        </div>
        <form action="" method="post">
          <div class="row">
            <div class="col">
              <input class="form-control" type="text" name="cNameDelete" placeholder="Company Name">
            </div>
            <div class="col">
              <input class="btn btn-square btn-danger" type="submit" name="deleteSponsor" value="Delete">
            </div>
          </div>
        </form>
      </div>
      <div class="col">
        <h1>Sponsor</h1>
      </div>
    </div>
  </div>

  <div class="container centered" id="homePageToggleNav">
    <div class="row">
      <div class="col-lg-1"></div>
      <div class="col-lg-10">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#studentList" role="tab">Students</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#professionalList" role="tab">Professionals</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#sponsorList" role="tab">Sponsor Employees</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#companyList" role="tab">Company Sponsors</a>
          </li>
        </ul>
      </div>
      <div class="col-lg-1"></div>
    </div>
  </div>

  <div class="tab-content">
    <!-- STUDENT TAB -->
    <div class="tab-pane active" id="studentList" role="tabpanel">
      <div class="container" id="homePageDivWhite">
        <table class="table">
          <th>First Name</th>
          <th>Last Name</th>
          <th>email</th>
          <th>School Name</th>

          <?php
            $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");
            $sql = "SELECT fname, lname, email, schoolName FROM student";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            #stmt now holds the result of the query
            while($row = $stmt->fetch()) {
              echo "<tr><td>".$row["fname"]."</td><td>".$row["lname"]."</td><td>".$row["email"]."</td><td>".$row["schoolName"]."</td></tr>";
              #echo "<tr><td>".$row["fname"]."</td><td>".$row["lname"]."</td></tr>";
            }
          ?>
        </table>
      </div>

    </div>

    <!-- PROFESSIONAL TAB -->
    <div class="tab-pane" id="professionalList" role="tabpanel">
      <div class="container" id="homePageDivWhite">
        <table class="table">
          <th>First Name</th>
          <th>Last Name</th>
          <th>email</th>

          <?php
            $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");
            $sql = "SELECT fname, lname, email FROM professional";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            #stmt now holds the result of the query
            while($row = $stmt->fetch()) {
              echo "<tr><td>".$row["fname"]."</td><td>".$row["lname"]."</td><td>".$row["email"]."</td></tr>";
            }
          ?>
        </table>
      </div>
    </div>

    <!-- SPONSOR TAB -->
    <div class="tab-pane" id="sponsorList" role="tabpanel">
      <div class="container" id="homePageDivWhite">
        <table class="table">
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Company Name</th>

          <?php
            $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");
            $sql = "SELECT fname, lname, email, companyName FROM sponsor";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            #stmt now holds the result of the query
            while($row = $stmt->fetch()) {
              echo "<tr><td>".$row["fname"]."</td><td>".$row["lname"]."</td><td>".$row["email"]."</td><td>".$row["companyName"]."</td></tr>";
            }
          ?>
        </table>
      </div>
    </div>
    <!-- COMPANY TAB -->
    <div class="tab-pane" id="companyList" role="tabpanel">
      <div class="container" id="homePageDivWhite">
        <table class="table">
          <th>Company Name</th>
          <th>Sponsorship Level</th>
          <th>Number of Emails Sent</th>

          <?php
            $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");
            $sql = "SELECT name, sponsorship, emailsSent FROM company";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            #stmt now holds the result of the query
            while($row = $stmt->fetch()) {
              echo "<tr><td>".$row["name"]."</td><td>".$row["sponsorship"]."</td><td>".$row["emailsSent"]."</td></tr>";
            }
          ?>
        </table>
      </div>
    </div>
  </div>
<script src="conferenceJavascript.js"></script>
</body>
</html>

<?php
  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }

  if(isset($_POST["attendeeSubmit"])){ //if a new attendee is registered
    $fname = $_POST["firstname"];
    $lname = $_POST["lastname"];
    $email = $_POST["email"];
    $companyName = $_POST["companyName"];
    $studentNum = $_POST["studentNum"];
    $roomNum = $_POST["roomNum"];
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
    elseif($attendee == "student"){
      if($roomNum == ""){
        $sql = "INSERT INTO student(email, fname, lname, studentNum, schoolName) VALUES ('$email', '$fname', '$lname', '$studentNum', '$schoolName')";
      }
      else{
        $sql = "INSERT INTO student(email, fname, lname, studentNum, schoolName) VALUES ('$email', '$fname', '$lname', '$studentNum', '$schoolName');
                INSERT INTO room(number, numBeds) VALUES ($roomNum, 2);
                INSERT INTO hotellist(studentEmail, roomNumber) VALUES ('$email', $roomNum)";
      }

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

    $sql = "INSERT INTO company(name, sponsorship, emailsSent, donation) VALUES ('$companyName', '$sponsorLevel', 0, $donationAmount)";
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
  <!-- NAVBAR -->
  <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="confrenceHome.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="conferenceSched.php">Schedule</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="conferenceJobBoard.php">Job Board</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="conferenceHousing.php">Housing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="conferenceCommittees.php">Committees</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- ATTENDEE SIGNUP -->
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

  <!-- COMPANY SIGNUP AND DELETE -->
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
        <div id="deleteSponsorBucket">
          <div class="row">
            <div class="col">
                <p>If you wish to delete a company and all associated employees from the database enter the company name in the textbox below.</p>
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
      </div>
      <div class="col">
        <h1>Sponsor</h1>
      </div>
    </div>
  </div>

  <!-- FUNDS -->
  <div class="container homePageDivWhite" id="funds">
    <div class="row">
      <div class="col-3">
        <h1>Funds Raised</h1>
      </div>
      <div class="col-9">
        <div class="row">
          <div class="col">
            <h4>Ticket Sales:</h4>
          </div>
          <div class="col">
            <?php
              $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");
              $sql = "SELECT COUNT(email) as studentFunds FROM student";
              $stmt = $pdo->prepare($sql);
              $stmt->execute();
              $result = $stmt->fetch();

              $studentFunds = $result[0];

              $sql = "SELECT COUNT(email) as studentFunds FROM professional";
              $stmt = $pdo->prepare($sql);
              $stmt->execute();
              $result = $stmt->fetch();

              $professionalFunds = $result[0];


              console_log($studentFunds);
              console_log($professionalFunds);

              $totalFunds = ($studentFunds * 50) + ($professionalFunds * 100);

              console_log($totalFunds);

              echo "<h4 id='totalTicketFunds'>"."$totalFunds"."</h4>";
             ?>

          </div>
        </div>
        <div class="row">
          <div class="col">
            <h4>Sponsorship:</h4>
          </div>
          <div class="col">

            <?php
              $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");
              $sql = "SELECT SUM(donation) as donationTotal FROM company";
              $stmt = $pdo->prepare($sql);
              $stmt->execute();
              $result = $stmt->fetch();
              $donationTotal = $result[0];
              echo "<h4 id='sponsorFunds'>"."$donationTotal"."</h4>";
             ?>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <h4>Total:</h4>
          </div>
          <div class="col">
            <h4 id="totalFunds"></h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- LISTS -->
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

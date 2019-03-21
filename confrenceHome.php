<!DOCTYPE html>
<html>
<head>
<link href="conStyle.css" type="text/css" rel="stylesheet" >
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container" id="homePageDivWhite">
    <div class="row">
      <div class="col">
        <h1>Sign Up.</h1>
      </div>
      <div class="col">
        <form action="conHome.html" method="post">
          <div class="row">
            <div class="col">
              <input class="form-control" type="text" name="firstname" placeholder="First Name">
            </div>
            <div class="col">
              <input class="form-control" type="text" name="lastname" placeholder="Last Name">
            </div>
          </div>
          <div class="row">
            <div class="col">
              <h6>Attendee Type:</h6>
            </div>
            <div class="col">
              <select class="form-control" name="attendee">
                <option value="professional">Professional</option>
                <option value="sponsor">Sponsor</option>
                <option value="student">Student</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col">
                <input class="form-control" type="text" name="roomNum" placeholder="Room Num (Stuents Only)">
            </div>
            <div class="col">
              <input class="btn btn-square btn-primary" type="submit" value="Sign Up">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="container" id="homePageDivGrey">
    <div class="row">
      <div class="col">
        <form action="conHome.html" method="post">
          <div class="row">
            <div class="col">
              <input class="form-control" type="text" name="companyName" placeholder="Company Name">
            </div>
            <div class="col">
              <input class="form-control" type="text" name="donation" placeholder="Donation Amount">
            </div>
            <div class="col">
              <input class="btn btn-square btn-primary" type="submit" value="Donate">
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col">
              <p>If you wish to delete a company from the database enter the company name in the textbox below.</p>
          </div>
        </div>
        <form action="conHome.html" method="post">
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
        <h1>Sponsor.</h1>
      </div>
    </div>
  </div>

  <div class="container centered" id="homePageToggleNav">
    <div class="row">
      <div class="col-lg-3"></div>
      <div class="col-lg-6">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#studentList" role="tab">Students</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#professionalList" role="tab">Professionals</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#sponsorList" role="tab">Sponsors</a>
          </li>
        </ul>
      </div>
      <div class="col-lg-3"></div>
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

</body>
</html>

<!DOCTYPE html>
<html>
<head>
<link href="conStyle.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
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
      </ul>
    </div>
  </nav>

  <div class="container">
    <br><br>
    <h4>Current Job Postings</h4>
    <br><br>
  </div>

  <div class="container">
    <h6>Sort By: </h6>
    <select class="form-control" id="attendeeTypeDropdown" name="attendee">
      <option value="companyName" selected>Company Name</option>
      <option value="salary">Highest Salary</option>
      <option value="jobTitle">Job Title</option>
    </select>
  </div>
  <div class="container" id="homePageDivWhite">
    <table class="table">
      <th>Company Name</th>
      <th>Job Title</th>
      <th>Salary</th>
      <th>City</th>
      <th>Province</th>

      <?php
        $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");
        $sql = "SELECT companyName, jobTitle, salary, city, prov FROM advert ORDER BY companyName ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        #stmt now holds the result of the query
        while($row = $stmt->fetch()) {
          echo "<tr><td>".$row["companyName"]."</td><td>".$row["jobTitle"]."</td><td>".$row["salary"]."</td><td>".$row["city"]."</td><td>".$row["prov"]."</td></tr>";
        }
      ?>
    </table>
  </div>
</body>

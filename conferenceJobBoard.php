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

  <div class="container">
    <br><br>
    <h1>Current Job Postings</h1>
  </div>

  <div class="container homePageDivWhite">
    <form class="" action="" method="post">
      <div class="row">
        <div class="col-lg-3">
          <select class="form-control" id="attendeeTypeDropdown" name="sortByDDJB">
            <option value="title">Sort By</option>
            <option value="companyName">Company Name</option>
            <option value="salary">Highest Salary</option>
            <option value="jobTitle">Job Title</option>
          </select>
        </div>
        <div class="col-lg-1">
          <input class="btn btn-square btn-primary" type="submit" name="sortByJB" value="Go">
        </div>
      </div>
    </form>
  </div>
  <div class="container" id="homePageDivWhite">
    <table class="table">
      <th>Company Name</th>
      <th>Job Title</th>
      <th>Salary</th>
      <th>City</th>
      <th>Province</th>

      <?php
        if (isset($_POST["sortByJB"])) {
          $sortBy = $_POST["sortByDDJB"];
          if('$sortBy' == 'title'){ //not working
            //Do Nothing
          }
          else{
            $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");

            if($sortBy == 'salary'){
              $sql = "SELECT companyName, jobTitle, salary, city, prov FROM advert ORDER BY $sortBy DESC";
            }
            else{
              $sql = "SELECT companyName, jobTitle, salary, city, prov FROM advert ORDER BY $sortBy ASC";
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            #stmt now holds the result of the query
            while($row = $stmt->fetch()) {
              echo "<tr><td>".$row["companyName"]."</td><td>".$row["jobTitle"]."</td><td>".$row["salary"]."</td><td>".$row["city"]."</td><td>".$row["prov"]."</td></tr>";
            }
          }
        }
      ?>
    </table>
  </div>
</body>

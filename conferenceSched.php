<?php
  function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }

  if(isset($_POST["changeSchedule"])){
    $currentRoom = $_POST["currentRoom"];
    $currentTime = $_POST["currentTime"];
    $newRoom = $_POST["newRoom"];
    $newTime = $_POST["newTime"];

    $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");

    $sql = "UPDATE speakerSession SET block = '$newTime', roomNumber = $newRoom WHERE block = '$currentTime' AND roomNumber = $currentRoom;
            UPDATE speaksat SET sessionBlock = '$newTime', sessionRoom = $newRoom WHERE sessionBlock = '$currentTime' AND sessionRoom = $currentRoom";

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

<div class="container">
  <br><br>
  <h1>Schedule</h1>
</div>

<div class="container homePageDivWhite">
  <form class="" action="" method="post">
    <div class="row">
      <div class="col-lg-2">
        <input class="form-control" type="text" name="currentRoom" placeholder="Current Room">
      </div>
      <div class="col-lg-3">
        <select class="form-control" name="currentTimeDropDown">
          <option value="currentTime">Current Slot</option>
          <option value="0">Saturday 9:00 - 10:00 am</option>
          <option value="2">Saturday 10:00 - 11:00 am</option>
          <option value="3">Saturday 11:00 - 12:00 am</option>
          <option value="4">Saturday 12:00 - 1:00 pm</option>
          <option value="5">Saturday 1:00 - 2:00 pm</option>
          <option value="6">Saturday 2:00 - 3:00 pm</option>
          <option value="7">Saturday 3:00 - 4:00 pm</option>
          <option value="8">Sunday 9:00 - 10:00 am</option>
          <option value="9">Sunday 10:00 - 11:00 am</option>
          <option value="A">Sunday 12:00 - 1:00 pm</option>
          <option value="B">Sunday 1:00 - 2:00 pm</option>
          <option value="C">Sunday 2:00 - 3:00 pm</option>
          <option value="D">Sunday 3:00 - 4:00 pm</option>
          <option value="E">Sunday 4:00 - 5:00 pm</option>
          <option value="F">Sunday 5:00 - 6:00 pm</option>
        </select>
      </div>
      <div class="col-lg-2">
        <input class="form-control" type="text" name="newRoom" placeholder="New Room">
      </div>
      <div class="col-lg-3">
        <select class="form-control" name="newTimeDropDown">
          <option value="currentTime">Current Slot</option>
          <option value="0">Saturday 9:00 - 10:00 am</option>
          <option value="1">Saturday 10:00 - 11:00 am</option>
          <option value="2">Saturday 11:00 - 12:00 am</option>
          <option value="3">Saturday 12:00 - 1:00 pm</option>
          <option value="4">Saturday 1:00 - 2:00 pm</option>
          <option value="5">Saturday 2:00 - 3:00 pm</option>
          <option value="6">Saturday 3:00 - 4:00 pm</option>
          <option value="6">Saturday 4:00 - 5:00 pm</option>
          <option value="8">Sunday 9:00 - 10:00 am</option>
          <option value="9">Sunday 10:00 - 11:00 am</option>
          <option value="A">Sunday 12:00 - 1:00 pm</option>
          <option value="B">Sunday 1:00 - 2:00 pm</option>
          <option value="C">Sunday 2:00 - 3:00 pm</option>
          <option value="D">Sunday 3:00 - 4:00 pm</option>
          <option value="E">Sunday 4:00 - 5:00 pm</option>
          <option value="F">Sunday 5:00 - 6:00 pm</option>
        </select>
      </div>
      <div class="col-lg-2">
        <input class="btn btn-square btn-primary" type="submit" name="changeSchedule" value="Change Schedule">
      </div>
    </div>
  </form>
</div>

<div class="container" id="homePageDivWhite">
  <table class="table">
    <th>Time Block</th>
    <th>Room Number</th>
    <th>Session Title</th>
    <th>Speaker's First Name</th>
    <th>Speaker's Last Name</th>

    <?php
      $pdo = new PDO('mysql:host=localhost;dbname=confrence', "root", "");
      $sql = "SELECT speakerSession.block, speakerSession.roomNumber, speakerSession.name, speaker.fname, speaker.lname
              FROM speaksat
              JOIN speaker ON speaksat.speakerEmail = speaker.email
              JOIN speakerSession ON speaksat.sessionBlock = speakerSession.block AND speaksat.sessionRoom = speakerSession.roomNumber ";

      $stmt = $pdo->prepare($sql);
      $stmt->execute();

      #stmt now holds the result of the query
      while($row = $stmt->fetch()) {
        if("block" == 0){
          $block = "Saturday 9:00 - 10:00 am";
        }elseif ("block" == 1) {
          $block = "Saturday 10:00 - 11:00 am";
        }elseif ("block" == 2) {
          $block = "Saturday 11:00 - 12:00 pm";
        }elseif ("block" == 3) {
          $block = "Saturday 12:00 - 1:00 pm";
        }elseif ("block" == 4) {
          $block = "Saturday 1:00 - 2:00 pm";
        }elseif ("block" == 5) {
          $block = "Saturday 2:00 - 3:00 pm";
        }elseif ("block" == 6) {
          $block = "Saturday 3:00 - 4:00 pm";
        }elseif ("block" == 7) {
          $block = "Saturday 4:00 - 5:00 pm";
        }elseif ("block" == 8) {
          $block = "Sunday 9:00 - 10:00 am";
        }elseif ("block" == 9) {
          $block = "Sunday 10:00 - 11:00 am";
        }elseif ("block" == A) {
          $block = "Sunday 11:00 - 12:00 pm";
        }elseif ("block" == B) {
          $block = "Sunday 12:00 - 1:00 pm";
        }elseif ("block" == C) {
          $block = "Sunday 1:00 - 2:00 pm";
        }elseif ("block" == D) {
          $block = "Sunday 2:00 - 3:00 pm";
        }elseif ("block" == E) {
          $block = "Sunday 3:00 - 4:00 pm";
        }elseif ("block" == F) {
          $block = "Sunday 4:00 - 5:00 pm";
        }
        echo "<tr><td>"."$block"."</td><td>".$row["roomNumber"]."</td><td>".$row["name"]."</td><td>".$row["fname"]."</td><td>".$row["lname"]."</td></tr>";
      }
    ?>
  </table>
</div>

</body>

<?php
$pagename = "Home";
?>

<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
  <link href="resources/stylesheet.css" rel="stylesheet">
  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="resources/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="resources/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="resources/favicon/favicon-16x16.png">
  <link rel="manifest" href="resources/favicon/site.webmanifest">
  <title>
    <?php echo $pagename; ?> - Group B4
  </title>
</head>
<body>
  <div class="content-wrapper">
    <div class="header">
      <p><?php echo $pagename; ?></p>

      <div class="subheader">
        <p>
          Creighton University Department of Public Safety
          <br />
          Parking Management System
        </p>
      </div>
    </div>

    <div class="nav">
      <div id="nav-left">
        <a href="index">
          Home
        </a>
      </div>

      <div>
        <a href="studentpark">
          Student Vehicle Location
        </a>
      </div>

      <div>
        <a href="officerlot">
          Lot Officer Assignment
        </a>
      </div>
      <div>

        <a href="updateavailable">
          Update Spots Available
        </a>
      </div>

      <div>
        <a href="lotmap.php">
          Lot Map
        </a>
      </div>

      <div id="nav-right">
        <a href="vehicletreemap">
          Vehicle Treemap
        </a>
      </div>
    </div>

    <div class="body">
      <div id="hometext">
        <p>
          BIA 354 - Group B4
        </p>

        <p>
          Parking Management System<br /><span class="subtext">for Creighton University Department of Public Safety</span>
        </p>

        <p>
          Ameer Chughtai, Colton Laface, Katie Ruane, Ted Silbernagel
        </p>

        <br /><br />

        <p id="hometextbottom">
          Links to all pages:
        </p>
      </div>

      <div class="homelinks">
        <div>
          <a href="studentpark">
            View where a student is parked
          </a>
        </div>

        <div>
          <a href="officerlot">
            View all officers assigned to a lot
          </a>
        </div>

        <div>
          <a href="updateavailable">
            Update spots available for a lot
          </a>
        </div>

        <div>
          <a href="lotmap">
            View map of lot locations
          </a>
        </div>

        <div>
          <a href="vehicletreemap">
            View treemap chart of all vehicles
          </a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

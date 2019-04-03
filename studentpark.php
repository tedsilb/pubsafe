<?php
# Declare variables, get set up
$pagename = "View Student Vehicle Location";
$resultMessage = "";
$table = "";

# Begin if statement to check if form has been submitted
if (isset($_POST["submit"])) {

  # Set up database connection
  require_once("resources/db.php");

  # Set up POSTed variables
  $firstName = mysqli_real_escape_string($con, $_POST["firstName"]);
  $lastName = mysqli_real_escape_string($con, $_POST["lastName"]);

  # Set result message
  $resultMessage = "Results for \"".$firstName." ".$lastName."\":";

  # Set up query
  $query = "SELECT s.first_name,
                    s.last_name,
                    v.vehicle_make,
                    v.vehicle_model,
                    l.lot_no,
                    l.street,
                    l.city,
                    l.state
            FROM lot l
            JOIN vehicle v
              ON l.lot_no = v.lot_no
            JOIN student s
              ON s.net_id = v.net_id
            WHERE s.first_name LIKE '%$firstName%'
              AND s.last_name LIKE '%$lastName%';
            ";

  # Run query, get results
  $results = mysqli_query($con, $query)
              or die("<b>Query failed</b>: "
                      . mysqli_error($con)
                      . "<br><i>{$query}</i>");

  # Set up table headers
  $table .= "<table>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Vehicle Make</th>
                <th>Vehicle Model</th>
                <th>Lot Number</th>
                <th>Street</th>
                <th>City</th>
                <th>State</th>
              </tr>
            ";

  # Put query results into table
  while ($row = mysqli_fetch_array($results)) {
  $table .= "<tr>
              <td>{$row["first_name"]}</td>
              <td>{$row["last_name"]}</td>
              <td>{$row["vehicle_make"]}</td>
              <td>{$row["vehicle_model"]}</td>
              <td>{$row["lot_no"]}</td>
              <td>{$row["street"]}</td>
              <td>{$row["city"]}</td>
              <td>{$row["state"]}</td>
            </tr>";
  }

  # Close table
  $table .= "</table>";

  # Free results
  mysqli_free_result($results);

  # Close database connection
  mysqli_close($con);

# Close IF statement checking to see if form has been submitted
}
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
    <p>
      <?php echo $pagename; ?>
    </p>
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
      <a href="index.php">
      Home
      </a>
    </div>
    <div>
      <a href="studentpark.php">
      Student Vehicle Location
      </a>
    </div>
    <div>
      <a href="officerlot.php">
      Lot Officer Assignment
      </a>
    </div>
    <div>
      <a href="updateavailable.php">
      Update Spots Available
      </a>
    </div>
    <div>
      <a href="lotmap.php">
      Lot Map
      </a>
    </div>
    <div id="nav-right">
      <a href="vehicletreemap.php">
      Vehicle Treemap
      </a>
    </div>
    </div>
    <div class="body">
    <p>Enter the first and last name of a student to search for their vehicle's location:</p>
    <div id="studentparkformdiv">
      <form method="post" id="studentparkform">
      <p>First Name:</p>
      <input type="text" name="firstName" placeholder="Ex: Ameer" required>
      <p>Last Name:</p>
      <input type="text" name="lastName" placeholder="Ex: Chughtai" required>
          <input class="button" type="submit" name="submit">
      </form>
    </div>
    <p>
      <?php echo $resultMessage; ?>
    </p>
    <div class="table">
      <?php echo $table; ?>
    </div>
    </div>
  </div>
</body>
</html>

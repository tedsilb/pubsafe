<?php
# Declare variables, get set up
$pagename = "Update Spots Available";
$table = "";
$lotnolist = "<option>Select a lot:</option>";
$updatemessage = "";

# Set up database connection
require_once("./resources/db.php");

# Set up query
$query = "SELECT lot_no FROM lot ORDER BY 1 ASC;";

# Run query, get results
$results = mysqli_query($con, $query)
            or die("<b>Query failed</b>: "
                    . mysqli_error($con)
                    . "<br><i>{$query}</i>");

# Put results into a list
while ($row = mysqli_fetch_array($results)) {
  $lotnolist .= "<option>{$row['lot_no']}</option>";
}

# Free results
mysqli_free_result($results);

# Begin if statement to check if form has been submitted
if(isset($_POST['submit'])){

  # Set up database connection
  require_once("resources/db.php");

  # Set variables to POSTed values
  $spotsavailable = $_POST["spotsAvailable"];
  $lotid = $_POST["lotno"];

  # Set up query
  $query2 = "UPDATE lot SET spots_available = {$spotsavailable} WHERE lot_no = {$lotid};";

  # Run query, get results
  mysqli_query($con, $query2);

  # Set message to be displayed to user
  $updatemessage = "Successfully updated spots available to {$spotsavailable} for lot {$lotid}.";

  # Set error message if it exists
  $errormessage = mysqli_error($con);
  if(!empty($errormessage)){
  $updatemessage = $errormessage;
  }
}

# Close database connection
mysqli_close($con);

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
  <script src="resources/jquery-3.3.1.min.js"></script>
  <script>
    // Checks whether the div with ID lotsDiv has changed
    $(document).on("change", "#lotsDiv", function(e) {
      // Grabs value of the drop-down with ID lots
      let lots = $("#lots").val();
      // Calls PHP page using AJAX request and the selected value as part of the POST request
      $.ajax({
        type: "POST",  // Using an AJAX call type of POST
        url: "resources/updateavailableAJAX.php",  // URL of the AJAX file to request
        data: { lots: lots },  // Passes variable to the next page
        // Upon successful AJAX request, return what PHP echoes, store it in variable called output
        success: function(output) {
          // Puts output in div called lotResults
          $("#lotResults").html(output);
        }
      });
    });
  </script>
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
    <div class="body" id="updatespotsbody">
    <p>Select a lot to update spots available in:</p>
    <form method="post" id="updatespotsform">
      <div id="lotsDiv">
      <p>
        Lot:
      </p>
      <select id="lots" name="lotno">
        <?php echo $lotnolist; ?>
      </select>
      </div>
      <div id="lotResults"></div>
    </form>
    <p id="updatemessagep">
      <?php echo $updatemessage; ?>
    </p>
    </div>
  </div>
</body>
</html>

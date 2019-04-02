<?php
# Begin if statement to check if form has been submitted
if (isset($_POST["lots"])) {

  # Connect to database
  require_once("../resources/db.php");

  # Set up POSTed variable
  $lotNo = mysqli_real_escape_string($con, $_POST["lots"]);

  # Set up query
  $query = "SELECT spots_available
            FROM lot
            WHERE lot_no = {$lotNo}
          ";

  # Run query, get results
  $results = mysqli_query($con, $query)
  or die("<b>Query failed</b>: "
          . mysqli_error($con)
          . "<br><i>{$query}</i>");

  # Gets first row of results
  $row = mysqli_fetch_array($results);

  # Sets variable
  $spotsAvailable = $row["spots_available"];

  # Echos content to return to updateavailable.php
  echo "<p>Spots available:</p>
        <input type='text' name='spotsAvailable' value='{$spotsAvailable}' required>
        <input class='button' type='submit' name='submit'>
        ";
}
?>

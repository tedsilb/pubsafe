<?php
# Prepare variable
$content = "";

# Begin if statement to check if form has been submitted
if (isset($_POST["lots"])) {

  # Connect to database
  require_once("../resources/db.php");

  # Set up POSTed variable
  $lotNo = mysqli_real_escape_string($con, $_POST["lots"]);

  # Set up query
  $query = "SELECT o.officer_id,
                    o.first_name,
                    o.last_name,
                    l.lot_no,
                    m.date_time
            FROM officer o
            JOIN monitor m
              ON o.officer_id = m.officer_id
            JOIN lot l
              ON l.lot_no = m.lot_no
            WHERE l.lot_no = {$lotNo}
            ";

  # Prepare content to be displayed
  $content .= "<p>Officer(s) assigned to lot {$lotNo}:</p>";

  # Run query, get results
  $results = mysqli_query($con, $query)
              or die("<b>Query failed</b>: "
                      . mysqli_error($con)
                      . "<br><i>{$query}</i>");

  # Set up table headers
  $content .= "<table>
                  <tr>
                    <th>Lot Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Officer ID</th>
                    <th>Current Date/Time</th>
                  </tr>
                ";

  # Start while loop to fetch results
  while ($row = mysqli_fetch_array($results)) {
  $content .= "<tr>
                  <td>{$row['lot_no']}</td>
                  <td>{$row['first_name']}</td>
                  <td>{$row['last_name']}</td>
                  <td>{$row['officer_id']}</td>
                  <td>{$row['date_time']}</td>
                </tr>
              ";
  }

  # Close table
  $content .= "</table>";

  # Echos content to return to updateavailable.php
  echo $content;
}
?>

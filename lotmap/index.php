<?php
# Set up variables
$pagename = "Lot Map (DEMO)";
$address = "";
$data = "";
$latitude = "";
$longitude = "";
$message = "";
$gMapsApiKey = "AIzaSyAk7UAuQEQTnaN-v0wIlwFZPkIdb8h1zRs";

# Connect to database
require_once("../resources/db.php");
require_once("../resources/gGeocodeApiKey.php");

# Set up query
$query = "SELECT lot_no,
                  street,
                  city,
                  state,
                  zip
          FROM lot
          ";

# Run query, get results
$results = mysqli_query($con, $query)
            or die("<b>Query failed</b>: "
                    . mysqli_error($con)
                    . "<br><i>{$query}</i>");

# Set data headers for chart
$data = "['Lat', 'Long', 'Name']";

# Start PHP map logic with SQL results
while ($row = mysqli_fetch_array($results)) {

  # Set up address from variables
  $address = str_replace(" ", "+", "{$row["street"]}, {$row["city"]}, {$row["state"]}, {$row["zip"]}");

  # Get map from Google Maps using data provided
  $geocode = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=" . $address . "&key=" . $gMapsGeocodeApiKey);
  $output = json_decode($geocode, true);
    if ($output["status"] == "OK") {
        $latitude = $output["results"][0]["geometry"]["location"]["lat"];
        $longitude = $output["results"][0]["geometry"]["location"]["lng"];
    $data .=  ", [{$latitude}, {$longitude}, '"
              . "<b>Lot " . addslashes($row["lot_no"])
              . "</b><br />"
              . addslashes($row["street"]) . "<br />" . addslashes($row["city"]) . ", " . addslashes($row["state"]) . " " . addslashes($row["zip"])."']";
  } else {
   $message .= $output["results"] . " - " . $address . "<br /><br />";
  }
}

# Set up JS to pull in actual map
$script = "<script type='text/javascript'>
              google.charts.load('current', {'packages': ['map'], 'mapsApiKey': '{$gMapsApiKey}' });
              google.charts.setOnLoadCallback(drawMap);
              function drawMap() {
                var data = google.visualization.arrayToDataTable([{$data}]);
                var options = {
                  showTooltip: false,
                  showInfoWindow: true,
                  useMapTypeControl: false,
                  mapType: 'normal',
                  zoomLevel: 3,
                  enableScrollWheel: true
                };
                var map = new google.visualization.Map(document.getElementById('mapdiv'));
                map.draw(data, options);
              };
            </script>
            ";
?>

<!DOCTYPE html>
<html>
<head>
  <!-- Font, CSS -->
  <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
  <link href="../resources/stylesheet.css" rel="stylesheet">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="../resources/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../resources/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../resources/favicon/favicon-16x16.png">
  <link rel="manifest" href="../resources/favicon/site.webmanifest">

  <!-- Title -->
  <title><?php echo $pagename; ?> - Group B4</title>

  <!-- Scripts -->
  <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
  <?php echo $script;	?>
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
        <a href="../">
          Home
        </a>
      </div>

      <div>
        <a href="../studentpark">
          Student Vehicle Location
        </a>
      </div>

      <div>
        <a href="../officerlot">
          Lot Officer Assignment
        </a>
      </div>

      <div>
        <a href="../updateavailable">
          Update Spots Available
        </a>
      </div>

      <div>
        <a href="../lotmap">
          Lot Map
        </a>
      </div>

      <div id="nav-right">
        <a href="../vehicletreemap">
          Vehicle Treemap
        </a>
      </div>
    </div>

    <div class="mapbody">
      <?php echo $message; ?>
      <div id="mapdiv"></div>
    </div>
  </div>
</body>
</html>

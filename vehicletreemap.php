<?php
# Set up variables
$pagename = "Vehicle Treemap";
$address = "";
$data = "";
$latitude = "";
$longitude = "";
$message = "";

# Set data headers for chart
$data = "['Model', 'Make', 'Size', 'Color']";
$data .= ", ['All Makes', null, 0, 0]";

# Connect to database
require_once("resources/db.php");

# Set up query to get all makes
$query = "SELECT DISTINCT vehicle_make, COUNT(*) AS makes FROM vehicle GROUP BY 1";

# Run query, get results
$results = mysqli_query($con, $query)
						or die("<b>Query failed</b>: "
										. mysqli_error($con)
										. "<br><i>{$query}</i>");

# Start PHP chart logic with SQL results
while ($row = mysqli_fetch_array($results)) {

  # Put all makes into data table
  $data .=  ", ['{$row["vehicle_make"]}', 'All Makes', {$row["makes"]}, {$row["makes"]}]";
}

# Free query results
mysqli_free_result($results);

# Set up query to get all vehicles
$query = "SELECT vehicle_make, vehicle_model, COUNT(*) AS models FROM vehicle GROUP BY 1, 2";

# Run query, get results
$results = mysqli_query($con, $query)
						or die("<b>Query failed</b>: "
										. mysqli_error($con)
										. "<br><i>{$query}</i>");

# Start PHP chart logic with SQL results
while ($row = mysqli_fetch_array($results)) {

  # Put all makes and models into data table
  $data .=  ", ['{$row["vehicle_model"]}', '{$row["vehicle_make"]}', {$row["models"]}, {$row["models"]}]";
}

# Set up JS to pull in actual map
$script = "<script type='text/javascript'>
							google.charts.load('current', {'packages':['treemap']});
							google.charts.setOnLoadCallback(drawChart);
							function drawChart() {
								var data = google.visualization.arrayToDataTable([{$data}]);

								tree = new google.visualization.TreeMap(document.getElementById('chartdiv'));

								tree.draw(data, {
									maxDepth: 1,
									minColor: '#00a8ff',
									midColor: '#40739e',
									maxColor: '#273c75',
									headerHeight: 0,
									fontFamily: 'Fira Sans',
									fontColor: '#FFF',
									showScale: true
								});

							};
						</script>
						";
?>

<!DOCTYPE html>
<html>
<head>
	<link href="resources/stylesheet.css" rel="stylesheet">
	<title>
	  <?php echo $pagename; ?> - Group B4
	</title>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<?php echo $script; ?>
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
		<p id="chartp">Treemap chart of all vehicle makes and models:</p>
		<div id="chartdiv"></div>
	  </div>
	</div>
</body>
</html>
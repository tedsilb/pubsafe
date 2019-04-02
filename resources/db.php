<?php
define("MyDB_HOST", "xxx");
define("MyDB_USER", "username");
define('MyDB_PASSWORD', 'password');
define("MyDB_NAME", "database");

$con = mysqli_connect(MyDB_HOST, MyDB_USER, MyDB_PASSWORD, MyDB_NAME)
        or exit("Connection failed: " . mysqli_connect_error());
?>
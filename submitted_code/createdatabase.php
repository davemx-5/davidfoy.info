<?php
$con=mysqli_connect("csserver.ucd.ie","12255080","dsieejp4","foy");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$sql="CREATE TABLE user1(userid INT AUTO_INCREMENT PRIMARY KEY, name CHAR(50) NOT NULL, review1 LONGTEXT NOT NULL, review2 LONGTEXT NOT NULL, review3 LONGTEXT NOT NULL, review4 LONGTEXT NOT NULL, review5 LONGTEXT NOT NULL)";

// Execute query
if (mysqli_query($con,$sql))
  {
  echo "Table user created successfully";
  }
else
  {
  echo "Error creating table: " . mysqli_error($con);
  }

?>
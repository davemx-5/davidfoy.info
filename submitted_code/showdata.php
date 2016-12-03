<?php
 
$con=mysqli_connect("csserver.ucd.ie","12255080","dsieejp4", "foy");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
 
$sql = "select * FROM user1";
$query = mysqli_query($con, $sql) or die ('Error: '.mysql_error ());
 
echo "<table>";
 
//now read and display the entire row of a table one by one looping through it.
//to loop we are using While condition here
 
while($row =  @mysqli_fetch_array($query))
{ 
	echo "<p><tr><td>" . "<b>Review Number:</b>"  . "<br>" . $row['userid'] . "</td></tr>";
	echo "<tr><td>" . "<b>Name:</b>" . "<br>" . $row['name'] . "</td></tr>";
	echo "<tr><td>" . "<b>How did you find the 'aggregated' results</b>?" . "<br>" . $row['review1'] . "</td></tr>";
	echo "<tr><td>" . "<b>Did the 'aggregated' search engine achieve your expected results?</b>" . "<br>" . $row['review2'] . "</td></tr>";
	echo "<tr><td>" . "<b>Which view did you prefer, aggregated or non-aggregated and why?</b>" . "<br>" . $row['review3'] . "</td></tr>";
	echo "<tr><td>" . "<b>How did you find the user interface?</b>" . "<br>" . $row['review4'] . "</td></tr>";
	echo "<tr><td>" . "<b>Would you use this search engine again?</b>" . "<br>" . $row['review5'] . "</td></tr></p>";
}
 
echo "</table>";
 
?>
<!DOCTYPE HTML>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<link href="order.css" type="text/css" rel="stylesheet" />
</head>
<body>

<h1 align="center"> telegram order </h1>

<?php

$num_rec_per_page=10;
$connection = mysqli_connect('mysql.hostinger.kr', 'u440522676_hcoop', 'tkddn12', 'u440522676_hcoop');

mysqli_query($connection,"set session character_set_connection=utf8;");
mysqli_query($connection,"set session character_set_results=utf8;");
mysqli_query($connection,"set session character_set_client=utf8;");

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * $num_rec_per_page;
$sql = "SELECT * FROM tele_order order by order_id desc LIMIT $start_from, $num_rec_per_page";
$result = mysqli_query($connection,$sql);
?>


<div id="container">
<div id="order_table" align="center">
<table class="tele_order"><thead>
<tr><th scope="cols"> &#51452;&#47928;&#48264;&#54840; </th>
<th scope="cols" width=15px> &#51060;&#47492; </th>
<th scope="cols"> &#54648;&#46300;&#54256;&#48264;&#54840; </th>
<th scope="cols"> &#49345;&#54408;&#47749; </th>
<th scope="cols"> &#49464;&#48512;&#54408;&#47749; </th>
<th scope="cols"> &#49688;&#47049; </th>
<th scope="cols"> &#49324;&#51060;&#51592; </th>
<th scope="cols"> &#51452;&#47928;&#49884;&#44036; </th></tr>

</thead>

<tbody>
<?php
while($row = mysqli_fetch_array($result,MYSQLI_BOTH)){   
	 echo "<tr><th>". $row['order_id'] . "</th><td>". $row['last_name'] . $row['first_name'] . "</td><td>0" .
                 $row['phone'] . "</td><td>" . $row['item'] . "</td><td>" . $row['color'] .
                 "</td><td>" . $row['count'] . "</td><td>" . $row['size'] . "</td><td>" . $row['date'] . "</td></tr>";

} ?>

</tbody>
</table>

<div id="pagination">
<?php
$sql = "SELECT COUNT(order_id) FROM tele_order";
$result = mysqli_query($connection,$sql);
$row = mysqli_fetch_row($result);
$total_records = $row[0];
$total_pages = ceil($total_records / $num_rec_per_page);

for ($i=1; $i<=$total_pages; $i++) {
	echo "<a href='http://hscoop.esy.es/wordpress/tele_order.php?page=".$i."'>".$i."</a> ";
};

mysqli_close($connection); //Make sure to close out the database connection
?>
</div></div>
</body>
</html>


	
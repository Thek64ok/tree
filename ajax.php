<?php
	$conn = pg_connect("host=localhost port=5432 dbname=tree user=postgres password=");
	$res = "";
	if(pg_query($conn, "INSERT INTO tree(sub_id) VALUES(0)"))
		$res .= "
			<ul>
				<li>root</li>
			</ul>
		";
	echo $res;
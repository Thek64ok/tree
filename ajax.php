<?php
	$conn = pg_connect("host=localhost port=5432 dbname=tree user=postgres password=322");
	$res = "";
	if(pg_query($conn, "INSERT INTO tree(main_id, sub_id) VALUES(1, 0)"))
		$res .= "
			<ul>
				<li>root</li>
			</ul>
		";
	echo $res;
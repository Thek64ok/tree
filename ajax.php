<?php
	$conn = pg_connect("host=localhost port=5432 dbname=tree user=postgres password=");
	$res = "";
	if($id = pg_query($conn, "INSERT INTO tree(sub_id) VALUES(0) RETURNING id")) {
	    $id = pg_fetch_assoc($id);
        $res .= "
			<ul>
				<li>
                    root ".$id['id']."
                    <button class=\"btn btn-success btn-sm\" type=\"button\" onclick=\"create(".$id['id'].", 'create', 0)\">+</button>
                    <button class=\"btn btn-danger btn-sm\" type=\"button\" onclick=\"create(".$id['id'].", 'delete', 0)\">-</button>
                </li>
			</ul>
		";
    }
	echo $res;
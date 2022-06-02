<?php
	$conn = pg_connect("host=localhost port=5432 dbname=tree user=postgres password=322");
	$tree = pg_fetch_all(pg_query($conn, "SELECT main_id, sub_id FROM tree ORDER BY id"));
	if(!empty($tree))
		echo "go";
	else
		echo "error";
?>
<html>
	<head>
		<title>Tree Creator</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<style>
			body{
				background-color: bisque;
			}
		</style>
	</head>
	<body>
		<div id="tree">
		</div>
		<button id="create">create root</button>
		<script>
			$("#create").click(function(){
				$.ajax({
					url: 'ajax.php',
					dataType: 'html',
					method: 'post',
					success: function(responce){
							if(responce.length > 0)
								$('#tree').html(responce);
							console.log(responce);	
						}
				})
			})
		</script>
	</body>
</html>
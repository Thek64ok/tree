<?php
	$conn = pg_connect("host=localhost port=5432 dbname=tree user=postgres password=");
	$tree = pg_fetch_all(pg_query($conn, "SELECT * FROM tree ORDER BY id"));

	$res = !empty($tree) ? tree($tree) : '';

    function tree($tree, $sub_id = 0){
        $res = '';
        foreach($tree as $row){
            if($row['sub_id'] == $sub_id){
                $res .=
                    '
                        <li>
                            root '.$row['id'].'
                            <button onclick="create('.$row['id'].')">+</button>
                            <button>-</button>
                            '.tree($tree, $row['id']).'
                        </li>
                    ';
            }
        }
        return $res ? '<ul>'.$res.'</ul>' : '';
    }

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
            <?php if(!empty($res)) echo $res;?>
		</div>
        <?php if(empty($res)):?>
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
                            }
                    })
                })
            </script>
        <?php else:?>
            <script>
                function create(sub_id){
                    $.ajax({
                        url: 'create.php',
                        method: 'post',
                        dataType: 'html',
                        data: {sub_id : sub_id},
                        success: function(response){
                            $('#tree').html(response);
                        }
                    })
                }
            </script>
        <?php endif; ?>
	</body>
</html>
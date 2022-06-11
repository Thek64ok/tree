<?php
	$conn = pg_connect("host=localhost port=5432 dbname=tree user=postgres password=");
	$tree = pg_fetch_all(pg_query($conn, "SELECT * FROM tree ORDER BY id"));

	$res = !empty($tree) ? tree($tree) : '';

    function tree($tree, $sub_id = 0){
        $res = '';
        foreach($tree as $row){
            if($row['sub_id'] == $sub_id){
                $res .=
                    "
                        <li>
                            root ".$row['id']."
                            <button class=\"btn btn-success btn-sm\" type=\"button\" onclick=\"create(".$row['id'].", 'create', ".$sub_id.")\">+</button>
                            <button class=\"btn btn-danger btn-sm\" type=\"button\" onclick=\"create(".$row['id'].", 'delete', ".$sub_id.")\">-</button>
                            ".tree($tree, $row['id'])."
                        </li>
                    ";
            }
        }
        return $res ? '<ul>'.$res.'</ul>' : '';
    }

?>
<html lang="en">
	<head>
		<title>Tree Creator</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
		<style>
			body{
				background-color: bisque;
			}
            .left_label{
                position: relative;
                left: -300px;
                font-size: 25px;
                color: brown;
            }
		</style>
	</head>
	<body>
		<div id="tree">
            <?php if(!empty($res)) echo $res;?>
		</div>
        <div id="modal">

        </div>
        <div id="create_tab">
        <?php if(empty($res)):?>
            <button id="create">create root</button>
            <script>
                $("#create").click(function(){
                    $.ajax({
                        url: 'ajax.php',
                        dataType: 'html',
                        method: 'post',
                        success: function(responce){
                                if(responce.length > 0) {
                                    $('#tree').html(responce);
                                    $('#create_tab').html('');
                                }
                            }
                    })
                })
            </script>
        <?php endif?>
        </div>
        <script>
            function create(sub_id, action, lvl){
                let file = action=='create'?'create.php':'delete.php';
                $('#second').text(20);
                if(lvl == 0 && action == 'delete') {
                    $.ajax({
                        url:'modal.php',
                        method:'get',
                        dataType:'html',
                        async:false,
                        success:function(response){
                            $('#modal').html(response);
                            let modal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {
                                keyboard: false
                            });
                            modal.show();
                        }
                    })
                    return;
                }
                $.ajax({
                    url: file,
                    method: 'post',
                    dataType: 'html',
                    data: {sub_id : sub_id},
                    success: function(response){
                        $('#tree').html(response);
                    }
                })
            }
        </script>
	</body>
</html>
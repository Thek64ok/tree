<?php
	$conn = pg_connect("host=localhost port=5432 dbname=tree user=postgres password=");
	$tree = pg_fetch_all(pg_query($conn, "SELECT * FROM tree ORDER BY sub_id"));
	if(!empty($tree))
		echo "go";
	else
		echo "error";

    function buildTree(array &$elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['sub_id'] == $parentId) {
                $children = buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['id']] = $element;
                unset($elements[$element['id']]);
            }
        }
        return $branch;
    }

    //var_dump(tree($tree));

    function tree($tree, $sub_id = 0){
        $res = '';
        foreach($tree as $row){
            if($row['sub_id'] == $sub_id){
                $res .=
                    '
                        <li>
                            root '.$row['id'].'
                            <button onclick="create()">+</button>
                            <button>-</button>
                            '.tree($tree, $row['id']).'
                        </li>
                    ';
            }
        }

        return $res ? '<ul>'.$res.'</ul>' : '';
    }

    $res = tree($tree);

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
                                console.log(responce);
                            }
                    })
                })
            </script>
        <?php endif; ?>
	</body>
</html>
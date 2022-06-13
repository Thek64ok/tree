<?php
    $res = '';
    if(!empty($_POST['name']) && !empty($_POST['id'])){
        $conn = pg_connect("host=localhost port=5432 dbname=tree user=postgres password=");
        if(pg_query_params($conn, "UPDATE tree SET name = $1 WHERE id = $2", array($_POST['name'], $_POST['id']))){
            $tree = pg_fetch_all(pg_query($conn, "SELECT * FROM tree ORDER BY id"));
            $res = !empty($tree) ? tree($tree) : 'Error with SELECT query';
        }
        else
           $res = 'Error with adding to DataBase';
    }
    else
        $res = "Name can't be an empty, make it fill";

    echo $res;


    function tree($tree, $sub_id = 0){
        $res = '';
        foreach($tree as $row){
            if($row['sub_id'] == $sub_id){
                $name = empty($row['name']) ? 'root':$row['name'];
                $res .=
                    "
                            <li>
                                <span class=\"normal_cursor\" onclick=\"change(".$row['id'].")\">$name ".$row['id']."</span>
                                <button class=\"btn btn-success btn-sm\" type=\"button\" onclick=\"create(".$row['id'].", 'create', ".$sub_id.")\">+</button>
                                <button class=\"btn btn-danger btn-sm\" type=\"button\" onclick=\"create(".$row['id'].", 'delete', ".$sub_id.")\">-</button>
                                ".tree($tree, $row['id'])."
                            </li>
                        ";
            }
        }
        return $res ? '<ul>'.$res.'</ul>' : '';
    }
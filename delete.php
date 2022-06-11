<?php
    $conn = pg_connect("host=localhost port=5432 dbname=tree user=postgres password=");
    $response = "";
    if(!empty($_POST['sub_id'])){
        $tree = pg_fetch_all(pg_query($conn, "SELECT * FROM tree ORDER BY id"));
        $response = !empty($tree) ? explode(' ', strval($_POST['sub_id']).' '.tree_delete($tree,$_POST['sub_id'])) : '';
        $empty = array_pop($response);
        rsort($response);
        foreach($response as $id)
            pg_query($conn, "DELETE FROM tree WHERE id = $id");

        $tree = pg_fetch_all(pg_query($conn, "SELECT * FROM tree ORDER BY id"));
        $response = !empty($tree) ? tree($tree) : '';
    }
    else
        $response = 'Some error';

    echo $response;

    function tree_delete($tree, $sub_id = 0){
        $res = '';
        foreach($tree as $row){
            if($row['sub_id'] == $sub_id){
                $res .= strval($row['id']).' '.tree_delete($tree, $row['id']);
            }
        }
        return $res ? $res : '';
    }

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
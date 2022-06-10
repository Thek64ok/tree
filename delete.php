<?php
    $conn = pg_connect("host=localhost port=5432 dbname=tree user=postgres password=");
    $response = "";
    if(!empty($_POST['sub_id'])){
        $tree = pg_fetch_all(pg_query($conn, "SELECT * FROM tree ORDER BY id"));
        $response = !empty($tree) ? explode(' ', strval($_POST['sub_id']).' '.tree($tree,$_POST['sub_id'])) : '';
        $empty = array_pop($response);
        rsort($response);
        $s = 0;
    }
    else
        $response = 'Some error';

    echo $response;

    function tree($tree, $sub_id = 0){
        $res = '';
        foreach($tree as $row){
            if($row['sub_id'] == $sub_id){
                $res .= strval($row['id']).' '.tree($tree, $row['id']);
            }
        }
        return $res ? $res : '';
    }
<?php
    $conn = pg_connect("host=localhost port=5432 dbname=tree user=postgres password=");
    pg_query($conn, "DELETE FROM tree");
    $res =
        "
            <div id=\"create_tab\">
            <button id=\"create\">create root</button>
            <script>
                $('#create').click(function(){
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
        </div>
        ";
    echo $res;
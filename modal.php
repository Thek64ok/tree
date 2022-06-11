<?php
    $res =
        "
            <div class=\"modal fade\" id=\"staticBackdrop\" data-bs-backdrop=\"static\" data-bs-keyboard=\"false\" tabindex=\"-1\" aria-labelledby=\"staticBackdropLabel\" aria-hidden=\"true\">
                <div class=\"modal-dialog\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"staticBackdropLabel\">Submitting</h5>
                        </div>
                        <div class=\"modal-body\">
                            Are you gonna delete this tree, are you sure?
                        </div>
                        <div class=\"modal-footer\">
                            <label id=\"second\" class=\"left_label\">5</label>
                            <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\" id='Close'>Close</button>
                            <button type=\"button\" class=\"btn btn-primary\" id=\"Accept\">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                seconds = parseInt($('#second').text());
                interval = setInterval(function(){
                    if(seconds > 0){
                        $('#second').text(seconds--);
                    }
                    else{
                        clearInterval(interval);
                        $('#staticBackdrop').modal('toggle');
                        $('#modal').html('');
                    }
                }, 1000);
                $('#Close').click(function(){
                    clearInterval(interval);
                    $('#modal').html('');
                });
                $(document).keypress(function(event){
                    if(event.keyCode == 120){
                        $('#staticBackdrop').modal('toggle');
                        $('#Close').trigger('click');
                    }
                });
                
                $('#Accept').click(function(){
                    $.ajax({
                        url:'delete_tree.php',
                        method: 'get',
                        dataType: 'html',
                        success:function(response){
                            console.log(response);
                            $('#tree').html('');
                            $('#create_tab').html(response);
                            $('#staticBackdrop').modal('toggle');
                            $('#Close').trigger('click');
                        }
                    })
                })
            </script>
        ";
    echo $res;
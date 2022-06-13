<?php
$res =
        "
            <style>
                .hidden{
                    display: none;
                }
                .invalid{
                    border-color:red;
                }
            </style>
            <div class=\"modal fade\" id=\"staticBackdropChange\" data-bs-backdrop=\"static\" data-bs-keyboard=\"false\" tabindex=\"-1\" aria-labelledby=\"staticBackdropChangeLabel\" aria-hidden=\"true\">
                <div class=\"modal-dialog\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"staticBackdropChangeLabel\">Change name for this element</h5>
                        </div>
                        <div class=\"modal-body\">
                            <form>
                                <div class=\"mb-3\">
                                    <label for=\"Name\" class=\"form-label\">Please, fill the name of element</label>
                                    <input type=\"text\" class=\"form-control\" id=\"Name\" name=\"name\" aria-describedby=\"emailHelp\">
                                    <div id=\"emailHelp\" class=\"form-text\">Assure you, it's simply</div>
                                    <label style='color:red;' id='validation' class='hidden'></label>
                                </div>
                            </form>
                        </div>
                        <div class=\"modal-footer\">
                            <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\" id='Close'>Close</button>
                            <button type=\"button\" class=\"btn btn-primary\" id=\"Accept\">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $('#Close').click(function(){
                    $('#modal_change').html('');
                })
                $('#Accept').click(function(){
                    $.ajax({
                        url:'fi4i/change_name.php',
                        method: 'post',
                        dataType: 'html',
                        data:{name:$('#Name').val(), id:".$_GET['id']."},
                        async: false,
                        success:function(response){
                            if(response.length <= 40){
                                $('#validation').text(response);
                                $('#validation').removeClass('hidden');
                                $('#Name').addClass('invalid');
                            }
                            else{
                                $('#tree').html(response);
                                $('#staticBackdropChange').modal('toggle');
                                $('#modal_change').html('');
                            }
                        }
                    })
                })
            </script>
        ";
echo $res;
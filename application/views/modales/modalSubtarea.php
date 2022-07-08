
<?php
if( true )  { ?>
  <div class="modal-header">
        <h5 class="modal-title"><?php echo ucwords($actividad[0]["nombre_actividad"])?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
  <p><?php echo ucfirst($actividad[0]["descripcion_actividad"])?></p>
  <h5>Subtareas</h5>
 
  <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="">
                                <div class="todo-list">
                                <form id="form1" method="POST">
                                    <div class="tdl-holder">
                                        <div class="tdl-content2 tdl-content--no-label">
                                        
                                            <input type="text" name="id" value="<?php echo $actividad[0]["id"]?>" hidden>
                                            <ul>
                                                <?php
                                                    $contador = 0;
                                                    foreach($subtarea as $key){
                                                ?>
                                                <li id="<?php echo $key['pk_subtarea']?>">
                                                    <label>
                                                        <input type="checkbox" <?php echo $key["estado_subtarea"] == "0" ? '' : 'checked'?> name="campo[<?php echo $contador?>]" 
                                                        value="<?php echo $key["pk_subtarea"].",".$key["estado_subtarea"]?>"><i></i>
                                                        <span><?php echo ucfirst($key["nombre_subtarea"])." - ".$key["detalle_subtarea"]?></span>
                                                        <a onclick="eliminar(<?php echo $key['pk_subtarea']?>)" class="ti-close"></a>
                                                    </label>
                                                </li>
                                                <?php
                                                    $contador++;
                                                    }
                                                ?>
                                            </ul>
                                        </div>
                                        
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="margin-top: 10px; margin-left: 40%; margin-bottom: 10px;">Guardar</button>
                                    </form>
                                    <input type="text" class="tdl-new2 form-control" id="new-subtarea" placeholder="Write new item and hit 'Enter'..." required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>

<div class="modal-footer">
    
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>

<div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>
<?php } ?>


<script>
window.localStorage.clear();
$(document).ready(function () {

    $('#list-items').html(localStorage.getItem('listItems'));

    $('.add-items').submit(function(event) 
    {
    event.preventDefault();

    var item = $('#todo-list-item').val();
    if(item) 
    {
    $('#list-items').append("<li><div class='round d-inline-block'><input type='checkbox' id='checkbox' /><label for='checkbox'></label></div><label for='checkbox'>" + item + "</label><a class='remove'><i class='fa fa-trash'></i></a></li>");
    localStorage.setItem('listItems', $('#list-items').html());

    $('#todo-list-item').val("");
    }

    });

    $(document).on('change', '.checkbox', function() 
    {
    if($(this).attr('checked')) 
    {
    $(this).removeAttr('checked');
    } 
    else 
    {
    $(this).attr('checked', 'checked');
    }

    $(this).parent().toggleClass('completed');

    localStorage.setItem('listItems', $('#list-items').html());
    });


    $(document).on('click', '.remove', function() 
    {
    $(this).parent().remove();

    localStorage.setItem('listItems', $('#list-items').html());
    });

});
$("#new-subtarea").keypress(function(event) {
    if (event.keyCode === 13) {
        $.ajax({
        type: "POST",
        url:  "<?= base_url().'ActividadExternaControlador/save_subtareas'; ?>",
        data: {nombre: $("#new-subtarea").val(),id:<?php echo $actividad[0]["id"]?>},
        success: function(data){
            console.log(data);
        },
            error: function(data){
            console.log('Error: '+data);
        },
    });
        
    }
});

$('#form1').submit(function(event){
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: "<?= base_url().'ActividadExternaControlador/guardar_estado_subtarea'; ?>",
        data: $(this).serialize(),
        success: function(data){
            console.log(data)
        },
        error: function(data){
            console.log('Error: '+data);
        }
    });
});

function eliminar(id)
{   
    $.ajax({
        type: "POST",
        url:  "<?= base_url().'ActividadExternaControlador/delete_subtareas'; ?>",
        data: {id: id},
        success: function(data){
            console.log(data);
            document.getElementById(id).remove();
        },
            error: function(data){
            console.log('Error: '+data);
        },
    });
}
</script>
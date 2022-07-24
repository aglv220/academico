<?php
if (true) { ?>
    <div class="modal-header">
        <h5 class="modal-title"><?php echo ucwords($actividad[0]["nombre_actividad"]) ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <p><?php echo ucfirst($actividad[0]["descripcion_actividad"]) ?></p>
        <h5>Subtareas</h5>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="">
                        <div class="todo-list">

                            <input type="text" class="tdl-new2 form-control" id="new-subtarea" placeholder="Escribe una nueva subtarea y apreta ENTER" required>
                            <form id="form1" method="POST">
                                <div class="tdl-holder">
                                    <div class="tdl-content2 tdl-content--no-label">

                                        <input type="text" name="id" value="<?php echo $actividad[0]["id"] ?>" hidden>
                                        <ul id="lst_subtareas">
                                            <?php
                                            $contador = 0;
                                            foreach ($subtarea as $key) {
                                            ?>
                                                <li id="<?php echo $key['pk_subtarea'] ?>">
                                                    <label>
                                                        <input type="checkbox" class="checkbox" <?php echo $key["estado_subtarea"] == "0" ? '' : 'checked' ?> name="campo[<?php echo $contador ?>]" value="<?php echo $key["pk_subtarea"] . "," . $key["estado_subtarea"] ?>"><i></i>
                                                        <span><?php echo ucfirst($key["nombre_subtarea"]) . " - " . $key["detalle_subtarea"] ?></span>
                                                        <a onclick="eliminar(<?php echo $key['pk_subtarea'] ?>)" class="ti-close"></a>
                                                    </label>
                                                </li>
                                            <?php
                                                $contador++;
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary btn-block btn-update-selected" disabled>Marcar seleccionadas como completadas</button>
                            </form>

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

    $(document).ajaxComplete(function() {
        $(document).off('change').on('change', '.checkbox', function() {
            if ($(this).attr('checked')) {
                $(this).removeAttr('checked');
                if (contador_st > 0) {
                    contador_st--;
                } else {
                    contador_st = 0;
                }
            } else {
                $(this).attr('checked', 'checked');
                contador_st++;
            }
            console.log(contador_st);
            if (contador_st > 0) {
                $(".btn-update-selected").prop("disabled", false);
            } else {
                $(".btn-update-selected").prop("disabled", true);
            }
            $(this).parent().toggleClass('completed');
            localStorage.setItem('listItems', $('#list-items').html());
        });
    });

    $(document).ready(function() {
        $('#list-items').html(localStorage.getItem('listItems'));
        $('.add-items').submit(function(event) {
            event.preventDefault();
            var item = $('#todo-list-item').val();
            if (item) {
                $('#list-items').append("<li><div class='round d-inline-block'><input type='checkbox' id='checkbox' /><label for='checkbox'></label></div><label for='checkbox'>" + item + "</label><a class='remove'><i class='fa fa-trash'></i></a></li>");
                localStorage.setItem('listItems', $('#list-items').html());
                $('#todo-list-item').val("");
            }
        });
        contador_st = 0;
        $(document).off('click').on('click', '.remove', function() {
            $(this).parent().remove();
            if (contador_st > 0) {
                contador_st -= 1;
            }
            console.log(contador_st);
            localStorage.setItem('listItems', $('#list-items').html());
        });
    });
    $("#new-subtarea").keypress(function(event) {
        if (event.keyCode === 13) {
            $("#new-subtarea").prop("readonly",true);
            $.ajax({
                type: "POST",
                url: "<?= base_url() . 'ActividadExternaControlador/save_subtareas'; ?>",
                data: {
                    nombre: $("#new-subtarea").val(),
                    id: <?php echo $actividad[0]["id"] ?>
                },
                success: function(data) {
                    contador_st = 0;
                    mydata = JSON.parse(data);
                    subtareas = mydata["subtareas"];
                    if (subtareas != "ERROR") {
                        $("#new-subtarea").prop("readonly",false);
                        $("#new-subtarea").val("");
                        $("#lst_subtareas").html("");
                        $("#lst_subtareas").html(subtareas);
                    }
                },
                error: function(data) {
                    console.log('Error: ' + data);
                },
            });
        }
    });

    /* function select_st(element) {
        if ($(element).attr('checked')) {
            $(element).removeAttr('checked');
            contador_st--;
        } else {
            $(element).attr('checked', 'checked');
            contador_st++;
        }
        console.log(contador_st);
        if (contador_st > 0) {
            $(".btn-update-selected").prop("disabled", false);
        } else {
            $(".btn-update-selected").prop("disabled", true);
        }
        $(element).parent().toggleClass('completed');
        localStorage.setItem('listItems', $('#list-items').html());
    } */

    $('#form1').submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "<?= base_url() . 'ActividadExternaControlador/guardar_estado_subtarea'; ?>",
            data: $(this).serialize(),
            success: function(data) {
                console.log(data)
            },
            error: function(data) {
                console.log('Error: ' + data);
            }
        });
    });

    function eliminar(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() . 'ActividadExternaControlador/delete_subtareas'; ?>",
            data: {
                id: id
            },
            success: function(data) {
                console.log(data);
                document.getElementById(id).remove();
            },
            error: function(data) {
                console.log('Error: ' + data);
            },
        });
    }
</script>
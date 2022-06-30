
<?php
if( true )  {
  $button="";
  foreach($estado as $key){
    $id = $key["id"];
    $nombre = $key["nombre_actividad"];
    $estado = $key["estado_pizarra"];
    if($estado == 0){
      $op = '<option value="0">Pendiente</option>';
      $op .= '<option value="1">En curso</option>';
      $op .= '<option value="2">Finalizado</option>';
      $button ='<button type="submit" class="btn btn-primary" style="margin-top: 5px;">Guardar</button>';
    }else if($estado == 1){
      $op = '<option value="1">En curso</option>';
      $op .= '<option value="0">Pendiente</option>';
      $op .= '<option value="2">Finalizado</option>';
      $button ='<button type="submit" class="btn btn-primary" style="margin-top: 5px;">Guardar</button>';
    }else{
      $op = '<option value="2">Finalizado</option>';
      $button ="";
    }
  }
  ?>
  <div class="modal-header">
        <h5 class="modal-title"><?php echo $nombre?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
  <h5>Estado de la actividad</h5>
  <form  id="form1"   method="POST">
    <input type="text" name="id" id="id" value="<?php echo $id?>" hidden>
    <select class="form-control" id="estado" name="estado">
      <?php echo $op?>
    </select>
    <?php echo $button?>
  </form>                        
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
    $(document).ready(function(){
	$('#form1').submit(function(event){

		event.preventDefault();
		$.ajax({
			type: 'POST',
			url: "<?= base_url().'ActividadExternaControlador/guardar_estado_pizarra'; ?>",
			data: $(this).serialize(),
			success: function(data){
        setTimeout(function() {
                        window.location.reload();
                   },0);
			},
			error: function(data){
        console.log('Error: '+data);
			}
		});
	});
});

</script>

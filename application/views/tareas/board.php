<style>
    .contenedor{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 65px;
    }
    .tarjeta{
        border-radius: 6px;
        min-width: 470px;
        max-width: 470px;
        box-shadow: initial;
        background-color: #F4F5F7;
        height: 750px;
        margin-left: 6px;
    }
    .title-card{
         margin-left: 10px;
         margin-top: 15px;
         font-weight: bold;
         font-size: 1rem;
         width: 95%;
         border-bottom: 1px solid black;
    }

    .actividad-inicio{
        width: 80%;
        height: 100px;
        margin-top: 30px;
        margin-left: 30px;
        background-color: #FF9F1A;
        box-shadow: var(--ds-shadow-raised,0 1px 1px rgba(23,43,77,0.2),0 0 1px rgba(23,43,77,0.2));
        border-radius: 8px;
    }
    .actividad-proceso{
        width: 80%;
        height: 100px;
        margin-top: 30px;
        margin-left: 30px;
        background-color: #00C2E0;
        box-shadow: var(--ds-shadow-raised,0 1px 1px rgba(23,43,77,0.2),0 0 1px rgba(23,43,77,0.2));
        border-radius: 8px;
    }
    .actividad-fin{
        width: 80%;
        height: 100px;
        margin-top: 30px;
        margin-left: 30px;
        background-color: #51E898;
        box-shadow: var(--ds-shadow-raised,0 1px 1px rgba(23,43,77,0.2),0 0 1px rgba(23,43,77,0.2));
        border-radius: 8px;
    }
    .title-actividad{
        width: 90%;
        margin-left: 5px;
        margin-top: 10px;
        border-bottom: 1px solid white;
        color: white;
    }
    .actividad-footer {
        margin-left: 280px;margin-top: 6px;
    }
    .actividad-footer button{
        align-items: center;
    }

    .descrp-actividad{
        width: 95%;
        margin-left: 5px;
        margin-top: 10px;
        color: white;
    }
    #preloader.none{
    display: none;
  }

  #preloader.active {
    display: block;
  }
</style>
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Pizarra</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Inicio</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h4>Pizarra de actividades</h4>
                                </div>
                                <div class="row">
                                    <div class="contenedor">
                                        <div class="tarjeta inicio">
                                            <div class="title-card">
                                                <span>Actividades en Pausa</span>
                                            </div>
                                            
                                        </div>
                                        <div class="tarjeta proceso">
                                            <div class="title-card">
                                                <span>Actividades en Curso</span>
                                            </div>
                                        </div>
                                        <div class="tarjeta fin">
                                            <div class="title-card">
                                                <span>Actividades Finalizadas</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                    
                    <!-- /# column -->
                </div>
            </div>
            <!-- #/ container -->
        </div>
        
        <!--**********************************
            Content body end
        ***********************************-->
<div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" id="md" role="document">
        <div class="modal-content" id="my-modal-content">Cargando...</div>
    </div>
</div>
<?php $this->load->view('base/js');?>
<script>
 actividadesyTareasPausa();
 actividadesyTareasProceso();
 actividadesyTareasFin();


function actividadesyTareasPausa(){
    var html = ` `;
    var button1 ="";
    var button2 ="";
    $.ajax({
        type: "POST",
        url:  "<?= base_url().'ActividadExternaControlador/get_tareas_pausa'; ?>",
        success: function(data){
            var mydata = JSON.parse(data);
            mydata.forEach(pausa=>{
                if(pausa.tipo !== 1){
                    button1 =`<button style="max-width: 38px;" title="Crear subtarea" type="button" class="open-modal-container btn btn-ligh btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodal(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-eye"></i>
                            </button>`;
                    button2 = `<button style="max-width: 10px;" title="Editar Estado" type="button" class="open-modal-container btn btn-ligh btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodalEdit(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-edit"></i></button>`;
                }else{
                    button1 =``;
                    button2 = `<button style="max-width: 10px;" title="Editar Estado" type="button" class="open-modal-container btn btn-ligh btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodalEditTarea(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-edit"></i></button>`;
                }
                html +=`<div class="actividad-inicio">
            <div class="title-actividad">
                        <span>${capitalizarPrimeraLetra(pausa.nombre_actividad)}</span>
                        </div>
                        <div class="descrp-actividad">
                            <span>${capitalizarPrimeraLetra(pausa.descripcion_actividad)}.</span>    
                        </div>
                        <div class="actividad-footer">
                            ${button1}
                            ${button2}
                        </div>                                               
                    </div>
                `;
            });
            $(".inicio").append(html);
        },
            error: function(data){
            console.log('Error: '+data);
        },
    });
}

function actividadesyTareasProceso(){
    var html = ``;
    var button1 ="";
    var button2 ="";
    $.ajax({
        type: "POST",
        url:  "<?= base_url().'ActividadExternaControlador/get_tareas_proceso'; ?>",
        success: function(data){
            console.log(data);
            var mydata = JSON.parse(data);
            mydata.forEach(pausa=>{
                if(pausa.tipo !== 1){
                    button1 =`<button style="max-width: 38px;" title="Crear subtarea" type="button" class="open-modal-container btn btn-ligh btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodal(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-eye"></i>
                            </button>`;
                    button2 = `<button style="max-width: 10px;" title="Editar Estado" type="button" class="open-modal-container btn btn-ligh btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodalEdit(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-edit"></i></button>`;
                }else{
                    button1 =``;
                    button2 = `<button style="max-width: 10px;" title="Editar Estado" type="button" class="open-modal-container btn btn-ligh btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodalEditTarea(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-edit"></i></button>`;
                }
                html +=`<div class="actividad-proceso">
            <div class="title-actividad">
                        <span>${capitalizarPrimeraLetra(pausa.nombre_actividad)}</span>
                        </div>
                        <div class="descrp-actividad">
                            <span>${capitalizarPrimeraLetra(pausa.descripcion_actividad)}.</span>    
                        </div>
                        <div class="actividad-footer">
                            ${button1}
                            ${button2}
                        </div>                                               
                    </div>
                `;
            });
            $(".proceso").append(html);
        },
            error: function(data){
            console.log('Error: '+data);
        },
    });
}

function actividadesyTareasFin(){
    var html = ``;
    var button1 ="";
    var button2 ="";
    $.ajax({
        type: "POST",
        url:  "<?= base_url().'ActividadExternaControlador/get_tareas_fin'; ?>",
        success: function(data){
            var mydata = JSON.parse(data);
            mydata.forEach(pausa=>{
                if(pausa.tipo !== 1){
                    button1 =`<button style="max-width: 38px;" title="Crear subtarea" type="button" class="open-modal-container btn btn-ligh btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodal(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-eye"></i>
                            </button>`;
                    button2 = `<button style="max-width: 10px;" title="Editar Estado" type="button" class="open-modal-container btn btn-ligh btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodalEdit(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-edit"></i></button>`;
                }else{
                    button1 =``;
                    button2 = `<button style="max-width: 10px;" title="Editar Estado" type="button" class="open-modal-container btn btn-ligh btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodalEditTarea(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-edit"></i></button>`;
                }
                html +=`<div class="actividad-fin">
            <div class="title-actividad">
                        <span>${capitalizarPrimeraLetra(pausa.nombre_actividad)}</span>
                        </div>
                        <div class="descrp-actividad">
                            <span>${capitalizarPrimeraLetra(pausa.descripcion_actividad)}.</span>    
                        </div>
                        <div class="actividad-footer">
                            ${button1}
                            ${button2}
                        </div>                                               
                    </div>
                `;
            });
            $(".fin").append(html);
        },
            error: function(data){
            console.log('Error: '+data);
        },
    });
}

function capitalizarPrimeraLetra(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}


function mostrarLoader(){
    $("#preloader").addClass("active");
}
function ocultarLoader(){
    $("#preloader").addClass("none");
}
function showmodal(pkActividad){
    $('#md').removeClass('modal-dialog modal-max').addClass('modal-dialog');
    $.ajax({
      type: "POST",
      url: "<?= base_url().'ActividadExternaControlador/get_modal_externa'; ?>",
      data: { pkActividad: pkActividad },
      async: true,
      dataType: "html",
      beforeSend: function () { mostrarLoader(); },
      success: function(data){
        ocultarLoader();
        if(data !== null && data !== '' && data !== undefined){
          $('#my-modal-content').html('').html(data);
          $("#my-modal").modal();
        }
      },
      error: function(data){
        ocultarLoader();
        console.log('Error: '+data);
      },
    });
}
  
function showmodalEdit(pkActividad){
    $('#md').removeClass('modal-dialog modal-max').addClass('modal-dialog');
    $.ajax({
      type: "POST",
      url: "<?= base_url().'ActividadExternaControlador/get_modal_edit_externa'; ?>",
      data: { pkActividad: pkActividad },
      async: true,
      dataType: "html",
      beforeSend: function () { mostrarLoader(); },
      success: function(data){
        ocultarLoader();
        if(data !== null && data !== '' && data !== undefined){
          $('#my-modal-content').html('').html(data);
          $("#my-modal").modal();
        }
      },
      error: function(data){
        ocultarLoader();
        console.log('Error: '+data);
      },
    });
}
function showmodalEditTarea(pkActividad){
    $('#md').removeClass('modal-dialog modal-max').addClass('modal-dialog');
    $.ajax({
      type: "POST",
      url: "<?= base_url().'TareaControlador/get_modal_edit_Tarea'; ?>",
      data: { pkActividad: pkActividad },
      async: true,
      dataType: "html",
      beforeSend: function () { mostrarLoader(); },
      success: function(data){
        ocultarLoader();
        if(data !== null && data !== '' && data !== undefined){
          $('#my-modal-content').html('').html(data);
          $("#my-modal").modal();
        }
      },
      error: function(data){
        ocultarLoader();
        console.log('Error: '+data);
      },
    });
}
</script>

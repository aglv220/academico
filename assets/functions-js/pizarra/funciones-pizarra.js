actividadesyTareasPausa();
actividadesyTareasProceso();
actividadesyTareasFin();

function actividadesyTareasPausa() {
    var html = ` `;
    var button1 = "";
    var button2 = "";
    $.ajax({
        type: "POST",
        url: root_path + "ActividadExternaControlador/get_tareas_pausa",
        success: function (data) {
            var mydata = JSON.parse(data);
            console.log(mydata);
            mydata.forEach(pausa => {
                button1 = ``;
                if (pausa.tipo !== "1") {
                    button1 = `<button title="Crear subtarea" type="button" class="open-modal-container btn-action a-subtarea btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodal(${pausa.id})" data-id="${pausa.id}"><i class="fa fa-eye"></i></button>`;
                    button2 = `<button title="Editar Estado" type="button" class="open-modal-container btn-action a-estado btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodalEdit(${pausa.id})" data-id="${pausa.id}"><i class="fa fa-edit"></i></button>`;
                } else {                    
                    button2 = `<button title="Editar Estado" type="button" class="open-modal-container btn-action a-estado btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodalEditTarea(${pausa.id})" data-id="${pausa.id}"><i class="fa fa-edit"></i></button>`;
                }
                html += `<div class="actividad-tj actividad-inicio">
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
        error: function (data) {
            console.log('Error: ' + data);
        },
    });
}

function actividadesyTareasProceso() {
    var html = ``;
    var button1 = "";
    var button2 = "";
    $.ajax({
        type: "POST",
        url: root_path + "ActividadExternaControlador/get_tareas_proceso",
        success: function (data) {
            var mydata = JSON.parse(data);
            mydata.forEach(pausa => {
                if (pausa.tipo !== "1") {
                    button1 = `<button title="Crear subtarea" type="button" class="open-modal-container btn-modal-exam btn-action a-subtarea" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodal(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-eye"></i>
                            </button>`;
                    button2 = `<button title="Editar Estado" type="button" class="open-modal-container btn-modal-exam btn-action a-estado" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodalEdit(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-edit"></i></button>`;
                } else {
                    button1 = ``;
                    button2 = `<button title="Editar Estado" type="button" class="open-modal-container btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodalEditTarea(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-edit"></i></button>`;
                }
                html += `<div class="actividad-tj actividad-proceso">
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
        error: function (data) {
            console.log('Error: ' + data);
        },
    });
}

function actividadesyTareasFin() {
    var html = ``;
    var button1 = "";
    var button2 = "";
    $.ajax({
        type: "POST",
        url: root_path + "ActividadExternaControlador/get_tareas_fin",
        success: function (data) {
            var mydata = JSON.parse(data);
            mydata.forEach(pausa => {
                if (pausa.tipo !== "1") {
                    button1 = `<button style="max-width: 38px;" title="Crear subtarea" type="button" class="open-modal-container btn btn-ligh btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodal(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-eye"></i>
                            </button>`;
                    button2 = `<button style="max-width: 10px;" title="Editar Estado" type="button" class="open-modal-container btn btn-ligh btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodalEdit(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-edit"></i></button>`;
                } else {
                    button1 = ``;
                    button2 = `<button style="max-width: 10px;" title="Editar Estado" type="button" class="open-modal-container btn btn-ligh btn-modal-exam" data-toggle="modal" data-act="ver" data-target="#modal-container" onclick="showmodalEditTarea(${pausa.id})" data-id="${pausa.id}">
                                <i class="fa fa-edit"></i></button>`;
                }
                html += `<div class="actividad-tj actividad-fin">
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
        error: function (data) {
            console.log('Error: ' + data);
        },
    });
}

function capitalizarPrimeraLetra(str) {
    console.log(str);
    new_str = str != null && str != "" ? str.charAt(0).toUpperCase() + str.slice(1) : "";
    return new_str;
}


function mostrarLoader() {
    $("#preloader").addClass("active");
}

function ocultarLoader() {
    $("#preloader").addClass("none");
}

function showmodal(pkActividad) {
    $('#md').removeClass('modal-dialog modal-max').addClass('modal-dialog');
    $.ajax({
        type: "POST",
        url: root_path + "ActividadExternaControlador/get_modal_externa",
        data: {
            pkActividad: pkActividad
        },
        async: true,
        dataType: "html",
        beforeSend: function () {
            mostrarLoader();
        },
        success: function (data) {
            ocultarLoader();
            if (data !== null && data !== '' && data !== undefined) {
                $('#my-modal-content').html('').html(data);
                $("#my-modal").modal();
            }
        },
        error: function (data) {
            ocultarLoader();
            console.log('Error: ' + data);
        },
    });
}

function showmodalEdit(pkActividad) {
    $('#md').removeClass('modal-dialog modal-max').addClass('modal-dialog');
    $.ajax({
        type: "POST",
        url: root_path + "ActividadExternaControlador/get_modal_edit_externa",
        data: {
            pkActividad: pkActividad
        },
        async: true,
        dataType: "html",
        beforeSend: function () {
            mostrarLoader();
        },
        success: function (data) {
            ocultarLoader();
            if (data !== null && data !== '' && data !== undefined) {
                $('#my-modal-content').html('').html(data);
                $("#my-modal").modal();
            }
        },
        error: function (data) {
            ocultarLoader();
            console.log('Error: ' + data);
        },
    });
}

function showmodalEditTarea(pkActividad) {
    $('#md').removeClass('modal-dialog modal-max').addClass('modal-dialog');
    $.ajax({
        type: "POST",
        url: root_path + "TareaControlador/get_modal_edit_Tarea",
        data: {
            pkActividad: pkActividad
        },
        async: true,
        dataType: "html",
        beforeSend: function () {
            mostrarLoader();
        },
        success: function (data) {
            ocultarLoader();
            if (data !== null && data !== '' && data !== undefined) {
                $('#my-modal-content').html('').html(data);
                $("#my-modal").modal();
            }
        },
        error: function (data) {
            ocultarLoader();
            console.log('Error: ' + data);
        },
    });
}
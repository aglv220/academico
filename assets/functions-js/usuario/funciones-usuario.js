/******** RECUPERACIÓN DE CONTRASEÑA *******/
var txt_validate = "Enviar correo de recuperación";
var txt_recover = "Actualizar contraseña";

$("#FRM_RECOVER_PASS").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var idform = form.attr("id");
    var url = form.attr('action');
    var formElement = document.getElementById(idform);
    var formData_rec = new FormData(formElement);
    var input_correo = $('input[name="usuario_correo"]');
    //var input_pass = $('input[name="usuario_password"]');
    var control_fase = $('#' + idform + ' input[name="operation_phase"]');
    var txt_msg_carga = 'Validando correo';
    if (control_fase.val() == "recover") {
        txt_msg_carga = "Validando código de recuperación y contraseña";
    }
    if (re_correo_utp.test(input_correo.val()) != "") {
        $.ajax({
            type: "POST",
            url: url,
            data: formData_rec,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                msg_swal_loading(txt_msg_carga,'Espera unos instantes');
            },
            success: function (data) {
                swal.close();
                control_validate = $('#' + idform + ' .control_validate');
                control_recover = $('#' + idform + ' .control_recover');
                boton_frm = $('#' + idform + ' button');
                switch (data) {
                    case "validate_error":
                        msg_swal("error", "Error", "El correo ingresado no existe");
                        break;
                    case "validate_ok":
                        control_fase.val("recover");
                        control_validate.prop("readonly", true);
                        control_recover.prop("required", true);
                        control_validate.hide();
                        control_recover.show();
                        boton_frm.text(txt_recover);
                        msg_swal("success", "Validación correcta", "Se ha enviado un código de recuperación al correo proporcionado");
                        break;
                    case "validate_error_codsended":
                        control_fase.val("recover");
                        control_validate.prop("readonly", true);
                        control_recover.prop("required", true);
                        control_validate.hide();
                        control_recover.show();
                        boton_frm.text(txt_recover);
                        msg_swal("warning", "Restablecimiento de cuenta detectado", "Recientemente ha solicitado un reestablecimiento de contraseña, use el código que se le envío a su correo");
                        break;
                    case "validate_error_cr":
                        msg_swal("error", "Error", "Ha ocurrido un error al generar el código de recuperación");
                        break;
                    case "validate_error_mail":
                        msg_swal("error", "Error", "Ha ocurrido un error al enviar el correo con el código de recuperación");
                        break;
                    case "pass_error":
                        msg_swal("error", "Error", "Las contraseñas no coinciden");
                        break;
                    case "codrecover_error":
                        msg_swal("error", "Error", "El código de recuperación ingresado es incorrecto");
                        break;
                    case "changepass_error":
                        msg_swal("error", "Error", "Ocurrió un error al actualizar la contraseña");
                        break;
                    case "changepass_ok":
                        Swal.fire({
                            title: 'Cambio de contraseña realizado correctamente',
                            html: 'Serás redireccionado a su página principal en 3 segundos',
                            timer: 3000,
                            allowOutsideClick: false,
                            showConfirmButton: false
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                location.href = root_path + "inicio-sesion";
                            }
                        })
                        break;
                }
            }
        });
    } else {
        msg_swal("error", "Error", "Introduzca un correo válido");
    }

});

$("#FRM_RECOVER_PASS").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var idform = form.attr("id");
    var url = form.attr('action');
    var formElement = document.getElementById(idform);
    var formData_rec = new FormData(formElement);
    $.ajax({
        type: "POST",
        url: url,
        data: formData_rec,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            msg_swal_loading('Guardando información','Espera unos instantes');
        },
        success: function (data) {
            swal.close();
            if (data == "ERROR_NO_CHANGES") {
                msg_swal("warning", "Sin cambios", "No se ha realizado ningún cambio");
            } else if (data == "ERROR_PASS_SHORT") {
                msg_swal("error", "Sin cambios", "La contraseña es muy corta (mínimo 8 caracteres)");
            } else if (data == "OK_SUCCESS") {
                msg_swal("success", "Información guardada", "Tus datos personales han sido actualizados");
            }
        }
    });
});

/******** CONFIGURACIÓN DE USUARIO *******/

$(".chkcfg_user").on("change", function () {
    tipo_item = $(this).attr("js-type");
    var checkboxs_target;
    switch (tipo_item) {
        case "activ":
            checkboxs_target = $(".subopt_actividad");
            break;
        case "piza":
            checkboxs_target = $(".subopt_tarea");
            break;
    }
    if ($(this).is(':checked')) {
        checkboxs_target.prop("checked", true);
        checkboxs_target.prop("disabled", true);
    } else {
        checkboxs_target.removeAttr("disabled");
        checkboxs_target.prop("checked", false);
    }
});

$("#FRM_CONFIGURACION").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var idform = form.attr("id");
    var url = form.attr('action');
    var formElement = document.getElementById(idform);
    var formData_rec = new FormData(formElement);
    $.ajax({
        type: "POST",
        url: url,
        data: formData_rec,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            Swal.fire({
                title: 'Guardando información',
                text: 'Espera unos instantes',
                allowOutsideClick: false,
                showConfirmButton: false,
            })
        },
        success: function (data) {
            swal.close();
            if (data == "OK") {
                msg_swal("success", "Información guardada", "Tu configuración ha sido actualizada correctamente");
            } else {
                msg_swal("error", "Error de actualización", "Ha ocurrido un error al actualizar la configuración");
            }
        }
    });
});

/******** HISTORIAL DE SISTEMA *******/

if($("#tblhistory").length != 0){
    var tblhistory = $('#tblhistory').DataTable(options_tbl);
}

/******** NOTIFICACIONES DEL SISTEMA *******/

if($("#tblnotifys").length != 0){
    var tblnotifys = $('#tblnotifys').DataTable(options_tbl);
}
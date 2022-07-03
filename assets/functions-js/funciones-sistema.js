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

$("#FRM_LOGIN").submit(function (e) {
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
                title: 'Validando credenciales',
                text: 'Espera unos instantes',
                allowOutsideClick: false,
                showConfirmButton: false,
            })
        },
        success: function (data) {
            console.log(data);
            swal.close();
            if (data == true) {
                location.href = root_path + "pagina_principal";
            } else if (data == false) {
                Swal.fire({
                    icon: 'error',
                    title: 'Credenciales incorrectas',
                    text: 'Verifica tu correo institucional y/o tu constraseña',
                    timer: 3000
                });
            } else { // SI FALTA EL REGISTRO POR PARTE DEL ALUMNO
                Swal.fire({
                    title: 'Registro incompleto',
                    html: 'Serás redireccionado a la página de registro para que completes tus datos',
                    timer: 3000,
                    allowOutsideClick: false,
                    showConfirmButton: false
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        location.href = root_path + "RegistroControlador/v_datos_personales?datoalumn=" + data;
                    }
                })
            }
        }
    });
});

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
                Swal.fire({
                    title: txt_msg_carga,
                    text: 'Espera unos instantes',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                })
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
                                location.href = root_path + "iniciar_sesion";
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
            Swal.fire({
                title: 'Guardando información',
                text: 'Espera unos instantes',
                allowOutsideClick: false,
                showConfirmButton: false,
            })
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

$("#FRM_REGISTRO_2").submit(function (e) {
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
                title: 'Validando credenciales',
                text: 'Espera unos instantes',
                allowOutsideClick: false,
                showConfirmButton: false,
            })
        },
        success: function (data) {
            swal.close();
            if (data == false) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Credenciales incorrectas',
                    timer: 3000
                })

            } else {
                location.href = root_path + "pagina_principal";
            }
        }
    });
});

$('#FRM_REGISTRO_2 a[href="#finish"]').on('click', function (e) {
    e.preventDefault();
    var formElement = document.getElementById("FRM_REGISTRO_2");
    var formData_rec = new FormData(formElement);
    $.ajax({
        type: "POST",
        url: root_path + "RegistroControlador/registrar_datos_personales",
        data: formData_rec,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            Swal.fire({
                title: 'Guardando tu información',
                text: 'Espera unos instantes',
                allowOutsideClick: false,
                showConfirmButton: false,
            })
        },
        success: function (resp) {
            swal.close();
            console.log(resp);
            if (resp == "OK") { //REGISTRO COMPLETO
                Swal.fire({
                    title: 'Registro completado satisfactoriamente',
                    html: 'Serás redireccionado a su página principal en 3 segundos',
                    timer: 3000,
                    allowOutsideClick: false,
                    showConfirmButton: false
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        location.href = root_path + "iniciar_sesion";
                    }
                })
            } else if (resp == "EXIST") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ya existe un alumno con el código registrado',
                    timer: 3000
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ha ocurrido un error en el sistema',
                    timer: 3000
                })
            }
        }
    });
});

function registrar() {
    var input_correo = $('input[name="usuario_correo"]');
    var input_pass = $('input[name="usuario_clave"]');

    if (re_correo_utp.test(input_correo.val()) != "" && input_pass.val() != "") {
        Swal.fire({
            title: "Detalles del registro",
            text: "Te preguntarás por qué necesitamos tus credenciales de la universidad. Es necesario para poder obtener la información relacionada a tus actividades, fechas de pagos y cursos. ¡No te preocupes! Mantenemos estándares altos de privacidad. ¿Desea continuar?",
            icon: 'info',
            showCancelButton: true,
            allowOutsideClick: false,
            cancelButtonText: "No",
            confirmButtonColor: '#00945e',
            cancelButtonColor: '#DD6B55',
            confirmButtonText: 'Si'
        }).then((result) => {

            if (result.isConfirmed) {

                swal.close();
                var formElement = document.getElementById("FRM_REGISTRO");
                var formData_rec = new FormData(formElement);
                var correo_alumno = $('input[name="usuario_correo"]').val();
                $.ajax({
                    type: "POST",
                    url: root_path + "RegistroControlador/validar_registro",
                    data: formData_rec,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (resp) {
                        if (resp == "OK") {
                            Swal.fire({
                                title: 'Primera parte del registro completa',
                                html: 'Serás redireccionado en 3 segundos',
                                timer: 3000,
                                allowOutsideClick: false,
                                showConfirmButton: false
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    location.href = root_path + "RegistroControlador/v_datos_personales?datoalumn=" + btoa(correo_alumno);
                                }
                            })
                        } else if (resp == "EXIST") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'El correo ya se encuentra registrado',
                                timer: 3000
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Ha ocurrido un error en el sistema',
                                timer: 3000
                            })
                        }
                    }
                });
            }

        })
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Datos incorrectos',
            text: 'Ingrese un correo valido de la universidad',
            timer: 3000
        })
    }
}

update_notifications();

function print_notify_header(notify_html, user_notify, one_notify) {
    var user_notify = decript_data_js(user_notify);
    $.post(root_path + "UsuarioControlador/validar_sesion_usuario", function (data) {
        var id_user_sess = decript_data_js(data);
        if (user_notify == id_user_sess) {
            var contain_lst_notify = $(".lst-notificaciones");
            var containt_notify = $(".contentedor-notify-pending");
            var count_notify_num = $('.count-notify-pending.notify-number');
            var count_notify_txt = $('.count-notify-pending.notify-text');
            var count_notify = containt_notify.length;
            var first_notify = containt_notify.last();
            if (one_notify == true) { //SI SE AGREGO UNA NUEVA NOTIFICACION
                cantidad_notify = parseInt(count_notify_num.html());
                cantidad_notify_n = cantidad_notify + 1;
            } else { //SI SE ACTUALIZARÁ TODO EL LISTADO DE NOTIFICACIONES
                cantidad_notify_n = parseInt(one_notify);
            }
            //ACTUALIZAR CANTIDAD DE NOTIFICACIONES
            count_notify_num.html(cantidad_notify_n);
            count_notify_txt.html(cantidad_notify_n + " notificaciones");
            if (one_notify == true) { //SI SE AGREGO UNA NUEVA NOTIFICACION
                //INSERTAR HTML DE NUEVA NOTIFICACION
                contain_lst_notify.prepend(notify_html);
                //ELIMINAR ULTIMA NOTIFICACION DE LA LISTA PARA COLOCAR LA ULTIMA ARRIBA
                if (count_notify > 4) {
                    first_notify.remove();
                }
            } else { //ACTUALIZAR TODA LA LISTA DE NOTIFICACIONES
                contain_lst_notify.empty();
                contain_lst_notify.html(notify_html);
            }
        }
    }).done(function(){
        update_notifications();
    });
}

$(document).ready(function () {
    //console.log(page_name);
});

$(".test-notification").on("click", function () {
    $.post(root_path + "NotificacionControlador/registrar_notificacion");
})

function update_notifications(){
    $(".notify-pending").on("click", function () {
        var notify_elem = $(this);
        var id_notify = notify_elem.attr("js-id");
        $.post(root_path + "NotificacionControlador/actualizar_estado_notificacion", { ID_notify: id_notify });
    })
}

//ACTUALIZACION DE NOTIFICACIONES EN TIEMPO REAL
channel_notif_user.bind('register-n', function (data) {
    one_notify = true;
    if (typeof data["NOTIFYPENDALL"] != 'undefined') {
        one_notify = data["NOTIFYPENDALL"];
    }
    print_notify_header(data["HTMLNOTIFY"], data["USERNOTIFY"], one_notify);
});
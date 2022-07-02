var pathname = window.location.pathname;
var data_path = pathname.split("/");
var root_path = "/" + data_path[1] + "/";
var re_correo_utp = new RegExp("([a-z]|[0-9])+@utp.edu.pe$");

function solo_texto(e) {

    especiales = [32];
    caracteres = ["%"];

    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();

    tecla_especial = false;

    if (caracteres.indexOf(tecla) == -1) {
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true; break;
            } else if (key > 96 && key < 123) {
                //LETRAS MINUSCULAS
                tecla_especial = true; break;
            } else if (key > 64 && key < 91) {
                //LETRAS MAYUSCULAS
                tecla_especial = true; break;
            }
        }
    }

    if (!tecla_especial)
        return false;
}

function numeros_decimales(e) {

    especiales = [8, 9, 37, 39, 46];
    numeros = "0123456789.";

    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) { tecla_especial = true; break; }
    }

    if (numeros.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}

function numeros_enteros(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "0123456789";
    especiales = [8, 9, 37, 39, 46];
    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) { tecla_especial = true; break; }
    }
    if (letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}

function msg_swal(tipo, titulo, mensaje, tmr = 3000) {
    Swal.fire({
        icon: tipo,
        title: titulo,
        text: mensaje,
        timer: tmr
    })
}

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
        checkboxs_target.prop("checked",true);
        checkboxs_target.prop("disabled",true);
    } else {
        checkboxs_target.removeAttr("disabled");
        checkboxs_target.prop("checked",false);
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
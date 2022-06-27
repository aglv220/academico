var pathname = window.location.pathname;
var data_path = pathname.split("/");
var root_path = "/" + data_path[1] + "/";
var re_correo_utp = new RegExp("([a-z]|[0-9])+@utp.edu.pe$");

function msg_swal(tipo, titulo, mensaje, tmr = 3000) {
    Swal.fire({
        icon: tipo,
        title: titulo,
        text: mensaje,
        timer: tmr
    })
}

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
            swal.close();
            if(data == true) {
                location.href = root_path + "UsuarioControlador/pagina_principal/";
            } else if (data == false) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Credenciales incorrectas',
                    timer: 3000
                });
            }  else {
                location.href = root_path + "RegistroControlador/v_datos_personales?datoalumn=" + data;
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
    if(control_fase.val() == "recover"){
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
                    case "validate_error_cr":
                        msg_swal("error", "Error", "Ha ocurrido un error al generar el código de recuperación");
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
                                location.href = root_path + "LoginControlador/";
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
                location.href = root_path + "UsuarioControlador/pagina_principal/";
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
                        location.href = root_path + "LoginControlador/";
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
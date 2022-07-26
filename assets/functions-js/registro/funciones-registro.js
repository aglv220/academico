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
            msg_swal_loading('Validando credenciales', 'Espera unos instantes');
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
            msg_swal_loading('Guardando tu información', 'Espera unos instantes');
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
                        location.href = root_path + "inicio-sesion";
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

html_loading =
    '<b>Nos encontramos guardando tu información al sistema...</b><br><br>' +
    'Te notificaremos cuando el proceso acabe.. Gracias<br><br>' +
    '<b>Cargando';

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
                msg_swal_loading("Validando las credenciales", "Estamos validando tu información");
                $.ajax({
                    type: "POST",
                    url: root_path + "RegistroControlador/validar_registro",
                    data: formData_rec,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (resp) {
                        var mydata = JSON.parse(resp);
                        var fase = mydata["data"][0];
                        var correo = mydata["data"][1];
                        var password = mydata["data"][2];
                        var apiuser = mydata["data"][3];
                        var apipass = mydata["data"][4];
                        if (fase == "VALIDACION") {
                            $.get(root_path + "ApiControlador/obtener_token",
                                { usuario: apiuser, password: apipass, encriptedlogin: 1, passhashed: 1, securetoken: 1 }).done(function (data) {
                                    data_t = JSON.parse(data);
                                    token = data_t["token"];
                                    $.get(root_path + "ApiControlador/web_scrapping",
                                        { correo: correo, clave: password, fase: fase, token: token }).done(function (data) {
                                            swal.close();
                                            if (data != false) {
                                                id_user = data;
                                                if (id_user == "EXIST") {
                                                    msg_swal("error", "Correo registrado", "Ya existe otra cuenta con ese correo");
                                                } else {
                                                    msg_swal_loading("Nos enfocamos en brindarte el mejor servicio", html_loading);
                                                    $.get(root_path + "ApiControlador/web_scrapping",
                                                        { correo: correo, clave: password, fase: "REGISTRO", token: token, iduser: id_user }).done(function (data) {
                                                            setTimeout(function () {
                                                                if (data == true) {
                                                                    swal.close();
                                                                    Swal.fire({
                                                                        title: 'Información guardada correctamente',
                                                                        html: '<b>Tu información académica ha sido registrada en nuestro sistema<b><br><br>Para completar tu registro serás redireccionado a otra página para que llenes tus datos personales.<br><br><b>Espera unos instantes...</b>',
                                                                        timer: 3000,
                                                                        allowOutsideClick: false,
                                                                        showConfirmButton: false
                                                                    }).then((result) => {
                                                                        if (result.dismiss === Swal.DismissReason.timer) {
                                                                            location.href = root_path + "RegistroControlador/v_datos_personales?datoalumn=" + btoa(correo);
                                                                        }
                                                                    })
                                                                }
                                                            }, 10000);
                                                        });
                                                }
                                            } else {
                                                msg_swal("error", "Credenciales incorrectas", "Verifica tu correo y/o contraseña");
                                            }
                                        });
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
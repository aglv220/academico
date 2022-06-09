var pathname = window.location.pathname;
var data_path = pathname.split("/");
var root_path = "/" + data_path[1] + "/";

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

function registrar() {

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
                    swal("Error de registro", "El correo proporcionado ya existe");
                } else {
                    swal("Error de registro", "Ha ocurrido un error en el sistema");
                }
            }
        });

      })
}
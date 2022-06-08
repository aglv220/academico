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
            swal({
                title: "Validando credenciales",
                buttons: false
            });
        },
        success: function (data) {
            if(data == false){
                swal({
                    title: "Error de credenciales"
                });
            } else {
                location.href = root_path + "UsuarioControlador/pagina_principal/";
            }
        }
    });
});

function registrar(){
    swal({
    title: "Detalles del registro",
    text: "Te preguntarás por qué necesitamos tus credenciales de la universidad. Es necesario para poder obtener la información relacionada a tus actividades, fechas de pagos y cursos. ¡No te preocupes! Mantenemos estándares altos de privacidad. ¿Desea continuar?",
    type: "info",
    showCancelButton: true,
    cancelButtonText: "No",
    cancelButtonColor: "#DD6B55",
    confirmButtonColor: "#00945e",
    confirmButtonText: "Si",
    closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
        var formElement = document.getElementById("FRM_REGISTRO");
        var formData_rec = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: root_path + "RegistroControlador/validar_registro",
            data: formData_rec,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if(data == "OK"){
                    setTimeout(function(){
                        swal("Primera parte del registro completa, serás redireccionado en 3 segundos", "success");
                        location.href = root_path + "RegistroControlador/v_datos_personales/";
                    }, 3000);                    
                } else if(data == "EXIST"){
                    swal("Error de registro", "El correo proporcionado ya existe", "error");
                } else {
                    swal("Error de registro", "Ha ocurrido un error en el sistema", "error");
                }                
            }
        });

    });
}
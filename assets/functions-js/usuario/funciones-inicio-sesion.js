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
            msg_swal_loading('Validando credenciales','Espera unos instantes');
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
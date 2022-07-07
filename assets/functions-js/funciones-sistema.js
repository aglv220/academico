/************ NOTIFICACIONES EN TIEMPO REAL ************/
update_notifications();

function print_notify_header(notify_html, user_notify, one_notify) {
    var user_notify = decript_data_js(user_notify);
    $.post(root_path + "UsuarioControlador/validar_sesion_usuario", function (data) {
        var id_user_sess = decript_data_js(data);
        if (user_notify == id_user_sess) {
            //LIMPIAR MENSAJE DE NOTIFICACIONES VACIAS
            if($(".notify-pending-none").length){
                $(".notify-pending-none").parent().remove();
            }
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
    }).done(function () {
        update_notifications();
    });
}

$(document).ready(function () {
    //console.log(page_name);
});

$(".test-notification").on("click", function () {
    $.post(root_path + "NotificacionControlador/registrar_notificacion");
})

function update_notifications() {
    $(".notify-pending").on("click", function () {
        var notify_elem = $(this);
        var id_notify = notify_elem.attr("js-id");
        //ELIMINAR NOTIFICACIÓN SELECCIONADA
        $(this).parent().remove();
        //ACTUALIZAR CONTENEDOR Y ESTADO POR BASE DE DATOS
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
/************ NOTIFICACIONES EN TIEMPO REAL ************/


update_notifications();

function setHTML_notify(contain_lst_notify, cantidad_notify_new, notify_html) {
    if (cantidad_notify_new == 0) {
        $(".c-notify-pending-none").removeClass("display-none");
    } else {
        $(".c-notify-pending-none").addClass("display-none");
    }
    contain_lst_notify.empty();
    contain_lst_notify.html(notify_html);
}

function print_notify_header(notify_html, user_notify, num_allnotify, type_notify, only_update) {
    var user_notify = decript_data_js(user_notify);
    $.post(root_path + "UsuarioControlador/validar_sesion_usuario", function (data) {
        var id_user_sess = decript_data_js(data);
        if (user_notify == id_user_sess) {
            var contain_lst_notify = $(".lst-notificaciones");
            var containt_notify = $(".contentedor-notify-pending");
            var count_notify_num = $('.count-notify-pending.notify-number');
            var count_notify_txt = $('.count-notify-pending.notify-text');
            //CANTIDAD DE NOTIFICACIONES POR HTML
            var count_notify = containt_notify.length;
            //console.log("nro. actual => " + parseInt(count_notify_num.html()) + " | nro. nuevo => " + num_allnotify);
            var first_notify = containt_notify.last();
            if (type_notify == "ONE") { //SI SE AGREGO UNA NUEVA NOTIFICACION
                cantidad_notify = parseInt(count_notify_num.html());
                cantidad_notify_new = cantidad_notify + 1;
            } else { //SI SE ACTUALIZARÁ TODO EL LISTADO DE NOTIFICACIONES
                if (only_update) {
                    if (parseInt(num_allnotify) == parseInt(count_notify_num.html())) {
                        cantidad_notify_new = parseInt(num_allnotify);
                    } else {
                        cantidad_notify_new = parseInt(count_notify_num.html());
                    }
                } else {
                    cantidad_notify_new = parseInt(num_allnotify);
                }
                //console.log(cantidad_notify_new);
            }
            //ACTUALIZAR CANTIDAD DE NOTIFICACIONES
            count_notify_num.html(cantidad_notify_new.toString());
            txt_notify = cantidad_notify_new == 1 ? " notificación" : " notificaciones";
            count_notify_txt.html(cantidad_notify_new.toString() + txt_notify);
            if (type_notify == "ONE") { //SI SE AGREGO UNA NUEVA NOTIFICACION
                //INSERTAR HTML DE NUEVA NOTIFICACION
                contain_lst_notify.prepend(notify_html);
                //ELIMINAR ULTIMA NOTIFICACION DE LA LISTA PARA COLOCAR LA ULTIMA ARRIBA
                if (count_notify > 4) {
                    first_notify.remove();
                }
            } else { //ACTUALIZAR TODA LA LISTA DE NOTIFICACIONES
                if (only_update) {
                    if (parseInt(num_allnotify) == parseInt(count_notify_num.html())) {
                        setHTML_notify(contain_lst_notify, cantidad_notify_new, notify_html);
                    }
                } else {
                    setHTML_notify(contain_lst_notify, cantidad_notify_new, notify_html);
                }
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

$(".notify-pending-deleteall").on("click", function () {
    $.post(root_path + "NotificacionControlador/actualizar_estado_notificaciones").done(function () {
        //console.log("Eliminadas");
    });
})

function update_notifications() {
    $(".notify-pending").on("click", function () {
        var notify_elem = $(this);
        var id_notify = notify_elem.attr("js-id");
        //ELIMINAR NOTIFICACIÓN SELECCIONADA
        $(this).parent().remove();
        //ACTUALIZAR CANTIDAD DE NOTIFICACIONES

        var count_notify_num = $('.count-notify-pending.notify-number');
        var count_notify_txt = $('.count-notify-pending.notify-text');

        //console.log("un"+count_notify);

        cantidad_notify = parseInt(count_notify_num.html());
        cantidad_notify_new = cantidad_notify - 1;
        //SI LA NUEVA CANTIDAD DE NOTIFICACIONES ES 0
        if (cantidad_notify_new == 0) {
            $(".c-notify-pending-none").removeClass("display-none");
        }
        txt_notify = cantidad_notify_new == 1 ? " notificación" : " notificaciones";
        count_notify_num.html(cantidad_notify_new.toString());
        count_notify_txt.html(cantidad_notify_new.toString() + txt_notify);
        //ACTUALIZAR CONTENEDOR Y ESTADO POR BASE DE DATOS
        $.post(root_path + "NotificacionControlador/actualizar_estado_notificacion", { ID_notify: id_notify }, function (data) {
            /*if (data != "NONE") {
                num_notify_new = parseInt(data);
                if (num_notify_new == 0) { //YA NO HAY NOTIFICACIONES
                    $(".c-notify-pending-none").removeClass("display-none");
                }
                txt_notify = num_notify_new == 1 ? " notificación" : " notificaciones";
                count_notify_num.html(num_notify_new.toString());
                count_notify_txt.html(num_notify_new.toString() + txt_notify);
            }*/
        }).done(function () {
            //$.post(root_path + "NotificacionControlador/listar_notificaciones_actualizadas");
        });
    })
}

//ACTUALIZACION DE NOTIFICACIONES EN TIEMPO REAL
channel_notif_user.bind('register-n', function (data) {
    print_notify_header(data["HTMLNOTIFY"], data["USERNOTIFY"], data["NOTIFYPENDALL"], data["TYPENOTIFY"], data["ONLYUPDATE"]);
});
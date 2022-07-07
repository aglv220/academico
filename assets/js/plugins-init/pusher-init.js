//CONFIGURACIÓN DE PUSHER - NOTIFICACIONES
Pusher.logToConsole = false;
var pusher = new Pusher('41b56b5d9bc46b65d611', {
    cluster: 'us3'
});
var channel_notif_user = pusher.subscribe('canal-notificaciones');
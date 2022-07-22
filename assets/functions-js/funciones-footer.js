var pathname = window.location.pathname;
var data_path = pathname.split("/");
var root_path = "/" + data_path[1] + "/";
var url = window.location.href;
var page_name = getPageName(url);
var re_correo_utp = new RegExp("([a-z]|[0-9])+@utp.edu.pe$");

function getPageName(url) {
    var index = url.lastIndexOf("/") + 1;
    var filenameWithExtension = url.substr(index);
    var filename = filenameWithExtension.split(".")[0];
    return filename;
}

function encode_utf8(s) {
    return unescape(encodeURIComponent(s));
}

function decode_utf8(s) {
    return decodeURIComponent(escape(s));
}

function encode_base64(cadena) {
    encode = encode_utf8($.base64.encode(cadena));
    return encode;
}

function decode_base64(cadena) {
    decode = decode_utf8($.base64.decode(cadena));
    return decode;
}

function reverse_string(cadena) {
    string_reverse = cadena.split("").reverse().join("");
    return string_reverse;
}

function convert_uuencode(str) {
    var chr = function (c) {
        return String.fromCharCode(c)
    }
    if (!str || str === '') {
        return chr(0)
    }
    var c = 0
    var u = 0
    var i = 0
    var a = 0
    var encoded = ''
    var tmp1 = ''
    var tmp2 = ''
    var bytes = {}
    // divide string into chunks of 45 characters
    var chunk = function () {
        bytes = str.substr(u, 45).split('')
        for (i in bytes) {
            bytes[i] = bytes[i].charCodeAt(0)
        }
        return bytes.length || 0
    }
    while ((c = chunk()) !== 0) {
        u += 45
        // New line encoded data starts with number of bytes encoded.
        encoded += chr(c + 32)
        // Convert each char in bytes[] to a byte
        for (i in bytes) {
            tmp1 = bytes[i].toString(2)
            while (tmp1.length < 8) {
                tmp1 = '0' + tmp1
            }
            tmp2 += tmp1
        }
        while (tmp2.length % 6) {
            tmp2 = tmp2 + '0'
        }
        for (i = 0; i <= (tmp2.length / 6) - 1; i++) {
            tmp1 = tmp2.substr(a, 6)
            if (tmp1 === '000000') {
                encoded += chr(96)
            } else {
                encoded += chr(parseInt(tmp1, 2) + 32)
            }
            a += 6
        }
        a = 0
        tmp2 = ''
        encoded += '\n'
    }
    // Add termination characters
    encoded += chr(96) + '\n'
    return encoded
}

function rtrim(str, charlist) {
    charlist = !charlist ? ' \\s\u00A0' : (charlist + '')
        .replace(/([[\]().?/*{}+$^:])/g, '\\$1');
    var re = new RegExp('[' + charlist + ']+$', 'g');
    return (str + '').replace(re, '');
}

function convert_uudecode(str) {
    // shortcut
    var chr = function (c) {
        return String.fromCharCode(c);
    };
    if (!str || str == "") {
        return chr(0);
    } else if (str.length < 8) {
        return false;
    }
    var decoded = "", tmp1 = "", tmp2 = "";
    var c = 0, i = 0, j = 0, a = 0;
    var line = str.split("\n");
    var bytes = [];
    for (i in line) {
        c = line[i].charCodeAt(0);
        bytes = line[i].substr(1);
        // Convert each char in bytes[] to a 6-bit
        for (j in bytes) {
            tmp1 = bytes[j].charCodeAt(0) - 32;
            tmp1 = tmp1.toString(2);
            while (tmp1.length < 6) {
                tmp1 = "0" + tmp1;
            }
            tmp2 += tmp1
        }
        for (i = 0; i <= (tmp2.length / 8) - 1; i++) {
            tmp1 = tmp2.substr(a, 8);
            if (tmp1 == "01100000") {
                decoded += chr(0);
            } else {
                decoded += chr(parseInt(tmp1, 2));
            }
            a += 8;
        }
        a = 0;
        tmp2 = "";
    }
    return this.rtrim(decoded, "\0");
}

function encript_data_js(cadena) {
    fase_1 = reverse_string(cadena);
    fase_2 = convert_uuencode(fase_1);
    fase_3 = encode_base64(fase_2);
    fase_4 = reverse_string(fase_3);
    return fase_4;
}

function decript_data_js(cadena) {
    fase_1 = reverse_string(cadena);
    fase_2 = decode_base64(fase_1);
    fase_3 = convert_uudecode(fase_2);
    fase_4 = reverse_string(fase_3);
    return fase_4;
}

function msg_swal(tipo, titulo, mensaje, tmr = 3000) {
    Swal.fire({
        icon: tipo,
        title: titulo,
        text: mensaje,
        timer: tmr
    })
}

function msg_swal_loading(titulo, html) {
    Swal.fire({
        title: titulo,
        html: html,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
        },
        allowOutsideClick: false,
        allowEscapeKey: false
    })
}


function labelFormatter(label, series) {
    return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
}

options_tbl = {
    "language": {
        "processing": "Cargando información...",
        "loadingRecords": "Cargando registros...",
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "No se ha encontrado información",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No existe información",
        "infoFiltered": "(filtered from _MAX_ total records)",
        "search": "Buscar en la tabla",
        "paginate": {
            "first":      "Primero",
            "previous":   "Anterior",
            "next":       "Siguiente",
            "last":       "Último"
        },
    }
}
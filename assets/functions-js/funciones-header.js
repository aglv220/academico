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
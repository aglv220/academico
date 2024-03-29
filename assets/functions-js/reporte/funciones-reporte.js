if (page_name == "actividades" || page_name == "tareas") {
    var tipo_reporte;
    switch (page_name) {
        case "actividades":
            tipo_reporte = 1;
            break;
        case "tareas":
            tipo_reporte = 2;
            break;
    }

    $("#select-mes").on("change", function () {
        var elem = $(this);
        var mes = elem.val();
        elem.prop("disabled", true);
        $('#chart_actividades').html("");
        obtener_reporte_actividades(mes, tipo_reporte);
    })

    obtener_reporte_actividades("", tipo_reporte);

    var txt_nodata_report = "<h4 class='mt-8'><center>No se encontró información</center></h4>";

    function obtener_reporte_actividades(mes = "", tipo_reporte) {
        Swal.fire({
            title: 'Cargando...',
            html: 'Esto tomará unos segundos',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
            },
            allowOutsideClick: false,
            allowEscapeKey: false,
            target: '#contenedor-report'
        })
        $.post(root_path + "ReporteControlador/listar_reporte_actividades", { input_mes: mes, input_tiprep: tipo_reporte }, function (data) {
            var mydata = JSON.parse(data);
            suma_cant = 0;
            sumtotal = false;
            c_mydata = mydata.length;
            last_mydata = c_mydata - 1;
            label_html = "";
            $("#div-porcentajes").html("");
            for (index = 0; index < c_mydata; index++) {
                if (sumtotal == false) {
                    //SE VA SUMANDO LA CANTIDAD TOTAL
                    data_val = parseInt(mydata[index].data[0]);
                    suma_cant += data_val;
                }
                if (index == last_mydata && sumtotal == false) {
                    //YA SE SUMO TODAS LAS CANTIDADES
                    sumtotal = true;
                    //REINICIAR FOR
                    index = 0;
                }
                //SI YA SE TIENE EL TOTAL SUMADO
                if (sumtotal == true) {
                    txt_lbl = mydata[index].label;
                    data_val = parseInt(mydata[index].data[0]);
                    porcentaje = parseFloat((data_val / parseInt(suma_cant)) * 100);
                    round_prc = Math.round(porcentaje * 100) / 100;
                    label_html +=
                        '<div class="card">' +
                        '<div class="card-body text-center">' +
                        '<span class="color porcentaje">' + round_prc+ '% </span> <span class="color nombre">' + txt_lbl + '</span>' +
                        '</div>' +
                        '</div>';
                }
            }
            $("#div-porcentajes").html(label_html);

            if (mydata.length == 0) {
                $('#chart_actividades').html(txt_nodata_report);
            } else {
                $.plot('#chart_actividades', mydata, {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            label: {
                                show: true,
                                radius: 2 / 3,
                                formatter: labelFormatter,
                                threshold: 0.1
                            }
                        }
                    },
                    grid: {
                        hoverable: true,
                        clickable: true
                    }
                });
            }
        }).done(function () {
            Swal.close();
            $("#select-mes").prop("disabled", false);
        });
    }

}
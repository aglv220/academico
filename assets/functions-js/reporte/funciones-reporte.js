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
            // setTimeout(function () {}, 1000);
            $("#select-mes").prop("disabled", false);
        });
    }

}
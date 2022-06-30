var pathname = window.location.pathname;
var data_path = pathname.split("/");
var root_path = "/" + data_path[1] + "/";
var re_correo_utp = new RegExp("([a-z]|[0-9])+@utp.edu.pe$");

! function(e) {
    "use strict";
    var t = function() {
        this.$body = e("body"), this.$modal = e("#event-modal"), this.$event = "#external-events div.external-event", this.$calendar = e("#calendar"), this.$saveCategoryBtn = e(".save-category"), this.$categoryForm = e("#add-category form"), this.$extEvents = e("#external-events"), this.$calendarObj = null
    };
    t.prototype.onDrop = function(t, n) {
        var a = t.data("eventObject"),
            o = t.attr("data-class"),
            i = e.extend({}, a);
        i.start = n, o && (i.className = [o]), this.$calendar.fullCalendar("renderEvent", i, !0), e("#drop-remove").is(":checked") && t.remove()
    }, t.prototype.onEventClick = function(t, n, a) {
        var o = this,
            i = e("<form></form>");
        i.append("<label>Cambiar nombre de la actividad</label>"), i.append("<div class='input-group'><input class='form-control' type=text value='" + t.title + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success waves-effect waves-light'><i class='fa fa-check'></i> Guardar</button></span></div>"), o.$modal.modal({
            backdrop: "static"
        }), o.$modal.find(".delete-event").show().end().find(".save-event").hide().end().find(".modal-body").empty().prepend(i).end().find(".delete-event").unbind("click").on("click", function() {
            o.$calendarObj.fullCalendar("removeEvents", function(e) {
                return e._id == t._id
            }), o.$modal.modal("hide")
        }), o.$modal.find("form").on("submit", function() {
            return t.title = i.find("input[type=text]").val(), o.$calendarObj.fullCalendar("updateEvent", t), o.$modal.modal("hide"), !1
        })
    }, t.prototype.onSelect = function(t, n, a) {
        var o = this;
        o.$modal.modal({
            backdrop: "static"
        });
        $.ajax({
            type: "POST",
            url:  root_path +'TareaControlador/listarTipoActividad',
            success: function(data){
                var mydata = JSON.parse(data);
                
                var i = e("<form></form>");

                i.append("<div class='row'></div>"), 
                
                i.find(".row").append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Nombre de la actividad</label><input class='form-control' placeholder='Ingrese nombre' type='text' name='nombre-actividad'/></div></div>").append("<div class='col-md-6'><div class='form-group div-tipo-act'><label class='control-label'>Tipo de actividad</label>");
                
                i.find(".div-tipo-act").append("<select class='form-control select-tipact' name='tipo-actividad'>");
                
                mydata.forEach(tipos=>{
                    i.find(".select-tipact").append(`<option value="${tipos.pk_tipo_actividad}" >${tipos.nombre_tipo_actividad}</option>`);
                });
                i.find(".div-tipo-act").append("</select></div></div>");
                i.find(".row").append('<div class="col-md-6"><label class="control-label">Fecha limite de la actividad</label><input class="form-control form-white"  type="date" name="fecha-actividad"></div><div class="col-md-6"><label class="control-label">Hora limite de la actividad</label><input class="form-control form-white"  type="time" name="hora-actividad"></div><div class="col-md-6"><label class="control-label">detalle</label><textarea name="detalle-actividad" id="" cols="30" rows="10"></textarea></div>');
                
                o.$modal.find(".delete-event").hide().end().find(".save-event").show().end().find(".modal-body").empty().prepend(i).end().find(".save-event").unbind("click").on("click", function() {
                    var nombre = i.find("input[name='nombre-actividad']").val();
                    var tipoActividad = i.find("select[name='tipo-actividad']").val();
                    var fecha = i.find("input[name='fecha-actividad']").val();
                    var hora = i.find("input[name='hora-actividad']").val();
                    var descrip = i.find("textarea[name='detalle-actividad']").val();
                    var estado = 1;
                    $.ajax({
                        type: "POST",
                        url:  root_path +'ActividadExternaControlador/crearActividad',
                        data: { nombre: nombre, tipoActividad: tipoActividad, fecha: fecha, hora: hora, descrip: descrip, estado:estado },
                        success: function(data){
                            setTimeout(function() {
                                window.location.reload();
                           },0);
                        },
                            error: function(data){
                            console.log('Error: '+data);
                        },
                    });
                })
                
            },
                error: function(data){
                console.log('Error: '+data);
            },
        });
        o.$modal.find("form").on("submit", function() {
            var e = i.find("input[name='title']").val(),
                a = (i.find("input[name='beginning']").val(), i.find("input[name='ending']").val(), i.find("select[name='category'] option:checked").val());
            return null !== e && 0 != e.length ? (o.$calendarObj.fullCalendar("renderEvent", {
                title: e,
                start: t,
                end: n,
                allDay: !1,
                className: a
            }, !0), o.$modal.modal("hide")) : alert("You have to give a title to your event"), !1
        }), o.$calendarObj.fullCalendar("unselect")
    }, t.prototype.enableDrag = function() {
        e(this.$event).each(function() {
            var t = {
                title: e.trim(e(this).text())
            };
            e(this).data("eventObject", t), e(this).draggable({
                zIndex: 999,
                revert: !0,
                revertDuration: 0
            })
        })
    }, t.prototype.init = function() {
        this.enableDrag();
        var t = new Date,
            n = (t.getDate(), t.getMonth(), t.getFullYear(), new Date(e.now())),
            
            o = this;
            $.ajax({
                type: "POST",
                url:  root_path +'ActividadExternaControlador/llenarCalendario',
                success: function(data){
                    var mydata = JSON.parse(data);
                    o.$calendarObj = o.$calendar.fullCalendar({
                        slotDuration: "00:15:00",
                        minTime: "08:00:00",
                        maxTime: "19:00:00",
                        defaultView: "month",
                        handleWindowResize: !0,
                        height: e(window).height() - 200,
                        header: {
                            left: "prev,next hoy",
                            center: "title",
                            right: "month,agendaWeek,agendaDay"
                        },
                        locale: 'es',
                        events: mydata,
                        editable: !0,
                        droppable: !0,
                        eventLimit: !0,
                        selectable: !0,
                        drop: function(t) {
                            o.onDrop(e(this), t)
                            var id, fecha;
                            id = (e(this)[0].id);
                            fecha = t._d;
                            $.ajax({
                                type: "POST",
                                url: '../ActividadExternaControlador/agregarCalendario',
                                data: { id: id, fecha: fecha },
                                success: function(data){
                                    setTimeout(function() {
                                        window.location.reload();
                                   },0);
                                },
                                    error: function(data){
                                    console.log('Error: '+data);
                                },
                            });
                           
                        },
                        select: function(e, t, n) {
                            o.onSelect(e, t, n)
                        },
                        eventClick: function(e, t, n) {
                            o.onEventClick(e, t, n)
                        }
                    })
                },
                    error: function(data){
                    console.log('Error: '+data);
                },
            });
            
        
        this.$saveCategoryBtn.on("click", function() {
            var nombre = o.$categoryForm.find("input[name='nombre-actividad']").val();
            var tipoActividad = o.$categoryForm.find("select[name='tipo-actividad']").val();
            var fecha = o.$categoryForm.find("input[name='fecha-actividad']").val();
            var hora = o.$categoryForm.find("input[name='hora-actividad']").val();
            var descrip = o.$categoryForm.find("textarea[name='detalle-actividad']").val();
            var estado = 0;
            $.ajax({
                type: "POST",
                url:  root_path +'ActividadExternaControlador/crearActividad',
                data: { nombre: nombre, tipoActividad: tipoActividad, fecha: fecha, hora: hora, descrip: descrip, estado: estado },
                success: function(data){
                    setTimeout(function() {
                        window.location.reload();
                   },0);
                },
                    error: function(data){
                    console.log('Error: '+data);
                },
            });

        })
    }, e.CalendarApp = new t, e.CalendarApp.Constructor = t
}(window.jQuery),
function(e) {
    "use strict";
    e.CalendarApp.init()
}(window.jQuery);
var cita = {
    InitCalendar:function () {
        $('#calendar').fullCalendar({
            //selectable: true,
            //selectHelper: true,
            lang: 'es',
            header    : {
                left  : 'prev,next today',
                center: 'title',
                right : 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week : 'Semana',
                day  : 'Día'
            },
            editable  : true,
            droppable : true, // this allows things to be dropped onto the calendar !!!
            drop      : function (date, allDay) {

            },
            eventClick: function(calEvent, jsEvent, view) {
                var entity = calEvent.entity;
                $('#btneliminar-cita').data('calEvent', calEvent);
                cita.GetCita(entity);
            },
            dayClick: function( date, allDay, jsEvent, view ) {
                cita.createCita(moment(date).format(), allDay)
            },
            eventRender: function(event, element) {
                /*var entity = event.entity;
                element.append( "<span data-toggle='tooltip' title='Eliminar' class='closeon'>&times;</span>" );
                element.find(".closeon").click(function() {
                    cita.DeleteCita(entity.ID_CITA, function () {
                        $('#calendar').fullCalendar('removeEvents',event._id);
                    });
                });*/
            }

            /*select: function( startDate, endDate, allDay, jsEvent, view ){
                console.log('Select: ', startDate);
            }*/
        });
        /*$('#calendar').fullCalendar('renderEvent', {
            title: ' Hola mundo',
            start: new Date(2017, 06, 12)
        }, true)*/
        cita.GetAllToday();
        cita.GetAll();
    },
    InitOnReady: function () {
        cita.InitCalendar();
        $('#btneliminar-cita').on('click', function () {
            var calEvent = $(this).data('calEvent');
            cita.DeleteCita(calEvent.entity.ID_CITA, function () {
                $('#modal-cita').modal('hide');
                $('#calendar').fullCalendar('removeEvents',calEvent._id);
            });
        });
        var cbopaciente = $('#cbopaciente');
        $.ajax({
            url: BasePage.basePath+'/paciente/getAll',
            success: function(response){
                cbopaciente.empty();
                cbopaciente.append($('<option/>',{
                    'value': 0,
                    'text': '<< SELECCIONE UN PACIENTE >>'
                }));
                $.each(response.data, function(i, val){
                    cbopaciente.append($('<option/>',{
                        'value':val.ID_PACIENTE,
                        'text': val.NOMBRE+' '+val.APELLIDOS
                    }));
                });
                cbopaciente.css({'width':'100%'}).select2();
            }
        });
        $('#txtfecha').mask("0000-00-00", {placeholder: "____-__-__"});
        $('#txthorainicio').mask("00:00:00", {placeholder: "__:__:__"});
        $('#txthorafin').mask("00:00:00", {placeholder: "__:__:__"});
        $('#btnguardar-cita').on('click', function () {
            if($('#form-cita').valid()){
                cita.SaveCita();
            }
        });
    },
    GetAllToday: function () {
        $.ajax({
            url: BasePage.StringFormat('{0}/cita/getAllToday', BasePage.basePath),
            success: function (response) {
                var target = $('#external-events');
                $.each(response.data, function (i, e) {
                    var event = $('<div/>', {
                        class: 'external-event '+e.CSS,
                        style: 'cursor: pointer',
                        text: e.HORA_INICIO+' - '+e.HORA_FIN
                    });
                    event.data('entity', e);
                    event.on('click', function () {
                        var entity = $(this).data('entity');
                        cita.GetCita(entity);
                    });
                    target.append(event);
                });
                $('#box-info-label').text(BasePage.StringFormat('Tiene {0} citas el día de hoy.', response.data.length));
            }
        });
    },
    GetAll: function () {
        $.ajax({
            url: BasePage.StringFormat('{0}/cita/getAll', BasePage.basePath),
            success: function (response) {
                $.each(response.data, function (i, e) {
                    $('#calendar').fullCalendar('renderEvent', {
                        title: e.NOMBRE+' '+e.APELLIDOS,
                        start: e.FECHA_CITA+' '+e.HORA_INICIO,
                        end: e.FECHA_CITA+' '+e.HORA_FIN,
                        backgroundColor: e.COLOR,
                        entity: e
                    });
                });
            }
        });
    },
    createCita: function (date, allDay) {
        BasePage.ShowModal({
            name: 'cita',
            title: '<i class=\'fa fa-plus\'></i> Nueva Cita',
            callback: function () {
                $('#btneliminar-cita').attr('disabled', 'disabled');
                $('#txthorainicio').val('');
                $('#txthorafin').val('');
                if(typeof (date)!==typeof (undefined)){
                    $('#txtfecha').attr('readonly','readonly').val(date);
                }else{
                    $('#txtfecha').removeAttr('readonly');
                }
            }
        });
    },
    SaveCita: function () {
        var request = new Object();
        request.id = parseInt($('#txtidcita').val());
        request.idpaciente = $('#cbopaciente').val();
        request.nota = $('#txtdescripcion').val();
        request.fecha = $('#txtfecha').val();
        request.hora_inicio = $('#txthorainicio').val();
        request.hora_fin = $('#txthorafin').val();
        request.estado = $('#cboestado').val();
        $.ajax({
            url: BasePage.StringFormat('{0}/guardarCita', BasePage.requestPath),
            data: request,
            success: function (response) {
                BasePage.Notify(response, function () {
                    $('#modal-cita').modal('hide');
                    if(request.id===0){
                        $('#calendar').fullCalendar('renderEvent', {

                        });
                    }
                });
            }
        });
    },
    GetCita: function (entity) {
        BasePage.ShowModal({
            name: 'cita',
            title: '<i class=\'fa fa-edit\'></i> Editar Cita',
            callback: function () {
                $('#btneliminar-cita').removeAttr('disabled');
                $('#cbopaciente').val(entity.ID_PACIENTE).trigger('change');
                $('#txtdescripcion').val(entity.NOTA);
                $('#txtfecha').val(entity.FECHA_CITA);
                $('#txthorainicio').val(entity.HORA_INICIO);
                $('#txthorafin').val(entity.HORA_FIN);
                $('#cboestado').val(entity.ESTADO);
                $('#txtidcita').val(entity.ID_CITA);
            }
        });
    },
    DeleteCita: function (idcita, fnCallback) {
        BootstrapDialog.confirm({
            title: 'Confirmación',
            message: '¿Desea eliminar este registro?',
            callback: function (result) {
                if(result){
                    $.ajax({
                        url: BasePage.StringFormat('{0}/eliminarCita', BasePage.requestPath),
                        data: { id: idcita },
                        success: function (response) {
                            BasePage.Notify(response, function () {
                                fnCallback();
                            });
                        }
                    });
                }
            }
        });
    }
};
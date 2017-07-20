var cita = {
    InitOnReady: function () {
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
                console.dir(calEvent);
                console.dir(jsEvent);
                console.dir(view);
            },
            dayClick: function( date, allDay, jsEvent, view ) {
                cita.createCita(moment(date).format(), allDay)
            },
            /*select: function( startDate, endDate, allDay, jsEvent, view ){
                console.log('Select: ', startDate);
            }*/
        });
        /*$('#calendar').fullCalendar('renderEvent', {
            title: ' Hola mundo',
            start: new Date(2017, 06, 12)
        }, true)*/
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
    createCita: function (date, allDay) {
        BasePage.ShowModal({
            name: 'cita',
            title: '<i class=\'fa fa-plus\'></i> Nueva Cita',
            callback: function () {
                if(typeof (date)!==typeof (undefined)){
                    $('#txtfecha').attr('readonly','readonly').val(date);
                }else{
                    $('#txtfecha').removeAttr('readonly');
                }
            }
        });
    },
    SaveCita: function () {

    }
};
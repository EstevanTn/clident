var odontograma = {
    InitEventOdontograma: function(){
        $('#odontograma').empty();
        AppOdontograma.Init('#odontograma',{}, function(self){
            self.bind('click', function(){
                var idpaciente = parseInt($('#cbolstpacientes').val());
                if(idpaciente>0){
                    var data = $(this).data('self');
                    BasePage.GetCaraDiente(data);
                }else{
                    BasePage.Notify({
                        success: 'Seleccione',
                        message: 'Primero debe seleccionar un paciente.'
                    });
                }
            }).createContextMenu(function(){
                var menu = $('<ul/>',{ class : 'list-group' });
                var itemCopy = $('<li/>',{ class : 'list-group-item', text: '@Tunaqui - Corpyright © '+new Date().getFullYear() });
                $(menu).append(itemCopy);
                $(this).append(menu);
            });
        }).Load();
    },
    InputEvent: function() {
        var ctrllist = $('#cbolstpacientes');
        $.ajax({
            url: BasePage.basePath+'/paciente/getAll',
            success: function(response){
                ctrllist.empty();
                ctrllist.append($('<option/>',{
                    'value': 0,
                    'text': '<< SELECCIONE UN PACIENTE >>'
                }));
                $.each(response.data, function(i, val){
                    ctrllist.append($('<option/>',{
                        'value':val.ID_PACIENTE,
                        'text': val.NOMBRE+' '+val.APELLIDOS
                    }));
                });
                ctrllist.select2();
            }
        });
        /*
        document.querySelector('input[list]').addEventListener('input', function(e) {
            var input = e.target,
                list = input.getAttribute('list'),
                options = document.querySelectorAll('#' + list + ' option'),
                hiddenInput = document.getElementById(input.id + '-hidden'),
                inputValue = input.value;

            hiddenInput.value = inputValue;

            for(var i = 0; i < options.length; i++) {
                var option = options[i];
                if(option.innerText === inputValue) {
                    hiddenInput.value = option.getAttribute('data-value');
                    break;
                }
            }
        });
        */
    },
    InitOnReady: function(){
        odontograma.InitEventOdontograma();
        odontograma.InputEvent();
        $('#btn-mostrar-odontograma').on('click', function(e) {
            AppOdontograma.Load();
            var id = parseInt($('#cbolstpacientes').val());
            if(id!=0){
                odontograma.Get(id);
            }else{
                BasePage.Notify({
                    type: 'warning',
                    icon: 'fa fa-warning',
                    title: 'Advertencia!',
                    message: 'Seleccione un paciente primero.',
                });
            }
        });
        BasePage.AppUtils.ComboResponse({
            target: '#cbotratamiento',
            action: 'getAll',
            controller: 'tratamiento',
            keys: {
                value: 'ID_TRATAMIENTO',
                text: 'NOMBRE',
                title: 'DESCRIPCION'
            }
        });
        $('#btnGuardarDetalleOdontograma').on('click', function () {
            if($('#form-detalle-odontograma').valid()){
                odontograma.SaveDetalleOdontograma();
            }
        });
        $('#btnagregar-medicacion').on('click', function (e) {
            BasePage.ShowModal({
                name: 'medicacion',
                title: '<i class=\'fa fa-plus\'></i> Nueva Medicación'
            });
        });
        $('#btnguardar-medicacion').on('click', function (e) {
            if($('#form-medicacion').valid()){
                odontograma.SaveMedicacion();
            }
        })
        //Lista medicamentos
        $.ajax({
            url: BasePage.StringFormat('{0}/medicamento/getAll', BasePage.basePath),
            success: function (response) {
                var target = $('#cbomedicamento');
                target.append($('<option/>',{
                    value: '0',
                    text: '<< SELECCIONE >>'
                }));
                $.each(response.data, function (i, v) {
                    target.append($('<option/>',{
                        value: v.ID_MEDICAMENTO,
                        text: v.NOMBRE
                    }));
                });
            }
        });
        //Lista de unidades
        $.ajax({
            url: BasePage.StringFormat('{0}/medicamento/getAllUnidades', BasePage.basePath),
            success: function (response) {
                var target = $('#cbounidadmedida');
                target.append($('<option/>',{
                    value: '0',
                    text: '<< SELECCIONE >>'
                }));
                $.each(response.data, function (i, v) {
                    target.append($('<option/>',{
                        value: v.ID_UNIDAD_MEDIDA,
                        text: v.NOMBRE
                    }));
                });
            }
        });
        $('#cbomedicamento, #cbounidadmedida').css({'width':'100%'}).select2();
    },
    GetCaraDiente: function(data){
        BasePage.ShowModal({
            name: 'detalle-odontograma',
            title: '<i class=\'fa fa-plus\'></i> Agregar detalle',
            callback: function(){
                AppOdontograma
                .createSingle('#diente-draw', data.nro)
                .select(data.cara);
                $('#cbocaradetalle').on('change', function(){
                    $(AppOdontograma.selectClear($(this).val()));
                }).val(data.cara).trigger('change');
                $('#txtnrodetalle').val(data.nro);
            }
        });
    },
    Get: function(id){
        $.ajax({
            url: BasePage.StringFormat('{0}/paciente/get', BasePage.basePath),
            data: { Id: id },
            success: function(response){
                $('#txtnumerodocumento').val(response.NUMERO_DOCUMENTO);
                $('#txtnombreapellidos').val(response.NOMBRE+' '+response.APELLIDOS);
                $('#txtcodigopaciente').val(response.ID_PACIENTE);
                $.ajax({
                    url: BasePage.StringFormat('{0}/odontograma/get', BasePage.basePath),
                    data: { id: response.ID_PACIENTE },
                    success: function (response2) {
                        $('#txtcodigoodontograma').val(response2.ID_ODONTOGRAMA);
                        odontograma.GetDetalleOdontograma(response2.ID_ODONTOGRAMA);
                    }
                });
            }
        });
    },
    GetDetalleOdontograma: function (IdOdontograma) {
        console.info('Cargando detalle de odontograma: N°'+IdOdontograma);
        BasePage.GridSetup({
            name: 'detalle-odontograma',
            columns: [
                { data: 'NUMERO_DIENTE', sWidth: '7%', sClass: 'text-center' },
                { data: function (row, type, set, meta) {
                    var caraText = '-';
                    if(row.CARA_DIENTE==='S'){
                        caraText = 'Superior';
                    }else if(row.CARA_DIENTE==='I'){
                        caraText = 'Inferior';
                    }else if(row.CARA_DIENTE==='Z'){
                        caraText = 'Izquierdo';
                    }else if(row.CARA_DIENTE==='C'){
                        caraText = 'Centro';
                    }else if(row.CARA_DIENTE==='X'){
                        caraText = 'Completo';
                    }else if(row.CARA_DIENTE==='D'){
                        caraText = 'Derecho';
                    }
                    return caraText;
                }, sWidth: '9%' },
                { data: 'NOMBRE', sWidth: '20%' },
                { data: 'DESCRIPCION', sWidth: '36%' },
                { data: 'FECHA_APLICACION', sClass: 'text-center', sWidth: '15%' },
                { data: function (row, type, set, meta) {
                    var html = '<a title=\'Editar\' onclick=\'BasePage.GetItemDetalleOdontograma('+row.ID_DETALLE_ODONTOGRAMA+')\') data-toggle=\'tooltip\' class=\'btn btn-link\'><i class=\'fa fa-edit\'></i></a>';
                    html += '<a title=\'Eliminar\' data-toggle=\'tooltip\' onclick=\'BasePage.Delete('+row.ID_DETALLE_ODONTOGRAMA+')\' class=\'btn btn-link\'><i class=\'fa fa-remove\'></i></a>';
                    html += '<a title=\'Medicación\' data-toggle=\'tooltip\' onclick=\'BasePage.ShowMedicacion('+row.ID_DETALLE_ODONTOGRAMA+')\' class=\'btn btn-link\'><i class=\'fa fa-medkit\'></i></a>';
                    return html;
                }, orderable: false, sWidth: '13%' },
            ],
            ajax: {
                type: 'POST',
                url: BasePage.StringFormat('{0}/odontograma/getAll', BasePage.basePath),
                data: {
                   id: IdOdontograma,
                }
            },
            initComplete: function (settings, data) {
                data = data.data;
                for(var i=0; i<data.length; i++){
                    var item = data[i];
                    AppOdontograma.paintTooth(item.NUMERO_DIENTE, item.CARA_DIENTE, 'red');
                }
            }
        });
    },
    GetItemDetalleOdontograma: function (id_detalle_odontograma) {
        BasePage.ShowModal({
            name: 'detalle-odontograma' ,
            title: '<i class=\'fa fa-edit\'></i> Editar Detalle',
            callback: function () {
                $.ajax({
                    url: BasePage.StringFormat('{0}/getDetalle', BasePage.requestPath),
                    data: { id: id_detalle_odontograma },
                    success: function (response) {
                        AppOdontograma
                            .createSingle('#diente-draw', response.NUMERO_DIENTE)
                            .select(response.CARA_DIENTE);
                        $('#txtiddetalleodontograma').val(response.ID_DETALLE_ODONTOGRAMA);
                        $('#txtnrodetalle').val(response.NUMERO_DIENTE);
                        $('#cbocaradetalle').val(response.CARA_DIENTE).trigger('change');
                        $('#cbotratamiento').val(response.ID_TRATAMIENTO).trigger('change');
                        $('#txtdescripciondetalle').val(response.DESCRIPCION);
                    }
                });
            }
        });
    },
    SaveDetalleOdontograma: function () {
        var request = new Object();
        request.id = $('#txtiddetalleodontograma').val();
        request.id_odontograma = $('#txtcodigoodontograma').val();
        request.numero_diente = $('#txtnrodetalle').val();
        request.cara_diente = $('#cbocaradetalle').val();
        request.id_tratamiento = $('#cbotratamiento').val();
        request.descripcion = $('#txtdescripciondetalle').val();
        request.estado = 1;
        $.ajax({
           url: BasePage.StringFormat('{0}/odontograma/guardarDetalle', BasePage.basePath),
           data: request,
           success: function (response) {
               BasePage.Notify(response, function () {
                   $('#btn-mostrar-odontograma').trigger('click');
                  //$('#datatable-detalle-odontograma').dataTable()._fnAjaxUpdate();
                  $('#modal-detalle-odontograma').modal('hide');
               });
           }
        });
    },
    fnDelete: function (id_detalle_odontograma) {
        $.ajax({
            url: BasePage.StringFormat('{0}/eliminar', BasePage.requestPath) ,
            data: { id: id_detalle_odontograma },
            success: function (response) {
                BasePage.Notify(response, function () {
                    //$('#datatable-detalle-odontograma').dataTable()._fnAjaxUpdate();
                    $('#btn-mostrar-odontograma').trigger('click');
                });
            }
        });
    },
    GetAllMedicacionItemDetalle: function (id_detalle) {
        BasePage.GridSetup({
            name: 'medicacion',
            columns: [
                { data: 'NOMBRE' , sWidth: '22%', },
                { data: 'NOMBRE_MARCA' , sWidth: '20%', },
                { data: function (row, type, set, meta) {
                    var text = typeof (row.DESCRIPCION_MEDICACION) === 'string' && row.DESCRIPCION_MEDICACION.length > 50 ?
                        row.DESCRIPCION_MEDICACION.substring(0,47)+'...' : row.DESCRIPCION_MEDICACION;
                    return text;
                } , sWidth: '50%', },
                { data: function (row, type, set, meta) {
                    var html = '<a onclick="odontograma.GetMedicacion('+row.ID_MEDICACION+')" href="#" data-toggle="tooltip" title="Editar" class="btn btn-link"><i class="fa fa-edit"></i></a>';
                    html += '<a onclick="odontograma.deleteMedicacion('+row.ID_MEDICACION+')" href="#" data-toggle="tooltip" title="Eliminar" class="btn btn-link"><i class="fa fa-remove"></i></a>';
                    return html;
                }, sWidth: '8%', },
            ],
            ajax: {
                url: BasePage.StringFormat('{0}/getAllMedicacion', BasePage.requestPath),
                data: { id_detalle: id_detalle}
            },
        });
    },
    GetMedicacion: function (id_medicacion) {
        BasePage.ShowModal({
            name: 'medicacion',
            title: '<i class=\'fa fa-edit\'></i> Editar Medicación',
            callback: function () {
                $.ajax({
                    url: BasePage.StringFormat('{0}/getMedicacion', BasePage.requestPath),
                    data: { id_medicacion: id_medicacion },
                    success: function (response) {
                        $('#txtidmedicacion').val(response.ID_MEDICACION);
                        $('#cbomedicamento').val(response.ID_MEDICAMENTO).trigger('change');
                        $('#cbotratamiento').val(response.ID_TRATAMIENTO).trigger('change');
                        $('#cbounidadmedida').val(response.ID_UNIDAD_MEDIDA).trigger('change');
                        $('#txtdescripcionmedicacion').val(response.DESCRIPCION_MEDICACION);
                        $('#txtcantidadmedicamento').val(response.CANTIDAD);
                    },
                });
            }
        });
    },
    deleteMedicacion: function (id_medicacion) {
        BootstrapDialog.confirm({
           title: 'Confirmación',
            message: '¿Deseas eliminar este registro?',
            callback: function (result) {
                if(result){
                    $.ajax({
                        url: BasePage.StringFormat('{0}/eliminarMedicacion', BasePage.requestPath),
                        data: { id_medicacion: id_medicacion },
                        success: function (response) {
                            BasePage.Notify(response, function () {
                                $('#datatable-medicacion').dataTable()._fnAjaxUpdate();
                            });
                        }
                    });
                }
            }
        });
    },
    SaveMedicacion: function () {
        var request = new Object();
        request.id = $('#txtidmedicacion').val();
        request.id_medicamento = $('#cbomedicamento').val();
        request.id_detalle = $('#txtiddetalleodontograma').val();
        request.id_unidad_medida = $('#cbounidadmedida').val();
        request.cantidad = $('#txtcantidadmedicamento').val();
        request.descripcion = $('#txtdescripcionmedicacion').val();
        $.ajax({
            url: BasePage.StringFormat('{0}/odontograma/guardarMedicacion', BasePage.basePath),
            data: request,
            success: function (response) {
                BasePage.Notify(response, function () {
                    $('#datatable-medicacion').dataTable()._fnAjaxUpdate();
                    $('#modal-medicacion').modal('hide');
                });
            }
        });
    },
    ShowMedicacion: function (id_detalle) {
        $('#txtiddetalleodontograma').val(id_detalle);
        BasePage.ShowModal({
            name: 'detalle-medicacion',
            title: '<i class="fa fa-list"></i> Detalle de Medicación',
            callback: function () {
                odontograma.GetAllMedicacionItemDetalle(id_detalle);
            }
        });
    }
};
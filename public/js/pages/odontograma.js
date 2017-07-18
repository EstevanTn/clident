var odontograma = {
    InitEventOdontograma: function(){
        $('#odontograma').empty();
        AppOdontograma.Init('#odontograma',{}, function(self){
            self.bind('click', function(){
                var data = $(this).data('self');
                BasePage.GetCaraDiente(data);
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
        $('[data-widget=\'fullscreen\']').on('click', function(e) {
            var isfull = $(this).attr('data-fullscreen');
            if(typeof(isfull) !== 'undefined' && isfull==='true'){
                $('#container-odontograma').css({'overflow': 'hidden'});
                BasePage.AppUtils.CancelFullScreen();
                $(this).attr('data-fullscreen', false).html('<i class=\'fa fa-expand\'></i>');
            }else{
                $('#container-odontograma').css({'overflow': 'auto'});
                BasePage.AppUtils.FullScreen('container-odontograma');
                $(this).attr('data-fullscreen', true).html('<i class=\'fa fa-compress\'></i>');
            }
        });
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
                { data: 'NUMERO_DIENTE', },
                { data: 'NOMBRE', },
                { data: 'DESCRIPCION', },
                { data: 'FECHA_APLICACION', sClass: 'text-center' },
                { data: function (row, type, set, meta) {
                    return '';
                }, orderable: false },
            ],
            ajax: {
                type: 'POST',
                url: BasePage.StringFormat('{0}/odontograma/getAll', BasePage.basePath),
                data: {
                   id: IdOdontograma,
                }
            }
        });
    },
    SaveDetalleOdontograma: function () {
        
    }
};
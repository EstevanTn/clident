var odontograma = {
    InitEventOdontograma: function(){
        $('#odontograma').empty();
        AppOdontograma.Init('#odontograma').bind('click', function(){
            var data = $(this).data('self');
            BasePage.GetCaraDiente(data);
        }).createContextMenu(function(){
            var menu = $('<ul/>',{ class : 'list-group' });
            var itemCopy = $('<li/>',{ class : 'list-group-item', text: '@Tunaqui - Corpyright © '+new Date().getFullYear() });
            $(menu).append(itemCopy);
            $(this).append(menu);
        });
    },
    InputEvent: function() {
        var ctrllist = $('#lstpaciente');
        $.ajax({
            url: BasePage.basePath+'/paciente/getAll',
            success: function(response){
                ctrllist.empty();
                $.each(response.data, function(i, val){
                    ctrllist.append($('<option/>',{
                        'data-value':val.ID_PACIENTE,
                        'text': val.NOMBRE+' '+val.APELLIDOS
                    }));
                });
            }
        });
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
    },
    InitOnReady: function(){
        odontograma.InitEventOdontograma();
        odontograma.InputEvent();
        $('[data-widget=\'fullscreen\']').on('click', function(e) {
            var isfull = $(this).attr('data-fullscreen');
            if(typeof(isfull) !== 'undefined' && isfull==='true'){
                BasePage.AppUtils.CancelFullScreen();
                $(this).attr('data-fullscreen', false).html('<i class=\'fa fa-expand\'></i>');
            }else{
                BasePage.AppUtils.FullScreen('container-odontograma');
                $(this).attr('data-fullscreen', true).html('<i class=\'fa fa-compress\'></i>');
            }
        });
        $('#btn-limpiar-paciente').on('click', function(e){
            $('#txtbuscarpaciente').val('').focus();
        });
        $('#btn-mostrar-odontograma').on('click', function(e) {
            odontograma.InitEventOdontograma();
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
    }
};
var odontograma = {
    InitEventOdontograma: function(){
        AppOdontograma.Init('#odontograma').bind('click', function(){
            var data = $(this).data('self');
            BasePage.GetCaraDiente(data);
        }).createContextMenu(function(){
            var menu = $('<ul/>',{ class : 'list-group' });
            var itemCopy = $('<li/>',{ class : 'list-group-item', text: '@Tunaqui - Corpyright © '+new Date().getFullYear() });
            $(menu).append(itemCopy);
            $(this).append(menu);
        });
        console.log(AppOdontograma);
    },
    InitOnReady: function(){
        odontograma.InitEventOdontograma();
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
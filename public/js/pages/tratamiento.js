var tratamiento = {
    columns: [
        { data: 'NOMBRE', sWidth: '30%' },
        { data: 'DESCRIPCION', sWidth: '40%' },
        { data: function(row, type, set, meta) {
                return row.APLICA_CARA === '1' ? '<i class=\'fa fa-check text-success\'></i>' : '<i class=\'fa fa-remove text-danger\'></i>';
            }, sWidth: '5%', sClass: 'text-center' },
        { data: function (row, type, set, meta) {
                return row.APLICA_DIENTE === '1' ? '<i class=\'fa fa-check text-success\'></i>' : '<i class=\'fa fa-remove text-danger\'></i>';
            }, sWidth: '5%', sClass: 'text-center' 
        },
        { data: 'PRECIO', sWidth: '10%', sClass: 'text-center' },
        { data: function (row, type, set, meta) {
            var html = '<a class=\'btn btn-link\' title=\'Editar\'><i class=\'fa fa-edit \' onclick=\'BasePage.Get('+row.ID_TRATAMIENTO+')\'></i></a>';
            html += '<a class=\'btn btn-link\' title=\'Eliminar\'><i class=\'fa fa-remove\' onclick=\'BasePage.Delete('+row.ID_TRATAMIENTO+')\'></i></a>';
            return html;
        }, sWidth: '8%', orderable: false }
    ],
    InitOnReady: function () {
        BasePage.GridSetup({
            name: 'tratamiento',
            columns: tratamiento.columns,
            ajax: {
                type: 'POST',
                data: {},
                url: BasePage.StringFormat('{0}/tratamiento/getAll', BasePage.basePath),
            },
        });
        $('#btnagregar-tratamiento').bind('click', function(e){
            BasePage.ShowModal({
                title: '<i class=\'fa fa-plus\'></i> Nuevo tratamiento',
                name: 'tratamiento',
                callback: function (o) {
                    BasePage.AppUtils.Checked('#chkaplica-cara', 0);
                    BasePage.AppUtils.Checked('#chkaplica-diente', 0);
                }
            });
        });
        $('[data-role=\'bstSwitch\']').bootstrapSwitch({
            size: 'normal',
            onText: 'SI',
            offText: 'NO'
        });
        $('#btnguardar-tratamiento').on('click', function (e) {
            if($('#form-tratamiento').valid()){
                tratamiento.Save();
            }
        });
    },
    Get: function (id) {
        var url = BasePage.StringFormat('{0}/tratamiento/{1}', BasePage.basePath, 'get');
        BasePage.ShowModal({
           name: 'tratamiento', 
            title: '<i class=\'fa fa-edit\'></i> Editar tratamiento',
            callback: function (o) {
                $.ajax({
                    url: url,
                    data: {
                        id: id,
                    }, success: function (response) {
                        $('#txtidtratamiento').val(response.ID_TRATAMIENTO);
                        $('#txtnombre').val(response.NOMBRE);
                        $('#txtdescripcion').val(response.DESCRIPCION);
                        $('#txtprecio').val(response.PRECIO);
                        BasePage.AppUtils.Checked('#chkaplica-cara', response.APLICA_CARA);
                        BasePage.AppUtils.Checked('#chkaplica-diente', response.APLICA_DIENTE);
                    }
                })
            }
        });
    },
    fnDelete: function (id) {
        $.ajax({
           url: BasePage.StringFormat('{0}/tratamiento/eliminar', BasePage.basePath),
            data: { id: id },
            success: function (response) {
               BasePage.Notify(response, function () {
                   $('#datatable-tratamiento').dataTable()._fnAjaxUpdate();
               });
            }
        });
    },
    Save: function () {
        var request = new Object();
        request.id = $('#txtidtratamiento').val();
        request.nombre = $('#txtnombre').val();
        request.descripcion = $('#txtdescripcion').val();
        request.precio = parseFloat($('#txtprecio').val());
        request.aplicaCara = $('#chkaplica-cara').prop('checked')?1:0;
        request.aplicaDiente = $('#chkaplica-diente').prop('checked')?1:0;
        $.ajax({
           url: BasePage.StringFormat('{0}/tratamiento/guardar', BasePage.basePath) ,
            data: request,
            success: function (response) {
                BasePage.Notify(response, function () {
                    $('#datatable-tratamiento').dataTable()._fnAjaxUpdate();
                    $('#modal-tratamiento').modal('hide');
                })
            }
        });
    },
    
};
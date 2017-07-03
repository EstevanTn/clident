var tratamiento = {
    columns: [
        { data: 'NOMBRE', sWidth: '30%' },
        { data: 'DESCRIPCION', sWidth: '40%' },
        { data: function(row, type, set, meta) {
                return row.APLICA_CARA === '1' ? '<i class=\'fa fa-check\'></i>' : '<i class=\'fa fa-remove\'></i>';
            }, sWidth: '5%', sClass: 'text-center' },
        { data: function (row, type, set, meta) {
                return row.APLICA_DIENTE === '1' ? '<i class=\'fa fa-check\'></i>' : '<i class=\'fa fa-remove\'></i>';
            }, sWidth: '5%', sClass: 'text-center' 
        },
        { data: 'PRECIO', sWidth: '10%', sClass: 'text-center' },
        { data: function (row, type, set, meta) {
            var html = '<a class=\'btn btn-link\' title=\'Editar\'><i class=\'fa fa-edit\' onclick=\'BasePage.Get('+row.ID_TRATAMIENTO+')\'></i></a>';
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
                name: 'tratamiento'
            });
        });
        $('[data-role=\'bstSwitch\']').bootstrapSwitch({
            size: 'normal',
            onText: 'SI',
            offText: 'NO'
        });
    },
    Get: function (id) {
        
    },
    fnDelete: function (id) {
        
    }
};
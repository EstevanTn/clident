var tipo = {
    InitGrid: function(){
        BasePage.GridSetup({
            name: 'tipo',
            ajax:{
                url: this.StringFormat('{0}/getAllKeyGrupo', this.requestPath),
                type: 'POST',
                data:{
                    id: $('#cbotipogrupo').val()
                }
            },
            columns:[
                { data : 'NOMBRE', sWidth: '60%' },
                { data : 'SIGLA', sWidth:'10%' },
                { data : 'VALOR', sClass: 'text-center', sWidth:'20%' },
                {
                    data : function(row, type, set, meta){
                        var html = '<a href=\'#\' onclick=\'BasePage.GetTipo('+row.ID_TIPO+')\' tile=\'Editar\' data-toggle=\'tooltip\' class=\'btn btn-link btn-sm btn-flat\'><i class=\'fa fa-edit\'></i></a>';
                        html += '<a href=\'#\' onclick=\'BasePage.DeleteTipo('+row.ID_TIPO+')\' tile=\'Eliminar\' data-toggle=\'tooltip\' class=\'btn btn-link btn-sm btn-flat\'><i class=\'fa fa-remove\'></i></a>';
                        return html;
                    } , sClass: 'text-center btn-group', sWidth: '10%', orderable: false
                },
            ]
        });
    },
    GetAllGrupos: function(){
        this.AppUtils.ComboResponse({
            controller: 'tipo',
            action: 'getAllGrupo',
            target: '#cbotipogrupo',
            keys: {
                value: 'ID_GRUPO',
                text: 'NOMBRE_GRUPO',
                title: 'DESCRIPCION_GRUPO'
            }
        });
    },
    InitOnReady: function(){
        this.GetAllGrupos();
        $('#btn-agregar-grupo').on('click', function(){
            BasePage.ShowModal({
                name: 'tipo-grupo',
                title: '<i class=\'fa fa-plus\'></i> Nuevo Grupo',
            });
        });
        $('#btn-agregar-tipo').on('click', function(){
            BasePage.ShowModal({
                name: 'tipo',
                title: '<i class=\'fa fa-plus\'></i> Nuevo Tipo',
            });
        });
        $('#cbotipogrupo').on('change', function(){
            var value = parseInt(this.value);
            if(value>0){
                $('#btn-agregar-tipo,#btn-editar-grupo,#btn-eliminar-grupo').removeAttr('disabled');
                BasePage.InitGrid();
            }else{
                $('#btn-agregar-tipo,#btn-editar-grupo,#btn-eliminar-grupo').attr('disabled', 'disabled');
            }
        });

        $('#btn-guardar-grupo').on('click', function(){
            if($('#form-tipo-grupo').valid()){
                BasePage.SaveGrupo();
            }
        });
        $('#btn-guardar-tipo').on('click', function(){
            if($('#form-tipo').valid()){
                BasePage.SaveTipo();
            }
        });
    },
    SaveGrupo: function(){
        $.ajax({
            url: this.StringFormat('{0}/guardarGrupo', this.requestPath),
            data:{
                id: $('#txtidgrupo').val(),
                nombre: $('#txtnombregrupo').val(),
                descripcion: $('#txtdescripciongrupo').val(),
            },
            success: function(response){
                BasePage.Notify(response, function(){
                    $('#btn-editar-grupo, #btn-eliminar-grupo').attr('disabled','disabled');
                    BasePage.GetAllGrupos();
                    $('#modal-tipo-grupo').modal('hide');
                });
            }
        });
    },
    SaveTipo: function(){
        $.ajax({
            url: this.StringFormat('{0}/guardarTipo', this.requestPath),
            data:{
                id: $('#txtidtipo').val(),
                idgrupo: $('#cbotipogrupo').val(),
                nombre: $('#txtnombretipo').val(),
                valor: $('#txtvalortipo').val(),
                sigla: $('#txtsiglatipo').val(),
            },
            success: function(response){
                BasePage.Notify(response, function(){
                    $('#datatable-tipo').dataTable()._fnAjaxUpdate();
                    $('#modal-tipo').modal('hide');
                });
            }
        });
    },
    GetTipo:function(id){
        BasePage.ShowModal({
            name: 'tipo',
            title: '<i class=\'fa fa-plus\'></i> Editar tipo',
            callback: function(){
                $.ajax({
                    url: BasePage.StringFormat('{0}/getTipo', BasePage.requestPath),
                    data:{ id : id },
                    success: function(response){
                        $('#txtidtipo').val(response.ID_TIPO);
                        $('#txtnombretipo').val(response.NOMBRE);
                        $('#txtvalortipo').val(response.VALOR);
                        $('#txtsiglatipo').val(response.SIGLA);
                    }
                });
            }
        });
    },
    DeleteTipo: function (id){
        BootstrapDialog.confirm({
            title: 'Confirmación',
            message: '¿Desea eliminar este registro?',
            callback: function(result){
                if(result){
                    $.ajax({
                    url: BasePage.StringFormat('{0}/eliminar', BasePage.requestPath),
                    data: { id : id },
                    success: function(response){
                        BasePage.Notify(response, function(){
                            $('#datatable-tipo').dataTable()._fnAjaxUpdate();
                        });
                    }
                });
                }
            }
        });
    },
    GetGrupo:function(){
        BasePage.ShowModal({
            name: 'tipo-grupo',
            title: '<i class=\'fa fa-plus\'></i> Editar Grupo',
            callback: function(){
                var item = $('#cbotipogrupo option:selected');
                $('#txtidgrupo').val(parseInt(item.val()));
                $('#txtnombregrupo').val(item.text());
                $('#txtdescripciongrupo').val(item.attr('title'));
            }
        });
    },
    DeleteGrupo:function(){

    },
};

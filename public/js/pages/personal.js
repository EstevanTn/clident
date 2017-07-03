var personal = {
    InitGrid: function(url, d){
      this.GridSetup({
        name: 'personal',
        ajax: {
          url:  url,
          type: 'POST',
          data: d,
        },
        columns:[
          { data: 'NUMERO_DOCUMENTO', sWidth: '10%', sClass:'text-center' },
          { data: 'NOMBRE', sWidth: '30%', },
          { data: 'APELLIDOS', sWidth: '30%', },
          { data: 'DIRECCION', sWidth: '10%', },
          { data: 'EMAIL', sWidth: '10%', },
          { data: function(row, type, set, meta){
            var html = '<a onclick=\'BasePage.Get('+row.ID_PERSONAL+');\' class=\'btn btn-link\' data-toggle=\'tooltip\' title=\'Editar\'><i class=\'fa fa-edit\'></i></a>';
            html += '<a onclick=\'BasePage.Delete('+row.ID_PERSONAL+');\' class=\'btn btn-link\' data-toggle=\'tooltip\' title=\'Eliminar\'><i class=\'fa fa-remove\'></i></a>';
            return html;
          }, orderable: false, sClass: 'text-center'
          },
        ]
      });
    },
    InitOnReady: function(){
      var url = this.StringFormat('{0}/{1}',this.requestPath, 'getAll');
      this.InitGrid.call(this, url,{});
        BasePage.AppUtils.ComboResponse({
            target: '#cbotipopersonal,#cbotipopersonal-buscar',
            controller: 'tipo',
            action: 'getAllNombreGrupo',
            data: { nombre: 'TIPO PERSONAL' },
            keys: {
                value: 'ID_TIPO',
                text: 'NOMBRE',
                title: 'SIGLA'
            }
        });
        BasePage.AppUtils.ComboResponse({
            target: '#cboarea,#cboarea-buscar',
            controller: 'area',
            action: 'getAll',
            keys: {
                value: 'ID_AREA',
                text: 'NOMBRE',
                title: 'DESCRIPCION'
            }
        });
        BasePage.AppUtils.ComboResponse({
          target: '#cbotipodocumento',
          controller: 'tipo',
          action: 'getAllNombreGrupo',
          data: { nombre: 'TIPO DOCUMENTO' },
          keys: {
            value: 'ID_TIPO',
            text: 'SIGLA',
            title: 'NOMBRE',
            'data-max': 'VALOR'
          }
        });
        $('#cbotipodocumento').on('change', function(){
          var len = $('#cbotipodocumento option:selected').attr('data-max');
          $('#txtnumerodocumento').attr('maxlength', len);
        });
        $('#btn-agregar-personal').bind('click', function(){
          BasePage.ShowModal({
            name: 'personal',
            title: '<i class=\'fa fa-plus\'></i> Nuevo personal'
          });
        });
        $('#btn-guardar-personal').bind('click', function(){
          if ($('#form-personal').valid()) {
            BasePage.Save();
          }
        });
        $('[data-mask]').mask("0000-00-00", {placeholder: "____-__-__"});
        $('#btnbuscar-personal').bind('click', function(){
          BasePage.Search();
        });
    },
    Save: function(){
      var request = new Object();
      request.id = $('#txtidpersonal').val();
      request.idpersona = $('#txtidpersona').val();
      request.tipodocumento = $('#cbotipodocumento').val();
      request.nombre = $('#txtnombre').val();
      request.apellidos = $('#txtapellidos').val();
      request.numerodocumento = $('#txtnumerodocumento').val();
      request.idarea = $('#cboarea').val();
      request.direccion = $('#txtdireccion').val();
      request.email = $('#txtemail').val();
      request.tipoperonal = $('#cbotipopersonal').val();
      request.cargo = $('#txtcargo').val();
      request.especialidad = $('#txtespecialidad').val();
      request.celular = $('#txtcelular').val();
      request.telefono = $('#txttelefono').val();
      request.fechaingreso = $('#txtfechaingreso').val();
      request.fechanacimiento = $('#txtfechanacimiento').val();
      request.fechacontrato_inicio = $('#txtfechacontrato1').val();
      request.fechacontrato_fin = $('#txtfechacontrato2').val();
      var url = BasePage.StringFormat('{0}/guardar', BasePage.requestPath);
      $.ajax({
        url:  url,
        data: request,
        success: function(response){
          BasePage.Notify(response, function(){
            $('#modal-personal').modal('hide');
            $('#datatable-personal').dataTable()._fnAjaxUpdate();
          });
        }
      });
    },
    Get: function(id){
      BasePage.ShowModal({
        name: 'personal',
        title: '<i class=\'fa fa-edit\'></i> Editar personal',
        callback: function(){
          $.ajax({
            url: BasePage.StringFormat('{0}/get', BasePage.requestPath),
            data: { id: id },
            success: function(response){
              $('#cbotipodocumento').val(response.TIPO_DOCUMENTO).trigger('change');
              $('#cboarea').val(response.ID_AREA).trigger('change');
              $('#cbotipopersonal').val(response.TIPO_PERSONAL).trigger('change');
              $('#txtnombre').val(response.NOMBRE);
              $('#txtnombre').val(response.NOMBRE);
              $('#txtapellidos').val(response.APELLIDOS);
              $('#txtdireccion').val(response.DIRECCION);
              $('#txtemail').val(response.EMAIL);
              $('#txtcargo').val(response.CARGO);
              $('#txtespecialidad').val(response.ESPECIALIDAD);
              $('#txtfechaingreso').val(response.FECHA_INGRESO);
              $('#txtfechanacimiento').val(response.FECHA_NACIMIENTO);
              $('#txtfechacontrato1').val(response.FECHA_CONTRATO_INICIO);
              $('#txtfechacontrato2').val(response.FECHA_CONTRATO_FIN);
              $('#txtidpersona').val(response.ID_PERSONA);
              $('#txtidpersonal').val(response.ID_PERSONAL);
              $('#txtnumerodocumento').val(response.NUMERO_DOCUMENTO);
            }
          });
        }
      });
    },
    fnDelete: function(id){
      $.ajax({
        url: BasePage.StringFormat('{0}/eliminar', BasePage.requestPath),
        data: { id: id },
        success: function(response){
          BasePage.Notify(response, function(){
            $('#modal-personal').modal('hide');
            $('#datatable-personal').dataTable()._fnAjaxUpdate();
          });
        }
      });
    },
    Search: function(){
      var url = this.StringFormat('{0}/{1}',this.requestPath, 'search');
      this.InitGrid.call(this, url,{
        nombre: $('#txtnombre-buscar').val(),
        idarea: $('#cboarea-buscar').val(),
        tipoperonal: $('#cbotipopersonal-buscar').val(),
      });
    }
};

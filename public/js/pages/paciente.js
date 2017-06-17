var paciente = {
  Columns: [
        { data : 'NUMERO_DOCUMENTO', sWidth: '10%', sClass:'text-center'},
        { data : 'NOMBRE', sWidth: '30%'},
        { data : 'APELLIDOS', sWidth: '30%'},
        { data : 'DIRECCION', sWidth: '20%'},
        { data : function(row, type, set, meta){
            var html = '<a class=\'btn btn-link btn-sm\' href=\'#\' onclick=\'BasePage.Get('+row.ID_PACIENTE+')\' data-toggle=\'tooltip\' title=\'Editar\'><i class="fa fa-edit"></i></a>';
            html += '<a class=\'btn btn-link btn-sm\' href=\'#\' onclick=\'BasePage.Delete('+row.ID_PACIENTE+')\' data-toggle=\'tooltip\' title=\'Editar\'><i class="fa fa-remove"></i></a>';
            return html;
          }, sWidth: '10%', sClass:'text-center'
        }
      ],
  InitOnReady: function(){
    $('[data-mask]').mask("0000-00-00", {placeholder: "____-__-__"});
    BasePage.Validate({
      rules:{
        txtdni:{
          required: true,
          digits: true
        },
        txtnombre:{
          required: true,
          letras: true
        },
        txtapellidos:{
          required: true,
          letras: true
        },
        txtemail: {
          email: true
        },
        txtfechanacimiento: {
          required: true,
        },
        cbotipodocumento:  {
          min: 1
        }
      }
    });
    this.GridSetup({
      ajax:{
        url: this.StringFormat('{0}/getAll', this.requestPath),
        type: 'POST'
      },
      columns: paciente.Columns,
    });
    $('#btn-guardar-paciente').on('click', function(){
      if($('#form-paciente').valid()){
        BasePage.Save();
      }
    });
    $('#btn-agregar-paciente').on('click', function(){
      $('#txtidpersona').val(0);
      BasePage.ShowModal({
        title: BasePage.StringFormat('<i class=\'fa fa-plus\'></i> Nuevo paciente'),
      });
    });
    BasePage.AppUtils.ComboResponse({
      controller: 'tipo',
      action: 'getAllNombreGrupo',
      target: '#cbotipodocumento',
      data: { nombre: 'TIPO DOCUMENTO' },
      keys: {
        value: 'ID_TIPO',
        text: 'SIGLA',
        title: 'NOMBRE',
        'data-len': 'VALOR'
      },
      callback: function(target, items){
        target.on('change', function(e){
          $('#txtdni').attr('maxlength',$('#cbotipodocumento option:selected').attr('data-len'));
        })
      }
    });

    $('#btn-buscar-paciente').on('click', function(){
      BasePage.GridSetup({
        ajax:{
          url: BasePage.StringFormat('{0}/search', BasePage.requestPath),
          type: 'POST',
          data: { q: $('#txtBuscar').val() },
          error: function(xhr){
            console.log(xhr.responseText);
          }
        },
        columns: paciente.Columns,
      });
    });
    $('#btn-limpiar').on('click', function(){
      $('#txtBuscar').val('').focus();
    });

  },
  Save: function(){
    var url = this.StringFormat('{0}/{1}', this.requestPath, 'guardar');
    var request = new Object();
    request.ID_PERSONA = $('#txtidpersona').val();
    request.ID_PACIENTE = $('#txtidpaciente').val();
    request.NUMERO_DOCUMENTO = $('#txtdni').val();
    request.TIPO_DOCUMENTO = $('#cbotipodocumento').val();
    request.NOMBRE = $('#txtnombre').val();
    request.APELLIDOS = $('#txtapellidos').val();
    request.EMAIL = $('#txtemail').val();
    request.FECHA_NACIMIENTO = $('#txtfechanacimiento').val();
    request.DIRECCION = $('#txtdireccion').val();
    request.CELULAR = $('#txtcelular').val();
    request.TELEFONO = $('#txttelefono').val();
    $.ajax({
      url: url,
      data: request,
      success: function(response){
        BasePage.Notify(response, function(){
          $('#modal-paciente').modal('hide');
          $('#datatable-paciente').dataTable()._fnAjaxUpdate();
        });
      }
    });
  },
  Get: function(ID_PACIENTE){
    var context = this;
    BasePage.ShowModal({
      title: '<i class="fa fa-edit"></i> Editar paciente',
      callback: function(){
        $.ajax({
          url: context.StringFormat('{0}/get', context.requestPath),
          data: { Id: ID_PACIENTE },
          success: function(response){
            $('#cbotipodocumento').val(response.TIPO_DOCUMENTO).trigger('change');
            $('#txtidpersona').val(response.ID_PERSONA);
            $('#txtidpaciente').val(response.ID_PACIENTE);
            $('#txtdni').val(response.NUMERO_DOCUMENTO);
            $('#txtnombre').val(response.NOMBRE);
            $('#txtapellidos').val(response.APELLIDOS);
            $('#txtdireccion').val(response.DIRECCION);
            $('#txttelefono').val(response.TELEFONO);
            $('#txtcelular').val(response.CELULAR);
            $('#txtemail').val(response.EMAIL);
            $('#txtfechanacimiento').val(response.FECHA_NACIMIENTO);
          }
        });
      }
    });
  },
  fnDelete: function(ID_PACIENTE){
    $.ajax({
      url: this.StringFormat('{0}/delete', this.requestPath),
      data: { Id: ID_PACIENTE },
      success: function(response){;
        BasePage.Notify(response, function(){
					$('#datatable-paciente').dataTable()._fnAjaxUpdate();
				});
      }
    });
  }
};

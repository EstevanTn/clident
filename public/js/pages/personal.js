var personal = {
    InitGrid: function(){
      this.GridSetup({
        name: 'personal',
        type: 'POST',
        ajax: {
          url:  this.StringFormat('{0}/{1}',this.requestPath, 'getAll'),
        },
        columns:[
          { data: 'ID_PERSONAL', sWidth: '10%', sClass:'text-center' },
          { data: 'NOMBRE', sWidth: '30%', },
          { data: 'APELLIDOS', sWidth: '30%', },
          { data: 'DIRECCION', sWidth: '10%', },
          { data: 'EMAIL', sWidth: '10%', },
          { data: function(row, type, set, meta){
            return '';
          }, orderable: false
          },
        ]
      });
    },
    InitOnReady: function(){
      this.InitGrid.call(this);
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
    },
    Save: function(){
      var request = new Object();
      request.id = $('#txtidpersonal').val();
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
        success: function(response){
          console.log(response);
        }
      });
    }
};

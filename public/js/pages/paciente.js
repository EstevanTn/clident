var paciente = {
  InitOnReady: function(){
    BasePage.Validate({
      rules:{
        txtdni:{
          required: true,
        },
        txtnombre:{
          required: true,
        },
        txtapellidos:{
          required: true,
        },
        txtfechanacimiento: {
          required: true,
        }
      }
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
  },
  Save: function(){
    var url = this.StringFormat('{0}/{1}', this.requestPath, 'guardar');
    var request = new Object();
    request.id = $('#txtidpersona').val();
    request.dni = $('#txtdni').val();
    request.nombres = $('#txtnombre').val();
    request.apellidos = $('#txtapellidos').val();
    request.email = $('#txtemail').val();
    request.fecha = $('#txtfechanacimiento').val();
    request.direccion = $('#txtdireccion').val();
    $.ajax({
      url: url,
      data: request,
      success: function(response){
        console.log(response);
      }
    });
  },
};

var area = {
	InitOnReady: function(){
		this.Validate({
			rules: {
				txtnombre:{
					required: true,
					letras: true,
				}
			}
		});
		this.GridSetup({
			ajax: {
				url: this.StringFormat('{0}/getAll', this.requestPath),
				type: 'POST',
			},
			columns: [
				{ data: 'NOMBRE', sWidth: '40%' },
				{ data: 'DESCRIPCION', sWidth: '52%' },
				{ data: function(row, type, set, meta){
					var html = '<a class=\'btn btn-link btn-sm\' onclick=\'BasePage.Get('+row.ID_AREA+')\' data-toggle=\'tooltip\' title=\'Editar\'><i class=\'fa fa-edit\'></i></a>';
					html += '<a class=\'btn btn-link btn-sm\' onclick=\'BasePage.Delete('+row.ID_AREA+')\' data-toggle=\'tooltip\' title=\'Eliminar\'><i class=\'fa fa-remove\'></i></a>';
					return html;
				}, sWidth: '8%', sClass:'btn-group' }
			]
		});
		$('#btn-agregar-area').on('click', function(){
			$('#txtidarea').val(0);
			BasePage.ShowModal({
				title: '<i class=\'fa fa-plus\'></i> Nueva área', 
			});
		});
		$('#btn-guardar-area').on('click', function(){
			if ($('#form-area').valid()) {
				BasePage.Save();
			}
		});
	},
	Save: function(){
		var request = new Object();
		request.ID_AREA = $('#txtidarea').val();
		request.ID_PARENT_AREA = $('#cboArea').val();
		request.NOMBRE = $('#txtnombre').val();
		request.DESCRIPCION = $('#txtdescripcion').val();
		$.ajax({
			url: this.StringFormat('{0}/guardar', this.requestPath),
			data: request,
			success: function(data){
				BasePage.Notify(data, function(){
					$('#modal-area').modal('hide');
					$('#datatable-area').dataTable()._fnAjaxUpdate();
				});
			}
		});
	},
	Get: function(ID_AREA){
		BasePage.ShowModal({
			title: '<i class=\'fa fa-edit\'></i> Editar área', 
			callback: function(){

			}
		});
	},
	Delete: function(ID_AREA){
		BootstrapDialog.confirm({
			title: 'Confirmación',
			message: '¿Desea eliminar este registro?',
			callback: function(result){
				if (result) {

				}
			}
		});
	},
};
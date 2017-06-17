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
		this.GetAreas();
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
			],
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
	GetAreas: function(){
		$.ajax({
			url: this.StringFormat('{0}/getAll', this.requestPath),
			type: 'POST',
			success: function(response){
				$('#cboArea').empty();
				$('#cboArea').append($('<option/>',{
					value: 0,
					text: '<< SELECCIONE >>'
				}));
				$(response.data).each(function(index, e){
					$('#cboArea').append($('<option/>',{
						value: e.ID_AREA,
						text: e.NOMBRE
					}));
				});
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
			success: function(response){
				BasePage.Notify(response, function(){
					$('#modal-area').modal('hide');
					$('#datatable-area').dataTable()._fnAjaxUpdate();
					area.GetAreas();
				});
			}
		});
	},
	Get: function(ID_AREA){
		var url = this.StringFormat('{0}/get', this.requestPath);
		BasePage.ShowModal({
			title: '<i class=\'fa fa-edit\'></i> Editar área', 
			callback: function(){
				$.ajax({
					url: url,
					data: { ID_AREA: ID_AREA },
					success: function(response){
						$('#txtidarea').val(response.ID_AREA);
						$('#txtnombre').val(response.NOMBRE);
						$('#txtdescripcion').val(response.DESCRIPCION);
						$('#cboArea').val(response.ID_PARENT_AREA?response.ID_PARENT_AREA:0).trigger('change');
					}
				});
			}
		});
	},
	fnDelete: function(ID_AREA){
		var url = this.StringFormat('{0}/delete', this.requestPath);
		$.ajax({
			url: url,
			data: { ID_AREA: ID_AREA },
			success: function(response){
				BasePage.Notify(response, function(){
					$('#datatable-area').dataTable()._fnAjaxUpdate();
				});
			}
		});
	},
};
var AppOdontograma = function(selectorId, options){
	var self = this;
	self.jQuery = jQuery;
	self.options = $.extend(true, {}, self.aoOptions, options);
	self.selector = selectorId;
	self.container = $(self.selector);
	var vm = self.fn.ViewModel.bind(self);
	var dm = self.fn.DienteModel.bind(self);
	self.vm = new vm(dm);
	self.storage = new Array();
	AppOdontograma = self;
}

AppOdontograma.prototype.handlers = {
	mouseenter: function(e, self){
		var me = $(this);
		me.data('oldFill', me.attr('fill'));
		me.attr('fill', self.context.options.colors.focus);
	},
	mouseleave: function(e, self){
		var me = $(this);
		me.attr('fill', me.data('oldFill'));
	},
}

AppOdontograma.prototype.aoOptions = {
	defaultPolygon: { fill: 'white', stroke: 'black', strokeWidth: 0.5 },
	defaultText: { fill: 'black', stroke: 'black', strokeWidth: 0.1, style: 'font-size: 6pt;font-weight:normal' },
	colors: { selected: 'red', focus: 'green' },
};

AppOdontograma.prototype.fn = {
	drawDiente: function (svg, parentGroup, diente){
		var self = this;
		if(!diente) throw new Error('Error no se ha especificado el diente.');
		
		var x = diente.x || 0,
			y = diente.y || 0;
		
		var defaultPolygon = $.extend(true, {}, self.options.defaultPolygon, { diente: diente.id });
		var dienteGroup = svg.group(parentGroup, { transform: 'translate(' + x + ',' + y + ')', });

		var caraSuperior = svg.polygon(dienteGroup,
			[[0,0],[20,0],[15,5],[5,5]],  
			defaultPolygon);
		caraSuperior = $(caraSuperior).data('cara', 'S');
		
		var caraInferior =  svg.polygon(dienteGroup,
			[[5,15],[15,15],[20,20],[0,20]],  
			defaultPolygon);			
		caraInferior = $(caraInferior).data('cara', 'I');

		var caraDerecha = svg.polygon(dienteGroup,
			[[15,5],[20,0],[20,20],[15,15]],  
			defaultPolygon);
		caraDerecha = $(caraDerecha).data('cara', 'D');
		
		var caraIzquierda = svg.polygon(dienteGroup,
			[[0,0],[5,5],[5,15],[0,20]],  
			defaultPolygon);
		caraIzquierda = $(caraIzquierda).data('cara', 'Z');		    
		
		var caraCentral = svg.polygon(dienteGroup,
			[[5,5],[15,5],[15,15],[5,15]],  
			defaultPolygon);	
		caraCentral = $(caraCentral).data('cara', 'C');
		
		var defaultText = $.extend(true, {}, self.options.defaultText, { diente: diente.id});
		var caraCompleto = svg.text(dienteGroup, 6, 30, diente.id.toString(), defaultText);
		caraCompleto = $(caraCompleto).data('cara', 'X');
		
		var caras = new Array();
		caras['I'] = caraInferior;
		caras['S'] = caraSuperior;
		caras['C'] = caraCentral;
		caras['X'] = caraCompleto;
		caras['Z'] = caraIzquierda;
		caras['D'] = caraDerecha;
		
		self.vm.gruposDiente.push(dienteGroup);
		var _self = {};
		_self.autor = '@Tunaqui';
		_self.context = self;
		_self.diente = diente;
		_self.polygon = dienteGroup;
		_self.carasDiente = caras;
		_self.svg = svg;
		_self.fill = self.fill.bind(self);

		Object.keys(caras).map(function(k){
			var x = $.extend(true,{}, _self, { cara: k});
			$(caras[k]).data('self', x);
			self.storage.push(caras[k]);
		});
		return _self;
	},
	renderSvg: function (selectorId){
		console.log('Update render');
		var self = this;
		var svg = $(selectorId).svg('get').clear();
		var parentGroup = svg.group({transform: 'scale(1.5)'});
		var dientes = self.vm.dientes();
		for (var i =  dientes.length - 1; i >= 0; i--) {
			var diente =  dientes[i];
			var dienteUnwrapped = ko.utils.unwrapObservable(diente); 
			var draw = self.fn.drawDiente.bind(self);
			draw(svg, parentGroup, dienteUnwrapped);
		};
	},
	DienteModel: function (id, x, y){
		var self = this;
		self.id = id;	
		self.x = x;
		self.y = y;		
	},
	ViewModel: function (dienteModel){
		var self = this;
		self.gruposDiente = ko.observableArray([]);
		//Cargo los dientes
		var dientes = [];
		//Dientes izquierdos
		for(var i = 0; i < 8; i++){
			dientes.push(new dienteModel(18 - i, i * 25, 0));	
		}
		for(var i = 3; i < 8; i++){
			dientes.push(new dienteModel(58 - i, i * 25, 1 * 40));
		}
		for(var i = 3; i < 8; i++){
			dientes.push(new dienteModel(88 - i, i * 25, 2 * 40));
		}
		for(var i = 0; i < 8; i++){
			dientes.push(new dienteModel(48 - i, i * 25, 3 * 40));	
		}
		//Dientes derechos
		for(var i = 0; i < 8; i++){
			dientes.push(new dienteModel(21 + i, i * 25 + 210, 0));	
		}
		for(var i = 0; i < 5; i++){
			dientes.push(new dienteModel(61 + i, i * 25 + 210, 1 * 40));	
		}
		for(var i = 0; i < 5; i++){
			dientes.push(new dienteModel(71 + i, i * 25 + 210, 2 * 40));	
		}
		for(var i = 0; i < 8; i++){
			dientes.push(new dienteModel(31 + i, i * 25 + 210, 3 * 40));	
		}

		self.dientes = ko.observableArray(dientes);
	},
	eventHandler : function(value, fn){
		var c = $(value).data('cara');
		value.bind('self', function(){
			var me = $(this);
			var _modelSelf = me.data('self');
			var _cara = me.data('cara');
			_modelSelf.nro = _modelSelf.diente.id;
			_modelSelf.id = _cara+'-'+_modelSelf.nro;
			_modelSelf.renderSvg = _modelSelf.context.renderSvg;
			_modelSelf.container = _modelSelf.context.container;
			_modelSelf.containerSelector = _modelSelf.context.selector;
			me.attr('cara', _cara);
		});
		value.on('mouseenter', function(e){
			fn.mouseenter.call(this,e, $(this).data('self'));
		}).on('mouseleave', function(e){
			fn.mouseleave.call(this,e, $(this).data('self'));
		});
		value.trigger('self');
	}
}

AppOdontograma.prototype.Init = function(){
	var self = this;
	//Inicializo SVG
	self.container.svg({
		settings:{ width: '620px', height: '250px' }
	});
	//
	ko.applyBindings(self.vm);
	//TODO: Cargo el estado del odontograma
	self.renderSvg();
	//Context menu
	self.contextmenu = $('<div/>',
			{ id: 'ctxmenuOdontograma', 'style': 'display: none;', class: 'ctxmenu-odontograma' }
		).get(0);
	$(self.container).data('contextmenu', self.contextmenu);
	self.storage.forEach(function(element) {
		self.fn.eventHandler.call(element, element, self.handlers);
	}, self);
	$(self.container).data('_self', self);
	$(self.container).bind('contextmenu', function(e){
		e.preventDefault();
		var pSelf = $(this).data('_self');
		var contextmenu = $(this).data('contextmenu');
		$(contextmenu).css({ 'position':'fixed', 'left':e.clientX+'px',
			'top':e.clientY+'px', 'max-width':400+'px', 'cursor':'pointer' });
		if($(contextmenu).hasClass('show')){
			$(contextmenu).css({'display':'none'});
		}else{
			$(contextmenu).css({'display':'block'});
		}
		$(this).toggleClass('show');
	});
	$(self.contextmenu).on('mouseleave', function(e){
		$(this).removeClass('show');
		$(this).fadeOut();
	});
	self.container.parent().append(self.contextmenu);
	return self;
}

AppOdontograma.prototype.renderSvg = function(){
	var self = this;
	self.fn.renderSvg.call(self,self.selector);
}

AppOdontograma.prototype.createSingle = function(selectorId, index, options){
	console.info('Update single');
	var self = this;
	var $ = self.jQuery;
	var container = $(selectorId);
	container.svg({	settings:{ width: '50px', height: '50px' }});
	var svg = container.svg('get').clear();
	var parentGroup = svg.group($.extend(true,{},{transform: 'scale(1.5)'}, options));
	self.selectedData = {
		selector: selectorId,
		container : container,
		svg: svg,
		nro: index,
		polygon: parentGroup,
	};
	var draw = self.fn.drawDiente.bind(self);
	self.selected = draw(svg, parentGroup, { id: index, x: 0, y: 0 });
	return self;
}

AppOdontograma.prototype.bind = function(name, fnCallback){
	var self = this;
	self.storage.forEach(function(element) {
		$(element).bind(name, fnCallback);
	}, self);
	return self;
}

AppOdontograma.prototype.on = function(name, fnCallback){
	var self = this;
	self.storage.forEach(function(element) {
		$(element).on(name, fnCallback);
	}, self);
	return self;
}

AppOdontograma.prototype.trigger = function(name){
	var self = this;
	self.storage.forEach(function(element) {
		$(element).trigger(name);
	}, self);
	return self;
}

AppOdontograma.prototype.call = function(fnCallback){
	fnCallback.call(this, fnCallback);
}

AppOdontograma.prototype.createContextMenu = function(fnCallback){
    var self = this;
    console.dir(self.contextmenu);
	fnCallback.call(self.contextmenu);
	return self;
}

AppOdontograma.prototype.fill = function(polygon, color){
	var self = this;
	color = typeof(color)==='string' ? color : self.options.colors.selected;
	$(polygon).attr('fill', color);
	return self;
}

AppOdontograma.prototype.paintTooth = function (diente, cara, color) {
    var polygon = $('[diente=\''+diente+'\'][cara=\''+cara+'\']');
    var self = this;
    self.fill(polygon, color);
    return self;
}

AppOdontograma.prototype.select = function(key, color){
	var self = this;
	color = typeof(color)==='string' ? color : self.options.colors.selected;
	self.fill(self.selected.carasDiente[key],color);
}

AppOdontograma.prototype.selectClear = function(key, color){
	var self = this;
	color = typeof(color)==='string' ? color : self.options.colors.selected;
	$(self.selected.polygon).find('polygon').attr('fill', 'white');
	$(self.selected.polygon).find('text').attr('fill', self.options.defaultText.fill);
	self.fill(self.selected.carasDiente[key],color);
}

AppOdontograma.prototype.Load = function() {
    $('#ctxmenuOdontograma').remove();
	var self = this;
	var onLoad = self.onLoad;
	self = AppOdontograma.Init(self.selectorId, self.options, self.onLoad);
	if(typeof(onLoad)==='function'){
		onLoad(self);
	}
	return self;
}

AppOdontograma.Init = function(selectorId, options, fnCallback){
	AppOdontograma.prototype.onLoad = fnCallback;
	var _appOdontograma = new AppOdontograma(selectorId, options);
	return _appOdontograma.Init();
}
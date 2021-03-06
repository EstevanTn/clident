String.prototype.capitalize = function() {
    return this.replace(/(^|\s)([a-z])/g, function(m, p1, p2) {
        return p1 + p2.toUpperCase();
    });
};

(function(w, j){
    'use strict';

    var fn_notify = function(options) {
        jQuery.notify({
            title: options.title ? options.title : 'Notificación',
            icon: options.icon ? options.icon : 'fa fa-info',
            message: options.message ? options.message : ''
        }, {
            element: options.element ? options.element : 'body',
            position: null,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            allow_dismiss: options.dismissable ? options.dismissable : true,
            delay: 3000,
            timer: 1000,
            type: options.type ? options.type : 'info',
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            z_index: 1531,//1031
            onShow: options.onShow ? options.onShow : null,
            onShown: options.onShown ? options.onShown : null,
            onClose: options.onClose ? options.onClose : null,
            offset:
                {
                    x: 20,
                    y: 60
                },
            mouse_over: 'pause',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<h4><span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span></h4> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
        });
    }

    /**
     * Formatear cadena
     * @param   {String}   str    [Formato de texto.]
     * @param   {Array} params [Valores a reemplazar en cadena]
     * @returns {String} [[Description]]
     */
    var StrFormat = function (str, params) {
        var args = [].slice.call(params);
        return str.replace(/(\{\d+\})/g, function (a){
            return args[+(a.substr(1,a.length-2))||0];
        });
    };

    /**
     * Agrega las propiedades del segundo objeto al primero objeto.
     * y o reemplaza una propiedad en la primera.
     * @param   {Object} obj1 [Object JSON]
     * @param   {Object} obj2 [Object JSON]
     * @returns {Object} [Object JSON]
     */
    var ReplaceObjectPropierty = function(obj1, obj2){
        var obj = {};
        Object.keys(obj1).forEach(function(k){
            obj[k] = obj1[k];
        });
        Object.keys(obj2).forEach(function(k){
            obj[k] = obj2[k];
        });
        return obj;
    }

    var getParameterByName = function(url, name){
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }


    var defaults = {
        datatable: {
            filter: false,
            bLengthChange: false,
            filtering: false,
            searching: false,
            ordering: true,
            ServerSide: true,
            destroy: true,
            responsive: true,
            processing: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json'
            },
            sServerMethod: 'POST',
            //sAjaxSource: '${pageContext.request.contextPath}/',
            iDisplayLength: 100,
            iDisplayStart : 0,
            aLengthMenu: [[100, 200, 300], [100, 200, 300]],
            initComplete: function(data, settings){
                console.info('Se ha cargado los datos a la tabla: ', data.sTableId);
            },
            //scrollY:        "500px",
            //scrollX:        false,
            //scrollCollapse: true,
            //paging:         false,
            /*columnDefs: [
                { width: 200, targets: 0 }
            ],*/
            columnDefs: [{
                targets: -1,
                data: null,
                defaultContent: "<button>Click!</button>"
            }],
            fixedColumns: true,
            drawCallback: function (data){
              $('a.btn-link').addClass('btn-flat')
                .attr('data-toggle','tooltip').parent()
                //.addClass('btn-group')
                .addClass('no-padding')
                .addClass('text-center');
            },
          }
    };


    /**
     * Object base page
     * @param {String} controllerName [Controllador de la pagina]
     */
    var BasePage = function(controllerName){
        if(controllerName !==undefined && controllerName !== null ){
            var protocol = w.location.protocol;
            var port = w.location.port===''?':80':':'+w.location.port;
            this.ControllerName = controllerName?controllerName:'index';
            this.basePath = StrFormat('{0}//{1}{2}/clident/public', [protocol, w.location.hostname, port]);
            this.requestPath = StrFormat('{0}//{1}{2}{3}', [protocol,w.location.hostname, port, w.location.pathname]);
            this.Instance.call(this);
        }
    };

    BasePage.prototype = {
        defaults : defaults,
        Instance: function(){
            try{
                var controller = eval(this.ControllerName);
                var context = this;
                if(typeof controller !== typeof undefined)
                {
                    Object.keys(controller).map(function(k){
                      context[k] = controller[k];
                    });
                }
            }catch(ex){
                console.error('No se ha definido la variable del controlador: '+this.ControllerName);
            }
        },
        /**
         * Inicializa al cargar pagina.
         */
        Init: function(){
            var context = this;
            context['AppUtils'] = new appUtils();

            $(".connectedSortable").sortable({
              placeholder: "sort-highlight",
              connectWith: ".connectedSortable",
              handle: ".box-header, .nav-tabs",
              forcePlaceholderSize: true,
              zIndex: 999999
            });
            $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

            jQuery.extend(jQuery.validator.messages, {
                required: "El campo es requerido.",
                remote: "El campo es requerido.",
                email: "Ingrese un email válido.",
                url: "Ingrese una url válida.",
                date: "Ingrese una fecha válida.",
                dateISO: "Please enter a valid date (ISO).",
                number: "Ingrese solo números.",
                digits: "Ingrese solo dígitos.",
                creditcard: "Please enter a valid credit card number.",
                equalTo: "Ingresa el mismo valor.",
                accept: "Please enter a value with a valid extension.",
                maxlength: $.validator.format("Ingrese máximo {0} caracteres."),
                minlength: $.validator.format("Ingrese mínimo {0} caracteres."),
                rangelength: $.validator.format("Ingrese cadena entre {0} y {1} caracteres."),
                range: $.validator.format("Ingrese cadena entre {0} y {1}."),
                max: $.validator.format("Máximo valor de la propiedad {0}."),
                min: "El campo es requerido.",
                fecharango: $.validator.format("Fecha Fin < Fecha Inicio."),
                letras: $.validator.format("Solo se permiten letras."),
                fechahorarango: "Fecha/Hora de Fin < Fecha/Hora de Inicio"
            });

            jQuery.validator.addMethod("letras", function (value, element) {
                return this.optional(element) || /^[a-zA-ZzáéíóúñÁÉÍÓÚÑ, " "]+$/i.test(value);
            });

            jQuery.validator.addMethod("fecharango", function (value, element, arg) {
                if (value == undefined || value == '' || value == null) return true;

                var _finicio = fn_formatDateToEN($(arg[0]).val());
                var _ffin = fn_formatDateToEN(value);
                return Date.parse(_finicio) <= Date.parse(_ffin);
            });

            jQuery.validator.addMethod("fechahorarango", function (value, element, arg) {
                // format fecha dd/mm/yyyy | formato hora hh:mm AM / hh:mm PM
                // arg [0] Fecha Inicio, [1] Fecha Fin, [2] Hora Inicio y value Hora Fin
                var fechaInicio = $(arg[0]).val(),
                    fechaFin = $(arg[1]).val(),
                    horaInicio = $(arg[2]).val(),
                    horaFin = value;

                if (fechaInicio == undefined || fechaInicio == '' || fechaInicio == null) return true;
                if (fechaFin == undefined || fechaFin == '' || fechaFin == null) return true;
                if (horaInicio == undefined || horaInicio == '' || horaInicio == null) return true;
                if (horaFin == undefined || horaFin == '' || horaFin == null) return true;

                var startDate = new Date(fn_formatDateToEN(fechaInicio) + ' ' + fn_convertTimeTo24(horaInicio));
                var endDate = new Date(fn_formatDateToEN(fechaFin) + ' ' + fn_convertTimeTo24(horaFin));

                return startDate < endDate;
            });

            jQuery.validator.setDefaults({
                highlight: function (label) {
                    $(label).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function (label) {
                    $(label).closest('.form-group').removeClass('has-error');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length || element.parent('.required-select2').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            jQuery.ajaxSetup({
                type: 'POST',
                //contentType: 'Content-Type: application/json; charset=utf-8',
                dataType: 'json',
                error: function(xhr, status, error){
                    console.error(status, xhr.responseText);
                }
            });
            jQuery('.treeview').each(function(e){
                var controllerNames = jQuery(this).attr('data-controllers');
                controllerNames = controllerNames.split(',');
                if(controllerNames.indexOf(context.ControllerName)!==-1){
                    jQuery(this).addClass('active');
                }
                jQuery(this).removeAttr('data-controllers');
            });
            jQuery('.box-body').find('table').attr('width', '100%')
                .addClass('table-hover').addClass('table-striped').parent().addClass('no-padding');
            //OnReady
            jQuery(w.document).ready(function(){
              jQuery('body').addClass('fixed');
                jQuery('.modal-dialog').draggable({
                    handler: '.modal-header',
                    helper: function(){
                        return $(this).css({'background':'transparent'});
                    }
                });
                if(jQuery.isFunction(context.InitOnReady)){
                    context.InitOnReady.call(context, context);
                }
                context.CustomThemeStyles();
            });

        },
        CustomThemeStyles: function(){
            jQuery('input[type=\'text\'], input[type=\'email\'], textarea').each(function(){
                jQuery(this).css({'text-transform':'capitalize'});
            });
            jQuery('.btn, button, a.btn').each(function(){
                jQuery(this).addClass('btn-flat');
            });
            jQuery('input[type=\'text\'], input[type=\'email\'], textarea').on('focusout', function(){
                jQuery(this).val(this.value.capitalize());
            });
        },
        GridSetup: function(options){
            options['name'] = typeof options['name'] === 'string'?options['name']:this.ControllerName;
            options = ReplaceObjectPropierty(this.defaults.datatable, options);
            var name = this.StringFormat('#datatable-{0}', options['name']);
            jQuery(name).DataTable(options);
        },
        StringFormat: function(){
            var args = new Array();
            for(var i=0; i<arguments.length; i++){
                if(i>=1){
                    args.push(arguments[i]);
                }
            }
            return StrFormat(arguments[0],args);
        },
        Capitalize: function(string){
            return string.replace(/\b\w/g, function(l){ return l.toUpperCase() })
        },
        getParameterByName: function(url, name){
            return getParameterByName(url, name);
        },
        Validate: function(o){
            var form = typeof o['form'] === typeof undefined || typeof o['form'] === typeof null ? '#form-'+this.ControllerName : o.form ;
            jQuery(form).validate({
                rules: o.rules,
                messages: (o.messages != undefined) ? o.messages : {},
            });
        },
        ValidateReset: function(name){
            name = this.StringFormat('#form-{0}',name);
            jQuery(name).validate().resetForm();
            jQuery(name).find('.form-group').removeClass('has-error');
            jQuery(name).find('input[type=\'text\'], textarea, input[type=\'email\']').val('');
            jQuery(name).find('input[type=\'number\'], input[type=\'hidden\']').val(0);
            jQuery(name).find('select').val(0).trigger('change');
            jQuery(name).find('[data-default-value]').each(function(){
                jQuery(this).val(jQuery(this).attr('data-default-value'));
            });
        },
        ShowModal: function(options){
            var name, reset, fnCallback;
            var title = this.StringFormat('<i class=\'fa fa-home\'></i> {0}', w.location.hostname);
            if (options!== null && typeof options === 'object') {
                name = options['name'] ? options['name'] : this.ControllerName;
                title = options['title'];
                fnCallback = options['callback'] ? options['callback'] : null;
            }else{
                name = options;
                fnCallback = null;
            }
            var modal = jQuery(this.StringFormat('#modal-{0}', name));
            modal.find('.modal-title').html(title);
            var form = jQuery(this.StringFormat('#form-{0}', name));
            var modal = jQuery(this.StringFormat('#modal-{0}', name)).modal({
                show: true,
                keyboard: false,
                backdrop: false
            });

            if(form.length>0){
                form.find('.modal-footer button').attr('type','button');
                form.find('.modal-footer .btn-default').addClass('pull-left');
                this.ValidateReset(name);
            }
            if (fnCallback!==null && fnCallback!==undefined) {
                fnCallback({
                    name: this.StringFormat('modal-{0}', name),
                    target: modal
                });
            }
        },
        Notify: function(options, successCallback, failCallback){
            if (typeof options['success'] !== typeof undefined && typeof options['success'] !== typeof null) {
                if (typeof options['success'] === typeof true) {
                    var exec = options['success'];
                    if (exec) {
                        options['title'] = 'Confirmación';
                        options['icon'] = 'fa fa-check';
                        options['type'] = 'success';
                        options['onShow'] = successCallback;
                    }else{
                        options['title'] = 'Error';
                        options['icon'] = 'fa fa-ban';
                        options['onShow'] = failCallback;
                        options['type'] = 'danger';
                    }
                }
                if (typeof options['success'] === 'string') {
                    options['title'] = 'Aviso';
                    options['icon'] = 'fa fa-warning';
                    options['onShow'] = failCallback;
                    options['type'] = 'warning';
                }
            }
            fn_notify.call(this, options);
        },
        Delete: function(Id){
            var context = this;
            BootstrapDialog.confirm({
                title: 'Confirmacion',
                message: '¿Deseas eliminar este registro?',
                callback: function(result){
                    if(result){
                        if(jQuery.isFunction(context.fnDelete)){
                            context.fnDelete.call(context,Id);
                        }
                    }
                }
            });
        }
    }

    var InitDashboard = function(){
        var page = new BasePage()
        var tagScripts = jQuery('script');
        var script = tagScripts[tagScripts.length-1];
        var controller = getParameterByName(script.src, 'controller');
        var page = new BasePage(controller);
        page.Init();
        w.BasePage = page;
    };

    InitDashboard();

}(window, jQuery));

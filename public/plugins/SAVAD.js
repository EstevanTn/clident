$.extend(jQuery.validator.messages, {
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

$.validator.addMethod("letras", function (value, element) {
    return this.optional(element) || /^[a-zA-ZzáéíóúñÁÉÍÓÚÑ, " "]+$/i.test(value);
});

$.validator.addMethod("fecharango", function (value, element, arg) {
    if (value == undefined || value == '' || value == null) return true;

    var _finicio = fn_formatDateToEN($(arg[0]).val());
    var _ffin = fn_formatDateToEN(value);
    return Date.parse(_finicio) <= Date.parse(_ffin);
});

$.validator.addMethod("fechahorarango", function (value, element, arg) {
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

$.validator.setDefaults({
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

function fn_validate(o) {
    $(o.form).validate({
        rules: o.rules,
        messages: (o.messages != undefined) ? o.messages : {},
    });
}

function fn_validate_reset(form) {
    $('#' + form).validate().resetForm();
    $('#' + form).find('.form-group').removeClass('has-error');
}

function notify_message(options) {
    $.notify({
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
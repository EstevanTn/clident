/// <reference path="../core/jquery-1.7.2.min.js" />
/// <reference path="../core/jquery-ui-1.8.21.custom.min.js" />
/// <reference path="../grid/jquery.jqGrid.min.js" />

function toDatePicker(str) {
    var dia = str.substr(0, 2);
    var mes = str.substr(3, 2) - 1;
    var anho = str.substr(6, 4);
    return new Date(anho, mes, dia);
}

function strPad(i, l, s) {
    var o = i.toString();
    if (!s) { s = '0'; }
    while (o.length < l) {
        o = s + o;
    }
    return o;
}

function parseJsonDate(jsonDate) {
    if (jsonDate == null)
        return '';
    var value = new Date(parseInt(jsonDate.substr(6)));
    var ret = strPad(value.getDate(), 2) + "/" + strPad(value.getMonth() + 1, 2) + "/" + value.getFullYear();
    return ret;
}

function ParseFloatDev(s) {
    return (isNaN(parseFloat(s)) ? 0 : parseFloat(s));
}

function isTextSelected(input) {
    if (typeof input.selectionStart == "number") {
        return input.selectionStart == 0 && input.selectionEnd == input.value.length;
    } else if (typeof document.selection != "undefined") {
        input.focus();
        return document.selection.createRange().text == input.value;
    }
}

//Inicializar
$(function () {

    $("form,input").bind("keypress", function (e) {
        if (e.keyCode == 13) { return false; }
    });

    $.ajaxSetup({
        type: "POST",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        data: {}
    });

    $(document).ajaxError(function (e, xhr, settings, exception) {
        if (exception == 'Unauthorized')
            window.location = 'Login.aspx';
        //else
        //    alert('error in: ' + settings.url + ' \\n' + 'error:\\n' + exception);

        switch (xhr.status) {
            case 403:
                window.location = 'Login.aspx';
                break;
            case 590:
                window.location = 'Login.aspx';
                break;
        }
    });

    $(document).ajaxSuccess(function (event, request, settings) {
        if (request.statusText == "ERR_SESSION_TIMEOUT") {
            window.location = 'Login.aspx'
        }
    });

    $("*").dblclick(function (e) {
        e.preventDefault();
    });

    $("div.btn-save-data").on('click', function () {
        var control = $(this);
        control.attr('disabled', true);
        setTimeout(function () {
            control.attr('disabled', false);
        }, 1000);

    });
});

$.fn.SoloLetras = function () {
    $(this).keydown(function (e) {
        if ((e.keyCode >= 48) && (e.keyCode <= 57) || (e.keyCode >= 96) && (e.keyCode <= 105))
            e.preventDefault();
    });
}

//extensiones
$.jgrid.extend({
    addToolBar: function (idToolBar) {
        var idGrid = this.attr('id');
        $("#" + idToolBar).appendTo("#t_" + idGrid);
        $("#t_" + idGrid).css('height', '30px');
    }
});

$.jgrid.extend({
    addToolNota: function (idToolBar) {
        var idGrid = this.attr('id');
        $("#" + idToolBar).appendTo("#t_" + idGrid);
        $("#t_" + idGrid).css('height', '65px');
    }
});

$.jgrid.extend({
    rowColumnHeader: function (columnNameIni, textColumn, colsMerge) {

        var idGrid = this.attr('id');
        var mygrid = $("#" + idGrid);
        var colModel, i, cmi, tr = "<tr>", skip = 0, ths;

        colModel = mygrid[0].p.colModel;
        ths = mygrid[0].grid.headers;
        for (i = 0; i < colModel.length; i++) {
            cmi = colModel[i];
            if (cmi.name !== columnNameIni) {
                if (skip === 0) {
                    $(ths[i].el).attr("rowspan", "2");
                } else {
                    skip--;
                }
            } else {
                tr += '<th class="ui-state-default ui-th-ltr" colspan="' + colsMerge + '" role="columnheader">' + textColumn + '</th>';
                skip = (colsMerge - 1); // because we make colspan="3" the next 2 columns should not receive the rowspan="2" attribute
            }
        }
        tr += "</tr>";
        mygrid.closest("div.ui-jqgrid-view").find("table.ui-jqgrid-htable > thead").append(tr);

    }
});

$.jgrid.extend({
    headerWrap: function () {

        var idGrid = this.attr('id');
        var grid = $("#t_" + idGrid);

        // get the header row which contains
        headerRow = grid.closest("div.ui-jqgrid-view")
                .find("table.ui-jqgrid-htable>thead>tr.ui-jqgrid-labels");

        // increase the height of the resizing span
        resizeSpanHeight = 'height: ' + headerRow.height() + 'px !important; cursor: col-resize;';
        headerRow.find("span.ui-jqgrid-resize").each(function () {
            this.style.cssText = resizeSpanHeight;
        });

        // set position of the dive with the column header text to the middle
        rowHight = headerRow.height();
        headerRow.find("div.ui-jqgrid-sortable").each(function () {
            var ts = $(this);
            ts.css('top', (rowHight - ts.outerHeight()) / 2 + 'px');
        });

    }
});

var ProyectoCultura = {
    //
    SnippetToAlfanumericosCustom: function (IdControl, allow) {
        /// <summary>         
        /// Convierte a Mayúsculas el texto ingresado en un control, y restringe a caracteres del alfabeto español         
        /// </summary>         
        /// <param name="IdControl" type="String">Id del control a aplicar</param>         
        var objControl = $("[id$=" + IdControl + "]");
        objControl.addClass('uppercase');
        var blnAlfanumericoCGR = false;
        // Add event Keydown due to support Firefox         
        objControl.keydown(function (e) {
            blnAlfanumericoCGR = false;
            e = e || window.event;
            var iKey = e.keycode || e.which || 0;
            if (iKey == 9 || iKey == 35 || iKey == 36 || iKey == 39 || iKey == 46) {
                //Tab, fin, inicio, Left, Right, Supr                 
                blnAlfanumericoCGR = true;
            }
        });
        objControl.keypress(function (e) {
            e = e || window.event;
            var iKey = e.keycode || e.which || 0;
            //var modifiers = (e.altKey || e.ctrlKey || e.shiftKey);             
            //alert(iKey);
            var permitidos = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚÄËÏÖÜ-.,;'_" + '"' + allow;
            if (iKey == 8 || iKey == 32 || iKey == 16 || iKey == 39 || iKey == 45 || iKey == 46 || blnAlfanumericoCGR) {
                return true;
            }
            // Check Permitidos             
            for (i = 0; i < permitidos.length; i++) {
                if (String.fromCharCode(iKey).toUpperCase() == permitidos.substr(i, 1)) return true;
            }
            return false;
        });
        objControl.blur(function (e) {
            blnAlfanumericoCGR = false;
            objControl.val(objControl.val().toUpperCase());
        });
    },
    //
    SnippetToTextoCustom: function (IdControl, allow) {
        /// <summary>         
        /// Convierte a Mayúsculas el texto ingresado en un control, y restringe a caracteres del alfabeto español         
        /// </summary>         
        /// <param name="IdControl" type="String">Id del control a aplicar</param>         
        var objControl = $("[id$=" + IdControl + "]");
        objControl.addClass('uppercase');
        var blnAlfanumericoCGR = false;
        // Add event Keydown due to support Firefox         
        objControl.keydown(function (e) {
            blnAlfanumericoCGR = false;
            e = e || window.event;
            var iKey = e.keycode || e.which || 0;
            if (iKey == 9 || iKey == 35 || iKey == 36 || iKey == 39 || iKey == 46) {
                //Tab, fin, inicio, Left, Right, Supr                 
                blnAlfanumericoCGR = true;
            }
        });
        objControl.keypress(function (e) {
            e = e || window.event;
            var iKey = e.keycode || e.which || 0;
            //var modifiers = (e.altKey || e.ctrlKey || e.shiftKey);             
            //alert(iKey);
            var permitidos = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚÄËÏÖÜ-.,;'_" + '"' + allow;
            if (iKey == 8 || iKey == 32 || iKey == 16 || iKey == 39 || iKey == 45 || iKey == 46 || blnAlfanumericoCGR) {
                return true;
            }
            // Check Permitidos             
            for (i = 0; i < permitidos.length; i++) {
                if (String.fromCharCode(iKey).toUpperCase() == permitidos.substr(i, 1)) return true;
            }
            return false;
        });
        objControl.blur(function (e) {
            blnAlfanumericoCGR = false;
            objControl.val(objControl.val().toUpperCase());
        });
    },
    //
    CalculaDuracion: function (dateFrom, dateTo, IdControl) {
        var start = $("[id$=" + dateFrom + "]").datepicker('getDate');
        var end = $("[id$=" + dateTo + "]").datepicker('getDate');
        if (start > end) {
            $("[id$=" + IdControl + "]").val('');
            return;
        }
        if (!start || !end)
            return;
        var days = 0;
        if (start && end) {
            var difference = (end.getTime() - start.getTime());
            var years = Math.floor(difference / (1000 * 60 * 60 * 24 * 365));
            difference -= years * (1000 * 60 * 60 * 24 * 365);
            var months = Math.floor(difference / (1000 * 60 * 60 * 24 * 30.4375));
            difference -= months * (1000 * 60 * 60 * 24 * 30.4375);
            var days = Math.floor(difference / (1000 * 60 * 60 * 24 * 1));
            var dif = '';
            if (years > 0)
                dif = years + 'a';
            if (months > 0) {
                dif += months + 'm';
            }
            if (days > 0) {
                dif += days + 'd';
            }
        }
        $("[id$=" + IdControl + "]").val(dif);
    },
    GetDateFromString: function (stringValue) {
        var dateSplit = stringValue.split('/');
        var date = new Date(parseInt(dateSplit[2]), parseInt(dateSplit[1]) - 1, parseInt(dateSplit[0]));
        return date;
    },
    CalculateSpendTime: function (dateFrom, dateTo) {
        var emptyObject = {
            anios: 0,
            meses: 0,
            dias: 0
        }

        var start = this.GetDateFromString(dateFrom);
        var end = this.GetDateFromString(dateTo);

        if (start > end) {
            return emptyObject;
        }

        if (!start || !end)
            return emptyObject;

        var days = 0;
        if (start && end) {
            var difference = (end.getTime() - start.getTime());
            var years = Math.floor(difference / (1000 * 60 * 60 * 24 * 365));
            difference -= years * (1000 * 60 * 60 * 24 * 365);
            var months = Math.floor(difference / (1000 * 60 * 60 * 24 * 30.4375));
            difference -= months * (1000 * 60 * 60 * 24 * 30.4375);
            var days = Math.floor(difference / (1000 * 60 * 60 * 24 * 1));

            return {
                anios: years,
                meses: months,
                dias: days
            }
        }

        return emptyObject;
    },
    //
    UrlPageMethod: function (WebMethod) {
        /// <summary>
        /// Devuelve el Url de un WebMethod (con relación a la página donde se ejecuta el script)
        /// </summary>
        /// <param name="WebMethod" type="String">Nombre del WebMethod</param>
        return window.location.pathname + '/' + WebMethod;
    },
    //
    MostrarPopup: function (Titulo, Mensaje, Opcion, CallbackAccept, CallbackCancel, TipoIcono) {
        /// <summary>
        /// Muestra una ventana de dialogo
        /// </summary>
        /// <param name="Titulo" type="String">Titulo de la ventana de dialogo</param>
        /// <param name="Mensaje" type="String">Mensaje a mostrar</param>
        /// <param name="Opcion" type="String">(Opcional) indica el tipo de ventana a mostrar (Default = Aceptar)</param>
        /// <param name="CallbackAccept" type="function">(Opcional) Función a ejecutar luego de pulsar [Aceptar] ó [Si]</param>
        /// <param name="CallbackCancel" type="function">(Opcional) Función a ejecutar luego de pulsar [Cancelar], [No], ó al salir de la ventana</param>
        /// <param name="TipoIcono" type="String">Tipo de icono que se muestra en la venta: [Informacion] [Pregunta] [Error] [Alerta] [Ok]</param>
        var executeCallBack = false;
        //
        if (!Opcion) { Opcion = 'Aceptar'; }
        //
        var imgDlg = '';
        var imgTip = 'ico-informacion.png';

        if (!TipoIcono) {
            switch (Opcion) {
                case 'Aceptar': imgTip = 'ico-informacion.png'; break;
                case 'SiNo', 'AceptarCancelar': imgTip = 'ico-pregunta.png'; break;
            }
        } else {
            switch (TipoIcono) {
                case 'Informacion': imgTip = 'ico-informacion.png'; break;
                case 'Pregunta': imgTip = 'ico-pregunta.png'; break;
                case 'Error': imgTip = 'ico-error.png'; break;
                case 'Alerta': imgTip = 'ico-alerta.png'; break;
                case 'Ok': imgTip = 'ico-guardar.png'; break;
            }
        }

        imgDlg = "";//<img src='../img/comun/popup/" + imgTip + "' alt='' title='' style='float: left;'/>";

        //
        var dlg = $('<div id="dlgBase">' + imgDlg + '<p style="float:left; width:370px; padding-top:10px;"> ' + Mensaje + '</p></div>')
            .dialog({
                title: Titulo,
                resizable: false,
                modal: true,
                width: 400,
                close: function () {
                    switch (Opcion) {
                        case 'Aceptar':
                            if (typeof CallbackAccept == 'function') {
                                if (!executeCallBack) { CallbackAccept.call(this); }
                            }
                            break;
                        case 'SiNo', 'AceptarCancelar':
                            if (typeof CallbackCancel == 'function') {
                                if (!executeCallBack) { CallbackCancel.call(this); }
                            }
                            break;
                        default:
                            break;
                    }
                }
            });

        if (Opcion == 'Aceptar') {
            dlg.dialog("option", "buttons", {
                "Aceptar": function () {
                    if (typeof CallbackAccept == 'function') {
                        executeCallBack = true;
                        $(this).dialog("close");
                        CallbackAccept.call(this);
                    } else {
                        $(this).dialog("close");
                    }
                    return true;
                }
            });
        }

        if (Opcion == 'SiNo') {
            dlg.dialog("option", "buttons", {
                "Si": function () {
                    if (typeof CallbackAccept == 'function') {
                        executeCallBack = true;
                        $(this).dialog("close");
                        CallbackAccept.call(this);
                    } else {
                        $(this).dialog("close");
                    }
                    return true;
                },
                "No": function () {
                    if (typeof CallbackCancel == 'function') {
                        executeCallBack = true;
                        $(this).dialog("close");
                        CallbackCancel.call(this);
                    } else {
                        $(this).dialog("close");
                    }
                    return false;
                }
            });
        }

        if (Opcion == 'AceptarCancelar') {
            dlg.dialog("option", "buttons", {
                "Aceptar": function () {
                    if (typeof CallbackAccept == 'function') {
                        executeCallBack = true;
                        $(this).dialog("close");

                        CallbackAccept.call(this);
                    } else {
                        $(this).dialog("close");
                    }
                    return true;
                },
                "Cancelar": function () {
                    if (typeof CallbackCancel == 'function') {
                        executeCallBack = true;
                        $(this).dialog("close");

                        CallbackCancel.call(this);
                    } else {
                        $(this).dialog("close");
                    }
                    return false;
                }
            });
        }
    },
    //
    CargarGridLoad: function (strPageMethod, strGridId, objJsonParams, callbackOK) {

        //ProyectoCultura.ShowProgress();

        $.ajax({
            url: ProyectoCultura.UrlPageMethod(strPageMethod),
            data: JSON.stringify(objJsonParams),            
            complete: function (jsondata, stat) {            
                //ProyectoCultura.HideProgress();

                if (stat == "success") {
                    $("#" + strGridId)[0].addJSONData(JSON.parse(jsondata.responseText).d);
                    if (typeof callbackOK == 'function') { callbackOK.call(this); }
                }
                //else
                //ProyectoCultura.MostrarPopup("Error", "Error Cargar grilla.", "Aceptar", null, null, "Error"); 

            },
            async: false
        });

    },
    //
    CargarGrid: function (WebMethod, IdGrid, JsonParams, CallbackOk) {
        /// <summary>
        /// Carga control Grid mediante método Ajax
        /// </summary>
        /// <param name="WebMethod" type="String">Nombre del WebMethod utilizado para cargar el Grid</param>
        /// <param name="IdGrid" type="String">Id del tag <Table> que se formatea como un Grid</param>
        /// <param name="JsonParams" type="Json">(Opcional) Parametros utilizados por el [WebMethod], serializados en notación Json</param>
        /// <param name="CallbackOk" type="function">(Opcional) Función a ejecutar después de realizar la carga del Grid</param>

        ProyectoCultura.ShowProgress();

        $("#" + IdGrid).jqGrid('setGridParam', {
            datatype: function () {
                $.ajax({
                    url: ProyectoCultura.UrlPageMethod(WebMethod),
                    data: JSON.stringify(JsonParams),
                    complete: function (jsondata, stat) {

                        ProyectoCultura.HideProgress();

                        if (stat == "success") {
                            $("#" + IdGrid)[0].addJSONData(JSON.parse(jsondata.responseText).d);
                            if (typeof CallbackOk == 'function') { CallbackOk.call(this); }
                        }
                        //else
                        //ProyectoCultura.MostrarPopup("Error", "Error al cargar el Grid.", "Aceptar", null, null, "Error");
                    }
                });
            }
        }).trigger('reloadGrid');

    },
    CargarCombo: function (WebMethod, IdCombo, JsonParams, PrimerItem, CallbackOk) {
        /// <summary>
        /// Carga control Combobox mediante método Ajax
        /// </summary>
        /// <param name="WebMethod" type="String">Nombre del WebMethod utilizado para cargar el Combo</param>
        /// <param name="IdCombo" type="String">Id del Combo</param>
        /// <param name="JsonParams" type="Json">(Opcional) Parametros utilizados por el [WebMethod], serializados en notación Json</param>
        /// <param name="PrimerItem" type="String">Texto que se agrega como primer elemento en el Combo, su value siempre es ['']</param>
        /// <param name="CallbackOk" type="function">(Opcional) Función a ejecutar después de realizar la carga del Combo</param>
        $.ajax({
            url: ProyectoCultura.UrlPageMethod(WebMethod),
            data: JSON.stringify(JsonParams),
            success: function (result) {
                if (result.d != null) {
                    $("[id$=" + IdCombo + "]").html("");
                    if (PrimerItem != null) {
                        $("[id$=" + IdCombo + "]").append($("<option></option>")
                                                 .attr("value", "").text(PrimerItem));
                    }
                    $.each(result.d, function () {
                        $("[id$=" + IdCombo + "]").append($("<option></option>")
                                                 .attr("value", this.Id).text(this.Valor))
                    });
                    if (typeof CallbackOk == 'function') { CallbackOk.call(this); }
                }
            }
        });
    },
    //
    //CargarCombo: function (WebMethod, IdCombo, JsonParams, PrimerItem, CallbackOk) {
    //    /// <summary>
    //    /// Carga control Combobox mediante método Ajax
    //    /// </summary>
    //    /// <param name="WebMethod" type="String">Nombre del WebMethod utilizado para cargar el Combo</param>
    //    /// <param name="IdCombo" type="String">Id del Combo</param>
    //    /// <param name="JsonParams" type="Json">(Opcional) Parametros utilizados por el [WebMethod], serializados en notación Json</param>
    //    /// <param name="PrimerItem" type="String">Texto que se agrega como primer elemento en el Combo, su value siempre es ['']</param>
    //    /// <param name="CallbackOk" type="function">(Opcional) Función a ejecutar después de realizar la carga del Combo</param>
    //    $.ajax({
    //        //url: WebMethod, //ProyectoCultura.UrlPageMethod(WebMethod),
    //        url: ProyectoCultura.UrlPageMethod(WebMethod),
    //        data: JSON.stringify(JsonParams),
    //        success: function (result) {
    //            if (result.d != null) {
    //                // $("#" + IdCombo).html("");
    //                $("[id$=" + IdCombo + "]").html("");
    //                if (PrimerItem != null) {
    //                    // $("#" + IdCombo ).append($("<option></option>")
    //                    $("[id$=" + IdCombo + "]").append($("<option></option>")
    //                                       .attr("value", "").text(PrimerItem));
    //                }
    //                $.each(result.d, function () {
    //                    // $("#" + IdCombo ).append($("<option></option>")
    //                    $("[id$=" + IdCombo + "]").append($("<option></option>")
    //                                       .attr("value", this.codigo).text(this.nombre))
    //                });
    //                if (typeof CallbackOk == 'function') { CallbackOk.call(this); }
    //            }
    //        }
    //    });
    //},

    //
    ToUpperCase: function (IdControl) {
        /// <summary>
        /// Convierte a Mayúsculas el texto ingresado en un control
        /// </summary>
        /// <param name="IdControl" type="String">Id del control a aplicar</param>
        var objControl = $("[id$=" + IdControl + "]");

        objControl.keydown(function (e) {
            blnAlfanumericoCGR = false;
            e = e || window.event;
            var iKey = e.keycode || e.which || 0;
            //alert(iKey);
            if (iKey == 9 || iKey == 35 || iKey == 36 || iKey == 39 || iKey == 46 || iKey == 37) {
                //Tab, fin, inicio, Left, Right, Supr                                 
                blnAlfanumericoCGR = true;
                //alert('iKey');
                return true;
            }
        });
        objControl.keypress(function (e) {
        //objControl.keyup(function (e) {
            //alert(String.fromCharCode(e.charCode));
            //alert(e.charCode);
            if (e.charCode >= 16 & e.charCode <= 17 || e.charCode >= 65 & e.charCode <= 90 || e.charCode >= 97 & e.charCode <= 122 || e.charCode == 241 || blnAlfanumericoCGR == true) {
                var pst = e.currentTarget.selectionStart;
                var string_start = e.currentTarget.value.substring(0, pst);
                var string_end = e.currentTarget.value.substring(pst, e.currentTarget.value.length);

                if (blnAlfanumericoCGR == true) {
                    return true;
                } else {
                    e.currentTarget.value = string_start + String.fromCharCode(e.charCode).toUpperCase() + string_end;
                    //e.currentTarget.selectionStart = pst + 1;
                    e.currentTarget.selectionEnd = pst + 1;
                    //objControl.val(e.currentTarget.value);
                    return false;
                }
            }
        });
    },

    //
    //ToUpperCase: function (IdControl) {
    //    /// <summary>
    //    /// Convierte a Mayúsculas el texto ingresado en un control
    //    /// </summary>
    //    /// <param name="IdControl" type="String">Id del control a aplicar</param>
    //    var objControl = $("[id$=" + IdControl + "]");

    //    objControl.keyup(function (e) {
    //        var valor = objControl.val();
    //        objControl.val(valor.toUpperCase());
    //        return false
    //    });
    //},


    //
    CheckEmail: function (IdControl, Mensaje) {
        /// <summary>
        /// Valida que el control contenga un email
        /// </summary>
        /// <param name="IdControl" type="String">Id del control a validar</param>
        /// <param name="Mensaje" type="String">Mensaje mostrado en caso se validación sea incorrecta</param>

        var valControl;
        var objControl = $("[id$=" + IdControl + "]");
        if (!objControl)
            return false;

        valControl = objControl.val();

        if (valControl.trim() != '') {
            expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!expr.test(valControl)) {
                objControl.addClass("ui-state-error");
                ProyectoCultura.MostrarPopup('Error', Mensaje, 'Aceptar', function () { objControl.focus(); }, null, "Error");
                return false;
            } else {
                objControl.removeClass("ui-state-error");
                return true;
            }
        } else {
            objControl.removeClass("ui-state-error");
            return true;
        }
    },
    resolveClientURL: function (url) {
        /// <summary>
        /// Devuelve la ruta relativa desde la raiz del sitio web
        /// </summary>
        /// <param name="url" type="String">Url relativa que será agregada a la ruta base</param>
        return url.replace("~/", commonPageUrl); // commonPageUrl esta definida en la master page.
    },
    //
    CheckLength: function (IdControl, Mensaje, Min, Max, OcultarMensaje) {
        /// <summary>
        /// Valida la longitud de un control
        /// </summary>
        /// <param name="IdControl" type="String">Id del control a validar</param>
        /// <param name="Mensaje" type="String">Mensaje mostrado en caso se validación sea incorrecta</param>
        /// <param name="Min" type="Number">Longitud mínima requerida para el control</param>
        /// <param name="Max" type="Number">Longitud máxima requerida para el control</param>
        /// <param name="OcultarMensaje" type="Boolean">(Opcional) Oculta mensaje de validación</param>

        var valControl;
        var objControl = $("[id$=" + IdControl + "]");
        if (!objControl)
            return false;

        valControl = objControl.val().length;

        if (valControl > Max || valControl < Min) {
            objControl.addClass("ui-state-error");
            if (!OcultarMensaje) {
                ProyectoCultura.MostrarPopup('Aviso', Mensaje, 'Aceptar', function () { objControl.focus(); }, null, "Error");
            }
            return false;
        } else {
            objControl.removeClass("ui-state-error");
            return true;
        }
    },
    //
    CheckVal: function (IdControl, Mensaje, Min, Max, OcultarMensaje) {
        /// <summary>
        /// Valida el rango de valores permitidos en un control
        /// </summary>
        /// <param name="IdControl" type="String">Id del control a validar</param>
        /// <param name="Mensaje" type="String">Mensaje mostrado en caso se validación sea incorrecta</param>
        /// <param name="Min" type="Number">Valor mínimo permitido para el control</param>
        /// <param name="Max" type="Number">Valor máximo permitido para el control</param>
        /// <param name="OcultarMensaje" type="Boolean">(Opcional) Oculta mensaje de validación</param>

        var valControl;
        var objControl = $("[id$=" + IdControl + "]");
        if (!objControl)
            return false;

        valControl = objControl.val();

        if (valControl > Max || valControl < Min) {
            objControl.addClass("ui-state-error");
            if (!OcultarMensaje) {
                ProyectoCultura.MostrarPopup('Error', Mensaje, 'Aceptar', function () { objControl.focus(); }, null, "Error");
            }
            return false;
        } else {
            objControl.removeClass("ui-state-error");
            return true;
        }
    },
    //
    isValidDate: function (IdControl, Mensaje, OcultarMensaje) {
        /// <summary>
        /// Valida que el contenido del control sea una fecha valida en formato DD/MM/YYYY
        /// </summary>
        /// <param name="IdControl" type="String">Id del control a validar</param>
        /// <param name="Mensaje" type="String">Mensaje mostrado en caso se validación sea incorrecta</param>
        /// <param name="OcultarMensaje" type="Boolean">(Opcional) Oculta mensaje de validación</param>
        var valControl;
        var objControl = $("[id$=" + IdControl + "]");
        if (!objControl)
            return false;

        var s = objControl.val();

        if (s.length != 10) {
            objControl.addClass("ui-state-error");
            if (!OcultarMensaje) {
                ProyectoCultura.MostrarPopup('Error', Mensaje, 'Aceptar', function () { objControl.focus(); }, null, "Error");
            }
            return false;
        }

        // format D(D)/M(M)/(YY)YY
        var dateFormat = /^\d{1,4}[\.|\/|-]\d{1,2}[\.|\/|-]\d{1,4}$/;
        if (dateFormat.test(s)) {
            // remover ceros del supuesto valor fecha
            s = s.replace(/0*(\d*)/gi, "$1");
            var dateArray = s.split(/[\.|\/|-]/);
            // valor de mes correcto
            dateArray[1] = dateArray[1] - 1;
            // valor de año correcto
            if (dateArray[2].length < 4) {
                // valor de año correcto
                dateArray[2] = (parseInt(dateArray[2]) < 50) ? 2000 + parseInt(dateArray[2]) : 1900 + parseInt(dateArray[2]);
            }
            var testDate = new Date(dateArray[2], dateArray[1], dateArray[0]);
            if (testDate.getDate() != dateArray[0] || testDate.getMonth() != dateArray[1] || testDate.getFullYear() != dateArray[2]) {
                objControl.addClass("ui-state-error");
                if (!OcultarMensaje) {
                    ProyectoCultura.MostrarPopup('Error', Mensaje, 'Aceptar', function () { objControl.focus(); }, null, "Error");
                }
                return false;
            } else {
                objControl.removeClass("ui-state-error");
                return true;
            }
        } else {
            objControl.addClass("ui-state-error");
            if (!OcultarMensaje) {
                ProyectoCultura.MostrarPopup('Error', Mensaje, 'Aceptar', function () { objControl.focus(); }, null, "Error");
            }
            return false;
        }
    },
    //
    ShowProgress: function () {
        $("#MEF_PleaseWaitDialog").dialog({
            autoOpen: false, modal: true, resizable: false, height: 110, width: 420,
            open: function (event, ui) {
                $('#MEF_PleaseWaitDialog').css('overflow', 'hidden');
            }
        });
        $("#MEF_PleaseWaitDialog").dialog("open");
        return false;
    },
    //
    HideProgress: function () {
        $("#MEF_PleaseWaitDialog").dialog("close");
        return false;
    }
};


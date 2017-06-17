var appUtils = function(){}
appUtils.prototype.ComboResponse = function(options){
    $.ajax({
        url: BasePage.StringFormat('{0}/{1}/{2}', BasePage.basePath, options.controller,options.action),
        data: options.data?options.data:{},
        success: function(response){
            $(options.target)
            .empty()
            .append($('<option/>',{ value: 0, text: '<< SELECCIONE >>'}));
            $(response.data).each(function(i,e){
                var args = new Object();
                Object.keys(options.keys).map(function(k){
                    args[k] = e[options.keys[k]];
                });
                args['data-toggle'] = 'tooltip';
                $(options.target).append($('<option/>', args));
            })
            if($.isFunction(options.callback)){
                options.callback($(options.target), response);
            }
        }
    });
}
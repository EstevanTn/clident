var appUtils = function(){}
appUtils.prototype.FullScreen = function(element){
    if(typeof(element)==='string'){
        element = document.getElementById(element);
    }
    if(element.requestFullScreen) {
        element.requestFullScreen();
    } else if(element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
    } else if(element.webkitRequestFullScreen) {
        element.webkitRequestFullScreen();
    }
}
appUtils.prototype.CancelFullScreen = function(){
    if(document.cancelFullScreen) {
        document.cancelFullScreen();
    } else if(document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    } else if(document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
    }
}
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

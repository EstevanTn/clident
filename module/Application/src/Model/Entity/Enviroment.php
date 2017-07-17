<?php
namespace Application\Model\Entity;

class Enviroment{
    //Session settings
    const NAME_SESSION = 'appTnqSoft';
    const NAME_COOKIE = 'appTnqSoft';
	//Mensajes
	const MSG_SAVE = 'Se ha guardado el registro satisfacoriamente.';
	const MSG_UPDATE = 'Se ha actualizado el registro satisfacoriamente.';
	const MSG_DELETE = 'Se ha eliminado el registro satisfacoriamente.';
	const MSG_ERROR = 'Se ha producido un error, intente en unos minutos o ponganse en contacto con el administrador.';
	const NOT_FIND = 'El registro que buscaba no se ha encontrado.';

	//Default AJAX RESPONSE jQuery
	const AJAX_RESPONSE = [
			'success' =>  false,
			'message' => 'No tiene los permisos para acceder a la información de esta pagina.'
		];

	const AJAX_TABLE = [
		'data'	=>	[]
	];

	//Settings Plugin Datatable jQuery
	const DRAW = 15;

	public static function GetDate(){
		$date = getdate();
		return sprintf('%s-%s-%s', $date['year'], $date['mon'], $date['mday']);
	}
	
	public static function GetCookie(){
	    if(isset($_COOKIE[Enviroment::NAME_COOKIE]))
        {
            return json_decode($_COOKIE[Enviroment::NAME_COOKIE], true);
        }
        return null;
	}
}

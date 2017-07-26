<?php
namespace Application\Model\Entity;

class Enviroment{
    //Session settings
    const NAME_SESSION = 'appTnqSoft';
    const NAME_COOKIE = 'appTnqSoft';
    const FILE_SESSION = 'data/session.json';

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
		'data'	=>	[],
	];

	//Settings Plugin Datatable jQuery
	const DRAW = 15;

	public static function GetDate(){
		$date = getdate();
		return sprintf('%s-%s-%s %s:%s:%s', $date['year'], $date['mon'], $date['mday'], $date['hours'], $date['minutes'], $date['seconds']);
	}
	
	public static function GetCookieUsuario(){
	    /*if(isset($_COOKIE[Enviroment::NAME_COOKIE]))
        {
            return json_decode($_COOKIE[Enviroment::NAME_COOKIE], true);
        }*/
	    if(file_exists(Enviroment::FILE_SESSION)){
	        $data = file_get_contents(Enviroment::FILE_SESSION);
            return json_decode($data, true);
        }
        return null;
	}
	public static function GetCookieValue($key){
	    $cookie = Enviroment::GetCookieUsuario();
	    $value = $cookie[$key];
	    return $value;
    }

    public static function setSessionData(array $data){
	    $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        $fh = fopen(Enviroment::FILE_SESSION, 'w');
        fwrite($fh, $json);
        fclose($fh);
    }
}

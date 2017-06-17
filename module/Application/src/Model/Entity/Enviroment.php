<?php
namespace Application\Model\Entity;

class Enviroment{
	//Mensajes
	const MSG_SAVE = 'Se ha guardado el registro satisfacoriamente.';
	const MSG_UPDATE = 'Se ha actualizado el registro satisfacoriamente.';
	const MSG_DELETE = 'Se ha eliminado el registro satisfacoriamente.';
	const MSG_ERROR = 'Se ha producido un error, intente en unos minutos o ponganse en contacto con el administrador.';
	const NOT_FIND = 'El registro que buscaba no se ha encontrado.';

	//Default AJAX RESPONSE jQuery
	const AJAX_RESPONSE = [
			'success' =>  false,
			'message' => 'No tiene los permisos para acceder a la informacion de esta pagina.'
		];

	//Settings Plugin Datatable jQuery
	const DRAW = 15;

	public static function GetDate(){
		$date = getdate();
		return sprintf('%s-%s-%s', $date['year'], $date['mon'], $date['mday']);
	}
}
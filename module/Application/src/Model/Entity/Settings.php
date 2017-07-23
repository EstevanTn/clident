<?php
/**
 * Apps TunaquiSoft (http://apps-tnqsoft.azurewebsites.net/)
 * -------------------------------------------------------------------------------
 * This file is part of the clident project.
 *
 * @autor @EstevanTn
 * @email tunaqui@outlook.es
 * @copyright Copyright © 2017 - TunaquiSoft
 * @website http://apps-tnqsoft.azurewebsites.net/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 22/07/2017
 **/

namespace Application\Model\Entity;


class Settings extends IEntity
{
    var $ID_AJUSTE;
    var $NOMBRE;
    var $VALOR;

    public  function exchangeArray(array $data)
    {
        $this->ID_AJUSTE = isset($data['ID_AJUSTE']) ? $data['ID_AJUSTE'] : null;
        $this->NOMBRE = isset($data['NOMBRE']) ? $data['NOMBRE'] : null;
        $this->VALOR = isset($data['VALOR']) ? $data['VALOR'] : null;
    }
    public static  function getColumnNames()
    {
        return [
            'ID_AJUSTE',
            'NOMBRE',
            'VALOR'
        ];
    }
}
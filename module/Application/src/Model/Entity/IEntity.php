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
 * Date: 18/07/2017 - 12:29
 **/

namespace Application\Model\Entity;


use function get_object_vars;

abstract class IEntity
{
    public abstract function exchangeArray(array $data);
    public static abstract function getColumnNames();
    public function getArrayCopy(){
        return get_object_vars($this);
    }
}
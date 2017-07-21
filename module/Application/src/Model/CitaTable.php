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
 * Date: 18/07/2017 - 14:30
 **/

namespace Application\Model;


use Application\Model\Entity\Enviroment;
use Application\Model\Entity\Persona;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;

class CitaTable extends BaseTable
{
    public function  __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function save($userId, $data)
    {
        try{
            $id = (int) $data['ID_CITA'];
            $dataX = [
                'ID_DENTISTA' => $data['ID_DENTISTA'],
                'ID_PACIENTE' => $data['ID_PACIENTE'],
                'FECHA_CITA' => $data['FECHA_CITA'],
                'HORA_INICIO' => $data['HORA_INICIO'],
                'HORA_FIN' => $data['HORA_FIN'],
                'TIPO_CITA' => $data['TIPO_CITA'],
                'ESTADO' => $data['ESTADO'],
                'NOTA' => $data['NOTA']
            ];
            if($id===0){
                $dataX['ACTIVE'] = true;
                $dataX['USUARIO_CREACION'] = Enviroment::GetCookieValue('ID_USUARIO');
                $dataX['FECHA_CREACION'] =  Enviroment::GetDate() ;
                $this->tableGateway->insert($dataX);
                return [
                    'success' => true,
                    'message' => Enviroment::MSG_DELETE,
                ];
            }else{
                $dataX['USUARIO_MODIFICACION'] = Enviroment::GetCookieValue('ID_USUARIO');
                $dataX['FECHA_MODIFICACION'] =  Enviroment::GetDate() ;
                $this->tableGateway->update($dataX, ['ID_CITA' => $id]);
                return [
                    'success' => true,
                    'message' => Enviroment::MSG_UPDATE,
                ];
            }
        }catch (\Exception $ex){
            return [
                'success' => false,
                'message' => Enviroment::MSG_ERROR.': '.$ex->getMessage(),
            ];
        }
    }

    public function fetchAll($where = ['ACTIVE' => true])
    {
        $select = new Select('cita');
        $select->join('paciente', 'cita.ID_PACIENTE=paciente.ID_PACIENTE',['ID_PACIENTE', 'ID_PERSONA'])
            ->join('persona', 'paciente.ID_PERSONA=persona.ID_PERSONA', Persona::getVarNames())
            ->where($where);
        $resultSet = $this->tableGateway->selectWith($select);
        return $this->toEntries($resultSet);
    }
}
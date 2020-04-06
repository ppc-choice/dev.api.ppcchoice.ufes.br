<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class DisciplinaCtl extends API_Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function getById($numDisciplina)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));

        $qb = $this->entity_manager->createQueryBuilder()
            ->select('d.nome, d.ch, d.codDepto, dep.nome')
            ->from('Entities\Disciplina', 'd')
            ->innerJoin('d.departamento', 'dep')
            ->where('d.numDisciplina = ' . $numDisciplina)
            ->getQuery();

        $r = $qb->getResult();
        $result = $this->doctrine_to_array($r);

        if ( !is_null($result) ){
            $this->api_return(array(
                'status' => true,
                'result' => $result,
            ), 200);
        } else {
            $this->api_return(array(
                'status' => false,
                'message' => 'Não Encontrado',
            ), 200);
        }
    }
}
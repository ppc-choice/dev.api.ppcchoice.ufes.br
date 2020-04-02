<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class DisciplinaCtl extends API_Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function listDisciplina($numDisciplina)
    {
        $disciplina = $this->entity_manager->createQueryBuilder()
            ->select('d.nome, d.ch, d.codDepto')
            ->from('Entities\Disciplina', 'd')
            ->where('d.numDisciplina = ' . $numDisciplina)
            ->getQuery()->getResult();

        /*
           createQuery(
                'SELECT d.nome, d.ch, d.codDepto
                FROM Entities\Disciplina d
                WHERE d.numDisciplina = ' . $numDisciplina
            )
            ->getResult();
        */

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));

        $this->api_return(array(
            'status' => true,
            'result' => $this->doctrine_to_array($disciplina),
        ), 200);
    }
}
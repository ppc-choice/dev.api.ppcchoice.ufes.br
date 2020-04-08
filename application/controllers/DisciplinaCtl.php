<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class DisciplinaCtl extends API_Controller
{

    /**
     * @api {get} /disciplinas Listar todas as Disciplinas dos Departamentos
     * @apiName getAll
     * @apiGroup Disciplinas
     * @apiError 404 Não encontrado
     *
     *
     * @apiSuccess {Number} numDisciplina Codigo único de cada Disciplina.
     * @apiSuccess {String} nome Nome da Disciplina.
     * @apiSuccess {Number} ch Carga Horária da Disciplina.
     * @apiSuccess {Number} codDepto Código do Departamento cujo qual a Disciplina pertence.
     * @apiSuccess {String} nomeDepto Nome do Departamento cujo qual a Disciplina pertence.
     */
    public function getAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));

        $result = $this->entity_manager->getRepository('Entities\Disciplina')->findAll();

        if ( !empty($result) ){
            $this->api_return(array(
                'status' => true,
                'result' => $result
            ), 200);
        } else {
            $this->api_return(array(
                'status' => false,
                'message' => 'Não Encontrado'
            ), 404  );
        }
    }

    /**
     * @api {get} /disciplinas/:numDisciplina Listar todas as Disciplinas dos Departamentos
     * @apiName getAll
     * @apiGroup Disciplinas
     * @apiError 404 Não encontrado
     *
     * @apiParam {Number} numDisciplina Codigo único de uma Disciplina.
     * @apiParam {Number} codDepto Código do Departamento cujo qual a Disciplina pertence.
     *
     * @apiSuccess {String} nome Nome da Disciplina.
     * @apiSuccess {Number} ch Carga Horária da Disciplina.
     * @apiSuccess {String} nomeDepto Nome do Departamento cujo qual a Disciplina pertence.
     */
    public function getById($numDisciplina, $codDepto)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));

        $result = $this->entity_manager->getRepository('Entities\Disciplina')->findById($numDisciplina, $codDepto);

        if ( !empty($result) ){
            $this->api_return(array(
                'status' => true,
                'result' => $result
            ), 200);
        } else {
            $this->api_return(array(
                'status' => false,
                'message' => 'Não Encontrado'
            ), 404);
        }
    }
}
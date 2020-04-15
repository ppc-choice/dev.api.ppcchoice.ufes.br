<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class DisciplinaController extends API_Controller
{

    /**
     * @api {get} /disciplinas Listar todas as Disciplinas dos Departamentos
     * @apiName findAll
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
    public function findAll()
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
            ), 404);
        }
    }

    /**
     * @api {get} /disciplinas/:numDisciplina Listar todas as Disciplinas dos Departamentos
     * @apiName findById
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
    public function findById($codDepto, $numDisciplina)
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

    /**
     * @api {post} disciplinas Cadastrar nova Disciplina no sistema
     * @apiName add
     * @apiGroup Disciplinas
     * @apiError 400 Campo Obrigatório Não Encontrado
     *
     * @apiSuccess {Number} numDisciplina Primeiro identificador da disciplina.
     * @apiSuccess {String} nome Nome da Disciplina.
     * @apiSuccess {Number} ch Carga Horária da Disciplina.
     * @apiSuccess {Number} codDepto Segundo identificador da disciplina e código do Departamento que ela pertence.
     */
    public function add()
    {
        $this->_apiconfig(array(
            'methods' => array('POST')
        ));

        $payload = json_decode(file_get_contents('php://input'), TRUE);

        if ( isset($payload['numDisciplina']) && isset($payload['ch'])
                && isset($payload['nome']) && isset($payload['codDepto']) ){

            $disciplina = new \Entities\Disciplina;
            $disciplina->setNumDisciplina($payload['numDisciplina']);
            $disciplina->setCh($payload['ch']);
            $disciplina->setNome($payload['nome']);

            $depto = $this->entity_manager->find('Entities\Departamento', $payload['codDepto']);

            if ( !is_null($depto) ){
                $disciplina->setDepartamento($depto);
                $disciplina->setCodDepto($payload['codDepto']);
            } else {
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => 'Campo Obrigatório Não Encontrado'
                ), 400);
            }

            try {
                $this->entity_manager->persist($disciplina);
                $this->entity_manager->flush();
    
                $this->api_return(array(
                    'status' => TRUE,
                    'message' => 'Disciplina Criada Com Sucesso',
                ), 200);
            } catch (\Exception $e){
                echo $e->getMessage();
            }

        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Campo Obrigatório Não Encontrado'
            ), 400);
        }
    }
}
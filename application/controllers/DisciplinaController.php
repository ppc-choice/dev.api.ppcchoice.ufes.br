<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class DisciplinaController extends API_Controller
{

    /**
     * @api {get} disciplinas Listar todas as Disciplinas dos Departamentos
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
     * @api {get} disciplinas/:codDepto/:numDisciplina Listar todas as Disciplinas dos Departamentos
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
     * @apiError 400 Departamento Não Encontrado
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

                try {
                    $this->entity_manager->persist($disciplina);
                    $this->entity_manager->flush();
        
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => 'Disciplina Criada Com Sucesso',
                    ), 200);
                } catch (\Exception $e){
                    $msg =  $e->getMessage();
                    $this->api_return(array(
                        'status' => FALSE,
                        'message' => $msg,
                    ), 400);
                }
                               
            } else {
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => 'Departamento Não Encontrado'
                ), 400);
            }

        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Campo Obrigatório Não Encontrado'
            ), 400);
        }
    }

    /**
     * @api {put} disciplinas/:codDepto/:numDisciplina Atualizar uma Disciplina específica
     * @apiName update
     * @apiGroup Disciplinas
     * @apiError 404 Não encontrado
     * @apiError 400 Requisição nula
     *
     * @apiParam {Number} numDisciplina Codigo único de uma Disciplina.
     * @apiParam {Number} codDepto Código do Departamento cujo qual a Disciplina pertence.
     *
     * @apiSuccess {String} nome Nome da Disciplina.
     * @apiSuccess {Number} ch Carga Horária da Disciplina.
     */
    public function update($codDepto, $numDisciplina)
    {
        $this->_apiconfig(array(
            'methods' => array('PUT')
        ));

        $disciplina = $this->entity_manager->find('Entities\Disciplina', 
        array('codDepto' => $codDepto, 'numDisciplina' => $numDisciplina));

        $payload = json_decode(file_get_contents('php://input'), TRUE);

        if ( !is_null($disciplina) && !empty($payload) ){

            if ( isset($payload['nome']) ) $disciplina->setNome($payload['nome']);

            if ( isset($payload['ch']) ) $disciplina->setCh($payload['ch']);

            try {
                $this->entity_manager->merge($disciplina);
                $this->entity_manager->flush();
    
                $this->api_return(array(
                    'status' => TRUE,
                    'message' => 'Disciplina Atualizada Com Sucesso',
                ), 200);
            } catch (\Exception $e){
                $msg =  $e->getMessage();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $msg,
                ), 400);
            }

        } elseif ( empty($payload) ){
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Não há requisição',
            ), 400);
            
        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Disciplina não encontrada',
            ), 404);
        }
    }

    /**
     * @api {delete} disciplinas/:codDepto/:numDisciplina Remover uma Disciplina específica
     * @apiName delete
     * @apiGroup Disciplinas
     * @apiError 404 Não encontrado
     * @apiError 400 Requisição nula
     *
     * @apiParam {Number} numDisciplina Codigo único de uma Disciplina.
     * @apiParam {Number} codDepto Código do Departamento cujo qual a Disciplina pertence.
     *
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Disciplina Removida com Sucesso"
     *     }
     */
    public function delete($codDepto, $numDisciplina)
    {
        $this->_apiconfig(array(
            'methods' => array('DELETE')
        ));

        $disciplina = $this->entity_manager->find('Entities\Disciplina', 
        array('codDepto' => $codDepto, 'numDisciplina' => $numDisciplina));

        if ( !is_null($disciplina) ){

            try {
                $this->entity_manager->remove($disciplina);
                $this->entity_manager->flush();
                $this->api_return(array(
                    'status' => TRUE,
                    'message' => 'Disciplina Removida com Sucesso'
                ), 200);
            
            } catch ( \Exception $e ){
                $e_msg = $e->getMessage();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $e_msg
                ), 400);
            } 

        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Disciplina não Encontrada'
            ), 404);
        }
    }
}
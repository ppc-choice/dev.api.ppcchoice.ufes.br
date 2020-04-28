<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class DisciplinaController extends API_Controller
{

    /**
     * @api {get} disciplinas Solicitar dados de todas as disciplinas
     * @apiName findAll
     * @apiGroup Disciplina
     *
     * @apiSuccess {Number} numDisciplina Identificador único da disciplina.
     * @apiSuccess {String} nome Nome da disciplina.
     * @apiSuccess {Number} ch Carga horária da disciplina.
     * @apiSuccess {Number} codDepto Código do departamento cujo qual a disciplina está vinculada.
     * @apiSuccess {String} nomeDepto Nome do departamento cujo qual a disciplina está vinculada.
     * 
     * @apiError {String[]} 404 Nenhuma disciplina foi encontrada.
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
            ), self::HTTP_OK);
        } else {
            $this->api_return(array(
                'status' => false,
                'message' => array("Disciplinas não encontradas.")
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {get} disciplinas/:codDepto/:numDisciplina Solicitar dados de uma disciplina
     * @apiName findById
     * @apiGroup Disciplina
     *
     * @apiParam {Number} numDisciplina Identificador único da disciplina.
     * @apiParam {Number} codDepto Código do departamento cujo qual a disciplina está vinculada.
     *
     * @apiSuccess {String} nome Nome da disciplina.
     * @apiSuccess {Number} ch Carga horária da disciplina.
     * @apiSuccess {String} nomeDepto Nome do departamento cujo qual a disciplina está vinculada.
     * 
     * @apiError {String[]} 404 O <code>codDepto</code> e <code>numDisciplina</code> não correspondem a uma disciplina cadastrada.
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
            ), self::HTTP_OK);
        } else {
            $this->api_return(array(
                'status' => false,
                'message' => array("Disciplina não encontrada.")
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {post} disciplinas Criar uma disciplina
     * @apiName create
     * @apiGroup Disciplina
     *
     * @apiParam (Request Body/JSON) {Number} numDisciplina Identificador primário da disciplina.
     * @apiParam (Request Body/JSON) {String} nome Nome da disciplina.
     * @apiParam (Request Body/JSON) {Number} ch Carga horária da disciplina.
     * @apiParam (Request Body/JSON) {Number} codDepto Identificador secundário da disciplina (identificador primário do departamento que ela está vinculada).
     * 
     * @apiSuccess {String} message Disciplina criada com sucesso.
     * 
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function create()
    {
        header("Access-Controll-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('POST')
        ));

        $payload = json_decode(file_get_contents('php://input'), TRUE);

        $disciplina = new \Entities\Disciplina;

        if ( array_key_exists('numDisciplina', $payload) )  $disciplina->setNumDisciplina($payload['numDisciplina']);
        if ( array_key_exists('ch', $payload) )             $disciplina->setCh($payload['ch']);
        if ( array_key_exists('nome', $payload) )           $disciplina->setNome($payload['nome']);

        if ( array_key_exists('codDepto', $payload) ){
            $depto = $this->entity_manager->find('Entities\Departamento', $payload['codDepto']);
            $disciplina->setDepartamento($depto);
            $disciplina->setCodDepto($payload['codDepto']);
        }

        $constraints = $this->validator->validate($disciplina);

        if ( $constraints->count() ){
            $msgViolacoes = $constraints->messageArray();
            $this->api_return(array(
                'status' => FALSE,
                'message' => $msgViolacoes
            ), self::HTTP_BAD_REQUEST);
    
        } else {
            try {
                $this->entity_manager->persist($disciplina);
                $this->entity_manager->flush();
            
                $this->api_return(array(
                    'status' => TRUE,
                    'message' => array("Disciplina criada com sucesso."),
                ), self::HTTP_OK);
                
            } catch (\Exception $e){
                $msgExcecao =  array($e->getMessage());
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $msgExcecao,
                ), self::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @api {put} disciplinas/:codDepto/:numDisciplina Atualizar dados de uma disciplina
     * @apiName update
     * @apiGroup Disciplina
     *
     * @apiParam {Number} numDisciplina Identificador único de uma disciplina.
     * @apiParam {Number} codDepto Código do departamento cujo qual a disciplina está vinculada.
     * @apiParam (Request Body/JSON) {String} nome Nome da disciplina.
     * @apiParam (Request Body/JSON) {Number} ch Carga horária da disciplina.
     * 
     * @apiSuccess {String} message Disciplina atualizada com sucesso.
     * 
     * @apiError {String[]} 404 O <code>codDepto</code> e <code>numDisciplina</code> não correspondem a uma disciplina cadastrada.
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function update($codDepto, $numDisciplina)
    {
        header("Access-Controll-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('PUT')
        ));

        $disciplina = $this->entity_manager->find('Entities\Disciplina', 
            array('codDepto' => $codDepto, 'numDisciplina' => $numDisciplina));
        $payload = json_decode(file_get_contents('php://input'), TRUE);

        if ( !is_null($disciplina) ){
            if ( array_key_exists('nome', $payload) )   $disciplina->setNome($payload['nome']);
            if ( array_key_exists('ch', $payload) )     $disciplina->setCh($payload['ch']);
                
            $constraints = $this->validator->validate($disciplina);

            if ( $constraints->count() ){
                $msgViolacoes = $constraints->messageArray();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $msgViolacoes
                ), self::HTTP_BAD_REQUEST);

            }else{
                try {
                    $this->entity_manager->merge($disciplina);
                    $this->entity_manager->flush();
        
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => array("Disciplina atualizada com sucesso."),
                    ), self::HTTP_OK);
                } catch (\Exception $e){
                    $msgExcecao =  array($e->getMessage());
                    $this->api_return(array(
                        'status' => FALSE,
                        'message' => $msgExcecao,
                    ), self::HTTP_BAD_REQUEST);
                }
            }
        
        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => array("Disciplina não encontrada."),
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {delete} disciplinas/:codDepto/:numDisciplina Excluir uma disciplina
     * @apiName delete
     * @apiGroup Disciplina
     *
     * @apiParam {Number} numDisciplina Identificador único da disciplina.
     * @apiParam {Number} codDepto Código do departamento cujo qual a disciplina está vinculada.
     *
     * @apiSuccess {String} message Disciplina deletada com sucesso.
     * 
     * @apiError {String[]} 404 O <code>codDepto</code> e <code>numDisciplina</code> não correspondem a uma disciplina cadastrada.
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function delete($codDepto, $numDisciplina)
    {
        header("Access-Controll-Allow-Origin: *");

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
                    'message' => array("Disciplina deletada com sucesso.")
                ), self::HTTP_OK);
            
            } catch ( \Exception $e ){
                $msgExcecao = array($e->getMessage());
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $msgExcecao
                ), self::HTTP_BAD_REQUEST);
            }

        } else {
            $this->api_return(array(
                'status' => FALSE,
                'message' => array("Disciplina não encontrada.")
            ), self::HTTP_NOT_FOUND);
        }
    }
}
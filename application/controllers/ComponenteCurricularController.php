<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class ComponenteCurricularController extends API_Controller {

    
    /**
     * @api {get} componentes-curriculares Listar todas as componentes curriculares
     * @apiName findAll
     * @apiGroup Componente Curricular
     *
     * @apiSuccess {ComponenteCurricular[]} ComponentesCurriculares Array de objetos do tipo ComponenteCurricular.
     * 
     * @apiError {String[]} 404 Nenhuma componente curricular encontrada.
     */
    public function findAll()
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));
    
        $compCurric = $this->entity_manager->getRepository('Entities\ComponenteCurricular')->findAll();
        
        if(!empty($compCurric))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $compCurric
                ),self::HTTP_OK
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  array('Nenhuma componente curricular encontrada!')
                ),self::HTTP_NOT_FOUND
            );
        }
        
    }
    /**
     * @api {get} projetos-pedagogicos-curso/:codPpc/componentes-curriculares Listar todas componentes curriculares de um PPC, ordenados por período e componente curricular
     * @apiName findByCodPpc
     * @apiGroup Componente Curricular
     * 
     * @apiParam {Number} codPpc Código de projeto pedagógico de curso (PPC).
     * 
     * @apiSuccess {ComponenteCurricular[]} ComponentesCurriculares Array de objetos do tipo ComponenteCurricular.
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {String} nome Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} ch Carga horária da disciplina da componente curricular.
     * @apiSuccess {Number} periodo Período da componente curricular.
     * 
     * @apiError {String[]} 404 O <code>codPpc</code> não corresponde a um ppc cadastrado.
     */
	public function findByCodPpc($codPpc)
	{
        
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));
                
        $compCurric = $this->entity_manager->getRepository('Entities\ComponenteCurricular')->findByCodPpc($codPpc);   
        
        if(!empty($compCurric))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $compCurric
                ),self::HTTP_OK
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  array('Não foram encontradas componentes curriculares para o ppc solicitado.')
                ),self::HTTP_NOT_FOUND
            );
        }
    }
    
    /**
     * @api {get} componentes-curriculares/:codCompCurric Requisitar uma componente curricular
     * @apiName findByCodCompCurric
     * @apiGroup Componente Curricular
     * 
     * @apiParam {Number} codCompCurric Código de componente curricular.
     *
     * @apiSuccess {String} nome Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {Number} ch Carga horária da disciplina.
     * @apiSuccess {Number} periodo Número do período da componente curricular.
     * @apiSuccess {Number} credito Crédito da componente curricular.
     * @apiSuccess {Number} codDepto Código do departamento.
     * @apiSuccess {String} codDisc Código da disciplina.
     * @apiSuccess {Number} codPpc Código do projeto pedagógico de curso o qual a componente pertence.
     * 
     * @apiError {String[]} 404 O <code>codCompCurric</code> não corresponde a uma componente curricular cadastrada.
     */
	public function findByCodCompCurric($codCompCurric)
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));

                
        $compCurric = $this->entity_manager->getRepository('Entities\ComponenteCurricular')->findByCodCompCurric($codCompCurric);  
                
        if(!empty($compCurric))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $compCurric
                ),self::HTTP_OK
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  array('Componente curricular não encontrada.')
                ),self::HTTP_NOT_FOUND
            );
        }
        
    }

    /**
     * @api {post} componentes-curriculares Criar Componente Curricular
     * @apiName create
     * @apiGroup Componente Curricular
     * 
     * @apiParam (Request Body/JSON) {String} periodo  Período da componente.
     * @apiParam (Request Body/JSON) {String} credito  Crédito da componente.
     * @apiParam (Request Body/JSON) {String} tipo  Tipo da componente.
     * @apiParam (Request Body/JSON) {String} codDepto  Código do departamento.
     * @apiParam (Request Body/JSON) {String} numDisciplina  Número da disicplina.
     * @apiParam (Request Body/JSON) {String} codPpc  Código do ppc.
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Componente curricular criada com sucesso"
     *     }
     * 
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function create()
    {
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
            'methods' => array('POST'),
            // 'limit' => array(2,'ip','everyday'),
            // 'requireAuthorization' => TRUE
            )
        );

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $compCurric = new Entities\ComponenteCurricular;

        if(isset($payload['periodo'])) $compCurric->setPeriodo($payload['periodo']);
        if(isset($payload['credito'])) $compCurric->setCredito($payload['credito']);
        if(isset($payload['tipo'])) $compCurric->setTipo($payload['tipo']);
        if(isset($payload['numDisciplina'], $payload['codDepto'])) 
        {
            $disciplina = $this->entity_manager->find('Entities\Disciplina',
            array('numDisciplina' => $payload['numDisciplina'], 'codDepto' => $payload['codDepto']));
            $compCurric->setDisciplina($disciplina );
        }
        if(isset($payload['codPpc']))
        {
            $ppc =  $this->entity_manager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpc']);
            $compCurric->setPpc($ppc);
        }

        $validador = $this->validator->validate($compCurric);
        if($validador->count())
        {
            $message = $validador->messageArray();
            $this->api_return(array(
                'status' => FALSE,
                'message' => $message
            ), self::HTTP_BAD_REQUEST);
        }else{
            try{
                $this->entity_manager->persist($compCurric);
                $this->entity_manager->flush();

                $this->api_return(array(
                    'status' => TRUE,
                    'message' => array('Componente curricular criada com sucesso.'),
                ), self::HTTP_OK);
            } catch (\Exception $e) {
                $eMsg = array($e->getMessage());
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $eMsg
                ), self::HTTP_BAD_REQUEST);
            }
        }
    }
 
    /**
     * @api {put} componentes-curriculares/:codCompCurric Atualizar Componente Curricular
     * @apiName update
     * @apiGroup Componente Curricular
     * 
     * @apiParam {Number} codCompCurric Código de componente curricular.
     * @apiParam (Request Body/JSON) {String} periodo  Período da componente.
     * @apiParam (Request Body/JSON) {String} credito  Crédito da componente.
     * @apiParam (Request Body/JSON) {String} tipo  Tipo da componente.
     * @apiParam (Request Body/JSON) {String} codDepto  Código do departamento.
     * @apiParam (Request Body/JSON) {String} numDisciplina  Número da disicplina.
     * @apiParam (Request Body/JSON) {String} codPpc  Código do ppc.
     * 
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Componente curricular atualizada com sucesso."
     *     }
     * 
     * @apiError {String[]} 404 O <code>codCompCurric</code> não corresponde a uma componente curricular cadastrada.
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function update($codCompCurric)
    {
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
            'methods' => array('PUT'),
            // 'limit' => array(2,'ip','everyday'),
            // 'requireAuthorization' => TRUE
            )
        );

        $compCurric = $this->entity_manager->find('Entities\ComponenteCurricular',$codCompCurric);
        $payload = json_decode(file_get_contents('php://input'),TRUE);

        if(!is_null($compCurric))
        {
            if(isset($payload['codPpc']))
            {
                $ppc = $this->entity_manager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpc']);
                $compCurric->setPpc($ppc);
            }
            if(isset($payload['numDisciplina'],$payload['codDepto']))
            {
                $disciplina = $this->entity_manager->find('Entities\Disciplina',
                    array('numDisciplina' => $payload['numDisciplina'], 'codDepto' => $payload['codDepto']));
                $compCurric->setDisciplina($disciplina);
            }
            if(isset($payload['periodo']))
            {
                $compCurric->setPeriodo($payload['periodo']);
            }
            if(isset($payload['credito']))
            {
                $compCurric->setCredito($payload['credito']);
            }
            if(isset($payload['tipo']))
            {
                $compCurric->setTipo($payload['tipo']);
            }
            
            $validador = $this->validator->validate($compCurric);
            if($validador->count())
            {
                $message = $validador->messageArray();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $message
                ), self::HTTP_BAD_REQUEST);
            }else{
                try {
                    $this->entity_manager->merge($compCurric);
                    $this->entity_manager->flush();
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => array('Componente Curricular atualizada com sucesso')
                    ),self::HTTP_OK);
                } catch (\Exception $e) {
                    $eMsg = array($e->getMessage());
                    $this->api_return(array(
                        'status' => FALSE,
                        'message' => $eMsg
                    ), self::HTTP_BAD_REQUEST);
                }
            }
        }else{ 
            $this->api_return(array(
                'status' => FALSE,
                'message' => array('Componente Curricular não encontrada'),
            ),self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {delete} componentes-curriculares/:codCompCurric Deletar Componente Curricular
     * @apiName delete
     * @apiGroup Componente Curricular
     * 
     * @apiParam {Number} codCompCurric Código de componente curricular.
     * 
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Componente curricular removida com sucesso"
     *     }
     * 
     * @apiError {String[]} 404 O <code>codCompCurric</code> não corresponde a uma componente curricular cadastrada.
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function delete($codCompCurric)
    {
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
            'methods' => array('DELETE'),
            )
        );

        $compCurric = $this->entity_manager->find('Entities\ComponenteCurricular',$codCompCurric);
        if(!is_null($compCurric))
        {
            try {
                $this->entity_manager->remove($compCurric);
                $this->entity_manager->flush();
                $this->api_return(array(
                    'status' => TRUE,
                    'message' => array('Componente Curricular removida com sucesso')
                ), self::HTTP_OK);
            } catch (\Exception $e) {
                $eMsg = array($e->getMessage());
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $eMsg
                ), self::HTTP_BAD_REQUEST);
            }
        }else{ 
            $this->api_return(array(
                'status' => FALSE,
                'message' => array('Componente Curricular não encontrada'),
            ),self::HTTP_NOT_FOUND);
        }
    }

}

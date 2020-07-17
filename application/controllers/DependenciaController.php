<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class DependenciaController extends APIController
{
    public function __construct() {
        parent::__construct();
    }

    /**
    * @api {GET} dependencias Solicitar todas dependências existentes entre componentes curriculares.
    *
    * @apiName findAll
    * @apiGroup Dependência
    *
    * @apiSuccess {Dependencia[]} dependencia Array de objetos do tipo depenência.
    *
    * @apiError {String[]} error Entities\\Dependencia: Instância não encontrada.
    */
    public function findAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));
        
        $colecaoDependencia = $this->entityManager->getRepository('Entities\Dependencia')->findAll();        
        
        if(!empty($colecaoDependencia)){
            $this->apiReturn($colecaoDependencia,
                self::HTTP_OK
            );
        }else
        {
            $this->apiReturn(
                array(
                    'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
                ), self::HTTP_NOT_FOUND
            );
        }   
    }

    /**
    * @api {GET} dependencias/:codCompCurric/:codPreReq Solicitar dependências entre componentes curriculares.
    * @apiParam (URL) {Number} codCompCurric Código de identificação de uma componente curricular.
    * @apiParam (URL) {Number} codPreReq Código de identificação de uma componente curricular que é pré-requisito.
    *
    * @apiName findById
    * @apiGroup Dependência
    *
    * @apiSuccess {String} nomeCurso Nome do curso que a componente curricular pertence.
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {String} nomeCompCurric Nome da componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    * @apiSuccess {String} nomePreReq Nome do pré-requisito da componente curricular.
    *     
    * @apiError {String[]} error Entities\\Dependencia: Instância não encontrada.
    */
    public function findById($codCompCurric, $codPreRequisito)
    {
        
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));
        
        $dependencia = $this->entityManager->getRepository('Entities\Dependencia')->findById($codCompCurric, $codPreRequisito);

        if(!empty($dependencia)){
            $this->apiReturn($dependencia,
                self::HTTP_OK
            ); 
        }else{
            
            $this->apiReturn(
                array(
                    'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
                ), self::HTTP_NOT_FOUND
            );
        }
    }  


    /**
    * @api {GET} projetos-pedagogicos-curso/:codPpc/dependencias Solicitar todas dependências entre componentes as curriculares de um Projeto Pedagógico de Curso.
    * @apiParam (URL) {Number} codPpc Código identificador de um projeto pedagógico de curso.
    * @apiParam (URL) {bool} allowEmpty Parâmetro que informa se o método deve retornar um array de Depêndencias vazio.
    * @apiParam (URL) {bool} senseConnection Parâmetro que informa se o método deve retornar uma string de sentido da dependencia concatenada ao seu respectivo código.
    *
    * @apiName findByCodPpc
    * @apiGroup Dependência
    *
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    *
    * @apiError {String[]} error Entities\\Dependencia: Instância não encontrada.
    */
    public function findByCodPpc($codPpc)
    {
        
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));
    
        $colecaoDependencia = $this->entityManager->getRepository('Entities\Dependencia')->findByCodPpc($codPpc);
        
        $senseConnection = $this->input->get('senseConnection');

        if(!empty($colecaoDependencia)){
            $colecaoDependencia = $this->doctrineToArray($colecaoDependencia);

            if( $senseConnection === "true" ){
                $sentidoDependencia= array();

                foreach ( $colecaoDependencia as $key => $dependencia ) {
                  
                    $sentidoDependencia[$key]['uuids']= array();
                    array_push($sentidoDependencia[$key]['uuids'], $dependencia['codPreRequisito'] . SENTIDO_PREREQUISITO);
                    array_push($sentidoDependencia[$key]['uuids'], $dependencia['codCompCurric'] . SENTIDO_COMPCURRIC);
                                      
                }    
                
                // echo var_dump($sentidoDependencia);
                $this->apiReturn($sentidoDependencia,
                self::HTTP_OK 
                ); 

            }else{
                $this->apiReturn($colecaoDependencia,
                self::HTTP_OK 
                ); 
            }

        }else{
            
            $allowEmpty = strtolower($this->input->get('allowEmpty'));
            
            if( $allowEmpty === "true" ){
                
                $this->apiReturn($colecaoDependencia,
                    self::HTTP_OK 
                ); 
                
            }else{

                $this->apiReturn(
                    array(
                        'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
                    ), self::HTTP_NOT_FOUND 
                );
            }
        }
    } 

    /**
    * @api {POST} dependencias Criar uma nova dependência entre componentes curriculares.
    * @apiParam (Request Body/JSON) {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiParam (Request Body/JSON) {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    *
    * @apiName create
    * @apiGroup Dependência
    *
    * 
    * @apiSuccess {String[]} message Entities\\Dependencia: Instância criada com sucesso.
    *
    * @apiError {String[]} error Entities\\Dependencia: Instância não encontrada.
	*/
    public function create()
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('POST'),
			)
		);

		$payload = json_decode(file_get_contents('php://input'),TRUE);
        $dependencia = new Entities\Dependencia();
        
        if ( isset($payload['codCompCurric'])){

            $componenteCurricular = $this->entityManager->find('Entities\ComponenteCurricular', $payload['codCompCurric']);
            $dependencia->setComponenteCurricular($componenteCurricular);
        }

        if( isset($payload['codPreRequisito'])){

            $preRequisito = $this->entityManager->find('Entities\ComponenteCurricular', $payload['codPreRequisito']);
            $dependencia->setPreRequisito($preRequisito);
        }

        $constraints = $this->validator->validate($dependencia);

        if ( $constraints->success() ){
            try{
                $this->entityManager->persist($dependencia);
                $this->entityManager->flush();

                $this->apiReturn(array(
                    'message' => $this->getApiMessage(STD_MSG_CREATED),
                    ), self::HTTP_OK 
                );

            }catch ( \Exception $e ){
                $this->apiReturn(array(
                    'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
                    ), self::HTTP_BAD_REQUEST 
                );
            }
        }else{
            $this->apiReturn(array(
                'error' => $constraints->messageArray(),
                ), self::HTTP_BAD_REQUEST 
            );
        }
    }

    /**
    * @api {PUT} dependencias/:codCompCurric/:codPreReq Atualizar depêndencia entre componentes curriculares.
    * @apiParam (URL) {Number} codCompCurric Código de identificação de uma componente curricular.
    * @apiParam (URL) {Number} codPreReq Código de identificação de uma componente curricular que é pré-requisito.
    * @apiParam (Request Body/JSON ) {Number} [codCompCurric] Código identificador de uma componente curricular.
    * @apiParam (Request Body/JSON ) {Number} [codPreRequisito] Código identificador de uma componente curricular que é pré-requisito.
    *
    * @apiName update
    * @apiGroup Dependência
    *
    *
    * @apiSuccess {String[]} message Entities\\Dependencia: Instância atualizada com sucesso.
    *
    * @apiError {String[]} error Entities\\Dependencia: Instância não encontrada.
    * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
    */
    public function update($codCompCurric, $codPreRequisito)
	{
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('PUT'),
            )
        );

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $dependencia = $this->entityManager->find('Entities\Dependencia',
        	array('componenteCurricular' => $codCompCurric, 'preRequisito' => $codPreRequisito));
        
        //Verifica se  existe dependencia entre as componentes curriculares 
        if(!is_null($dependencia)){

            if(array_key_exists('codCompCurric', $payload)){
                if(isset($payload['codCompCurric'])){
                    $componenteCurricular = $this->entityManager->find('Entities\ComponenteCurricular', $payload['codCompCurric']);
                }else{
                    $componenteCurricular = null;    
                }
                $dependencia->setComponenteCurricular($componenteCurricular);
            }
            
            if(array_key_exists('codPreRequisito', $payload)){       
                if(isset($payload['codPreRequisito'])){
                    $preRequisito = $this->entityManager->find('Entities\ComponenteCurricular', $payload['codPreRequisito']);
                }else{
                    $preRequisito = null;    
                }
                $dependencia->setPreRequisito($preRequisito);
            }
            
            $constraints = $this->validator->validate($dependencia);
            
            if ($constraints->success()){

                try{
                    $this->entityManager->merge($dependencia);
                    $this->entityManager->flush();
                                
                    $this->apiReturn(array(
                        'message' => $this->getApiMessage(STD_MSG_UPDATED),
                        ), self::HTTP_OK 
                    );

                } catch (\Exception $e){
                    $this->apiReturn(array(
                        'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
                        ), self::HTTP_BAD_REQUEST 
                    );
                }
                
            }else{
                $this->apiReturn(array(
                    'error' => $constraints->messageArray(),
                    ), self::HTTP_BAD_REQUEST
                );
            }
        
        }else{
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
                ), self::HTTP_NOT_FOUND 
            );
        }
    }

    /**
    * @api {DELETE} dependencias/:codCompCurric/:codPreReq Deletar dependência entre componentes curriculares.
    * @apiParam (URL) {Number} codCompCurric Código de identificação de uma componente curricular.
    * @apiParam (URL) {Number} codPreReq Código de identificação de uma componente curricular que é pré-requisito.
    *
    * @apiName delete
    * @apiGroup Dependência
    *
    * @apiSuccess {Number} codCompCurric Código identificador de uma componente curricular.
    * @apiSuccess {Number} codPreRequisito Código identificador de uma componente curricular que é pré-requisito.
    *
    * @apiSuccess {String[]} message Entities\\Dependencia: Instância removida com sucesso.
    *
    * @apiError {String[]} error  Entities\\Dependencia: Instância não encontrada.
    */
    public function delete($codCompCurric, $codPreRequisito)
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('DELETE'),
			)
		);
	
        $dependencia = $this->entityManager->find('Entities\Dependencia',array('componenteCurricular' => $codCompCurric, 'preRequisito' => $codPreRequisito));
            
        if(!is_null($dependencia)){
            try{
                $this->entityManager->remove($dependencia);
                $this->entityManager->flush();
                
                $this->apiReturn(array(
                    'message' => $this->getApiMessage(STD_MSG_DELETED),
                    ), self::HTTP_OK 
                );

            }catch (\Exception $e){
                $this->apiReturn(array(
                    'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
                    ), self::HTTP_BAD_REQUEST 
                );
            }
        }else{
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
                ), self::HTTP_NOT_FOUND 
            );
        }	
    }
} 
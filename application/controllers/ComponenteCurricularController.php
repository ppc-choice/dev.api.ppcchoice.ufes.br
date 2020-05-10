<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class ComponenteCurricularController extends APIController 
{
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * @api {get} componentes-curriculares Listar todas as componentes curriculares
     * @apiName findAll
     * @apiGroup Componente Curricular
     *
     * @apiSuccess {ComponenteCurricular[]} componentesCurriculares Array de objetos do tipo ComponenteCurricular.
     * 
     * @apiError {String[]} 404 Nenhuma componente curricular encontrada.
     */
    public function findAll()
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));
    
        $colecaoCompCurric = $this->entityManager->getRepository('Entities\ComponenteCurricular')->findAll();
        
        if(!empty($colecaoCompCurric))
        {
            $this->apiReturn($colecaoCompCurric,
                self::HTTP_OK
            );
        } else {
            $this->apiReturn(array(
                'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
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
     * @apiSuccess {ComponenteCurricular[]} componentesCurriculares Array de objetos do tipo ComponenteCurricular.
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
                
        $colecaoCompCurric = $this->entityManager->getRepository('Entities\ComponenteCurricular')->findByCodPpc($codPpc);   
        
        if(!empty($colecaoCompCurric))
        {
            $this->apiReturn($colecaoCompCurric,
                self::HTTP_OK
            );
            
        }else{
            $this->apiReturn(array(
                    'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
                ),self::HTTP_NOT_FOUND
            );
        }
    }
    
    /**
     * @api {get} componentes-curriculares/:codCompCurric Solicitar uma componente curricular
     * @apiName findByCodCompCurric
     * @apiGroup Componente Curricular
     * 
     * @apiParam {Number} codCompCurric Identificador único da componente curricular solicitada.
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

                
        $componenteCurricular = $this->entityManager->getRepository('Entities\ComponenteCurricular')->findByCodCompCurric($codCompCurric);  
                
        if(!empty($componenteCurricular))
        {
            $this->apiReturn($componenteCurricular,
                self::HTTP_OK
            );
            
        }else{
            $this->apiReturn(array(
                    'error' =>  $this->stdMessage(STD_MSG_NOT_FOUND),
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
     * @apiSuccess {String[]} message  Entities\\ComponenteCurricular: Instância criada com sucesso.
     * 
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function create()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('POST'),
            )
        );

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $componenteCurricular = new Entities\ComponenteCurricular();

        if(isset($payload['periodo'])) $componenteCurricular->setPeriodo($payload['periodo']);

        if(isset($payload['credito'])) $componenteCurricular->setCredito($payload['credito']);

        if(isset($payload['tipo'])) $componenteCurricular->setTipo($payload['tipo']);

        if(isset($payload['numDisciplina'], $payload['codDepto'])) 
        {
            $disciplina = $this->entityManager->find('Entities\Disciplina',
            array('numDisciplina' => $payload['numDisciplina'], 'codDepto' => $payload['codDepto']));
            $componenteCurricular->setDisciplina($disciplina );
        }

        if(isset($payload['codPpc']))
        {
            $ppc =  $this->entityManager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpc']);
            $componenteCurricular->setPpc($ppc);
        }

        $constraints = $this->validator->validate($componenteCurricular);

        if($constraints->success())
        {
            try{
                $this->entityManager->persist($componenteCurricular);
                $this->entityManager->flush();
                
                $this->apiReturn(array(
                    'message' => $this->stdMessage(STD_MSG_CREATED),
                ), self::HTTP_OK);
            } catch (\Exception $e) {
                $this->apiReturn(array(
                    'error' => $this->stdMessage(STD_MSG_EXCEPTION)
                    ),self::HTTP_BAD_REQUEST
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
     * @api {put} componentes-curriculares/:codCompCurric Atualizar Componente Curricular
     * @apiName update
     * @apiGroup Componente Curricular
     * 
     * @apiParam {Number} codCompCurric Identificador único da componente curricular solicitada.
     * @apiParam (Request Body/JSON) {String} [periodo]  Período da componente.
     * @apiParam (Request Body/JSON) {String} [credito]  Crédito da componente.
     * @apiParam (Request Body/JSON) {String} [tipo]  Tipo da componente.
     * @apiParam (Request Body/JSON) {String} [codDepto]  Código do departamento.
     * @apiParam (Request Body/JSON) {String} [numDisciplina]  Número da disicplina.
     * @apiParam (Request Body/JSON) {String} [codPpc]  Código do ppc.
     * 
     * @apiSuccess {String[]} message  Entities\\ComponenteCurricular: Instância atualizada com sucesso.
     * 
     * @apiError {String[]} 404 O <code>codCompCurric</code> não corresponde a uma componente curricular cadastrada.
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function update($codCompCurric)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('PUT'),
            )
        );

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $componenteCurricular = $this->entityManager->find('Entities\ComponenteCurricular',$codCompCurric);

        if(!is_null($componenteCurricular))
        {
            if(isset($payload['codPpc']))
            {
                $ppc = $this->entityManager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpc']);
                $componenteCurricular->setPpc($ppc);
            }

            if(isset($payload['numDisciplina'],$payload['codDepto']))
            {
                $disciplina = $this->entityManager->find('Entities\Disciplina',
                    array('numDisciplina' => $payload['numDisciplina'], 'codDepto' => $payload['codDepto']));
                $componenteCurricular->setDisciplina($disciplina);
            }

            if(isset($payload['periodo'])){
                $componenteCurricular->setPeriodo($payload['periodo']);
            }

            if(isset($payload['credito'])){
                $componenteCurricular->setCredito($payload['credito']);
            }
            
            if(isset($payload['tipo'])){
                $componenteCurricular->setTipo($payload['tipo']);
            }
            
            $constraints = $this->validator->validate($componenteCurricular);

            if($constraints->success())
            {
                try {
                    $this->entityManager->merge($componenteCurricular);
                    $this->entityManager->flush();

                    $this->apiReturn(array(
                        'message' => $this->stdMessage(STD_MSG_UPDATED),
                    ),self::HTTP_OK);
                } catch (\Exception $e) {
                    $this->apiReturn(array(
                        'error' => $this->stdMessage(STD_MSG_EXCEPTION),
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
                'error' => $this->stdMessage(STD_MSG_NOT_FOUND),         
                ),self::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @api {delete} componentes-curriculares/:codCompCurric Deletar Componente Curricular
     * @apiName delete
     * @apiGroup Componente Curricular
     * 
     * @apiParam {Number} codCompCurric Identificador único da componente curricular solicitada.
     * 
     * @apiSuccess {String[]} message  Entities\\ComponenteCurricular: Instância deletada com sucesso.
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

        $componenteCurricular = $this->entityManager->find('Entities\ComponenteCurricular',$codCompCurric);

        if(!is_null($componenteCurricular))
        {
            try {
                $this->entityManager->remove($componenteCurricular);
                $this->entityManager->flush();

                $this->apiReturn(array(
                    'message' => $this->stdMessage(STD_MSG_DELETED),
                    ), self::HTTP_OK
                );
            } catch (\Exception $e) {
                $this->apiReturn(array(
                    'error' => $this->stdMessage(STD_MSG_EXCEPTION),
                    ), self::HTTP_BAD_REQUEST
                );
            }
        }else{ 
            $this->apiReturn(array(
                'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
                ),self::HTTP_NOT_FOUND
            );
        }
    }

}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class CorrespondenciaController extends APIController
{
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * @api {get} correspondencias Listar todas as correspondências de todas as componentes curriculares.
     * @apiName findAll
     * @apiGroup Correspondência
     * @apiError  404 NotFound Nenhuma Correspondência encontrada.
     *
     * @apiSuccess {Correspondencia[]} correspondencias Array de objetos do tipo Correspondencia.
     * 
     * @apiError {String[]} 404 Nenhuma componente curricular encontrada.
     */
    public function findAll()
    {
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));
                
        $colecaoCorrespondencia = $this->entityManager->getRepository('Entities\Correspondencia')->findAll();
     
        if(!empty($colecaoCorrespondencia))
        {
            $this->apiReturn($colecaoCorrespondencia,
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
     * @api {get} projetos-pedagogicos-curso/:codPpcAtual/correspondencias/:codPpcAlvo Listar todas as relações de correspondência entre os cursos referidos
     * @apiName findAllByCodPpc
     * @apiGroup Correspondência
     * 
     * @apiParam {Number} codPpcAtual Identificador único do ppc atual.
     * @apiParam {Number} codPpcAlvo Identificador único do ppc alvo.
     *
     * @apiSuccess {Correspondencia[]} correspondencias Array de objetos do tipo Correspondencia.
     * @apiSuccess {Number} codCompCurric Código da componente curricular correspondente.
     * @apiSuccess {Number} codCompCorresp Código da disciplina correspondente.
     * @apiSuccess {Number} percentual Percentual de correspondencia entre a componente e sua componente correspondente.
     * 
     * @apiError {String[]} 404 O <code>codPpcAtual</code> ou <code>codPpcAlvo</code> não correspondem a ppc cadastrados.
     */
    public function findAllByCodPpc($codPpcAtual,$codPpcAlvo)
	{
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));
   
        $colecaoCorrespondencia = $this->entityManager->getRepository('Entities\Correspondencia')->findAllByCodPpc($codPpcAtual,$codPpcAlvo);
        
        if(!empty($colecaoCorrespondencia))
        {
            $this->apiReturn($colecaoCorrespondencia,
                self::HTTP_OK
            );
            
        }else{
            $this->apiReturn(
                array(
                    'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
                ),self::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @api {get} componentes-curriculares/:codCompCurric/correspondencias Listar as correspondências de uma componente curricular
     * @apiName findByCodCompCurric
     * @apiGroup Correspondência
     * 
     * @apiParam {Number} codCompCurric Identificador único da componente curricular da qual as correpondências foram solicitadas.
     *
     * @apiSuccess {Correspondencia[]} correspondencias Array de objetos do tipo Correspondencia.
     * @apiSuccess {String} nomeDisc Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {String} codDisc Código da disciplina.
     * @apiSuccess {String} nomeDiscCorresp Nome da disciplina correspondente que a componente correspondente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCorresp Código da componente curricular correspondente.
     * @apiSuccess {String} codDiscCorresp Código da disciplina correspondente.
     * @apiSuccess {Number} percentual Percentual de correspondencia entre a componente e sua componente correspondente.
     * 
     * @apiError {String[]} 404 O <code>codCompCurric</code> não corresponde a ppc cadastrado.
     */
    public function findByCodCompCurric($codCompCurric)
	{
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
                'methods' => array('GET'), 
        ));
              
        $colecaoCorrespondencia = $this->entityManager->getRepository('Entities\Correspondencia')->findByCodCompCurric($codCompCurric);

        if(!empty($colecaoCorrespondencia))
        {
            $this->apiReturn($colecaoCorrespondencia,
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
     * @api {post} correspondencias Criar correspondência
     * @apiName create
     * @apiGroup Correspondência
     * 
     * @apiParam (Request Body/JSON) {String} codCompCurric  Código da componente curricular.
     * @apiParam (Request Body/JSON) {String} codCompCurricCorresp  Código da componente curricular correspondente.
     * 
     * @apiSuccess {String[]} message  Entities\\Correspondencia: Instância criada com sucesso.
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
        $correspondencia = new Entities\Correspondencia();

        if (isset( $payload['codCompCurric']))
        {
            $componenteCurricular = $this->entityManager->find('Entities\ComponenteCurricular',$payload['codCompCurric']);
            if(!is_null($componenteCurricular)) $correspondencia->setComponenteCurricular($componenteCurricular);
        }
        
        if (isset($payload['codCompCurricCorresp']))
        {
            $componenteCurricularCorresp = $this->entityManager->find('Entities\ComponenteCurricular',$payload['codCompCurricCorresp']);
            if(!is_null($componenteCurricularCorresp)) $correspondencia->setComponenteCurricularCorresp($componenteCurricularCorresp);
        } 

        if (isset($payload['percentual'])) $correspondencia->setPercentual($payload['percentual']);
        
        $constraints = $this->validator->validate($correspondencia);

        if($constraints->success())
        {
            try {
                $this->entityManager->persist($correspondencia);
                $this->entityManager->flush();

                $this->apiReturn(array(
                    'message' => $this->stdMessage(STD_MSG_CREATED),
                    ), self::HTTP_OK
                );
            } catch (\Exception $e) {
                $this->apiReturn(array(
                    'error' => $this->stdMessage(STD_MSG_EXCEPTION),
                    ),self::HTTP_BAD_REQUEST
                );
            }
        }else{
            $this->apiReturn(array(
                'error' => $constraints->messageArray(),
                ),self::HTTP_BAD_REQUEST
            );
        }         
    }

    /**
     * @api {put} correspondencia/:codCompCurric/:codCompCorresp Atualizar Correspondência
     * @apiName update
     * @apiGroup Correspondência
     * 
     * @apiParam {Number} codCompCurric Identificador único de componente curricular.
     * @apiParam {Number} codCompCorresp Identificador único de componente curricular correspondente.
     * @apiParam (Request Body/JSON) {String} [codCompCurric]  Código da componente curricular.
     * @apiParam (Request Body/JSON) {String} [codCompCurricCorresp]  Código da componente curricular correspondente.
     * 
     * @apiSuccess {String[]} message  Entities\\Correspondencia: Instância atualizada com sucesso.
     * 
     * @apiError {String[]} 404 O <code>codCompCurric</code> ou <code>codCompCorresp</code> não correspondem a componentes cadastradas.
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function update($codCompCurric,$codCompCorresp)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('PUT'),
            )
        );

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $correspondencia = $this->entityManager->find('Entities\Correspondencia',
                array('componenteCurricular' => $codCompCurric, 'componenteCurricularCorresp' => $codCompCorresp));

        if(!is_null($correspondencia))
        {
            if (array_key_exists('codCompCurric', $payload))
            {
                if(isset($payload['codCompCurric'])){
                    $componenteCurricular = $this->entityManager->find('Entities\ComponenteCurricular',$payload['codCompCurric']);
                } else {
                    $componenteCurricular = null;
                }
                $correspondencia->setComponenteCurricular($componenteCurricular);
            }

            if (array_key_exists('codCompCurricCorresp',$payload))
            {
                if(isset($payload['codCompCurricCorresp'])){
                    $componenteCurricularCorresp = $this->entityManager->find('Entities\ComponenteCurricular',$payload['codCompCurricCorresp']);
                } else {
                    $componenteCurricularCorresp = null;
                } 
                $correspondencia->setComponenteCurricularCorresp($componenteCurricularCorresp);
            } 
            
            if(array_key_exists('percentual',$payload)) $correspondencia->setPercentual($payload['percentual']);
            
            $constraints = $this->validator->validate($correspondencia);

            if($constraints->success())
            {
                try {
                    $this->entityManager->merge($correspondencia);
                    $this->entityManager->flush();

                    $this->apiReturn(array(
                        'message' => $this->stdMessage(STD_MSG_UPDATED),
                        ), self::HTTP_OK
                    );
                } catch (\Exception $e) {
                    $this->apiReturn(array(
                        'error' => $this->stdMessage(STD_MSG_EXCEPTION),
                        ),self::HTTP_BAD_REQUEST
                    );
                }
            }else{
                $this->apiReturn(array(
                    'error' => $constraints->messageArray(),
                    ),self::HTTP_BAD_REQUEST
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
     * @api {delete} correspondencias/:codCompCurric/:codCompCorresp Deletar Correspondência
     * @apiName delete
     * @apiGroup Correspondência
     * 
     * @apiParam {Number} codCompCurric Identificador único de componente curricular.
     * @apiParam {Number} codCompCorresp Identificador único de componente curricular correspondente.
     * 
     * @apiSuccess {String[]} message  Entities\\Correspondencia: Instância deletada com sucesso.
     * 
     * @apiError {String[]} 404 O <code>codCompCurric</code> ou <code>codCompCorresp</code> não correspondem a componentes cadastradas.
     * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
     */
    public function delete($codCompCurric,$codCompCorresp)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('DELETE'),
            )
        );
        $correspondencia = $this->entityManager->find('Entities\Correspondencia',
                array('componenteCurricular' => $codCompCurric, 'componenteCurricularCorresp' => $codCompCorresp));

        if(!is_null($correspondencia))
        {
            try {
                $this->entityManager->remove($correspondencia);
                $this->entityManager->flush();

                $this->apiReturn(array(
                    'message' => $this->stdMessage(STD_MSG_DELETED),
                    ), self::HTTP_OK
                );
            } catch (\Exception $e) {
                $this->apiReturn(array(
                    'error' => $this->stdMessage(STD_MSG_EXCEPTION),
                    ),self::HTTP_BAD_REQUEST
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
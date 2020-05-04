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
     * @apiSuccess {Correspondencia[]} Correspondencias Array de objetos do tipo Correspondencia.
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
     
        $this->apiReturn( $colecaoCorrespondencia,
            self::HTTP_OK
        );
    }

    /**
     * @api {get} projetos-pedagogicos-curso/:codPpcAtual/correspondencias/:codPpcAlvo Listar todas as relações de correspondência entre os cursos referidos
     * @apiName findAllByCodPpc
     * @apiGroup Correspondência
     * 
     * @apiParam {Number} codPpcAtual Código do PPC atual .
     * @apiParam {Number} codPpcAlvo Código do PPC alvo.
     *
     * @apiSuccess {Correspondencia[]} Correspondencias Array de objetos do tipo Correspondencia.
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
                    'error' =>  array('Nenhuma relação de correspondência encontrada entre componentes dos ppcs solicitados.')
                ),self::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @api {get} componentes-curriculares/:codCompCurric/correspondencias Listar as correspondências de uma componente curricular
     * @apiName findByCodCompCurric
     * @apiGroup Correspondência
     * @apiError  404 NotFound Nenhuma correspondência encontrada para esta componente.
     * 
     * @apiParam {Number} codCompCurric Código de componente curricular.
     *
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
                    'error' =>  array('Nenhuma correspondência encontrada para esta componente.')
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
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Correspondência criada com sucesso."
     *     }
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
                    'message' => array('Correspondência criada com sucesso.'),
                    ), self::HTTP_OK
                );
            } catch (\Exception $e) {
                $msgExcecao = array($e->getMessage());

                $this->apiReturn(array(
                    'error' => $msgExcecao
                    ),self::HTTP_BAD_REQUEST
                );
            }
        }else{
            $msgViolacoes = $constraints->messageArray();
            
            $this->apiReturn(array(
                'error' => $msgViolacoes
                ),self::HTTP_BAD_REQUEST
            );
        }         
    }

    /**
     * @api {put} correspondencia/:codCompCurric/:codCompCorresp Atualizar Correspondência
     * @apiName update
     * @apiGroup Correspondência
     * 
     * @apiParam {Number} codCompCurric Código de componente curricular.
     * @apiParam {Number} codCompCorresp Código de componente curricular correspondente.
     * @apiParam (Request Body/JSON) {String} codCompCurric  Código da componente curricular.
     * @apiParam (Request Body/JSON) {String} codCompCurricCorresp  Código da componente curricular correspondente.
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Correspondência atualizada com sucesso"
     *     }
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
                        'error' => array('Correspondência atualizada com sucesso.'),
                        ), self::HTTP_OK
                    );
                } catch (\Exception $e) {
                    $msgExcecao = array($e->getMessage());

                    $this->apiReturn(array(
                        'error' => $msgExcecao
                        ),self::HTTP_BAD_REQUEST
                    );
                }
            }else{
                $msgViolacoes = $constraints->messageArray();
                
                $this->apiReturn(array(
                    'error' => $msgViolacoes
                    ),self::HTTP_BAD_REQUEST
                );
            }
        }else{
            $this->apiReturn(array(
                'error' => array('Correspondência não encontrada'),
                ),self::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @api {delete} correspondencias/:codCompCurric/:codCompCorresp Deletar Correspondência
     * @apiName delete
     * @apiGroup Correspondência
     * 
     * @apiParam {Number} codCompCurric Código de componente curricular.
     * @apiParam {Number} codCompCorresp Código de componente curricular correspondente.
     * 
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Correspondência removida com sucesso"
     *     }
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
                    'message' => array('Correspondência removida com sucesso')
                    ), self::HTTP_OK
                );
            } catch (\Exception $e) {
                $msgExcecao = array($e->getMessage());
                
                $this->apiReturn(array(
                    'error' => $msgExcecao
                    ),self::HTTP_BAD_REQUEST
                );
            }
        }else{ 
            $this->apiReturn(array(
                'error' => array('Correspondência não encontrada'),
                ),self::HTTP_NOT_FOUND
            );
        }
    }
}
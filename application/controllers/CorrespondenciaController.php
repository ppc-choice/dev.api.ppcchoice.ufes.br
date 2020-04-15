<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class CorrespondenciaController extends API_Controller {

    /**
     * @api {get} projetos-pedagogicos-curso/:codPpcAtual/correspondencias/:codPpcAlvo Listar todas as relações de correspondência entre os cursos referidos
     * @apiName findAllByCodPpc
     * @apiGroup Correspondência
     * @apiError  (Correspondência Não Encontrada 404) CorrespondenciaNaoEncontrada Nenhuma relação de correspondência encontrada entre componentes dos ppc's solicitados.
     * @apiParam {Number} codPpcAtual Código do PPC atual .
     * @apiParam {Number} codPpcAlvo Código do PPC alvo.
     *
     * @apiSuccess {Number} codCompCurric Código da componente curricular correspondente.
     * @apiSuccess {Number} codCompCorresp Código da disciplina correspondente.
     * @apiSuccess {Number} percentual Percentual de correspondencia entre a componente e sua componente correspondente.
     */
    public function findAllByCodPpc($codPpcAtual,$codPpcAlvo)
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));
   
        $correspondencia = $this->entity_manager->getRepository('Entities\Correspondencia')->findAllByCodPpc($codPpcAtual,$codPpcAlvo);
        
        if(!empty($correspondencia))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $correspondencia
                ),200
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Nenhuma relação de correspondência encontrada entre componentes dos ppcs solicitados.'
                ),404
            );
        }
    }

    /**
     * @api {get} correspondencias Listar todas as correspondências de todas as componentes curriculares.
     * @apiName findAll
     * @apiGroup Correspondência
     * @apiError  (Correspondência Não Encontrada 404) CorrespondenciaNaoEncontrada Nenhuma Correspondência encontrada.
     *
     * @apiSuccess {String} nomeDisc Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {String} codDisc Código da disciplina.
     * @apiSuccess {String} nomeDiscCorresp Nome da disciplina correspondente que a componente correspondente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCorresp Código da componente curricular correspondente.
     * @apiSuccess {String} codDiscCorresp Código da disciplina correspondente.
     * @apiSuccess {Number} percentual Percentual de correspondencia entre a componente e sua componente correspondente.
     */
    public function findAll()
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));

                
        $correspondencia = $this->entity_manager->getRepository('Entities\Correspondencia')->findAll();
     
        
        if(!empty($correspondencia))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $correspondencia
                ),200
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Nenhuma Correspondência encontrada.'
                ),404
            );
        }
    }


    /**
     * @api {get} componentes-curriculares/:codCompCurric/correspondencias Listar as correspondências de uma componente curricular
     * @apiName findByCodCompCurric
     * @apiGroup Correspondência
     * @apiError  (Correspondência Não Encontrada 404) CorrespondenciaNaoEncontrada Nenhuma correspondência encontrada para esta componente.
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
     */
    public function findByCodCompCurric($codCompCurric)
	{
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
                'methods' => array('GET'), 
            ));

              
        $correspondencia = $this->entity_manager->getRepository('Entities\Correspondencia')->findByCodCompCurric($codCompCurric);


        if(!empty($correspondencia))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $correspondencia
                ),200
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Nenhuma correspondência encontrada para esta componente.'
                ),404
            );
        }
    }

    /**
     * @api {post} correspondencias Criar correspondência
     * @apiName add
     * @apiGroup Correspondência
     * @apiError  (Campo obrigatorio não encontrado 400) BadRequest Algum campo obrigatório não foi inserido.
     * @apiError  (Componente curricular não encontrada 404) ComponenteNaoEncontrada Componente curricular não encontrada.
     * @apiError  (Componentes de mesmo ppc 400) BadRequest Componentes pertencem ao mesmo ppc.
     * @apiError  (Valor de percentual errado 400) BadRequest Percentual de correspondência deve ser > 0 e <= 1.
     * @apiParamExample {json} Request-Example:
     *     {
     *         "codCompCurric" : 220 ,
	 *         "codCompCurricCorresp" : 221,
	 *         "percentual" : 1
     *     }
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Correspondência criada com sucesso."
     *     }
     */
    public function add()
    {
        $this->_apiConfig(array(
            'methods' => array('POST'),
            // 'limit' => array(2,'ip','everyday'),
            // 'requireAuthorization' => TRUE
            )
        );

        $payload = json_decode(file_get_contents('php://input'),TRUE);

        if (isset( $payload['codCompCurric'], $payload['codCompCurricCorresp'], $payload['percentual'] ))
        {
            $corresp = new \Entities\Correspondencia;
            $compCurric = $this->entity_manager->find('Entities\ComponenteCurricular',$payload['codCompCurric']);
            $compCorresp = $this->entity_manager->find('Entities\ComponenteCurricular',$payload['codCompCurricCorresp']);
            
            if(!is_null($compCurric) && !is_null($compCorresp ))
            {
                
                $ppc1 = $compCurric->getPpc();
                $ppc2 = $compCorresp->getPpc();

                if($ppc1 != $ppc2)
                {
                    $corresp -> setComponenteCurricular($compCurric);
                    $corresp -> setComponenteCurricularCorresp($compCorresp);
                    
                    if( (0 < $payload['percentual']) && ( $payload['percentual'] <= 1 ) )
                    {
                        $corresp->setPercentual($payload['percentual']);

                        try {
                            $this->entity_manager->persist($corresp);
                            $this->entity_manager->flush();
            
                            $this->api_return(array(
                                'status' => TRUE,
                                'message' => 'Correspondência criada com sucesso.',
                            ), 200);
                        } catch (\Exception $e) {
                            $e_msg = $e->getMessage();
                            $this->api_return(array(
                                'status' => FALSE,
                                'message' => $e_msg
                            ), 400);
                        }
                    }else{
                        $this->api_return(array(
                            'status' => FALSE,
                            'message' => 'Percentual de correspondência deve ser > 0 e <= 1.',
                        ), 400);
                    }
                    
                }else{
                    $this->api_return(array(
                        'status' => FALSE,
                        'message' => 'Componentes pertencem ao mesmo ppc.',
                    ), 400);
                }
                
            }else{
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => 'Componente curricular não encontrada.',
                ), 404);
            }

        }else{
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Campo Obrigatorio Não Encontrado.',
            ), 400);
        }
    }
}
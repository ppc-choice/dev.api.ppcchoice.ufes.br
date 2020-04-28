<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class CorrespondenciaController extends API_Controller {

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
   
        $correspondencia = $this->entity_manager->getRepository('Entities\Correspondencia')->findAllByCodPpc($codPpcAtual,$codPpcAlvo);
        
        if(!empty($correspondencia))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $correspondencia
                ),self::HTTP_OK
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  array('Nenhuma relação de correspondência encontrada entre componentes dos ppcs solicitados.')
                ),self::HTTP_NOT_FOUND
            );
        }
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

                
        $correspondencia = $this->entity_manager->getRepository('Entities\Correspondencia')->findAll();
     
        
        if(!empty($correspondencia))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $correspondencia
                ),self::HTTP_OK
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  array('Nenhuma Correspondência encontrada.')
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

              
        $correspondencia = $this->entity_manager->getRepository('Entities\Correspondencia')->findByCodCompCurric($codCompCurric);


        if(!empty($correspondencia))
        {
            $this->api_return(
                array(
                    'status' => true,
                    'result' =>  $correspondencia
                ),self::HTTP_OK
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  array('Nenhuma correspondência encontrada para esta componente.')
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
        $corresp = new \Entities\Correspondencia;

        if (isset( $payload['codCompCurric']))
        {
            $compCurric = $this->entity_manager->find('Entities\ComponenteCurricular',$payload['codCompCurric']);
            // // nao tem como dar set se for null pois o metodo da entidade construida automaticamente nao
            // // aceita null, e a execução da erro antes de chegar no validador
            // // se nao for setado vai continuar como null e chegar no validador e continuar fluxo normal
            if(!is_null($compCurric)) $corresp->setComponenteCurricular($compCurric);
        }
        if (isset($payload['codCompCurricCorresp']))
        {
            $compCorresp = $this->entity_manager->find('Entities\ComponenteCurricular',$payload['codCompCurricCorresp']);
            // // nao tem como dar set se for null pois o metodo da entidade construida automaticamente nao
            // // aceita null, e a execução da erro antes de chegar no validador
            // //se nao for setado vai continuar como null e chegar no validador e continuar fluxo normal
            if(!is_null($compCorresp)) $corresp->setComponenteCurricularCorresp($compCorresp);
        } 
        if (isset($payload['percentual'])) $corresp->setPercentual($payload['percentual']);
        
        $validador = $this->validator->validate($corresp);
        if($validador->count())
        {
            $message = $validador->messageArray();
            $this->api_return(array(
                'status' => FALSE,
                'message' => $message
            ),self::HTTP_BAD_REQUEST);
        }else{
            try {
                $this->entity_manager->persist($corresp);
                $this->entity_manager->flush();

                $this->api_return(array(
                    'status' => TRUE,
                    'message' => array('Correspondência criada com sucesso.'),
                ), self::HTTP_OK);
            } catch (\Exception $e) {
                $eMsg = array($e->getMessage());
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $eMsg
                ),self::HTTP_BAD_REQUEST);
            }
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

        $corresp = $this->entity_manager->find('Entities\Correspondencia',
                array('componenteCurricular' => $codCompCurric, 'componenteCurricularCorresp' => $codCompCorresp));
        $payload = json_decode(file_get_contents('php://input'),TRUE);

        if(!is_null($corresp))
        {
            //usar array_key_exists para tratar o caso de setar null e ser pego pelo validador
            //para gerar mensagem de erro, mas eh necessário colocar "= null" no argumento do setter
            //da chave no arquivo da entidade
            if (array_key_exists('codCompCurric', $payload))
            {
                if(isset($payload['codCompCurric']))
                    $compCurric = $this->entity_manager->find('Entities\ComponenteCurricular',$payload['codCompCurric']);
                else{
                    $compCurric = null;
                }
                $corresp->setComponenteCurricular($compCurric);
            }
            if (array_key_exists('codCompCurricCorresp',$payload))
            {
                if(isset($payload['codCompCurricCorresp']))
                    $compCorresp = $this->entity_manager->find('Entities\ComponenteCurricular',$payload['codCompCurricCorresp']);           
                else{
                    $compCorresp = null;
                } 
                $corresp->setComponenteCurricularCorresp($compCorresp);
            } 
            
            if(array_key_exists('percentual',$payload)) $corresp->setPercentual($payload['percentual']);
            
            $validador = $this->validator->validate($corresp);
            if($validador->count())
            {
                $message = $validador->messageArray();
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $message
                ),self::HTTP_BAD_REQUEST);
            }else{
                try {
                    $this->entity_manager->merge($corresp);
                    $this->entity_manager->flush();

                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => array('Correspondência atualizada com sucesso.'),
                    ), self::HTTP_OK);
                } catch (\Exception $e) {
                    $eMsg = array($e->getMessage());
                    $this->api_return(array(
                        'status' => FALSE,
                        'message' => $eMsg
                    ),self::HTTP_BAD_REQUEST);
                }
            }
        }else{
            $this->api_return(array(
                'status' => FALSE,
                'message' => array('Correspondência não encontrada'),
            ),self::HTTP_NOT_FOUND);
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
        $correspondencia = $this->entity_manager->find('Entities\Correspondencia',
                array('componenteCurricular' => $codCompCurric, 'componenteCurricularCorresp' => $codCompCorresp));
        if(!is_null($correspondencia))
        {
            try {
                $this->entity_manager->remove($correspondencia);
                $this->entity_manager->flush();
                $this->api_return(array(
                    'status' => TRUE,
                    'message' => array('Correspondência removida com sucesso')
                ), self::HTTP_OK);
            } catch (\Exception $e) {
                $eMsg = array($e->getMessage());
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $eMsg
                ),self::HTTP_BAD_REQUEST);
            }
        }else{ 
            $this->api_return(array(
                'status' => FALSE,
                'message' => array('Correspondência não encontrada'),
            ),self::HTTP_NOT_FOUND);
        }
    }
}
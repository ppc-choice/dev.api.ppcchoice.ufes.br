<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class ComponenteCurricularController extends API_Controller {

    
    /**
     * @api {get} componentes-curriculares Listar todas as componentes curriculares
     * @apiName findAll
     * @apiGroup Componente Curricular
     * @apiError  (Componente Curricular Não Encontrada 404) ComponenteCurricularNaoEncontrada Nenhuma componente curricular encontrada.
     *
     * @apiSuccess {String} nome Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {Number} periodo Número do período da componente curricular.
     * @apiSuccess {Number} credito Crédito da componente curricular.
     * @apiSuccess {Number} codDepto Código do departamento.
     * @apiSuccess {String} codDisc Código da disciplina.
     * @apiSuccess {Number} codPpc Código do projeto pedagógico de curso no qual o componente pertence.
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
                ),200
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Nenhuma componente curricular encontrada!'
                ),404
            );
        }
        
    }
    /**
     * @api {get} projetos-pedagogicos-curso/:codPpc/componentes-curriculares Listar todas componentes curriculares de um PPC, ordenados por período e componente curricular
     * @apiName findByCodPpc
     * @apiGroup Componente Curricular
     * @apiError  (Componente Curricular Não Encontrada 404) ComponenteCurricularNaoEncontrada Não foram encontradas componentes curriculares para o ppc solicitado
     * @apiParam {Number} codPpc Código de projeto pedagógico de curso (PPC).
     * 
     * @apiSuccess {Number} codCompCurric Código da componente curricular.
     * @apiSuccess {String} nome Nome da disciplina que a componente integraliza no projeto pedagógico de curso.
     * @apiSuccess {Number} ch Carga horária da disciplina da componente curricular.
     * @apiSuccess {Number} periodo Período da componente curricular.
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
                ),200
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Não foram encontradas componentes curriculares para o ppc solicitado.'
                ),404
            );
        }
    }
    
    /**
     * @api {get} componentes-curriculares/:codCompCurric Requisitar uma componente curricular
     * @apiName findByCodCompCurric
     * @apiGroup Componente Curricular
     * @apiError  (Componente Curricular Não Encontrada 404) ComponenteCurricularNaoEncontrada Componente curricular não encontrada.
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
                ),200
            );
            
        }else{
            $this->api_return(
                array(
                    'status' => false,
                    'message' =>  'Componente curricular não encontrada.'
                ),404
            );
        }
        
    }

    /**
     * @api {post} componentes-curriculares Criar Componente Curricular
     * @apiName add
     * @apiGroup Componente Curricular
     * @apiError  (Campo obrigatorio não encontrado 400) BadRequest Algum campo obrigatório não foi inserido.
     * @apiError  (PPC/Disciplina não encontrado 404) PPCNaoEncontrado PPC não encontrado. Disciplina não encontrada
     * @apiParamExample {json} Request-Example:
     *     {
     *         "periodo" : 2,
	 *         "credito" : 5 ,
	 *         "tipo" : "OPTATIVA" ,
	 *         "codDepto" : 1,
	 *         "numDisciplina" : 6,
	 *         "codPpc" : 2
     *     }
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Componente curricular criada com sucesso"
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

        if (  isset($payload['periodo'], $payload['credito'], $payload['tipo'], $payload['numDisciplina'],
            $payload['codDepto'], $payload['codPpc']))
        {
            $compCurric = new Entities\ComponenteCurricular;
            $disciplina = $this->entity_manager->find('Entities\Disciplina',array('numDisciplina' => $payload['numDisciplina'], 'codDepto' => $payload['codDepto']));
            $ppc =  $this->entity_manager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpc']);
            
            $msg = '';
            if(is_null($ppc)) $msg = $msg . 'PPC não encontrado. ';
            if(is_null($disciplina)) $msg = $msg . 'Disciplina não encontrada. ';
            if(empty($msg))
            {
                $compCurric->setPeriodo($payload['periodo']);
                $compCurric->setCredito($payload['credito']) ;
                $compCurric->setTipo($payload['tipo']) ;
                $compCurric->setDisciplina($disciplina );
                $compCurric->setPpc($ppc);

                try{
                    $this->entity_manager->persist($compCurric);
                    $this->entity_manager->flush();
    
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => 'Componente curricular criada com sucesso.',
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
                    'message' => $msg,
                ), 404);
            }
        }else{
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Campo Obrigatorio Não Encontrado.',
            ), 400);
        }
    }
 
    /**
     * @api {put} componentes-curriculares/:codCompCurric Atualizar Componente Curricular
     * @apiName update
     * @apiGroup Componente Curricular
     * @apiParam {Number} codCompCurric Código de componente curricular.
     * @apiError  (Campo obrigatorio não encontrado 400) BadRequest Algum campo obrigatório não foi inserido.
     * @apiError  (PPC/Disciplina não encontrado 404) PPCNaoEncontrado PPC não encontrado. Disciplina não encontrada
     * @apiParamExample {json} Request-Example:
     *     {
     *         "periodo" : 2,
	 *         "credito" : 5 ,
	 *         "tipo" : "OPTATIVA" ,
	 *         "codDepto" : 1,
	 *         "numDisciplina" : 6,
	 *         "codPpc" : 2
     *     }
     *  @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Componente curricular atualizada com sucesso"
     *     }
     */
    public function update($codCompCurric)
    {
        $compCurric = $this->entity_manager->find('Entities\ComponenteCurricular',$codCompCurric);
        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $msg = '';
        if(!is_null($compCurric) && !empty($payload))
        {
            
            if(isset($payload['codPpc']))
            {
                $ppc = $this->entity_manager->find('Entities\ProjetoPedagogicoCurso',$payload['codPpc']);
                if(is_null($ppc)) $msg = $msg . 'PPC não encontrado. ';
            }
            if(isset($payload['numDisciplina'],$payload['codDepto']))
            {
                $disciplina = $this->entity_manager->find('Entities\Disciplina',
                    array('numDisciplina' => $payload['numDisciplina'], 'codDepto' => $payload['codDepto']));
                if(is_null($disciplina)) $msg = $msg . 'Disciplina não encontrada. ';
            }

            if(empty($msg))
            {
                $compCurric->setPpc($ppc);
                $compCurric->setDisciplina($disciplina);
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
                try {
                    $this->entity_manager->merge($compCurric);
                    $this->entity_manager->flush();
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => 'Componente Curricular atualizada com sucesso'
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
                    'message' => $msg
                ), 404);
            } 
        }elseif(empty($payload))
        {
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Corpo da Requisição vazio',
            ), 400);
        }else{
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Componente Curricular não encontrada',
            ), 404);
        }

    }
}

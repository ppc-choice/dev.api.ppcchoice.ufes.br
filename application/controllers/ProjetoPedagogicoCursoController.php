
<?php defined('BASEPATH') OR exit('No direct script access allowed');



require_once APPPATH . 'libraries/API_Controller.php';


class ProjetoPedagogicoCursoController extends API_Controller
{
    
    public function __construct() {
        parent::__construct();
    }

    /**
    * @api {get} projetos-pedagogicos-curso Solicitar todos Projetos Pedagógicos de Curso.
    *
    * @apiName findAll
    * @apiGroup Projeto Pedagógico Curso
    *
    * @apiSuccess {DateTime} dtInicioVigencia Data correspondente ao ínicio de vigência do projeto pedagógico do curso.
    * @apiSuccess {DateTime} dtTerminoVigencia  Data correspondente ao término de vigência do projeto pedagógico do curso.
    * @apiSuccess {Number} chTotalDisciplinaOpt  Carga horária total de disciplinas optativas que o curso deve possuir.
    * @apiSuccess {Number} chTotalDisciplinaOb  Carga horária total de disciplinas obrigatórias que o curso deve possuir.
    * @apiSuccess {Number} chTotalAtividadeExt  Carga horária total de atividades extensão que o curso deve possuir.
    * @apiSuccess {Number} chTotalAtividadeCmplt  Carga horária total de atividades complementares que o curso deve possuir.
    * @apiSuccess {Number} chTotalProjetoConclusao  Carga horária total de projeto de conclusão de curso deve possuir.
    * @apiSuccess {Number} chTotalEstagio  Carga horária total de estágio que o curso deve possuir.
    * @apiSuccess {Number} duracao  Tempo de duração do curso descrito por anos.
    * @apiSuccess {Number} qtdPeriodos  Quantidade de períodos necessário para a conclusão do curso em situação normal.
    * @apiSuccess {Number} chTotal  Carga horária total que as componentes curriculares do curso deve possuir.
    * @apiSuccess {String} anoAprovacao  Ano de aprovação do projeto pedagógico de curso.
    * @apiSuccess {String = "CORRENTE", "ATIVO ANTERIOR", "INATIVO"} situacao  Situação em que se encontra o projeto pedagógico de curso.
    * @apiSuccess {String} codCurso  Código de indentificação do curso que o projeto pedagógico de curso integraliza.  
    *
    */

    public function findAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
           
            'methods' => array('GET'), 

        ));
       
        $ppc = $this->entity_manager->getRepository('Entities\ProjetoPedagogicoCurso')->findAll();
        $result = $this->doctrine_to_array($ppc,TRUE);

        if(!empty($result)){
            
            $this->api_return(
                array(
                    'status' => true,
                    "result" => $result,
                ),
            200); 

        }else{
            
            $this->api_return(
                array(
                    'status' => false,
                    "message" => 'Projeto Pedagógico de Curso não encontrado!',
                ),
            404);
        }
    }
        
    /**
    * @api {get} projetos-pedagogicos-curso/:codPpc Solicitar Projeto Pedagógico de Curso.
    * @apiParam {Number} codPpc Código de identificação de um Projeto Pedagógico de Curso.
    *
    * @apiName findById
    * @apiGroup Projeto Pedagógico Curso
    *
    *
    * @apiSuccess {DateTime} dtInicioVigencia Data correspondente ao ínicio de vigência do projeto pedagógico do curso.
    * @apiSuccess {DateTime} dtTerminoVigencia  Data correspondente ao término de vigência do projeto pedagógico do curso.
    * @apiSuccess {Number} chTotalDisciplinaOpt  Carga horária total de disciplinas optativas que o curso deve possuir.
    * @apiSuccess {Number} chTotalDisciplinaOb  Carga horária total de disciplinas obrigatórias que o curso deve possuir.
    * @apiSuccess {Number} chTotalAtividadeExt  Carga horária total de atividades extensão que o curso deve possuir.
    * @apiSuccess {Number} chTotalAtividadeCmplt  Carga horária total de atividades complementares que o curso deve possuir.
    * @apiSuccess {Number} chTotalProjetoConclusao  Carga horária total de projeto de conclusão de curso deve possuir.
    * @apiSuccess {Number} chTotalEstagio  Carga horária total de estágio que o curso deve possuir.
    * @apiSuccess {Number} duracao  Tempo de duração do curso descrito por anos.
    * @apiSuccess {Number} qtdPeriodos  Quantidade de períodos necessário para a conclusão do curso em situação normal.
    * @apiSuccess {Number} chTotal  Carga horária total que as componentes curriculares do curso deve possuir.
    * @apiSuccess {String} anoAprovacao  Ano de aprovação do projeto pedagógico de curso.
    * @apiSuccess {String = "CORRENTE", "ATIVO ANTERIOR", "INATIVO"} situacao  Situação em que se encontra o projeto pedagógico de curso.
    * @apiSuccess {String} codCurso  Código de indentificação do curso que o projeto pedagógico de curso integraliza.  
    * 
    * apiExample {curl} Exemplo:
    *      curl -i http://dev.api.ppcchoice.ufes.br/projetos-pedagogicos-curso/1
    * @apiSuccessExample {JSON} Success-Response:
    *   HTTP/1.1 200 OK
    *   {
    *       "codPpc": 1,
    *       "dtInicioVigencia": "2011-08-01",
    *       "dtTerminoVigencia": null,
    *       "chTotalDisciplinaOpt": 240,
    *       "chTotalDisciplinaOb": 3030,
    *       "chTotalAtividadeExt": 0,
    *       "chTotalAtividadeCmplt": 180,
    *       "chTotalProjetoConclusao": 120,
    *       "chTotalEstagio": 300,
    *       "duracao": 5,
    *       "qtdPeriodos": 10,
    *       "chTotal": 3870,
    *       "anoAprovacao": 2011,
    *       "situacao": "ATIVO ANTERIOR",
    *       "codCurso": 1   
    *   }
    *.
    * @apiErrorExample {JSON} Error-Response:
    *     HTTP/1.1 404 Not Found
    *     {
    *       status": false,
    *       "message": "Projeto Pedagógico de Curso não encontrado!"
    *     }
    */
    public function findById($codPpc)
    {
        
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
           
            'methods' => array('GET'), 

        ));
        
        $ppc = $this->entity_manager->getRepository('Entities\ProjetoPedagogicoCurso')->findById($codPpc);
        $result = $this->doctrine_to_array($ppc, TRUE);

        if(!empty($result)){
            
            $this->api_return(
                array(
                    'status' => true,
                    "result" => $result,
                ),
            200); 

        }else{
            
            $this->api_return(
                array(
                    'status' => false,
                    "message" => 'Projeto Pedagógico de Curso não encontrado!',
                ),
            404);
        }
    }  

    /**
    * @api {post} projetos-pedagogicos-curso/ Criar novo Projeto Pedagógico de Curso.
    *
    * @apiName add
    * @apiGroup Projeto Pedagógico Curso
    *
    *
    * @apiSuccess {DateTime} dtInicioVigencia Data correspondente ao ínicio de vigência do projeto pedagógico do curso.
    * @apiSuccess {DateTime} dtTerminoVigencia  Data correspondente ao término de vigência do projeto pedagógico do curso.
    * @apiSuccess {Number} chTotalDisciplinaOpt  Carga horária total de disciplinas optativas que o curso deve possuir.
    * @apiSuccess {Number} chTotalDisciplinaOb  Carga horária total de disciplinas obrigatórias que o curso deve possuir.
    * @apiSuccess {Number} chTotalAtividadeExt  Carga horária total de atividades extensão que o curso deve possuir.
    * @apiSuccess {Number} chTotalAtividadeCmplt  Carga horária total de atividades complementares que o curso deve possuir.
    * @apiSuccess {Number} chTotalProjetoConclusao  Carga horária total de projeto de conclusão de curso deve possuir.
    * @apiSuccess {Number} chTotalEstagio  Carga horária total de estágio que o curso deve possuir.
    * @apiSuccess {Number} qtdPeriodos  Quantidade de períodos necessário para a conclusão do curso em situação normal.
    * @apiSuccess {String} anoAprovacao  Ano de aprovação do projeto pedagógico de curso.
    * @apiSuccess {String = "CORRENTE", "ATIVO ANTERIOR", "INATIVO"} situacao  Situação em que se encontra o projeto pedagógico de curso.
    * @apiSuccess {String} codCurso  Código de indentificação do curso que o projeto pedagógico de curso integraliza.  
    * 
    * apiExample {curl} Exemplo:
    *      curl -i http://dev.api.ppcchoice.ufes.br/projetos-pedagogicos-curso/
    * @apiParamExample {JSON} Request-Example:
    *   HTTP/1.1 200 OK
    *   {
    *       "codCurso": 1   
    *       "dtInicioVigencia": "2011-08-01",
    *       "dtTerminoVigencia": null,
    *       "chTotalDisciplinaOpt": 240,
    *       "chTotalDisciplinaOb": 3030,
    *       "chTotalAtividadeExt": 0,
    *       "chTotalAtividadeCmplt": 180,
    *       "chTotalProjetoConclusao": 120,
    *       "chTotalEstagio": 300,
    *       "qtdPeriodos": 10,
    *       "anoAprovacao": 2011,
    *       "situacao": "ATIVO ANTERIOR",
    *   }
    *.
    * @apiSuccessExample {JSON} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       status": true,
    *       "message": "Projeto Pedagógico de Curso criada com sucesso!"
    *     }
    *
    * @apiError PpcNotFound Não foi possível adicionar um novo Projeto Pedagogico Curso.
	* @apiSampleRequest cursos/
	* @apiErrorExample {JSON} Error-Response:
	* HTTP/1.1 404 Not Found
	* {
	*	"status": false,
	*	"message": "Campo Obrigatorio Não Encontrado!"
	* }
    */
    
    public function add()
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('POST'),
			)
		);

		$payload = json_decode(file_get_contents('php://input'),TRUE);

        if (isset($payload['codCurso'], $payload['situacao']))
        {

			$curso = $this->entity_manager->find('Entities\Curso', $payload['codCurso']);
            $ppcs = $this->entity_manager->getRepository('Entities\ProjetoPedagogicoCurso')->findByCurso($payload['codCurso']);
            $result = $this->doctrine_to_array($ppcs);

            $situacao = true; 
            $uppersituacao = strtoupper($payload['situacao']);
                   
            if(!is_null($curso))
            {
                if($uppersituacao!="INATIVO")
                {
                    foreach ($result as $ppc) 
                    {
                        if($uppersituacao == $ppc['situacao'])
                        {
                            $situacao = false;
                            $this->api_return(array(
                                    'status' => FALSE,
                                    'message' => 'Não é permitido mais de um ppc com a situação corrente e ativo-anterior',
                            ), 400);
                            break;
                        }                    
                    }
                    if($situacao)
                    {   
                        if(!isset($payload['dtTerminoVigencia']))
                        {
                            if(isset($payload['chTotalDisciplinaOpt'], $payload['chTotalDisciplinaOb'], $payload['chTotalAtividadeExt'], $payload['chTotalAtividadeCmplt'], $payload['chTotalProjetoConclusao'], $payload['chTotalEstagio'], $payload['dtInicioVigencia'], $payload['qtdPeriodos'], $payload['anoAprovacao']))
                            {
                                $ppc = new Entities\ProjetoPedagogicoCurso;
                                $chtotal = $payload['chTotalDisciplinaOpt']+$payload['chTotalDisciplinaOb']+$payload['chTotalAtividadeExt']+$payload['chTotalAtividadeCmplt']+$payload['chTotalProjetoConclusao']+$payload['chTotalEstagio'];
                                
                                $ppc->setChTotalDisciplinaOpt($payload['chTotalDisciplinaOpt']);
                                $ppc->setChTotalDisciplinaOb($payload['chTotalDisciplinaOb']);
                                $ppc->setChTotalAtividadeExt($payload['chTotalAtividadeExt']);
                                $ppc->setChTotalAtividadeCmplt($payload['chTotalAtividadeCmplt']);
                                $ppc->setChTotalProjetoConclusao($payload['chTotalProjetoConclusao']);
                                $ppc->setChTotalEstagio($payload['chTotalEstagio']);
                                $ppc->setChTotal($chtotal);

                                $ppc->setDtInicioVigencia(new DateTime($payload['dtInicioVigencia']));

                                $ppc->setDuracao($payload['duracao']);
                                $ppc->setQtdPeriodos($payload['qtdPeriodos']);
                                $ppc->setAnoAprovacao($payload['anoAprovacao']);
                                $ppc->setSituacao($uppersituacao);
                                $ppc->setCurso($curso);
                            }
                            try {
                                $this->entity_manager->persist($ppc);
                                $this->entity_manager->flush();
            
                                $this->api_return(array(
                                    'status' => TRUE,
                                    'mesage' => 'PPCCriadoComSucesso',
                                ), 200);
                            } catch (\Exception $e) {
                                $this->api_return(array(
                                    'status' => false,
                                    'message' => $e->getMessage(),
                                ), 400);
                            }
                        }else
                        {
                            $this->api_return(array(
                                    'status' => FALSE,
                                    'message' => 'A data de termino de vigência de PPCs com situação CORRENTE ou ATIVO-ANTERIOR deve ser null',
                            ), 400);
                        }
                    
                    }
                }
                else if(isset($payload['dtTerminoVigencia']))
                {                      
                        if($payload['dtInicioVigencia'] < $payload['dtTerminoVigencia'])
                        {
                            
                            if(isset($payload['chTotalDisciplinaOpt'], $payload['chTotalDisciplinaOb'], $payload['chTotalAtividadeExt'], $payload['chTotalAtividadeCmplt'], $payload['chTotalProjetoConclusao'], $payload['chTotalEstagio'], $payload['dtInicioVigencia'], $payload['dtTerminoVigencia'], $payload['qtdPeriodos']))
                            {
                                $ppc = new Entities\ProjetoPedagogicoCurso;
                                $chtotal = $payload['chTotalDisciplinaOpt']+$payload['chTotalDisciplinaOb']+$payload['chTotalAtividadeExt']+$payload['chTotalAtividadeCmplt']+$payload['chTotalProjetoConclusao']+$payload['chTotalEstagio'];
                                
                                $ppc->setChTotalDisciplinaOpt($payload['chTotalDisciplinaOpt']);    
                                $ppc->setChTotalDisciplinaOb($payload['chTotalDisciplinaOb']);
                                $ppc->setChTotalAtividadeExt($payload['chTotalAtividadeExt']);
                                $ppc->setChTotalAtividadeCmplt($payload['chTotalAtividadeCmplt']);
                                $ppc->setChTotalProjetoConclusao($payload['chTotalProjetoConclusao']);
                                $ppc->setChTotalEstagio($payload['chTotalEstagio']);
                                $ppc->setChTotal($chtotal);
                                
                                $ppc->setDtinicioVigencia(new DateTime($payload['dtInicioVigencia']));
                                $ppc->setDtTerminoVigencia(new DateTime($payload['dtTerminoVigencia']));

                                $ppc->setDuracao($payload['duracao']);
                                $ppc->setQtdPeriodos($payload['qtdPeriodos']);
                                $ppc->setAnoAprovacao($payload['anoAprovacao']);
                                $ppc->setSituacao($uppersituacao);
                                $ppc->setCurso($curso);
                                
                                try {
                                    $this->entity_manager->persist($ppc);
                                    $this->entity_manager->flush();
                
                                    $this->api_return(array(
                                        'status' => TRUE,
                                        'result' => 'PPC criado com sucesso',
                                    ), 200);
                                } catch (\Exception $e) {
                                    $this->api_return(array(
                                        'status' => false,
                                        'message' => $e->getMessage(),
                                    ), 400);
                                }
                            }
                        }
                        else
                        {
                            $this->api_return(array(
                                'status' => FALSE,
                                'message' => 'A data de inicio de vigência não pode ser maior que a data de termino de vigencia',
                                ), 400);
                        }
                }else
                {
                        $this->api_return(array(
                            'status' => FALSE,
                            'message' => 'A data de termino de vigência de PPCs com situação INATIVO não pode ser vazia',
                            ), 400);
                }
            }else
            {
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => 'Curso não encontrado',
                ), 400);

            }
        }else
        {
        	$this->api_return(array(
                'status' => FALSE,
                'message' => 'Campo obrigatorio não encontrado',
            ), 400);
        }
    }   

    public function update($codPpc)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
			'methods' => array('POST'),
			)
		);


        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $ppc = $this->entity_manager->find('Entities\ProjetoPedagogicoCurso',$codPpc);

        if(!is_null($ppc))
        {
            if(!empty($payload))
            {   

                if(isset($payload['chTotalDisciplinaOpt']))$ppc->setChTotalDisciplinaOpt($payload['chTotalDisciplinaOpt']);    
                if(isset($payload['chTotalDisciplinaOb']))$ppc->setChTotalDisciplinaOb($payload['chTotalDisciplinaOb']);
                if(isset($payload['chTotalAtividadeExt']))$ppc->setChTotalAtividadeExt($payload['chTotalAtividadeExt']);
                if(isset($payload['chTotalAtividadeCmplt']))$ppc->setChTotalAtividadeCmplt($payload['chTotalAtividadeCmplt']);
                if(isset($payload['chTotalProjetoConclusao']))$ppc->setChTotalProjetoConclusao($payload['chTotalProjetoConclusao']);
                if(isset($payload['chTotalEstagio']))$ppc->setChTotalEstagio($payload['chTotalEstagio']);
                if(isset($payload['duracao']))$ppc->setDuracao($payload['duracao']);
                if(isset($payload['qtdPeriodos']))$ppc->setQtdPeriodos($payload['qtdPeriodos']);
                if(isset($payload['anoAprovacao']))$ppc->setAnoAprovacao($payload['anoAprovacao']);
               
                if(isset($payload['dtInicioVigencia']))
                {
                    if($ppc->getSituacao()=="INATIVO")
                    {
                        if(new DateTime($payload['dtInicioVigencia']) < $ppc->getDtTerminoVigencia())
                            $ppc->setDtInicioVigencia(new DateTime($payload['dtInicioVigencia']));
                        else
                            echo 'a data de inicio de vigencia não pode ser menor que a de termino de vigencia';
                    }
                    else
                        $ppc->setDtTerminoVigencia(new DateTime($payload['dtInicioVigencia']));
                }
                if(isset($payload['dtTerminoVigencia']))
                {
                    if($ppc->getSituacao()=="INATIVO")
                        $ppc->setDtTerminoVigencia(new DateTime($payload['dtTerminoVigencia']));
                    else
                        echo "ppc com situação corrente ou inativa não deve possuir data de termino de vigencia";
                }

                if(isset($payload['situacao']))
                {   
                    $situacao = true;
                    $uppersituacao = strtoupper($payload['situacao']);
                    
                    if($uppersituacao != "INATIVO")
                    {
                        $ppcs = $this->entity_manager->getRepository('Entities\ProjetoPedagogicoCurso')->findByCurso($ppc->getCurso());
                        $result = $this->doctrine_to_array($ppcs);
                        $situacao = true;
                        // verifica se já existe algum ppc com a situacao a ser alterada.
                        foreach ($result as $p) 
                        {
                            if($uppersituacao == $p['situacao'])
                            {
                                $situacao = false;
                                $this->api_return(array(
                                        'status' => FALSE,
                                        'message' => 'Não é permitido mais de um ppc com a situação corrente e ativo-anterior',
                                ), 400);
                                break;
                            }  
                        }                  
                        if($situacao)//se não existir ppcs com mesma situação de corrente e ativo anterior
                        {
                            echo "situacao alterada";
                            $ppc->setSituacao($uppersituacao);
                        }
                    }else
                    {
                        if(isset($payload['dtTerminoVigencia']))
                        {
                            if(new DateTime($payload['dtInicioVigencia']) < $payload['dtTerminoVigencia'])
                                $ppc->setDtTerminoVigencia(new DateTime($payload['dtTerminoVigencia']));

                        }else
                        {
                            echo "Data de termino de vigencia é obrigatória para ppcs inativos";
                        }
                    }    
                }

                if(isset($payload['codCurso']))
                {
                    $curso = $this->entity_manager->find('Entities\Curso', $payload['codCurso']);

                    $ppcs = $this->entity_manager->getRepository('Entities\ProjetoPedagogicoCurso')->findByCurso($payload['codCurso']);
                    $result = $this->doctrine_to_array($ppcs);
                    $situacao = true;

                    if(!is_null($curso))
                    {
                        // verifica se já existe algum ppc com a situacao a ser alterada.
                        foreach ($result as $aucPpc) 
                        {
                            if($auxPpc['situacao'] == $auxPpc->getSituacao())
                            {
                                $situacao = false;
                                $this->api_return(array(
                                        'status' => FALSE,
                                        'message' => 'Não é permitido mais de um ppc com a situação corrente e ativo-anterior',
                                ), 400);
                                break;
                            }  
                        }                  
                        if($situacao)//se não existir ppcs com mesma situação de corrente e ativo anterior
                        {
                            echo "curso do ppc alterado";
                            $ppc->setCurso($curso);
                        }
                    }
                    else
                    echo"curso nao encontrado";
                }

                try
                {
                    $this->entity_manager->merge($ppc);
                    $this->entity_manager->flush();
                    
                    $this->api_return(array(
                        'status' => TRUE,
                        'message' => 'PPC alterado com sucesso',
                    ), 200);
                } catch (\Exception $e) {
                    $this->api_return(array(
                        'status' => false,
                        'message' => $e->getMessage(),
                    ), 400);
                }

            }else
            {
                echo "campo obrigatorio vazio";
            }
        }else
        {
            echo "ppc não encontrado";
        }
    }

    public function delete($codPpc)
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('GET'),
			)
		);

	
        $ppc = $this->entity_manager->find('Entities\Dependencia',$codPpc);
            
        if(!is_null($ppc))
        {
            try
            {
                $this->entity_manager->merge($ppc);
                $this->entity_manager->flush();
                
                $this->api_return(array(
                    'status' => TRUE,
                    'message' => 'Projeto Pedagogico de Curso deletado com sucesso',
                ), 200);
            } catch (\Exception $e) {
                $this->api_return(array(
                    'status' => false,
                    'message' => $e->getMessage(),
                ), 400);
            }
        }
        else
        {   
            $this->api_return(array(
                'status' => FALSE,
                'message' => 'Projeto Pedagogico de curso não encontrado',
            ), 400);

        }		
    }
}

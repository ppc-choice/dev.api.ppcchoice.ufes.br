
<?php defined('BASEPATH') OR exit('No direct script access allowed');



require_once APPPATH . 'libraries/API_Controller.php';


class ProjetoPedagogicoCursoController extends API_Controller
{
    
    public function __construct() {
        parent::__construct();
    }

    /**
    * @api {get} projetos-pedagogicos-curso Requisitar todos Projetos Pedagógicos de Curso.
    *
    * @apiName findAll
    * @apiGroup Projeto Pedagógico Curso
    *
    * 
    * @apiExample {curl} Exemplo:
    *      curl -i http://dev.api.ppcchoice.ufes.br/projetos-pedagogicos-curso/
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
    * @api {get} projetos-pedagogicos-curso/:codPpc Requisitar Projeto Pedagógico de Curso.
    * @apiParam {Number} codPpc Código de identificação de um Projeto Pedagógico de Curso.
    *
    * @apiName findById
    * @apiGroup Projeto Pedagógico Curso
    *
    * @apiExample {curl} Exemplo:
    *      curl -i http://dev.api.ppcchoice.ufes.br/projetos-pedagogicos-curso/1
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
    * @apiSuccess {DateTime} dtTerminoVigencia  Data correspondente ao término de vigência do projeto pedagógico do curso (Obrigatório para projeto pedagógicos de cursos INATIVOS)..
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
    * @apiExample {curl} Exemplo:
    *      curl -i http://dev.api.ppcchoice.ufes.br/projetos-pedagogicos-curso/
    *
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
    *
    *
    * @apiSuccessExample {JSON} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       status": true,
    *       "message": "Projeto Pedagógico de Curso criado com sucesso!"
    *     }
    *
    * @apiError PpcNotFound Não foi possível adicionar um novo Projeto Pedagogico Curso.
    */
    
    public function create()
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('POST'),
			)
		);

		$payload = json_decode(file_get_contents('php://input'),TRUE);
        
        $ppc = new Entities\ProjetoPedagogicoCurso;
        
        if(isset($payload['codCurso'])) 
        {
            $curso = $this->entity_manager->find('Entities\Curso',$payload['codCurso']);
            $ppc->setCurso($curso);
        } 
            
        
        if(isset($payload['situacao'])) $ppc->setSituacao(strtoupper($payload['situacao']));
        
        if(isset($payload['dtTerminoVigencia'])) $ppc->setDtTerminoVigencia(new DateTime($payload['dtTerminoVigencia']));
        
        if(isset($payload['chTotalDisciplinaOpt'])) $ppc->setChTotalDisciplinaOpt($payload['chTotalDisciplinaOpt']);
        
        if(isset($payload['chTotalDisciplinaOb'])) $ppc->setChTotalDisciplinaOb($payload['chTotalDisciplinaOb']);
        
        if(isset($payload['chTotalAtividadeExt'])) $ppc->setChTotalAtividadeExt($payload['chTotalAtividadeExt']);
        
        if(isset($payload['chTotalAtividadeCmplt'])) $ppc->setChTotalAtividadeCmplt($payload['chTotalAtividadeCmplt']);
        
        if(isset($payload['chTotalProjetoConclusao'])) $ppc->setChTotalProjetoConclusao($payload['chTotalProjetoConclusao']);
        
        if(isset($payload['chTotalEstagio'])) $ppc->setChTotalEstagio($payload['chTotalEstagio']);
        
        if(isset($payload['dtInicioVigencia'])) $ppc->setDtInicioVigencia(new DateTime($payload['dtInicioVigencia']));
        
        if(isset($payload['qtdPeriodos'])) $ppc->setQtdPeriodos($payload['qtdPeriodos']);
        
        if(isset($payload['anoAprovacao'])) $ppc->setAnoAprovacao($payload['anoAprovacao']);
        
        if(isset($payload['duracao'])) $ppc->setDuracao($payload['duracao']);
        
        $chtotal = $payload['chTotalDisciplinaOpt']+$payload['chTotalDisciplinaOb']+$payload['chTotalAtividadeExt']+$payload['chTotalAtividadeCmplt']+$payload['chTotalProjetoConclusao']+$payload['chTotalEstagio'];                                
        $ppc->setChTotal($chtotal);
        
        $validador = $this->validator->validate($ppc);

        if ( $validador->count() ){
    
            $msg = $validador->messageArray();
            
            $this->api_return(array(
                'status' => FALSE,
                'message' => $msg,
            ), 400);
        }
        else{
            try {
                $this->entity_manager->persist($ppc);
                $this->entity_manager->flush();

                $this->api_return(array(
                    'status' => TRUE,
                    'mesage' => 'Projeto Pedaogico de Curso criado com sucesso',
                ), 200);
            } catch (\Exception $e) {
                $this->api_return(array(
                    'status' => false,
                    'message' => $e->getMessage(),
                ), 400);
            }
        }

    }   

    /**
    * @api {PUT} projetos-pedagogicos-curso/:codPpc Atualizar Projeto Pedagógico de Curso.
    *
    * @apiName update
    * @apiGroup Projeto Pedagógico Curso
    *
    * @apiExample {curl} Exemplo:
    *      curl -i http://dev.api.ppcchoice.ufes.br/projetos-pedagogicos-curso/1
    *
    * @apiSuccess {DateTime} dtInicioVigencia Data correspondente ao ínicio de vigência do projeto pedagógico do curso.
    * @apiSuccess {DateTime} dtTerminoVigencia  Data correspondente ao término de vigência do projeto pedagógico do curso (Obrigatório para projeto pedagógicos de cursos INATIVOS).
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
    *       "situacao": "INATIVO",
    *   }
    *
    *
    * @apiSuccessExample {JSON} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       status": true,
    *       "message": "Projeto Pedagógico de Curso atualizado com sucesso!"
    *     }
    *
    * @apiError PpcNotFound Não foi possível atualizar Projeto Pedagogico Curso.
    */
    public function update($codPpc)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
			'methods' => array('PUT'),
			)
		);

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $ppc = $this->entity_manager->find('Entities\ProjetoPedagogicoCurso',$codPpc);
        
        if(!is_null($ppc))
        {
            if(isset($payload['codCurso'])) 
            {
                $curso = $this->entity_manager->find('Entities\Curso',$payload['codCurso']);
                $ppc->setCurso($curso);
            }    
            if(isset($payload['situacao'])) $ppc->setSituacao(strtoupper($payload['situacao']));
            
            if(isset($payload['dtTerminoVigencia'])) $ppc->setDtTerminoVigencia(new DateTime($payload['dtTerminoVigencia']));
            
            if(isset($payload['chTotalDisciplinaOpt'])) $ppc->setChTotalDisciplinaOpt($payload['chTotalDisciplinaOpt']);
            
            if(isset($payload['chTotalDisciplinaOb'])) $ppc->setChTotalDisciplinaOb($payload['chTotalDisciplinaOb']);
            
            if(isset($payload['chTotalAtividadeExt'])) $ppc->setChTotalAtividadeExt($payload['chTotalAtividadeExt']);
            
            if(isset($payload['chTotalAtividadeCmplt'])) $ppc->setChTotalAtividadeCmplt($payload['chTotalAtividadeCmplt']);
            
            if(isset($payload['chTotalProjetoConclusao'])) $ppc->setChTotalProjetoConclusao($payload['chTotalProjetoConclusao']);
            
            if(isset($payload['chTotalEstagio'])) $ppc->setChTotalEstagio($payload['chTotalEstagio']);
            
            if(isset($payload['dtInicioVigencia'])) $ppc->setDtInicioVigencia(new DateTime($payload['dtInicioVigencia']));
            
            if(isset($payload['qtdPeriodos'])) $ppc->setQtdPeriodos($payload['qtdPeriodos']);
            
            if(isset($payload['anoAprovacao'])) $ppc->setAnoAprovacao($payload['anoAprovacao']);
            
            if(isset($payload['duracao'])) $ppc->setDuracao((float)$payload['duracao']);
    
            $validador = $this->validator->validate($ppc);

            if ( $validador->count() )
            {
        
                $msg = $validador->messageArray();
                
                $this->api_return(array(
                    'status' => FALSE,
                    'message' => $msg,
                ), 400);
            }else{
                try {
                    $this->entity_manager->merge($ppc);
                    $this->entity_manager->flush();
    
                    $this->api_return(array(
                        'status' => TRUE,
                        'mesage' => 'Projeto Pedaogico de Curso alterado com sucesso',
                    ), 200);
                } catch (\Exception $e) {
                    $this->api_return(array(
                        'status' => false,
                        'message' => $e->getMessage(),
                    ), 400);
                }
            }
            
        }else
        {
            $this->api_return(array(
                'status' => false,
                'message' => "Projeto Pedagogico de Curso não encontrado.",
            ), 400);
        }        
    }

    /**
    * @api {DELETE} projetos-pedagogicos-curso/:codPpc Deletar Projeto Pedagógico de Curso.
    * @apiParam {Number} codPpc Código de identificação de um Projeto Pedagógico de Curso.
    * @apiName update
    * @apiGroup Projeto Pedagógico Curso
    *
    * @apiExample {curl} Exemplo:
    *      curl -i http://dev.api.ppcchoice.ufes.br/projetos-pedagogicos-curso/1
    *
    * @apiSuccessExample {JSON} Success-Response:
    *     HTTP/1.1 200 OK
    *     {
    *       status": true,
    *       "message": "Projeto Pedagógico de Curso deletado com sucesso!"
    *     }
    *
    * @apiError PpcNotFound Não foi possível deletar um novo Projeto Pedagogico Curso.
    */
    public function delete($codPpc)
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('DELETE'),
			)
		);

	
        $ppc = $this->entity_manager->find('Entities\ProjetoPedagogicoCurso',$codPpc);
            
        if(!is_null($ppc))
        {
            try
            {
                $this->entity_manager->remove($ppc);
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

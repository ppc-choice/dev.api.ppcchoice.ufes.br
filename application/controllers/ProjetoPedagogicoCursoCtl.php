
<?php defined('BASEPATH') OR exit('No direct script access allowed');



require_once APPPATH . 'libraries/API_Controller.php';


class ProjetoPedagogicoCursoCtl extends API_Controller
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
    * @apiSuccess {Number} qtdPeriodos  Quantidade de períodos necessário para a conclusão do curso em situação normal..
    * @apiSuccess {Number} chTotal  Carga horária total que as componentes curriculares do curso deve possuir.
    * @apiSuccess {String} anoAprovacao  Ano de aprovação do projeto pedagógico de curso.
    * @apiSuccess {String = "CORRENTE", "ATIVO ANTERIOR", "INATIVO"} situacao  Situação em que se encontra o projeto pedagógico de curso.
    * @apiSuccess {String} codCurso  Código de indentificação do curso que o projeto pedagógico de curso integraliza.  .
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
        
        $ppc = $this->entity_manager->find('Entities\ProjetoPedagogicoCurso', $codPpc);
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
   
}
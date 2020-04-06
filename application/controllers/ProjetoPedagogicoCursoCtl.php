
<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @api {get} projetos-pedagogicos-cursos/:codPpc Solicitar Projeto Pedagógico de Curso.
 * @apiName getById
 * @apiGroup ProjetoPedagogicoCurso
 *
 * @apiParam {Number} codPpc Código de identificação de um Projeto Pedagógico de Curso.
 *
 * @apiSuccess {String} dtInicioVigencia Data correspondente ao ínicio de vigência do Projeto Pedagógico do Curso.
 * @apiSuccess {String} dtTerminoVigencia  Data correspondente ao término de vigência do Projeto Pedagógico do Curso.
 * @apiSuccess {String} chTotalDisciplinaOpt  Carga horária total de disciplinas optativas.
 * @apiSuccess {String} chTotalDisciplinaOb  Carga horária total de disciplinas obrigatórias.
 * @apiSuccess {String} chTotalAtividadeExt  Carga horária total de atividades extra.
 * @apiSuccess {String} chTotalAtividadeCmplt  Carga horária total de atividades complementares.
 * @apiSuccess {String} chTotalProjetoConclusao  Carga horária total de projeto de conclusão.
 * @apiSuccess {String} chTotalEstagio  Carga horária total de estágio.
 * @apiSuccess {String} duracao  Tempo de duração do curso.
 * @apiSuccess {String} qtdPeriodos  Lastname of the User.
 * @apiSuccess {String} chTotal  Lastname of the User.
 * @apiSuccess {String} anoAprovacao  Lastname of the User.
 * @apiSuccess {String} codCurso  Lastname of the User.
 * @apiSuccess {String} nome  Lastname of the User.
 * @apiSuccess {String} anoCriacao  Lastname of the User.
 * @apiSuccess {String} codUnEnsino  Lastname of the User.
 * @apiSuccess {String} nome  Lastname of the User.
 * @apiSuccess {String} cnpj  Lastname of the User.
 * @apiSuccess {String} codIes  Lastname of the User.
 * @apiSuccess {String} nome  Lastname of the User.
 * @apiSuccess {String} abreviatura  Lastname of the User.

 * apiExample {curl} Exemplo:
 *      curl -i http://dev.api.ppcchoice.ufes.br/dependencias/6/1
 * @apiSuccessExample {JSON} Success-Response:
 * HHTP/1.1 200 OK
 * 
 * {
 *   "codPpc": 1,
 *   "dtInicioVigencia": "2011-08-01",
 *   "dtTerminoVigencia": null,
 *   "chTotalDisciplinaOpt": 240,
 *   "chTotalDisciplinaOb": 3030,
 *   "chTotalAtividadeExt": 0,
 *   "chTotalAtividadeCmplt": 180,
 *   "chTotalProjetoConclusao": 120,
 *   "chTotalEstagio": 300,
 *   "duracao": 5,
 *   "qtdPeriodos": 10,
 *   "chTotal": 3870,
 *   "anoAprovacao": 2011,
 *   "situacao": "ATIVO ANTERIOR",
 *   "curso": {
 *      "codCurso": 1,
 *     "nome": "Ciência da Computação",
 *     "anoCriacao": 2011,
 *     "unidadeEnsino": {
 *       "codUnEnsino": 1,
 *       "nome": "Campus São Mateus",
 *       "cnpj": "32.479.123/0001-43",
 *       "ies": {
 *         "codIes": 573,
 *         "nome": "Universidade Federal do Espírito Santo",
 *         "abreviatura": "UFES"
 *              }
 *          }
 *      }      
 * }
 */

require_once APPPATH . 'libraries/API_Controller.php';


class ProjetoPedagogicoCursoCtl extends API_Controller
{
    
    public function __construct() {
        parent::__construct();
    }
    public function getAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
           
            'methods' => array('GET'), 

        ));
       
        $ppc = $this->entity_manager->getRepository('Entities\ProjetoPedagogicoCurso')->findBy(array());
        $result = $this->doctrine_to_array($ppc);

        $this->api_return(
            array(
                'status' => true,
                "result" => $result,
            ),
        200);
        
    }
    public function getById($codPpc)
    {
        
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
           
            'methods' => array('GET'), 

        ));
        
        $ppc = $this->entity_manager->find('Entities\ProjetoPedagogicoCurso', $codPpc);
        $result = $this->doctrine_to_array($ppc);

        $this->api_return(
            array(
                'status' => true,
                "result" => $result,
            ),
        200);
    }

    

   
   
}
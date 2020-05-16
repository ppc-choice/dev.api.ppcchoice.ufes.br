<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class ProjetoPedagogicoCursoController extends APIController
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
    * @apiSuccess {ProjetoPedagogicoCurso[]} projetoPedagógicoCurso Array de objetos do tipo Projeto Pesagógico Curso.
    *
    * @apiError {String[]} error Entities\\ProjetoPedagogicoCurso: Instância não encontrada.    *
    */
    public function findAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));
       
        $colecaoPpc = $this->entityManager->getRepository('Entities\ProjetoPedagogicoCurso')->findAll();
        
        if(!empty($colecaoPpc)){
            $colecaoPpc = $this->doctrineToArray($colecaoPpc,TRUE);
            
            $this->apiReturn($colecaoPpc,
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
    * @api {get} projetos-pedagogicos-curso/:codPpc Requisitar Projeto Pedagógico de Curso.
    * @apiParam {Number} codPpc Código de identificação de um Projeto Pedagógico de Curso.
    *
    * @apiName findById
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
    * @apiError {String[]} error Entities\\ProjetoPedagogicoCurso: Instância não encontrada.    *
    */
    public function findById($codPpc)
    {
        
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'), 
        ));

        $ppc = $this->entityManager->getRepository('Entities\ProjetoPedagogicoCurso')->findById($codPpc);
        
        if(!empty($ppc)){
            $ppc = $this->doctrineToArray($ppc, TRUE);

            $this->apiReturn($ppc,
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
    * @api {post} projetos-pedagogicos-curso Criar um novo Projeto Pedagógico de Curso.
    *
    * @apiName create
    * @apiGroup Projeto Pedagógico Curso
    *
    * @apiParam (Request Body/JSON) {DateTime} dtInicioVigencia Data correspondente ao ínicio de vigência do projeto pedagógico do curso.
    * @apiParam (Request Body/JSON) {DateTime} dtTerminoVigencia  Data correspondente ao término de vigência do projeto pedagógico do curso (Obrigatório para projeto pedagógicos de cursos INATIVOS).
    * @apiParam (Request Body/JSON) {Number} [chTotalDisciplinaOpt = 0]  Carga horária total de disciplinas optativas que o curso deve possuir.
    * @apiParam (Request Body/JSON) {Number} [chTotalDisciplinaOb = 0]  Carga horária total de disciplinas obrigatórias que o curso deve possuir.
    * @apiParam (Request Body/JSON) {Number} [chTotalAtividadeExt = 0] Carga horária total de atividades extensão que o curso deve possuir.
    * @apiParam (Request Body/JSON) {Number} [chTotalAtividadeCmplt = 0]  Carga horária total de atividades complementares que o curso deve possuir.
    * @apiParam (Request Body/JSON) {Number} [chTotalProjetoConclusao = 0]  Carga horária total de projeto de conclusão de curso deve possuir.
    * @apiParam (Request Body/JSON) {Number} [chTotalEstagio = 0]  Carga horária total de estágio que o curso deve possuir.
    * @apiParam (Request Body/JSON) {Number} qtdPeriodos  Quantidade de períodos necessário para a conclusão do curso em situação normal.
    * @apiParam (Request Body/JSON) {String} anoAprovacao  Ano de aprovação do projeto pedagógico de curso.
    * @apiParam (Request Body/JSON) {String = "CORRENTE", "ATIVO ANTERIOR", "INATIVO"} situacao  Situação em que se encontra o projeto pedagógico de curso.
    * @apiParam (Request Body/JSON) {String} codCurso  Código de indentificação do curso que o projeto pedagógico de curso integraliza.  
    *
    * @apiSuccess {String[]} message Entities\\ProjetoPedagogicoCurso: Instância criada com sucesso.
    *
    * @apiError {String[]} error Entities\\ProjetoPedagogicoCurso: Instância não encontrada.
    * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
    */
    
    public function create()
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('POST'),
			)
		);

		$payload = json_decode(file_get_contents('php://input'),TRUE);
        $ppc = new Entities\ProjetoPedagogicoCurso();
        
        if(isset($payload['codCurso'])) 
        {
            $curso = $this->entityManager->find('Entities\Curso',$payload['codCurso']);
            $ppc->setCurso($curso);
        } 
            
        if(array_key_exists('situacao', $payload)) $ppc->setSituacao(strtoupper($payload['situacao']));
        
        if(array_key_exists('dtTerminoVigencia', $payload)) 
        {
            if(is_null($payload['dtTerminoVigencia']))
                $ppc->setDtTerminoVigencia(null);
            else
                $ppc->setDtTerminoVigencia(new DateTime($payload['dtTerminoVigencia']));
        }

        
        if(array_key_exists('chTotalDisciplinaOpt', $payload)) 
            $ppc->setChTotalDisciplinaOpt($payload['chTotalDisciplinaOpt']);
        else
            $ppc->setChTotalDisciplinaOpt(0);

        if(array_key_exists('chTotalDisciplinaOb', $payload)) 
            $ppc->setChTotalDisciplinaOb($payload['chTotalDisciplinaOb']);
        else
            $ppc->setChTotalDisciplinaOb(0);

        if(array_key_exists('chTotalAtividadeExt',$payload))
            $ppc->setChTotalAtividadeExt($payload['chTotalAtividadeExt']);
        else
            $ppc->setChTotalAtividadeExt(0);

        if(array_key_exists('chTotalAtividadeCmplt', $payload)) 
            $ppc->setChTotalAtividadeCmplt($payload['chTotalAtividadeCmplt']);
        else
            $ppc->setChTotalAtividadeCmplt(0);

        if(array_key_exists('chTotalProjetoConclusao', $payload)) 
            $ppc->setChTotalProjetoConclusao($payload['chTotalProjetoConclusao']);
        else
            $ppc->setChTotalProjetoConclusao(0);  
        
        if(array_key_exists('chTotalEstagio',$payload)) 
            $ppc->setChTotalEstagio($payload['chTotalEstagio']);
        else
            $ppc->setChTotalEstagio(0);
                
        if(array_key_exists('dtInicioVigencia', $payload)) $ppc->setDtInicioVigencia(new DateTime($payload['dtInicioVigencia']));
        
        if(array_key_exists('qtdPeriodos', $payload)) $ppc->setQtdPeriodos($payload['qtdPeriodos']);
        
        if(array_key_exists('anoAprovacao', $payload)) $ppc->setAnoAprovacao($payload['anoAprovacao']);
        
        if(array_key_exists('duracao', $payload)) $ppc->setDuracao(floatval($payload['duracao']));
        
        $ppc->setChTotal(0);
        
        $constraints = $this->validator->validate($ppc);
        
        if ( $constraints->success() ){
            
            $chtotal = $ppc->getChTotalDisciplinaOpt()+ $ppc->getChTotalDisciplinaOb()+
                        $ppc->getChTotalAtividadeExt()+ $ppc->getChTotalAtividadeCmplt()+
                        $ppc->getChTotalProjetoConclusao()+ $ppc->getChTotalEstagio();
            
            $ppc->setChTotal($chtotal);
    
            try{
                $this->entityManager->persist($ppc);
                $this->entityManager->flush();
    
                $this->apiReturn(array(
                    'message' => $this->stdMessage(STD_MSG_CREATED),
                    ),self::HTTP_OK
                );
    
            } catch (\Exception $e){
                $this->apiReturn(array(
                    'error' => $this->stdMessage(STD_MSG_EXCEPTION),
                    ),self::HTTP_BAD_REQUEST
                );
            }
        }
        else{
            $this->apiReturn(array(
                'error' => $constraints->messageArray(),
                ),self::HTTP_BAD_REQUEST
            );
        }
    }   

    /**
    * @api {PUT} projetos-pedagogicos-curso/:codPpc Atualizar um Projeto Pedagógico de Curso.
    * @apiParam {Number} codPpc Código de identificação de um Projeto Pedagógico de Curso.
    *
    * @apiName update
    * @apiGroup Projeto Pedagógico Curso
    *
    * @apiParam (Request Body/JSON) {DateTime} [dtInicioVigencia] Data correspondente ao ínicio de vigência do projeto pedagógico do curso.
    * @apiParam (Request Body/JSON) {DateTime} [dtTerminoVigencia]  Data correspondente ao término de vigência do projeto pedagógico do curso (Obrigatório para projeto pedagógicos de cursos INATIVOS).
    * @apiParam (Request Body/JSON) {Number} [chTotalDisciplinaOpt]  Carga horária total de disciplinas optativas que o curso deve possuir.
    * @apiParam (Request Body/JSON) {Number} [chTotalDisciplinaOb]  Carga horária total de disciplinas obrigatórias que o curso deve possuir.
    * @apiParam (Request Body/JSON) {Number} [chTotalAtividadeExt]  Carga horária total de atividades extensão que o curso deve possuir.
    * @apiParam (Request Body/JSON) {Number} [chTotalAtividadeCmplt]  Carga horária total de atividades complementares que o curso deve possuir.
    * @apiParam (Request Body/JSON) {Number} [chTotalProjetoConclusao]  Carga horária total de projeto de conclusão de curso deve possuir.
    * @apiParam (Request Body/JSON) {Number} [chTotalEstagio]  Carga horária total de estágio que o curso deve possuir.
    * @apiParam (Request Body/JSON) {Number} [qtdPeriodos]  Quantidade de períodos necessário para a conclusão do curso em situação normal.
    * @apiParam (Request Body/JSON) {String} [anoAprovacao]  Ano de aprovação do projeto pedagógico de curso.
    * @apiParam (Request Body/JSON) {String = "CORRENTE", "ATIVO ANTERIOR", "INATIVO"} [situacao]  Situação em que se encontra o projeto pedagógico de curso.
    * @apiParam (Request Body/JSON) {String} [codCurso]  Código de indentificação do curso que o projeto pedagógico de curso integraliza.  
    * 
    * @apiSuccess {String[]} message Entities\\ProjetoPedagogicoCurso: Instância atualizada com sucesso.
    *
    * @apiError {String[]} error Entities\\ProjetoPedagogicoCurso: Instância não encontrada.
    * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
    */
    public function update($codPpc)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
			'methods' => array('PUT'),
			)
		);

        $payload = json_decode(file_get_contents('php://input'),TRUE);
        $ppc = $this->entityManager->find('Entities\ProjetoPedagogicoCurso',$codPpc);
        
        if(!is_null($ppc))
        {
            if(array_key_exists('codCurso', $payload)) 
            {
                $curso = $this->entityManager->find('Entities\Curso',$payload['codCurso']);
                $ppc->setCurso($curso);
            }   

            if(array_key_exists('situacao', $payload)) $ppc->setSituacao(strtoupper($payload['situacao']));

            if(array_key_exists('dtTerminoVigencia', $payload)) 
            {
                if(is_null($payload['dtTerminoVigencia']))
                    $ppc->setDtTerminoVigencia(null);
                else
                    $ppc->setDtTerminoVigencia(new DateTime($payload['dtTerminoVigencia']));
            }
            
            if(array_key_exists('chTotalDisciplinaOpt', $payload)) $ppc->setChTotalDisciplinaOpt($payload['chTotalDisciplinaOpt']);
            
            if(array_key_exists('chTotalDisciplinaOb', $payload)) $ppc->setChTotalDisciplinaOb($payload['chTotalDisciplinaOb']);
            
            if(array_key_exists('chTotalAtividadeExt',$payload)) $ppc->setChTotalAtividadeExt($payload['chTotalAtividadeExt']);
            
            if(array_key_exists('chTotalAtividadeCmplt', $payload)) $ppc->setChTotalAtividadeCmplt($payload['chTotalAtividadeCmplt']);
            
            if(array_key_exists('chTotalProjetoConclusao', $payload)) $ppc->setChTotalProjetoConclusao($payload['chTotalProjetoConclusao']);
            
            if(array_key_exists('chTotalEstagio',$payload)) $ppc->setChTotalEstagio($payload['chTotalEstagio']);
            
            if(array_key_exists('dtInicioVigencia', $payload)) $ppc->setDtInicioVigencia(new DateTime($payload['dtInicioVigencia']));
            
            if(array_key_exists('qtdPeriodos', $payload)) $ppc->setQtdPeriodos($payload['qtdPeriodos']);
            
            if(array_key_exists('anoAprovacao', $payload)) $ppc->setAnoAprovacao($payload['anoAprovacao']);
            
            if(array_key_exists('duracao', $payload)) $ppc->setDuracao(floatval($payload['duracao']));
    
            $constraints = $this->validator->validate($ppc);

            if ( $constraints->success() )
            {
                $chtotal = $ppc->getChTotalDisciplinaOpt()+ $ppc->getChTotalDisciplinaOb()+
                        $ppc->getChTotalAtividadeExt()+ $ppc->getChTotalAtividadeCmplt()+
                        $ppc->getChTotalProjetoConclusao()+ $ppc->getChTotalEstagio();
            
                $ppc->setChTotal($chtotal);
                
                try {
                    $this->entityManager->merge($ppc);
                    $this->entityManager->flush();
                    
                    $this->apiReturn(array(
                        'message' => $this->stdMessage(STD_MSG_UPDATED),
                        ), self::HTTP_OK
                     );
                    
                } catch (\Exception $e){
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
                ), self::HTTP_NOT_FOUND 
            );
        }        
    }

    /**
    * @api {DELETE} projetos-pedagogicos-curso/:codPpc Deletar Projeto Pedagógico de Curso.
    * @apiParam {Number} codPpc Código de identificação de um Projeto Pedagógico de Curso.
    *
    * @apiName delete
    * @apiGroup Projeto Pedagógico Curso
    *
    * @apiSuccess {String[]} message Entities\\ProjetoPedagogicoCurso: Instância removida com sucesso.
    *
    * @apiError {String[]} error Entities\\ProjetoPedagogicoCurso: Instância não encontrada.
    */
    public function delete($codPpc)
	{
        header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('DELETE'),
			)
		);

        $ppc = $this->entityManager->find('Entities\ProjetoPedagogicoCurso',$codPpc);
            
        if(!is_null($ppc))
        {
            try
            {
                $this->entityManager->remove($ppc);
                $this->entityManager->flush();
                
                $this->apiReturn(array(
                    'message' => $this->stdMessage(STD_MSG_DELETED),
                    ), self::HTTP_OK
                );

            }catch (\Exception $e){
                $this->apiReturn(array(
                    'error' => $this->stdMessage(STD_MSG_EXCEPTION),
                    ), self::HTTP_BAD_REQUEST 
                );
            }
        }
        else{   
            $this->apiReturn(array(
                'error' => $this->stdMessage(STD_MSG_NOT_FOUND),
                ), self::HTTP_NOT_FOUND
            );
        }		
    }
}

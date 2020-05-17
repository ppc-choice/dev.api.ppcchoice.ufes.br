<?php

use PHPUnit\Framework\TestCase;

class ProjetoPedagogicoCursoTest extends TestCase
{
    // Cliente HTTP para testes de requisição
    private $http;

    // Entity name 
    private $entity;
    
    // Mensagens de sucesso
    const CREATED = 'CREATED';
    
    const UPDATED = 'UPDATED';

    const DELETED = 'DELETED';


    // Error
    const NOT_FOUND = 'NOT_FOUND';

    const EXCEPTION = 'EXCEPTION';

    const CONSTRAINT_SITUACAO = 'CONSTRAINT_SITUACAO';

    const CONSTRAINT_DATA_VAZIA = 'CONSTRAINT_DATA_VAZIA';

    const CONSTRAINT_DATA_TERMINO = 'CONSTRAINT_DATA_TERMINO';

    const CONSTRAINT_MENOR_DATA = 'CONSTRAINT_MENOR_DATA';

    const CONSTRAINT_NOT_NULL = 'CONSTRAINT_NOT_NULL';

    const CONSTRAINT_INTEGER = 'CONSTRAINT_INTEGER';

    const CONSTRAINT_FLOAT = 'CONSTRAINT_FLOAT'; 

    const CONSTRAINT_DATE_TIME = 'CONSTRAINT_DATE_TIME';

    const CONSTRAINT_CHOICE = 'CONSTRAINT_CHOICE'; 

    const CONSTRAINT_NOT_BLANK = 'CONSTRAINT_NOT_BLANK'; 

    const CONSTRAINT_INVALID_MESSAGE = 'CONSTRAINT_INVALID_MESSAGE';
    
    const CONSTRAINT_RANGE= 'CONSTRAINT_RANGE';

    const CONSTRAINT_RANGE_YEAR= 'CONSTRAINT_RANGE_YEAR';

    // Mensagens padrão de retorno
    const STD_MSGS = [
        self::CREATED => 'Instância criada com sucesso.', 
        self::DELETED => 'Instância removida com sucesso.', 
        self::UPDATED => 'Instância atualizada com sucesso.', 
        self::NOT_FOUND => 'Instância não encontrada.', 
        self::EXCEPTION => 'Ocorreu uma exceção ao persistir a instância.', 
        self::CONSTRAINT_SITUACAO => 'Não é permitido mais de um Projeto Pedagogico de Curso com a situação CORRENTE OU ATIVO ANTERIOR.',
        self::CONSTRAINT_DATA_VAZIA => 'Projeto pedagógico de curso com situação corrente e ativo-anterior a data de termino de vigência deve ser nulo.',
        self::CONSTRAINT_DATA_TERMINO => 'A data de termino de vigência em projeto pedagogico de curso com situacao INATIVO não pode ser vazia.',
        self::CONSTRAINT_MENOR_DATA => 'A data de termino de vigência deve ser maior que a data de inicio de vigência.',
        self::CONSTRAINT_NOT_NULL => 'Este valor não deve ser nulo.',
        self::CONSTRAINT_INTEGER => 'Este valor deve ser do tipo integer.',
        self::CONSTRAINT_FLOAT => 'Este valor deve ser do tipo float.',
        self::CONSTRAINT_DATE_TIME => 'Este valor não é uma data e hora válida.',
        self::CONSTRAINT_CHOICE => 'O valor selecionado não é uma opção válida.',
        self::CONSTRAINT_NOT_BLANK => 'Este valor não deve ser vazio.',
        self::CONSTRAINT_INVALID_MESSAGE => 'O valor deve ser um número válido.',
        self::CONSTRAINT_RANGE =>'O valor mínimo aceitável é 0.',
        self::CONSTRAINT_RANGE_YEAR => 'O valor mínimo aceitável é 1950.'
    ];

    public function setUp(){
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://dev.api.ppcchoice.ufes.br:8080/']);
        $this->entity = preg_replace('/Test$/', "", get_class($this));
    }

    public function tearDown() {
        $this->http = null;
        $this->entity = null;
    }

    /** 
    * Gera chave para o array de mensagens padrões de retorno da API.
    * @author Hádamo Egito (http://github.com/hadamo)  
    * @param $category {string} Tipo da mensagem de retorno da API.
    * @return string
    */
    public function generateKey($category)
    {
        switch ($category) {
            case self::CREATED:
            case self::DELETED:
            case self::UPDATED:
                $key = 'message';
                break;
            case self::NOT_FOUND:
            case self::EXCEPTION:
            case self::CONSTRAINT_NOT_NULL:
            case self::CONSTRAINT_SITUACAO:
            case self::CONSTRAINT_DATA_VAZIA:
            case self::CONSTRAINT_DATA_TERMINO:
            case self::CONSTRAINT_MENOR_DATA:
            case self::CONSTRAINT_INTEGER:
            case self::CONSTRAINT_FLOAT:
            case self::CONSTRAINT_DATE_TIME:
            case self::CONSTRAINT_CHOICE:
            case self::CONSTRAINT_NOT_BLANK:
            case self::CONSTRAINT_INVALID_MESSAGE:
            case self::CONSTRAINT_RANGE:
            case self::CONSTRAINT_RANGE_YEAR:
                $key = 'error';
                break;
            default:
                $key = 'key';
                break;
        }
        return $key;   
    }

    /** 
    * Gera mensagem para o array de mensagens padrões de retorno da API.
    * @author Hádamo Egito (http://github.com/hadamo)  
    * @param $subpath {string} Identifica o atributo da classe na qual o erro ocorre.
    * @param $category {string} Tipo da mensagem de retorno da API.
    * @return string
    */
    public function generateMessage($category, $subpath = '')
    {
        return 'Entities\\' . $this->entity . ( !empty($subpath) ? '.'  :  ''  ) 
            . $subpath . ':    '  . self::STD_MSGS[$category];
    }

    /** 
    * Gera objeto json com chave da categoria e mensagens padrões de retorno da API.
    * @author Hádamo Egito (http://github.com/hadamo)  
    * @param $subpath {string} Identifica o atributo da classe na qual o erro ocorre.
    * @param $category {string} Tipo da mensagem de retorno da API.
    * @return json
    */
    public function getStdMessage($category = 'NOT_FOUND', $subpath = '')
    {
        $key = $this->generateKey($category);
        return json_encode( [ $key => [$this->generateMessage($category, $subpath)]]);
    }

    /** 
    * Gera objeto json com todas as mensagens de erro.
    * @author Hádamo Egito (http://github.com/hadamo)  
    * @param $violation {Array} Array com categorias como chave e array de strings com todos os subpathes como valor.
    * @return json
    */
    public function getMultipleErrorMessages($violations)
    {
        $messages = [];
        //foreach ($violations as $category => $subpathes) {
            foreach ($violations as $content ) {
                $message = $this->generateMessage($content[0],$content[1]);
                array_push($messages,$message);
            }
        
        $errorArray = ["error" => $messages];        
        return json_encode($errorArray);
    }

    // Testes

    public function testGetProjetoPedagogicoCursoNaoExistente()
    {
        $response = $this->http->request('GET','projetos-pedagogicos-curso/100', ['http_errors' => FALSE] );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    } 
    
    public function testGetProjetoPedagogicoCursoExistente()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/4', ['http_errors' => FALSE] );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();

        $ppcArray = [ 
                        'codPpc'=>4,
                        'dtInicioVigencia'=> '2021-01-01T00:00:00-03:00',                   
                        'dtTerminoVigencia'=> null, 
                        'chTotalDisciplinaOpt'=> 0, 
                        'chTotalDisciplinaOb'=> 0, 
                        'chTotalAtividadeExt'=> 0, 
                        'chTotalAtividadeCmplt'=> 0, 
                        'chTotalProjetoConclusao'=> 60, 
                        'chTotalEstagio'=>300, 
                        'duracao'=> 5,
                        'qtdPeriodos'=> 10,
                        'chTotal'=> 0, 
                        'anoAprovacao'=> 2020,
                        'situacao'=> 'CORRENTE', 
                        'codCurso'=> 2,
                    ];

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertEquals(json_encode($ppcArray), $contentBody);
    } 

    public function testGetAllProjetoPedagogicoCursoExistente()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso', ['http_errors' => FALSE] );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
    
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

    }

    public function testPostProjetoPedagogicoCurso()
    {
        $response = $this->http->request('POST', 'projetos-pedagogicos-curso',
                                                [ 'json' => [ 
                                                                'dtInicioVigencia'=> '1995-01-09T00:00:00-02:00', 
                                                                'dtTerminoVigencia'=> '2000-01-09T00:00:00-02:00',
                                                                'duracao'=> 5, 
                                                                'qtdPeriodos'=> 10, 
                                                                'anoAprovacao'=> 1994,
                                                                'situacao'=> 'INATIVO', 
                                                                'codCurso'=> 1
                                                            ], 
                                                            'http_errors' => FALSE ]);
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CREATED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);

    }

    public function testPostProjetoPedagogicoCursoSituacao()
    {
        $response = $this->http->request('POST', 'projetos-pedagogicos-curso',
                                                [ 'json' => [
                                                                'dtInicioVigencia'=> '1995-01-09T00:00:00-02:00', 
                                                                'dtTerminoVigencia'=> null,
                                                                'duracao'=> 5, 'qtdPeriodos'=> 10, 
                                                                'anoAprovacao'=> 1994,
                                                                'situacao'=> 'CORRENTE', 
                                                                'codCurso'=> 1
                                                            ], 
                                                            'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_SITUACAO, "situacao");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPostProjetoPedagogicoCursoDtVigenciaVazia()
    {
        $response = $this->http->request('POST', 'projetos-pedagogicos-curso',
                                                [ 'json' => [ 
                                                                'dtInicioVigencia'=> '2000-01-09T00:00:00-02:00', 
                                                                'dtTerminoVigencia'=> '2000-01-09T00:00:00-02:00', 
                                                                'chTotalDisciplinaOpt'=> 300, 
                                                                'chTotalDisciplinaOb'=> 3030,
                                                                'chTotalAtividadeExt'=> 0, 
                                                                'chTotalAtividadeCmplt'=> 180, 
                                                                'chTotalProjetoConclusao'=> 120,
                                                                'chTotalEstagio'=> 300, 
                                                                'duracao'=> 5, 
                                                                'qtdPeriodos'=> 10, 
                                                                'anoAprovacao'=> 2015,
                                                                'situacao'=> 'CorRente', 
                                                                'codCurso'=> 0
                                                            ], 
                                                            'http_errors' => FALSE] );
        $violations = [
                        [self::CONSTRAINT_DATA_VAZIA, "dtTerminoVigencia"],
                        [self::CONSTRAINT_NOT_NULL, "curso"]
        ];

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $errorArray = $this->getMultipleErrorMessages($violations); 

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($errorArray, $contentBody);    
    }

    public function testPostProjetoPedagogicoCursoDtVaziaInativo()
    {
        $response = $this->http->request('POST', 'projetos-pedagogicos-curso',
                                                [ 'json' => [ 
                                                                'dtInicioVigencia'=> '2000-01-09T00:00:00-02:00', 
                                                                'dtTerminoVigencia'=> null, 
                                                                'chTotalDisciplinaOpt'=> 300, 
                                                                'chTotalDisciplinaOb'=> 3030,
                                                                'chTotalAtividadeExt'=> 0, 
                                                                'chTotalAtividadeCmplt'=> 180, 
                                                                'chTotalProjetoConclusao'=> 120,
                                                                'chTotalEstagio'=> 300, 
                                                                'duracao'=> 5, 
                                                                'qtdPeriodos'=> 10, 
                                                                'anoAprovacao'=> 2015,
                                                                'situacao'=> 'INATIVO',
                                                                'codCurso'=> 3
                                                            ], 
                                                            'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_DATA_TERMINO, "dtTerminoVigencia");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);

    }

    public function testPostProjetoPedagogicoCursoDtTerminoInativo()
    {
        $response = $this->http->request('POST', 'projetos-pedagogicos-curso',
                                                [ 'json' => [ 
                                                                'dtInicioVigencia'=> '2000-01-09T00:00:00-02:00', 
                                                                'dtTerminoVigencia'=> '2000-01-04T00:00:00-02:00', 
                                                                'chTotalDisciplinaOpt'=> 300, 
                                                                'chTotalDisciplinaOb'=> 3030,
                                                                'chTotalAtividadeExt'=> 0, 
                                                                'chTotalAtividadeCmplt'=> 180, 
                                                                'chTotalProjetoConclusao'=> 120, 
                                                                'chTotalEstagio'=> 300, 
                                                                'duracao'=> 5, 'qtdPeriodos'=> 10, 
                                                                'anoAprovacao'=> 2015,
                                                                'situacao'=> 'INATIVO', 
                                                                'codCurso'=> 3
                                                            ], 
                                                            'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_MENOR_DATA, "dtTerminoVigencia");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutProjetoPedagogicoCurso()
    {
        $response = $this->http->request('PUT', 'projetos-pedagogicos-curso/1',['json'=>[],
                                         'http_errors' => FALSE]);
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::UPDATED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertEquals($message, $contentBody);    
    }

    public function testPutProjetoPedagogicoCursoFalha()
    {
        $response = $this->http->request('PUT', 'projetos-pedagogicos-curso/100', [ 'json'=>[],'http_errors' => FALSE] );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);
        
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertEquals($message, $contentBody);
    }

    public function testPutProjetoPedagogicoCursoSituacao()
    {
        $response = $this->http->request('PUT', 'projetos-pedagogicos-curso/1', 
                                                ['json'=>[
                                                            'situacao'=>'INATIVO'
                                                        ], 
                                                        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        
        $violations = [
                        
                        [self::CONSTRAINT_DATA_TERMINO, "dtTerminoVigencia"]
                     ];

        $errorArray = $this->getMultipleErrorMessages($violations);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertEquals($errorArray, $contentBody);    
    }

    public function testPutProjetoPedagogicoCursoDtVazia()
    {
        $response = $this->http->request('PUT', 'projetos-pedagogicos-curso/1', 
                                                ['json'=>[
                                                                'dtTerminoVigencia'=>'2011-08-01T00:00:00-03:00'
                                                         ],
                                                         'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_DATA_VAZIA, "dtTerminoVigencia");

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertEquals($message, $contentBody);    
    }
    
    public function testPutProjetoPedagogicoCursoDtTerminoVaziaInativo()
    {
        $response = $this->http->request('PUT', 'projetos-pedagogicos-curso/5',
                                                [ 'json' => [
                                                                'situacao'=> 'INATIVO'
                                                            ], 
                                                            'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_DATA_TERMINO, "dtTerminoVigencia");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutProjetoPedagogicoCursoMenorDataInativo()
    {
        $response = $this->http->request('PUT', 'projetos-pedagogicos-curso/4',
                                                [ 'json' => [ 
                                                                'dtTerminoVigencia'=> '2000-01-04T00:00:00-02:00',
                                                                'situacao'=> 'INATIVO'
                                                            ], 
                                                            'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_MENOR_DATA, "dtTerminoVigencia");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testDeleteProjetoPedagogicoCurso()
    {
        $response = $this->http->request('DELETE', 'projetos-pedagogicos-curso/40', ['http_errors' => FALSE] );
       
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::DELETED);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertEquals($message, $contentBody);
    }

    public function testDeleteProjetoPedagogicoCursoFalha()
    {
        $response = $this->http->request('DELETE', 'projetos-pedagogicos-curso/100', ['http_errors' => FALSE] );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertEquals($message, $contentBody);
    }

    // Teste de erro com entrada null

    public function testPostProjetoPedagogicoCursoInputValuesNull()
    {
        $response = $this->http->request('POST','projetos-pedagogicos-curso', 
                                                [ 'json' => [ 
                                                                'dtInicioVigencia'=> null,
                                                                'dtTerminoVigencia'=> null,
                                                                'chTotalDisciplinaOb'=> null,
                                                                'chTotalDisciplinaOpt'=>null,
                                                                'chTotalAtividadeExt'=> null,
                                                                'chTotalAtividadeCmplt'=> null,
                                                                'chTotalProjetoConclusao'=> null,
                                                                'chTotalEstagio'=> null,
                                                                'duracao'=> null,
                                                                'qtdPeriodos'=> null,
                                                                'anoAprovacao'=> null,
                                                                'situacao'=>null,
                                                                'codCurso'=> null
                                                            ], 
                                                            'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        

        $violations = [[self::CONSTRAINT_NOT_NULL,'dtInicioVigencia'], 
                        [self::CONSTRAINT_NOT_BLANK,'dtInicioVigencia'], 
                        // [self::CONSTRAINT_NOT_BLANK,'dtTerminoVigencia'], 
                        [self::CONSTRAINT_NOT_NULL ,'chTotalDisciplinaOpt'], 
                        [self::CONSTRAINT_NOT_NULL ,'chTotalDisciplinaOb'], 
                        [self::CONSTRAINT_NOT_NULL ,'chTotalAtividadeExt'], 
                        [self::CONSTRAINT_NOT_NULL ,'chTotalAtividadeCmplt'],
                        [self::CONSTRAINT_NOT_NULL ,'chTotalProjetoConclusao'],
                        [self::CONSTRAINT_NOT_NULL , 'chTotalEstagio'],
                        [self::CONSTRAINT_NOT_NULL ,  'duracao'] ,
                        [self::CONSTRAINT_NOT_NULL , 'qtdPeriodos'],
                        [self::CONSTRAINT_NOT_NULL , 'anoAprovacao'],
                        [self::CONSTRAINT_CHOICE ,'situacao'],
                        [self::CONSTRAINT_NOT_NULL ,'curso']]; 

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutProjetoPedagogicoCursoInputValuesNull()
    {
        $response = $this->http->request('PUT','projetos-pedagogicos-curso/1', 
                                            [ 'json' => [ 
                                                            'dtInicioVigencia'=> null,
                                                            'dtTerminoVigencia'=> null,
                                                            'chTotalDisciplinaOb'=> null,
                                                            'chTotalDisciplinaOpt'=> null,
                                                            'chTotalAtividadeExt'=> null,
                                                            'chTotalAtividadeCmplt'=> null,
                                                            'chTotalProjetoConclusao'=> null,
                                                            'chTotalEstagio'=> null,
                                                            'duracao'=> null,
                                                            'qtdPeriodos'=> null,
                                                            'anoAprovacao'=> null,
                                                            'situacao'=>null,
                                                            'codCurso'=> null
                                                        ], 
                                                        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        

        $violations = [[self::CONSTRAINT_NOT_NULL,'dtInicioVigencia'], 
                        [self::CONSTRAINT_NOT_BLANK,'dtInicioVigencia'], 
                        // [self::CONSTRAINT_NOT_BLANK,'dtTerminoVigencia'], 
                        [self::CONSTRAINT_NOT_NULL ,'chTotalDisciplinaOpt'], 
                        [self::CONSTRAINT_NOT_NULL ,'chTotalDisciplinaOb'], 
                        [self::CONSTRAINT_NOT_NULL ,'chTotalAtividadeExt'], 
                        [self::CONSTRAINT_NOT_NULL ,'chTotalAtividadeCmplt'],
                        [self::CONSTRAINT_NOT_NULL ,'chTotalProjetoConclusao'],
                        [self::CONSTRAINT_NOT_NULL , 'chTotalEstagio'],
                        [self::CONSTRAINT_NOT_NULL ,  'duracao'] ,
                        [self::CONSTRAINT_NOT_NULL , 'qtdPeriodos'],
                        [self::CONSTRAINT_NOT_NULL , 'anoAprovacao'],
                        [self::CONSTRAINT_CHOICE ,'situacao'],
                        [self::CONSTRAINT_NOT_NULL ,'curso']]; 

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPostProjetoPedagogicoCursoInputValuesRange()
    {
        $response = $this->http->request('POST','projetos-pedagogicos-curso', 
                                                [ 'json' => [ 
                                                                'dtInicioVigencia'=> "", 
                                                                'chTotalDisciplinaOpt'=>-1, 
                                                                'chTotalDisciplinaOb'=> -1, 
                                                                'chTotalAtividadeExt'=> -1,
                                                                'chTotalAtividadeCmplt'=> -1, 
                                                                'chTotalProjetoConclusao'=> -1, 
                                                                'chTotalEstagio'=> -1, 
                                                                'duracao'=> -1, 
                                                                'qtdPeriodos'=> -1,
                                                                'situacao'=>"ATIVO ANTERIOR",
                                                                'anoAprovacao'=> 1400, 
                                                                'codCurso'=> ""
                                                            ], 
                                                            'http_errors' => FALSE] );
                                
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        

        $violations = [ 
                        [self::CONSTRAINT_NOT_BLANK,'dtInicioVigencia'], 
                        // [self::CONSTRAINT_NOT_BLANK,'dtTerminoVigencia'], 
                        [self::CONSTRAINT_RANGE,'chTotalDisciplinaOpt'], 
                        [self::CONSTRAINT_RANGE,'chTotalDisciplinaOb'], 
                        // [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalDisciplinaOb'], 
                        [self::CONSTRAINT_RANGE,'chTotalAtividadeExt'], 
                        // [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalAtividadeExt'], 
                        [self::CONSTRAINT_RANGE,'chTotalAtividadeCmplt'], 
                        // [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalAtividadeCmplt'], 
                        [self::CONSTRAINT_RANGE,'chTotalProjetoConclusao'], 
                        // [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalProjetoConclusao'], 
                        [self::CONSTRAINT_RANGE,'chTotalEstagio'], 
                        // [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalEstagio'], 
                        // [self::CONSTRAINT_NOT_NULL , 'chTotalEstagio'],
                        [self::CONSTRAINT_RANGE,'duracao'], 
                        [self::CONSTRAINT_RANGE,'qtdPeriodos'], 
                        // [self::CONSTRAINT_INVALID_MESSAGE ,'qtdPeriodos'],
                        // [self::CONSTRAINT_INTEGER ,'anoAprovacao'], 
                        [self::CONSTRAINT_RANGE_YEAR ,'anoAprovacao'], 
                        // [self::CONSTRAINT_INVALID_MESSAGE ,'anoAprovacao'],  
                        // [self::CONSTRAINT_NOT_NULL ,'situacao'],
                        [self::CONSTRAINT_NOT_NULL ,'curso']]; 

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($errorArray,$contentBody);
    }

    public function testPutProjetoPedagogicoCursoInputValuesRange()
    {
        $response = $this->http->request('PUT','projetos-pedagogicos-curso/1', 
                                                [ 'json' => [  
                                                                'chTotalDisciplinaOpt'=>-1, 
                                                                'chTotalDisciplinaOb'=> -1, 
                                                                'chTotalAtividadeExt'=> -1, 
                                                                'chTotalAtividadeCmplt'=> -1, 
                                                                'chTotalProjetoConclusao'=> -1, 
                                                                'chTotalEstagio'=> -1, 
                                                                'duracao'=> -1, 
                                                                'qtdPeriodos'=> -1, 
                                                                'anoAprovacao'=> 1400
                                                            ], 
                                                            'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        

        $violations = [  
                        [self::CONSTRAINT_RANGE,'chTotalDisciplinaOpt'], 
                        [self::CONSTRAINT_RANGE,'chTotalDisciplinaOb'], 
                        [self::CONSTRAINT_RANGE,'chTotalAtividadeExt'], 
                        [self::CONSTRAINT_RANGE,'chTotalAtividadeCmplt'], 
                        [self::CONSTRAINT_RANGE,'chTotalProjetoConclusao'], 
                        [self::CONSTRAINT_RANGE,'chTotalEstagio'], 
                        [self::CONSTRAINT_RANGE,'duracao'], 
                        [self::CONSTRAINT_RANGE,'qtdPeriodos'], 
                        [self::CONSTRAINT_RANGE_YEAR ,'anoAprovacao'] 
                    ];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($errorArray,$contentBody);
    }

    public function testPostProjetoPedagogicoCursoInputValuesBlank()
    {
        $response = $this->http->request('POST','projetos-pedagogicos-curso', 
                                                [ 'json' => [ 
                                                                'dtInicioVigencia'=> "",
                                                                'dtTerminoVigencia'=> "",
                                                                'chTotalDisciplinaOb'=>"",
                                                                'chTotalDisciplinaOpt'=>"", 
                                                                'chTotalAtividadeExt'=> "",
                                                                'chTotalAtividadeCmplt'=> "",
                                                                'chTotalProjetoConclusao'=> "",
                                                                'chTotalEstagio'=> "",
                                                                'duracao'=> "",
                                                                'qtdPeriodos'=> "",
                                                                'anoAprovacao'=> "",
                                                                'situacao'=>"", 
                                                                'codCurso'=> ""
                                                            ], 
                                                            'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        

        $violations = [
                        [self::CONSTRAINT_DATA_VAZIA,'dtTerminoVigencia'], 
                        [self::CONSTRAINT_NOT_BLANK,'dtInicioVigencia'], 
                        [self::CONSTRAINT_INTEGER ,'chTotalDisciplinaOpt'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalDisciplinaOpt'], 
                        [self::CONSTRAINT_INTEGER ,'chTotalDisciplinaOb'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalDisciplinaOb'], 
                        [self::CONSTRAINT_INTEGER ,'chTotalAtividadeExt'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalAtividadeExt'], 
                        [self::CONSTRAINT_INTEGER ,'chTotalAtividadeCmplt'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalAtividadeCmplt'], 
                        [self::CONSTRAINT_INTEGER ,'chTotalProjetoConclusao'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalProjetoConclusao'], 
                        [self::CONSTRAINT_INTEGER ,'chTotalEstagio'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalEstagio'], 
                        [self::CONSTRAINT_FLOAT ,'duracao'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'duracao'],  
                        [self::CONSTRAINT_INTEGER ,'qtdPeriodos'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'qtdPeriodos'],
                        [self::CONSTRAINT_INTEGER ,'anoAprovacao'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'anoAprovacao'],  
                        [self::CONSTRAINT_CHOICE ,'situacao'],
                        [self::CONSTRAINT_NOT_NULL ,'curso']
                    ];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutProjetoPedagogicoCursoInputValuesBlank()
    {
        $response = $this->http->request('PUT','projetos-pedagogicos-curso/1', 
                                                [ 'json' => [ 
                                                                'dtInicioVigencia'=> "",
                                                                'dtTerminoVigencia'=> "", 
                                                                'chTotalDisciplinaOb'=>"",
                                                                'chTotalAtividadeExt'=> "",
                                                                'chTotalDisciplinaOpt'=>"", 
                                                                'chTotalAtividadeCmplt'=> "", 
                                                                'chTotalProjetoConclusao'=> "", 
                                                                'chTotalEstagio'=> "", 
                                                                'duracao'=> "", 
                                                                'qtdPeriodos'=> "", 
                                                                'anoAprovacao'=> "", 
                                                                'situacao'=>"", 
                                                                'codCurso'=> ""
                                                            ], 
                                                            'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        

        $violations = [
                        [self::CONSTRAINT_DATA_VAZIA,'dtTerminoVigencia'], 
                        [self::CONSTRAINT_NOT_BLANK,'dtInicioVigencia'], 
                        [self::CONSTRAINT_INTEGER ,'chTotalDisciplinaOpt'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalDisciplinaOpt'], 
                        [self::CONSTRAINT_INTEGER ,'chTotalDisciplinaOb'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalDisciplinaOb'], 
                        [self::CONSTRAINT_INTEGER ,'chTotalAtividadeExt'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalAtividadeExt'], 
                        [self::CONSTRAINT_INTEGER ,'chTotalAtividadeCmplt'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalAtividadeCmplt'], 
                        [self::CONSTRAINT_INTEGER ,'chTotalProjetoConclusao'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalProjetoConclusao'], 
                        [self::CONSTRAINT_INTEGER ,'chTotalEstagio'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'chTotalEstagio'], 
                        [self::CONSTRAINT_FLOAT ,'duracao'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'duracao'],  
                        [self::CONSTRAINT_INTEGER ,'qtdPeriodos'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'qtdPeriodos'],
                        [self::CONSTRAINT_INTEGER ,'anoAprovacao'], 
                        [self::CONSTRAINT_INVALID_MESSAGE ,'anoAprovacao'],  
                        [self::CONSTRAINT_CHOICE ,'situacao'],
                        [self::CONSTRAINT_NOT_NULL ,'curso']
                    ]; 

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }
}
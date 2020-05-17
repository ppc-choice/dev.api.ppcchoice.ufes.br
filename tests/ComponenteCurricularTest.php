<?php

use PHPUnit\Framework\TestCase;

class ComponenteCurricularTest extends TestCase
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

    const CONSTRAINT_ONE_OF = 'CONSTRAIN_ONE_OF';

    const CONSTRAINT_NOT_NULL = 'CONSTRAINT_NOT_NULL';

    const CONSTRAINT_NOT_BLANK = 'CONSTRAINT_NOT_BLANK';

    const CONSTRAINT_RANGE_MIN_PERIODO = 'CONSTRAINT_RANGE_MIN_PERIODO' ;

    const CONSTRAINT_RANGE_MIN_CREDITO = 'CONSTRAINT_RANGE_MIN_CREDITO';

    // Mensagens padrão de retorno
    const STD_MSGS = [
        self::CREATED => 'Instância criada com sucesso.', 
        self::DELETED => 'Instância removida com sucesso.', 
        self::UPDATED => 'Instância atualizada com sucesso.', 
        self::NOT_FOUND => 'Instância não encontrada.', 
        self::EXCEPTION => 'Ocorreu uma exceção ao persistir a instância.', 
        self::CONSTRAINT_ONE_OF => 'O valor selecionado não é uma opção válida.',
        self::CONSTRAINT_NOT_NULL => 'Este valor não deve ser nulo.',
        self::CONSTRAINT_RANGE_MIN_PERIODO => 'Período não pode ser valor menor que 1.',
        self::CONSTRAINT_RANGE_MIN_CREDITO => 'Crédito deve ter valor positivo.',
        self::CONSTRAINT_NOT_BLANK => 'Este valor não deve ser vazio.',
    ];

    public function setUp(){
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://dev.api.ppcchoice.ufes.br/']);
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
            case self::CONSTRAINT_ONE_OF:
            case self::CONSTRAINT_NOT_NULL:
            case self::CONSTRAINT_RANGE_MIN_PERIODO:
            case self::CONSTRAINT_RANGE_MIN_CREDITO:
            case self::CONSTRAINT_NOT_BLANK:
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
    * @param $violation {Array} Array de arrays, os quais contém categoria e mensagem de erros
    * @return json
    */
    public function getMultipleErrorMessages($violations = [])
    {
        $messages = [];
        foreach ($violations as $content)
        {
            $message = $this->generateMessage($content[0],$content[1]);
            array_push($messages,$message);
        }

        $errorArray = ['error' => $messages];        
        return json_encode($errorArray);
    }

    
    // Testes

    // Testes de comportamento normal

    // Teste de rotas GET
    public function testGetAllComponentes()
    {
        $response = $this->http->request('GET', 'componentes-curriculares', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetComponente()
    {
        $response = $this->http->request('GET', 'componentes-curriculares/1', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetComponentesPpc()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/1/componentes-curriculares', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
    
    // Testes POST

    public function testPostComponente()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 1,
            'codPpc'=> 3,
            'credito'=>  4,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CREATED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    // Teste PUT

    public function testPutComponente()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/221', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 5,
            'codPpc'=> 4,
            'credito'=>  2,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::UPDATED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    // Teste DELETE

    // public function testDeleteComponente()
    // {
    //     $response = $this->http->request('DELETE', 'componentes-curriculares/227', ['http_errors' => FALSE] );

    //     $contentType = $response->getHeaders()["Content-Type"][0];
    //     $contentBody = $response->getBody()->getContents();
    //     $message = $this->getStdMessage(self::DELETED);

    //     $this->assertEquals(200, $response->getStatusCode());
    //     $this->assertEquals("application/json; charset=UTF-8", $contentType);
    //     $this->assertJsonStringEqualsJsonString($message,$contentBody);
    // }


    // Teste de erros GET

    // Testes por ppc não existente ou não encontrado

    public function testGetComponentesPpcNaoExistente()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/1234/componentes-curriculares', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPostComponentePpcNaoExistente()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 1,
            'codPpc'=> 1234,
            'credito'=>  4,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_NOT_NULL,'ppc');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPutComponentePpcNaoExistente()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 5,
            'codPpc'=> 1234,
            'credito'=>  2,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_NOT_NULL,'ppc');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }


    // Testes por componente não existente ou não encontrado
    public function testGetComponenteNaoExistente()
    {
        $response = $this->http->request('GET', 'componentes-curriculares/1234', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPutComponenteNaoExistente()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1234', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 5,
            'codPpc'=> 3,
            'credito'=>  2,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testDeleteComponenteNaoExistente()
    {
        $response = $this->http->request('DELETE', 'componentes-curriculares/1234', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    // teste departamento não existente

    // Testes por disciplina não existente ou não encontrada
    
    public function testPostComponenteDisciplinaNaoExistente()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  1234,
            'numDisciplina'=> 6,
            'periodo'=> 1,
            'codPpc'=> 1,
            'credito'=>  4,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_NOT_NULL, 'disciplina');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }
    
    public function testPutComponenteDisciplinaNaoExistente()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 32456,
            'periodo'=> 5,
            'codPpc'=> 3,
            'credito'=>  2,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_NOT_NULL, 'disciplina');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    //  Teste por período de valor inválido

    public function testPostComponentePeriodoInvalido()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 0,
            'codPpc'=> 3,
            'credito'=>  2,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_RANGE_MIN_PERIODO, 'periodo');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }
    
    public function testPutComponentePeriodoInvalido()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1', 
        ['json' => [
            'periodo'=> 0
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_RANGE_MIN_PERIODO, 'periodo');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    // Teste por crédito de valor inválido

    public function testPostComponenteCreditoInvalido()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 5,
            'codPpc'=> 3,
            'credito'=>  -1,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_RANGE_MIN_CREDITO, 'credito');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }
    
    public function testPutComponenteCreditoInvalido()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1', 
        ['json' => [
            'credito'=>  -1
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_RANGE_MIN_CREDITO, 'credito');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }


    // Teste por tipo de valor inválido

    public function testPostComponenteTipoInvalido()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 5,
            'codPpc'=> 3,
            'credito'=>  2,
            'tipo'=>  'OPTATORIA'
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_ONE_OF, 'tipo');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }
    
    public function testPutComponenteTipoInvalido()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1', 
        ['json' => [
            'tipo'=>  'OPTATORIA'
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_ONE_OF, 'tipo');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    // Teste valores NULL

    public function testPostComponenteValoresNull()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  null,
            'numDisciplina'=> null,
            'periodo'=> null,
            'codPpc'=> null,
            'credito'=>  null,
            'tipo'=>  null
        ],'http_errors' => FALSE] );

        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL,'periodo'],
                    [self::CONSTRAINT_NOT_NULL,  'credito'],
                    [self::CONSTRAINT_NOT_NULL,'tipo'],
                    [self::CONSTRAINT_NOT_BLANK,'tipo'],
                    [self::CONSTRAINT_NOT_NULL,'disciplina'],
                    [self::CONSTRAINT_NOT_NULL,'ppc']]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);

    }      
    
    public function testPutComponenteValoresNull()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1', 
        ['json' => [
            'codDepto'=>  null,
            'numDisciplina'=> null,
            'periodo'=> null,
            'codPpc'=> null,
            'credito'=>  null,
            'tipo'=>  null
        ],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL,'periodo'],
                    [self::CONSTRAINT_NOT_NULL,  'credito'],
                    [self::CONSTRAINT_NOT_NULL,'tipo'],
                    [self::CONSTRAINT_NOT_BLANK,'tipo'],
                    [self::CONSTRAINT_NOT_NULL,'disciplina'],
                    [self::CONSTRAINT_NOT_NULL,'ppc']]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }
}
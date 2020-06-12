<?php

use PHPUnit\Framework\TestCase;

class DisciplinaTest extends TestCase
{
    private $http;

    private $entity;
    
    const CREATED = 'CREATED';
    
    const UPDATED = 'UPDATED';

    const DELETED = 'DELETED';

    const NOT_FOUND = 'NOT_FOUND';

    const EXCEPTION = 'EXCEPTION';

    const CONSTRAINT_NOT_NULL = 'CONSTRAINT_NOT_NULL';

    const CONSTRAINT_NOT_BLANK = 'CONSTRAINT_NOT_BLANK';

    const CONSTRAINT_NOT_NEGATIVE = 'CONSTRAINT_NOT_NEGATIVE';

    const CONSTRAINT_INTEGER = 'CONSTRAINT_INTEGER';

    const CONSTRAINT_STRING = 'CONSTRAINT_STRING';

    const CONSTRAINT_OBJECT = 'CONSTRAINT_OBJECT';

    const CONSTRAINT_VALID = 'CONSTRAINT_VALID';

    const STD_MSGS = [
        self::CREATED => 'Instância criada com sucesso.', 
        self::DELETED => 'Instância removida com sucesso.', 
        self::UPDATED => 'Instância atualizada com sucesso.', 
        self::NOT_FOUND => 'Instância não encontrada.', 
        self::EXCEPTION => 'Ocorreu uma exceção ao persistir a instância.', 
        self::CONSTRAINT_NOT_NULL => 'Este valor não deve ser nulo.',
        self::CONSTRAINT_NOT_BLANK => 'Este valor não deve ser vazio.',
        self::CONSTRAINT_NOT_NEGATIVE => 'Este valor deve ser não negativo.',
        self::CONSTRAINT_INTEGER => 'Este valor deve ser do tipo integer.',
        self::CONSTRAINT_STRING => 'Este valor deve ser do tipo string.',
        self::CONSTRAINT_OBJECT => 'Este valor deve ser do tipo object.',
        self::CONSTRAINT_VALID => 'O valor deve ser um número válido.',
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
            case self::CONSTRAINT_NOT_NULL:
            case self::CONSTRAINT_NOT_BLANK:
            case self::CONSTRAINT_NOT_NEGATIVE:
            case self::CONSTRAINT_INTEGER:
            case self::CONSTRAINT_STRING:
            case self::CONSTRAINT_OBJECT:
            case self::CONSTRAINT_VALID:    
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

    // GET
    public function testGetAllDisciplinaSucesso()
    {
        $response = $this->http->request('GET', 'disciplinas', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
       
        $disciplinaArray = ["numDisciplina" => 6,
                            "nome" => "Matemática Discreta",
                            "ch" => 60,
                            "codDepto" => 1,
                            "nomeDepto" => "Departamento de Computação e Eletrônica"];

        $disciplinaJson = json_encode($disciplinaArray);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($disciplinaJson, $contentBody);
        
    }

    public function testGetDisciplinaSucesso()
    {
        $response = $this->http->request('GET', 'disciplinas/1/6', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
       
        $disciplinaArray = ["nome" => "Matemática Discreta",
                            "ch" => 60,
                            "nomeDepto" => "Departamento de Computação e Eletrônica"];

        $disciplinaJson = json_encode($disciplinaArray);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($disciplinaJson, $contentBody);
    }

    public function testGetDisciplinaNaoExistente()
    {
        $response = $this->http->request('GET', 'disciplinas/7/2', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    // POST
    public function testPostDisciplinaSucesso()
    {
        $response = $this->http->request('POST', 'disciplinas', ['json' => ['numDisciplina' => 84,
        'codDepto' => 3, 'nome' => 'Nome Disciplina', 'ch' => 60], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CREATED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPostDisciplinaJaExisteNoBanco()
    {
        $response = $this->http->request('POST', 'disciplinas', ['json' => ['numDisciplina' => 84,
        'codDepto' => 3, 'nome' => 'Nome Disciplina', 'ch' => 60], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::EXCEPTION);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPostDisciplinaNulo()
    {
        $response = $this->http->request('POST', 'disciplinas', ['json' => ['numDisciplina' => null,
        'codDepto' => null, 'nome' => null, 'ch' => null], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'numDisciplina'],
                    [self::CONSTRAINT_NOT_NULL,'codDepto'],
                    [self::CONSTRAINT_NOT_NULL,'nome'],
                    [self::CONSTRAINT_NOT_BLANK,'nome'],
                    [self::CONSTRAINT_NOT_NULL,'ch'],
                    [self::CONSTRAINT_NOT_NULL,'departamento']]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPostDisciplinaTipagem()
    {
        $response = $this->http->request('POST', 'disciplinas', ['json' => ['numDisciplina' => 'string',
        'codDepto' => 'string', 'nome' => 60, 'ch' => 'string'], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_INTEGER, 'numDisciplina'],
                    [self::CONSTRAINT_NOT_NULL,'codDepto'],
                    [self::CONSTRAINT_STRING,'nome'],
                    [self::CONSTRAINT_INTEGER,'ch'],
                    [self::CONSTRAINT_VALID,'ch'],
                    [self::CONSTRAINT_NOT_NULL,'departamento']]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPostDisciplinaEmBranco()
    {
        $response = $this->http->request('POST', 'disciplinas', ['json' => ['numDisciplina' => 79,
        'codDepto' => 6, 'nome' => '', 'ch' => 60], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_NOT_BLANK, 'nome');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPostDisciplinaChNaoNegativo()
    {
        $response = $this->http->request('POST', 'disciplinas', ['json' => ['numDisciplina' => 79,
        'codDepto' => 6, 'nome' => 'Nome Disciplina', 'ch' => -60], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_NOT_NEGATIVE, 'ch');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    // PUT
    public function testPutDisciplinaSucesso()
    {
        $response = $this->http->request('PUT', 'disciplinas/6/1', 
        ['json' => ['nome' => 'Nome Disciplina', 'ch' => 60], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::UPDATED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPutDisciplinaNaoExistente()
    {
        $response = $this->http->request('PUT', 'disciplinas/1/600', 
        ['json' => ['ch' => 60, 'nome' => "Qualquer Disciplina"], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutDisciplinaNulo()
    {
        $response = $this->http->request('PUT', 'disciplinas/6/1', 
        ['json' => ['nome' => null, 'ch' => null], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL,'nome'],
                    [self::CONSTRAINT_NOT_BLANK,'nome'],
                    [self::CONSTRAINT_NOT_NULL,'ch']]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutDisciplinaTipagem()
    {
        $response = $this->http->request('PUT', 'disciplinas/6/1',
         ['json' => ['nome' => 60, 'ch' => 'string'], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_STRING,'nome'],
                    [self::CONSTRAINT_INTEGER,'ch'],
                    [self::CONSTRAINT_VALID,'ch']]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutDisciplinaNomeEmBranco()
    {
        $response = $this->http->request('PUT', 'disciplinas/6/1',
        ['json' => ['nome' => '', 'ch' => 60], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_NOT_BLANK, 'nome');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutDisciplinaChNaoNegativo()
    {
        $response = $this->http->request('PUT', 'disciplinas/6/1',
         ['json' => ['nome' => 'Nome Disciplina', 'ch' => -60], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_NOT_NEGATIVE, 'ch');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    // DELETE
    public function testDeleteDisciplinaSucesso()
    {
        $response = $this->http->request('DELETE', 'disciplinas/3/84', ['http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::DELETED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testDeleteDisciplinaNaoExistente()
    {
        $response = $this->http->request('DELETE', 'disciplinas/3/84', ['http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }
}

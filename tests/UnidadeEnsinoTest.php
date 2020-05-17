<?php

use PHPUnit\Framework\TestCase;

class UnidadeEnsinoTest extends TestCase
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

    const CONSTRAINT_REGEX_CNPJ = 'CONSTRAINT_REGEX_CNPJ';

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
        self::CONSTRAINT_REGEX_CNPJ => 'O valor não possui o padrão de CNPJ.',
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
            case self::CONSTRAINT_REGEX_CNPJ:
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
    public function testGetAllUnidadeEnsinoSucesso()
    {
        $response = $this->http->request('GET', 'unidades-ensino', ['http_errors' => FALSE]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetUnidadeEnsinoSucesso()
    {
        $response = $this->http->request('GET', 'unidades-ensino/4', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetUnidadeEnsinoNaoExistente()
    {
        $response = $this->http->request('GET', 'unidades-ensino/27', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    // POST
    public function testPostUnidadeEnsinoSucesso()
    {
        $response = $this->http->request('POST', 'unidades-ensino', ['json' => ['nome' => 'Nome Unidade Ensino',
        'codIes' => 573, 'cnpj' => '12.123.123/1234-12'], 'http_errors' => FALSE]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostUnidadeEnsinoNulo()
    {
        $response = $this->http->request('POST', 'unidades-ensino', ['json' => ['nome' => null,
        'codIes' => null, 'cnpj' => null], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'nome'],
                    [self::CONSTRAINT_NOT_BLANK, 'nome'],
                    [self::CONSTRAINT_NOT_NULL,'cnpj'],
                    [self::CONSTRAINT_NOT_BLANK,'cnpj'],
                    [self::CONSTRAINT_NOT_NULL,'ies']]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPostUnidadeEnsinoTipagem()
    {
        $response = $this->http->request('POST', 'unidades-ensino', ['json' => ['nome' => 64,
        'codIes' => 'string', 'cnpj' => 64], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_STRING, 'nome'],
                    [self::CONSTRAINT_STRING,'cnpj'],
                    [self::CONSTRAINT_REGEX_CNPJ,'cnpj'],
                    [self::CONSTRAINT_NOT_NULL,'ies']];  
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPostUnidadeEnsinoEmBranco()
    {
        $response = $this->http->request('POST', 'unidades-ensino', ['json' => ['nome' => '',
        'codIes' => 573, 'cnpj' => ''], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_BLANK, 'nome'],
                    [self::CONSTRAINT_NOT_BLANK,'cnpj']];  
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPostUnidadeEnsinoRegex()
    {
        $response = $this->http->request('POST', 'unidades-ensino', ['json' => ['nome' => 'Nome Unidade Ensino',
        'codIes' => 573, 'cnpj' => '123.123.123'], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_REGEX_CNPJ, 'cnpj');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    // PUT
    public function testPutUnidadeEnsinoSucesso()
    {
        $response = $this->http->request('PUT', 'unidades-ensino/1', ['json' => ['nome' => 'Nome Unidade Ensino',
        'codIes' => 573, 'cnpj' => '12.123.123/1234-12'], 'http_errors' => FALSE]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutUnidadeEnsinoNaoExistente()
    {
        $response = $this->http->request('PUT', 'unidades-ensino/27', ['json' => ['nome' => 'Nome Unidade Ensino',
        'codIes' => 573, 'cnpj' => '12.123.123/1234-12'], 'http_errors' => FALSE]);

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutUnidadeEnsinoNulo()
    {
        $response = $this->http->request('PUT', 'unidades-ensino/1', ['json' => ['nome' => null,
        'codIes' => null, 'cnpj' => null], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'nome'],
                    [self::CONSTRAINT_NOT_BLANK, 'nome'],
                    [self::CONSTRAINT_NOT_NULL,'cnpj'],
                    [self::CONSTRAINT_NOT_BLANK,'cnpj']]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutUnidadeEnsinoTipagem()
    {
        $response = $this->http->request('PUT', 'unidades-ensino/1', ['json' => ['nome' => 64,
        'codIes' => 'string', 'cnpj' => 64], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_STRING, 'nome'],
                    [self::CONSTRAINT_STRING,'cnpj'],
                    [self::CONSTRAINT_REGEX_CNPJ,'cnpj']];  
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutUnidadeEnsinoEmBranco()
    {
        $response = $this->http->request('PUT', 'unidades-ensino/1', ['json' => ['nome' => '',
        'codIes' => 573, 'cnpj' => ''], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_BLANK, 'nome'],
                    [self::CONSTRAINT_NOT_BLANK,'cnpj']];  
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutUnidadeEnsinoRegex()
    {
        $response = $this->http->request('PUT', 'unidades-ensino/1', ['json' => ['nome' => 'Nome Unidade Ensino',
        'codIes' => 573, 'cnpj' => '123.123.123'], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_REGEX_CNPJ, 'cnpj');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    // DELETE
    public function testDeleteUnidadeEnsinoSucesso()
    {
        $response = $this->http->request('DELETE', 'unidades-ensino/31', ['http_errors' => FALSE]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testDeleteUnidadeEnsinoNaoExistente()
    {
        $response = $this->http->request('DELETE', 'unidades-ensino/27', ['http_errors' => FALSE]);

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
}

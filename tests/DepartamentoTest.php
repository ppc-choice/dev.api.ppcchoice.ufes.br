<?php

use PHPUnit\Framework\TestCase;

class DepartamentoTest extends TestCase
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

    const CONSTRAINT_NOT_NULL = 'CONSTRAINT_NOT_NULL';
    const CONSTRAINT_NOT_BLANK = 'CONSTRAINT_NOT_BLANK';
    const CONSTRAINT_NOT_NUMERIC = 'CONSTRAINT_NOT_NUMERIC';
    const CONSTRAINT_TYPE_STRING = 'CONSTRAINT_TYPE_INTEGER';

    // Mensagens padrão de retorno
    const STD_MSGS = [
        self::CREATED => 'Instância criada com sucesso.', 
        self::DELETED => 'Instância removida com sucesso.', 
        self::UPDATED => 'Instância atualizada com sucesso.', 
        self::NOT_FOUND => 'Instância não encontrada.', 
        self::EXCEPTION => 'Ocorreu uma exceção ao persistir a instância.',
        self::CONSTRAINT_NOT_NULL => 'Este valor não deve ser nulo.',
        self::CONSTRAINT_NOT_BLANK => 'Este valor não deve ser vazio.',
        self::CONSTRAINT_NOT_NUMERIC => 'Este valor não deve conter caracteres numéricos.',
        self::CONSTRAINT_TYPE_STRING => 'Este valor deve ser do tipo string.',
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
            case self::CONSTRAINT_TYPE_STRING:
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
    public function getMultipleErrorMessages($violations=[])
    {
        $messages = [];
        //foreach ($violations as $category => $subpathes) {
            foreach ($violations as $content ) {
                $message = $this->generateMessage($content[0],$content[1]);
                array_push($messages,$message);
            }
        //}
        $errorArray = ['error' => $messages];        
        return json_encode($errorArray);
    }
    
    // Testes
    //ROTAS
    //GET
    public function testGetDepartamento()
    {
        $response = $this->http->request('GET', 'departamentos', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetDepartamento2()
    {
        $response = $this->http->request('GET', 'departamentos', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody,$message);
    }
    
    public function testGetDepartamentoNaoExistente()
    {
        $response = $this->http->request('GET', 'departamentos/100', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetDepartamentoNaoExistente2()
    {
        $response = $this->http->request('GET', 'departamentos/100', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody,$message);
    }

    public function testGetDepartamentoSucesso()
    {
        $response = $this->http->request('GET', 'departamentos/1', ['http_errors' => FALSE] );
        
        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetDepartamentoSucesso2()
    {
        $response = $this->http->request('GET', 'departamentos', ['http_errors' => FALSE] );
        
        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    //POST
    public function testPostDepartamentoSucesso()
    {
        $response = $this->http->request('POST','departamentos', 
        [ 'json' => [
        'nome' => 'Depto',
        'abreviatura'=> 'ABFF',
        'codUnidadeEnsino' => 1], 
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CREATED);
      
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    //PUT
    public function testPutDepartamentoNaoExistente()
    {
        $response = $this->http->request('PUT', 'departamentos/111', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDepartamentoNaoExistente2()
    {
        $response = $this->http->request('PUT', 'departamentos/111', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody,$message);
    }

    public function testPutDepartamentoSucesso()
    {
        $response = $this->http->request('PUT', 'departamentos/8',
        [ 'json' => [
        'nome' => 'Departamento de Desenvolvimento',
        'abreviatura'=>'DDS',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::UPDATED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    //DELETE
    public function testDeleteDepartamentoNaoExistente()
    {
        $response = $this->http->request('DELETE', 'departamentos/157', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testDeleteDepartamentoNaoExistente2()
    {
        $response = $this->http->request('DELETE', 'departamentos/157', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody, $message);
    }

    public function testDeleteDepartamentoSucesso()
    {
        $response = $this->http->request('DELETE', 'departamentos/7', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::DELETED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody, $message);
    }
    
    // Tudo vazio
    public function testPostDepartamentoAllVazio()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => '',
        'abreviatura' => '',
        'codUnidadeEnsino' => ''],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostDepartamentoAllVazioBody()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => '',
        'abreviatura' => '',
        'codUnidadeEnsino' => ''],
        'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_BLANK, 'nome'],
                        [self::CONSTRAINT_NOT_BLANK, 'abreviatura'],
                        [self::CONSTRAINT_NOT_NULL, 'unidadeEnsino'],
                        [self::CONSTRAINT_NOT_BLANK, 'unidadeEnsino']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutDepartamentoAllVazio()
    {
        $response = $this->http->request('PUT', 'departamentos/25',
        [ 'json' => [
        'nome' => '',
        'abreviatura' => '',
        'codUnidadeEnsino' => ''],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDepartamentoAllVazioBody()
    {
        $response = $this->http->request('PUT', 'departamentos/22',
        [ 'json' => [
        'nome' => '',
        'abreviatura' => '',
        'codUnidadeEnsino' => ''],
        'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_BLANK, 'nome'],
                        [self::CONSTRAINT_NOT_BLANK, 'abreviatura'],
                        [self::CONSTRAINT_NOT_NULL, 'unidadeEnsino'],
                        [self::CONSTRAINT_NOT_BLANK, 'unidadeEnsino']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    //Tudo null
    public function testPostDepartamentoAllNull()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => null,
        'abreviatura' => null,
        'codUnidadeEnsino' => null],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostDepartamentoAllNullBody()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => null,
        'abreviatura' => null,
        'codUnidadeEnsino' => null],
        'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'nome'],
                        [self::CONSTRAINT_NOT_BLANK, 'nome'],
                        [self::CONSTRAINT_NOT_NULL, 'abreviatura'],
                        [self::CONSTRAINT_NOT_BLANK, 'abreviatura'],
                        [self::CONSTRAINT_NOT_NULL, 'unidadeEnsino'],
                        [self::CONSTRAINT_NOT_BLANK, 'unidadeEnsino']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutDepartamentoAllNull()
    {
        $response = $this->http->request('PUT', 'departamentos/25',
        [ 'json' => [
        'nome' => null,
        'abreviatura' => null,
        'codUnidadeEnsino' => null],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDepartamentoAllNullBody()
    {
        $response = $this->http->request('PUT', 'departamentos/22',
        [ 'json' => [
        'nome' => null,
        'abreviatura' => null,
        'codUnidadeEnsino' => null],
        'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'nome'],
                        [self::CONSTRAINT_NOT_BLANK, 'nome'],
                        [self::CONSTRAINT_NOT_NULL, 'abreviatura'],
                        [self::CONSTRAINT_NOT_BLANK, 'abreviatura'],
                        [self::CONSTRAINT_NOT_NULL, 'unidadeEnsino'],
                        [self::CONSTRAINT_NOT_BLANK, 'unidadeEnsino']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    //Nome numérico
    public function testPostDepartamentoNomeNumerico()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => '1ab',
        'abreviatura' => 'ABCD',
        'codUnidadeEnsino' => 1],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostDepartamentoNomeNumericoBody()
    {
        $response = $this->http->request('POST','departamentos', 
        [ 'json' => [
        'nome' => 'Departamento Teste 222',
        'abreviatura'=> 'GGGG',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NUMERIC, 'nome']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutDepartamentoNomeNumerico()
    {
        $response = $this->http->request('PUT', 'departamentos/25',
        [ 'json' => [
        'nome' => '1abb',
        'abreviatura' => 'ABCD',
        'codUnidadeEnsino' => 1],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDepartamentoNomeNumericoBody()
    {
        $response = $this->http->request('PUT','departamentos/22', 
        [ 'json' => [
        'nome' => 'Departamento Teste 222',
        'abreviatura'=> 'AGGG',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NUMERIC, 'nome']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    //Nome Vazio
    public function testPostDepartamentoNomeVazio()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => '',
        'abreviatura' => 'ABCD',
        'codUnidadeEnsino' => 1],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostDepartamentoNomeVazioBody()
    {
        $response = $this->http->request('POST','departamentos', 
        [ 'json' => [
        'nome' => '',
        'abreviatura'=> 'AGUUU',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_BLANK, 'nome']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutDepartamentoNomeVazio()
    {
        $response = $this->http->request('PUT', 'departamentos/25',
        [ 'json' => [
        'nome' => '',
        'abreviatura' => 'ABCD',
        'codUnidadeEnsino' => 1],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDepartamentoNomeVazioBody()
    {
        $response = $this->http->request('PUT','departamentos/22', 
        [ 'json' => [
        'nome' => '',
        'abreviatura'=> 'AUUU',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_BLANK, 'nome']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    //Nome null
    public function testPostDepartamentoNomeNull()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => null,
        'abreviatura' => 'ABCD',
        'codUnidadeEnsino' => 1],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostDepartamentoNomeNullBody()
    {
        $response = $this->http->request('POST','departamentos', 
        [ 'json' => [
        'nome' => null,
        'abreviatura'=> 'AUUU',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'nome'],
                        [self::CONSTRAINT_NOT_BLANK, 'nome']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutDepartamentoNomeNull()
    {
        $response = $this->http->request('PUT', 'departamentos/25',
        [ 'json' => [
        'nome' => null,
        'abreviatura' => 'ABCD',
        'codUnidadeEnsino' => 1],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDepartamentoNomeNullBody()
    {
        $response = $this->http->request('PUT','departamentos/22', 
        [ 'json' => [
        'nome' => null,
        'abreviatura'=> 'AUUU',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'nome'],
                        [self::CONSTRAINT_NOT_BLANK, 'nome']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    //Abreviatura numérica
    public function testPostDepartamentoAbreviaturaNumerica()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => 'Departamento Novo',
        'abreviatura' => '1233',
        'codUnidadeEnsino' => 1],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostDepartamentoAbreviaturaNumericaBody()
    {
        $response = $this->http->request('POST','departamentos', 
        [ 'json' => [
        'nome' => 'DEPARTAMENTO',
        'abreviatura'=> '123',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NUMERIC, 'abreviatura']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutDepartamentoAbreviaturaNumerica()
    {
        $response = $this->http->request('PUT', 'departamentos/25',
        [ 'json' => [
        'nome' => 'Departamento Novo',
        'abreviatura' => '444',
        'codUnidadeEnsino' => 1],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDepartamentoAbreviaturaNumericaBody()
    {
        $response = $this->http->request('PUT','departamentos/22', 
        [ 'json' => [
        'nome' => 'DEPARTAMENTO LOL',
        'abreviatura'=> '123',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NUMERIC, 'abreviatura']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    //CodUnidadeEnsino Vazia
    public function testPostDepartamentoCodUnidadeEnsinoVazia()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => 'Departamento teste',
        'abreviatura' => 'ABCD',
        'codUnidadeEnsino' => ''],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDepartamentoCodUnidadeEnsinoVazia()
    {
        $response = $this->http->request('PUT', 'departamentos/25',
        [ 'json' => [
        'nome' => 'Departamento teste segundo',
        'abreviatura' => 'ABCD',
        'codUnidadeEnsino' => ''],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    // CodUnidadeEnsino Letra
    public function testPostDepartamentoCodUnidadeEnsinoLetra()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => 'Departamento Novo',
        'abreviatura' => 'ABC',
        'codUnidadeEnsino' => 'abb'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostDepartamentoCodUnidadeEnsinoLetraBody()
    {
        $response = $this->http->request('POST','departamentos', 
        [ 'json' => [
        'nome' => 'DEPARTAMENTO CENTRAL',
        'abreviatura'=> 'DC',
        'codUnidadeEnsino' => 'asd'],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'unidadeEnsino'],
                        [self::CONSTRAINT_NOT_BLANK, 'unidadeEnsino']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutDepartamentoCodUnidadeEnsinoLetra()
    {
        $response = $this->http->request('PUT', 'departamentos/25',
        [ 'json' => [
        'nome' => 'Departamento Novo',
        'abreviatura' => 'BDD',
        'codUnidadeEnsino' => 'bhj'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDepartamentoCodUnidadeEnsinoLetraBody()
    {
        $response = $this->http->request('PUT','departamentos/22', 
        [ 'json' => [
        'nome' => 'DEPARTAMENTO CENTRAL',
        'abreviatura'=> 'DC',
        'codUnidadeEnsino' => 'asd'],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'unidadeEnsino'],
                        [self::CONSTRAINT_NOT_BLANK, 'unidadeEnsino']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    //Unidade de Ensino Não Existente
    public function testPostDepartamentoCodUnidadeEnsinoNaoExistente()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => 'Departamento teste',
        'abreviatura' => 'ABCD',
        'codUnidadeEnsino' => 15885],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostDepartamentoCodUnidadeEnsinoNaoExistenteBody()
    {
        $response = $this->http->request('POST','departamentos', 
        [ 'json' => [
        'nome' => 'DEPARTAMENTO CENTRAL',
        'abreviatura'=> 'DC',
        'codUnidadeEnsino' => 'asd'],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'unidadeEnsino'],
                        [self::CONSTRAINT_NOT_BLANK, 'unidadeEnsino']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutDepartamentoCodUnidadeEnsinoNaoExistente()
    {
        $response = $this->http->request('PUT', 'departamentos/25',
        [ 'json' => [
        'nome' => 'Departamento teste',
        'abreviatura' => 'ABCD',
        'codUnidadeEnsino' => 18955],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDepartamentoCodUnidadeEnsinoNaoExistenteBody()
    {
        $response = $this->http->request('PUT','departamentos/22', 
        [ 'json' => [
        'nome' => 'DEPARTAMENTO CENTRAL',
        'abreviatura'=> 'DC',
        'codUnidadeEnsino' => 'asd'],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'unidadeEnsino'],
                        [self::CONSTRAINT_NOT_BLANK, 'unidadeEnsino']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }
}
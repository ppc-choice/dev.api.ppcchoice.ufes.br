<?php

use PHPUnit\Framework\TestCase;

class CursoTest extends TestCase
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
    const CONSTRAINT_RANGE_MIN_1950 = 'CONSTRAINT_RANGE_MIN_1950';

    const CONSTRAINT_NUM_VALID = 'CONSTRAINT_NUM_VALID';
    const CONSTRAINT_TYPE_INTEGER = 'CONSTRAINT_TYPE_INTEGER';



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
        self::CONSTRAINT_RANGE_MIN_1950 => 'Ano de criação deve ser não negativo e maior que 1950.',
        self::CONSTRAINT_NUM_VALID => 'O valor deve ser um número válido.',
        self::CONSTRAINT_TYPE_INTEGER => 'Este valor deve ser do tipo integer.',
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
            case self::CONSTRAINT_NOT_NUMERIC:
            case self::CONSTRAINT_RANGE_MIN_1950:
            case self::CONSTRAINT_NUM_VALID:
            case self::CONSTRAINT_TYPE_INTEGER:
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
    // ROTAS
    //GET
    public function testGetCurso()
    {
        $response = $this->http->request('GET', 'cursos', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetCurso2()
    {
        $response = $this->http->request('GET', 'cursos', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody,$message);
    }

    public function testGetCursoNaoExistente()
    {
        $response = $this->http->request('GET', 'cursos/80', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetCursoNaoExistente2()
    {
        $response = $this->http->request('GET', 'cursos/100', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody,$message);
    }
    //POST
    public function testPostCursoSucesso()
    {
        $response = $this->http->request('POST','cursos', 
        [ 'json' => [
        'nome' => 'CURSO DE DATA SCIENCE',
        'anoCriacao'=> 2015,
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
    public function testPutCursoNaoExistente()
    {
        $response = $this->http->request('PUT', 'cursos/111', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCursoNaoExistente2()
    {
        $response = $this->http->request('PUT', 'cursos/111', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody,$message);
    }

    public function testPutCursoSucesso()
    {
        $response = $this->http->request('PUT', 'cursos/8',
        [ 'json' => [
        'nome' => 'Curso de Desenvolvimento',
        'anoCriacao'=> 2017,
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
    public function testDeleteCursoNaoExistente()
    {
        $response = $this->http->request('DELETE', 'cursos/157', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testDeleteCursoNaoExistente2()
    {
        $response = $this->http->request('DELETE', 'cursos/157', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody,$message);
    }

    public function testDeleteCurso() // Testado e funcionando
    {
        $response = $this->http->request('DELETE', 'cursos/14', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::DELETED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    // Métodos com atributos null
    public function testPostCursoAllNull()
    {
        $response = $this->http->request('POST', 'cursos',
        [ 'json' => [
        'nome' => null,
        'anoCriacao'=> null,
        'codUnidadeEnsino' => null],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostCursoAllNullBody()
    {
        $response = $this->http->request('POST','cursos', 
        [ 'json' => [
        'nome' => null,
        'anoCriacao'=> null,
        'codUnidadeEnsino' => null], 
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'nome'],
                        [self::CONSTRAINT_NOT_BLANK, 'nome'],
                        [self::CONSTRAINT_NOT_NULL, 'anoCriacao'],
                        [self::CONSTRAINT_NOT_BLANK, 'anoCriacao'],
                        [self::CONSTRAINT_NOT_NULL, 'unidadeEnsino'],
                        [self::CONSTRAINT_NOT_BLANK, 'unidadeEnsino']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutCursoAllNull()
    {
        $response = $this->http->request('PUT', 'cursos/8',
        [ 'json' => [
        'nome' => null,
        'anoCriacao'=> null,
        'codUnidadeEnsino' => null],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCursoAllNullBody()
    {
        $response = $this->http->request('PUT','cursos/6', 
        [ 'json' => [
        'nome' => null,
        'anoCriacao'=> null,
        'codUnidadeEnsino' => null], 
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'nome'],
                        [self::CONSTRAINT_NOT_BLANK, 'nome'],
                        [self::CONSTRAINT_NOT_NULL, 'anoCriacao'],
                        [self::CONSTRAINT_NOT_BLANK, 'anoCriacao'],
                        [self::CONSTRAINT_NOT_NULL, 'unidadeEnsino'],
                        [self::CONSTRAINT_NOT_BLANK, 'unidadeEnsino']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    //Caracteres numéricos no nome
    public function testPostCursoNomeNumerico()
    {
        $response = $this->http->request('POST', 'cursos',
        [ 'json' => [
        'nome' => 'Curso Teste 222',
        'anoCriacao'=> 2001,
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostCursoNomeNumericoBody()
    {
        $response = $this->http->request('POST','cursos', 
        [ 'json' => [
        'nome' => 'Curso Teste 222',
        'anoCriacao'=> 2001,
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

    public function testPutCursoNomeNumerico()
    {
        $response = $this->http->request('PUT', 'cursos/8',
        [ 'json' => [
        'nome' => 'ABC 123',
        'anoCriacao'=> 2000,
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCursoNomeNumericoBody()
    {
        $response = $this->http->request('PUT','cursos/9', 
        [ 'json' => [
        'nome' => 'Curso Teste 222',
        'anoCriacao'=> 2001,
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

    //Ano de criacao com letra
    public function testPostCursoAnoCriacaoLetra()
    {
        $response = $this->http->request('POST', 'cursos',
        [ 'json' => [
        'nome' => 'Curso Criado para Teste',
        'anoCriacao'=> 'aaa',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostCursoAnoCriacaoLetraBody()
    {
        $response = $this->http->request('POST','cursos', 
        [ 'json' => [
        'nome' => 'Curso Teste',
        'anoCriacao'=> 'bbb',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_TYPE_INTEGER, 'anoCriacao'],
                        [self::CONSTRAINT_NUM_VALID, 'anoCriacao']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutCursoAnoCriacaoLetra()
    {
        $response = $this->http->request('PUT', 'cursos/8',
        [ 'json' => [
        'nome' => 'Curso Modificado para Teste',
        'anoCriacao'=> 'aaa',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCursoAnoCriacaoLetraBody()
    {
        $response = $this->http->request('PUT','cursos/9', 
        [ 'json' => [
        'nome' => 'Curso Teste',
        'anoCriacao'=> 'bbb',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_TYPE_INTEGER, 'anoCriacao'],
                        [self::CONSTRAINT_NUM_VALID, 'anoCriacao']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    // CodUnidadeEnsino com letra
    public function testPostCursoCodUnidadeEnsinoLetra()
    {
        $response = $this->http->request('POST', 'cursos',
        [ 'json' => [
        'nome' => 'Curso Criado para Teste',
        'anoCriacao'=> 2000,
        'codUnidadeEnsino' => 'aa'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostCursoCodUnidadeEnsinoLetraBody()
    {
        $response = $this->http->request('POST','cursos', 
        [ 'json' => [
        'nome' => 'Curso Teste',
        'anoCriacao'=> 2002,
        'codUnidadeEnsino' => 'abb'],
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

    public function testPutCursoCodUnidadeEnsinoLetra()
    {
        $response = $this->http->request('PUT', 'cursos/8',
        [ 'json' => [
        'nome' => 'Curso Modificado para Teste',
        'anoCriacao'=> 2001,
        'codUnidadeEnsino' => 'cc'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCursoCodUnidadeEnsinoLetraBody()
    {
        $response = $this->http->request('PUT','cursos/8', 
        [ 'json' => [
        'nome' => 'Curso Teste',
        'anoCriacao'=> 2002,
        'codUnidadeEnsino' => 'abb'],
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

    //CodUnidadeEnsino null
    public function testPostCursoCodUnidadeEnsinoNull()
    {
        $response = $this->http->request('POST', 'cursos',
        [ 'json' => [
        'nome' => 'Curso Modificado para Teste',
        'anoCriacao'=> 2001,
        'codUnidadeEnsino' => null],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostCursoCodUnidadeEnsinoNullBody()
    {
        $response = $this->http->request('POST','cursos', 
        [ 'json' => [
        'nome' => 'Curso Teste',
        'anoCriacao'=> 2002,
        'codUnidadeEnsino' => null],
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

    public function testPutCursoCodUnidadeEnsinoNull()
    {
        $response = $this->http->request('PUT', 'cursos/8',
        [ 'json' => [
        'nome' => 'Curso Modificado para Teste',
        'anoCriacao'=> 2001,
        'codUnidadeEnsino' => null],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCursoCodUnidadeEnsinoNullBody()
    {
        $response = $this->http->request('PUT','cursos/8', 
        [ 'json' => [
        'nome' => 'Curso Teste',
        'anoCriacao'=> 2002,
        'codUnidadeEnsino' => null],
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

    //CodUnidadeEnsino Vazia
    public function testPostCursoCodUnidadeEnsinoVazia()
    {
        $response = $this->http->request('POST', 'cursos',
        [ 'json' => [
        'nome' => 'Curso Modificado para Teste',
        'anoCriacao'=> 2001,
        'codUnidadeEnsino' => ''],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostCursoCodUnidadeEnsinoVaziaBody()
    {
        $response = $this->http->request('POST','cursos', 
        [ 'json' => [
        'nome' => 'Curso Teste',
        'anoCriacao'=> 2002,
        'codUnidadeEnsino' => ''],
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

    public function testPutCursoCodUnidadeEnsinoVazia()
    {
        $response = $this->http->request('PUT', 'cursos/8',
        [ 'json' => [
        'nome' => 'Curso Modificado para Teste',
        'anoCriacao'=> 2001,
        'codUnidadeEnsino' => ''],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCursoCodUnidadeEnsinoVaziaBody()
    {
        $response = $this->http->request('PUT','cursos/8', 
        [ 'json' => [
        'nome' => 'Curso Teste',
        'anoCriacao'=> 2002,
        'codUnidadeEnsino' => ''],
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

    //Ano de criação deve ser superior a 1950
    public function testPostCursoAnoCriacaoSuperior()
    {
        $response = $this->http->request('POST', 'cursos',
        [ 'json' => [
        'nome' => 'Curso Criado para Teste',
        'anoCriacao'=> 1849,
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostCursoAnoCriacaoSuperiorBody()
    {
        $response = $this->http->request('POST','cursos', 
        [ 'json' => [
        'nome' => 'Curso Teste',
        'anoCriacao'=> 1948,
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_RANGE_MIN_1950, 'anoCriacao']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutCursoAnoCriacaoSuperior() 
    {
        $response = $this->http->request('PUT', 'cursos/8',
        [ 'json' => [
        'nome' => 'Curso Modificado para Teste',
        'anoCriacao'=> 1900,
        'codUnidadeEnsino' => 3],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCursoAnoCriacaoSuperiorBody()
    {
        $response = $this->http->request('POST','cursos', 
        [ 'json' => [
        'nome' => 'Curso Teste',
        'anoCriacao'=> 1948,
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_RANGE_MIN_1950, 'anoCriacao']];

        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    //Unidade de Ensino Não existente
    public function testPostCursoCodUnidadeEnsinoNaoExistente()
    {
        $response = $this->http->request('POST', 'cursos',
        [ 'json' => [
        'nome' => 'Curso Criado para Teste',
        'anoCriacao'=> 2001,
        'codUnidadeEnsino' => 1593],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostCursoCodUnidadeEnsinoNaoExistenteBody()
    {
        $response = $this->http->request('POST','cursos', 
        [ 'json' => [
        'nome' => 'Curso Teste',
        'anoCriacao'=> 2002,
        'codUnidadeEnsino' => 14782],
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

    public function testPutCursoCodUnidadeEnsinoNaoExistente()
    {
        $response = $this->http->request('PUT', 'cursos/8',
        [ 'json' => [
        'nome' => 'Curso Criado para Teste',
        'anoCriacao'=> 2001,
        'codUnidadeEnsino' => 1593],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCursoCodUnidadeEnsinoNaoExistenteBody()
    {
        $response = $this->http->request('PUT','cursos/9', 
        [ 'json' => [
        'nome' => 'Curso Teste',
        'anoCriacao'=> 2002,
        'codUnidadeEnsino' => 25478],
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
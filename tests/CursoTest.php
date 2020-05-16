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


    // Mensagens padrão de retorno
    const STD_MSGS = [
        self::CREATED => 'Instância criada com sucesso.', 
        self::DELETED => 'Instância removida com sucesso.', 
        self::UPDATED => 'Instância atualizada com sucesso.', 
        self::NOT_FOUND => 'Instância não encontrada.', 
        self::EXCEPTION => 'Ocorreu uma exceção ao persistir a instância.',
    ];

    public function setUp(){
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://dev.api.ppcchoice.ufes.br/']);
        $this->entity = preg_replace('/Test$/', "", get_class($this));
    }

    public function tearDown() {
        $this->http = null;
        $this->entity = null;
    }

    /* 
    * Retorna msg padrão 
    */
    public function getStdMessage($category)
    {
        switch ($category) {
            case self::CREATED:
            case self::DELETED:
            case self::UPDATED:
                $key = 'message';
                break;
            case self::NOT_FOUND:
            case self::EXCEPTION:
                $key = 'error';
                break;
            default:
                $key = 'key';
                break;
        }

        return json_encode([ $key => [
            'Entities\\' . $this->entity . ': ' . self::STD_MSGS[$category]
        ]]);
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
        $response = $this->http->request('GET', 'cursos/100', ['http_errors' => FALSE] );

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

    public function testPutCursoAllNull()
    {
        $response = $this->http->request('PUT', 'cursos/10',
        [ 'json' => [
        'nome' => null,
        'anoCriacao'=> null,
        'codUnidadeEnsino' => null],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
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

    public function testPutCursoNomeNumerico()
    {
        $response = $this->http->request('PUT', 'cursos/10',
        [ 'json' => [
        'nome' => 'ABC 123',
        'anoCriacao'=> 2000,
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
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

    public function testPutCursoAnoCriacaoLetra()
    {
        $response = $this->http->request('PUT', 'cursos/10',
        [ 'json' => [
        'nome' => 'Curso Modificado para Teste',
        'anoCriacao'=> 'aaa',
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
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

    public function testPutCursoCodUnidadeEnsinoLetra()
    {
        $response = $this->http->request('PUT', 'cursos/10',
        [ 'json' => [
        'nome' => 'Curso Modificado para Teste',
        'anoCriacao'=> 2001,
        'codUnidadeEnsino' => 'cc'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
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

    public function testPutCursoCodUnidadeEnsinoVazia()
    {
        $response = $this->http->request('PUT', 'cursos/10',
        [ 'json' => [
        'nome' => 'Curso Modificado para Teste',
        'anoCriacao'=> 2001,
        'codUnidadeEnsino' => ''],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    //Ano de criação deve ser superior a 1950
    public function testPostCursoAnoCriacaoSuperior()
    {
        $response = $this->http->request('POST', 'cursos',
        [ 'json' => [
        'nome' => 'Curso Criado para Teste',
        'anoCriacao'=> 1949,
        'codUnidadeEnsino' => 2],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCursoAnoCriacaoSuperior() 
    {
        $response = $this->http->request('PUT', 'cursos/10',
        [ 'json' => [
        'nome' => 'Curso Modificado para Teste',
        'anoCriacao'=> 1900,
        'codUnidadeEnsino' => 3],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
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

    public function testPutCursoCodUnidadeEnsinoNaoExistente()
    {
        $response = $this->http->request('PUT', 'cursos/10',
        [ 'json' => [
        'nome' => 'Curso Criado para Teste',
        'anoCriacao'=> 2001,
        'codUnidadeEnsino' => 1593],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

}
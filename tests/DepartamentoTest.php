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

    //Abreviatura vazia
    public function testPostDepartamentoaAbreviaturaVazia()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => 'Departamento teste',
        'abreviatura' => '',
        'codUnidadeEnsino' => 1],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDepartamentoaAbreviaturaVazia()
    {
        $response = $this->http->request('PUT', 'departamentos/25',
        [ 'json' => [
        'nome' => 'Departamento teste',
        'abreviatura' => '',
        'codUnidadeEnsino' => 1],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    //Abreviatura null
    public function testPostDepartamentoaAbreviaturaNull()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => 'Departamento teste',
        'abreviatura' => null,
        'codUnidadeEnsino' => 1],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDepartamentoaAbreviaturaNull()
    {
        $response = $this->http->request('PUT', 'departamentos/25',
        [ 'json' => [
        'nome' => 'Departamento teste segundo',
        'abreviatura' => null,
        'codUnidadeEnsino' => 1],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
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

    //CodUnidadeEnsino Null
    public function testPostDepartamentoCodUnidadeEnsinoNull()
    {
        $response = $this->http->request('POST', 'departamentos',
        [ 'json' => [
        'nome' => 'Departamento teste',
        'abreviatura' => 'ABCD',
        'codUnidadeEnsino' => null],
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
}
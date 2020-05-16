<?php

use PHPUnit\Framework\TestCase;

class InstituicaoEnsinoSuperiorTest extends TestCase
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
    public function testGetIes()
    {
        $response = $this->http->request('GET', 'instituicoes-ensino-superior', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetIes2()
    {
        $response = $this->http->request('GET', 'instituicoes-ensino-superior', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody,$message);
    }

    public function testGetIesNaoExistente()
    {
        $response = $this->http->request('GET', 'instituicoes-ensino-superior/100', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    //PUT
    public function testPutIesNaoExistente()
    {
        $response = $this->http->request('PUT', 'instituicoes-ensino-superior/111', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutIesNaoExistente2()
    {
        $response = $this->http->request('PUT', 'instituicoes-ensino-superior/2633', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody,$message);
    }

    //DELETE
    public function testDeleteIesNaoExistente()
    {
        $response = $this->http->request('DELETE', 'instituicoes-ensino-superior/157', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testDeleteIesNaoExistente2()
    {
        $response = $this->http->request('DELETE', 'instituicoes-ensino-superior/2637', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody,$message);
    }

    //CREATE - CÓDIGO ERRADO
    public function testPostIesCodIesVazio()
    {
        $response = $this->http->request('POST', 'instituicoes-ensino-superior',
        [ 'json' => [
        'codIes'=> '',
        'nome' => 'IES',
        'abreviatura' => 'ABCD'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostIesCodIesNull()
    {
        $response = $this->http->request('POST', 'instituicoes-ensino-superior',
        [ 'json' => [
        'codIes'=> null,
        'nome' => 'Instituicao Teste',
        'abreviatura' => 'ABCD'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostIesCodIesLetra()
    {
        $response = $this->http->request('POST', 'instituicoes-ensino-superior',
        [ 'json' => [
        'codIes'=> 'fff',
        'nome' => 'Instituição Teste',
        'abreviatura' => 'ABCD'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    //TUDO VAZIO
    public function testPostIesAllVazio()
    {
        $response = $this->http->request('POST', 'instituicoes-ensino-superior',
        [ 'json' => [
        'codIes'=> '',
        'nome' => '',
        'abreviatura' => ''],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutIesAllVazio()
    {
        $response = $this->http->request('PUT', 'instituicoes-ensino-superior/1500',
        [ 'json' => [
        'codIes'=> '',
        'nome' => '',
        'abreviatura' => ''],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    //TUDO NULL
    public function testPostIesAllNull()
    {
        $response = $this->http->request('POST', 'instituicoes-ensino-superior',
        [ 'json' => [
        'codIes'=> null,
        'nome' => null,
        'abreviatura' => null],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutIesAllNull()
    {
        $response = $this->http->request('PUT', 'instituicoes-ensino-superior/1500',
        [ 'json' => [
        'nome' => null,
        'abreviatura' => null],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    // NOME NUMÉRICO
    public function testPostIesNomeNumerico()
    {
        $response = $this->http->request('POST', 'instituicoes-ensino-superior',
        [ 'json' => [
        'codIes'=> '555',
        'nome' => '111',
        'abreviatura' => 'ABCD'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutIesNomeNumerico()
    {
        $response = $this->http->request('PUT', 'instituicoes-ensino-superior/1500',
        [ 'json' => [
        'nome' => '111',
        'abreviatura' => 'ABBB'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    //Nome Null
    public function testPostIesNomeNull()
    {
        $response = $this->http->request('POST', 'instituicoes-ensino-superior',
        [ 'json' => [
        'codIes'=> '777',
        'nome' => null,
        'abreviatura' => 'ABCD'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutIesNomeNull()
    {
        $response = $this->http->request('PUT', 'instituicoes-ensino-superior/1500',
        [ 'json' => [
        'nome' => null,
        'abreviatura' => 'ABCD'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    //Nome Vazio
    public function testPostIesNomeVazio()
    {
        $response = $this->http->request('POST', 'instituicoes-ensino-superior',
        [ 'json' => [
        'codIes'=> '555',
        'nome' => '',
        'abreviatura' => 'ABCD'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutIesNomeVazio()
    {
        $response = $this->http->request('PUT', 'instituicoes-ensino-superior/1500',
        [ 'json' => [
        'nome' => '',
        'abreviatura' => 'ABCD'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    //Abreviatura VAZIA
    public function testPostIesAbreviaturaVazio()
    {
        $response = $this->http->request('POST', 'instituicoes-ensino-superior',
        [ 'json' => [
        'codIes'=> '555',
        'nome' => 'Instituição Teste',
        'abreviatura' => ''],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutIesAbreviaturaVazio()
    {
        $response = $this->http->request('PUT', 'instituicoes-ensino-superior/1500',
        [ 'json' => [
        'nome' => 'Instituição Teste',
        'abreviatura' => ''],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    //Abreviatura Null
    public function testPostIesAbreviaturaNull()
    {
        $response = $this->http->request('POST', 'instituicoes-ensino-superior',
        [ 'json' => [
        'codIes'=> '888',
        'nome' => 'Instituicao Teste',
        'abreviatura' => null],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutIesAbreviaturaNull()
    {
        $response = $this->http->request('PUT', 'instituicoes-ensino-superior/1500',
        [ 'json' => [
        'nome' => 'Instituicao Teste',
        'abreviatura' => null],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    //Abreviatura Numérica
    public function testPostIesAbreviaturaNumerica()
    {
        $response = $this->http->request('POST', 'instituicoes-ensino-superior',
        [ 'json' => [
        'codIes'=> '555',
        'nome' => 'Instituicao Teste',
        'abreviatura' => '333'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutIesAbreviaturaNumerica()
    {
        $response = $this->http->request('PUT', 'instituicoes-ensino-superior/1500',
        [ 'json' => [
        'nome' => 'Teste Instituicao',
        'abreviatura' => '557'],
        'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
}
<?php

use PHPUnit\Framework\TestCase;

class CorrespondenciaTest extends TestCase
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

        return [ $key => [
            'Entities\\' . $this->entity . ': ' . self::STD_MSGS[$category]
        ]];
    }

    // Testes de comportamento normal

    // Teste de rotas GET
    public function testGetAllCorrespondencia()
    {
        $response = $this->http->request('GET', 'correspondencias', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetCorrespondenciasPpc()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/1/correspondencias/2', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetCorrespondenciaComponentes()
    {
        $response = $this->http->request('GET', 'componentes-curriculares/1/correspondencias/58', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // Teste POST
    public function testPostCorrespondencia()
    {
        $response = $this->http->request('POST', 'correspondencias', ['json' => ['codCompCurric' => 20,
        'codCompCurricCorresp' => 85, 'percentual' => 0.5],'http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // // Teste PUT
    public function testPutCorrespondencia()
    {
        $response = $this->http->request('PUT', 'correspondencias/20/85', ['json' => ['codCompCurric' => 36,
        'codCompCurricCorresp' => 90, 'percentual' => 0.5],'http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // Teste DELETE
    public function testDeleteCorrespondencia()
    {
        $response = $this->http->request('DELETE', 'correspondencias/36/90', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // Testes de erros
    // Teste de erro por correspondência não encontrada
    // public function testGetCorrespondenciaNaoExistente()
    // {
    //     $response = $this->http->request('GET', 'correspondencias', ['http_errors' => FALSE] );

    //     $this->assertEquals(404, $response->getStatusCode());

    //     $contentType = $response->getHeaders()["Content-Type"][0];
    //     $this->assertEquals("application/json; charset=UTF-8", $contentType);
    // }

    // Teste de erro por Ppc não existente
    public function testGetCorrespondenciaPpcNaoExistente()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/1234/correspondencias/1235', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    // Testes de erro por componente não existente ou não encontrado
    public function testGetCorrespondenciaComponentesNaoExistentes()
    {
        $response = $this->http->request('GET', 'componentes-curriculares/1234/correspondencias/1235', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostCorrespondenciaComponenteNaoExistente()
    {
        $response = $this->http->request('POST', 'correspondencias', ['json' => ['codCompCurric' => 1234,
        'codCompCurricCorresp' => 1235, 'percentual' => 1],'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCorrespondenciaComponenteNaoExistenteUrl()
    {
        $response = $this->http->request('PUT', 'correspondencias/1234/1235', ['json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 58, 'percentual' => 1],'http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCorrespondenciaComponenteNaoExistenteBody()
    {
        $response = $this->http->request('PUT', 'correspondencias/1/58', ['json' => ['codCompCurric' => 1234,
        'codCompCurricCorresp' => 1235, 'percentual' => 1],'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testDeleteCorrespondenciaComponenteNaoExistente()
    {
        $response = $this->http->request('DELETE', 'correspondencias/1234/1235', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
    

    //testes de erro por correspondências entre componentes de mesmo ppc
    public function testPostCorrespondenciaComponentesMesmoPpc()
    {
        $response = $this->http->request('POST','correspondencias', [ 'json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 222, 'percentual' => 1], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCorrespondenciaComponentesMesmoPpc()
    {
        $response = $this->http->request('PUT','correspondencias/1/58', [ 'json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 222, 'percentual' => 1], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    //testes de erro por correspondência entre componentes cujos ppcs não possuem transição mapeada
    public function testPostCorrespondenciaComponentesPpcSemTransicao()
    {
        $response = $this->http->request('POST','correspondencias/', [ 'json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 104, 'percentual' => 1], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutCorrespondenciaComponentesPpcSemTransicao()
    {
        $response = $this->http->request('PUT','correspondencias/1/58', [ 'json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 104, 'percentual' => 1], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // testes de erro por valores de percentual não aceitáveis
    public function testPutCorrespondenciaPercentualInferiorAoAceitavel()
    {
        $response = $this->http->request('PUT','correspondencias/1/58', [ 'json' => [ 'percentual' => 0], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostCorrespondenciaPercentualSuperiorAoAceitavel()
    {
        $response = $this->http->request('POST','correspondencias', [ 'json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 90, 'percentual' => 1.1], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // Testes de erro por entrada null
    public function testPutCorrespondenciaValoresNullBody()
    {
        $response = $this->http->request('PUT','correspondencias/1/58', [ 'json' =>  ['codCompCurric' => null,
        'codCompCurricCorresp' => null, 'percentual' => null], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostCorrespondenciaValoresNullBody()
    {
        $response = $this->http->request('POST','correspondencias', [ 'json' => ['codCompCurric' => null,
        'codCompCurricCorresp' => null, 'percentual' => null], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }



}
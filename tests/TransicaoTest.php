<?php

use PHPUnit\Framework\TestCase;

class TransicaoTest extends TestCase
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

    // Testes
    
    // Testes de comportamento normal

    // Teste de rotas GET
    public function testGetTransicao()
    {
        $response = $this->http->request('GET', 'transicoes', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetTransicaoPpc()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/1/transicoes', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetTransicaoUnidadeEnsino()
    {
        $response = $this->http->request('GET', 'unidades-ensino/1/transicoes', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // Teste POST
    public function testPostTransicao()
    {
        $response = $this->http->request('POST', 'transicoes', ['json' => ['codPpcAtual' => 1,
        'codPpcAlvo' => 3],'http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // Teste PUT
    public function testPutTransicao()
    {
        $response = $this->http->request('PUT', 'transicoes/1/3', ['json' => ['codPpcAtual' => 1,
        'codPpcAlvo' => 4],'http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // Teste DELETE
    public function testDeleteTransicao()
    {
        $response = $this->http->request('DELETE', 'transicoes/1/4', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // Testes de erros

    // Teste de erro por Ppc não existente
    public function testGetTransicaoPpcNaoExistente()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/1234/transicoes', ['http_errors' => FALSE] );

        // $this->assertEquals(404, $response->getStatusCode());
        
        // $contentType = $response->getHeaders()["Content-Type"][0];
        // $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = json_encode($this->getStdMessage(self::NOT_FOUND));

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($contentBody,$message);
    }

    // Testes de erro por componente não existente ou não encontrado
    public function testGetTransicaoUnidadeEnsinoNaoExistente()
    {
        $response = $this->http->request('GET', 'unidades-ensino/1234/transicoes', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostTransicaoPpcNaoExistente()
    {
        $response = $this->http->request('POST', 'transicoes', ['json' => ['codPpcAtual' => 1234,
        'codPpcAlvo' => 1235],'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutTransicaoPpcNaoExistenteUrl()
    {
        $response = $this->http->request('PUT', 'transicoes/1234/1235', ['json' => ['codPpcAtual' => 1,
        'codPpcAlvo' => 2],'http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutTransicaoPpcNaoExistenteBody()
    {
        $response = $this->http->request('PUT', 'transicoes/1/2', ['json' => ['codPpcAtual' => 1234,
        'codPpcAlvo' => 1235],'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testDeleteTransicaoComponenteNaoExistente()
    {
        $response = $this->http->request('DELETE', 'transicoes/1234/1235', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
    

    //testes de erro por Auto-transição
    public function testPostTransicaoMesmoPpc()
    {
        $response = $this->http->request('POST','transicoes', [ 'json' => ['codPpcAtual' => 1,
        'codPpcAlvo' => 1], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutTransicaoMesmoPpc()
    {
        $response = $this->http->request('PUT','transicoes/1/2', [ 'json' => ['codPpcAtual' => 1,
        'codPpcAlvo' => 1], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // Testes de erro por entrada null

    public function testPostTransicaoValoresNullBody()
    {
        $response = $this->http->request('POST','transicoes', [ 'json' => ['codPpcAtual' => null,
        'codPpcAlvo' => null], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
    
    public function testPutTransicaoValoresNullBody()
    {
        $response = $this->http->request('PUT','transicoes/1/2', [ 'json' =>  ['codPpcAtual' => null,
        'codPpcAlvo' => null], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    
}
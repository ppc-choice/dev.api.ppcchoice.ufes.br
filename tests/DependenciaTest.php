<?php

use PHPUnit\Framework\TestCase;

class DependenciaTest extends TestCase
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
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://dev.api.ppcchoice.ufes.br:8080/']);
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
    
    public function testGetDependenciaNaoExistente()
    {
        $response = $this->http->request('GET', 'dependencias/15/1', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetDependenciaExistente()
    {
        $response = $this->http->request('GET', 'dependencias/6/1', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetAllDependenciaExistente()
    {
        $response = $this->http->request('GET', 'dependencias', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        // $contentBody = $response->getBody()->getContents();
        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        
        $this->assertInternalType('array', $contentBody);
        // $this->assertEquals(getStdMessage('self::CREATED') , $contentBody["message"][0]);
    }

    public function testPostDependenciaFalha()
    {
        $response = $this->http->request('POST', 'dependencias',[ 'json' => ['codCompCurric' => 5,
        'codPreRequisito' => 1], 'http_errors' => FALSE]);

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostDependencia()
    {
        $response = $this->http->request('POST', 'dependencias', [ 'json' => ['codCompCurric' => 15,
        'codPreRequisito' => 1], 'http_errors' => FALSE]);
        
        $this->assertEquals(200, $response->getStatusCode());
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        // $contentBody = $response->getBody()->getContents();
        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        
        $this->assertInternalType('array', $contentBody);
        // $this->assertEquals(getStdMessage('self::CREATED') , $contentBody["message"][0]);
    }

    public function testPostDependenciaPeriodoIgual()
    {
        $response = $this->http->request('POST', 'dependencias', [ 'json' => ['codCompCurric' => 5,
        'codPreRequisito' => 1], 'http_errors' => FALSE]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        
        // $contentBody = $response->getBody()->getContents();
        $contentBody = json_decode($response->getBody()->getContents(),TRUE);

        $this->assertInternalType('array', $contentBody);

        $this->assertEquals("Entities\\Dependencia.componenteCurricular:    A componente curricular deve ter periodo maior que o seu pré-requisito.", $contentBody["error"][0]);
    }

    public function testPostDependenciaPpcDiferente()
    {
        $response = $this->http->request('POST', 'dependencias', [ 'json' => ['codCompCurric' => 120,
        'codPreRequisito' => 1], 'http_errors' => FALSE]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        
        // $contentBody = $response->getBody()->getContents();
        $contentBody = json_decode($response->getBody()->getContents(),TRUE);

        $this->assertInternalType('array', $contentBody);

        $this->assertEquals("Entities\\Dependencia.componenteCurricular:    As componentes curriculares devem pertencer ao mesmo ppc", $contentBody["error"][0]);

    }

    public function testPutDependenciaNaoExistente()
    {
        $response = $this->http->request('PUT', 'dependencias/12/2',[ 'json' => ['codCompCurric' => 18,
        'codPreRequisito' => 1], 'http_errors' => FALSE]);

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDependencia1()
    {
        $response = $this->http->request('PUT', 'dependencias/6/1',[ 'json' => ['codCompCurric' => 7,
        'codPreRequisito' => 2], 'http_errors' => FALSE]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDependencia2()
    {
        $response = $this->http->request('PUT', 'dependencias/7/2',[ 'json' => ['codCompCurric' => 15], 'http_errors' => FALSE]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDependencia3()
    {
        $response = $this->http->request('PUT', 'dependencias/15/2',[ 'json' => ['codPreRequisito' => 1], 'http_errors' => FALSE]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDependenciaFalha1PpcDiferente()
    {
        $response = $this->http->request('PUT', 'dependencias/15/1',[ 'json' => ['codCompCurric' => 7,
        'codPreRequisito' => 2], 'http_errors' => FALSE]);

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);

        $this->assertInternalType('array', $contentBody);

        $this->assertEquals("Entities\\Dependencia.componenteCurricular:    As componentes curriculares devem pertencer ao mesmo ppc", $contentBody["error"][0]);
    }

    public function testPutDependenciaFalha1PeriodoIgual()
    {
        $response = $this->http->request('PUT', 'dependencias/14/11',[ 'json' => ['codCompCurric' => 5,
        'codPreRequisito' => 3], 'http_errors' => FALSE]);

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);

        $this->assertInternalType('array', $contentBody);

        $this->assertEquals("Entities\\Dependencia.componenteCurricular:    A componente curricular deve ter periodo maior que o seu pré-requisito.", $contentBody["error"][0]);
    }

    public function testPutDependenciaFalha2PpcDiferente()
    {
        $response = $this->http->request('PUT', 'dependencias/18/14',[ 'json' => ['codCompCurric' => 100], 'http_errors' => FALSE]);

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);

        $this->assertInternalType('array', $contentBody);
        $this->assertEquals("Entities\\Dependencia.componenteCurricular:    As componentes curriculares devem pertencer ao mesmo ppc", $contentBody["error"][0]);
    }

    public function testPutDependenciaFalha2Periodoigual()
    {
        $response = $this->http->request('PUT', 'dependencias/20/14',[ 'json' => ['codCompCurric' => 15], 'http_errors' => FALSE]);

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);

        $this->assertInternalType('array', $contentBody);
        $this->assertEquals("Entities\\Dependencia.componenteCurricular:    A componente curricular deve ter periodo maior que o seu pré-requisito.", $contentBody["error"][0]);
    }

    public function testPutDependenciaFalha3PpcDiferente()
    {
        $response = $this->http->request('PUT', 'dependencias/17/5',[ 'json' => ['codPreRequisito' => 160], 'http_errors' => FALSE]);

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);

        $this->assertInternalType('array', $contentBody);
        $this->assertEquals("Entities\\Dependencia.componenteCurricular:    As componentes curriculares devem pertencer ao mesmo ppc", $contentBody["error"][0]);
    }

    public function testPutDependenciaFalha3Periodoigual()
    {
        $response = $this->http->request('PUT', 'dependencias/17/5',[ 'json' => ['codPreRequisito' => 16], 'http_errors' => FALSE]);

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);

        $this->assertInternalType('array', $contentBody);
        $this->assertEquals("Entities\\Dependencia.componenteCurricular:    A componente curricular deve ter periodo maior que o seu pré-requisito.", $contentBody["error"][0]);
    }

    public function testDeleteDependencia()
    {
        $response = $this->http->request('DELETE', 'dependencias/8/1', ['http_errors' => FALSE]);
        
        $this->assertEquals(200, $response->getStatusCode());
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        // $contentBody = $response->getBody()->getContents();
        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        
        $message = getStdMessage('CREATED');
        var_dump($message);

        $this->assertInternalType('array', $contentBody);
        $this->assertEquals($message, $contentBody["message"][0]);

    }

    public function testDeleteDependenciaFalha()
    {
        $response = $this->http->request('DELETE', 'dependencias/63/58', ['http_errors' => FALSE]);
        
        $this->assertEquals(404, $response->getStatusCode());
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        // $contentBody = $response->getBody()->getContents();
        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        
        $message = getStdMessage('CREATED');
        var_dump($message);

        $this->assertInternalType('array', $contentBody);
        $this->assertEquals($message, $contentBody["message"][0]);
    } 
}
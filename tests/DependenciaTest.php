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

    const CONSTRAINT_PERIODO_IGUAL = 'CONSTRAINT_PERIODO_IGUAL';

    const CONSTRAINT_PPC_DIFERENTE = 'CONSTRAINT_PPC_DIFERENTE';

    // Mensagens padrão de retorno
    const STD_MSGS = [
        self::CREATED => 'Instância criada com sucesso.', 
        self::DELETED => 'Instância removida com sucesso.', 
        self::UPDATED => 'Instância atualizada com sucesso.', 
        self::NOT_FOUND => 'Instância não encontrada.', 
        self::EXCEPTION => 'Ocorreu uma exceção ao persistir a instância.', 
        self::CONSTRAINT_PERIODO_IGUAL => '   A componente curricular deve ter periodo maior que o seu pré-requisito.',
        self::CONSTRAINT_PPC_DIFERENTE => '   As componentes curriculares devem pertencer ao mesmo ppc.'
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
    public function getStdMessage($category = 'NOT_FOUND', $subpath = '')
    {
        switch ($category) {
            case self::CREATED:
            case self::DELETED:
            case self::UPDATED:
                $key = 'message';
                break;
            case self::NOT_FOUND:
            case self::EXCEPTION:
            case self::CONSTRAINT_PERIODO_IGUAL:
            case self::CONSTRAINT_PPC_DIFERENTE:
                $key = 'error';
                break;
            default:
                $key = 'key';
                break;
        }

        if($subpath!=''){
            return json_encode([ $key => [
                'Entities\\' . $this->entity . '.' . $subpath  . ': '  . self::STD_MSGS[$category]
            ]]);
            
        }

        else{
            return json_encode([ $key => [
                'Entities\\' . $this->entity . ': '  . self::STD_MSGS[$category]
            ]]);
        }
        
    }

    public function setArrayDependencia($curso, $codCompCurric, $nomeCompCurric, $codPreRequisito, $nomePreRequisito)
    {
        $dependenciaArray = [ "curso"=> $curso, "codCompCurric"=> $codCompCurric, 
                            "nomeCompCurric"=> $nomeCompCurric, "CodPreRequisito"=> $codPreRequisito, 
                            "nomePreRequisita"=> $nomePreRequisito];

       return json_encode($dependenciaArray);
    }

    // Testes
    
    public function testGetDependenciaNaoExistente()
    {
        $response = $this->http->request('GET', 'dependencias/15/1', ['http_errors' => FALSE] );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testGetDependenciaExistente()
    {
        $response = $this->http->request('GET', 'dependencias/7/1', ['http_errors' => FALSE] );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
       
        $dependenciaArray= ["Curso" => "Ciência da Computação", "codCompCurric" => 7,
                            "nomeCompCurric" => "Fundamentos de Mecânica Clássica",
                            "codPreRequisito" => 1, "nomePreRequisito" => "Cálculo I"];

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString(json_encode($dependenciaArray), $contentBody);
    }

    public function testGetAllDependenciaExistente()
    {
        $response = $this->http->request('GET', 'dependencias', ['http_errors' => FALSE] );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertEquals(getStdMessage(self::CREATED) , $contentBody["message"][0]);
    }

    public function testPostDependenciaFalha()
    {
        $response = $this->http->request('POST', 'dependencias',[ 'json' => ['codCompCurric' => 5,
                                         'codPreRequisito' => 1], 'http_errors' => FALSE]);
       
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::EXCEPTION);
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);       
    }

    public function testPostDependencia()
    {
        $response = $this->http->request('POST', 'dependencias', [ 'json' => ['codCompCurric' => 15,
                                         'codPreRequisito' => 1], 'http_errors' => FALSE]);
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CREATED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);     
    }

    public function testPostDependenciaPeriodoIgual()
    {
        $response = $this->http->request('POST', 'dependencias', [ 'json' => ['codCompCurric' => 5,
                                         'codPreRequisito' => 1], 'http_errors' => FALSE]);
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_PERIODO_IGUAL, "componenteCurricular");

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody); 
    }

    public function testPostDependenciaPpcDiferente()
    {
        $response = $this->http->request('POST', 'dependencias', [ 'json' => ['codCompCurric' => 120,
                                         'codPreRequisito' => 1], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_PPC_DIFERENTE, "componenteCurricular");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutDependenciaNaoExistente()
    {
        $response = $this->http->request('PUT', 'dependencias/12/2',[ 'json' => ['codCompCurric' => 18,
                                         'codPreRequisito' => 1], 'http_errors' => FALSE]);
                                         
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);     
    }

    public function testPutDependencia1()
    {
        $response = $this->http->request('PUT', 'dependencias/6/1',[ 'json' => ['codCompCurric' => 7,
                                         'codPreRequisito' => 2], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::UPDATED);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutDependencia2()
    {
        $response = $this->http->request('PUT', 'dependencias/7/2',[ 'json' => ['codCompCurric' => 15], 
                                         'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::UPDATED);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutDependencia3()
    {
        $response = $this->http->request('PUT', 'dependencias/15/2',[ 'json' => ['codPreRequisito' => 1], 
                                         'http_errors' => FALSE]);

        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::UPDATED);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutDependenciaFalha1PpcDiferente()
    {
        $response = $this->http->request('PUT', 'dependencias/15/1',[ 'json' => ['codCompCurric' => 7,
                                         'codPreRequisito' => 2], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_PPC_DIFERENTE, "componenteCurricular");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutDependenciaFalha1PeriodoIgual()
    {
        $response = $this->http->request('PUT', 'dependencias/14/11',[ 'json' => ['codCompCurric' => 5,
                                         'codPreRequisito' => 3], 'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_PERIODO_IGUAL, "componenteCurricular");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutDependenciaFalha2PpcDiferente()
    {
        $response = $this->http->request('PUT', 'dependencias/18/14',[ 'json' => ['codCompCurric' => 100], 
                                         'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_PPC_DIFERENTE, "componenteCurricular");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutDependenciaFalha2Periodoigual()
    {
        $response = $this->http->request('PUT', 'dependencias/20/14',[ 'json' => ['codCompCurric' => 15], 
                                         'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_PERIODO_IGUAL, "componenteCurricular");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutDependenciaFalha3PpcDiferente()
    {
        $response = $this->http->request('PUT', 'dependencias/17/5',[ 'json' => ['codPreRequisito' => 160],
                                         'http_errors' => FALSE]);
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_PPC_DIFERENTE, "componenteCurricular");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutDependenciaFalha3Periodoigual()
    {
        $response = $this->http->request('PUT', 'dependencias/17/5',['json' =>['codPreRequisito' => 16,
                                         'http_errors' => FALSE]]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_PERIODO_IGUAL, "componenteCurricular");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testDeleteDependencia()
    {
        $response = $this->http->request('DELETE', 'dependencias/64/59', ['http_errors' => FALSE]);
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::DELETED);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testDeleteDependenciaFalha()
    {
        $response = $this->http->request('DELETE', 'dependencias/7/2', ['http_errors' => FALSE]);
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);
        
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    } 
}
<?php

use PHPUnit\Framework\TestCase;

class ComponenteCurricularTest extends TestCase
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
    public function testGetAllComponentes()
    {
        $response = $this->http->request('GET', 'componentes-curriculares', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetComponente()
    {
        $response = $this->http->request('GET', 'componentes-curriculares/1', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetComponentesPpc()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/1/componentes-curriculares', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
    
    // Testes POST

    public function testPostComponente()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 1,
            'codPpc'=> 3,
            'credito'=>  4,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    // Teste PUT

    public function testPutComponente()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/221', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 5,
            'codPpc'=> 4,
            'credito'=>  2,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    // Teste DELETE

    // public function testDeleteComponente()
    // {
    //     $response = $this->http->request('DELETE', 'componentes-curriculares/227', ['http_errors' => FALSE] );

    //     $this->assertEquals(200, $response->getStatusCode());

    //     $contentType = $response->getHeaders()["Content-Type"][0];
    //     $this->assertEquals("application/json; charset=UTF-8", $contentType);
    // }


    // Teste de erros GET

    // Testes por ppc não existente ou não encontrado

    public function testGetComponentesPpcNaoExistente()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/1234/componentes-curriculares', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPostComponentePpcNaoExistente()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 1,
            'codPpc'=> 1234,
            'credito'=>  4,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutComponentePpcNaoExistente()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 5,
            'codPpc'=> 1234,
            'credito'=>  2,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // Testes por com ponente não existente ou não encontrado
    public function testGetComponenteNaoExistente()
    {
        $response = $this->http->request('GET', 'componentes-curriculares/1234', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testPutComponenteNaoExistente()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1234', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 5,
            'codPpc'=> 3,
            'credito'=>  2,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testDeleteComponenteNaoExistente()
    {
        $response = $this->http->request('DELETE', 'componentes-curriculares/1234', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    // teste departamento não existente

    // Testes por disciplina não existente ou não encontrada
    
    public function testPostComponenteDisciplinaNaoExistente()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  1234,
            'numDisciplina'=> 6,
            'periodo'=> 1,
            'codPpc'=> 1,
            'credito'=>  4,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
    
    public function testPutComponenteDisciplinaNaoExistente()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1234', 
        ['json' => [
            'codDepto'=>  1234,
            'numDisciplina'=> 6,
            'periodo'=> 5,
            'codPpc'=> 3,
            'credito'=>  2,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    //  Teste por período de valor inválido

    public function testPostComponentePeriodoInvalido()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 0,
            'codPpc'=> 3,
            'credito'=>  2,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
    
    public function testPutComponentePeriodoInvalido()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1234', 
        ['json' => [
            'periodo'=> 0
        ],'http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    // Teste por crédito de valor inválido

    public function testPostComponenteCreditoInvalido()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 5,
            'codPpc'=> 3,
            'credito'=>  -1,
            'tipo'=>  'OPTATIVA'
        ],'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
    
    public function testPutComponenteCreditoInvalido()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1234', 
        ['json' => [
            'credito'=>  -1
        ],'http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }


    // Teste por tipo de valor inválido

    public function testPostComponenteTipoInvalido()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  1,
            'numDisciplina'=> 6,
            'periodo'=> 5,
            'codPpc'=> 3,
            'credito'=>  2,
            'tipo'=>  'OPTATORIA'
        ],'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
    
    public function testPutComponenteTipoInvalido()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1234', 
        ['json' => [
            'tipo'=>  'OPTATORIA'
        ],'http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    // Teste valores NULL

    public function testPostComponenteValoresNull()
    {
        $response = $this->http->request('POST', 'componentes-curriculares', 
        ['json' => [
            'codDepto'=>  null,
            'numDisciplina'=> null,
            'periodo'=> null,
            'codPpc'=> null,
            'credito'=>  null,
            'tipo'=>  null
        ],'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
    
    public function testPutComponenteValoresNull()
    {
        $response = $this->http->request('PUT', 'componentes-curriculares/1234', 
        ['json' => [
            'codDepto'=>  null,
            'numDisciplina'=> null,
            'periodo'=> null,
            'codPpc'=> null,
            'credito'=>  null,
            'tipo'=>  null
        ],'http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
}
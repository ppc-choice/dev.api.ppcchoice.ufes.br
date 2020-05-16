<?php

use PHPUnit\Framework\TestCase;

class DisciplinaTest extends TestCase
{
    private $http;

    private $entity;
    
    const CREATED = 'CREATED';
    
    const UPDATED = 'UPDATED';

    const DELETED = 'DELETED';

    const NOT_FOUND = 'NOT_FOUND';

    const EXCEPTION = 'EXCEPTION';

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

    // GET
    public function testGetDisciplinaNaoExistente()
    {
        $response = $this->http->request('GET', 'disciplinas/7/2', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    public function testGetAllDisciplinaExistente()
    {
        $response = $this->http->request('GET', 'disciplinas', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    // POST
    public function testPostDisciplinaFalhaRequisicao()
    {
        $response = $this->http->request('POST', 'disciplinas', ['json' => ['numDisciplina' => 6,
        'ch' => 60, 'nome' => 6, 'codDepto' => 6], 'http_errors' => FALSE]);

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    // PUT
    public function testPutDisciplinaNaoExistente()
    {
        $response = $this->http->request('PUT', 'disciplinas/1/6', 
        ['json' => ['ch' => 60, 'nome' => 6], 'http_errors' => FALSE]);

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }

    // DELETE
    public function testDeleteDisciplinaNaoExistente()
    {
        $response = $this->http->request('PUT', 'disciplinas/1/6', ['http_errors' => FALSE]);

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
}
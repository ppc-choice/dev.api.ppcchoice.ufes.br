<?php

use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase
{
    // Cliente HTTP para testes de requisição
    private $http;

    // Entity name 
    private $entity;
    
    // Mensagens padrão de retorno
    const STD_MSGS = [
        'CREATED' => 'Instância criada com sucesso.', 
        'DELETED' => 'Instância removida com sucesso.', 
        'UPDATED' => 'Instância atualizada com sucesso.', 
        'NOT_FOUND' => 'Instância não encontrada.', 
        'EXCEPTION' => 'Ocorreu uma exceção ao persistir a instância.', 
    ];

    public function setUp(){
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://dev.api.ppcchoice.ufes.br/']);
        $this->entity = preg_replace('/Test$/', "", get_class($this));
    }

    public function tearDown() {
        $this->http = null;
    }

    /* 
    * Retorna msg padrão 
    */
    public function getStdMessage($category)
    {
        switch ($category) {
            case 'CREATED':
            case 'DELETED':
            case 'UPDATED':
                $key = 'message';
                break;
            case 'NOT_FOUND':
            case 'EXCEPTION':
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

    public function testGetUsuarioNaoExistente()
    {
        $response = $this->http->request('GET', 'usuarios/100', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        echo json_encode($this->getStdMessage('CREATED'));
    }
}
<?php

use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase
{
    // Cliente HTTP para testes de requisição
    private $http;

    // Nome da entidade 
    private $entity;
    
    // Categoria 'message'
    const CREATED = 'CREATED';
    
    const UPDATED = 'UPDATED';

    const DELETED = 'DELETED';


    // Categoria  'error'
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

    // public function testGetTodosUsuarios()
    // {
    //     $response = $this->http->request('GET', 'usuarios', ['http_errors' => FALSE]);
        
    //     $this->assertEquals(200, $response->getStatusCode());

    //     $this->assertEquals("application/json; charset=UTF-8", $response->getHeader('Content-Type')[0]);

    //     $body = json_decode($response->getBody()->getContents());
        
    //     $this->assertInternalType('array', $body);

    //     $usuarioEsperado = [
    //         "codUsuario" =>  2,
    //         "senha" => "$2a$10$.urkFh/lvzcnzm1S.TQ6rup5Slv.DQ0NZfkwFXPijBeNO.E032Ugi",
    //         "nome" => "Hadamo",
    //         "dtUltimoAcesso" => "2019-02-01T00:00:00-02:00",
    //         "email" => "hadamo.egito@ppcchoice",
    //         "papel" => "ADMIN",
    //         "conjuntoSelecao" => null
    //     ];

    //     $this->assertContains($usuarioEsperado,$body);

    // }
    
    // public function testGetUsuarioById()
    // {
    //     $response = $this->http->request('GET', 'usuarios/2', ['http_errors' => FALSE]);
        
    //     $this->assertEquals(200, $response->getStatusCode());

    //     $this->assertEquals("application/json; charset=UTF-8", $response->getHeader('Content-Type')[0]);

    //     $usuario = [
    //         "codUsuario" =>  2,
    //         "senha" => "$2a$10$.urkFh/lvzcnzm1S.TQ6rup5Slv.DQ0NZfkwFXPijBeNO.E032Ugi",
    //         "nome" => "Hadamo",
    //         "dtUltimoAcesso" => "2019-02-01T00:00:00-02:00",
    //         "email" => "hadamo.egito@ppcchoice",
    //         "papel" => "ADMIN",
    //         "conjuntoSelecao" => null
    //     ];

    //     $this->assertJsonStringEqualsJsonString( json_encode($usuario), $response->getBody()->getContents());
    // }

    // public function testCriarUsuarioTodosCamposValidos()
    // {
    //     $usuario = [
    //         "senha" => "senhaTeste",
    //         "nome" => "Teste",
    //         "dtUltimoAcesso" => "2019-02-01T00:00:00-02:00",
    //         "email" => "meuemail@gmail.com",
    //         "papel" => "VISITOR",
    //         "conjuntoSelecao" => null
    //     ];

    //     $response = $this->http->request('POST', 'usuarios', [ 
    //     'headers' => [
    //         'Content-Type' => 'application/json'
    //     ],
    //     'json' => $usuario,
    //     'http_errors' => FALSE]);
        
    //     $this->assertEquals(200, $response->getStatusCode());

    //     $this->assertEquals("application/json; charset=UTF-8", $response->getHeader('Content-Type')[0]);

    //     $this->assertJsonStringEqualsJsonString( $this->getStdMessage(self::CREATED), $response->getBody()->getContents());
        
    // }   

    // // Testes

    // public function testGetUsuarioNaoExistente()
    // {
    //     $response = $this->http->request('GET', 'usuarios/100', ['http_errors' => FALSE] );

    //     $this->assertEquals(404, $response->getStatusCode());

    //     // $this->assertEquals("application/json; charset=UTF-8", $response->getContentType());


    // }

    // // Exemplo
    // public function testPostUsuarioDadoInvalido()
    // {
    //     $response = $this->http->request('POST', 'usuarios', [
    //         'http_errors' => FALSE,
    //         'headers' => [
    //             // 'Content-Type' => 'application/json',
    //             'Cache-Control' => 'no-cache'        
    //         ],
    //         'json' => [
    //                 'nome' => 'x',
    //         ],
    //     ]);
    //     // echo $response->getBody()->getContents();
    //     // $this->assertEquals(200, $response->getStatusCode());

    //     // $contentType = $response->getHeaders()["Content-Type"][0];
    //     // $this->assertEquals("application/json; charset=UTF-8", $contentType);
    // }
}
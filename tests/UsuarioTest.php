<?php

use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase
{
    private $http;

    public function setUp(){
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://dev.api.ppcchoice.ufes.br/']);
    }

    public function tearDown() {
        $this->http = null;
    }

    public function testGetUsuarioNaoExistente()
    {
        $response = $this->http->request('GET', 'usuarios/100', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    }
}
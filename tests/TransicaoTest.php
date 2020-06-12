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

    const CONSTRAINT_PPC_IGUAL = 'CONSTRAINT_PPC_IGUAL';
    
    const CONSTRAINT_NOT_NULL = 'CONSTRAINT_NOT_NULL';

    // Mensagens padrão de retorno
    const STD_MSGS = [
        self::CREATED => 'Instância criada com sucesso.', 
        self::DELETED => 'Instância removida com sucesso.', 
        self::UPDATED => 'Instância atualizada com sucesso.', 
        self::NOT_FOUND => 'Instância não encontrada.', 
        self::EXCEPTION => 'Ocorreu uma exceção ao persistir a instância.', 
        self::CONSTRAINT_PPC_IGUAL => 'Auto-transição não é permitida.',
        self::CONSTRAINT_NOT_NULL => 'Este valor não deve ser nulo.'
    ];

    public function setUp(){
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://dev.api.ppcchoice.ufes.br/']);
        $this->entity = preg_replace('/Test$/', "", get_class($this));
    }

    public function tearDown() {
        $this->http = null;
        $this->entity = null;
    }


    /** 
    * Gera chave para o array de mensagens padrões de retorno da API.
    * @author Hádamo Egito (http://github.com/hadamo)  
    * @param $category {string} Tipo da mensagem de retorno da API.
    * @return string
    */
    public function generateKey($category)
    {
        switch ($category) {
            case self::CREATED:
            case self::DELETED:
            case self::UPDATED:
                $key = 'message';
                break;
            case self::NOT_FOUND:
            case self::EXCEPTION:
            case self::CONSTRAINT_PPC_IGUAL:
            case self::CONSTRAINT_NOT_NULL:
                $key = 'error';
                break;
            default:
                $key = 'key';
                break;
        }
        return $key;   
    }

    /** 
    * Gera mensagem para o array de mensagens padrões de retorno da API.
    * @author Hádamo Egito (http://github.com/hadamo)  
    * @param $subpath {string} Identifica o atributo da classe na qual o erro ocorre.
    * @param $category {string} Tipo da mensagem de retorno da API.
    * @return string
    */
    public function generateMessage($category, $subpath = '')
    {
        return 'Entities\\' . $this->entity . ( !empty($subpath) ? '.'  :  ''  ) 
            . $subpath . ':    '  . self::STD_MSGS[$category];
    }

    /** 
    * Gera objeto json com chave da categoria e mensagens padrões de retorno da API.
    * @author Hádamo Egito (http://github.com/hadamo)  
    * @param $subpath {string} Identifica o atributo da classe na qual o erro ocorre.
    * @param $category {string} Tipo da mensagem de retorno da API.
    * @return json
    */
    public function getStdMessage($category = 'NOT_FOUND', $subpath = '')
    {
        $key = $this->generateKey($category);
        return json_encode( [ $key => [$this->generateMessage($category, $subpath)]]);
    }

    /** 
    * Gera objeto json com todas as mensagens de erro.
    * @author Hádamo Egito (http://github.com/hadamo)  
    * @param $violation {Array} Array de arrays, os quais contém categoria e mensagem de erros
    * @return json
    */
    public function getMultipleErrorMessages($violations = [])
    {
        $messages = [];
        foreach ($violations as $content)
        {
            $message = $this->generateMessage($content[0],$content[1]);
            array_push($messages,$message);
        }

        $errorArray = ['error' => $messages];        
        return json_encode($errorArray);
    }

    // Testes
    
    // Testes de comportamento normal

    // Teste de rotas GET
    public function testGetAllTransicoes()
    {
        $response = $this->http->request('GET', 'transicoes', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
       
        $transicao = [ "ppcAtual"=> "Ciência da Computação (2011)",
                    "codPpcAtual"=> 1,
                    "ppcAlvo"=> "Ciência da Computação (2019)",
                    "codPpcAlvo"=> 2];

        $transicaoJson = json_encode($transicao);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($transicaoJson, $contentBody);
        
    }

    public function testGetTransicaoPpc()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/1/transicoes', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
       
        $transicao = [ "ppcAtual"=> "Ciência da Computação (2011)",
                    "codPpcAtual"=> 1,
                    "ppcAlvo"=> "Ciência da Computação (2019)",
                    "codPpcAlvo"=> 2];

        $transicaoJson = json_encode($transicao);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($transicaoJson, $contentBody);
    }

    public function testGetTransicaoUnidadeEnsino()
    {
        $response = $this->http->request('GET', 'unidades-ensino/1/transicoes', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
       
        $transicao = ["nomeCurso"=> "Ciência da Computação (2011)", "codPpc"=> 1];

        $transicaoJson = json_encode($transicao);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($transicaoJson, $contentBody);
    }


    // Teste POST
    public function testPostTransicao()
    {
        $response = $this->http->request('POST', 'transicoes', ['json' => ['codPpcAtual' => 1,
        'codPpcAlvo' => 3],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CREATED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }


    // Teste PUT
    public function testPutTransicao()
    {
        $response = $this->http->request('PUT', 'transicoes/1/3', ['json' => ['codPpcAtual' => 1,
        'codPpcAlvo' => 4],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::UPDATED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }


    // Teste DELETE
    public function testDeleteTransicao()
    {
        $response = $this->http->request('DELETE', 'transicoes/1/4', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::DELETED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }


    // Testes de erros

    // Teste de erro por Ppc não existente
    public function testGetTransicaoPpcNaoExistente()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/1234/transicoes', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    // Testes de erro por unidade de ensino não existente ou não encontrado
    public function testGetTransicaoUnidadeEnsinoNaoExistente()
    {
        $response = $this->http->request('GET', 'unidades-ensino/1234/transicoes', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    // Testes de erro por ppc não existente ou não encontrado
    public function testPostTransicaoPpcNaoExistente()
    {
        $response = $this->http->request('POST', 'transicoes', ['json' => ['codPpcAtual' => 1234,
        'codPpcAlvo' => 1235],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'ppcAtual'],
                    [self::CONSTRAINT_NOT_NULL,'ppcAlvo'] ]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutTransicaoPpcNaoExistenteUrl()
    {
        $response = $this->http->request('PUT', 'transicoes/1234/1235', ['json' => ['codPpcAtual' => 1,
        'codPpcAlvo' => 2],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPutTransicaoPpcNaoExistenteBody()
    {
        $response = $this->http->request('PUT', 'transicoes/1/2', ['json' => ['codPpcAtual' => 1234,
        'codPpcAlvo' => 1235],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'ppcAtual'],
                    [self::CONSTRAINT_NOT_NULL,'ppcAlvo'] ]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testDeleteTransicaoPpcNaoExistente()
    {
        $response = $this->http->request('DELETE', 'transicoes/1234/1235', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);

    }
    

    //testes de erro por Auto-transição
    public function testPostTransicaoPpcIgual()
    {
        $response = $this->http->request('POST','transicoes', [ 'json' => ['codPpcAtual' => 1,
        'codPpcAlvo' => 1], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        $message = $this->getStdMessage(self::CONSTRAINT_PPC_IGUAL, 'ppcAtual');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
        
    }

    public function testPutTransicaoPpcIgual()
    {
        $response = $this->http->request('PUT','transicoes/1/2', [ 'json' => ['codPpcAtual' => 1,
        'codPpcAlvo' => 1], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        $message = $this->getStdMessage(self::CONSTRAINT_PPC_IGUAL, 'ppcAtual');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }


    // Testes de erro por entrada null

    public function testPostTransicaoValoresNullBody()
    {
        $response = $this->http->request('POST','transicoes', [ 'json' => ['codPpcAtual' => null,
        'codPpcAlvo' => null], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'ppcAtual'],
                    [self::CONSTRAINT_NOT_NULL,'ppcAlvo'] ]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }
    
    public function testPutTransicaoValoresNullBody()
    {
        $response = $this->http->request('PUT','transicoes/1/2', [ 'json' =>  ['codPpcAtual' => null,
        'codPpcAlvo' => null], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL, 'ppcAtual'],
                    [self::CONSTRAINT_NOT_NULL,'ppcAlvo'] ]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    
}
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

    const CONSTRAINT_PPC_IGUAL = 'CONSTRAINT_PPC_IGUAL';

    const CONSTRAINT_TRANSICAO_INEXISTENTE = 'CONSTRAINT_TRANSICAO_INEXISTENTE';

    const CONSTRAINT_NOT_NULL = 'CONSTRAINT_NOT_NULL';

    const CONSTRAINT_RANGE_MIN = 'CONSTRAINT_RANGE_MIN';

    const CONSTRAINT_RANGE_MAX = 'CONSTRAINT_RANGE_MAX';
     
    const CONSTRAINT_RANGE_INVALIDO = 'CONSTRAINT_RANGE_INVALID';

    // Mensagens padrão de retorno
    const STD_MSGS = [
        self::CREATED => 'Instância criada com sucesso.', 
        self::DELETED => 'Instância removida com sucesso.', 
        self::UPDATED => 'Instância atualizada com sucesso.', 
        self::NOT_FOUND => 'Instância não encontrada.', 
        self::EXCEPTION => 'Ocorreu uma exceção ao persistir a instância.', 
        self::CONSTRAINT_PPC_IGUAL => 'Componentes curriculares devem ser de ppcs diferentes.',
        self::CONSTRAINT_TRANSICAO_INEXISTENTE => 'Os Componentes curriculares devem ser de ppcs com transição mapeada entre si.',
        self::CONSTRAINT_NOT_NULL => 'Este valor não deve ser nulo.',
        self::CONSTRAINT_RANGE_MIN => 'Este valor deve ser maior que 0%.',
        self::CONSTRAINT_RANGE_MAX => 'Este valor não pode ser maior que 100%.',
        self::CONSTRAINT_RANGE_INVALIDO => 'O valor deve ser um número válido.',
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
            case self::CONSTRAINT_TRANSICAO_INEXISTENTE:
            case self::CONSTRAINT_PPC_IGUAL:
            case self::CONSTRAINT_RANGE_MIN:
            case self::CONSTRAINT_RANGE_MAX:
            case self::CONSTRAINT_RANGE_INVALIDO:
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

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CREATED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }


    // // Teste PUT
    public function testPutCorrespondencia()
    {
        $response = $this->http->request('PUT', 'correspondencias/20/85', ['json' => ['codCompCurric' => 36,
        'codCompCurricCorresp' => 90, 'percentual' => 0.5],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::UPDATED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }


    // Teste DELETE
    public function testDeleteCorrespondencia()
    {
        $response = $this->http->request('DELETE', 'correspondencias/36/90', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::DELETED);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
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

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    // Testes de erro por componente não existente ou não encontrado
    public function testGetCorrespondenciaComponentesNaoExistentes()
    {
        $response = $this->http->request('GET', 'componentes-curriculares/1234/correspondencias/1235', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPostCorrespondenciaComponenteNaoExistente()
    {
        $response = $this->http->request('POST', 'correspondencias', ['json' => ['codCompCurric' => 1234,
        'codCompCurricCorresp' => 1235, 'percentual' => 0.5],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL ,'componenteCurricular'],
                    [self::CONSTRAINT_NOT_NULL ,'componenteCurricularCorresp'] ]; 
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutCorrespondenciaComponenteNaoExistenteUrl()
    {
        $response = $this->http->request('PUT', 'correspondencias/1234/1235', ['json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 58, 'percentual' => 0.5],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPutCorrespondenciaComponenteNaoExistenteBody()
    {
        $response = $this->http->request('PUT', 'correspondencias/1/58', ['json' => ['codCompCurric' => 1234,
        'codCompCurricCorresp' => 1235, 'percentual' => 0.5],'http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL ,'componenteCurricular'],
                    [self::CONSTRAINT_NOT_NULL ,'componenteCurricularCorresp'] ];  
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testDeleteCorrespondenciaComponenteNaoExistente()
    {
        $response = $this->http->request('DELETE', 'correspondencias/1234/1235', ['http_errors' => FALSE] );

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }
    

    //testes de erro por correspondências entre componentes de mesmo ppc
    public function testPostCorrespondenciaComponentesPpcIgual()
    {
        $response = $this->http->request('POST','correspondencias', [ 'json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 222, 'percentual' => 0.5], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_PPC_IGUAL,'componenteCurricular');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPutCorrespondenciaComponentesPpcIgual()
    {
        $response = $this->http->request('PUT','correspondencias/1/58', [ 'json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 222, 'percentual' => 0.5], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_PPC_IGUAL,'componenteCurricular');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }


    // testes de erro por correspondência entre componentes cujos ppcs não possuem transição mapeada
    public function testPostCorrespondenciaComponentesTransicaoInexistente()
    {
        $response = $this->http->request('POST','correspondencias/', [ 'json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 104, 'percentual' => 0.5], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_TRANSICAO_INEXISTENTE,'componenteCurricular');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPutCorrespondenciaComponentesTransicaoInexistente()
    {
        $response = $this->http->request('PUT','correspondencias/1/58', [ 'json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 104, 'percentual' => 0.5], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_TRANSICAO_INEXISTENTE,'componenteCurricular');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }


    // testes de erro por valores de percentual não aceitáveis

    public function testPostCorrespondenciaPercentualInferiorAoAceitavel()
    {
        $response = $this->http->request('POST','correspondencias', [ 'json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 90, 'percentual' => 0.01], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_RANGE_MIN,'percentual');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPostCorrespondenciaPercentualSuperiorAoAceitavel()
    {
        $response = $this->http->request('POST','correspondencias', [ 'json' => ['codCompCurric' => 1,
        'codCompCurricCorresp' => 90, 'percentual' => 1.1], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_RANGE_MAX,'percentual');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPutCorrespondenciaPercentualInferiorAoAceitavel()
    {
        $response = $this->http->request('PUT','correspondencias/1/58', [ 'json' => [ 'percentual' => 0.01], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_RANGE_MIN,'percentual');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }

    public function testPutCorrespondenciaPercentualSuperiorAoAceitavel()
    {
        $response = $this->http->request('PUT','correspondencias/1/58', [ 'json' => [ 'percentual' => 1.1], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_RANGE_MAX,'percentual');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message,$contentBody);
    }


    // Testes de erro por entrada null

    public function testPostCorrespondenciaValoresNullBody()
    {
        $response = $this->http->request('POST','correspondencias', [ 'json' => ['codCompCurric' => null,
        'codCompCurricCorresp' => null, 'percentual' => null], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL ,'componenteCurricular'],
                    [self::CONSTRAINT_NOT_NULL ,'componenteCurricularCorresp'],   
                    [self::CONSTRAINT_NOT_NULL ,'percentual'] ];   
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }

    public function testPutCorrespondenciaValoresNullBody()
    {
        $response = $this->http->request('PUT','correspondencias/1/58', [ 'json' =>  ['codCompCurric' => null,
        'codCompCurricCorresp' => null, 'percentual' => null], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [[self::CONSTRAINT_NOT_NULL ,'componenteCurricular'],
                    [self::CONSTRAINT_NOT_NULL ,'componenteCurricularCorresp'],   
                    [self::CONSTRAINT_NOT_NULL ,'percentual'] ];  
        $errorArray = $this->getMultipleErrorMessages($violations);       
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertContains($errorArray,$contentBody);
    }
}
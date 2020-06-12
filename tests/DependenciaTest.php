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

    const CONSTRAINT_NOT_NULL = 'CONSTRAINT_NOT_NULL';


    // Mensagens padrão de retorno
    const STD_MSGS = [
        self::CREATED => 'Instância criada com sucesso.', 
        self::DELETED => 'Instância removida com sucesso.', 
        self::UPDATED => 'Instância atualizada com sucesso.', 
        self::NOT_FOUND => 'Instância não encontrada.', 
        self::EXCEPTION => 'Ocorreu uma exceção ao persistir a instância.', 
        self::CONSTRAINT_PERIODO_IGUAL => 'A componente curricular deve ter periodo maior que o seu pré-requisito.',
        self::CONSTRAINT_PPC_DIFERENTE => 'As componentes curriculares devem pertencer ao mesmo Projeto Pedagógico de Curso.',
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
            case self::CONSTRAINT_NOT_NULL:
            case self::CONSTRAINT_PERIODO_IGUAL:
            case self::CONSTRAINT_PPC_DIFERENTE:                
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
    * @param $violation {Array} Array com categorias como chave e array de strings com todos os subpathes como valor.
    * @return json
    */
    public function getMultipleErrorMessages($violations = [])
    {
        $messages = [];
        
        foreach ($violations as $content ) 
        {
            $message = $this->generateMessage($content[0],$content[1]);
            array_push($messages,$message);
        }
        
        $errorArray = ["error" => $messages];        
        return json_encode($errorArray);
    }


    public function generateArrayDependencia($curso, $codCompCurric, $nomeCompCurric, $codPreRequisito, $nomePreRequisito)
    {
        $dependenciaArray = [ 
                                "Curso"=> $curso, 
                                "codCompCurric"=> $codCompCurric, 
                                "nomeCompCurric"=> $nomeCompCurric, 
                                "codPreRequisito"=> $codPreRequisito, 
                                "nomePreRequisito"=> $nomePreRequisito
                            ];

       return json_encode($dependenciaArray);
    }

    // Testes
    // Teste de sucesso
    // Metodos GET 

    public function testGetDependenciantnt()
    {
        $response = $this->http->request('GET', 'dependencias/7/1', ['http_errors' => FALSE] );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
       
        $dependenciaArray= $this->generateArrayDependencia("Ciência da Computação",
                                                            7, "Fundamentos de Mecânica Clássica", 
                                                            1, "Cálculo I");

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($dependenciaArray, $contentBody);
    }

    public function testGetAllDependenciantnt()
    {
        $response = $this->http->request('GET', 'dependencias', ['http_errors' => FALSE] );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = json_decode($response->getBody()->getContents());

        $dependenciaArray=$this->generateArrayDependencia("Ciência da Computação",
                                                          7, "Fundamentos de Mecânica Clássica", 
                                                          1, "Cálculo I");
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertEquals($dependenciaArray,json_encode($contentBody[0]));
    }

    public function testGetAllDependenciantntByIdPpc()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/1/dependencias', ['http_errors' => FALSE] );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = json_decode($response->getBody()->getContents());

        $dependenciaArray = [ "codCompCurric"=> 7, "codPreRequisito"=> 1 ];
                            
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertEquals(json_encode($dependenciaArray),json_encode($contentBody[0]));
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

    public function testPutDependenciaFirst()
    {
        $response = $this->http->request('PUT', 'dependencias/6/1',[ 'json' => ['codCompCurric' => 18,
        'codPreRequisito' => 2], 'http_errors' => FALSE]);
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::UPDATED);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutDependenciaSecond()
    {
        $response = $this->http->request('PUT', 'dependencias/6/1',[ 'json' => ['codCompCurric' => 19], 
                                         'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::UPDATED);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }
    
    public function testPutDependenciaThird()
    {
        $response = $this->http->request('PUT', 'dependencias/15/2',[ 'json' => ['codPreRequisito' => 25], 
        'http_errors' => FALSE]);
        
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::UPDATED);
        
        $this->assertEquals(200, $response->getStatusCode());
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

    //Teste de instâncias não encontradas
    
    public function testGetDependenciaNaontnt()
    {
        $response = $this->http->request('GET', 'dependencias/98/1', ['http_errors' => FALSE] );
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);
        
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    public function testPutDependenciaNaontnt()
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

    public function testDeleteDependenciaNaoExistent()
    {
        $response = $this->http->request('DELETE', 'dependencias/7/2', ['http_errors' => FALSE]);
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::NOT_FOUND);
        
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    //Teste de erros gerados por constraints de validação

    public function testPostDependenciaPeriodoIgual()
    {
        $response = $this->http->request('POST', 'dependencias',[ 'json' => ['codCompCurric' => 5,
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

    public function testPutDependenciaPpcDiferenteFirst()
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

    public function testPutDependenciaPpcDiferenteSecond()
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

    public function testPutDependenciaPpcDiferenteThird()
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

    public function testPutDependenciaPeriodoIgualFirst()
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

    public function testPutDependenciaPeriodoigualSecond()
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

    public function testPutDependenciaPeriodoigualThird()
    {
        $response = $this->http->request('PUT', 'dependencias/17/5',['json' =>['codPreRequisito' => 16],
                                         'http_errors' => FALSE]);

        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();
        $message = $this->getStdMessage(self::CONSTRAINT_PERIODO_IGUAL, "componenteCurricular");
        
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);
    }

    // Testes de erro gerado de entradas null

    public function testPostDependenciaInputValuesNull()
    {
        $response = $this->http->request('POST','dependencias', [ 'json' => ['codCompCurric' => null,
        'codPreRequisito' => null], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [
                        [self::CONSTRAINT_NOT_NULL,'componenteCurricular'],
                        [self::CONSTRAINT_NOT_NULL,'preRequisito'] 
                     ];
        $errorArray = $this->getMultipleErrorMessages($violations);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($errorArray,$contentBody);
    }

    public function testPutDependenciaInputValuesNullFirst()
    {
        $response = $this->http->request('PUT','dependencias/7/1', [ 'json' => ['codCompCurric' => null,
        'codPreRequisito' => null], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        
        $violations = [
                        [self::CONSTRAINT_NOT_NULL,'componenteCurricular'],
                        [self::CONSTRAINT_NOT_NULL,'preRequisito'] 
                     ];
        $errorArray = $this->getMultipleErrorMessages($violations);  

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($errorArray,$contentBody);
    }

    public function testPutDependenciaInputValuesNullSecond()
    {
        $response = $this->http->request('PUT','dependencias/7/1', [ 'json' => ['codCompCurric' => null], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        $message = $this->getStdMessage(self::CONSTRAINT_NOT_NULL,"componenteCurricular");

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);         
    }

    public function testPutDependenciaInputValuesNullThird()
    {
        $response = $this->http->request('PUT','dependencias/7/1', [ 'json' => ['codPreRequisito' => null], 'http_errors' => FALSE] );
        
        $contentType = $response->getHeaders()["Content-Type"][0];
        $contentBody = $response->getBody()->getContents();        
        $message = $this->getStdMessage(self::CONSTRAINT_NOT_NULL,"preRequisito");

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
        $this->assertJsonStringEqualsJsonString($message, $contentBody);         
    }
}
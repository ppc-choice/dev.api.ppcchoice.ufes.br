<?php

use PHPUnit\Framework\TestCase;

class ProjetoPedagogicoCursoTest extends TestCase
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

    public function testGetProjetoPedagogicoCursoNaoExistente()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/40', ['http_errors' => FALSE] );

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    } 
    
    public function testGetProjetoPedagogicoCursoExistente()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso/1', ['http_errors' => FALSE] );

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);
    } 

    public function testGetAllProjetoPedagogicoCursoExistente()
    {
        $response = $this->http->request('GET', 'projetos-pedagogicos-curso', ['http_errors' => FALSE] );
        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        $this->assertInternalType('array', $contentBody);
    }

    public function testPostProjetoPedagogicoCurso()
    {
        $response = $this->http->request('POST', 'projetos-pedagogicos-curso',
        [ 'json' => [ 'dtInicioVigencia'=> '1995-01-09T00:00:00-02:00', 'dtTerminoVigencia'=> null,
        'duracao'=> 5, 'qtdPeriodos'=> 10, 'anoAprovacao'=> 1994,
        'situacao'=> 'CORRENTE', 'codCurso'=> 0], 'http_errors' => FALSE] );
        
        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        $this->assertInternalType('array', $contentBody);
    }

    public function testPostProjetoPedagogicoCursoSituacao()
    {
        $response = $this->http->request('POST', 'projetos-pedagogicos-curso',
        [ 'json' => [ 'dtInicioVigencia'=> '1995-01-09T00:00:00-02:00', 'dtTerminoVigencia'=> null,
        'duracao'=> 5, 'qtdPeriodos'=> 10, 'anoAprovacao'=> 1994,
        'situacao'=> 'CORRENTE', 'codCurso'=> 1], 'http_errors' => FALSE] );
        
        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        $this->assertInternalType('array', $contentBody);
    }

    public function testPostProjetoPedagogicoCursoDtVigenciaVazia()
    {
        $response = $this->http->request('POST', 'projetos-pedagogicos-curso',[ 'json' => [ 'dtInicioVigencia'=> '2000-01-09T00:00:00-02:00', 'dtTerminoVigencia'=> '2000-01-09T00:00:00-02:00', 'chTotalDisciplinaOpt'=> 300, 'chTotalDisciplinaOb'=> 3030,
        'chTotalAtividadeExt'=> 0, 'chTotalAtividadeCmplt'=> 180, 'chTotalProjetoConclusao'=> 120,
        'chTotalEstagio'=> 300, 'duracao'=> 5, 'qtdPeriodos'=> 10, 'anoAprovacao'=> 2015,
        'situacao'=> 'CorRente', 'codCurso'=> 0], 'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        $this->assertInternalType('array', $contentBody);
           $this->assertEquals("Entities\\ProjetoPedagogicoCurso.dtTerminoVigencia:    Projeto pedagógico de curso com situação corrente e ativo-anterior a data de termino de vigência deve ser nulo.", $contentBody["error"][0]);
    }

    public function testPostProjetoPedagogicoCursoDtVaziaInativo()
    {
        $response = $this->http->request('POST', 'projetos-pedagogicos-curso',[ 'json' => [ 'dtInicioVigencia'=> '2000-01-09T00:00:00-02:00', 'dtTerminoVigencia'=> null, 'chTotalDisciplinaOpt'=> 300, 'chTotalDisciplinaOb'=> 3030,
        'chTotalAtividadeExt'=> 0, 'chTotalAtividadeCmplt'=> 180, 'chTotalProjetoConclusao'=> 120,
        'chTotalEstagio'=> 300, 'duracao'=> 5, 'qtdPeriodos'=> 10, 'anoAprovacao'=> 2015,
        'situacao'=> 'INATIVO', 'codCurso'=> 3], 'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        $this->assertInternalType('array', $contentBody);

        $this->assertEquals("Entities\\ProjetoPedagogicoCurso.dtTerminoVigencia:    A data de termino de vigência em projeto pedagogico de curso com situacao INATIVO não pode ser vazia.", $contentBody["error"][0]);
    }

    public function testPostProjetoPedagogicoCursoDtTerminoInativo()
    {
        $response = $this->http->request('POST', 'projetos-pedagogicos-curso',[ 'json' => [ 'dtInicioVigencia'=> '2000-01-09T00:00:00-02:00', 'dtTerminoVigencia'=> '2000-01-04T00:00:00-02:00', 'chTotalDisciplinaOpt'=> 300, 'chTotalDisciplinaOb'=> 3030,
        'chTotalAtividadeExt'=> 0, 'chTotalAtividadeCmplt'=> 180, 'chTotalProjetoConclusao'=> 120,
        'chTotalEstagio'=> 300, 'duracao'=> 5, 'qtdPeriodos'=> 10, 'anoAprovacao'=> 2015,
        'situacao'=> 'INATIVO', 'codCurso'=> 3], 'http_errors' => FALSE] );

        $this->assertEquals(400, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        $this->assertInternalType('array', $contentBody);

        $this->assertEquals("Entities\\ProjetoPedagogicoCurso.dtTerminoVigencia:    A data de termino de vigência deve ser maior que a data de inicio de vigência.", $contentBody["error"][0]);
    }

    public function testPutProjetoPedagogicoCurso()
    {
        $response = $this->http->request('PUT', 'projetos-pedagogicos-curso/1', ['http_errors' => FALSE] );
        
        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        $this->assertInternalType('array', $contentBody);
    }

    public function testPutProjetoPedagogicoCursoFalha()
    {
        $response = $this->http->request('PUT', 'projetos-pedagogicos-curso/1', ['http_errors' => FALSE] );
        
        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        $this->assertInternalType('array', $contentBody);
    }

    public function testDeleteProjetoPedagogicoCurso()
    {
        $response = $this->http->request('DELETE', 'projetos-pedagogicos-curso/31', ['http_errors' => FALSE] );
        
        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        $this->assertInternalType('array', $contentBody);
    }

    public function testDeleteProjetoPedagogicoCursoFalha()
    {
        $response = $this->http->request('DELETE', 'projetos-pedagogicos-curso/100', ['http_errors' => FALSE] );
        
        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json; charset=UTF-8", $contentType);

        $contentBody = json_decode($response->getBody()->getContents(),TRUE);
        $this->assertInternalType('array', $contentBody);
    }

}
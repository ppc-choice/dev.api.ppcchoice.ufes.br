<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class ComponenteCurricularController extends APIController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @api {get} componentes-curriculares Listar todas as componentes curriculares
     * @apiName findAll
     * @apiGroup Componente Curricular
     *
     * @apiSuccess {ComponenteCurricular[]} componentesCurriculares     Array de objetos do tipo ComponenteCurricular.
     * @apiSuccess {String}   componenteCurricular[nome]                Nome da diciplina.
     * @apiSuccess {Number}   componenteCurricular[codCompCurric]       Identificador único de componente curricular.
     * @apiSuccess {Number}   componenteCurricular[periodo]             Período da componente.
     * @apiSuccess {Number}   componenteCurricular[credito]             Crédito da componente.
     * @apiSuccess {Number}   componenteCurricular[codDepto]            Identificador único de departamento e parte do identificador único de disciplina.
     * @apiSuccess {String}   componenteCurricular[depto]               Abreviatura de departamento.
     * @apiSuccess {Number}   componenteCurricular[numDisciplina]       Número de disciplina, parte do identificador único de disciplina.
     * @apiSuccess {Number}   componenteCurricular[codPpc]              Identificador único de ppc.
     * @apiSuccess {Number}   componenteCurricular[tipo]                Tipo de componente curricular.
     * @apiSuccess {Number}   componenteCurricular[top]                 Posição Vertical da componente na grade curricular.
     * @apiSuccess {Number}   componenteCurricular[left]                Posição Horizontal da componente na grade curricular.
     * @apiSuccess {Number}   componenteCurricular[posicaoColuna]       Posição da componente na coluna da grade curricular.
     * 
     * @apiError {String[]} error Entities\\ComponenteCurricular:    Instância não encontrada.
     */
    public function findAll()
    {
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
            'methods' => array('GET'),
        ));

        $colecaoCompCurric = $this->entityManager->getRepository('Entities\ComponenteCurricular')->findAll();

        if (!empty($colecaoCompCurric)) {
            $this->apiReturn(
                $colecaoCompCurric,
                self::HTTP_OK
            );
        } else {
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
            ), self::HTTP_NOT_FOUND);
        }
    }
    /**
     * @api {get} projetos-pedagogicos-curso/:codPpc/componentes-curriculares Listar todas componentes curriculares de um PPC, ordenados por período e componente curricular
     * @apiName findByCodPpc
     * @apiGroup Componente Curricular
     * 
     * @apiParam {Number} codPpc Identificador único de projeto pedagógico de curso (PPC).
     * 
     * @apiSuccess {ComponenteCurricular[]} componentesCurriculares     Array de objetos do tipo ComponenteCurricular.
     * @apiSuccess {String}   componenteCurricular[nome]                Nome da diciplina.
     * @apiSuccess {Number}   componenteCurricular[codCompCurric]       Identificador único de componente curricular.
     * @apiSuccess {Number}   componenteCurricular[periodo]             Período da componente.
     * @apiSuccess {Number}   componenteCurricular[credito]             Crédito da componente.
     * @apiSuccess {Number}   componenteCurricular[codDepto]            Identificador único de departamento e parte do identificador único de disciplina.
     * @apiSuccess {String}   componenteCurricular[depto]               Abreviatura de departamento.
     * @apiSuccess {Number}   componenteCurricular[numDisciplina]       Número de disciplina, parte do identificador único de disciplina.
     * @apiSuccess {Number}   componenteCurricular[codPpc]              Identificador único de ppc.
     * @apiSuccess {Number}   componenteCurricular[tipo]                Tipo de componente curricular.
     * @apiSuccess {Number}   componenteCurricular[top]                 Posição Vertical da componente na grade curricular.
     * @apiSuccess {Number}   componenteCurricular[left]                Posição Horizontal da componente na grade curricular.
     * @apiSuccess {Number}   componenteCurricular[posicaoColuna]       Posição da componente na coluna da grade curricular
     *  
     * @apiError {String[]} error  Entities\\ComponenteCurricular:    Instância não encontrada.
     */
    public function findByCodPpc($codPpc)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'),
        ));

        $colecaoCompCurric = $this->entityManager->getRepository('Entities\ComponenteCurricular')->findByCodPpc($codPpc);

        if (!empty($colecaoCompCurric)) {
            $asNode = strtolower($this->input->get('asNode'));

            if ($asNode === "true") {
                $colecaoNode = array_map(function ($compCurric) {
                    $node = array_merge($compCurric, array('id' => $compCurric['codCompCurric']));
                    return $node;
                }, $colecaoCompCurric);

                $this->apiReturn(
                    $colecaoNode,
                    self::HTTP_OK
                );
            } else {
                $this->apiReturn(
                    $colecaoCompCurric,
                    self::HTTP_OK
                );
            }
        } else {
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {get} componentes-curriculares/:codCompCurric Listar dados de uma componente curricular
     * @apiName findByCodCompCurric
     * @apiGroup Componente Curricular
     * 
     * @apiParam {Number} codCompCurric     Identificador único de componente curricular.
     *
     * @apiSuccess {String} nome            Nome da disciplina.
     * @apiSuccess {Number} codCompCurric   Identificador único de componente curricular.
     * @apiSuccess {Number} ch Carga        horária da componente curricular.
     * @apiSuccess {Number} periodo         Período da componente curricular.
     * @apiSuccess {Number} credito         Crédito da componente curricular.
     * @apiSuccess {Number} tipo            Tipo de componente curricular.
     * @apiSuccess {Number} codDepto        Identificador único de departamento e parte do identificador único de disciplina.
     * @apiSuccess {String} depto           Abreviatura de departamento.
     * @apiSuccess {Number} numDisciplina   Número da disciplina, parte do identificador único de disciplina.
     * @apiSuccess {Number} codPpc          Identificador único de ppc.
     * @apiSuccess {Number} top                 Posição Vertical da componente na grade curricular.
     * @apiSuccess {Number} left                Posição Horizontal da componente na grade curricular.
     * @apiSuccess {Number} posicaoColuna       Posição da componente na coluna da grade curricular
     * 
     * @apiError {String[]} error           Entities\\ComponenteCurricular:    Instância não encontrada.
     */
    public function findByCodCompCurric($codCompCurric)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'),
        ));


        $componenteCurricular = $this->entityManager->getRepository('Entities\ComponenteCurricular')->findByCodCompCurric($codCompCurric);

        if (!empty($componenteCurricular)) {
            $this->apiReturn(
                $componenteCurricular,
                self::HTTP_OK
            );
        } else {
            $this->apiReturn(array(
                'error' =>  $this->getApiMessage(STD_MSG_NOT_FOUND),
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {get} componentes-curriculares/tipos Listar tipos definidos de componente curricular
     * @apiName findTipos
     * @apiGroup Componente Curricular
     * 
     * @apiSuccess {String[]} tipos    Array de String com os tipos definidos como constantes.
     */
    public function findTipos()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'),
        ));

        $tipos = array(
            TP_CC_OBRIGATORIA,
            TP_CC_OPTATIVA,
            TP_CC_ESTAGIO,
            TP_CC_ATV_CMPLT,
            TP_CC_ATV_EXT,
            TP_CC_PROJ_CONC
        );


        $this->apiReturn(
            $tipos,
            self::HTTP_OK
        );
    }

    /**
     * @api {post} componentes-curriculares Criar Componente Curricular
     * @apiName create
     * @apiGroup Componente Curricular
     * 
     * @apiParam (Request Body/JSON) {Number}   periodo  Período da componente.
     * @apiParam (Request Body/JSON) {Number}   credito  Crédito da componente.
     * @apiParam (Request Body/JSON) {String = "OBRIGATORIA", "OPTATIVA", "ESTAGIO", "ATIVIDADE COMPLEMENTAR", "ATIVIDADE EXTENSAO", "PROJETO CONCLUSAO"} tipo  Tipo da componente.
     * @apiParam (Request Body/JSON) {Number}   codDepto  Identificador único de departamento e parte do identificador único de disciplina.
     * @apiParam (Request Body/JSON) {Number}   numDisciplina  Número da disicplina, parte do identificador único de disciplina.
     * @apiParam (Request Body/JSON) {Number}   codPpc  Identificador único de ppc.
     * 
     * @apiSuccess {String[]} message   Entities\\ComponenteCurricular: Instância criada com sucesso.
     * 
     * @apiError {String[]} error       Campo obrigatório não informado ou contém valor inválido.
     * @apiError {String[]} error       Ocorreu uma exceção ao persistir a instância.
     */
    public function create()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('POST'),
            'requireAuthorization' => TRUE,
        ));

        $payload = $this->getBodyRequest();
        $componenteCurricular = new Entities\ComponenteCurricular();

        if (isset($payload['periodo'])) $componenteCurricular->setPeriodo($payload['periodo']);

        if (isset($payload['credito'])) $componenteCurricular->setCredito($payload['credito']);

        if (isset($payload['tipo'])) $componenteCurricular->setTipo($payload['tipo']);

        if (isset($payload['numDisciplina'], $payload['codDepto'])) {
            $disciplina = $this->entityManager->find(
                'Entities\Disciplina',
                array('numDisciplina' => $payload['numDisciplina'], 'codDepto' => $payload['codDepto'])
            );
            $componenteCurricular->setDisciplina($disciplina);
        }

        if (isset($payload['codPpc'])) {
            $ppc =  $this->entityManager->find('Entities\ProjetoPedagogicoCurso', $payload['codPpc']);
            $componenteCurricular->setPpc($ppc);
        }

        if (isset($payload['styleTop'])) {
            $componenteCurricular->setStyleTop($payload['styleTop']);
        }

        if (isset($payload['styleLeft'])) {
            $componenteCurricular->setStyleLeft($payload['styleLeft']);
        }

        if (isset($payload['posicaoColuna'])) {
            $componenteCurricular->setPosicaoColuna($payload['posicaoColuna']);
        }

        $componenteCurricular->setCodCompCurric($this->uniqIdV2());
        $constraints = $this->validator->validate($componenteCurricular);

        if ($constraints->success()) {
            try {
                $this->entityManager->persist($componenteCurricular);
                $this->entityManager->flush();

                $this->apiReturn(array(
                    'message' => $this->getApiMessage(STD_MSG_CREATED),
                ), self::HTTP_OK);
            } catch (\Exception $e) {
                $this->apiReturn(array(
                    // 'error' => $this->getApiMessage(STD_MSG_EXCEPTION)
                    'error' => $e->getMessage()
                ), self::HTTP_BAD_REQUEST);
            }
        } else {
            $this->apiReturn(array(
                'error' => $constraints->messageArray(),
            ), self::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @api {put} componentes-curriculares/:codCompCurric Atualizar Componente Curricular
     * @apiName update
     * @apiGroup Componente Curricular
     * 
     * @apiParam {Number} codCompCurric                         Identificador único de componente curricular.
     * @apiParam (Request Body/JSON) {Number} [periodo]         Período da componente.
     * @apiParam (Request Body/JSON) {Number} [credito]         Crédito da componente.
     * @apiParam (Request Body/JSON) {String = "OBRIGATORIA", "OPTATIVA", "ESTAGIO", "ATIVIDADE COMPLEMENTAR", "ATIVIDADE EXTENSAO", "PROJETO CONCLUSAO"} [tipo]  Tipo da componente.
     * @apiParam (Request Body/JSON) {Number} [codDepto]        Identificador único de departamento.
     * @apiParam (Request Body/JSON) {Number} [numDisciplina]   Número da disciplina, parte do idenficador único de disciplina.
     * @apiParam (Request Body/JSON) {Number} [codPpc]          Identificador único de ppc.
     * 
     * @apiSuccess {String[]} message  Entities\\ComponenteCurricular: Instância atualizada com sucesso.
     * 
     * @apiError {String[]} error Entities\\ComponenteCurricular:    Instância não encontrada.
     * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
     * @apiError {String[]} error Ocorreu uma exceção ao persistir a instância.
     */
    public function update($codCompCurric)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('PUT'),
            'requireAuthorization' => TRUE,
        ));

        $payload = $this->getBodyRequest();
        $componenteCurricular = $this->entityManager->find('Entities\ComponenteCurricular', $codCompCurric);

        if (!is_null($componenteCurricular)) {
            if (array_key_exists('codPpc', $payload)) {
                if (isset($payload['codPpc'])) {
                    $ppc = $this->entityManager->find('Entities\ProjetoPedagogicoCurso', $payload['codPpc']);
                } else {
                    $ppc = null;
                }
                $componenteCurricular->setPpc($ppc);
            }

            if (array_key_exists('numDisciplina', $payload) && array_key_exists('codDepto', $payload)) {
                if (isset($payload['numDisciplina'], $payload['codDepto'])) {
                    $disciplina = $this->entityManager->find(
                        'Entities\Disciplina',
                        array('numDisciplina' =>  $payload['numDisciplina'], 'codDepto' =>  $payload['codDepto'])
                    );
                } else {
                    $disciplina = null;
                }
                $componenteCurricular->setDisciplina($disciplina);
            }

            if (array_key_exists('periodo', $payload)) {
                $componenteCurricular->setPeriodo($payload['periodo']);
            }

            if (array_key_exists('credito', $payload)) {
                $componenteCurricular->setCredito($payload['credito']);
            }

            if (array_key_exists('tipo', $payload)) {
                $componenteCurricular->setTipo($payload['tipo']);
            }

            if (array_key_exists('styleTop', $payload)) {
                $componenteCurricular->setStyleTop($payload['styleTop']);
            }

            if (array_key_exists('styleLeft', $payload)) {
                $componenteCurricular->setStyleLeft($payload['styleLeft']);
            }

            if (array_key_exists('posicaoColuna', $payload)) {
                $componenteCurricular->setPosicaoColuna($payload['posicaoColuna']);
            }

            $constraints = $this->validator->validate($componenteCurricular);

            if ($constraints->success()) {
                try {
                    $this->entityManager->merge($componenteCurricular);
                    $this->entityManager->flush();

                    $this->apiReturn(array(
                        'message' => $this->getApiMessage(STD_MSG_UPDATED),
                    ), self::HTTP_OK);
                } catch (\Exception $e) {
                    $this->apiReturn(array(
                        'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
                    ), self::HTTP_BAD_REQUEST);
                }
            } else {
                $this->apiReturn(array(
                    'error' => $constraints->messageArray(),
                ), self::HTTP_BAD_REQUEST);
            }
        } else {
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {delete} componentes-curriculares/:codCompCurric Excluir Componente Curricular
     * @apiName delete
     * @apiGroup Componente Curricular
     * 
     * @apiParam {Number} codCompCurric     Identificador único de componente curricular.
     * 
     * @apiSuccess {String[]} message       Entities\\ComponenteCurricular: Instância deletada com sucesso.
     * 
     * @apiError {String[]} error           Entities\\ComponenteCurricular:    Instância não encontrada.
     * @apiError {String[]} error           Campo obrigatório não informado ou contém valor inválido.
     * @apiError {String[]} error           Ocorreu uma exceção ao persistir a instância.
     */
    public function delete($codCompCurric)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('DELETE'),
            'requireAuthorization' => TRUE,
        ));

        $componenteCurricular = $this->entityManager->find('Entities\ComponenteCurricular', $codCompCurric);

        if (!is_null($componenteCurricular)) {
            try {
                $this->entityManager->remove($componenteCurricular);
                $this->entityManager->flush();

                $this->apiReturn(array(
                    'message' => $this->getApiMessage(STD_MSG_DELETED),
                ), self::HTTP_OK);
            } catch (\Exception $e) {
                $this->apiReturn(array(
                    'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
                ), self::HTTP_BAD_REQUEST);
            }
        } else {
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
            ), self::HTTP_NOT_FOUND);
        }
    }
}

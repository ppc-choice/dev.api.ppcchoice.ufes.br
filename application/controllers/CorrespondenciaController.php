<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class CorrespondenciaController extends APIController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @api {get} correspondencias Listar todas as correspondências de todas as componentes curriculares.
     * @apiName findAll
     * @apiGroup Correspondência
     *
     * @apiSuccess {Correspondencia[]}   correspondencia        Array de objetos do tipo Correspondência.
     * @apiSuccess {Number}   correspondencia[codCompCurric]    Identificador único de componente curricular.
     * @apiSuccess {String}   correspondencia[depto]            Abreviatura de departamento.
     * @apiSuccess {Number}   correspondencia[numDisciplina]    Número de disciplina, parte do identificador único de disciplina.
     * @apiSuccess {String}   correspondencia[nomeDisciplina]   Nome de disciplina
     * @apiSuccess {Number}   correspondencia[codCompCurricCorresp]   Identificador único de componente curricular.
     * @apiSuccess {String}   correspondencia[deptoDisciplinaCorresp] Abreviatura de departamento.
     * @apiSuccess {Number}   correspondencia[numDisciplinaCorresp] Número de disciplina, parte do identificador único de disciplina.
     * @apiSuccess {String}   correspondencia[nomeDisciplinaCorresp] Nome de disciplina
     * @apiSuccess {Number}   correspondencia[percentual] Percentual de correspondência entre componentes.
     * 
     * 
     * @apiError {String[]} error Entities\\Correspondencia:    Instância não encontrada.
     */
    public function findAll()
    {
        header("Access-Control-Allow-Origin: *");
        $this->_apiConfig(array(
            'methods' => array('GET'),
        ));

        $colecaoCorrespondencia = $this->entityManager->getRepository('Entities\Correspondencia')->findAll();

        if (!empty($colecaoCorrespondencia)) {
            $this->apiReturn(
                $colecaoCorrespondencia,
                self::HTTP_OK
            );
        } else {
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {get} projetos-pedagogicos-curso/:codPpcAtual/correspondencias/:codPpcAlvo Listar todas as relações de correspondência entre os cursos referidos
     * @apiName findAllByCodPpc
     * @apiGroup Correspondência
     * 
     * @apiParam {Number} codPpcAtual   Identificador único do ppc atual.
     * @apiParam {Number} codPpcAlvo    Identificador único do ppc alvo.
     *
     * @apiSuccess {Correspondencia[]}  correspondencia                     Array de objetos do tipo Correspondência.
     * @apiSuccess {Number}             correspondencia[codCompCurric]      Identificador único de componente curricular.
     * @apiSuccess {String}             correspondencia[nomeDisciplina]     Nome de disciplina
     * @apiSuccess {String}             correspondencia[nomeDisciplinaCorresp] Nome de disciplina
     * @apiSuccess {Number}             componenteCurricular[tipoCompCurric]          Tipo de componente curricular.
     * @apiSuccess {Number}             componenteCurricular[tipoCompCurricCorresp]   Tipo de componente curricular.
     * @apiSuccess {Number}             componenteCurricular[chDisciplina]   Carga Horária de disciplina.
     * @apiSuccess {Number}             componenteCurricular[chDisciplinaCorresp]   Carga Horária de disciplina.
     * @apiSuccess {Number}             correspondencia[codCompCorresp]     Identificador único de componente curricular.
     * @apiSuccess {Number}             correspondencia[percentual]         Percentual de correspondência entre componentes.
     * 
     * @apiError {String[]} error       Entities\\Correspondencia:    Instância não encontrada.
     */
    public function findAllByCodPpc($codPpcAtual, $codPpcAlvo)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'),
        ));

        $colecaoCorrespondencia = $this->entityManager->getRepository('Entities\Correspondencia')->findAllByCodPpc($codPpcAtual, $codPpcAlvo);

        if (!empty($colecaoCorrespondencia)) {
            $this->apiReturn(
                $colecaoCorrespondencia,
                self::HTTP_OK
            );
        } else {
            $this->apiReturn(
                array(
                    'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
                ),
                self::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @api {get} componentes-curriculares/:codCompCurric/correspondencias/:codCompCorresp Listar as correspondências de uma componente curricular
     * @apiName findByCodCompCurric
     * @apiGroup Correspondência
     * 
     * @apiParam {Number}   codCompCurric     Identificador único de componente curricular.
     * @apiParam {Number}   codCompCorresp    Identificador único de componente curricular.
     *
     * @apiSuccess {String} nomeDisciplina          Nome de disciplina.
     * @apiSuccess {Number} codCompCurric           Identificador único de componente curricular.
     * @apiSuccess {Number} numDisciplina           Número de disciplina, parte do identificador único de disciplina.
     * @apiSuccess {String} nomeDisciplinaCorresp   Nome de disciplina.
     * @apiSuccess {Number} codCompCorresp          Identificador único de componente curricular.
     * @apiSuccess {Number} numDisciplinaCorresp    Número de disciplina, parte do identificador único de disciplina.
     * @apiSuccess {Number} percentual              Percentual de correspondência entre componentes.
     * 
     * @apiError {String[]} error   Entities\\Correspondencia:    Instância não encontrada.
     */
    public function findByCodCompCurric($codCompCurric, $codCompCorresp)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('GET'),
        ));

        $colecaoCorrespondencia = $this->entityManager->getRepository('Entities\Correspondencia')->findByCodCompCurric($codCompCurric, $codCompCorresp);

        if (!empty($colecaoCorrespondencia)) {
            $this->apiReturn(
                $colecaoCorrespondencia,
                self::HTTP_OK
            );
        } else {
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {post} correspondencias Criar correspondência
     * @apiName create
     * @apiGroup Correspondência
     * 
     * @apiParam (Request Body/JSON) {Number}       codCompCurric           Identificador único de componente curricular.
     * @apiParam (Request Body/JSON) {Number}       codCompCurricCorresp    Identificador único de componente curricular.
     * @apiParam (Request Body/JSON) {Number}       percentual              Percentual de correspondência entre componentes.
     * 
     * 
     * @apiSuccess {String[]}   message     Entities\\Correspondencia: Instância criada com sucesso.
     * 
     * @apiError {String[]}     error       Campo obrigatório não informado ou contém valor inválido.
     * @apiError {String[]}     error       Ocorreu uma exceção ao persistir a instância.
     */
    public function create()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('POST'),
            'requireAuthorization' => TRUE,
        ));

        $payload = $this->getBodyRequest();
        $correspondencia = new Entities\Correspondencia();

        if (isset($payload['codCompCurric'])) {
            $componenteCurricular = $this->entityManager->find('Entities\ComponenteCurricular', $payload['codCompCurric']);
            if (!is_null($componenteCurricular)) $correspondencia->setComponenteCurricular($componenteCurricular);
        }

        if (isset($payload['codCompCurricCorresp'])) {
            $componenteCurricularCorresp = $this->entityManager->find('Entities\ComponenteCurricular', $payload['codCompCurricCorresp']);
            if (!is_null($componenteCurricularCorresp)) $correspondencia->setComponenteCurricularCorresp($componenteCurricularCorresp);
        }

        if (isset($payload['percentual'])) $correspondencia->setPercentual($payload['percentual']);

        $constraints = $this->validator->validate($correspondencia);

        if ($constraints->success()) {
            try {
                $this->entityManager->persist($correspondencia);
                $this->entityManager->flush();

                $this->apiReturn(array(
                    'message' => $this->getApiMessage(STD_MSG_CREATED),
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
    }

    /**
     * @api {put} correspondencia/:codCompCurric/:codCompCorresp Atualizar Correspondência
     * @apiName update
     * @apiGroup Correspondência
     * 
     * @apiParam {Number} codCompCurric         Identificador único de componente curricular.
     * @apiParam {Number} codCompCorresp        Identificador único de componente curricular.
     * 
     * @apiParam (Request Body/JSON) {Number} [codCompCurric]           Identificador único de componente curricular.
     * @apiParam (Request Body/JSON) {Number} [codCompCurricCorresp]    Identificador único de componente curricular.
     * @apiParam (Request Body/JSON) {Number} [percentual]              Percentual de correspondência entre componentes.
     * 
     * @apiSuccess {String[]}   message     Entities\\Correspondencia: Instância atualizada com sucesso.
     * 
     * @apiError {String[]}     error       Entities\\Correspondencia:    Instância não encontrada.
     * @apiError {String[]}     error       Campo obrigatório não informado ou contém valor inválido.
     * @apiError {String[]}     error       Ocorreu uma exceção ao persistir a instância.
     */
    public function update($codCompCurric, $codCompCorresp)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('PUT'),
            'requireAuthorization' => TRUE,
        ));

        $payload = $this->getBodyRequest();
        $correspondencia = $this->entityManager->find(
            'Entities\Correspondencia',
            array('componenteCurricular' => $codCompCurric, 'componenteCurricularCorresp' => $codCompCorresp)
        );

        if (!is_null($correspondencia)) {
            if (array_key_exists('codCompCurric', $payload)) {
                if (isset($payload['codCompCurric'])) {
                    $componenteCurricular = $this->entityManager->find('Entities\ComponenteCurricular', $payload['codCompCurric']);
                } else {
                    $componenteCurricular = null;
                }
                $correspondencia->setComponenteCurricular($componenteCurricular);
            }

            if (array_key_exists('codCompCurricCorresp', $payload)) {
                if (isset($payload['codCompCurricCorresp'])) {
                    $componenteCurricularCorresp = $this->entityManager->find('Entities\ComponenteCurricular', $payload['codCompCurricCorresp']);
                } else {
                    $componenteCurricularCorresp = null;
                }
                $correspondencia->setComponenteCurricularCorresp($componenteCurricularCorresp);
            }

            if (array_key_exists('percentual', $payload)) $correspondencia->setPercentual($payload['percentual']);

            $constraints = $this->validator->validate($correspondencia);

            if ($constraints->success()) {
                try {
                    $this->entityManager->merge($correspondencia);
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
     * @api {delete} correspondencias/:codCompCurric/:codCompCorresp Excluir Correspondência
     * @apiName delete
     * @apiGroup Correspondência
     * 
     * @apiParam {Number}       codCompCurric   Identificador único de componente curricular.
     * @apiParam {Number}       codCompCorresp  Identificador único de componente curricular.
     * 
     * @apiSuccess {String[]}   message         Entities\\Correspondencia: Instância deletada com sucesso.
     * 
     * @apiError {String[]}     error           Entities\\Correspondencia:    Instância não encontrada.
     * @apiError {String[]}     error           Campo obrigatório não informado ou contém valor inválido.
     * @apiError {String[]}     error           Ocorreu uma exceção ao persistir a instância.
     */
    public function delete($codCompCurric, $codCompCorresp)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('DELETE'),
            'requireAuthorization' => TRUE,
        ));
        $correspondencia = $this->entityManager->find(
            'Entities\Correspondencia',
            array('componenteCurricular' => $codCompCurric, 'componenteCurricularCorresp' => $codCompCorresp)
        );

        if (!is_null($correspondencia)) {
            try {
                $this->entityManager->remove($correspondencia);
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

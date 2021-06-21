<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class DisciplinaController extends APIController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @api {get} disciplinas Listar dados de todas as disciplinas
     * @apiName findAll
     * @apiGroup Disciplina
     *
     * @apiSuccess {Disciplina[]} disciplina Array de objetos do tipo Disciplina.
     * @apiSuccess {Number} disciplina[numDisciplina] Identificador único da disciplina.
     * @apiSuccess {String} disciplina[nome] Nome da disciplina.
     * @apiSuccess {Number} disciplina[ch] Carga horária da disciplina.
     * @apiSuccess {Number} disciplina[codDepto] Código do departamento cujo qual a disciplina está vinculada.
     * @apiSuccess {String} disciplina[abreviaturaDepto] Abreviatura do departamento cujo qual a disciplina está vinculada.
     * 
     * @apiError {String[]} error Entities\\Disciplina: Instância não encontrada.
     */
    public function findAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));

        $colecaoDisciplina = $this->entityManager->getRepository('Entities\Disciplina')->findAll();

        if (!is_null($colecaoDisciplina)) {
            $this->apiReturn(
                $colecaoDisciplina,
                self::HTTP_OK
            );
        } else {
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {get} disciplinas/:codDepto/:numDisciplina Listar dados de uma disciplina
     * @apiName findById
     * @apiGroup Disciplina
     *
     * @apiParam {Number} numDisciplina Identificador único da disciplina.
     * @apiParam {Number} codDepto Código do departamento cujo qual a disciplina está vinculada.
     *
     * @apiSuccess {String} nome Nome da disciplina.
     * @apiSuccess {Number} ch Carga horária da disciplina.
     * @apiSuccess {String} nomeDepto Nome do departamento cujo qual a disciplina está vinculada.
     * 
     * @apiError {String[]} error Entities\\Disciplina: Instância não encontrada.
     */
    public function findById($codDepto, $numDisciplina)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));

        $disciplina = $this->entityManager->getRepository('Entities\Disciplina')->findById($numDisciplina, $codDepto);

        if (!is_null($disciplina)) {
            $this->apiReturn(
                $disciplina,
                self::HTTP_OK
            );
        } else {
            $this->apiReturn(array(
                'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
            ), self::HTTP_NOT_FOUND);
        }
    }

    /**
     * @api {post} disciplinas Criar uma disciplina
     * @apiName create
     * @apiGroup Disciplina
     *
     * @apiParam (Request Body/JSON) {Number} numDisciplina Identificador primário da disciplina.
     * @apiParam (Request Body/JSON) {String} nome Nome da disciplina.
     * @apiParam (Request Body/JSON) {Number} ch Carga horária da disciplina.
     * @apiParam (Request Body/JSON) {Number} codDepto Identificador secundário da disciplina (identificador primário do departamento que ela está vinculada).
     * 
     * @apiSuccess {String[]} message Entities\\Disciplina: Instância criada com sucesso.
     * 
     * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
     */
    public function create()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('POST'),
            'requireAuthorization' => TRUE,
        ));

        $payload = $this->getBodyRequest();
        $disciplina = new Entities\Disciplina();

        if (array_key_exists('numDisciplina', $payload))  $disciplina->setNumDisciplina($payload['numDisciplina']);
        if (array_key_exists('ch', $payload))             $disciplina->setCh($payload['ch']);
        if (array_key_exists('nome', $payload))           $disciplina->setNome($payload['nome']);

        if (isset($payload['codDepto'])) {
            $depto = $this->entityManager->find('Entities\Departamento', $payload['codDepto']);
            if (!is_null($depto)) {
                $disciplina->setDepartamento($depto);
                $disciplina->setCodDepto($payload['codDepto']);
            }
        }

        $constraints = $this->validator->validate($disciplina);

        if ($constraints->success()) {
            try {
                $this->entityManager->persist($disciplina);
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
     * @api {put} disciplinas/:codDepto/:numDisciplina Atualizar dados de uma disciplina
     * @apiName update
     * @apiGroup Disciplina
     *
     * @apiParam {Number} numDisciplina Identificador único de uma disciplina.
     * @apiParam {Number} codDepto Código do departamento cujo qual a disciplina está vinculada.
     * @apiParam (Request Body/JSON) {String} [nome] Nome da disciplina.
     * @apiParam (Request Body/JSON) {Number} [ch] Carga horária da disciplina.
     * 
     * @apiSuccess {String[]} message Entities\\Disciplina: Instância atualizada com sucesso.
     * 
     * @apiError {String[]} error Entities\\Disciplina: Instância não encontrada.
     * @apiError {String[]} error Campo obrigatório não informado ou contém valor inválido.
     */
    public function update($codDepto, $numDisciplina)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('PUT'),
            'requireAuthorization' => TRUE,
        ));

        $disciplina = $this->entityManager->find(
            'Entities\Disciplina',
            array('codDepto' => $codDepto, 'numDisciplina' => $numDisciplina)
        );
        $payload = $this->getBodyRequest();

        if (!is_null($disciplina)) {
            if (array_key_exists('nome', $payload))   $disciplina->setNome($payload['nome']);
            if (array_key_exists('ch', $payload))     $disciplina->setCh($payload['ch']);

            $constraints = $this->validator->validate($disciplina);

            if ($constraints->success()) {
                try {
                    $this->entityManager->merge($disciplina);
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
     * @api {delete} disciplinas/:codDepto/:numDisciplina Excluir uma disciplina
     * @apiName delete
     * @apiGroup Disciplina
     *
     * @apiParam {Number} numDisciplina Identificador único da disciplina.
     * @apiParam {Number} codDepto Código do departamento cujo qual a disciplina está vinculada.
     *
     * @apiSuccess {String[]} message Entities\\Disciplina: Instância removida com sucesso.
     * 
     * @apiError {String[]} error Entities\\Disciplina: Instância não encontrada.
     */
    public function delete($codDepto, $numDisciplina)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('DELETE'),
            'requireAuthorization' => TRUE,
        ));

        $disciplina = $this->entityManager->find(
            'Entities\Disciplina',
            array('codDepto' => $codDepto, 'numDisciplina' => $numDisciplina)
        );

        if (!is_null($disciplina)) {
            try {
                $this->entityManager->remove($disciplina);
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

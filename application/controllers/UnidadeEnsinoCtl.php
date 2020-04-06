<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class UnidadeEnsinoCtl extends API_Controller
{
    /**
     * @api {get} unidades-ensino/ Listar todas as Unidades de Ensino
     * @apiName getAll
     * @apiGroup Unidades de Ensino
     *
     *
     * @apiSuccess {String} nome Nome da Unidade de Ensino.
     * @apiSuccess {Number} codUnEnsino Código da Unidade de Ensino.
     * @apiSuccess {String} cnpj CNPJ da Unidade de Ensino.
     * @apiSuccess {Number} codIes Código da Instutuição de Ensino Superior que a Unidade de Ensino pertence.
     */
    public function getAll()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));


        $qb = $this->entity_manager->
            createQueryBuilder()
            ->select('u.codUnEnsino', 'i.codIes', 'u.nome', 'u.cnpj')
            ->from('Entities\UnidadeEnsino', 'u')
            ->innerJoin('u.ies', 'i')
            ->getQuery();

        $r = $qb->getResult();
        $result = $this->doctrine_to_array($r);

        if ( !is_null($result) ){
            $this->api_return(array(
                'status' => true,
                'result' => $result,
            ), 200);
        } else {
            $this->api_return(array(
                'status' => false,
                'message' => 'Não Encontrado',
            ), 200);
        }
    }

    /**
     * @api {get} unidades-ensino/:codUnidadeEnsino Obter Unidade de Ensino pelo códigoda dela
     * @apiName getById
     * @apiGroup Unidades de Ensino
     *
     * @apiParam {Number} codUnidadeEnsino Codigo unico de uma Unidade de Ensino.
     *
     * @apiSuccess {String} nome Nome da Unidade de Ensino.
     * @apiSuccess {Number} codUnEnsino Código da Unidade de Ensino.
     * @apiSuccess {String} cnpj CNPJ da Unidade de Ensino.
     * @apiSuccess {Number} codIes Código da Instutuição de Ensino Superior que a Unidade de Ensino pertence.
     */
    public function getById($codUnidadeEnsino)
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));


        $qb = $this->entity_manager->
            createQueryBuilder()
            ->select('i.codIes, u.nome, u.cnpj')
            ->from('Entities\UnidadeEnsino', 'u')
            ->innerJoin('u.ies', 'i')
            ->where('u.codUnEnsino = ' . $codUnidadeEnsino)
            ->getQuery();

        $r = $qb->getResult();
        $result = $this->doctrine_to_array($r);

        if ( !is_null($result) ){
            $this->api_return(array(
                'status' => true,
                'result' => $result,
            ), 200);
        } else {
            $this->api_return(array(
                'status' => false,
                'message' => 'Não Encontrado',
            ), 200);
        }
    }
}
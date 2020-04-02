<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class UnidadeEnsinoCtl extends API_Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function listUes($codUnEnsino)
    {
        $ues = $this->entity_manager->//find('Entities\UnidadeEnsino', $codUnEnsino);
            createQueryBuilder()
            ->select('u.nome', 'u.cnpj')
            ->from('Entities\UnidadeEnsino', 'u')
            ->where('u.codUnEnsino = ' . $codUnEnsino)
            ->getQuery()->getResult();
        
        //find('Entities\UnidadeEnsino', $codUnEnsino);

        /*
                'SELECT u.nome, u.cnpj
                FROM Entities\UnidadeEnsino u
                WHERE u.codUnEnsino = ' . $codUnEnsino
            )
            ->getResult();
        */

        $this->_apiconfig(array(
            'methods' => array('GET'),
        ));

        $this->api_return(array(
            'status' => true,
            'result' => $this->doctrine_to_array($ues),
        ), 200);
    }
}
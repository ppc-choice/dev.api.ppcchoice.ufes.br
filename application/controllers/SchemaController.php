<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class SchemaController extends APIController
{

    public function create()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('POST', 'PUT'),
            'requireAuthorization' => TRUE,
        ));

        $folder = 'database/';
        $payload = $this->getBodyRequest();

        if (array_key_exists('arquivo', $payload)) {
            $fileName = $payload['arquivo'];
        } else {
            $fileName = 'arquivo.sql';
        }

        try {

            $path = $folder . '/' . $fileName;

            if (file_exists($path)) {

                $this->runQueryFile($path);

                $this->apiReturn(array(
                    'message' => 'Success',
                ), self::HTTP_OK);
            } else {
                $this->apiReturn(array(
                    'error' => 'file not exists',
                ), self::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            $this->apiReturn(array(
                'error' => $e->getMessage(),
            ), self::HTTP_BAD_REQUEST);
        }
    }

    public function delete()
    {
        header("Access-Control-Allow-Origin: *");

        $this->_apiConfig(array(
            'methods' => array('DELETE'),
            'requireAuthorization' => TRUE,
        ));

        $folder = 'database/';

        try {
            $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');

            $tables = $this->db->list_tables();

            $this->db->trans_start();
            foreach ($tables as $table) {
                $this->db->query('DROP TABLE ' . $table . ';');
            }
            $this->db->trans_complete();

            $this->apiReturn(array(
                'message' => 'Success',
            ), self::HTTP_OK);

            $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
        } catch (Exception $e) {
            $this->apiReturn(array(
                'error' => $e->getMessage(),
            ), self::HTTP_BAD_REQUEST);
        }
    }

    private function runQueryFile($path)
    {
        $sql = file_get_contents($path);
        $sqls = explode(';', $sql);
        array_pop($sqls);

        $this->db->trans_start();
        foreach ($sqls as $statement) {
            $statment = $statement . ";";
            $this->db->query($statement);
        }
        $this->db->trans_complete();
    }

    public function getUuid()
    {
        $this->apiReturn(array(
            'uuid' => $this->uniqIdV2()
        ), self::HTTP_OK);
    }
}

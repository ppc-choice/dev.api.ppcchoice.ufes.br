<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class UsuarioController extends API_Controller {

	/**
	 * @api {get} usuarios/:id Solicitar dados de um usuário
	 * @apiName findById
	 * @apiGroup Usuario
	 *
	 * @apiParam {Number} id Identificador único do usuário requerido.
	 *
	 * @apiSuccess {Number} codUsuario Identificador único do usuário.
	 * @apiSuccess {String} email  Endereço de e-mail do usuário.
	 * @apiSuccess {String} nome   Nome do usuário.
	 * @apiSuccess {String} papel  Categoria que define o acesso administrativo do usuário
	 * @apiSuccess {String} senha  Senha de acesso encriptada.
	 * @apiSuccess {DateTime} dtUltimoAcesso  Data do último acesso realizado pelo usuário.
	 * @apiSuccess {JSON} conjuntoSelecao Conjunto de componente curriculares selecionadas pelo usuário.
	 * @apiExample {curl} Exemplo:
	 *     curl -i http://dev.api.ppcchoice.ufes.br/usuarios/1
	 * @apiSuccessExample {JSON} Success-Response:
	 * HTTP/1.1 200 OK
	 * {
	 *	"codUsuario": 1,
	 *	"senha": "$2a$10$W5h77hC63g/0r17QYAmAn.YjnxjZNQHXkWgrhxCNJiFXoebL4Bhra",
	 *	"nome": "Elyabe",
	 *	"dtUltimoAcesso": "2019-01-30",
	 *	"email": "elyabe.santos@ppcchoice",
	 *	"papel": "ADMIN",
	 *	"conjuntoSelecao": null
	 * }
	 * @apiError UserNotFound O <code>id</code> não corresponde a nenhum usuário cadastrado.
	 */
	public function findById($codUsuario)
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
		$usuario = $this->entity_manager->find('Entities\Usuario',$codUsuario);
		

		if ( !is_null($usuario) ) {
			$result = $this->doctrine_to_array($usuario);	
			$this->api_return(array(
				'status' => TRUE,
				'result' => $result,
			), 200);
		} else {
			$this->api_return(array(
				'status' => FALSE,
				'message' => 'Usuário não encontrado',
			), 404);
		}
	}


	/**
	 * @api {get} usuarios Solicitar dados de todos os usuários
	 * @apiName findAll
	 * @apiGroup Usuario
	 *
	 * @apiSuccess {Number} codUsuario Identificador único do usuário.
	 * @apiSuccess {String} email  Endereço de e-mail do usuário.
	 * @apiSuccess {String} nome   Nome do usuário.
	 * @apiSuccess {String} papel  Categoria que define o acesso administrativo do usuário
	 * @apiSuccess {String} senha  Senha de acesso encriptada.
	 * @apiSuccess {DateTime} dtUltimoAcesso  Data do último acesso realizado pelo usuário.
	 * @apiSuccess {JSON} conjuntoSelecao Conjunto de componente curriculares selecionadas pelo usuário.
	 * @apiExample {curl} Exemplo:
	 *     curl -i http://dev.api.ppcchoice.ufes.br/usuarios
	 * @apiSampleRequest usuarios
	 */
	public function findAll()
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
			'methods' => array('GET'),
			// 'limit' => array(10,'ip','everyday'),
			)
		);
		
		$usuarios = $this->entity_manager->getRepository('Entities\Usuario')->findAll();
		$result = $this->doctrine_to_array($usuarios);

		$this->api_return(array(
			'status' => TRUE,
			'result' => $result,
		), 200);
	}
}

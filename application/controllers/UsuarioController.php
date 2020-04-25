<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class UsuarioController extends API_Controller 
{

	/**
	 * @api {get} usuarios/:id Solicitar dados de um usuário
	 * @apiName findById
	 * @apiGroup Usuario
	 * @apiPermission ADMINISTRATOR
	 *
	 * @apiParam {Number} id  Identificador único do usuário requerido.
	 *
	 * @apiSuccess {Number} codUsuario Identificador único do usuário.
	 * @apiSuccess {String} email  Endereço de e-mail do usuário.
	 * @apiSuccess {String} nome   Nome do usuário.
	 * @apiSuccess {String} papel  Categoria que define o acesso administrativo do usuário
	 * @apiSuccess {String} senha  Senha de acesso encriptada.
	 * @apiSuccess {DateTime} dtUltimoAcesso  Data do último acesso realizado pelo usuário.
	 * @apiSuccess {JSON} conjuntoSelecao Conjunto de componente curriculares selecionadas pelo usuário.
	 * 
	 * @apiError {String[]} 404 O <code>id</code> não corresponde a um usuário cadastrado.
	 * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
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
			), self::HTTP_OK);
		} else {
			$this->api_return(array(
				'status' => FALSE,
				'message' => array('Usuário não encontrado'),
			), self::HTTP_NOT_FOUND);
		}
	}

	/**
	 * @api {get} usuarios Solicitar dados de todos os usuários
	 * @apiName findAll
	 * @apiGroup Usuario
	 * @apiPermission ADMINISTRATOR
	 *
	 * @apiSuccess {Usuario[]} Usuarios Array de objetos do tipo usuário.
	 */
	public function findAll()
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
		$usuarios = $this->entity_manager->getRepository('Entities\Usuario')->findAll();

		$result = $this->doctrine_to_array($usuarios);

		$this->api_return(array(
			'status' => TRUE,
			'result' => $result,
		), self::HTTP_OK);
	}

	/**
	 * @api {post} usuarios Criar um usuário
	 * @apiName create
	 * @apiGroup Usuario
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam (Request Body/JSON) {String} email  Endereço de e-mail do usuário.
	 * @apiParam (Request Body/JSON) {String} nome   Nome do usuário.
	 * @apiParam (Request Body/JSON) {String=ADMINISTRATOR,SUPERVISOR, VISITOR} [papel=VISITOR]  Categoria que define o acesso administrativo do usuário
	 * @apiParam (Request Body/JSON) {String} senha  Senha de acesso encriptada.
	 * @apiParam (Request Body/JSON) {JSON} [conjuntoSelecao] Conjunto de componente curriculares selecionadas pelo usuário.
	 * 
	 * @apiSuccess {String} message  Usuário criado com sucesso.
	 *
	 * @apiError {String[]} 404 O <code>id</code> não corresponde a um usuário cadastrado.
	 * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
	 */
	public function create()
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('POST'),
			)
		);

		$payload = json_decode(file_get_contents('php://input'), TRUE);

		$usuario = new Entities\Usuario();
		
		if ( array_key_exists('nome', $payload) ) $usuario->setNome($payload['nome']);
		if ( array_key_exists('email', $payload) ) $usuario->setEmail($payload['email']);
		if ( array_key_exists('senha', $payload) ) $usuario->setSenha($payload['senha']);
		if ( array_key_exists('conjuntoSelecao', $payload) ) $usuario->setConjuntoSelecao($payload['conjuntoSelecao']);
		
		if ( array_key_exists('papel', $payload) ){
			$usuario->setPapel($payload['papel']);
		} else {
			$usuario->setPapel(PAPEL_USUARIO_VISITOR);
		}
		
		$usuario->setDtUltimoAcesso(new DateTime('NOW'));

		$constraints = $this->validator->validate($usuario);
	
		if ( $constraints->success() )
		{
			
			try {
				$this->entity_manager->persist($usuario);
				$this->entity_manager->flush();

				$this->api_return(array(
					'status' => TRUE,
					'message' => array("Usuário criado com sucesso."),
				), self::HTTP_OK);	
				
			} catch (Exception $e) {
				$msgExcecao = array($e->getMessage());
				$this->api_return(array(
					'status' => FALSE,
					'message' => $msgExcecao,
				), self::HTTP_BAD_REQUEST);	
			}
			
		} else {
			$msgViolacoes = $constraints->messageArray();

			$this->api_return(array(
				'status' => FALSE,
				'message' => $msgViolacoes,
			), self::HTTP_BAD_REQUEST);	
		}
	}

	/**
	 * @api {put} usuarios/:id Atualizar dados de um usuário
	 * @apiName update
	 * @apiGroup Usuario
	 * 
	 * @apiPermission ADMINISTRATOR
	 * @apiParam (Request Body/JSON ) {String} [email] Optional Endereço de e-mail do usuário. 
	 * @apiParam (Request Body/JSON ) {String} [nome] Optional   Nome do usuário.
	 * @apiParam (Request Body/JSON ) {String} [papel] Optional  Categoria que define o acesso administrativo do usuário
	 * @apiParam (Request Body/JSON ) {String} [senha] Optional Senha de acesso encriptada.
	 * @apiParam (Request Body/JSON ) {DateTime} [dtUltimoAcesso] Optional  Data do último acesso realizado pelo usuário.
	 * @apiParam (Request Body/JSON ) {JSON} [conjuntoSelecao] Optional Conjunto de componente curriculares selecionadas pelo usuário.
	 *
	 * @apiSuccess {String} message Usuário atualizado com sucesso.
	 * 
	 * @apiError {String[]} 404 O <code>id</code> não corresponde a um usuário cadastrado.
	 * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
	 */
	public function update($codUsuario)
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('PUT'),
			)
		);

		$payload = json_decode(file_get_contents('php://input'), TRUE);
		$usuario = $this->entity_manager->find('Entities\Usuario',$codUsuario);

		if ( !is_null($usuario) ) 
		{
			if ( array_key_exists('nome', $payload) ) $usuario->setNome($payload['nome']);
			if ( array_key_exists('papel', $payload) ) $usuario->setPapel($payload['papel']);
			if ( array_key_exists('email', $payload) ) $usuario->setEmail($payload['email']);
			if ( array_key_exists('senha', $payload) ) $usuario->setSenha($payload['senha']);
			if ( array_key_exists('dtUltimoAcesso', $payload) ) $usuario->setDtUltimoAcesso(new DateTime($payload['dtUltimoAcesso']));
			if ( array_key_exists('conjuntoSelecao', $payload) ) $usuario->setConjuntoSelecao($payload['conjuntoSelecao']);

			$constraints = $this->validator->validate($usuario);
		
			if ( $constraints->success() )
			{
				
				try {
					$this->entity_manager->merge($usuario);
					$this->entity_manager->flush();
	
					$this->api_return(array(
						'status' => TRUE,
						'message' => array("Atualização realizada com sucesso."),
					), self::HTTP_OK);	
					
				} catch (Exception $e) {
					$msgExcecao = array($e->getMessage());
					$this->api_return(array(
					'status' => FALSE,
					'message' => $msgViolacoes,
				), self::HTTP_BAD_REQUEST);	
				}
				
			} else {
				$msgViolacoes = $constraints->messageArray();
				$this->api_return(array(
					'status' => FALSE,
					'message' => $msgViolacoes,
				), self::HTTP_BAD_REQUEST);	
			}
		} else {
			$this->api_return(array(
				'status' => FALSE,
				'message' => array("Usuário não encontrado."),
			), self::HTTP_BAD_REQUEST);
		}
	}

	/**
	 * @api {delete} usuarios/:id Excluir um usuário
	 * @apiName delete
	 * @apiGroup Usuario
	 *
	 * @apiSuccess {String} message  Usuário deletado com sucesso.
	 * 
	 * @apiError {String[]} 404 O <code>id</code> não corresponde a um usuário cadastrado.
	 */
	public function delete($codUsuario)
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('DELETE'),
			)
		);

		$usuario = $this->entity_manager->find('Entities\Usuario',$codUsuario);

		if ( !is_null($usuario) ) {
			try {
				$this->entity_manager->remove($usuario);
				$this->entity_manager->flush();

				$this->api_return(array(
					'status' => TRUE,
					'message' => array("Usuário deletado com sucesso."),
				), self::HTTP_OK);	
				
			} catch (Exception $e) {
				$msgExcecao = array($e->getMessage());
				$this->api_return(array(
					'status' => FALSE,
					'message' => $msgViolacoes,
				), self::HTTP_BAD_REQUEST);	
			}
		} else {
			$this->api_return(array(
				'status' => FALSE,
				'message' => array("Usuário não encontrado."),
			), self::HTTP_BAD_REQUEST);
		}
	}
}

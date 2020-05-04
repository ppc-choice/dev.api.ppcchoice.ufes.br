<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/APIController.php';

class UsuarioController extends APIController 
{
	public function __construct() {
        parent::__construct();
    }

	/**
	 * @api {get} usuarios Solicitar dados da coleção dos usuários
	 * @apiName findAll
	 * @apiGroup Usuário
	 * @apiPermission ADMINISTRATOR
	 *
	 * @apiSuccess {Usuario[]} usuarios Array de objetos do tipo usuário.
	 */
	public function findAll()
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
		$colecaoUsuario = $this->entityManager->getRepository('Entities\Usuario')->findAll();
		$colecaoUsuario = $this->doctrineToArray($colecaoUsuario);

		$this->apiReturn($colecaoUsuario,
			self::HTTP_OK
		);
	}

	/**
	 * @api {get} usuarios/:codUsuario Solicitar dados de um usuário
	 * @apiName findById
	 * @apiGroup Usuário
	 * @apiPermission ADMINISTRATOR
	 *
	 * @apiParam {Number} codUsuario  Identificador único do usuário requerido.
	 *
	 * @apiSuccess {Number} codUsuario Identificador único do usuário.
	 * @apiSuccess {String} email  Endereço de e-mail do usuário.
	 * @apiSuccess {String} nome   Nome do usuário.
	 * @apiSuccess {String} papel  Categoria que define o acesso administrativo do usuário
	 * @apiSuccess {String} senha  Senha de acesso encriptada.
	 * @apiSuccess {DateTime} dtUltimoAcesso  Data do último acesso realizado pelo usuário.
	 * @apiSuccess {JSON} conjuntoSelecao Conjunto de componente curriculares selecionadas pelo usuário.
	 * @apiSuccess {Number} conjuntoSelecao[ppcAtual] Identificador único do PPC atual.
	 * @apiSuccess {Number} conjuntoSelecao[ppcAlvo] Identificador único do PPC alvo.
	 * @apiSuccess {Number[]} conjuntoSelecao[componentesCurriculares] Conjunto de identificadores únicos das componentes curriculares selecionadas.
	 * 
	 * @apiError {String[]} 404 O <code>codUsuario</code> não corresponde a um usuário cadastrado.
	 */
	public function findById($codUsuario)
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('GET'),
				// 'requireAuthorization' => TRUE,
				// 'limit' => array(1,'ip','everyday')
			)
		);
		
		$usuario = $this->entityManager->find('Entities\Usuario',$codUsuario);
		
		if ( !is_null($usuario) ) {
			$usuario = $this->doctrineToArray($usuario);	
			$this->apiReturn($usuario,
				self::HTTP_OK
			);
		} else {
			$this->apiReturn(array(
				'error' => array('Usuário não encontrado')
				),self::HTTP_NOT_FOUND
			);
		}
	}
	
	/**
	 * @api {post} usuarios Criar um usuário
	 * @apiName create
	 * @apiGroup Usuário
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam (Request Body/JSON) {String} email  Endereço de e-mail do usuário.
	 * @apiParam (Request Body/JSON) {String} nome   Nome do usuário.
	 * @apiParam (Request Body/JSON) {String=ADMINISTRATOR,SUPERVISOR, VISITOR} [papel=VISITOR]  Categoria que define o acesso administrativo do usuário
	 * @apiParam (Request Body/JSON) {String} senha  Senha de acesso encriptada.
	 * @apiParam (Request Body/JSON) {JSON} [conjuntoSelecao] Conjunto de componente curriculares selecionadas pelo usuário.
	 * @apiParam (Request Body/JSON) {Number} conjuntoSelecao[ppcAtual] Identificador único do PPC atual.
	 * @apiParam (Request Body/JSON) {Number} conjuntoSelecao[ppcAlvo] Identificador único do PPC alvo.
	 * @apiParam (Request Body/JSON) {Number[]} conjuntoSelecao[componentesCurriculares] Conjunto de identificadores únicos das componentes curriculares selecionadas.
	 * 
	 * @apiSuccess {String[]} message  Usuário criado com sucesso.
	 *
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
		if ( array_key_exists('conjuntoSelecao', $payload) ) {
			$conjuntoSelecaoJSON = json_encode($payload['conjuntoSelecao']);

			if ( is_string($conjuntoSelecaoJSON) ) {
				$usuario->setConjuntoSelecao($conjuntoSelecaoJSON);}
			else {
				$usuario->setConjuntoSelecao(null);}
		}	

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
				$this->entityManager->persist($usuario);
				$this->entityManager->flush();

				$this->apiReturn(array(
					'message' => array("Usuário criado com sucesso."),
					),self::HTTP_OK
				);	
				
			} catch (Exception $e) {
				$msgExcecao = array($e->getMessage());

				$this->apiReturn(array(
					'error' => $msgExcecao,
					),self::HTTP_BAD_REQUEST
				);	
			}
			
		} else {
			$msgViolacoes = $constraints->messageArray();

			$this->apiReturn(array(
				'error' => $msgViolacoes,
				),self::HTTP_BAD_REQUEST
			);	
		}
	}

	/**
	 * @api {put} usuarios/:codUsuario Atualizar dados de um usuário
	 * @apiName update
	 * @apiGroup Usuário
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam (Request Body/JSON ) {String} [email] Endereço de e-mail do usuário. 
	 * @apiParam (Request Body/JSON ) {String} [nome]   Nome do usuário.
	 * @apiParam (Request Body/JSON ) {String} [papel]  Categoria que define o acesso administrativo do usuário
	 * @apiParam (Request Body/JSON ) {String} [senha] Senha de acesso encriptada.
	 * @apiParam (Request Body/JSON ) {DateTime} [dtUltimoAcesso]  Data do último acesso realizado pelo usuário.
	 * @apiParam (Request Body/JSON ) {JSON} [conjuntoSelecao] Conjunto de componente curriculares selecionadas pelo usuário.
	 * @apiParam (Request Body/JSON) {Number} conjuntoSelecao[ppcAtual] Identificador único do PPC atual.
	 * @apiParam (Request Body/JSON) {Number} conjuntoSelecao[ppcAlvo] Identificador único do PPC alvo.
	 * @apiParam (Request Body/JSON) {Number[]} conjuntoSelecao[componentesCurriculares] Conjunto de identificadores únicos das componentes curriculares selecionadas.
	 * 
	 * @apiSuccess {String[]} message Usuário atualizado com sucesso.
	 * 
	 * @apiError {String[]} 404 O <code>codUsuario</code> não corresponde a um usuário cadastrado.
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
		$usuario = $this->entityManager->find('Entities\Usuario',$codUsuario);

		if ( !is_null($usuario) ) 
		{
			if ( array_key_exists('nome', $payload) ) $usuario->setNome($payload['nome']);
			if ( array_key_exists('papel', $payload) ) $usuario->setPapel($payload['papel']);
			if ( array_key_exists('email', $payload) ) $usuario->setEmail($payload['email']);
			if ( array_key_exists('senha', $payload) ) $usuario->setSenha($payload['senha']);
			if ( array_key_exists('conjuntoSelecao', $payload) ) {
				$conjuntoSelecaoJSON = json_encode($payload['conjuntoSelecao']);
				
				if ( is_string($conjuntoSelecaoJSON) ) {
					$usuario->setConjuntoSelecao($conjuntoSelecaoJSON);}
				else {
					$usuario->setConjuntoSelecao(null);}
				}	

			$usuario->setDtUltimoAcesso(new DateTime('NOW'));

			$constraints = $this->validator->validate($usuario);
		
			if ( $constraints->success() )
			{
				
				try {
					$this->entityManager->merge($usuario);
					$this->entityManager->flush();
	
					$this->apiReturn(array(
						'message' => array("Atualização realizada com sucesso."),
						),self::HTTP_OK
					);	
					
				} catch (Exception $e) {
					$msgExcecao = array($e->getMessage());
					
					$this->apiReturn(array(
						'error' => $msgExcecao,
						),self::HTTP_BAD_REQUEST
					);	
				}
				
			} else {
				$msgViolacoes = $constraints->messageArray();

				$this->apiReturn(array(
					'error' => $msgViolacoes,
					),self::HTTP_BAD_REQUEST
				);	
			}
		} else {
			$this->apiReturn(array(
				'error' => array("Usuário não encontrado."),
				),self::HTTP_NOT_FOUND
			);
		}
	}

	/**
	 * @api {delete} usuarios/:codUsuario Excluir um usuário
	 * @apiName delete
	 * @apiGroup Usuário
	 * @apiPermission ADMINISTRATOR
	 * 
	 * @apiParam {Number} codUsuario Identificador único do usuário. 
	 * 
	 * @apiSuccess {String[]} message  Usuário deletado com sucesso.
	 * 
	 * @apiError {String[]} 404 O <code>codUsuario</code> não corresponde a um usuário cadastrado.
	 */
	public function delete($codUsuario)
	{
		header("Access-Controll-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('DELETE'),
			)
		);

		$usuario = $this->entityManager->find('Entities\Usuario',$codUsuario);

		if ( !is_null($usuario) ) {
			try {
				$this->entityManager->remove($usuario);
				$this->entityManager->flush();

				$this->apiReturn(array(
					'message' => array("Usuário deletado com sucesso."),
					),self::HTTP_OK
				);	
				
			} catch (Exception $e) {
				$msgExcecao = array($e->getMessage());

				$this->apiReturn(array(
					'error' => $msgExcecao,
					),self::HTTP_BAD_REQUEST
				);	
			}
		} else {
			$this->apiReturn(array(
				'error' => array("Usuário não encontrado."),
				),self::HTTP_NOT_FOUND
			);
		}
	}
}

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
	 * 
	 * @apiError {String[]} error Entities\\Usuario: Instância não encontrada. Não existem usuários cadastrados 
	 */
	public function findAll()
	{
		
		header("Access-Control-Allow-Origin: *");
		

		$this->_apiConfig(array(
				'methods' => array('GET'),
			)
		);
		
		$colecaoUsuario = $this->entityManager->getRepository('Entities\Usuario')->findAll();
		
		if ( !empty($colecaoUsuario) ){
			$colecaoUsuario = $this->doctrineToArray($colecaoUsuario);
			$this->apiReturn($colecaoUsuario,
				self::HTTP_OK
			);
		} else {
			$this->apiReturn(array(
				'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
				),self::HTTP_NOT_FOUND
			);
		}

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
		header("Access-Control-Allow-Origin: *");

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
				'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
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
	 * @apiSuccess {String[]} message  Entities\\Usuario: Instância criada com sucesso.
	 *
	 * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
	 */
	public function create()
	{
		header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('POST'),
			)
		);

		$payload = $this->getBodyRequest();
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
		$usuario->setCodUsuario($this->uniqIdV2());

		$constraints = $this->validator->validate($usuario);
	
		if ( $constraints->success() )
		{
			$this->load->library('Bcrypt');
			$usuario->setSenha($this->bcrypt->hash($payload['senha']));

			try {
				$this->entityManager->persist($usuario);
				$this->entityManager->flush();

				$this->apiReturn(array(
					'message' => $this->getApiMessage(STD_MSG_CREATED),
					),self::HTTP_OK
				);	
				
			} catch (Exception $e) {
				$this->apiReturn(array(
					'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
					),self::HTTP_BAD_REQUEST
				);	
			}
			
		} else {
			$this->apiReturn(array(
				'error' => $constraints->messageArray(),
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
	 * @apiSuccess {String[]} message Entities\\Usuario: Instância atualizada com sucesso.
	 * 
	 * @apiError {String[]} 404 O <code>codUsuario</code> não corresponde a um usuário cadastrado.
	 * @apiError {String[]} 400 Campo obrigatório não informado ou contém valor inválido.
	 */
	public function update($codUsuario)
	{
		header("Access-Control-Allow-Origin: *");
		
		$this->_apiConfig(array(
				'methods' => array('PUT'),
			)
		);

		$payload = $this->getBodyRequest();
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
				$this->load->library('Bcrypt');
				$usuario->setSenha($this->bcrypt->hash($payload['senha']));

				try {
					$this->entityManager->merge($usuario);
					$this->entityManager->flush();
	
					$this->apiReturn(array(
						'message' => $this->getApiMessage(STD_MSG_UPDATED),
						),self::HTTP_OK
					);	
					
				} catch (Exception $e) {
					$this->apiReturn(array(
						'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
						),self::HTTP_BAD_REQUEST
					);	
				}
				
			} else {
				$this->apiReturn(array(
					'error' => $constraints->messageArray(),
					),self::HTTP_BAD_REQUEST
				);	
			}
		} else {
			$this->apiReturn(array(
				'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
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
	 * @apiSuccess {String[]} message  Entities\\Usuario: Instância deletada com sucesso.
	 * 
	 * @apiError {String[]} 404 O <code>codUsuario</code> não corresponde a um usuário cadastrado.
	 */
	public function delete($codUsuario)
	{
		header("Access-Control-Allow-Origin: *");

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
					'message' => $this->getApiMessage(STD_MSG_DELETED),
					),self::HTTP_OK
				);	
				
			} catch (Exception $e) {
				$this->apiReturn(array(
					'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
					),self::HTTP_BAD_REQUEST
				);	
			}
		} else {
			$this->apiReturn(array(
				'error' => $this->getApiMessage(STD_MSG_NOT_FOUND),
				),self::HTTP_NOT_FOUND
			);
		}
	}

    /**
	 * @api {post} usuarios/login Entrar na conta de usuário
	 * @apiName login
	 * @apiGroup Usuário
	 * 
	 * @apiParam (Request Body/JSON ) {String} [email] Endereço de e-mail do usuário. 
	 * @apiParam (Request Body/JSON ) {String} [senha] Senha de acesso.
	 * 
	 * @apiSuccess {JSON} usuario  Perfil do usuário logado
	 * @apiSuccess {String} usuario[email]  Endereço de email do usuário
	 * @apiSuccess {DateTime} usuario[dtUltimoAcesso]  Data e hora do último login realizado com sucesso
	 * @apiSuccess {String} usuario[papel]  Categoria que define o nível de acesso
	 * @apiSuccess {JSON} usuario[nome]  Nome do usuário
	 * @apiSuccess {String} token  Token de acesso JWT
	 * 
	 * @apiError {String[]} 401 Entities\\Usuario.(email|senha): Credencial inválida. O <code>email</code> ou <code>senha</code> informado(s) não são válidos
	 */
	public function login()
	{
		header("Access-Control-Allow-Origin: *");

		$this->_apiConfig(array(
				'methods' => array('POST'),
			)
		);

		$payload = $this->getBodyRequest();
		$usuarioRequisicao = new Entities\Usuario();

		if ( array_key_exists('email', $payload) ) $usuarioRequisicao->setEmail($payload['email']);
		if ( array_key_exists('senha', $payload) ) $usuarioRequisicao->setSenha($payload['senha']);

		$constraints = $this->validator->validate($usuarioRequisicao,'Login');

		if ( $constraints->success() )
		{
			$usuario = $this->entityManager->getRepository('Entities\Usuario')
				->findOneByEmail($usuarioRequisicao->getEmail());

			if ( !is_null($usuario))
			{
				$this->load->library('Bcrypt');

				if ( $this->bcrypt->check($usuarioRequisicao->getSenha(), $usuario->getSenha()) )
				{
					$usuario->setDtUltimoAcesso(new DateTime('NOW'));

					$this->load->library('AuthorizationToken');
					$token = $this->authorizationtoken->generateToken($payload);

					try {
						$this->entityManager->merge($usuario);
						$this->entityManager->flush();
					} catch (\Throwable $th) {
						$this->apiReturn(array(
							'error' => $this->getApiMessage(STD_MSG_EXCEPTION),
							),self::HTTP_UNAUTHORIZED
						);
					}	
					
					$perfilUsuario = array(
						'email' => $usuario->getEmail(),
						'dtUltimoAcesso' => $usuario->getDtUltimoAcesso()->format('c'),
						'nome' => $usuario->getNome(),
						'papel' => $usuario->getPapel(),
					);

					$this->apiReturn(array(
						'usuario' => $perfilUsuario,
						'token' => $token
						),self::HTTP_OK
					);
				} else {
					$this->apiReturn(array(
						'error' => $this->getApiMessage(STD_MSG_INVALID_CREDENTIAL, 'senha'),
						),self::HTTP_UNAUTHORIZED
					);
				}

			} else {
				$this->apiReturn(array(
					'error' => $this->getApiMessage(STD_MSG_INVALID_CREDENTIAL, 'email'),
					),self::HTTP_UNAUTHORIZED
				);
			}

		} else {
			$this->apiReturn(array(
				'error' => $constraints->messageArray(),
				),self::HTTP_BAD_REQUEST
			);
		}


	}

	public function test(){
		echo uniqid();
	}
}

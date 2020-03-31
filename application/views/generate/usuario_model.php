<?php
class Usuario_model extends CI_Model
{

	private $tbl_usuario = 'usuario';
		function Usuario_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('conjunto_selecao', $data['conjunto_selecao']);
		$this->db->set('dt_ultimo_acesso', $data['dt_ultimo_acesso']);
		$this->db->set('email', $data['email']);
		$this->db->set('nome', $data['nome']);
		$this->db->set('papel', $data['papel']);
		$this->db->set('senha', $data['senha']);
		$this->db->insert($this->tbl_usuario);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$this->db->where('cod_usuario', $id);
		$query = $this->db->get($this->tbl_usuario);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_usuario);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->where('cod_usuario', $data['cod_usuario']);
		$this->db->set('conjunto_selecao', $data['conjunto_selecao']);
		$this->db->set('dt_ultimo_acesso', $data['dt_ultimo_acesso']);
		$this->db->set('email', $data['email']);
		$this->db->set('nome', $data['nome']);
		$this->db->set('papel', $data['papel']);
		$this->db->set('senha', $data['senha']);
		$this->db->update($this->tbl_usuario);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('cod_usuario', $id);
		$this->db->delete($this->tbl_usuario);

		return $this->db->affected_rows();
	}

}
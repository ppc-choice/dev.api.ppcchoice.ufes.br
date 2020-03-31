<?php
class Unidade_ensino_model extends CI_Model
{

	private $tbl_unidade_ensino = 'unidade_ensino';
		function Unidade_ensino_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('cnpj', $data['cnpj']);
		$this->db->set('cod_ies', $data['cod_ies']);
		$this->db->set('nome', $data['nome']);
		$this->db->insert($this->tbl_unidade_ensino);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$this->db->where('cod_un_ensino', $id);
		$query = $this->db->get($this->tbl_unidade_ensino);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_unidade_ensino);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->set('cnpj', $data['cnpj']);
		$this->db->set('cod_ies', $data['cod_ies']);
		$this->db->where('cod_un_ensino', $data['cod_un_ensino']);
		$this->db->set('nome', $data['nome']);
		$this->db->update($this->tbl_unidade_ensino);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('cod_un_ensino', $id);
		$this->db->delete($this->tbl_unidade_ensino);

		return $this->db->affected_rows();
	}

}
<?php
class Transicao_model extends CI_Model
{

	private $tbl_transicao = 'transicao';
		function Transicao_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('cod_ppc_alvo', $data['cod_ppc_alvo']);
		$this->db->set('cod_ppc_atual', $data['cod_ppc_atual']);
		$this->db->insert($this->tbl_transicao);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$this->db->where('cod_ppc_alvo', $id);
		$this->db->where('cod_ppc_atual', $id);
		$query = $this->db->get($this->tbl_transicao);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_transicao);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->where('cod_ppc_alvo', $data['cod_ppc_alvo']);
		$this->db->where('cod_ppc_atual', $data['cod_ppc_atual']);
		$this->db->update($this->tbl_transicao);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('cod_ppc_alvo', $id);
		$this->db->where('cod_ppc_atual', $id);
		$this->db->delete($this->tbl_transicao);

		return $this->db->affected_rows();
	}

}
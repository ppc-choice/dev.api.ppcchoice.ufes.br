<?php
class Departamento_model extends CI_Model
{

	private $tbl_departamento = 'departamento';
		function Departamento_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('abreviatura', $data['abreviatura']);
		$this->db->set('cod_un_ensino', $data['cod_un_ensino']);
		$this->db->set('nome', $data['nome']);
		$this->db->insert($this->tbl_departamento);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$this->db->where('cod_depto', $id);
		$query = $this->db->get($this->tbl_departamento);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_departamento);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->set('abreviatura', $data['abreviatura']);
		$this->db->where('cod_depto', $data['cod_depto']);
		$this->db->set('cod_un_ensino', $data['cod_un_ensino']);
		$this->db->set('nome', $data['nome']);
		$this->db->update($this->tbl_departamento);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('cod_depto', $id);
		$this->db->delete($this->tbl_departamento);

		return $this->db->affected_rows();
	}

}
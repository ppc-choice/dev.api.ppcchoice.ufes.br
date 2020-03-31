<?php
class Dependencia_model extends CI_Model
{

	private $tbl_dependencia = 'dependencia';
		function Dependencia_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('cod_comp_curric', $data['cod_comp_curric']);
		$this->db->set('cod_pre_requisito', $data['cod_pre_requisito']);
		$this->db->insert($this->tbl_dependencia);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$query = $this->db->get($this->tbl_dependencia);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_dependencia);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->set('cod_comp_curric', $data['cod_comp_curric']);
		$this->db->set('cod_pre_requisito', $data['cod_pre_requisito']);
		$this->db->update($this->tbl_dependencia);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->delete($this->tbl_dependencia);

		return $this->db->affected_rows();
	}

}
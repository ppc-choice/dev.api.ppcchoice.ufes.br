<?php
class Correspondencia_model extends CI_Model
{

	private $tbl_correspondencia = 'correspondencia';
		function Correspondencia_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('cod_comp_curric', $data['cod_comp_curric']);
		$this->db->set('cod_comp_curric_corresp', $data['cod_comp_curric_corresp']);
		$this->db->set('percentual', $data['percentual']);
		$this->db->insert($this->tbl_correspondencia);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$query = $this->db->get($this->tbl_correspondencia);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_correspondencia);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->set('cod_comp_curric', $data['cod_comp_curric']);
		$this->db->set('cod_comp_curric_corresp', $data['cod_comp_curric_corresp']);
		$this->db->set('percentual', $data['percentual']);
		$this->db->update($this->tbl_correspondencia);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->delete($this->tbl_correspondencia);

		return $this->db->affected_rows();
	}

}
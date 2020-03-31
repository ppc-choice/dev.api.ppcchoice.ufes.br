<?php
class Componente_curricular_model extends CI_Model
{

	private $tbl_componente_curricular = 'componente_curricular';
		function Componente_curricular_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('cod_depto', $data['cod_depto']);
		$this->db->set('cod_ppc', $data['cod_ppc']);
		$this->db->set('credito', $data['credito']);
		$this->db->set('num_disciplina', $data['num_disciplina']);
		$this->db->set('periodo', $data['periodo']);
		$this->db->set('tipo', $data['tipo']);
		$this->db->insert($this->tbl_componente_curricular);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$this->db->where('cod_comp_curric', $id);
		$query = $this->db->get($this->tbl_componente_curricular);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_componente_curricular);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->where('cod_comp_curric', $data['cod_comp_curric']);
		$this->db->set('cod_depto', $data['cod_depto']);
		$this->db->set('cod_ppc', $data['cod_ppc']);
		$this->db->set('credito', $data['credito']);
		$this->db->set('num_disciplina', $data['num_disciplina']);
		$this->db->set('periodo', $data['periodo']);
		$this->db->set('tipo', $data['tipo']);
		$this->db->update($this->tbl_componente_curricular);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('cod_comp_curric', $id);
		$this->db->delete($this->tbl_componente_curricular);

		return $this->db->affected_rows();
	}

}
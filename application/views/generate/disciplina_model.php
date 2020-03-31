<?php
class Disciplina_model extends CI_Model
{

	private $tbl_disciplina = 'disciplina';
		function Disciplina_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('ch', $data['ch']);
		$this->db->set('cod_depto', $data['cod_depto']);
		$this->db->set('nome', $data['nome']);
		$this->db->set('num_disciplina', $data['num_disciplina']);
		$this->db->insert($this->tbl_disciplina);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$this->db->where('cod_depto', $id);
		$this->db->where('num_disciplina', $id);
		$query = $this->db->get($this->tbl_disciplina);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_disciplina);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->set('ch', $data['ch']);
		$this->db->where('cod_depto', $data['cod_depto']);
		$this->db->set('nome', $data['nome']);
		$this->db->where('num_disciplina', $data['num_disciplina']);
		$this->db->update($this->tbl_disciplina);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('cod_depto', $id);
		$this->db->where('num_disciplina', $id);
		$this->db->delete($this->tbl_disciplina);

		return $this->db->affected_rows();
	}

}
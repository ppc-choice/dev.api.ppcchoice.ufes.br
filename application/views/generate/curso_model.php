<?php
class Curso_model extends CI_Model
{

	private $tbl_curso = 'curso';
		function Curso_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('ano_criacao', $data['ano_criacao']);
		$this->db->set('cod_un_ensino', $data['cod_un_ensino']);
		$this->db->set('nome', $data['nome']);
		$this->db->insert($this->tbl_curso);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$this->db->where('cod_curso', $id);
		$query = $this->db->get($this->tbl_curso);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_curso);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->set('ano_criacao', $data['ano_criacao']);
		$this->db->where('cod_curso', $data['cod_curso']);
		$this->db->set('cod_un_ensino', $data['cod_un_ensino']);
		$this->db->set('nome', $data['nome']);
		$this->db->update($this->tbl_curso);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('cod_curso', $id);
		$this->db->delete($this->tbl_curso);

		return $this->db->affected_rows();
	}

}
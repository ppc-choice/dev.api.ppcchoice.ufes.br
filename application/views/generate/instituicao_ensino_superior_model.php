<?php
class Instituicao_ensino_superior_model extends CI_Model
{

	private $tbl_instituicao_ensino_superior = 'instituicao_ensino_superior';
		function Instituicao_ensino_superior_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('abreviatura', $data['abreviatura']);
		$this->db->set('cod_ies', $data['cod_ies']);
		$this->db->set('nome', $data['nome']);
		$this->db->insert($this->tbl_instituicao_ensino_superior);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$this->db->where('cod_ies', $id);
		$query = $this->db->get($this->tbl_instituicao_ensino_superior);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_instituicao_ensino_superior);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->set('abreviatura', $data['abreviatura']);
		$this->db->where('cod_ies', $data['cod_ies']);
		$this->db->set('nome', $data['nome']);
		$this->db->update($this->tbl_instituicao_ensino_superior);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('cod_ies', $id);
		$this->db->delete($this->tbl_instituicao_ensino_superior);

		return $this->db->affected_rows();
	}

}
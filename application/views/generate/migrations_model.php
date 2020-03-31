<?php
class Migrations_model extends CI_Model
{

	private $tbl_migrations = 'migrations';
		function Migrations_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('version', $data['version']);
		$this->db->insert($this->tbl_migrations);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$query = $this->db->get($this->tbl_migrations);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_migrations);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->set('version', $data['version']);
		$this->db->update($this->tbl_migrations);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->delete($this->tbl_migrations);

		return $this->db->affected_rows();
	}

}
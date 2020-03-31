<?php
class Api_keys_model extends CI_Model
{

	private $tbl_api_keys = 'api_keys';
		function Api_keys_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('api_key', $data['api_key']);
		$this->db->set('controller', $data['controller']);
		$this->db->set('date_created', $data['date_created']);
		$this->db->set('date_modified', $data['date_modified']);
		$this->db->insert($this->tbl_api_keys);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get($this->tbl_api_keys);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_api_keys);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->set('api_key', $data['api_key']);
		$this->db->set('controller', $data['controller']);
		$this->db->set('date_created', $data['date_created']);
		$this->db->set('date_modified', $data['date_modified']);
		$this->db->where('id', $data['id']);
		$this->db->update($this->tbl_api_keys);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->tbl_api_keys);

		return $this->db->affected_rows();
	}

}
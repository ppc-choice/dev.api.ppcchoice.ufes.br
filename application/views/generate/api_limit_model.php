<?php
class Api_limit_model extends CI_Model
{

	private $tbl_api_limit = 'api_limit';
		function Api_limit_model()
	{
		parent::__construct();
		$this->load->database();
	}

	function create($data)
	{
		$this->db->set('class', $data['class']);
		$this->db->set('ip_address', $data['ip_address']);
		$this->db->set('method', $data['method']);
		$this->db->set('time', $data['time']);
		$this->db->set('uri', $data['uri']);
		$this->db->set('user_id', $data['user_id']);
		$this->db->insert($this->tbl_api_limit);

		return $this->db->affected_rows();
	}

	function read($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get($this->tbl_api_limit);

		return $query;
	}

	function readAll()
	{
		$query = $this->db->get($this->tbl_api_limit);

		return $query;
	}

	function update($id, $data)
	{
		$this->db->set('class', $data['class']);
		$this->db->where('id', $data['id']);
		$this->db->set('ip_address', $data['ip_address']);
		$this->db->set('method', $data['method']);
		$this->db->set('time', $data['time']);
		$this->db->set('uri', $data['uri']);
		$this->db->set('user_id', $data['user_id']);
		$this->db->update($this->tbl_api_limit);

		return $this->db->affected_rows();
	}

	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->tbl_api_limit);

		return $this->db->affected_rows();
	}

}
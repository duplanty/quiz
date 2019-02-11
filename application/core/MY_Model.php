<?php
class MY_model extends CI_Model {
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}
	
	public function debug($obj){
		$fp = fopen("debug.txt", 'a');
		fputs($fp, print_r($obj, true) . "\n");
		fclose($fp);
	}

	public function get_last_ten_entries()
	{
		$query = $this->db->get($this->table, 10);
		return $query->result();
	}

	public function insert($params = array())
	{
		$this->db->insert($this->table, $params);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function update($where = array(), $params = array())
	{
		$this->db->update($this->table, $params, $where);
	}

	public function delete($where = array())
	{
		$this->db->delete($this->table, $where);
	}

	public function getOne($where = array())
	{
		$this->db->from($this->table);
		$this->db->where($where);
		$query = $this->db->get();
		$res = $query->result_array();
		return count($res) > 0 ? $res[0] : null;
	}

	public function getAll($where = array(), $orderby = 'id', $direct = 'ASC', $limit = 0, $start = 0)
	{
		$this->db->from($this->table);
		$this->db->where($where);
		$this->db->order_by($orderby, $direct);
		if ($limit > 0)
			$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result_array();
	}
}
?>
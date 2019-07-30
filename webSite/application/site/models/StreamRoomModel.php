<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户模型
 */
class StreamRoomModel extends MY_Model {

	private $table;

	public function __construct()
	{
		parent::__construct();

		$this->table = 'streamroom';

	}

	/**
	 * 获取用户列表
	 */
	public function list($filter, $num, $size)
	{
		//$this->db->select('title, content, date');

		$this->db->reset_query();


		foreach($filter as $key => $value) {
			if($key == 'where'){
				$this->db->where($value);
			}elseif($key == 'like'){
				$this->db->like($value);
			}
		}


		$this->db->from($this->table);
		$count = $this->db->count_all_results('', false);

		$this->db->select('*');
		$this->db->order_by('id DESC');
		$this->db->limit($size, ($num-1)*$size);//从0开始要减1

		$query = $this->db->get();

		return array(
			'list' => $query->result_array(),
			'count' => $count
		);
	}

	/**
	 * 获取单个用户
	 */
	public function get($data)
	{
    $query = $this->db->get_where($this->table, $data);
    return $query->row_array();
	}

	/**
	 * 添加单个用户
	 */
	public function insert($data)
	{
		$id = 0;
		if($this->db->insert($this->table, $data)){
			$id = $this->db->insert_id();
		}
		return $id;
		//$this->db->insert_batch()
	}

	/**
	 * 编辑单个用户
	 */
	public function update($where, $data)
	{
		$id = 0;
		if($this->db->update($this->table, $data, $where)){
			$query = $this->db->get_where($this->table, $where);
			$user = $query->row_array();
			$id = $user['id'];
		}
		return $id;
	}

	/**
	 * 删除用户
	 */
	public function delete($idsStr)
	{
		if(strpos($idsStr, ',')){ //多个id
			$this->db->where_in('id', explode(',', $idsStr));
		}else{
			$this->db->where('id', $idsStr);
		}
		return $this->db->delete($this->table);
	}

	/**
	 * 设置用户状态
	 */
	public function setState($idsStr, $state)
	{
		if(strpos($idsStr, ',')){ //多个id
			$this->db->where_in('id', explode(',', $idsStr));
		}else{
			$this->db->where('id', $idsStr);
		}
		return $this->db->update($this->table, array('state' => $state ? 1 : 0));
	}
}

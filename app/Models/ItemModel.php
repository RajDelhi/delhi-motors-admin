<?php

namespace App\Models;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Model;
use Hermawan\DataTables\DataTable;

class ItemModel extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'item_id';

    public function __construct()
    {
        $this->db = db_connect();
        $this->item_builder = $this->db->table($this->table);
    }

    public function add_items($params = array())
    {
        $status = false;
        if (!empty($params)) {
            $this->item_builder->insert($params);
            $status = true;
        }
        return $status;

    }

    public function get_item_list($where = array(), $order_by = "", $where_in = array(), $join_table = "")
    {
        $query = array();
        if (!empty($order_by)) {
            $this->item_builder->orderBy($order_by);
        }

        if (!empty($where_in)) {
            $this->item_builder->whereIn('mls_status', array('active', 'close'));
        }

        if (!empty($join_table) && $join_table == 'employee') {
            $this->item_builder->join('employee', 'employee.emp_id = items.item_id');
        }


        if (!empty($where)) {

            $query = $this->item_builder->getWhere($where)->getResultArray();

        } else {

            $query = $this->item_builder->get()->getResultArray();
        }
        // echo $this->db->getLastQuery(); die;
        return $query;

    }

    public function delete_list($where = array())
    {
        $status = false;
        $emp_id = session()->get('emp_id');
        if (!empty($where)) {
            $this->item_builder->set('item_active', '0');
            $this->item_builder->set('deleted_by', $emp_id);
            $this->item_builder->where($where);
            $this->item_builder->update();
            $status = true;
        }
        return $status;

    }


    public function update_item($params = array(), $item_id = "")
    {
        $status = false;
        if (!empty($item_id)) {

            $this->item_builder->set($params);
            $this->item_builder->where('item_id', $item_id);
            $this->item_builder->update();

            $status = true;
        }
        return $status;

    }

}

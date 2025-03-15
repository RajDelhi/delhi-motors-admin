<?php

namespace App\Models;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Model;
use Hermawan\DataTables\DataTable;

class InventoryModel extends Model
{
    protected $table = 'inventory';
    protected $inventory_detail = 'inventory_detail';
    protected $primaryKey = 'inventory_id';

    public function __construct()
    {
        $this->db = db_connect();
        $this->item_builder = $this->db->table($this->table);
        $this->item_details_builder = $this->db->table($this->inventory_detail);
        
    }

    public function add_inventory($params = array())
    {
        $last_insert_id = '';
        if (!empty($params)) {
            $this->item_builder->insert($params);
            $last_insert_id = $this->db->insertID();
            
        }
        return $last_insert_id;

    }

    public function add_inventory_details($params = array())
    {
        $last_insert_id = '';
        if (!empty($params)) {
           
            $this->item_details_builder->insert($params);
            $last_insert_id = $this->db->insertID();
            
        }
        return $last_insert_id;

    }

    public function get_inventory_list($where = array(), $order_by = "", $where_in = array(), $join_table = "", $select = "",  $group_by="")
    {
        $query = array();
        if (!empty($select)) {
            $this->item_builder->select($select);
        }

        if (!empty($order_by)) {
            $this->item_builder->orderBy($order_by);
        }

        if (!empty($where_in)) {
            $this->item_builder->whereIn('mls_status', array('active', 'close'));
        }

        if (!empty($join_table) && in_array("inventory_detail",$join_table )) {
            $this->item_builder->join('inventory_detail', 'inventory_detail.inventory_id = inventory.inventory_id', "LEFT");
        }
        if (!empty($join_table) && in_array("items",$join_table )) {
            $this->item_builder->join('items', 'inventory_detail.inventory_id = items.id', "LEFT");
        }
        if (!empty( $group_by)) {
            $this->item_builder->groupBy($group_by);
        }

        if (!empty($where)) {

            $query = $this->item_builder->getWhere($where)->getResultArray();

        } else {

            $query = $this->item_builder->get()->getResultArray();
        }
        // echo $this->db->getLastQuery(); die;
        return $query;

    }

    public function delete_invetory($where = array())
    {
        $status = false;
        $emp_id = session()->get('emp_id');
        if (!empty($where)) {
            $this->item_builder->set('active', '0');
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

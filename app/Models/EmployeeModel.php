<?php

namespace App\Models;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Model;
use Hermawan\DataTables\DataTable;

class EmployeeModel extends Model
{
    protected $table = 'employee';
    protected $primaryKey = 'emp_id';

    protected $allowedFields = [
        'emp_office_id',
        'emp_email',
        'emp_first_name',
        'emp_last_name',
        'emp_phone',
        'emp_company',
        'emp_email_verified',
        'emp_active',
        'emp_password',
        'type',
        /* All other fields */
    ];
    public function __construct()
    {
        $this->db = db_connect();
        $this->employee_builder = $this->db->table('employee');
    }

    public function add_employee($params = array())
    {
        $status['status'] = false;
        if (!empty($params)) {
            $this->employee_builder->insert($params);
            $status['status'] = true;
            $status['inserted_id'] = $this->db->insertID();
        }
        
        return $status;

    }

    public function get_employee($where = array(), $join_table = "", $order_by = "", $where_not = "")
    {
        if (!empty($join_table) && $join_table == 'admin') {

            $this->employee_builder->join('admin', 'admin.email = employee.emp_email', 'left');
        }

        if (!empty($where_not)) {
            $query = $this->employee_builder->whereNotIn('emp_id', $where_not);

        }

        if (!empty($where)) {
            $query = $this->employee_builder->getWhere($where)->getResultArray();

        } else {

            $query = $this->employee_builder->get()->getResultArray();
        }
        // echo $this->db->getLastQuery(); die;
        return $query;

    }


    public function update_profile($params = array(), $emp_id = "")
    {
        $status = false;
        if (!empty($emp_id)) {
            $this->employee_builder->set($params);
            $this->employee_builder->where('emp_id', $emp_id);
            $this->employee_builder->update();
            // echo $this->db->getLastQuery(); die;
            $status = true;
        }
        return $status;

    }

}

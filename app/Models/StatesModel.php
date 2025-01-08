<?php

namespace App\Models;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Model;
use Hermawan\DataTables\DataTable;

class StatesModel extends Model
{
    protected $table = 'states';
    protected $primaryKey = 'id';

    public function __construct()
    {
        $this->db = db_connect();
        $this->states_builder = $this->db->table($this->table);
    }


    public function get_states($where = array())
    {
        if (!empty($where)) {
            $query = $this->states_builder->getWhere($where)->getResultArray();

        } else {
            $query = $this->states_builder->get()->getResultArray();
        }
        return $query;

    }

}

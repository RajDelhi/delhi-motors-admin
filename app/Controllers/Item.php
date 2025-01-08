<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\ItemModel;
//use App\Models\StatesModel;
//use App\Models\PropertyModel;

class Item extends BaseController
{

    public function __construct()
    {
        $this->session = session();
        $this->item_obj = new ItemModel();
        helper('common');

    }
    public function dashboard()
    {
        $data = array();
        $emp_id =  $this->session->get('emp_id');
        
        if (!empty($emp_id)) {
           // $whare['emp_id'] = $emp_id;
            $whare['item_active'] = 1;
            $order_by = 'item_id desc';
            $item_list = $this->item_obj->get_item_list($whare, $order_by);
            $data['list'] = $item_list;
            $data['userName'] = 0;
        }
        $data['page_title'] = 'Dashboard';
        return view('modules/item/dashboard', $data);
    }

    public function add_list()
    {
        $data = array();
        $emp_id = session()->get('emp_id');
        $data['emp_id'] = $emp_id;
//        $state_arr = $this->state_obj->get_states();
//        $state_list = array();
//        foreach ($state_arr as $state_arr_data) {
//            $state_list[$state_arr_data['abbrev']] = $state_arr_data['name'];
//        }
//        $data['state_list'] = $state_list;
        $data['page_title'] = 'Add Item';
        return view('modules/item/add', $data);
    }

    public function add_mls_ajax()
    {
        $emp_id =  $this->session->get('emp_id');
        if (empty($emp_id)) {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);

        }

        $item_params['item_name'] = !empty($_POST['item_name']) ? $_POST['item_name'] : "";
        $item_params['item_HSN_code'] = !empty($_POST['item_HSN_code']) ? $_POST['item_HSN_code'] : "";
        $item_params['price'] = !empty($_POST['price']) ? $_POST['price'] : "";
        $item_params['quantity'] = !empty($_POST['quantity']) ? $_POST['quantity'] : "";
        $item_params['emp_id'] = $emp_id;
        $item_params['item_purchase_date'] = !empty($_POST['item_purchase_date']) ? $_POST['item_purchase_date'] : "";
        $item_params['item_description'] = !empty($_POST['item_description']) ? $_POST['item_description'] : "";
        $status = $this->item_obj->add_items($item_params);
        if ($status) {
            $response['status'] = 1;
            $response['message'] = ADD_MLS_MSG;
            $response['URL'] = base_url() . 'item-list';
            session()->setFlashdata('success_smg', ADD_MLS_MSG);
            return json_encode($response);
        }
        $response['status'] = 0;
        $response['message'] = TECHNICAL_ERROR;
        return json_encode($response);


    }

    public function edit_list($id = "")
    {
        $item_id = !empty($id) ? base64_decode($id) : "";
        if (!empty($item_id)) {

            $data = array();
            $where = array('item_id' => $item_id);
            $item_data = $this->item_obj->get_item_list($where);
            $data['item_data'] = !empty($item_data[0]) ? $item_data[0] : "";
//            $state_arr = $this->state_obj->get_states();
//            $state_list = array();
//            foreach ($state_arr as $state_arr_data) {
//                $state_list[$state_arr_data['abbrev']] = $state_arr_data['name'];
//            }

//           $data['mls_status_list'] = array('active' => 'Active', 'close' => 'Close', 'deleted' => 'Delete');
//            $data['state_list'] = $state_list;
            $data['page_title'] = 'Edit MLS';
            return view('modules/item/edit', $data);


        } else {
            // Return dashboard

        }


    }

    public function edit_list_ajax()
    {
        $emp_id =  $this->session->get('emp_id');
        
        if (empty($emp_id)) {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);

        }

        $item_params['item_name'] = !empty($_POST['item_name']) ? $_POST['item_name'] : "";
        $item_params['item_HSN_code'] = !empty($_POST['item_HSN_code']) ? $_POST['item_HSN_code'] : "";
        $item_params['price'] = !empty($_POST['price']) ? $_POST['price'] : "";
        $item_params['quantity'] = !empty($_POST['quantity']) ? $_POST['quantity'] : "";
        $item_params['emp_id'] = $emp_id;
        $item_params['item_purchase_date'] = !empty($_POST['item_purchase_date']) ? $_POST['item_purchase_date'] : "";
        $item_params['item_description'] = !empty($_POST['item_description']) ? $_POST['item_description'] : "";
        $item_id = !empty($_POST['item_id']) ? $_POST['item_id'] : "";
        
        if (!empty($item_id)) {
            $status = $this->item_obj->update_item($item_params, $item_id);

            if ($status) {
                $response['status'] = 1;
                $response['message'] = UPDATE_MLS_MSG;
                $response['URL'] = base_url() . 'item-list';
                session()->setFlashdata('success_smg', UPDATE_MLS_MSG);
                return json_encode($response);
            }
        } else {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);

        }




    }

    public function delete_item_ajax()
    {
        if (!empty($_POST['id'])) {
            $item_id = $_POST['id'];
            $where = array('item_id' => $item_id);
            $status = $this->item_obj->delete_list($where);

            if ($status) {
                $response['status'] = 1;
                $response['message'] = '';
                return json_encode($response);

            }
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);
        }



    }

    public function get_list()
    {
        $mls_id = !empty($_GET['mls_id']) ? $_GET['mls_id'] : "";
        if (!empty($mls_id)) {
            $data = [];
            $where = ['mls_id' => $mls_id, 'mls_status' => 'active'];
            $join_table = "agent";
            $mls_data = $this->mls_obj->get_mls_list($where, "", "", $join_table);
            $data['mls_data'] = !empty($mls_data[0]) ? $mls_data[0] : "";
            $state_arr = $this->state_obj->get_states();
            $state_list = [];
            foreach ($state_arr as $state_arr_data) {
                $state_list[$state_arr_data['abbrev']] = $state_arr_data['name'];
            }
        } else {
            // No record found message
        }

        $data['page_title'] = 'MLS Data';
        return view('modules/search', $data);
    }


    public function all_list()
    {
        $data = array();


        if (is_admin()) {

            $order_by = 'mls_listing_id desc';
            $join_table = "agent";
            $property_list = $this->mls_obj->get_mls_list("", $order_by, "", $join_table);
            $data['list'] = $property_list;
            $data['page_title'] = 'All Ist';
            $data['userName'] = 1;
            return view('modules/item/dashboard', $data);
        }
        redirect(base_url());

    }

}

<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\ItemModel;
use App\Models\InventoryModel;
//use App\Models\StatesModel;
//use App\Models\PropertyModel;

class Item extends BaseController
{

    public function __construct()
    {
        $this->session = session();
        $this->inventory_obj = new InventoryModel();
        $this->item_obj = new ItemModel();
        helper('common');

    }
    public function dashboard()
    {
        $data = array();
        $emp_id =  $this->session->get('emp_id');
        
        if (!empty($emp_id)) {
            $whare = array("items.active" => '1');
            $order_by = 'items.id desc';
            $item_list = $this->item_obj->get_item_list($whare, $order_by);
            $data['list'] = $item_list;
           
        }
        $data['page_title'] = 'Dashboard';
        return view('modules/item/item_dashboard', $data);
    }

    public function add_item()
    {
        $data = array();
        $emp_id = session()->get('emp_id');
        $data['emp_id'] = $emp_id;
        $data['page_title'] = 'Add Item';
        return view('modules/item/add_item', $data);
    }

    public function add_item_ajax()
    {
       
        $emp_id =  $this->session->get('emp_id');
        if (empty($emp_id)) {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);

        }

        $item_param['created_by']       =   $emp_id;    
        $item_param['name']             =   !empty($_POST['item_name']) ? $_POST['item_name'] : "";
        $item_param['hsn_code']         =   !empty($_POST['item_HSN_code']) ? $_POST['item_HSN_code'] : "";
        $item_param['unit']             =   !empty($_POST['unit_type']) ? $_POST['unit_type'] : "";
        $item_param['sgst_tax_rate']         =   !empty($_POST['sgst_tax_rate']) ? $_POST['sgst_tax_rate'] : "";
        $item_param['cgst_tax_rate']         =   !empty($_POST['cgst_tax_rate']) ? $_POST['cgst_tax_rate'] : "";
        

        $last_insert_id = $this->item_obj->add_items($item_param);
         
            if ($last_insert_id) {
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

    public function edit_item($id = "")
    { 
        $item_id = !empty($id) ? base64_decode($id) : "";
        if (!empty($item_id)) {
            $data = array();
            $where = array('id' => $item_id);
            $item_data = $this->item_obj->get_item_list($where);
            $data['item_data'] = !empty($item_data[0]) ? $item_data[0] : "";
            $data['page_title'] = 'Edit Item';
            return view('modules/item/edit_item', $data);


        } else {
            // Return dashboard

        }


    }

    public function edit_item_ajax()
    {
        $emp_id =  $this->session->get('emp_id');
        
        if (empty($emp_id)) {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);

        }

        $item_param['created_by']       =   $emp_id;    
        $item_id                        =   !empty($_POST['id']) ? $_POST['id'] : "";
        $item_param['name']             =   !empty($_POST['item_name']) ? $_POST['item_name'] : "";
        $item_param['hsn_code']         =   !empty($_POST['item_HSN_code']) ? $_POST['item_HSN_code'] : "";
        $item_param['unit']             =   !empty($_POST['unit_type']) ? $_POST['unit_type'] : "";
        $item_param['cgst_tax_rate']         =   !empty($_POST['cgst_tax_rate']) ? $_POST['cgst_tax_rate'] : "";
        $item_param['sgst_tax_rate']         =   !empty($_POST['sgst_tax_rate']) ? $_POST['sgst_tax_rate'] : "";
        
        if (!empty($item_id)) {
            $status = $this->item_obj->update_item($item_param, $item_id);

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
            $where = array('id' => $item_id);
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
    
    
    public function read_item()
    {
        if (!empty($_POST["term"]) || !empty($_POST["card_id"])) {
            $term = !empty($_POST["term"]) ? $_POST["term"] : '';
            
            $final_result_array = (array) $this->item_obj->get_item_list("", "", "","",$term );
           
            //$final_result_array = array();
//            foreach ($result as $player_array) {
//                $final_result_array[] = array('signer_id' => $player_array['card_id'], 'fee' => $player_array['fees'], 'value' => trim($player_array['display_name'],','), 'hof' => $player_array['hof'], 'notable' => $player_array['notable']);
//            }
            if (!empty($final_result_array)) {
                echo json_encode(array('status' => 'success', 'result' => $final_result_array));
                die;
            } else {
                echo json_encode(array('status' => 'error', 'result' => ''));
                die();
            }
            if (!empty($final_result_array)) {
                echo json_encode($final_result_array);
                die;
            }
        }

    }

}

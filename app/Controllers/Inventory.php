<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\ItemModel;
use App\Models\InventoryModel;
//use App\Models\StatesModel;
//use App\Models\PropertyModel;

class Inventory extends BaseController
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
            $select = "inventory.inventory_id,vendor, invoice_id, created_at, count(`inventory_detail`.`inventory_id`) as inventory_total";
            $whare = array("inventory.active" => '1');
            $order_by = 'inventory.inventory_id desc';
            $group_by = 'inventory_detail`.`inventory_id' ;
            $join_table = array("inventory_detail");
            $item_list = $this->inventory_obj->get_inventory_list($whare, $order_by,'',$join_table, $select,  $group_by);
           // echo "<pre>"; print_r($item_list); die;
            $data['list'] = $item_list;
            $data['userName'] = 0;
        }
        $data['page_title'] = 'Dashboard';
        return view('modules/inventory/dashboard', $data);
    }

    public function add_inventory()
    {
        $data = array();
        $emp_id = session()->get('emp_id');
        $data['emp_id'] = $emp_id;
        $data['page_title'] = 'Add Item';
        return view('modules/inventory/add', $data);
    }

    public function add_inventory_ajax()
    {
       
        $emp_id =  $this->session->get('emp_id');
        if (empty($emp_id)) {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);

        }
        // echo "<pre>"; print_r($_POST); die;
        $invoice_params['vendor']       = !empty($_POST['vendor_name']) ? $_POST['vendor_name'] : "";
        $invoice_params['invoice_id']   = !empty($_POST['invoice_id']) ? $_POST['invoice_id'] : "";
        $invoice_params['created_by']   = $emp_id;
        $inventory_id =  $this->inventory_obj->add_inventory($invoice_params);
        // save vandor level detalils
        if ($inventory_id) {
            // echo "<pre>"; print_r($_POST);  die;
           $count = count($_POST['item_name']);
                for($i = 0; $i < $count; $i++) {        
                   
                    $invoice_detail_param['inventory_id'] =   $inventory_id;
                    $invoice_detail_param['created_by']   = $emp_id;    
                    $invoice_detail_param['item_name'] =   !empty($_POST['item_name'][$i]) ? $_POST['item_name'][$i] : "";
                    $invoice_detail_param['item_id'] =   !empty($_POST['item_id'][$i]) ? $_POST['item_id'][$i] : "";
                    $invoice_detail_param['HSN_code']  =   !empty($_POST['HSN_code'][$i]) ? $_POST['HSN_code'][$i] : "";
                    $invoice_detail_param['sgst_tax_rate']  =   !empty($_POST['sgst_tax_rate'][$i]) ? $_POST['sgst_tax_rate'][$i] : "";
                    $invoice_detail_param['cgst_tax_rate']  =   !empty($_POST['cgst_tax_rate'][$i]) ? $_POST['cgst_tax_rate'][$i] : "";
                    $invoice_detail_param['quantity']  =   !empty($_POST['quantity'][$i]) ? $_POST['quantity'][$i] : "";
                    $invoice_detail_param['unit_type']  =   !empty($_POST['unit'][$i]) ? $_POST['unit'][$i] : "";
                    $invoice_detail_param['mrp']        =   !empty($_POST['mrp_unit'][$i]) ? $_POST['mrp_unit'][$i] : "";
                    $invoice_detail_param['base_price']  =   !empty($_POS['base_price'][$i]) ? $_POST['base_price'][$i] : "";
                    $invoice_detail_param['sgst_tax_value']  =   !empty($_POST['sgst_tax_value'][$i]) ? $_POST['sgst_tax_value'][$i] : "";
                    $invoice_detail_param['cgst_tax_value']  =   !empty($_POST['cgst_tax_value'][$i]) ? $_POST['cgst_tax_value'][$i] : "";
                    $invoice_detail_param['net_value']  =   !empty($_POST['net_value'][$i]) ? $_POST['net_value'][$i] : "";
                    $last_insert_id = $this->inventory_obj->add_inventory_details($invoice_detail_param);
            }
            if ($last_insert_id) {
                $response['status'] = 1;
                $response['message'] = ADD_MLS_MSG;
                $response['URL'] = base_url() . 'inventory-list';
                session()->setFlashdata('success_smg', ADD_MLS_MSG);
                return json_encode($response);
            }
        }    
        
        $response['status'] = 0;
        $response['message'] = TECHNICAL_ERROR;
        return json_encode($response);


    }

    public function edit_inventory($id = "")
    { 
        $inventory_id = !empty($id) ? base64_decode($id) : "";
        if (!empty($inventory_id)) {

            $data = array();
            $where = array('inventory.inventory_id' => $inventory_id);
            $join_table = array("inventory_detail");
            $inventory_data = $this->inventory_obj->get_inventory_list($where,'','',$join_table);
           
            $data['inventory_data'] = !empty($inventory_data) ? $inventory_data: "";
           
            $data['page_title'] = 'Edit Inventory';
            return view('modules/inventory/edit', $data);


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

    public function delete_inventory_ajax()
    {
        if (!empty($_POST['id'])) {
            $item_id = $_POST['id'];
            $where = array('inventory_id' => $item_id);
            $status = $this->inventory_obj->delete_invetory($where);

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
            if (!empty($final_result_array)) {
                echo json_encode(array('status' => 'success', 'result' => $final_result_array));
                die;
            } else {
                // generate html button to add inventory, instead of no record found
                
                $html = '<a href="'.base_url().'add-item" target="_blank"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-item">Add Item</button></a>';
                $final_result_array = array(array('id' => '', 'name' => $html ));
                echo json_encode(array('status' => 'success', 'result' => $final_result_array));
                die();

                // $final_result_array = array(array('id' => '9999', 'name' => 'No Record Found'));
                // echo json_encode(array('status' => 'success', 'result' => $final_result_array));
                // die();
            }
            if (!empty($final_result_array)) {
                echo json_encode($final_result_array);
                die;
            }
        }

    }

}

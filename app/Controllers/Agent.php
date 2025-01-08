<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
//use App\Models\MlsModel;
use App\Models\StatesModel;
use App\Models\PropertyModel;

class Agent extends BaseController
{

    public function __construct()
    {
        $this->session = session();
       //$this->mls_obj = new MlsModel();
        $this->emp_obj = new EmployeeModel();
        helper('common');

    }


    public function edit_profile()
    {
        $data = array();
        $emp_id = $this->session->get('emp_id');
        if (!empty($emp_id)) {

        }
        $where = array('emp_id' => (int) $emp_id);
        $emp_arr = $this->emp_obj->get_employee($where);
       // echo "<pre>"; print_r($emp_arr); die;
        $data['emp_arr'] = !empty($emp_arr[0]) ? $emp_arr[0] : '';
        $data['page_title'] = 'Edit Employees';
        return view('modules/edit_agent', $data);
    }

    public function edit_profile_ajax()
    {
        $data = array();
        $emp_id = $this->session->get('emp_id');
        if (!empty($emp_id)) {
            $params =   $_POST;
            unset($params['confirm_password']);
            if( !empty($params['emp_password'])){
                $params['emp_password']   =   md5($params['emp_password']);
            }else{
                unset($params['emp_password']);
            }

            $profile_params = $params;
            $status = $this->emp_obj->update_profile($profile_params, $emp_id);

            if ($status) {
                $response['status'] = 1;
                $response['message'] = UPDATE_PROFILE_MSG;
                $response['URL'] = base_url() . 'dashboard';
                session()->setFlashdata('success_smg', UPDATE_PROFILE_MSG);
                return json_encode($response);
            }


        } else {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);

        }

    }

    public function add_mls_ajax()
    {
        $agent_id = session()->get('agent_id');
        if (empty($agent_id)) {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);

        }
        $mls_params['mls_id'] = !empty($_POST['mls_id']) ? $_POST['mls_id'] : "";
        $mls_params['mls_concessions'] = !empty($_POST['mls_concessions']) ? $_POST['mls_concessions'] : "";
        $mls_params['mls_commission'] = !empty($_POST['mls_commission']) ? $_POST['mls_commission'] : "";
        $mls_params['mls_address1'] = !empty($_POST['mls_address1']) ? $_POST['mls_address1'] : "";
        $mls_params['mls_address2'] = !empty($_POST['mls_address2']) ? $_POST['mls_address2'] : "";
        $mls_params['mls_city'] = !empty($_POST['mls_city']) ? $_POST['mls_city'] : "";
        $mls_params['mls_state'] = !empty($_POST['mls_state']) ? $_POST['mls_state'] : "";
        $mls_params['mls_zip'] = !empty($_POST['mls_zip']) ? $_POST['mls_zip'] : "";
        $mls_params['mls_start_date'] = !empty($_POST['mls_start_date']) ? $_POST['mls_start_date'] : "";
        $mls_params['mls_expiration_date'] = !empty($_POST['mls_end_date']) ? $_POST['mls_end_date'] : "";
        $mls_params['mls_showing_instructions'] = !empty($_POST['mls_showing_instructions']) ? $_POST['mls_showing_instructions'] : "";
        $mls_params['mls_agent_id'] = $agent_id;
        $mls_params['mls_status'] = "active";

        $status = $this->mls_obj->add_mls($mls_params);
        if ($status) {
            $response['status'] = 1;
            $response['message'] = ADD_MLS_MSG;
            $response['URL'] = base_url() . 'dashboard';
            session()->setFlashdata('success_smg', ADD_MLS_MSG);
            return json_encode($response);
        }
        $response['status'] = 0;
        $response['message'] = TECHNICAL_ERROR;
        return json_encode($response);


    }


    public function all_users()
    {
        $data = array();
        if (is_admin()) {
            $agent_id = session()->get('agent_id');
            $order_by = 'agent_id desc';
            $where_not = array($agent_id);
            $agent_list = $this->emp_obj->get_agents("", "", $order_by, $where_not);
            $data['list'] = $agent_list;
            $data['page_title'] = 'All Users';
            // echo "<pre>"; print_r($data); die;
            return view('modules/users/user-list', $data);
        }

        redirect(base_url());
    }

    public function edit_user($user_id = "")
    {
        $data = array();
        $agent_id = !empty($user_id) ? base64_decode($user_id) : '';
        if (!empty($agent_id)) {

        }
        $where = array('agent_id' => (int) $agent_id);
        $agent_arr = $this->emp_obj->get_agents($where);

        $data['agent_arr'] = !empty($agent_arr[0]) ? $agent_arr[0] : '';
        $data['page_title'] = 'Edit Agent';
        return view('modules/edit_agent_admin', $data);
    }

    public function edit_user_ajax()
    {
        $data = array();
        $profile_params = $_POST;
        $agent_id = !empty($profile_params['agent_id'])?$profile_params['agent_id']:"";
        if (!empty($agent_id)) {

            unset($profile_params['confirm_password']);
            if( !empty($profile_params['agent_password'])){
                $profile_params['agent_password']   =   md5($profile_params['agent_password']);
            }else{
                unset($profile_params['agent_password']);
            }
            $status = $this->emp_obj->update_profile($profile_params, $agent_id);

            if ($status) {
                $response['status'] = 1;
                $response['message'] = UPDATE_PROFILE_MSG;
                $response['URL'] = base_url() . 'all-user';
                session()->setFlashdata('success_smg', UPDATE_PROFILE_MSG);
                return json_encode($response);
            }


        } else {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);

        }

    }


}

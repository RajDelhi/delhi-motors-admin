<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class Login extends BaseController
{

    public function __construct()
    {
        $this->session = session();

    }

    public function signin()
    {
        if (session()->get('emp_id')) {
            //return redirect()->to(base_url());
            return redirect()->to(base_url().'dashboard');
        }
        $data['page_title'] = 'Login';
        return view('modules/login', $data);
    }

    public function employee_register(): string
    {
        try {

            $register_params['emp_email'] = !empty($_POST['email']) ? $_POST['email'] : "";
            $register_params['emp_first_name'] = !empty($_POST['first_name']) ? $_POST['first_name'] : "";
            $register_params['emp_last_name'] = !empty($_POST['last_name']) ? $_POST['last_name'] : "";
           // $register_params['employee_office_id'] = !empty($_POST['estate_id']) ? $_POST['estate_id'] : "";
            $register_params['emp_password'] = !empty($_POST['password']) ? md5($_POST['password']) : "";
            $register_params['emp_phone'] = !empty($_POST['mobile']) ? $_POST['mobile'] : "";
            
            if (!empty($register_params['emp_email'])) {
                $response['URL'] = base_url() . 'login';
                $valid_email_status = $this->validate_email($register_params['emp_email']); // 1-> not found, -> 2 - exist, 3-> registered, not active, 4 -> deactivated, contact admin
                if (!empty($valid_email_status) && $valid_email_status == 1) {
                    $obj_employee = new EmployeeModel();
                    $registration_status = $obj_employee->add_employee($register_params);
                    if ($registration_status['status']) {
                        $register_params['inserted_id'] = !empty($registration_status['inserted_id']) ? $registration_status['inserted_id'] : "";
                        // $this->send_mail($register_params);
                        $response['status'] = 1;
                        $response['message'] = ACCOUNT_REGISTERED;
                        session()->setFlashdata('success_smg', ACCOUNT_REGISTERED);
                        return json_encode($response);
                    }
                    $response['status'] = 0;
                    $response['message'] = TECHNICAL_ERROR;
                    return json_encode($response);

                } else if (!empty($valid_email_status) && $valid_email_status == 2) {
                    $response['status'] = 0;
                    session()->setFlashdata('success_smg', AGENT_EMAIL_NOT_VERIFIED);
                    $response['message'] = AGENT_EMAIL_NOT_VERIFIED;
                    return json_encode($response);
                } else if (!empty($valid_email_status) && $valid_email_status == 3) {
                    $response['status'] = 0;
                    session()->setFlashdata('success_smg', AGENT_ACCOUNT_DEACTIVE);
                    $response['message'] = AGENT_ACCOUNT_DEACTIVE;
                    return json_encode($response);
                } else if (!empty($valid_email_status) && $valid_email_status == 4) {
                    $response['status'] = 0;
                    session()->setFlashdata('success_smg', AGENT_EXIST);
                    $response['message'] = AGENT_EXIST;
                    return json_encode($response);
                }
            } else {
                $response['status'] = 0;
                $response['message'] = VALID_EMAIL;
                return json_encode($response);

            }




        } catch (Exception $e) {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);
        }

    }

    public function validate_email($email = ""): string
    {
        if (!empty($email)) {
            $obj_employee = new EmployeeModel();
            $where = array('emp_email' => $email);
            $employee_detail = $obj_employee->get_employee($where);
            if (count($employee_detail) > 0) {
                if ($employee_detail[0]['emp_email_verified'] == 0) {
                    $status = 2; // not verified
                } else if ($employee_detail[0]['emp_email_verified'] == 1 && $employee_detail[0]['emp_active'] == 0) {
                    $status = 3;  // deactive, contact admin
                } else {
                    $status = 4; // exist and active
                }
            } else {
                $status = 1;
            }

            return $status;

        }
        return false;

    }

    public function login(): string
    {
        try {

            $params['email'] = !empty($_POST['email']) ? $_POST['email'] : "";
            $params['password'] = !empty($_POST['password']) ? md5($_POST['password']) : "";
            if (!empty($params['email']) && !empty($params['password'])) {
                $valid_email_status = $this->login_status($params); // 1-> not found, -> 2 - exist, 3-> registered, not active, 4 -> deactivated, contact admin
                $response['URL'] = base_url() . 'login';
                //echo "<pre>"; print_r($valid_email_status); die;
                if (!empty($valid_email_status) && $valid_email_status['status'] == 4) {

                    //login successfully, create session now 
                    $this->session->set($valid_email_status['employee_detail']);
                    $response['status'] = 1;
                    return json_encode($response);

                } else if (!empty($valid_email_status) && $valid_email_status['status'] == 2) {
                    $response['status'] = 0;
                    $agent_id = $valid_email_status['employee_detail']['emp_id'] . '_' . ENCODE_SALT;
                    $encoded_agent_id = base64_encode($agent_id);
                    $response['message'] = AGENT_EMAIL_NOT_VERIFIED . " Do you want to resend activation email, Please <a href=" . base_url() . "resend-email/{$encoded_agent_id}>click here </a>";
                    session()->setFlashdata('success_smg', $response['message']);
                    return json_encode($response);
                } else if (!empty($valid_email_status) && $valid_email_status['status'] == 3) {
                    $response['status'] = 0;
                    $response['message'] = AGENT_ACCOUNT_DEACTIVE;
                    session()->setFlashdata('success_smg', AGENT_ACCOUNT_DEACTIVE);
                    return json_encode($response);
                } else if (!empty($valid_email_status) && $valid_email_status['status'] == 1) {
                    $response['status'] = 0;
                    $response['message'] = AGENT_NOT_EXIST;
                    session()->setFlashdata('success_smg', AGENT_NOT_EXIST);
                    return json_encode($response);
                }
            } else {
                $response['status'] = 0;
                $response['message'] = TECHNICAL_ERROR;
                return json_encode($response);

            }
        } catch (Exception $e) {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);
        }

    }

    public function login_status($login_param = array()): array
    {
        if (!empty($login_param)) {
            $obj_employee = new EmployeeModel();
            if(!empty($login_param['email'])){
                $whare['emp_email'] = $login_param['email'];
            }
            if(!empty($login_param['password'])){
                $whare['emp_password'] = $login_param['password'];      
            }
           
            $join_table = "admin";
            $employee_detail = $obj_employee->get_employee($whare, $join_table);
            if (count($employee_detail) > 0) {
                if ($employee_detail[0]['emp_email_verified'] == 0) {
                    $status['status'] = 2; // not verified
                    $status['employee_detail'] = !empty($employee_detail[0]) ? $employee_detail[0] : "";
                } else if ($employee_detail[0]['emp_email_verified'] == 1 && $employee_detail[0]['emp_active'] == 0) {
                    $status['status'] = 3;  // deactive, contact admin
                } else {
                    $status['status'] = 4; // exist and active, credential verified
                    $status['employee_detail'] = !empty($employee_detail[0]) ? $employee_detail[0] : ""; // exist and active, credential verified
                }
            } else {
                $status['status'] = 1;
            }

            return $status;

        }
        return false;

    }

    public function send_mail($email_arr = array())
    {

        $to = $email_arr['agent_email'];
        $agend_id = $email_arr['inserted_id'] . '_' . ENCODE_SALT;
        $encode_agend_id = base64_encode($agend_id);
        $verification_link = base_url() . 'activate/' . $encode_agend_id;

        $subject = "Please Verify Your Email Address";
        $message = "Hi {$email_arr['agent_first_name']},

                        Welcome to commission verification !

                        Thank you for registering an account with us. To complete the registration process and activate your account, please verify your email address by clicking the link below:

                        [Verify Your Email Address] [Link]

                        If the button above doesn't work, please copy and paste the following URL into your web browser:
                        
                        {$verification_link}

                        If you did not create an account with commission verification, please disregard this email.

                        Thank you for joining us!

                        Best regards,";
        $headers = 'From: admin@commissionverification.com' . "\r\n" .
            'Reply-To: admin@commissionverification.com' . "\r\n";


        // mail($to, $subject, $message, $headers);

    }

    public function resend_mail($encode_agend_id = "")
    {

        // $to = $email_arr['agent_email'];
        if (!empty($encode_agend_id)) {
           // $this->load->library('Notification_sendgrid');
                
           $mail = new \App\Libraries\Notification_sendgrid();
            $verification_link = base_url() . 'activate/' . $encode_agend_id;
            //*********************************************** */
            $agent_arr = !empty($encode_agend_id) ? explode("_", base64_decode($encode_agend_id)) : "";
            $agent_id = !empty($agent_arr[0]) ? $agent_arr[0] : "";
            $obj_agents = new AgentsModel();
            $where = array('agent_id' => $agent_id);
            $agent_detail = $obj_agents->get_agents($where);
            $to = !empty($agent_detail[0]['agent_email']) ? $agent_detail[0]['agent_email'] : "";
            if (empty($to)) {
                return false;
            }
            //*********************************************** */

            $subject = "Please Verify Your Email Address";
            $message = "Hi {$agent_detail[0]['agent_first_name']},

                        Welcome to commission verification !

                        Thank you for registering an account with us. To complete the registration process and activate your account, please verify your email address by clicking the link below:

                                              
                        {$verification_link}

                        If you did not create an account with commission verification, please disregard this email.

                        Thank you for joining us!

                        Best regards,";
            $headers = 'From: admin@commissionverification.com' . "\r\n" .
                'Reply-To: admin@commissionverification.com' . "\r\n";
            
            $from = "admin@commissionverification.com";
            $from_name = "commission verification" ;   
            $mail->send_email($from, $from_name,  $to , $subject, $message, 'noreply@commissionverification.com');
             // mail($to, $subject, $message, $headers);

        }
        $data['msg'] = MAIL_SENT;
        $data['page_title'] = 'Email Sent';
        return view('modules/activate', $data);
    }


    public function resend_mail_bkp($encode_agend_id = "")
    {

        // $to = $email_arr['agent_email'];
        if (!empty($encode_agend_id)) {
            $verification_link = base_url() . 'activate/' . $encode_agend_id;
            //*********************************************** */
            $agent_arr = !empty($encode_agend_id) ? explode("_", base64_decode($encode_agend_id)) : "";
            $agent_id = !empty($agent_arr[0]) ? $agent_arr[0] : "";
            $obj_agents = new AgentsModel();
            $where = array('agent_id' => $agent_id);
            $agent_detail = $obj_agents->get_agents($where);
            $to = !empty($agent_detail[0]['agent_email']) ? $agent_detail[0]['agent_email'] : "";
            if (empty($to)) {
                return false;
            }
            //*********************************************** */

            $subject = "Please Verify Your Email Address";
            $message = "Hi {$agent_detail[0]['agent_first_name']},

                        Welcome to commission verification !

                        Thank you for registering an account with us. To complete the registration process and activate your account, please verify your email address by clicking the link below:

                                              
                        {$verification_link}

                        If you did not create an account with commission verification, please disregard this email.

                        Thank you for joining us!

                        Best regards,";
            $headers = 'From: admin@commissionverification.com' . "\r\n" .
                'Reply-To: admin@commissionverification.com' . "\r\n";


            // mail($to, $subject, $message, $headers);

        }
        $data['msg'] = MAIL_SENT;
        $data['page_title'] = 'Email Sent';
        return view('modules/activate', $data);
    }





    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url());
    }


    public function activate($id = "")
    {
        try {

            $agent_arr = !empty($id) ? explode("_", base64_decode($id)) : "";
            $agent_id = !empty($agent_arr[0]) ? $agent_arr[0] : "";
            if (!empty($agent_id)) {
                $account_status = $this->account_status($agent_id); // 1-> not found, -> 2 - exist, 3-> registered, not active, 4 -> deactivated, contact admin

                if (!empty($account_status)) {

                    if ($account_status == 1) {
                        $data['msg'] = ACTIVATION_STATUS;
                    } else if ($account_status == 2) {
                        $data['msg'] = ALREADY_ACTIVE;
                    } else if ($account_status == 3) {
                        $data['msg'] = AGENT_ACCOUNT_DEACTIVE;
                    } else {
                        redirect(base_url());
                    }
                    $data['page_title'] = 'Account activation';
                    return view('modules/activate', $data);

                } else {
                    redirect(base_url());
                }
            } else {
                redirect(base_url());
            }

        } catch (Exception $e) {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);
        }

    }



    public function account_status($agent_id = ""): string
    {
        if (!empty($agent_id)) {
            $obj_agents = new AgentsModel();
            $where = array('agent_id' => $agent_id);
            $agent_detail = $obj_agents->get_agents($where);
            $status = 0;
            if (count($agent_detail) > 0) {
                if ($agent_detail[0]['agent_email_verified'] == 0 && $agent_detail[0]['agent_active'] == 1) {
                    $udpate_param = array('agent_email_verified' => 1);
                    $obj_agents->update_profile($udpate_param, $agent_id);
                    $status = 1; // not verified
                } else if ($agent_detail[0]['agent_email_verified'] == 1 && $agent_detail[0]['agent_active'] == 1) {
                    $status = 2;  // deactive, contact admin
                } else if ($agent_detail[0]['agent_email_verified'] == 1 && $agent_detail[0]['agent_active'] == 0) {
                    $status = 3;  // deactive, contact admin
                }

            } else {
                $status = 0;
            }
            return $status;

        }
        return false;

    }

    public function forget_password(){
        $data['page_title'] = 'Forget Password';
        return view('modules/forget_password', $data);
    }

    public function send_password_link(){
        $params['email'] = !empty($_POST['email']) ? $_POST['email'] : "";
        if (!empty($params['email'])) {
            $valid_email_status = $this->email_status($params); // 1-> not found, -> 2 - exist, 3-> registered, not active, 4 -> deactivated, contact admin
            $response['URL'] = base_url() . 'login';
           
            if ($valid_email_status == false) {

                $response['message'] = ACCOUNT_NOT_FOUND;
                session()->setFlashdata('error_msg', ACCOUNT_NOT_FOUND);
                $response['URL'] = base_url() . 'forget-password';
                return json_encode($response);

            }else{
                $response['URL'] = base_url() . 'forget-password';
                return json_encode($response);
            } 
        } else {
            $response['status'] = 0;
            $response['message'] = TECHNICAL_ERROR;
            return json_encode($response);

        }
    }


    public function email_status($login_param = array())
    {
        if (!empty($login_param)) {
            $obj_agents = new AgentsModel();
            if(!empty($login_param['email'])){
                $whare['agent_email'] = $login_param['email'];
            }
            $agent_detail = $obj_agents->get_agents($whare);
            if (count($agent_detail) > 0) {
                $this->send_forget_password_link($agent_detail);
                return true;
            } else {
                return false;
            }

        }
        return false;

    }

    public function send_forget_password_link($agent_detail){
            // $to = $email_arr['agent_email'];
            if (!empty($agent_detail)) {
                $agend_id = $agent_detail[0]['agent_id'] . '_' . ENCODE_SALT;
                $encode_agend_id = base64_encode($agend_id);     
                $mail = new \App\Libraries\Notification_sendgrid();
                $password_reset_link = base_url() . 'password-reset/' . $encode_agend_id;
                $to = $agent_detail[0]['agent_email'];
    
                $subject = "Please Verify Your Email Address";
                $message = "Hi {$agent_detail[0]['agent_first_name']},
                            <BR><BR>
                            Welcome to commission verification !
                            <BR><BR>
                            It seems like you requested a password reset for your account. No worries, we've got you covered!
                            <BR><BR>
                            To reset your password, simply click the link below:
                            <BR><BR>
                            {$password_reset_link   }
                            <BR><BR>
                            If you have any questions or need further assistance, feel free to reach out to our support team at
                            <BR><BR>
                            Thank you for joining us!
                             <BR><BR>
                            Best regards,";
                $headers = 'From: admin@commissionverification.com' . "\r\n" .
                    'Reply-To: admin@commissionverification.com' . "\r\n";
                
                $from = "admin@commissionverification.com";
                $from_name = "commission verification" ;   
                //echo $message; die;
                $mail->send_email($from, $from_name,  $to , $subject, $message, 'noreply@commissionverification.com');
                 // mail($to, $subject, $message, $headers);
                
            }
            $data['msg'] = FORGET_MAIL_SENT;
            session()->setFlashdata('success_smg', FORGET_MAIL_SENT);
            $data['page_title'] = 'Email Sent';
            redirect()->to(base_url().'forget-password');
            
        }

     
        public function reset_password($encode_agend_id = ""){
            $data['agend_id'] = !empty($encode_agend_id)?$encode_agend_id:""; 
            $data['page_title'] = 'Reset Password';
            return view('modules/reset_password', $data);
        }
        
        public function reset_password_value(){
            $encode_agend_id =  !empty($_POST['agend_id'])?$_POST['agend_id']:"";
            $password =  !empty($_POST['password'])?$_POST['password']:"";
              if (!empty($encode_agend_id) && !empty($password)) {
                //  //*********************************************** */
                    $agent_arr = !empty($encode_agend_id) ? explode("_", base64_decode($encode_agend_id)) : "";
                    $agent_id = !empty($agent_arr[0]) ? $agent_arr[0] : "";
                    $obj_agents = new AgentsModel();
                    $where = array('agent_id' => $agent_id);
                    $agent_detail = $obj_agents->get_agents($where);
                    
                    if(!empty($agent_detail[0])){
                        $update_param['agent_password'] = md5($password);
                        $obj_agents->update_profile($update_param,  $agent_id);
                        $response['message'] = PASSWORD_RESET;
                        session()->setFlashdata('success_smg', PASSWORD_RESET);
                        $response['URL'] = base_url() . 'login';
                        return json_encode($response);
                    }
                 //*********************************************** */

                   
             }



        }


    
}

<?php

//use CodeIgniter\CodeIgniter;

/**
 * Returns CodeIgniter's version.
 */
function is_admin(){
   
   return !empty($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0? true : false;
   
}


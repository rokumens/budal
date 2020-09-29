<?php
/*
* For PHP Info
* prepared by: luffy
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends CI_Controller {

    public function index()
    {
        $this->load->helper('url');
        $this->load->view('info');
    }
}

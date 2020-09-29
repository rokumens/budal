<style type='text/css'>body {background-color:#000 !important;}
.aw_yeah_logo{width:8%;height:auto;position:relative;margin:0;position:absolute;top:28%;left:50%;margin-right:-50%;transform:translate(-50%, -50%);}
.aw_yeah{width:8%;height:auto;position:relative;margin:0;position:absolute;top:48%;left:50%;margin-right:-50%;transform:translate(-50%, -50%);}
</style>
<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Api extends REST_Controller {
  function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->database();
  }
  function index_get(){
    #echo '<pre>';print_r($_POST);echo '<br />';print_r($_GET);die;
    #http://a2.kanonhost.com/api?ApprovalNote=%7Bapproval_note%7D&ApprovalNoteAll=%7Bapproval_note_all%7D&ApprovalStatus=Pending&DateCreated=2019-08-15%2021%3A24%3A46&EntryNumber=9&FormId=38780&FormName=Luffy%20FINANCE%20Form%20Test&HargaIDR=222&HargaUSD=123&IpAddress=%3A%3A1&data=Harga%20%28USD%29%3A%20123%20%0A%0AHarga%20%28IDR%29%3A%20222%20%0A%0APrice%3A%20Rp.%203333.44%20%0A%0ATotal%3A%20Rp0%20IDR%20%0A%0A
    // from finance form
    if((!empty($_GET))&&(!empty($this->get('FormId')))){
      $paramFormId=$this->get('FormId');
      $paramEntryNumber=$this->get('EntryNumber');
      $paramDateCreated=$this->get('DateCreated');
      $paramIpAddress=$this->get('IpAddress');
      $paramFormName=$this->get('FormName');
      $paramApprovalStatus=$this->get('ApprovalStatus');
      $paramApprovalNote=$this->get('ApprovalNote');
      $paramApprovalNoteAll=$this->get('ApprovalNoteAll');
      $paramHargaUSD=$this->get('HargaUSD');
      $paramHargaIDR=$this->get('HargaIDR');
      if($_SERVER['HTTP_HOST']=='localhost')
        $baseUrl='http://localhost/github/financeform';
      else $baseUrl='http://finance.form.hrdmanage.com';
      $urlView=$baseUrl."/view_entry.php?form_id=".$paramFormId."&entry_id=".$paramEntryNumber;
      $paramDataFull=$this->get('data');
      $tableName = "api_form_".$paramFormId;
      $checkTable = "SHOW TABLES LIKE '$tableName'";
      if(empty($this->db->query($checkTable)->result())){
        $sql = "CREATE TABLE ".$tableName." (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        form_id INT(6) NULL,
        form_name VARCHAR(255) NULL,
        entry_number INT(11),
        date_created DATETIME,
        ip_address VARCHAR(15) NULL,
        approval_status varchar(11) NOT NULL DEFAULT 'pending',
        approval_note TEXT NULL,
        approval_note_all TEXT NULL,
        harga_usd DECIMAL(62,2) NULL COMMENT 'Price',
        harga_idr DECIMAL(62,2) NULL COMMENT 'Price',
        url_view_entry TEXT NULL,
        data TEXT NULL
        )";
        $this->db->query($sql);
      }
      $hargaUsd = filter_var($paramHargaUSD, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
      $valueIdr = filter_var($paramHargaIDR, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
      if(substr($valueIdr, 0, 1)=='.'){
        $hargaIdr=ltrim($valueIdr, '.');
      }else{$hargaIdr=$valueIdr;}
      $data = array(
        'form_id'=>$paramFormId,
        'form_name'=>$paramFormName,
        'entry_number'=>$paramEntryNumber,
        // default from matchform
        'date_created'=>empty($paramDateCreated)?date("Y-m-d H:i:s"):$paramDateCreated,
        'ip_address'=>$paramIpAddress,
        'approval_status'=>empty($paramApprovalStatus)?'Pending':$paramApprovalStatus,
        'approval_note'=>empty($paramApprovalNote)?'':$paramApprovalNote,
        'approval_note_all'=>empty($paramApprovalNoteAll)?'':$paramApprovalNoteAll,
        // all elements
        'harga_usd'=>empty($paramHargaUSD)?'':$hargaUsd,  // ini boleh memungkinkan dikosongkan, info dari megane.
        'harga_idr'=>empty($paramHargaIDR)?'':$hargaIdr,  // tetap empty condition biar aman walau info dari megane required.
        'url_view_entry'=>$urlView,
        // all data entry
        'data'=>$paramDataFull
      );
      // go go go luffy :v
      $insert = $this->db->insert($tableName, $data);
      if ($insert) {
        $this->response($data, 200);
      } else {
        $this->response(array('status' => 'fail', 502));
      }
    }
    echo "<span style='margin:0;position:absolute;top:45%;left:50%;margin-right:-50%;color:#b3b6b7;transform:translate(-45%,-50%);font-size:95%;'>goo..muu...gomuuu...noooo!</span>
    <img class='aw_yeah_logo' src='https://emoji.slack-edge.com/T03JZKZCX/apg/5032c072b6a519ac.png'><br /><img class='aw_yeah' src='https://emoji.slack-edge.com/T03JZKZCX/luffy-gomu-gomu-no/37ed44d61ff41691.gif' />";
    header( "refresh:3; url=".site_url('admin'));
  }
  function index_post() {
    $data = array(
        'nama'    => $this->post('nama_blah'),
        'nomor'   => $this->post('nomor_blah')
        // 'message' => 'Kontak baru ditambahkan bosque.'
    );
    $insert = $this->db->insert('api_kontak', $data);
    if ($insert) {
      $this->response($data, 200);
    } else {
      $this->response(array('status' => 'fail', 502));
    }
  }

  function index_put() {
    $id = $this->put('id');
    $data = array(
      'id'       => $this->put('id'),
      'nama'     => $this->put('nama'),
      'nomor'    => $this->put('nomor')
    );
    $this->db->where('id', $id);
    $update = $this->db->update('api_kontak', $data);
    if ($update) {
      $this->response($data, 200);
    } else {
      $this->response(array('status' => 'fail', 502));
    }
  }

  function index_delete() {
    $id = $this->delete('id');
    $this->db->where('id', $id);
    $delete = $this->db->delete('api_kontak');
    if ($delete) {
      $this->response(array('status' => 'success'), 201);
    } else {
      $this->response(array('status' => 'fail', 502));
    }
  }

  function getIp(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
}
?>

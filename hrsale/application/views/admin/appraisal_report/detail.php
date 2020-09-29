<?php
/* Appraisal Report detail */
$currSubdeptId=0;
$isCsSales_WD_TF=FALSE;
if(!empty($allMainTask)){
  $arrSubdept=array();
  foreach($allMainTask as $key=>$singMainTask){
    $arrSubdept[$key]=$singMainTask->sub_department_id;
  }
  $currSubdeptId=$arrSubdept[0];
}
$session = $this->session->userdata('username');
$role_resources_ids = $this->Xin_model->user_role_resource();
if(($subDeptid==13)||($subDeptid==21)||($subDeptid==32))
  $isCsSales_WD_TF=TRUE;
?>
<style type='text/css'>
.borderless td, .borderless th {border:none!important;}
.putar{
  -moz-transition: all 0.5s ease;
  -ms-transform: rotate(90deg);
  -webkit-transition: all 0.5s ease;
  transition: all 0.5s ease;
}
.putar .naik{
  color:red;
  -moz-transform:rotate(-180deg); /* Firefox */
  -ms-transform: rotate(-180deg); /* IE 9 */
  -webkit-transform:rotate(-180deg); /* Chrome, Safari, Opera */
  transform:rotate(-180deg); /* Standard syntax */
}
.ui-state-active .putar{
   -moz-transform:rotate(90deg);
   -webkit-transform:rotate(90deg);
   transform:rotate(90deg);
}
</style>
<div class="row">
  <div class="col-md-12">
    <div class="box mb-4">
      <div class="box-header with-border">
        <h3 class="box-title">Period: <span class="text-danger" style='padding-left:5px;'><?=$period;?></span></h3>
        <!-- <div class="box-tools pull-right"> <a href="<?=site_url();?>admin/payroll/pdf_create/p/<?=$make_payment_id;?>/" class="btn btn-social-icon mb-1 btn-outline-github" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=$this->lang->line('xin_payroll_download_payslip');?>"><i class="fa fa-file-pdf-o"></i></a> </div> -->
      </div>
      <div class="box-body">
        <div class="table-responsive" data-pattern="priority-columns">
          <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
            <tbody>
              <tr>
                <td><strong class="help-split"><?=$this->lang->line('dashboard_employee_id');?>:</strong> <?=$employee_id;?></td>
                <td><strong class="help-split"><?=$this->lang->line('left_department');?>:</strong> <?=(strlen($department_name)>2)?ucwords(strtolower($department_name)):$department_name;?></td>
                <td><strong class="help-split">Office Location:</strong> <?=ucwords(strtolower($officeLocation));?></td>
              </tr>
              <tr>
                <td><strong class="help-split">Name:</strong> <?=ucwords(strtolower($first_name.' '.$last_name));?></td>
                <td><strong class="help-split">Sub <?=$this->lang->line('left_department');?>:</strong> <?=(strlen($subDeptName)>2)?ucwords(strtolower($subDeptName)):$subDeptName;?></td>
                <td><strong class="help-split"><?=$this->lang->line('xin_joining_date');?>:</strong> <?=$this->Xin_model->set_date_format($date_of_joining);?></td>
              </tr>
              <tr>
                <td><strong class="help-split">Nickname:</strong> <?=ucwords(strtolower($username));?></td>
                <td><strong class="help-split"><?=$this->lang->line('left_designation');?>:</strong> <?=$designation_name;?></td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row m-b-1">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> Report Details </h3> <span style="float:right;"> &laquo; <a href='<?=site_url();?>admin/appraisal_report'>Back to Appraisal Report</a></span>
      </div>
      <div class="box-body">
        <div id="accordion">
          <?///////////////////////////////////// API report data for AMP /////////////////////////////////////?>
          <?php #if($subDeptid==13): #withdrawal?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIwithdrawalAMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Withdrawal on AMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalALLAction_WD_AMP==0)?0:$totalALLAction_WD_AMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalALLAmount_WD_AMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIwithdrawalAMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
                          <td>Created Withdrawal on Anonymous</td>
                          <td><?=($totalAction_WD_168_Anonymous_CreatedBy_AMP==0)?0:$totalAction_WD_168_Anonymous_CreatedBy_AMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_WD_168_Anonymous_CreatedBy_AMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Created Withdrawal on Seniormasteragent</td>
                          <td><?=($totalAction_WD_168_Seniormasteragent_CreatedBy_AMP==0)?0:$totalAction_WD_168_Seniormasteragent_CreatedBy_AMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_WD_168_Seniormasteragent_CreatedBy_AMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Created Withdrawal on Ayosbobet</td>
                          <td><?=($totalAction_WD_168_Ayosbobet_CreatedBy_AMP==0)?0:$totalAction_WD_168_Ayosbobet_CreatedBy_AMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_WD_168_Ayosbobet_CreatedBy_AMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Created Withdrawal on SbobetHoki</td>
                          <td><?=($totalAction_WD_001_SbobetHoki_CreatedBy_AMP==0)?0:$totalAction_WD_001_SbobetHoki_CreatedBy_AMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_WD_001_SbobetHoki_CreatedBy_AMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Withdrawal on Anonymous</td>
                          <td><?=($totalAction_WD_168_Anonymous_ApprovedBy_AMP==0)?0:$totalAction_WD_168_Anonymous_ApprovedBy_AMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_WD_168_Anonymous_ApprovedBy_AMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Withdrawal on Seniormasteragent</td>
                          <td><?=($totalAction_WD_168_Seniormasteragent_ApprovedBy_AMP==0)?0:$totalAction_WD_168_Seniormasteragent_ApprovedBy_AMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_WD_168_Seniormasteragent_ApprovedBy_AMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Withdrawal on Ayosbobet</td>
                          <td><?=($totalAction_WD_168_Ayosbobet_ApprovedBy_AMP==0)?0:$totalAction_WD_168_Ayosbobet_ApprovedBy_AMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_WD_168_Ayosbobet_ApprovedBy_AMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Withdrawal on SbobetHoki</td>
                          <td><?=($totalAction_WD_001_SbobetHoki_CreatedBy_AMP==0)?0:$totalAction_WD_001_SbobetHoki_CreatedBy_AMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_WD_001_SbobetHoki_CreatedBy_AMP,2,',','.');?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #endif; #withdrawal?>
          <?php #if($subDeptid==32): #cs depo?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIdepoAMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Deposit on AMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalALLAction_DEPO_AMP==0)?0:$totalALLAction_DEPO_AMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalALLAmount_DEPO_AMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIdepoAMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
  												<td>Created Deposit on Anonymous</td>
                          <td><?=($totalAction_DEPO_168_Anonymous_CreatedBy_AMP==0)?0:$totalAction_DEPO_168_Anonymous_CreatedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_DEPO_168_Anonymous_CreatedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Created Deposit on Seniormasteragent</td>
                          <td><?=($totalAction_DEPO_168_Seniormasteragent_CreatedBy_AMP==0)?0:$totalAction_DEPO_168_Seniormasteragent_CreatedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_DEPO_168_Seniormasteragent_CreatedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Created Deposit on Ayosbobet</td>
                          <td><?=($totalAction_DEPO_168_Ayosbobet_CreatedBy_AMP==0)?0:$totalAction_DEPO_168_Ayosbobet_CreatedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_DEPO_168_Ayosbobet_CreatedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Created Deposit on SbobetHoki</td>
                          <td><?=($totalAction_DEPO_001_SbobetHoki_CreatedBy_AMP==0)?0:$totalAction_DEPO_001_SbobetHoki_CreatedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_DEPO_001_SbobetHoki_CreatedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Approved Deposit on Anonymous</td>
                          <td><?=($totalAction_DEPO_168_Anonymous_ApprovedBy_AMP==0)?0:$totalAction_DEPO_168_Anonymous_ApprovedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_DEPO_168_Anonymous_ApprovedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Approved Deposit on Seniormasteragent</td>
                          <td><?=($totalAction_DEPO_168_Seniormasteragent_ApprovedBy_AMP==0)?0:$totalAction_DEPO_168_Seniormasteragent_ApprovedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_DEPO_168_Seniormasteragent_ApprovedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Approved Deposit on Ayosbobet</td>
                          <td><?=($totalAction_DEPO_168_Ayosbobet_ApprovedBy_AMP==0)?0:$totalAction_DEPO_168_Ayosbobet_ApprovedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_DEPO_168_Ayosbobet_ApprovedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Approved Deposit on SbobetHoki</td>
                          <td><?=($totalAction_DEPO_001_SbobetHoki_ApprovedBy_AMP==0)?0:$totalAction_DEPO_001_SbobetHoki_ApprovedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_DEPO_001_SbobetHoki_ApprovedBy_AMP,2,',','.');?></td>
  											</tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #endif; #cs depo?>
          <?php #TF?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APItransferAMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Transfer on AMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalALLAction_TF_AMP==0)?0:$totalALLAction_TF_AMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalALLAmount_TF_AMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APItransferAMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
  												<td>Created Transfer on Anonymous</td>
                          <td><?=($totalAction_TF_168_Anonymous_CreatedBy_AMP==0)?0:$totalAction_TF_168_Anonymous_CreatedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_TF_168_Anonymous_CreatedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Created Transfer on Seniormasteragent</td>
                          <td><?=($totalAction_TF_168_Seniormasteragent_CreatedBy_AMP==0)?0:$totalAction_TF_168_Seniormasteragent_CreatedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_TF_168_Seniormasteragent_CreatedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Created Transfer on Ayosbobet</td>
                          <td><?=($totalAction_TF_168_Ayosbobet_CreatedBy_AMP==0)?0:$totalAction_TF_168_Ayosbobet_CreatedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_TF_168_Ayosbobet_CreatedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Created Transfer on SbobetHoki</td>
                          <td><?=($totalAction_TF_001_SbobetHoki_CreatedBy_AMP==0)?0:$totalAction_TF_001_SbobetHoki_CreatedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_TF_001_SbobetHoki_CreatedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Approved Transfer on Anonymous</td>
                          <td><?=($totalAction_TF_168_Anonymous_ApprovedBy_AMP==0)?0:$totalAction_TF_168_Anonymous_ApprovedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_TF_168_Anonymous_ApprovedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Approved Transfer on Seniormasteragent</td>
                          <td><?=($totalAction_TF_168_Seniormasteragent_ApprovedBy_AMP==0)?0:$totalAction_TF_168_Seniormasteragent_ApprovedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_TF_168_Seniormasteragent_ApprovedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Approved Transfer on Ayosbobet</td>
                          <td><?=($totalAction_TF_168_Ayosbobet_ApprovedBy_AMP==0)?0:$totalAction_TF_168_Ayosbobet_ApprovedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_TF_168_Ayosbobet_ApprovedBy_AMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Approved Transfer on SbobetHoki</td>
                          <td><?=($totalAction_TF_001_SbobetHoki_ApprovedBy_AMP==0)?0:$totalAction_TF_001_SbobetHoki_ApprovedBy_AMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_TF_001_SbobetHoki_ApprovedBy_AMP,2,',','.');?></td>
  											</tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #endif; #TF?>
          <?///////////////////////////////////// API report data for AMP /////////////////////////////////////?>

          <?///////////////////////////////////// API report data for TMP /////////////////////////////////////?>
          <?php #deposit?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIdepoTMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Deposit on TMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalAllAction_DEPO_TMP==0)?0:$totalAllAction_DEPO_TMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalAllAmount_DEPO_TMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIdepoTMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
  												<td>Created Deposit</td>
                          <td><?=($totalAction_DEPO_CreatedBy_TMP==0)?0:$totalAction_DEPO_CreatedBy_TMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_DEPO_CreatedBy_TMP,2,',','.');?></td>
  											</tr>
                        <tr>
  												<td>Approved Deposit</td>
                          <td><?=($totalAction_DEPO_ApprovedBy_TMP==0)?0:$totalAction_DEPO_ApprovedBy_TMP.' x'?></td>
  												<td>Rp. <?=number_format($totalAmount_DEPO_ApprovedBy_TMP,2,',','.');?></td>
  											</tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #deposit?>
          <?php #withdrawal?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIwidthdrawalTMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Withdrawal on TMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalAllAction_WD_TMP==0)?0:$totalAllAction_WD_TMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalAllAmount_WD_TMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIwidthdrawalTMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
                          <td>Created Withdrawal</td>
                          <td><?=($totalAction_WD_CreatedBy_TMP==0)?0:$totalAction_WD_CreatedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_WD_CreatedBy_TMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Withdrawal</td>
                          <td><?=($totalAction_WD_ApprovedBy_TMP==0)?0:$totalAction_WD_ApprovedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_WD_ApprovedBy_TMP,2,',','.');?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #withdrawal?>
          <?php #transfer?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APItransferTMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Transfer on TMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalAllAction_TF_TMP==0)?0:$totalAllAction_TF_TMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalAllAmount_TF_TMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APItransferTMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
                          <td>Created Transfer</td>
                          <td><?=($totalAction_TF_CreatedBy_TMP==0)?0:$totalAction_TF_CreatedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_TF_CreatedBy_TMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Transfer</td>
                          <td><?=($totalAction_TF_ApprovedBy_TMP==0)?0:$totalAction_TF_ApprovedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_TF_ApprovedBy_TMP,2,',','.');?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #transfer?>
          <?php #adjustment?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIadjustmentTMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Adjustment on TMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalAllAction_ADJ_TMP==0)?0:$totalAllAction_ADJ_TMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalAllAmount_ADJ_TMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIadjustmentTMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
                          <td>Created Adjustment</td>
                          <td><?=($totalAction_ADJ_CreatedBy_TMP==0)?0:$totalAction_ADJ_CreatedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_ADJ_CreatedBy_TMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Adjustment</td>
                          <td><?=($totalAction_ADJ_ApprovedBy_TMP==0)?0:$totalAction_ADJ_ApprovedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_ADJ_ApprovedBy_TMP,2,',','.');?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #adjustment?>
          <?php #bonus?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIbonusTMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Bonus on TMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalAllAction_BONUS_TMP==0)?0:$totalAllAction_BONUS_TMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalAllAmount_BONUS_TMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIbonusTMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
                          <td>Created Bonus</td>
                          <td><?=($totalAction_BONUS_CreatedBy_TMP==0)?0:$totalAction_BONUS_CreatedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_BONUS_CreatedBy_TMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Bonus</td>
                          <td><?=($totalAction_BONUS_ApprovedBy_TMP==0)?0:$totalAction_BONUS_ApprovedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_BONUS_ApprovedBy_TMP,2,',','.');?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #bonus?>
          <?php #comission?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIcomissionTMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Comission on TMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalAllAction_COMMISSION_TMP==0)?0:$totalAllAction_COMMISSION_TMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalAllAmount_COMMISSION_TMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIcomissionTMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
                          <td>Created Comission</td>
                          <td><?=($totalAction_COMMISSION_CreatedBy_TMP==0)?0:$totalAction_COMMISSION_CreatedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_COMMISSION_CreatedBy_TMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Comission</td>
                          <td><?=($totalAction_COMMISSION_ApprovedBy_TMP==0)?0:$totalAction_COMMISSION_ApprovedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_COMMISSION_ApprovedBy_TMP,2,',','.');?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #comission?>
          <?php #cashback?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIcashbackTMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Cashback on TMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalAllAction_CASHBACK_TMP==0)?0:$totalAllAction_CASHBACK_TMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalAllAmount_CASHBACK_TMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIcashbackTMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
                          <td>Created Cashback</td>
                          <td><?=($totalAction_CASHBACK_CreatedBy_TMP==0)?0:$totalAction_CASHBACK_CreatedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_CASHBACK_CreatedBy_TMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Cashback</td>
                          <td><?=($totalAction_CASHBACK_ApprovedBy_TMP==0)?0:$totalAction_CASHBACK_ApprovedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_CASHBACK_ApprovedBy_TMP,2,',','.');?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #cashback?>
          <?php #referral?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIreferralTMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Referral on TMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalAllAction_REFERRAL_TMP==0)?0:$totalAllAction_REFERRAL_TMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalAllAmount_REFERRAL_TMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIreferralTMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
                          <td>Created Referral</td>
                          <td><?=($totalAction_REFERRAL_CreatedBy_TMP==0)?0:$totalAction_REFERRAL_CreatedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_REFERRAL_CreatedBy_TMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Referral</td>
                          <td><?=($totalAction_REFERRAL_ApprovedBy_TMP==0)?0:$totalAction_REFERRAL_ApprovedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_REFERRAL_ApprovedBy_TMP,2,',','.');?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #referral?>
          <?php #freebet?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIfreebetTMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Freebet on TMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalAllAction_FREEBET_TMP==0)?0:$totalAllAction_FREEBET_TMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalAllAmount_FREEBET_TMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIfreebetTMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
                          <td>Created Freebet</td>
                          <td><?=($totalAction_FREEBET_CreatedBy_TMP==0)?0:$totalAction_FREEBET_CreatedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_FREEBET_CreatedBy_TMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Freebet</td>
                          <td><?=($totalAction_FREEBET_ApprovedBy_TMP==0)?0:$totalAction_FREEBET_ApprovedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_FREEBET_ApprovedBy_TMP,2,',','.');?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #freebet?>
          <?php #affiliate?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIaffiliateTMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Affiliate on TMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalAllAction_AFFILIATE_TMP==0)?0:$totalAllAction_AFFILIATE_TMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalAllAmount_AFFILIATE_TMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIaffiliateTMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
                          <td>Created Affiliate</td>
                          <td><?=($totalAction_AFFILIATE_CreatedBy_TMP==0)?0:$totalAction_AFFILIATE_CreatedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_AFFILIATE_CreatedBy_TMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Affiliate</td>
                          <td><?=($totalAction_AFFILIATE_ApprovedBy_TMP==0)?0:$totalAction_AFFILIATE_ApprovedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_AFFILIATE_ApprovedBy_TMP,2,',','.');?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #affiliate?>
          <?php #surrender?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIsurrenderTMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Surrender on TMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalAllAction_SURRENDER_TMP==0)?0:$totalAllAction_SURRENDER_TMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalAllAmount_SURRENDER_TMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIsurrenderTMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
                          <td>Created Surrender</td>
                          <td><?=($totalAction_SURRENDER_CreatedBy_TMP==0)?0:$totalAction_SURRENDER_CreatedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_SURRENDER_CreatedBy_TMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Surrender</td>
                          <td><?=($totalAction_SURRENDER_ApprovedBy_TMP==0)?0:$totalAction_SURRENDER_ApprovedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_SURRENDER_ApprovedBy_TMP,2,',','.');?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #surrender?>
          <?php #cancel?>
            <div class="card mb-2">
              <div class="card-header">
                <table class="table borderless" style='margin-bottom:0!important;'>
                  <thead>
                    <tr>
                      <th style='width:40%;'>
                        <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#APIcancelTMP" aria-expanded="false">
                          <!-- <i class="fa fa-angle-down putar naik"></i> -->
                          <strong>Cancel on TMP</strong>
                        </a>
                      </th>
                      <th style='width:30%;'>Total Action: <?=($totalAllAction_CANCEL_TMP==0)?0:$totalAllAction_CANCEL_TMP.' x'?></th>
                      <th style='width:30%;'>Total Amount: Rp. <?=number_format($totalAllAmount_CANCEL_TMP,2,',','.');?><span style='float:right;'>Grade: -</span></th>
                    </tr>
                  </thead>
                </table>
              </div>
              <div id="APIcancelTMP" class="collapse" data-parent="#accordion" style="">
                <div class="box-body">
                  <div class="table-responsive" data-pattern="priority-columns">
                    <table class="datatables-demo table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style='width:40%;'>Job</th>
                          <th style='width:30%;'>Action</th>
                          <th style='width:30%;'>Amount</th>
                        </tr>
                        <tr>
                          <td>Created Cancel</td>
                          <td><?=($totalAction_CANCEL_CreatedBy_TMP==0)?0:$totalAction_CANCEL_CreatedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_CANCEL_CreatedBy_TMP,2,',','.');?></td>
                        </tr>
                        <tr>
                          <td>Approved Cancel</td>
                          <td><?=($totalAction_CANCEL_ApprovedBy_TMP==0)?0:$totalAction_CANCEL_ApprovedBy_TMP.' x'?></td>
                          <td>Rp. <?=number_format($totalAmount_CANCEL_ApprovedBy_TMP,2,',','.');?></td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php #cancel?>
          <?///////////////////////////////////// API report data for TMP /////////////////////////////////////?>

          <?php #if($subDeptid==21): #cs sales?>
          <div class="card mb-2">
            <div class="card-header">
              <table class="table borderless" style='margin-bottom:0!important;'>
                <thead>
                  <tr>
                    <th style='width:40%;'>
                      <a class="text-dark collapsed luffyputar" data-toggle="collapse" href="#callActionReport" aria-expanded="false">
                        <!-- <i class="fa fa-angle-down putar naik"></i> -->
                        <strong>Call Action Report</strong>
                      </a>
                    </th>
                    <th style='width:60%;'>
                      Total Action: <?php
                      if($reportType==='daily')
                        $totalActionCall=$this->Appraisal_report_model->a1TotalCallActionByEmailDaily($employeeEmail,$reportMonth);
                      elseif($reportType==='monthly')
                        $totalActionCall=$this->Appraisal_report_model->a1TotalCallActionByEmailMonthly($employeeEmail,$reportMonth);
                      elseif($reportType==='custom')
                        $totalActionCall=$this->Appraisal_report_model->a1TotalCallActionByEmailCustom($employeeEmail,$reportMonth,$reportMonthTo);
                      $totalSummarycall=$totalActionCall->total;
                      (0==$totalSummarycall)?$times='':$times=' x';
                      echo number_format($totalSummarycall,0,'','.').$times;
                      ;?>
                      <span style='float:right;'>Grade: -</span>
                    </th>
                    <!-- <th style='width:30%;'>Grade: <?=$finalGrade;?></th> -->
                  </tr>
                </thead>
              </table>
            </div>
            <div id="callActionReport" class="collapse" data-parent="#accordion" style="">
              <div class="box-body">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th style='width:40%;'>Job</th>
                        <th style='width:60%;'>Action</th>
                        <!-- <th style='width:30%;'>Result</th> -->
                      </tr>
                      <?php $key=0;foreach($allConnectResponse as $key=>$singConnectResponse):
                        //report type
                        if($reportType==='daily')
  												$totalActionCall=$this->Appraisal_report_model->a1TotalCallActionByResponseIdAndEmailDaily($singConnectResponse->id,$employeeEmail,$reportMonth);
                        elseif($reportType==='monthly')
                          $totalActionCall=$this->Appraisal_report_model->a1TotalCallActionByResponseIdAndEmailMonthly($singConnectResponse->id,$employeeEmail,$reportMonth);
                        elseif($reportType==='custom')
                          $totalActionCall=$this->Appraisal_report_model->a1TotalCallActionByResponseIdAndEmailCustom($singConnectResponse->id,$employeeEmail,$reportMonth,$reportMonthTo);
                        $totalConnectResponseCall=$totalActionCall->total;
											?>
                      <tr>
												<td><?=$singConnectResponse->name;?></td>
												<td><?=($totalConnectResponseCall==0)?0:number_format($totalConnectResponseCall,0,'','.')." x";?></td>
												<!-- <td><?='Belum ada';?></td> -->
											</tr>
											<?php endforeach;?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php #endif;
            if(!empty($allMainTask)): foreach($allMainTask as $singMainTask):
            $idAccordion=strtolower(preg_replace("/[^a-zA-Z0-9]/", "", $singMainTask->taskName));
            #$getActualGrade=$this->Appraisal_report_model->getGradeByMaintaskEmployeeId($singMainTask->id,$userId)->grade_name;
            //report type
            if($reportType==='daily'){
              $currAppraisal=$this->Appraisal_report_model->getAppraisalByMaintaskEmployeeDaily($singMainTask->id,$userId,$reportMonth);
              $finalGrade='-';
              if(!empty($currAppraisal)){
                $finalGradeId=$currAppraisal->final_grade_id;
                if(!empty($this->Appraisal_report_model->getGradeNameByFinalGradeIdDaily($finalGradeId,$singMainTask->id,$userId,$reportMonth))){
                  $finalGrade=$this->Appraisal_report_model->getGradeNameByFinalGradeIdDaily($finalGradeId,$singMainTask->id,$userId,$reportMonth)->gradeName;
                }
              }
            }elseif($reportType==='monthly'){
              $currAppraisal=$this->Appraisal_report_model->getAppraisalByMaintaskEmployeeMonthly($singMainTask->id,$userId,$reportMonth);
              $finalGrade='-';
              if(!empty($currAppraisal)){
                $finalGradeId=$currAppraisal->final_grade_id;
                if(!empty($this->Appraisal_report_model->getGradeNameByFinalGradeIdMonthly($finalGradeId,$singMainTask->id,$userId,$reportMonth))){
                  $finalGrade=$this->Appraisal_report_model->getGradeNameByFinalGradeIdMonthly($finalGradeId,$singMainTask->id,$userId,$reportMonth)->gradeName;
                }
              }
            }elseif($reportType==='custom'){
              $currAppraisal=$this->Appraisal_report_model->getAppraisalByMaintaskEmployeeCustom($singMainTask->id,$userId,$reportMonth,$reportMonthTo);
              $finalGrade='-';
              if(!empty($currAppraisal)){
                $finalGradeId=$currAppraisal->final_grade_id;
                if(!empty($this->Appraisal_report_model->getGradeNameByFinalGradeIdCustom($finalGradeId,$singMainTask->id,$userId,$reportMonth,$reportMonthTo))){
                  $finalGrade=$this->Appraisal_report_model->getGradeNameByFinalGradeIdCustom($finalGradeId,$singMainTask->id,$userId,$reportMonth,$reportMonthTo)->gradeName;
                }
              }
            }
          ?>
          <div class="card mb-2">
            <div class="card-header">
              <table class="table borderless" style='margin-bottom:0!important;'>
                <thead>
                  <tr>
                    <th style='width:40%;'>
                      <a class="text-dark luffyputar" data-toggle="collapse" href="#<?=$idAccordion;?>" aria-expanded="false">
                        <!-- <i class="fa fa-angle-down putar naik"></i> -->
                        <?=ucwords(strtolower($singMainTask->taskName));?>
                      </a>
                    </th>
                    <th style='width:60%;'>
                      Total Action: <?php
                      if($reportType==='daily')
                        $totalPointSubByMaintask=$this->Appraisal_report_model->totalPointByMainTaskDaily($singMainTask->id,$userId,$reportMonth);
                      elseif($reportType==='monthly')
                        $totalPointSubByMaintask=$this->Appraisal_report_model->totalPointByMainTaskMonthly($singMainTask->id,$userId,$reportMonth);
                      elseif($reportType==='custom')
                        $totalPointSubByMaintask=$this->Appraisal_report_model->totalPointByMainTaskCustom($singMainTask->id,$userId,$reportMonth,$reportMonthTo);
                      $totalSummaryMainTask=$totalPointSubByMaintask->subTaskTotalPointByMainTask;
                      (0==$totalSummaryMainTask)?$times='':$times='x';
                      echo number_format($totalSummaryMainTask,0,'','.').$times;
                      ;?>
                      <span style='float:right;'>Grade: <?=$finalGrade;?></span>
                    </th>
                    <!-- <th style='width:30%;'>Grade: <?=$finalGrade;?></th> -->
                  </tr>
                </thead>
              </table>
            </div>
            <div id="<?=$idAccordion;?>" class="collapse" data-parent="#accordion">
              <div class="box-body">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="datatables-demo table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th style='width:40%;'>Job</th>
                        <th style='width:60%;'>Action</th>
                        <!-- <th style='width:30%;'><?#='Result';?></th> -->
                      </tr>
                      <?php
                        $allSubtaskTitle=$this->Appraisal_sub_task_model->getAllSubtaskTitleByMainTaskId($singMainTask->id);
                        foreach($allSubtaskTitle as $singSubtask):
                        if($reportType==='daily')
                          $totalPointSub=$this->Appraisal_report_model->totalPointBySubtaskTitleDaily($singSubtask->id,$singMainTask->id,$userId,$reportMonth);
                        elseif($reportType==='monthly')
                          $totalPointSub=$this->Appraisal_report_model->totalPointBySubtaskTitleMonthly($singSubtask->id,$singMainTask->id,$userId,$reportMonth);
                        elseif($reportType==='custom')
                          $totalPointSub=$this->Appraisal_report_model->totalPointBySubtaskTitleCustom($singSubtask->id,$singMainTask->id,$userId,$reportMonth,$reportMonthTo);
                      	$totalPointSubTask=$totalPointSub->subTaskTotalPoint;
											?>
                      <tr>
												<td><?=ucwords($singSubtask->sub_task_title_name);?></td>
												<td><?=$totalPointSubTask==0?0:$totalPointSubTask.' x';?></td>
												<!-- <td><?#='Belum ada';?></td> -->
											</tr>
                      <?php endforeach;?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach;else: if(!$isCsSales_WD_TF):?>
          <div class="card mb-2">
            <div class="card-header">No Main Task yet under <?=$subDeptName;?> subdepartment or Shift.
              <?php if(in_array('2005',$role_resources_ids)):?>
              <div>Create one <a href='<?=site_url();?>admin/appraisal_task_list'>here</a> &raquo;</div>
            <?php endif;?>
            </div>
          </div>
          <?php endif;endif;?>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="col-md-4">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"> Total Result </h3>
          </div>
          <div class="box-body">
            <div class="table-responsive" data-pattern="priority-columns">
              <table class="datatables-demo table table-striped table-bordered dataTable no-footer">
                <tbody>
                  <tr>
                    <td><strong>Aaa:</strong> <span class="pull-right">bbb</span></td>
                  </tr>
                  <tr>
                    <td><strong>Ccc:</strong> <span class="pull-right">ddd</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
</div>
<!-- pd-->

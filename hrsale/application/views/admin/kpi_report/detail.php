<?php
/* Appraisal Report detail */
$currSubdeptId=0;
$isCsSales_WD_TF=FALSE;
if(!empty($allKpi)){
  $arrSubdept=array();
  foreach($allKpi as $key=>$singKpi){
    $arrSubdept[$key]=$singKpi->sub_department_id;
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
        <h3 class="box-title"> Report Details </h3> <span style="float:right;"> &laquo; <a href='<?=site_url();?>admin/kpi_report'>Back to Kpi Report List</a></span>
      </div>
      <div class="box-body">
        <div>
          <?php
            $totalBonusAchieved=0;
            if(!empty($allKpi)):
          ?>
          <div class="card mb-2">
            <div class="card-header">
              <table class="table" style='margin-bottom:0!important;'>
                <thead>
                  <tr>
                    <th style='width:50%;'>Main Task</th>
                    <th style='width:50%;'>Bonus</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allKpi as $singKpi):?>
                  <tr>
                    <td style='width:50%;'>
                      <?=ucwords(strtolower($singKpi->taskName));?>
                    </td>
                    <td style='width:50%;'>
                      <?php
                      $checkEmployeeBonus=$this->Kpi_report_model->employeeBonusAchieved($userId,$singKpi->maintask_id,$startDate,$toDate);
                      if((!empty($checkEmployeeBonus))||($checkEmployeeBonus!=0)){
                        $employeeBonus=$checkEmployeeBonus->employeeBonusAchieved;
                      }else{
                        $employeeBonus=0;
                      }
                      $eachBonusAchieved=$employeeBonus;?>
                      <?=$this->Xin_model->currency_sign($eachBonusAchieved);
                        $totalBonusAchieved+=$eachBonusAchieved;
                      ?>
                    </td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
                <tfoot>
                  <tr>
                    <th style='width:50%;'>Total Bonus</th>
                    <th style='width:50%;'><?=$this->Xin_model->currency_sign($totalBonusAchieved);?></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <?php else: #if(!$isCsSales_WD_TF):?>
          <div class="card mb-2">
            <div class="card-header">No KPI Sales yet for <?=$subDeptName;?> subdepartment.</u>.
              <?php if(in_array('2005',$role_resources_ids)):?>
              <div>Create one <a href='<?=site_url();?>admin/kpi_sales'>here</a> &raquo;</div>
            <?php endif;?>
            </div>
          </div>
        <?php endif;#endif;?>
        </div>
      </div>
    </div>
  </div>
</div>

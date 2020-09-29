<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['employee_id']) && $_GET['data']=='payroll_template' && $_GET['type']=='payroll_template'){
if($profile_picture!='' && $profile_picture!='no file') {
	$u_file = 'uploads/profile/'.$profile_picture;
} else {
	if($gender=='Male') {
		$u_file = 'uploads/profile/default_male.jpg';
	} else {
		$u_file = 'uploads/profile/default_female.jpg';
	}
}
?>
<div class="modal-header animated fadeInRight">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">Employee's Report</h4>
</div>
<div class="modal-body animated fadeInRight">
  <div class="row row-md">
    <div class="col-md-12">
      <div class="card">
        <div class="bg-white product-view">
          <div class="box-block">
            <div class="row">
              <div class="col-md-12 col-sm-7">
                <div class="box box-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-yellow1">
                    <div class="widget-user-image"> <img class="img-circle" src="<?php echo base_url().$u_file;?>" alt="<?php echo $first_name.' '.$last_name;?>"> </div>
                    <h3 class="widget-user-username"><?php echo $first_name.' '.$last_name;?></h3>
                    <h5 class="widget-user-desc"><?php echo $designation_name;?></h5>
                  </div>
                  <div class="no-padding">
                    <ul class="nav nav-stacked">
                      <li><a href="javascript:void(0);"><?php echo $this->lang->line('xin_emp_id');?> <span class="pull-right"><?php echo $employee_id;?></span></a></li>
                      <li><a href="javascript:void(0);"><?php echo $this->lang->line('left_department');?> <span class="pull-right"><?php echo $department_name;?></span></a></li>
                      <li><a href="javascript:void(0);">Location<span class="pull-right badge"><?php echo $office_location;?></span></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-1">
    <div class="col-sm-12 col-xs-12 col-xl-12">
      <div class="card-header text-uppercase"><b>Report Details for <span class="text-danger" id="p_month"><?=$reportMonthFormat;?></span></b></div>
      <div class="card-block">
        <div id="accordion">
          <div class="card mb-2">
          </div>
          <div class="card mb-2">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#attendance" aria-expanded="false"> <strong>Attendance Report</strong> </a> </div>
            <div id="attendance" class="collapse" data-parent="#accordion" style="">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <thead>
                      <tr>
                        <!-- <th>#</th> -->
                        <th style='width:300px;'>Job</th>
                        <th>Action</th>
                        <th>Result</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // $no=1; $overtime_amount = 0; foreach($overtime->result() as $r_overtime) {
          						// $overtime_total = $r_overtime->overtime_hours * $r_overtime->overtime_rate;
          						// $overtime_amount += $overtime_total;
											$role_resources_ids=$this->Xin_model->user_role_resource();
											if(in_array("28",$role_resources_ids)):
												$totalLupaAbsen=$this->Reports_model->totalLupaAbsenByDateAndEmployeeId($reportMonth,$employeeId)->totalLupaAbsen;
												$totalTelat=$this->Reports_model->totalLateByDateAndEmployeeId($reportMonth,$employeeId)->totalTelat;
          						?>
                      <tr>
                        <!-- <th scope="row"><?php #echo $no;?></th> -->
                        <td>Terlambat</td>
                        <td><?=$totalTelat==0?'Belum pernah':$totalTelat." kali";?></td>
                        <td>Belum ada</td>
                      </tr>
											<?php endif;?>
											<?php if(in_array('1017',$role_resources_ids)):?>
											<tr>
                        <td>Lupa Absen</td>
                        <td><?=$totalLupaAbsen==0?'Belum pernah':$totalLupaAbsen." kali";?></td>
                        <td>Belum ada</td>
                      </tr>
											<?php endif;?>
                      <?php #$i++; } ?>
                    </tbody>
                    <!-- <tfoot>
                      <tr>
                        <td colspan="3" align="right"><strong><?php #echo $this->lang->line('xin_acc_total');?>:</strong></td>
                        <td><?php #echo $this->Xin_model->currency_sign($overtime_amount);?></td>
                      </tr>
                    </tfoot> -->
                  </table>
                </div>
              </div>
            </div>
          </div>
					<?php if(($subDepartmentId==21)||($subDepartmentId==32)):?>
          <div class="card mb-2">
            <div class="card-header"> <a class="text-dark collapsed" data-toggle="collapse" href="#callaction" aria-expanded="false"> <strong>Call Action Report</strong> </a> </div>
            <div id="callaction" class="collapse" data-parent="#accordion" style="">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <thead>
                      <tr>
                        <th style='width:300px;'>Job</th>
                        <th>Action</th>
                        <th>Result</th>
                      </tr>
                    </thead>
                    <tbody>
											<?php $key=0;foreach($allConnectResponse as $key=>$singConnectResponse):
												$totalActionCall=$this->Reports_model->a1TotalCallActionByResponseIdAndEmail($reportMonth,$singConnectResponse->id,$employeeEmail);
												$totalCall=$totalActionCall->total;
											?>
											<tr>
												<td><?=$singConnectResponse->name;?></td>
												<td><?=$totalCall==0?0:number_format($totalCall,0,'','.')." kali";?></td>
												<td><?='Belum ada';?></td>
											</tr>
											<?php endforeach;?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>

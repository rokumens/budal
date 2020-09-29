<?php
/*
* Luffy 9 Dec 2019 - 03:59 pm
* Warning Detail view
*/
?>
<style type="text/css">
.iframe-container {
  padding-bottom: 60%;
  padding-top: 30px; height: 0; overflow: hidden;
}
.iframe-container iframe,
.iframe-container object,
.iframe-container embed {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
.luffy-modal {
  width: 65%;
  margin: auto;
}
</style>
<?php
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row m-b-1 <?=$get_animate;?>">
  <div class="col-md-4">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> Details </h3>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <div class="datatables-demo table table-striped table-bordered" data-pattern="priority-columns">
                  <table class="table table-striped m-md-b-0">
                    <tbody>
                      <tr>
                        <th scope="row">Warning to</th>
                        <td class="text-right">
                          <?=$warningToFullName;?>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Warning type</th>
                        <td class="text-right"><?=$warningType;?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="datatables-demo table table-striped" data-pattern="priority-columns">
                  <table class="table table-striped m-md-b-0">
                    <tbody>
                      <tr>
                        <th scope="row">Warned by</th>
                        <td class="text-right"><?=$warningByFullName;?></td>
                      </tr>
                      <tr>
                        <th scope="row">Warning date</th>
                        <td class="text-right"><?=$warningDate;?></td>
                      </tr>
                      <tr>
                        <th scope="row">Approval by</th>
                        <td class="text-right">
                          <?=$approval_1_by;?> and <?=$approval_2_by;?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="col-md-8 <?=$get_animate;?>">
    <div class="col-xl-12 col-lg-12">
      <div class="box">
        <div class="box-block">
          <ul class="nav nav-tabs nav-top-border no-hover-bg">
            <li class="nav-item active"> <a class="nav-link active" id="baseIcon-tab11" data-toggle="tab" aria-controls="tabIcon11" href="#tabIcon11" aria-expanded="true"><i class="fa fa-comment"></i> Approval</a> </li>
          </ul>
          <!-- tab -->
          <div class="tab-content pt-1">
            <div role="tabpanel" class="tab-pane active <?=$get_animate;?>" id="tabIcon11" aria-expanded="true" aria-labelledby="baseIcon-tab11">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <?php $attributes2 = array('name' => 'update_warning_detail', 'id' => 'update_warning_detail', 'autocomplete' => 'off');?>
                    <?php $hidden2 = array('user_id' => $session['user_id']);?>
                    <?=form_open('admin/warning/update_warning_detail/'.$warningId, $attributes2, $hidden2);?>
                    <?php
            					$dataApproval = array(
            					  'name'        => 'warning_id',
            					  'id'          => 'warning_id',
            					  'type'        => 'hidden',
            					  'value'   	   => $warningId,
            					  'class'       => 'form-control',
            					);
            					echo form_input($dataApproval);
          					?>
                    <div class="datatables-demo table table-striped" data-pattern="priority-columns">
                      <table class="table table-striped m-md-b-0">
                        <tbody>
                          <tr>
                            <th width="20%">Number</th>
                            <td width="60%"><?=$letterNumber;?></td>
                          </tr>
                          <tr>
                            <th width="20%">Warning Subject</th>
                            <td width="60%"><?=$warningSubject;?></td>
                          </tr>
                          <tr>
                            <th width="20%">Warning Description</th>
                            <td width="60%"><?=$warningDescription;?></td>
                          </tr>
                          <tr>
                            <th width="20%">Warning Letter</th>
                            <td width="60%">
                              <i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red;"></i>&nbsp;
                              <a class="view-warning-letter" data-toggle="modal" data-target="#noneedid" data-dismiss="modal" href="#">
                                See warning letter
                              </a>
                            </td>
                          </tr>
                          <tr>
                            <th width="20%">Status</th>
                            <td width="60%">
                              <?php
                              $selectedPending='';
                              $selectedAccepted='';
                              $selectedRejected='';
                              if($currentUser==$approval_1){
                                if($approval_status_by_1=='0') $selectedPending='selected';
                                if($approval_status_by_1=='1') $selectedAccepted='selected';
                                if($approval_status_by_1=='2') $selectedRejected='selected';
                              }elseif($currentUser==$approval_2){
                                if($approval_status_by_2=='0') $selectedPending='selected';
                                if($approval_status_by_2=='1') $selectedAccepted='selected';
                                if($approval_status_by_2=='2') $selectedRejected='selected';
                              }else{
                                if($approvalStatus=='0') $selectedPending='selected';
                                if($approvalStatus=='1') $selectedAccepted='selected';
                                if($approvalStatus=='2') $selectedRejected='selected';
                              }
                              ?>
                              <?php if(($currentUser==$approval_1)||($currentUser==$approval_2)):?>
                                <select name="approval" id="select2-demo-6" class="form-control" data-plugin="select_hrm" data-placeholder="<?=$this->lang->line('dashboard_xin_status');?>">
                                  <option value="0" <?=$selectedPending;?>><?=$this->lang->line('xin_pending');?></option>
                                  <option value="1" <?=$selectedAccepted;?>><?=$this->lang->line('xin_accepted');?></option>
                                  <option value="2" <?=$selectedRejected;?>><?=$this->lang->line('xin_rejected');?></option>
                                </select>
                              <?php else:?>
                                <?=$approvalStatusName;?>
                              <?php endif;?>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="form-actions box-footer">
                      <?php //hidden field data for sending notif to slack?>
                      <input type='hidden' value='<?=$employee;?>' name='paramEmployee' readonly style='background:none;border:none;'>
                      <input type='hidden' value='<?=str_replace('-',' ',$date);?>' name='paramDate' readonly style='background:none;border:none;'>
                      <input type='hidden' value='<?=str_replace(':00','',$clockTime);?>' name='param<?=str_replace(' ','',$clockLabel);?>' readonly style='background:none;border:none;'>
                      <input type='hidden' value='<?=$submittedBy;?>' name='paramProposedBy' readonly style='background:none;border:none;'>
                      <?php //hidden field data for sending notif to slack?>
                      <a href=<?=base_url()."admin/warning";?> type="button" style="margin-right:10px;" class="btn btn-md btn-secondary"> <i class="fa fa-hand-o-left custom"></i> Cancel </a>
                      <?php if(($currentUser==35)||($currentUser==$approval_2)):?>
                      <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
                      <?php endif;?>
                    </div>
                    <?=form_close(); ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- tab -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalWarningLetter" role="dialog" aria-labelledby="WarningFileLabel" aria-hidden="true">
  <div class="modal-dialog luffy-modal">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Warning Letter</h4>
      </div>
      <div class="modal-body">
        <div class="iframe-container"><iframe src="<?=site_url()?>admin/warning/warning_letter/p/<?=$warningId;?>"></iframe></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script src="<?=site_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=site_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
  var options = {
    "backdrop" : "static",
    "show":true
  }
  jQuery(".view-warning-letter").on("click", function(){
    jQuery('#modalWarningLetter').modal(options);
  });
</script>

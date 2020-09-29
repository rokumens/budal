<?php // Grade List?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource();?>
<?php if(in_array('2030',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title">Add New Grade</h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a>
      </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_grade', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open('admin/grade_list/add_grade', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="grade_detail_id">Grade</label>
                  <select name="grade_detail_id" class="form-control" data-plugin="select_hrm" data-placeholder="Choose grade">
                    <option value=""></option>
                    <?php foreach($allGradeDetail as $singGrade) {?>
                    <option value="<?=$singGrade->grade_detail_id?>"><?=$singGrade->grade_name?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class='row'>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="dailyRequirement">Daily Minimum Requirement</label>
                      <input class="form-control dailyRequirement" placeholder="Set daily minimum requirement" name="dailyRequirement" type="number" min='0' />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="monthlyRequirement">Monthly Minimum Requirement</label>
                      <input class="form-control monthlyRequirement" placeholder="Set monthly minimum requirement" name="monthlyRequirement" type="number" min='1' />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="maintask">Main Task</label>
                  <select name="maintask" class="form-control aj_maintask" data-plugin="select_hrm" data-placeholder="Choose main task">
                    <?php if(count($allMainTask)):?>
                      <option value=""></option>
                    <?php foreach($allMainTask as $singMaintask) {?>
                    <option value="<?php echo $singMaintask->id;?>"><?php echo $singMaintask->taskName;?></option>
                    <?php } ?>
                    <?php else:?>
                    <option value="">Main task not yet created in the main task list</option>
                    <?php endif;?>
                  </select>
                </div>
                <div class='row subdept_ajax'>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="subdepartment_id"><?=$this->lang->line('xin_hr_sub_department');?></label>
                      <input class="form-control" type="text" readonly />
                      <!-- sementara, jangan dihapus
                      <select name="subdepartment_id" class="form-control" data-plugin="select_hrm" data-placeholder="Choose sub department">
                        <option value=""></option>
                        <option value="allSubDepartments_val">All Sub Department</option>
                        <?php foreach($all_sub_departments as $company) {?>
                        <option value="<?=$company->sub_department_id?>"><?=$company->department_name?></option>
                        <?php } ?>
                      </select> -->
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="office_shift">Office Shift</label>
                      <input class="form-control" type="text" readonly />
                      <!-- sementara, jangan dihapus
                      <select name="office_shift" class="form-control subDeptId" data-plugin="select_hrm" data-placeholder="Choose shift">
                        <option value=""></option>
                        <?php foreach($allShift as $singShift) {?>
                        <option value="<?=$singShift->office_shift_id?>"><?=$singShift->shift_name?></option>
                        <?php } ?>
                      </select> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?=$this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?=form_close();?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="box <?=$get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?=$this->lang->line('xin_list_all');?> Grade </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?=$this->lang->line('xin_action');?></th>
            <th>Grade</th>
            <th>Monthly Requirement</th>
            <th>Main Task</th>
            <th>Sub Department</th>
            <th>Shift</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

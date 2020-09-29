<style type="text/css">
.iframe-container {padding-bottom:60%;padding-top:30px;height:0;overflow:hidden;}
.iframe-container iframe,
.iframe-container object,
.iframe-container embed {position:absolute;top:0;left:0;width:100%;height:100%;}
.luffy-modal{width:65%;margin:auto;}
</style>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('2010',$role_resources_ids)) {?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title">Add New Subtask</h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?=$this->lang->line('xin_add_new');?></button>
        </a>
      </div>
    </div>
    <div id="add_form" class="collapse add-form <?=$get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_subtask', 'id' => 'xin-form', 'class' => 'subtask-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?=form_open_multipart('admin/appraisal_sub_task/add_subtask', $attributes, $hidden);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="job_task">Main Task</label>
                  <select name="job_task" class="form-control maintaskTitle aj_maintask" data-plugin="select_hrm" data-placeholder="Choose main task">
                    <?php if (count($getAllJobTask)):?>
                    <option data-value='' value="chooseSubtask" selected>Choose main task</option>
                    <?php foreach($getAllJobTask as $singTask) {?>
                    <option value="<?=$singTask->jobtask_id;?>" data-value='<?=$singTask->jobtask_name;?>'><?=$singTask->jobtask_name;?></option>
                    <?php } ?>
                    <?php else:?>
                    <option value=""></option>
                    <?php endif;?>
                  </select>
                </div>
                <div class="form-group subtask_ajax"><?#subtask title will show up here?></div>
                <div class="form-group">
                  <label for="urlPost">Url</label>
                  <input class="form-control" placeholder="Use http:// or https://" name="url" type="url" />
                </div>
                <div class="row" style="padding-top:15px;">
                  <div class="col-md-6">
                    <div class="form-group">
                      <fieldset class="form-group">
                        <label for="scan_file">Upload Image</label>
                        <input type="file" class="form-control-file" accept="image/png, image/jpg, image/jpeg" id="scan_file" name="scan_file">
                        <small>Image allowed: png, jpg, jpeg</small>
                      </fieldset>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <fieldset class="form-group">
                        <label for="scan_video">Upload Video</label>
                        <input type="file" class="form-control-file" accept="video/mp4, video/mkv, video/avi" id="scan_file" name="scan_video">
                        <small>Video allowed: mp4, avi, avi</small>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="subtask_description">Subtask <?=$this->lang->line('xin_description');?></label>
                  <textarea class="form-control textarea description" placeholder="Subtask <?=$this->lang->line('xin_description');?>" name="subtask_description" rows="9"></textarea>
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
    <h3 class="box-title"><?=$this->lang->line('xin_list_all');?> Subtasks</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?=$this->lang->line('xin_action');?></th>
            <th>Subtask</th>
            <th>Main Task</th>
            <th>Status</th>
            <th>By</th>
            <th>Office Location</th>
            <th>Created at</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

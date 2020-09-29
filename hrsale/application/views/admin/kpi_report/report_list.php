<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box mb-4 <?=$get_animate;?>">
  <div id="accordion">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <?php $attributes = array('name' => 'general_report', 'id' => 'general_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?=form_open('admin/kpi_report/report_list', $attributes, $hidden);?>
          <?php
  				$data = array(
  				  'type'        => 'hidden',
  				  'name'        => 'date_format',
  				  'id'          => 'date_format',
  				  'value'       => $this->Xin_model->set_date_format(date('Y-m')),
  				  'class'       => 'form-control',
  				);
  				echo form_input($data);
  				?>
          <div class="row">
            <div class="col-md-12">
              <!-- <div class="form-group">
                <div class="form-group" style="padding:10px 0 10px;">
                  <label style="padding-right:10px;">Filter Report by:</label>
                  <label class="radio-inline"><input type="radio" id="dailyRadio" class='reportFor' name="report_for" value="daily" checked>Daily</label>
                  <label class="radio-inline" style="margin-left:20px;"><input type="radio" checked='checked' id="monthlyRadio" class='reportFor' name="report_for" value="monthly">Monthly</label>
                  <label class="radio-inline" style="margin-left:20px;"><input type="radio" id="customRadio" class='reportFor' name="report_for" value="custom">Custom</label>
                </div>
              </div> -->
              <div class="row" id="rowDaily" style="display:none;">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="date">Pick Date</label>
                    <input class="form-control report_daily" placeholder="Pick a date" readonly id="report_daily" name="report_daily" type="text" value="<?=date('Y-m-d');?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="">&nbsp;</label>
                    <button id='submitReportDaily' type="submit" class="btn btn-small btn-primary save form-control">Get Report</button>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="">&nbsp;</label>
                  </div>
                </div>
              </div>
              <div class="row" id="rowMonthly">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="date">Pick Month</label>
                    <input class="form-control report_month" placeholder="<?=$this->lang->line('xin_select_month');?>" readonly id="report_month" name="report_month" type="text" value="<?=date('Y-m');?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="">&nbsp;</label>
                    <button id='submitReportMonthly' type="submit" class="btn btn-small btn-primary save form-control">Get Report</button>
                  </div>
                </div>
              </div>
              <div class="row" id="rowCustom" style="display:none;">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="date">From</label>
                    <input class="form-control report_date" placeholder="Pick a date" readonly id="report_custom_from" name="report_custom_from" type="text" value="<?=date('Y-m-d');?>">
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="date">To</label>
                    <input class="form-control report_date" placeholder="Pick a date" readonly id="report_custom_to" name="report_custom_to" type="text" value="<?=date('Y-m-d');?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="">&nbsp;</label>
                    <button id='submitReportCustom' type="submit" class="btn btn-small btn-primary save form-control">Get Report</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?=form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="box <?=$get_animate;?>">
  <div class="box-header">
    <h3 class="box-title"> Period: <span class="text-danger reportMonthFormat" style='padding-left:5px;'></span> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered luffyReport" id="xin_table">
        <thead>
          <tr>
            <th style='width:100px;'><?=$this->lang->line('xin_action');?></th>
            <th>ID</th>
            <th>Nickname</th>
            <th><?=$this->lang->line('xin_employee');?></th>
            <th>Sub Department</th>
            <th>Office Location</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>

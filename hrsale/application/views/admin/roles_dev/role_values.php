<script type="text/javascript">
//$(document).ready(function(){
	jQuery("#treeview_r1").kendoTreeView({
	checkboxes: {
	checkChildren: true,
	//template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>"
	/*template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text # <small>#= item.add_info #</small></span></label>"
	},*/
	template: "<label><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'> #= item.text #</label>"
	},
	//<label class='custom-control custom-checkbox'><input type='checkbox' class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>

	//template: "<label class="custom-control custom-checkbox"><input type="checkbox" #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class="custom-control-label">#= item.add_info #</span></label>"
	check: onCheck,
	dataSource: [

	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('let_staff');?>",  add_info: "", value: "103",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('dashboard_employees');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "13",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "13",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "201",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "202",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "203",}
	]},

	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_import_employees');?>",  add_info: "<?php echo $this->lang->line('xin_import_employees');?>", value: "92"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_employees_directory');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "88"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_employees_exit');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "23",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "23",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "204",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "205",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "206",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "231",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_employees_last_login');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "22"}
	]},
	//
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr');?>",  add_info: "", value: "12",  items: [

	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_awards');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "14",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "14",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "207",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "208",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "209",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "232",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_transfers');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "15",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "15",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "210",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "211",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "212",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "233",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_resignations');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "16",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "16",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "213",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "214",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "215",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "234",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_travels');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "17",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "17",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "216",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "217",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "218",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "235",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_promotions');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "18",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "18",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "219",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "220",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "221",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "236",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_complaints');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "19",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "19",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "222",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "223",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "224",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "237",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_warnings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "20",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "20",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "225",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "226",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "227",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "238",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_terminations');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "21",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "21",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "228",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "229",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "230",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "239",}
	]}
	]},

	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_organization');?>", add_info: "", value:"2", items: [
	// sub 1
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_department');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "3",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "3",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "240",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "241",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "242",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_designation');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "4",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "4",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "243",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "244",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "245",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_company');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "5",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "5",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "246",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "247",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "248",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "249",}
	]},
	// luffy 9 Feb 2020 08:26 pm
	{ id: "", class: "role-checkbox", text: "Official Document",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "1019",items: [
	// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "1019",},
	// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "246",},
	// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "247",},
	// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "248",},
	// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "249",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_location');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "6",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "6",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "250",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "251",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "252",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "253",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_announcements');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "11",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "11",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "254",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "255",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "256",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "257",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_policies');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "9",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "9",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "258",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "259",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "260",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "261",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_org_chart_title');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "96",}
	]}, // sub 1 end

	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_assets');?>",  add_info: "", value: "24",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_assets');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "25",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "25",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "262",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "263",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "264",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "265",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_category');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "26",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "26",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "266",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "267",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "268",}
	]},
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_events_meetings');?>",  add_info: "", value: "97",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_events');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "98",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "98",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "269",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "270",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "271",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "272",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_meetings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "99",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "99",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "273",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "274",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "275",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "276",}
	]},
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_timesheet');?>",  add_info: "", value: "27",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "",items: [
		//luffy
		{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "28",},
		{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?> All",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2087",},
		{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?> Own",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2088",},
	]},
	// Timesheet Approval List - Luffy 7380
	{ id: "", class: "role-checkbox", text: "Attendance Approval",  add_info: "Edit/View", value: "1017",items: [
		{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1017",},
		{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2075",},
		{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2076",},
		// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2077",},
		{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?> All",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2078",},
		{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?> Own",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2086",},
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_date_wise_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "29",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_update_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "30",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "30",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "277",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "278",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "279",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_import_attendance');?>",  add_info: "<?php echo $this->lang->line('xin_attendance_import');?>", value: "31",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_office_shifts');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "7",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "7",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "280",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "281",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "282",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_change_default');?>",  add_info: "<?php echo $this->lang->line('xin_role_change_default');?>", value: "2822",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_holidays');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "8",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "8",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "283",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "284",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "285",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "286",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_leaves');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "46",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "46",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "287",},
	{ id: "", class: "role-checkbox", text: "View Detail",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "288",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "289",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "290",}
	]},
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_recruitment');?>",  add_info: "", value: "48",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_job_posts');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "49",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "49",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "291",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "292",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "293",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_jobs_listing');?> <small><?php echo $this->lang->line('left_frontend');?></small>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "50"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_job_candidates');?>",  add_info: "<?php echo $this->lang->line('xin_update_status_delete');?>", value: "51",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "51",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_dwn_resume');?>",  add_info: "<?php echo $this->lang->line('xin_role_dwn_resume');?>", value: "294",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "295",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_job_interviews');?>",  add_info: "<?php echo $this->lang->line('xin_add_delete');?>", value: "52",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "52",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "296",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "297",}
	]},
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_payroll');?>",  add_info: "", value: "32",  items: [
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('left_generate_payslip');?>",  add_info: "<?php echo $this->lang->line('xin_generate_view');?>", value: "36", check: "<?php if(isset($_GET['role_id'])) { if(in_array('36',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('left_payment_history');?>",  add_info: "<?php echo $this->lang->line('xin_view_payslip');?>", value: "37", check: "<?php if(isset($_GET['role_id'])) { if(in_array('37',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "37", check: "<?php if(isset($_GET['role_id'])) { if(in_array('37',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "391", check: "<?php if(isset($_GET['role_id'])) { if(in_array('391',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "392", check: "<?php if(isset($_GET['role_id'])) { if(in_array('392',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	]},

	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_performance');?>",  add_info: "", value: "40",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_performance_indicator');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "41",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "41",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "298",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "299",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "300",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "301",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_performance_appraisal');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "42",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "42",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "302",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "303",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "304",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "305",}
	]},
	]},

	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_tickets');?>",  add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", value: "43",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "43",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "306",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "307",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "308",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "309",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_expense');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "10",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "10",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "310",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "311",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "312",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "313",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_download');?>",  add_info: "<?php echo $this->lang->line('xin_download');?>", value: "314",},
	{ id: "", class: "role-checkbox", text: "View Own",  add_info: "<?php echo $this->lang->line('xin_download');?>", value: "389",},
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_projects');?>",  add_info: "", value: "104",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_projects');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "44",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "44",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "315",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "316",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "317",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "318",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_tasks');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "45",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "45",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "319",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "320",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "321",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "322",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_project_clients');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "119",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "119",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "323",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "324",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "325",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "326",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_invoices_title');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "121",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "121",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_create');?>",  add_info: "<?php echo $this->lang->line('xin_role_create');?>", value: "120",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "328",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "329",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "330",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_invoice_tax_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "122",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "122",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "331",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "332",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "333",}
	]},
	]},

	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_goal_tracking');?>",  add_info: "", value: "106",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_goal_tracking');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "107",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "107",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "334",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "335",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "336",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "337",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_goal_tracking_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "108",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "108",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "338",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "339",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "340",}
	]},
	]},

	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_files_manager');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "47",},

	]
	});

	jQuery("#treeview_r2").kendoTreeView({
	checkboxes: {
	checkChildren: true,
	//template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>"
	/*template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text # <small>#= item.add_info #</small></span></label>"*/
	template: "<label><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'> #= item.text #</label>"
	},
	check: onCheck,
	dataSource: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_training');?>",  add_info: "", value: "53",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_training_list');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "54",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "54",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "341",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "342",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "343",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "344",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_training_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "55",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "55",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "345",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "346",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "347",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_trainers_list');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "56",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "56",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "348",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "349",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "350",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view');?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "351",}
	]},
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_system');?>",  add_info: "", value: "57",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_lang_settings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "89",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "89",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "370",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "371",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_settings');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "60",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_theme_settings');?>",  add_info: "<?php echo $this->lang->line('xin_theme_settings');?>", value: "94",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_constants');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "61",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_db_backup');?>",  add_info: "<?php echo $this->lang->line('xin_create_delete_download');?>", value: "62",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('left_email_templates');?>",  add_info: "<?php echo $this->lang->line('xin_update');?>", value: "63",},

	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_setup_modules');?>",  add_info: "<?php echo $this->lang->line('xin_update');?>", value: "93",}
	]},
	{ id: "", class: "role-checkbox",text: "<?php echo $this->lang->line('xin_acc_accounts');?>", add_info: "",value: "71",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_account_list');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "72",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "72",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "352",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "353",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "354",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_account_balances');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "73",},
	]},
	{ id: "", class: "role-checkbox",text: "<?php echo $this->lang->line('xin_acc_transactions');?>", add_info: "",value: "74",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_deposit');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "75",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "75",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "355",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "356",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "357",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_expense');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "76",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "76",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "358",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "359",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "360",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_transfer');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "77",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "77",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "361",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "362",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "363",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_view_transactions');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "78",},
	]},

	{ id: "", class: "role-checkbox",text: "<?php echo $this->lang->line('xin_acc_payees_payers');?>", add_info: "",value: "79",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_payees');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "80",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "80",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "364",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "365",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "366",}
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_payers');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "81",items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "81",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "367",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "368",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "369",}
	]},
	]},

	{ id: "", class: "role-checkbox",text: "<?php echo $this->lang->line('xin_acc_reports');?>", add_info: "",value: "82",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_account_statement');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "83"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_expense_reports');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "84",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_income_reports');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "85",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_acc_transfer_report');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "86",},
	]},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('hd_changelog');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "87",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_notify_top');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "90",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('header_apply_jobs');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "91",},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_calendar_title');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "95",},

	{ id: "", class: "role-checkbox",text: "<?php echo $this->lang->line('xin_hr_report_title');?>", add_info: "",value: "110",  items: [
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_reports_payslip');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "111"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_reports_attendance_employee');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "112"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_reports_training');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "113"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_reports_projects');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "114"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_reports_tasks');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "115"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_report_user_roles');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "116"},
	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_hr_report_employees');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "117"},
	// General Report
	{ id: "", class: "role-checkbox", text: "General Report",  add_info: "Add/Edit/View/Delete", value: "1018",items: [
		{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1018",},
		// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2078",},
		// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2079",},
		// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2080",},
		{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2081",},
		{ id: "", class: "role-checkbox", text: "View Detail",  add_info: "View Detail", value: "2082",},
		// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "2083",}
	]},
	]},
	// luffy - Appraisal Module [new]
	{ id: "", class: "role-checkbox", text: "Appraisal <small style='color:#f64747;'>[new]</small>",  add_info: "", value: "1000",  items: [
		// Assign Task
		{ id: "", class: "role-checkbox", text: "Assign Task",  add_info: "Add/Edit/View/Delete", value: "1001",items: [
			{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1001",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2000",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2001",},
			//delete cukup dari main task
			//{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2002",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2003",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "2004",}
		]},
		// Task List
		{ id: "", class: "role-checkbox", text: "Task List",  add_info: "Add/Edit/View/Delete", value: "1002",items: [
			{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1002",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2005",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2006",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2007",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2008",},
			// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "2009",}
		]},
		// Sub Task
		{ id: "", class: "role-checkbox", text: "Subtask",  add_info: "Add/Edit/View/Delete", value: "1003",items: [
			{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1003",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2010",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2011",},
			//delete cukup dari main task
			//{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2012",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2013",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "2014",},
			{ id: "", class: "role-checkbox", text: "Auditor <small>[Valid & Reject]</small>",  add_info: "For Auditor", value: "2084",},
			{ id: "", class: "role-checkbox", text: "Reviewer <small>[Qualified & Reject]</small>",  add_info: "For Review", value: "2085",}
		]},
		// Rewards list
		{ id: "", class: "role-checkbox", text: "Rewards List",  add_info: "Add/Edit/View/Delete", value: "1004",items: [
			{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1004",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2015",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2016",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2017",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2018",},
			// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "2019",}
		]},
		// Assign rewards
		{ id: "", class: "role-checkbox", text: "Assign Rewards",  add_info: "Add/Edit/View/Delete", value: "1008",items: [
			{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1008",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2035",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2036",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2037",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2038",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "2039",}
		]},
		// Punishment list
		{ id: "", class: "role-checkbox", text: "Punishment List",  add_info: "Add/Edit/View/Delete", value: "1005",items: [
			{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1005",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2020",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2021",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2022",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2023",},
			// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "2024",}
		]},
		// Assign punishment
		{ id: "", class: "role-checkbox", text: "Assign Punishment",  add_info: "Add/Edit/View/Delete", value: "1009",items: [
			{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1009",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2040",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2041",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2042",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2043",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "2044",}
		]},
		// KPI sales
		{ id: "", class: "role-checkbox", text: "KPI Sales",  add_info: "Add/Edit/View/Delete", value: "1006",items: [
			{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1006",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2025",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2026",},
			//delete cukup dari main task
			//{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2027",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2028",},
			// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "2029",}
		]},
		// Grade list
		{ id: "", class: "role-checkbox", text: "Grade List",  add_info: "Add/Edit/View/Delete", value: "1007",items: [
			{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1007",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2030",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2031",},
			//delete cukup dari main task
			//{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2032",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2033",},
			// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "2034",}
		]},
		// Appraisal Report
		{ id: "", class: "role-checkbox", text: "Appraisal Report",  add_info: "Add/Edit/View/Delete", value: "1010",items: [
			{ id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1010",},
			// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2045",},
			// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2046",},
			// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2047",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2048",},
			{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "2049",}
		]},
	]},
	// Dayoff module
	{ id: "", class: "role-checkbox-modal", text: "Dayoff <small style='color:#f64747;'>[new]</small>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('1011',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "1011",  items: [
		// Enable Module
		{ id: "", class: "role-checkbox-modal", text: "Enable Module",  add_info: "Add/Edit/View/Delete", value: "1012", check: "<?php if(isset($_GET['role_id'])) { if(in_array('1012',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		// Generate
		{ id: "", class: "role-checkbox-modal", text: "Generate",  add_info: "Add/Edit/View/Delete", value: "1013", check: "<?php if(isset($_GET['role_id'])) { if(in_array('1013',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		// View Detail
		{ id: "", class: "role-checkbox-modal", text: "View Detail",  add_info: "Add/Edit/View/Delete", value: "1014", check: "<?php if(isset($_GET['role_id'])) { if(in_array('1014',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		// Download PDF
		{ id: "", class: "role-checkbox-modal", text: "See PDF",  add_info: "Add/Edit/View/Delete", value: "1015", check: "<?php if(isset($_GET['role_id'])) { if(in_array('1015',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
	]}, 
	// day off ends
	// Rolling Shift module
	{ id: "", class: "role-checkbox-modal", text: "Rolling Shift <small style='color:#f64747;'>[new]</small>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('1023',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "1023",  items: [
		// Enable Module
		{ id: "", class: "role-checkbox-modal", text: "Enable Module",  add_info: "Add/Edit/View/Delete", value: "1024", check: "<?php if(isset($_GET['role_id'])) { if(in_array('1024',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		// Generate
		{ id: "", class: "role-checkbox-modal", text: "Generate",  add_info: "Add/Edit/View/Delete", value: "1025", check: "<?php if(isset($_GET['role_id'])) { if(in_array('1025',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		// View Detail
		{ id: "", class: "role-checkbox-modal", text: "View Detail",  add_info: "Add/Edit/View/Delete", value: "1026", check: "<?php if(isset($_GET['role_id'])) { if(in_array('1026',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		// Download PDF
		{ id: "", class: "role-checkbox-modal", text: "See PDF",  add_info: "Add/Edit/View/Delete", value: "1027", check: "<?php if(isset($_GET['role_id'])) { if(in_array('1027',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
	]}, 
	// For Documentation Access only
	// a2.kanonhost.com/documentation
	{ id: "", class: "role-checkbox-modal", text: "Documentation",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('1028',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "1028"}, 
	// rolling shift ends
	// // Immigrations
	// { id: "", class: "role-checkbox", text: "Immigrations",  add_info: "Add/Edit/View/Delete", value: "1016",items: [
	// 	// { id: "", class: "role-checkbox", text: "Enable Module",  add_info: "Enable Module", value: "1016",},
	// 	// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "2070",},
	// 	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "2071",},
	// 	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "2072",},
	// 	{ id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_view');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "2073",},
	// 	// { id: "", class: "role-checkbox", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "2074",}
	// ]},
	// // Customer data | salah room, yg dimaksud mgkin ini buat A1
	// // Contacts list, upload from excel.
	// { id: "", class: "role-checkbox", text: "Customer Data <small style='color:#f64747;'>[new]</small>",  add_info: "", value: "3000",  items: [
	// 	{ id: "", class: "role-checkbox", text: "Customer List",  add_info: "", value: "3001"},
	// 	{ id: "", class: "role-checkbox", text: "Import Customer",  add_info: "", value: "3002"},
	// ]},

	// luffy 10 Feb 2020 11:42 am
	// Company Policy
	{ id: "", class: "role-checkbox", text: "Company Policy",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "1020"},
	// Finance Form
	{ id: "", class: "role-checkbox", text: "Finance Form",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "1021"},

	]
	});
//});

// role besar terakhir:
// 1028
// 2088

// show checked node IDs on datasource change
function onCheck() {
var checkedNodes = [],
		treeView = jQuery("#treeview2").data("kendoTreeView"),
		message;
		jQuery("#result").html(message);
}
</script>

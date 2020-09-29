<?php $theme = $this->Xin_model->read_theme_info(1);?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<link rel="stylesheet" href="<?=base_url();?>skin/hrsale_assets/vendor/orgchart/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=base_url();?>skin/hrsale_assets/vendor/orgchart/css/jquery.orgchart.css">
<link rel="stylesheet" href="<?=base_url();?>skin/hrsale_assets/vendor/orgchart/css/style.css">
<style type="text/css">
/* orgchart style start */
.left {
  position: fixed;
  top: 10px;
  left: 14px;
  font-size: large;
}

.orgchart {
  background: #fff;
}

.orgchart2>table>tr:nth-child(-n+3) {
  display:none;
}

:before, :after {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.orgchart .verticalNodes ul>li {
  position: relative;
}
.orgchart .verticalNodes ul>li::before {
    content: '';
    position: absolute;
    left: -6px;
    width: 10px;
    height: calc(50%);
    border-color: #CCC;
    border-style: solid;
}
.orgchart .verticalNodes ul>li::after {
    content: '';
    position: absolute;
    left: -6px;
    top: 20px;
    width: 0px;
    height: calc(50%);
    border-color: #CCC;
    border-width: 0 0 2px 2px;
    border-style: solid;
}
.orgchart .verticalNodes ul>li:first-child::before {

}
.orgchart .verticalNodes ul {
  padding-left: 12px;
  margin-left: 12px;
}
.orgchart .verticalNodes ul>li::before {
  top: -4px;
  border-width: 0 0 2px 2px;
}
.orgchart .verticalNodes ul>li:last-child::before {
  border-radius: 0 0 0 4px;
}
.orgchart .verticalNodes ul>li:last-child::after {
  display: none;
}
.orgchart .node {
  border-radius: 5px;
  border-width: 1px;
  padding: 1px;
	min-width:180px;
}

.orgchart .node .horizontalEdge,
.orgchart .node .topEdge {
  display: none;
}

.orgchart .node .title {
  color: #000;
}

.orgchart .node .content {
  border-color: transparent;
  border-top-color: #333;
}

.orgchart .node:hover {
  background-color: rgba(255, 255, 0, 0.6);
}

.orgchart .node.focused {
  background-color: rgba(255, 255, 0, 0.6);
}

.orgchart .node .edge {
  color: rgba(0, 0, 0, 0.6);
}

.orgchart .edge:hover {
  color: #000;
}

.orgchart td.left,
.orgchart td.top,
.orgchart td.right {
  border-color: #fff;
}

.orgchart td>.down {
  background-color: #fff;
}

.orgchart .second-menu-icon {
  transition: opacity .5s;
  opacity: 0;
  right: -5px;
  top: -5px;
  z-index: 2;
  color: rgba(184, 0, 100, 0.8);
  font-size: 18px;
  position: absolute;
}

.orgchart .second-menu-icon:hover {
  color: #b80064;
}

.orgchart .node:hover .second-menu-icon {
  opacity: 1;
}

.orgchart .node .second-menu {
  display: none;
  position: absolute;
  top: -28px;
  left: 46px;
  border-radius: 35px;
  box-shadow: 0 0 4px 1px #999;
  z-index: 1;
}

.orgchart .node .second-menu .avatar {
  width: 30px;
  height: 30px;
  border-radius: 30px;
  float: left;
  margin: 1px;
}
/* orgchart style end */

/* orgchart color start */
.orgchart .classDept { border:1px solid #999; }
.orgchart .classDept .title { background-color: #ebeb16; } /* kuning. old: FFFF00 */
.orgchart .classDept .content { border-color: #999; }
.orgchart .classSubDept { border:1px solid #999; }
.orgchart .classSubDept .title { background-color: #21ebeb; } /* biru. old: FFFF00 */
.orgchart .classSubDept .content { border-color: #999; }
.orgchart .classDesignation { border:1px solid #999; }
.orgchart .classDesignation .title { background-color: #72e972; }  /* ijo. old: 00FF00 */
.orgchart .classDesignation .content { border-color: #999; }
.orgchart .node .content-chart {border: none;}
/* orgchart color end */

/* luffy 27 nov 2019 */
.orgchart .node .second-menu {
  top: 5px !important;
  left: 140px !important;
}

#chart-container {
	background-color: #fff;
 <?php if($theme[0]->org_chart_layout=='t2b' || $theme[0]->org_chart_layout=='b2t'):?>  text-align: center !important;
 <?php elseif($theme[0]->org_chart_layout=='l2r'):?>  text-align: left !important;
 <?php elseif($theme[0]->org_chart_layout=='r2l'):?>  text-align: right !important;
 <?php endif;
?>
}
</style>
<script type="text/javascript" src="<?=base_url();?>skin/hrsale_assets/vendor/orgchart/js/html2canvas.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>skin/hrsale_assets/vendor/orgchart/js/jquery.orgchart.js"></script>
<script type="text/javascript" src="<?=base_url();?>skin/hrsale_assets/vendor/orgchart/js/jspdf.min.js"></script>
<?php #$department = get_main_departments_employees();?>
<?php $department = orgchartDept();?>
<script type="text/javascript">
    $(function() {
    var datascource = {
			'id': 'https://lh3.googleusercontent.com/-w4Rzbi2CNeI/AAAAAAAAAAI/AAAAAAAAAAA/ACHi3rc7TAH9tgEzC83m2Q2ZHAR6TSCgrw/s50/photo.jpg',
			'name': 'Director',
			'title': '8000 - Roy',
			'className':'classDesignation',
			'children': [
				{'name': 'Manager','title': '7369 - Goku','className':'classDesignation',
					'children': [
            <?php foreach($department as $singDept){ ?>
            {'name':'<?=$singDept->department_name;?>','title':'','className':'classDept',
							'children': [
                <?php if($singDept->department_id==2){?>
                <?php $spv=orgChartSupervisors(2);?>
                <?php foreach($spv as $singSpv){?>
                <?php
                if(!empty($singSpv->profile_picture_sso) && empty($singSpv->profile_picture)){
                  $photo=$singSpv->profile_picture_sso;
                }elseif(empty($singSpv->profile_picture_sso) && !empty($singSpv->profile_picture)){
                  $photo=base_url().'uploads/profile/'.$singSpv->profile_picture;
                }elseif(empty($singSpv->profile_picture_sso) && empty($singSpv->profile_picture)){
                  if($singSpv->gender=='Male') {
                    $photo = base_url().'uploads/profile/default_male.jpg';
                  }else{
                    $photo = base_url().'uploads/profile/default_female.jpg';
                  }
                }
                ?>
								{'id':'<?=$photo;?>','name':'Supervisor','title':'<?=$singSpv->username?>','className':'classDesignation',
									'children': [
                    <?php $subDept=orgchartSubDept($singSpv->department_id);?>
                    <?php foreach($subDept as $singSubDept){?>
                    {'name':'<?=$singSubDept->department_name?>','title':'','className':'classSubDept',
        							'children': [
                        <?php $officers=orgChartOfficers($singSubDept->department_id,$singSubDept->sub_department_id);?>
                        <?php foreach($officers as $singOfficers){?>
                        <?php
                        if(!empty($singOfficers->profile_picture_sso) && empty($singOfficers->profile_picture)){
                          $photo=$singOfficers->profile_picture_sso;
                        }elseif(empty($singOfficers->profile_picture_sso) && !empty($singOfficers->profile_picture)){
                          $photo=base_url().'uploads/profile/'.$singOfficers->profile_picture;
                        }elseif(empty($singOfficers->profile_picture_sso) && empty($singOfficers->profile_picture)){
                          if($singOfficers->gender=='Male') {
                            $photo = base_url().'uploads/profile/default_male.jpg';
                          }else{
                            $photo = base_url().'uploads/profile/default_female.jpg';
                          }
                        }
                        ?>
                        {'id':'<?=$photo;?>','name':'Officer','title':'<?=$singOfficers->employee_id.' - '.$singOfficers->username?>','className':'classDesignation',},
                        <?php } #endforeach officers?>

                        <?php $staffs=orgChartStaffs($singSubDept->department_id,$singSubDept->sub_department_id);?>
                        <?php foreach($staffs as $singStaffs){?>
                        <?php
                        if(!empty($singStaffs->profile_picture_sso)){
                          $photo=$singStaffs->profile_picture_sso;
                        }elseif(!empty($singStaffs->profile_picture)){
                          $photo=base_url().'uploads/profile/'.$singStaffs->profile_picture;
                        }elseif(empty($singStaffs->profile_picture_sso) && empty($singStaffs->profile_picture)){
                          if($singStaffs->gender=='Male') {
                            $photo = base_url().'uploads/profile/default_male.jpg';
                          }else{
                            $photo = base_url().'uploads/profile/default_female.jpg';
                          }
                        }
                        ?>
                        {'id':'<?=$photo;?>','name':'Staff','title':'<?=$singStaffs->employee_id.' - '.$singStaffs->username?>','className':'classDesignation',},
                        <?php } #endforeach staffs?>

        							]
        						},
                    <?php } #endforeach subdept?>
									]
								},
                <?php } #endforeach spv?>
                <?php
              }elseif($singDept->department_id==5){?>

                <?php $spv=orgChartSupervisors(5);?>
                <?php foreach($spv as $singSpv){?>
                {'name':'Supervisor','title':'<?=$singSpv->employee_id.' - '.$singSpv->username?>','className':'classDesignation',
                  'children':[
                    <?php $subDept=orgchartSubDept(5);?>
                    <?php foreach($subDept as $singSubDept){?>
                    {'name':'<?=$singSubDept->department_name?>','title':'','className':'classSubDept',
                      'children': [
                        <?php $officers=orgChartOfficers($singSubDept->department_id,$singSubDept->sub_department_id);?>
                        <?php if($singSubDept->sub_department_id==33):?>
                        {'name':'Officer','title':'9300 - Megane','className':'classDesignation',},
                        {'name':'Officer','title':'9302 - Caroline','className':'classDesignation',},
                        <?php endif;?>
                        <?php if($singSubDept->sub_department_id==16):?>
                        {'name':'Officer','title':'6360 - Dion','className':'classDesignation',},
                        <?php endif;?>
                        <?php foreach($officers as $singOfficers){?>
                        <?php
                        if(!empty($singOfficers->profile_picture_sso) && empty($singOfficers->profile_picture)){
                          $photo=$singOfficers->profile_picture_sso;
                        }elseif(empty($singOfficers->profile_picture_sso) && !empty($singOfficers->profile_picture)){
                          $photo=base_url().'uploads/profile/'.$singOfficers->profile_picture;
                        }elseif(empty($singOfficers->profile_picture_sso) && empty($singOfficers->profile_picture)){
                          if($singOfficers->gender=='Male') {
                            $photo = base_url().'uploads/profile/default_male.jpg';
                          }else{
                            $photo = base_url().'uploads/profile/default_female.jpg';
                          }
                        }
                        ?>
                        {'id':'<?=$photo?>','name':'Officer','title':'<?=$singOfficers->employee_id.' - '.$singOfficers->username?>','className':'classDesignation',},
                        <?php } #endforeach officers?>

                        <?php $staffs=orgChartStaffs($singSubDept->department_id,$singSubDept->sub_department_id);?>
                        <?php foreach($staffs as $singStaffs){?>
                        <?php
                        if(!empty($singStaffs->profile_picture_sso)){
                          $photo=$singStaffs->profile_picture_sso;
                        }elseif(!empty($singStaffs->profile_picture)){
                          $photo=base_url().'uploads/profile/'.$singStaffs->profile_picture;
                        }elseif(empty($singStaffs->profile_picture_sso) && empty($singStaffs->profile_picture)){
                          if($singStaffs->gender=='Male') {
                            $photo = base_url().'uploads/profile/default_male.jpg';
                          }else{
                            $photo = base_url().'uploads/profile/default_female.jpg';
                          }
                        }
                        ?>
                        {'id':'<?=$photo?>','name':'Staff','title':'<?=$singStaffs->employee_id.' - '.$singStaffs->username?>','className':'classDesignation',},
                        <?php } #endforeach staffs?>
                      ]
                    },
                    <?php } #endforeach subdept?>
                  ]
                },
                <?php } #endforeach spv?>

              <?php }else{ #all subdept without have supervisor?>
                <?php $subDept=orgchartSubDept($singDept->department_id);?>
                <?php foreach($subDept as $singSubDept){?>
                {'name':'<?=$singSubDept->department_name?>','title':'','className':'classSubDept',
                  'children': [

                    <?php if($singSubDept->sub_department_id==34):?>
                    {'name':'Officer','title':'9302 - Caroline','className':'classDesignation',},
                    <?php endif;?>
                    <?php if($singSubDept->sub_department_id==19):?>
                    {'name':'Officer','title':'9302 - Caroline','className':'classDesignation',},
                    <?php endif;?>
                    <?php $officers=orgChartOfficers($singSubDept->department_id,$singSubDept->sub_department_id);?>
                    <?php foreach($officers as $singOfficers){?>
                    <?php
                    if(!empty($singOfficers->profile_picture_sso) && empty($singOfficers->profile_picture)){
                      $photo=$singOfficers->profile_picture_sso;
                    }elseif(empty($singOfficers->profile_picture_sso) && !empty($singOfficers->profile_picture)){
                      $photo=base_url().'uploads/profile/'.$singOfficers->profile_picture;
                    }elseif(empty($singOfficers->profile_picture_sso) && empty($singOfficers->profile_picture)){
                      if($singOfficers->gender=='Male') {
                        $photo = base_url().'uploads/profile/default_male.jpg';
                      }else{
                        $photo = base_url().'uploads/profile/default_female.jpg';
                      }
                    }
                    ?>
                    {'id':'<?=$photo?>','name':'Officer','title':'<?=$singOfficers->employee_id.' - '.$singOfficers->username?>','className':'classDesignation',},
                    <?php } #endforeach officers?>

                    <?php if($singSubDept->sub_department_id==35):?>
                    {'name':'Staff','title':'9300 - Megane','className':'classDesignation',},
                    <?php endif;?>
                    <?php $staffs=orgChartStaffs($singSubDept->department_id,$singSubDept->sub_department_id);?>
                    <?php foreach($staffs as $singStaffs){?>
                    <?php
                    if(!empty($singStaffs->profile_picture_sso)){
                      $photo=$singStaffs->profile_picture_sso;
                    }elseif(!empty($singStaffs->profile_picture)){
                      $photo=base_url().'uploads/profile/'.$singStaffs->profile_picture;
                    }elseif(empty($singStaffs->profile_picture_sso) && empty($singStaffs->profile_picture)){
                      if($singStaffs->gender=='Male') {
                        $photo = base_url().'uploads/profile/default_male.jpg';
                      }else{
                        $photo = base_url().'uploads/profile/default_female.jpg';
                      }
                    }
                    ?>
                    {'id':'<?=$photo?>','name':'Staff','title':'<?=$singStaffs->employee_id.' - '.$singStaffs->username?>','className':'classDesignation',},
                    <?php } #endforeach staffs?>

                  ]
                },
                <?php } #endforeach subdept?>
              <?php } #endif spv?>
							]
						},
            <?php } #endforeach dept?>
					]
				},
			]
    };
    $('#chart-container').orgchart({
      'data' : datascource,
      'nodeContent': 'title',
      'exportButton': true <?php #echo $theme[0]->export_orgchart;?>,
      'exportFilename': 'A2 Kanonhost - Struktur Perusahaan Asia Power Games<?php #echo $theme[0]->export_file_title;?>',
	  	'exportFileextension': 'pdf',	//buang klo mo jd image/png
			'pan': false<?php #echo $theme[0]->org_chart_pan;?>,
      'zoom': false<?php #echo $theme[0]->org_chart_zoom;?>,
      'direction': '<?=$theme[0]->org_chart_layout;?>',
			// 'verticalDepth': 3,
      'visibleLevel': 5, <?php #buat vertical default collapse #bikin 6 kalo mo ngikutin spt di google docs?>
      'depth': 3,
			'verticalLevel': 4, <?php #bikin 6 kalo mo ngikutin spt di google docs?>
			// // luffy 24 nov 2019
			// 'createNode': function($node, data) {
      //   $node.on('click', function() {
      //     $node.children('i.bottomEdge').trigger('click');
      //   });
      //   var secondMenuIcon = $('<i>', {
      //     'class': 'fa fa-info-circle second-menu-icon',
      //     click: function() {
      //       $(this).siblings('.second-menu').toggle();
      //       return false;
      //     }
      //   });
      //   var secondMenu = '<div class="second-menu"><img class="avatar" src="' + data.id + '"></div>';
      //   $node.append(secondMenuIcon).append(secondMenu);
      // }
    });
		// // luffy 24 nov 2019
		// $('#icon').on('change', function() {
		// 	$('#chart-container div.second-menu').toggle(this.checked);
		// });

  });
  </script>

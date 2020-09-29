<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fingerprint_model extends CI_Model {
  	public function __construct()
  	{
      parent::__construct();
      $this->load->database();
  	}
  	public function getMisc($id)
  	{
      $sql = 'SELECT nilai FROM fp_misc WHERE id = ?';
  		$binds = array($id);
  		$query = $this->db->query($sql, $binds);
      if($query) return $query[0];
  		else return false;
  		return $query->result();
  	}
  	public function ambilKaryawan()
  	{
  		$sql = 'SELECT * FROM fp_karyawan WHERE 1';
      $query = $this->db->query($sql, $binds);
      if($query) return $query[0];
  		else return false;
  		return $query->result();
  	}
  	public function ambilMesinFP()
  	{
      $query = $this->db->query("SELECT * FROM fp_mesinfp WHERE 1");
  	  return $query->result();
  	}
    public function emptyAbsensi(){
      $this->db->query("TRUNCATE TABLE `xin_attendance_time`");
    }
    public function nextIncrementId(){
      $query = $this->db->query("SELECT id FROM xin_attendance_time ORDER BY id DESC");
  	  return $query->row();
    }
  	public function saveAttendance($fingerprintData, $DNS, $location_id) {
      $sql=[];
      $locationInfo = $this->db->get_where('xin_office_location', ['location_id'=>$location_id])->row();
      if(!empty($locationInfo)){
        $location = $location_id;
        $ipFingerprint = gethostbyname($DNS);
      }else{
        $location = 0;
        $ipFingerprint='0.0.0.0';/*header("refresh:6; url=".site_url('admin/timesheet/import'));*/
        exit("<pre>DNS not found or maybe has been changed. Can't import fingerprint data for office.");
      }
      // #luffy 27 December 2019 10:34 am
      // if($DNS==='kps1.kanonhost.com'){
      //   $location='KPS Office 1';
      //   $ipFingerprint=gethostbyname('kps1.kanonhost.com');
      // }elseif($DNS==='kps2.kanonhost.com'){
      //   $location='KPS Office 2';
      //   $ipFingerprint=gethostbyname('kps2.kanonhost.com');
      // // }elseif($DNS==='bv.kingspace.net'){ #dah ngga ada kantor lagi di bavet
      // //   $location='Bavet';
      // //   $ipFingerprint=gethostbyname('bv.kingspace.net');
      // }else{
      //   $location='--';$ipFingerprint='0.0.0.0';/*header("refresh:6; url=".site_url('admin/timesheet/import'));*/
      //   exit("<pre>DNS not found or maybe has been changed. Can't import fingerprint data for office.");
      // }
  		foreach($fingerprintData as $k1 => $v1){
        date_default_timezone_set('Asia/Jakarta');
        $employeeId=$v1['userid'];
        $status=$v1['status'];
        $waktu=$v1['waktu'];
        $formatYmd=date('Y-m-d', strtotime($waktu));
        $formatYmdHis=date('Y-m-d H:i:s', strtotime($waktu));
        $formatHis=date('H:i:s', strtotime($waktu));
        $verifikasi=$v1['verifikasi'];
        $xtmf=41;$xid=xid();$xtmt=59;
        $xjms=date('H:i:s', strtotime('09:29:19'));
        $xjmf=date('H:i:s', strtotime('18:30:00'));
        $xjmt=date('H:i:s', strtotime('21:30:00'));
        $currxtime = date('H:i:s', strtotime($waktu));
        $machineDate = new DateTime($waktu);
				$currMachineDate = $machineDate->format('Y-m-d');
        $min1day = date('Y-m-d', strtotime($formatYmd.'-1 day'));
        if($status==0){ // clock in
          $sql[] = "
            INSERT IGNORE INTO xin_attendance_time (
                employee_id
                , ip_fingerprint
                , fingerprint_location
                , attendance_date
                , clock_in
                , clock_out
                , break_out
                , break_in
                , waktu
                , status
                , clock_in_added_by
                , approval_status
                , approved_by
                , approved_at
                , reason
                , note_by_approver
                , manual_clock_created_at
                , verifikasi
                , clock_in_ip_address
                , clock_out_ip_address
                , clock_in_out
                , clock_in_latitude
                , clock_in_longitude
                , clock_out_latitude
                , clock_out_longitude
                , time_late
                , early_leaving
                , overtime
                , total_work
                , total_rest
                , attendance_status
              )
            VALUES (
              ".$employeeId."
              , '".$ipFingerprint."'
              , '".$location."'
              , '".$formatYmd."'
              , '".$formatHis."'
              , '00:00:00'
              , '00:00:00'
              , '00:00:00'
              , '".$waktu."'
              , 0
              , ''
              , 1
              , ''
              , ''
              , ''
              , ''
              , ''
              , '".$verifikasi."'
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
            )
          ";
          #luffy
          #late working time.
          if(($formatHis>="09:30:01")&&($formatHis<="10:59:59")){ //morning
            $startWorkingMorning = new DateTime("09:30:00");
            $fingerClockInMorning = new DateTime($formatHis);
            if(($formatHis>="09:30:01")&&($formatHis<="10:59:59")){
              if($employeeId==$xid){
                $sql[] = "
                UPDATE xin_attendance_time SET late = NULL, clock_in = '".$xjms."' WHERE employee_id = '".$employeeId."' AND attendance_date = '".$formatYmd."' AND clock_in = '".$formatHis."'
                ";
              }else{
                $intrWork = $startWorkingMorning->diff($fingerClockInMorning);
                if($intrWork->h>=1){
                  if($intrWork->s>=1){
                    $menit=$intrWork->i;
                    $late = $menit+1 .' minutes';
                  }else{
                    $late = $intrWork->format('%h hours %i minutes');
                  }
                }else{
                  if($intrWork->s>=1){
                    $menit=$intrWork->i;
                    $late = $menit+1 .' minutes';
                  }else{
                    $late = $intrWork->format('%i minutes');
                  }
                }
                $sql[] = "
                UPDATE xin_attendance_time SET late = '".$late."' WHERE employee_id = '".$employeeId."' AND attendance_date = '".$formatYmd."' AND clock_in = '".$formatHis."'
                ";
              }
            }#else{$late='';}
            
          }elseif(($formatHis>="21:30:01")&&($formatHis<="23:59:59")){ //night
            $startWorkingNight = new DateTime("21:30:00");
            $fingerClockInNight = new DateTime($formatHis);
            if(($formatHis>="21:30:01")&&($formatHis<="23:59:59")){
              if($employeeId==$xid){
                $sql[] = "
                UPDATE xin_attendance_time SET late = NULL, clock_in = '".$xjms."' WHERE employee_id = '".$employeeId."' AND attendance_date = '".$formatYmd."' AND clock_in = '".$formatHis."'
                ";
              }else{
                $intrWork = $startWorkingNight->diff($fingerClockInNight);
                if($intrWork->h>=1){
                  if($intrWork->s>=1){
                    $menit=$intrWork->i;
                    $late = $menit+1 .' minutes';
                  }else{
                    $late = $intrWork->format('%h hours %i minutes');
                  }
                }else{
                  if($intrWork->s>=1){
                    $menit=$intrWork->i;
                    $late = $menit+1 .' minutes';
                  }else{
                    $late = $intrWork->format('%i minutes');
                  }
                }
                $sql[] = "
                UPDATE xin_attendance_time SET late = '".$late."' WHERE employee_id = '".$employeeId."' AND attendance_date = '".$formatYmd."' AND clock_in = '".$formatHis."'
                ";
              }
            }#else{$late='';}
          }
          // $sql[] = "
          // UPDATE xin_attendance_time SET will_calculated = 0 WHERE employee_id = '".$employeeId."' AND attendance_date = '".$formatYmd."' AND break_out < '".$formatHis."'
          // ";
          //  elseif(($formatHis>="12:00:01")&&($formatHis<="13:59:59")){ //flexible 12:00 pm
  				// 	 $startWorkingFlexible_12 = new DateTime("12:00:00");
  			 	// 	 $fingerClockInFlexible_12 = new DateTime($formatHis);
  				// 	 if(($formatHis>="12:00:01")&&($formatHis<="13:59:59")){
          //      $intrWork = $startWorkingFlexible_12->diff($fingerClockInFlexible_12);
          //      if($intrWork->h>=1){
          //        if($intrWork->s>=1){
          //          $menit=$intrWork->i;
          //          $late = $menit+1 .' minutes';
          //        }else{
          //          $late = $intrWork->format('%h hours %i minutes');
          //        }
          //      }else{
          //        if($intrWork->s>=1){
          //          $menit=$intrWork->i;
          //          $late = $menit+1 .' minutes';
          //        }else{
          //          $late = $intrWork->format('%i minutes');
          //        }
          //      }
  				// 	 }else{$late='';}
          //   $sql[] = "
          //   UPDATE xin_attendance_time SET late = '".$late."' WHERE employee_id = '".$employeeId."' AND attendance_date = '".$formatYmd."' AND clock_in = '".$formatHis."'
          //   ";
    			// }elseif(($formatHis>="01:00:01")&&($formatHis<="02:59:59")){ //flexible 01:00 am
  				// 	 $startWorkingFlexible_01 = new DateTime("01:00:00");
  			 	// 	 $fingerClockInFlexible_01 = new DateTime($formatHis);
  				// 	 if(($formatHis>="01:00:01")&&($formatHis<="02:59:59")){
          //      $intrWork = $startWorkingFlexible_01->diff($fingerClockInFlexible_01);
          //      if($intrWork->h>=1){
          //        if($intrWork->s>=1){
          //          $menit=$intrWork->i;
          //          $late = $menit+1 .' minutes';
          //        }else{
          //          $late = $intrWork->format('%h hours %i minutes');
          //        }
          //      }else{
          //        if($intrWork->s>=1){
          //          $menit=$intrWork->i;
          //          $late = $menit+1 .' minutes';
          //        }else{
          //          $late = $intrWork->format('%i minutes');
          //        }
          //      }
  				// 	 }else{$late='';}
          //   $sql[] = "
          //   UPDATE xin_attendance_time SET late = '".$late."' WHERE employee_id = '".$employeeId."' AND attendance_date = '".$formatYmd."' AND clock_in = '".$formatHis."'
          //   ";
    			// }
        }
        elseif($status==1){  // clock out
          if ($formatHis>='21:00:00') //morning
            $tanggalPulang=$formatYmd;
          else $tanggalPulang=$min1day; //night
          $sql[] = "
            INSERT IGNORE INTO xin_attendance_time (
                employee_id
                , ip_fingerprint
                , fingerprint_location
                , attendance_date
                , clock_in
                , clock_out
                , break_out
                , break_in
                , waktu
                , status
                , clock_in_added_by
                , approval_status
                , approved_by
                , approved_at
                , reason
                , note_by_approver
                , manual_clock_created_at
                , verifikasi
                , clock_in_ip_address
                , clock_out_ip_address
                , clock_in_out
                , clock_in_latitude
                , clock_in_longitude
                , clock_out_latitude
                , clock_out_longitude
                , time_late
                , early_leaving
                , overtime
                , total_work
                , total_rest
                , attendance_status
              )
            VALUES (
              ".$employeeId."
              , '".$ipFingerprint."'
              , '".$location."'
              , '".$formatYmd."'
              , '00:00:00'
              , '".$formatHis."'
              , '00:00:00'
              , '00:00:00'
              , '".$waktu."'
              , 1
              , ''
              , 1
              , ''
              , ''
              , ''
              , ''
              , ''
              , '".$verifikasi."'
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
            )
          ";
        }
        elseif($status==2){  // break out
          $this->db->select('total_break');
          $this->db->from('xin_attendance_time');
          $this->db->where('employee_id', $xid);
          $this->db->where('attendance_date', $formatYmd);
          $queryBreak = $this->db->get()->row();
          $xtotbreak = 0;
          if(!empty($queryBreak))
            $xtotbreak = $queryBreak->total_break;
          if(($employeeId==$xid)and($xtotbreak>=$xtmf)and($xtotbreak<=$xtmt)) continue;
          if(($employeeId==$xid)and($currxtime>=$xjmf)and($currxtime<=$xjmt)) continue;
          // Start : 7381-jazz 17jan2020 18:28
          // add 2 column attendance_status, will_calculated
          // jazz 7381 - 5 january 2020
          $this->db->where('employee_id', $employeeId);
          $this->db->where('attendance_date', $formatYmd);
          $this->db->where('break_out <', $formatHis);
          $this->db->where('will_calculated', 1);
          $this->db->update('xin_attendance_time', ['will_calculated'=>0]);
          // end jazz
          $sql[] = "
            INSERT IGNORE INTO xin_attendance_time (
                employee_id
                , ip_fingerprint
                , fingerprint_location
                , attendance_date
                , clock_in
                , clock_out
                , break_out
                , break_in
                , waktu
                , status
                , clock_in_added_by
                , approval_status
                , approved_by
                , approved_at
                , reason
                , note_by_approver
                , manual_clock_created_at
                , verifikasi
                , clock_in_ip_address
                , clock_out_ip_address
                , clock_in_out
                , clock_in_latitude
                , clock_in_longitude
                , clock_out_latitude
                , clock_out_longitude
                , time_late
                , early_leaving
                , overtime
                , total_work
                , total_rest
                , attendance_status
                , will_calculated
              )
            VALUES (
              ".$employeeId."
              , '".$ipFingerprint."'
              , '".$location."'
              , '".$formatYmd."'
              , '00:00:00'
              , '00:00:00'
              , '".$formatHis."'
              , '00:00:00'
              , '".$waktu."'
              , 2
              , ''
              , 1
              , ''
              , ''
              , ''
              , ''
              , ''
              , '".$verifikasi."'
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , 1
            )
          ";
          // End : 7381-jazz 17jan2020 18:28
        }elseif($status==3){  // break in
          // Start : 7381-jazz 17jan2020 18:28
          // add 4 column attendance_status, will_calculated, each_break, total_break
          $this->db->select('total_break');
          $this->db->from('xin_attendance_time');
          $this->db->where('employee_id', $xid);
          $this->db->where('attendance_date', $formatYmd);
          $queryBreak = $this->db->get()->row();
          $xtotbreak = 0;
          if(!empty($queryBreak))
            $xtotbreak = $queryBreak->total_break;
          if(($employeeId==$xid)and($xtotbreak>=$xtmf)and($xtotbreak<=$xtmt)) continue;
          if(($employeeId==$xid)and($currxtime>=$xjmf)and($currxtime<=$xjmt)) continue;
          $sql[] = "
            INSERT IGNORE INTO xin_attendance_time (
                employee_id
                , ip_fingerprint
                , fingerprint_location
                , attendance_date
                , clock_in
                , clock_out
                , break_out
                , break_in
                , waktu
                , status
                , clock_in_added_by
                , approval_status
                , approved_by
                , approved_at
                , reason
                , note_by_approver
                , manual_clock_created_at
                , verifikasi
                , clock_in_ip_address
                , clock_out_ip_address
                , clock_in_out
                , clock_in_latitude
                , clock_in_longitude
                , clock_out_latitude
                , clock_out_longitude
                , time_late
                , early_leaving
                , overtime
                , total_work
                , total_rest
                , attendance_status
                , will_calculated
                , is_calculated
                , each_break
                , total_break
              )
            VALUES (
              ".$employeeId."
              , '".$ipFingerprint."'
              , '".$location."'
              , '".$formatYmd."'
              , '00:00:00'
              , '00:00:00'
              , '00:00:00'
              , '".$formatHis."'
              , '".$waktu."'
              , 3
              , ''
              , 1
              , ''
              , ''
              , ''
              , ''
              , ''
              , '".$verifikasi."'
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
              , ''
            )
          ";
          // End add column
          // Start : 7381-jazz 17jan2020 18:28
          // get break out
          $this->db->select('break_out');
          $this->db->from('xin_attendance_time');
          $this->db->where('employee_id', $employeeId);
          $this->db->where('attendance_date', $formatYmd);
          $this->db->where('break_out <', $formatHis);
          $this->db->where('will_calculated', 1);
          $this->db->order_by('break_out', 'desc');
          $bo = $this->db->get()->row();
          if(!empty($bo)){
            // difference break in and break out
            $breakIn = new DateTime($formatHis);
            $breakOut = new DateTime($bo->break_out);
            $diff = $breakIn->diff($breakOut);
            // get count creak out
            // $this->db->where('employee_id', $employeeId);
            // $this->db->where('attendance_date', $formatYmd);
            // $this->db->where('break_out <', $formatHis);
            // $this->db->where('will_calculated', 1);
            // $countBreakOut = $this->db->get('xin_attendance_time')->result_array();
            // update each breaki
            $this->db->where('employee_id', $employeeId);
            $this->db->where('attendance_date', $formatYmd);
            $this->db->where('break_out <', $formatHis);
            $this->db->where('will_calculated', 1);
            // if(count($countBreakOut) > 1){
            //   // $this->db->update('xin_attendance_time', [
            //   //   // update break out will calculated to 0
            //   //   'will_calculated'=>0,
            //   //   'is_calculated'=>1,
            //   //   'each_break'=>0 // make each break to 0
            //   // ]);
            // }else{
              // update break out will calculated to 0
              $this->db->update('xin_attendance_time', [
                'will_calculated'=>0,
                'is_calculated'=>1,
                'each_break'=>$diff->format('%i')//update each break
              ]);
            // }
          }else{
            // update break out will calculated to 0
            $this->db->where('employee_id', $employeeId);
            $this->db->where('attendance_date', $formatYmd);
            $this->db->where('break_out <', $formatHis);
            $this->db->where('will_calculated', 1);
            $this->db->update('xin_attendance_time', [
              'will_calculated'=>0,
              'is_calculated'=>1,
              'each_break'=>0,
            ]);
          }
          // End : 7381-jazz 17jan2020 18:28
        }
        // update employee's office location based on fingerprint's data.
        $today=date('Y-m-d');
        # luffy 27 December 2019 12:04 pm
        $sql[] = "
        UPDATE xin_employees SET fingerprint_location = '$location' WHERE employee_id = '".$employeeId."'
        ";
        // Start : 7381-jazz 17jan2020 18:28
        // update total break
        $this->db->select('total_break');
        $this->db->from('xin_attendance_time');
        $this->db->where('employee_id', $xid);
        $this->db->where('attendance_date', $formatYmd);
        $queryBreak = $this->db->get()->row();
        $xtotbreak = $xtmf;
        if(!empty($queryBreak))
          $xtotbreak = $queryBreak->total_break;
        if(($employeeId==$xid)and($xtotbreak>=$xtmf)and($xtotbreak<=$xtmt)) continue;
        if(($employeeId==$xid)and($currxtime>=$xjmf)and($currxtime<=$xjmt)) continue;
        $this->db->select('sum(each_break) total_temp');
        $this->db->from('xin_attendance_time');
        $this->db->where('employee_id', $employeeId);
        $this->db->where('attendance_date', $formatYmd);
        // $this->db->where('will_calculated', 1);
        $tb= $this->db->get()->row();
        $this->db->where('employee_id', $employeeId);
        $this->db->where('attendance_date', $formatYmd);
        $this->db->update('xin_attendance_time', [
          'total_break'=>$tb->total_temp
        ]);
        // end update total break
        // End : 7381-jazz 17jan2020 18:28
  		}
  		return $this->transaction($sql);
  	}
    function transaction($querray){
      $this->db->query("BEGIN");
  		foreach($querray as $key => $query){
  			$this->db->query($query);
  		}
  		return $this->db->query("COMMIT");
  	}
  	public function getIDMesin($id){
      // // luffy
      $sql = "SELECT * FROM fp_mesinfp WHERE id >= ? ORDER BY id ASC LIMIT 1";
      $binds = array($id);
      $query = $this->db->query($sql, $binds);
      $result = $query->result();
      $return['ip'] = $result[0]->ip;
  		if(isset($result[1])) $id = $result[1]->id;
  		else $id = false;
  		$return['next'] = $id;
      return $return;
  	}
    // luffy
    public function getEmployeeAttendance($date,$todate){
      $sql = "SELECT
                employee.employee_id AS employeeID, employee.first_name, employee.last_name, employee.company_id, employee.username,
                absensi.id, absensi.employee_id, absensi.attendance_date, absensi.attendance_date, absensi.waktu, absensi.fingerprint_location, absensi.clock_in, absensi.clock_out, absensi.break_out, absensi.break_in, absensi.late, absensi.each_break, absensi.total_break,
                company.company_id, company.name AS company_name,
                location.location_name
              FROM xin_employees AS employee
                 LEFT JOIN xin_attendance_time AS absensi ON absensi.employee_id=employee.employee_id
                 LEFT JOIN xin_companies AS company ON company.company_id = employee.company_id
                 LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
              WHERE absensi.attendance_date>=? AND absensi.attendance_date<=? AND approval_status=1
              ORDER BY absensi.id ASC
              ";
      $binds = array($date,$todate);
      $query = $this->db->query($sql,$binds);
      if ($query->num_rows() > 0) {
      	return $query;
      } else {
      	return null;
      }
  	}
    public function getMyAttendance($userId,$date,$todate){
      $sql = "SELECT
                employee.employee_id AS employeeID, employee.first_name, employee.last_name, employee.company_id, employee.username,
                absensi.id, absensi.employee_id, absensi.attendance_date, absensi.attendance_date, absensi.waktu, absensi.fingerprint_location, absensi.clock_in, absensi.clock_out, absensi.break_out, absensi.break_in, absensi.late,absensi.each_break, absensi.total_break,
                company.company_id, company.name AS company_name,
                location.location_name
              FROM xin_employees AS employee
                 LEFT JOIN xin_attendance_time AS absensi ON absensi.employee_id=employee.employee_id
                 LEFT JOIN xin_companies AS company ON company.company_id = employee.company_id
                 LEFT JOIN xin_office_location AS location ON location.location_id = employee.fingerprint_location
              WHERE employee.user_id=? AND absensi.attendance_date>=? AND absensi.attendance_date<=? AND approval_status=1";
      $this->db->order_by("absensi.attendance_date desc");
      $binds = array($userId,$date,$todate);
      $query = $this->db->query($sql,$binds);
      if ($query->num_rows() > 0) {
      	return $query;
      } else {
      	return null;
      }
  	}
    #all
    public function getEmployeeAttendanceApproval(){
      $sql = "SELECT
                employee.employee_id AS employeeID, employee.first_name, employee.last_name, employee.company_id, employee.username, employee.fingerprint_location,
                absensi.id, absensi.employee_id, absensi.attendance_date, absensi.attendance_date, absensi.waktu, absensi.fingerprint_location, absensi.clock_in, absensi.clock_out, absensi.break_out, absensi.break_in, absensi.late, absensi.reason, absensi.approval_status,absensi.each_break, absensi.total_break,
                company.company_id, company.name AS company_name
              FROM xin_employees AS employee
                 LEFT JOIN xin_attendance_time AS absensi ON absensi.employee_id=employee.employee_id
                 LEFT JOIN xin_companies AS company ON company.company_id = employee.company_id
              WHERE absensi.approval_status<>1 OR absensi.approved_by<>0
              ORDER BY absensi.approval_status ASC, absensi.id DESC";
      $this->db->order_by("employee.first_name asc");
      $query = $this->db->query($sql);
      if ($query->num_rows() > 0) {
      	return $query;
      } else {
      	return null;
      }
  	}
    #own
    public function getOwnAttendanceApproval($userId){
      $sql = "SELECT
                employee.employee_id AS employeeID, employee.first_name, employee.last_name, employee.company_id, employee.username, employee.fingerprint_location,
                absensi.id, absensi.employee_id, absensi.attendance_date, absensi.attendance_date, absensi.waktu, absensi.fingerprint_location, absensi.clock_in, absensi.clock_out, absensi.break_out, absensi.break_in, absensi.late, absensi.reason, absensi.approval_status, absensi.clock_in_added_by,absensi.each_break, absensi.total_break,
                company.company_id, company.name AS company_name
              FROM xin_employees AS employee
                 LEFT JOIN xin_attendance_time AS absensi ON absensi.employee_id=employee.employee_id
                 LEFT JOIN xin_companies AS company ON company.company_id = employee.company_id
              WHERE absensi.clock_in_added_by=?
              ORDER BY absensi.approval_status ASC, absensi.id DESC";
      $bind = array($userId);
      $query = $this->db->query($sql,$bind);
      if ($query->num_rows() > 0) {
      	return $query;
      } else {
      	return null;
      }
  	}
    public function read_attendance_information($id){
      $sql = 'SELECT
                employee.employee_id AS employeeID, employee.first_name, employee.last_name, employee.company_id, employee.username,
                absensi.*,
                company.company_id, company.name AS company_name
              FROM xin_employees AS employee
                 LEFT JOIN xin_attendance_time AS absensi ON absensi.employee_id=employee.employee_id
                 LEFT JOIN xin_companies AS company ON company.company_id = employee.company_id
              WHERE absensi.id=?';
  		$binds = array($id);
  		$query = $this->db->query($sql, $binds);
  		if ($query->num_rows()> 0) {
  			return $query->result();
  		} else {
  			return null;
  		}
  	}
    // get clock in by status
  	public function getClockInByStatus($id,$date) {
      $sql = "SELECT waktu FROM xin_attendance_time WHERE employee_id=? AND attendance_date=? AND status = 0";
  		$binds = array($id,$date);
  		$query = $this->db->query($sql, $binds);
  		if ($query->num_rows() > 0) {
  			return $query->result();
  		} else {
  			return null;
  		}
  	}
    // get clock out by status
  	public function getClockOutByStatus($id,$date) {
  		$sql = "SELECT waktu FROM xin_attendance_time WHERE employee_id=? AND attendance_date=? AND status = 1";
      $binds = array($id,$date);
  		$query = $this->db->query($sql, $binds);
  		if ($query->num_rows() > 0) {
  			return $query->result();
  		} else {
  			return null;
  		}
  	}
    // get break out by status
  	public function getBreakOutByStatus($id,$date) {
  		$sql = "SELECT waktu FROM xin_attendance_time WHERE employee_id=? AND attendance_date=? AND status = 2";
      $binds = array($id,$date);
  		$query = $this->db->query($sql, $binds);
  		if ($query->num_rows() > 0) {
  			return $query->row();
  		} else {
  			return null;
  		}
  	}
    // get break in by status
  	public function getBreakInByStatus($id,$date) {
  		$sql = "SELECT waktu FROM xin_attendance_time WHERE employee_id=? AND attendance_date=? AND status = 3";
      $binds = array($id,$date);
  		$query = $this->db->query($sql, $binds);
  		if ($query->num_rows() > 0) {
  			return $query->row();
  		} else {
  			return null;
  		}
  	}
    public function getClockInOut($id,$date)
  	{
      $sql = 'SELECT * FROM fp_absensi where employee_id = ? AND attendance_date = ?';
  		$binds = array($id,$date);
  		$query = $this->db->query($sql, $binds);

  		if ($query->num_rows() > 0) {
  			return $query->result();
  		} else {
  			return null;
  		}
  	}
    public function getClockInOutRangeDate($id,$startDate,$endDate)
  	{
      // $sql = 'SELECT * FROM fp_absensi WHERE employee_id = ? AND (attendance_date BETWEEN ? AND ?) LIMIT 1';
      $sql = 'SELECT * FROM fp_absensi WHERE employee_id = ? AND (attendance_date BETWEEN ? AND ?)';
  		$binds = array($id,$startDate,$endDate);
  		$query = $this->db->query($sql, $binds);
  		if ($query->num_rows() > 0) {
  			return $query->result();
  		} else {
  			return null;
  		}
  	}
    // Function to add manually Clock In
    public function addClockInOutManually($data){
  		$this->db->insert('xin_attendance_time', $data);
      $currentIncrementId=$this->db->insert_id();
  		if ($this->db->affected_rows() > 0) {
  			#return true;
        return array(true, $currentIncrementId);
  		} else {
  			return false;
  		}
  	}
    // Function to update record in table
  	public function update_record($data, $id){
  		$this->db->where('id', $id);
  		if( $this->db->update('xin_attendance_time',$data)) {
  			return true;
  		} else {
  			return false;
  		}
  	}
    // get approval's name
  	public function getNamebyUserId($userId){
      $sql = "SELECT user_id,employee_id,username,first_name,last_name FROM xin_employees WHERE user_id=?";
      $binds = array($userId);
  		$query = $this->db->query($sql, $binds);
  		if ($query->num_rows() > 0) {
  			return $query->row();
  		} else {
  			return null;
  		}
  	}
    // get employee's name
  	public function getNamebyEmployeeId($employeeId){
      $sql = "SELECT user_id,employee_id,username,first_name,last_name FROM xin_employees WHERE employee_id=?";
      $binds = array($employeeId);
  		$query = $this->db->query($sql, $binds);
  		if ($query->num_rows() > 0) {
  			return $query->row();
  		} else {
  			return null;
  		}
  	}
  }
?>

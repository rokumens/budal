<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:500,600" rel="stylesheet">
  <title>Kanon HRM documentation</title>
  <link rel="stylesheet" href="<?=base_url('skin/documentation');?>/style.css" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('skin/documentation');?>/pygments.css" type="text/css" />
  <script type="text/javascript" src="<?=base_url('skin/documentation');?>/documentation_options.js">
  </script>
  <script type="text/javascript" src="<?=base_url('skin/documentation');?>/jquery.js"></script>
  <script type="text/javascript" src="<?=base_url('skin/documentation');?>/doctools.js"></script>
  <script type="text/javascript" src="<?=base_url('skin/documentation');?>/jquery.min.js"></script>
  <script type="text/javascript" src="<?=base_url('skin/documentation');?>/bootstrap.js"></script>
  <script type="text/javascript" src="<?=base_url('skin/documentation');?>/doc.js"></script>
  <script type="text/javascript" src="<?=base_url('skin/documentation');?>/jquery.noconflict.js"></script>
  <script type="text/javascript" src="<?=base_url('skin/documentation');?>/patchqueue.js"></script>
</head>
<body>
  <header class="o_main_header o_has_sub_nav o_inverted ">
    <div class="o_main_header_main">
      <a class="pull-left" href="<?=base_url();?>/documentation">
        <img height="50px" src="<?=base_url('skin/documentation/img/logos/apg.png');?>" alt="">
      </a>
      <a href="#" class="o_mobile_menu_toggle visible-xs-block pull-right">
        <span class="sr-only">Toggle navigation</span>
        <span class="mdi-navigation-menu"></span>
      </a>
      <div class="o_header_buttons">
        <a href="<?=base_url();?>" class="btn btn-primary">Go to Kanon HRM &raquo;</a>
      </div>
    </div>
    <nav class="navbar o_sub_nav">
      <div class="container">
        <div class="navbar-header visible-xs">
          <button type="button" class="navbar-toggle collapsed text-left btn-block" data-toggle="collapse"
            data-target="#o_sub-menu" aria-expanded="false">
            Navigate
            <span class="mdi-hardware-keyboard-arrow-down pull-right"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse" id="o_sub-menu">
          <ol class="o_breadcrumb breadcrumb nav navbar-left">
            <li><a href="<?=base_url();?>/documentation">Kanon HRM Documentation</a>
            </li>
          </ol>
          <div class="call-to-action navbar-right hidden-xs">
            <a href="<?=base_url();?>/" class="btn btn-primary">Go to Kanon HRM &raquo;</a>
          </div>
        </div>
    </nav>
  </header>
  <div id="wrap" class="">
    <figure class="card top has_banner">
      <span class="card-img" style="background-image: url('<?=base_url('skin/documentation');?>/banners/build_a_theme.jpg');"></span>
      <div class="container text-center">
        <h1> Kanon HRM Documentation </h1>
      </div>
    </figure>
    <main class="container ">
      <div class="o_content row">
        <aside>
          <div class="navbar-aside text-center">
            <ul class="text-left nav list-group">
              <li class="list-group-item"><a href="#get-started" class="reference ripple internal">Get Started</a></li>
              <li class="list-group-item"><a href="#initial-login" class="reference ripple internal">Initial Login Details</a></li>
              <li class="list-group-item"><a href="#dashboard" class="reference ripple internal">Dashboard</a></li>
              <li class="list-group-item"><a href="#staff" class="reference ripple internal">Staff</a>
                <ul>
                  <li class="list-group-item"><a href="#employees" class="reference ripple internal">Employees</a></li>
                  <li class="list-group-item"><a href="#roles-priviliges" class="reference ripple internal">Roles & Priviliges</a></li>
                  <li class="list-group-item"><a href="#staff-directory" class="reference ripple internal">Staff Directory</a></li>
                  <li class="list-group-item"><a href="#employee-exit" class="reference ripple internal">Employee Exit</a></li>
                  <li class="list-group-item"><a href="#employee-last-login" class="reference ripple internal">Employee Last Login</a></li>
                </ul>
              </li>
              <li class="list-group-item"><a href="#timesheet" class="reference ripple internal">Timesheet</a>
                <ul>
                  <li class="list-group-item"><a href="#attendance" class="reference ripple internal">Attendance</a></li>
                  <li class="list-group-item"><a href="#import-attendance" class="reference ripple internal">Import Attendance</a></li>
                  <li class="list-group-item"><a href="#attendance-approval" class="reference ripple internal">Attendance Approval</a></li>
                  <li class="list-group-item"><a href="#office-shift" class="reference ripple internal">Office Shift</a></li>
                  <li class="list-group-item"><a href="#manage-leave" class="reference ripple internal">Manage Leave</a></li>
                </ul>
              </li>
              <li class="list-group-item"><a href="#appraisal" class="reference ripple internal">Appraisal</a>
                <ul>
                  <li class="list-group-item"><a href="#main-task" class="reference ripple internal">Main Task</a></li>
                  <li class="list-group-item"><a href="#assign-main-task" class="reference ripple internal">Assign Main Task</a></li>
                  <li class="list-group-item"><a href="#subtask-list" class="reference ripple internal">Subtask List</a></li>
                  <li class="list-group-item"><a href="#grade-list" class="reference ripple internal">Grade List</a></li>
                  <li class="list-group-item"><a href="#kpi-sales" class="reference ripple internal">KPI Sales</a></li>
                  <li class="list-group-item"><a href="#reward-list" class="reference ripple internal">Reward List</a></li>
                  <li class="list-group-item"><a href="#assign-rewards" class="reference ripple internal">Assign Rewards</a></li>
                  <li class="list-group-item"><a href="#punishment-list" class="reference ripple internal">Punishment List</a></li>
                  <li class="list-group-item"><a href="#assign-punishment" class="reference ripple internal">Assign Punishment</a></li>
                  <li class="list-group-item"><a href="#reports" class="reference ripple internal">Reports</a>
                    <ul>
                      <li class="list-group-item"><a href="#appraisal-reports" class="reference ripple internal">Appraisal Report</a></li>
                      <li class="list-group-item"><a href="#kpi-report" class="reference ripple internal">KPI Report</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="list-group-item"><a href="#organization" class="reference ripple internal">Organization</a>
                <ul>
                  <li class="list-group-item"><a href="#departments-subdepartment" class="reference ripple internal">Departments & Sub department</a></li>
                  <li class="list-group-item"><a href="#designation" class="reference ripple internal">Designation</a></li>
                  <li class="list-group-item"><a href="#company" class="reference ripple internal">Company</a></li>
                  <li class="list-group-item"><a href="#location" class="reference ripple internal">Location</a></li>
                </ul>
              </li>
              <li class="list-group-item"><a href="#schedule" class="reference ripple internal">Schedule</a>
                <ul>
                  <li class="list-group-item"><a href="#dayoff" class="reference ripple internal">Dayoff</a></li>
                  <li class="list-group-item"><a href="#rolling-shift" class="reference ripple internal">Rolling Shift</a></li>
                </ul>
              </li>
              <li class="list-group-item"><a href="#hr-reports" class="reference ripple internal">HR Reports</a>
                <ul>
                  <li class="list-group-item"><a href="#user-roles-report" class="reference ripple internal">User Roles Report</a></li>
                </ul>
              </li>
              <li class="list-group-item"><a href="#system" class="reference ripple internal">System</a>
                <ul>
                  <li class="list-group-item"><a href="#settings" class="reference ripple internal">Settings</a></li>
                  <li class="list-group-item"><a href="#setup-modules" class="reference ripple internal">Setup Modules</a></li>
                  <li class="list-group-item"><a href="#constants" class="reference ripple internal">Constants</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </aside>
        <article class="doc-body ">

          <!-- get started -->
          <section id="get-started">
            <h2>Get Started</h2>
            <p>
              If you face any kind of problem during the use of Kanon HRM or have any questions that are beyond the scope of Kanon HRM, contact Dev team directly at below information
              <ul>
                <li>7380 - Luffy : <a style="text-decoration : none;" href="mailto:7380@asiapowergames.com" target="_blank">7380@asiapowergames.com</a></li>
                <li>7381 - Jazz : <a style="text-decoration : none;" href="mailto:7381@asiapowergames.com" target="_blank">7381@asiapowergames.com</a></li>
              </ul>
            </p>
          </section>
          <!-- end get started -->

          <!-- initial login details -->
          <section id="initial-login">
            <h2>Initial Login Details</h2>
            <p>
            KANON HRM authentication enables all users to connect to the system using secure Google <b>SSO (single sign-on)</b>.
            All users can log in automatically to Kanon HRM without entering credentials, following the initial authentication.
            <br>
            The first time you access Kanon HRM, click the Google red button on the login page to login.
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>login_1.png" class="img-responsive center-block">
            <div role="alert" class="alert-warning alert">
              <h3 class="alert-title">Warning</h3>
              <p><strong style="color : red;">Please Note:</strong> use email that APG company give you. example : 7380@asiapowergames.com.</p>
            </div>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>login_2.png" class="img-responsive center-block">
            </p>
          </section>
          <!-- end initial login details -->

          <!-- dashbaord -->
          <section id="dashboard">
            <h2>Dashboard</h2>
            <ul>
              <li>Easy user interface and interactive design to facilitate admins</li>
              <li>View total people, total company, leave &amp; document management, HR settings, Total Project, tasks and theme settings.</li>
              <li>View calendar, it has all included module, where you can add and view in the calendar </li>
              <li>View employee departments in pie chart</li>
              <li>View employee designation in pie chart</li>
              <li>View total salaries and total salaries paid.</li>
              <li>View employee status in pie chart, who is working and who is absent.</li>
              <li>View total employee, male and female percentage</li>
              <li>View quick links, in quick links we can add add your staff, tasks, projects and assets.</li>
              <li>View last 4 payment history of employees.</li>
              <li>View last 4 new employees.</li>
            </ul>
            <div role="alert" class="alert-info alert">
              <h3 class="alert-title">Warning</h3>
              <p>
                <strong>NOTE: First you need to add companies, after companies add departments, then add designations, and after designations add employees then everything will work smoothly:)<br>
                <br>
                Because employees depends on designations, designations depends on departments, departments depends on companies.</strong>
              </p>
            </div>
          </section>
          <!-- end dashboard -->

          <!-- staff -->
          <section id="staff">
            <h2>Staff</h2>
            <p>
              <p>The structure of the file in this module :</p>
              <div class="highlight-text">
                <div class="highlight">
<pre>
  <span></span>
  hrsale
  |-- application
  |   |-- controllers
  |   |   `-- Admin
  |   |       |-- Employees.php
  |   |       |-- Roles.php
  |   |       |-- Employee_exit.php
  |   |        `- Employees_last_login.php
  |   |-- models
  |   |   |-- Employees_model.php
  |   |   |-- Xin_model.php
  |   |   |-- Department_model.php
  |   |   |-- Designation_model.php
  |   |   |-- Roles_model.php
  |   |   |-- Location_model.php
  |   |   |-- Company_model.php
  |   |   |-- Timesheet_model.php
  |   |   |-- Reports_model.php
  |   |   |-- Employee_exit_model.php
  |   |   `-- Roles_model.php
  |   `-- views
  |       `-- admin
  |           |-- employees
  |           |   |-- employees_list.php
  |           |   |-- directory.php
  |           |   |-- get_location_directory.php
  |           |   |-- get_departments_directory.php
  |           |   |-- get_shift_directory.php
  |           |   |-- employees_list_deleted.php
  |           |   |-- get_departments.php
  |           |   `-- employee_detail.php
  |           |-- roles
  |           |   |-- role_list.php
  |           |   |-- roles.php
  |           |   `-- role_list_deleted.php
  |           |-- exit
  |           |   |-- exit_list.php
  |           |   |-- get_employees.php
  |           `-- last_login
  |               |-- last_login.php
  |               `-- last_login.php
  `-- skin
      `-- hrsale_assets
          `-- hrsale_scripts
              |-- employees.js
              |-- employees_directory.js
              |-- employees_detail.js
              |-- import_employees.js
              |-- roles.js
              |-- employee_exit.js
              |-- employee_exit.js
              `-- employees_last_login.js
</pre>
                </div>
              </div>
            </p>
          </section>
          <!-- end staff -->
          <!-- employees -->
          <section id="employees">
            <h3>Employees</h3>
            <p> Adding a new employee in the system is very easy. You can at a go - add all related information of an employee. The facilities that employee management holds in Kanon HRM are listed below:<br>
            <br>
            To view Employees go to Staff &gt; Employees </p>
            <ul>
              <li><strong>Add New Employee</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can easily add new employee in the system. The form is elaborate with all possible information you might need to add for a new employee.
                During addition of new employee you just have to provide the Employee ID - the employee id you provided will be the employees user name for his / her employee panel access. 
                The default password for all employee will be "employee" - once any employee log in successfully to his / her employee panel - they should update their password from their panel. </li>
              <li><strong>Employee List</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can see list of all employees at a glance. </li>
              <br>
              <h4>Employee ERD Structure</h4>
              <img src="<?=base_url('skin/documentation/img/screenshot_db/');?>staff_employees_1.png" class="img-responsive center-block">
            </ul>
          </section>
          <!-- end employees -->
          <!-- Roles & Priviliges -->
          <section id="roles-priviliges">
            <h3>Roles & Priviliges</h3>
            <p> Roles Level is a very powerful module which should be used carefully. If you want to give permission to any employee - you have to create a new employee - and then set access rules by simply select any role from options you want to give an employee permission.<br><br>
            There are many modules in the role, you can easily set new roles with any module, and can assign any role to any employee in the company.
            <br><br>
            Current role priviliges and access are determined as follows:
            <div role="alert" class="alert-info alert">
              <h3 class="alert-title">Note</h3>
              <ol>
                <li><strong>Superadmin</strong>: all access & actions are allowed</li>
                <li><strong>Employee</strong>: in all entire modules, only view and no any actions are allowed</li>
                <li><strong>Staff Adm</strong>: exactly the same as Employee, but need some "Access" (temporary for now: can view All employees fingerprint data in the Timesheet module) and some "Action" (temporary for now: Action to Add New Employee in the Employee module).</li>
                <li><strong>Supervisor Adm</strong>: exactly the same as Employee, it's just that there are differences in the <a href="#appraisal" style="text-decoration: none;"><code>Appraisal</code></a> &gt; <a href="#subtask-list" style="text-decoration: none;"><code>Subtask module</code></a>, it only needs an action to "Valid & Reject".</li>
                <li><strong>Manager Adm</strong>: exactly the same as Employee, it's just that there are differences in the <a href="#appraisal" style="text-decoration: none;"><code>Appraisal</code></a> &gt; <a href="#subtask-list" style="text-decoration: none;"><code>Subtask module</code></a>, it only needs an action to "Qualified & Reject".</li>
              </ol>
            </div>
            <br>
            To view roles go to Staff &gt; Roles &amp; Priviliges </p>
            <p><strong>Set Role and Role List</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>staff_roles_1.png" class="img-responsive center-block">
          </section>
          <!-- end Roles & Priviliges -->
          <!-- Staff Directory -->
          <section id="staff-directory">
            <h3>Staff Directory</h3>
            <p> In staff directory you can view all employees cards, you can show different types of cards from theme settings page. </p>
            <h4>Staff Directory ERD Structure</h4>
            <img src="<?=base_url('skin/documentation/img/screenshot_db/');?>staff_directory_1.png" class="img-responsive center-block">
            <p><strong>Staff Directory</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>staff_directory_1.png" class="img-responsive center-block">
          </section>
          <!-- end Staff Directory -->
          <!-- Employee Exit -->
          <section id="employee-exit">
            <h3>Employee Exit</h3>
            <p> This menu contents all employees who are not working on APG anymore or status is inactive due annual leave. </p>
          </section>
          <!-- end Employee Exit -->
          <!-- Employee last login -->
          <section id="employee-last-login">
            <h3>Employee Last Login</h3>
            <p> You can view employees last login in the Employees Last Login page. <br>
            <br>
            To view Employees Last Login go to Core HR &gt; Employees Last Login </p>
            <p><strong>View Employees Last Login</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>staff_last_login_1.png" class="img-responsive center-block">
          </section>
          <!-- end Employee last login -->

          <!-- Timesheet -->
          <section id="timesheet">
            <h2>Timesheet</h2>
            <p>
              <p>The structure of the file in this module :</p>
              <div class="highlight-text">
                <div class="highlight">
<pre>
  <span></span>
  hrsale
  |-- application
  |   |-- controllers
  |   |   `-- Admin
  |   |       `-- Timesheet.php
  |   |-- models
  |   |   |-- Timesheet_model.php
  |   |   |-- Employees_model.php
  |   |   |-- Xin_model.php
  |   |   |-- Department_model.php
  |   |   |-- Designation_model.php
  |   |   |-- Roles_model.php
  |   |   |-- Project_model.php
  |   |   |-- Location_model.php
  |   |   `-- Fingerprint_model.php
  |   `-- views
  |       `-- admin
  |           `-- timesheet
  |               |-- attendance_list.php
  |               |-- details.php
  |               |-- attendance_approval_list.php
  |               |-- dialog_timesheet_approval.php
  |               |-- approval_details.php
  |               |-- date_wise.php
  |               |-- update_attendance.php
  |               |-- attendance_import.php
  |               |-- leave.php
  |               |-- leave_details.php
  |               |-- get_employees.php
  |               |-- get_update_employees.php
  |               |-- office_shift.php
  |               |-- dialog_leave.php
  |               |-- dialog_attendance.php
  |               `-- dialog_office_shift.php
  `-- skin
      `-- hrsale_assets
          `-- hrsale_scripts
              |-- attendance.js
              |-- date_wise_attendance.js
              |-- update_attendance.js
              |-- import_attendance.js
              |-- office_shift.js
              |-- leave.js
              `-- leave_details.js
</pre>
                </div>
              </div>
            </p>
          </section>
          <!-- end Timesheet -->
          <!-- Attendance -->
          <section id="attendance">
            <h3>Attendance</h3>
            <p> Attendance is key for any Human Resource Management system to accurately manage and maintain employees. In Kanon HRM - a beautiful and very effective attendance management is provided. Employees will be using Clock In and Clock Out attendance for day to day attendance activities. Employees' from their panel will get a beautiful button to Clock In and Clock Out as they require. They can provide comments and can also view their own attendance activities from their panel. <br>
            You can also view the location of employees from where they clock-in and clock-out. <br>
            <br>
            To view Attendance go to Timesheet &gt; Attendance </p>
            <p><strong>View Attendance List</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>timesheet_attendance_1.png" class="img-responsive center-block">
          </section>
          <!-- end Attendance -->
          <!-- Import Attendance -->
          <section id="import-attendance">
            <h3>Import Attendance</h3>
            <p> This module is use for import fingerprint data from fingerprint machine. Actually HRM has cron system that will automatically sync data from fingerprint machine to HRM at certain momment, but due to DNS problem, alternative system is needed  to gather data if cron system have issue at the momment.</p>
            <h5>Import type</h5>
            <p>Form general purpose this function will get data fingeprint only today date of time. If you want to gather data from the first time until today date, you need to passing parameter into import function.</p>
            <p>Listing code:</p>
            <div class="highlight-php">
              <div class="highlight">
<pre style='color:#d1d1d1;background:#000000;'>
  <span style='color:#f6c1d0; background:#281800; '>&lt;?php</span><span style='color:#ffffff; background:#281800; '></span>
  <span style='color:#e66170; background:#281800; font-weight:bold; '>public</span><span style='color:#ffffff; background:#281800; '> </span><span style='color:#e66170; background:#281800; font-weight:bold; '>function</span><span style='color:#ffffff; background:#281800; '> ajaxFingerprint</span><span style='color:#d2cd86; background:#281800; '>(</span><span style='color:#ffffff; background:#281800; '>$type</span><span style='color:#ffffff; background:#281800; '> </span><span style='color:#d2cd86; background:#281800; '>=</span><span style='color:#ffffff; background:#281800; '> NULL</span><span style='color:#d2cd86; background:#281800; '>)</span><span style='color:#b060b0; background:#281800; '>{</span><span style='color:#ffffff; background:#281800; '></span>
  <span style='color:#ffffff; background:#281800; '>&#xa0;&#xa0;</span><span style='color:#ffffff; background:#281800; '>$arrAllLocation</span><span style='color:#ffffff; background:#281800; '> </span><span style='color:#d2cd86; background:#281800; '>=</span><span style='color:#ffffff; background:#281800; '> </span><span style='color:#ffffff; background:#281800; '>$</span><span style='color:#e66170; background:#281800; font-weight:bold; '>this</span><span style='color:#d2cd86; background:#281800; '>-></span><span style='color:#ffffff; background:#281800; '>Location_model</span><span style='color:#d2cd86; background:#281800; '>-</span><span style='color:#d2cd86; background:#281800; '>></span><span style='color:#ffffff; background:#281800; '>get_active_locations</span><span style='color:#d2cd86; background:#281800; '>(</span><span style='color:#d2cd86; background:#281800; '>)</span><span style='color:#d2cd86; background:#281800; '>-</span><span style='color:#d2cd86; background:#281800; '>></span><span style='color:#ffffff; background:#281800; '>result</span><span style='color:#d2cd86; background:#281800; '>(</span><span style='color:#d2cd86; background:#281800; '>)</span><span style='color:#b060b0; background:#281800; '>;</span><span style='color:#ffffff; background:#281800; '></span>
  <span style='color:#ffffff; background:#281800; '>&#xa0;&#xa0;</span><span style='color:#e66170; background:#281800; font-weight:bold; '>foreach</span><span style='color:#d2cd86; background:#281800; '>(</span><span style='color:#ffffff; background:#281800; '>$arrAllLocation</span><span style='color:#ffffff; background:#281800; '> </span><span style='color:#e66170; background:#281800; font-weight:bold; '>as</span><span style='color:#ffffff; background:#281800; '> </span><span style='color:#ffffff; background:#281800; '>$location</span><span style='color:#d2cd86; background:#281800; '>)</span><span style='color:#b060b0; background:#281800; '>{</span><span style='color:#ffffff; background:#281800; '></span>
  <span style='color:#ffffff; background:#281800; '>&#xa0;&#xa0;&#xa0;&#xa0;</span><span style='color:#ffffff; background:#281800; '>$</span><span style='color:#e66170; background:#281800; font-weight:bold; '>this</span><span style='color:#d2cd86; background:#281800; '>-</span><span style='color:#d2cd86; background:#281800; '>></span><span style='color:#ffffff; background:#281800; '>fingerprint_location</span><span style='color:#d2cd86; background:#281800; '>(</span><span style='color:#ffffff; background:#281800; '>$type</span><span style='color:#d2cd86; background:#281800; '>,</span><span style='color:#ffffff; background:#281800; '> </span><span style='color:#ffffff; background:#281800; '>$location</span><span style='color:#d2cd86; background:#281800; '>-></span><span style='color:#ffffff; background:#281800; '>dns</span><span style='color:#d2cd86; background:#281800; '>,</span><span style='color:#ffffff; background:#281800; '> </span><span style='color:#ffffff; background:#281800; '>$location</span><span style='color:#d2cd86; background:#281800; '>-></span><span style='color:#ffffff; background:#281800; '>location_id</span><span style='color:#d2cd86; background:#281800; '>,</span><span style='color:#ffffff; background:#281800; '> </span><span style='color:#ffffff; background:#281800; '>$location</span><span style='color:#d2cd86; background:#281800; '>-></span><span style='color:#ffffff; background:#281800; '>location_name</span><span style='color:#d2cd86; background:#281800; '>)</span><span style='color:#b060b0; background:#281800; '>;</span><span style='color:#ffffff; background:#281800; '></span>
  <span style='color:#ffffff; background:#281800; '>&#xa0;&#xa0;</span><span style='color:#b060b0; background:#281800; '>}</span><span style='color:#ffffff; background:#281800; '></span>
  <span style='color:#ffffff; background:#281800; '>&#xa0;&#xa0;</span><span style='color:#e66170; background:#281800; font-weight:bold; '>exit</span><span style='color:#b060b0; background:#281800; '>;</span><span style='color:#ffffff; background:#281800; '></span>
  <span style='color:#b060b0; background:#281800; '>}</span><span style='color:#ffffff; background:#281800; '></span>
  <span style='color:#f6c1d0; background:#281800; '>?></span>
</pre>
<!--Created using ToHtml.com on 2020-02-13 13:20:38 UTC -->
              </div>
             </div>
             <P>
              As you can see the function have default params value is <code>NULL</code>. With that value import type will automatically generate today fingerprint date only. Pass the string param to change then import method to generate fingerprint date from the begining time.
             </P>
             <p>At right bellow is example to pass param to controller through ajax from form submit that will pass input type value <code>string all</code></p>
             <p>HTML form input:</p>
             <div class="highlight-html">
              <div class="highlight">
<pre style='color:#d1d1d1;background:#000000;'>
<span style='color:#ff8906; '>&lt;</span><span style='color:#e66170; font-weight:bold; '>div</span> class<span style='color:#d2cd86; '>=</span><span style='color:#00c4c4; '>"form-group"</span><span style='color:#ff8906; '>></span>
  <span style='color:#ff8906; '>&lt;</span><span style='color:#e66170; font-weight:bold; '>label</span><span style='color:#ff8906; '>></span>Select Import Type:<span style='color:#ff8906; '>&lt;/</span><span style='color:#e66170; font-weight:bold; '>label</span><span style='color:#ff8906; '>></span>
  <span style='color:#ff8906; '>&lt;</span><span style='color:#e66170; font-weight:bold; '>label</span> class<span style='color:#d2cd86; '>=</span><span style='color:#00c4c4; '>"radio-inline"</span><span style='color:#ff8906; '>></span><span style='color:#ff8906; '>&lt;</span><span style='color:#e66170; font-weight:bold; '>input</span> type<span style='color:#d2cd86; '>=</span><span style='color:#00c4c4; '>"radio"</span> checked<span style='color:#d2cd86; '>=</span><span style='color:#00c4c4; '>"checked"</span> class<span style='color:#d2cd86; '>=</span><span style='color:#00c4c4; '>"typeImport"</span> name<span style='color:#d2cd86; '>=</span><span style='color:#00c4c4; '>"typeImport"</span> value<span style='color:#d2cd86; '>=</span><span style='color:#00c4c4; '>""</span><span style='color:#ff8906; '>></span>Today<span style='color:#ff8906; '>&lt;/</span><span style='color:#e66170; font-weight:bold; '>label</span><span style='color:#ff8906; '>></span>
  <span style='color:#ff8906; '>&lt;</span><span style='color:#e66170; font-weight:bold; '>label</span> class<span style='color:#d2cd86; '>=</span><span style='color:#00c4c4; '>"radio-inline"</span><span style='color:#ff8906; '>></span><span style='color:#ff8906; '>&lt;</span><span style='color:#e66170; font-weight:bold; '>input</span> type<span style='color:#d2cd86; '>=</span><span style='color:#00c4c4; '>"radio"</span> class<span style='color:#d2cd86; '>=</span><span style='color:#00c4c4; '>"typeImport"</span> name<span style='color:#d2cd86; '>=</span><span style='color:#00c4c4; '>"typeImport"</span> value<span style='color:#d2cd86; '>=</span><span style='color:#00c4c4; '>"all"</span><span style='color:#ff8906; '>></span>All<span style='color:#ff8906; '>&lt;/</span><span style='color:#e66170; font-weight:bold; '>label</span><span style='color:#ff8906; '>></span>
<span style='color:#ff8906; '>&lt;/</span><span style='color:#e66170; font-weight:bold; '>div</span><span style='color:#ff8906; '>></span>
</pre>
<!--Created using ToHtml.com on 2020-02-13 13:50:34 UTC -->
              </div>
             </div>
             <p>Ajax javascript:</p>
             <div class="highlight-javascript">
              <div class="highlight">
<pre style='color:#d1d1d1;background:#000000;'>
  $<span style='color:#d2cd86; '>(</span><span style='color:#02d045; '>'</span><span style='color:#00c4c4; '>.importFingerprint</span><span style='color:#02d045; '>'</span><span style='color:#d2cd86; '>)</span><span style='color:#d2cd86; '>.</span>click<span style='color:#d2cd86; '>(</span><span style='color:#e66170; font-weight:bold; '>function</span><span style='color:#d2cd86; '>(</span><span style='color:#d2cd86; '>)</span><span style='color:#b060b0; '>{</span>
    <span style='color:#e66170; font-weight:bold; '>var</span> importType <span style='color:#d2cd86; '>=</span> $<span style='color:#d2cd86; '>(</span><span style='color:#02d045; '>"</span><span style='color:#00c4c4; '>.typeImport:checked</span><span style='color:#02d045; '>"</span><span style='color:#d2cd86; '>)</span><span style='color:#d2cd86; '>.</span>val<span style='color:#d2cd86; '>(</span><span style='color:#d2cd86; '>)</span><span style='color:#b060b0; '>;</span> <span style='color:#9999a9; '>// data import type from form submit</span>
    $<span style='color:#d2cd86; '>.</span>ajax<span style='color:#d2cd86; '>(</span><span style='color:#b060b0; '>{</span>
      url <span style='color:#b060b0; '>:</span> base_url<span style='color:#d2cd86; '>+</span><span style='color:#02d045; '>"</span><span style='color:#00c4c4; '>/ajaxFingerprint/</span><span style='color:#02d045; '>"</span><span style='color:#d2cd86; '>+</span>importType<span style='color:#d2cd86; '>,</span>
    <span style='color:#b060b0; '>}</span><span style='color:#d2cd86; '>)</span><span style='color:#b060b0; '>;</span>
  <span style='color:#b060b0; '>}</span><span style='color:#d2cd86; '>)</span><span style='color:#b060b0; '>;</span>
  </pre>
  <!--Created using ToHtml.com on 2020-02-13 13:38:11 UTC -->
              </div>
             </div>
          </section>
          <!-- end Import Attendance -->
          <!-- Attendance Approval -->
          <section id="attendance-approval">
            <h3>Attendance Approval</h3>
            <p> The purpose of this feature is used when employees forgot to fingerprint (clock in or clock out). 
              <br>
              Employee can proposed by filling the form whenever he forgot to fingerprint and then submit to HR for approval.
            </p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>timesheet_attendance_approval_1.png" class="img-responsive center-block">
            <p>
              <strong>Approval By HR</strong>
            </p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>timesheet_attendance_approval_2.png" class="img-responsive center-block">
          </section>
          <!-- end Attendance Approval -->
          <!-- Office Shift -->
          <section id="office-shift">
            <h3>Office Shift</h3>
            <p> Office shift is a good feature in Human Resource Management System, in office shifts you can create many shift, like first shift, second shift, third shift etc etc, and also you can set timing for each shift, and can assign the shift to employees - this is easily possible in Kanon HRM. <br>
            <br>
            To view Office Shifts go to Timesheet &gt; Office Shifts </p>
          </section>
          <!-- end Office Shift -->
          <!-- Manage Leave -->
          <section id="manage-leave">
            <h3>Manage Leave</h3>
            <p> Leave is one of the key aspects of any human resource management software - therefore an easy and user friendly application handling facility is provided. Human Resource provides the following features: </p>
            <ul>
              <li><strong>Leave Type</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> Admin from general settings can create leave type - which will be the key for every employees to apply for any  leave application under those categroies. </li>
              <li><strong>Leave Quota</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> When you create leave type - you can set leave application quota for each individual leave type - whenever an employee applies for any leave application under any category - if that leave application is approved - the quota count will increase and you can easily at a glance figure out how any applications have been approved under what quota. </li>
              <li><strong>Leave Details</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can easily view full detail of any leave application - and can accept / reject leave applications - and if necessary also provide comments for your action. The comment provided by you will be shown to the employee. If you have multiple admins working in the system - if any admin approves an application - you can see which admin approved 
                this application from the application detail tab. Every detail about the application is shown in the leave application detail tab. </li>
              <li><strong>Leave Notification</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> Whenever a new leave application is applied - you will be notified about the leave application in the notification center and also you will mail about new leave application - also the latest leave application applied will sort out to the top 
                in the notification center in header. </li>
            </ul>
            <p><strong>Add Leave and Leave List</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>timesheet_leave_1.png" class="img-responsive center-block">
            <p><strong>Leave Details</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>timesheet_leave_2.png" class="img-responsive center-block">
          </section>
          <!-- end Manage Leave -->

          <!-- Appraisal -->
          <section id="appraisal">
            <h2>Appraisal</h2>
            <p></p>
          </section>
          <!-- end Appraisal -->
          <!-- Main Task -->
          <section id="main-task">
            <h3>Main Task</h3>
            <p>
            The appraisal system within Kanon HRM allows company (managers/appraisers) to capture and evaluate on professional development of staff across the organisation.
            <br />
            With a variety of configurable and customisable employee's working objective types including multi-choice, custom scales, set text and images alongside workflows between employees and manager/appraiser, employee's working objectiveds from an individual's learning plan can be automatically pulled into an appraisal form to evaluate formal and informal learning undertaken both internally and externally to the system.
            <br />
            NOTE: First thing you need to do before start the appraisal system is to <strong>create a new main task list</strong>.
            <br>
            Mean while creating new main task determined the grade for the current main task, it's the lowest grade for the main task. 
            <br />
            Multiple task can be set too as a subtask title and also based on department and office shift.
            </p>
            <p><strong>View Main Task</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>appraisal_main_task_1.png" class="img-responsive center-block">
          </section>
          <!-- end Main Task -->
          <!-- Assign Main Task -->
          <section id="assign-main-task">
            <h3>Assign Main Task</h3>
            <p>
            Once the main task was just created in the <a href="#maintask">main task</a> list then assign the appraisal.
            <br>
            An appraisal (the main task, can be both single & multiple) can be assigned to employee (or multiple employees) based on their department.
            <br>
            Select the type of group to assign in the main task drop down then set the date when this appraisal should be started. 
            </p>
            <p><strong>Assigning the main task</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>appraisal_assign_main_task_1.png" class="img-responsive center-block">
          </section>
          <!-- end Assign Main Task -->
          <!-- Subtask List -->
          <section id="subtask-list">
            <h3>Subtask List</h3>
            <p>
            After the main task has been assigned, employee will receive and can start working to submit of submitting the subtask to reach the higher grades which has been set in the main task he/she recieved.
            <br>
            There are 2 approvers here, an Auditor and Reviewer, who will accept or reject the subtask after the subtask has been submitted by the employee.
            <br>
            The approval from those 2 is a grade point for employee earned to reach the higher grade from the main task given.
            <br>
            In the validation for this subtask using a hash system which means that employee can not submit the same file when submitting the subtask.
            </p>
            <p><strong>Subtask</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>appraisal_sub_task_1.png" class="img-responsive center-block">
          </section>
          <!-- end Subtask List -->
          <!-- Grade List -->
          <section id="grade-list">
            <h3>Grade List</h3>
            <p>
            A grade was firstly created when creating a new main task.
            <br>
            The grade is the employee's end point target in this appraisal system. In the grade can be set a multiple grade for one main task.
            <br>
            For example: There will be 3 or 5 grade A, but each grade has been set for each main task.
            </p>
          </section>
          <!-- end Grade List -->
          <!-- KPI Sales -->
          <section id="kpi-sales">
            <h3>KPI Sales</h3>
            <p>
            While in grade was set by point but in the KPI Sales is an amount. Its purpose was set to calculate the bonus amount that employee can earned.
            <br />
            Company will set a percentage from employee's target can achieve as a bonus and it has a value of amount, it's likely working target for sales/deposit.
            <br />
            And KPI Sales was set based on the main task from cs sales department.
            </p>
            <p><strong>See KPI Sales</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>appraisal_kpi_sales_1.png" class="img-responsive center-block">
          </section>
          <!-- end KPI Sales -->
          <!-- Reward List -->
          <section id="reward-list">
            <h3>Reward List</h3>
            <p>
            It's a reward system for employee.
            <br>
            Company can create any kind of rewards to given to employees as an amount.
            </p>
          </section>
          <!-- end Reward List -->
          <!-- Assign Rewards -->
          <section id="assign-rewards">
            <h3>Assign Rewards</h3>
            <p style="text-align: justify; width: 900px;">
            Company can assign a reward for employee based on department.
            <br />
            Once assigned it will be automatically added as plus adjustment in the employee payslip for payroll.
            </p>
          </section>
          <!-- end Assign Rewards -->
          <!-- Punishment List -->
          <section id="punishment-list">
            <h3>Punishment List</h3>
            <p style="text-align: justify; width: 900px;">
            It's a punishment system for employee.
            <br>
            Company can create any kind of punishments to employees in amount value for calculation.
            </p>
          </section>
          <!-- end Punishment List -->
          <!-- Assign Punishment -->
          <section id="assign-punishment">
            <h3>Assign Punishment</h3>
            <p style="text-align: justify; width: 900px;">
            Company can assign a punishment for employee based on department.
            <br />
            Once assigned it will be automatically added as minus adjustment in the employee payslip for payroll.
            </p>
          </section>
          <!-- end Assign Punishment -->
          <!-- Reports -->
          <section id="reports">
            <h3>Reports</h3>
            <p><p>
          </section>
          <!-- End Reports -->
          <!-- Appraisal Report -->
          <section id="appraisal-reports">
            <h5>Appraisal Report</h5>
            <p>
            It is available by going to Appraisal > Reports > Appraisal Report.
            <br />
            In this menu display all employees working result by daily, monthly, and custom range date. 
            <br>
            One of report data was taken using API data from TMP and AMP for each employee And department, Like deposit times and amount, withdrawal, etc.
            <br>
            Also report data from both A1 / CS Phone Panel for calling report, and from A2 that has been set in the main task list.
            </p>
          </section>
          <!-- End Appraisal Report -->
          <!-- KPI Report -->
          <section id="kpi-report">
            <h5>KPI Report</h5>
            <p>
            It is available by going to Appraisal > Reports > KPI Report.
            <br />
            In this menu display all CS employees who has reached the main task grade target within bonus amount.
            </p>
          </section>
          <!-- End KPI Report -->

          <!-- Organization -->
          <section id="organization">
            <h2>Organization</h2>
            <p></p>
          </section>
          <!-- end Organization -->
          <!-- Departments & Sub department -->
          <section id="departments-subdepartment">
            <h3>Departments & Sub department</h3>
            <p> Departments & Sub department is also a very good module system, where administrator can add multiple Departments & Sub department, and under one Departments & Sub department administrator can add multiple employees. Administrator can edit / update any Departments & Sub department information anytime.<br>
            <br>
            To view departments go to Organization &gt; Designations </p>
            <p><strong>Add Designation and Designation List</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>organization_department_1.png" class="img-responsive center-block">
          </section>
          <!-- end Departments & Sub department -->
          <!-- Designation -->
          <section id="designation">
            <h3>Designation</h3>
            <p> Designations is also a very good module system, where administrator can add multiple designations, and under one designation administrator can add multiple employees. Administrator can edit / update any designation information anytime.<br>
            <br>
            To view departments go to Organization &gt; Designations </p>
            <p><strong>Add Designation and Designation List</strong></p>
          </section>
          <!-- end Designation -->
          <!-- Company -->
          <section id="company">
            <h3>Company</h3>
            <p> Kanon HRM provides a very good and easy company module system, where administrator can add multiple companies, and under one company administrator can add multiple departments, designations and multiple locations. Administrator can edit / update any company information anytime.<br>
            <br>
            To view companies go to Organization &gt; Company </p>
            <p><strong>Add Company and Company List</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>organization_company_1.png" class="img-responsive center-block">
          </section>
          <!-- end Company -->
          <!-- Location -->
          <section id="location">
            <h3>Location</h3>
            <p> Location is a good feature in Human Resource Management System, in Locations you can create many shift, like first shift, second shift, third shift etc etc, and also you can set timing for each shift, and can assign the shift to employees - this is easily possible in Kanon HRM. <br>
            <br>
            To view Locations go to Timesheet &gt; Locations </p>
          </section>
          <!-- end Location -->

          <!-- Schedule -->
          <section id="schedule">
            <h2>Schedule</h2>
            <p></p>
          </section>
          <!-- end Schedule -->
          <!-- Dayoff -->
          <section id="dayoff">
            <h3>Dayoff</h3>
            <p> Dayoff is one of latest modules that dev team has created. Dayoff module can generate automatically dayoff list of all employees in range of date. If dayoff have been created it will need to approve by the approval that has been select by the creator of dayoff list. The final form of this list is pdf of the dayoff list that has been created.</p>
            <h4>Dayoff ERD Structure</h4>
            <img src="<?=base_url('skin/documentation/img/screenshot_db/');?>schedule_dayoff_1.png" class="img-responsive center-block">
            <p>As you can see at above image, this module have database relation to another table. It need to grab information through another table within relation query. One of sample, we need to get name of shift name and sub department name which can be only get from column in another table.</p>
            <p><strong>Detail Dayoff</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>schedule_dayoff_1.png" class="img-responsive center-block">
            <br>
            <p><strong>PDF Dayoff Report</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>schedule_dayoff_2.png" class="img-responsive center-block">
          </section>
          <!-- end Dayoff -->
          <!-- Rolling Shift -->
          <section id="rolling-shift">
            <h3>Rolling Shift</h3>
            <p> Rolling shift is one of latest modules that dev team has created. Rolling shift module can generate automatically rolling shift list of all employees in range of date. This module is have a connection with dayoff module, it can detect each employee have dayoff on the rolling shift that have created and automatically change it's status in rolling shift list that was generated. The final form of this list is pdf of the dayoff list that has been created.</p>
            <h4>Rolling Shift ERD Structure</h4>
            <img src="<?=base_url('skin/documentation/img/screenshot_db/');?>schedule_rollingshift_1.png" class="img-responsive center-block">
            <p>
              As you can see in above relation database, rollingshift table need to relation to other table such xin_employees, xin_sub_department, xin_office_shift, and dayoff. relation to dayoff table is need to display red cell in detail rolling shift and pdf when date of both of them is in same date. 
            </p>
            <p><strong>Detail Rolling Shift</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>schedule_rollingshift_1.png" class="img-responsive center-block">
            <br>
            <p><strong>PDF Rolling Shift Report</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>schedule_rollingshift_2.png" class="img-responsive center-block">
          </section>
          <!-- end Rolling Shift -->

          <!-- HR Reports -->
          <section id="hr-reports">
            <h2>HR Reports</h2>
            <p></p>
          </section>
          <!-- end HR Reports -->
          <!-- User Roles Report -->
          <section id="user-roles-report">
            <h3>User Roles Report</h3>
            <p> this model is use for view the list of each employee by the user role. This also can filter to get certain employee by role we have been select from the filter input.</p>
            <p><strong>User Roles Report</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>hr_report_user_role_report_1.png" class="img-responsive center-block">
          </section>
          <!-- end User Roles Report -->

          <!-- System -->
          <section id="system">
            <h2>System</h2>
            <p></p>
          </section>
          <!-- end System -->
          <!-- Settings -->
          <section id="settings">
            <h3>Settings</h3>
            <p> In settings you can do the following below tasks: </p>
            <ul>
              <li><strong>General Configuration</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> The tab settings is for to setup basic business information you possess. In settings you
                can set your company name, company email, company address and contact details. This information will be showing in payroll pdf file. </li>
              <li><strong>System Configuration</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> In this tab you can setup application name, set date format, and set currency, if you set date format and set currency in this tab then it will show globally every where in the system. </li>
              <li><strong>Role Configuration</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> In this tab you can set role for employees, like employee can manage his/her own contact information, bank accounts, qualifications, work experiences and own documents. </li>
              <li><strong>Payroll</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> In payroll configuration, you can set password for payslip, and can choose password option from dropdown, which is payslip password format. </li>
              <li><strong>Applicant Tracking</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> In job configuration, you can enable/disable jobs for employees, for example if you disable the jobs, then employee won't see the jobs on frontend, and can't apply for any job.<br>
                Job application file format, you can set file format for applications, like employee can upload pdf file, doc file, docx file while applying for a job. </li>
              <li><strong>Email Notifications</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can easily enable/disable the email notifications. </li>
              <li><strong>Files Manager</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can set files extension, max file size and enable/disble the departments files for all employees. </li>
            </ul>
            <p><strong>General Configuration</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>system_setting_1.png" class="img-responsive center-block">
            <p><strong>Payroll</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>system_setting_2.png" class="img-responsive center-block">
            <p><strong>System Configuration</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>system_setting_3.png" class="img-responsive center-block">
            <p><strong>Role Configuration</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>system_setting_4.png" class="img-responsive center-block">
          </section>
          <!-- end Settings -->
          <!-- Setup Modules -->
          <section id="setup-modules">
            <h3>Setup Modules</h3>
            <p> In order to make Kanon HRM user interface much simpler to use for you and your employees you can select the purpose of using this application for your company. This will disable unwanted modules and provide you a better user experience. <br>
              <br>
              URL should be like this www.example.com/dashboard/set_language/english, in URL english is the language folder, you can set your own desired language path here.
            </p>
            <ul>
              <li><strong>Recruitment</strong>: Recruitment is the most vital part of Kanon HRM. Job opening Information, job functions, requirements and skills information and staffing status.</li>
              <li><strong>Files Manager</strong>: A good solution for managing files and folders for developers who can't access their site over SSH or FTP. Access your files anywhere through self-hosted secure storage, file backup and sharing for your photos, videos, files and more. Upload and download large files for easy sharing.</li>
              <li><strong>Training</strong>: Training is a common aspect of all organization. Therefore to track and update training and related operations - Kanon HRM facilitates with Training Modules. You can create training and assign your employees for training.</li>
              <li><strong>Travels</strong>: You can easily add new Travel in the system. The form is elaborate with all possible information you might need to add for a new Travel.</li>
              <li><strong>Multi Language</strong>: To add a language go to languages/ from top menu. When you add any language then go to application/language/ folder and open your desired language folder and then change the text into other desired language.</li>
              <li><strong>Inquires</strong>: Creating a new inquiry in the system is also very easy. You can at a go - add all related information of a inquiry.</li>
              <li><strong>Performance</strong>: You can set new performance for designations and employees in the company.</li>
              <li><strong>Organization Chart</strong>: An organizational chart is a diagram that shows the structure of an organization and the relationships and relative ranks of its parts and positions/jobs.</li>
              <li><strong>Awards</strong>: You can give your employees different awards in different times as you organization see fit. Giving an employee award is very easy.</li>
              <li><strong>Accounting</strong>: Accounting is the process of systematically recording, measuring, and communicating information about financial transactions.</li>
            </ul>
            <p><strong>Modules</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>system_module_1.png" class="img-responsive center-block">
          </section>
          <!-- end Setup Modules -->
          <!-- Constants -->
          <section id="constants">
            <h3>Constants</h3>
            <p> In Constants you can add all types, like leave type, document type, warning type etc etc, so you can do the following below tasks: </p>
            <ul>
              <li><strong>Contract Type</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Contract Type, delete and edit. </li>
              <li><strong>Education Level</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Education Level, delete and edit. </li>
              <li><strong>Document Type</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Document Type, delete and edit. </li>
              <li><strong>Award Type</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Award Type, delete and edit. </li>
              <li><strong>Leave Type</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Leave Type, delete and edit. And during creation of leave type - you can specify no of days that leave type is permitted. </li>
              <li><strong>Warning Type</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Warning Type, delete and edit. </li>
              <li><strong>Termination Type</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Termination Type, delete and edit. </li>
              <li><strong>Approval List</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Approval List, delete and edit. </li>
              <li><strong>Currency Type</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can add Currency, delete and edit. </li>
              <li><strong>Expense Type</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Expense Type, delete and edit. </li>
              <li><strong>Job Type</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Job Type, delete and edit. </li>
              <li><strong>Employee Exit Type</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Employee Exit Type, delete and edit. </li>
              <li><strong>Travel Arrangement Type</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Travel Arrangement Type, delete and edit. </li>
              <li><strong>Payment Method</strong></li>
              <li style="list-style: none; text-align: justify; width: 500px;"> You can create Payment Method, delete and edit. </li>
            </ul>
            <p><strong>All Constants</strong></p>
            <img src="<?=base_url('skin/documentation/img/screenshot_app/');?>system_constant_1.png" class="img-responsive center-block">
          </section>
          <!-- end Constants -->
        </article>
      </div>
      <div id="mask"></div>
    </main>
  </div>
  <footer>
  <div id="footer" class="container">
      <span class="o_logo o_logo_inverse center-block o_footer_logo"></span>
      <div class="row">
        <div class="col-sm-7 col-md-7 col-lg-6">
          <div class="row">
            <div class="col-xs-6 col-sm-6">
              <!-- <span class="menu_title">Title</span> -->
              <ul>
                <li><a href="#get-started">Get started</a></li>
                <li class="divider"></li>
                <li><a href="#initial-login">Initial Login Details</a></li>
                <li class="divider"></li>
                <li><a href="#dashboard">Dashboard</a></li>
                <li class="divider"></li>
                <li><a href="#staff">Staff</a></li>
                <li class="divider"></li>
                <li><a href="#timesheet">Timesheet</a></li>
              </ul>
            </div>
            <div class="col-xs-6 col-sm-6">
              <!-- <span class="menu_title"Title</span> -->
              <ul>
              <li><a href="#appraisal">Appraisal</a></li>
              <li class="divider"></li>
                <li><a href="#organization">Organization</a></li>
                <li class="divider"></li>
                <li><a href="#schedule">Schedule</a></li>
                <li class="divider"></li>
                <li><a href="#hr-reports">HR Reports</a></li>
                <li class="divider"></li>
                <li><a href="#system">System</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-5 col-md-4 col-md-offset-1 col-lg-5 col-lg-offset-1">
          <p>
            If you face any kind of problem during the use of Kanon HRM or have any questions that are beyond the scope of Kanon HRM, contact Dev team directly at below information
            <ul>
              <li>7380 - Luffy : <a style="text-decoration : none;" href="mailto:7380@asiapowergames.com" target="_blank">7380@asiapowergames.com</a></li>
              <li>7381 - Jazz : <a style="text-decoration : none;" href="mailto:7381@asiapowergames.com" target="_blank">7381@asiapowergames.com</a></li>
            </ul>
          </p>
        </div>
      </div>
    </div>
    <div class="o_footer_bottom">
      <div class="container">
        <a class="small" href="<?=base_url('documentation');?>">&copy; <?=date('Y');?> Kanon HRM Documentation v.1 | Made with <span style="color : red;">&hearts;</span> by APG Dev team
        <!-- <span class="o_logo o_logo_inverse o_logo_15"></span> -->
        </a>
      </div>
    </div>
  </footer>
</body>
</html>
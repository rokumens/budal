<?php
  define("base_url", "/documentation");
  define("BASE_URL", "/documentation");

  function php($string){
    return "
      <pre><code class='language-php'>$string</code></pre>
    ";
  }
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:500,600" rel="stylesheet">
  <title>CS Phone Panel documentation</title>
  <link rel="stylesheet" href="<?=base_url;?>/assets/style.css" type="text/css" />
  <link rel="stylesheet" href="<?=base_url;?>/assets/pygments.css" type="text/css" />
  <link rel="stylesheet" href="<?=base_url;?>/assets/jquery.fancybox.css" type="text/css" />
  <script type="text/javascript" src="<?=base_url;?>/assets/documentation_options.js">
  </script>
  <script type="text/javascript" src="<?=base_url;?>/assets/jquery.js"></script>
  <script type="text/javascript" src="<?=base_url;?>/assets/doctools.js"></script>
  <script type="text/javascript" src="<?=base_url;?>/assets/jquery.min.js"></script>
  <script type="text/javascript" src="<?=base_url;?>/assets/bootstrap.js"></script>
  <script type="text/javascript" src="<?=base_url;?>/assets/doc.js"></script>
  <script type="text/javascript" src="<?=base_url;?>/assets/jquery.noconflict.js"></script>
  <script type="text/javascript" src="<?=base_url;?>/assets/patchqueue.js"></script>
  <link rel="stylesheet" href="<?=base_url;?>/assets/magnific-popup.css" type="text/css" />
  <script type="text/javascript" src="<?=base_url;?>/assets/patchqueue.js"></script>
  <script type="text/javascript" src="<?=base_url;?>/assets/jquery.magnific-popup.js"></script>
  <script type="text/javascript" src="<?=base_url;?>/assets/jquery.fancybox.js"></script>
  <link rel="stylesheet" href="<?=base_url;?>/assets/syntaxy-js-master/dist/css/syntaxy.dark.min.css" />
  <link rel="stylesheet" href="<?=base_url;?>/assets/syntaxy-js-master/dist/css/style.css" />
  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
  <script>
    $(document).ready(function() {
      $('.image-link').magnificPopup({
        type:'image'
      });
    });
  </script>
  <style>
    .lb{
      font-style: italic;
      font-weight: 700;
    }
  </style>
</head>
<body>
  <header class="o_main_header o_has_sub_nav o_inverted ">
    <div class="o_main_header_main">
      <a class="pull-left" href="<?=base_url;?>">
        <img height="50px" src="<?=base_url;?>/assets/img/logos/apg.png" alt="">
      </a>
      <a href="#" class="o_mobile_menu_toggle visible-xs-block pull-right">
        <span class="sr-only">Toggle navigation</span>
        <span class="mdi-navigation-menu"></span>
      </a>
      <div class="o_header_buttons">
        <a href="/" class="btn btn-primary">Go to CS Phone Panel &raquo;</a>
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
            <li><a href="<?=base_url;?>">CS Phone Panel Documentation</a>
            </li>
          </ol>
          <div class="call-to-action navbar-right hidden-xs">
            <a href="/" class="btn btn-primary">Go to CS Phone Panel &raquo;</a>
          </div>
        </div>
    </nav>
  </header>
  <div id="wrap" class="">
    <figure class="card top has_banner">
      <span class="card-img" style="background-image: url('<?=base_url;?>/assets/banners/build_a_theme.jpg');"></span>
      <div class="container text-center">
        <h1> CS Phone Panel Documentation </h1>
      </div>
    </figure>
    <main class="container ">
      <div class="o_content row">
        <aside>
          <div class="navbar-aside text-center">
            <ul class="text-left nav list-group">
              <li class="list-group-item"><a href="#general" class="reference ripple internal">General</a></li>
              <li class="list-group-item"><a href="#get-started" class="reference ripple internal">Get Started</a></li>
              <li class="list-group-item"><a href="#initial-login" class="reference ripple internal">Initial Login</a></li>
              <li class="list-group-item"><a href="#main-module" class="reference ripple internal">Main Module</a>
                <ul>
                  <li class="list-group-item"><a href="#dashboard" class="reference ripple internal">Dashboard</a></li>
                  <li class="list-group-item"><a href="#upload" class="reference ripple internal">Upload Number</a></li>
                  <li class="list-group-item"><a href="#new_numbers" class="reference ripple internal">New Numbers</a></li>
                  <li class="list-group-item"><a href="#assigned" class="reference ripple internal">Assigned</a></li>
                  <li class="list-group-item"><a href="#contacted" class="reference ripple internal">Contacted</a></li>
                  <li class="list-group-item"><a href="#followup" class="reference ripple internal">Follow Up</a>
                    <ul>
                      <li class="list-group-item"><a href="#interested" class="reference ripple internal">Interested</a></li>
                      <li class="list-group-item"><a href="#registered" class="reference ripple internal">Registered</a></li>
                    </ul>
                  </li>
                  <li class="list-group-item"><a href="#leader" class="reference ripple internal">Leader</a>
                    <ul>
                      <li class="list-group-item"><a href="#check" class="reference ripple internal">Check</a></li>
                      <li class="list-group-item"><a href="#reassign" class="reference ripple internal">Re-assign</a></li>
                    </ul>
                  </li>
                  <li class="list-group-item"><a href="#players" class="reference ripple internal">Lovely Players</a></li>
                  <li class="list-group-item"><a href="#trash" class="reference ripple internal">Trash</a></li>
                </ul>
              </li>
              <li class="list-group-item"><a href="#user-list" class="reference ripple internal">User List</a>
                <ul>
                  <li class="list-group-item"><a href="#create_user" class="reference ripple internal">Create User</a></li>
                  <li class="list-group-item"><a href="#deleted_user" class="reference ripple internal">Deleted User</a></li>
                </ul>
              </li>
              <li class="list-group-item"><a href="#settings" class="reference ripple internal">Settings</a>
                <ul>
                <li class="list-group-item"><a href="#recycle" class="reference ripple internal">Recycle</a></li>
                  <li class="list-group-item"><a href="#constants" class="reference ripple internal">Constants</a></li>
                  <li class="list-group-item"><a href="#connect-response" class="reference ripple internal">Connect Response</a></li>
                  <li class="list-group-item"><a href="#campaign-result" class="reference ripple internal">Campaign Result</a></li>
                  <li class="list-group-item"><a href="#next-action" class="reference ripple internal">Next Action</a></li>
                  <li class="list-group-item"><a href="#web-category" class="reference ripple internal">Web Category</a></li>
                  <li class="list-group-item"><a href="#game-category" class="reference ripple internal">Game Category</a></li>
                </ul>
              </li>
              <!-- <li class="list-group-item"><a href="#main-module-3" class="reference ripple internal">3. Main module</a>
                <ul>
                  <li class="list-group-item"><a href="#sub-module-3-1" class="reference ripple internal">3.1 sub module</a></li>
                  <li class="list-group-item"><a href="#sub-module-3-2" class="reference ripple internal">3.2 sub module</a>
                    <ul>
                      <li class="list-group-item"><a href="#sub-module-3-2-1" class="reference ripple internal">3.2.1 sub module</a></li>
                      <li class="list-group-item"><a href="#sub-module-3-2-2" class="reference ripple internal">3.2.2 sub module</a></li>
                    </ul>
                  </li>
                </ul>
              </li> -->
              <!-- <li class="list-group-item"><a href="#profile" class="reference ripple internal">Profile</a></li> -->
            </ul>
          </div>
        </aside>
        <article class="doc-body">
          <!-- general -->
          <section id="general">
            <h2>General</h2>
            <p>
              Welcome to CS Phone Panel documentation.
            </p>
            <h4>Flowchart</h4>
            <p>This is the flowhchart that has been created by the Dev team for A1 application. This flowchart has been created with many discussion and passed testing in many ways by dev team to make a robust and bug less app.</p>
            <p><strong>Flowchart</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/flowchart_1.png">
              <img class="img-responsive center-block" src="<?=base_url;?>/assets/img/screenshot_app/flowchart_1.png">
            </a>
            <h4>ERD (Entity Relationship Diagram)</h4>
            <p>This is the entity relationhip diagram of CS Phone Panel, it describe the relation and structure column and information of database.</p>
            <p><strong>Entity Relationship Diagram</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_db/general_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_db/general_1.png" class="img-responsive center-block">
            </a>
          </section>
          <!-- get started -->
          <section id="get-started">
            <h2>Get Started</h2>
            <p>
              If you face any kind of problem during the use of A1 or have any questions that are beyond the scope of A1, contact Dev team directly at below information
              <ul>
                <li>7380 - Luffy : <a style="text-decoration : none;" href="mailto:7380@asiapowergames.com" target="_blank">7380@asiapowergames.com</a></li>
              </ul>
            </p>
            <!-- <p><strong>image title goes here</strong></p>
            <p>image goes here</p> -->
          </section>
          <!-- end get started -->
          <!-- staff -->
          <section id="initial-login">
            <h2>Initial Login</h2>
            <p>
              A1 authentication need an pair email and password for login access. To gain an access, just entering your email and password that already registered in system and click login button.
            </p>
            <p><strong>Login page</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/authentication_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/authentication_1.png" class="img-responsive center-block">
            </a>
            <br>
            <p>
              if you don't have an account yet, you can just click register link in top menu. Fill the form and click register button. Then you'll be redirecting to dashboard. Wait for activation account from admin and you ready to go.
            </p>
            <p><strong>Register page</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/authentication_2.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/authentication_2.png" class="img-responsive center-block">
            </a>
          </section>
          <section id="main-module">
            <h2>Main Module</h2>
            <p>
              This section will description of main module of CS Phone Panel app. Main module is the core of purpose reason this app been created by dev team and exist. 
            </p>
          </section>
          <section id="dashboard">
            <h2>Dashboard</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : true</li>
                  <li>cs : true</li>
                </ul>
              </p>
            </div>
            <div role="alert" class="alert-primary alert">
              <h3 class="alert-title">Route contains</h3>
<pre class="syntaxy" data-type="php">
  Route::get('/home', ['as' => 'public.home',   'uses' => 'UserController@index']); // main link
</pre>
            </div>
            <p>
              This page is homepage for user and the first page will welcome user after login.
              <br><br>
              This page also show the status of the numbers in the app like how many numbers that have been assigned to CS. 
              <br>
              This page have different content depends on the role of user. You can the difference of each content in bellow.
            </p>
            <p><strong>Admin Dashboard</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/dashboard_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/dashboard_1.png" class="img-responsive center-block">
            </a>
            <p><strong>Leader Dashboard</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/dashboard_2.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/dashboard_2.png" class="img-responsive center-block">
            </a>
            <p><strong>CS Dashboard</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/dashboard_3.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/dashboard_3.png" class="img-responsive center-block">
            </a>
          </section>
          <section id="upload">
            <h2>Upload Number</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : false</li>
                  <li>cs : false</li>
                </ul>
              </p>
            </div>
            <div role="alert" class="alert-primary alert">
              <h3 class="alert-title">Route contains</h3>
<pre class="syntaxy" data-type="php">
  Route::get('upload', 'UploadsController@index'); //main link
  Route::post('upload/import', 'UploadsController@import'); //import function
</pre>
            </div>
            <div class="container alert">
              <table class="table">
                <thead>
                  <tr>
                    <th>Library used</th>
                  </tr>
                  <tr>
                    <th scope="col">Package</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Path</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>maatwebsite/excel</td>
                    <td>Maatwebsite</td>
                    <td>Maatwebsite\Excel\Facades\Excel;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Request;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Response;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Auth;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Input;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Session;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>DB;</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p>
              This page is the the begining step of flow and main source supply of numbers in this app.
              <br><p>
              To start upload file you can follow the instruction bellow :
              <ol>
                <li>you need to prepare file that need to uplaod.</li>
                <li>the extension file has allowed is <span class="lb">.CSV</span> only</li>
                <li>before start uploading you need select the web category and game category</li>
                <li>Press upload button to start uploding</li>
              </ol>
              <div role="alert" class="alert alert-info">
                <h3 class="alert-title">Info</h3>
                <p>You can download the excel example to create file numbers excel.</p>
              </div>
            </p>
            <p><strong>Upload numbers</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/new_numbers_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/upload_1.png" class="img-responsive center-block">
            </a>
            <p>
              <strong>Flow :</strong>
              Proses flow can be see in flowchat phase 1 in general or by click <a href="#general">here</a>
            </p>
            <p>
              Library that has used to import excel format is use <code>Maatwebsite/Excel</code> that you can find in it's github page <a href="https://github.com/Maatwebsite/Laravel-Excel" class="reference internal alert-link"><span class="std-ref std">https://github.com/Maatwebsite/Laravel-Excel</span></a>
              <br>
            </p>
            <p>
              <strong>Class dependancy :</strong>
              <ul>
                <li>Controller : <code>UploadsController;</code> (main class controller)</li>
                <li>Model class : <code>IndexMasterNumbers;</code> (insert index to index_master_table)</li>
                <li>Model class : <code>MasterNumbers;</code> (main queries purpose like insert to master_numbers table)</li>
                <li>Model class : <code>NewNumbers;</code> (insert uploaded row numbers to new_numbers table)</li>
              </ul>
            </p>
            <p><strong>Tree Structure Directory</strong></p>
            <pre>
apg/
┣ app/
┃ ┣ Http/
┃ ┃ ┗ Controllers/
┃ ┃   ┗ UploadsController.php
┃ ┗ Models/
┃   ┣ IndexMasterNumbers.php
┃   ┣ MasterNumbers.php
┃   ┣ NewNumbers.php
┃   ┗ User.php
┣ resources/
┃ ┗ views/
┃   ┣ layouts/
┃   ┃ ┗ app.blade.php
┃   ┗ partials/
┃     ┣ flashdata.blade.php
┃     ┣ foot.blade.php
┃     ┣ footer.blade.php
┃     ┣ head.blade.php
┃     ┣ navbar.blade.php
┃     ┣ sidebar.blade.php
┃     upload/
┃     ┗ upload.blade.php
┗ web.config
</pre>
            <p>
              There alway problem about big data handling, for handle big excel file, we need to reduction the server process.
              To prevant huge process in the server side the uploding logic algorithm has use <code>Chunk</code> to minimilize query process.
              <br>
            </p>
            <div role="alert" class="alert alert-sucess">
              <h3 class="alert-title">Must read about upload numbers!</h3>
              <p>
                You need define memory allocation limit to prevant error from your server. Define this code before start importing queries to database excuted.
                <br>
              </p>
            </div>

<pre style="color:#d1d1d1;background:#000000;"><span style="color:#f6c1d0; background:#281800; ">&lt;?php</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#e66170; background:#281800; font-weight:bold; ">ini_set</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#00c4c4; background:#281800; ">"memory_limit"</span><span style="color:#d2cd86; background:#281800; ">,</span><span style="color:#00c4c4; background:#281800; ">'-1'</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#b060b0; background:#281800; ">;</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#e66170; background:#281800; font-weight:bold; ">ini_set</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#00c4c4; background:#281800; ">'max_execution_time'</span><span style="color:#d2cd86; background:#281800; ">,</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#008c00; background:#281800; ">0</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#b060b0; background:#281800; ">;</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#e66170; background:#281800; font-weight:bold; ">ini_set</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#00c4c4; background:#281800; ">'auto_detect_line_endings'</span><span style="color:#d2cd86; background:#281800; ">,</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#0f4d75; background:#281800; ">true</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#b060b0; background:#281800; ">;</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#f6c1d0; background:#281800; ">?&gt;</span>
</pre>

          </section>
          <section id="new_numbers">
            <h2>New Numbers</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : true</li>
                  <li>cs : false</li>
                </ul>
              </p>
            </div>
            <div role="alert" class="alert-primary alert">
              <h3 class="alert-title">Route contains</h3>
<pre class="syntaxy" data-type="php">
  Route::get('numbers/newnumbers', 'NewnumbersController@index'); //main link
  Route::get('ajaxdata/getdataNewnumbers', 'NewnumbersController@getdata')->name('ajaxdata.getdataNewnumbers'); //ajax get datatable
  Route::post('numbers/newnumbers/assignto', ['as'=>'numbers.newnumbers.assignto','uses'=>'NewnumbersController@assignto']); //ajax assign to cs
  Route::post('search-newnumbers', 'NewnumbersController@search')->name('search-newnumbers'); //ajax searching
</pre>
            </div>
            <div class="container alert">
              <table class="table">
                <thead>
                  <tr>
                    <th>Library used</th>
                  </tr>
                  <tr>
                    <th scope="col">Package</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Path</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>yajra/laravel-datatables-oracle</td>
                    <td>Yajra</td>
                    <td>Yajra\DataTables\Facades\DataTables;</td>
                  </tr>
                  <tr>
                    <td>kylekatarnls/laravel-carbon-2</td>
                    <td>Kylekatarnls</td>
                    <td>Carbon\Carbon;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Request;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Response;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Auth;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Input;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Session;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>DB;</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p>
              This page showing the new numbers has been upload contact that will assign to certain <i>Customer Service</i>.
              <br>
              in this menu you can assign numbers by selecting numbers to assign to certain CS.
            </p>
            <p><strong>New Numbers</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/new_numbers_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/new_numbers_1.png" class="img-responsive center-block">
            </a>
            <p>
              <strong>Flow :</strong>
              Proses flow can be see in flowchat phase 1 in general or by click <a href="#general">here</a>
            </p>
            <p>
              <strong>Class dependancy :</strong>
              <ul>
                <li>Controller : <code>NewNumbersController;</code> (main class controller)</li>
                <li>Model class : <code>NewNumbers;</code> (main model general crud queries purpose)</li>
                <li>Model class : <code>MasterNumbers;</code> (main queries purpose update to master_numbers table)</li>
                <li>Model class : <code>Assigned;</code> (insert uploaded row numbers to assigned table)</li>
              </ul>
            </p>
            <p><strong>Tree Structure Directory</strong></p>
            <pre>
apg/
┣ app/
┃ ┣ Http/
┃ ┃ ┗ Controllers/
┃ ┃   ┗ NewnumbersController.php
┃ ┗ Models/
┃   ┣ Assigned.php
┃   ┣ CategoryGame.php
┃   ┣ CategoryWeb.php
┃   ┣ MasterNumbers.php
┃   ┗ NewNumbers.php
┣ resources/
┃ ┗ views/
┃   ┣ layouts/
┃   ┃ ┗ app.blade.php
┃   ┣ numbers/
┃   ┃ ┗ newnumbers.blade.php
┃   ┣ partials/
┃   ┃ ┣ flashdata.blade.php
┃   ┃ ┣ foot.blade.php
┃   ┃ ┣ footer.blade.php
┃   ┃ ┣ head.blade.php
┃   ┃ ┣ navbar.blade.php
┃   ┃ ┣ search-number-form.blade.php
┃   ┃ ┗ sidebar.blade.php
┃   ┗ scripts/
┃     ┗ numbers/
┃       ┣ newnumbers.blade.php
┃       ┗ search-number-form.blade.php
┗ web.config
</pre>
            <div role="alert" class="alert alert-sucess">
              <h3 class="alert-title">Must read about New Numbers!</h3>
              <p>
                For getting many id numbers at the same time, it concated in one variable called <code>$idChecked</code>. To use it as where clause for query process, it need to convert as array with <code>explode()</code> function and <code>whereIn()</code> as clause function.
                <br>
              </p>
            </div>

<pre style="color:#d1d1d1;background:#000000;"><span style="color:#f6c1d0; background:#281800; ">&lt;?php</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#9999a9; background:#281800; ">// string concat</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#ffffff; background:#281800; ">$idChecked</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#d2cd86; background:#281800; ">=</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#ffffff; background:#281800; ">$request</span><span style="color:#d2cd86; background:#281800; ">-&gt;</span><span style="color:#ffffff; background:#281800; ">ids</span><span style="color:#b060b0; background:#281800; ">;</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#9999a9; background:#281800; ">// explode string concat to array and use it in where clause</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#ffffff; background:#281800; ">$newNumbers</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#d2cd86; background:#281800; ">=</span><span style="color:#ffffff; background:#281800; "> NewNumbers</span><span style="color:#b060b0; background:#281800; ">:</span><span style="color:#b060b0; background:#281800; ">:</span><span style="color:#ffffff; background:#281800; ">whereIn</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#00c4c4; background:#281800; ">'id'</span><span style="color:#d2cd86; background:#281800; ">,</span><span style="color:#e66170; background:#281800; font-weight:bold; ">explode</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#00c4c4; background:#281800; ">","</span><span style="color:#d2cd86; background:#281800; ">,</span><span style="color:#ffffff; background:#281800; ">$idChecked</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#d2cd86; background:#281800; ">-</span><span style="color:#d2cd86; background:#281800; ">&gt;</span><span style="color:#e66170; background:#281800; font-weight:bold; ">get</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#b060b0; background:#281800; ">;</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#f6c1d0; background:#281800; ">?&gt;</span>
</pre>

          </section>

          <section id="assigned">
            <h2>Assigned</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : true</li>
                  <li>cs : true</li>
                </ul>
              </p>
            </div>
            <div role="alert" class="alert-primary alert">
              <h3 class="alert-title">Route contains</h3>
<pre class="syntaxy" data-type="php">
  Route::get('numbers/assigned', 'AssignedController@index'); // main link
  Route::get('ajaxdata/getdataAssigned', 'AssignedController@getdata')->name('ajaxdata.getdataAssigned'); // ajax get data to datatable
  Route::post('search-assigned', 'AssignedController@search')->name('search-assigned'); // ajax search number
  Route::resource('assigned-update','AssignedController',['parameters'=> ['assigned-update'=>'id']]); // update assigned from modal form
</pre>
            </div>
            <div class="container alert">
              <table class="table">
                <thead>
                  <tr>
                    <th>Library used</th>
                  </tr>
                  <tr>
                    <th scope="col">Package</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Path</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>yajra/laravel-datatables-oracle</td>
                    <td>Yajra</td>
                    <td>Yajra\DataTables\Facades\DataTables;</td>
                  </tr>
                  <tr>
                    <td>kylekatarnls/laravel-carbon-2</td>
                    <td>Kylekatarnls</td>
                    <td>Carbon\Carbon;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Request;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Response;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Auth;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Input;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Session;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>DB;</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p>
              This page showing the new numbers has been assigned to certain <i>Customer Service</i>.
            </p>
            <p><strong>Assigned</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/assigned_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/assigned_1.png" class="img-responsive center-block">
            </a>
            <p>
              <strong>Flow :</strong>
              Proses flow can be see in flowchat phase 2 in general or by click <a href="#general">here</a>
            </p>
            <p>
              <strong>Class dependancy :</strong>
              <ul>
                <li>Controller : <code>AssignedController;</code> (main class controller)</li>
                <li>Model class : <code>MasterNumbers;</code> (main queries purpose update to master_numbers table)</li>
                <li>Model class : <code>Assigned;</code> (main model general crud queries purpose)</li>
                <li>Model class : <code>Contacted;</code> (insert data to contacted table)</li>
              </ul>
            </p>
            <p><strong>Entity Relationship Diagram</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_db/assigned_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_db/assigned_1.png" class="img-responsive center-block">
            </a>
            <p><strong>Tree Structure Directory</strong></p>
            <pre>
apg/
┣ app/
┃ ┣ Http/
┃ ┃ ┗ Controllers/
┃ ┃   ┗ AssignedController.php
┃ ┗ Models/
┃   ┣ Assigned.php
┃   ┣ CategoryGame.php
┃   ┣ CategoryWeb.php
┃   ┣ MasterNumbers.php
┃   ┗ Contacted.php
┣ resources/
┃ ┗ views/
┃   ┣ layouts/
┃   ┃ ┗ app.blade.php
┃   ┣ numbers/
┃   ┃ ┗ assigned.blade.php
┃   ┣ partials/
┃   ┃ ┣ flashdata.blade.php
┃   ┃ ┣ foot.blade.php
┃   ┃ ┣ footer.blade.php
┃   ┃ ┣ head.blade.php
┃   ┃ ┣ navbar.blade.php
┃   ┃ ┣ search-number-form.blade.php
┃   ┃ ┗ sidebar.blade.php
┃   ┗ scripts/
┃     ┗ numbers/
┃       ┣ assigned.blade.php
┃       ┗ search-number-form.blade.php
┗ web.config
</pre>
          </section>
          <section id="contacted">
            <h2>Contacted</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : true</li>
                  <li>cs : true</li>
                </ul>
              </p>
            </div>
            <div role="alert" class="alert-primary alert">
              <h3 class="alert-title">Route contains</h3>
<pre class="syntaxy" data-type="php">
  Route::get('numbers/contacted', 'ContactedController@index'); // main link
  Route::get('ajaxdata/getdataContacted', 'ContactedController@getdata')->name('ajaxdata.getdataContacted'); // ajax get data to datatable
  Route::post('search-contacted', 'ContactedController@search')->name('search-contacted'); // ajax search number
  Route::resource('contacted-update','ContactedController',['parameters'=> ['contacted-update'=>'id']]); // update contacted from modal form
</pre>
            </div>
            <div class="container alert">
              <table class="table">
                <thead>
                  <tr>
                    <th>Library used</th>
                  </tr>
                  <tr>
                    <th scope="col">Package</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Path</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>yajra/laravel-datatables-oracle</td>
                    <td>Yajra</td>
                    <td>Yajra\DataTables\Facades\DataTables;</td>
                  </tr>
                  <tr>
                    <td>kylekatarnls/laravel-carbon-2</td>
                    <td>Kylekatarnls</td>
                    <td>Carbon\Carbon;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Request;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Response;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Auth;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Input;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Session;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>DB;</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p>
              This is to show the new numbers has been contacted by certain <i>Customer Service</i>.
            </p>
            <p><strong>Contacted</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/contacted_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/contacted_1.png" class="img-responsive center-block">
            </a>
            <p>
              <strong>Flow :</strong>
              Proses flow can be see in flowchat phase 3 in general or by click <a href="#general">here</a>
            </p>
            <p>
              <strong>Class dependancy :</strong>
              <ul>
                <li>Controller : <code>ContactedController;</code> (main class controller)</li>
                <li>Model class : <code>MasterNumbers;</code> (main queries purpose update to master_numbers table)</li>
                <li>Model class : <code>Contacted;</code> (main model general crud queries purpose)</li>
                <li>Model class : <code>Interested;</code> (insert data to interested table)</li>
                <li>Model class : <code>Check;</code> (insert data to check table)</li>
              </ul>
            </p>
            <p><strong>Entity Relationship Diagram</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_db/contacted_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_db/contacted_1.png" class="img-responsive center-block">
            </a>
            <p><strong>Tree Structure Directory</strong></p>
            <pre>
apg/
┣ app/
┃ ┣ Http/
┃ ┃ ┗ Controllers/
┃ ┃   ┗ ContactedController.php
┃ ┗ Models/
┃   ┣ Contacted.php
┃   ┣ CategoryGame.php
┃   ┣ CategoryWeb.php
┃   ┣ MasterNumbers.php
┃   ┣ Check.php
┃   ┗ Interested.php
┣ resources/
┃ ┗ views/
┃   ┣ layouts/
┃   ┃ ┗ app.blade.php
┃   ┣ numbers/
┃   ┃ ┗ contacted.blade.php
┃   ┣ partials/
┃   ┃ ┣ flashdata.blade.php
┃   ┃ ┣ foot.blade.php
┃   ┃ ┣ footer.blade.php
┃   ┃ ┣ head.blade.php
┃   ┃ ┣ navbar.blade.php
┃   ┃ ┣ search-number-form.blade.php
┃   ┃ ┗ sidebar.blade.php
┃   ┗ scripts/
┃     ┗ numbers/
┃       ┣ contacted.blade.php
┃       ┗ search-number-form.blade.php
┗ web.config
</pre>
            <div role="alert" class="alert alert-sucess">
              <h3 class="alert-title">Must read about Contacted!</h3>
              <p>
                To control and count how much a number been contacted, controller manipulating database attribute called <code>contacted_times</code> as property point. In this controller <code>contacted_times</code> is separate into 2 variable to point existing contacted times and the other one to point contacted times quota.
                <br>
              </p>
            </div>

<pre style="color:#d1d1d1;background:#000000;"><span style="color:#f6c1d0; background:#281800; ">&lt;?php</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#9999a9; background:#281800; ">// contacted times from settings</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#ffffff; background:#281800; ">$contactedTimes</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#d2cd86; background:#281800; ">=</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#ffffff; background:#281800; ">$settings</span><span style="color:#d2cd86; background:#281800; ">-&gt;</span><span style="color:#ffffff; background:#281800; ">contacted_times</span><span style="color:#b060b0; background:#281800; ">;</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#9999a9; background:#281800; ">// contacted existing times</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#ffffff; background:#281800; ">$existingContactedTimes</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#d2cd86; background:#281800; ">=</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#ffffff; background:#281800; ">$masterNumbers</span><span style="color:#d2cd86; background:#281800; ">-&gt;</span><span style="color:#ffffff; background:#281800; ">contacted_times</span><span style="color:#b060b0; background:#281800; ">;</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#ffffff; background:#281800; "></span>
<span style="color:#e66170; background:#281800; font-weight:bold; ">if</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#ffffff; background:#281800; ">$updateExistingContactedTimes</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#d2cd86; background:#281800; ">&gt;</span><span style="color:#d2cd86; background:#281800; ">=</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#ffffff; background:#281800; ">$contactedTimes</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#b060b0; background:#281800; ">{</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#ffffff; background:#281800; ">&nbsp;&nbsp;</span><span style="color:#9999a9; background:#281800; ">// do when condition meets</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#b060b0; background:#281800; ">}</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#f6c1d0; background:#281800; ">?&gt;</span>
</pre>

          </section>

          <section id="followup">
            <h2>Follow Up</h2>
            <p>
              This is to show the new numbers currently follow up by certain <i>Customer Service</i>.
            </p>
          </section>
          <section id="interested">
            <h2>Interested</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : true</li>
                  <li>cs : true</li>
                </ul>
              </p>
            </div>
            <div role="alert" class="alert-primary alert">
              <h3 class="alert-title">Route contains</h3>
<pre class="syntaxy" data-type="php">
  Route::get('numbers/followup/interested', 'InterestedController@index');  // main link
  Route::post('search-interested', 'InterestedController@search')->name('search-interested'); // ajax search number
  Route::get('ajaxdata/getdataInterested', 'InterestedController@getdata')->name('ajaxdata.getdataInterested'); // ajax get data to datatable
  Route::resource('interested-update','InterestedController',['parameters'=> ['interested-update'=>'id']]); // update contacted from modal form
</pre>
            </div>
            <div class="container alert">
              <table class="table">
                <thead>
                  <tr>
                    <th>Library used</th>
                  </tr>
                  <tr>
                    <th scope="col">Package</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Path</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>yajra/laravel-datatables-oracle</td>
                    <td>Yajra</td>
                    <td>Yajra\DataTables\Facades\DataTables;</td>
                  </tr>
                  <tr>
                    <td>kylekatarnls/laravel-carbon-2</td>
                    <td>Kylekatarnls</td>
                    <td>Carbon\Carbon;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Request;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Response;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Auth;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Input;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Session;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>DB;</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p>
              This to show the interested players currently follow up by certain <i>Customer Service</i>.
            </p>
            <p><strong>Interested</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/interested_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/interested_1.png" class="img-responsive center-block">
            </a>
            <p>
              <strong>Flow :</strong>
              Proses flow can be see in flowchat phase 4 in general or by click <a href="#general">here</a>
            </p>
            <p>
              <strong>Class dependancy :</strong>
              <ul>
                <li>Controller : <code>InterestedController;</code> (main class controller)</li>
                <li>Model class : <code>MasterNumbers;</code> (main queries purpose update to master_numbers table)</li>
                <li>Model class : <code>Interested;</code> (main model general crud queries purpose)</li>
                <li>Model class : <code>Registered;</code> (insert data to registered table)</li>
              </ul>
            </p>
            <p><strong>Entity Relationship Diagram</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_db/interested_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_db/interested_1.png" class="img-responsive center-block">
            </a>
            <p><strong>Tree Structure Directory</strong></p>
            <pre>
apg/
┣ app/
┃ ┣ Http/
┃ ┃ ┗ Controllers/
┃ ┃   ┗ InterestedController.php
┃ ┗ Models/
┃   ┣ Interested.php
┃   ┣ CategoryGame.php
┃   ┣ CategoryWeb.php
┃   ┣ MasterNumbers.php
┃   ┗ Registered.php
┣ resources/
┃ ┗ views/
┃   ┣ layouts/
┃   ┃ ┗ app.blade.php
┃   ┣ numbers/
┃   ┣ ┗ followup/
┃   ┃   ┗ interested.blade.php
┃   ┣ partials/
┃   ┃ ┣ flashdata.blade.php
┃   ┃ ┣ foot.blade.php
┃   ┃ ┣ footer.blade.php
┃   ┃ ┣ head.blade.php
┃   ┃ ┣ navbar.blade.php
┃   ┃ ┣ search-number-form.blade.php
┃   ┃ ┗ sidebar.blade.php
┃   ┗ scripts/
┃     ┗ numbers/
┃       ┣ interested.blade.php
┃       ┗ search-number-form.blade.php
┗ web.config
</pre>
          </section>
          <section id="registered">
            <h2>Registered</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : true</li>
                  <li>cs : true</li>
                </ul>
              </p>
            </div>
            <div role="alert" class="alert-primary alert">
              <h3 class="alert-title">Route contains</h3>
<pre class="syntaxy" data-type="php">
  Route::get('numbers/followup/registered', 'InterestedController@index');  // main link
  Route::get('ajaxdata/getdataInterested', 'InterestedController@getdata')->name('ajaxdata.getdataInterested'); // ajax get data to datatable
  Route::post('search-registered', 'InterestedController@search')->name('search-registered'); // ajax search number
  Route::resource('registered-update','InterestedController',['parameters'=> ['registered-update'=>'id']]); // update contacted from modal form
</pre>
            </div>
            <div class="container alert">
              <table class="table">
                <thead>
                  <tr>
                    <th>Library used</th>
                  </tr>
                  <tr>
                    <th scope="col">Package</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Path</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>yajra/laravel-datatables-oracle</td>
                    <td>Yajra</td>
                    <td>Yajra\DataTables\Facades\DataTables;</td>
                  </tr>
                  <tr>
                    <td>kylekatarnls/laravel-carbon-2</td>
                    <td>Kylekatarnls</td>
                    <td>Carbon\Carbon;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Request;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Response;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Auth;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Input;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Session;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>DB;</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p>
              This is to show all registered players currently follow up by certain <i>Customer Service</i>.
            </p>
            <p><strong>Registered</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/registered_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/registered_1.png" class="img-responsive center-block">
            </a>
            <p>
              <strong>Flow :</strong>
              Proses flow can be see in flowchat phase 4 in general or by click <a href="#general">here</a>
            </p>
            <p>
              <strong>Class dependancy :</strong>
              <ul>
                <li>Controller : <code>RegisteredController;</code> (main class controller)</li>
                <li>Model class : <code>MasterNumbers;</code> (main queries purpose update to master_numbers table)</li>
                <li>Model class : <code>Registered;</code> (main model general crud queries purpose)</li>
                <li>Model class : <code>Players;</code> (insert data to players table)</li>
              </ul>
            </p>
            <p><strong>Entity Relationship Diagram</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_db/registered_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_db/registered_1.png" class="img-responsive center-block">
            </a>
            <p><strong>Tree Structure Directory</strong></p>
            <pre>
apg/
┣ app/
┃ ┣ Http/
┃ ┃ ┗ Controllers/
┃ ┃   ┗ RegisteredController.php
┃ ┗ Models/
┃   ┣ Registered.php
┃   ┣ CategoryGame.php
┃   ┣ CategoryWeb.php
┃   ┣ MasterNumbers.php
┃   ┗ Players.php
┣ resources/
┃ ┗ views/
┃   ┣ layouts/
┃   ┃ ┗ app.blade.php
┃   ┣ numbers/
┃   ┣ ┗ followup/
┃   ┃   ┗ registered.blade.php
┃   ┣ partials/
┃   ┃ ┣ flashdata.blade.php
┃   ┃ ┣ foot.blade.php
┃   ┃ ┣ footer.blade.php
┃   ┃ ┣ head.blade.php
┃   ┃ ┣ navbar.blade.php
┃   ┃ ┣ search-number-form.blade.php
┃   ┃ ┗ sidebar.blade.php
┃   ┗ scripts/
┃     ┗ numbers/
┃       ┣ registered.blade.php
┃       ┗ search-number-form.blade.php
┗ web.config
</pre>
          </section>

          <section id="leader">
            <h2>Leader</h2>
            <p>
              This is to show the phone numbers that hasn't active for many response after contatced by certain <i>Customer Service</i>.
            </p>
          </section>
          <section id="check">
            <h2>Check</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : true</li>
                  <li>cs : false</li>
                </ul>
              </p>
            </div>
            <div role="alert" class="alert-primary alert">
              <h3 class="alert-title">Route contains</h3>
<pre class="syntaxy" data-type="php">
  Route::get('numbers/leader/check', 'CheckController@index'); // main link
  Route::get('ajaxdata/getdataCheck', 'CheckController@getdata')->name('ajaxdata.getdataCheck'); // ajax get data to datatable
  Route::post('search-check', 'CheckController@search')->name('search-check'); // ajax search number
  Route::resource('check-update','CheckController',['parameters'=> ['check-update'=>'id']]); // update contacted from modal form
</pre>
            </div>
            <div class="container alert">
              <table class="table">
                <thead>
                  <tr>
                    <th>Library used</th>
                  </tr>
                  <tr>
                    <th scope="col">Package</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Path</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>yajra/laravel-datatables-oracle</td>
                    <td>Yajra</td>
                    <td>Yajra\DataTables\Facades\DataTables;</td>
                  </tr>
                  <tr>
                    <td>kylekatarnls/laravel-carbon-2</td>
                    <td>Kylekatarnls</td>
                    <td>Carbon\Carbon;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Request;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Response;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Auth;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Input;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Session;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>DB;</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p>
              This page showing number that hasn't pass players qualification after conatcted by certain <i>Customer Service</i>.
            </p>
            <p><strong>Check</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/check_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/check_1.png" class="img-responsive center-block">
            </a>
            <p>
              <strong>Flow :</strong>
              Proses flow can be see in flowchat phase 5 in general or by click <a href="#general">here</a>
            </p>
            <p>
              <strong>Class dependancy :</strong>
              <ul>
                <li>Controller : <code>CheckController;</code> (main class controller)</li>
                <li>Model class : <code>MasterNumbers;</code> (main queries purpose update to master_numbers table)</li>
                <li>Model class : <code>Check;</code> (main model general crud queries purpose)</li>
                <li>Model class : <code>Reassign;</code> (insert data to reassign table)</li>
                <li>Model class : <code>Assigned;</code> (insert data to assigned table)</li>
              </ul>
            </p>
            <p><strong>Entity Relationship Diagram</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_db/check_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_db/check_1.png" class="img-responsive center-block">
            </a>
            <p><strong>Tree Structure Directory</strong></p>
            <pre>
apg/
┣ app/
┃ ┣ Http/
┃ ┃ ┗ Controllers/
┃ ┃   ┗ CheckController.php
┃ ┗ Models/
┃   ┣ Check.php
┃   ┣ CategoryGame.php
┃   ┣ CategoryWeb.php
┃   ┣ MasterNumbers.php
┃   ┣ Assigned.php
┃   ┗ Reassign.php
┣ resources/
┃ ┗ views/
┃   ┣ layouts/
┃   ┃ ┗ app.blade.php
┃   ┣ numbers/
┃   ┣ ┗ leader/
┃   ┃   ┗ check.blade.php
┃   ┣ partials/
┃   ┃ ┣ flashdata.blade.php
┃   ┃ ┣ foot.blade.php
┃   ┃ ┣ footer.blade.php
┃   ┃ ┣ head.blade.php
┃   ┃ ┣ navbar.blade.php
┃   ┃ ┣ search-number-form.blade.php
┃   ┃ ┗ sidebar.blade.php
┃   ┗ scripts/
┃     ┗ numbers/
┃       ┣ check.blade.php
┃       ┗ search-number-form.blade.php
┗ web.config
</pre>
            <div role="alert" class="alert alert-sucess">
              <h3 class="alert-title">Must read about Check!</h3>
              <p>
                Error occurred if the column <code>check_'[variable]'_'[variable]'</code> in master_numbers have less column than <code>assigned times</code> value in <code>settings</code> table in database. To prevant this we need to create script that will prevant this.
                <br><br>
              </p>

<pre style="color:#d1d1d1;background:#000000;"><span style="color:#f6c1d0; background:#281800; ">&lt;?php</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#e66170; background:#281800; font-weight:bold; ">if</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#d2cd86; background:#281800; ">!</span><span style="color:#ffffff; background:#281800; ">Schema</span><span style="color:#b060b0; background:#281800; ">:</span><span style="color:#b060b0; background:#281800; ">:</span><span style="color:#ffffff; background:#281800; ">hasColumn</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#00c4c4; background:#281800; ">'master_numbers'</span><span style="color:#d2cd86; background:#281800; ">,</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#00c4c4; background:#281800; ">'check_'</span><span style="color:#d2cd86; background:#281800; ">.</span><span style="color:#ffffff; background:#281800; ">$existingTimesMaster</span><span style="color:#d2cd86; background:#281800; ">.</span><span style="color:#00c4c4; background:#281800; ">'_1'</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#b060b0; background:#281800; ">{</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#ffffff; background:#281800; ">&nbsp;</span><span style="color:#e66170; background:#281800; font-weight:bold; ">if</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#ffffff; background:#281800; ">$user</span><span style="color:#d2cd86; background:#281800; ">-</span><span style="color:#d2cd86; background:#281800; ">&gt;</span><span style="color:#ffffff; background:#281800; ">isAdmin</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#b060b0; background:#281800; ">{</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#ffffff; background:#281800; ">&nbsp;&nbsp;Session</span><span style="color:#b060b0; background:#281800; ">:</span><span style="color:#b060b0; background:#281800; ">:</span><span style="color:#ffffff; background:#281800; ">put</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#00c4c4; background:#281800; ">'errorNoFade'</span><span style="color:#d2cd86; background:#281800; ">,</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#00c4c4; background:#281800; ">'Error found! Assigned times setting error, change setting &lt;a href="/settings"&gt;here&lt;/a&gt;.'</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#b060b0; background:#281800; ">;</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#ffffff; background:#281800; ">&nbsp;</span><span style="color:#b060b0; background:#281800; ">}</span><span style="color:#e66170; background:#281800; font-weight:bold; ">else</span><span style="color:#b060b0; background:#281800; ">{</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#ffffff; background:#281800; ">&nbsp;&nbsp;Session</span><span style="color:#b060b0; background:#281800; ">:</span><span style="color:#b060b0; background:#281800; ">:</span><span style="color:#ffffff; background:#281800; ">put</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#00c4c4; background:#281800; ">'errorNoFade'</span><span style="color:#d2cd86; background:#281800; ">,</span><span style="color:#ffffff; background:#281800; "> </span><span style="color:#00c4c4; background:#281800; ">'Error found! Assigned times setting error, contact admin for setting asigned times change.'</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#b060b0; background:#281800; ">;</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#ffffff; background:#281800; ">&nbsp;</span><span style="color:#b060b0; background:#281800; ">}</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#ffffff; background:#281800; ">&nbsp;</span><span style="color:#e66170; background:#281800; font-weight:bold; ">return</span><span style="color:#ffffff; background:#281800; "> back</span><span style="color:#d2cd86; background:#281800; ">(</span><span style="color:#d2cd86; background:#281800; ">)</span><span style="color:#b060b0; background:#281800; ">;</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#b060b0; background:#281800; ">}</span><span style="color:#ffffff; background:#281800; "></span>
<span style="color:#f6c1d0; background:#281800; ">?&gt;</span>
</pre>
              <br>
              <p>
                As you can see at above it need class called <code>Schema</code> to read information about table. 
              </p>
            </div>
          </section>
          <section id="reassign">
            <h2>Re-assign</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : true</li>
                  <li>cs : false</li>
                </ul>
              </p>
            </div>
            <div role="alert" class="alert-primary alert">
              <h3 class="alert-title">Route contains</h3>
<pre class="syntaxy" data-type="php">
  Route::get('numbers/leader/reassign', 'ReassignController@index'); // main link
  Route::get('ajaxdata/getdataReassign', 'ReassignController@getdata')->name('ajaxdata.getdataReassign'); // ajax get data to datatable
  Route::post('leader/reassign/assignto', ['as'=>'leader.reassign.assignto','uses'=>'ReassignController@assignto']); // ajax assign to cs
  Route::delete('leader/reassign/multiple-delete', ['as'=>'leader.reassign.multiple-delete','uses'=>'ReassignController@multipleDelete']); // ajax multiple delete
  Route::post('search-reassign', 'ReassignController@search')->name('search-reassign'); // ajax search number
</pre>
            </div>
            <div class="container alert">
              <table class="table">
                <thead>
                  <tr>
                    <th>Library used</th>
                  </tr>
                  <tr>
                    <th scope="col">Package</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Path</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>yajra/laravel-datatables-oracle</td>
                    <td>Yajra</td>
                    <td>Yajra\DataTables\Facades\DataTables;</td>
                  </tr>
                  <tr>
                    <td>kylekatarnls/laravel-carbon-2</td>
                    <td>Kylekatarnls</td>
                    <td>Carbon\Carbon;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Request;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Response;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Auth;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Input;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Session;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>DB;</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p>
              This page contains number that passed from check module. In this page <i>Admin</i> or <i>Leader</i> will decide the number must be delete or re assign to certain <i>Customer Service</i>.
            </p>
            <p><strong>Re-assign</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/reassign_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/reassign_1.png" class="img-responsive center-block">
            </a>
            <p>
              <strong>Flow :</strong>
              Proses flow can be see in flowchat phase 5 in general or by click <a href="#general">here</a>
            </p>
            <p>
              <strong>Class dependancy :</strong>
              <ul>
                <li>Controller : <code>ReassignController;</code> (main class controller)</li>
                <li>Model class : <code>MasterNumbers;</code> (main queries purpose update to master_numbers table)</li>
                <li>Model class : <code>Reassign;</code> (main model general crud queries purpose)</li>
                <li>Model class : <code>Assigned;</code> (insert data to assigned table)</li>
                <li>Model class : <code>Trash;</code> (insert data to trash table)</li>
              </ul>
            </p>
            <p><strong>Entity Relationship Diagram</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_db/reassign_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_db/reassign_1.png" class="img-responsive center-block">
            </a>
            <p><strong>Tree Structure Directory</strong></p>
            <pre>
apg/
┣ app/
┃ ┣ Http/
┃ ┃ ┗ Controllers/
┃ ┃   ┗ ReassignController.php
┃ ┗ Models/
┃   ┣ Reassign.php
┃   ┣ CategoryGame.php
┃   ┣ CategoryWeb.php
┃   ┣ MasterNumbers.php
┃   ┣ Assigned.php
┃   ┗ Trash.php
┣ resources/
┃ ┗ views/
┃   ┣ layouts/
┃   ┃ ┗ app.blade.php
┃   ┣ numbers/
┃   ┣ ┗ leader/
┃   ┃   ┗ reassign.blade.php
┃   ┣ partials/
┃   ┃ ┣ flashdata.blade.php
┃   ┃ ┣ foot.blade.php
┃   ┃ ┣ footer.blade.php
┃   ┃ ┣ head.blade.php
┃   ┃ ┣ navbar.blade.php
┃   ┃ ┣ search-number-form.blade.php
┃   ┃ ┗ sidebar.blade.php
┃   ┗ scripts/
┃     ┗ numbers/
┃       ┣ reassign.blade.php
┃       ┗ search-number-form.blade.php
┗ web.config
</pre>
          </section>

          <section id="players">
            <h2>Lovely Players</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : true</li>
                  <li>cs : false</li>
                </ul>
              </p>
            </div>
            <div role="alert" class="alert-primary alert">
              <h3 class="alert-title">Route contains</h3>
<pre class="syntaxy" data-type="php">
  Route::get('numbers/players', 'PlayersController@index'); // main link
  Route::get('ajaxdata/getdataPlayers', 'PlayersController@getdata')->name('ajaxdata.getdataPlayers'); // ajax get data to datatable
  Route::post('search-players', 'PlayersController@search')->name('search-players'); // ajax search number
</pre>
            </div>
            <div class="container alert">
              <table class="table">
                <thead>
                  <tr>
                    <th>Library used</th>
                  </tr>
                  <tr>
                    <th scope="col">Package</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Path</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>yajra/laravel-datatables-oracle</td>
                    <td>Yajra</td>
                    <td>Yajra\DataTables\Facades\DataTables;</td>
                  </tr>
                  <tr>
                    <td>kylekatarnls/laravel-carbon-2</td>
                    <td>Kylekatarnls</td>
                    <td>Carbon\Carbon;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Request;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Response;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Auth;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Input;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Session;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>DB;</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p>
              This page show the number that has registered and depaosit even only once.
            </p>
            <p><strong>Lovely players</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/players_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/players_1.png" class="img-responsive center-block">
            </a>
            <p>
              <strong>Flow :</strong>
              Proses flow can be see in flowchat phase 6 in general or by click <a href="#general">here</a>
            </p>
            <p>
              <strong>Class dependancy :</strong>
              <ul>
                <li>Controller : <code>PlayersController;</code> (main class controller)</li>
                <li>Model class : <code>MasterNumbers;</code> (main queries purpose update to master_numbers table)</li>
                <li>Model class : <code>Players;</code> (main model general crud queries purpose)</li>
              </ul>
            </p>
            <p><strong>Entity Relationship Diagram</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_db/players_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_db/players_1.png" class="img-responsive center-block">
            </a>
            <p><strong>Tree Structure Directory</strong></p>
            <pre>
apg/
┣ app/
┃ ┣ Http/
┃ ┃ ┗ Controllers/
┃ ┃   ┗ PlayersController.php
┃ ┗ Models/
┃   ┣ Players.php
┃   ┣ CategoryGame.php
┃   ┣ CategoryWeb.php
┃   ┗ MasterNumbers.php
┣ resources/
┃ ┗ views/
┃   ┣ layouts/
┃   ┃ ┗ app.blade.php
┃   ┣ numbers/
┃   ┃ ┗ players.blade.php
┃   ┣ partials/
┃   ┃ ┣ flashdata.blade.php
┃   ┃ ┣ foot.blade.php
┃   ┃ ┣ footer.blade.php
┃   ┃ ┣ head.blade.php
┃   ┃ ┣ navbar.blade.php
┃   ┃ ┣ search-number-form.blade.php
┃   ┃ ┗ sidebar.blade.php
┃   ┗ scripts/
┃     ┗ numbers/
┃       ┣ players.blade.php
┃       ┗ search-number-form.blade.php
┗ web.config
</pre>
          </section>

          <section id="trash">
            <h2>Trash</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : true</li>
                  <li>cs : false</li>
                </ul>
              </p>
            </div>
            <div role="alert" class="alert-primary alert">
              <h3 class="alert-title">Route contains</h3>
<pre class="syntaxy" data-type="php">
  Route::get('numbers/trash', 'TrashController@index'); // main link
  Route::get('ajaxdata/getdataTrash', 'TrashController@getdata')->name('ajaxdata.getdataTrash'); // ajax get data to datatable
  Route::post('search-trash', 'TrashController@search')->name('search-trash'); // ajax search number
</pre>
            </div>
            <div class="container alert">
              <table class="table">
                <thead>
                  <tr>
                    <th>Library used</th>
                  </tr>
                  <tr>
                    <th scope="col">Package</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Path</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>yajra/laravel-datatables-oracle</td>
                    <td>Yajra</td>
                    <td>Yajra\DataTables\Facades\DataTables;</td>
                  </tr>
                  <tr>
                    <td>kylekatarnls/laravel-carbon-2</td>
                    <td>Kylekatarnls</td>
                    <td>Carbon\Carbon;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Request;</td>
                  </tr>
                  <tr>
                    <td>Illuminate</td>
                    <td>Laravel</td>
                    <td>Illuminate\Http\Response;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Auth;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Input;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>Session;</td>
                  </tr>
                  <tr>
                    <td>Internal</td>
                    <td>Laravel</td>
                    <td>DB;</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p>
              This page show number that has been delete from re assign by leader or admin.
            </p>
            <p><strong>Trash</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/trash_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/trash_1.png" class="img-responsive center-block">
            </a>
            <p>
              <strong>Flow :</strong>
              Proses flow can be see in flowchat phase 5 in general or by click <a href="#general">here</a>
            </p>
            <p>
              <strong>Class dependancy :</strong>
              <ul>
                <li>Controller : <code>TrashController;</code> (main class controller)</li>
                <li>Model class : <code>MasterNumbers;</code> (main queries purpose update to master_numbers table)</li>
                <li>Model class : <code>Trash;</code> (main model general crud queries purpose)</li>
              </ul>
            </p>
            <p><strong>Entity Relationship Diagram</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_db/trash_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_db/trash_1.png" class="img-responsive center-block">
            </a>
            <p><strong>Tree Structure Directory</strong></p>
            <pre>
apg/
┣ app/
┃ ┣ Http/
┃ ┃ ┗ Controllers/
┃ ┃   ┗ TrashController.php
┃ ┗ Models/
┃   ┣ Trash.php
┃   ┣ CategoryGame.php
┃   ┣ CategoryWeb.php
┃   ┗ MasterNumbers.php
┣ resources/
┃ ┗ views/
┃   ┣ layouts/
┃   ┃ ┗ app.blade.php
┃   ┣ numbers/
┃   ┃ ┗ trash.blade.php
┃   ┣ partials/
┃   ┃ ┣ flashdata.blade.php
┃   ┃ ┣ foot.blade.php
┃   ┃ ┣ footer.blade.php
┃   ┃ ┣ head.blade.php
┃   ┃ ┣ navbar.blade.php
┃   ┃ ┣ search-number-form.blade.php
┃   ┃ ┗ sidebar.blade.php
┃   ┗ scripts/
┃     ┗ numbers/
┃       ┣ trash.blade.php
┃       ┗ search-number-form.blade.php
┗ web.config
</pre>
            <div role="alert" class="alert alert-sucess">
              <h3 class="alert-title">Must read about Trash!</h3>
              <p>
                There something tricky about this module, you can't get the ajax in common way like other module who use same ajax route. It cause by <code>ReassignController</code> updated the <code>deleted_at</code> column in <code>master_numbers</code> table and since laravel use <code>soft delete</code>, laravel will assume that column is currently soft deleted.
                <br>
              </p>
            </div>
          </section>

          <section id="user-list">
            <h2>User List</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : false</li>
                  <li>cs : false</li>
                </ul>
              </p>
            </div>
            <p>
              This page show the list of user in the database with various role like admin, user, and unverified (yet need to be activate by admin).
            </p>
            <p><strong>User List</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/user_administration.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/user_administration.png" class="img-responsive center-block">
            </a>
            <p>
              <strong>Flow :</strong>
              Proses flow can be see in flowchat phase 5 in general or by click <a href="#general">here</a>
            </p>
          </section>
          <section id="create_user">
            <h3>Create user</h3>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>user : false</li>
                </ul>
              </p>
            </div>
            <p>
              If you want to create a new user, just fill the form and click "Create New User" button.
            </p>
            <p><strong>Create User</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/create_user_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/create_user_1.png" class="img-responsive center-block">
            </a>
          </section>
          <section id="deleted_user">
            <h3>Deleted user</h3>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>user : false</li>
                </ul>
              </p>
            </div>
            <p>
              All deleted user is goes here, you can also restore the user that have deleted.  
            </p>
            <p><strong>Deleted User</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/deleted_user_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/deleted_user_1.png" class="img-responsive center-block">
            </a>
          </section>

          <section id="settings">
            <h2>Settings</h2>
            <div role="alert" class="alert-exercise alert">
              <h3 class="alert-title">Role Access</h3>
              <p>
                <ul>
                  <li>admin : true</li>
                  <li>leader : false</li>
                  <li>cs : false</li>
                </ul>
              </p>
            </div>
            <p>
              This modul contain additional settings for the program like contacted times, constant for boolean select input, category and other stuff that needed by the app.
            </p>
          </section>
          <section id="recycle">
            <h3>Recycle</h3>
            <p>
              This menu contains contacted times for CS and assigned times for leader.
            </p>
            <p><strong>Recycle</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/recycle_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/recycle_1.png" class="img-responsive center-block">
            </a>
          </section>
          <section id="constants">
            <h3>Constants</h3>
            <p>
              This menu contain constant boolean for select input that can reuse in any page if it needed.  
            </p>
            <p><strong>Connect Response</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/constants_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/constants_1.png" class="img-responsive center-block">
            </a>
          </section>
          <section id="connect-response">
            <h3>Connect Response</h3>
            <p>
              This menu contains all connect response for select input that can be used for the page does needed it.  
            </p>
            <p><strong>Connect Response</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/connect_response_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/connect_response_1.png" class="img-responsive center-block">
            </a>
          </section>
          <section id="campaign-result">
            <h3>Campaign Result</h3>
            <p>
              this menu contains campaign result.  
            </p>
            <p><strong>Campaign result</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/campaign_result_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/campaign_result_1.png" class="img-responsive center-block">
            </a>
          </section>
          <section id="next-action">
            <h3>Next Action</h3>
            <p>
              this menu contains next action.  
            </p>
            <p><strong>Next action</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/next_action_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/next_action_1.png" class="img-responsive center-block">
            </a>
          </section>
          <section id="web-category">
            <h3>Web Category</h3>
            <p>
              this menu contains web category.  
            </p>
            <p><strong>Web category</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/category_web_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/category_web_1.png" class="img-responsive center-block">
            </a>
          <section id="game-category">
            <h3>Game Category</h3>
            <p>
              this menu contains game category.  
            </p>
            <p><strong>Game category</strong></p>
            <a data-fancybox="gallery" href="<?=base_url;?>/assets/img/screenshot_app/category_game_1.png">
              <img src="<?=base_url;?>/assets/img/screenshot_app/category_game_1.png" class="img-responsive center-block">
            </a>
          </section>

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
          <div class="col-xs-4 col-sm-4">
            <!-- <span class="menu_title">Title</span> -->
            <ul>
              <li class="list-group-item"><a href="#general" class="reference ripple internal">General</a></li>
              <li class="list-group-item"><a href="#get-started" class="reference ripple internal">Get Started</a></li>
              <li class="list-group-item"><a href="#initial-login" class="reference ripple internal">Initial Login</a></li>
              <li class="list-group-item"><a href="#main-module" class="reference ripple internal">Main Module</a></li>
              <li class="list-group-item"><a href="#user-list" class="reference ripple internal">User List</a></li>
              <li class="list-group-item"><a href="#settings" class="reference ripple internal">Settings</a></li>
              <li class="list-group-item"><a href="#profile" class="reference ripple internal">Profile</a></li>
            </ul>
          </div>
          <div class="col-xs-4 col-sm-4">
            <!-- <span class="menu_title"Title</span> -->
            <ul>
              <li class="list-group-item"><a href="#dashboard" class="reference ripple internal">Dashboard</a></li>
              <li class="list-group-item"><a href="#upload" class="reference ripple internal">Upload Number</a></li>
              <li class="list-group-item"><a href="#new_numbers" class="reference ripple internal">New Numbers</a></li>
              <li class="list-group-item"><a href="#assigned" class="reference ripple internal">Assigned</a></li>
              <li class="list-group-item"><a href="#contacted" class="reference ripple internal">Contacted</a></li>
              <li class="list-group-item"><a href="#followup" class="reference ripple internal">Follow Up</a>
              <li class="list-group-item"><a href="#interested" class="reference ripple internal">Interested</a></li>
            </ul>
          </div>
          <div class="col-xs-4 col-sm-4">
            <!-- <span class="menu_title"Title</span> -->
            <ul>
              <li class="list-group-item"><a href="#registered" class="reference ripple internal">Registered</a></li>
              <li class="list-group-item"><a href="#leader" class="reference ripple internal">Leader</a></li>
              <li class="list-group-item"><a href="#check" class="reference ripple internal">Check</a></li>
              <li class="list-group-item"><a href="#reassign" class="reference ripple internal">Re-assign</a></li>
              <li class="list-group-item"><a href="#players" class="reference ripple internal">Lovely Players</a></li>
              <li class="list-group-item"><a href="#trash" class="reference ripple internal">Trash</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-5 col-md-4 col-md-offset-1 col-lg-5 col-lg-offset-1">
        <p>
          If you face any kind of problem during the use of CS Phone Panel or have any questions that are beyond the scope of CS Phone Panel, contact Dev team directly at below information
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
        <a class="small" href="documentation">&copy; <?=date('Y'); ?> CS Phone Panel Documentation v.1 | Made with <span style="color : red;">&hearts;</span> by APG Dev team
        <!-- <span class="o_logo o_logo_inverse o_logo_15"></span> -->
        </a>
      </div>
    </div>
  </footer>

  <script src="/assets/syntaxy-js-master/dist/js/syntaxy.min.js"></script>
</body>
</html>
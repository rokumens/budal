<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class SettingGeneralController extends Controller
{
  public function index()
  {
    $scripts = DB::table('orchardpools_scripts')->orderBy('priority', 'asc')->paginate(10);
    $settings = DB::table('orchardpools_settings')->first();
    $socials = DB::table('orchardpools_socials')->orderBy('id', 'desc')->paginate(10);
    $footers = DB::table('orchardpools_footer')->orderBy('id', 'asc')->get();
    return view('pages/settings/general/index', compact('scripts', 'settings', 'socials', 'footers'));
  }

  public function update(Request $request)
  {
    $post = $request->all();
    if($post['type'] == 'general'){
      $message = 'data';
      $data = [
        'launching_date' => $post['launching_date']
      ];
      if ($request->hasFile('logo')) {
        $setting = DB::table('orchardpools_settings')->first();
        // $this->validate($request, [
        //   'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        // ]);
        // $image = $request->file('logo');
        // $name = 'logo.'.$image->getClientOriginalExtension();
        // if($setting->logo != NULL || $setting->logo != ''){
        //   if(file_exists(public_path("/upload/$setting->logo"))){
        //     unlink(public_path("/upload/$setting->logo"));
        //   }
        // }
        // $destinationPath = public_path('/upload');
        // $image->move($destinationPath, $name);
        // $data['logo'] = $name;
        $request->validate([
          'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($setting->logo != NULL || $setting->logo != ''){
          if(file_exists(public_path("/upload/$setting->logo"))){
            unlink(public_path("/upload/$setting->logo"));
          }
        }
        $imageName = 'logo-'.time().'.'.$request->logo->extension();  
        $request->logo->move(public_path('upload'), $imageName);
        $data['logo'] = $imageName;
      }
      if ($request->hasFile('background')) {
        $setting = DB::table('orchardpools_settings')->first();
        // $this->validate($request, [
        //   'background' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        // ]);
        // $image = $request->file('background');
        // $name = 'background.'.$image->getClientOriginalExtension();
        // if(!is_null($setting->background)){
        //   unlink(public_path("/upload/$setting->background"));
        // }
        // $destinationPath = public_path('/upload');
        // $image->move($destinationPath, $name);
        // $data['background'] = $name;
        $request->validate([
            'background' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        if($setting->background != NULL || $setting->background != ''){
          if(file_exists(public_path("/upload/$setting->background"))){
            unlink(public_path("/upload/$setting->background"));
          }
        }
        $imageName = 'background-'.time().'.'.$request->background->extension(); 
        $request->background->move(public_path('upload'), $imageName);
        $data['background'] = $imageName;
      }
      DB::table('orchardpools_settings')->where('id', 1)->update($data);
    }elseif($post['type'] == 'script'){
      $message = 'script';
      DB::table('orchardpools_scripts')->where('id', $post['id'])->update([
        'name' => $post['name'],
        'script' => $post['script'],
      ]);
    }elseif($post['type'] == 'social'){
      $message = 'social media';
      // validation
      $validator = Validator::make(
        $request->all(),[
          'title' => 'required',
          'url' => 'required',
          'icon' => 'required',
        ],
      );
      if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
      }
      $data = [
        'title' => $post['title'],
        'url' => $post['url'],
        'icon' => $post['icon'],
      ];
      DB::table('orchardpools_socials')->where('id', $post['id'])->update($data);
    }elseif($post['type'] == 'footer'){
      $message = 'footer';
      DB::table('orchardpools_footer')->where('id', 1)->update([
        'content' => $post['footer1_content'],
      ]);
      DB::table('orchardpools_footer')->where('id', 2)->update([
        'content' => $post['footer2_content'],
      ]);
      DB::table('orchardpools_footer')->where('id', 3)->update([
        'content' => $post['footer3_content'],
      ]);
      DB::table('orchardpools_footer')->where('id', 4)->update([
        'content' => $post['footer4_content'],
      ]);
    }else{
      return back()->with('error', 'Sorry something wrong.');
    }
    return back()->with('success', "Succesfully updated $message");
  }

  public function store(Request $request)
  {
    $post = $request->all();
    if($post['type'] == 'script'){ // insert script
      $message = 'script';
      // validation
      $validator = Validator::make(
        $request->all(),[
          'name' => 'required',
          'script' => 'required',
        ],
      );
      if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
      }
      $maxPriority = DB::table('orchardpools_scripts')->max('priority');
      $data = [
        'name' => $post['name'],
        'script' => $post['script'],
        'active' => 1,
        'priority' => $maxPriority+1,
      ];
      DB::table('orchardpools_scripts')->insert($data);
    }elseif($post['type'] == 'social'){ // insert social media
      $message = 'social media';
      // validation
      $validator = Validator::make(
        $request->all(),[
          'title' => 'required',
          'url' => 'required',
          'icon' => 'required',
        ],
      );
      if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
      }
      $data = [
        'title' => $post['title'],
        'url' => $post['url'],
        'icon' => $post['icon'],
      ];
      DB::table('orchardpools_socials')->insert($data);
    }else{
      return back()->with('error', 'Something wrong.');
    }
    return back()->with('success', "Succesfully insert $message");
  }

  public function edit($id)
  {
    $script = DB::table('orchardpools_scripts')->where('id', $id)->first();
    return view('pages/settings/general/edit', compact('script'));
  }

  public function ajaxEdit(Request $request)
  {
    $post = $request->all();
    $response = DB::table('orchardpools_socials')->where('id', $post['id'])->first();
    return json_encode($response);
  }

  public function destroy($id, $type)
  {
    // if second param is script
    if($type == 'script'){
      $message = 'script';
      DB::table('orchardpools_scripts')->where('id', $id)->delete();
    }elseif($type == 'social'){// if second param is social
      $message = 'social media';
      DB::table('orchardpools_socials')->where('id', $id)->delete();
    }else{
      return back()->with('error', 'Something wrong.');
    }
    return back()->with('success', "Succesfully delete $message.");
  }

  public function terminator($id)
  {
    $script = DB::table('orchardpools_scripts')->where('id', $id)->first();
    if($script->active == 1){
      DB::table('orchardpools_scripts')->where('id', $id)->update(['active'=>0]);
      $message = 'deactivate';
    }else{
      DB::table('orchardpools_scripts')->where('id', $id)->update(['active'=>1]);
      $message = 'activate';
    }
    return back()->with('success', "Succesfully $message script.");
  }

  public function level($id, $level = 'down')
  {
    $currPriority = DB::table('orchardpools_scripts')->where('id', $id)->first();
    if($level == 'up'){
      if($currPriority->priority > 1){
        $previousPriority = DB::table('orchardpools_scripts')->where('priority', $currPriority->priority-1)->first();
        DB::table('orchardpools_scripts')->where('id', $previousPriority->id)->update([
          'priority' => $previousPriority->priority+1,
        ]);
        DB::table('orchardpools_scripts')->where('id', $id)->update([
          'priority' => $currPriority->priority-1,
        ]);
        $message = "Succesfully raise up script";
      }else{
        return back()->with('error', "Script already have highest priority.");
      }
    }elseif($level == 'down'){
      $maxPriority = DB::table('orchardpools_scripts')->max('priority');
      if($currPriority->priority >= $maxPriority){
        return back()->with('error', "Script already have lowest priority.");
      }else{
        $nextPriority = DB::table('orchardpools_scripts')->where('priority', $currPriority->priority+1)->first();
        DB::table('orchardpools_scripts')->where('id', $nextPriority->id)->update([
          'priority' => $nextPriority->priority-1,
        ]);
        DB::table('orchardpools_scripts')->where('id', $id)->update([
          'priority' => $currPriority->priority+1,
        ]);
        $message = "Succesfully raise down script";
      }
    }else{
      return back()->with('error', "Unknown command.");
    }
    return back()->with('success', "Succesfully $message script.");
  }
}

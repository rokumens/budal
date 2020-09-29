<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class SettingPopupController extends Controller
{
  public function index()
  {
    $settings = DB::table('orchardpools_settings')->first();
    return view('pages/settings/popup/index', compact('settings'));
  }
  public function update(Request $request)
  {
    $post = $request->all();
    $data = [
      'popup_title' => $post['popup_title'],
      'popup_content' => $post['popup_content'],
      'popup_status' => $post['popup_status'],
      'popup_timeout' => $post['popup_timeout'],
    ];
    DB::table('orchardpools_settings')->where('id', 1)->update($data);
    return back()->with('success', 'Succesfully updated');
  }
}

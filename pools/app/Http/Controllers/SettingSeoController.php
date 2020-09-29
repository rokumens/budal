<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\Seo;

class SettingSeoController extends Controller
{
  public function index()
  {
    $seos = DB::table('orchardpools_seo')->get();
    return view('pages/settings/seo/index', compact('seos'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $post = $request->all();
    // Validation
    $validator = Validator::make(
      $request->all(),
      [
        'menu_name' => 'required|unique:orchardpools_seo',
      ],
    );
    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput();
    }
    $data[] = [
      'menu_name' => $post['menu_name'],
      'title' => $post['title'],
      'keyword' => $post['keyword'],
      'description' => $post['description'],
      'canonical' => $post['canonical'],
      'url' => $post['url'],
      'property' => $post['property'],
      'content' => $post['content'],
    ];
    DB::table('orchardpools_seo')->insert($data);

    return redirect('apgadm/settings/seo')->with('success', 'Succesfully insert data');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $data = DB::table('orchardpools_seo')->where('id', $id)->first();
    return view('pages/settings/seo/edit', compact('data'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $post = $request->all();
    if($post['type'] == 'seo'){
      $data = [
        'menu_name' => $post['menu_name'],
        'title' => $post['title'],
        'keyword' => $post['keyword'],
        'description' => $post['description'],
        'canonical' => $post['canonical'],
        'url' => $post['url'],
        'property' => $post['property'],
      ];
    }elseif($post['type'] == 'content'){
      $data = [
        'content' => $post['content'],
      ];
    }else{
      return back()->with('error', 'Oops! something wrong.');
    }
    DB::table('orchardpools_seo')->where('id', $post['id'])->update($data);
    return redirect('apgadm/settings/seo')->with('success', 'Succesfully updated data');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $post = $request->all();
    Seo::findOrFail($post['id'])->delete();
    return redirect('apgadm/settings/seo')->with('success', 'Succesfully deleted number');
  }
}

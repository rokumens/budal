<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryGame;
use App\Models\CategoryWeb;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\User;

class UsersController extends Controller
{
  public function __construct()
  {
    // $this->middleware(backpack_middleware());
  }
  
  public function index()
  {
    $catWeb = CategoryWeb::select('id', 'name')->get();
    $catGames = CategoryGame::select('id', 'name')->get();
    $pageName = request()->segment(2);
    return view('user/deleted', compact('pageName', 'catWeb', 'catGames'));
  }

  function getdata(Request $request)
  {
    $input = $request->all();
    $user = backpack_user()->onlyTrashed();
    $data = $user->select('users.id', 'users.nik', 'users.name', 'users.email', 'created_at', 'users.deleted_at', 'users.deleted_by')
                ->orderBy('users.deleted_at', 'desc');
    return Datatables::of($data)
                        ->setTotalRecords($data->count())
                        ->editColumn('created_at', function ($query) {
                            return $query->created_at ? with(new Carbon($query->created_at))->format('d F Y') : '';
                        })
                        ->editColumn('deleted_at', function ($query) {
                            return $query->deleted_at ? with(new Carbon($query->deleted_at))->format('d F Y') : '';
                        })
                        ->editColumn('deleted_by', function ($query) {
                          $return = '-';
                          if($query->deleted_by != NULL){
                            $name = backpack_user()->where('id', $query->deleted_by)->first();
                            $return = $name->name;
                          }
                          return $return;
                        })
                        ->addColumn('button', function ($query) {
                          $button = "<a href='/user/deleted/$query->id/restore' onclick='return confirm(\"Are you sure?\");' id='restore' class='restore btn btn-sm btn-success' data-id='$query->id'>Restore</a>";
                          return $button;
                        })
                        ->rawColumns(['button'])
                        ->make(true);

  }

  public function restore(Request $request, $id)
  {
    backpack_user()->withTrashed()->find($id)->restore();
    return back()->with('success', trans('User restored.'));
  }
}

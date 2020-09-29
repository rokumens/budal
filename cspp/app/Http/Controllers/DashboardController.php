<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Models\MasterNumbers;
use App\Models\NewNumbers;
use App\Models\Assigned;
use App\Models\Contacted;
use App\Models\Interested;
use App\Models\Registered;
use App\Models\Trash;
use App\Models\Players;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
  public function __construct()
  {
    $this->middleware(backpack_middleware());
  }

  public function index(Request $request)
  {
    $user = backpack_user();
    if ($user->can('dashboard-all')) {
      $countNewnumbers = NewNumbers::count();
      $countContacted = Contacted::count();
      $countInterested = Interested::count();
      $countPlayers = Players::count();
      $countTrash = Trash::count();
      return view('pages.admin.home', compact('countNewnumbers', 'countContacted', 'countInterested', 'countPlayers', 'countTrash'));
    }else{
      $countAssigned = Assigned::leftJoin('master_numbers', 'master_numbers.id', 'assigned.master_numbers_id')
                                ->where('master_numbers.assign_to', $user->id)->count();
      $countContacted = Contacted::leftJoin('master_numbers', 'master_numbers.id', 'contacted.master_numbers_id')
                                ->where('master_numbers.contacted_by', $user->id)->count();
      $countInterested = Interested::leftJoin('master_numbers', 'master_numbers.id', 'interested.master_numbers_id')
                                ->where('master_numbers.contacted_by', $user->id)
                                ->where('master_numbers.is_interested', 1)->count();
      $countRegistered = Registered::leftJoin('master_numbers', 'master_numbers.id', 'registered.master_numbers_id')
                                ->where('master_numbers.registered_by', $user->id)
                                ->where('master_numbers.is_registered', 1)->count();
      return view('pages.user.home', compact('countAssigned', 'countContacted', 'countInterested', 'countRegistered'));
    }
  }

  // download example excel file
  public function file_example(){
    $name = 'format_example_A1_v1.xlsx';
    $file = storage_path('/uploads/format_example_A1_v1.xlsx');
    $header = array(
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'Content-Disposition' => 'attachment',
        'Content-lenght' => filesize($file),
        'filename' => $name,
    );
    return Response::download($file, $name, $header);
  }

  public function to_login(){
    return redirect('/login');
  }
  public function to_demo_leader(){
    return redirect('uploads\demo-leader');
  }
  public function to_demo_cs(){
    return redirect('uploads\demo-cs');
  }

}

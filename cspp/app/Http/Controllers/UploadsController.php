<?php
namespace App\Http\Controllers;
use App\Models\MasterNumbers;
use App\Models\NewNumbers;
use App\User;
use App\Models\IndexMasterNumbers;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\CategoryGame;
use App\Models\CategoryWeb;
use App\Imports\NumbersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controller;

class UploadsController extends Controller
{
  public function __construct()
  {
    $this->middleware(backpack_middleware());
  }

  public function index()
  {
    $catWeb = CategoryWeb::select('id', 'name')->get();
    $catGames = CategoryGame::select('id', 'name')->get();
    return view('upload.upload', compact('catWeb', 'catGames'));
  }
  
  public function import(Request $request)
  {
    $input = $request->all();
    if($request->hasFile('imported-file')){
      $start = microtime(true);
      // $file = $request->file('imported-file')->getRealPath();
      $file = $request->file('imported-file');

      // format mime yg kita mau
      // $mimes = array('application/excel','application/vnd.ms-excel','application/vnd.msexcel');
      // if(!in_array($_FILES['imported-file']['type'], $mimes)) { return back()->with('error', trans('Please choose Excel file only to upload.')); }

      // DB::connection()->disableQueryLog();
      DB::disableQueryLog();

      ini_set("memory_limit",'-1');
      ini_set('max_execution_time', 0);
      ini_set('auto_detect_line_endings', true);
      
      try{
        /*
        *   Filter file size yang mau diupload
        *   get current max upload in our php.ini setting
        */
        $currentUploadMaxSize = ini_get('upload_max_filesize'); //10000M
        $maxFileSize = 10485760000; //10000M in bytes
  
        // get size file yg mau diupload
        // $uploadedFileMimeSize = $input['imported-file']->getSize();
        $uploadedFileMimeSize = $file->getSize();
  
        if($uploadedFileMimeSize >= $maxFileSize) { return back()->with('error', trans('Please choose file smaller than '.$currentUploadMaxSize.'b')); }
  
        // get total rows
        // buat total loading progress
        // $totalRows = $rows->count();
        // $isDuplicate=false;
        $categoryWeb = $request->category_web;
        $categoryGame = $request->category_game;
        
        // Data to index
        $dataIndexMaster = [
          'uploaded_by' => backpack_user()->id
        ];
        IndexMasterNumbers::create($dataIndexMaster);
        
        // Get index id
        $index_id = IndexMasterNumbers::max('id');
        $numbersImport = new NumbersImport;
  
        // get excel from upload to array
        $rawArrayExcel = Excel::toArray($numbersImport, $file);
        // chunking array from excel
        $chunksArray = array_chunk($rawArrayExcel[0], 10000);
  
        // pastikan hanya angka, tidak ada karakter string aneh2
        // digit minimal 9 dan maksimal 14 digit
        // boleh pakai 62, boleh +62, boleh 0812xxx, boleh 812xxx, boleh 628xxx
        // yg tidak boleh kalau 6208xxx
        $regex = '/^(^\+628\s?|^628|^8|^08)(\d{2,4}-?){2}\d{3,4}$/';
        //jebak phone number from Excel
        $arrPhoneNumber = [];
        // looping the chunk
        foreach($chunksArray as $key => $chunks){
          // delete header from array
          if($key == 0){
            unset($chunks[0]);
            $chunks = array_values($chunks);
          }
  
          // prevant error
          $firstId = '';
          $lastId = '';
          $data = [];
          $noIndexFirst = 0;
  
          // looping element each chunk
          foreach($chunks as $chunk){
            // di sini kita filter mana2 aja yg nomor sampah..
            // pastikan hanya format nomor yg benar yg kita masukin ke db :)
            if (!preg_match($regex, $chunk[0])) {
              continue;
            }
            // Skip phone number previously added from Excel
            if (array_key_exists(strval($chunk[0]), $arrPhoneNumber)) //using array_key_exists or in_array
            {
              continue;
            }
  
            $phoneNumberFromExcel = $chunk[0];
            $hasilNomor = '';
  
            switch ($phoneNumberFromExcel) {
              case substr($phoneNumberFromExcel, 0, 1) === "0":
                $hasilNomor = str_replace("0", "62", $phoneNumberFromExcel);
                break;
              case substr($phoneNumberFromExcel, 0, 1) === "8":
                $hasilNomor = "62" . $phoneNumberFromExcel;
                break;
              case substr($phoneNumberFromExcel, 0, 2) === "62":
                $hasilNomor = "62" . str_replace("62", "", $phoneNumberFromExcel);
                break;
              case substr($phoneNumberFromExcel, 0, 1) === "+":
                $hasilNomor = str_replace("+", "", $phoneNumberFromExcel);
                break;
              case substr($phoneNumberFromExcel, 0, 3) === "+62":
                $hasilNomor = "62" . str_replace("+", "", $phoneNumberFromExcel);
                break;
              default:break;
            }
  
            $duplicates = DB::table('master_numbers')->where('phone', '=', $hasilNomor)->count();
  
            if ($duplicates == 0) {
              if($noIndexFirst == 0){
                  $firstId = DB::table('master_numbers')->insertGetId([
                    'phone' => $hasilNomor, // ini isinya 'phone', SEHARUSNYA value
                    'email' => $chunk[1], // ini isinya 'email', SEHARUSNYA value
                    'category_web' => $categoryWeb,
                    'category_game' => $categoryGame,
                    'index_id' => $index_id,
                  ]);
              }else{
                  // data insert master numbers
                  $data[] = [
                    'phone' => $hasilNomor, // ini isinya 'phone', SEHARUSNYA value
                    'email' => $chunk[1], // ini isinya 'email', SEHARUSNYA value
                    'category_web' => $categoryWeb,
                    'category_game' => $categoryGame,
                    'index_id' => $index_id,
                  ];
              }
              $noIndexFirst = $noIndexFirst+1;
            }
          }
          if ($duplicates == 0) {
            // insert into master_numbers table
            DB::table('master_numbers')->insert($data);
            // get last id
            $lastId = DB::table('master_numbers')->max('id');
            // get data insert drom master_numbers
            $dataNewNumbers = MasterNumbers::select('id AS master_numbers_id', 'category_web', 'category_game')->where('id', '>=', $firstId)->where('id', '<=', $lastId)->get()->toArray();
            // insert into new_numbers
            DB::table('new_numbers')->insert($dataNewNumbers);
            // clear all array container variable
            unset($data);
            unset($dataNewNumbers);
            unset($chunksArray[$key]);
          }
        }
        $time = microtime(true) - $start;
        // Session::flash('success', "New phone numbers successfully imported. Import time : $time");
        return redirect('numbers/upload')->with('successNoFade', trans("New phone numbers successfully imported. Import time: ".round($time).'s'));
      }catch(\Exception $error){
      //   dd($error);
      //   // Session::flash('error', $error);
        return redirect('numbers/upload')->with('error', "$error <br /> Contact the dev team.");
      }
    }else{
      return back()->with('error', trans('Please choose file to upload.'));
    }
    return back();
  }
}

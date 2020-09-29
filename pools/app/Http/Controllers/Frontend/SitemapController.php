<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use DB;

class SitemapController extends Controller
{
    public function index() {
        // luffy 12 may 2020 02:01 pm
        // note: Sitemap file must have no more than 50,000 URLs and must be no larger than 10MB
        $resultNumbers = DB::table('orchardpools_draw')->orderBy("id", "desc")
        ->take(49995)->paginate(6);
        $date=date('Y-m-d').'T'.date('H:i:s').'+00:00';
        return response()->view('sitemap.index', [
          'resultNumbers' => $resultNumbers,
          'date' => $date,
        ])->header('Content-Type', 'text/xml');
    }
}

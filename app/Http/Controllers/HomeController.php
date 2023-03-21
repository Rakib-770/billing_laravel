<?php

namespace App\Http\Controllers;

use App\Models\clientInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Psy\Command\WhereamiCommand;

class HomeController extends Controller

{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function clientCount()
    {
        $totalClientCount = DB::table('client_infos')->count();
        $totalActiveClientCount = DB::table('client_infos')->where('status', 'y')->count();
        $totalInactiveClientCount = DB::table('client_infos')->where('status', 'n')->count();
        $totalColoasiaClientCount = DB::table('client_infos')->where('invoice_for', '1')->count();
        $totalMcloudClientCount = DB::table('client_infos')->where('invoice_for', '2')->count();
        $totalBograClientCount = DB::table('client_infos')->where('invoice_for', '3')->count();
        $totalServiceCount = DB::table('service_infos')->count();
        $coloasiaMRC = DB::table('client_infos')->where('invoice_for', '1')->sum('mrc_tk');
        $mcloudMRCMRC = DB::table('client_infos')->where('invoice_for', '2')->sum('mrc_tk');
        $bograMRC = DB::table('client_infos')->where('invoice_for', '3')->sum('mrc_tk');
        $sylhetMRC = DB::table('client_infos')->where('invoice_for', '4')->sum('mrc_tk');
        $smsMRC= DB::table('client_infos')->where('invoice_for', '5')->sum('mrc_tk');
        return View::make('home')->with(compact('totalClientCount', 'totalActiveClientCount', 'totalInactiveClientCount', 'totalServiceCount', 'coloasiaMRC', 'mcloudMRCMRC', 'bograMRC', 'sylhetMRC', 'smsMRC', 'totalColoasiaClientCount', 'totalMcloudClientCount', 'totalBograClientCount'));
    }
}

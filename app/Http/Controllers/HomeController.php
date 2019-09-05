<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
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
        $date = date('Y-m-d');
        if(Session::has('pdate1')) {
            $date = Session::get('pdate1');
        }
        else {
            Session::put('pdate1', $date);
        }

        $voyages = DB::select("select t.voyage_id, t.train_no, t.train_name_mn from VOYAGESCHEMA t where to_char(t.plan_date,'YYYY-MM-DD')='$date'");
        $voyage = 0;
        if(Session::has('voyage')) {
            $voyage = Session::get('voyage');
        }
        else {
            Session::put('voyage', $voyage);
        }

        $bindings = [
            'p_voyageid'  => $voyage,
        ];

        $rep = DB::executeProcedureWithCursor('rep_odb_free_mests', $bindings);
        return view('home', compact('rep','date','voyages','voyage'));
    }

    public function filter_free_mest_date($date) {
        Session::put('pdate1',$date);
        return redirect('home');
    }
    public function filter_free_mest_voyage($voyage) {
        Session::put('voyage',$voyage);
        return redirect('home');
    }
    public function rep_vchd()
    {
        $date = date('Y-m-d');
        if(Session::has('pdate1')) {
            $date = Session::get('pdate1');
        }
        else {
            Session::put('pdate1', $date);
        }

        $voyages = DB::select("select t.voyage_id, t.train_no, t.train_name_mn from VOYAGESCHEMA t where to_char(t.plan_date,'YYYY-MM-DD')='$date'");
        $voyage = 0;
        if(Session::has('voyage')) {
            $voyage = Session::get('voyage');
        }
        else {
            Session::put('voyage', $voyage);
        }

        $bindings = [
            'preporttype' => 1,
            'p_voyageid'  => $voyage,
        ];

        $rep = DB::executeProcedureWithCursor('rep_vchd', $bindings);
        return view('rep_vchd', compact('rep','date','voyages','voyage'));
    }

    public function filter_rep_vchd_date($date) {
        Session::put('pdate1',$date);
        return redirect('rep_vchd');
    }
    public function filter_rep_vchd_voyage($voyage) {
        Session::put('voyage',$voyage);
        return redirect('rep_vchd');
    }
}

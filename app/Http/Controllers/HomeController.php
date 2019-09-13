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
        $date1 = date('Y-m-d');
        if(Session::has('pdate1')) {
            $date = Session::get('pdate1');
        }
        else {
            Session::put('pdate1', $date);
        }
        if(Session::has('pdate2')) {
            $date1 = Session::get('pdate2');
        }
        else {
            Session::put('pdate2', $date1);
        }
        $voyages1 = DB::select("select t.voyage_id, t.train_no, t.train_name_mn from VOYAGESCHEMA t where to_char(t.plan_date,'YYYY-MM-DD')='$date1'");
        $voyage1 = 0;

        $voyages = DB::select("select t.voyage_id, t.train_no, t.train_name_mn from VOYAGESCHEMA t where to_char(t.plan_date,'YYYY-MM-DD')='$date'");
        $voyage = 0;
        $fr = 0;
        $to = 0;
        if(Session::has('voyage')) {
            $voyage = Session::get('voyage');
        }
        else {
            Session::put('voyage', $voyage);
        }
        if(Session::has('voyage1')) {
            $voyage1 = Session::get('voyage1');
        }
        else {
            Session::put('voyage1', $voyage1);
        }
        $frs = DB::select("select t.STOP_NAME, t.STATION_CODE , stop_posno from V_YOYAGE_STOPS t where t.VOYAGE_ID='$voyage1' order by stop_posno desc");

        $tos = DB::select("select t.STOP_NAME, t.STATION_CODE , stop_posno from V_YOYAGE_STOPS t where t.VOYAGE_ID='$voyage1' order by stop_posno asc");

        if(Session::has('fr')) {
            $fr = Session::get('fr');
        }
        else {
            Session::put('fr', $fr);
        }
        if(Session::has('to')) {
            $to = Session::get('to');
        }
        else {
            Session::put('to', $to);
        }
        $bindings = [
            'p_voyageid'  => $voyage,
        ];
        $bindings1 = [
            'p_voyageid'  => $voyage1,
            'pfromstcode'  => $fr,
            'ptostcode'  => $to,
        ];

        $rep = DB::executeProcedureWithCursor('rep_odb_free_mests', $bindings);
        $tar = DB::executeProcedureWithCursor('proc_get_voyage_fare', $bindings1);

        return view('home', compact('rep','date1','date','voyages','voyage','voyages1','voyage1','tar','to','fr','tos','frs'));
    }

    public function filter_free_mest_date($date) {
        Session::put('pdate1',$date);
        return redirect('home');
    }
    public function filter_free_mest_voyage($voyage) {
        Session::put('voyage',$voyage);
        return redirect('home');
    }
    public function filter_tr_date($date2) {
        Session::put('pdate2',$date2);
        return redirect('home');
    }
    public function filter_tr_voyage($voyage1) {
        Session::put('voyage1',$voyage1);
        return redirect('home');
    }
    public function filter_tr_frstcode($fr) {
    Session::put('fr',$fr);
    return redirect('home');
}
    public function filter_tr_tostcode($to) {
        Session::put('to',$to);
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
        $voyage = 0;
        $wagon = 0;
        if(Session::has('voyage')) {
            $voyage = Session::get('voyage');
        }
        else {
            Session::put('voyage', $voyage);
        }
        $voyages = DB::select("select t.voyage_id, t.train_no, t.train_name_mn from VOYAGESCHEMA t where to_char(t.plan_date,'YYYY-MM-DD')='$date'");
        $wagons = DB::select("select t.vwagon_id, t.wagon_name from VOYAGEWAGON t where t.voyage_id='$voyage' order by wagon_name");


        if(Session::has('wagon')) {

            if(Session::get('wagon') == 0) {
                $bindings = [
                    'preporttype' => 1,
                    'p_voyageid'  => $voyage,
                ];
                $t = 1;
                Session::put('wagon', $wagon);
            }
            elseif(Session::get('wagon') != 0) {
                $wagon = Session::get('wagon');
                $bindings = [
                    'preporttype' => 2,
                    'p_voyageid'  => $wagon,
                ];
                $t = 2;
                Session::put('wagon', $wagon);
            }
            }
            else{
                $bindings = [
                    'preporttype' => 1,
                    'p_voyageid'  => $voyage,
                ];
                $t = 1;
                Session::put('wagon', $wagon);
    }

        $rep = DB::executeProcedureWithCursor('rep_vchd', $bindings);
        return view('rep_vchd', compact('rep','date','voyages','voyage','wagons','wagon','t'));
    }

    public function filter_rep_vchd_date($date) {
        Session::put('pdate1',$date);
        return redirect('rep_vchd');
    }
    public function filter_rep_vchd_voyage($voyage) {
        Session::put('voyage',$voyage);
        return redirect('rep_vchd');
    }
    public function filter_rep_vchd_wagon($wagon) {
        Session::put('wagon',$wagon);
        return redirect('rep_vchd');
    }
}

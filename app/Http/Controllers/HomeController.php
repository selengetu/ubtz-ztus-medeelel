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

        $bind = [
            'ppos'  => 54,
        ];
        $date = date('Y-m-d');
        $date1 =date('Y-m-d');
        $voyage1 = 0;

        $voyage = 0;
        $fr = 37;
        $to = 3;
        $fvstop_id = 0;
        $tvstop_id = 0;

        if(Session::has('pdate1')) {
            $date = Session::get('pdate1');
        }
        else {
            Session::put('pdate1', $date);
        }
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
        if(Session::has('fvstop_id')) {
            $fvstop_id = Session::get('fvstop_id');
        }
        else {
            Session::put('fvstop_id', $fvstop_id);
        }
        if(Session::has('tvstop_id')) {
            $tvstop_id = Session::get('tvstop_id');
        }
        else {
            Session::put('tvstop_id', $tvstop_id);
        }

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
        $bind1 = [
            'ppos'  => 54,
            'pfromst'  => $fr,
        ];

        $bind2 = [
            'p_fromstid'  => $fr,
            'p_tostid'  => $to,
            'p_saleid' => 0,
        ];

        $voyages = DB::select("select t.voyage_id, t.train_no, t.train_name_mn from VOYAGESCHEMA t where to_char(t.plan_date,'YYYY-MM-DD')='$date'");
        if(sizeof($voyages)== 1) {
            $first = $voyages[0]->voyage_id;
            $voyage = $first;
        }
        else{

        }
        $frs = DB::executeProcedureWithCursor('get_from_stations', $bind);
        $tos = DB::executeProcedureWithCursor('get_to_stations', $bind1);
        $dates = DB::executeProcedureWithCursor('proc_find_voyagedates', $bind2);

        if(sizeof($dates)> 0) {
            $first = $dates[0]->orderby;
            $found = false;
            if (Session::has('pdate2')) {
                $date1 = Session::get('pdate2');
            }
            foreach ($dates as $dt) {
                if ($dt->orderby == $date1) {
                    $found = true;
                }
            }
            if (!$found) {
                $date1 = $first;
                Session::put('pdate2', $date1);
            }
        }



        $bind3 = [
            'p_pos'  => 54,
            'p_fromstid'  => $fr,
            'p_tostid'  => $to,
            'p_plandate' => $date1,
        ];

        $voyages1 = DB::executeProcedureWithCursor('proc_find_voyage', $bind3);

        if(sizeof($voyages1)>0) {
            $first = $voyages1[0]->voyage_id;
            $fvfirst = $voyages1[0]->fvstop_id;
            $tvfirst = $voyages1[0]->tvstop_id;
            $tvstop_id = $tvfirst;
            $fvstop_id = $fvfirst;
            $voyage1 = $first;
        }
        else{

        }

        $bindings1 = [
            'p_pos'  => 54,
            'p_voyage_id'  => $voyage1,
            'p_fstop_id'  => $fvstop_id,
            'p_tstop_id'  => $tvstop_id,

        ];
        /* $bindings1 = [
            'p_pos'  => 54,
            'p_voyage_id'  => 6511,
            'p_fstop_id'  => 98002,
            'p_tstop_id'  => 98022,

        ]; */
        $bindings = [
            'p_voyageid'  => $voyage,
        ];

        $rep = DB::executeProcedureWithCursor('rep_odb_free_mests', $bindings);
        $tar = DB::executeProcedureWithCursor('proc_get_voyage_wagon_info', $bindings1);

        return view('home', compact('rep','date1','date','voyages','voyage','voyages1','voyage1','tar','to','fr','tos','frs','dates'));
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
    public function filter_tr_voyage($voyage1,$fvstop_id,$tvstop_id) {
        Session::put('voyage1',$voyage1);
        Session::put('fvstop_id',$fvstop_id);
        Session::put('tvstop_id',$tvstop_id);
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

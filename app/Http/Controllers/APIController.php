<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\PackageManifest;
use Illuminate\Http\Request;
use App\Ban;
use Carbon\Carbon;

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return app()->server->enforcedBans();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ban = new Ban();

        $ban->serial = $request->has("serial") ? $request->get("serial") : null;
        $ban->ip = $request->has("ip") ? $request->get("ip") : null;
        $ban->banner_id = app()->server->id;
        $ban->ban_reason_id = $request->has("reason") ? $request->get("reason") : 6;
        $ban->details = $request->has("details") ? $request->get("details") : "N/A";
        $ban->banned_until = $request->has("banned_until") ? $request->get("banned_until") : Carbon::now()->addYears(100);
        $ban->server_id = app()->server->id;
        $ban->appeal_code = strtoupper(str_random(8));

        $ban->save();
        return response("success",200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request)
    {
        $banSelector = Ban::select();
        $banSelector->where("banned_until",">",Carbon::now());
        $hasIP = false;
        if ( $request->has('ip') && $request->get("ip") != "" ){
            $hasIP = true;
            $banSelector->where('ip',$request->get('ip'));
        }
        if ( $request->has('serial') ){
            if ($hasIP){
                $banSelector->orWhere("serial",$request->get("serial"))->where("banned_until",">",Carbon::now());
            } else {
                $banSelector->where('serial',$request->get('serial'));
            }
        }
        $bans = $banSelector->get();


        $enforcingBans = [];
        $server = app()->server;
        $serverSettings = $server->settings;
        foreach($bans as $ban){
            foreach($serverSettings as $setting){
                if ($setting->subject == $ban->server && isset($setting->reasons[$ban->reason->reason])){
                    $enforcingBans[count($enforcingBans)] = $ban;
                    break;
                }
            }
        }
        return response($enforcingBans);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $banSelector = Ban::select();
        if ($request->has("serial")){

        }
        if ($request->has("ip")){

        }
        $bans = $banSelector->get();
        foreach($bans as $ban){
            if ($ban->server == app()->server){
                $ban->banned_until = Carbon::now();
                $ban->save();
                return response("success",200);
            }
        }
        abort(403, 'Access denied');
    }
}

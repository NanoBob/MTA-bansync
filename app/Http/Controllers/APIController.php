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
        $ban->reason_id = $request->has("reason") ? $request->get("reason") : 1;
        $ban->details = $request->has("details") ? $request->get("details") : "N/A";
        $ban->banned_until = $request->has("banned_until") ? $request->get("banned_until") : Carbon::now()->addYears(100);

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
        if ( $request->has('ip') ){
            $banSelector->orWhere('ip',$request->get('ip'));
        }
        if ( $request->has('serial') ){
            $banSelector->orWhere('serial',$request->get('serial'));
        }
        $bans = $banSelector->get();

        $enforcingBans = [];
        $server = app()->server;
        $serverSettings = $server->settings;
        foreach($bans as $ban){
            foreach($serverSettings as $setting){
                if ($setting->server == $ban->server && $setting->reasons[$ban->reason->reason]){
                    $enforcingBans[count($enforcingBans)] = $ban;
                    break;
                }
            }
        }
        return response(json_encode($enforcingBans));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $ban = Ban::find($id);
        if ($ban->server !== app()->server){
            abort(403, 'Access denied');
        }
        $ban->banned_until = Carbon::now();
        $ban->save();
    }
}

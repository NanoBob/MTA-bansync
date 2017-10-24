<?php

namespace App\Http\Controllers;

use App\ServerSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\BanReason;

class ServerSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Auth::user()->server->settings;
        $servers = User::where("type","server")->get();
        $remainingServers = [];
        foreach($servers as $server){
            $found = false;
            foreach($settings as $setting){
                if ($setting->subject == $server){
                    $found = true;
                }
            }
            if (! $found){
                $remainingServers[count($remainingServers)] = $server;
            }
        }
        return view('management.settings.index', ["server" => Auth::user(), "settings" => $settings, "servers" => $remainingServers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $settingServer = User::find($request->get("server-id"));
        if ($settingServer->server != $settingServer){
            return redirect(route("settings.index"));
        }
        return view('management.settings.create', [ "settingServer" => $settingServer ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $server = $user->server;

        $setting = new ServerSetting();
        $setting->subject_id = $request->get("server-id");
        $setting->server_id = $server->id;
        $setting->save();

        foreach( BanReason::all() as $banReason ){
            if ($request->has("reason" . $banReason->id)){
                $setting->enable($banReason);
            }
        }
        if ($request->has("applyToVerified")){
            foreach(User::where("verified",1)->get() as $verifiedServer){
                $setting = ServerSetting::where("server_id",Auth::user()->server->id)->where("subject_id",$verifiedServer->id)->first();
                if (! $setting){
                    $setting = new ServerSetting();
                    $setting->subject_id = $verifiedServer->id;
                    $setting->server_id = Auth::user()->server->id;
                    $setting->save();
                }
                foreach( BanReason::all() as $banReason ){
                    if ($request->has("reason" . $banReason->id)){
                        $setting->enable($banReason);
                    } else {
                        $setting->disable($banReason);
                    }
                }
            }
        }

        return redirect(route("manage.settings.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = ServerSetting::find($id);
        if ($setting->server != Auth::user()->server){
            return redirect(route("manage.settings.index"));
        }
        return view("management.settings.edit", [ "setting" => $setting]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $setting = ServerSetting::find($id);
        if ($setting->server != Auth::user()->server){
            return redirect(route("manage.settings.index"));
        }

        foreach( BanReason::all() as $banReason ){
            if ($request->has("reason" . $banReason->id)){
                $setting->enable($banReason);
            } else {
                $setting->disable($banReason);
            }
        }
        if ($request->has("applyToVerified")){
            foreach(User::where("verified",1)->get() as $verifiedServer){
                $setting = ServerSetting::where("server_id",Auth::user()->server->id)->where("subject_id",$verifiedServer->id)->first();
                if (! $setting){
                    $setting = new ServerSetting();
                    $setting->subject_id = $verifiedServer->id;
                    $setting->server_id = Auth::user()->server->id;
                    $setting->save();
                }
                foreach( BanReason::all() as $banReason ){
                    if ($request->has("reason" . $banReason->id)){
                        $setting->enable($banReason);
                    } else {
                        $setting->disable($banReason);
                    }
                }
            }
        }
        return redirect(route("manage.settings.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $setting = ServerSetting::find($id);
        if ($setting->server != Auth::user()->server){
            return redirect(route("manage.settings.index"));
        }
        $setting->delete();
        return redirect(route("manage.settings.index"));
    }
}

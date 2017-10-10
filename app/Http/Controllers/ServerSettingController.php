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
        foreach($settings as $setting){
            foreach($servers as $key => $server){
                if ($server == $setting->server){
                    $servers = $servers->except($key);
                    break;
                }
            }
        }
        return view('management.settings.index', ["server" => Auth::user(), "settings" => $settings, "servers" => $servers]);
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

        return redirect(route("settings.index"));
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
        $settingServer = $setting->server;
        return view("management.settings.edit", [ "settingServer" => $settingServer, "setting" => $setting]);
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

        foreach( BanReason::all() as $banReason ){
            if ($request->has("reason" . $banReason->id)){
                $setting->enable($banReason);
            } else {
                $setting->disable($banReason);
            }
        }
        return redirect(route("settings.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect(route("settings.index"));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\PackageManifest;
use Illuminate\Http\Request;
use App\Ban;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $server = $user->server;
        $bans = $server->bans()->paginate(15);

        return view("management.bans.index", [ "bans" => $bans ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view("management.bans.create", [  ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           "name" => "string",
            "ip" => "string|nullable",
            "serial" => "string|nullable",
            "unbanDateTime" => "date",
            "detail" => "string",
            "ban_reason_id" => "exists:ban_reasons,id"
        ]);
        $ban = new Ban();

        $ban->name = $request->get("name");
        if ($request->has("ip")){
            $ban->ip = $request->get("ip");
        }
        if ($request->has("ip")){
            $ban->serial = $request->get("serial");
        }
        $ban->details = $request->get("detail");
        $ban->appeal_code = strtoupper(str_random(8));
        $ban->banner_id = Auth::user()->id;
        $ban->server_id = Auth::user()->server->id;
        $ban->ban_reason_id = $request->get("ban_reason_id");
        $ban->banned_until = $request->get("unbanDateTime");

        $ban->save();
        return redirect(route("manage.bans.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id = -1)
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
        $ban = Ban::find($id);
        return view("management.bans.edit",[ "ban" => $ban]);
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
        $request->validate([
            "name" => "string",
            "ip" => "string|nullable",
            "serial" => "string|nullable",
            "unbanDateTime" => "date",
            "detail" => "string",
            "ban_reason_id" => "exists:ban_reasons,id"
        ]);
        $ban = Ban::find($id);

        $ban->name = $request->get("name");
        if ($request->has("ip")){
            $ban->ip = $request->get("ip");
        }
        if ($request->has("ip")){
            $ban->serial = $request->get("serial");
        }
        $ban->details = $request->get("detail");
        $ban->appeal_code = strtoupper(str_random(8));
        $ban->banner_id = Auth::user()->id;
        $ban->server_id = Auth::user()->server->id;
        $ban->ban_reason_id = $request->get("ban_reason_id");
        $ban->banned_until = $request->get("unbanDateTime");

        $ban->save();
        return redirect(route("manage.bans.index"));
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
        $ban->delete();
        return redirect(route("manage.bans.index"));
    }
}

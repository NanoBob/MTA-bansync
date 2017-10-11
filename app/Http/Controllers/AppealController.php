<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Ban;
use App\BanAppeal;

class AppealController extends Controller
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
        $appeals = $server->appeals()->paginate(15);

        return view("management.appeals.index", [ "appeals" => $appeals ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view("appeals.create");
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
            "content" => "string",
            "ban_id" => "exists:bans,id",
            "appeal_code" => "string"
        ]);
        $ban = Ban::find($request->get("ban_id"));
        $appeal_code = $request->get("appeal_code");
        if ( $appeal_code != $ban->appeal_code ){
            return abort(304,'Access denied');
        }

        $appeal = new BanAppeal;

        $appeal->ban_id = $ban->id;
        $appeal->server_id = $ban->server->id;
        $appeal->banned_id = Auth::user()->id;
        $appeal->content = $request->get("content");

        $appeal->save();
        return redirect(route("appeals.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id = -1)
    {
        $banAppeal = BanAppeal::find($id);
        return view("management.appeals.view",[ "appeal" => $banAppeal]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banAppeal = BanAppeal::find($id);
        return view("appeals.edit",[ "appeal" => $banAppeal]);
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
            "new_state" => "exists:appeal_states,id",
        ]);
        $appeal = BanAppeal::find($id);

        $appeal->state_id = $request->get("new_state");

        $appeal->save();

        if ($appeal->state->state == "Accepted"){
            $appeal->ban->banned_until = Carbon::now();
            $appeal->ban->save();
        }
        return redirect(route("manage.appeals.index"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateClient(Request $request, $id)
    {
        $request->validate([
            "content" => "string",
        ]);
        $appeal = BanAppeal::find($id);

        $appeal->content = $request->get("content");

        $appeal->save();
        return redirect(route("manage.appeals.index"));
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
        return redirect(route("manage.appeals.index"));
    }
}

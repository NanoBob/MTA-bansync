<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ban;
use App\BanAppeal;
use Illuminate\Support\Facades\Auth;

class PublicAppealController extends Controller
{
    public function banList(Request $request){
        $bans = Ban::where("appeal_code",$request->get("appealCode"))->get();
        return view("appeals.list", [ "bans" => $bans, "appeal_code" => $request->get("appealCode")]);
    }

    public function create($appeal_code,$ban_id){
        $ban = Ban::find($ban_id);

        return view("appeals.create", [ "ban" => $ban, "appeal_code" => $appeal_code]);
    }

    public function store(Request $request, $ban_id){
        $request->validate([
            "content" => "string",
            "appeal_code" => "string"
        ]);
        $ban = Ban::find($ban_id);
        $appeal_code = $request->get("appeal_code");
        if ( $appeal_code != $ban->appeal_code ){
            return abort(304,'Access denied');
        }

        $appeal = new BanAppeal;

        $appeal->ban_id = $ban->id;
        $appeal->server_id = $ban->server->id;
        $appeal->banned_id = Auth::user()->id;
        $appeal->content = $request->get("content");
        $appeal->state_id = 1;

        $appeal->save();
        return redirect(route("appeal.view", [ "id" => $appeal->id ]));
    }

    public function update(Request $request, $id){
        $request->validate([
            "content" => "string",
        ]);
        $appeal = BanAppeal::find($id);

        $appeal->content = $request->get("content");

        $appeal->save();
        return redirect(route("appeal.view", [ "id" => $appeal->id ]));
    }

    public function view($id){
        $appeal = BanAppeal::find($id);
        if ($appeal->banned != Auth::user()){
            if ($appeal->banner == Auth::user()){
                return redirect(route("management.appeals.edit", [ "id" => $appeal->id ]));
            }
            return abort(304,"Access denied");
        }
        return view("appeals.edit", [ "appeal" => $appeal ]);
    }

    public function reply(Request $request, $id){
        $appeal = BanAppeal::find($id);
        $appeal->reply(Auth::user(),$request->get("content"));
        return redirect(route("appeal.view", [ "id" => $appeal->id ]));
    }
}

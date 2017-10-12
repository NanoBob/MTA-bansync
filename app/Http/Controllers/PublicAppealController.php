<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ban;
use App\BanAppeal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PublicAppealController extends Controller
{
    public function banList(Request $request){
        $bans = Ban::where("banned_until",">",Carbon::now())->where("appeal_code",$request->get("appealCode"))->get();
        return view("appeals.list", [ "bans" => $bans, "appeal_code" => $request->get("appealCode")]);
    }

    public function appealList(Request $request){
        $appeals = BanAppeal::where("banned_id",Auth::user()->id)->get();
        return view("appeals.listAppeals", [ "appeals" => $appeals]);
    }

    public function create($appeal_code,$ban_id){
        $ban = Ban::find($ban_id);
        if ($ban->openAppeals()->first()){
            return redirect()->back()->withErrors([ "You can not create a ban appeal for this ban, because there is already an open ban appeal for it."]);
        }
        foreach( $ban->appeals as $appeal ){
            if ($appeal->state->state == "Permanently denied"){
                return redirect()->back()->withErrors([ "Your previous appeal has been permanently denied. You are no longer able to appeal this ban."]);
            }
        }


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
            if ($appeal->server == Auth::user()->server){
                return redirect(route("manage.appeals.edit", [ "id" => $appeal->id ]));
            }
            return redirect()->back()->withErrors( "This appeal was created by another account. You can not appeal it untill the previous one is closed" );
        }
        return view("appeals.edit", [ "appeal" => $appeal ]);
    }

    public function reply(Request $request, $id){
        $appeal = BanAppeal::find($id);
        if ($appeal->state->state != "Open"){
            return redirect(route("appeal.view", [ "id" => $appeal->id]))->withErrors( "This appeal is closed, you can not reply to it" );
        }
        $appeal->reply(Auth::user(),$request->get("content"));
        return redirect(route("appeal.view", [ "id" => $appeal->id ]));
    }
}

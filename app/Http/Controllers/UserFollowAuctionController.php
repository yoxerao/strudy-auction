<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\UserFollowAuction;

class UserFollowAuctionController extends Controller
{
    public function follow(int $idAuction)
    {
        $alreadyFollow = UserFollowAuction::where('id_user', Auth::id())
                                            ->where('id_auction', $idAuction)
                                            ->first();
        
        if($alreadyFollow == null) {
         
          $idUser = Auth::id();
          $data=array('id_user'=>$idUser, 'id_auction'=>$idAuction);
          DB::table('user_follow_auction')->insert($data);
        }

        return redirect("/auctions");
    }

    public function list(int $idAuction)
    {
      $followers = UserFollowAuction::all()->where('id_auction', $idAuction);
      return view('pages.followers', ['followers' => $followers]);
    }
}
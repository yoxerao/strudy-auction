<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Auction;
use App\Models\Bid;

use DateTime;

class BidController extends Controller
{

    /**
     * Creates a new bid.
     *
     * @return Bid The bid created.
     */
    public function makeBid(Request $request, $id)
    {
      $bid = new Bid();
      $dt = new DateTime();

      $bid->value = $request->input('value');
      $bid->date = $dt->format('Y-m-d H:i:s');
      $bid->winner = false;
      $bid->bidder = Auth::user()->id;
      $bid->id_auction = $id;
      $bid->save();

      return redirect("/auctions");
    }

    public function makeBidForm($id)
    {
      $auction =  Auction::find($id);

      return view('pages.bid', ['auction' => $auction]);
    }
}
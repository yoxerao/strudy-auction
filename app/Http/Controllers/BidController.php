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
      $auction = Auction::find($id);
      
      if($auction->user_id == Auth::user()->id) {
        return redirect()->back()->with('error', 'You can not bid on your own auction');
      }
      
      $highestBid = Bid::where('id_auction', $id)
                        ->orderBy('value', 'desc')
                        ->first();

      if($request->input('value') >= $auction->min_bid && $request->input('value') <= $auction->buyout_value && $request->input('value') > $highestBid->value) {
        $bid = new Bid();
        $dt = new DateTime();

        $bid->value = $request->input('value');
        $bid->date = $dt->format('Y-m-d H:i:s');
        if($request->input('value') == $auction->buyout_value){
          $bid->winner = true;
          $auction->winner = Auth::user()->id;
          $auction->save();
        }
        else {
          $bid->winner = false;
        }
        $bid->user_id = Auth::user()->id;
        $bid->id_auction = $id;
        $bid->save();
      }
      else {
        return redirect()->back()->with('error', 'You can not bid lower than minimum bid or higher than the buyout');
      }
      return redirect("/auctions");
    }

    public function makeBidForm($id)
    {
      $auction =  Auction::find($id);

      return view('pages.bid', ['auction' => $auction]);
    }

    public function deleteHighestBid($auctionId)
    {
        $highestBid = Bid::where('user_id', Auth::id())
                        ->where('id_auction', $auctionId)
                        ->orderBy('value', 'desc')
                        ->first();

        $highestBid->delete();

        return redirect('/auctions');
    }
}
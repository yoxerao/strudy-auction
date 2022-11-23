<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Auction;

class AuctionController extends Controller
{
    /**php 
     * Shows the card for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
      $auction = Auction::find($id);
      $this->authorize('show', $auction);
      return view('pages.auction', ['auction' => $auction]);
    }
    /**
     * Shows all cards.
     *
     * @return Response
     */
    public function list()
    {
      //if (!Auth::check()) return redirect('/login');
    
      $auctions = Auction::all();
      return view('pages.auctions', ['auctions' => $auctions]); //criar auctions.blade.php em pages!!!
    }

    /**
     * Creates a new card.
     *
     * @return Card The card created.
     */
    public function create(Request $request)
    {
      $auction = new Auction();

      $this->authorize('create', $auction);

      $auction->name = $request->input('name');
      $auction->buyout_value = $request->input('buyout_value');
      $auction->min_bid = $request->input('min_bid');
      $auction->description = $request->input('description');
      $auction->start_date = $request->input('start_date');
      $auction->end_date = $request->input('end_date');
      $auction->winner = null;
      $auction->owner = Auth::user()->id;
      $auction->save();

      return $auction;
    }

    public function createForm()
    {

      return view('pages.auction');
    }

    public function delete(Request $request, $id)
    {
      $auction =  Auction::find($id);

      $this->authorize('delete', $auction);
      $auction->delete();

      return $auction;
    }
}

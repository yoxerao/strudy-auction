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
      if (!Auth::check()) return redirect('/login');
      $this->authorize('list', Auction::class);
      $auctions = Auth::user()->auctions()->orderBy('id')->get();
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

      $auction->title = $request->input('title');
      $auction->user_id = Auth::user()->id;
      $auction->save();

      return $auction;
    }

    public function delete(Request $request, $id)
    {
      $auction =  Auction::find($id);

      $this->authorize('delete', $auction);
      $auction->delete();

      return $auction;
    }
}

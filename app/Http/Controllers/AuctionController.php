<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\UserFollowAuction;
use App\Models\Comment;

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
    //$this->authorize('list', Auction::class);
    $auctions = Auction::all();
    return view('pages.auctions', ['auctions' => $auctions]); //criar auctions.blade.php em pages!!!
  }

  /**
   * Creates a new auction.
   *
   * @return Auction The auction created.
   */
  public function create(Request $request)
  {
    $auction = new Auction();

    $auction->name = $request->input('name');
    $auction->buyout_value = $request->input('buyout_value');
    $auction->min_bid = $request->input('min_bid');
    $auction->description = $request->input('description');
    $auction->start_date = $request->input('start_date');
    $auction->end_date = $request->input('end_date');
    $auction->winner = null;
    $auction->user_id = Auth::user()->id;
    $auction->save();

    $alreadyFollow = UserFollowAuction::where('id_user', Auth::id())
      ->where('id_auction', $auction->id)
      ->first();

    if ($alreadyFollow == null) {
      $idUser = Auth::id();
      $data = array('id_user' => $idUser, 'id_auction' => $auction->id);
      DB::table('user_follow_auction')->insert($data);
    }

    return redirect("/auctions");
  }

  public function createForm()
  {
    return view('pages.auctionCreate');
  }

  public function edit(Request $request, $id)
  {
    $auction =  Auction::find($id);

    $auction->name = $request->input('name');
    $auction->description = $request->input('description');
    $auction->save();

    return redirect("/auctions");
  }

  public function editForm($id)
  {
    $auction =  Auction::find($id);
    return view('pages.auctionEdit', ['auction' => $auction]);
  }

  public function delete(Request $request, $id)
  {

    $bid =  Bid::where('id_auction', '=', $id)->first();
    if ($bid) {
      return redirect("/auctions")->with('error', 'Auction cannot be deleted');
    }

    $auction =  Auction::find($id);
    $auction->delete();

    return redirect("/auctions")->with('success', 'Auction is successfully deleted');
  }


  public function show_my(int $id)
  {
    $auction = Auction::find($id);
    $auctionInfo = [
      'id' => $auction->id,
      'name' => $auction->name,
      'buyout_value' => $auction->buyout_value,
      'min_bid' => $auction->min_bid,
      'description' => $auction->description,
      'start_date' => $auction->start_date,
      'end_date' => $auction->end_date,
      'winner' => $auction->winner,
      'user_id' => $auction->user_id,
    ];

    $comments = Comment::where('id_auction', $id)->orderBy('creation_date', 'ASC')->get();

    return view('pages.auction', ['auction' => $auctionInfo, 'comments' => $comments]);
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Like;
use App\Models\Reservation;

class ShopsController extends Controller
{
    public function getShops(Request $request)
    {
        $shops = Shop::with('area', 'genre')->with('likes', function($query) use ($request) {
            $query->where('user_id', $request->user_id);
        })->get();

        return response()->json([
            'message' => 'Shops got successfully',
            'data' => $shops
        ], 200);
    }
    public function getShop($shop_id)
    {
        $shop = Shop::where('id', $shop_id)->with('area', 'genre')->first();

        return response()->json([
            'message' => 'Shop got successfully',
            'data' => $shop
        ],200);
    }
    public function postLike(Request $request, $shop_id)
    {
        $result = Like::postLike($request->user_id, $shop_id);

        return response()->json([
            'message' => 'Like created successfully',
            'data' => $result
        ], 201);
    }
    public function deleteLike($shop_id, $like_id)
    {
        Like::where('id', $like_id)->where('shop_id', $shop_id)->delete();

        return response()->json([
            'message' => 'Like deleted successfully'
        ], 200);
    }
    public function postReservation(Request $request, $shop_id)
    {
        $result = Reservation::postReservation($request, $shop_id);

        return response()->json([
            'message' => 'Reservation created successfully',
            'data' => $result
        ], 201);
    }
    public function deleteReservation($shop_id, $reservation_id)
    {
        Reservation::where('id', $reservation_id)->where('shop_id', $shop_id)->delete();

        return response()->json([
            'message' => 'Reservation deleted successfully'
        ], 200);
    }
}
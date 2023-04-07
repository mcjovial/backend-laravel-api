<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class NewsApiController extends Controller
{
    private $api_key = '5446082a8939421d911559e492ce9185';
    public function everything(){
        $saved_feed = User::find(auth()->user()->id)->feed;
        $query = '?apiKey='.$this->api_key.'&sortBy=popularity&pageSize=20&page=1';
        if($saved_feed){
            $query.='&sources='.$saved_feed->source_id;
        }else{
            $query .= '&q=apple';
        }
        //return $query;
        $data = Http::get('https://newsapi.org/v2/everything'.$query);
        return $data;
    }

    public function sources(){
        $category = request()->category;
        $data = Http::get('https://newsapi.org/v2/top-headlines/sources?apiKey='.$this->api_key.'&category='.$category);
        return $data;
    }

    public function feed(){
        return User::find(auth()->user()->id)->feed;
    }

    public function createFeed(Request $request){
        $user = Auth::user();
        $user_feed = $user->feed;
        $feed = [
            'category' => $request->category,
            'source_id' => $request->selected_source_id,
        ];
        if($user_feed){
            $user->feed()->update($feed);
        }else{
            $user->feed()->create($feed);
        }
        $source = $request->selected_source_id;
        $query = '?pageSize=30&page=1&apiKey='.$this->api_key;
        $query.='&sources='.$source;
        $data = Http::get('https://newsapi.org/v2/everything'.$query);
        return $data;
    }

    function filter(Request $request){
        $keyword = $request->keyword;
        $query = '?pageSize=30&page=1&apiKey='.$this->api_key;
        if($keyword){
            $query .= '&q='.$keyword;
        }
        $saved_feed = User::find(auth()->user()->id)->feed;
        if($saved_feed){
            $query.='&sources='.$saved_feed->source_id;
        }

        // return $query;
        $data = Http::get('https://newsapi.org/v2/everything'.$query);
        return $data;
    }
}

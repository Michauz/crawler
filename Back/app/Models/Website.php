<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Website extends Model
{
    use HasFactory;
    public function getWebsite(){
        return ( DB::table('websites')->get());
    }
    public function addWebsite($data){
        DB::table("websites")->insert($data);
    }
    public function checkWebsite($originWebsite){
        return DB::table("websites")->select("URL")->where("originWebsite","=",$originWebsite)->get();
    }
}

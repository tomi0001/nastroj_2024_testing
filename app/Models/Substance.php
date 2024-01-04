<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substance extends Model
{
    use HasFactory;
    public static function ifExist(string $name, int $idUsers) {
        return self::selectRaw("name as name")->where("id_users",$idUsers)->where("name",$name)->first();
    }
    public static function selectListSubstance(int $idUsers) {
        return self::selectRaw("id as id")->selectRaw("name as name")->where("id_users",$idUsers)->get();
    }
    
    public static function showSettingsSubstance(int $id, int $idUsers) {
        return self::join("substances_groups","substances_groups.id_substances","substances.id")
                ->join("groups","groups.id","substances_groups.id_groups")
                ->selectRaw("groups.name as nameGroup")
                ->selectRaw("substances_groups.id_groups as id_groups")
                ->where("substances.id",$id)
                ->where("substances.id_users",$idUsers)->get();
    }
    public static function showSubstanceEquivalentName(int $id,int $idUsers) {
       return self::selectRaw("substances.equivalent as equivalent")->selectRaw("substances.name as name")->where("id",$id)
                ->where("id_users",$idUsers)->first();
    }
    public static function checkIfNameSubstance( $name,int $idUsers, $id) {
        return self::where("id_users",$idUsers)->where("name",$name)->where("id","!=",$id)->count();
    }
    public static function selectIdNameSubstanceIdProduct(string $name) {
        return self::join("substances_products","substances_products.id_substances","substances.id")
                    ->join("products","substances_products.id_products","products.id")
            ->selectRaw("products.id as id")
            ->where("substances.name","like","%".$name."%")->get();
    }
 
    public static function checkEquivalent(int $idSubstance,int $idUsers) {
        return self::where("id_users",$idUsers)
                ->where("id",$idSubstance)
                ->where("equivalent",">",0)
                ->first();
    }    
    
}

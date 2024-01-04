<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
class Usee extends Model
{
    use HasFactory;
    public $questions;
    
    
    public function createQuestionsSumDay(int $startDay) {
        $this->questions = self::query();
        $this->questions

            ->select( DB::Raw("(DATE(IF(HOUR(usees.date) >= '$startDay', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) as dat  "));

            $this->questions->selectRaw("(sum(usees.portion)   )  as portions")
                ->selectRaw("((count(*) ) )  as count");

        $this->questions->selectRaw("usees.id_products as id")
            ->selectRaw("usees.id as id_usees")
            ->selectRaw("products.name as name")
            ->selectRaw("sum(usees.price) as price")
            ->selectRaw("products.type_of_portion as type");

            $this->questions->join("products","products.id","usees.id_products");
    }
    public function createQuestionsGroupDay(int $startDay) {
        $this->questions = self::query();
        $this->questions

            ->select( DB::Raw("(DATE(IF(HOUR(usees.date) >= '$startDay', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) as dat  "));

            $this->questions->selectRaw("(sum(usees.portion)   )  as portions")
                ->selectRaw("((count(*) ) )  as count");

        $this->questions->selectRaw("usees.id_products as id")
            ->selectRaw("usees.id as id_usees")
            ->selectRaw("products.name as name")
            ->selectRaw("sum(usees.price) as price")
            ->selectRaw("products.type_of_portion as type");

        $this->questions->join("products","products.id","usees.id_products");
    }
    public function createQuestions(int $startDay)
    {
        $this->questions = self::query();
        $this->questions

            ->select( DB::Raw("(DATE(IF(HOUR(usees.date) >= '$startDay', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) as dat  "))
            ->selectRaw("hour(usees.date) as hour");

            $this->questions->selectRaw("usees.portion as portions");

        $this->questions
            ->selectRaw("day(usees.date) as day")
            ->selectRaw("month(usees.date) as month")
            ->selectRaw("year(usees.date) as year")

            ->selectRaw("usees.date as date")
            ->selectRaw("usees.id_products as id")
            ->selectRaw("usees.id as id_usees")
            ->selectRaw(  DB::Raw("TIME(Date_add(usees.date, INTERVAL - '$startDay' HOUR) ) as hour2"))
            //->selectRaw("descriptions.description as description")
            //->selectRaw("descriptions.date as date_description")
            ->selectRaw("usees.id_products as product")
            ->selectRaw("usees.price as price")
            ->selectRaw("products.name as name")
            ->selectRaw("products.type_of_portion as type")
            ->leftjoin("users_descriptions","usees.id","users_descriptions.id_usees")
            ->leftjoin("descriptions","descriptions.id","users_descriptions.id_descriptions")
            ->join("products","products.id","usees.id_products");



    }

    public function setGroupDay(int $startDay) {
        $this->questions->groupBy(DB::Raw("(DATE(IF(HOUR(usees.date) >= '$startDay', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) )  "));
    }
    public function setGroupIdProduct() {
        $this->questions->groupBy("usees.id_products");
    }
    public function setGroupDescription() {
        $this->questions->groupBy("usees.id");
    }
    public function orderBy(string $asc,string $type,$startDay) {

        switch ($type) {

            case 'date': $this->questions->orderBy("usees.date",$asc);
                break;
            case 'hour' : $this->questions->orderByRaw("   time(  Date_add(usees.date,INTERVAL - '$startDay' HOUR)) $asc");
                break;
            case 'product' : $this->questions->orderBy("usees.id_products",$asc);
                break;
            case 'dose' : $this->questions->orderBy("usees.portion",$asc);
                break;
    


        }
    }
    public function orderByGroupDay(string $asc,string $type) {

        switch ($type) {

            case 'date': $this->questions->orderBy("usees.date",$asc);
                break;
            case 'hour' : $this->questions->orderByRaw("time(usees.date) $asc");
                break;
            case 'product' : $this->questions->orderBy("usees.id_products",$asc);
                break;
            case 'dose' : $this->questions->orderByRaw(""
                    . "case "
                    . " when products.type_of_portion = 4 THEN sum(usees.portion) / count(*)"
                    . " when products.type_of_portion = 5 THEN sum(usees.portion) / count(*)"
                    . "ELSE sum(usees.portion) "
                    . " END "
                    . "$asc");
                break;


        }
    }
    public function setDate($dateFrom,$dateTo,$startDay) {
        if ($dateFrom != "") {
            $this->questions->whereRaw(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) >= '$dateFrom'") );
        }
        if ($dateTo != "") {
            $this->questions->whereRaw(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) < '$dateTo'") );
        }
    }
    public function setDose($doseFrom,$doseTo) {
        if ($doseFrom != "") {
            $this->questions->where("usees.portion",">=",$doseFrom);
        }
        if ($doseTo != "") {
            $this->questions->where("usees.portion","<=",$doseTo);
        }
    }
    public function setDoseGroupDay($doseFrom,$doseTo) {
        if ($doseFrom != "") {
            $this->questions->havingRaw(""
                       . "case "
                    . " when products.type_of_portion = 4 THEN sum(usees.portion) / count(*) >= '$doseFrom'"
                    . " when products.type_of_portion = 5 THEN sum(usees.portion) / count(*) >= '$doseFrom'"
                    . "ELSE sum(usees.portion) >= '$doseFrom'"
                    . " END "
                    
                    . "");
        }
        if ($doseTo != "") {
             $this->questions->havingRaw(""
                       . "case "
                    . " when products.type_of_portion = 4 THEN sum(usees.portion) / count(*) <= '$doseTo'"
                    . " when products.type_of_portion = 5 THEN sum(usees.portion) / count(*) <= '$doseTo'"
                    . "ELSE sum(usees.portion) <= '$doseTo'"
                    . " END "
                    
                    . "");
            
        }
    }
    public function setProduct(array $idProduct) {
        $this->questions->whereIn("usees.id_products",$idProduct);
    }

    public function setIdUsers(int $idUsers) {
        $this->questions->where("usees.id_users",$idUsers);
    }
    public function setHourTwo($hourFrom,$hourTo,$startDay) {
        $this->questions->whereRaw("(time(date_add(usees.date,INTERVAL - $startDay hour))) <= '$hourTo'");
        $this->questions->whereRaw("(time(date_add(usees.date,INTERVAL - $startDay hour))) >= '$hourFrom'");
    }
    public function setWhatWork(string $whatWork) {
        $this->questions->whereRaw("descriptions.description like '%" . $whatWork  . "%'");
    }
    public function setWhatWorkOn() {
        $this->questions->where("descriptions.description","!=","");
    }
    public function setHourTo(string $hourTo) {
        $this->questions->whereRaw("time(usees.date) <= " . "'" .  $hourTo . ":00'");
    }
    public function setHourFrom(string $hourFrom) {
        $this->questions->whereRaw("time(usees.date) >= " . "'" .  $hourFrom . ":00'");
    }
    public static function selectLastDrugs(int $idProduct,string $date,float $dose) {
        return self::selectRaw("date")->where("id_users",Auth::User()->id)->where("id_products",$idProduct)->where("usees.portion",$dose)
                ->where("date",">=",date("Y-m-d H:i:s", strtotime($date )- 80))->where("date","<=",$date)->first();
    }
    public static function selectLastDescription(int $idUsee,string $date, $description) {
        return self::join("users_descriptions","users_descriptions.id_usees","usees.id")->join("descriptions","descriptions.id","users_descriptions.id_descriptions")
                ->selectRaw("usees.date")->where("usees.id_users",Auth::User()->id)->where("usees.id",$idUsee)->where("descriptions.description",$description)
                ->where("descriptions.date",">=",date("Y-m-d H:i:s", strtotime($date )- 80))->first();
    }
    public static function selectLastDrugsPlaned(int $idProduct,string $date) {
        return self::selectRaw("date")->where("id_users",Auth::User()->id)->where("id_products",$idProduct)
                ->where("date",">=",date("Y-m-d H:i:s", strtotime($date )- 80))->where("date","<=",$date)->first();
    }
    public static function ifExistUsee(string $dateStart, string $dateEnd, int $idUsers) {
        return self::selectRaw("date")->where("id_users",$idUsers)
                ->where("date",">=",$dateStart)->where("date","<=",$dateEnd)->first();
    }
    public static function selectUsee(string $date, int $idUsers,int $startDay) {
        return self::join("products","products.id","usees.id_products")
                ->selectRaw("products.id as products_id")
                ->selectRaw("products.type_of_portion as type")
                ->selectRaw("usees.date as date")
                ->selectRaw("usees.price as price")
                ->selectRaw("usees.id as id")
                ->selectRaw("usees.portion as portions")
                ->selectRaw("products.name as name")
                ->where("usees.id_users",$idUsers)
                ->whereRaw(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) = '" . $date . "' "))
                ->orderBy("usees.date")
                ->get();

    }
    public static function selectlistDrugs(string $dateOne, string $dateTwo, int $idUsers) {
        return self::join("products","products.id","usees.id_products")
                ->selectRaw("products.id as products_id")
                ->selectRaw("products.type_of_portion as type")
                ->selectRaw("usees.date as date")
                ->selectRaw("usees.id as id")
                ->selectRaw("usees.price as price")
                ->selectRaw("usees.portion as portions")
                ->selectRaw("products.name as name")
                ->where("usees.id_users",$idUsers)
                ->where("usees.date",">=",$dateOne)
                ->where("usees.date","<",$dateTwo)
                ->orderBy("usees.date")
                ->get();

    }
    public static function listSubstnace(string $date, int $idUsers,int $startDay) {
        return self::join("products","products.id","usees.id_products")
                ->join("substances_products","substances_products.id_products","products.id")
                ->join("substances","substances.id","substances_products.id_substances")
                ->selectRaw("count(*) as count")
                ->selectRaw(" round(sum("
                        . " CASE "
                        . " WHEN products.type_of_portion = 2  THEN ( (products.how_percent / 100) * usees.portion ) " 
                        . " WHEN substances_products.doseProduct is NULL  THEN (usees.portion ) "
                        
                        . "ELSE (substances_products.doseProduct * usees.portion) "
                        . " END),2)"
                        . "  as portions ")
                ->selectRaw("substances.name as name")
                ->selectRaw("products.type_of_portion as type")
                ->where("usees.id_users",$idUsers)
                ->whereRaw(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) = '" . $date . "' "))
                ->groupBy("substances.id")
                ->get();
    }
    public static function ifDescriptionDrugs(int $idUsee, int $idUsers) {
        return self::join("users_descriptions","users_descriptions.id_usees","usees.id")
                ->where("users_descriptions.id_usees",$idUsee)
                ->count();
    }
    public static function ifIdUsersExist(int $id,int $idUsers) {
        return self::where("id",$id)->where("id_users",$idUsers)->count();
    }
    public static function selectValueDrugs(int $id,int $idUsers) {
        return self::join("products","products.id","usees.id_products")
                ->selectRaw("products.name  as name")
                ->selectRaw("products.type_of_portion as type")
                ->selectRaw("usees.portion as portions")
                ->selectRaw("SUBSTRING((usees.date),11,6) as date")
                ->selectRaw("usees.price as price")
                ->selectRaw("products.type_of_portion as type")
                ->where("usees.id_users",$idUsers)
                ->where("usees.id",$id)
                ->first();
    }
    public static function selectAllSubstance(int $id,int $idUsers) {
        return self::join("products","products.id","usees.id_products")
                ->join("substances_products","substances_products.id_products","products.id")
                ->join("substances","substances.id","substances_products.id_substances")
                ->selectRaw("substances.name  as nameSubstances")
                ->selectRaw("substances.id as id_substances")
                ->where("usees.id_users",$idUsers)
                ->where("usees.id",$id)
                ->get();
    }
    public static function showDosePruduct(int $idUsee,int $idSubstance,int $idUsers) {
        return self::join("products","products.id","usees.id_products")
                ->join("substances_products","substances_products.id_products","products.id")
                ->selectRaw("(usees.portion * substances_products.doseProduct)  as doseProduct")
                
                ->selectRaw(" "
                      . "( CASE "
                        . " WHEN products.type_of_portion = 4  THEN ('4' ) "
                        . " WHEN products.type_of_portion = 5  THEN ('5' ) "
                        . " WHEN products.type_of_portion = 6  THEN ('6' ) "
                        . " WHEN substances_products.Mg_Ug = 2  THEN ('7' ) "
                        . "ELSE '1' "
                        . " END)"
                        . "  as type ")
                ->where("usees.id_users",$idUsers)
                ->where("usees.id",$idUsee)
                ->where("substances_products.id_substances",$idSubstance)
                ->first();
    }
    public static function selectProductName(int $id,int $idUsers) {
        return self::join("products","products.id","usees.id_products")
                ->selectRaw("products.name  as nameProducts")
                ->selectRaw("products.id  as id_products")
                ->where("usees.id_users",$idUsers)
                ->where("usees.id",$id)
                ->get();
    }
    public static function selectDateIdUsee(int $id,int $idUsers) {
        return self::selectRaw("date  as date")
                ->where("usees.id_users",$idUsers)
                ->where("usees.id",$id)
                ->first();
    }
    public static function selectOldUsee(int $idProduct,string $dateEnd,int $idUsers,int $startDay,$hour) {
        return self::join("products","products.id","usees.id_products")
                ->selectRaw("sum(usees.portion) as portions")
                ->selectRaw("products.type_of_portion as type")
                ->selectRaw("count(usees.portion) as how")
                ->selectRaw(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) as dat "))
                ->where("usees.date","<=",$dateEnd)
                ->where("usees.id_products",$idProduct)
                ->where("usees.id_users",$idUsers)
                ->whereRaw("(time(date_add(usees.date,INTERVAL - $startDay hour))) <= '$hour[1]'")
                ->whereRaw("(time(date_add(usees.date,INTERVAL - $startDay hour))) >= '$hour[0]'")
                ->groupBy(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) )  "))
                ->orderBy("usees.date","DESC")
                ->get();
    }

    public static function selectOldUseeSubstances(int $idSubstances,string $dateEnd,int $idUsers,int $startDay,$hour) {
        return self::join("products","products.id","usees.id_products")
                ->join("substances_products","substances_products.id_products","products.id")
                ->selectRaw("count(usees.portion) as how")
                //->selectRaw("'1' as type")
                ->selectRaw(" "
                        . "( CASE "
                        . " WHEN products.type_of_portion = 2  THEN ('2' ) "
                        . " WHEN products.type_of_portion = 4  THEN ('4' ) "
                        . " WHEN products.type_of_portion = 5  THEN ('5' ) "
                        . " WHEN products.type_of_portion = 6  THEN ('6' ) "
                        . " WHEN substances_products.Mg_Ug = 2  THEN ('7' ) "
                        . "ELSE '1' "
                        . " END)"
                        . "  as type ")
                ->selectRaw(" round(sum("
                        . " CASE "
                        . " WHEN products.type_of_portion = 2  THEN ( (products.how_percent / 100) * usees.portion ) " 
                        . " WHEN substances_products.doseProduct is NULL  THEN (usees.portion ) "
                        . "ELSE (substances_products.doseProduct * usees.portion) "
                        . " END),2)"
                        . "  as portions ")
                ->selectRaw(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) as dat "))
                ->where("usees.date","<=",$dateEnd)
                ->where("substances_products.id_substances",$idSubstances)
                ->where("usees.id_users",$idUsers)
                ->whereRaw("(time(date_add(usees.date,INTERVAL - $startDay hour))) <= '$hour[1]'")
                ->whereRaw("(time(date_add(usees.date,INTERVAL - $startDay hour))) >= '$hour[0]'")
                ->groupBy(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) )  "))
                ->orderBy("usees.date","DESC")
                ->get();
    }
     /*
     * 
     * Create year 2023
     */
    
    
    public static function selectOldUseeEquivalent(string $dateEnd,int $idUsers,int $startDay,$hour) {
        return self::join("products","products.id","usees.id_products")
                ->join("substances_products","substances_products.id_products","products.id")
                ->join("substances","substances.id","substances_products.id_substances")
                ->selectRaw("count(usees.portion) as how")
                //->selectRaw("'1' as type")
                ->selectRaw(" "
                        . "( CASE "
                        . " WHEN products.type_of_portion = 2  THEN ('2' ) "
                        . " WHEN products.type_of_portion = 4  THEN ('4' ) "
                        . " WHEN products.type_of_portion = 5  THEN ('5' ) "
                        . " WHEN products.type_of_portion = 6  THEN ('6' ) "
                        . " WHEN substances_products.Mg_Ug = 2  THEN ('7' ) "
                        . "ELSE '1' "
                        . " END)"
                        . "  as type ")
                ->selectRaw(" "
                        . "sum(CASE "
                        . "WHEN products.type_of_portion = 1 THEN  ( usees.portion / ( substances.equivalent / 10) ) "
                        . "ELSE ( (usees.portion *  substances_products.doseProduct) / ( substances.equivalent / 10) ) "
                        . " END"
                        . ") as portions")
                ->selectRaw(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) as dat "))
                ->where("usees.date","<=",$dateEnd)
                ->where("usees.id_users",$idUsers)
                ->whereRaw("(time(date_add(usees.date,INTERVAL - $startDay hour))) <= '$hour[1]'")
                ->whereRaw("(time(date_add(usees.date,INTERVAL - $startDay hour))) >= '$hour[0]'")
                ->where("substances.equivalent",">",0)
                ->groupBy(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) )  "))
                ->orderBy("usees.date","DESC")
                ->get();        
    }
    
    public static function checkEquivalent(int $idUsee,int $idUsers) {
        return self::join("products","products.id","usees.id_products")
                ->join("substances_products","substances_products.id_products","products.id")
                ->join("substances","substances_products.id_substances","substances.id")
                ->where("products.id_users",$idUsers)
                ->where("usees.id",$idUsee)
                ->where("substances.equivalent",">",0)
                ->first();
    }
    /*
     * update may 2023
     */
    public static function selectDateUsee(int $idUsers,  $name,int $startDay, $doseFrom, $doseTo,array $arrayProdduct) {
        
        return self::join("products","products.id","usees.id_products")
                ->join("substances_products","substances_products.id_products","products.id")
                ->join("substances","substances_products.id_substances","substances.id")
                ->selectRaw(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) as dat "))
                ->where("products.id_users",$idUsers)
                ->whereRaw("products.name like '%" . $name  . "%'")
                ->where("usees.date",">=",$arrayProdduct["dateFrom"])
                ->where("usees.date","<",$arrayProdduct["dateTo"])
                  ->where(function ($query) use ($arrayProdduct,$doseFrom,$doseTo,$startDay) {
                      if ($doseFrom != "") {
                          $query->where("usees.portion",">=",$doseFrom);
                      }
                      if ($doseTo != "") {
                          $query->where("usees.portion","<=",$doseTo);
                      }
                      if ($arrayProdduct["timeFrom"] != "" and $arrayProdduct["timeTo"] != "") {
                          $query->whereRaw("(time(date_add(usees.date,INTERVAL - $startDay hour))) <= '" .  $arrayProdduct["timeTo"] . "'");
                          $query->whereRaw("(time(date_add(usees.date,INTERVAL - $startDay hour))) >= '" . $arrayProdduct["timeFrom"] . "'");

                      }
                      else if ($arrayProdduct["timeFrom"] != "") {
                          $query->whereRaw("time(usees.date) >= " . "'" .  $arrayProdduct["timeFrom"] . ":00'");
                          
                      }
                      else if ($arrayProdduct["timeTo"] != "") {
                          $query->whereRaw("time(usees.date) <= " . "'" .  $arrayProdduct["timeTo"] . ":00'");
                      }
                 
                })
                ->groupBy(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) )  "))
                 ->get();
                
                
    }
    
    public static function selectFirstDrugs($array,int $startDay, int $idUsers) {
        return self::selectRaw(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) as dat "))
                ->selectRaw("min(date) as date")
                ->where("id_users",$idUsers)
                ->whereRaw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) ) IN " . $array)
                ->groupBy(DB::Raw("(DATE(IF(HOUR(    usees.date) >= '" . $startDay . "', usees.date,Date_add(usees.date, INTERVAL - 1 DAY) )) )"))
                ->orderBy("date","ASC")  
                ->get();
                
    }

}

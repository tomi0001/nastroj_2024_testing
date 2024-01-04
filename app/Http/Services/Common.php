<?php

/*
 * copyright 2021 Tomasz Leszczyński tomi0001@gmail.com
 */

namespace App\Http\Services;
use Storage;
use DateTime;
use App\Models\User;
use Auth;
/**
 * Description of Common
 *
 * @author tomi2
 */
class Common {
    private static $doseProduct = [
        null,
        'Mg',
        'militry',
         'porcji',
         'waga ciała',
        'temperatura ciała',
        'ilości',
        'Ug'
    ];
    public static function ifChangeTimeWinterOne(string $dateStart) :bool {
        $yearFrom = explode("-",$dateStart);
        //$yearFrom2 = explode("-",$yearFrom[0]);
        
//        $yearTo = explode(" ",$dateTo);
//        $yearTo2 = explode("-",$yearTo[0]);
        
        
        
        
         if ( (  (  strtotime($yearFrom[0] . "-" . "11-" . "01") - strtotime($dateStart)  )  < 86400 * 7)  and (  (  strtotime($yearFrom[0] . "-" . "10-" . "31") - strtotime($dateStart)  )  >= 0) ) {
            return true;
        }  
        else {
            return false;
        }
    }
    
    
    public static function ifChangeTimeWinterTwo(string $dateStart) :bool {
        $yearFrom = explode("-",$dateStart);
        if  (  (  (   strtotime($dateStart)  )  < 86400 * 7  ) -  strtotime($yearFrom[0] . "-" . "11-" . "01")  and (  (  strtotime($yearFrom[0] . "-" . "10-" . "31") - strtotime($dateStart)  )  < 0)    ) {
            return true;
        }
        else {
            return false;
        }
    }
    
    
    public static function returnDayWeek($data) {
        $week = date('N', strtotime($data));
        switch ($week) {
            case 1: return "Poniedziałek";
                break;
            case 2: return "Wtorek";
                break;
            case 3: return "Środa";
                break;
            case 4: return "Czwartek";
                break;
            case 5: return "Piątek";
                break;
            case 6: return "Sobota";
                break;
            default: return "Niedziela";
                break;


        }
    }
    
    
 
    
    public static function setColorStatic( $mood) :string {
        if (empty($mood) and $mood != 0) {
            return '10000';
        }
        if ($mood >= -20  and  $mood < -16) {
            return '-10';
        }
        if ($mood >= -16  and  $mood < -11) {
            return '-9';
        }
        if ($mood >= -11  and  $mood < -7) {
            return '-8';
        }
        if ($mood >= -7  and  $mood < -2) {
            return '-7';
        }
        if ($mood >= -2  and  $mood < -1) {
            return '-6';
        }
        if ($mood >= -1  and  $mood < -0.5) {
            return '-5';
        }
        if ($mood >= -0.5  and  $mood < -0.2) {
            return '-4';
        }
        if ($mood >= -0.2  and  $mood < -0.1) {
            return '-3';
        }
        if ($mood >= -0.1  and  $mood < -0.05) {
            return '-2';
        }
        if ($mood >= -0.05  and  $mood < 0) {
            return '-1';
        }
        if ($mood >= 0  and  $mood < 0.03) {
            return '0';
        }
        if ($mood >= 0.03  and  $mood < 0.1) {
            return '1';
        }
        if ($mood >= 0.1  and  $mood < 0.2) {
            return '2';
        }
        if ($mood >= 0.2  and  $mood < 0.3) {
            return '3';
        }
        if ($mood >= 0.3  and  $mood < 0.5) {
            return '4';
        }
        if ($mood >= 0.5  and  $mood < 1) {
            return '5';
        }
        if ($mood >= 1  and  $mood < 3) {
            return '6';
        }
        if ($mood >= 3  and  $mood < 8) {
            return '7';
        }
        if ($mood >= 8  and  $mood < 12) {
            return '8';
        }
        if ($mood >= 12  and  $mood < 16) {
            return '9';
        }
        if ($mood >= 16  and  $mood <= 20) {
            return '10';
        }

    }
    
    public static function calculateHour($dateOne,$dateTwo) {

        $dateStart = new \DateTime($dateOne);
        $dateEnd = new \DateTime($dateTwo);
        $diff = $dateEnd->diff($dateStart);

        $string = "";
        if ($diff->y != 0) {
            $string .=  $diff->y .  " Lat, ";
        }
        if ($diff->m != 0) {
            $string .=  $diff->m . " Miesięcy, ";
        }
        if ($diff->d != 0) {
            $string .=  $diff->d . " Dni, ";
        }
        if ($diff->h != 0) {
            $string .=  $diff->h . " Godzin, ";
        }
        if ($diff->i != 0) {
            $string .=  $diff->i . " Minut, ";
        }
        return substr($string,0,-2);
    }
   
    public static function subMonth($dateOne,$dateTwo) :int {

        $dateStart = new \DateTime($dateOne);
        $dateEnd = new \DateTime($dateTwo);
        $diff = $dateEnd->diff($dateStart);

        
        
        
        return (12 * $diff->y) + $diff->m;
    }
    
    public static function calculateHourAverage($dateOne,$dateTwo) {
        $dateStart = new \DateTime($dateOne);
        $dateEnd = new \DateTime($dateTwo);
        $diff = $dateEnd->diff($dateStart);

        //$sum =  $diff->y * $diff->m * $diff->d;

        return $diff->days;
    }
    public static function calculateHourOne(int $time) {
        $dateStart = new \DateTime("1970-01-01 00:00:00");
        $dateEnd = new \DateTime(date("Y-m-d H:i:s", strtotime("1970-01-01 00:00:00") + $time));
        $diff = $dateEnd->diff($dateStart);
        $string = "";
        if ($diff->y != 0) {
            $string .=  $diff->y .  " Lat, ";
        }
        if ($diff->m != 0) {
            $string .=  $diff->m . " Miesięcy, ";
        }
        if ($diff->d != 0) {
            $string .=  $diff->d . " Dni, ";
        }
        if ($diff->h != 0) {
            $string .=  $diff->h . " Godzin, ";
        }
        if ($diff->i != 0) {
            $string .=  $diff->i . " Minut, ";
        }
        return substr($string,0,-2);
    }
    public  static function setColorPleasure($color) {
        if ($color <= -16) {
            return 0;
        }
        else if ($color <= -12) {
            return 1;
        }
        else if ($color <= -7) {
            return 2;
        }
        else if ($color <= -4) {
            return 3;
        }
        else if ($color <= -1) {
            return 4;
        }
        else if ($color <= 1) {
            return 5;
        }
        else if ($color <= 5) {
            return 6;
        }
        else if ($color <= 8) {
            return 7;
        }
        else if ($color <= 12) {
            return 8;
        }
        else if ($color <= 16) {
            return 9;
        }
        else if ($color <= 20) {
            return 10;
        }
    }
    public static function showDoseProduct(int $type) {
        return self::$doseProduct[$type];
    }
    public static function showDoseProductSubstance(int $type) {
        if ($type == 3) {
            return self::$doseProduct[1];
        }
        return self::$doseProduct[$type];
    }
    public static function showListDoseProduct() :array {
        return self::$doseProduct;
    }
    public static function ifDateTrue(string $date) :bool  {
        if (strlen($date) == 19) {
            return true;
        }
        else {
            return false;
        }
    }
    
    public static function  sumHour($hour,$startDay) {
        $sumHour = $hour[0] + $startDay;
        if ($sumHour > 24) {
            $sumHour = 24 - $sumHour;
            if ($sumHour < 0) {
                
                $sumHour = -$sumHour;
                $sumHour = " ND " .  $sumHour;
                
            }
        }
        if (strlen($sumHour) == 1) {
            $sumHour = "0" .$sumHour;
        }
        if (strlen($hour[1]) == 1) {
            $hour[1] = "0" . $hour[1];
        }

        return $sumHour . ":" .  $hour[1] . ":00";
    }
    public static function showColorTypeHow(int $how) {
        switch($how) {
            case 1:
                return "how-color-one";
                break;
            case 2:
                return "how-color-two";
                break;
            case 3:
                return "how-color-three";
                break;
            default:
                return "how-color-long";
                break;
        }
    }
    /*
     * Update year 2023 April
     */
    public static function setColor($mood) :string {
        
        if (empty($mood) and $mood != 0) {
            return '10000';
        }
        else {
            if (User::ifNullMoodColor(Auth::User()->id) == null) {
                return (string) self::setColorStatic($mood);
            }
            else {
                $arrayList = User::readLevelMoodColor(Auth::User()->id,$mood);
           
                return (string) $arrayList->color;
            }
        }
        
    }
    
}

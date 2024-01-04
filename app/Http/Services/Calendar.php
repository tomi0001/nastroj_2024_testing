<?php
/*
 * copyright 2020 Tomasz Leszczyński tomi0001@gmail.com
 * Edition 2021 
 */
namespace App\Http\Services;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class calendar
{
    
    public $month;
    public $day;
    public $action;
    public $year;
    public $day_week;
    
    public $back_year;
    public $next_year;
    public $text_month;
    public $next_month;
    public $back_month;
    public $how_day_month;
    
    function __construct($year,$month,$day) {
            $this->setDate($month,$day,$year);
            $this->how_day_month = $this->checkMonth($this->month,$this->year);
            $this->back_month = $this->returnBackMonth($this->month,$this->year);
            $this->next_month = $this->returnNextMonth($this->month,$this->year);
            $this->text_month = $this->returnMonthText($this->month);
            $this->next_year  = $this->returnNextYear($this->year);
            $this->back_year  = $this->returnBackYear($this->year);
    }

    public function returnMonthText($month) {
    
            switch($month) {
              case 1 : return "Styczeń";
              case 2 : return "Luty";
              case 3 : return "Marzec";
              case 4 : return "Kwiecień";
              case 5 : return "Maj";
              case 6 : return "Czerwiec";
              case 7 : return "Lipiec";
              case 8 : return "Sierpień";
              case 9 : return "Wrzesień";
              case 10 : return "Październik";
              case 11: return "Listopad";
              case 12 : return "Grudzień";
            }

      }
    public static function nextMonth($year,$month) {
         if ($month == 12) {
          $year++;
          $month = 1;
        }
        else {
          $month++;
        }
        return $year . "-" . $month;
    }
    public function returnBackMonth($month,$year) {
        if ($month == 1) {
          $year--;
          $month = 12;
        }
        else {
          $month--;
        }
        return array($year,$month);
    }

        public function returnNextMonth($month,$year) {
          if ($month == 12) {
            $year++;
            $month = 1;
          }
          else {
            $month++;
          }
          return array($year,$month);
        }

    
        public function returnNextYear($year) {
            
            return array($year+1,$this->month);
        }
        public function returnBackYear($year) {
            
            return array($year-1,$this->month);
        }
    
        public function setDate($month,$day,$year) {
            if (empty($year)) {
                
                $this->year = date("Y");
            }
            else {
                $this->year = $year;
            }
            if (empty($month)) {
                $this->month = date("m");
                
            }
            else {
                $this->month = $month;
            }
            if (empty($day)) {
                $this->day = date("d");
                
            }
            else {
                $this->day = $day;
            }
            $this->day_week = $this->setBeginningDay($this->year . "-" . $this->month . "-1");
            
            if ($this->day_week == 0) {
                $this->day_week = 7;
            }
            
    }
    
    
      private function setBeginningDay($data) {
        return date("w",strtotime($data));
      }
        public static function checkMonth($month,$year) {
            if ($month == 12) {
            return 31;
            }
            else if ($month == 11) {
            return 30;
            }
            else if ($month == 10) {
            return 31;
            }
            else if ($month == 9) {
            return 30;
            }
            else if ($month == 8) {
            return 31;
            }
            else if ($month == 7) {
            return 31;
            }
            else if ($month == 6) {
            return 30;
            }
            else if ($month == 5) {
            return 31;
            }
            else if ($month == 4) {
            return 30;
            }
            else if ($month == 3) {
            return 31;
            }
            else if ($month == 2) {

                if ( self::orAffordable($year) == 1) {
                    return 29;
                }
                else {
                    return 28;
                }

            }
            else if ($month == 1) {
                return 31;
            }
            else {
                return 30;
            }


  }
  
    private static function orAffordable($year)
    {
         return (($year%4 == 0 && $year%100 != 0) || $year%400 == 0);
    }
  
  
    
}

<?php

/*
 * copyright 2022 Tomasz Leszczyński tomi0001@gmail.com
 */
namespace App\Http\Controllers\MySQL;
use DB;

use App\Models\Action_plan;
use App\Models\Description;
use App\Models\Product;
use App\Models\Group;
use App\Models\Substances_group;
use App\Models\Substance;
use App\Models\Substances_product;
use App\Models\Usee;
use App\Models\Mood;
use App\Models\Users_description;
use App\Models\Planned_drug;
use App\Models\Moods_action;
/*
class MySQLController {
    public function index() {
        set_time_limit(0);
        $this->tableUsers();
        $this->tableAction();
        $this->tableActionDays();
        $this->group();
        $this->sub();
        $this->subGro();
        $this->products();
        $this->subPro();
        $this->tableActionPlans();
        $this->moods();
        $this->sleep();
        $this->moods_action();
        $this->usees();
        $this->description();
        $this->planed();
        $this->descriuser();
        //$this->descriuser();
    }
    public function tableAction() {
        DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from actions");
            foreach ($users as $users2) {
                 DB::insert("insert into actions(id,name,id_users,level_pleasure,created_at,updated_at)  values('"
                         . $users2->id .  "'," . 
                        "'" . $users2->name .  "'," . 
                        "'" . $users2->id_users .   "'," . 
                        "'" . $users2->level_pleasure .  "'," . 
                        "'" . $users2->created_at .  "'," . 
                        "'" . $users2->updated_at .  "')" 
                         
                        );
            }
        });
    }
    public function tableActionDays() {
        DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from actions_days");
            foreach ($users as $users2) {
                $array = explode(" ",$users2->created_at);
                $date = $users2->date . " " . $array[1];
                 DB::insert("insert into actions_days(id,id_users,id_actions,date,created_at,updated_at)  values('"
                         . $users2->id .  "'," . 
                        "'" . $users2->id_users .  "'," . 
                        "'" . $users2->id_actions .   "'," . 
                        "'" . $date.  "'," . 
                        "'" . $users2->created_at .  "'," . 
                        "'" . $users2->updated_at .  "')" 
                         
                        );
            }
        });
    }
    public function group() {
         DB::transaction(function () {
            $users = DB::connection('mysql2')->select("SELECT * FROM `groups`");
            foreach ($users as $users2) {
                //print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                //if ($users2->id_users == 38) {
                $Action_plan = new Group;
                $Action_plan->id = $users2->id;
                $Action_plan->name = $users2->name;
                $Action_plan->color = $users2->color;
    
              
                $Action_plan->id_users = $users2->id_users;
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = $users2->updated_at;
                $Action_plan->save();
                //}
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });
    }
    
    
        public function planed() {
         DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from planned_drugs");
            foreach ($users as $users2) {
                print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                //if ($users2->id_users == 38) {
                //if ($users2->id_users == 38) {
                $Action_plan = new Planned_drug;
                $Action_plan->id = $users2->id;
                $Action_plan->name = $users2->name;
                $Action_plan->id_users = $users2->id_users;
                $Action_plan->id_products = $users2->id_products;
                $Action_plan->portion = $users2->portion;
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = $users2->updated_at;
                $Action_plan->save();
                //}
                //}
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });  
    }
    
    
    public function sub() {
         DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from substances");
            foreach ($users as $users2) {
                print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                //if ($users2->id_users == 38) {
                //if ($users2->id_users == 38) {
                $Action_plan = new Substance;
                $Action_plan->id = $users2->id;
                $Action_plan->name = $users2->name;
                $Action_plan->id_users = $users2->id_users;
                $Action_plan->equivalent = $users2->equivalent;
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = $users2->updated_at;
                $Action_plan->save();
                //}
                //}
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });  
    }
    
    
    public function subGro() {
              DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from forwarding_groups");
            foreach ($users as $users2) {
                print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                //if ($users2->id != 424 and $users2->id != 425 and $users2->id != 426 and $users2->id != 427 and $users2->id != 428 and $users2->id != 429 and $users2->id != 430) {
                if (!empty(Substance::where("id",$users2->id_substances)->first()   )   and  !empty(Group::where("id",$users2->id_groups)->first()   ) ) {
                $Action_plan = new Substances_group;
                $Action_plan->id = $users2->id;
                $Action_plan->id_groups = $users2->id_groups;
                $Action_plan->id_substances = $users2->id_substances;
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = "2021-12-12 13:45:00";
                $Action_plan->save();
                }
                //}
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });  
    }
    public function subPro() {
              DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from forwarding_substances");
            foreach ($users as $users2) {
                print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                //if ($users2->id != 424 and $users2->id != 425 and $users2->id != 426 and $users2->id != 427 and $users2->id != 428 and $users2->id != 429 and $users2->id != 430) {
                if (!empty(Substance::where("id",$users2->id_substances)->first()   )   and  !empty(Product::where("id",$users2->id_products)->first()   ) ) {
                $Action_plan = new Substances_product;
                $Action_plan->id = $users2->id;
                $Action_plan->id_products = $users2->id_products;
                $Action_plan->id_substances = $users2->id_substances;
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = $users2->updated_at;
                $Action_plan->save();
                }
                //}
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });  
    }
        public function descriuser() {
              DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from forwarding_descriptions");
            foreach ($users as $users2) {
                print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                //if ($users2->id != 424 and $users2->id != 425 and $users2->id != 426 and $users2->id != 427 and $users2->id != 428 and $users2->id != 429 and $users2->id != 430) {
                //if (!empty(Substance::where("id",$users2->id_substances)->first()   )   and  !empty(Product::where("id",$users2->id_products)->first()   ) ) {
                if (!empty(Usee::where("id",$users2->id_usees)->first()   )   and  !empty(Description::where("id",$users2->id_descriptions)->first()   ) ) {
               
                $Action_plan = new Users_description;
                $Action_plan->id = $users2->id;
                $Action_plan->id_usees = $users2->id_usees;
                $Action_plan->id_descriptions = $users2->id_descriptions;
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = $users2->updated_at;
                $Action_plan->save();
                }
                //}
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });  
    }
    public function products() {
         DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from products");
            foreach ($users as $users2) {
                print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                //if ($users2->id_users == 38) {
                $Action_plan = new Product;
                $Action_plan->id = $users2->id;
                $Action_plan->name = $users2->name;
                $Action_plan->how_percent = $users2->how_percent;
    
                 $Action_plan->price = $users2->price;
                  $Action_plan->type_of_portion = $users2->type_of_portion;
                  $Action_plan->how_much = $users2->how_much;
                $Action_plan->id_users = $users2->id_users;
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = $users2->updated_at;
                $Action_plan->save();
                //}
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });
    }
    public function description() {
        DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from descriptions");
            foreach ($users as $users2) {
                print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                
                $Action_plan = new Description;
                $Action_plan->id = $users2->id;
                $Action_plan->date = $users2->date;
                $Action_plan->description = $users2->description;
                $Action_plan->id_users = $users2->id_users;
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = $users2->updated_at;
                $Action_plan->save();
                
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });
    }
    public function usees() {
        set_time_limit(0);
        DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from usees");
            foreach ($users as $users2) {
                print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                if (!empty(Product::where("id",$users2->id_products)->first()   )       ) {
                
                $Action_plan = new Usee;
                $Action_plan->id = $users2->id;
                $Action_plan->id_users = $users2->id_users;
                $Action_plan->id_products = $users2->id_products;
                $Action_plan->date = $users2->date;
                $Action_plan->portion = $users2->portion;
                $Action_plan->price = $users2->price;
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = $users2->updated_at;
                $Action_plan->save();
                }
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });        
    }
    
     
            public function moods_action() {
        set_time_limit(0);
        DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from moods_actions");
            foreach ($users as $users2) {
                print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                //if (!empty(Product::where("id",$users2->id_products)->first()   )       ) {
                
                $Action_plan = new Moods_action;
                
                $Action_plan->id_actions = $users2->id_actions;
                $Action_plan->id_moods = $users2->id_moods;
                $Action_plan->percent_executing = $users2->percent_executing2;
               
               
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = $users2->updated_at;
                $Action_plan->save();
                //}
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });        
    }
    
    
    
            public function sleep() {
        set_time_limit(0);
        DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from sleeps");
            foreach ($users as $users2) {
                print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                //if (!empty(Product::where("id",$users2->id_products)->first()   )       ) {
                
                $Action_plan = new Mood;
                
                $Action_plan->id_users = $users2->id_users;
                
                $Action_plan->date_start = $users2->date_start;
                $Action_plan->date_end = $users2->date_end;
      
                if ($users2->how_wake_up == "") {
                    $Action_plan->epizodes_psychotik = 0;
                }
                else {
                $Action_plan->epizodes_psychotik = $users2->how_wake_up;
                }
                
                $Action_plan->type = "sleep";
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = $users2->updated_at;
                $Action_plan->save();
                //}
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });        
    }
    
        public function moods() {
        set_time_limit(0);
        DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from moods");
            foreach ($users as $users2) {
                print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                //if (!empty(Product::where("id",$users2->id_products)->first()   )       ) {
                
                $Action_plan = new Mood;
                $Action_plan->id = $users2->id;
                $Action_plan->id_users = $users2->id_users;
                
                $Action_plan->date_start = $users2->date_start;
                $Action_plan->date_end = $users2->date_end;
                $Action_plan->level_mood = $users2->level_mood;
                $Action_plan->level_anxiety = $users2->level_anxiety;
                $Action_plan->level_nervousness = $users2->level_nervousness;
                $Action_plan->level_stimulation = $users2->level_stimulation;
                if ($users2->epizodes_psychotik == "") {
                    $Action_plan->epizodes_psychotik = 0;
                }
                else {
                $Action_plan->epizodes_psychotik = $users2->epizodes_psychotik;
                }
                $Action_plan->what_work = $users2->what_work;
                $Action_plan->type = "mood";
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = $users2->updated_at;
                $Action_plan->save();
                //}
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });        
    }
    public function tableActionPlans() {
        DB::transaction(function () {
            $users = DB::connection('mysql2')->select("select * from actions_plans");
            foreach ($users as $users2) {
                print $users2->updated_at ;
//                $array = explode(" ",$users2->created_at);
//                $date = $users2->date . " " . $array[1];
                
                $Action_plan = new Action_plan;
                $Action_plan->id = $users2->id;
                $Action_plan->id_users = $users2->id_users;
                $Action_plan->id_actions = $users2->id_actions;
                $Action_plan->date = $users2->date_start;
                $Action_plan->long = $users2->long;
                $Action_plan->created_at = $users2->created_at;
                $Action_plan->updated_at = $users2->updated_at;
                $Action_plan->save();
                
                
//                 DB::insert("insert into actions_plans(id,id_users,id_actions,date,long,created_at,updated_at)  values('"
//                         . $users2->id .  "'," . 
//                        "'" . $users2->id_users .  "'," . 
//                        "'" . $users2->id_actions .   "'," . 
//                        "'" . $users2->date_start .  "'," . 
//                        "'" . $users2->long .  "'," . 
//                        "'" . $users2->created_at .  "'," . 
//                        "'" . $users2->updated_at .  "')" 
//                         
//                        );
            }
        });
    }
    public function tableUsers() {
//        Schema::connection('mysql2')->create('posts', function (Blueprint $table) {
//                $table->id();
//                $table->string('title');
//                $table->timestamps();
//            });
            DB::transaction(function () {
                $users = DB::connection('mysql2')->select("select * from users");
                foreach ($users as $users2) {
                    print $users2->id . "<br>";
                    //if ($users2->login != "") {
                    DB::insert("insert into users("
                            . "id,"
                           
                            . "name,"
                            . "email,"
                            . "if_true,"
                            . "type,"
                            . "email_verified_at,"
                            . "password,"
                            . "start_day,"
                            . "minutes,"
                            . "hash,"
                          
                            . "login2,"
                            . "id_user,"
                            . "level_mood_10,"
                            . "level_mood_9,"
                            . "level_mood_8,"
                            . "level_mood_7,"
                            . "level_mood_6,"
                            . "level_mood_5,"
                            . "level_mood_4,"
                            . "level_mood_3,"
                            . "level_mood_2,"
                            . "level_mood_1,"
                            . "level_mood0,"
                            . "level_mood1,"
                            . "level_mood2,"
                            . "level_mood3,"
                            . "level_mood4,"
                            . "level_mood5,"
                            . "level_mood6,"
                            . "level_mood7,"
                            . "level_mood8,"
                            . "level_mood9,"
                            . "level_mood10,"
                            . "remember_token,"
                            . "created_at,"
                            . "updated_at) "
                            . "values ('" 
                            . $users2->id . "'"
                            
                            . ",'" . $users2->login . "',"
                            . "'" . $users2->email . "'"
                            . ",'" . $users2->if_true . "'"
                            . ",'" . $users2->type . "'"
                            . ",'" . $users2->email_verified_at . "'"
                            . ",'" . $users2->password . "'"
                            . ",'" . $users2->start_day . "'"
                            . ",'" . $users2->minutes . "'"
                            . ",'" . $users2->hash . "'"
                            
                            . ",'" . $users2->login2 . "'"
                            . ",'" . $users2->id_user . "'"
                            . ",'" . $users2->level_mood_10 . "'"
                            . ",'" . $users2->level_mood_9 . "'"
                            . ",'" . $users2->level_mood_8 . "'"
                            . ",'" . $users2->level_mood_7 . "'"
                            . ",'" . $users2->level_mood_6 . "'"
                            . ",'" . $users2->level_mood_5 . "'"
                            . ",'" . $users2->level_mood_4 . "'"
                            . ",'" . $users2->level_mood_3 . "'"
                            . ",'" . $users2->level_mood_2 . "'"
                            . ",'" . $users2->level_mood_1 . "'"
                            . ",'" . $users2->level_mood0 . "'"
                            . ",'" . $users2->level_mood1 . "'"
                            . ",'" . $users2->level_mood2 . "'"
                            . ",'" . $users2->level_mood3 . "'"
                            . ",'" . $users2->level_mood4 . "'"
                            . ",'" . $users2->level_mood5 . "'"
                            . ",'" . $users2->level_mood6 . "'"
                            . ",'" . $users2->level_mood7 . "'"
                            . ",'" . $users2->level_mood8 . "'"
                            . ",'" . $users2->level_mood9 . "'"
                            . ",'" . $users2->level_mood10 . "'"
                            . ",'" . $users2->remember_token . "'"
                            . ",'" . $users2->created_at . "'"
                            . ",'" . $users2->updated_at . "')");
                    //}
                }
                //$users = DB::connection('mysql2')->select("select * from users");
                //var_dump($users);
                
            });
    }
}
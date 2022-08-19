<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;



class AdminController extends Controller
{
       public function dashboardData(){
       $ticketData = DB::select('select * from tbl_grab_tickets order by id desc');
        return view("list",['ticketData'=>$ticketData]);
   }
   public function opendashboardData(){
       $ticketData = DB::select('select * from tbl_grab_tickets where status IN(1,2)order by id desc');
        return view("openlist_data",['ticketData'=>$ticketData]);
   }
   public function closedashboardData(){
       $ticketData = DB::select('select * from tbl_grab_tickets where status=0 order by id desc');
        return view("closelist_data",['ticketData'=>$ticketData]);
   }
   

}

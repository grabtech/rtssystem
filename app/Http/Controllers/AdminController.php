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
   

}

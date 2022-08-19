<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Mail\NotifyMail;
use App\Jobs\SendEmailJob;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Mail;

class AdminController extends Controller
{
    
    public function login(Request $request){
        $response = ["response"=>"success","error"=>""];
        return response()->json($response);
    }

    public function checkin(Request $request){
        $response = ["response"=>"failed","error"=>"102"];
        return response()->json($response);
    }

    public function createTicket(Request $request){
        // $request =json_encode(['headerreq'=>$request->header(),'files'=>$file]);
         //Log::channel('weblog')->info($request);
 
         // $validatedData = $request->validate([
         //     'file' => 'required|csv,txt,xlx,xls,pdf,zip,mp4,mp3',
         //    ]);
        
        
         $eid = $request->input('eid');
         $rider_name = $request->input('ridername');
         $App_version = $request->input('appversion');
         $phone_number = $request->input('phonenumber');
         $subject = $request->input('subject');
         $description = $request->input('description');
 
         $eid=isset($eid) ? $eid : 'G123';
         $rider_name = isset($rider_name) ? $rider_name : "TestRider";
         $App_version = isset($App_version) ? $App_version : "7.0.0.12";
         $phone_number= isset($phone_number) ? $phone_number : "8095533";
         $subject =isset($subject) ? $subject: "";
         $description = isset($description) ? $description :"";
         $ticketid=$eid.rand(1,10).time();
         
         $details =["title" =>"test mail", "mailbody"=>$ticketid,'ticketid'=>$ticketid,"App_version"=>$App_version,"eid"=>$eid,"subject" =>$subject,"description"=>$description];
         $file='';
         if(!empty($request->file())){
             $file = $request->file();
         }
         if(empty($file)){
             $response = ['status' => 'failed','error'=>'No files uploaded','ticketId'=>'','datetime'=>date('Y-m-d')];
             return response()->json($response);
         }
         foreach($file as $file){
             $filename = rand(10,200).time().'_'.$file->getClientOriginalName();
             $path = $file->storeAs('public/files',$filename);
             $attachments[] = 'D:\xampp\htdocs\rtssystem\storage\app\public\files'.DIRECTORY_SEPARATOR .$filename;
             $fileinsertdata[] = ['ticket_id'=>$ticketid,'filename'=>$filename,'file_path'=>$path];
         }
         $ticketinsertdata = ['ticket_id'=>$ticketid,'eid'=>$eid,'rider_name'=>$rider_name,'app_version'=>$App_version,'phone_no'=>$phone_number,'status'=>1];
         DB::table('tbl_grab_tickets')->insert($ticketinsertdata);
         DB::table('tbl_grab_files')->insert($fileinsertdata);
         //dispatch(new App\Jobs\SendEmailJob($details,$attachments));
         SendEmailJob::dispatch($details,$attachments);
         //Mail::to('bharatjogi.07@gmail.com')->send(new NotifyMail($details,$attachments));
         $response = ['status' => 'Success','error'=>'','ticketId'=>$ticketid,'datetime'=>date('Y-m-d')];
 
         $request =json_encode(['headerreq'=>$request->header(),'files'=>$attachments,'alldata'=>$request->all(),'response' =>$response]);
         Log::channel('weblog')->info($request);
         
         return response()->json($response);
        
     } 
    
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

    public function updateticketstatus(Request $request){
        $status = $request->status;
        $id = $request->id;
        $statusupdate = DB::table('tbl_grab_tickets')->where('id', $id)->update(['status' => $status]);
        $ticketData = DB::select('select * from tbl_grab_tickets where id=?',[$id]);
        if($ticketData[0]->status == 0){
         $this->riderNotify($ticketData);
        }
  
        $data = 'Status updated successfully';
        return response()->json(array(
         'success' => true,
         'msg'   => $data
       ));
     }

     function riderNotify($ticketData){
        $ticketid = $ticketData[0]->ticket_id;
        $riderName = $ticketData[0]->rider_name;
        $recipients = '+917977250352';
        $recipients = '+918660137088';
        $message    = 'Hi '."$riderName".',
                             Your ticket has been resolved!!. 
                             TicketId : '."$ticketid".'

                       Thanks,
                       Grab a Grub Services Pvt Ltd
                             ';
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, 
               ['from' => $twilio_number, 'body' => $message] );

        
        $calltext = "<Response><Say>Hi  ".$riderName."

                                  Your ticket number ".$ticketid." has been resolve

                                  Please check again

                              Thank You
                              Grab a Grub Services Pvt Ltd
                                  </Say></Response>";
                

        $call = $client->calls
               ->create($recipients, // to
                        "+19093421130", // from
                        [
                            "twiml" => $calltext
                        ]
               );


    }

    public function getfiledata($id){
        //$test = 'public/files/10_159177852_282441379938675_5556678584481918162_n.jpg';
     $ticketData = DB::select('select * from tbl_grab_files where id=?',[$id]);
     return Storage::download($ticketData[0]->file_path);
     //return Storage::download($ticketData[0]->file_path);
     //return  response()->download(public_path($ticketData[0]->file_path,'userimage')); 
    
    }


}

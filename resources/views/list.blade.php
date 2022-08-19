@extends('layouts.app')

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script> 
      <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
      <script src="{{url('/togglebtn/bootstrap-toggle.min.js')}}"></script> 
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
#selector select option {
 color: white;        
  position: relative;  
  top: 5px;
}

#selector {
  width: 10%;
  color:white;
}

select {
  -webkit-appearance: none;
  -moz-appearance: none;
  -o-appearance:none;
  appearance:none;
}

select.input-lg {
  //height: 50px !important;
  line-height:25px !important;
}

select + i.fa {
  float: right;
  margin-top: -32px;
  margin-right: 9px;
  
  pointer-events: none;
  
  background-color: #FFF
    padding-right: 5px;
}


</style>
    @section('content')
                 <main>
              
                    <div class="container-fluid px-4">

                    <div class='row'>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <h1 class="mt-4">Dashboard</h1>
                                </div>
                                <div class='col-lg-6 col-md-6 col-sm-6'>
                                <span style='padding:20px;float:right'>
                                    <div class="col" id="flash" hidden>
                                        <span class="alert alert-success" id="msg"></span>
                                    </div>
                                </span> 
                                </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Support Tickets Records
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>SI NO</th>
                                            <th>TicketId</th>
                                            <th>Eid</th>
                                            <th>Rider Name</th>
                                            <th>App Version</th>
                                            <th>Phone Number</th>
                                            <th>Subject</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $counter=0; ?>
                                    @foreach($ticketData as $ticketData)
                                        <tr>
                                            <td>{{++$counter}}</td>
                                            <td>{{$ticketData->ticket_id}}</td>
                                            <td>{{$ticketData->eid}}</td>
                                            <td>{{$ticketData->rider_name}}</td>
                                            <td>{{$ticketData->app_version}}</td>
                                            <td>{{$ticketData->phone_no}}</td>
                                            <td>{{$ticketData->subject}}</td>
                                            <td>{{$ticketData->description}}</td>
                                            <td>{{$ticketData->created_time}}</td>
                                            <td>
                                                <select id="{{$ticketData->id}}" class="form-control input-lg actiontext" onchange="updatestatus(this,'{{$ticketData->id}}')" style="color:white; <?php if($ticketData->status==1) { echo 'background:#b02a37 ;';} elseif($ticketData->status==0){ echo 'background: #146c43;';} else{echo 'background: #4682B4;';}?>" >
                                                    <option value='1' {{($ticketData->status)==1 ? 'selected' : ''}} >Active</option>
                                                    <option value='2' {{($ticketData->status)==2 ? 'selected' : ''}} >Inprogress</option>
                                                    <option value='0' {{($ticketData->status)==0 ? 'selected' : ''}} >Closed</option>
                                                </select>
                                            </td>
                                            <!-- <td><input type="checkbox" checked data-toggle="toggle" data-onstyle="danger"></td> -->
                                            <!-- <td><input  data-id="{{$ticketData->id}}" class="toggle-class" type="checkbox" data-onstyle="danger" data-offstyle="success" data-toggle="toggle" data-on="Open" data-off="Resolved" {{($ticketData->status) ? 'checked' : ''}} onclick="changeUserStatus(this, {{ $ticketData->id }});"></td> -->
                                            <!-- <td><input data-id="{{$ticketData->id}}" class="toggle-class" type="checkbox" data-onstyle="danger" data-offstyle="success" data-toggle="toggle" data-on="Open" data-off="Resolved" {{($ticketData->status) ? 'checked' : ''}}></td> -->
                                            <td><a href="/ticketview/{{$ticketData->ticket_id}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main> 

       

    @endsection
<script>
    function updatestatus(req,id){
        if(req.value == 1){
        $("#"+req.id).css('background', "#b02a37"); 
        } else if(req.value == 2){
            $("#"+req.id).css('background', '#4682B4'); 
        } else {
            $("#"+req.id).css('background', "#146c43"); 
        }

        var status = req.value;  
           $.ajax({ 
    
               type: "POST", 
               dataType: "json", 
               url: 'api/updatestatus', 
               data: {'status': status, 'id': id}, 
               success: function(data){ 
               //$("#flash").css("display", "block")
               $("#flash").attr("hidden",false);
               //alert-success
               $("#msg").fadeIn(1000);
                $("#msg").html(data.msg);
                $("#msg").fadeOut(2000);
            } 
         });
   
    }

//    $(function() { 
//            $('.toggle-class').change(function() { 
//            var status = $(this).prop('checked') == true ? 1 : 0;  
//            var id = $(this).data('id');  
//            console.log(id)
//            $.ajax({ 
    
//                type: "POST", 
//                dataType: "json", 
//                url: 'api/updatestatus', 
//                data: {'status': status, 'id': id}, 
//                success: function(data){ 
//               //s $("#flash").css("display", "block")
//                $("#msg").fadeIn(1000);
//                 $("#msg").html(data.msg);
//                 $("#msg").fadeOut(1000);
//             } 
//          }); 
//       }) 
//    }); 

   function getticketfiles(ticket_id){
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $.ajax({ 
        type: "POST", 
        dataType: "json", 
        url: 'api/getfilesdata', 
        data: {'ticket_id': ticket_id}, 
        success: function(data){ 
            var result = data;
            //for(var k=0 ;k <result.length;k++){
                //var ticketid = result[k]['filename'];
                //var file_path = result[k]['file_path'];
                $(".modal-body").html(result);
            //}
           // console.log(result);
        $('#myModal').modal('show'); 

        } 
        }); 

    
   }

//    function changeUserStatus(data,id){
//     var status = data.checked == true ? 1 : 0;  
//            $.ajax({ 
    
//                type: "POST", 
//                dataType: "json", 
//                url: 'api/updatestatus', 
//                data: {'status': status, 'id': id}, 
//                success: function(data){ 
//                $("#flash").css("display", "block")
//                $("#msg").fadeIn(1000);
//                 $("#msg").html(data.msg);
//                 $("#msg").fadeOut(2000);
//             } 
//          });
   
//    }




</script>
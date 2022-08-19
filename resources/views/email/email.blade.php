<!DOCTYPE html>
<html>
<head>
 <title>TechSupport - {{$data['ticketid']}}}</title>
</head>
<body>
 
 <h2 style='color:red'>Auto Generated Tech Support Mail</h2>
 <p> Please look into following issue and update the status on dashboard</p>


<ul>
  <li>TicketID - <span style='color:blue;font-wieght:bold'>{{$data['ticketid']}}</span></li>
  <li>RiderId - <span style='color:blue;font-wieght:bold'>{{$data['eid']}}</span></li>
  <li>AppVersion - <span style='color:blue;font-wieght:bold'>{{$data['App_version']}}</span></li>
</ul>


 
</body>
</html> 
<div>
<style>
          body{
            font-family: 'Montserrat', sans-serif;
        }
        input::placeholder {
    color: #ccc; /* Change this to the desired color */
}
        .detail-container {
        display: flex;
        flex-direction: column;
        width: 100%;
        gap: 10px;
        padding: 5px;
        background-color: none;
    }
    .detail1-container
    {
        display: flex;
        flex-direction: column;
        width: 100%;
        gap: 10px;
        padding: 5px;
        background-color: none;
    }
          .approved-leave{
            display: flex;
        flex-direction: row;
        width: 100%;
        gap: 10px;
        padding: 5px;
        background-color: none;
          }
 
    .heading {
    flex: 8; /* Adjust the flex value to control the size of the heading container */
    padding: 20px;
    width: 100%;
    background: #fff;
    border: 1px solid #ccc;
    border-radius:5px;
}
 
.side-container {
    flex: 4; /* Adjust the flex value to control the size of the side container */
    background-color: #fff;
    text-align: center;
    padding: 20px;
    height: 230px;
    border-radius:5px;
    border:1px solid #dcdcdc;
}
   
        .view-container{
            border:1px solid #ccc;
            background:#ffffe8;
            display:flex;
            width:80%;
            padding:5px 10px;
            border-radius:5px;
            height:auto;
        }
        .middle-container{
            background:#fff;
            display:flex;
            flex-direction:row;
            justify-content:space-between;
            margin:0.975rem auto;
        }
 
        .field {
            display: flex;
            justify-content: start;
            flex-direction: column;
        }
 
        .pay-bal  {
         display:flex;
         gap:10px;
        }
 
        .details {
       
            line-height:2;
        }
 
        .details p {
            margin: 0;
        }
        .vertical-line {
            width: 1px; /* Width of the vertical line */
            height: 70px; /* Height of the vertical line */
            background-color: #ccc;
            margin-left:-10px; /* Color of the vertical line */
        }
        .tooltip-container {
        position: relative;
    }
    .tooltip-text {
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 2px;
        white-space: nowrap;
    
    }
   
    .tooltip-text:hover::after {
    content: attr(data-tooltip);
    font-weight: bold;
    position: absolute;
    background-color: #f2f2f2;
    border: 1px solid black;
    padding: 10px;
    z-index: 1;
    width: 200px;
    top: calc(100% + 10px); /* Position below the tooltip-text */
    left: 50%; /* Position in the center horizontally */
    transform: translateX(-50%); /* Center horizontally */
    border-radius: 8px; /* Rounded corners */
    clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%); /* Square shape */
}



    
        .group h6{
            font-weight:600;
            font-size:0.875rem;
        }
        .table-container
        {
            width: auto;
            height:auto;
            background-color: #fff;
            margin-left:10px;
            border-radius: 5px;
            border:1px solid #ccc;
            display: flex;
        }
        .group h5{
            font-weight: 400;
            font-size: 1rem;
            white-space: nowrap; /* Prevent text from wrapping */
            overflow: hidden; /* Hide overflowing text */
            text-overflow: ellipsis;
            margin-top:0.975rem;
        }
        .group {
            margin-left:10px;
        }
     
        .data{
            display:flex;
            flex-direction:column;
   
        }
        .cirlce{
            height:0.75rem; width:0.75rem; background: #778899; border-radius:50%;
        }
        .v-line{
            height:100px; width:0.5px; background: #778899; border-right:1px solid #778899; margin-left:5px;
        }
        table {
        width: 75%;
        border-collapse: collapse;
    }
    th, td {
        border-bottom: 1px solid #dcdcdc; /* Change the color and style as needed */
        padding: 4px;  /* Adjust padding as needed */
        text-align:  left;/* Adjust text alignment as needed */
        font-weight: 200;
    }
    td{
        text-align: left;
    }
    th {
        background-color: #f3faff;
        font-size: 12px;
        text-align: left; /* Center align column headers */
    }
    .overflow-cell {
        max-width: 70px; /* Adjust the maximum width of the cell */
        white-space: nowrap; /* Prevent text wrapping */
        overflow: hidden; /* Hide overflow text */
        text-overflow: ellipsis; /* Display an ellipsis (...) when text overflows */
    }
    td{
        font-size: 14px;
    }
        .leave{
            display:flex; flex-direction:row; gap:50px; background:#fff;
            border-bottom:1px solid #ccc;padding-bottom:10px;
        }
        @media screen and (max-width: 1060px) {
           .detail-container{
            width:100%;
            display:flex;
            flex-direction:column;
           }
           .heading {
        flex: 1; /* Change the flex value for the heading container */
        padding: 10px; /* Modify padding as needed */
        width: 100%;
    }
 
    .side-container {
        flex: 1; /* Change the flex value for the side container */
        padding: 10px; /* Modify padding as needed */
        height: auto;
        width: 100%;/* Allow the height to adjust based on content */
    }
    

}
    </style>
     <div class="row m-0 p-0">
            <div class="col-md-4 p-0 m-0 mb-2 ">
                <div aria-label="breadcrumb bg-none">
                    <ol class="breadcrumb d-flex align-items-center ">
                        <li class="breadcrumb-item"><a type="button" style="color:#fff !important;" class="submit-btn" href="{{ route('review') }}">Back</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Regularisation - View Details</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="headers-details">
            <h6>Regularisation Applied on {{ $regularisationrequest->created_at->format('d M, Y') }} </h6>
        </div>
    <div class="detail-container">
        
        <div class="approved-leave d-flex gap-3">
            <div class="heading mb-3">
                <div class="heading-2" >
                    <div class="d-flex flex-row justify-content-between rounded">
                    <div class="field">
                               
                                        <span style="color: #778899; font-size: 12px; font-weight: 500;">
                                            Applied by
                                        </span>
                               
                                      
                           
                                
                               
                                  
                                        <span style="color: #333; font-weight: 500;font-size:12px;">
                                            {{ucwords(strtolower($employeeDetails->first_name))}}&nbsp;&nbsp;{{ucwords(strtolower($employeeDetails->last_name))}}
                                        </span>
                                   
                                       
                                 
                        </div>
 
                     <div>
                        <span style="color: #32CD32; font-size: 12px; font-weight: 500; text-transform:uppercase;">
                      
                                @if($regularisationrequest->status==3)
                                    <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#f66;text-transform:uppercase;">{{$regularisationrequest->status_name}}</span>
                                @elseif($regularisationrequest->status==2)
                                    <span style="margin-top:0.625rem; font-size: 12px; font-weight: 500; color:#32CD32;text-transform:uppercase;">{{$regularisationrequest->status_name}}</span>
                                @endif    
                        </span>
                   </div>
                </div>
            <div class="middle-container">
                <div class="view-container m-0 p-0">
                     <div class="first-col" style="display:flex; gap:40px;">
                            <div class="field p-2">
                                <span style="color: #778899; font-size:11px; font-weight: 500;">Remarks</span><br>
                                @if(empty($regularisationrequest->employee_remarks))
                                   <span style="font-size: 12px; font-weight: 600;text-align:center;">-</span>
                                @else
                                  <span style="font-size: 12px; font-weight: 600;text-align:center;">{{$regularisationrequest->employee_remarks}}</span>
                                @endif
                            </div>
                           
                            <div class="vertical-line"></div>
                         </div>
                         <div class="box" style="display:flex;  margin-left:30px;  text-align:center; padding:5px;">
                            <div class="field p-2">
                                <span style="color: #778899; font-size:10px; font-weight: 500;">No. of days</span>
                                <span style=" font-size: 12px; font-weight: 600;">{{$totalEntries}}</span>
                            </div>
                        </div>
                     </div>
                 </div>
              </div>
 
        
        </div>
        <div class="side-container mx-2 ">
            <h6 style="color: #778899; font-size: 12px; font-weight: 500; text-align:start;"> Application Timeline </h6>
           <div  style="display:flex; ">
           <div style="margin-top:20px;">
             <div class="cirlce"></div>
             <div class="v-line"></div>
              <div class=cirlce></div>
            </div>
              <div style="display:flex; flex-direction:column; gap:60px;">
              <div class="group">
              <div style="padding-top:5px;">
                <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">
                      
                             Pending<br><span style="color: #778899; font-size: 12px; font-weight: 400; text-align:start;">with</span>
                      
                           
                           <span style="color: #778899; font-weight: 500;">
                               {{ucwords(strtolower($ManagerName->first_name))}}&nbsp;{{ucwords(strtolower($ManagerName->last_name))}}
                           </span><br>
                         
                    <br>
                    
                </h5>
            </div>
 
           </div>
           <div class="group">
               <div  style="padding-top:-20px;margin-top:-15px;">
                  <h5 style="color: #333; font-size: 12px; font-weight: 400; text-align:start;">Submitted<br>
                          <span style="color: #778899; font-size: 11px; font-weight: 400;text-align:start;">
                                    
                                    
                          @if(\Carbon\Carbon::parse($regularisationrequest->created_at)->isToday())
                                                       Today
                                          @elseif(\Carbon\Carbon::parse($regularisationrequest->created_at)->isYesterday())
                                                      Yesterday
                                          @else
                                               {{ \Carbon\Carbon::parse($regularisationrequest->created_at)->format('jS M, Y') }}
 
                                          @endif
                                          &nbsp;&nbsp;&nbsp;
                                              {{ \Carbon\Carbon::parse($regularisationrequest->created_at)->format('h:i A') }}
                          </span>
                    </h5>
               </div>
           </div>
              </div>
           
           </div>
             
        </div>
        </div>
    </div>
  
  <div class="table-container table-responsive">
        <table style=" width: 50%;height:60%"> 
              <thead style="height:40%;background-color:white">
                    <tr>
                        <th style="font-weight:700;color:#778899;padding: 12px;">Dates Applied for Regularisation</th>
                        <th></th>
                        <th style="border-right:1px solid #dcdcdc;"></th>
                    </tr>
                </thead>
                <thead style="height:40%;">
                    <tr>
                        <th style="padding: 8px;">Date</th>
                        <th>Approve/Reject</th>
                        <th style="border-right:1px solid #dcdcdc;">Approver&nbsp;Remarks</th>
                    </tr>
                </thead>
                @foreach($regularisationEntries  as $r1)
                <tbody class="regularisationEntries"style="height:50%;">
                        
                        <td style="padding: 8px;">{{ \Carbon\Carbon::parse($r1['date'])->format('d M, Y') }}</td>
                           
                               <td >
                                  <div style="display: flex; align-items: center;">
                                    
                                       <i class="fa-regular fa-circle-check"style="color:lightgreen;margin-right: 5px;height:20px;width:20px;cursor:pointer;"wire:click="approve('{{$r1['date']}}')"></i>
                                       <i class="fa-regular fa-circle-xmark"style="color:#ccc;height:20px;width:20px;cursor:pointer;"wire:click="reject('{{$r1['date']}}')"></i>
                                     
                                  </div>
                               </td>
                          
                         
                               <td style="border-right: 1px solid #dcdcdc;">
                                        <input type="text" placeholder="Write Remarks" 
                                            style="border: 1px solid #ccc; border-radius:5px; color: #666;"
                                            wire:model.defer="remarks.{{ $r1['date'] }}">
                               </td>

                     
                </tbody>
                @endforeach
        </table>
    
     <table style="width: 50%;height:68%">
           <thead style="height:40%;">
                <tr>
                     <th style="padding: 8px;"></th>
                     <th></th>
                     <th></th>
                     <th></th>
                </tr>
            </thead> 
        
        <thead style="height:30%;margin:2px;">
                    <tr>
                        <th>Shift</th>
                        <th>First In Time</th>
                        <th>Last Out Time</th>
                        <th style="border-right:1px solid #dcdcdc;">Reason</th>
                    </tr>
                </thead>
         
            
        @foreach($regularisationEntries as $r1)
        <tbody class="regularisationEntries">
                
                
                <td style="white-space:nowrap;">10:00 am to 07:00 pm</td>
                <td>
                      
                       @if(empty($r1['from']))
                            10:00
                       @else
                            {{ $r1['from'] }}
                       @endif
                      
                </td>
                <td>
                       
                       @if(empty($r1['to']))
                            19:00
                       @else
                            {{ $r1['to'] }}
                       @endif
                       
                </td>
                <td class="tooltip-container" style="max-width: 10px; border-right: 1px solid #dcdcdc;">
                            <span class="tooltip-text" style="display: inline-block; max-width: 100%; overflow: hidden; text-overflow: ellipsis;"data-tooltip="{{$r1['reason']}}">{{$r1['reason']}}</span>
                </td>
        </tbody>
        @endforeach
    </table>
   
  </div>
  
                <div style="display:flex; justify-content: right;">
                    
                    <a style="color:rgb(2,17,79); margin-right: 20px; padding: 10px 20px;"href="{{ route('review') }}">Cancel</a>
                    <button type="button"style="margin-right: 20px;color: #fff; border:1px solid rgb(2,17,79); background: rgb(2,17,79); border-radius:5px; padding: 10px 20px;"wire:click="rejectAll('{{$regularisationrequest->id}}')">Reject All</button>
                    <button type="button" style="margin-right: 20px;color: #fff; border:1px solid rgb(2,17,79); background: rgb(2,17,79); border-radius:5px; padding: 10px 20px;"wire:click="submitRegularisation">Submit</button>
                </div>
  

</div>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            line-height: 1.6;
            color: #333;
        }

        .content {
            margin: 20px;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.8em;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="content">
    
            <p>Hi  <strong>   
    
 </strong>,{{ ucwords(strtolower($firstName ))}} {{ ucwords(strtolower($lastName ))}}
</p>

            <p>You got a new request <strong> {{ $RequestId }} </strong> from  <b> {{ $createdbyFirstName }} {{ $createdbyLastName }}</b> ({{ $employeeId }})</p>
 
        
        <p>Below are the New Request details:</p>
        <b style="text-decoration:underline">{{ $helpDesk->category }}</b>
        
        <ul>

          
        <strong>Employee ID:</strong> {{ $helpDesk->emp_id }}<br>
<strong>Subject:</strong> {{ $helpDesk->subject }}<br>
<strong>Description:</strong> {{ $helpDesk->description }}<br>
<strong>Priority:</strong> {{ $helpDesk->priority }}<br>

        </ul>

     
            <p><a href="https://s6.payg-india.com/HelpDesk">Click here</a>  View Request .</p>
           
    
    </div>
<p>Thank You</p>
    <div class="footer">
        <p>Note: This is an auto-generated email. Please do not reply.</p>
        <p>PS: "This e-mail is generated from info@s6.payg-india.com"</p>
    </div>
</body>

</html>

<!DOCTYPE html>
<html>
<head>
    <title>Regularization Approval Mail</title>
</head>
<body>

    <h1>Regularization  Mail</h1>
    <p>Your regularization request has been mentioned for the following dates.</p>
    
    <div style="margin-bottom: 20px;">
        <table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="width:10%; padding:5px; text-align:center;">Employee ID</th>
                    <th style="width:15%; padding:5px; text-align:center;">Date</th>
                    <th style="width:10%; padding:5px; text-align:center;">From</th>
                    <th style="width:10%; padding:5px; text-align:center;">To</th>
                    <th style="width:55%; padding:10px; text-align:center;">Reason</th>
                    <th style="width:55%; padding:10px; text-align:center;">Status</th>
                    <th style="width:55%; padding:10px; text-align:center;">Approver Remarks</th>
                    <th style="width:55%; padding:10px; text-align:center;">Employee Remarks</th>
                </tr>
             
            </thead>
            <tbody>
            @if(!empty($details['regularisationRequests']) && is_array($details['regularisationRequests']))
                    @foreach($details['regularisationRequests'] as $entry)
                        <tr>
                            <td style="text-align:center; padding:5px;">{{ $details['sender_id']}}</td>
                            <td style="text-align:center; padding:5px;"> {{ \Carbon\Carbon::parse($entry['date'])->format('jS M, Y') }} </td>
                            <td style="text-align:center; padding:5px;">{{ htmlspecialchars($entry['from']) }}</td>
                            <td style="text-align:center; padding:5px;">{{ htmlspecialchars($entry['to']) }}</td>
                            <td style="text-align:center; padding:10px;">{{ htmlspecialchars($entry['reason']) }}</td>
                            <td style="text-align:center; padding:10px;">{{ ucwords(strtolower(htmlspecialchars($entry['status']))) }}</td>
                            <td style="text-align:center; padding:10px;">{{ htmlspecialchars($entry['remark']) }}</td>
                            <td style="text-align:center; padding:10px;">{{ htmlspecialchars($details['employee_remarks']) }}</td>
                        </tr>
                    @endforeach
                  
            @else
                <tr>
                    <td colspan="5">No regularisation entries available.</td>
                </tr>
            @endif
        
            </tbody>
            </table>
            <p style="font-size: 12px; color: gray; margin-top: 20px;">
                   <strong>Note:</strong> This is an auto-generated mail. Please do not reply.
            </p>
            </div>
</body>
</html>

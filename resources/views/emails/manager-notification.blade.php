<!DOCTYPE html>
<html>
<head>
    <title>Manager Notification</title>
</head>
<body>
    <h1>Notification Regarding Regularization</h1>
    <p>{{ $details['message'] }}</p>
    <p>From: {{ $details['sender_name'] }}</p>
    <div style="margin-bottom: 20px;">
        <table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Date</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Reason</th>
                </tr>
                
            </thead>
            <tbody>
            @if(!empty($details['regularisationRequests']) && is_array($details['regularisationRequests']))
                    @foreach($details['regularisationRequests'] as $entry)
                        <tr>
                            <td class="text-center">{{ $details['sender_id']}}</td>
                            <td class="text-center"> {{ \Carbon\Carbon::parse($entry['date'])->format('jS M, Y') }} </td>
                            <td class="text-center">{{ htmlspecialchars($entry['from']) }}</td>
                            <td class="text-center">{{ htmlspecialchars($entry['to']) }}</td>
                            <td class="text-center">{{ htmlspecialchars($entry['reason']) }}</td>
                        </tr>
                    @endforeach
                    
            @else
                <tr>
                    <td colspan="5">No regularisation entries available.</td>
                </tr>
            @endif
            </tbody>
            </table>
            </div>
</body>
</html>

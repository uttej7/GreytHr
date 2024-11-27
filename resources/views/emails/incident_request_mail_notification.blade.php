<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Incident Request Created</title>
    <style>
        .headings{
            color: #333;
            font-size: 14px;
            font-weight: 500;
        }
        .value{
            font-size: 14px;
            color: #000;
            font-weight: normal;
        }
        .reciverName{
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <p>Hi, <span class="reciverName"> {{ ucwords(strtolower($firstName ))}} {{ ucwords(strtolower($lastName ))}}</span></p>

    <p>You got a new incident request <strong>{{ $incidentRequest->snow_id }}</strong> from <b>{{ $createdbyFirstName }} {{ $createdbyLastName }}</b> ({{ $employeeId }}) </p>

    <p class="headings">Short Description: <span class="value">{{ $short_description }}</span></p>
    <p class="headings">Description: <span class="value">{{ $description }}</span> </p>
    <p class="headings">Priority: <span class="value">{{ $priority }}</span> </p>

    <p>Thank you,<br>Service Desk Team</p>

    <p>Note: This is an auto-generated mail. Please do not reply.</p>
    <p>PS: "This e-mail is generated from info@s6.payg-india.com"</p>
</body>
</html>

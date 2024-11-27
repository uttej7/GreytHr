<div>
    <style>
        .button-container {
            display: flex;
            justify-content: center;
            /* margin-right: 250px; */
            /* Adjust as needed for alignment */
        }

        .rotate-arrow {
            transform: rotate(90deg);
            transition: transform 0.3s ease;
            /* Add a smooth transition effect */
        }

        .activeBtn {
            color: #fff !important;
            background-color: #02114f !important;
        }

        .my-button {
            margin: 0px;
            font-size: 0.8rem;
            background-color: #FFFFFF;
            border: 1px solid #a3b2c7;
            /* font-size: 20px;
        height: 50px; */
            padding: 8px 30px;
        }

        .mother-box {
            border: 1px solid #ccc;
            /* Add a 1px solid gray border */
            padding: 20px;
            /* Add some padding for better visual appearance */
            display: flex;
            /* Add this to center the content */
            align-items: center;
            /* Align the content vertically */
        }


        .horizontal-line-attendance-info {
            width: 100%;
            /* Set the width to the desired value */
            border-top: 1px solid #000;
            /* You can adjust the color and thickness */
            margin: 0px 0;
            /* Adjust the margin as needed */
        }

        .horizontal-line1-attendance-info {
            width: 100%;
            /* Set the width to the desired value */
            border-top: 1px solid #000;
            /* You can adjust the color and thickness */
            margin: 0px 0;
            /* Adjust the margin as needed */
        }


        .history-button {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .apply-button {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            transition: border-color 0.3s, color 0.3s;
            /* Smooth transition effect */
        }

        .apply-button:hover {
            border-color: rgb(2, 17, 79);
            /* Change the border color to green on hover */
            color: rgb(2, 17, 79);
            /* Change the text color to green on hover */
        }

        .pending-button:hover {
            border-color: rgb(2, 17, 79);
            /* Change the border color to green on hover */
            color: rgb(2, 17, 79);
            /* Change the text color to green on hover */
        }

        .history-button:hover {
            border-color: rgb(2, 17, 79);
            /* Change the border color to green on hover */
            color: rgb(2, 17, 79);
            /* Change the text color to green on hover */
        }

        .apply-button:active {
            background-color: rgb(2, 17, 79);
            /* Change background color to green when clicked */
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
            /* Change text color to white when clicked */
        }

        .pending-button:active {
            background-color: rgb(2, 17, 79);
            /* Change background color to green when clicked */
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
            /* Change text color to white when clicked */
        }

        .history-button:active {
            background-color: rgb(2, 17, 79);
            /* Change background color to green when clicked */
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
            /* Change text color to white when clicked */
        }

        .calendar {
            max-width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            background-color: #ffff;
            margin-right: 20px;
            /* Add spacing between calendar and content */
        }

        /* Styles for the calendar header */
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 8px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        /* Styles for the navigation buttons */

        #prevMonth,
        #nextMonth {


            cursor: pointer;
            font-size: 14px;
            /* Reduce font size */
            padding: 2px 5px;
            /* Reduce padding */
        }

        #currentMonth {
            font-size: 18px;
        }



        .calendar-weekdays {
            display: flex;
            justify-content: space-between;
            background-color: white;
            color: #7f8fa4;
            text-transform: uppercase;
            padding: 3px 0;
            /* Adjust the padding */
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }

        .approve-button {
            background-color: rgb(2, 17, 79);
            color: white;
            /* White text */
            padding: 10px 20px;
            /* Padding around the text */
            border: none;
            /* No border */
            cursor: pointer;
            /* Cursor style on hover */
            border-radius: 5px;
            /* Rounded corners */
        }

        .reject-button {
            background-color: rgb(2, 17, 79);
            color: white;
            /* White text */
            padding: 10px 20px;
            /* Padding around the text */
            border: none;
            /* No border */
            cursor: pointer;
            /* Cursor style on hover */
            border-radius: 5px;
            /* Rounded corners */
        }

        .weekday {
            text-align: center;
            flex: 1;
            /* padding: 5px; */
            font-weight: 600;
            font-size: 10px;
            margin: 0;
            /* Reset margin */
        }

        /* Style for the Submit button */
        #submitButton {
            background-color: rgb(2, 17, 79);
            color: white;
            /* White text */
            padding: 10px 20px;
            /* Padding around the text */
            border: none;
            /* No border */
            cursor: pointer;
            /* Cursor style on hover */
            border-radius: 5px;
            /* Rounded corners */
        }

        /* Style for the Cancel button */
        #cancelButton {
            /* Red background */
            color: rgb(2, 17, 79);
            /* White text */
            padding: 10px 20px;
            /* Padding around the text */
            border: none;
            /* No border */
            cursor: pointer;
            /* Cursor style on hover */
            border-radius: 5px;
            /* Rounded corners */
            margin-left: 10px;
            /* Add some spacing between buttons */
        }

        /* Hover effect for buttons */
        #submitButton:hover,
        #cancelButton:hover {
            opacity: 0.8;
            /* Reduced opacity on hover */
        }

        /* Styles for the calendar dates */
        .calendar-dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
            padding: 5px;
            justify-items: center;
            /* Center the date elements both horizontally and vertically */
        }

        .accordion {

            border: 0.0625rem solid #ccc;

            margin-bottom: 0.625rem;

            width: 100%;

            margin: 0 auto;

        }

        .down-arrow-reg {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 10px solid transparent;
            border-bottom: 10px solid #f09541;
            margin-right: 5px;
        }



        .accordion:hover {

            border: 0.0625rem solid #3a9efd;

        }

        .accordion-heading {

            background-color: white;

            cursor: pointer;

        }



        .accordion-body {

            display: none;
            width: 100%;

        }





        .calendar-box {

            /* margin-left: 50px;
        margin-top: 120px; */
            background-color: white;
            border-radius: 10px;
            border: 1px solid #ccc;


        }

        .nav1-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
        }

        .nav1-text {
            margin: 0 10px;
            font-weight: bold;
            font-size: 16px;
        }

        #infoBox {
            display: none;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: absolute;
            margin-top: 230px;
            left: 56%;
            height: 320px;
            width: 400px;
            transform: translate(-50%, -50%);
            z-index: 999;
            /* Ensure it appears on top of other content */
        }

        .calendar-date-info {
            margin: 10px 0;
            font-size: 18px;
            font-weight: 400;
        }

        #selectedDate {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
        }


        .hidden-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            /* margin-top: 300px; */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            /* position: absolute;
        top: 80%;
        left: 67%;
        height: 400px;
        width: 600px; */
            /* transform: translate(-50%, -50%); */
        }

        .apply-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            /* margin-top: 300px; */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            /* position: absolute;
        top: 80%;
        left: 67%;
        height: 400px;
        width: 600px; */
            /* transform: translate(-50%, -50%); */
        }

        .history:hover {
            border: 1px solid rgb(2, 17, 79);

        }

        .hidden-pending-box {

            background-color: #fff;
            margin-top: 200px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-left: 500px;
            position: absolute;
            height: 320px;
            width: 900px;
            transform: translate(-50%, -50%);
        }

        .history-box {

            background-color: #fff;
            margin-top: 200px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-left: 550px;
            position: absolute;
            height: 320px;
            width: 900px;
            transform: translate(-50%, -50%);
        }

        .hidden-pending-box1 {
            display: none;

            margin-top: 300px;
            padding: 20px;
            border-radius: 5px;

            text-align: center;
            margin-left: 30px;
            position: absolute;
            top: 50%;
            left: 50%;
            height: 320px;
            width: 900px;
            transform: translate(-50%, -50%);
        }

        .calendar-date:hover::before {

            font-size: 20px;
            display: block;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }


        /* Styles for the selected option container */
        .custom-dropdown {
            width: 300px;
            position: relative;
        }

        /* Styles for the selected option container */
        .selected-option {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Styles for the manager image */
        .manager-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Styles for the dropdown options */
        .dropdown-options {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0 0 5px 5px;
            z-index: 1;
        }

        .horizontal-line {
            position: absolute;
            width: 942px;
            margin-left: -10px;
            /* Make the line stretch across the container */
            height: 1px;
            /* Adjust the line thickness as needed */
            background-color: #7f8fa4;
            /* Line color */
            margin-top: 10px;
            /* Position the line vertically at the middle */
            transform: translateY(-50%);
            /* Adjust for vertical alignment */
        }

        .horizontal-line1 {
            position: absolute;
            width: 500px;
            margin-left: -10px;
            /* Make the line stretch across the container */
            height: 1px;
            /* Adjust the line thickness as needed */
            background-color: #7f8fa4;
            /* Line color */
            margin-top: 10px;
            /* Position the line vertically at the middle */
            transform: translateY(-50%);
        }

        .horizontal-line2 {
            position: absolute;
            width: 859px;
            margin-left: -10px;
            /* Make the line stretch across the container */
            height: 1px;
            /* Adjust the line thickness as needed */
            background-color: #7f8fa4;
            /* Line color */
            margin-top: 10px;
            /* Position the line vertically at the middle */
            transform: translateY(-50%);
        }

        /* Show the options when the selected option is clicked */
        .custom-dropdown.open .dropdown-options {
            display: block;
        }

        .history {
            border-radius: 5px;
        }

        .history:hover {
            border: 1px solid rgb(2, 17, 79);
        }

        .container-body1:hover {
            border: 1px solid rgb(2, 17, 79);
        }

        .hidden-history-box {


            margin-top: 280px;
            padding: 20px;
            border-radius: 5px;

            text-align: center;
            margin-left: 30px;
            position: absolute;
            top: 50%;
            left: 50%;
            height: 320px;
            width: 900px;
            transform: translate(-50%, -50%);
        }


        .my-button.active-button {
            background-color: rgb(2, 17, 79);
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
        }

        .calendar-date-info table {
            border-collapse: separate;
            border-spacing: 10px;
            /* Adjust the spacing as needed */
        }

        table {
            border-collapse: collapse;
            width: 75%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            border: none;
            /* Remove border for table headers */
        }


        /* Style for table header cells (th) */
        .calendar-date-info th {
            padding: 8px;
            /* Adjust the padding as needed */
            background-color: #f2f2f2;
            margin-left: -30px;
        }

        /* Restyle the active button on hover */
        .my-button.active-button:hover {
            background-color: rgb(2, 17, 79);
            color: #FFFFFF;
            border-color: rgb(2, 17, 79);
        }

        .calendar-footer {
            text-align: center;
            background: rgb(2, 17, 79);
            /* Blue background color */
            color: #fff;
            /* White text color */
            padding: 8px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .arrow-button::after {
            content: "\25B6";
            /* Unicode character for right-pointing triangle (arrow) */
            font-size: 18px;

        }

        .custom-view-details-button {
            background-color: transparent;
            /* Add other styles as needed */
        }

        #closeButton {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        .current-date {
            background-color: #007bff;
            color: #fff;
            border-radius: 50%;
            /* Make it circular */
            /* padding: 3px 3px; */
            /* Adjust padding to center the text vertically */
            text-align: center;
            width: 30px;
            /* Add a fixed width to ensure a circular shape */
            height: 30px;
            /* Add a fixed height to ensure a circular shape */
            line-height: 30px;
            /* Center the text vertically */
            font-size: 14px;
            /* Adjust font size as needed */
        }



        /* Calendar Styles */
        /* Apply gap between table header cells */
        thead th {
            padding-left: -40px;
            /* Adjust the horizontal padding as needed */
        }

        /* Apply gap between "To" and "Reason" */
        thead th:nth-child(2) {
            padding-left: 40px;
            /* Adjust the right padding for the second header cell */
        }

        .withdraw-button {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            /* Adjust the border radius as needed */
            background-color: rgb(2, 17, 79);
            /* Orange background color */
            color: #fff;
            /* White text color */
            text-align: center;
            border: none;
            /* Remove button border */
            cursor: pointer;
            margin-left: -40px;
            /* Add a pointer cursor on hover */
        }

        .hidden-history-box1 {
            width: 350px;
            height: 70px;
            background-color: #ffff;
            text-align: center;
            padding: 10px;
            margin-right: 4px;
            margin-top: 80px;

        }

        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active,
        .accordion:hover {
            background-color: #fff;
        }

        .panel {
            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }



        .remarks-container {
            width: 100%;
            /* This will make the container take the full width */
            max-width: 1200px;
            /* Adjust to set a specific large width */
            height: 150px;
            /* A smaller height */
            background-color: #fff;
            /* Light background color for visibility */
            border: 1px solid #ccc;
            padding: 20px;
            margin: 0 auto;
            /* Center the container */
        }

        .calendar-dates {
            display: flex;
            flex-wrap: wrap;
            text-align: center;
        }

        .calendar-week {
            display: flex;
            width: 100%;
            font-weight: bold;
        }

        .calendar-date {
            width: calc(100% / 7);
            padding: 10px;
            font-size: 12px;
            font-weight: bold;
            box-sizing: border-box;
            cursor: pointer;
        }

        .calendar-date.current-date {
            background-color: rgb(2, 17, 79);
            color: white;
            border-radius: 50%;
            padding: 10px;
            height: 30px;
            width: 30px;
            display: flex;
            margin: 0 auto;
            align-items: center;
        }

        .calendar-date.selected-date {
            background-color: #e8f6ff;
            ;
            border: 1px solid #24a7f8;
            padding: 10px;
            height: 25px;
            width: 2px;
            justify-content: center;
            display: flex;
            margin: 0 auto;
            margin-top: 5px;
            align-items: center;
        }

        .calendar-date.other-month-date {
            color: #a3b2c7;
            font-weight: bold;
            font-size: 12px;
        }

        .calendar-date.after-today {
            color: #a3b2c7;
            font-weight: bold;
            font-size: 12px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .back-button {
            background-color: transparent;
            /* Green background */
            color: rgb(2, 17, 79);
            /* White text */
            padding: 10px 30px;
            margin-left: -35px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            /* Remove underline */

        }

        .remarks-input {
            width: 500px;
            /* Adjust width as needed */
            height: 30px;
            /* Adjust height as needed */
            padding: 10px;
            /* Adds some inner spacing */
            font-size: 12px;
            /* Increases font size */
            color: #778899;
        }

        .nextMonth {
            background-color: rgb(2, 17, 79);
            color: white;
        }

        .nextMonth:hover {

            border: 1px solid rgb(2, 17, 79);
            color: white;
            background-color: rgb(2, 17, 79);
        }

        .nextMonth:active {

            border: 1px solid rgb(2, 17, 79);
            color: rgb(2, 17, 79);
            background-color: rgb(2, 17, 79);
        }

        .prevMonth:hover {

            border: 1px solid rgb(2, 17, 79);
            color: white;
            background-color: rgb(2, 17, 79);
        }

        .next-month-date {
            color: #a3b2c7;
            ;
        }

        .prevMonth:active {

            border: 1px solid rgb(2, 17, 79);
            color: white;
            background-color: rgb(2, 17, 79);
        }

        .prevMonth {
            background-color: rgb(2, 17, 79);
            color: white;
        }

        .regularisationCardheading {
            background: pink;
        }

        .scrollApplyingTO {
            max-height: 400px;
            overflow-y: auto;

        }

        .highermanager:hover {
            background-color: aliceblue;
        }

        @media screen and (max-height: 320px) {
            .regularisation-footer footer {
                left: 30px;
                padding: 10px 0;
            }

            .regularisation-footer div {
                justify-content: center;
                /* Center buttons on very small screens */
            }

            .regularisation-footer button,
            .regularisation-footer a {
                padding: 8px 15px;
                /* Adjust padding for smaller screens */
            }

            .accordion-heading {

                background-color: whitesmoke;

                border: 1px solid #778899;


            }

            .accordion-body {
                background-color: whitesmoke;

                border: 1px solid #778899;
            }
        }
    </style>

    @if($showMessage)
    <div class="alert alert-success">
        {{ session('success') }}

    </div>
    @endif
    <div class="container">
        <a href="/Attendance" class="submit-btn" style="text-decoration:none;">Back</a>
        <!-- Check for success message -->


        <!-- Your page content here -->
    </div>

    <div class="button-container">
        <button class="my-button apply-button" style="background-color: {{ ($isApply == 1 && $defaultApply == 1) ? 'rgb(2,17,79)' : '#fff' }};color: {{ ($isApply == 1 && $defaultApply == 1) ? '#fff' : 'initial' }};" wire:click="applyButton">Apply</button>
        <button class="my-button pending-button" style="background-color: {{ ($isPending==1&&$defaultApply==0) ? 'rgb(2,17,79)' : '#fff' }};color: {{ ($isPending==1&&$defaultApply==0) ? '#fff' : 'initial' }};" wire:click="pendingButton">Pending</button>
        <button class="my-button history-button" style="background-color: {{ ($isHistory==1&&$defaultApply==0) ? 'rgb(2,17,79)' : '#fff' }};color: {{ ($isHistory==1&&$defaultApply==0) ? '#fff' : 'initial' }};" wire:click="historyButton">History</button>
    </div>
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show w-50 m-auto" role="alert" wire:poll.10s="hideAlert">
        {{ session('error') }}
    </div>
    @endif
    @if($isApply==1&&$defaultApply==1)
    @if (session('flash_error'))
            
    @endif
    @if (session('flash_success'))
            
    @endif
    <div class="h row m-0 mt-4">
        <div class="col-md-5 mb-3">
            <div class="calendar-box">
                <div class="calendar-header">
                    <button class="btn prevMonth" wire:click="previousMonth"><i style="line-height: inherit;" class="fas fa-chevron-left"></i></button>
                    <p style="margin-top:7px; font-weight: 600">

                        {{ \Carbon\Carbon::createFromDate($this->year, $this->month, 1)->format('F Y') }}
                    </p>
                    <button class="btn nextMonth" wire:click="nextMonth"><i style="line-height: inherit;" class="fas fa-chevron-right"></i></button>
                </div>
                <div class="calendar-weekdays">
                    <div class="weekday">Sun</div>
                    <div class="weekday">Mon</div>
                    <div class="weekday">Tue</div>
                    <div class="weekday">Wed</div>
                    <div class="weekday">Thu</div>
                    <div class="weekday">Fri</div>
                    <div class="weekday">Sat</div>
                </div>
                <div class="calendar-dates">
                    @foreach($calendar as $week)
                    <div class="calendar-week">
                        @foreach($week as $day)
                        <div class="calendar-date {{ $day['isCurrentDate'] ? 'current-date' : '' }} 
                                        {{ in_array($day['date'], $selectedDates) ? 'selected-date' : '' }} 
                                        {{ $day['isCurrentMonth'] ? '' : ($day['isNextMonth'] ? 'next-month-date' : 'other-month-date') }} 
                                        {{ $day['isAfterToday'] ? 'after-today' : '' }}"
                            wire:click="submitShifts('{{ $day['date'] }}')">
                            {{ $day['day'] }}
                            @if($day['isRegularised'])
                            <div class="down-arrow-reg"></div>
                            @endif
                        </div>

                        @endforeach
                    </div>
                    @endforeach
                </div>
                <div class="calendar-footer" style="text-align: center;
                                
                                @if($year<=$todayYear&&$month<$todayMonth)
                                      background-color: rgb(176, 255, 176);
                                    color: green; 
                                @elseif($isdatesApplied)
                                    background-color: rgb(176, 255, 176);
                                    color: green; /* Change text color accordingly */
                                @else
                                    background: #ecf7fe;
                                    color: #7f8fa4;
                                @endif
                                padding: 8px;">
                    @if($year<=$todayYear&&$month<$todayMonth)
                        @if($todayMonth-$month==1)
                        <i class="far fa-check-circle"></i>
                        All exception days are already applied.
                        @else
                        <i class="far fa-check-circle"></i>
                        Regularization done for this period.
                        @endif
                        @elseif($isdatesApplied==true)
                        <i class="far fa-check-circle"></i>
                        All exception days are already applied.
                        @else
                        No exception dates to regularise.
                        @endif
                </div>


            </div>
        </div>
        <div class="col-md-7 mb-3">
            @if(count($selectedDates)>0&&$isdatesApplied==false)

            <div class="remarks-container">
                <div class="reporting mb-2">
                    @if(!empty($reportingmanagerfullName->image) && ($reportingmanagerfullName->image !== 'null'))
                    <div class="employee-profile-image-container">
                        <img class="rounded-circle" height="35px" width="35px" src="data:image/jpeg;base64,{{($reportingmanagerfullName->image)}}">
                    </div>
                    @else
                    @if($reportingmanagerfullName->gender === "Male")
                    <div class="employee-profile-image-container">
                        <img src="{{ asset('images/male-default.png') }}" class="employee-profile-image-placeholder rounded-circle" height="33" width="33">
                    </div>
                    @elseif($reportingmanagerfullName->gender === "Female")
                    <div class="employee-profile-image-container">
                        <img src="{{ asset('images/female-default.jpg') }}" class="employee-profile-image-placeholder rounded-circle" height="33" width="33">
                    </div>
                    @else
                    <div class="employee-profile-image-container">
                        <img src="{{ asset('images/user.jpg') }}" class="employee-profile-image-placeholder rounded-circle" height="35px" width="35px">
                    </div>
                    @endif

                    @endif
                    <div class="center p-0 m-0">
                        <p class="mb-0" style="font-size:10px;">{{ucwords(strtolower($reportingmanagerfullName->first_name))}}&nbsp;{{ucwords(strtolower($reportingmanagerfullName->last_name))}}</p>
                        <p class="mb-0 normalTextValue" style="font-size: 10px !important;" id="managerIdText">#({{$reportingmanager}})</p>
                    </div>
                    <div class="downArrow" wire:click="applyingTo">
                        <i class="fas fa-chevron-{{$chevronButton ? 'up' : 'down' }}" style="cursor:pointer"></i>
                    </div>
                </div>

                @if($showApplyingToContainer)
                <div class="searchContainer" style="z-index: 10;position: relative;">
                    <!-- Content for the search container -->
                    <div class="search-container-who-is-in" style="margin-left: auto;">

                        <div class="form-group-who-is-in">
                            <div class="search-input-who-is-in" style="margin-top:100px;">
                                <input wire:model="search" type="text" placeholder="Search Employee" class="search-text">
                                <div class="search-icon-who-is-in" wire:click="searchFilters">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>



                    </div>

                    <!-- Your Blade file -->
                    <div class="scrollApplyingTO">

                        @foreach ($heademployees as $employee)
                        <div class="highermanager d-flex gap-4 mt-2 align-items-center" wire:click="togglehigherManagers('{{ $employee->emp_id }}')">

                            @if(!empty($employee['image']) && ($employee['image'] !== 'null'))
                            <div class="employee-profile-image-container">
                                <img class="rounded-circle" height="35px" width="35px" src="{{ 'data:image/jpeg;base64,' . base64_encode($employee['image'])}}">
                            </div>
                            @else
                            @if($employee['gender'] === "Male")
                            <div class="employee-profile-image-container">
                                <img src="{{ asset('images/male-default.png') }}" class="employee-profile-image-placeholder rounded-circle" height="33" width="33">
                            </div>
                            @elseif($employee['gender'] === "Female")
                            <div class="employee-profile-image-container">
                                <img src="{{ asset('images/female-default.jpg') }}" class="employee-profile-image-placeholder rounded-circle" height="33" width="33">
                            </div>
                            @else
                            <div class="employee-profile-image-container">
                                <img src="{{ asset('images/user.jpg') }}" class="employee-profile-image-placeholder rounded-circle" height="35px" width="35px">
                            </div>
                            @endif
                            @endif

                            <div class="center d-flex flex-column mt-3 mb-2">
                                <span class="ellipsis mb-0">
                                    {{ ucwords(strtolower($employee->first_name))}} {{ ucwords(strtolower($employee->last_name))}}
                                </span>
                                <span class="mb-0 normalTextValue" style="font-size:10px;"> #{{ $employee->emp_id }} </span>
                            </div>
                        </div>
                        @endforeach



                    </div>
                </div>
                @endif
                <input type="text" placeholder="Enter Remarks" wire:model="remarks" class="remarks-input">

            </div>










            <div class="col-md-5">
                @if (session('error1'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" wire:poll.1s="hideAlert">
                    {{ session('error1') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <li>

                    @foreach($shift_times as $index => $regularisationEntry)

                    <div class="container-for-adding-regularisation-entries" style="background-color:white;">
                        <div class="row m-0" style="position:relative;">
                            <div class="col-2 pb-0 pt-0 p-1" style="border-right: 1px solid #7f8fa4; text-align: center; padding-left: 15px; padding-right: 15px;">
                                <p class="mb-1" style="font-weight:600;font-size:20px;color:#7f8fa4;">
                                    {{date('d', strtotime($regularisationEntry['date']))}}
                                </p>
                                <p class="text-muted m-0" style="font-weight:500;font-size:14px;color:#7f8fa4;">
                                    {{ date('D', strtotime($regularisationEntry['date'])) }}
                                </p>
                            </div>
                            <div class="col-5 pb-1 pt-1">
                                <p class="shift-time-for-regularisation text-overflow mb-1 disabled">
                                    10:00 am to 07:00 pm<span><i class="fas fa-caret-down"></i></span></p>

                            </div>
                            <div style="position: absolute; top: 5px; display:flex;justify-content:end; cursor: pointer;font-size:20px;color:#7f8fa4;" wire:click="deleteStoredArray({{ $index }})">
                                <i class="fa fa-times"></i>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="regularisationCard" style="width:100%">
                                <thead class="regularisationCardheading">
                                    <tr>
                                        <th style="font-weight:normal;font-size:12px;border: none;">From</th>
                                        <th style="font-weight:normal;font-size:12px;border: none;text-align:left;">To</th>
                                        <th style="font-weight:normal;font-size:12px;border: none;">Reason</th>

                                    </tr>
                                </thead>
                                <tbody>


                                    <tr>

                                        <td style="border: none;">

                                            <input type="text" placeholder="10:00" class="time-input text-5"
                                                wire:model.lazy="shift_times.{{ $index }}.from"
                                                style="text-align: center;width: 70px;" maxlength="5" oninput="validateFromTime(this)" />

                                            <!-- <p class="text-muted">
                                                    Entered Start Time: {{ $shift_times[$index]['from'] ?? '' }}
                                                </p> -->
                                            @if ($errors->has('shift_times.'.$index.'.from'))
                                            <span class="error-message" style="color: red; font-size: 12px;">{{ $errors->first('shift_times.'.$index.'.from') }}</span>
                                            @endif
                                        </td>
                                        <td style="border: none;">

                                            <input type="text" placeholder="19:00" class="time-input text-5"
                                                wire:model.lazy="shift_times.{{ $index }}.to"
                                                style="text-align: center;width: 70px;" maxlength="5" oninput="validateToTime(this)" />

                                            <!-- <p class="text-muted">
                                                Entered End Time: {{ $shift_times[$index]['to'] ?? '' }}
                                            </p> -->
                                            @if ($errors->has('shift_times.'.$index.'.to'))
                                            @if (strpos($errors->first('shift_times.'.$index.'.to'), 'HH:MM') !== false)
                                            <span class="error-message" style="color: red; font-size: 12px;">Please enter sign-out time in HH:MM format</span>
                                            @elseif (strpos($errors->first('shift_times.'.$index.'.to'), 'later') !== false)
                                            <span class="error-message" style="color: red; font-size: 12px;">Sign-out time must be later than sign-in time</span>
                                            @endif
                                            @endif
                                        </td>
                                        <td style="border: none;">

                                            <input type="text" placeholder="Reason" class="reason-input text-5"
                                                wire:model.lazy="shift_times.{{ $index }}.reason"
                                                style="text-align: center;width: 200px;" />

                                            @if ($errors->has('shift_times.'.$index.'.reason'))
                                            <span class="error-message" style="color: red; font-size: 12px;">{{ $errors->first('shift_times.'.$index.'.reason') }}</span>
                                            @endif

                                        </td>


                                    </tr>


                                    <!-- Add more rows with dashes as needed -->
                                </tbody>
                                <!-- Add table rows (tbody) and data here if needed -->
                            </table>

                        </div>
                    </div>

                </li>
                <!-- <button wire:click="submitShiftsForcheck">test</button> -->
                @endforeach
            </div>
            <footer class="regularisation-footer" style="position: fixed; bottom: 0; width: 100%;left:-20px; background-color: #fff; padding: 5px 0; text-align: center; box-shadow: 0 -2px 5px rgba(0,0,0,0.1);">
                <div style="display:flex; justify-content: right;">
                    <button type="button" wire:click="storearraydates" style="color: #fff; border:1px solid rgb(2,17,79); background: rgb(2,17,79); border-radius:5px; padding: 10px 20px;">Submit</button>
                    <a href="/Attendance" style="color:rgb(2,17,79); margin-left: 20px; padding: 10px 20px;">Cancel</a>
                </div>
            </footer>

        </div>
        @elseif($year==$todayYear&&$month==$todayMonth&&$todayDay>25)
        <div class="apply-box">
            <img src="{{ asset('images/Attendance-Period-Locked.png') }}" style="margin-top:50px;" height="250" width="250">

        </div>
        @elseif($year<=$todayYear&&$todayMonth-$month>1)
            <div class="apply-box">
                <img src="{{ asset('images/Attendance-Period-Locked.png') }}" style="margin-top:50px;" height="250" width="250">

            </div>
            @elseif($isdatesApplied==false)
            <div class="apply-box">
                <img src="{{ asset('images/pending.png') }}" style="margin-top:50px;" height="180" width="180">
                <p style="color: #7f8fa4;font-weight:400;font-size: 14px;">Smart! Your attendance is sorted.</p>
                <p style="color: #a3b2c7;font-weight:400;font-size: 12px;margin-top:-20px;">Still want to apply
                    regularization? Select dates(s).</p>
            </div>
            @else
            <div class="apply-box">
                <img src="{{ asset('images/date-to-start-regularizing.png') }}" style="margin-top:50px;" height="180" width="180">
                <p style="color: #7f8fa4;font-weight:400;font-size: 14px;">Select date to start regularizing</p>
            </div>
            @endif
    </div>
</div>

@elseif($isPending==1&&$defaultApply==0)
@if(count($pendingRegularisations)>0)
@foreach($pendingRegularisations as $pr)
@if ($pr->regularisation_entries!='[]')
@php
$regularisationEntries = json_decode($pr->regularisation_entries, true);
$numberOfEntries = count($regularisationEntries);
$firstItem = reset($regularisationEntries); // Get the first item
$lastItem = end($regularisationEntries); // Get the last item
@endphp
<div class="accordion-heading rounded" style="margin-top:10px;">

    <div class="accordion-title p-2 rounded">

        <!-- Display leave details here based on $leaveRequest -->

        <div class="col accordion-content">

            <span style="color: #778899; font-size: 12px; font-weight: 500;">Pending&nbsp;With</span>
            @if(!empty($EmployeeDetails))
            <span style="color: #36454F; font-size: 12px; font-weight: 500;">{{ucwords(strtolower($EmployeeDetails->first_name))}}&nbsp;{{ucwords(strtolower($EmployeeDetails->last_name))}}</span>
            @else
            <span style="color: #36454F; font-size: 12px; font-weight: 500;">Manager Details not Available</span>
            @endif
        </div>



        <div class="col accordion-content">

            <span style="color: #778899; font-size: 12px; font-weight: 500;">No. of Days</span>

            <span style="color: #36454F; font-size: 12px; font-weight: 500;">

                {{$numberOfEntries}}

            </span>

        </div>


        <!-- Add other details based on your leave request structure -->

        <div class="col accordion-content">

            <span style="margin-top:0.625rem; font-size: 12px; font-weight: 400; color:#cf9b17;text-transform:uppercase;">{{$pr->status_name}}</span>

        </div>

        <div class="arrow-btn" wire:click="togglePendingAccordion({{ $pr->id }})" style="color:{{ $openAccordionForPending === $pr->id ? '#3a9efd' : '#778899' }};border:1px solid {{ $openAccordionForPending === $pr->id ? '#3a9efd' : '#778899' }}">
            <i class="fa fa-angle-{{ $openAccordionForPending === $pr->id ? 'up' : 'down' }}" style="color:{{ $openAccordionForPending === $pr->id ? '#3a9efd' : '#778899' }}"></i>
        </div>

    </div>

</div>


<div class="accordion-body m-0 p-0" style="display: {{ $openAccordionForPending === $pr->id ? 'block' : 'none' }}">

    <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

    <div class="content px-2">

        <span class="normalTextValue">Dates Applied:</span>
        @if($numberOfEntries>1)
        <span style="font-size: 11px;">

        @foreach ($regularisationEntries as $key => $entry)
        <span style="font-size: 11px; font-weight: 500;">
            <!-- Display the date in (d format -->
            {{ date('d', strtotime($entry['date'])) }}{{ date(' M Y', strtotime($entry['date'])) }}
            
            @if ($key !== count($regularisationEntries) - 1)
                <!-- Display the separator for entries in between, without comma for the last entry -->
                ,
            @endif
        </span>
    @endforeach

    <!-- For the last item, display the formatted date -->
                

        </span>
        @else
        <span style="font-size: 11px;">

            <span style="font-size: 11px; font-weight: 500;">
                {{ date('d', strtotime($lastItem['date'])) }}
                {{ date('M Y', strtotime($lastItem['date'])) }}
                <!-- This will retrieve the day -->
            </span>

            @endif
    </div>



    <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

    <div style="display:flex; flex-direction:row; justify-content:space-between;">

        <div class="content px-2">

            <span style="color: #778899; font-size: 12px; font-weight: 500;">Applied on:</span>

            <span style="color: #333; font-size:12px; font-weight: 500;">{{ date('d M, Y', strtotime($pr->created_at)) }}</span>

        </div>

        <div class="content px-2">

            <a href="{{ route('regularisation-pending', ['id' => $pr->id]) }}">

                <span style="color: #3a9efd; font-size: 12px; font-weight: 500;">View Details</span>

            </a>
            <button class="withdraw mb-2" wire:click="openWithdrawModal">Withdraw</button>

        </div>

    </div>
    @if($withdrawModal==true)
    <div class="modal" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #f5f5f5; height: 50px">
                    <h5 class="modal-title" id="approveModalTitle" style="color:#778899;">Withdraw Confirmation</h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closewithdrawModal" style="background-color: #f5f5f5;font-size:12px;border-radius:20px;border:2px solid #778899;height:15px;width:15px;">
                    </button>
                </div>
                <div class="modal-body" style="max-height:300px;overflow-y:auto">
                    <p style="font-size:14px;">Are you sure you want to withdraw this application?</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="approveBtn" wire:click="withdraw({{$pr->id}})">Confirm</button>
                    <button type="button" class="rejectBtn" wire:click="closewithdrawModal">Cancel</button>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop" style="background-color: rgba(0, 0, 0, 0.2);"></div>


    @endif
</div>

@endif
@endforeach

@else
<div class="hidden-pending-box">
    <img src="{{ asset('images/pending.png') }}" style="margin-top:50px;" height="180" width="180">
    <p style="color: #a3b2c7;font-weight:400;font-size: 14px;margin-top:20px;">Hey, you have no
        regularization records to view.</p>
</div>
@endif

@elseif($isHistory==1&&$defaultApply==0)
@if(count($historyRegularisations)>0)
    @foreach($historyRegularisations as $hr)

    @php
$regularisationEntries = json_decode($hr->regularisation_entries, true);
// Count the number of elements in the array
$numberOfEntries = count($regularisationEntries);
// Initialize variables for minimum and maximum dates
$minDate = null;
$maxDate = null;
// Iterate through each entry to find the minimum and maximum dates
foreach ($regularisationEntries as $entry) {
// Check if the entry contains the 'date' key
if (isset($entry['date'])) {
$date = strtotime($entry['date']);

// Set the initial values for min and max dates
if ($minDate === null || $date < $minDate) { $minDate=$date; } if ($maxDate===null || $date> $maxDate) {
    $maxDate = $date;
    }
    } else {
    }
    }

    // Convert timestamps back to date strings
    $minDate = $minDate !== null ? date('Y-m-d', $minDate) : null;
    $maxDate = $maxDate !== null ? date('Y-m-d', $maxDate) : null;
    @endphp

    @if(($hr->status==4&&$hr->is_withdraw==1)||$hr->status==2||$hr->status==3)

    <div class="mt-4">
        <div class="accordion-heading rounded" style="margin-top:10px;">

            <div class="accordion-title p-2 rounded">

                <!-- Display leave details here based on $leaveRequest -->

                <div class="col accordion-content">
                    @if($hr->status==4)
                    <span style="color: #778899; font-size: 12px; font-weight: 500;">Withdrawn&nbsp;By</span>
                    @elseif($hr->status==3)
                    <span style="color: #778899; font-size: 12px; font-weight: 500;">Rejected&nbsp;By</span>
                    @elseif($hr->status==2)
                    <span style="color: #778899; font-size: 12px; font-weight: 500;">Regularized&nbsp;By</span>
                    @endif
                    @if($hr->status==4&&$hr->is_withdraw==1)
                    <span style="color: #36454F; font-size: 12px; font-weight: 500;">Me</span>
                    @else
                    <span style="color: #36454F; font-size: 12px; font-weight: 500; max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block;" data-toggle="tooltip" data-placement="top" title="{{ ucwords(strtolower($EmployeeDetails->first_name)) }} {{ ucwords(strtolower($EmployeeDetails->last_name)) }}">{{ ucwords(strtolower($EmployeeDetails->first_name)) }}&nbsp;{{ ucwords(strtolower($EmployeeDetails->last_name)) }}</span>

                    @endif
                </div>



                <div class="col accordion-content">

                    <span style="color: #778899; font-size: 12px; font-weight: 500;white-space-nowrap;">No. of Days</span>

                    <span style="color: #36454F; font-size: 12px; font-weight: 500;">

                        {{$numberOfEntries}}

                    </span>

                </div>


                <!-- Add other details based on your leave request structure -->

                <div class="col accordion-content">
                    @if($hr->status==2)
                    <span style="margin-top:0.625rem; font-size: 12px; font-weight: 400; color:green;text-transform:uppercase;">closed</span>
                    @elseif($hr->status==3)
                    <span style="margin-top:0.625rem; font-size: 12px; font-weight: 400; color:#f66;text-transform:uppercase;">{{$hr->status_name}}</span>
                    @elseif($hr->status==4&&$hr->is_withdraw==1)
                    <span style="margin-top:0.625rem; font-size: 12px; font-weight: 400; color:#cf9b17;text-transform:uppercase;">{{$hr->status_name}}</span>
                    @endif
                </div>

                <div class="arrow-btn" wire:click="toggleHistoryAccordion({{ $hr->id }})" style="color:{{ $openAccordionForHistory === $hr->id ? '#3a9efd' : '#778899' }};border:1px solid {{ $openAccordionForHistory === $hr->id ? '#3a9efd' : '#778899' }}">
                    <i class="fa fa-angle-{{ $openAccordionForHistory === $hr->id ? 'up' : 'down' }}" style="color:{{ $openAccordionForHistory === $hr->id ? '#3a9efd' : '#778899' }}"></i>
                </div>

            </div>

        </div>
    </div>
    <div class="accordion-body m-0 p-0" style="display: {{ $openAccordionForHistory === $hr->id ? 'block' : 'none' }}">

        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

        <div class="content px-2">

            <span style="color: #778899; font-size: 12px; font-weight: 500;">Dates Applied:</span>

            <span style="font-size: 11px;">

                <span style="font-size: 11px; font-weight: 500;"></span>

                {{ date('d M, Y', strtotime($minDate)) }}
                @if($numberOfEntries>1)
                -
                @endif
                <span style="font-size: 11px; font-weight: 500;"></span>

                @if($numberOfEntries>1)
                {{ date('d M, Y', strtotime($maxDate)) }}
                @endif
            </span>

        </div>



        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

        <div style="display:flex; flex-direction:row; justify-content:space-between;">

            <div class="content px-2">
                @if($hr->status==4)
                <span style="color: #778899; font-size: 12px; font-weight: 500;">Withdrawn on:</span><br>
                <span style="color: #333; font-size:12px; font-weight: 500;">{{ date('d M, Y', strtotime($hr->created_at)) }}</span>
                @elseif($hr->status==3)
                <span style="color: #778899; font-size: 12px; font-weight: 500;">Rejected on:</span><br>
                <span style="color: #333; font-size:12px; font-weight: 500;">{{ date('d M, Y', strtotime($hr->created_at)) }}</span>
                @elseif($hr->status==2)
                <span style="color: #778899; font-size: 12px; font-weight: 500;">Regularized on:</span><br>
                <span style="color: #333; font-size:12px; font-weight: 500;">{{ date('d M, Y', strtotime($hr->created_at)) }}</span>
                @endif
            </div>

            <div class="content px-2">

                <a href="{{ route('regularisation-history', ['id' => $hr->id]) }}">

                    <span style="color: #3a9efd; font-size: 12px; font-weight: 500;">View Details</span>

                </a>

            </div>

        </div>

    </div>
    @endif
    @endforeach
    @else
    
    <div class="hidden-pending-box">
        <img src="{{ asset('images/pending.png') }}" style="margin-top:50px;" height="180" width="180">
        <p style="color: #a3b2c7;font-weight:400;font-size: 14px;margin-top:20px;">Hey, you have no
            regularization records to view.</p>
    </div>

    @endif
    @endif

    <script>
        function toggleAccordion(element) {

            const accordionBody = element.nextElementSibling;

            if (accordionBody.style.display === 'block') {

                accordionBody.style.display = 'none';

                element.classList.remove('active'); // Remove active class

            } else {

                accordionBody.style.display = 'block';

                element.classList.add('active'); // Add active class

            }
        }

        function validateFromTime(input) {
            const timeFromFormat = /^([01]\d|2[0-3]):([0-5]\d)$/; // 24-hour time format validation
            const isFromValid = timeFromFormat.test(input.value);
            const errorFromMessage = input.nextElementSibling; // Assuming the error message is the next sibling of the input

            if (!isFromValid && input.value.length === 5) {
                errorFromMessage.style.display = 'inline'; // Show the error message
            } else {
                errorFromMessage.style.display = 'none'; // Hide the error message when valid
            }
        }

        function validateToTime(input) {
            const timeToFormat = /^([01]\d|2[0-3]):([0-5]\d)$/; // 24-hour time format validation
            const isToValid = timeToFormat.test(input.value);
            const errorToMessage = input.nextElementSibling; // Assuming the error message is the next sibling of the input

            if (!isToValid && input.value.length === 5) {
                errorToMessage.style.display = 'inline'; // Show the error message
            } else {
                errorToMessage.style.display = 'none'; // Hide the error message when valid
            }
        }
    </script>

    </div>
    </div>
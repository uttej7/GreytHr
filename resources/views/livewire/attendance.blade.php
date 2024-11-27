<div>
    <style>
        .date-range-container12-attendance-info {
            margin-right: 62px;
        }

        .my-button-attendance-info {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            color: #fff;
            border-color: rgb(2, 17, 79);
            background: rgb(2, 17, 79);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;

        }

        .my-button-attendance-info:hover {
            /* Styles for hover state */
            text-decoration: none;
            background-color: #24a7f8 !important;
            color: #fff !important;
            /* Remove underline on hover */
        }

        .my-button-attendance-info:active {
            /* Styles for active/clicked state */
            text-decoration: none;
            /* Remove underline when clicked */
        }

        .topMsg-attendance-info {
            border: 1px solid #ccc;
            border-radius: 5px;
            /* Adjust the height as needed */
            /* Adjust the padding as needed */
            padding: 12px;
            font-size: 12px;
            background-color: #FFFFFF;



        }

        .container-attendance-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 500px;
            height: 40px;
            /* Adjust the height as needed */
            /* Background color of the container */
            border: 1px solid #ccc;
            /* Border style for the container */
            padding: 10px;
            /* Padding inside the container */
            font-size: 14px;
            margin-left: 170px;
            margin-bottom: -100px;
            background-color: #FFFFFF;
            /* Font size for the text */
        }

        .insight-card[_ngcontent-hbw-c670] {
            border: 1px solid red;
            border-radius: 4px;
            /* margin-right: 15px;
min-height: 102px;
width: 170px; */
        }

        .insight-card {
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .insight-card[_ngcontent-hbw-c670] h6[_ngcontent-hbw-c670] {
            border-bottom: 1px solid #cbd5e1;
            margin: 0;
            padding: 7px 20px;
            text-transform: uppercase;
        }

        .text-regular {
            font-weight: 400;
        }

        .text {
            color: #000;
        }

        .arrow-icon-attendance-info {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 5px;
            /* Adjust the margin as needed */
        }

        .arrow-icon-attendance-info::after {
            content: '\2192';
            /* Unicode right arrow character */
            margin-left: 5px;
            /* Adjust the margin as needed */
        }

        .text-secondary {
            color: #7f8fa4;
        }

        .text-center {
            text-align: center;
        }

        .info-icon-container-attendance-info {
            position: relative;
            display: inline-block;
        }

        .info-icon-attendance-info {
            font-size: 14px;
            color: blue;
        }

        .info-box-attendance-info {
            display: none;
            position: absolute;
            font-size: 10px;
            top: 100%;
            left: 50%;
            color: #fff;
            transform: translateX(-50%);
            background-color: #808080;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            Z-index: 1
        }

        .info-icon-container-attendance-info .fa-info-circle:hover+.info-box-attendance-info {
            display: block;
        }

        .text-2 {
            font-size: 18px;
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
        }

        .text-success {
            color: #5bc67e;
        }

        .text-muted {
            color: #a3b2c7;
        }

        a {
            color: #24a7f8;
        }

        .text-5 {
            font-size: 12px;
            margin-top: 50px;
            margin-bottom: 0;
        }

        .btn-group {
            position: relative;
            display: inline-block;
            vertical-align: middle;
        }

        .btn-group>.btn:first-child:not(:last-child):not(.dropdown-toggle) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .btn-group .btn.icon-btn {
            min-width: 30px;
            padding: 0;
        }

        .btn-group .btn.active {
            background-color: #24a7f8;
            border: 1px solid #24a7f8;
            color: #fff;
        }

        .btn-group>.btn:first-child {
            margin-left: 0;
        }

        [_nghost-exg-c673] .details[_ngcontent-exg-c673] {
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .legendtext {
            color: #778899;
            font-size: 12px;
            padding-top: 2px;
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
        }

        .calendar-attendance-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* width: 700px;
    margin-left: 20px;
    margin-top: 10px; */
        }

        .large-box-attendance-info {
            max-width: 900px;
            height: 220px;
            margin: 0 auto;

            margin-left: 10px;
            margin-top: 10px;
            border: 1px solid #cbd5e1;


        }

        /* Month header */
        .calendar-header-attendance-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }


        #calendar-icon-attendance-info {
            border-top-left-radius: 5px;
            /* Adjust the value as needed */
            border-bottom-left-radius: 5px;
            /* Adjust the value as needed */
        }

        #bars-icon-attendance-info {
            border-top-right-radius: 5px;
            /* Adjust the value as needed */
            border-bottom-right-radius: 5px;
            /* Adjust the value as needed */
        }
       

        .calendar-weekdays-attendance-info {
            display: flex;
            justify-content: space-around;
            color: #02114f;
            gap: 5px;
            padding: 5px 10px;
            /* margin-bottom: 10px; */
            border: 1px solid #dedede;
        }

        .container-leave {
            padding: 0;
            margin: 0;
        }

        .table thead {
            border: none;
        }

        .table th {
            text-align: center;
            height: 15px;
            border: none;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            font-weight: normal;
            color: #778899;
        }

        .table td:hover {
            background-color: #ecf7fe;
            /* Hover background color */
            cursor: pointer;
        }

        /* Add styles for the navigation buttons */
        .nav-btn {
            background: none;
            border: none;
            color: #778899;
            font-size: 12px;
            margin-top: -6px;
            cursor: pointer;
        }

        .nav-btn:hover {
            color: blue;
        }

        /* Increase the size of tbody cells and align text to top-left */
        .table-1 tbody td {
            width: 75px;
            height: 80px;
            border-color: #c5cdd4;
            font-weight: 500;
            font-size: 13px;
            /* Adjust font size as needed */
            vertical-align: top;
            position: relative;
            text-align: left;
        }

        .table-1 thead {
            border: none;
        }

        .table-1 th {
            text-align: center;
            /* Center days of the week */
            height: 15px;
            border: none;
            color: #778899;
            font-size: 12px;
        }

        .table-1 {
            overflow-x: hidden;
        }

        /* Add style for the current date cell */
        .current-date {
            background-color: #ff0000;
            /* Highlight color for the current date */
            color: #fff;
            /* Text color for the current date */
            font-weight: bold;
        }

        .calendar-heading-container {
            background: #fff;
            padding: 10px 10px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            /* Add spacing between heading and icons */
        }

        .calendar-heading-container h5 {
            font-size: 0.975rem;
            color: black;
            font-weight: 500;
        }

        .table {
            overflow-x: hidden;
            /* Add horizontal scrolling if the table overflows the container */
        }

        .tol-calendar-legend {
            display: flex;
            font-size: 0.875rem;
            width: 100%;
            justify-content: space-between;
            font-weight: 500;
            color: #778899;
        }

        /* CSS for legend circles */
        .legend-circle {
            display: inline-block;
            width: 15px;
            /* Adjust the width as needed */
            height: 15px;
            /* Adjust the height as needed */
            border-radius: 50%;
            text-align: center;
            line-height: 15px;
            /* Vertically center the text */
            margin-right: 2px;
            /* Add some spacing between the circle and text */
            font-weight: bold;
            /* Make the text bold */
            color: white;
            /* Text color */
        }

        .circle-pale-yellow {
            background-color: #ffeb3b;
            /* Define the yellow color */
        }

        /* CSS for the pink circle */
        .circle-pale-pink {
            background-color: #d29be1;
            /* Define the pink color */
        }

        .accordion {
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            /* Adjust the width as needed */
            top: 100px;
            overflow-x: auto;
            left: 0;
            /* Adjust the top position as needed */
            /* Adjust the right position as needed */
        }

        .accordion-heading {
            background-color: #fff;
            cursor: pointer;
        }
        .accordion-icon {
            font-size: 13px;
            color: #fff;
            float: right;
            margin-left: 5px;
}
        .accordion-body {
            background-color: #fff;
            padding: 0;
            display: block;
            width: 100%;
            overflow: auto;
        }

        .accordion-content {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .accordion-title {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .active .leave-container {
            border-color: #3a9efd;
            /* Blue border when active */
        }

        .accordion-button {
            color: #DCDCDC;
            border: 1px solid #DCDCDC;
        }

        .active .accordion-button {
            color: #3a9efd;
            border: 1px solid #3a9efd;
        }

        @media (max-width: 760px) {


            .accordion {
                width: 65%;
                top: auto;
                right: auto;
                margin-top: 20px;
            }
        }

        .centered-modal {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Calendar days */
        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            /* gap: 5px; */
            justify-items: center;
            padding: 0px;
        }

        .calendar-date {
            width: 100%;
            height: 4em;
            font-weight: normal;
            font-size: 12px;
            /* border-radius: 50%; */
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
            /* padding: 14px; */
        }



        .attendance-calendar-date:hover {
            background-color: #f3faff;
        }

        .attendance-calendar-date.clicked {
            background-color: #f3faff;
            border-color: blue;
            border: 2px solid #24a7f8;

        }

        .clickable-date:active {
            background-color: #f3faff;
            border: 1px solid #c5cdd4;
        }

        .clickable-date1 {
            background-color: pink;
        }

        .calendar-day {
            text-align: center;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: white;
        }

        #prevMonth,
        #nextMonth {
            /* background-color: rgb(2, 17, 79);
    color: white; */
            border: none;
            padding: 2px 5px;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;

        }

        #currentMonth {
            font-size: 12px;
            margin: 0;
        }

        .today {
            background-color: rgb(2, 17, 79);
            color: white;
        }

        /* Today's date */
        .calendar-day.today {
            background-color: #0099cc;
            color: white;
        }

        .container1 {
            /* width: 600px;  */
            /* height: 200px; */
            /* margin-right: 300px; */
            background-color: #FFFFFF;
            margin-top: 15px;
            /* margin-top: 420px; */
            border-radius: 10px;
            /* float: right; */
            border: 1px solid #ccc;
        }

     

        

        .container6 {
            /* width: 600px; */
            /* Adjust the width as needed */
            /* height: 45px; */
            /* margin-right: 300px; */
            background-color: #FFFFFF;
            margin-top: 30px;
            border-radius: 10px;
            /* float: right; */
            /* Adjust the height as needed */
            /* Background color of the container */
            border: 1px solid #ccc;
            /* border-bottom: 1px solid #ccc; */
            /* Border style for the container */
        }

        

        /* Basic styles for the input container */
        .date-range-container {
            display: flex;
            align-items: center;
            width: 300px;
            /* Adjust the width as needed */
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            margin-left: 198px;

            margin-top: -80px;
        }

        .chart-range-container {
            display: flex;
            align-items: center;
            /* width: 600px; */
            /* Adjust the width as needed */
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            /* margin-left: -98px; */
            overflow-x: auto;
            height: 120px;
            /* margin-top: 40px; */
        }

        /* Style for the calendar icon */
        .calendar-icon {
            margin-right: 10px;
            color: #888;
        }

        /* Style for the input field */
        .date-range-input {
            border: none;
            outline: none;
            width: 100%;
        }

        .container3 {
            /* width: 600px; */
            /* Adjust the width as needed */
            /* height: 180px; */
            /* margin-right: 300px; */
            background-color: #FFFFFF;
            margin-top: 30px;
            border-radius: 10px;
            /* float: right; */
            /* Adjust the height as needed */
            /* Background color of the container */
            border: 1px solid #ccc;
            /* Border style for the container */
        }

        /* CSS for the table */
        .large-box-attendance-info {
            width: 100%;
            overflow-x: auto;
        }

        .second-header-row th.date {

            /* Adjust the width of the Date column as needed */
        }

        .second-header-row th:not(.date) {

            /* Adjust the width of the Shift and Shift Timings columns as needed */
        }

        .large-box-attendance-info table {



            max-width: 100%;
            margin-top: -20px;
            table-layout: fixed;
            /* Fix the table layout */
            width: auto;
            /* Set the table to an appropriate width or it will expand to the container's full width */
            white-space: nowrap;
            /* Prevent table cell content from wrapping */
            border-collapse: collapse;

        }

        .large-box-attendance-info td {
            padding: 10px;


        }

        .date {

            border-bottom: 1px solid #cbd5e1;
            margin-left: 10px;

        }

        .large-box-attendance-info {

            height: 200px;
        }

        .large-box-attendance-info th {
            background-color: rgb(2, 17, 79);
            color: white;
            width: 600px;
            /* Adjust the width as needed */
            padding-right: 50px;
        }

        /* CSS for the second header row */
        .large-box-attendance-info .second-header-row {

            background-color: rgb(2, 17, 79);
            color: white;
        }

        .large-box-attendance-info .third-header-row {

            color: black;
        }

        .large-box-attendance-info .first-header-row {
            background-color: rgb(2, 17, 79);
            color: white;


        }

        .large-box-attendance-info .fourth-header-row {
            background-color: #fff;
            color: black;
        }

        .vertical-line-attendance-info {
            border-left: 1px solid black;
            /* Adjust the width and color as needed */
            /* Adjust the height as needed */
            margin-top: -68px;
            height: 70px;
            padding: 0;
            margin-left: 70px;
        }


        .chart-column-attendance-info {
            flex: 1;
            /* Distribute available space equally among columns */
            padding: 70px;
            margin-top: -40px;
            text-align: center;
            border-right: 1px solid #ccc;
        }

        /* Remove the right border for the last column */
        .chart-column-attendance-info:last-child {
            border-right: none;
            margin-top: -40px;
        }

       


        .horizontal-line2-attendance-info {
            width: 100%;
            /* Set the width to the desired value */
            border-top: 1px solid #000;
            /* You can adjust the color and thickness */
            margin: -10px 0;
            /* Adjust the margin as needed */
        }

        table {
            border-collapse: collapse;
            width: 100%;

        }

        /* CSS for the table header (thead) */
        thead {
            background-color: #eef7fa;
            color: #778899;
            border-top: 1px solid #ccc;
        }

        /* CSS for the table header cells (th) */
        th {
            padding: 10px;
            text-align: left;
        }

        td {
            /* Add borders to separate cells */
            padding: 10px;
            text-align: left;
        }

        .toggle-box-attendance-info {

            background-color: transparent;
            margin-left: 40px;
            float: right;
            display: flex;
            align-items: center;
            /* margin-left: 850px; */
            /* margin-top: -40px; */
            /* padding: 5.5px 6px; */
            /* Adjust padding as needed */
        }


        .toggle-box-attendance-info i {
            color: grey;
            /* Set the icon color */
            background-color: pink;
            /* Set the background color for icons */
            padding: 6px 6px;
            /* Set padding for icons */
            margin-right: 0px;
            /* Add spacing between icons if desired */
        }

        .toggle-box-attendance-info i.fas.fa-calendar {
            /* Initial icon color */
            /* Initial background color for icon */
            padding: 10px 10px;
            /* Initial padding for icon */
            margin-right: 0px;
            /* Initial spacing between icons */
            border: 2px solid transparent;


            /* Initial border color (transparent) */
        }


        .toggle-box-attendance-info i.fas.fa-calendar:hover {
            color: rgb(2, 17, 79);
            /* Icon color on hover */
            /* Background color for icon on hover */
            border-color: rgb(2, 17, 79);
            /* Border color on hover */
        }

        .toggle-box-attendance-info i.fas.fa-bars {
            color: grey;
            /* Initial icon color */
            /* Initial background color for icon */
            padding: 10px 10px;
            /* Initial padding for icon */
            margin-right: 0px;
            /* Initial spacing between icons */
            border: 2px solid transparent;
            /* Initial border color (transparent) */
        }

        .toggle-box-attendance-info i.fas.fa-bars:hover {
            color: rgb(2, 17, 79);
            /* Icon color on hover */
            /* Background color for icon on hover */
            border-color: rgb(2, 17, 79);
            /* Border color on hover */
        }

        .toggle-box-attendance-info i.fas.fa-calendar.active {
            color: white;
            /* Icon color when active (clicked) */
            background-color: rgb(2, 17, 79);
            /* Background color when active (clicked) */
        }

        .toggle-box-attendance-info i.fas.fa-bars.active {
            color: white;
            /* Icon color when active (clicked) */
            background-color: rgb(2, 17, 79);
            /* Background color when active (clicked) */
        }

        .box-attendance-info {
            width: 160px;
            height: 30px;
            /* You can change the border color here */
            text-align: center;
            display: inline-block;
            margin-top: 14px;
            margin-left: 8px;


        }





        .custom-modal .modal-header {
            padding: 10px;
            background-color: #e9edf1;
            /* Decrease header padding */
        }

        .date-picker-container {
            position: relative;
            display: none;

        }

        .date-input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .calendar-icon1 {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        #calendar4 {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            border: 1px solid #ccc;
            z-index: 1000;
        }

        #calendar4 .calendar {
            display: inline-block;
            margin: 10px;
        }


        /* .custom-modal .modal-body {
    padding: 100px;
} */

        /* CSS for the icons */

        /* Style for the row container */


        /* Style for individual values */

        /* Style for individual values */
        .chart-value {
            flex: 1;
            /* Distribute available space equally among values */
            text-align: center;
            margin-top: 40px;
            padding: 10px;


        }

        .chart-column-attendance-info>div {
            margin: 0 auto;
        }

        /* CSS for the lines icon */
        .lines-icon::before {
            content: "\2630";
            background-color: white;
            padding-top: 5px;
            padding-right: 12px;
            padding-bottom: 7px;
            margin-left: -10px;
            /* Unicode character for the three lines icon */
        }

        .rotate-arrow {
            transform: rotate(90deg);
            transition: transform 0.3s ease;
            /* Add a smooth transition effect */
        }

        /* CSS for the calendar icon */
        .calendar-icon::before {
            content: "\1F4C5";
            background-color: white;
            /* Add a blue background color */
            color: white;
            /* Set the text color to white */
            padding-top: 5px;
            padding-right: 6px;
            padding-bottom: 6px;
            /* Add padding for spacing */
            /* Unicode character for the calendar icon */
        }

        .arrow-button::after {

            /* Unicode character for right-pointing triangle (arrow) */
            font-size: 18px;

        }

        .modal-box-attendance-info {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            /* Adjust as needed for spacing */
        }

        .attendance-calendar-date {
            cursor: pointer;
            padding: 3px;
            margin: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }


        .custom-modal-lg {
            max-width: 90%;

        }

        .modal-content-attendance-info {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }


        .circle.IRIS {
            background-color: #d29be1;
        }

        .container11 {
            display: flex;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: -250px;
            /* Initially, hide the sidebar off-screen */
            width: 250px;
            height: 100%;
            background-color: #fff;
            color: #fff;
            transition: right 0.3s ease-in-out;
        }

        .close-sidebar {
            margin-left: 205px;
            margin-bottom: -50px;
        }

        .content {
            margin-right: 20px;

        }

        /* Existing styles for sidebar */


        /* Styles for sidebar header */
        .sidebar .sidebar-header {
            background-color: #e9edf1;
            padding: 10px;
            text-align: center;
        }

        .sidebar .sidebar-header h2 {
            color: #7f8fa4;
            font-size: 24px;
            margin: 0;
        }

        .sidebar-content h3 {
            color: #7f8fa4;
            margin-left: 30px;
        }

        .sidebar-content p {
            color: #7f8fa4;
            font-size: 12px;
            margin-left: 30px;
        }

        /* Hover styles */

        .text-overflow {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .accordion {
            background-color: #dae0f7;
            color: #444;
            cursor: pointer;
            padding: 21px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
            margin-top: 10px;
            border: 1px solid #cecece;
        }

        /* .active, .accordion:hover {
background-color: #02114f;
color: #fff;
} */

        .panel {
            /* padding: 0 18px; */
            display: none;
            background-color: white;
            overflow: hidden;
            border: 1px solid #cecece;
            font-size: 14px;
        }

        .accordion:before {

            /* Unicode character for "plus" sign (+) */
            font-size: 13px;
            color: #fff;
            float: right;
            margin-left: 5px;
        }

        .accordion:before {

            /* Unicode character for "plus" sign (+) */
            font-size: 13px;
            color: #fff;
            float: right;
            margin-left: 5px;
        }

        .accordion.active:after {
            content: '\2796';
            /* Unicode character for "minus" sign (-) */
        }

        .legendsIcon {
            padding: 1px 6px;
            font-weight: 500;
        }

        .presentIcon {
            background-color: #edfaed;
        }

        .absentIcon {
            background-color: #fcf0f0;
            color: #ff6666;
        }

        .offDayIcon {
            background-color: #f7f7f7;
        }

        .leaveIcon {
            background-color: #fcf2ff;
        }

        .onDutyIcon {
            background-color: #fff7eb;
        }

        .holidayIcon {
            background-color: #f2feff;
        }

        .alertForDeIcon {
            background-color: #edf3ff;
        }

        .deductionIcon {
            background-color: #fcd2ca;
        }

        .down-arrow-reg {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #f09541;
            margin-right: 5px;
        }

        .down-arrow-gra {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #5473e3;
            margin-right: 5px;
        }

        .down-arrow-ign-attendance-info {
            width: 0;
            height: 0;
            /* border-left: 20px solid transparent; */
            border-right: 17px solid transparent;
            border-bottom: 17px solid #677a8e;
            margin-right: 5px;
        }

        .emptyday {
            color: #aeadad;
            pointer-events: none;
        }

        .attendance-legend-text {
            white-space: nowrap;
            font-size: 12px;
            color: #778899;
        }

        .attendanceperiod {
            text-transform: uppercase;
            margin-top: 40px;
            color: rgb(2, 17, 79);
            text-decoration: none;
        }

        .attendanceperiod:hover {

            text-decoration: underline;
        }

        .insights-for-attendance-period-avg-working-hours {
            text-align: center;
            font-size: 0.7rem;
            font-weight: 400;
            padding: 1px;
            margin: 0px;
            width: 15%;
            border: 1px solid lightgray;
        }

        .insights-for-attendance-period {
            text-align: center;
            font-size: 0.7rem;
            font-weight: 400;
            padding: 1px;
            margin: 0px;
            width: 5%;
            border: 1px solid lightgray;

        }

        .attendance-period {
            width: 90rem
        }

        .attendence-period-table {
            width: 100%
        }

        .start-date-for-attend-period {
            margin-right: 8px;
        }

        .average-first-and-last-time {
            display: flex;
            white-space: nowrap;
            justify-content: space-evenly;
            text-align: center;
        }

        .attendance-period-header {
            font-weight: 500;
        }
        .custom-scrollbar {
    max-height: 600px; /* Set the height limit to trigger the scrollbar */
    overflow-y: auto; /* Enable vertical scrolling */
    scrollbar-width: thin; /* For Firefox - makes the scrollbar thinner */
    scrollbar-color: #888 #f1f1f1; /* For Firefox - custom scrollbar color */
}

/* Chrome, Edge, Safari */
.custom-scrollbar::-webkit-scrollbar {
    width: 8px; /* Set the width of the scrollbar */
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1; /* Background of the scrollbar track */
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #888; /* Scrollbar thumb color */
    border-radius: 10px; /* Rounded corners for the scrollbar thumb */
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: #555; /* Change color on hover */
}
.custom-scrollbar-for-right-side-container
{
    max-height: 600px; /* Set the height limit to trigger the scrollbar */
    overflow-y: auto; /* Enable vertical scrolling */
    scrollbar-width: thin; /* For Firefox - makes the scrollbar thinner */
    scrollbar-color: #888 #f1f1f1; /* For Firefox - custom scrollbar color */
    height: 600px;
}

/* Chrome, Edge, Safari */
.custom-scrollbar-for-right-side-container
::-webkit-scrollbar {
    width: 8px; /* Set the width of the scrollbar */
}

.custom-scrollbar-for-right-side-container
::-webkit-scrollbar-track {
    background: #f1f1f1; /* Background of the scrollbar track */
}

.custom-scrollbar-for-right-side-container
::-webkit-scrollbar-thumb {
    background-color: #888; /* Scrollbar thumb color */
    border-radius: 10px; /* Rounded corners for the scrollbar thumb */
}

.custom-scrollbar-for-right-side-container
::-webkit-scrollbar-thumb:hover {
    background-color: #555; /* Change color on hover */
}
.container1box
{
    border-right: 1px solid #ccc; 
    text-align: center;
 
}
.container1boxDate
{
    font-weight:bold;
    font-size:14px;
    color:#778899;
}
.container1boxDay
{
    font-weight:600;
    font-size:12px;
    color:#778899;
}
@media screen and (max-height: 513px) {
    .penalty-and-average-work-hours-card{
        margin-top: 40px;
    }
}
@media screen and (max-height: 320px) {
   
    .legendTriangleIcon
    {
        margin-right: 40px;
    }
}
    </style>
    @php
    $flag=0;
    $flag1=0;
    $leave=0;
    $todayDate = date('Y-m-d');

    @endphp

    <div>

        <div class="row m-0" style="text-align: end;">
            <div class="col-md-12">
                <a href="/regularisation" class="btn btn-primary mb-3 my-button-attendance-info" id="myButton">My Regularisations</a>
            </div>
        </div>



        <div class="row m-0 d-flex justify-content-center text-center">
            <div class="col-12 col-md-4">
                <div class="row m-0 topMsg-attendance-info d-flex align-items-center">

                    <div class="col-8 p-0">
                        <!-- Small box with the text -->
                        <div style="white-space:nowrap;text-align:center;margin-left:30px;font-size:12px;">Access card details not available</div>

                    </div>

                    <!-- Blue info icon on the right -->
                    <div class="info-icon-container-attendance-info col-4">
                        <i class="fa fa-info-circle" aria-hidden="true" style="margin-left:66px;font-size: 14px; color: blue;text-decoration:none;"></i>
                        <div class="info-box-attendance-info">
                            Contact administrator to get access card assigned.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

        <div class="row m-0 mt-3">
            <div class="row m-0 d-flex justify-content-center" style="display:flex;justify-content:center;">
            
                <div class="penalty-and-average-work-hours-card col-md-3 mb-3">
                    <div class="insight-card bg-white pt-2 pb-2"style="{{ $percentageinworkhrsforattendance == 0 ? 'height: 135px;' : '' }}">
                        <h6 class="text-secondary text-regular text-center" style="font-size:12px;border-bottom:1px solid #ccc;padding-bottom:5px;">Avg. Work Hrs
                        </h6>
                        <section class="text-center">
                            
                            <p class="text-2" style="margin-top:30px;">{{$averageWorkHrsForCurrentMonth}}</p>
                            
                          
                            <div>

                            
                              
                            @if($percentageinworkhrsforattendance>0)
                                            <span class="text-success ng-star-inserted" style="font-size:10px;"> +{{intval($percentageinworkhrsforattendance)}}%
                                            </span>
                                            <span class="text-muted" style="font-size:10px;margin-left:0px;"> From {{ \Carbon\Carbon::createFromDate($year, $month, 1)->subMonth()->format('F') }}
                                            </span>
                                            @elseif($percentageinworkhrsforattendance==0)
                                            <span class="text-success ng-star-inserted" style="font-size:10px;"> {{intval($percentageinworkhrsforattendance)}}%
                                            </span>
                                            <span class="text-muted" style="font-size:10px;margin-left:0px;"> From {{ \Carbon\Carbon::createFromDate($year, $month, 1)->subMonth()->format('F') }}
                                            </span>   
                                   @elseif($percentageinworkhrsforattendance<0)
                                       <span class="text-danger ng-star-inserted" style="font-size:10px;"> {{intval($percentageinworkhrsforattendance)}}%
                                        </span>
                                        <span class="text-muted" style="font-size:10px;margin-left:0px;"> From {{ \Carbon\Carbon::createFromDate($year, $month, 1)->subMonth()->format('F') }}
                                        </span>

                                    @endif

                            </div>

                        </section>
                    </div>
                </div>
                <div class="penalty-and-average-work-hours-card mb-3 col-md-3">
                    <div class="insight-card bg-white pt-2 pb-2"style="{{ $percentageinworkhrsforattendance == 0 ? 'height: 135px;' : '' }}">
                        <h6 class="text-secondary text-regular text-center" style="font-size:12px;border-bottom:1px solid #ccc;padding-bottom:5px;">
                            Avg.&nbsp;Actual&nbsp;Work&nbsp;Hrs</h6>
                        <section class="text-center">

                                            <p class="text-2" style="margin-top:30px;">{{$averageWorkHrsForCurrentMonth}}</p>


                            <div>


                                   @if($percentageinworkhrsforattendance>0)
                                            <span class="text-success ng-star-inserted" style="font-size:10px;"> +{{intval($percentageinworkhrsforattendance)}}%
                                            </span>
                                            <span class="text-muted" style="font-size:10px;margin-left:0px;"> From {{ \Carbon\Carbon::createFromDate($year, $month, 1)->subMonth()->format('F') }}
                                            </span>
                                   @elseif($percentageinworkhrsforattendance==0)
                                            <span class="text-success ng-star-inserted" style="font-size:10px;"> {{intval($percentageinworkhrsforattendance)}}%
                                            </span>
                                            <span class="text-muted" style="font-size:10px;margin-left:0px;"> From {{ \Carbon\Carbon::createFromDate($year, $month, 1)->subMonth()->format('F') }}
                                            </span>        
                                   @elseif($percentageinworkhrsforattendance<0) 
                                       <span class="text-danger ng-star-inserted" style="font-size:10px;"> {{intval($percentageinworkhrsforattendance)}}%
                                        </span>
                                        <span class="text-muted" style="font-size:10px;margin-left:0px;"> From {{ \Carbon\Carbon::createFromDate($year, $month, 1)->subMonth()->format('F') }}
                                        </span> 
                                       
                                    @endif
                            </div>

                        </section>
                    </div>
                </div>

                <div class="penalty-and-average-work-hours-card mb-3 col-md-3">
                    <div class="insight-card  bg-white pt-2 pb-2" style="height: 135px;">
                        <h6 class="text-secondary text-regular text-center" style="font-size:12px;border-bottom:1px solid #ccc;padding-bottom:5px;"> Penalty Days </h6>
                        <section class="text-center">
                            <p class="text-2" style="margin-top:30px;"> 0 </p>
                        </section>
                    </div>
                </div>
                <div class="col-md-2 mt-5" style="text-align: center">
                    <a href="#" class="attendanceperiod" wire:click="öpenattendanceperiodModal">
                        Insights
                    </a>
                </div>
            </div>
            @if ($öpenattendanceperiod==true)
            
            <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
                    <div class="modal-content attendance-period">
                        <div class="modal-header" style="background-color: rgb(2, 17, 79); height: 50px;display: flex; justify-content: space-between; align-items: center;">
                            <p class="modal-title attendance-period-header" style="color:white;">
                                {{$modalTitle}}

                            </p>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeattendanceperiodModal" style="background: none; border: none;">
                                <span aria-hidden="true" class="close-btn" style="color: white; font-size: 30px;">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                          @if ($errors->has('date_range'))
                                     <span class="text-danger text-center"style="padding-left:200px;">{{ $errors->first('date_range') }}</span>
                          @endif
                            <div class="form-row" style="display: flex; justify-content: center;">
                                <div class="form-group col-md-3 col-sm-6 start-date-for-attend-period">
                                    <label for="fromDate" style="color: #778899; font-size: 12px; font-weight: 500;">From
                                        Date</label>
                                    <input type="date" class="form-control" id="fromDate" wire:model="start_date_for_insights" name="fromDate" wire:change="calculateTotalDays" style="color: #778899;">
                                </div>
                                <div class="form-group col-md-3 col-sm-6">
                                    <label for="toDate" style="color: #778899; font-size: 12px; font-weight: 500;">To
                                        Date</label>
                                    <input type="date" class="form-control" id="toDate" name="toDate" wire:model="to_date" wire:change="calculateTotalDays" style="color: #778899;">
                                </div>
                            </div>
                            <p style="font-size:12px;margin-top:3px">Total Working Days:&nbsp;&nbsp;<span style="font-weight:bold;">{{$totalWorkingDays}}</span></p>

                            <div class="table-responsive">


                                <table class="attendence-period-table">
                                    <thead>
                                        <tr>
                                            <th class="insights-for-attendance-period-avg-working-hours">Avg. Work Hrs</th>
                                            <th class="insights-for-attendance-period-avg-working-hours">Avg. Actual Work Hrs</th>
                                            <th class="insights-for-attendance-period">Penalty Days</th>
                                            <th class="insights-for-attendance-period">Late In</th>
                                            <th class="insights-for-attendance-period">Early Out</th>
                                            <th class="insights-for-attendance-period">Leave Taken</th>
                                            <th class="insights-for-attendance-period">Absent Days</th>
                                            <th class="insights-for-attendance-period">Exception Days</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="insights-for-attendance-period-avg-working-hours">
                                                      <section class="text-center">
                                                               <p class="text-2" style="margin-top:30px;">{{$averageWorkHoursForModalTitle}}</p>
                                                                        

                                    l                 </section>
                                            </td>
                                            <td class="insights-for-attendance-period-avg-working-hours">

                                            <section class="text-center">
                                                               <p class="text-2" style="margin-top:30px;">{{$averageWorkHoursForModalTitle}}</p>
                                                                       
                                                     </section>
                                            </td>
                                            <td class="insights-for-attendance-period">0</td>
                                            <td class="insights-for-attendance-period">{{$totalLateInSwipes}}</td>
                                            <td class="insights-for-attendance-period">{{$totalnumberofEarlyOut}}</td>
                                            <td class="insights-for-attendance-period">{{$totalnumberofLeaves}}</td>
                                            <td class="insights-for-attendance-period">{{$totalnumberofAbsents}}</td>
                                            <td class="insights-for-attendance-period">-</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="row m-0 mt-3 average-first-and-last-time">
                                <div class="col-md-3 col-sm-6 p-0">
                                    <p style="font-size:12px;color:#778899;">Avg First In Time:&nbsp;&nbsp;<span style="font-weight:600;color:black;">{{$avergageFirstInTime}}</span></p>
                                </div>
                                <div class="col-md-3 col-sm-6 p-0">
                                    <p style="font-size:12px;color:#778899;">Avg Last Out Time:&nbsp;&nbsp;<span style="font-weight:600;color:black;">{{$averageLastOutTime}}</span></p>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show blurred-backdrop"></div>
        @endif


        <div class="row m-0 mt-3">
            <div class="col-6" style="text-align: left">
                <a href="#" id="toggleSidebar" class="gt-overlay-toggle" style="margin-top:69px;color:rgb(2, 17, 79); display: none">Legend</a>
            </div>
            <div class="col-12">
                <div class="toggle-box-attendance-info">
                    <i class="fas fa-calendar" id="calendar-icon" style="cursor:pointer;padding:2px 2px;color: {{ ($defaultfaCalendar == 1 )? '#fff' : 'rgb(2,17,79)' }};background-color: {{ ($defaultfaCalendar == 1 )? 'rgb(2,17,79)' : '#fff' }};" wire:click="showBars"></i>
                    <i class="fas fa-bars" id="bars-icon" style="cursor:pointer;padding:2px 2px;color: {{ ($defaultfaCalendar == 0 )? '#fff' : 'rgb(2,17,79)' }};background-color: {{ ($defaultfaCalendar == 0 )? 'rgb(2,17,79)' : '#fff' }};" wire:click="showTable"></i>
                </div>
            </div>
        </div>






        @php
        $Regularised=false;
        @endphp




        <div class="row m-0 p-0">
            @if($defaultfaCalendar==1)
            <div class="col-12 col-md-7 m-0 p-1 calendar custom-scrollbar">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="calendar-heading-container">
                        <button wire:click="beforeMonth" class="nav-btn">&lt; Prev</button>
                        <p style="font-size: 14px;color:black;font-weight:500;margin-bottom:0;">{{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}</p>
                        <button wire:click="nextMonth" class="nav-btn">Next &gt;</button>
                    </div>
                </div>
                <!-- Calendar -->
                <div class="table-responsive">
                    <table class="table-1 table-bordered">
                        <thead class="calender-header bg-white">
                            <tr>
                                <th class="text">Sun</th>
                                <th class="text">Mon</th>
                                <th class="text">Tue</th>
                                <th class="text">Wed</th>
                                <th class="text">Thu</th>
                                <th class="text">Fri</th>
                                <th class="text">Sat</th>
                            </tr>
                        </thead>
                        <tbody id="calendar-body">
                            @if(!empty($calendar))
                            @foreach($calendar as $week)
                            <tr>
                                @foreach($week as $day)
                                @php
                                $carbonDate = \Carbon\Carbon::createFromDate($year, $month, $day['day']);

                                $formattedDate = $carbonDate->format('Y-m-d');
                                $formattedDate1 = $carbonDate->format('Y-m-d');
                                $isCurrentMonth = $day['isCurrentMonth'];
                                $isWeekend = in_array($carbonDate->dayOfWeek, [0, 6]); // 0 for Sunday, 6 for Saturday
                                $isActiveDate = ($selectedDate === $carbonDate->toDateString());
                                @endphp


                                @if ($day)
                                @if(strtotime($formattedDate) < strtotime(date('Y-m-d'))) @php $flag=1; @endphp @else @php $flag=0; @endphp @endif @if($day['status']=='CLP' ||$day['status']=='SL' ||$day['status']=='LOP'||$day['status']=='CL'||$day['status']=='ML'||$day['status']=='PL'||$day['status']=='L') @php $leave=1; @endphp @else @php $leave=0; @endphp @endif <td wire:click="dateClicked('{{$formattedDate}}')" wire:model="dateclicked" class="attendance-calendar-date {{ $isCurrentMonth && !$isWeekend ? 'clickable-date' : '' }}" style="text-align:start;color: {{ $isCurrentMonth ? ($isWeekend ? '#c5cdd4' : 'black')  : '#c5cdd4'}};background-color:  @if($isCurrentMonth && !$isWeekend && $flag==1 ) @if($day['isPublicHoliday'] ) #f3faff @elseif($leave == 1) rgb(252, 242, 255) @elseif($day['status'] == 'A') #fcf0f0 @elseif($day['status'] == 'P') #edfaed @endif @elseif($isCurrentMonth && $isWeekend && $flag==1)rgb(247, 247, 247) @endif ;">
                                    <div>

                                       @if($day['status']=='HP'&&!$day['isToday']&&!$isWeekend)
                                                <div style="background-color:#edfaed;margin:-3px;height: 45px;display: flex; justify-content: center; align-items: center;position: relative;">
                                                        
                                                         <span style="position: absolute; left: 2px;top:2px;">{{ str_pad($day['day'], 2, '0', STR_PAD_LEFT) }}</span>
                                                        <span class="text-secondary">P</span>
                                                        
                                                </div>
                                                

                                       @else
                                                <div>
                                                        @if ($day['isToday'])
                                                        <div style="background-color: rgb(2,17,79); color: white; border-radius: 50%; width: 24px; height: 24px; text-align: center; line-height: 24px;">
                                                            {{ str_pad($day['day'], 2, '0', STR_PAD_LEFT) }}
                                                        </div>
                                                        @else
                                                        {{ str_pad($day['day'], 2, '0', STR_PAD_LEFT) }}
                                                        @endif

                                                </div>
                                                

                                       @endif

                                        @if($day['status']=='HP'&&!$day['isToday'])

                                        <div class="{{ $isWeekend ? '' : 'circle-grey' }}"style="background-color:#fcf0f0;margin: -3px;">
                                            <!-- Render your grey circle -->
                                            @if ($isWeekend&&$isCurrentMonth)
                                            <i class="fas fa-tv" style="float:right;padding-left:8px;margin-top:-15px;"></i>

                                            <span style="text-align:center;color: #7f8fa4; padding-left:21px;padding-right:26px;margin-left: 6px;white-space: nowrap;">
                                                O
                                            </span>
                                            @elseif($isCurrentMonth)


                                            @if(strtotime($formattedDate) < strtotime(date('Y-m-d'))) <span style="display: flex; justify-content: center; align-items: center; width: 20px; height: 20px; border-radius: 50%; white-space: nowrap;">

                                                @if($day['isPublicHoliday'])
                                                <span style="background-color: #f3faff;text-align:center;color: #7f8fa4; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">H</span>
                                                @elseif($day['status'] == 'CLP')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">CLP</span>
                                                @elseif($day['status'] == 'SL')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">SL</span>
                                                @elseif($day['status'] == 'LOP')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">LOP</span>
                                                @elseif($day['status'] == 'CL')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">CL</span>
                                                @elseif($day['status'] == 'ML')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">ML</span>
                                                @elseif($day['status'] == 'PL')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">PL</span>
                                                @elseif($day['status'] == 'L')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">L</span>
                                                @elseif($day['status'] == 'A')
                                                  
                                                <span style="color:#ff6666; background-color: #fcf0f0;text-align:center;padding-left:30px;margin-left: 37px;white-space: nowrap;padding-top:5px">A</span>
                    

                                                @elseif($day['status'] == 'P')
                                                   
                                                   <span style="background-color:#edfaed; text-align:center; color: #7f8fa4; padding-left:30px; margin-left: 37px;white-space: nowrap;padding-top:10px">P</span>
                                                   
                                                @endif


                                                </span>
                                                @endif
                                                @if($day['status']=='HP')
                                                
                                                <span style="padding-left:12px;width:10px;height:10px;border-radius:50%;color:#f66;padding-left: 39px;margin-top: -5px;">
                                                    A
                                                </span>
                                                @endif
                                                @if($day['isRegularised']==true&&($day['status']=='CLP' ||$day['status']=='SL' ||$day['status']=='LOP'||$day['status']=='CL'||$day['status']=='ML'||$day['status']=='PL'||$day['status']=='MTL'||$day['status']=='L'))
                                                @php
                                                $Regularised=true;
                                                @endphp
                                                
                                                @if($day['status']=='P')
                                                <span style="display:flex;text-align:start;width:10px;height:10px;border-radius:50%;padding-right: 10px; margin-right:25px;">
                                                    <div class="down-arrow-reg"></div>
                                                </span>
                                                @endif
                                                @endif
                                                @if(strtotime($formattedDate) >= strtotime(date('Y-m-d')))
                                                <span style="display: flex; text-align:end;width:10px;height:10px;border-radius:50%;padding-left: 60px; margin-right:12px;white-space: nowrap;">
                                                    <p style="color: #a3b2c7;margin-top:30px;font-weight: 400;">{{$employee->shift_type}}</p>
                                                </span>
                                                @elseif($day['status']=='HP')
                                                <div style="background-color:#fcf0f0;">
                                                    <span style="display: flex; text-align:end;width:10px;height:30px;margin-top:-23px;border-radius:50%;padding-left: 60px; margin-right:12px;white-space: nowrap;">
                                                        <p style="color: #a3b2c7;margin-top: 6px;padding-left: 4px;font-weight: 300;">{{$employee->shift_type}}</p>
                                                    </span>
                                                </div>
                                                @elseif($isCurrentMonth)
                                                @if($day['isRegularised']==true)
                                                <span style="display: flex; text-align:end;width:10px;height:10px;border-radius:50%;padding-left: 60px;margin-right:20px; white-space: nowrap;">
                                                    <p style="color: #a3b2c7;margin-top:5px;font-weight: 400;">{{$employee->shift_type}}</p>
                                                </span>
                                                @else
                                                <span style="display: flex; text-align:end;width:10px;height:10px;border-radius:50%;padding-left: 60px;margin-right:20px; white-space: nowrap;">
                                                    <p style="color: #a3b2c7;margin-top:15px;font-weight: 400;">{{$employee->shift_type}}</p>
                                                </span>

                                                @endif
                                                @endif
                                                @endif
                                        </div>
                                        @else

                                        <div class="{{ $isWeekend ? '' : 'circle-grey' }}">
                                            <!-- Render your grey circle -->
                                            @if ($isWeekend&&$isCurrentMonth)
                                            <i class="fas fa-tv" style="float:right;padding-left:8px;margin-top:-15px;"></i>

                                            <span style="text-align:center;color: #7f8fa4; padding-left:21px;padding-right:26px;margin-left: 6px;white-space: nowrap;">
                                                O
                                            </span>
                                            @elseif($isCurrentMonth)


                                            @if(strtotime($formattedDate) < strtotime(date('Y-m-d'))) <span style="display: flex; justify-content: center; align-items: center; width: 20px; height: 20px; border-radius: 50%; white-space: nowrap;">

                                                @if($day['isPublicHoliday'])
                                                <span style="background-color: #f3faff;text-align:center;color: #7f8fa4; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">H</span>
                                                @elseif($day['status'] == 'CLP')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">CLP</span>
                                                @elseif($day['status'] == 'SL')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">SL</span>
                                                @elseif($day['status'] == 'LOP')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">LOP</span>
                                                @elseif($day['status'] == 'CL')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">CL</span>
                                                @elseif($day['status'] == 'ML')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">ML</span>
                                                @elseif($day['status'] == 'PL')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">PL</span>
                                                @elseif($day['status'] == 'L')
                                                <span style="background-color:  rgb(252, 242, 255);color: #7f8fa4;text-align:center; padding-left: 30px; margin-left: 37px;white-space: nowrap;padding-top:5px">L</span>
                                                @elseif($day['status'] == 'A')
                                                  
                                                <span style="color:#ff6666; background-color: #fcf0f0;text-align:center;padding-left:30px;margin-left: 37px;white-space: nowrap;padding-top:5px">A</span>
                    
                                                @elseif($day['status'] == 'HP')
                                                   
                                                   <span style="text-align:center; color: #7f8fa4; padding-left:30px; margin-left: 33px;white-space: nowrap;padding-bottom:10px;">:</span>

                                                @elseif($day['status'] == 'P')
                                                   
                                                   <span style="background-color:#edfaed; text-align:center; color: #7f8fa4; padding-left:30px; margin-left: 37px;white-space: nowrap;padding-top:10px">P</span>
                                                   
                                                @endif


                                                </span>
                                                @endif
                                                @if($day['isRegularised']==true&&($day['status']=='CLP' ||$day['status']=='SL' ||$day['status']=='LOP'||$day['status']=='CL'||$day['status']=='ML'||$day['status']=='PL'||$day['status']=='MTL'||$day['status']=='L'))
                                                @php
                                                $Regularised=true;
                                                @endphp
                                                @if($day['status']=='P')
                                                <span style="display:flex;text-align:start;width:10px;height:10px;border-radius:50%;padding-right: 10px; margin-right:25px;">
                                                    <div class="down-arrow-reg"></div>
                                                </span>
                                                @endif
                                                @endif
                                                @if(strtotime($formattedDate) >= strtotime(date('Y-m-d')))
                                                <span style="display: flex; text-align:end;width:10px;height:10px;border-radius:50%;padding-left: 60px; margin-right:12px;white-space: nowrap;">
                                                    <p style="color: #a3b2c7;margin-top:30px;font-weight: 400;">{{$employee->shift_type}}</p>
                                                </span>
                                                @elseif($day['status']=='HP')
                                                <span style="display: flex; text-align:end;width:10px;height:10px;border-radius:50%;padding-left: 60px; margin-right:12px;white-space: nowrap;">
                                                    <p style="color: #a3b2c7;font-weight: 400;">{{$employee->shift_type}}</p>
                                                </span>
                                                @elseif($isCurrentMonth)
                                                @if($day['isRegularised']==true)
                                                <span style="display: flex; text-align:end;width:10px;height:10px;border-radius:50%;padding-left: 60px;margin-right:20px; white-space: nowrap;">
                                                    <p style="color: #a3b2c7;margin-top:5px;font-weight: 400;">{{$employee->shift_type}}</p>
                                                </span>
                                                @else
                                                <span style="display: flex; text-align:end;width:10px;height:10px;border-radius:50%;padding-left: 60px;margin-right:20px; white-space: nowrap;">
                                                    <p style="color: #a3b2c7;margin-top:15px;font-weight: 400;">{{$employee->shift_type}}</p>
                                                </span>

                                                @endif
                                                @endif
                                                @endif
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                    </td>

                                    @endforeach
                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                    @else
                    <p>No calendar data available</p>
                    @endif
                </div>

                <button class="accordion"wire:click="openlegend">Legends
                    <span class="accordion-icon">
                            @if($legend)
                                &#x2796; <!-- Unicode for minus sign -->
                            @else
                                &#x2795; <!-- Unicode for plus sign -->
                            @endif
                    </span>
                </button>
                <div class="panel"style="display: {{ $legend ? 'block' : 'none' }};">
                    <div class="row m-0 mt-3 mb-3">
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="me-2 mb-0">
                                <span class="legendsIcon presentIcon">P</span>
                            </p>
                            <p class="legendtext m-0">Present</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="me-2 mb-0">
                                <span class="legendsIcon absentIcon">A</span>
                            </p>
                            <p class="legendtext m-0">Absent</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="me-2 mb-0">
                                <span class="legendsIcon offDayIcon">O</span>
                            </p>
                            <p class="legendtext m-0">Off Day</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="me-2 mb-0">
                                <span class="legendsIcon offDayIcon">R</span>
                            </p>
                            <p class="legendtext m-0">Rest Day</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="me-2 mb-0">
                                <span class="legendsIcon leaveIcon">L</span>
                            </p>
                            <p class="legendtext m-0">Leave</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="me-2 mb-0">
                                <span class="legendsIcon onDutyIcon">OD</span>
                            </p>
                            <p class="legendtext m-0">On Duty</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="me-2 mb-0">
                                <span class="legendsIcon holidayIcon">H</span>
                            </p>
                            <p class="legendtext m-0">Holiday</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="me-2 mb-0">
                                <span class="legendsIcon deductionIcon">&nbsp;&nbsp;</span>
                            </p>
                            <p class="legendtext m-0" style="word-break: break-all;"> Deduction</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="me-2 mb-0">
                                <span class="legendsIcon alertForDeIcon">&nbsp;&nbsp;</span>
                            </p>
                            <p class="legendtext m-0">Allert for Deduction</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="me-2 mb-0">
                                <span class="legendsIcon absentIcon">?</span>
                            </p>
                            <p class="legendtext m-0">Status Unknown</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="me-2 mb-0">
                                <i class="far fa-clock"></i>
                            </p>
                            <p class="legendtext m-0">Overtime</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="me-2 mb-0">
                                <i class="far fa-edit"></i>
                            </p>
                            <p class="legendtext m-0">Override</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="legendTriangleIcon me-2 mb-0">
                            <div class="down-arrow-ign-attendance-info"></div>
                            </p>
                            <p class="legendtext m-0">Ignored</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="legendTriangleIcon me-2 mb-0">
                            <div class="down-arrow-gra"></div>
                            </p>
                            <p class="legendtext m-0">Grace</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="legendTriangleIcon me-2 mb-0">
                            <div class="down-arrow-reg"></div>
                            </p>
                            <p class="legendtext m-0">Regularized</p>
                        </div>
                    </div>
                    <div class="row m-0 mb-3">
                        <h6 class="m-0 p-2 mb-2" style="background-color: #f1f4f7">Day Type</h6>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="mb-0">
                                <i class="fas fa-mug-hot"></i>
                            </p>
                            <p class="m-1 pb-2 attendance-legend-text">Rest Day</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="mb-0">
                                <i class="fas fa-tv"></i>
                            </p>
                            <p class="m-1 attendance-legend-text"style="margin-bottom:14px;">Off Day</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="mb-0">
                                <i class="fas fa-umbrella"></i>
                            </p>
                            <p class="m-1 pb-2 attendance-legend-text">Holiday</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="mb-0">
                                <i class="fas fa-calendar-day"></i>
                            </p>
                            <p class="m-1  pb-2 attendance-legend-text">Half Day</p>
                        </div>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="mb-0">
                                <i class="fas fa-battery-empty"></i>
                            </p>
                            <p class="m-1 attendance-legend-text">IT Maintanance</p>
                        </div>
                    </div>
                    <div class="row m-0 mb-3">
                        <h6 class="m-0 p-2 mb-2" style="background-color: #f1f4f7">Leave Type</h6>
                        <div class="col-md-3 mb-2 pe-0" style="display: flex">
                            <p class="mb-0">
                                <span class="legendsIcon sickleaveIcon">SL</span>
                            </p>
                            <p class="m-1 attendance-legend-text">Sick Leave</p>
                        </div>



                    </div>
                </div>

            </div>
            @endif
            @if($defaultfaCalendar==0)
            @livewire('attendance-table')

            @endif
            <div class="col-md-5 custom-scrollbar-for-right-side-container">
                @if($defaultfaCalendar==1)
                <div class="container1">
                    <!-- Content goes here -->
                    <div class="row m-0">
                        <div class="col-2 pb-1 pt-1 p-0 container1box">
                            <p class="mb-1 container1boxDate">{{ \Carbon\Carbon::parse($currentDate2)->format('d') }}</p>
                            <p class="m-0 container1boxDay">
                                {{ \Carbon\Carbon::parse($currentDate2)->format('D') }}
                            </p>
                        </div>
                        <div class="col-5 pb-1 pt-1">

                            <p class="text-overflow mb-1" style="font-size:12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;font-weight: 500;">
                                10:00 am to 07:00 pm</p>
                            <p class="text-muted m-0" style="font-size:12px;">Shift:10:00 to
                                19:00</p>
                        </div>
                        <div class="col-5 pb-1 pt-1">
                            <p class="mb-1" style="font-size:12px;overflow: hidden;font-weight: 500;text-overflow: ellipsis;white-space: nowrap;font-weight: 500;">
                                10:00 am to 07:00 pm</p>
                            <p class="text-muted m-0" style="font-size:12px;">Attendance
                                Scheme</p>

                        </div>
                    </div>


                    <div class="horizontal-line-attendance-info"></div>
                    @if($changeDate==1)
                    @php
                    $nextDayDate = \Carbon\Carbon::parse($CurrentDate)->addDay()->setTime(0, 0, 0);
                    @endphp
                    <div class="text-muted" style="margin-left:20px;font-weight: 400;font-size: 12px;">Processed On {{ $nextDayDate->format('jS M') }}</div>
                    @else
                    <div class="text-muted" style="margin-left:20px;font-weight: 400;font-size: 12px;">Processed On</div>
                    @endif
                    <div class="horizontal-line1-attendance-info"></div>
                    <div class="table-responsive"style=" overflow-x: auto; max-width: 100%;">
                        <table>
                            <thead>
                                <tr>
                                    <th class="attendance-info-table-head">First&nbsp;In</th>
                                    <th class="attendance-info-table-head">Last&nbsp;Out</th>
                                    <th class="attendance-info-table-head">Total&nbsp;Work&nbsp;Hrs</th>
                                    <th class="attendance-info-table-head">Break&nbsp;Hrs</th>
                                    <th class="attendance-info-table-head">Actual&nbsp;Work&nbsp;Hrs</th>
                                    <th class="attendance-info-table-head">
                                        Work&nbsp;Hours&nbsp;in&nbsp;Shift&nbsp;Time</th>
                                    <th class="attendance-info-table-head">Shortfall&nbsp;Hrs</th>
                                    <th class="attendance-info-table-head">Excess&nbsp;Hrs</th>
                                </tr>
                            </thead>
                            <tbody>


                                <tr>

                                    <td class="attendance-info-table-data">
                                        @if($changeDate==1)
                                        {{$this->first_in_time}}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="attendance-info-table-data">
                                        @if($changeDate==1)
                                        {{$this->last_out_time}}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if($this->first_in_time!=$this->last_out_time)
                                        {{str_pad($this->hours, 2, '0', STR_PAD_LEFT)}}:{{str_pad($this->minutesFormatted,2,'0',STR_PAD_LEFT)}}
                                        @else
                                        -
                                        @endif

                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>{{$this->work_hrs_in_shift_time}}</td>
                                    <td>
                                         {{$this->shortFallHrs}}
                                    </td>
                                    <td>{{$this->excessHrs}}</td>

                                </tr>


                                <!-- Add more rows with dashes as needed -->
                            </tbody>
                            <!-- Add table rows (tbody) and data here if needed -->
                        </table>

                    </div>
                </div>
                @endif
                @if($defaultfaCalendar==1)
                <div class="container2">
                    <h3 class="container2-status-details-heading">Status Details</h3>

                    <div class="container2-table-scrollable">
                        <table class="container2-table">
                            <thead>
                                <tr>
                                    <th class="container2-table-head">Status</th>
                                    <th class="container2-table-head">Remarks</th>
                                    <th class="container2-table-head"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @php


                                        $CurrentDate = $currentDate2;
                                        $swiperecord = App\Models\SwipeRecord::where('emp_id', $employeeIdForRegularisation)->where('is_regularized',1)->get(); // Example query

                                        if ($swiperecord && is_iterable($swiperecord)) {
                                        $swipeRecordExists = $swiperecord->contains(function ($record) use ($CurrentDate) {
                                        return \Carbon\Carbon::parse($record->created_at)->toDateString() === $CurrentDate;
                                        });
                                        } else {
                                        $swipeRecordExists = false;
                                        }
                                        @endphp

                                        @if($swipeRecordExists==true)
                                        Regularisation
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>-</td>
                                    @if($swipeRecordExists==true)
                                    <td>
                                        <button type="button" class="info-button"wire:click="checkDateInRegularisationEntries('{{$CurrentDate}}')">
                                            Info
                                        </button>
                                        @if($showRegularisationDialog==true)

                                        <div class="modal modal-show" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">

                                                    <div class="modal-header regularisation-dialog-head-modal">
                                                        <h5 class="regularisation-dialog-head-modal-heading modal-title"><b>Regularisation&nbsp;&nbsp;Details</b></h5>
                                                        <button type="button" class="regularisation-close btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closeRegularisationModal">
                                                        </button>
                                                    </div>
                                                    <div class="regularisation-dialog-head-modal-body modal-body">
                                                        <div class="row m-0 mt-3">

                                                            <div class="col regularisation-dialog-head-modal-body-label">Status : <br /><span class="regularisation-dialog-head-modal-body-insidelabel">Regularization</span></div>
                                                            <div class="col regularisation-dialog-head-modal-body-label">Regularized By: <br /><span class="regularisation-dialog-head-modal-body-insidelabel">{{ucwords(strtolower($regularised_by))}}</span></div>
                                                        </div>
                                                        <div class="row m-0 mt-3">
                                                            <div class="col regularisation-dialog-head-modal-body-label">Regularized Date : <br /><span class="regularisation-dialog-head-modal-body-insidelabel">{{ date('jS M,Y', strtotime($regularised_date)) }}</span></div>
                                                            <div class="col regularisation-dialog-head-modal-body-label">Regularized Time: <br /><span class="regularisation-dialog-head-modal-body-insidelabel">{{ date('H:i:s', strtotime($regularised_date)) }}</span></div>
                                                        </div>
                                                        <div class="row m-0 mt-3">
                                                            <div class="col regularisation-dialog-head-modal-body-label"> Reason:<br /> <span class="regularisation-dialog-head-modal-body-insidelabel">{{$regularised_reason}}</span></div>
                                                        </div>
                                                        <div class="regularisation-dialog-head-modal-body-button">
                                                                 <button class="cancel-btn"wire:click="closeRegularisationModal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-backdrop fade show blurred-backdrop"></div>

                                        @endif
                                    </td>
                                    @endif
                                </tr>
                                <!-- Add more rows with dashes as needed -->
                            </tbody>
                            <!-- Add table rows (tbody) and data here if needed -->
                        </table>
                    </div>
                </div>
                @endif
                @if($defaultfaCalendar==1)
                <div class="container3">
                    <h3 class="container3-head">Session Details</h3>

                    <div class="container3-table-scrollable">
                        <table class="container3-table">
                            <thead>
                                <tr>
                                    <th class="container3-table-head">Session</th>
                                    <th class="container3-table-head">Session&nbsp;Timing</th>
                                    <th class="container3-table-head">First&nbsp;In</th>
                                    <th class="container3-table-head">Last&nbsp;Out</th>

                                </tr>
                            </thead>

                            <tbody>

                                <tr class="container3-table-row">
                                    <td class="container3-table-data">Session&nbsp;1</td>
                                    <td class="container3-table-data">10:00 - 14:00</td>
                                    <td class="container3-table-data">
                                        @if($changeDate==1)
                                        {{$this->first_in_time}}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="container3-table-data">-</td>

                                </tr>
                                <tr class="container3-table-row">
                                    <td class="container3-table-data">Session&nbsp;2</td>
                                    <td class="container3-table-data">14:01 - 19:00</td>
                                    <td class="container3-table-data">-</td>
                                    <td class="container3-table-data">
                                        @if($changeDate==1)
                                        {{$this->last_out_time}}
                                        @else
                                        -
                                        @endif
                                    </td>

                                </tr>
                                <!-- Add more rows with dashes as needed -->
                            </tbody>
                            <!-- Add table rows (tbody) and data here if needed -->
                        </table>
                    </div>

                </div>
                @endif
                @if($defaultfaCalendar==1)
                <div class="container6">
                    <h3 class="container6-head">Swipe Details</h3>
                    <div class="arrow-btn container6-button {{ $toggleButton ? 'arrow-btn-active' : 'arrow-btn-inactive' }}"wire:click="opentoggleButton">
                        <i class="fa fa-angle-{{ $toggleButton ? 'down' : 'up' }} icon-btn {{ $toggleButton ? 'icon-btn-active' : 'icon-btn-inactive' }}"></i>
                    </div>

                    <div class="container-body {{ $toggleButton ? 'container-body-active' : 'container-body-inactive' }}">
                        <!-- Content of the container body -->
                        <div class="table-responsive container-body-scrollable">

                            <table>
                               @if ($swipe_records_count > 0)
                                <thead>

                                    <tr>
                                        <th class="container3-table-data">In/Out</th>
                                        <th class="container3-table-data">Swipe&nbsp;Time</th>
                                        <th class="container3-table-data">Location</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach ($swiperecordsfortoggleButton as $index =>$swiperecord)
                                <tr>
                                       <td class="container3-table-data">{{ $swiperecord->in_or_out }}</td>
                                       <td>
                                           <div class="swipe-record">
                                               <p class="swipe-record-swipe-time">
                                                   {{ date('h:i:s A', strtotime($swiperecord->swipe_time)) }}
                                               </p>
                                               <p class="swipe-record-date">
                                                   {{ date('d M Y', strtotime($currentDate2)) }}
                                               </p>
                                           </div>
                                       </td>
                                       <td class="container3-table-location">{{$this->city}},{{$this->country}},{{$this->postal_code}}</td>

                                       <td><button class="info-button" wire:click="viewDetails('{{$swiperecord->id}}')">Info</button></td>

                                   </tr>
                                   @if (($index + 1) % 2 == 0)
                                   <!-- Add a small container after every two records -->
                                   <tr>
                                       <td colspan="4" class="container3-table-actual-hours">
                                           Actual Hrs:{{ $actualHours[($index + 1) / 2 - 1] }}</td>
                                   </tr>

                                   @endif

                                @endforeach


                                    <!-- Add more rows with dashes as needed -->
                                </tbody>
                                <!-- Add table rows (tbody) and data here if needed -->
                                @else
                                <img src="https://linckia.cdn.greytip.com/static-ess-v6.3.0-prod-1543/attendace_swipe_empty.svg" style="margin-top:30px;">
                                <div class="text-muted">No record Found</div>
                                @endif
                            </table>

                        </div>

                    </div>
                    @endif
                    @if($showSR=="true")
                    <div class="modal modal-show" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header regularisation-dialog-head-modal">
                                    <h5 class="regularisation-dialog-head-modal-heading" class="modal-title"><b>Swipe Details</b></h5>
                                    <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closeSWIPESR" style="background-color: #eef7fa; height:10px;width:10px;">
                                    </button>
                                </div>
                                <div class="modal-body" style="max-height:300px;">
                                    @if($swiperecord)
                                    <div class="row m-0 mt-3">


                                              <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Employee&nbsp;Name:<br /><span style="color: #000000;">{{ ucwords(strtolower($employee->first_name)) }} {{ ucwords(strtolower($employee->last_name)) }}</span></div>

                                        <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Employee&nbsp;Id<br /><span style="color: #000000;">{{ $swiperecord->emp_id }}</span></div>

                                    </div>
                                    <div class="row m-0 mt-3">


                                        <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Swipe&nbsp;Date:<br /><span style="color: #000000;">{{\Carbon\Carbon::parse($swiperecord->created_at)->format('jS F, Y')}}</span></div>

                                        <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Swipe&nbsp;Time:<br /><span style="color: #000000;">{{ $view_student_swipe_time }}</span></div>

                                    </div>
                                    <div class="row m-0 mt-3">


                                        <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">In/Out:<br /><span style="color: #000000;">{{ $view_student_in_or_out }}</span></div>

                                        <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Access&nbsp;Card&nbsp;Number:<br /><span style="color: #000000;">-</span></div>

                                    </div>
                                    <div class="row m-0 mt-3">



                                        <div class="col" style="font-size: 11px;color:#778899;font-weight:500;">Location<br /><span style="color: #000000;">{{$this->city}},{{$this->country}},{{$this->postal_code}}</span></div>

                                    </div>
                                    @endif
                                    <div style="display: flex; justify-content: center; margin-top: 20px;">
                                            <button class="cancel-btn" style="border:1px solid rgb(2, 17, 79);"wire:click="closeSWIPESR">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-backdrop fade show blurred-backdrop"></div>
                    @endif

                </div>
            </div>
        </div>



    </div>

















   


</div>

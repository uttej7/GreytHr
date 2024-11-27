<div>
    @php
    $employeeId = auth()->guard('emp')->user()->emp_id;
    $managerId = DB::table('employee_details')
    ->where('manager_id', $employeeId)->value('manager_id');
    @endphp
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <!-- <i class='bx bxs-smile icon'></i> -->
            <img class="m-auto" src="{{ asset('images/hr_new_blue.png') }}" alt="Company Logo" style="width: 6em !important;">
        </a>
        <ul class="side-menu">
            <li><a href="/" class="active"><i class='fas fa-home icon'></i> Home</a></li>

            <li>
                <a href="#"><i class='fas fa-clock icon'></i> Time Sheets <i class='fa fa-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="/time-sheet">Time Sheet</a></li>
                    @if ($managerId)
                    <li>
                        <a href="/team-time-sheets">
                            Team Time Sheets
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            <li><a href="/Feeds"><i class='fas fa-rss icon'></i> Feeds</a></li>
            <li><a href="/PeoplesList"><i class='fas fa-users icon'></i> People</a></li>
            <!-- <li class="divider" data-text="main">Main</li> -->
            <li>
                <a href="#"><i class='fas fa-file-alt icon'></i> To Do <i class='fa fa-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="/tasks">Tasks</a></li>
                    <li><a href="/employees-review">Review</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class='fas fas-solid fa-money-bill-transfer icon'></i> Salary <i class='fa fa-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="/slip">Payslips</a></li>
                    <li><a href="/ytd">YTD Reports</a></li>
                    <li><a href="/itstatement">IT Statement</a></li>
                    <li><a href="/formdeclaration">IT Declaration</a></li>
                    <li><a href="/reimbursement">Reimbursement</a></li>
                    <li><a href="/investment">Proof of Investment</a></li>
                    <li><a href="/salary-revision">Salary Revision</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class='fas fa-file-alt icon'></i> Leave <i class='fa fa-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="/leave-form-page">Leave Apply</a></li>
                    <li><a href="/leave-balances">Leave Balances</a></li>
                    <li><a href="/leave-calender">Leave Calendar</a></li>
                    <li><a href="/holiday-calendar">Holiday Calendar</a></li>
                    @if($managerId)
                    <li>
                        <a href="/team-on-leave-chart">
                            <span>Team on Leave</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            <li>
                <a href="#"><i class='fas fa-clock icon'></i> Attendance <i class='fa fa-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="/Attendance">Attendance Info</a></li>
                    @if ($managerId)
                    <li>
                        <a href="/whoisinchart">
                        <span>Who is in</span>
                        </a>
                    </li>
                    <li>
                        <a href="/employee-swipes-data">
                            <span>Employee Swipes</span>
                        </a>
                    </li>
                    <li>
                        <a href="/attendance-muster-data">
                            <span>Attendance Muster</span>
                        </a>
                    </li>
                    <li>
                        <a href="/shift-roaster-data">
                            <span>Shift Roaster</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            <li><a href="/document"><i class='fas fa-folder icon'></i>Document Center</a></li>
            <li>
                <a href="#"><i class='fas fa-headset icon'></i> Helpdesk <i class='fa fa-chevron-right icon-right'></i></a>
                <ul class="side-dropdown">
                    <li><a href="/HelpDesk">Catalog & HR Requests</a></li>
                    <li><a href="/incident">Incident & Service <br> Requests</a></li>
                    <li><a href="/users">Connect</a></li>
                </ul>
            </li>
            <li><a href="/delegates"><i class='fas fa-user-friends icon'></i> Workflow Delegates</a></li>
            @if ($managerId)
            <li>
                <a href="/reports">
                    <i class="fas fa-file-alt icon" ></i> Reports
                </a>
            </li>
            @endif

        </ul>
    </section>


    <!-- NAVBAR -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='fas fa-bars toggle-sidebar'></i>
            <h6 class="mx-0 my-0 page-title"> @livewire('page-title')</h6>
            <div class="d-flex">
                <div class="m-auto me-2">
                    @livewire('notification')
                </div>
                <span class="divider m-auto me-2"></span>
                <div class="profile m-auto me-2">
                    <div class="d-flex brandLogoDiv" >
                        @livewire('company-logo')

                        @if($loginEmployeeProfile->image !== null && $loginEmployeeProfile->image != "null" && $loginEmployeeProfile->image != "Null" && $loginEmployeeProfile->image != "")
                        <img class="navProfileImg" src="data:image/jpeg;base64,{{ ($loginEmployeeProfile->image) }}" alt="" onclick="openProfile()">
                        @else
                        @if($loginEmployeeProfile->gender=='Male')
                        <img class="navProfileImg" src="{{ asset('images/male-default.png') }}" alt="" onclick="openProfile()">
                        @elseif($loginEmployeeProfile->gender=='Female')
                        <img class="navProfileImg" src="{{ asset('images/female-default.jpg') }}" alt="" onclick="openProfile()">
                        @else
                        <img class="navProfileImg" src="{{ asset('images/user.jpg') }}" alt="" onclick="openProfile()">
                        @endif
                        @endif
                    </div>
                    <ul class="profile-link mt-3">
                        <li><a href="/ProfileInfo"><i class='fas fa-user-circle icon'></i> Profile</a></li>
                        <li><a href="/Settings"><i class='fas fa-cog'></i> Settings</a></li>
                    </ul>
                </div>
                <div class="pointer m-auto">@livewire('log-out')</div>
            </div>
        </nav>
        <!-- NAVBAR -->
    </section>

    <!-- NAVBAR -->
</div>

<div class="position-relative">
    <div class="position-absolute" wire:loading wire:target="open,toggleSignState,openAbsentEmployees,openLateEmployees,openEarlyEmployees">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row m-0 p-0 mb-3">
            <div class="col-md-9 mb-3">
                <div class="row m-0 welcomeContainer hover-card">
                    <div class="card-content row p-0 m-0">
                        <div class="col-md-6 p-0 ps-3 pt-4">
                            @if ($greetingText)
                            <p class="morning-city">{{ $greetingText }}</p>
                            @endif
                            <p class="morning-city" style="padding-top: 2.5em;">Welcome<br>
                                {{ ucwords(strtolower($loginEmployee->first_name)) }}
                                {{ ucwords(strtolower($loginEmployee->last_name)) }}
                            </p>
                        </div>


                        <!-- <div class="col-md-3 p-0">
                            
                        </div> -->

                        <div class="col-md-6">
                            <div>
                                <img src="images/admin_banner.png" style="width: 100%" />
                            </div>
                            <div class="mb-4 homeBaneerCard row m-0" style="margin-top: -40px !important;">

                                <div class="col-md-6 pe-0">
                                    <div class="bigCircle">
                                        <div class="smallCircle"></div>
                                    </div>
                                    <div class="d-flex" style="font-size: 14px;
                                        margin-top: 3em;
                                        position: relative;
                                        font-weight: 600; margin-left: 5px;"
                                        x-data="{
                                            time: '',
                                            updateTime() {
                                                const now = new Date();
                                                const hours = String(now.getHours()).padStart(2, '0');
                                                const minutes = String(now.getMinutes()).padStart(2, '0');
                                                const seconds = String(now.getSeconds()).padStart(2, '0');
                                                this.time = `${hours} : ${minutes} : ${seconds}`;
                                            }
                                        }" x-init="setInterval(() => updateTime(), 1000)">
                                        <template x-if="time">
                                            <p x-text="time" class="showTimer"></p>
                                        </template>
                                        <img src="images/stopwatch.png" style="width: 2.5em; height: fit-content" />
                                    </div>
                                </div>
                                <div class="col-md-6 ps-0 pt-2 text-end">
                                    <p class="normalText mt-2">
                                        @php
                                        // Fetch shift times
                                        $EmployeeStartshiftTime = $employeeShiftDetails->shift_start_time;
                                        $EmployeeEndshiftTime = $employeeShiftDetails->shift_end_time;

                                        // Default times
                                        $defaultStartShiftTime = '10:00 am';
                                        $defaultEndShiftTime = '7:00 pm';

                                        // Format the times if they are not null
                                        $formattedStartShiftTime = $EmployeeStartshiftTime
                                        ? (new DateTime($EmployeeStartshiftTime))->format('h:i a')
                                        : $defaultStartShiftTime;
                                        $formattedEndShiftTime = $EmployeeEndshiftTime
                                        ? (new DateTime($EmployeeEndshiftTime))->format('h:i a')
                                        : $defaultEndShiftTime;

                                        @endphp
                                        {{ substr($currentDay, 0, 3) }} | {{ $formattedStartShiftTime }} to
                                        {{ $formattedEndShiftTime }} Shift
                                    </p>
                                    <p class="payslip-card-title">{{ $currentDate }}</p>
                                </div>
                                <div class="locationGlobe row m-0">
                                    <div class="col-1 p-0">
                                        <i class="fa-solid fa-location-dot" id="openMapIcon"
                                            style="color: red;cursor: pointer; font-size: 14px;"></i>
                                    </div>
                                    <div class="col-11 p-0">
                                        @if (
                                        !empty($formattedAddress['village']) ||
                                        !empty($formattedAddress['county']) ||
                                        !empty($formattedAddress['city']) ||
                                        !empty($formattedAddress['country']) ||
                                        !empty($formattedAddress['postcode']))
                                        {{-- Display the formatted address if any of the fields are not empty --}}
                                        <p class="mb-1">
                                            {{ !empty($formattedAddress['village']) ? $formattedAddress['village'] . ', ' : '' }}
                                            {{ !empty($formattedAddress['county']) ? $formattedAddress['county'] . ', ' : '' }}
                                            {{ !empty($formattedAddress['city']) ? $formattedAddress['city'] . ', ' : '' }}
                                            {{ !empty($formattedAddress['country']) ? $formattedAddress['country'] . '-' : '' }}
                                            {{ !empty($formattedAddress['postcode']) ? $formattedAddress['postcode'] . '.' : '' }}
                                        </p>
                                        @elseif(!empty($country) || !empty($city))
                                        {{-- Display fallback values if the formatted address is empty but country, city, or postal code are available --}}
                                        <p class="mb-1">{{ $city }} , {{ $country }}</p>
                                        @else
                                        {{-- Display a default message if everything is empty --}}
                                        <p class="mb-1">Address not available</p>
                                        @endif

                                    </div>

                                </div>
                                <div class="A d-flex justify-content-between align-items-center flex-row mb-3">
                                    <a class="viewSwipesList" wire:click="open">View Swipes</a>
                                    <button id="signButton" class="signInButton"
                                        wire:click="toggleSignState">
                                        @if ($swipes)
                                        @if ($swipes->in_or_out === 'OUT')
                                        Sign In
                                        @else
                                        Sign Out
                                        @endif
                                        @else
                                        Sign In
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-3 homeReporting">
                <div class="card-reporting">
                    <button class="mail">
                        <span class="rounded-pill home-reportTo"> Reports To </span>
                    </button>

                    <div class="profile-pic">
                        @if ($loginEmpManagerDetails && $loginEmpManagerDetails->image && $loginEmpManagerDetails->image !== 'null')
                        <img src="data:image/jpeg;base64,{{ $loginEmpManagerDetails->image }}" alt="">
                        @elseif($loginEmpManagerDetails === null)
                        <img src="{{ asset('/images/user.jpg')}}" alt="" width="50" height="50">
                        @else
                        <img src="{{ asset('/images/user.jpge')}}" alt="">
                        @endif
                    </div>

                    <div class="bottom">
                        <div class="content">
                            @if ($loginEmpManagerDetails)
                            <span class="name">{{ ucwords(strtolower($loginEmpManagerDetails->first_name)) }}
                                {{ ucwords(strtolower($loginEmpManagerDetails->last_name)) }}</span>
                            @else
                            <span class="name">HR will assign a reporting manager soon</span>
                            @endif

                            <span class="about-me">
                                @php
                                $jobTitle = $loginEmpManagerDetails ? $loginEmpManagerDetails->job_role : ''; // Empty string instead of 'N/A'

                                // Replace specific titles with desired formats
                                $convertedTitle = preg_replace('/\bHR\b/i', 'HR', $jobTitle);
                                $convertedTitle = preg_replace('/\bI\b/i', 'I', $convertedTitle);
                                $convertedTitle = preg_replace('/\bII\b/i', 'II', $convertedTitle);
                                $convertedTitle = preg_replace('/\bIII\b/i', 'III', $convertedTitle);

                                // Capitalize the first letter of each word, while keeping 'II' intact
                                $convertedTitle = preg_replace_callback(
                                '/\b([a-z])([a-z]*)/i',
                                function ($matches) {
                                return strtoupper($matches[1]) . strtolower($matches[2]);
                                },
                                $convertedTitle,
                                );

                                // Ensure 'II' and 'HR' stay capitalized after the callback
                                $convertedTitle = str_replace(
                                [' Ii', ' Hr', ' IIi', 'Iii'],
                                [' II', ' HR', ' III'],
                                $convertedTitle,
                                );
                                @endphp

                                {{ $convertedTitle }}
                            </span>
                        </div>

                        <!-- <div class="bottom-bottom">
                            <div class="social-links-container">
                                <img src="images/teams.png" style="width: 1.5em; height: fit-content;" />
                                <img src="images/outlook.png" style="width: 1.5em; height: fit-content;" />
                            </div>

                        </div> -->
                    </div>
                </div>
            </div>

        </div>

        <!-- main content -->
        <div class="row m-0">
            <div class="col-md-3">
                <div class="payslip-card mb-4" style="height: 195px;">
                    <p class="payslip-card-title mb-0">Upcoming Holidays</p>
                    @if ($calendarData->isEmpty())
                    <p class="payslip-small-desc mt-3">Uh oh! No holidays to show.</p>
                    @else
                    @php
                    $count = 0;
                    @endphp

                    <div class="row m-0">
                        <div class="col-12 p-0">
                            @foreach ($calendarData as $entry)
                            @if (!empty($entry->festivals))
                            <div>
                                <p class="payslip-small-desc mt-3">
                                    <span
                                        class="payslip-small-desc fw-500">{{ date('d M', strtotime($entry->date)) }}
                                        <span
                                            class="smallTextMin">{{ date('l', strtotime($entry->date)) }}</span></span>
                                    <br>
                                    <span class="smallTextMax">{{ ucfirst($entry->festivals) }}</span>
                                </p>
                            </div>
                            @php
                            $count++;
                            @endphp
                            @endif

                            @if ($count >= 2)
                            @break
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <a href="/holiday-calendar">
                        <div class="payslip-go-corner">
                            <div class="payslip-go-arrow">→</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="payslip-card mb-4" style="height: 195px;">
                    <div class="row m-0 avatarImgDiv">
                        <img src="images/gamer.png" class="firstImg position-absolute" />
                        <img src="images/agent.png" class="secondImg position-absolute" />
                        <img src="images/woman.png" class="thirdImg position-absolute" />
                        <p class="moreImgTxt">+3</p>
                    </div>
                    <p class="payslip-card-title">Connect</p>
                    <p class="payslip-small-desc">
                        Wanted to connect with you
                    </p>
                    <a href="#">
                        <div class="payslip-go-corner">
                            <div class="payslip-go-arrow">→</div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3  ">
                <div class="payslip-card mb-4 " style="height: 195px;">
                    <p class="payslip-card-title">Time Sheet</p>
                    <p class="payslip-small-desc">
                        Submit your time sheet for this week.
                    </p>
                    <a href="/time-sheet">
                        <div class="payslip-go-corner">
                            <div class="payslip-go-arrow">→</div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3  ">
                <div class="payslip-card mb-4" style="height: 195px;">
                    <p class="payslip-card-title">Apply for a Leave</p>
                    <p class="payslip-small-desc">
                        Kindly click on the Arrow button to apply a leave.
                    </p>
                    <a href="/leave-form-page">
                        <div class="payslip-go-corner">
                            <div class="payslip-go-arrow">→</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-md-3  ">
                @if ($ismanager || $leaveApplied)
                <div class="payslip-card mb-4" style="height: 195px;">
                    <p class="payslip-card-title">Review</p>
                    @if ($this->count > 0)
                    <div class="notify d-flex justify-content-between">
                        <p class="payslip-small-desc">
                            {{ $count }} <br>
                            <span class="normalTextValue">Things to review</span>
                        </p>
                        <img src="https://png.pngtree.com/png-vector/20190214/ourlarge/pngtree-vector-notes-icon-png-image_509622.jpg"
                            alt="" width="40" height="40">
                    </div>
                    <div class="leave-display d-flex align-items-center border-top pt-3 gap-3">
                        @php
                        function getRandomColor()
                        {
                        $colors = ['#FFD1DC', '#B0E57C', '#ADD8E6', '#E6E6FA', '#FFB6C1'];
                        return $colors[array_rand($colors)];
                        }
                        @endphp
                        @php
                        // Separate requests into those to show and those to hide
                        $requestsToShow = array_slice($groupedRequests, 0, 3, true);
                        $totalRequests = count($groupedRequests);
                        $requestsToHide =
                        $totalRequests > 3 ? array_slice($groupedRequests, 3, null, true) : [];
                        @endphp

                        @foreach ($requestsToShow as $empId => $data)
                        @php
                        $leaveRequests = $data['leaveRequests'];
                        $count = $data['count'];

                        // Use the first leave request to get employee details
                        $firstLeaveRequest = $leaveRequests[0];
                        if ($firstLeaveRequest && $firstLeaveRequest->employee) {
                        $firstName = ucwords(strtolower($firstLeaveRequest->employee->first_name));
                        $lastName = ucwords(strtolower($firstLeaveRequest->employee->last_name));
                        $initials =
                        strtoupper(substr($firstName, 0, 1)) . strtoupper(substr($lastName, 0, 1));
                        } else {
                        $firstName = 'Unknown';
                        $lastName = '';
                        $initials = '?';
                        }
                        @endphp
                        <a href="/employees-review">
                            <div
                                class="circle-container d-flex flex-column mr-3 payslip-small-desc text-center position-relative">
                                <div class="thisCircle d-flex align-items-center justify-content-center"
                                    style="border: 2px solid {{ getRandomColor() }}"
                                    data-toggle="tooltip" data-placement="top"
                                    title="{{ $firstName }} {{ $lastName }}">
                                    <span>{{ $initials }}</span>
                                </div>
                                @if ($count > 1)
                                <span
                                    class="badge badge-pill badge-info position-absolute translate-middle badge-count">
                                    {{ $count }}
                                </span>
                                @endif
                                <span class="leaveText">Leave</span>
                            </div>
                        </a>
                        @endforeach

                        @if ($totalRequests > 3)
                        <div
                            class="remainContent d-flex flex-column justify-content-center align-items-center">
                            <a href="#" wire:click="reviewLeaveAndAttendance">
                                <span>+{{ $totalRequests - 3 }}</span>
                                <p class="mb-0" style="margin-top:-5px;">More</p>
                            </a>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p class="payslip-small-desc mb-2 homeText">
                            Hurrah! You've nothing to review.
                        </p>
                    </div>
                    @endif
                    <a href="/employees-review">
                        <div class="payslip-go-corner">
                            <div class="payslip-go-arrow">→</div>
                        </div>
                    </a>
                </div>
                @if ($showReviewLeaveAndAttendance)
                <div class="modal d-block" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <b>Review</b>
                                </h5>
                                <button type="button" class="btn-close btn-primary" aria-label="Close"
                                    wire:click="closereviewLeaveAndAttendance">
                                </button>
                            </div>
                            <div class="modal-body">
                                <h6 class="normalTextValue">Leave Requests</h6>
                                <div class="d-flex flex-row gap-2">
                                    @if ($totalRequests > 3)
                                    <div class="d-flex flex-row">
                                        @foreach ($requestsToHide as $empId => $data)
                                        @php
                                        $leaveRequests = $data['leaveRequests'];
                                        $count = $data['count'];

                                        // Use the first leave request to get employee details
                                        $firstLeaveRequest = $leaveRequests[0];
                                        if ($firstLeaveRequest && $firstLeaveRequest->employee) {
                                        $firstName = $firstLeaveRequest->employee->first_name;
                                        $lastName = $firstLeaveRequest->employee->last_name;
                                        $initials =
                                        strtoupper(substr($firstName, 0, 1)) .
                                        strtoupper(substr($lastName, 0, 1));
                                        } else {
                                        $firstName = 'Unknown';
                                        $lastName = '';
                                        $initials = '?';
                                        }
                                        @endphp
                                        <div
                                            class="circle-container d-flex flex-column mr-3 payslip-small-desc text-center position-relative">
                                            <div class="thisCircle d-flex align-items-center justify-content-center"
                                                style="border: 2px solid {{ getRandomColor() }}"
                                                data-toggle="tooltip" data-placement="top"
                                                title="{{ $firstName }} {{ $lastName }}">
                                                <span>{{ $initials }}</span>
                                            </div>
                                            @if ($count > 1)
                                            <span
                                                class="badge badge-pill badge-info position-absolute translate-middle badge-count">
                                                {{ $count }}
                                            </span>
                                            @endif
                                            <span class="leaveText">Leave</span>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <h6 class="normalTextValue">Attendance Requests</h6>
                                <div class="d-flex flex-row">
                                    @for ($i = 0; $i <= $countofregularisations; $i++)
                                        <?php
                                        // Fetch the regularisation at the current index
                                        $regularisation = $this->regularisations[$i] ?? null;
                                        if ($regularisation && $regularisation->employee) {
                                            $firstName = $regularisation->employee->first_name;
                                            $lastName = $regularisation->employee->last_name;
                                            $initials = strtoupper(substr($firstName, 0, 1)) . strtoupper(substr($lastName, 0, 1));
                                        ?> <div class=" d-flex flex-column mr-3">
                                        <div class="thisCircle d-flex"
                                            style="border: 2px solid {{ getRandomColor() }}"
                                            data-toggle="tooltip" data-placement="top"
                                            title="{{ $firstName }} {{ $lastName }}">
                                            <span>{{ $initials }}</span>
                                        </div>
                                        <span class="attendanceRegularization">Attendance
                                            Regularisation</span>
                                </div>

                            <?php
                                        }
                            ?>
                            @endfor
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="cancel-btn"
                                style="border:1px solid rgb(2,17,79);" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show blurred-backdrop"></div>
            @endif
            @endif

            <div class="payslip-card mb-4">
                <p class="payslip-card-title">IT Declaration</p>
                <p class="payslip-small-desc">
                    Hurrah! Considered your IT declaration for Apr 2023.
                </p>
                <a href="/formdeclaration">
                    <div class="payslip-go-corner">
                        <div class="payslip-go-arrow">→</div>
                    </div>
                </a>
            </div>
            <div class="payslip-card mb-3">
                <p class="payslip-card-title">POI</p>
                <p class="payslip-small-desc">
                    Hold on! You can submit your Proof of Investments (POI) once released.
                </p>
                <a href="#">
                    <div class="payslip-go-corner">
                        <div class="payslip-go-arrow">→</div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-5 mb-4 ">
            @if ($ismanager)
            <div class="payslip-card mb-4">
                <p class="payslip-card-title">Who is in?</p>
                <div class="who-is-in d-flex flex-column justify-content-start ">
                    <p class="mb-2  mt-2 section-name payslip-small-desc">
                        Not Yet In ({{ $CountAbsentEmployees }})
                    </p>
                    <div class="team-leave d-flex flex-row gap-3">
                        @php
                        function getRandomAbsentColor()
                        {
                        $colors = ['#FFD1DC', '#D2E0FB', '#ADD8E6', '#E6E6FA', '#F1EAFF', '#FFC5C5'];
                        return $colors[array_rand($colors)];
                        }
                        @endphp
                        @if ($CountAbsentEmployees > 0)
                        @for ($i = 0; $i < min($CountAbsentEmployees, 5); $i++)
                            @if (isset($AbsentEmployees[$i]))
                            @php
                            $employee=$AbsentEmployees[$i];
                            $randomColorAbsent='#' . str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0' , STR_PAD_LEFT);
                            @endphp
                            <a href="/whoisinchart" style="text-decoration: none;">
                            <div class="thisCircle"
                                style="border: 2px solid {{ getRandomAbsentColor() }};"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ ucwords(strtolower($employee['first_name'])) }} {{ ucwords(strtolower($employee['last_name'])) }}">
                                <span class="initials">
                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0, 1)) }}
                                </span>
                            </div>
                            </a>
                            @endif
                            @endfor
                            @else
                            <p class="payslip-small-desc">No employees are absent today</p>
                            @endif
                            @if ($CountAbsentEmployees > 5)
                            <div class="remainContent d-flex flex-column align-items-center payslip-small-desc"
                                wire:click="openAbsentEmployees">
                                <span>+{{ $CountAbsentEmployees - 5 }}</span>
                                <p class="mb-0" style="margin-top:-5px;">More</p>
                            </div>
                            @endif
                    </div>
                </div>
                <!-- /second row -->

                <div class="who-is-in d-flex flex-column justify-content-start ">
                    <p class="mb-2 mt-2 section-name mt-1 payslip-small-desc">
                        Late Arrival ({{ $CountLateSwipes }})
                    </p>
                    <div class="team-leave d-flex flex-row  gap-3">
                        @php
                        function getRandomLateColor()
                        {
                        $colors = ['#FFD1DC', '#D2E0FB', '#ADD8E6', '#E6E6FA', '#F1EAFF', '#FFC5C5'];
                        return $colors[array_rand($colors)];
                        }
                        @endphp
                        @if ($CountLateSwipes > 0)
                        @for ($i = 0; $i < min($CountLateSwipes, 5); $i++)
                            @php $employee=$LateSwipes[$i]; @endphp
                            @if (isset($LateSwipes[$i]))
                            <a href="/whoisinchart" style="text-decoration: none;">
                            <div class="thisCircle"
                                style="border: 2px solid {{ getRandomAbsentColor() }};border-radius:50%;width: 35px;height: 35px;display: flex;align-items: center;justify-content: center;"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ ucwords(strtolower($employee['first_name'])) }} {{ ucwords(strtolower($employee['last_name'])) }}">
                                <span class="initials">
                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0, 1)) }}
                                </span>
                            </div>
                            </a>
                            @endif
                            @endfor
                            @else
                            <p class="payslip-small-desc">No employees arrived late today</p>
                            @endif
                            @if ($CountLateSwipes > 5)
                            <div class="remainContent d-flex flex-column align-items-center payslip-small-desc"
                                wire:click="openLateEmployees">
                                <span>+{{ $CountLateSwipes - 5 }}</span>
                                <p class="mb-0" style="margin-top:-5px;">More</p>
                            </div>
                            @endif
                    </div>
                </div>

                <!-- /third row -->
                <div class="who-is-in d-flex flex-column justify-content-start">
                    <p class="mb-2 mt-2 section-name mt-1 payslip-small-desc">
                        On Time ({{ $CountEarlySwipes }})
                    </p>
                    <div class="team-leave d-flex flex-row gap-3">
                        @php
                        function getRandomEarlyColor()
                        {
                        $colors = ['#FFD1DC', '#D2E0FB', '#ADD8E6', '#E6E6FA', '#F1EAFF', '#FFC5C5'];
                        return $colors[array_rand($colors)];
                        }
                        @endphp
                        @if ($CountEarlySwipes)
                        @for ($i = 0; $i < min($CountEarlySwipes, 5); $i++)
                            @if (isset($EarlySwipes[$i]))
                            @php
                            $employee=$EarlySwipes[$i];
                            $randomColorEarly='#' .
                            str_pad(dechex(mt_rand(0xcccccc, 0xffffff)), 6, '0' , STR_PAD_LEFT);
                            @endphp
                            <a href="/whoisinchart" style="text-decoration: none;">
                            <div class="thisCircle"
                                style="border: 2px solid {{ getRandomAbsentColor() }};border-radius:50%;width: 35px;height: 35px;display: flex;align-items: center;justify-content: center;"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ ucwords(strtolower($employee['first_name'])) }} {{ ucwords(strtolower($employee['last_name'])) }}">
                                <span class="initials">
                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0, 1)) }}
                                </span>
                            </div>
                            </a>
                            @endif
                            @endfor
                            @else
                            <p class="payslip-small-desc">No employees arrived early today</p>
                            @endif
                            @if ($CountEarlySwipes > 5)
                            <div class="remainContent d-flex flex-column align-items-center payslip-small-desc"
                                wire:click="openEarlyEmployees">
                                <span>+{{ $CountEarlySwipes - 5 }}</span>
                                <p class="mb-0" style="margin-top:-5px;">More</p>
                            </div>
                            @endif
                    </div>
                </div>

                <a href="/whoisinchart">
                    <div class="payslip-go-corner">
                        <div class="payslip-go-arrow">→</div>
                    </div>
                </a>
            </div>
            @endif
            <div class="payslip-card">
                <div class="px-3 py-2">
                    <p class="payslip-card-title">Payslip</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="canvasBorder">
                            <canvas wire:ignore id="combinedPieChart" width="117" height="117"></canvas>
                        </div>
                        <div class="c d-flex justify-content-end flex-column">
                            <p class="payslip-small-desc font-weight-500">{{ date('M Y', strtotime('-1 month')) }}
                            </p>
                            <p class="payslip-small-desc align-items-end d-flex justify-content-end flex-column">
                                {{ date('t', strtotime('-1 month')) }} <br>
                                <span class="payslip-small-desc">Paid days</span>
                            </p>
                        </div>
                    </div>

                    <div class="d-flex flex-column mt-3">
                        <div class="net-salary">
                            <div class="d-flex gap-4">
                                <div class="grossPay"></div>
                                <p class="payslip-small-desc">Gross Pay</p>
                            </div>
                            <p class="payslip-small-desc">
                                {{ $showSalary ? '₹****' : '₹ 50,000.00' }}
                            </p>
                        </div>
                        <div class="net-salary">
                            <div class="d-flex gap-4">
                                <div class="deductionsPay"></div>
                                <p class="payslip-small-desc">Deduction</p>
                            </div>
                            <p class="payslip-small-desc">
                                {{ $showSalary ? '₹****' : '₹ 5,000.00' }}
                            </p>
                        </div>
                        <div class="net-salary">
                            <div class="d-flex gap-4">
                                <div class="netPay"></div>
                                <p class="payslip-small-desc">Net Pay</p>
                            </div>
                            <p class="payslip-small-desc">
                                {{ $showSalary ? '₹****' : '₹ 45,000.00' }}
                            </p>
                        </div>
                    </div>

                    <div class="show-salary">
                        <a href="/your-download-route" id="pdfLink2023_4" class="pdf-download" download>Download
                            PDF</a>
                        <a href="javascript:void(0);" wire:click="toggleSalary" class="showHideSalary">
                            {{ $showSalary ? 'Show Salary' : 'Hide Salary' }}
                        </a>
                    </div>
                </div>
                <a href="#">
                    <div class="payslip-go-corner">
                        <div class="payslip-go-arrow">→</div>
                    </div>
                </a>
            </div>
        </div>
        <!-- TEAM ON LEAVE -->
        <div class="col-md-4  mb-4 ">
            @if ($this->showLeaveApplies)
            <div class="payslip-card  mb-4">
                <div class="reviews">
                    <div>
                        <div class="team-heading mt-2 d-flex justify-content-between">
                            <div>
                                <p class="payslip-card-title"> Team On Leave</p>
                            </div>
                        </div>
                        @if ($this->teamCount > 0)
                        <div class="team-Notify ">
                            <p class="payslip-small-desc">
                                Today ({{ $teamCount }}) </p>
                            <div class="team-leave d-flex flex-row  gap-3">
                                @php
                                function getRandomLightColor()
                                {
                                $colors = ['#FFD1DC', '#B0E57C', '#ADD8E6', '#E6E6FA', '#FFB6C1'];
                                return $colors[array_rand($colors)];
                                }
                                @endphp

                                @for ($i = 0; $i < min($teamCount, 3); $i++)
                                    <?php
                                    $teamLeave = $this->teamOnLeave[$i] ?? null;
                                    if ($teamLeave) {
                                        $initials = strtoupper(substr($teamLeave->employee->first_name, 0, 1) . substr($teamLeave->employee->last_name, 0, 1));
                                    ?> <div class="thisCircle"
                                    style="  border: 2px solid {{ getRandomLightColor() }};"
                                    data-toggle="tooltip" data-placement="top"
                                    title="{{ ucwords(strtolower($teamLeave->employee->first_name)) }} {{ ucwords(strtolower($teamLeave->employee->last_name)) }}">
                                    <span>{{ $initials }}</span>
                            </div>

                        <?php
                                    }
                        ?>
                        @endfor
                        @if ($teamCount > 3)
                        <div class="remainContent d-flex mt-3 flex-column align-items-center">
                            <a href="/team-on-leave-chart">
                                <span>+{{ $teamCount - 3 }}</span>
                                <p class="mb-0" style="margin-top:-5px;">More</p>
                            </a>
                        </div>
                        @endif
                        </div>

                        <div class="mt-3">
                            <p class="payslip-small-desc">
                                This month ({{ $upcomingLeaveApplications }}) </p>
                            @if ($upcomingLeaveRequests)
                            <div class="mt-2 d-flex align-items-center gap-2 mb-3">
                                @foreach ($upcomingLeaveRequests->take(3) as $requests)
                                @php
                                $randomColorList =
                                '#' .
                                str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0', STR_PAD_LEFT);
                                @endphp
                                <div class="d-flex align-items-center">
                                    <div class="thisCircle"
                                        style="border: 1px solid {{ $randomColorList }}">
                                        <span>{{ substr($requests->employee->first_name, 0, 1) }}{{ substr($requests->employee->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                                @if ($upcomingLeaveRequests->count() > 3)
                                <div
                                    class="remainContent d-flex flex-column align-items-center">
                                    <!-- Placeholder color -->
                                    <a href="/team-on-leave-chart">
                                        <span>+{{ $upcomingLeaveRequests->count() - 3 }}
                                        </span>
                                        <span style="margin-top:-5px;">More</span>
                                    </a>
                                </div>
                                @endif
                            </div>
                            @endif
                            <p class="payslip-small-desc"><a href="/team-on-leave-chart">Click
                                    here</a> to see
                                who will be on leave in the
                                upcoming days!</p>
                        </div>
                    </div>
                    @else
                    <div class="leaveNodata gap-3">
                        <img src="{{ asset('images/no data.png') }}" name="noData" id="noData"
                            alt="Image Description" width="120" height="100">
                        <p class="payslip-small-desc">
                            Wow! No leaves planned today.
                        </p>
                    </div>
                    @endif
                </div>
                <a href="#">
                    <div class="payslip-go-corner">
                        <div class="payslip-go-arrow">→</div>
                    </div>
                </a>
            </div>
        </div>
        @endif

        <div class="payslip-card mb-4">
            <div>
                <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 30px;">
                    <h5 class="payslip-card-title">Task Overview</h5>
                    <div>
                        <select class="form-select custom-select-width"
                            wire:change="$set('filterPeriod', $event.target.value)">
                            <option value="this_month" selected>This month</option>
                            <option value="last_month">Last month</option>
                            <option value="this_year">This year</option>
                        </select>
                    </div>
                </div>
                <div class="row text-center mt-3">
                    <div class="col-4">
                        <h3 class="mb-1 track-text">{{ $TaskAssignedToCount }}</h3>
                        <p class="mb-0 track-text">Tasks Assigned</p>
                    </div>
                    <div class="col-4">
                        <h3 class="mb-1 track-text">{{ $TasksCompletedCount }}</h3>
                        <p class="mb-0 track-text">Tasks Completed</p>
                    </div>
                    <div class="col-4">
                        <h3 class="mb-1 track-text">{{ $TasksInProgressCount }}</h3>
                        <p class="mb-0 track-text">Tasks In Progress</p>
                    </div>
                </div>
            </div>
            <a href="/tasks">
                <div class="payslip-go-corner">
                    <div class="payslip-go-arrow">→</div>
                </div>
            </a>
        </div>
        <div class="payslip-card mb-4">
            <p class="payslip-card-title">Quick Access</p>
            <div class="m-0 row">
                <div class="quick payslip-small-desc col-md-7 px-3 py-0 ps-0">
                    <a href="/reimbursement" class="quick-link">Reimbursement</a>
                    <a href="/itstatement" class="quick-link">IT Statement</a>
                    <a href="#" class="quick-link">YTD Reports</a>
                    <a href="#" class="quick-link">Loan Statement</a>
                </div>
                <div class="col-md-5 quickAccessNoData">
                    <img src="images/quick_access.png" style="padding-top: 2em; width: 6em">
                    <p class="pt-4">Use quick access to view important salary details.</p>
                </div>
            </div>
            <div class="payslip-go-corner">
                <div class="payslip-go-arrow">→</div>
            </div>
        </div>

    </div>
    @if ($showAlertDialog)
    <div class="modal d-block" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <b>Swipes</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                        aria-label="Close" wire:click="close">
                    </button>
                </div>
                <div class="modal-body" style="max-height:300px;overflow-y:auto">
                    <div class="row">
                        <div class="col normalTextValue">Date :
                            <span class="normalText">{{ $currentDate }}</span>
                        </div>
                        <div class="col normalTextValue">Shift
                            Time : <span class="normalText">10:00 to 19:00</span></div>
                    </div>
                    <table class="swipes-table mt-2 border w-100">
                        <tr>
                            <th>
                                Swipe Time</th>
                            <th>
                                Sign-In / Sign-Out</th>
                            <th>
                                Device</th>
                        </tr>
                        @if (!is_null($swipeDetails) && $swipeDetails->count() > 0)
                        @foreach ($swipeDetails as $swipe)
                        <tr>
                            <td>
                                {{ $swipe->swipe_time }}
                            </td>
                            <td>
                                {{ $swipe->in_or_out }}
                            </td>
                            <td>
                                {{ $swipe->sign_in_device }}
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="homeText" colspan="2">No swipe records found for today.</td>
                        </tr>
                        @endif

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif
    @if ($showAllAbsentEmployees)
    <div class="modal d-block" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <b>{{ $whoisinTitle }}</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                        aria-label="Close" wire:click="closeAllAbsentEmployees">
                    </button>
                </div>
                <div class="modal-body" style="max-height:300px;overflow-y:auto">
                    <div class="team-leave d-flex flex-row gap-3">
                        @for ($i = 0; $i < $CountAbsentEmployees; $i++)
                            @if (isset($AbsentEmployees[$i]))
                            @php
                            $employee=$AbsentEmployees[$i];
                            $randomColorAbsent='#' . str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0' , STR_PAD_LEFT);
                            @endphp
                            <a href="/whoisinchart" style="text-decoration: none;">
                            <div class="thisCircle"
                                style="border: 2px solid {{ getRandomAbsentColor() }};"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ ucwords(strtolower($employee['first_name'])) }} {{ ucwords(strtolower($employee['last_name'])) }}">
                                <span class="initials">
                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0, 1)) }}
                                </span>
                            </div>
                            </a>
                            @endif
                            @endfor
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif
    @if ($showAllLateEmployees)
    <div class="modal d-block" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <b>{{ $whoisinTitle }}</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                        aria-label="Close" wire:click="closeAllLateEmployees">
                    </button>
                </div>
                <div class="modal-body" style="max-height:300px;overflow-y:auto">
                    <div class="team-leave d-flex flex-row gap-3">
                        @for ($i = 0; $i < $CountLateSwipes; $i++)
                            @if (isset($LateSwipes[$i]))
                            @php
                            $employee=$LateSwipes[$i];
                            $randomColorLate='#' . str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0' , STR_PAD_LEFT);
                            @endphp
                            <a href="/whoisinchart" style="text-decoration: none;">
                            <div class="thisCircle"
                                style="border: 2px solid {{ getRandomLateColor() }};"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ ucwords(strtolower($employee['first_name'])) }} {{ ucwords(strtolower($employee['last_name'])) }}">
                                <span class="initials">
                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0, 1)) }}
                                </span>
                            </div>
                            </a>
                            @endif
                            @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>

    @endif
    @if ($showAllEarlyEmployees)
    <div class="modal d-block" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <b>{{ $whoisinTitle }}</b>
                    </h5>
                    <button type="button" class="btn-close btn-primary" data-dismiss="modal"
                        aria-label="Close" wire:click="closeAllEarlyEmployees">
                    </button>
                </div>
                <div class="modal-body" style="max-height:300px;overflow-y:auto">
                    <div class="team-leave d-flex flex-row gap-3">
                        @for ($i = 0; $i < $CountEarlySwipes; $i++)
                            @if (isset($EarlySwipes[$i]))
                            @php
                            $employee=$EarlySwipes[$i];
                            $randomColorEarly='#' . str_pad(dechex(mt_rand(0, 0xffffff)), 6, '0' , STR_PAD_LEFT);
                            @endphp
                            <a href="/whoisinchart" style="text-decoration: none;">
                            <div class="thisCircle"
                                style="border: 2px solid {{ getRandomEarlyColor() }};"
                                data-toggle="tooltip" data-placement="top"
                                title="{{ ucwords(strtolower($employee['first_name'])) }} {{ ucwords(strtolower($employee['last_name'])) }}">
                                <span class="initials">
                                    {{ strtoupper(substr(trim($employee['first_name']), 0, 1)) }}{{ strtoupper(substr(trim($employee['last_name']), 0, 1)) }}
                                </span>
                            </div>
                            </a>
                            @endif
                            @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show blurred-backdrop"></div>
    @endif
</div>
</div>
<div>
    {{-- @script
        <script>
            // Livewire.dispatch('post-created') (or) $wire.dispatch('post-created'); both are working........
        </script>
    @endscript --}}

</div>

{{-- <script>
    document.addEventListener('livewire:initialized', () => {
        // Runs immediately after Livewire has finished initializing
        // on the page...
        Livewire.dispatch('post-created')
    })
</script> --}}
<script>
    // Function to check if an element is in the viewport
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
    // Initial check on page load
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('combinedPieChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Gross Pay', 'Deduction', 'Net Pay'],
                datasets: [{
                    label: 'Salary Breakdown',
                    data: [50000, 5000, 45000],
                    backgroundColor: ['#000000', '#B9E3C6', '#1C9372'],
                    borderColor: '#f2f8f9', // Set border color for the segments
                    borderWidth: 2, // Normal border width
                    hoverBorderWidth: 3 // Border width on hover
                }]
            },
            options: {
                responsive: true,
                cutout: '60%', // Adjust this to increase thickness (lower cutout value for thicker ring)
                plugins: {
                    legend: {
                        display: false // Hide labels
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ₹ ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
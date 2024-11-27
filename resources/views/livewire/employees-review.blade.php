<div class="position-relative">
    <div class="position-absolute" wire:loading
        wire:target="setActiveTab,searchPendingLeave,setActiveLeaveTab">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>
        </div>
    </div>
    <style>
        .emp-side-page-nav-item-group {
            font-weight: 600;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            font-weight: normal;
            padding-left: 1rem;
            font-size: 0.75rem;
            color: rgba(127, 143, 164, .5);
        }

        .emp-side-page-nav-item {
            padding-left: 1rem;
            margin-bottom: 0.5rem;
            align-items: center;
        }

        .emp-side-page-nav-item .nav-link {
            cursor: pointer;
            color: #778899;
            text-decoration: none;
            padding: 0px;
        }

        .emp-side-page-nav-item .nav-link:hover {
            border-radius: 0px;

        }

        .nav-link.active {
            font-weight: 600;
            color: rgb(2, 17, 79);
            border-left: 2px solid rgb(2, 17, 79);
            padding: 0.3rem;
            white-space: nowrap;
            border-radius: none;
        }

        .emp-info {
            white-space: nowrap;
            border-radius: none;
        }


        .emp-input-with-icon {
            position: relative;

        }

        .emp-search {
            color: #778899;
        }

        .emp-input-with-icon input {

            padding-right: 30px;
            box-sizing: border-box;
            border: 1px solid #ccc;
        }

        .emp-input-with-icon i {
            position: absolute;
            right: 25px;
            top: 55%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .workflow-list-view-empty {
            margin-top: 30px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            width: 100%;
            height: 60vh;
            min-height: calc(90vh - 200px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #a3b2c7;

        }

        .emp-leave-count {
            display: inline-flex;
        }

        .leaveCountReview {
            height: 15px;
            margin: 3px;
            font-size: 0.6rem;
            width: 15px;
            border-radius: 50%;
            background-color: #FAE392;
            padding: 5px;
        }

        .image-scheme-empty-state {
            width: 300px;
            height: 150px;
            background: url(https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcS8OnbtjxKr4x4YdVfTg3g4MWT4WR6BJFIhIGQuhZkUyZt8zd4t) no-repeat 50%;
            margin-bottom: 20px;
        }
    </style>

    <div class="row m-0 p-0">

        <div class="sidenav col-md-3 col-lg-2">
            <div>
                <ul class="nav flex-column side-page-nav">
                    <label class="emp-side-page-nav-item-group">LEAVE</label>
                    <li class="nav-item emp-side-page-nav-item d-flex gap-1" tabindex="0">
                        <p class="emp-leave-count mb-0 ">
                            <span class="nav-link emp-info {{ $activeTab === 'leave' ? 'active' : '' }}" wire:click="setActiveTab('leave')">
                                Leave
                            </span>
                        </p>
                    </li>
                    <li class="nav-item emp-side-page-nav-item" tabindex="0">
                        <span class="nav-link emp-info {{ $activeTab === 'attendance' ? 'active' : '' }}" wire:click="setActiveTab('attendance')">
                            Attendance Regularization
                        </span>
                    </li>
                </ul>
            </div>
        </div>


        @if($showattendance )
        <div class="col-md-9 col-lg-9 py-2x ml-3x">
            <div class="nav-buttons d-flex justify-content-center" style="margin-top: 15px;">
                <ul class="nav custom-nav-tabs border">
                    <li class="custom-item m-0 p-0 flex-grow-1 mbl-dev-active">
                        <div style="border-top-left-radius:5px;border-bottom-left-radius:5px;" class="custom-nav-link {{ $attendenceActiveTab === 'active' ? 'active' : '' }}" wire:click.prevent="$set('attendenceActiveTab', 'active')">Active</div>
                    </li>
                    <li class="custom-item m-0 p-0 flex-grow-1 mbl-dev-closed">
                        <a href="#" style="border-top-right-radius:5px;border-bottom-right-radius:5px;" class="custom-nav-link {{ $attendenceActiveTab === 'closed' ? 'active' : '' }}" wire:click.prevent="$set('attendenceActiveTab', 'closed')">Closed</a>
                    </li>
                </ul>
            </div>

            @if ($attendenceActiveTab == "active")
            <div class="reviewList" style="margin:50px auto;">
                @livewire('view-regularisation-pending-new')
            </div>
            @else

            <div class="row p-0 mt-3">
    <div class="row m-0 p-0 mt-3 w-100">
        <div 
            class="search-container d-flex align-items-end ms-auto p-2" 
            style="position: relative; width: 220px;">
            <input 
                type="text" 
                wire:model.debounce.500ms="searchQuery" 
                id="searchInput" 
                placeholder="Search..." 
                class="form-control placeholder-small border outline-none rounded" 
                style="padding-right: 40px;"
            >
            <button wire:click="searchApprovedLeave" id="searchButtonReports">
                <i class="fas fa-search" style="width: 16px; height: 16px;"></i>
            </button>
        </div>
    </div>
</div>



            @if(count($approvedRegularisationRequestList))

            @foreach($approvedRegularisationRequestList as $arrl)

            @php
            // Decode the JSON string into an array
            $regularisationEntries = json_decode($arrl->regularisation_entries, true);
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


                <div class="accordion bg-white border mb-2 rounded">
                    <div class="accordion-heading rounded " onclick="toggleAccordion(this)">

                        <div class="accordion-title p-2 rounded">

                            <!-- Display leave details here based on $leaveRequest -->
                            <div class="col accordion-content">


                            @if(isset($arrl->image) && $arrl->image !== 'null' && $arrl->image != "Null" && $arrl->image != "")
                                    <img height="40" width="40" src="data:image/jpeg;base64,{{ ($arrl->image) }}" style="border-radius: 50%;">
                                    @else
                                    @if($arrl->gender === 'FEMALE')
                                    <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                    @elseif($arrl->gender === 'MALE')
                                    <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                    @else
                                    <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                    @endif
                                    @endif
                            </div>

                            <div class="col accordion-content">

                                <span style="color: #778899; font-size: 12px; font-weight: 500; max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block;" data-toggle="tooltip" data-placement="top" title="{{ ucwords(strtolower($arrl->first_name)) }} {{ ucwords(strtolower($arrl->last_name)) }}">{{ ucwords(strtolower($arrl->first_name)) }}&nbsp;{{ ucwords(strtolower($arrl->last_name)) }}</span>

                                <span style="color: #36454F; font-size: 12px; font-weight: 500;text-align:left">{{$arrl->emp_id}}</span>

                            </div>

                            <div class="col accordion-content">

                                <span style="color: #778899; font-size: 12px; font-weight: 500;">No. of Days</span>

                                <span style="color: #36454F; font-size: 12px; font-weight: 500;">
                                    {{$numberOfEntries}}
                                </span>

                            </div>
                            <!-- Add other details based on your leave request structure -->

                            <div class="col accordion-content">
                                @if($arrl->status==2)
                                <span style="margin-top:0.625rem; font-size: 12px; font-weight: 400; color:green;text-transform:uppercase;">{{$arrl->status_name}}</span>
                                @elseif($arrl->status==3)
                                <span style="margin-top:0.625rem; font-size: 12px; font-weight: 400; color:#f66;text-transform:uppercase;">{{$arrl->status_name}}</span>
                                @elseif($arrl->status==13)
                                <span style="margin-top:0.625rem; font-size: 12px; font-weight: 400; color:orange;text-transform:uppercase;">{{$arrl->status_name}}</span>


                                @endif
                            </div>

                            <div class="arrow-btn"wire:click="toggleActiveAccordion({{ $arrl->id }})" style="color:{{ in_array($arrl->id, $openAccordionsForClosed) ? '#3a9efd' : '#778899' }};
                                border:1px solid {{ in_array($arrl->id, $openAccordionsForClosed) ? '#3a9efd' : '#778899' }};">
                                <i class="fa fa-angle-{{ in_array($arrl->id, $openAccordionsForClosed) ? 'up' : 'down' }}"
                                style="color:{{ in_array($arrl->id, $openAccordionsForClosed) ? '#3a9efd' : '#778899' }}"></i>
                            </div>

                        </div>

                    </div>
                    @if(in_array($arrl->id, $openAccordionsForClosed))
                    <div class=" m-0 p-0">

                        <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

                        <div class="content px-4">

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

                            <div class="content px-4">

                                <span style="color: #778899; font-size: 12px; font-weight: 500;">Applied on:</span>

                                <span style="color: #333; font-size:12px; font-weight: 500;">{{ \Carbon\Carbon::parse($arrl->created_at)->format('d M, Y') }}
                                </span>

                            </div>

                            <div class="content px-4">
                                <a href="{{ route('review-closed-regularation', ['id' => $arrl->id]) }}" class="anchorTagDetails">View Details</a>

                            </div>

                        </div>
                    </div>
                    @endif
                </div>

                @endforeach
                @else
                <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                    <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
                    <p style="color:#969ea9; font-size:12px; font-weight:400; "> Hey, you have no closed regularization records
                        to view
                    </p>
                </div>
                @endif

                @endif

        </div>

        @endif

        @if($showleave)
        <div class="col-md-9 col-lg-9 py-2x ml-3x">
            <div class="nav-buttons d-flex justify-content-center" style="margin-top: 15px;">
                <ul class="nav custom-nav-tabs border">
                    <li class="custom-item m-0 p-0 flex-grow-1 mbl-dev-active">
                        <div class="reviewActiveButtons custom-nav-link {{ $leaveactiveTab === 'active' ? 'active' : '' }}" wire:click.prevent="setActiveLeaveTab('active')">Active</div>
                    </li>
                    <li class="custom-item m-0 p-0 flex-grow-1 mbl-dev-closed">
                        <div class="reviewClosedButtons custom-nav-link {{ $leaveactiveTab === 'closed' ? 'active' : '' }}"  wire:click.prevent="setActiveLeaveTab('closed')">Closed</div>
                    </li>
                </ul>
            </div>

            @if ($showActiveLeaveContent)
            <div class="pending-leavves-container">
                @if($count > 0 || $sendLeaveApplications)
                <div class="reviewList">
                    @livewire('view-pending-details')
                </div>
                @else
                <div class="leave-pending bg-white rounded border text-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <img src="/images/pending.png" alt="Pending Image" width="200">
                        <p class="normalTextValue fw-normal">Hey, you have no leave records to view
                        </p>
                    </div>
                </div>
                @endif
            </div>

            @else
            <div class="row p-0 m-0 mt-3" style="display:flex; justify-content: end;">

                <!-- <div class="col-3 emp-input-with-icon">
                    <input autocomplete="off" placeholder="Select date range" name="searchKey"
                        typeaheadoptionfield="name" typeaheadwaitms="300"
                        class="form-control text-overflow ng-untouched ng-pristine ng-valid" aria-exp anded="false"
                        aria-autocomplete="list">
                </div> -->
                <div class="row m-0 p-0 mt-3 d-flex align-items-end justify-content-end">
                    <div class="col-md-4 m-0 p-0">
                        <div class="search-container  p-2" style="position: relative;">
                            <input type="text" wire:model.debounce.500ms="searchQuery" id="searchInput" placeholder="Search..." class="form-control placeholder-small border outline-none rounded" style="padding-right: 40px;">
                            <button wire:click="searchPendingLeave" id="searchButtonReview">
                                <i class="fas fa-search" style="width: 16px; height: 16px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @if($isManager)
            <div class="closed-leaves-container px-2">
                @if(!empty($approvedLeaveApplicationsList))
                @foreach($approvedLeaveApplicationsList as $leaveRequest)
                <div class="accordion rounded mb-3">
                    <div class="accordion-heading rounded p-1" onclick="toggleAccordion(this)">
                        <div class="accordion-head rounded m-0">
                            <!-- Display leave details here based on $leaveRequest -->
                            <div class="col accordion-content">
                                <div class="accordion-profile d-flex align-items-center justify-content-center gap-2 m-auto">
                                    @if(isset($leaveRequest['approvedLeaveRequest']->image) && $leaveRequest['approvedLeaveRequest']->image !== 'null' && $leaveRequest['approvedLeaveRequest']->image != "Null" && $leaveRequest['approvedLeaveRequest']->image != "")
                                    <img height="40" width="40" src="data:image/jpeg;base64,{{ ($leaveRequest['approvedLeaveRequest']->image) }}" style="border-radius: 50%;">
                                    @else
                                    @if($leaveRequest['approvedLeaveRequest']->gender === 'FEMALE')
                                    <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                    @elseif($leaveRequest['approvedLeaveRequest']->gender === 'MALE')
                                    <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                    @else
                                    <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                    @endif
                                    @endif
                                    <div>
                                        @if(isset($leaveRequest['approvedLeaveRequest']->first_name))
                                        <p class="mb-0 d-flex flex-column m-auto text-start">
                                            <span class="employeeName" title="{{ ucwords(strtolower($leaveRequest['approvedLeaveRequest']->first_name)) }} {{ ucwords(strtolower($leaveRequest['approvedLeaveRequest']->last_name)) }}">
                                                {{ ucwords(strtolower($leaveRequest['approvedLeaveRequest']->first_name)) }}
                                                {{ ucwords(strtolower($leaveRequest['approvedLeaveRequest']->last_name)) }}
                                            </span>

                                            @if(isset($leaveRequest['approvedLeaveRequest']->emp_id))
                                            <span class="normalTextSmall text-start">
                                                #{{ $leaveRequest['approvedLeaveRequest']->emp_id }}
                                            </span>
                                            @endif
                                        </p>

                                        @else
                                        <p class="normalTetValue text-center mb-0">Name Not
                                            Available</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col accordion-content">
                                <span class="category-type-hide">Category</span>
                                <span class="leave-type-hide" title="{{ $leaveRequest['approvedLeaveRequest']->category_type }}">{{ $leaveRequest['approvedLeaveRequest']->category_type }}</span>
                            </div>

                            <div class="col accordion-content">
                                <span class="category-type-hide">Leave Type</span>
                                <span class="leave-type-hide" title="{{ $leaveRequest['approvedLeaveRequest']->leave_type }}">{{ $leaveRequest['approvedLeaveRequest']->leave_type }}</span>
                            </div>

                            <div class="col accordion-content">
                                <span class="category-type-hide">No. of Days</span>
                                <span class="normalText">
                                    {{ $this->calculateNumberOfDays($leaveRequest['approvedLeaveRequest']->from_date, $leaveRequest['approvedLeaveRequest']->from_session, $leaveRequest['approvedLeaveRequest']->to_date, $leaveRequest['approvedLeaveRequest']->to_session,$leaveRequest['approvedLeaveRequest']->leave_type) }}
                                </span>
                            </div>
                            @if(($leaveRequest['approvedLeaveRequest']->category_type) === 'Leave')
                            <div class="col accordion-content">
                                @if($leaveRequest['approvedLeaveRequest']->leave_status === 2)
                                <span class="approvedColor">APPROVED</span>
                                @elseif($leaveRequest['approvedLeaveRequest']->leave_status === 3)
                                <span class="rejectColor">REJECTED</span>
                                @else
                                <span class="normalTextValue">-</span>
                                @endif
                            </div>
                            @else
                            <div class="col accordion-content">
                                @if($leaveRequest['approvedLeaveRequest']->cancel_status === 2)
                                <span class="approvedColor">APPROVED</span>
                                @elseif($leaveRequest['approvedLeaveRequest']->cancel_status === 3)
                                <span class="rejectColor">REJECTED</span>
                                @else
                                <span class="normalTextValue">-</span>
                                @endif
                            </div>
                            @endif
                            <div class="arrow-btn px-1">
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-body m-0 p-0">
                        <div class="horizontalLine"></div>
                        <div class="review-content px-3">

                            <span class="normalTextValue">Duration:</span>

                            <span class="normalText font-weight-normal">

                                <span class="normalText">{{ $leaveRequest['approvedLeaveRequest']->formatted_from_date }}</span>

                                ({{ $leaveRequest['approvedLeaveRequest']->from_session }} ) to

                                <span class="normalText">{{ $leaveRequest['approvedLeaveRequest']->formatted_to_date }}</span>

                                ( {{ $leaveRequest['approvedLeaveRequest']->to_session }} )

                            </span>

                        </div>
                        @if($leaveRequest['approvedLeaveRequest']->category_type === 'Leave')
                        <div class="review-content px-3">

                            <span class="normalTextValue">Reason:</span>

                            <span class="normalText font-weight-400">{{ucfirst( $leaveRequest['approvedLeaveRequest']->reason) }}</span>
                        </div>
                        @else
                        @if($leaveRequest['approvedLeaveRequest']->category_type === 'Leave')
                        <div class="review-content px-3">

                            <span class="normalTextValue">Reason:</span>

                            <span class="normalText font-weight-400">{{ucfirst( $leaveRequest['approvedLeaveRequest']->leave_cancel_reason) }}</span>
                        </div>
                        @endif
                        @endif
                        <div class="horizontalLine"></div>
                        <div class="approvedLeaveDetails d-flex justify-content-between align-items-center">

                            <div class="review-content px-3">

                                <span class="normalTextValue">Applied on:</span>

                                <span class="normalText">{{ $leaveRequest['approvedLeaveRequest']->created_at->format('d M, Y') }}</span>

                            </div>
                            <div class="review-content px-3">
                                <span class="normalTextValue">Leave Balance:</span>
                                @if(!empty($leaveRequest['leaveBalances']))
                                <div class="d-flex align-items-center justify-content-center">

                                    <!-- Sick Leave -->

                                    <div class="sickLeaveCircle">

                                        <span class="sickLeaveBal">SL</span>

                                    </div>

                                    <span class="sickLeaveValue">{{ $leaveRequest['leaveBalances']['sickLeaveBalance'] }}</span>

                                    <!-- Casual Leave  -->

                                    <div class="casLeaveCircle">

                                        <span class="casLeaveBal">CL</span>

                                    </div>

                                    <span class="casLeaveValue">{{ $leaveRequest['leaveBalances']['casualLeaveBalance'] }}</span>

                                    <!-- Casual Leave  Probation-->
                                    @if($leaveRequest['approvedLeaveRequest']->leave_type === 'Casual Leave Probation' && isset($leaveRequest['leaveBalances']['casualProbationLeaveBalance']))
                                    <div class="probLeave">

                                        <span class="probLeaveBal">CLP</span>

                                    </div>
                                    <span class="probLeaveValue">{{ $leaveRequest['leaveBalances']['casualProbationLeaveBalance'] }}</span>

                                    <!-- Loss of Pay -->

                                    @elseif($leaveRequest['approvedLeaveRequest']->leave_type === 'Loss Of Pay' && isset($leaveRequest['leaveBalances']['lossOfPayBalance']))

                                    <div class="lossLeave">

                                        <span class="lossLeaveBal">LOP</span>

                                    </div>
                                    @if(($leaveRequest['leaveBalances']['lossOfPayBalance'])>0)
                                    <span class="lossLeaveValue">&minus;{{ $leaveRequest['leaveBalances']['lossOfPayBalance'] }}</span>
                                    @else
                                    <span class="lossLeaveValue">{{ $leaveRequest['leaveBalances']['lossOfPayBalance'] }}</span>
                                    @endif
                                    @elseif($leaveRequest['approvedLeaveRequest']->leave_type === 'Marriage Leave' && isset($leaveRequest['leaveBalances']['marriageLeaveBalance']))

                                    <div class="marriageLeave">

                                        <span class="marriageLeaveBal">MRL</span>

                                    </div>

                                    <span class="marriageLeaveValue">{{ $leaveRequest['leaveBalances']['marriageLeaveBalance'] }}</span>

                                    @elseif($leaveRequest['approvedLeaveRequest']->leave_type === 'Petarnity Leave' && isset($leaveRequest['leaveBalances']['paternityLeaveBalance']))

                                    <div class="petarnityLeave">

                                        <span class="petarnityLeaveBal">PL</span>

                                    </div>

                                    <span class="petarnityLeaveValue">{{ $leaveRequest['leaveBalances']['paternityLeaveBalance'] }}</span>

                                    @elseif($leaveRequest['approvedLeaveRequest']->leave_type === 'Maternity Leave' && isset($leaveRequest['leaveBalances']['maternityLeaveBalance']))

                                    <div class="maternityLeave">

                                        <span class="maternityLeaveBal">ML</span>

                                    </div>

                                    <span class="maternityLeaveValue">{{ $leaveRequest['leaveBalances']['maternityLeaveBalance'] }}</span>

                                    @endif

                                </div>
                                @else
                                <span class="normalText">0</span>
                                @endif

                            </div>

                            <div class="review-content px-3">
                                <a href="{{ route('approved-details', ['leaveRequestId' => $leaveRequest['approvedLeaveRequest']->id]) }}">
                                    <span class="anchorTagDetails">View Details</span>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>
                @endforeach
            </div>
            @else
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                <img src="/images/pending.png" alt="Pending Image" style="width:50%; margin:0 auto;">
                <p class="normalTextValue text-center">Hey, you have no leave records to view
                </p>
            </div>
            @endif
            <!-- if loginid is a normal employee they can view their leave history -->
            @else
            @if($empLeaveRequests->isNotEmpty())

            @foreach($empLeaveRequests as $leaveRequest)

            <div class="mt-4">

                <div class="accordion rounded">

                    <div class="accordion-heading rounded" onclick="toggleAccordion(this)">

                        <div class="accordion-title">

                            <!-- Display leave details here based on $leaveRequest -->

                            <div class="col accordion-content">

                                <span class="normalTextValue">Category</span>

                                <span class="normalText">{{ $leaveRequest->category_type}}</span>

                            </div>

                            <div class="col accordion-content">

                                <span class="normalTextValue">Leave Type</span>

                                <span class="normalText">{{ $leaveRequest->leave_type}}</span>

                            </div>

                            <div class="col accordion-content">

                                <span class="normalTextValue">No. of Days</span>

                                <span class="normalText">

                                    {{ $this->calculateNumberOfDays($leaveRequest->from_date, $leaveRequest->from_session, $leaveRequest->to_date, $leaveRequest->to_session, $leaveRequest->leave_typev) }}

                                </span>

                            </div>



                            <!-- Add other details based on your leave request structure -->
                            @if($leaveRequest->category_type === 'Leave Cancel')
                            <div class="col accordion-content">

                                @if($leaveRequest->cancel_status === 2)

                                <span class="approvedColor">APPROVED</span>

                                @elseif($leaveRequest->cancel_status === 3)

                                <span class="rejectColor">REJECTED</span>

                                @else

                                <span class="normalTextValue">WITHDRAWN</span>

                                @endif

                            </div>
                            @else
                            <div class="col accordion-content">

                                @if($leaveRequest->leave_status === 2)

                                <span class="approvedColor">APPROVED</span>

                                @elseif($leaveRequest->leave_status === 3)

                                <span class="rejectColor">REJECTED</span>

                                @else

                                <span class="normalTextValue">WITHDRAWN</span>

                                @endif

                            </div>
                            @endif

                            <div class="arrow-btn">
                                <i class="fa fa-chevron-down"></i>
                            </div>

                        </div>

                    </div>

                    <div class="accordion-body m-0 p-0">

                        <div class="verticalLine"></div>

                        <div class="content pt-1 px-3">

                            <span class="headerText">Duration:</span>

                            <span>

                                <span class="normalTextValueSmall"> {{ \Carbon\Carbon::parse($leaveRequest->from_date)->format('d-m-Y') }}</span>

                                ({{ $leaveRequest->from_session }} ) to

                                <span class="normalTextValueSmall"> {{ \Carbon\Carbon::parse($leaveRequest->to_date)->format('d-m-Y') }}</span>

                                ( {{ $leaveRequest->to_session }} )

                            </span>

                        </div>

                        <div class="content  pb-1 px-3">

                            <span class="headerText">Reason:</span>

                            <span class="normalTextValueSmall">{{ ucfirst($leaveRequest->reason) }}</span>

                        </div>

                        <div class="verticalLine"></div>

                        <div class="d-flex flex-row justify-content-between px-3 py-2">

                            <div class="content px-1 ">

                                <span class="headerText">Applied on:</span>

                                <span class="paragraphContent">{{ $leaveRequest->created_at->format('d M, Y') }}</span>

                            </div>

                            <div class="content px-1 ">
                                <a href="{{ route('approved-details', ['leaveRequestId' => $leaveRequest->id]) }}">
                                    <span class="anchorTagDetails">View
                                        Details</span>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            @endforeach

            @else

            <div class="containerWidth">
                <div class="leave-pending rounded">

                    <img src="{{asset('/images/pending.png')}}" alt="Pending Image" class="imgContainer">

                    <p class="restrictedHoliday">There are no records of any leave
                        transaction</p>

                </div>
            </div>

            @endif

            @endif


            @endif





        </div>


        @endif



    </div>

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
    </script>
</div>
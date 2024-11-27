<div class="position-relative">
    <div class="position-absolute" wire:loading
        wire:target="leaveApply,toggleInfo,applyingTo,getFilteredManagers,openModal,toggleManager,openCcRecipientsContainer,closeCcRecipientsContainer,searchCCRecipients,resetFields">
        <div class="loader-overlay">
            <div class="loader">
                <div></div>
            </div>
        </div>
    </div>
    <div class="applyContainer bg-white position-relative">
        @if($showinfoMessage)
        <div class="hide-leave-info p-2 px-2 mb-2 mt-2 rounded d-flex gap-2 align-items-center">
            <p class="mb-0 normalTextSmall">Leave is earned by an employee and granted by the employer to take time off work. The employee is free to
                avail this leave in accordance with the company policy.</p>
            <p class="mb-0 hideInfo" wire:click="toggleInfo">Hide</p>
        </div>
        @endif
        <div class=" d-flex justify-content-between">
            <p class="applyingFor">Applying for Leave</p>
            @if($showinfoButton)
            <p class="info-paragraph mb-0" wire:click="toggleInfo">Info</p>
            @endif
        </div>
        <form class="scrollLeaveApply m-0 p-2 " wire:submit.prevent="leaveApply" enctype="multipart/form-data">
            <div class="row d-flex align-items-center">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="leave_type">Leave Type <span class="requiredMark">*</span> </label> <br>
                        <div class="custom-select-wrapper mb-2" style="width: 65%;">
                            <select id="leave_type" class="form-control outline-none rounded placeholder-small" wire:click="selectLeave" wire:model.lazy="leave_type" name="leave_type" wire:change="handleFieldUpdate('leave_type')">
                                <option value="" disabled selected>Select Type</option>
                                @if($showCasualLeaveProbation == true)
                                <option value="Casual Leave Probation">Casual Leave Probation</option>
                                @else
                                <option value="Casual Leave">Casual Leave</option>
                                @endif
                                @if($showCasualLeaveProbationYear == true)
                                <option value="Casual Leave Probation">Casual Leave Probation</option>
                                @endif
                                <option value="Loss of Pay">Loss of Pay</option>
                                <option value="Marriage Leave">Marriage Leave</option>
                                @if($employeeGender && $employeeGender === 'FEMALE')
                                <option value="Maternity Leave">Maternity Leave</option>
                                @elseif($employeeGender && $employeeGender === 'MALE')
                                <option value="Paternity Leave">Paternity Leave</option>
                                @endif
                                <option value="Sick Leave">Sick Leave</option>
                            </select>
                        </div>
                        <br>
                        @error('leave_type') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
            <div class="row d-flex align-items-center">
                <div class="col-md-8">
                    <div class="row d-flex mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="from_date">From Date <span class="requiredMark">*</span> </label>
                                <input id="from_date" type="date" wire:model.lazy="from_date" wire:keydown.debounce.500ms="validateField('from_date')" class="form-control placeholder-small" name="from_date" wire:change="handleFieldUpdate('from_date')">
                                @error('from_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($showSessionDropdown)
                            <div class="form-group">
                                <label for="fromSession">Session</label> <br>
                                <div class="custom-select-wrapper">
                                    <select id="fromSession" class="form-control outline-none rounded placeholder-small" wire:model="from_session" wire:keydown.debounce.500ms="validateField('from_session')" name="fromSession" wire:change="handleFieldUpdate('from_session')">
                                        <option value="Session 1">Session 1</option>
                                        <option value="Session 2">Session 2</option>
                                    </select>
                                    @error('from_session') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row d-flex mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="toDate">To Date <span class="requiredMark">*</span> </label>
                                <input id="toDate" type="date" wire:model.lazy="to_date" class="form-control placeholder-small" wire:keydown.debounce.500ms="validateField('to_date')" name="toDate" wire:change="handleFieldUpdate('to_date')">
                                @error('to_date') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($showSessionDropdown)
                            <div class="form-group ">
                                <label for="to_session">Session</label> <br>
                                <div class="custom-select-wrapper">
                                    <select id="to_session" class="form-control outline-none rounded placeholder-small" wire:model="to_session" wire:keydown.debounce.500ms="validateField('to_session')" name="toSession" wire:change="handleFieldUpdate('to_session')">
                                        <option value="Session 1">Session 1</option>
                                        <option value="Session 2">Session 2</option>
                                    </select>
                                    @error('to_session') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4 checkLeaveBal">
                    <div class="form-group borderLeft">
                        <div class="pay-bal">
                            <span class="normalTextValue">Balance :</span>
                            @if(isset($leaveBalances) && !empty($leaveBalances))
                            <div class="downArrow d-flex align-items-center justify-content-center">
                                @if($leave_type == 'Sick Leave')
                                <span class="sickLeaveBalance" title="Sick Leave">
                                    {{ ($leaveBalances['sickLeaveBalance'] ?? '0') }}
                                </span>
                                @elseif($leave_type == 'Casual Leave')
                                <span class="sickLeaveBalance" title="Casual Leave">
                                    {{ ($leaveBalances['casualLeaveBalance'] ?? '0') }}
                                </span>
                                @elseif($leave_type == 'Casual Leave Probation')
                                <span class="sickLeaveBalance">
                                    {{ ($leaveBalances['casualProbationLeaveBalance'] ?? '0') }}
                                </span>
                                @elseif($leave_type == 'Loss of Pay')
                                <span class="sickLeaveBalance">
                                    @if(isset($leaveBalances['lossOfPayBalance']) && $leaveBalances['lossOfPayBalance'] > 0)
                                    &minus;&nbsp;{{ $leaveBalances['lossOfPayBalance'] }}
                                    @else
                                    {{ $leaveBalances['lossOfPayBalance'] ?? '0' }}
                                    @endif
                                </span>
                                @elseif($leave_type == 'Maternity Leave')
                                <span class="sickLeaveBalance">
                                    {{ ($leaveBalances['maternityLeaveBalance'] ?? '0') }}
                                </span>
                                @elseif($leave_type == 'Paternity Leave')
                                <span class="sickLeaveBalance">
                                    {{ ($leaveBalances['paternityLeaveBalance'] ?? '0') }}
                                </span>
                                @elseif($leave_type == 'Marriage Leave')
                                <span class="sickLeaveBalance">
                                    {{ ($leaveBalances['marriageLeaveBalance'] ?? '0') }}
                                </span>
                                @endif
                            </div>
                            @else
                            <span class="normalText">0</span>
                            @endif
                        </div>

                        <div class="form-group mb-0">
                            <span class="normalTextValue">Applying For :</span>
                            @if($showNumberOfDays)
                            @if($from_date && $to_date && $from_session && $to_session) <!-- Check for all date inputs -->
                            @php
                            $calculatedNumberOfDays = $this->calculateNumberOfDays($from_date, $from_session, $to_date, $to_session, $leave_type);
                            @endphp
                            <span id="numberOfDays" class="sickLeaveBalance">
                                {{ $calculatedNumberOfDays }}
                            </span>
                            @else
                            <span class="normalText">0</span>
                            @endif
                            @else
                            <span class="normalText">0</span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <div>
                @if($showApplyingTo)
                <div class="form-group mt-3">
                    <div class="d-flex " wire:click="applyingTo">
                        <span class="normalTextValue downArrow">
                            <img class="rounded-circle" src="https://t4.ftcdn.net/jpg/05/35/51/31/360_F_535513106_hwSrSN1TLzoqdfjWpv1zWQR9Y5lCen6q.jpg" alt="" width="35px" height="32px">
                            Applying To
                        </span>
                    </div>
                </div>
                @endif
                <!-- Your Blade file -->
                @if($show_reporting)
                <div class="form-group mt-3">
                    <span class="normalTextValue"> Applying To</span>
                </div>
                <div class="reporting rounded-pill mb-2">
                    @if($selectedManagerDetails)
                    @if($selectedManagerDetails->image && $selectedManagerDetails->image !=='null')
                    <div class="employee-profile-image-container">
                        <img class=" navProfileImg rounded-circle" height="40" width="40" src="data:image/jpeg;base64,{{($selectedManagerDetails->image)}} ">
                    </div>
                    @else
                    @if($selectedManagerDetails->gender=='FEMALE')
                    <div class="employee-profile-image-container">
                        <img src="{{ asset('images/female-default.jpg') }}" class="employee-profile-image-placeholder rounded-circle" height="40" width="40" alt="Default Image">
                    </div>
                    @elseif($selectedManagerDetails->gender=='MALE')
                    <div class="employee-profile-image-container">
                        <img src="{{ asset('images/male-default.png') }}" class="employee-profile-image-placeholder rounded-circle" height="40" width="40" alt="Default Image">
                    </div>
                    @else
                    <div class="employee-profile-image-container">
                        <img src="{{ asset('images/user.jpg') }}" class="employee-profile-image-placeholder rounded-circle" height="40" width="40" alt="Default Image">
                    </div>
                    @endif
                    @endif
                    <div class="p-0 m-0">
                        <p id="reportToText" class="ellipsis mb-0">{{ ucwords(strtolower($selectedManagerDetails->first_name)) }} {{ ucwords(strtolower($selectedManagerDetails->last_name)) }}</p>
                        <p class="mb-0 normalTextSmall" id="managerIdText"><span class="remaining">#{{$selectedManagerDetails->emp_id}}</span></p>
                    </div>
                    @else
                    <div class="p-0 m-0">
                        <p class="mb-0 normalTextSmall">N/A</p>
                        <p class="mb-0 normalTextSmall" id="managerIdText">#(N/A)</p>
                    </div>
                    @endif
                    <div class="downArrow" wire:click="applyingTo">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                @endif


                @if($showApplyingToContainer)
                <div class="searchContainer">
                    <!-- Content for the search container -->
                        <div class=" m-0 p-0 d-flex align-items-center justify-content-between">
                            <div class="searchapplyingto p-0 m-0">
                                <div class="input-group">
                                    <input
                                        wire:model="searchQuery"
                                        id="searchInput"
                                        type="text"
                                        class="form-control placeholder-small"
                                        placeholder="Search...."
                                        aria-label="Search"
                                        aria-describedby="basic-addon1">
                                    <div class="input-group-append searchBtnBg d-flex align-items-center">
                                        <button
                                            type="button"
                                            class="search-btn-leave"
                                            wire:click="getFilteredManagers">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="searchapplyingto-btn ms-2 m-0 p-0 d-flex justify-content-end">
                                <button wire:click="applyingTo" type="button" class="close rounded px-1 py-0" aria-label="Close">
                                    <span aria-hidden="true" class="closeIcon"><i class="fas fa-times "></i>
                                    </span>
                                </button>
                            </div>
                        </div>

                    <!-- Your Blade file -->
                    <div class="scrollApplyingTO">
                        @if(!empty($managers))
                        @foreach($managers as $employee)
                        <div class="d-flex gap-3 align-items-center"
                            style="cursor: pointer; @if(in_array($employee['emp_id'], $selectedManager)) background-color: #d6dbe0; @endif"
                            wire:click="toggleManager('{{ $employee['emp_id'] }}')" wire:key="{{ $employee['emp_id'] }}">
                            @if(!empty($employee['image']) && ($employee['image'] !== 'null') && $employee['image'] !== null && $employee['image'] != "Null" && $employee['image'] != "")
                            <div class="employee-profile-image-container">
                                <img class="rounded-circle navProfileImg" src="data:image/jpeg;base64,{{($employee['image'])}}">
                            </div>
                            @else
                            @if($employee['gender'] === 'FEMALE')
                            <div class="employee-profile-image-container">
                                <img src="{{ asset('images/female-default.jpg') }}" class="navProfileImg rounded-circle" alt="Default Image">
                            </div>
                            @elseif($employee['gender'] === 'MALE')
                            <div class="employee-profile-image-container">
                                <img src="{{ asset('images/male-default.png') }}" class="navProfileImg rounded-circle" alt="Default Image">
                            </div>
                            @else
                            <div class="employee-profile-image-container">
                                <img src="{{ asset('images/user.jpg') }}" class="navProfileImg rounded-circle" alt="Default Image">
                            </div>
                            @endif
                            @endif
                            <div class="d-flex flex-column mt-2 mb-2">
                                <span class="ellipsis mb-0">{{ $employee['full_name'] }}</span>
                                <span class="mb-0 normalTextSmall"> #{{ $employee['emp_id'] }} </span>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <p class="mb-0 normalTextValue m-auto text-center">No managers found.</p>
                        @endif
                    </div>
                </div>
                @endif
                @error('applying_to') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mt-3">
                <span class="normalTextValue">
                    CC To
                </span>
                <div class="control-wrapper d-flex align-items-center">
                    <a class="text-3 text-secondary no-underline control" aria-haspopup="true" wire:click="openCcRecipientsContainer">
                        <div class="icon-container">
                            <i class="fa fa-plus"></i>
                        </div>
                    </a>
                    <!-- Blade Template: your-component.blade.php -->
                    <span class="addText" wire:click="openCcRecipientsContainer">Add</span>

                    @if(count($selectedCCEmployees) > 0)
                    @php
                    $employeesCollection = collect($selectedCCEmployees);
                    $visibleEmployees = $employeesCollection->take(3);
                    $hiddenEmployees = $employeesCollection->slice(3);
                    @endphp

                    <ul class="d-flex align-items-center list-unstyled mb-0 gap-3 employee-list">
                        @foreach($visibleEmployees as $recipient)
                        <li class="employee-item">
                            <div class="px-2 py-1 d-flex justify-content-between align-items-center rounded-pill gap-3" style=" border: 2px solid #adb7c1;" title="{{ ucwords(strtolower($recipient['first_name'])) }} {{ ucwords(strtolower($recipient['last_name'])) }}">
                                <span class="text-container selecetdCcName font-weight-normal">
                                    {{ ucwords(strtolower($recipient['first_name'])) }} {{ ucwords(strtolower($recipient['last_name'])) }}
                                </span>
                                <i class="fas fa-times-circle cancel-icon d-flex align-items-center justify-content-end" style="cursor: pointer; color:#adb7c1;" wire:click="removeFromCcTo('{{ $recipient['emp_id'] }}')"></i>
                            </div>
                        </li>

                        @endforeach

                        @if(count($selectedCCEmployees) > 3)
                        <li>
                            <span type="button" wire:click="openModal" class="anchorTagDetails">View More</span>
                        </li>
                        @endif
                    </ul>

                    <!-- Popup Modal -->
                    @if($showCCEmployees)
                    <div class="modal d-block" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">CC To</h5>
                                    <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close"
                                        wire:click="openModal">
                                    </button>
                                </div>
                                <div class="modal-body d-flex align-items-center" style="max-width:100%;overflow-x:auto;">
                                    <ul class="d-flex align-items-center mb-0 list-unstyled gap-3">
                                        @foreach($hiddenEmployees as $recipient)
                                        <li class="employee-item">
                                            <div class="px-2 py-1 d-flex justify-content-between align-items-center rounded-pill gap-3" style=" border: 2px solid #adb7c1; " title="{{ ucwords(strtolower($recipient['first_name'])) }} {{ ucwords(strtolower($recipient['last_name'])) }}">
                                                <span class="text-container selecetdCcName font-weight-normal">
                                                    {{ ucwords(strtolower($recipient['first_name'])) }} {{ ucwords(strtolower($recipient['last_name'])) }}
                                                </span>
                                                <i class="fas fa-times-circle cancel-icon d-flex align-items-center justify-content-end" style="cursor: pointer; color:#adb7c1;" wire:click="removeFromCcTo('{{ $recipient['emp_id'] }}')"></i>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-backdrop fade show"></div>
                    @endif
                    @endif
                </div>

                @if($showCcRecipents)
                <div class="ccContainer" x-data="{ open: @entangle('showCcRecipents') }" x-cloak @click.away="open = false">
                    <div class="m-0 p-0 d-flex align-items-center justify-content-between">
                        <div class="cctosearch m-0 p-0">
                            <div class="input-group">
                                <input wire:model.debounce.500ms="searchTerm" id="searchInput" type="text" class="form-control placeholder-small" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon1" wire:keydown.enter.prevent="handleEnterKey">
                                <div class="input-group-append searchBtnBg d-flex align-items-center">
                                    <button type="button" wire:click="searchCCRecipients" class="search-btn-leave">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="cctobtn ms-2 m-0 p-0 d-flex justify-content-end">
                            <button wire:click="closeCcRecipientsContainer" type="button" class="close rounded px-1 py-0" aria-label="Close">
                                <span aria-hidden="true" class="closeIcon"><i class="fas fa-times "></i></span>
                            </button>
                        </div>
                    </div>
                    <div class="scrollApplyingTO mb-2 mt-2 ">
                        @if($ccRecipients && count($ccRecipients) > 0)
                        @foreach($ccRecipients as $employee)
                        <div class="borderContainer px-2 mb-2 rounded" wire:click="toggleSelection('{{ $employee->emp_id }}')">
                            <div class="downArrow d-flex align-items-center text-capitalize" wire:click.prevent>
                                <label class="custom-checkbox">
                                    <input type="checkbox"
                                        wire:model="selectedPeople.{{ $employee->emp_id }}" />
                                    <span class="checkmark"></span>
                                </label>
                                <div class="d-flex align-items-center gap-2">
                                    <div>
                                        @if(!empty($employee->image) && $employee->image !== 'null')
                                        <div class="employee-profile-image-container">
                                            <img class="navProfileImg rounded-circle" src="data:image/jpeg;base64,{{ $employee->image }}">
                                        </div>
                                        @else
                                        <div class="employee-profile-image-container">
                                            <img src="{{ $employee->gender === 'MALE' ? asset('images/male-default.png') : ($employee->gender === 'FEMALE' ? asset('images/female-default.jpg') : asset('images/user.jpg')) }}" class="employee-profile-image-placeholder rounded-circle" height="33" width="33">
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-2 mt-2">
                                        <p class="mb-0 empCcName">{{ ucwords(strtolower($employee->full_name)) }}</p>
                                        <p class="mb-0 empIdStyle">#{{ $employee->emp_id }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="mb-0 normalTextValue">
                            No data found
                        </div>
                        @endif
                    </div>

                </div>
                @endif
                @error('cc_to') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mt-3">
                <label for="contactDetails">Contact Details <span class="requiredMark">*</span> </label>
                <input id="contactDetails" type="text" wire:model.lazy="contact_details" class="form-control placeholder-small" wire:keydown.debounce.500ms="validateField('contact_details')" name="contactDetails">
                @error('contact_details') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mt-3">
                <label for="reason">Reason <span class="requiredMark">*</span> </label>
                <textarea id="reason" class="form-control placeholder-small" wire:model.lazy="reason" wire:keydown.debounce.500ms="validateField('reason')" name="reason" placeholder="Enter a reason" rows="4"></textarea>
                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mt-3">
                <label for="file_paths">Attachments</label> <br>
                <input id="file_paths" style="font-size:12px;" type="file"
                    wire:model="file_paths"
                    wire:keydown="validateField('file_paths')"
                    wire:change="handleFieldUpdate('file_paths')"
                    multiple />
                @error('file_paths.*') <span class="text-danger">{{ $message }}</span> @enderror <br>
                <span class="normalTextValue mt-2 fw-normal">File type : xls,csv,xlsx,pdf,jpeg,png,jpg,gif</span>
            </div>

            <div class="buttons-leave">
                <button type="submit" class="submit-btn" @if(isset($insufficientBalance)) disabled @endif>Submit</button>
                <button type="button" class="cancel-btn" wire:click="resetFields">Cancel</button>
            </div>
        </form>
    </div>
</div>
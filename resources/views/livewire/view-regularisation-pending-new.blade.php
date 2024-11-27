<div>
<style>
        #remarks::placeholder {
            color: #a3b2c7;
            font-size: 12px;
        }

    </style>
    <div>
    <div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if (session()->has('success'))
            <div class="alert alert-success"wire:poll.10s="hideAlert">
                {{ session('success') }}
                
 
            </div>
    @elseif (session()->has('success'))
           <div class="alert alert-danger"wire:poll.10s="hideAlert">
                {{ session('success') }}
                
            </div>
    @endif
    
</div>
    
    <div class="row m-0 p-0 mt-3">
                <div class="reviewCountShow p-0">
                    <div class="d-flex align-items-center gap-2">
                        @if(count($regularisations) > 0)
                        <span class="totalRequestCount">Total Attendance  Requests
                            <span class="leaveCountReview d-flex align-items-center justify-content-center">
                                {{ $countofregularisations }}
                            </span>
                        </span>
                        @endif
                    </div>
                    <div class="search-container d-flex align-items-end justify-content-end p-2" style="position: relative;">
                        <input type="text" wire:model.debounce.500ms="searchQuery" id="searchInput" placeholder="Search..." class="form-control placeholder-small border outline-none rounded" style="padding-right: 40px;">
                        <button wire:click="searchRegularisation" id="searchButtonReports">
                            <i class="fas fa-search" style="width: 16px; height: 16px;"></i>
                        </button>
                    </div>
                </div>    
    </div>
    @if(count($regularisations)>0)
    @foreach($regularisations as $r)
    @php
    $regularisationEntries = json_decode($r->regularisation_entries, true);
    $numberOfEntries = count($regularisationEntries);
    $firstItem = reset($regularisationEntries); // Get the first item
    $lastItem = end($regularisationEntries); // Get the last item
    @endphp
    @foreach($regularisationEntries as $r1)
    @if(empty($r1['date']))
    @php
    $numberOfEntries-=1;
    @endphp
    @endif

    @endforeach
    


    <div class="accordion bg-white border mb-3 rounded">
        <div class="accordion-heading rounded">

            <div class="accordion-title p-2 rounded">

                <!-- Display leave details here based on $leaveRequest -->
                <div class="accordion-content col">

                @if(isset($r->employee->image) && $r->employee->image !== 'null' && $r->employee->image != "Null" && $r->employee->image != "")
                                    <img height="40" width="40" src="data:image/jpeg;base64,{{ ($r->employee->image) }}" style="border-radius: 50%;margin-right:180px;">
                                    @else
                                    @if($r->employee->gender === 'FEMALE')
                                    <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                    @elseif($r->employee->gender === 'MALE')
                                    <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                    @else
                                    <img src="{{ asset('images/user.jpg') }}" alt="" height="40" width="40" style="border-radius: 50%;">
                                    @endif
                                    @endif

                </div>

                <div class="accordion-content col"style="margin-right:100px;">

                    <span style="color: #778899; font-size: 12px; font-weight: 500;">{{ucwords(strtolower($r->employee->first_name))}}&nbsp;{{ucwords(strtolower($r->employee->last_name))}}</span>

                    <span style="color: #36454F; font-size: 10px; font-weight: 500;">{{$r->emp_id}}</span>

                </div>



                <div class="accordion-content col">

                    <span style="color: #778899; font-size: 12px; font-weight: 500;">No. of Days</span>

                    <span style="color: #36454F; font-size: 12px; font-weight: 500;">
                        {{$numberOfEntries}}
                    </span>

                </div>


                <!-- Add other details based on your leave request structure -->



                <div class="arrow-btn" wire:click="toggleActiveAccordion({{ $r->id }})"
                        style="color:{{ in_array($r->id, $openAccordions) ? '#3a9efd' : '#778899' }};
                                border:1px solid {{ in_array($r->id, $openAccordions) ? '#3a9efd' : '#778899' }};">
                        <i class="fa fa-angle-{{ in_array($r->id, $openAccordions) ? 'up' : 'down' }}"
                        style="color:{{ in_array($r->id, $openAccordions) ? '#3a9efd' : '#778899' }}"></i>
                </div>

            </div>

        </div>
        @if(in_array($r->id, $openAccordions))
        <div class="accordion-body m-0 p-0"style="display:block ;">

            <div style="width:100%; height:1px; border-bottom:1px solid #ccc;"></div>

            <div class="content px-4 py-2">

                <span style="color: #778899; font-size: 12px; font-weight: 500;">Dates Applied:</span>

                <span style="font-size: 11px;">
                    @if($r->regularisation_entries_count>1)
                    <span style="font-size: 11px; font-weight: 500;"></span>

                    {{ date('(d', strtotime($firstItem['date'])) }} -

                    <span style="font-size: 11px; font-weight: 500;"></span>

                                @if (!empty($lastItem['date']))
                                {{ date('d)', strtotime($lastItem['date'])) }} {{ date('M Y', strtotime($lastItem['date'])) }}
                                @endif
                    @else
                    {{ date('d', strtotime($firstItem['date'])) }} {{ date('M Y', strtotime($lastItem['date'])) }}
                    @endif

                </span>

            </div>



            <div style="width:100%; height:1px; border-bottom:1px solid #ccc; margin-bottom:10px;"></div>

            <div style="display:flex; flex-direction:row; justify-content:space-between;">

                <div class="content mb-2 mt-0 px-4">

                    <span style="color: #778899; font-size: 12px; font-weight: 500;">Applied on:</span>

                    <span style="color: #333; font-size:12px; font-weight: 500;">{{ \Carbon\Carbon::parse($r->created_at)->format('d M, Y') }}
                    </span>

                </div>

                <div class="content mb-2 px-4 d-flex gap-2">
                    <a href="{{ route('review-pending-regularation', ['id' => $r->id, 'count' => $countofregularisations]) }}" class="anchorTagDetails">View Details</a>
                    <button class="rejectBtn"wire:click="openRejectModal">Reject</button>
                    <button class="approveBtn"wire:click="openApproveModal">Approve</button>
                </div>
                @if($openRejectPopupModal==true)
                <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #f5f5f5; height: 50px">
                                <h5 class="modal-title" id="rejectModalTitle"style="color:#778899;">Reject Request</h5>
                                <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closeRejectModal" style="background-color: #f5f5f5;border-radius:20px;font-size:12px;border:2px solid #778899;height:15px;width:15px;" >
                                </button>
                            </div>
                            <div class="modal-body" style="max-height:300px;overflow-y:auto">
                                    <p style="font-size:14px;">Are you sure you want to reject this application?</p>
                                    <div class="form-group">
                                            <label for="remarks" style="font-size:12px;color:#666;font-weight:400;">Remarks</label>
                                            <input type="text" class="form-control placeholder-small" id="remarks" placeholder="Enter reason here" wire:model="remarks" style="height: 100px; padding-bottom: 70px;">
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button"class="approveBtn"wire:click="reject({{$r->id}})">Confirm</button>
                                <button type="button"class="rejectBtn"wire:click="closeRejectModal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show blurred-backdrop"></div>
                @endif
                @if($openApprovePopupModal==true)
                        <div class="modal" tabindex="-1" role="dialog" style="display: block;">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #f5f5f5; height: 50px">
                                        <h5 class="modal-title" id="approveModalTitle"style="color:#778899;">Approve Request</h5>
                                        <button type="button" class="btn-close btn-primary" data-dismiss="modal" aria-label="Close" wire:click="closeApproveModal" style="background-color: #f5f5f5;font-size:12px;border-radius:20px;border:2px solid #778899;height:15px;width:15px;" >
                                        </button>
                                    </div>
                                    <div class="modal-body" style="max-height:300px;overflow-y:auto">
                                            <p style="font-size:14px;">Are you sure you want to approve this application?</p>
                                            <div class="form-group">
                                                    <label for="remarks" style="font-size:12px;color:#666;font-weight:400;">Remarks</label>
                                                    <input type="text" class="form-control" id="remarks" placeholder="Enter reason here" wire:model="remarks" style="height: 100px; padding-bottom: 70px;">
                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                            <button type="button"class="approveBtn"wire:click="approve({{$r->id}})">Confirm</button>
                                            <button type="button"class="rejectBtn"wire:click="closeApproveModal">Cancel</button>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-backdrop fade show blurred-backdrop"></div>
                @endif
            </div>
        </div>
        @endif


    </div>
      @endforeach
    @else
            <div class="d-flex flex-column justify-content-center bg-white rounded border text-center">
                            <img src="/images/pending.png" alt="Pending Image" style="width:55%; margin:0 auto;">
                            <p style="color:#969ea9; font-size:12px; font-weight:400; ">Hey, you have no regularization records to view
                            </p>
            </div>
    @endif
    </div>

</div>

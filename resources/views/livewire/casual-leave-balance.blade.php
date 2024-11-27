<div>

    <div class="row m-0 px-2 py-1 ">
        @if(session()->has('emp_error'))
        <div class="alert alert-danger">
            {{ session('emp_error') }}
        </div>
        @endif
        <div class="row m-0 p-0">
            <div class="col-md-7 col-sm-12 p-0 m-0 ">
                <ol class="breadcrumb d-flex align-items-center ">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('leave-balance') }}">Leave Balance</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Casual Leave</li>
                </ol>
            </div>
            <div class="col-md-5 ">
                <div class="buttons-container d-flex gap-3 justify-content-end  p-0 ">
                    @if($year==$currentYear)
                    <button class="leaveApply-balance-buttons  py-2 px-4  rounded" onclick="window.location.href='/leave-form-page'">Apply</button>
                    @endif
                    <select class="dropdown bg-white rounded select-year-dropdown " wire:change='changeYear($event.target.value)' wire:model='year'>
                        <?php
                        // Get the current year
                        $currentYear = date('Y');
                        // Generate options for current year, previous year, and next year
                        $options = [$currentYear - 2, $currentYear - 1, $currentYear, $currentYear + 1];
                        ?>
                        @foreach($options as $pre_year)
                        <option value="{{ $pre_year }}">{{ $pre_year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if($employeeLeaveBalances == 0)
            <div class="row m-0 p-0">
                <div class="col-md-12 leave-details-col-md-12">
                    <div class="card leave-details-card">
                        <div class="card-body leave-details-card-body">
                            <h6 class="card-title">Information</h6>
                            @if($year <= $currentYear)
                                <p class="card-text">No information found</p>
                                @else

                                <p class="card-text">HR will add the leaves</p>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row m-0 p-0">

                <div class="col-12 mt-2 d-flex justify-content-start">
                    <div class="info-container">
                        <div class="info-item px-2">
                            <div class="info-title">Available Balance</div>
                            <div class="info-value">{{ $Availablebalance }}</div>
                        </div>
                        <div class="info-item px-2">
                            <div class="info-title">Opening Balance</div>
                            <div class="info-value">0</div>
                        </div>
                        <div class="info-item px-2">
                            <div class="info-title">Granted</div>

                            <div class="info-value">{{ $employeeLeaveBalances}}</div>

                        </div>
                        <div class="info-item px-2">
                            <div class="info-title">Availed</div>
                            <div class="info-value">{{ $totalSickDays }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="conatiner mt-4 ">
                <div class="row m-0 p-0">
                    <div class=" p-2 bg-white border">
                        <div class="col-md-10">
                            <canvas class="leave-details-canvas" id="casualLeaveChart">
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-0 m-0">
                <div class="col-md-12 mt-4">
                    <div class="custom-table-wrapper-leave-details bg-white border rounded ">
                        <table class="balance-table table-responsive ">
                            <thead class="thead">
                                <tr>
                                    <th>Transaction Type</th>
                                    <th>Posted On</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Days</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employeeleaveavlid as $index => $balance)
                                <tr>
                                    <td>
                                        @if($balance->category_type === 'Leave')
                                        @if($balance->leave_status == '2')
                                        Availed
                                        @elseif($balance->leave_status == '5' )
                                        Applied
                                        @elseif($balance->leave_status == '4' )
                                        Withdrawn
                                        @else
                                        Rejected
                                        @endif
                                        @else
                                        @if($balance->cancel_status=='7')
                                        Leave Cancel-Applied

                                        @elseif($balance->cancel_status=='2')
                                        Leave Cancel-Approved
                                        @elseif($balance->cancel_status=='3')
                                        Leave Cancel-Rejected
                                        @elseif($balance->cancel_status=='4')
                                        Leave Cancel-Withdrawn
                                        @endif
                                        @endif
                                    </td>
                                    <td>{{ date('d M Y', strtotime($balance->created_at)) }}</td>
                                    <td>{{ date('d M Y', strtotime($balance->from_date)) }}</td>
                                    <td>{{ date('d M Y', strtotime($balance->to_date)) }}</td>
                                    <td>
                                        @php
                                        $days = $this->calculateNumberOfDays($balance->from_date, $balance->from_session, $balance->to_date, $balance->to_session,$balance->leave_type);
                                        @endphp
                                        {{ $days }}
                                    </td>
                                    @if($balance->category_type === 'Leave')
                                    <td>{{ $balance->reason }}</td>
                                    @else
                                    <td>{{ $balance->leave_cancel_reason }}</td>
                                    @endif
                                </tr>
                                @endforeach
                                @foreach($leaveGrantedData as $index => $balance)
                                <tr>
                                    <td>{{ $balance->status }}</td>
                                    <td>{{ date('d M Y', strtotime($balance->created_at)) }}</td>
                                    <td>{{ date('d M Y', strtotime('first day of January', strtotime($balance->period))) }}</td>
                                    <td>{{ date('d M Y', strtotime('last day of December', strtotime($balance->period))) }}</td>


                                    <td>{{ $employeeLeaveBalances }}</td>
                                    <td>Annual Grant for the present year </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<script>
    // Ensure that Chart.js is properly loaded
    document.addEventListener("DOMContentLoaded", function() {
        // Convert PHP variables to JavaScript
        var chartData = @json($chartData);
        var chartOptions = @json($chartOptions);

        // Get the context of the canvas element
        var ctx = document.getElementById('casualLeaveChart').getContext('2d');

        // Create the chart
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: chartOptions
        });

    });
</script>

<!-- <script>
    var ctx = document.getElementById('sickLeaveChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data:  json_encode($chartData),
        options: json_encode($chartOptions)
    });
    console.log(json_encode($chartData));
</script> -->

<?php

use App\Livewire\AllTeamTimeSheets;
use App\Livewire\LeaveFormPage;
use App\Models\EmpSalaryRevision;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Livewire\Activities;
use App\Livewire\ApprovedDetails;
use App\Livewire\AddEmployeeDetails;
use App\Livewire\AddHolidayList;
use App\Livewire\ProfileCard;
use App\Livewire\ReviewClosedRegularisation;
use App\Livewire\SickLeaveBalance;
use App\Livewire\UpdateEmployeeDetails;
use App\Livewire\Delegates;
use App\Livewire\EmpLogin;
use App\Livewire\EmployeesReview;
use App\Livewire\Everyone;
use App\Livewire\Feeds;
use App\Livewire\Catalog;

use App\Http\Controllers\GoogleDriveController;
use App\Livewire\Attendance;
use App\Livewire\AuthChecking;
use App\Livewire\GoogleLogins;
use App\Livewire\LeaveCalender;
use App\Livewire\LeaveHistory;
use App\Livewire\LeavePending;
use App\Livewire\Payslip;
use App\Livewire\Regularisation;

use App\Livewire\RegularisationPending;
use App\Livewire\EmployeeSwipes;
use App\Livewire\AttendanceMusterData;
use App\Livewire\AttendanceMuster;
use App\Livewire\AttendanceTableNew;
use App\Livewire\AttendenceMasterDataNew;
use App\Livewire\Chat\Chat;
use App\Livewire\EmployeeSwipesData;
use Illuminate\Support\Facades\Response;
use App\Livewire\HelpDesk;
use App\Livewire\Home;
use App\Livewire\Peoples;
use App\Livewire\ProfileInfo;
use App\Livewire\ReviewLeave;
use App\Livewire\ReviewRegularizations;
use App\Livewire\SalaryRevisions;
use App\Livewire\Settings;
use App\Livewire\Review;
use App\Livewire\Tasks;
// use App\Livewire\Loan;
use App\Livewire\Itdeclaration;
use App\Livewire\Itstatement1;
use App\Livewire\Payroll;
use App\Livewire\SalarySlips;
use App\Livewire\PlanA;
use App\Livewire\Documents;
use App\Livewire\Declaration;
use App\Livewire\DocForms;
use App\Livewire\Downloadform;
use App\Livewire\Documentcenter;
use App\Livewire\DocumentCenterLetters;
use App\Livewire\EmpList;
use App\Livewire\Investment;
use App\Livewire\LeaveApply;
use App\Livewire\LeavePage;

// use App\Livewire\SalaryRevisions;
use App\Livewire\Reimbursement;
use App\Livewire\LeaveBalances;
use App\Livewire\WhoIsInChart;
use App\Livewire\LeaveCancel;
use App\Livewire\TeamOnLeave;
use App\Livewire\HolidayCalender;
use App\Livewire\HomeDashboard;
use App\Livewire\LeaveBalanaceAsOnADay;
use App\Livewire\LetterRequests;
use App\Livewire\TeamOnLeaveChart;
use App\Livewire\CasualLeaveBalance;
use App\Livewire\CasualProbationLeaveBalance;
use App\Livewire\Chat\EmployeeList;
use App\Livewire\ViewDetails;
use App\Livewire\ViewDetails1;
use App\Livewire\ListOfAppliedJobs;
use App\Livewire\RegularisationHistory;
use App\Livewire\HrAttendanceOverviewNew;
use App\Livewire\WhoisinChartHr;
use App\Livewire\TeamOnAttendance;
use App\Livewire\TeamOnAttendanceChart;
use App\Livewire\ViewPendingDetails;
use App\Livewire\Emojies;
use App\Livewire\EmployeeAssetsDetails;
use App\Livewire\EmployeeDirectory;
use App\Livewire\EmployeesReviewNew;
use App\Livewire\EmpPostrequest;
use App\Livewire\EmpTimeSheet;
use App\Livewire\GrantLeaveBalance;
use App\Livewire\ImageUpload;
use App\Livewire\IncidentRequests;
use App\Livewire\ItDashboardPage;
use App\Livewire\LeaveBalancesChart;
use App\Livewire\OrganisationChart;
use App\Livewire\PasswordResetComponent;
use App\Livewire\ReportManagement;
use App\Livewire\ReviewPendingRegularisation;
use App\Livewire\ShiftRoaster;
use App\Livewire\SickLeaveBalances;
use App\Livewire\Test;
use App\Livewire\ViewRegularisationPendingNew;
use App\Livewire\Ytdreport;
use App\Models\Message;
use App\Models\SalaryRevision;
use Illuminate\Support\Facades\Route;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\HelpDesks;
use App\Models\Task;
use Illuminate\Support\Facades\File;

Route::group(['middleware' => 'checkAuth'], function () {

    Route::get('/emplogin', EmpLogin::class)->name('emplogin');
    Route::get('/CompanyLogin', function () {
        return view('company_login_view');
    });


    Route::get('/login', [GoogleLogins::class, 'redirectToGoogle'])->name('login');
    Route::get('/auth/google/callback', [GoogleLogins::class, 'handleGoogleCallback'])->name('auth/google/callback');
    Route::get('/Jobs', function () {
        return view('jobs_view');
    });
    Route::get('/CreateCV', function () {
        return view('create_cv_view');
    });
});

Route::get('/Login&Register', function () {
    return view('login_and_register_view');
});

Route::get('/Privacy&Policy', function () {
    return view('privacy_policy_view');
});

Route::get('/Terms&Services', function () {
    return view('terms_services_view');
});


Route::middleware(['auth:web', 'handleSession'])->group(function () {
    Route::get('/CreateCV', function () {
        return view('create_cv_view');
    });
    Route::get('/Jobs', function () {
        return view('jobs_view');
    });


    Route::get('/AllNotifications', function () {
        return view('all-notifications_view');
    });
    Route::get('/NotificationList{jobId}', function ($jobId) {
        return view('notification_list_view', compact('jobId'));
    })->name('job-interview-details');

    Route::get('/UserProfile', function () {
        return view('user_profile_view');
    });
    Route::get('/full-job-view/{jobId}', function ($jobId) {
        return view('full_job_details_view', compact('jobId'));
    })->name('full-job-view');

    Route::get('/AppliedJobs', function () {
        return view('applied_jobs_view');
    });
    Route::get('/list-of-applied-jobs', ListOfAppliedJobs::class)->name('list-of-applied-jobs');
    Route::get('/Companies', function () {
        return view('companies_view');
    });
    Route::get('/company-based-jobs/{companyId}', function ($companyId) {
        return view('company_based_jobs_view', compact('companyId'));
    })->name('company-based-jobs');
    Route::get('/VendorScreen', function () {
        return view('vendor_screen_view');
    });
});



Route::middleware(['auth:com', 'handleSession'])->group(function () {
    Route::get('/PostJobs', function () {
        return view('post_jobs_view');
    });


    Route::get('/VendorsSubmittedCVs', function () {
        return view('vendors-submitted-cvs');
    });
    Route::get('/JobSeekersAppliedJobs', function () {
        return view('job-seekers-applied-jobs');
    });

    Route::get('/empregister', function () {
        return view('emp-register-view');
    });
    // Route::get('/emplist', EmpList::class)->name('emplist');
    Route::get('/emplist', function () {
        return view('emp-list-view');
    });

    Route::get('/emp-update/{empId}', function ($empId) {
        return view('emp-update-view', compact('empId'));
    })->name('emp-update');
});

Route::middleware(['auth:hr', 'handleSession'])->group(function () {
    Route::get('/hrFeeds', Feeds::class)->name('hrfeeds');
    Route::get('/hreveryone', Everyone::class)->name('hreveryone');
    Route::get('/hrevents', Activities::class);
    Route::get('/hrPage', AuthChecking::class)->name('hrPage');
    Route::get('/home-dashboard', HomeDashboard::class)->name('admin-home');
    Route::get('/letter-requests', LetterRequests::class)->name('letter-requests');
    Route::get('/add-employee-details/{employee?}', AddEmployeeDetails::class)->name('add-employee-details');
    Route::get('/update-employee-details', UpdateEmployeeDetails::class)->name('update-employee-details');
    Route::get('/whoisinhrchart', WhoisinChartHr::class)->name('whoisinhrchart');
    // Route::get('/hrleaveOverview', HrLeaveOverview::class)->name('hrleaveOverview');
    Route::get('/hrAttendanceOverview', HrAttendanceOverviewNew::class)->name('hrAttendanceOverview');
    Route::get('/addLeaves', GrantLeaveBalance::class)->name('leave-grant');
    // Route::get('/hremployeedirectory', EmployeeDirectory::class)->name('employee-directory');
    Route::get('/hrorganisationchart', OrganisationChart::class)->name('organisation-chart');
    Route::get('/add-holiday-list', AddHolidayList::class)->name('holiday-list');
    // Route::get('/linechart', LineChart::class)->name('linechart');
});

Route::middleware(['auth:finance', 'handleSession'])->group(function () {
    Route::get('/financePage', AuthChecking::class)->name('financePage');
});

Route::middleware(['auth:it', 'handleSession'])->group(function () {
    Route::get('/itPage', AuthChecking::class)->name('IT-requests');
    Route::get('/ithomepage', ItDashboardPage::class)->name('ithomepage');
});

Route::middleware(['auth:admins', 'handleSession'])->group(function () {
    Route::get('/adminPage', AuthChecking::class)->name('auth-checking');
});


Route::middleware(['auth:emp', 'handleSession'])->group(function () {
    Route::get('/google-redirect', [GoogleDriveController::class, 'auth'])
        ->name('google-redirect');
    Route::get('/google-callback', [GoogleDriveController::class, 'callback'])
        ->name('google-callback');

    Route::get('/', Home::class)->name('home');
    Route::get('/doc-forms', DocForms::class);
    Route::get('/LeaveBalanceAsOnADay', LeaveBalanaceAsOnADay::class);

    // Attendance Routes
    Route::get('/Attendance', Attendance::class)->name('Attendance info');
    Route::get('/whoisinchart', WhoIsInChart::class)->name('whoisin');
    Route::get('/regularisation', Regularisation::class)->name('regularisation');
    Route::get('/regularisation-pending/{id}', RegularisationPending::class)->name('regularisation-pending');
    Route::get('/regularisation-history/{id}', RegularisationHistory::class)->name('regularisation-history');
    Route::get('/employee-swipes-data', EmployeeSwipesData::class)->name('employee-swipes-data');
    Route::get('/attendance-muster-data', AttendenceMasterDataNew::class)->name('attendance-muster-data');
    Route::get('/shift-roaster-data', ShiftRoaster::class)->name('shift-roaster-data');
    Route::get('/ProfileInfo', ProfileInfo::class)->name('profile.info');
    Route::get('/ProfileCard', ProfileCard::class)->name('profile');
    Route::get('/Settings', Settings::class)->name('settings');
    Route::get('/view-regularisation-pending-new', ViewRegularisationPendingNew::class)->name('view-regularisation-pending-new');
    Route::get('/review-pending-regularation/{id}/{count}', ReviewPendingRegularisation::class)->name('review-pending-regularation');
    Route::get('/review-closed-regularation/{id}', ReviewClosedRegularisation::class)->name('review-closed-regularation');
    Route::get('/time-sheet', EmpTimeSheet::class)->name('time-sheet');
    Route::get('/team-time-sheets', AllTeamTimeSheets::class)->name('team-time-sheets');


    //Feeds Module
    Route::get('/Feeds', Feeds::class)->name('Feeds');
    Route::get('/events', Everyone::class)->name('events');
    Route::get('/everyone', Everyone::class)->name('everyone');
    Route::get('/emp-post-requests', EmpPostrequest::class)->name('emp-post-requests');

    //People module
    Route::get('/PeoplesList', Peoples::class)->name('people');


    //Helpdesk module

    Route::get('/HelpDesk', HelpDesk::class)->name('helpdesk');

    Route::get('/catalog', Catalog::class)->name('catalog');
    Route::get('/incident', IncidentRequests::class)->name('incident');

    // Related salary module and ITdeclaration Document center
    Route::get('/payslip', Payroll::class);
    Route::get('/slip', SalarySlips::class)->name('payslips');
    Route::get('/itdeclaration', Itdeclaration::class)->name('itdeclaration');
    Route::get('/itstatement', Itstatement1::class)->name('IT-Statement');
    Route::get('/plan-A', PlanA::class)->name('plan-a');
    Route::get('/document-center-letters', DocumentCenterLetters::class);
    Route::get('/delegates', Delegates::class)->name('work-flow-delegates');
    Route::get('/salary-revision', SalaryRevisions::class)->name('salary-revision');
    Route::get('/plan-C', PlanA::class)->name('plan-c');
    Route::get('/formdeclaration', Declaration::class)->name('IT-Declaration');
    Route::get('/document', Documentcenter::class)->name('Document-center');
    Route::get('/reimbursement', Reimbursement::class)->name('reimbursement');
    Route::get('/investment', Investment::class)->name('proof-of-investment');
    Route::get('/documents', Documents::class);
    Route::get('/ytd', Ytdreport::class)->name('ytdreport');
    Route::get('download/file/{id}', function ($id) {
        $message = Message::findOrFail($id);

        return Response::make($message->file_path, 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . basename($message->file_path) . '"',
        ]);
    })->name('download.file');
    // In web.php
    Route::get('/download-image', [HelpDesk::class, 'downloadImage'])->name('downloadImage');



    //leave module
    Route::get('/leave-form-page', LeaveFormPage::class)->name('leave-form-page');
    Route::get('/approved-details/{leaveRequestId}', ApprovedDetails::class)->name('approved-details');
    Route::get('/view-details/{leaveRequestId}', ViewDetails::class)->name('view-details');
    Route::get('/view-pending-details', ViewDetails::class)->name('pending-details');
    Route::get('/holiday-calendar', HolidayCalender::class)->name('holiday-calendar');
    Route::get('/leave-balances', LeaveBalances::class)->name('leave-balance');
    Route::get('/leave-balances/casualleavebalance', CasualLeaveBalance::class)->name('casual-leave-balance');
    Route::get('/leave-balances/sickleavebalance', SickLeaveBalances::class)->name('sick-leave-balance');
    Route::get('/leave-balances/casualprobationleavebalance', CasualProbationLeaveBalance::class)->name('casual-probation-leave-balance');
    Route::get('/leave-calender', LeaveCalender::class)->name('leave-calendar');
    Route::get('/leave-history/{leaveRequestId}', LeaveHistory::class)->name('leave-history');
    Route::get('/leave-pending/{leaveRequestId}', LeavePending::class)->name('leave-pending');
    Route::get('/team-on-leave-chart', TeamOnLeaveChart::class)->name('team-on-leave');
    // Route::get('/leaveBalChart', LeaveBalancesChart::class)->name('leave-details');
    // Route::get('/navigate-to-helpdesk', [EmployeesReview::class, 'navigateToHelpdesk'])->name('navigate.to.helpdesk');

    // TODO module
    Route::get('/tasks', Tasks::class)->name('tasks');

    Route::get('/employees-review', EmployeesReview::class)->name('review');
    Route::get('/reports', ReportManagement::class)->name('reports');
    Route::get('/review-regularizations', ReviewRegularizations::class)->name('regularizations');

    // ####################################### Chat Module Routes #########################endregion
    Route::get('/users', EmployeeList::class)->name('users');
    Route::get('/chat', Chat::class)->name('chat');
    //*******************************************  End Of Chat Module Routes *************************/
});






Route::get('/itform', function () {
    return view('itform');
});

//Download routes
Route::get('/your-download-route', function () {
    return view('download-pdf');
});
Route::get('/downloadform', function () {
    return view('downloadform');
});

Route::get('/attune-reports', function () {
    return view('mail-content_view');
});

Route::get('/data-entry', function () {
    return view('data-entry_view');
});
Route::get('/ytdpayslip', function () {
    return view('ytdpayslip');
});







#########################################This are routes for checking hash and encrypt values################################################################################################################################################################

use App\Models\EmpSalary;
use Illuminate\Support\Facades\Artisan;

Route::get('/encode/{value}', function ($value) {
    // Determine the number of decimal places
    $decimalPlaces = strpos($value, '.') !== false ? strlen(substr(strrchr($value, "."), 1)) : 0;

    // Convert the float to an integer with precision
    $factor = pow(10, $decimalPlaces);
    $integerValue = intval($value * $factor);

    // Encode the integer value along with the decimal places
    $hash = Hashids::encode($integerValue, $decimalPlaces);

    return response()->json([
        'value' => $value,
        'hash' => $hash,
        // 'decimalPlaces' => $decimalPlaces
    ]);
});



Route::get('/decode/{hash}', function ($hash) {
    // Decode the hash
    $decoded = Hashids::decode($hash);

    // Check if decoding was successful
    if (count($decoded) === 0) {
        return response()->json(['error' => 'Invalid hash'], 400);
    }

    // Retrieve the integer value and decimal places
    $integerValue = $decoded[0];
    $decimalPlaces = $decoded[1] ?? 0; // Fallback to 0 if not present

    // Convert back to float
    $originalValue = $integerValue / pow(10, $decimalPlaces);

    return response()->json([
        'hash' => $hash,
        'value' => $originalValue
    ]);
});



Route::get('/salary/{emp_id}', function ($emp_id) {
    $empSalary = EmpSalary::findOrFail($emp_id);
    // Return the salary attribute
    return response()->json([
        'emp_id' => $empSalary->emp_id,
        'salary' => $empSalary->salary, // This will automatically call the getSalaryAttribute method
        'effective_date' => $empSalary->effective_date,
        'remarks' => $empSalary->remarks,
    ]);
});

Route::get('/file/{id}', function ($id) {
    $file = HelpDesks::findOrFail($id);

    return Response::make($file->file_path, 200, [
        'Content-Type' => $file->mime_type,
        'Content-Disposition' => (strpos($file->mime_type, 'image') === false ? 'attachment' : 'inline') . '; filename="' . $file->file_name . '"',
    ]);
})->name('file.show');

Route::get('/taskfile/{id}', function ($id) {
    $file = Task::findOrFail($id);

    return Response::make($file->file_path, 200, [
        'Content-Type' => $file->mime_type,
        'Content-Disposition' => (strpos($file->mime_type, 'image') === false ? 'attachment' : 'inline') . '; filename="' . $file->file_name . '"',
    ]);
})->name('files.showTask');


Route::get('/clear', function () {
    // Clear the contents of all log files
    $logFiles = File::glob(storage_path('logs/*.log'));
    foreach ($logFiles as $file) {
        File::put($file, ''); // This will empty the file without deleting it
    }
    // Perform other Artisan commands
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize');
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('auth:clear-resets');
    Artisan::call('config:cache');
    return 'Log contents cleared, and caches have been cleared and optimized!';
});

Route::get('/test-odbc', function () {
    try {
        // Hard-coded DSN, username, and password
        $dsn = 'Driver={SQL Server};Server=122.175.44.131,1433;Database=eSSL;';
        $username = 'essl'; // Replace with your actual username
        $password = 'essl'; // Replace with your actual password

        // Create a new PDO instance
        $dbh = new PDO("odbc:{$dsn}", $username, $password);

        // Optionally, you can perform a query to further test the connection
        // $result = $dbh->query("SELECT TOP 1 * FROM YourTableName")->fetchAll(PDO::FETCH_ASSOC);

        return "Connection successful!";
    } catch (\PDOException $e) {
        return "Connection failed: " . $e->getMessage();
    }
});


Route::get('/test-odbc-env', function () {
    try {
        // Fetch details from .env file
        $dsn = env('DB_ODBC_DSN');
        $username = env('DB_ODBC_USERNAME');
        $password = env('DB_ODBC_PASSWORD');

        // Create a new PDO instance
        $dbh = new PDO("odbc:{$dsn}", $username, $password);

        // Optionally, you can perform a query to further test the connection
        // $result = $dbh->query("SELECT TOP 1 * FROM YourTableName")->fetchAll(PDO::FETCH_ASSOC);

        return "Connection successful!";
    } catch (\PDOException $e) {
        return "Connection failed: " . $e->getMessage();
    }
});




Route::get('/test-odbc-dir', function () {
    try {
        // Hard-coded ODBC DSN, username, and password
        $dsn = 'Driver={SQL Server};Server=122.175.44.131,1433;Database=eSSL;';
        $username = 'essl'; // Replace with your actual username
        $password = 'essl'; // Replace with your actual password

        // Create a new PDO instance
        $dbh = new PDO("odbc:{$dsn}", $username, $password);

        // Define your table name and user ID
        $tableName = 'DeviceLogs_8_2024'; // Replace with your actual table name
        $normalizedUserId = 'XSS0488'; // Replace with your actual user ID
        $today = now()->toDateString(); // Get today's date in 'Y-m-d' format

        // Fetch data using raw PDO query
        $stmt = $dbh->prepare("SELECT UserId, logDate, Direction FROM {$tableName} WHERE UserId = ? AND CAST(logDate AS DATE) = ? ORDER BY logDate");
        $stmt->execute([$normalizedUserId, $today]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output the data for debugging
        dd($data);

        return "Data fetched successfully!";
    } catch (\PDOException $e) {
        return "Error: " . $e->getMessage();
    }
});

Route::get('/down', function () {
    Artisan::call('down');
    return 'Application is now in maintenance mode!';
});


Route::get('/up', function () {
    Artisan::call('up');
    return 'Application is now live!';
});
Route::get('password/reset/{token}', PasswordResetComponent::class)->name('password.reset');

use Illuminate\Support\Facades\Crypt;

Route::get('/encode-decode/{value}', function ($value) {
    try {
        // Attempt to decrypt the value
        $decrypted = Crypt::decryptString($value);
        return response()->json(['action' => 'decrypted', 'value' => $decrypted]);
    } catch (\Exception $e) {
        // If decryption fails, encrypt the value
        $encrypted = Crypt::encryptString($value);
        return response()->json(['action' => 'encrypted', 'value' => $encrypted]);
    }
});

use Illuminate\Support\Facades\Hash;

Route::get('/hash-verify/{value}', function ($value) {
    // Attempt to verify the value against the hashed version
    // Here, we'll assume that a certain value (e.g., 'originalValue') needs to be verified
    $originalValue = 'originalValue'; // Replace this with the actual value you want to verify against

    if (Hash::check($originalValue, $value)) {
        return response()->json(['action' => 'verified', 'value' => $originalValue]);
    } else {
        // If not verified, hash the original value
        $hashed = Hash::make($originalValue);
        return response()->json(['action' => 'hashed', 'value' => $hashed]);
    }
});

Route::get('tester/{name}', function ($name) {
    return "Hello, {$name}!";
});

Route::get('/test-emp-salary/{id}', function ($id) {
    $empSalary = EmpSalary::findOrFail($id);

    return [
        'Decoded Salary' => $empSalary->getDecodedSalary(),
        'Basic' => $empSalary->basic,
        'HRA' => $empSalary->hra,
        'Medical' => $empSalary->medical,
        'Conveyance' => $empSalary->conveyance,
        'Special' => $empSalary->special,
        'PF' => $empSalary->pf,
        'ESI' => $empSalary->calculateEsi(),
        'Professional Tax' => $empSalary->calculateProfTax(),
        'Total Deductions' => $empSalary->calculateTotalDeductions(),
        'Total Allowances' => $empSalary->calculateTotalAllowance(),
    ];
});


Route::get('/salary/{emp_id}', function ($emp_id) {
    // Fetch the EmpSalaryRevision record by emp_id if it's not the primary key
    $salaryRevision = EmpSalaryRevision::where('emp_id', $emp_id)->firstOrFail();

    // Return the record as a JSON response
    return response()->json([
        'emp_id' => $salaryRevision->emp_id,
        'current_ctc' => $salaryRevision->current_ctc,  // This will return the decoded value
        'revised_ctc' => $salaryRevision->revised_ctc,  // This will return the decoded value
        'revision_date' => $salaryRevision->revision_date,
        'revision_type' => $salaryRevision->revision_type,
        'reason' => $salaryRevision->reason,
        'status' => $salaryRevision->status,
    ]);
});

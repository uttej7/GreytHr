<?php

namespace App\Livewire;

use App\Models\IncidentRequest;
use Livewire\Component;
use App\Models\EmployeeDetails;
use App\Models\PeopleList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\HelpDesks;
use App\Mail\HelpDeskotification;
use App\Models\Request;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use App\Helpers\FlashMessageHelper;
use App\Mail\IncidentRequestMail;
use App\Mail\ServiceRequestMail;
use App\Models\IT;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class IncidentRequests extends Component
{

    public $ServiceRequestaceessDialog = false;
    public $incidentRequestaceessDialog = false;
    use WithFileUploads;
    public $isOpen = false;
    public $short_description;
    public $rejection_reason;
    public $full_name;
    public $selectedCategory = [];

    public $activeCategory = '';
    public $pendingCategory = '';
    public $closedCategory = '';
    public $searchTerm = '';
    public $showViewFileDialog = false;
    public $showModal = false;
    public $search = '';
    public $isRotated = false;
    public $requestId;

    public $requestCategories = '';
    public $selectedPerson = null;
    public $peoples;
    public $filteredPeoples;
    public $showserviceViewFileDialog = false;
    public $peopleFound = true;
    public $category;
    public $ccToArray = [];
    public $request;
    public $subject;
    public $description;
    public $file_path;
    public $cc_to;
    public $priority;
    public $servicerecords;
    public $records;
    public $image;
    public $mobile;
    public $selectedPeopleNames = [];
    public $employeeDetails;
    public $showDialog = false;
    public $fileContent, $file_name, $mime_type;

    public $showDialogFinance = false;
    public $record;
    public $peopleData = '';
    public $filterData;
    public $activeTab = 'active';
    public $selectedPeople = [];
    public $activeSearch = [];
    public $pendingSearch = '';
    public $closedSearch = '';



    protected $rules = [

        'short_description' => 'required|string|max:255',

        'description' => 'required|string',

        'priority' => 'required|in:High,Medium,Low',


        'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960',

    ];
    protected $messages = [
        'priority.required' => 'Priority is required.',
        'description.required' => ' Description is required.',
        'short_description.required' => 'Short description required',
    ];

    public function validateField($field)
    {
        if (in_array($field, ['description', 'category', 'priority', 'short_description'])) {
            $this->validateOnly($field, $this->rules);
        }
    }
    public function open()
    {
        $this->showDialog = true;
    }
    public function mount()
    {
        // Fetch unique requests with their categories
        $requestCategories = Request::select('Request', 'category')->get();

        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $companyId = auth()->guard('emp')->user()->company_id;
        $this->peoples = EmployeeDetails::whereJsonContains('company_id', $companyId)->whereNotIn('employee_status', ['rejected', 'terminated'])->get();

        $this->peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;
        $this->selectedPeople = [];
        $this->selectedPeopleNames = [];
        $employeeName = auth()->user()->first_name . ' #(' . $employeeId . ')';
        $this->records = IncidentRequest::with('emp')
            ->whereHas('emp', function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy('created_at', 'desc')


            ->get();
        $this->servicerecords = ServiceRequest::with('emp')
            ->whereHas('emp', function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy('created_at', 'desc')


            ->get();


        if ($this->employeeDetails) {
            // Combine first and last names
            $this->full_name = $this->employeeDetails->first_name . ' ' . $this->employeeDetails->last_name;
        }

        $this->filterData = [];
        $this->peoples = EmployeeDetails::whereJsonContains('company_id', $companyId)->whereNotIn('employee_status', ['rejected', 'terminated'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
        $this->loadHelpDeskData();
    }



    public function cancelIncidentRequest()
    {

        $this->incidentRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->resetIncidentFields();
    }
    public function cancelServiceRequest()
    {

        $this->ServiceRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->resetIncidentFields();
    }


    public function openFinance()
    {
        $this->showDialogFinance = true;
    }
    public function updatedCategory()
    {
        $this->filter();
        logger($this->category); // Log selected category
        logger($this->records); // Log filtered records
    }

    public function loadHelpDeskData()
    {
        $this->activeCategory = '';
        $this->pendingCategory = '';
        $this->closedCategory = '';
        $this->activeSearch = '';
        $this->pendingSearch = '';
        $this->closedSearch = '';
        if ($this->activeTab === 'active') {

            $this->searchActiveHelpDesk();
        } elseif ($this->activeTab === 'pending') {

            $this->searchPendingHelpDesk();
        } elseif ($this->activeTab === 'closed') {
            $this->searchClosedHelpDesk();
        }
    }

    public function updatedActiveTab()
    {
        $this->loadHelpDeskData(); // Reload data when the tab is updated
    }



    public function searchHelpDesk($status, $searchTerm, $selectedCategory, $requestId = null, $priority = null)
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        // Base query for employee-specific requests
        // IncidentRequest query

        $this->records = IncidentRequest::where(function ($query) use ($employeeId) {
            $query->where('emp_id', $employeeId);
        });

        // ServiceRequest query


        // Combine both queries using union
        $query = $this->records
            ->orderBy('created_at', 'desc');

        // Apply status filtering for 10 and 8
        if (is_array($status)) {
            $query->whereIn('status_code', $status); // Example: 8 and 10 status codes
        } else {
            $query->where('status_code', $status);
        }

        // Apply active category filter if selected
        if (!empty($selectedCategory)) {
            $query->where(function ($query) use ($selectedCategory) {
                $query->where('category', $selectedCategory);
            });
        }

        // Apply search term filtering (if provided)
        if (!empty($searchTerm)) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('emp_id', 'like', '%' . $searchTerm . '%') // Employee ID
                      ->orWhere('snow_id', 'like', '%' . $searchTerm . '%') // Request ID
                      ->orWhere('priority', 'like', '%' . $searchTerm . '%') // Priority
                      ->orWhereHas('emp', function ($query) use ($searchTerm) { // Related employee name
                          $query->where('first_name', 'like', '%' . $searchTerm . '%')
                                ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
                      });
            });
        }
        // Fetch and assign the results
        $this->filterData = $query->orderBy('created_at', 'desc')->get();
        $this->peopleFound = count($this->filterData) > 0;
    }




    public function searchActiveHelpDesk()
    {

        $this->searchHelpDesk(
            [8, 10],
            $this->activeSearch,
            $this->activeCategory,      // Request ID
        );
    }

    public function searchPendingHelpDesk()
    {
        $this->searchHelpDesk(
            5,
            $this->pendingSearch,
            $this->pendingCategory,          // Request ID
        );
    }

    public function searchClosedHelpDesk()
    {
        $this->searchHelpDesk(
            [11, 3],
            $this->closedSearch,
            $this->closedCategory,       // Request ID
        );
    }

    public function showRejectionReason($id)
    {

        $record = IncidentRequest::findOrFail($id);

        if ($record && $record->status_code === 3) {
            $this->rejection_reason = $record->rejection_reason;

            $this->isOpen = true;
        } else {
            $this->dispatchBrowserEvent('notification', ['message' => 'Reason not available.']);
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->rejection_reason = null;
    }
    public function close()
    {
        $this->showDialog = false;
        $this->isRotated = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'description', 'cc_to', 'category', 'file_path', 'priority', 'image', 'selectedPeopleNames', 'selectedPeople']);
    }

    public function closeFinance()
    {
        $this->showDialogFinance = false;
    }



    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    protected function addErrorMessages($messages)
    {
        foreach ($messages as $field => $message) {
            $this->addError($field, $message[0]);
        }
    }

    public function openForDesks($taskId)
    {
        $task = IncidentRequest::find($taskId);

        if ($task) {
            $task->update(['status_code' => 12]);
        }
        return redirect()->to('/HelpDesk');
    }

    public function closeForDesks($taskId)
    {
        $task = IncidentRequest::find($taskId);

        if ($task) {
            $task->update(['status_code' => 10]);
        }
        return redirect()->to('/HelpDesk');
    }
    public function setActiveTab($tab)
    {

        $this->activeTab = $tab;
    }
    public function Catalog()
    {
        return redirect()->to('/catalog');
    }

    public function selectPerson($personId)
    {
        try {
            if (count($this->selectedPeopleNames) >= 5 && !in_array($personId, $this->selectedPeople)) {

                return;
            }


            $selectedPerson = $this->peoples->where('emp_id', $personId)->first();

            if ($selectedPerson) {
                if (in_array($personId, $this->selectedPeople)) {
                    $this->selectedPeopleNames[] =  ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name)) . ' #(' . $selectedPerson->emp_id . ')';
                } else {
                    $this->selectedPeopleNames = array_diff($this->selectedPeopleNames, [ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name)) . ' #(' . $selectedPerson->emp_id . ')']);
                }
                $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
            }
        } catch (\Exception $e) {
            // Log the exception message or handle it as needed
            Log::error('Error selecting person: ' . $e->getMessage());
            // Optionally, you can set an error message to display to the user
            $this->dispatchBrowserEvent('error', ['message' => 'An error occurred while selecting the person. Please try again.']);
        }
    }




    public function showFile($id)
    {
        $record = IncidentRequest::findOrFail($id);

        if ($record && $record->file_path !== 'N/A') {
            $mimeType = 'image/jpeg'; // Adjust as necessary

            return response($record->file_path, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="image.jpg"'); // Adjust filename and extension as needed
        }

        return abort(404, 'File not found');
    }

    public $recordId;
    public $viewrecord;

    public function showViewFile($id)
    {
        $this->records = IncidentRequest::findOrFail($id);

        if ($this->records && $this->records->file_path !== 'null') {
            $this->file_path = $this->records->file_path;
            $this->showViewFileDialog = true;
        } else {
            // Handle case where file is not found or is null
            $this->dispatch('file-not-found', ['message' => 'File not found.']);
        }
    }
    public function showserviceViewFile($id)
    {
        $this->servicerecords = ServiceRequest::findOrFail($id);

        if ($this->servicerecords &&   $this->servicerecords->file_path !== 'null') {
            $this->file_path = $this->records->file_path;
            $this->showserviceViewFileDialog = true;
        } else {
            // Handle case where file is not found or is null
            $this->dispatch('file-not-found', ['message' => 'File not found.']);
        }
    }
    public $showImageDialog = false;
    public $imageUrl;
    public function downloadImage()
    {
        if ($this->imageUrl) {
            // Decode the Base64 data if necessary
            $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->imageUrl));

            // Determine MIME type and file extension
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_buffer($finfo, $fileData);
            finfo_close($finfo);

            $extension = '';
            switch ($mimeType) {
                case 'image/jpeg':
                    $extension = 'jpg';
                    break;
                case 'image/png':
                    $extension = 'png';
                    break;
                case 'image/gif':
                    $extension = 'gif';
                    break;
                default:
                    return abort(415, 'Unsupported Media Type');
            }

            // Prepare file name and response
            $fileName = 'image-' . time() . '.' . $extension;
            return response()->streamDownload(
                function () use ($fileData) {
                    echo $fileData;
                },
                $fileName,
                [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                ]
            );
        }
        return abort(404, 'Image not found');
    }
    public function getImageUrlAttribute()
    {
        if ($this->file_path && $this->mime_type) {
            return 'data:' . $this->mime_type . ';base64,' . base64_encode($this->file_path);
        }
        return null;
    }

    public function showImage($url)
    {
        $this->imageUrl = $url;

        $this->showImageDialog = true;
    }

    public function closeImageDialog()
    {
        $this->showImageDialog = false;
    }

    public function show()
    {
        $this->showDialog = true;
    }

    public function closeViewFile()
    {
        $this->showViewFileDialog = false;
    }
    public function resetIncidentFields()
    {

        $this->short_description = null;
        $this->priority = null;
        $this->description = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }
    public function ServiceRequest()
    {



        $this->ServiceRequestaceessDialog = true;
        $this->showModal = true;
        $this->category = 'Service Request';
    }

    public function incidentRequest()
    {

        $this->incidentRequestaceessDialog = true;
        $this->showModal = true;
        $this->category = 'Incident Request';
    }

    public function createIncidentRequest()
    {
        $this->validate([
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
            'file_path' => 'nullable|file|max:10240',  // Validate that file is an actual file and its size is within limit (e.g., 10MB)
        ]);

        // Get the logged-in employee ID
        $employeeId = auth()->guard('emp')->user()->emp_id;
        Log::debug('Create Incident Request called by employee ID: ' . $employeeId);

        // Handle file upload if there is a file
        $fileContent = null;
        $mimeType = null;
        $fileName = null;
        // Store the file as binary data
        if ($this->file_path) {

            $fileContent = file_get_contents($this->file_path->getRealPath());
            if ($fileContent === false) {
                Log::error('Failed to read the uploaded file.', [
                    'file_path' => $this->file_path->getRealPath(),
                ]);
                FlashMessageHelper::flashError('Failed to read the uploaded file.');
                return;
            }

            // Check if the file content is too large
            if (strlen($fileContent) > 16777215) { // 16MB for MEDIUMBLOB
                FlashMessageHelper::flashWarning('File size exceeds the allowed limit.');
                return;
            }


            $mimeType = $this->file_path->getMimeType();
            $fileName = $this->file_path->getClientOriginalName();
        }

        // Create the new IncidentRequest
        try {
            $incidentRequest = IncidentRequest::create([
                'emp_id' => $employeeId,
                'category' => $this->category,
                'short_description' => $this->short_description,
                'description' => $this->description,
                'priority' => $this->priority,
                'assigned_dept' => 'IT',
                'file_path' => $fileContent,
                'file_name' => $fileName,
                'mime_type' => $mimeType,
                'status_code' => 10, // Set default status
            ]);
            $incidentRequest->refresh();
            $this->resetIncidentFields();
            $this->showModal = false;
            FlashMessageHelper::flashSuccess('Incident request created successfully.');
            // Fetch all admin emails from the IT table
            $adminEmails = IT::where('role', 'admin')->pluck('email')->toArray();
            // Send Email Notification
            foreach ($adminEmails as $email) {
                // Get the admin's emp_id from the IT table
                $admin = IT::where('email', $email)->first();

                if ($admin) {
                    // Retrieve the corresponding first name and last name from EmployeeDetails
                    $employeeDetails = EmployeeDetails::where('emp_id', $admin->emp_id)->first();

                    $firstName = $employeeDetails ? $employeeDetails->first_name : 'N/A';
                    $lastName = $employeeDetails ? $employeeDetails->last_name : 'N/A';

                    // Send email
                    Mail::to($email)
                        ->send(new IncidentRequestMail(
                            $incidentRequest,
                            $firstName,
                            $lastName
                        ));
                } else {
                    Log::warning("No admin found in IT table for email: $email");
                }
            }
            return redirect()->to('/incident');
        } catch (\Exception $e) {
            Log::error('Error creating Incident Request: ' . $e->getMessage());
            FlashMessageHelper::flashError('Error creating Incident Request.');
            return;
        }
    }

    public function createServiceRequest()
    {
        $this->validate([
            'short_description' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
            'file_path' => 'nullable|file|max:10240',  // Validate that file is an actual file and its size is within limit (e.g., 10MB)
        ]);

        // Get the logged-in employee ID
        $employeeId = auth()->guard('emp')->user()->emp_id;

        // Handle file upload if there is a file
        $fileContent = null;
        $mimeType = null;
        $fileName = null;
        // Store the file as binary data
        if ($this->file_path) {

            $fileContent = file_get_contents($this->file_path->getRealPath());
            if ($fileContent === false) {
                Log::error('Failed to read the uploaded file.', [
                    'file_path' => $this->file_path->getRealPath(),
                ]);
                FlashMessageHelper::flashError('Failed to read the uploaded file.');
                return;
            }

            // Check if the file content is too large
            if (strlen($fileContent) > 16777215) { // 16MB for MEDIUMBLOB
                FlashMessageHelper::flashWarning('File size exceeds the allowed limit.');
                return;
            }


            $mimeType = $this->file_path->getMimeType();
            $fileName = $this->file_path->getClientOriginalName();
        }


        // Create the new IncidentRequest
        try {
            $serviceRequest = IncidentRequest::create([
                'emp_id' => $employeeId,
                'category' => $this->category,
                'short_description' => $this->short_description,
                'description' => $this->description,
                'priority' => $this->priority,
                'assigned_dept' => 'IT',
                'file_path' => $fileContent,
                'file_name' => $fileName,
                'mime_type' => $mimeType,
                'status_code' => 10, // Set default status
            ]);
            $serviceRequest->refresh();
            $adminEmails = IT::where('role', 'admin')->pluck('email')->toArray();
            // Send Email Notification
            foreach ($adminEmails as $email) {
                // Get the admin's emp_id from the IT table
                $admin = IT::where('email', $email)->first();

                if ($admin) {
                    // Retrieve the corresponding first name and last name from EmployeeDetails
                    $employeeDetails = EmployeeDetails::where('emp_id', $admin->emp_id)->first();

                    $firstName = $employeeDetails ? $employeeDetails->first_name : 'N/A';
                    $lastName = $employeeDetails ? $employeeDetails->last_name : 'N/A';

                    // Send email
                    Mail::to($email)
                        ->send(new ServiceRequestMail(
                            $serviceRequest,
                            $firstName,
                            $lastName
                        ));
                } else {
                    Log::warning("No admin found in IT table for email: $email");
                }
            }
            $this->resetIncidentFields();
            $this->showModal = false;
            FlashMessageHelper::flashSuccess('Service request created successfully.');

            return redirect()->to('/incident');
        } catch (\Exception $e) {
            Log::error('Error creating Service Request: ' . $e->getMessage());
            FlashMessageHelper::flashError('Error creating Service Request.');
            return;
        }
    }
    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = auth()->guard('emp')->user()->companyc_id;
        $this->peoples = EmployeeDetails::where('company_id', $companyId)->whereNotIn('employee_status', ['rejected', 'terminated'])->get();

        $peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;

        $this->peoples = EmployeeDetails::where('company_id', $companyId)->whereNotIn('employee_status', ['rejected', 'terminated'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $searchData = $this->filterData ?: $this->records;
        $searchData = $this->filterData ?: $this->servicerecords;
        $employeeName = auth()->user()->first_name . ' #(' . $employeeId . ')';

        $this->records = IncidentRequest::with('emp')
            ->whereHas('emp', function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();



        $query = IncidentRequest::with('emp')
            ->where('emp_id', $employeeId);


        // Apply filtering based on the selected category

        $this->peoples = EmployeeDetails::whereJsonContains('company_id', $companyId)->get();
        // Initialize peopleData properly
        $peopleData = $this->filteredPeoples ?: $this->peoples;

        // Ensure peopleData is a collection, not null
        $peopleData = $peopleData ?: collect();

        return view('livewire.incident-requests', [
            'records' => $this->records,
            'searchData' => $this->filterData ?: $this->records,
            'requestCategories' => $this->requestCategories,
            'peopleData' => $this->peopleData,

        ]);
    }
}

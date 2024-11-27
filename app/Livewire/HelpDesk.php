<?php
// File Name                       : HelpDesk.php
// Description                     : This file contains the information about various IT requests related to the catalog.
//                                   It includes functionality for adding members to distribution lists and mailboxes, requesting IT accessories,
//                                   new ID cards, MMS accounts, new distribution lists, laptops, new mailboxes, and DevOps access.
// Creator                         : Asapu Sri Kumar Mmanikanta,Ashannagari Archana
// Email                           : archanaashannagari@gmail.com
// Organization                    : PayG.
// Date                            : 2023-09-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : HelpDesk,EmployeeDetails
namespace App\Livewire;

use App\Models\EmployeeDetails;
use App\Models\PeopleList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use App\Models\HelpDesks;
use App\Mail\HelpDeskotification;
use App\Models\Request;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use App\Helpers\FlashMessageHelper; 
use Illuminate\Support\Facades\Response;

class HelpDesk extends Component
{
    use WithFileUploads;
    public $isOpen = false;
    public $rejection_reason;
    public $selectedCategory = [];
    public $activeCategory = null; // Category for Active tab
public $pendingCategory = null; // Category for Pending tab
public $closedCategory = null; // Category for Closed tab

  
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
    public $peopleFound = true;
    public $category;
    public $ccToArray = [];
    public $request;
    public $subject;
    public $description;
    public $file_path;
    public $cc_to;
    public $priority;
    public $records;
    public $image;
    public $mobile;
    public $selectedPeopleNames = [];
    public $employeeDetails;
    public $showDialog = false;
    public $fileContent,$file_name,$mime_type;

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
        'category' => 'required|string',
        'subject' => 'required|string',
        'description' => 'required|string',
        'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,csv,xls,xlsx|max:40960', // Adjust max size as needed
        'priority' => 'required|in:High,Medium,Low',

    ];

    protected $messages = [
        'category.required' => 'Category is required.',
        'subject.required' => 'Subject is required.',
        'description.required' => 'Description is required.',
        'priority.required' => 'Priority is required.',
        'priority.in' => 'Priority must be one of: High, Medium, Low.',
        'image.image' => 'File must be an image.',
        'image.max' => 'Image size must not exceed 2MB.',
        'file_path.mimes' => 'File must be a document of type: pdf, xls, xlsx, doc, docx, jpg, jpeg, png.',
        'file_path.max' => 'Document size must not exceed 40 MB.',
    ];

    public function validateField($field)
    {
        if (in_array($field, ['description', 'subject','category','priority',])) {
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
        $this->records = HelpDesks::with('emp')
            ->where(function ($query) use ($employeeId, $employeeName) {
                $query->where('emp_id', $employeeId)
                    ->orWhere('cc_to', 'LIKE', "%$employeeName%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
         
         
         
     
        $this->peoples = EmployeeDetails::whereJsonContains('company_id', $companyId)->whereNotIn('employee_status', ['rejected', 'terminated'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
   $this->loadHelpDeskData();
        // Group categories by their request
        if ($requestCategories->isNotEmpty()) {
            // Group categories by their request
            $this->requestCategories = $requestCategories->groupBy('Request')->map(function ($group) {
                return $group->unique('category'); // Ensure categories are unique
            });
        } else {
            // Handle the case where there are no requests
            $this->requestCategories = collect(); // Initialize as an empty collection
        }
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
    
  
    public function searchHelpDesk($status_code, $searchTerm,$selectedCategory)
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
    
        // Start the base query based on status and employee ID or cc_to
        $query = HelpDesks::where(function ($query) use ($employeeId) {
            $query->where('emp_id', $employeeId)->orWhere('cc_to', 'like', "%$employeeId%");
        });
        if (is_array($status_code)) {
            $query->whereIn('status_code', $status_code);  // Multiple statuses (array)
        } else {
            $query->where('status_code', $status_code);    // Single status (string)
        }// Apply status filter dynamically
    
        // If a category is selected, apply category filtering
        if ($selectedCategory) {
            logger('Selected Category: ' . $selectedCategory);
            $query->whereIn('category', Request::where('Request', $selectedCategory)->pluck('category'));
        }
    
        // If there's a search term, apply search filtering
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('emp_id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('category', 'like', '%' . $searchTerm . '%')
                    ->orWhere('subject', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('emp', function ($query) use ($searchTerm) {
                        $query->where('first_name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }
    
        // Get results
        $results = $query->orderBy('created_at', 'desc')->get();
     
        $this->filterData = $results;
        $this->peopleFound = count($this->filterData) > 0;
    }
    
    
    public function searchActiveHelpDesk()
    {
        $this->searchHelpDesk([8,10], $this->activeSearch,$this->activeCategory);
    }
    
    public function searchPendingHelpDesk()
    {
        $this->searchHelpDesk(6, $this->pendingSearch,$this->pendingCategory);
    }
    
    public function searchClosedHelpDesk()
    {
        $this->searchHelpDesk([12,4], $this->closedSearch,$this->closedCategory);
    }
    
    public function showRejectionReason($id)
    {
     
        $record = HelpDesks::findOrFail($id);
    
        if ($record && $record->status === 'Reject') {
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
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Completed']);
        }
        return redirect()->to('/HelpDesk');
    }

    public function closeForDesks($taskId)
    {
        $task = HelpDesks::find($taskId);

        if ($task) {
            $task->update(['status' => 'Open']);
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
        $record = HelpDesks::findOrFail($id);

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
        $this->records = HelpDesks::findOrFail($id);

        if ($this->records && $this->records->file_path !== 'null') {
            $this->file_path = $this->records->file_path;
            $this->showViewFileDialog = true;
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



    public function submitHR()
    {
        try {
            $this->validate($this->rules);
           
    
            // Validate the maximum followers selection
      
            $fileContent = null;
            $mime_type = null;
            $file_name = null;
    
            if ($this->file_path) {
                $fileContent = file_get_contents($this->file_path->getRealPath());
    
                if ($fileContent === false) {
                    Log::error('Failed to read the uploaded file.', [
                        'file_path' => $this->file_path->getRealPath(),
                    ]);
                    session()->flashError('error', 'Failed to read the uploaded file.');
                    return;
                }
    
                // Check if the file content is too large
                $maxFileSize = 16777215; // 16MB for MEDIUMBLOB
                if (strlen($fileContent) > $maxFileSize) {
                    FlashMessageHelper::flashWarning( 'File size exceeds the allowed limit.');
                    return;
                }
    
                $mime_type = $this->file_path->getMimeType();
                $file_name = $this->file_path->getClientOriginalName();
            }
    
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
          
            HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' => $fileContent, // Store the binary file data
                'file_name' => $file_name,
                'mime_type' => $mime_type,
                'cc_to' => $this->cc_to ?? '-',
                'priority' => $this->priority,
                'mail' => 'N/A',
                'mobile' => 'N/A',
                'distributor_name' => 'N/A',
               
           
            ]);
            
    
            FlashMessageHelper::flashSuccess( 'Request created successfully.');
            return redirect()->to('/HelpDesk');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null,
            ]);
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
        }
    }
    

    public function downloadFile($id)
    {
        // Fetch the HelpDesk record using the provided ID
        $helpDeskRecord = HelpDesks::findOrFail($id);

        // Check if the file_path has content
        if (!$helpDeskRecord->file_path) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Prepare the response for the file download
        $fileContent = $helpDeskRecord->file_path; // Retrieve binary content from the database
        $filename = 'document_' . $id; // You may want to generate a more meaningful filename

        return response()->stream(function () use ($fileContent) {
            echo $fileContent; // Output the file content
        }, 200, [
            'Content-Type' => 'application/octet-stream', // Change based on the actual file type
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    protected function resetInputFields()
    {
        $this->category = '';
        $this->subject = '';
        $this->description = '';
        $this->file_path = '';
        $this->cc_to = '';
        $this->priority = '';
        $this->image = '';
    }

    public function closePeoples()
    {
        $this->isRotated = false;
    }

    public $warningShown = false;  // Flag to track if the warning has been shown

    public function updatedSelectedPeople()
    {
        // Check if the number of selected people exceeds 5
        if (count($this->selectedPeople) > 5) {
            if (!$this->warningShown) {
                // Flash a warning message only once
                FlashMessageHelper::flashWarning('You can only select up to 5 people.');
                
                // Set the flag to true, so the warning won't be shown again in this iteration
                $this->warningShown = true;
            }
            
            // Optionally, reset the selected people array or remove the last selection
            $this->selectedPeople = array_slice($this->selectedPeople, 0, 5);
        } else {
            // If the number of selected people is valid, update the cc_to field
            $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
            
            // Reset the warning flag when the count is valid
            $this->warningShown = false;
        }
    }
    


    public function toggleRotation()
    {

        $this->isRotated = true;


        $this->selectedPeopleNames = [];

        $this->cc_to = '';
    }
    public function toggle()
    {

        $this->isRotated = true;


        $this->selectedPeopleNames = [];

        $this->cc_to = '';
    }

    public function filter()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = Auth::user()->company_id;
    
        // Fetch people data based on company ID and search term
        $this->peopleData = EmployeeDetails::whereJsonContains('company_id', $companyId)->whereNotIn('employee_status', ['rejected', 'terminated'])
            ->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('emp_id', 'like', '%' . $this->searchTerm . '%');
            })
            ->get();

            

        // Apply isChecked only for selected people, uncheck the rest
        $this->peoples->transform(function ($person) {
            // Ensure the comparison is between the same types (convert emp_id to string)
            $person->isChecked = in_array((string)$person->emp_id, $this->selectedPeople);
            return $person;
        });
            
        // Reset filteredPeoples if search term is present
        $this->filteredPeoples = $this->searchTerm ? $this->peopleData : null;
    
        // Filter records based on category and search term
        $this->records = HelpDesks::with('emp')
            ->whereHas('emp', function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    
    


    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = auth()->guard('emp')->user()->company_id;
        $this->peoples = EmployeeDetails::where('company_id', $companyId)->whereNotIn('employee_status', ['rejected', 'terminated'])->get();

        $peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;

        $this->peoples = EmployeeDetails::where('company_id', $companyId) ->whereNotIn('employee_status', ['rejected', 'terminated'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $searchData = $this->filterData ?: $this->records;
        $employeeName = auth()->user()->first_name . ' #(' . $employeeId . ')';

        $this->records = HelpDesks::with('emp')
            ->where(function ($query) use ($employeeId, $employeeName) {
                $query->where('emp_id', $employeeId)
                    ->orWhere('cc_to', 'LIKE', "%$employeeName%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Apply filtering based on the selected category
        if ($this->selectedCategory) {
            $this->records->where('request', function ($q) {
                $q->where('category', $this->selectedCategory);
            });
        }



        $query = HelpDesks::with('emp')
            ->where('emp_id', $employeeId);

        // Apply filtering based on the selected category

        $this->peoples = EmployeeDetails::whereJsonContains('company_id', $companyId)->get();
        // Initialize peopleData properly
        $peopleData = $this->filteredPeoples ?: $this->peoples;

        // Ensure peopleData is a collection, not null
        $peopleData = $peopleData ?: collect();

        return view('livewire.help-desk', [
            'records' => $this->records,
            'searchData' => $this->filterData ?: $this->records,
            'requestCategories' => $this->requestCategories,
            'peopleData' => $this->peopleData,
            
        ]);
    }
}

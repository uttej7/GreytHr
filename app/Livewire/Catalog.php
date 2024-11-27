<?php
// File Name                       : Catalog.php
// Description                     : This file contains the information about various IT requests related to the catalog.
//                                   It includes functionality for adding members to distribution lists and mailboxes, requesting IT accessories,
//                                   new ID cards, MMS accounts, new distribution lists, laptops, new mailboxes, and DevOps access.
// Creator                         : Ashannagari Archana
// Email                           : archanaashannagari@gmail.com
// Organization                    : PayG.
// Date                            : 2023-09-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : HelpDesk,EmployeeDetails

namespace App\Livewire;

use Livewire\Component;
use App\Models\EmployeeDetails;
use App\Models\PeopleList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\HelpDesks;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use App\Helpers\FlashMessageHelper;
use Illuminate\Support\Facades\Mail;
use App\Mail\HelpDeskNotification;
use App\Mail\IncidentRequestMail;
use App\Mail\ServiceRequestMail;
use App\Models\IncidentRequest;
use App\Models\IT;
use App\Models\ServiceRequest;

class Catalog extends Component
{

    use WithFileUploads;
    public $searchTerm = '';
    public $superAdmins;
    public $email;
    public $ServiceRequestaceessDialog = false;

    public $recipient;
    public $mobile;
    public $showModal = true;
    public $selectedDeptId;

    public $ItRequestaceessDialog = false;
    public $MailRequestaceessDialog = false;
    public $closeMailRequestaccess = false;
    public $openMailRequestaccess = false;
    public $closeItRequestaccess = false;
    public $openItRequestaccess = false;
    public $closeDevopsRequestaccess = false;
    public $openDevopsRequestaccess = false;

    public $isNames = false;
    public $record;
    public $peopleData = '';
    public $mail;
    public $subject;
    public $distributor_name;
    public $description;
    public $selected_equipment;
    public $NewMailRequestaceessDialog = false;
    public $priority = 'Low';
    public $activeTab = 'active';
    public $image;
    public $employeeDetails;
    public $employees;

    public $selectedPerson = null;
    public $addselectedPerson = null;
    public $cc_to;
    public $peoples;
    public $category;
    public $requestId;
    public $emergency_contact = '';
    public $filteredPeoples;
    public $selectedPeopleNames = [];
    public $selectedPeople = [];
    public $addselectedPeople = [];
    public $records;
    public $peopleFound = true;
    public $attachment;

    public $file_path;
    public $DevopsRequestaceessDialog = false;

    public $closeMmsRequestaccess = false;
    public $openMmsRequestaccess = false;
    public $DistributionRequestaceessDialog = false;
    public $closeDistributionRequestaccess = false;
    public $openDistributionRequestaccess = false;
    public $closeAddRequestaccess = false;
    public $openAddRequestaccess = false;
    public $DesktopRequestaceessDialog = false;

    public $closeDesktopRequestaccess = false;
    public $openDesktopRequestaccess = false;
    public $IdRequestaceessDialog = false;
    public $MmsRequestaceessDialog = false;
    public $LapRequestaceessDialog = false;
    public    $InternetRequestaceessDialog = false;
      
    public $AddRequestaceessDialog = false;
    public $incidentRequestaceessDialog = false;
    public $justification;
    public $information;
    public $short_description;
    public $assigned_dept;
    public $file;
    public $issue;
    protected $rules = [
        'subject' => 'required|string|max:255',
        'short_description' => 'required|string|max:255',
        'mobile' => 'required|string|max:15',
        'description' => 'required|string',
        'mail' => 'required|email',
        'priority' => 'required|in:High,Medium,Low',
        'distributor_name' => 'required|string|max:15',
        'selected_equipment' => 'required',
        'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960',
        'issue' => 'required|string|max:255'
    ];


    protected $messages = [
        'distributor_name' => 'Distributor name is required',
        'selected_equipment' => 'Select Equipment is required ',
        'subject.required' => 'Subject  is required.',
        'mail.required' => ' Email  is required.',
        'priority.required' => 'Priority is required.',
        'priority.in' => 'Priority must be one of: High, Medium, Low.',
        'mail.email' => ' Email must be a valid email address.',
        'mobile.required' => ' Mobile number is required.',
        'mobile.max' => ' Mobile number must not exceed 15 characters.',
        'description.required' => ' Description is required.',
        'short_description.required' => 'Short description required',
    ];
    public $first_name;
    public $last_name;
    public $full_name;
    public function mount()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
        $companyId = auth()->guard('emp')->user()->company_id;
        $this->peoples = EmployeeDetails::whereJsonContains('company_id', $companyId)
            ->whereNotIn('employee_status', ['rejected', 'terminated'])
            ->get();
        $this->superAdmins = IT::where('role', 'super_admin')->get();
        if ($this->employeeDetails) {
            // Combine first and last names
            $this->full_name = $this->employeeDetails->first_name . ' ' . $this->employeeDetails->last_name;
            $this->mobile = $this->employeeDetails->mobile ?? '-';
            $this->mail = $this->employeeDetails->mail ?? '-';
            $this->selectedDeptId =  $this->employeeDetails->dept_id;
        }


        $this->peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;
        $this->selectedPeople = [];
        $this->addselectedPeople = [];
        $this->selectedPeopleNames = [];
        $employeeName = auth()->user()->first_name . ' #(' . $employeeId . ')';
        $this->records = HelpDesks::with('emp')
            ->where(function ($query) use ($employeeId, $employeeName) {
                $query->where('emp_id', $employeeId)
                    ->orWhere('cc_to', 'LIKE', "%$employeeName%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
        // dd( $this->records);
        $this->peoples = EmployeeDetails::whereJsonContains('company_id', $companyId)
            ->whereNotIn('employee_status', ['rejected', 'terminated'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();


        $this->selected_equipment = '';  // Initialize with a default value if needed
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function validateField($field)
    {
        if (in_array($field, ['mail', 'description', 'subject', 'category', 'selected_equipment', 'distributor_name', 'mobile'])) {
            $this->validateOnly($field, $this->rules);
        }
    }
    public function resetDialogs()
    {
        $this->AddRequestaceessDialog = false;
        // Close all dialogs
        $this->ItRequestaceessDialog = false;

        $this->LapRequestaceessDialog = false;
        $this->DistributionRequestaceessDialog = false;
        $this->MailRequestaceessDialog = false;
        $this->DevopsRequestaceessDialog = false;
        $this->IdRequestaceessDialog = false;
        $this->MmsRequestaceessDialog = false;
        $this->DesktopRequestaceessDialog = false;
        $this->NewMailRequestaceessDialog=false;

        $this->selectedPeople = [];
        $this->addselectedPeople = [];
        $this->isNames = false;
        $this->searchTerm = '';
        $this->filteredPeoples = '';

        $this->filter();
    }

    public function ItRequest()
    {
        $this->resetDialogs();
        $this->ItRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category', 'cc_to', 'priority']);
        $this->category = 'Request For IT';
    }


    public function AddRequest()
    {
        $this->resetDialogs();
        $this->AddRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category', 'priority']);
        $this->category = 'Distribution List Request';
    }

    public function LapRequest()
    {
        $this->resetDialogs();
        $this->LapRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category', 'priority']);
        $this->category = 'Laptop Request';
    }

    public function DistributionRequest()
    {
        $this->resetDialogs();
        $this->DistributionRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category', 'priority']);
        $this->category = 'New Distribution Request';
    }

    public function MailRequest()
    {
        $this->resetDialogs();
        $this->MailRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category', 'priority']);
        $this->category = 'New Mailbox Request';
    }

    public function DevopsRequest()
    {
        $this->resetDialogs();
        $this->DevopsRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category', 'priority']);
        $this->category = 'Devops Access Request';
    }

    public function IdRequest()
    {
        $this->resetDialogs();
        $this->IdRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category', 'priority']);
        $this->category = 'New ID Card';
    }

    public function MmsRequest()
    {
        $this->resetDialogs();
        $this->MmsRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category', 'priority']);
        $this->category = 'MMS Request';
    }

    public function DesktopRequest()
    {
        $this->resetDialogs();
        $this->DesktopRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category', 'priority']);
        $this->category = 'Desktop Request';
    }
    public function NewMailRequest()
    {
        $this->resetDialogs();
        $this->NewMailRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category', 'priority']);
        $this->category = 'New Mailbox Request';
    }
    public function IntenetRequest()
    {
        $this->resetDialogs();
        $this->InternetRequestaceessDialog = true;
        $this->showModal = true;
        $this->reset(['category', 'priority']);
        $this->category = 'Internet Access Request';
    }
    public function openItRequestaccess()
    {
        $this->ItRequestaceessDialog = true; // Open the Sec 80C modal
    }
    public function openAddRequestaccess()
    {
        $this->AddRequestaceessDialog = true; // Open the Sec 80C modal
    }
    public function openLapRequestaccess()
    {
        $this->LapRequestaceessDialog = true; // Open the Sec 80C modal
    }


    public function openDevopsRequestaccess()
    {
        $this->DevopsRequestaceessDialog = true; // Open the Sec 80C modal
    }
    public function openIdRequestaccess()
    {
        $this->IdRequestaceessDialog = true; // Open the Sec 80C modal
    }
    public function openMailRequestaccess()
    {
        $this->MailRequestaceessDialog = true; // Open the Sec 80C modal
    }
    public function openMMSRequestaccess()
    {
        $this->MmsRequestaceessDialog = true; // Open the Sec 80C modal
    }
    public function openDesktopRequestaccess()
    {
        $this->DesktopRequestaceessDialog = true;
    }
    public function openDistributionRequestaccess()
    {
        $this->DistributionRequestaceessDialog = true;
    }
    public function closeInternetRequestaccess()
    {
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment', 'cc_to', 'category', 'file_path', 'selectedPeople', 'selectedPeopleNames']);
        $this->InternetRequestaceessDialog = false;
    }
    public function closeItRequestaccess()
    {


        $this->ItRequestaceessDialog = false;

        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation();
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment', 'cc_to', 'category', 'file_path', 'selectedPeople', 'selectedPeopleNames']);
    }

    public function closeAddRequestaccess()
    {
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment', 'cc_to', 'category', 'file_path', 'selectedPeople', 'selectedPeopleNames']);
        $this->AddRequestaceessDialog = false;
    }

    public function closeDesktopRequestaccess()
    {
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment', 'cc_to', 'category', 'file_path', 'selectedPeople', 'selectedPeopleNames']);
        $this->DesktopRequestaceessDialog = false;
    }

    public function closeDistributionRequestaccess()
    {

        $this->DistributionRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment', 'cc_to', 'category', 'file_path', 'distributor_name', 'selectedPeople', 'selectedPeopleNames']);
    }

    public function closeDevopsRequestaccess()
    {

        $this->DevopsRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment', 'cc_to', 'category', 'file_path', 'distributor_name', 'selectedPeople', 'selectedPeopleNames']);
    }

    public function closeLapRequestaccess()
    {
        $this->reset();
        $this->LapRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment', 'cc_to', 'category', 'file_path', 'distributor_name', 'selectedPeople', 'selectedPeopleNames']);
    }
    public function redirectToHelpDesk()
    {
        return redirect('/HelpDesk');
    }

    public function closeIdRequestaccess()
    {

        $this->IdRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment', 'cc_to', 'category', 'file_path', 'distributor_name', 'selectedPeople', 'selectedPeopleNames']);
    }

    public function closeMailRequestaccess()
    {

        $this->MailRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment', 'cc_to', 'category', 'file_path', 'distributor_name', 'selectedPeople', 'selectedPeopleNames']);
    }

    public function closeMMSRequestaccess()
    {

        $this->MmsRequestaceessDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['subject', 'mail', 'mobile', 'description', 'selected_equipment', 'cc_to', 'category', 'file_path', 'distributor_name', 'selectedPeople', 'selectedPeopleNames']);
    }


    public function closePeoples()
    {
        $this->isNames = false;
    }
    protected function resetInputFields()
    {
        $this->subject = '';
        $this->description = '';
        $this->file_path = '';
        $this->cc_to = '';
    }


    public function selectPerson($personId)
    {
        try {
            // Retrieve the selected person's details
            $selectedPerson = $this->peoples->where('emp_id', $personId)->first();

            if ($selectedPerson) {
                // Create the formatted name with the emp_id
                $nameWithId = ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name)) . ' #(' . $selectedPerson->emp_id . ')';

                if (in_array($personId, $this->selectedPeople)) {
                    // Add the formatted name if not already in the list
                    if (!in_array($nameWithId, $this->selectedPeopleNames)) {
                        // Remove any instances of the plain name
                        $plainName = ucwords(strtolower($selectedPerson->first_name)) . ' ' . ucwords(strtolower($selectedPerson->last_name));
                        $this->selectedPeopleNames = array_diff($this->selectedPeopleNames, [$plainName]);
                    }
                } else {
                    // Remove the person's name from selectedPeopleNames if they are unselected
                    $this->selectedPeopleNames = array_diff($this->selectedPeopleNames, [$nameWithId]);
                }
                // Update cc_to field


                // Update email and mobile if there are any selected people left
                if (!empty($this->selectedPeople)) {
                    $lastSelectedId = end($this->selectedPeople);
                    $lastSelectedPerson = EmployeeDetails::where('emp_id', $lastSelectedId)->first();

                    if ($lastSelectedPerson) {
                        $this->mail = $lastSelectedPerson->email;
                        $this->mobile = $lastSelectedPerson->emergency_contact;
                    }
                } else {
                    // Clear email and mobile if no one is selected
                    $this->mail = null;
                    $this->mobile = null;
                }

                // Update cc_to field with unique selected names
                $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
            }
        } catch (\Exception $e) {
            Log::error('Error selecting person: ' . $e->getMessage());
            $this->dispatchBrowserEvent('error', ['message' => 'An error occurred while selecting the person. Please try again.']);
        }
    }



    public function addselectPerson($personId)
    {
        try {
            // Limit to a maximum of 5 selected people

            $addselectedPerson = $this->peoples->where('emp_id', $personId)->first();

            if ($addselectedPerson) {
                // Add or remove the person's name based on current selection
                if (in_array($personId, $this->addselectedPeople)) {
                    $name = ucwords(strtolower($addselectedPerson->first_name)) . ' ' . ucwords(strtolower($addselectedPerson->last_name)) . ' #(' . $addselectedPerson->emp_id . ')';
                    if (!in_array($name, $this->selectedPeopleNames)) {
                        $this->selectedPeopleNames[] = $name;
                    }
                } else {
                    // Remove the person's name from selectedPeopleNames if they are unselected
                    $this->selectedPeopleNames = array_diff($this->selectedPeopleNames, [ucwords(strtolower($addselectedPerson->first_name)) . ' ' . ucwords(strtolower($addselectedPerson->last_name)) . ' #(' . $addselectedPerson->emp_id . ')']);
                }

                // Update cc_to field
                $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
            }
        } catch (\Exception $e) {
            Log::error('Error selecting person: ' . $e->getMessage());
            $this->dispatch('error', ['message' => 'An error occurred while selecting the person. Please try again.']);
        }
    }


    public function filter()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = Auth::user()->company_id;

        // Fetch people data based on company ID and search term
        $this->peopleData =  EmployeeDetails::whereJsonContains('company_id', $companyId)
            ->whereNotIn('employee_status', ['rejected', 'terminated'])
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
    public function updatedAddselectedPeople()
    {
        // Ensure $this->addselectedPeople is always an array
        if (!is_array($this->addselectedPeople)) {
            $this->addselectedPeople = [];
        }

        // Limit the selection in addselectedPeople to a maximum of 5
        if (count($this->addselectedPeople) > 5) {
            FlashMessageHelper::flashWarning('You can only select up to 5 people.');
            $this->addselectedPeople = array_slice($this->addselectedPeople, 0, 5); // Trim the array
        }

        // Update cc_to field
        $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
    }
    public function updatedSelectedPeople()
    {
        // Ensure $this->selectedPeople is an array
        if (!is_array($this->selectedPeople)) {
            $this->selectedPeople = [];
        }

        // Limit selection to only one person

        if (count($this->selectedPeople) > 1) {
            FlashMessageHelper::flashWarning('You can only select up to 1 people.');
            $this->addselectedPeople = array_slice($this->addselectedPeople, 0, 1);
            $this->selectedPeople = array_slice($this->selectedPeople, 0, 1);
        } else {
            $this->cc_to = implode(', ', array_unique($this->selectedPeopleNames));
        }

        // Update the name display if a person is selected
        $this->selectedPeopleNames = [];
        foreach ($this->selectedPeople as $empId) {
            $person = EmployeeDetails::where('emp_id', $empId)->first();
            if ($person) {
                $this->selectedPeopleNames[] = $person->first_name . ' ' . $person->last_name . ' #(' . $person->emp_id . ')';
            }
        }

        // Update the email and mobile if only one person is selected
        if (!empty($this->selectedPeople)) {
            $selectedPerson = EmployeeDetails::where('emp_id', $this->selectedPeople[0])->first();
            $this->mail = $selectedPerson->email ?? null;
            $this->mobile = $selectedPerson->emergency_contact ?? null;
        } else {
            $this->mail = null;
            $this->mobile = null;
        }
    }



    public function NamesSearch()
    {
        $this->isNames = !$this->isNames;
    }
    public function DistributorRequest()
    {
        $messages = [
            'subject.required' => 'Business Justification is required',
            'distributor_name.required' => 'Distributor name is required',
            'description.required' => 'Specific Information is required',
            'priority.required' => 'Priority is required.',
        ];

        $this->validate([
            'distributor_name' => 'required|string',
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:High,Medium,Low',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960',
        ], $messages);

        try {
            $fileContent = null;
            $mimeType = null;
            $fileName = null;

            if ($this->file_path) {
                $fileContent = file_get_contents($this->file_path->getRealPath());
                if ($fileContent === false) {
                    Log::error('Failed to read the uploaded file.', [
                        'file_path' => $this->file_path->getRealPath(),
                    ]);
                    FlashMessageHelper::flashError('Failed to read the uploaded file.');
                    return;
                }

                if (strlen($fileContent) > 16777215) { // 16MB for MEDIUMBLOB
                    FlashMessageHelper::flashWarning('File size exceeds the allowed limit.');
                    return;
                }

                $mimeType = $this->file_path->getMimeType();
                $fileName = $this->file_path->getClientOriginalName();
            }

            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();

            $helpDesk = HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,

                'distributor_name' => $this->distributor_name,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' => $fileContent,
                'file_name' => $fileName,
                'mime_type' => $mimeType,
                'cc_to' => $this->cc_to ?? '-',
                'category' => $this->category,
                'priority' => $this->priority,
                'mail' => 'N/A',
                'mobile' => 'N/A',
                'status_code' => 8,
            ]);
            $helpDesk->refresh();
            
            // Notify super admins
            $superAdmins = IT::where('role', 'super_admin')->get();
            
            foreach ($superAdmins as $admin) {
                $employeeDetails = EmployeeDetails::where('emp_id', $admin->emp_id)->first();
            
                $firstName = $employeeDetails->first_name ?? 'N/A';
                $lastName = $employeeDetails->last_name ?? 'N/A';
            
                Mail::to($admin->email)->send(
                    new HelpDeskNotification($helpDesk, $firstName, $lastName)
                );
            }

            FlashMessageHelper::flashSuccess('Request created successfully.');
            $this->reset();
            return redirect()->to('/HelpDesk');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Do not reset here, just set the error bag
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id' => $this->employeeDetails->emp_id,
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null,
            ]);
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
        }
    }


    public function Devops()
    {
        $messages = [
            'subject.required' => 'Business Justification is required',
            'priority.required' => 'Priority is required.',
            'description.required' => 'Specific Information is required',
            'file_path.file' => 'The uploaded file must be a valid file.',
            'file_path.mimes' => 'The file must be of type: xls, csv, xlsx, pdf, jpeg, png, jpg, gif.',
            'file_path.max' => 'The file may not be greater than 40MB.',
        ];

        // Validate input fields
        $this->validate([
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:High,Medium,Low',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960',
        ], $messages);

        try {
            // Fetch logged-in employee details
            $employeeId = auth()->guard('emp')->user()->emp_id;

            if (!$employeeId) {
                FlashMessageHelper::flashError('Employee ID is missing.');
                return;
            }

            // Retrieve employee details using the emp_id
            $employeeDetails = EmployeeDetails::select('emergency_contact', 'email')
                ->where('emp_id', $employeeId)
                ->firstOrFail();

            // Directly fetch email and assign mobile as emergencyContact
            $this->mail = $employeeDetails->email ?? '-';
            $this->mobile = $employeeDetails->emergency_contact ?? '-'; // Using mobile as emergencyContact

            // Process file upload
            $fileContent = null;
            $mimeType = null;
            $fileName = null;

            if ($this->file_path) {
                $fileContent = file_get_contents($this->file_path->getRealPath());
                if ($fileContent === false) {
                    FlashMessageHelper::flashError('Failed to read the uploaded file.');
                    return;
                }

                // Check file size limit for BLOB storage
                if (strlen($fileContent) > 16777215) { // 16MB for MEDIUMBLOB
                    FlashMessageHelper::flashWarning('File size exceeds the allowed limit.');
                    return;
                }

                $mimeType = $this->file_path->getMimeType();
                $fileName = $this->file_path->getClientOriginalName();
            }

            $helpDesk = HelpDesks::create([
                'emp_id' => $employeeId, // Pass the employee ID directly
                'distributor_name' => $this->distributor_name ?? '-',
                'subject' => $this->subject,
               
                'description' => $this->description,
                'file_path' => $fileContent,
                'file_name' => $fileName,
                'priority' => $this->priority,
                'mime_type' => $mimeType,
                'cc_to' => $this->cc_to ?? '-',
                'category' => $this->category,
                'mail' => $this->mail, // Directly fetched email
                'mobile' => $this->mobile, 
                'status_code' => 8,
            ]);
            
            // Ensure `request_id` is fetched
            $helpDesk->refresh();
            
            // Notify super admins
            $superAdmins = IT::where('role', 'super_admin')->get();
            
            foreach ($superAdmins as $admin) {
                $employeeDetails = EmployeeDetails::where('emp_id', $admin->emp_id)->first();
            
                $firstName = $employeeDetails->first_name ?? 'N/A';
                $lastName = $employeeDetails->last_name ?? 'N/A';
            
                Mail::to($admin->email)->send(
                    new HelpDeskNotification($helpDesk, $firstName, $lastName)
                );
            }
            
            

            FlashMessageHelper::flashSuccess('Request created successfully.');
            $this->reset();
            return redirect()->to('/HelpDesk');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id' => $employeeId,
                'category' => $this->category ?? null,
                'subject' => $this->subject ?? null,
                'description' => $this->description ?? null,
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null,
            ]);
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
        }
    }



    public function Request()
    {
        try {
            $messages = [
                'subject.required' => 'Business Justification is required',
                'cc_to.required' => 'Add members is required',
                'description' => 'Specific Information is required',
                'priority.required' => 'Priority is required.',

            ];
            $this->validate([
                'subject' => 'required|string|max:255',
                'cc_to' => 'required',
                'priority' => 'required|in:High,Medium,Low',
                'description' => 'required|string',
                'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960', // Adjust max size as needed

            ],$messages);
         
    // Store the file as binary data
    $fileContent=null;
    $mimeType = null;
    $fileName = null;
    if ($this->file_path) {
   
   
        $fileContent = file_get_contents($this->file_path->getRealPath());
        if ($fileContent === false) {
            Log::error('Failed to read the uploaded file.', [
                'file_path' => $this->file_path->getRealPath(),
            ]);
            FlashMessageHelper::flashError( 'Failed to read the uploaded file.');
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
   
        $employeeId = auth()->guard('emp')->user()->emp_id;
       
        $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
       
       
     
    $helpDesk=HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,

                'subject' => $this->subject,
                'description' => $this->description,
                'file_path' =>  $fileContent,
                'file_name' => $fileName,
                'mime_type' => $mimeType,
                'cc_to' => $this->cc_to ?? '-',
                'category' => $this->category,
                'mobile' => 'N/A',
                'mail' => $this->mail ?? '-',
                'distributor_name' => $this->distributor_name ?? '-',
                'priority' => $this->priority,
                'status_code' => 8,


            ]);

            $helpDesk->refresh();
            
            // Notify super admins
            $superAdmins = IT::where('role', 'super_admin')->get();
            
            foreach ($superAdmins as $admin) {
                $employeeDetails = EmployeeDetails::where('emp_id', $admin->emp_id)->first();
            
                $firstName = $employeeDetails->first_name ?? 'N/A';
                $lastName = $employeeDetails->last_name ?? 'N/A';
            
                Mail::to($admin->email)->send(
                    new HelpDeskNotification($helpDesk, $firstName, $lastName)
                );
            }
            FlashMessageHelper::flashSuccess('Request created successfully.');
            $this->reset();
            return redirect()->to('/HelpDesk');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id' => $this->employeeDetails->emp_id,
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null, // Log the length of the file content
            ]);
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
        }
    }

    public function submit()
    {
        try {
            $messages = [
                'subject' => 'Subject is required',
                'description' => 'Specific Information is required',
                'selected_equipment' => 'Selected equipment is required',
                'priority.required' => 'Priority is required.',
            ];
            $this->validate([
                'subject' => 'required|string',
                'description' => 'required|string',
                'priority' => 'required|in:High,Medium,Low',
                'selected_equipment' => 'required|in:keyboard,mouse,headset,monitor',
                'file_path' => 'nullable|file|mimes:xls,csv,xlsx,pdf,jpeg,png,jpg,gif|max:40960',
            ], $messages);


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

            $employeeId = auth()->guard('emp')->user()->emp_id;

            $this->employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();


            $helpDesk =  HelpDesks::create([
                'emp_id' => $this->employeeDetails->emp_id,

                'subject' => $this->subject,
                'description' => $this->description,
                'selected_equipment' => $this->selected_equipment, // Ensure this is correctly referenced
                'file_path' => $fileContent,
                'file_name' => $fileName,
                'mime_type' => $mimeType,
                'cc_to' => $this->cc_to ?? '-',
                'category' => $this->category ?? '-',
                'mail' => 'N/A',
                'mobile' => 'N/A',
                'priority' => $this->priority,
                'distributor_name' => 'N/A',
                'status_code' => 8,
            ]);

            $superAdmins = IT::where('role', 'super_admin')->get();
            $superAdmins = IT::where('role', 'super_admin')->get();
            foreach ($superAdmins as $admin) {
                Mail::to($admin->email)->send(
                    new HelpDeskNotification($helpDesk, $admin->first_name, $admin->last_name)
                );
            }



            FlashMessageHelper::flashSuccess('Request created successfully.');
            $this->reset();
            return redirect()->to('/HelpDesk');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id' => $this->employeeDetails->emp_id,
                'category' => $this->category,
                'subject' => $this->subject,
                'description' => $this->description,
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null, // Log the length of the file content
            ]);
            FlashMessageHelper::flashError('An error occurred while creating the request. Please try again.');
        }
    }




    protected $listeners = ['closeModal'];

    public function closeModal()
    {
        // Handle modal closing logic here
        $this->showModal = false;
    }

    public function closecatalog()
    {
        $this->showModal = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset([
            'subject',
            'mail',
            'mobile',
            'description',
            'selected_equipment',
            'cc_to',
            'category',
            'file_path',
            'distributor_name',
            'selectedPeopleNames',
            'image',
            'selectedPeople',
            'selectedPeople',
        ]);
    }



    public function render()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
        $companyId = auth()->guard('emp')->user()->company_id;
        $this->peoples = EmployeeDetails::whereJsonContains('company_id', $companyId)
            ->whereNotIn('employee_status', ['rejected', 'terminated'])
            ->get();

        $peopleData = $this->filteredPeoples ? $this->filteredPeoples : $this->peoples;
        $this->record = HelpDesks::all();
        $employeeDetails = EmployeeDetails::select('emergency_contact', 'email')
            ->where('emp_id', $employeeId)
            ->firstOrFail();
        $this->mail = $employeeDetails->email;
        $this->mobile = $employeeDetails->emergency_contact;
        $employee = auth()->guard('emp')->user();
        $employeeId = $employee->emp_id;
        $employeeName = $employee->first_name . ' ' . $employee->last_name . ' #(' . $employeeId . ')';
        $superAdmins = IT::where('role', 'super_admin')->get();

        $this->records = HelpDesks::with('emp')
            ->where(function ($query) use ($employeeId, $employeeName) {
                $query->where('emp_id', $employeeId)
                    ->orWhere('cc_to', 'LIKE', "%$employeeName%");
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $records = HelpDesks::all();
        return view('livewire.catalog', [
            'peopleData' => $peopleData,
            'records' => $records,
            'superAdmins' => $superAdmins,
        ]);
    }
}

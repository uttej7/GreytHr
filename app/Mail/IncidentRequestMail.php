<?php

namespace App\Mail;

use App\Models\EmployeeDetails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IncidentRequestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $incidentRequest;
    public $firstName;
    public $lastName;
    public $requestCreatedBy;
    public $recipient;
    public $createdbyLastName;
    public $createdbyFirstName;
    public $employeeId;
    public $incidentID;
    /**
     * Create a new message instance.
     */
    public function __construct($incidentRequest, $firstName, $lastName)
    {
        $this->incidentRequest = $incidentRequest;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->incidentID = $this->incidentRequest->snow_id ;
        // Retrieve the first employee details based on emp_id
        $this->requestCreatedBy = EmployeeDetails::where('emp_id', '=', $this->incidentRequest->emp_id)->first();
        if ($this->requestCreatedBy) {
            // Access the first_name, last_name, and emp_id directly
            $this->createdbyFirstName = $this->requestCreatedBy->first_name;
            $this->createdbyLastName = $this->requestCreatedBy->last_name;
            $this->employeeId = $this->requestCreatedBy->emp_id;

        } else {
            // Handle not found scenario
            $this->createdbyFirstName = 'N/A';
            $this->createdbyLastName = 'N/A';
            $this->employeeId = 'N/A';
        }
    }
    public function build()
    {
        return $this->subject('New Service Request Created')
            ->view('emails.incident_request_mail_notification')
            ->with([
                'firstName' => $this->firstName,
                'incidentRequest' => $this->incidentRequest,
                'lastName' => $this->lastName,
                'incidentID' =>$this->incidentID,
                'short_description' => $this->incidentRequest->short_description,
                'description' => $this->incidentRequest->description,
                'priority' => $this->incidentRequest->priority,
                'file_name' => $this->incidentRequest->file_name,
                'file_path' => $this->incidentRequest->file_path,
                'requestCreatedBy' => $this->requestCreatedBy,
                'createdbyLastName' => $this->createdbyLastName,
                'createdbyFirstName' => $this->createdbyFirstName,
                'employeeId' => $this->employeeId
            ]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Incident ' . $this->incidentRequest->snow_id . ' Created by ' . $this->createdbyFirstName . ' ' . $this->createdbyLastName
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.incident_request_mail_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

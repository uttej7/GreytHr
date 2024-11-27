<?php

namespace App\Mail;

use App\Models\EmployeeDetails;
use App\Models\IT;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServiceRequestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $serviceRequest;
    public $firstName;
    public $lastName;
    public $requestCreatedBy;

    public $recipient;
    public $createdbyLastName;
    public $createdbyFirstName;
    public $employeeId;
    public $serviceID;

    /**
     * Create a new message instance.
     */
    public function __construct($serviceRequest, $firstName, $lastName)
    {
        $this->serviceRequest = $serviceRequest;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->serviceID = $this->serviceRequest->snow_id ;
        $this->requestCreatedBy = EmployeeDetails::where('emp_id', '=', $this->serviceRequest->emp_id)->first();
        // Retrieve the first employee details based on emp_id
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
            ->view('emails.service_request_mail_notification')
            ->with([
                'firstName' => $this->firstName,
                'serviceRequest' => $this->serviceRequest,
                'lastName' => $this->lastName,
                'incidentID' =>$this->serviceID,
                'short_description' => $this->serviceRequest->short_description,
                'description' => $this->serviceRequest->description,
                'priority' => $this->serviceRequest->priority,
                'file_name' => $this->serviceRequest->file_name,
                'file_path' => $this->serviceRequest->file_path,
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
            subject: 'Service ' . $this->serviceRequest->snow_id . ' Created by ' . $this->createdbyFirstName . ' ' . $this->createdbyLastName
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.service_request_mail_notification',
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

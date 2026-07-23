<?php
// app/Mail/ContactMail.php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use SerializesModels;

    // KHÔNG khai báo $subject vì Mailable đã có sẵn
    public string $senderName;
    public string $senderEmail;
    public string $senderPhone;
    public string $senderSubject;  // đổi tên thành senderSubject
    public string $messageBody;

    public function __construct(array $data)
    {
        $this->senderName    = $data['name']    ?? '';
        $this->senderEmail   = $data['email']   ?? '';
        $this->senderPhone   = $data['phone']   ?? 'Không có';
        $this->senderSubject = $data['subject'] ?? 'Không có chủ đề';
        $this->messageBody   = $data['message'] ?? '';
    }

    public function build()
    {
        return $this
            ->subject('[Luxury Watch] Liên hệ từ ' . $this->senderName)
            ->view('emails.contact');
    }
}

<?php
// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'message' => 'required|string|min:10',
        ], [
            'name.required'    => 'Vui lòng nhập họ tên.',
            'email.required'   => 'Vui lòng nhập email.',
            'email.email'      => 'Email không hợp lệ.',
            'message.required' => 'Vui lòng nhập nội dung.',
            'message.min'      => 'Nội dung phải ít nhất 10 ký tự.',
        ]);

        // 1. Lưu vào database
        Contact::create($request->only('name', 'email', 'phone', 'subject', 'message'));

        // 2. Gửi email – nếu lỗi vẫn báo thành công (không chặn user)
        try {
            $adminEmail = env('ADMIN_EMAIL', 'truongductuan2006@gmail.com');

            Mail::to($adminEmail)->send(
                new ContactMail($request->only('name', 'email', 'phone', 'subject', 'message'))
            );
        } catch (\Exception $e) {
            Log::error('Gửi email liên hệ thất bại: ' . $e->getMessage());
        }

        return back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong 24 giờ.');
    }
}
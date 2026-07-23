<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::latest();
        if ($request->filled('is_read')) $query->where('is_read', $request->is_read);
        $contacts = $query->paginate(15)->appends($request->all());
        $unread   = Contact::where('is_read', false)->count();
        return view('admin.contacts.index', compact('contacts','unread'));
    }

    public function show(Contact $contact)
    {
        if (!$contact->is_read) $contact->update(['is_read' => true]);
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Đã xóa tin nhắn!');
    }

    public function markAllRead()
    {
        Contact::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Đã đánh dấu tất cả là đã đọc!');
    }
}

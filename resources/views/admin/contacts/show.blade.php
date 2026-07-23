@extends('layouts.admin')
@section('title', 'Chi tiết liên hệ')

@section('content')
<div style="max-width:600px">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-envelope" style="color:#c4a96a;margin-right:6px"></i> Nội dung tin nhắn</h3>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-body" style="padding:24px">
            <table style="width:100%;font-size:14px;line-height:1.8">
                <tr>
                    <td style="color:#888;width:120px;padding:8px 0;vertical-align:top">Người gửi:</td>
                    <td><strong>{{ $contact->name }}</strong></td>
                </tr>
                <tr>
                    <td style="color:#888;padding:8px 0">Email:</td>
                    <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                </tr>
                <tr>
                    <td style="color:#888;padding:8px 0">Điện thoại:</td>
                    <td>{{ $contact->phone ?: '—' }}</td>
                </tr>
                <tr>
                    <td style="color:#888;padding:8px 0">Chủ đề:</td>
                    <td>{{ $contact->subject ?: '—' }}</td>
                </tr>
                <tr>
                    <td style="color:#888;padding:8px 0">Ngày gửi:</td>
                    <td>{{ $contact->created_at->format('H:i – d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="color:#888;padding:8px 0;vertical-align:top">Nội dung:</td>
                    <td>
                        <div style="background:#f8f9fa;padding:16px;border-radius:8px;line-height:1.8;white-space:pre-wrap">{{ $contact->message }}</div>
                    </td>
                </tr>
            </table>

            <div style="margin-top:20px;display:flex;gap:10px">
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-gold">
                    <i class="fas fa-reply"></i> Trả lời email
                </a>
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                      onsubmit="return confirm('Xóa tin nhắn này?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

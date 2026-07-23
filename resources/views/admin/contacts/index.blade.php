@extends('layouts.admin')
@section('title', 'Quản lý liên hệ')

@section('content')

<div class="toolbar">
    <form method="GET" style="display:contents">
        <select name="is_read" class="filter-select" onchange="this.form.submit()">
            <option value="">Tất cả tin nhắn</option>
            <option value="0" {{ request('is_read') === '0' ? 'selected' : '' }}>Chưa đọc ({{ $unread }})</option>
            <option value="1" {{ request('is_read') === '1' ? 'selected' : '' }}>Đã đọc</option>
        </select>
    </form>
    @if($unread > 0)
    <form action="{{ route('admin.contacts.mark-all-read') }}" method="POST" style="margin-left:auto">
        @csrf
        <button type="submit" class="btn btn-success btn-sm">
            <i class="fas fa-check-double"></i> Đánh dấu tất cả đã đọc
        </button>
    </form>
    @endif
</div>

<div class="card">
    <div class="card-header">
        <h3>Tin nhắn liên hệ ({{ $contacts->total() }})
            @if($unread > 0)
                <span class="badge-count" style="margin-left:8px">{{ $unread }} chưa đọc</span>
            @endif
        </h3>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Người gửi</th>
                    <th>Email / SĐT</th>
                    <th>Chủ đề</th>
                    <th>Nội dung</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Ngày gửi</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                <tr style="{{ !$contact->is_read ? 'background:#fffef0' : '' }}">
                    <td>
                        <strong style="font-size:13.5px">{{ $contact->name }}</strong>
                        @if(!$contact->is_read)
                            <span style="width:8px;height:8px;background:#e74c3c;border-radius:50%;display:inline-block;margin-left:6px"></span>
                        @endif
                    </td>
                    <td class="text-muted" style="font-size:12px">
                        {{ $contact->email }}<br>{{ $contact->phone }}
                    </td>
                    <td class="text-muted" style="font-size:13px">{{ $contact->subject ?: '—' }}</td>
                    <td style="font-size:13px;max-width:200px">{{ Str::limit($contact->message, 60) }}</td>
                    <td class="text-center">
                        <span class="badge {{ $contact->is_read ? 'badge-read' : 'badge-unread' }}">
                            {{ $contact->is_read ? 'Đã đọc' : 'Chưa đọc' }}
                        </span>
                    </td>
                    <td class="text-muted" style="font-size:12px">{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center">
                        <div class="flex" style="justify-content:center">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                                  onsubmit="return confirm('Xóa tin nhắn này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted" style="padding:32px">
                        <i class="fas fa-envelope-open" style="font-size:32px;display:block;margin-bottom:8px;opacity:.3"></i>
                        Không có tin nhắn nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $contacts->appends(request()->all())->links() }}

@endsection

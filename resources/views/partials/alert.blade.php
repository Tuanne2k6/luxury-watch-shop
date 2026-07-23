{{-- resources/views/partials/alert.blade.php --}}
@if(session('success'))
    <div class="alert alert-success" id="alertMsg">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-error" id="alertMsg">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button class="alert-close" onclick="this.parentElement.remove()">×</button>
    </div>
@endif

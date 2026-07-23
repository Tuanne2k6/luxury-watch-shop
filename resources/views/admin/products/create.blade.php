@extends('layouts.admin')
@section('title', 'Thêm sản phẩm mới')

@section('content')
<div style="max-width:900px">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-plus-circle" style="color:#c4a96a;margin-right:6px"></i> Thêm sản phẩm mới</h3>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-body" style="padding:24px">
            @if($errors->any())
                <div class="alert alert-error">
                    <div><i class="fas fa-exclamation-circle"></i> <strong>Có lỗi xảy ra:</strong>
                    <ul style="margin:6px 0 0 20px">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul></div>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label>Tên sản phẩm <span style="color:red">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="VD: Tissot T-Classic Tradition" required>
                    </div>
                    <div class="form-group">
                        <label>Thương hiệu <span style="color:red">*</span></label>
                        <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" placeholder="VD: Tissot, Citizen, Seiko..." required>
                    </div>
                    <div class="form-group">
                        <label>Danh mục <span style="color:red">*</span></label>
                        <select name="category" class="form-control" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach(['Đồng hồ nam','Đồng hồ nữ','Đồng hồ thể thao','Đồng hồ thông minh','Đồng hồ cao cấp'] as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                            @foreach($categories as $cat)
                                @if(!in_array($cat, ['Đồng hồ nam','Đồng hồ nữ','Đồng hồ thể thao','Đồng hồ thông minh','Đồng hồ cao cấp']))
                                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Số lượng tồn kho <span style="color:red">*</span></label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Giá bán (VNĐ) <span style="color:red">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}" min="0" step="1000" placeholder="VD: 5000000" required>
                    </div>
                    <div class="form-group">
                        <label>Giá gốc (VNĐ) <small class="text-muted">(để tính % giảm)</small></label>
                        <input type="number" name="original_price" class="form-control" value="{{ old('original_price') }}" min="0" step="1000" placeholder="Để trống nếu không có">
                    </div>
                    <div class="form-group form-full">
                        <label>Mô tả sản phẩm</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Mô tả chi tiết về sản phẩm...">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Điểm nổi bật <small class="text-muted">(mỗi dòng 1 điểm)</small></label>
                        <textarea name="features_text" class="form-control" rows="5" placeholder="Chống nước 100m&#10;Kính sapphire&#10;Máy cơ tự động...">{{ old('features_text') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Thông số kỹ thuật <small class="text-muted">(Key: Value, mỗi dòng)</small></label>
                        <textarea name="specifications_text" class="form-control" rows="5" placeholder="Đường kính: 40mm&#10;Chất liệu dây: Da bò&#10;Máy: Quartz...">{{ old('specifications_text') }}</textarea>
                    </div>
                    <div class="form-group form-full">
                        <label>Ảnh sản phẩm</label>
                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                        <small class="text-muted">Ảnh sẽ lưu vào public/images/products/. Khuyến nghị tỷ lệ 1:1, tối thiểu 500×500px.</small>
                        <br><img id="imgPreview" class="img-preview" src="" style="display:none;margin-top:10px">
                    </div>
                    <div class="form-group">
                        <label class="form-check">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            Đánh dấu là sản phẩm nổi bật (hiện trang chủ)
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-check">
                            <input type="checkbox" name="is_active" value="1" checked {{ old('is_active', true) ? 'checked' : '' }}>
                            Hiển thị sản phẩm lên website
                        </label>
                    </div>
                </div>

                <div style="margin-top:8px;display:flex;gap:12px">
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-save"></i> Lưu sản phẩm
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('imgPreview');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection

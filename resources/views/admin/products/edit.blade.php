@extends('layouts.admin')
@section('title', 'Sửa sản phẩm')

@section('content')
<div style="max-width:900px">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-edit" style="color:#c4a96a;margin-right:6px"></i> Sửa sản phẩm</h3>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
        <div class="card-body" style="padding:24px">
            @if($errors->any())
                <div class="alert alert-error">
                    <div><i class="fas fa-exclamation-circle"></i> <strong>Có lỗi:</strong>
                    <ul style="margin:6px 0 0 20px">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul></div>
                </div>
            @endif

            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label>Tên sản phẩm <span style="color:red">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Thương hiệu <span style="color:red">*</span></label>
                        <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Danh mục <span style="color:red">*</span></label>
                        <select name="category" class="form-control" required>
                            @foreach(['Đồng hồ nam','Đồng hồ nữ','Đồng hồ thể thao','Đồng hồ thông minh','Đồng hồ cao cấp'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                            @foreach($categories as $cat)
                                @if(!in_array($cat, ['Đồng hồ nam','Đồng hồ nữ','Đồng hồ thể thao','Đồng hồ thông minh','Đồng hồ cao cấp']))
                                    <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Số lượng tồn kho <span style="color:red">*</span></label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Giá bán (VNĐ) <span style="color:red">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" step="1000" required>
                    </div>
                    <div class="form-group">
                        <label>Giá gốc (VNĐ)</label>
                        <input type="number" name="original_price" class="form-control" value="{{ old('original_price', $product->original_price) }}" min="0" step="1000">
                    </div>
                    <div class="form-group form-full">
                        <label>Mô tả sản phẩm</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Điểm nổi bật (mỗi dòng 1 điểm)</label>
                        <textarea name="features_text" class="form-control" rows="5">{{ old('features_text', $featuresText) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Thông số kỹ thuật (Key: Value, mỗi dòng)</label>
                        <textarea name="specifications_text" class="form-control" rows="5">{{ old('specifications_text', $specificationsText) }}</textarea>
                    </div>
                    <div class="form-group form-full">
                        <label>Ảnh sản phẩm</label>
                        <div style="display:flex;align-items:flex-start;gap:16px">
                            <img src="{{ asset('images/' . $product->image) }}"
                                 id="imgPreview" class="img-preview"
                                 onerror="this.src='https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?w=100'">
                            <div style="flex:1">
                                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                                <small class="text-muted">Để trống nếu không muốn thay ảnh</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-check">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            Sản phẩm nổi bật (hiện trang chủ)
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-check">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            Hiển thị sản phẩm lên website
                        </label>
                    </div>
                </div>

                <div style="margin-top:8px;display:flex;gap:12px">
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-save"></i> Cập nhật
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
        reader.onload = function(e) { document.getElementById('imgPreview').src = e.target.result; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection

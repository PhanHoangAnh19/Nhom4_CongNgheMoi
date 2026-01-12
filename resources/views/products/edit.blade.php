@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                        <i class="fas fa-edit me-2 text-warning"></i> Chỉnh sửa: 
                        <span class="text-primary ms-1">{{ $product->name }}</span>
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    {{-- Gửi dữ liệu đến route admin.products.update --}}
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Tên điện thoại</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       style="border-radius: 8px;" value="{{ old('name', $product->name) }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Hãng sản xuất</label>
                                <select name="brand" class="form-select" style="border-radius: 8px;">
                                    @foreach(['iPhone', 'Samsung', 'Xiaomi', 'OPPO'] as $brand)
                                        <option value="{{ $brand }}" {{ old('brand', $product->brand) == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">RAM</label>
                                <input type="text" name="ram" class="form-control" style="border-radius: 8px;" value="{{ old('ram', $product->ram) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Bộ nhớ (ROM)</label>
                                <input type="text" name="storage" class="form-control" style="border-radius: 8px;" value="{{ old('storage', $product->storage) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Màu sắc</label>
                                <input type="text" name="color" class="form-control" style="border-radius: 8px;" value="{{ old('color', $product->color) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Giá bán (VNĐ)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-danger fw-bold">₫</span>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                           style="border-radius: 0 8px 8px 0;" value="{{ old('price', $product->price) }}">
                                </div>
                                @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Số lượng kho</label>
                                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                                       style="border-radius: 8px;" value="{{ old('quantity', $product->quantity) }}">
                                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <div class="p-3 bg-light rounded-3 border">
                                    <label class="form-label fw-bold small text-uppercase text-secondary">Hình ảnh sản phẩm</label>
                                    <div class="d-flex align-items-center gap-4">
                                        <div class="text-center">
                                            @if($product->image)
                                                <img src="{{ asset($product->image) }}" width="100" height="100" class="rounded shadow-sm border bg-white object-fit-contain">
                                                <div class="small text-muted mt-1">Ảnh hiện tại</div>
                                            @else
                                                <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width:100px; height:100px;">No Image</div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" style="border-radius: 8px;">
                                            <small class="text-muted d-block mt-2 italic">Chọn ảnh mới để thay đổi, để trống nếu giữ nguyên.</small>
                                        </div>
                                    </div>
                                    @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            {{-- Route admin.products.index đã được sửa đúng --}}
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4 fw-bold" style="border-radius: 8px;">
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-dark px-4 fw-bold shadow-sm" style="border-radius: 8px; background: #212529; border: none;">
                                <i class="fas fa-save me-2"></i>Cập nhật thông tin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
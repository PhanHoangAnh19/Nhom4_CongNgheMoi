@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}" class="text-decoration-none">Đơn hàng</a></li>
                    <li class="breadcrumb-item active">Chi tiết #{{ $order->id }}</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0 text-dark">
                <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>Đơn hàng #{{ $order->id }}
            </h3>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary border-2 fw-bold">
            <i class="fas fa-reply me-2"></i>Quay lại danh sách
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0 fw-bold"><i class="fas fa-box-open me-2 text-warning"></i>Sản phẩm đã đặt</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small uppercase">
                                <tr>
                                    <th class="ps-4 py-3">Tên sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end pe-4">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-3 p-2 me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-mobile-alt text-secondary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark mb-0">{{ $item->product_name }}</div>
                                                <small class="text-muted">Mã SP: #{{ $item->product_id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold text-secondary">x{{ $item->quantity }}</td>
                                    <td class="text-end text-dark font-monospace">{{ number_format($item->price) }}₫</td>
                                    <td class="text-end pe-4 fw-bold text-primary font-monospace">{{ number_format($item->subtotal) }}₫</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light-subtle py-4 px-4 border-0">
                    <div class="row justify-content-end">
                        <div class="col-md-5 col-lg-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tạm tính:</span>
                                <span class="fw-bold text-dark">{{ number_format($order->total_amount) }}₫</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Phí vận chuyển:</span>
                                <span class="text-success fw-bold">Miễn phí</span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 fw-bold mb-0">Tổng cộng:</span>
                                <span class="h4 fw-bold text-danger mb-0">{{ number_format($order->total_amount) }}₫</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-uppercase small tracking-wider text-muted">Thông tin giao hàng</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary-subtle text-primary rounded-circle p-2 me-3" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user small"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Người nhận</div>
                                <div class="fw-bold text-dark">{{ $order->customer_name }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-success-subtle text-success rounded-circle p-2 me-3" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-phone-alt small"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Điện thoại</div>
                                <div class="fw-bold text-dark font-monospace">{{ $order->customer_phone }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info border-0 shadow-none rounded-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i><small>Đơn hàng đặt lúc: {{ $order->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-muted small text-uppercase">Xử lý đơn hàng</h6>
                    <span class="badge rounded-pill bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }} py-2 px-3">
                        {{ $order->status == 'completed' ? 'Hoàn thành' : ($order->status == 'pending' ? 'Đang chờ' : 'Đã hủy') }}
                    </span>
                </div>
                <div class="card-body bg-light-subtle">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Thay đổi trạng thái:</label>
                            <select name="status" class="form-select border-2 shadow-none rounded-3">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Hủy đơn hàng</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm rounded-3">
                            <i class="fas fa-check-circle me-2"></i>Lưu cập nhật
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Một chút CSS để giao diện mượt mà hơn */
    .bg-primary-subtle { background-color: #e7f1ff; }
    .bg-success-subtle { background-color: #e6fffa; }
    .tracking-wider { letter-spacing: 0.05em; }
    .font-monospace { font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; }
    .card { transition: transform 0.2s ease; }
    .rounded-4 { border-radius: 1rem !important; }
</style>
@endsection
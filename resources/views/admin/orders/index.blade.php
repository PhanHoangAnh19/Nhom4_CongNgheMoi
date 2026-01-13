@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fas fa-history me-2 text-primary"></i>Quản lý lịch sử giao dịch
            </h3>
            <p class="text-muted small mb-0">Hệ thống ghi nhận tổng cộng <strong>{{ $orders->total() }}</strong> đơn hàng</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-white shadow-sm border fw-bold text-dark">
                <i class="fas fa-download me-2 text-success"></i>Xuất Excel
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase small fw-bold text-muted">
                        <tr>
                            <th class="ps-4 py-3">Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Số điện thoại</th>
                            <th class="text-end">Tổng tiền</th>
                            <th class="text-center">Ngày đặt</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center pe-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-primary">{{ $order->order_number ?? 'ORD-' . $order->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold text-dark">{{ $order->customer_name }}</span>
                                    <small class="text-muted">{{ $order->customer_email }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary font-monospace">{{ $order->customer_phone }}</span>
                            </td>
                            <td class="text-end fw-bold text-danger">
                                {{ number_format($order->total_amount) }}₫
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column">
                                    <span class="text-dark small">{{ $order->created_at->format('d/m/Y') }}</span>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $order->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-warning-subtle text-warning border-warning',
                                        'completed' => 'bg-success-subtle text-success border-success',
                                        'cancelled' => 'bg-danger-subtle text-danger border-danger'
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Chờ xử lý',
                                        'completed' => 'Đã hoàn thành',
                                        'cancelled' => 'Đã hủy'
                                    ];
                                    $class = $statusClasses[$order->status] ?? 'bg-secondary-subtle text-secondary border-secondary';
                                    $label = $statusLabels[$order->status] ?? $order->status;
                                @endphp
                                <span class="badge {{ $class }} border py-2 px-3 rounded-pill fw-bold" style="min-width: 110px;">
                                    {{ $label }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold shadow-sm transition-all">
                                    <i class="fas fa-eye me-1"></i> Chi tiết
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
        <div class="card-footer bg-white py-3 border-top">
            <div class="d-flex justify-content-center">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* CSS bổ trợ để giao diện mượt hơn */
    .bg-warning-subtle { background-color: #fff9db !important; }
    .bg-success-subtle { background-color: #ebfbee !important; }
    .bg-danger-subtle { background-color: #fff5f5 !important; }
    .font-monospace { font-family: 'SFMono-Regular', Consolas, monospace; }
    .rounded-4 { border-radius: 1rem !important; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .transition-all:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    .table-hover tbody tr:hover { background-color: #f8f9fa; }
</style>
@endsection
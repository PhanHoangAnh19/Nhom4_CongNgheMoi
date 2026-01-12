@extends('layouts.app') {{-- Đảm bảo tên layout này khớp với file bạn vừa sửa --}}

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark"><i class="fas fa-history me-2"></i>Quản lý lịch sử giao dịch</h3>
        <span class="badge bg-primary px-3 py-2">Tổng số đơn hàng: {{ $orders->count() }}</span>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-primary">{{ $order->order_number }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $order->customer_name }}</div>
                                <small class="text-muted">{{ $order->customer_email }}</small>
                            </td>
                            <td>{{ $order->customer_phone }}</td>
                            <td>
                                <span class="text-danger fw-bold">{{ number_format($order->total_amount) }}₫</span>
                            </td>
                            <td>
                                <div class="small">{{ $order->created_at->format('d/m/Y') }}</div>
                                <div class="text-muted small">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td>
                                @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                @elseif($order->status == 'completed')
                                <span class="badge bg-success">Đã hoàn thành</span>
                                @else
                                <span class="badge bg-secondary">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                Chưa có giao dịch nào được thực hiện.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
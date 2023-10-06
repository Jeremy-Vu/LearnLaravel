@extends('admin.layout.master')
@section('content')
    <h3>Quản lý hoá đơn</h3>

    <div class="card">
        <div class='card-body'>

            <a class="btn btn-success" href="{{ route('admin.order.create')}}">Thêm </a>
            <caption>
                <form class="float-right form-group form-inline">
                    <label class="mr-1">Search:</label>
                    <input type="search" name="q" value="{{ $search }}" placeholder="Tìm theo mã đơn..."
                           class="form-control">
                </form>
            </caption>
            <table class="table table-striped table-centered mb-0">
                <tr>
                    <th>Mã đơn</th>
                    <th>Tên khách hàng</th>
                    <th>Customer ID</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Phương thức thanh toán</th>
                    <th>Trạng thái đơn hàng</th>
                    <th>Ghi chú</th>
                    <th>Tổng tiền</th>
                    <th>Action</th>

                </tr>

                @foreach ($data as $each)
                    <tr>
                        <td>{{ $each->id }}</td>
                        <td>{{ $each->name_customer }}</td>
                        <td>{{ $each->customer_id }}</td>
                        <td>{{ $each->phone }}</td>
                        <td>{{ $each->address }}</td>
                        <td>{{ $each->payment_method }}</td>
                        <td>{{ $each->status }}</td>
                        <td>{{ $each->order_note }}</td>
                        <td>{{ $each->total_amount }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('admin.order.edit', $each) }}">Sửa</a>
                            <form action="{{ route('admin.order.destroy', $each) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Xoá</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </table>
            <nav>
                <ul class="pagination pagination-rounded mb-0">
                    {{ $data->links() }}
                </ul>
            </nav>
        </div>
    </div>
@endsection

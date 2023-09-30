@extends('admin.layout.master')
@section('content')
    <h3>Chi tiết đơn hàng</h3>
    <div class="card">
        <div class='card-body'>
{{--            <a class="btn btn-success" href="{{ route('customer.create')}}">Thêm </a>--}}
            <caption>
                <form class="float-right form-group form-inline">
                    <label class="mr-1">Search:</label>
{{--                    <input type="search" name="q" value="{{ //$search }}" placeholder="Tìm theo tên..." class="form-control">--}}
                </form>
            </caption>
            <table  class="table table-striped table-centered mb-0">
                <tr>
                    <th>Mã hoá đơn chi tiết</th>
                    <th>Product ID</th>
                    <th>Order ID</th>
                    <th>Giá tiền</th>
                    <th>Số lượng</th>
                    <th>Sửa</th>
{{--                    @if(checkSuperAdmin())--}}
{{--                        <th>Xoá</th>--}}
{{--                    @endif--}}

                </tr>

                @foreach ($data as $each)
                    <tr>
                        <td>{{ $each->id }}</td>
                        <td>{{ $each->product_id }}</td>
                        <td>{{ $each->order_id }}</td>
                        <td>{{ $each->price }}</td>
                        <td>{{ $each->quantity }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('admin.order.edit', $each) }}">Sửa</a>
                        </td>
{{--                        @if(checkSuperAdmin())--}}
{{--                            <td>--}}
{{--                                <form action="{{ route('khach-hang.destroy', $each) }}" method="post">--}}
{{--                                    @csrf--}}
{{--                                    @method('DELETE')--}}
{{--                                    <button class="btn btn-danger">Xoá</button>--}}
{{--                                </form>--}}
{{--                            </td>--}}
{{--                        @endif--}}

                    </tr>
                @endforeach
            </table>
            <nav>
                <ul class="pagination pagination-rounded mb-0">
{{--                    {{ $data->links() }}--}}
                </ul>
            </nav>
        </div>
    </div>
@endsection

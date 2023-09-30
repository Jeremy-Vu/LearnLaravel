@extends('admin.layout.master')
@section('content')
    <h3>Quản lý hoá đơn</h3>

    <div class="card">
        <div class='card-body'>

            <a class="btn btn-success" href="{{ route('admin.product.create')}}">Thêm </a>
            <caption>
                <form class="float-right form-group form-inline">
                    <label class="mr-1">Search:</label>
{{--                    <input type="search" name="q" value="{{ //$search }}" placeholder="Tìm theo tên..." class="form-control">--}}
                </form>
            </caption>
            <table  class="table table-striped table-centered mb-0">
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Slug</th>
                    <th>Ảnh</th>
                    <th>SKU</th>
                    <th>Chi tiết sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Thương hiệu</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th>Sửa</th>
{{--                    @if(checkSuperAdmin())--}}
{{--                        <th>Xoá</th>--}}
{{--                    @endif--}}

                </tr>

                @foreach ($data as $each)
                    <tr>
                        <td>{{ $each->id }}</td>
                        <td>{{ $each->name }}</td>
                        <td>{{ $each->price }}</td>
                        <td>{{ $each->quantity }}</td>
                        <td>{{ $each->slug }}</td>
                        <td>{{ $each->image }}</td>
                        <td>{{ $each->sku }}</td>
                        <td>{{ $each->detail_product }}</td>
                        <td>{{ $each->description }}</td>
                        <td>{{ $each->brand_id }}</td>
                        <td>{{ $each->category_id }}</td>
                        <td>{{ $each->status }}</td>
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

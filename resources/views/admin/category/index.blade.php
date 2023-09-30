@extends('admin.layout.master')
@section('content')
    <h3>Quản lý hoá đơn</h3>

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
                    <th>Mã danh mục</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Mô tả</th>
                    <th>Nội dung</th>
                    <th>Ảnh</th>
                    <th>Trạng thái</th>
                    <th>Mô tả</th>
                    <th>Thương hiệu</th>
                    <th>Is menu</th>
                    <th>Parrent ID</th>
                    <th>Sửa</th>
{{--                    @if(checkSuperAdmin())--}}
{{--                        <th>Xoá</th>--}}
{{--                    @endif--}}

                </tr>

                @foreach ($data as $each)
                    <tr>
                        <td>{{ $each->id }}</td>
                        <td>{{ $each->name }}</td>
                        <td>{{ $each->slug }}</td>
                        <td>{{ $each->description }}</td>
                        <td>{{ $each->content }}</td>
                        <td>{{ $each->image }}</td>
                        <td>{{ $each->status }}</td>
                        <td>{{ $each->is_menu }}</td>
                        <td>{{ $each->parrent_id }}</td>
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

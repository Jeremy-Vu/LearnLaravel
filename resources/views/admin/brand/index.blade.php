@extends('admin.layout.master')
@section('content')
    <h3>Thương hiệu</h3>

    <div class="card">
        <div class='card-body'>

            <a class="btn btn-success" href="{{ route('admin.brand.create')}}">Thêm </a>
            <caption>
                <form class="float-right form-group form-inline">
                    <label class="mr-1">Search:</label>
                    {{--                    <input type="search" name="q" value="{{ $search }}" placeholder="Tìm theo tên..." class="form-control">--}}
                </form>
            </caption>
            <table class="table table-striped table-centered mb-0">
                <tr>
                    <th>Mã thương hiệu</th>
                    <th>Tên thương hiệu</th>
                    <th>Slug</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Logo</th>
                    <th>Mô tả</th>
                    <th>Địa chỉ</th>
                    <th>Trạng thái</th>
                    <th>Sửa</th>
                    {{--                    @if(checkSuperAdmin())--}}
{{--                    <th>Xoá</th>--}}
                    {{--                    @endif--}}

                </tr>

                @foreach ($data as $each)
                    <tr>
                        <td>{{ $each->id }}</td>
                        <td>{{ $each->name }}</td>
                        <td>{{ $each->slug }}</td>
                        <td>{{ $each->phone }}</td>
                        <td>{{ $each->email }}</td>
                        <td>{{ $each->logo }}</td>
                        <td>{{ $each->description }}</td>
                        <td>{{ $each->address }}</td>
                        <td>{{ $each->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('admin.brand.edit', $each) }}">Sửa</a>
                        </td>
                        {{--                        @if(checkSuperAdmin())--}}
{{--                        <td>--}}
{{--                            <form onclick="return confirm('Em có chắc không?')" action="{{ route('admin.brand.destroy', $each) }}" method="post">--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <button class="btn btn-danger">Xoá</button>--}}
{{--                            </form>--}}
{{--                        </td>--}}
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

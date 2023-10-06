@extends('admin.layout.master')
@section('content')
    <h3>Quản lý danh mục</h3>

    <div class="card">
        <div class='card-body'>

            <a class="btn btn-success" href="{{ route('admin.category.create')}}">Thêm </a>
            <form class="float-right form-group form-inline">
                <label class="mr-1">Search:</label>
                <input type="search" name="q" value="{{ $search }}" placeholder="Tìm theo tên..." class="form-control">
            </form>
            <table class="table table-striped table-centered mb-0">
                <tr>
                    <th>Mã danh mục</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Mô tả</th>
                    <th>Nội dung</th>
                    <th>Ảnh</th>
                    <th>Trạng thái</th>
                    <th>Is menu</th>
                    <th>Parrent ID</th>
                    <th>Action</th>

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
                            <a class="btn btn-primary" href="{{ route('admin.category.edit', $each) }}">Sửa</a>
                            <form action="{{ route('admin.category.destroy', $each) }}" method="post">
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
                    {{--                    {{ $data->links() }}--}}
                </ul>
            </nav>
        </div>
    </div>
@endsection

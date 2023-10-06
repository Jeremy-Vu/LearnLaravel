@extends('admin.layout.master')
@section('content')
    <h3>Thương hiệu</h3>

    <div class="card">
        <div class='card-body'>
            <a class="btn btn-success" href="{{ route('admin.brand.create')}}">Thêm </a>
            <form class="float-right form-group form-inline">
                <label class="mr-1">Search:</label>
                <input type="search" name="q" value="{{ $search }}" placeholder="Tìm theo tên..." class="form-control">
            </form>
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
                    <th>Action</th>
                </tr>

                @foreach ($data as $each)
                    <tr>
                        <td>{{ $each->id }}</td>
                        <td>{{ $each->name }}</td>
                        <td>{{ $each->slug }}</td>
                        <td>{{ $each->phone }}</td>
                        <td>{{ $each->email }}</td>
                        <td>
                            <img src="{{ asset($each->logo) }}" alt="banner_logo" style="max-height: 90px">
                        </td>
                        <td>{{ $each->description }}</td>
                        <td>{{ $each->address }}</td>
                        <td>{{ $each->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('admin.brand.edit', $each) }}">Sửa</a>
                            <form onclick="return confirm('Em có chắc không?')"
                                  action="{{ route('admin.brand.destroy', $each) }}" method="post">
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

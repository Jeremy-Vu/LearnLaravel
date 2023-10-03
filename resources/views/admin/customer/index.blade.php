@extends('admin.layout.master')
@section('content')
    <h3>Quản lý khách hàng</h3>

    <div class="card">
        <div class='card-body'>

            <a class="btn btn-success" href="{{ route('admin.customer.create')}}">Thêm </a>
            <caption>
                <form class="float-right form-group form-inline">
                    <label class="mr-1">Search:</label>
{{--                    <input type="search" name="q" value="{{ $search }}" placeholder="Tìm theo tên..." class="form-control">--}}
                </form>
            </caption>
            <table class="table table-striped table-centered mb-0">
                <tr>
                    <th>Mã khách hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Giới tính</th>
                    <th>SĐT</th>
                    <th>Sửa</th>
                    {{--                    @if(checkSuperAdmin())--}}
                    <th>Xoá</th>
                    {{--                    @endif--}}

                </tr>

                @foreach ($data as $each)
                    <tr>
                        <td>{{ $each ->id }}</td>
                        <td>{{ $each ->name }}</td>
                        <td>{{ $each ->email }}</td>
                        <td>{{ $each ->address }}</td>
                        <td> {{ $each ->gender === 1 ? 'Nam' : 'Nữ' }} </td>
                        <td>{{ $each ->phone }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('admin.customer.edit', $each) }}">Sửa</a>
                        </td>
                        <td>
                            <form onclick="return confirm('Em có chắc không?')" action="{{ route('admin.customer.destroy', $each) }}" method="post">
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

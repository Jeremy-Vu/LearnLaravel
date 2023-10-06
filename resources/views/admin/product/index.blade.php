@extends('admin.layout.master')
@section('content')
    <h3>Quản lý sản phẩm</h3>

    <div class="card">
        <div class='card-body'>

            <a class="btn btn-success" href="{{ route('admin.product.create')}}">Thêm </a>
            <caption>
                <form class="float-right form-group form-inline">
                    <label class="mr-1">Search:</label>
                    <input type="search" name="q" value="{{ $search }}" placeholder="Tìm theo tên..." class="form-control">
                </form>
            </caption>
            <table class="table table-striped table-centered mb-0">
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
                    <th>Action</th>

                </tr>
                @foreach ($data as $each)
                    <tr>
                        <td>{{ $each->id }}</td>
                        <td>{{ $each->name }}</td>
                        <td>{{ $each->price }}</td>
                        <td>{{ $each->quantity }}</td>
                        <td>{{ $each->slug }}</td>
                        <td>
                            <img src="{{ asset($each->image) }}" alt="product_img" style="max-height: 90px">
                        </td>
                        <td>{{ $each->sku }}</td>
                        <td>{{ $each->detail_product }}</td>
                        <td>{{ $each->description }}</td>
                        <td>{{ $each->brand_id }}</td>
                        <td>{{ $each->category_id }}</td>
                        <td>{{ $each->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('admin.product.edit', $each) }}">Sửa</a>
                            <form onclick="return confirm('Em có chắc không?')" action="{{ route('admin.product.destroy', $each) }}" method="post">
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

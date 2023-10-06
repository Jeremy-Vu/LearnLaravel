@extends('admin.layout.master')
@section('content')
    <style>
        .mr-1 {
            display: table-cell;
        }

        label {
            margin-left: 5px;
            margin-bottom: 1rem;
            display: block;
        }
    </style>
    <form action="{{ route('admin.product.store') }}" method="post" style="display: table" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <div style="display: table-row">
                <label class="mr-1"> Tên sản phẩm: </label>
                <label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    @if ($errors->has('name'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('name') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Giá sản phẩm: </label>
                <label>
                    <input type="number" min="0" name="price" value="{{ old('price') }}" class="form-control">
                    @if ($errors->has('price'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('price') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Số lượng: </label>
                <label>
                    <input type="number" min="0" name="quantity" class="form-control" value="{{ old('quantity') }}">
                    @if ($errors->has('quantity'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('quantity') }}
                    </span>
                    @endif
                </label>
            </div>

            <div hidden>
                <label class="mr-1"> Slug: </label>
                <label>
                    <input disabled type="text" name="slug" class="form-control">
                    @if ($errors->has('slug'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('slug') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Ảnh: </label>
                <label>
                    <input type="file" name="image" value="{{ old('image') }}" class="form-control-file">
                    @if ($errors->has('image'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('image') }}
                    </span>
                    @endif
                </label>
            </div>


            <div style="display: table-row">
                <label class="mr-1"> SKU: </label>
                <label>
                    <input type="text" name="sku" value="{{ old('sku') }}" class="form-control">
                    @if ($errors->has('sku'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('sku') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Mô tả: </label>
                <label>
                    <input type="text" name="description" value="{{ old('description') }}" class="form-control">
                    @if ($errors->has('description'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('description') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Chi tiết sản phẩm: </label>
                <label>
                    <textarea type="text" name="detail_product" placeholder="{{ old('detail_product') }}"
                              class="form-control">
                    </textarea>
                    @if ($errors->has('detail_product'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('detail_product') }}
                    </span>
                    @endif
                </label>

            </div>


            <div style="display: table-row">
                <label class="mr-1"> Thương hiệu: </label>
                <label>
                    <select name="brand_id" class="form-control select">
                        <option value="" selected>Chọn thương hiệu</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('brand_id'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('brand_id') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Danh mục: </label>
                <label>
                    <select name="category_id" class="form-control select">
                        <option value="" selected> Chọn danh mục</option>
                        @foreach ($categories as $category )
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('category_id'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('category_id') }}
                    </span>
                    @endif
                </label>

            </div>
            <br>

            <button class="btn btn-success">Tạo</button>
        </div>
    </form>

@endsection

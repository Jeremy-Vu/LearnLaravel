@extends('admin.layout.master')
@section('content')
    <form action="{{ route('admin.product.store') }}" method="post">
        @csrf
        <div class="form-group">
            <div>
                <label class="mr-1"> Tên sản phẩm: </label>
                <label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                </label>
                @if ($errors->has('name'))
                    <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('name') }}
                        </span>
                @endif
            </div>

            <div>
                <label class="mr-1"> Giá sản phẩm: </label>
                <label>
                    <input type="number" min="0" name="price" value="{{ old('price') }}" class="form-control">
                </label>
                @if ($errors->has('price'))
                    <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('price') }}
                    </span>
                @endif
            </div>

            <div>
                <label class="mr-1"> Số lượng: </label>
                <label>
                    <input type="number" min="0" name="quantity" class="form-control" value="{{ old('quantity') }}">
                </label>
                @if ($errors->has('quantity'))
                    <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('quantity') }}
                    </span>
                @endif
            </div>

            <div hidden>
                <label class="mr-1"> Slug: </label>
                <label>
                    <input disabled type="text" name="slug" class="form-control">
                </label>
                @if ($errors->has('slug'))
                    <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('slug') }}
                    </span>
                @endif
            </div>

            <div>
                <label class="mr-1"> Ảnh: </label>
                <label>
                    <input type="file" name="image" value="{{ old('image') }}" class="form-control">
                </label>
                @if ($errors->has('image'))
                    <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('image') }}
                    </span>
                @endif
            </div>


            <div>
                <label class="mr-1"> SKU: </label>
                <label>
                    <input type="text" name="sku" value="{{ old('sku') }}" class="form-control">
                </label>
                @if ($errors->has('sku'))
                    <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('sku') }}
                    </span>
                @endif
            </div>


            <div>
                <label class="mr-1"> Chi tiết sản phẩm: </label>
                <label>
                    <input type="text" name="detail_product" value="{{ old('detail_product') }}" class="form-control">
                </label>
                @if ($errors->has('detail_product'))
                    <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('detail_product') }}
                    </span>
                @endif
            </div>

            <div>
                <label class="mr-1"> Mô tả: </label>
                <label>
                <textarea type="text" name="description" placeholder="{{ old('description') }}" class="form-control">
                </textarea>
                </label>
                @if ($errors->has('description'))
                    <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('description') }}
                    </span>
                @endif
            </div>

            <div>
                <label class="mr-1"> Thương hiệu : </label>
                <label>
                    <select name="brand_id" class="form-control select">
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </label>
                @if ($errors->has('brand_id'))
                    <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('brand_id') }}
                    </span>
                @endif
            </div>

            <div>
                <label class="mr-1"> Danh mục : </label>
                <label>
                    <select name="category_id" class="form-control select">
                        @foreach ($categories as $category )
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </label>
                @if ($errors->has('category_id'))
                    <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('category_id') }}
                    </span>
                @endif
            </div>
            <br>

            <button class="btn btn-success">Tạo</button>
        </div>
    </form>

@endsection

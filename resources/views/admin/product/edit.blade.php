@extends('admin.layout.master')
@section('content')
    <style>
        label {
            display: block;
        }
    </style>
    <form action="{{ route('admin.product.update' , $each) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="mr-1"> Tên sản phẩm: </label>
            <label>
                <input type="text" name="name" value="{{ $each->name ?? old('name') }}" class="form-control">
            </label>
            @if ($errors->has('name'))
                <span class="error" style="color: red; font-size: 12px;">
                    {{ $errors->first('name') }}
                </span>
            @endif
            <br>

            <label class="mr-1"> Giá sản phẩm: </label>
            <label>
                <input type="number" name="price" value="{{ $each->price ?? old('price') }}" class="form-control">
            </label>
            @if ($errors->has('price'))
                <span class="error" style="color: red; font-size: 12px;">
                    {{ $errors->first('price') }}
                </span>
            @endif
            <br>


            <label class="mr-1"> Số lượng: </label>
            <label>
                <input type="number" name="quantity" value="{{ $each->quantity ?? old('quantity') }}" class="form-control">
            </label>
            @if ($errors->has('quantity'))
                <span class="error" style="color: red; font-size: 12px;">
                    {{ $errors->first('quantity') }}
                </span>
            @endif
            <br>

            <label class="mr-1"> Slug: </label>
            <label>
                <input disabled type="text" name="slug" value="{{ $each->slug }}" class="form-control">
            </label>
            @if ($errors->has('slug'))
                <span class="error" style="color: red; font-size: 12px;">
                    {{ $errors->first('slug') }}
                </span>
            @endif
            <br>

            <label class="mr-1"> Ảnh: </label>
            <label>
                <input type="file" name="image" value="{{ old('image') }}" class="form-control">
            </label>
            @if ($errors->has('image'))
                <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('image') }}
                        </span>
            @endif
            <br>

            <label class="mr-1"> SKU: </label>
            <label>
                <input type="text" name="sku" value="{{  $each->sku ?? old('sku') }}" class="form-control">
            </label>
            @if ($errors->has('sku'))
                <span class="error" style="color: red; font-size: 12px;">
                    {{ $errors->first('sku') }}
                </span>
            @endif
            <br>

            <label class="mr-1"> Chi tiết sản phẩm: </label>
            <label>
                <input type="text" name="detail_product" value="{{ $each->detail_product ??  old('detail_product') }}" class="form-control">
            </label>
            @if ($errors->has('detail_product'))
                <span class="error" style="color: red; font-size: 12px;">
                    {{ $errors->first('detail_product') }}
                </span>
            @endif
            <br>

            <label class="mr-1"> Mô tả: </label>
            <label>
                <textarea type="text" name="description" placeholder="{{ $each->description ?? old('description') }}" class="form-control">
                </textarea>
            </label>
            @if ($errors->has('description'))
                <span class="error" style="color: red; font-size: 12px;">
                    {{ $errors->first('description') }}
                </span>
            @endif
            <br>

            <label class="mr-1"> Thương hiệu : </label>
            <label>
                <select name="brand_id" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </label>
            @if ($errors->has('brand_id'))
                <span class="error" style="color: red; font-size: 12px;">
                    {{ $errors->first('brand_id') }}
                </span>
            @endif
            <br>

            <label class="mr-1"> Danh mục : </label>
            <label>
                <select name="category_id" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </label>
            @if ($errors->has('category_id'))
                <span class="error" style="color: red; font-size: 12px;">
                    {{ $errors->first('category_id') }}
                </span>
            @endif
            <br>


            <button class="btn btn-success">Tạo</button>
        </div>
    </form>

@endsection

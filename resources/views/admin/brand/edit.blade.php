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
    <form action="{{ route('admin.brand.update', $each) }}" method="post" style="display: table">
        @csrf
        @method('put')
        <div class="form-group">

            <div style="display: table-row">
                <label class="mr-1"> Tên thương hiêụ  : </label>
                <label>
                    <input type="text" name="name" value="{{$each->name ?? old('name') }}" class="form-control">
                    @if ($errors->has('name'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('name') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Slug : </label>
                <label>
                    <input type="text" min="0" name="slug" value="{{$each->slug ?? old('slug') }}" class="form-control">
                    @if ($errors->has('slug'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('slug') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Số điện thoại: </label>
                <label>
                    <input type="number" min="0" name="phone" class="form-control" value="{{$each->phone ?? old('phone') }}">
                    @if ($errors->has('phone'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('phone') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Email: </label>
                <label>
                    <input type="email" name="email" value="{{$each->email ?? old('email') }}" class="form-control">
                    @if ($errors->has('email'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('email') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1">  Logo: </label>
                <label>
                    <input type="file" name="logo" value="{{$each->logo ?? old('logo') }}" class="form-control">
                    @if ($errors->has('logo'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('logo') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Mô tả: </label>
                <label>
                    <textarea type="text" name="description" placeholder="{{$each->description ?? old('description') }}"
                              class="form-control">
                    </textarea>
                    @if ($errors->has('description'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('description') }}
                    </span>
                    @endif
                </label>

            </div>

            <div style="display: table-row">
                <label class="mr-1">  Địa chỉ: </label>
                <label>
                    <input type="text" name="address" value="{{$each->address ?? old('address') }}" class="form-control">
                    @if ($errors->has('address'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('address') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1">  Trạng thái : </label>
                <label>
                    <input type="text" name="status" value="{{$each->status ?? old('status') }}" class="form-control">
                    @if ($errors->has('status'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('status') }}
                    </span>
                    @endif
                </label>
            </div>
            <br>

            <button class="btn btn-success">Tạo</button>
        </div>
    </form>

@endsection

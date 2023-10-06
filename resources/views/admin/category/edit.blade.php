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
    <form action="{{ route('admin.category.update',$each) }}" method="post" style="display: table">
        @csrf
        @method('put')
        <div class="form-group">
            <div style="display: table-row">
                <label class="mr-1"> Tên danh mục: </label>
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
                <label class="mr-1"> Slug: </label>
                <label>
                    <input type="text" min="0" name="slug " value="{{$each->slug ?? old('slug ') }}" class="form-control">
                    @if ($errors->has('slug '))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('slug ') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Mô tả: </label>
                <label>
                    <input type="text" min="0" name="description" class="form-control" value="{{$each->description ?? old('description') }}">
                    @if ($errors->has('description'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('description') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Nội dung: </label>
                <label>
                    <textarea type="text" name="content" placeholder="{{$each->content ?? old('content') }}"
                              class="form-control">
                    </textarea>
                    @if ($errors->has('content'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('content') }}
                    </span>
                    @endif
                </label>

            </div>


            <div style="display: table-row">
                <label class="mr-1"> Ảnh: </label>
                <label>
                    <input type="file" name="image" value="{{$each->image ?? old('image') }}" class="form-control-file">
                    @if ($errors->has('image'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('image') }}
                    </span>
                    @endif
                </label>
            </div>


            <div style="display: table-row">
                <label class="mr-1"> Trạng thái: </label>
                <label>
                    <input type="text" name="status" value="{{$each->status ?? old('status') }}" class="form-control">
                    @if ($errors->has('status'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('status') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Is menu : </label>
                <label>
                    <input type="number" name="is_menu" value="{{$each->is_menu ?? old('is_menu') }}" class="form-control">
                    @if ($errors->has('is_menu'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('is_menu') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Parent id : </label>
                <label>
                    <input type="number" name="parrent_id" value="{{$each->parrent_id ?? old('parrent_id') }}" class="form-control">
                    @if ($errors->has('parrent_id'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('parrent_id') }}
                    </span>
                    @endif
                </label>
            </div>

            <br>

            <button class="btn btn-success">Tạo</button>
        </div>
    </form>

@endsection

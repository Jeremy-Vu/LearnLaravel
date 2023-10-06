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
    <form action="{{ route('admin.customer.update' , $each) }}" method="post" style="display: table">
        @csrf
        @method('PUT')
        <div class="form-group">
            <div style="display: table-row">
                <label class="mr-1"> Tên khách hàng: </label>
                <label>
                    <input type="text" name="name" value="{{ $each->name ?? old('name') }}" class="form-control">
                    @if ($errors->has('name'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('name') }}
                        </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Email: </label>
                <label>
                    <input type="email" name="email" value="{{ $each->email ?? old('email') }}" class="form-control">
                    @if ($errors->has('email'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('email') }}
                        </span>
                    @endif
                </label>
            </div>


            <div style="display: table-row">
                <label class="mr-1"> Password: </label>
                <label>
                    <input type="password" name="password" class="form-control">
                    @if ($errors->has('password'))
                        <span class="error" style="color: red; font-size: 12px;">
                     {{ $errors->first('password') }}
                </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Confirm Password: </label>
                <label>
                    <input type="password" name="confirm_password" class="form-control">
                    @if ($errors->has('confirm_password'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('confirm_password') }}
                        </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Số điện thoại: </label>
                <label>
                    <input type="number" name="phone" value="{{ $each->phone ?? old('phone') }}" class="form-control">
                    @if ($errors->has('phone'))
                        <span class="error" style="color: red; font-size: 12px;">
                     {{ $errors->first('phone') }}
                </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Ngày sinh: </label>
                <label>
                    <input type="date" name="birthdate" value="{{ $each->birthdate ?? old('birthdate') }}" class="form-control">
                    @if ($errors->has('birthdate'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('birthdate') }}
                        </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Địa chỉ: </label>
                <label>
                    <input type="text" name="address" value="{{ $each->address ?? old('address') }}" class="form-control">
                    @if ($errors->has('address'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('address') }}
                        </span>
                    @endif
                </label>
            </div>


            <button class="btn btn-success">Sửa</button>
        </div>
    </form>

@endsection

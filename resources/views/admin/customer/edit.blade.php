@extends('admin.layout.master')
@section('content')
    <style>
        label {
            display: block;
        }
    </style>
    <form action="{{ route('admin.customer.update' , $each) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="mr-1"> Tên khách hàng: </label>
            <label>
                <input type="text" name="name" value="{{ $each->name ?? old('name') }}" class="form-control">
            </label>
                      @if ($errors->has('name'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('name') }}
                        </span>
                      @endif
            <br>

            <label class="mr-1"> Email: </label>
            <label>
                <input type="email" name="email" value="{{ $each->email ?? old('email') }}" class="form-control">
            </label>
                      @if ($errors->has('email'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('email') }}
                        </span>
                      @endif
            <br>



            <label class="mr-1"> Password: </label>
            <label>
                <input type="password" name="password" class="form-control">
            </label>
                      @if ($errors->has('password'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('password') }}
                        </span>
                      @endif
            <br>

            <label class="mr-1"> Confirm Password: </label>
            <label>
                <input type="password" name="confirm_password" class="form-control">
            </label>
                      @if ($errors->has('confirm_password'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('confirm_password') }}
                        </span>
                      @endif
            <br>

            <label class="mr-1"> Số điện thoại: </label>
            <label>
                <input type="number" name="phone" value="{{ $each->phone ?? old('phone') }}" class="form-control">
            </label>
                      @if ($errors->has('phone'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('phone') }}
                        </span>
                      @endif
            <br>

            <label class="mr-1"> Ngày sinh: </label>
            <label>
                <input type="date" name="birthdate" value="{{ $each->birthdate ?? old('birthdate') }}" class="form-control">
            </label>
                      @if ($errors->has('birthdate'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('birthdate') }}
                        </span>
                      @endif
            <br>

            <label class="mr-1"> Địa chỉ: </label>
            <label>
                <input type="text" name="address" value="{{ $each->address ?? old('address') }}" class="form-control">
            </label>
                      @if ($errors->has('address'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('address') }}
                        </span>
                      @endif
            <br>


            <button class="btn btn-success">Sửa</button>
        </div>
    </form>

@endsection

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
    <form action="{{ route('admin.customer.store') }}" method="post" style="display: table">
        @csrf
        <div class="form-group">
            <div style="display: table-row">
                <label class="mr-1"> Tên khách hàng: </label>
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
                <label class="mr-1"> Email  : </label>
                <label>
                    <input type="text" name="email" value="{{ old('email') }}" class="form-control">
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
                    <input type="number" name="phone" value="{{ old('phone') }}" class="form-control">

                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Ngày sinh: </label>
                <label>
                    <input type="date" name="birthdate" value="{{ old('birthdate') }}" class="form-control">
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
                    <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                    @if ($errors->has('address'))
                        <span class="error" style="color: red; font-size: 12px;">
                             {{ $errors->first('address') }}
                        </span>
                    @endif
                </label>

            </div>


            <button class="btn btn-success">Tạo</button>
        </div>
    </form>

@endsection

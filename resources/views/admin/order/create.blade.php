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
    <form action="{{ route('admin.order.store') }}" method="post" style="display: table">
        @csrf
        <div class="form-group">

            <div style="display: table-row">
                <label class="mr-1"> Tên khách hàng  : </label>
                <label>
                    <input type="text" name="name_customer" value="{{ old('name_customer') }}" class="form-control">
                    @if ($errors->has('name_customer'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('name_customer') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Customer ID: </label>
                <label>
                    <input type="number" min="0" name="customer_id" value="{{ old('customer_id') }}" class="form-control">
                    @if ($errors->has('customer_id'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('customer_id') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Số điện thoại: </label>
                <label>
                    <input type="number" min="0" name="phone" class="form-control" value="{{ old('phone') }}">
                    @if ($errors->has('phone'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('phone') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Địa Chỉ: </label>
                <label>
                    <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                    @if ($errors->has('address'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('address') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1">  Phương thức thanh toán: </label>
                <label>
                    <input type="text" name="payment_method" value="{{ old('payment_method') }}" class="form-control">
                    @if ($errors->has('payment_method'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('payment_method') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Trạng thái đơn hàng: </label>
                <label>
                    <input type="number" name="status" value="{{ old('status') }}" class="form-control">
                    @if ($errors->has('status'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('status') }}
                    </span>
                    @endif
                </label>
            </div>

            <div style="display: table-row">
                <label class="mr-1"> Ghi chú: </label>
                <label>
                    <textarea type="text" name="order_note" placeholder="{{ old('order_note') }}"
                              class="form-control">
                    </textarea>
                    @if ($errors->has('order_note'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('order_note') }}
                    </span>
                    @endif
                </label>

            </div>

            <div style="display: table-row">
                <label class="mr-1">Tổng tiền: </label>
                <label>
                    <input type="number" name="total_amount" value="{{ old('total_amount') }}" class="form-control">
                    @if ($errors->has('total_amount'))
                        <span class="error" style="color: red; font-size: 12px;">
                        {{ $errors->first('total_amount') }}
                    </span>
                    @endif
                </label>
            </div>
            <br>

            <button class="btn btn-success">Tạo</button>
        </div>
    </form>

@endsection

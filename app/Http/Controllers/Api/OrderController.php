<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Repositories\Eloquent\Order\OrderRepository;
use App\Repositories\Eloquent\OrderDetail\OrderDetailReposity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected $_orderRepository;
    protected $_orderDetailRepository;

    public function __construct(
        OrderRepository $orderRepository,
        OrderDetailReposity $orderDetailRepository
    )
    {
        $this->_orderRepository = $orderRepository;
        $this->_orderDetailRepository = $orderDetailRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        return $this->_orderRepository->getAll();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $result = $request->all();

        $validator = Validator::make($result, [
            'name_customer' => ['required', 'max:255'],
            'customer_id' => ['nullable'],
            'phone' => ['numeric', 'digits:10'],
            'payment_method' => ['required'],
            'address' => ['required'],
            'order_code' => ['required'],
            'order_note' => ['nullable'],
            'status' => ['required'],
            'product_id' => ['required'],
            'price' => ['required', 'numeric', 'between:0,9999999999.99'],
            'quantity' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validate failed, pls check again',
                'error' => $validator->errors()
            ], 400);
        }
//        $orderRepository = $this->_orderRepository;
        $orderModel = new Order();
        $orderDetail = new OrderDetail();
        $dataOrder = [
            'name_customer' => $result['name_customer'],
            'phone' => $result['phone'],
            'payment_method' => $result['payment_method'],
            'status' => $result['status'],
            'order_code' => $result['order_code'],
            'order_note' => $result['order_note'],
            'address' => $result['address'],
            'delete_at' => NULL
        ];
        $orderModel->fill($dataOrder);
        $orderModel->save();

        $dataOrderDetail = [
            'product_id' => $result['product_id'],
            'price' => $result['price'],
            'quantity' => $result['quantity'],
            'delete_at' => NULL
        ];

        $orderModel->orderDetails()->save($orderDetail->fill($dataOrderDetail));

        return response()->json([
            'status' => 200,
            'message' => 'Created',
            'data' => $result
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $result = $this->_orderRepository->find($id);

        if ($result){
            return response()->json([
                'status' => 200,
                'data' => $result
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Attribute not found',
        ],400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $attrById = $this->_orderRepository->find($id);

        $result = $request->all();
        if ($attrById) {
            $validator = Validator::make($result, [
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Validate failed, pls check again',
                ], 400);
            }

            $this->_orderRepository->update($id, $result);
            return response()->json([
                'status' => 200,
                'message' => 'Updated',
                'data' => $result
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Attribute not found',
        ], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $attrById = $this->_orderRepository->find($id);
        if ($attrById) {
            $this->_orderRepository->delete($id);
            return response()->json([
                'status' => 200,
                'message' => 'Deleted',
            ], 200);
        }
        return response()->json([
            'status' => 401,
            'message' => 'Attribute not found',
        ], 401);
    }
}

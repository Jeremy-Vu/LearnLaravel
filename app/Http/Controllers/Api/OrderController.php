<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistoryOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Repositories\Eloquent\Customer\CustomerRepository;
use App\Repositories\Eloquent\HistoryOrder\HistoryOrderRepository;
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
    protected $_customerRepository;
    protected $_historyRepository;


    public function __construct(
        OrderRepository $orderRepository,
        OrderDetailReposity $orderDetailRepository,
        CustomerRepository $customerRepository,
        HistoryOrderRepository $historyOrderRepository
    )
    {
        $this->_historyRepository = $historyOrderRepository;
        $this->_orderRepository = $orderRepository;
        $this->_orderDetailRepository = $orderDetailRepository;
        $this->_customerRepository = $customerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        return $this->_orderRepository->all();
    }

    public function isCustomer($bearerToken){
        $hashedReceivedToken  = hash('sha256', $bearerToken);
        $customerByToken = $this->_customerRepository->findByField('api_token', $hashedReceivedToken);

        if ($customerByToken) {
            return $customerByToken['id'];
        }
        return false;

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
            'phone' => ['numeric', 'digits:10'],
            'payment_method' => ['required'],
            'address' => ['required'],
            'order_note' => ['nullable'],
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validate failed, pls check again',
                'error' => $validator->errors()
            ], 400);
        }
        $orderModel = new Order();

        $checkCustomer = $this->isCustomer($request->bearerToken());


        $dataOrder = [
            'name_customer' => $result['name_customer'],
            'phone' => $result['phone'],
            'payment_method' => $result['payment_method'],
            'order_note' => $result['order_note'],
            'address' => $result['address'],
            'delete_at' => NULL
        ];
        if (isset($checkCustomer)){
            $dataOrder['customer_id'] = $checkCustomer;
        }else{
            $dataOrder['customer_id'] = null;
        }
        $orderDetails = $result['product_detail'];
        $dataOrder['total_amount'] = array_sum(array_column($orderDetails, 'price'));
        $orderModel->fill($dataOrder);
        $orderModel->save();

        foreach ($orderDetails as $orderDetailData) {
            $orderDetail = new OrderDetail();
            $orderDetail->product_id = $orderDetailData['product_id'];
            $orderDetail->price = $orderDetailData['price'];
            $orderDetail->quantity = $orderDetailData['quantity'];
            $orderModel->orderDetails()->save($orderDetail);
        }
        $historyOrder = new HistoryOrder();
        if (isset($checkCustomer)){
            $historyOrder->customer_id = $checkCustomer;
        }else{
            $historyOrder->customer_id = null;
        }
        $historyOrder->order_date = $orderModel->getCreatedAttribute();
        $orderModel->historyOrder()->save($historyOrder);

        $orderCode = [
            'order_code' => 'MDH-' . $orderModel->getId()
        ];
        $result= array_merge($orderCode, $result);
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
        $result = $this->_orderRepository->findById($id);

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

    public function getHistoryOrderById($id){
        $historyOrder = $this->_historyRepository->findById($id);
        if ($historyOrder) {
            return response()->json([
                'status' => 200,
                'data' => $historyOrder
            ], 200);
        }
        return response()->json([
            'status' => 401,
            'message' => 'History order not found',
        ],400);
    }


    public function getHistoryOrderByCustomer(Request $request){
        $customerId = $this->isCustomer($request->bearerToken());
        $historyOrder = $this->_historyRepository->findByField('customer_id',$customerId);
        if ($historyOrder) {
            return response()->json([
                'status' => 200,
                'data' => $historyOrder
            ], 200);
        }
        return response()->json([
            'status' => 401,
            'message' => 'History order not found',
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
        $attrById = $this->_orderRepository->findById($id);

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
        $attrById = $this->_orderRepository->findById($id);
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

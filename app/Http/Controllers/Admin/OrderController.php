<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Repositories\Eloquent\Customer\CustomerRepository;
use App\Repositories\Eloquent\Order\OrderRepository;
use App\Repositories\Eloquent\OrderDetail\OrderDetailReposity;
use App\Repositories\Eloquent\Product\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    protected $_orderRepository;
    protected $_orderDetailRepository;
    protected $_customerRepository;
    protected $_productRepository;


    public function __construct(
        OrderRepository $orderRepository,
        OrderDetailReposity $orderDetailRepository,
        CustomerRepository $customerRepository,
        ProductRepository $productRepository
    )
    {
        $this->_orderRepository = $orderRepository;
        $this->_orderDetailRepository = $orderDetailRepository;
        $this->_customerRepository = $customerRepository;
        $this->_productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $data = $this->_orderRepository->all();
        $search = $request->get('q');

//        $data = $this->_customerRepository->paginateWhere()
//            ->where('name', 'like', '%'. $search. '%')
//            ->paginate(10);

        return view('admin.order.index', [
            'data' => $data,
//            'search' => $search,
        ]);
    }

    public function orderDetail(Request $request){
        $data = $this->_orderDetailRepository->all();
        $search = $request->get('q');

//        $data = $this->_customerRepository->paginateWhere()
//            ->where('name', 'like', '%'. $search. '%')
//            ->paginate(10);

        return view('admin.orderdetail.index', [
            'data' => $data,
//            'search' => $search,
        ]);
    }

    public function isCustomer(Request $request){
        $hashedReceivedToken  = hash('sha256',$request->bearerToken());
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

//        $validator = Validator::make($result, [
//            'name_customer' => ['required', 'max:255'],
//            'phone' => ['numeric', 'digits:10'],
//            'payment_method' => ['required'],
//            'address' => ['required'],
//            'order_note' => ['nullable'],
//        ]);

//        if ($validator->fails()) {
//            return response()->json([
//                'status' => 400,
//                'message' => 'Validate failed, pls check again',
//                'error' => $validator->errors()
//            ], 400);
//        }
//        $orderModel = new Order();

        $checkCustomer = $this->isCustomer($request);

        $dataOrder = [
            'name_customer' => $result['name_customer'],
            'phone' => $result['phone'],
            'payment_method' => $result['payment_method'],
            'order_note' => $result['order_note'],
            'address' => $result['address'],
            'customer_id' => $checkCustomer ?? null
        ];

        $orderModel->fill($dataOrder);
        $orderModel->save();
        $productDetails = $result['product_detail'];

        $totalPrice = 0;
        foreach ($productDetails as $productDetail) {
            $product = $this->_productRepository->findById($productDetail['product_id']);
            if ($product) {
                if ($productDetail['quantity'] < 1){
                    $totalPrice += $product->price * 1;
                }else{
                    $totalPrice += $productDetail['quantity'] * $product->price;
                }
                $orderDetail = new OrderDetail();
                $orderDetail->product_id = $productDetail['product_id'];
                $orderDetail->price = $product->price;
                $orderDetail->quantity = $productDetail['quantity'];
                $orderModel->orderDetails()->save($orderDetail);
            }else{
                return response()->json([
                    'status' => 401,
                    'message' => 'Product không tồn tại',
                ], 401);
            }
        }
        $dataOrder['total_amount'] = $totalPrice;
        $this->_orderRepository->update($orderModel->getId(),$dataOrder);

        $orderCode = [
            'order_code' => 'MDH-' . $orderModel->getId(),
            'total_amount' => $totalPrice
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

    public function getHistoryOrderByCustomerId($id){
        $result = $this->_orderRepository->findByField('customer_id',$id);
        if ($result){
            return response()->json([
                'status' => 200,
                'data' => $result->get()
            ], 200);
        }
        return response()->json([
            'status' => 401,
            'message' => 'Customer not found',
        ],400);
    }


    public function getHistoryOrderByCustomer(Request $request){
        $result = $this->_orderRepository->findByField('customer_id', $this->isCustomer($request))->get();

        return response()->json([
            'status' => 200,
            'data' => $result
        ], 200);
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

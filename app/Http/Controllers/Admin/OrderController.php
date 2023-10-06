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
        OrderRepository     $orderRepository,
        OrderDetailReposity $orderDetailRepository,
        CustomerRepository  $customerRepository,
        ProductRepository   $productRepository
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
        $search = $request->get('q');
        $data = $this->_orderRepository->paginateWhereLikeOrderBy(['status' => 1], ['id' =>$search]);


        return view('admin.order.index', [
            'data' => $data,
            'search' => $search,
        ]);
    }

    public function orderDetail(Request $request)
    {
        $data = $this->_orderDetailRepository->all();
        $search = $request->get('q');

        return view('admin.orderdetail.index', [
            'data' => $data,
//            'search' => $search,
        ]);
    }

    public function isCustomer(Request $request)
    {
        $hashedReceivedToken = hash('sha256', $request->bearerToken());
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        return view('admin.order.create');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required',
            'customer_id' => 'nullable',
            'phone' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
            'status' => 'required',
            'order_note' => 'nullable',
            'total_amount' => 'required',
        ], [
            'name_customer.required' => 'Tên khách hàng không được trống.',
            'address.required' => 'Địa chỉ không được trống.',
            'phone.required' => 'Số điện thoại không được trống',
            'status.required' => 'Trạng thái đơn hàng không được trống',
            'payment_method.required' => 'Phương thức thanh toán không được trống.',
            'total_amount.required' => 'Tổng tiền không được trống.',
            'status.integer' => 'Trạng thái phải là một số nguyên.',

        ]);
        $data = [
            'name_customer' => $request['name_customer'],
            'customer_id' => $request['customer_id'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'payment_method' => $request['payment_method'],
            'status' => $request['status'],
            'order_note' => $request['order_note'],
            'total_amount' => $request['total_amount'],
        ];
        try {
            $this->_orderRepository->create($data);
            return redirect()->route('admin.order.index')->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something wrong');
        }
    }

    public function show($id)
    {
        $result = $this->_orderRepository->findById($id);

        if ($result) {
            return response()->json([
                'status' => 200,
                'data' => $result
            ], 200);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Attribute not found',
        ], 400);
    }

    public function getHistoryOrderByCustomerId($id)
    {
        $result = $this->_orderRepository->findByField('customer_id', $id);
        if ($result) {
            return response()->json([
                'status' => 200,
                'data' => $result->get()
            ], 200);
        }
        return response()->json([
            'status' => 401,
            'message' => 'Customer not found',
        ], 400);
    }

    public function getHistoryOrderByCustomer(Request $request)
    {
        $result = $this->_orderRepository->findByField('customer_id', $this->isCustomer($request))->get();

        return response()->json([
            'status' => 200,
            'data' => $result
        ], 200);
    }

    public function edit($id)
    {
        try {
            $orderById = $this->_orderRepository->findById($id);
            if ($orderById) {
                return view('admin.order.edit', [
                    'each' => $orderById
                ]);
            }
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.order.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
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
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $orderById = $this->_orderRepository->findById($id);
            if ($orderById) {
                $this->_orderRepository->delete($id);
                return redirect()->route('admin.order.index')->with('success', 'Xoá đơn hàng thành công');
            }
            return redirect()->back()->with('error', 'Order không tồn tại');

        } catch (\Throwable $e) {
            return redirect()->route('admin.order.index')->with('error', $e->getMessage());
        }
    }
}

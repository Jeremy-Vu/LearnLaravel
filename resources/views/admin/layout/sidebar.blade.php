<!-- ========== Left Sidebar Start ========== -->

<div class="left-side-menu">

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="assets/images/logo.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo_sm.png" alt="" height="16">
        </span>
    </a>

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="assets/images/logo-dark.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo_sm_dark.png" alt="" height="16">
        </span>
    </a>

    <div class="h-100" id="left-side-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="metismenu side-nav">

            <li class="side-nav-title side-nav-item">Quản lý sản phẩm</li>

            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span class="badge badge-success float-right"></span>
                    <span> Trang chủ </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href={{ route('admin.customer.index') }} class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Quản lý khách hàng </span>
                </a>
            </li>


            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link">
                    <i class="uil-briefcase"></i>
                    <span>Quản lý hoá đơn </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{ route('admin.order.index') }}">Hoá đơn</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orderdetail.index') }}">Chi tiết hoá đơn</a>
                    </li>
                </ul>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.product.index') }}" class="side-nav-link">
                    <i class="uil-rss"></i>
                    <span> Quản lý sản phẩm </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.category.index') }}" class="side-nav-link">
                    <i class="uil-rss"></i>
                    <span> Quản lý danh mục </span>
                </a>
            </li>
{{--            @if(checkSuperAdmin())--}}
{{--            <li class="side-nav-item">--}}
{{--                <a href="javascript: void(0);" class="side-nav-link">--}}
{{--                    <i class="uil-clipboard-alt"></i>--}}
{{--                    <span> Quản lý nhân viên </span>--}}
{{--                    <span class="menu-arrow"></span>--}}
{{--                </a>--}}
{{--                <ul class="side-nav-second-level" aria-expanded="false">--}}
{{--                    <li>--}}
{{--                        <a href="{{ route('nhan-vien.index') }}">Nhân viên</a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="{{ route('chuc-vu.index') }}">Chức vụ</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            @endif--}}


        </ul>

        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->

@include('panel.head')

<body>
<!-- Sidenav -->


@include('panel.sidebar')
<!-- Main content -->
<div class="main-content">

    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <!-- Card stats -->
                {{--@include('panel.headerbody')--}}
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
        <!-- start Card's -->
    {{--<div class="card-deck" >--}}
    {{--<div class="card">--}}
    {{--<img class="card-img-top" src="{{asset('image/1.jpg')}}" alt="Card image cap">--}}
    {{--<div class="card-body text-right">--}}
    {{--<h5 class="card-title ">رنج سنی کاربران</h5>--}}
    {{--<p class="card-text">میانگین : {{$user[0]->avg_age}}</p>--}}
    {{--<p class="card-text">بیشترین : {{$user[0]->max_age}}</p>--}}
    {{--<p class="card-text">کمترین : {{$user[0]->min_age}}</p>--}}
    {{--</div>--}}
    {{--<div class="card-footer">--}}
    {{--<small class="text-muted"></small>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="card">--}}
    {{--<img class="card-img-top" src="{{asset('image/2.jpg')}}" alt="Card image cap">--}}
    {{--<div class="card-body text-right">--}}
    {{--<h5 class="card-title ">تعداد کاربران</h5>--}}
    {{--<p class="card-text">تعداد کاربران : {{$user[0]->count}}</p>--}}

    {{--</div>--}}
    {{--<div class="card-footer">--}}
    {{--<small class="text-muted"></small>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="card">--}}
    {{--<img class="card-img-top" src="{{asset('image/3.jpg')}}" alt="Card image cap">--}}
    {{--<div class="card-body text-right">--}}
    {{--<h5 class="card-title ">وزن کاربران</h5>--}}
    {{--<p class="card-text">میانگین : {{$weight[0]->avg}}</p>--}}
    {{--<p class="card-text">بیشترین : {{$weight[0]->max}}</p>--}}
    {{--<p class="card-text">کمترین : {{$weight[0]->min}}</p>--}}
    {{--</div>--}}
    {{--<div class="card-footer">--}}
    {{--<small class="text-muted"></small>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="card-deck mt-5">--}}
    {{--<div class="card">--}}
    {{--<img class="card-img-top" src="{{asset('image/4.jpg')}}" alt="Card image cap">--}}
    {{--<div class="card-body text-right">--}}
    {{--<h5 class="card-title ">طول دوره</h5>--}}
    {{--<p class="card-text">میانگین : {{$user[0]->avg_period_time}}</p>--}}
    {{--<p class="card-text">بیشترین : {{$user[0]->max_period_time}}</p>--}}
    {{--<p class="card-text">کمترین : {{$user[0]->min_period_time}}</p>--}}
    {{--</div>--}}
    {{--<div class="card-footer">--}}
    {{--<small class="text-muted"></small>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="card">--}}
    {{--<img class="card-img-top" src="{{asset('image/5.jpg')}}" alt="Card image cap">--}}
    {{--<div class="card-body text-right">--}}
    {{--<h5 class="card-title ">فاصله بین دوره</h5>--}}
    {{--<p class="card-text">میانگین : {{$user[0]->avg_between_period}}</p>--}}
    {{--<p class="card-text">بیشترین : {{$user[0]->max_between_period}}</p>--}}
    {{--<p class="card-text">کمترین : {{$user[0]->min_between_period}}</p>--}}
    {{--</div>--}}
    {{--<div class="card-footer">--}}
    {{--<small class="text-muted"></small>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="card">--}}
    {{--<img class="card-img-top" src="{{asset('image/6.jpg')}}" alt="Card image cap">--}}
    {{--<div class="card-body text-right">--}}
    {{--<h5 class="card-title ">سندروم پیش از قاعدگی</h5>--}}
    {{--<p class="card-text">میانگین : {{$user[0]->avg_period_syndrome}}</p>--}}
    {{--<p class="card-text">بیشترین : {{$user[0]->max_period_syndrome}}</p>--}}
    {{--<p class="card-text">کمترین : {{$user[0]->min_period_syndrome}}</p>--}}
    {{--</div>--}}
    {{--<div class="card-footer">--}}
    {{--<small class="text-muted"></small>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}


    <!-- end Card's -->
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">مشخصات کاربر</h3>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.products.update',['product'=>$product->id])}}">
                        {!! csrf_field() !!}
                        @method('PUT')
                        <div class="col">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">نام کاربری</label>
                                        <input type="text" name="user_name" id="input-username"
                                               class="form-control form-control-alternative" placeholder="Username"
                                               value="{{$product->user->name}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">نام محصول</label>
                                        <input type="text" name="name" id="input-product_name"
                                               class="form-control form-control-alternative" placeholder="product_name"
                                               value="{{$product->name}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone">تاریخ خرید</label>
                                        <input type="text" name="purchase_date" id="purchase_date"
                                               class="form-control form-control-alternative "
                                               value="{{$product->purchase_date}}" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone">شماره کارانتی</label>
                                        <input type="text" name="warranty_number" id="warranty_number"
                                               class="form-control form-control-alternative "
                                               value="{{$product->warranty_number}}" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone">تاریخ پایان گارانتی</label>
                                        <input type="text" name="end_date_of_warranty" id="end_date_of_warranty"
                                               class="form-control form-control-alternative "
                                               value="{{$product->end_date_of_warranty}}" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone">شماره فاکتور</label>
                                        <input type="text" name="factor_number" id="input-factor_number"
                                               class="form-control form-control-alternative "
                                               value="{{$product->factor_number}}" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone">شماره فروشنده</label>
                                        <input type="text" name="seller_phone" id="input-phone"
                                               class="form-control form-control-alternative "
                                               value="{{$product->seller_phone}}" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4"/>
                        <button href="#!" class="btn btn-info">ویرایش</button>
                    </form>

                </div>
            </div>
        </div>
        <!-- Footer -->
        {{--@include('panel.footer')--}}
    </div>
</div>

<!-- Argon Scripts -->
@include('panel.footer_scripts')
</body>

</html>
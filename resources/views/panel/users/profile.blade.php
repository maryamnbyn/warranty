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
    <div class="rtl">
    <div class="container-fluid mt--7">

        <!-- Table -->
        <div class="row">
            <div class="col">
                <div class=" card-user">
                    <img  class="card-body" src="/picture/upload/1.png" alt="John" style="width:100%">

                    <p class="title">{{$user->name}}</p>
                    <p>{{$user->phone}}</p>

                    <p><a href="{{ route('admin.users.edit',['user' =>$user->id ])  }}">ویرایش کاربر</a></p>
                    {{--<p><a href="{{ route('admin.user.message',['user' =>$user->id ])  }}">ارسال پیام</a></p>--}}
                </div>
            </div>
            <div class="col">
                {{--<div class="card shadow">--}}
                    <div class="card-header border-0">
                        <h3 class="mb-0">لیست محصولات کاربر</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">شناسه</th>
                                <th scope="col">نام محصول</th>
                                <th scope="col">شماه گارانتی</th>
                                <th scope="col">تاریخ خرید</th>
                                <th scope="col">تاریخ پایان گارانتی</th>
                                <th scope="col">شماره فروشنده</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>

                                @foreach($products as $product)

                                    <th scope="row">
                                        <div class="media align-items-center">
                                            {{--<a href="#" class="avatar rounded-circle mr-3">--}}
                                            {{--<img alt="Image placeholder" src="../assets/img/theme/bootstrap.jpg">--}}
                                            {{--</a>--}}
                                            <div class="media-body">
                                                <span class="mb-0 text-sm">{{$product['id']}}</span>
                                            </div>
                                        </div>
                                    </th>


                                    <td>
                      <span class="badge badge-dot mr-4">
                        <i class="bg-warning"></i>   {{$product['name']}}
                      </span>
                                    </td>
                                    <td>
                                        {{$product['warranty_number']}}
                                    </td>
                                    <td>
                                        {{$product['purchase_date']}}
                                    </td>
                                    <td>
                                        {{$product['end_date_of_warranty']}}
                                    </td>
                                    <td>
                                        {{$product['seller_phone']}}
                                    </td>



                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <form action="{{ route('admin.products.destroy',['user' =>$product->id ]) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item" href="#"
                                                            onClick="deleteme({{$product->id}})">حذف
                                                    </button>
                                                    <a class="dropdown-item"
                                                       href="{{ route('admin.products.edit',['products' =>$product->id ])  }}">ویرایش</a>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <script language="javascript">
                                        function deleteme(id) {
                                            if (confirm("Do you want Delete!")) {
                                                window.location.href = 'products.destroy?del=' + id + '';
                                                return true;
                                            }
                                        }
                                    </script>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{--<div class="card-footer py-4">--}}
                    {{--<nav aria-label="...">--}}
                    {{--<ul class="pagination justify-content-end mb-0">--}}
                    {{--<li class="page-item disabled">--}}
                    {{--<a class="page-link" href="#" tabindex="-1">--}}
                    {{--<i class="fas fa-angle-left"></i>--}}
                    {{--<span class="sr-only">Previous</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="page-item active">--}}
                    {{--<a class="page-link" href="#">1</a>--}}
                    {{--</li>--}}
                    {{--<li class="page-item">--}}
                    {{--<a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>--}}
                    {{--</li>--}}
                    {{--<li class="page-item"><a class="page-link" href="#">3</a></li>--}}
                    {{--<li class="page-item">--}}
                    {{--<a class="page-link" href="#">--}}
                    {{--<i class="fas fa-angle-right"></i>--}}
                    {{--<span class="sr-only">Next</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                    {{--</nav>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
        <!-- Dark table -->

        <!-- Footer -->

    </div>
</div>
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
<!-- Footer -->
@include('panel.footer')
</div>
</div>

<!-- Argon Scripts -->
@include('panel.footer_scripts')
</body>

</html>
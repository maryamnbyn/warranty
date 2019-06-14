
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

    <!-- start Chart -->
    <div class="container-fluid mt--7">
        <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card bg-gradient-white shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                        </div>
                        <div class="col text-right" dir="rtl">
                            <h6 class="text-uppercase text-darker ls-1 mb-1">نمودار خطی ای</h6>
                            <h2 class="text-dark mb-0">میانگین زمان خواب کاربران</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <!-- Chart wrapper -->
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>

        <!-- End Chart -->

        <!-- Start Table -->

        <div class="row mt-5">
            <div class="col">

                <a class="card shadow mb-2" href="{{"route('excel_age')"}}">
                    <button class="btn btn-icon btn-3 btn-primary" type="button">
                        <span class="btn-inner--icon"><i class="ni ni-cloud-download-95"></i></span>
                        <span class="btn-inner--text">دانلود اطلاعات</span>
                    </button>
                </a>

                <div class="card shadow" dir="rtl">
                    <div class="card-header border-0 text-right">
                        <h3 class="mb-0">مانگین زمان خواب کاربران</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-right table-flush pr-5">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">تاریخ</th>
                                <th scope="col">زمان (ساعت)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($info as $inf)
                                <tr>
                                    <td>
                                        {{$inf->label}}
                                    </td>
                                    <td>
                                        {{$inf->hour_sleep}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <div class="pagination justify-content-center">
                            {{$info->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Table -->
    </div>




    <!-- Footer -->
    @include('panel.footer')
</div>
</div>

<!-- Argon Scripts -->

@include('panel.footer_scripts')
{!! $chart->script() !!}
</body>

</html>
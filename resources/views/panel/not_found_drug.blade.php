
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

        <!-- Start Table -->
        <form action="{{url('admin/drugs')}}" method="GET" class="navbar-search navbar-search-dark form-inline mr-sm-3 mb-2" dir="rtl" id="navbar-search-main">
            <div class="form-group mb-0">
                <div class="input-group input-group-alternative input-group-merge">
                    <div class="input-group-prepend">
                        <button type="submit" class="input-group-text"><i class="fas fa-search"></i></button>
                    </div>
                    <input name="search" class="form-control" placeholder="جستجوی دارو" type="text">
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col">
                <div class="card shadow" dir="rtl">
                    <div class="card-header border-0 text-right">
                        <h3 class="mb-0">دارویی با اطلاعت وارد شده یافت نشد!</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-right table-flush pr-5">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">نام دارو</th>
                                <th scope="col">تعداد مصرف</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <div class="pagination justify-content-center">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Table -->

        <!-- Footer -->
        @include('panel.footer')
    </div>
</div>

<!-- Argon Scripts -->
@include('panel.footer_scripts')
</body>

</html>
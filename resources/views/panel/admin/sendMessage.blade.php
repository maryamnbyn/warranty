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

    <!-- end Card's -->
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">ارسال پیام</h3>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    @if(count($errors))
                        <div class="alert alert-danger">
                            <ui>
                                @foreach($errors->all() as $error)
                                    <li> {{$error}}</li>
                                @endforeach
                            </ui>
                        </div>
                    @endif
                    <form method="post"
                          action="{{route('admin.send.message',['user'=>$user->id])}}">
                        @csrf
                        <div class="col">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">پیام</label>
                                        <input type="textarea" name="message" id="input-username"
                                               class="form-control form-control-alternative" placeholder="متن پیام"
                                               value="">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr class="my-4"/>
                        <button href="#!" class="btn btn-info">ارسال</button>
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
<nav class="nav navbar navbar-expand-lg navbar-light bg-light">
    {{--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"--}}
            {{--aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">--}}
        {{--<span class="navbar-toggler-icon"></span>--}}
    {{--</button>--}}

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto pr-3">
            {{--<li class="nav-item active">--}}
                {{--<a class="nav-link" href="/"> خانه <span class="sr-only">(current)</span></a>--}}
            {{--</li>--}}


        </ul>
        <ul class=" navbar-nav pr-3 a">
            {{--@if(Auth::check())--}}

                {{--<li>--}}
                    <form action="{{route('logout')}}" method="post">
                        {!! csrf_field() !!}
                        <button class="logout-btn" style="margin-left: 10px">پنل کاربری</button>
                    </form>
                {{--</li>--}}
                {{--@if(Auth::admin()->role == 'admin')--}}
                    {{--<li>--}}
                        {{--<a href="/admin/dashboard" style="margin-left: 10px">ادمین پنل</a>--}}
                    {{--</li>--}}


                {{--@endif--}}
            {{--@endif--}}

        </ul>
    </div>
</nav>

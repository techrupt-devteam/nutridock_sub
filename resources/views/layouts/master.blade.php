@if(Session::get('subscriber_id'))
    @include('layouts.subscriber_header')
@else
    @include('layouts.header')
@endif
  
    @yield('content')

@include('layouts.footer')
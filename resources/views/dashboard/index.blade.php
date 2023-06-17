@extends('layouts.admin')
@section('content')
<div class="container-fluid">
@if (\auth()->user()->is_admin == 1)
    @include('partials.dashboardAdmin')
@else
@include('partials.dashboardMember')
@endif
</div>
@endsection




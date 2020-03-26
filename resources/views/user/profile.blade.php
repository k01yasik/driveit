@extends('layouts.profile')

@section('content')
    <div class="row">
        <div class="col s12 m4 l4 sm-margin-bottom-2 profile-block">
            @include('components.profile')
        </div>
        <div class="col s12 m8 l8">
            <div class="user-profile-content">

            </div>
        </div>
    </div>
@endsection
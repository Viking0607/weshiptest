@extends('layout.main')

@section('title', 'Регистрация')

@section('content')

<div class="col-xs-12">
    <h2 class="text-center">Register extracted items as a new package</h2>
    <div class="col-xs-12 text-center">
        <h3>Extracted from</h3>
        <h4>{{$user->name}} {{$user->surname}}</h4>
        <h4>{{ $parcel->track }}</h4>
        <h4>{{ $parcel->shop }}</h4>
    </div>
    <hr>
</div>

<div class="col-xs-12 col-md-6">
    <form id="registration_perhibition" action="/create_prohibited" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="weight">Weight, lbs</label>
            <input type="text" class="form-control" name="weight" value="">
            <input type="hidden" name="parcel" value="{{ $parcel->track }}" >
            <input type="hidden" name="user" value="{{ $user->id }}" >
        </div>

        <div class="form-group">
          <label for="image">Image input</label>
          <input type="file" id="image" name="image">
        </div>

        <input type="submit" class="btn btn-success registration" value="Зарегестрировать" disabled="disabled"/>

        <div class="prohibition-error prohibition-error-display alert alert-dismissible alert-warning" >
            <span></span>
        </div>
    </form>
</div>

@endsection

@section('JavaScript')
    <script src="{{ asset('js/prohibition.js') }}"></script>
@endsection

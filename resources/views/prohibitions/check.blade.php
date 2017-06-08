@extends('layout.main')

@section('title', 'Проверка')

@section('content')

<div class="col-xs-12">
    <h2 class="section-title text-center">Extraction prohibited items</h2>
    <hr>
</div>

<div class="col-xs-12 col-md-6">
    <form id="check_tracking" action="check_tracking" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="tracking">Shipment number</label>
            <input type="text" class="form-control" name="tracking" placeholder="Enter or scan shipment number. example:e12345-6789" />
        </div>
        <input type="submit" class="btn btn-success" value="Check" />
    </form>

    @if(session()->has('message'))
        <div class="prohibition-error alert alert-dismissible alert-{{ session('message.level') }}" >
            <span> {!! session('message.content') !!} </span>
        </div>
    @endif
</div>

@endsection

@section('JavaScript')
    <script src="{{ asset('js/prohibition.js') }}"></script>
@endsection

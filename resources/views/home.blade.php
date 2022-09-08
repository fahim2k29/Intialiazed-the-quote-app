@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Quotes') }}</div>

                <div class="card-body">
                    <ul>
                        @foreach($data as $quote)
                            <li>{{$quote}}</li>
                        @endforeach
                    </ul>
                    <div>
                        <button onClick="history.go(0);" class="btn btn-primary">Refresh</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

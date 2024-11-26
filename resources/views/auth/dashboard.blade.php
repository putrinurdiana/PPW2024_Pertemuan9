@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @elseif ($message = Session::get('error'))
                    <div class="alert alert-error">
                            {{ $message }}
                    </div>
                @else
                    <div class="alert alert-success">
                        You are logged in!
                    </div>       
                @endif    
                <a href="{{route('buku.index')}}" class="btn btn-primary">Book</a>            
            </div>
            
        </div>
    </div>    
</div>
    
@endsection
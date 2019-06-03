@extends('layouts.error')

@section('content')
    <h1 class="font-s128 font-w300 text-city animated flipInX">404</h1>
    <h2 class="h3 font-w300 push-50 animated fadeInUp">We are sorry but the page you are looking for was not
        found..</h2>
    <form class="form-horizontal push-50 animated fadeInUp" action="/items" method="get">
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="input-group input-group-lg">
                    <input class="form-control" type="text" name="q" placeholder="Search marketplace..">
                    <div class="input-group-btn">
                        <button class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
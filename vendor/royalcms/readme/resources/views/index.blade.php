@extends('readme::layout')

@section('packageName', $packageName)

@section('packageList')
    @foreach($packages as $key => $package)
        <h2>{{$key}}</h2>
        <ul>
        @foreach($package as $package => $param)
            <li><a href="{{route('readme.index', $param)}}">{{$package}}</a></li>
        @endforeach
        </ul>
    @endforeach
@endsection

@section('docs')
    <h1>{{$packageName}}</h1>
    {!! $docs !!}
@endsection
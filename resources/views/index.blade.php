
@extends('layouts.main')

@section('title', 'Home')

@section('content')
    @include('sections.hero')
    @include('sections.about')
    @include('sections.benefits')
    @include('sections.events')
    @include('sections.founders')
    @include('sections.coverage')
@endsection
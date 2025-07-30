
@extends('layouts.website')

@section('title', 'Home')

@section('content')
    @include('website.sections.hero')
    @include('website.sections.about')
    @include('website.sections.benefits')
    @include('website.sections.events')
    @include('website.sections.founders')
    @include('website.sections.coverage')
@endsection
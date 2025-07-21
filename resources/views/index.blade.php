
@extends('layouts.main')

@section('title', 'home')

@section('content')
    @include('sections.hero')
    @include('sections.about')
    @include('sections.benefits')
    @include('sections.events')
    @include('sections.founders')
    @include('sections.coverage')
    @include('sections.newsletter')
@endsection
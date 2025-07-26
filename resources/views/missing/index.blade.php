@extends('layout.with-main')

@section('title')
    <title>Missing Media</title>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb--active">Missing Media</li>
@endsection

@section('page', 'page__missing--index')

@section('main')
    @livewire('missing-media-search')
@endsection

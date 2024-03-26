@extends('layouts.app')
@section('title', 'Modifica Progetto')
@section('content')
<header>
    <h1>Modifica Progetto</h1>
</header>

@include('includes.projects.form')
@endsection
@section('scripts')
    @vite('resources/js/image_preview.js')
@endsection
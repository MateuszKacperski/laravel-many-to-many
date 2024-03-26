@extends('layouts.app')
@section('title', 'Crea Post')
@section('content')
<header>
    <h1>Nuovo Post</h1>
</header>

@include('includes.projects.form')
@endsection
@section('scripts')
    @vite('resources/js/image_preview.js')
@endsection
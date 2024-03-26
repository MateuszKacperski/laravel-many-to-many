@extends('layouts.app')
@section('title', 'home')
@section('content')
<header>
    <h1>Projects</h1>
    <h3>Scopri i miei progetti</h3>
    @if($projects->hasPages())
    {{$projects->links()}}
    @endif
</header>

@forelse ($projects as $project)
<div class="card my-5">
    <div class="card-header d-flex align-items-center justify-content-between">
        {{$project->title}}
        <a href="{{route('guest.projects.show', $project->slug)}}" class="btn btn-sm btn-primary">Vedi</a>
    </div>
    <div class="card-body">
        <div class="row">
            @if($project->image)
            <div class="col-3">
                <img src="{{$project->image}}" alt="{{$project->title}}">
            </div>
            @endif
            <div class="col">
                <h5 class="card-title">{{$project->title}}</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary">{{$project->created_at}}</h6>
                <p class="card-text">{{$project->content}}</p>
            </div>
        </div>
            
     </div>
</div>
@empty
    <h3>Non ci sono progetti</h3>
@endforelse

@endsection
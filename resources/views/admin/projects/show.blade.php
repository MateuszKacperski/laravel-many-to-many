@extends('layouts.app')

@section('title', 'Projects')

@section('content')

<header>
    <h1 class="mt-4 mb-1">{{$project->title}}</h1>

    <h4>Tipo: @if($project->type) <span class="badge" style="background-color: {{$project->type->color}}">{{$project->type->lable}}</span>  @else Nessun @endif</h4>
</header>

<div class="clearfix">
    @if($project->image)
    <img src="{{asset('storage/' . $project_img)}}" alt="{{$project->title}}" class="me-2 float-start">
    @endif
<p>{{$project->content}}</p>
<div>
    <strong>Creato il:</strong>{{ $project->getFormatedDate('created_at', 'd-m-Y H:i:s')}}
    <strong>Ultima modifica:</strong>{{ $project->getFormatedDate('updated_at', 'd-m-Y H:i:s')}}
</div>
</div>

<footer class="d-flex justify-content-between align-items-center">
    <a href="{{route('admin.projects.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> indietro</a>

    <div class="d-flex justify-content-between gap-2">
        <a href="{{route('admin.projects.edit', $project)}}" class="btn btn-warning"> <i class="fas fa-pencil me-2"></i>Modifica</a>
       <form action="{{route('admin.projects.destroy', $project)}}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-can me-2"></i>Elimina</button>
       </form>
    </div>
</footer>

@endsection


@section('scripts')
      @vite('resources/js/delete_confermation.js')
@endsection
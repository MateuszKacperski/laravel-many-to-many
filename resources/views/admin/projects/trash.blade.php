@extends('layouts.app')

@section('title', 'Projects')

@section('content')

<header class="d-flex align-tiem-center justify-content-between">
    <h1>Progetti eliminati</h1>
</header>



    <table class="table table-dark table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Titolo</th>
            <th scope="col">Slug</th>
            <th scope="col">Stato</th>
            <th scope="col">Creato il</th>
            <th scope="col">Ultima modifica</th>
            <th>
              <div class="d-flex justify-content-end gap-2">
                <a href="{{route('admin.projects.index')}}" class="btn btn-warning">Vedi post attivi</a>
                <a href="" class="btn btn-danger"><i class="fas fa-tash me-2"></i>Svuota cestino </a>
              </div>
          </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
            <tr>
              <th scope="row">{{$project->id}}</th>
              <td>{{ $project->title }}</td>
              <td>{{ $project->slug }}</td>
              <td>{{ $project->is_published ? 'Pubblicata' : 'Bozza' }}</td>
              <td>{{ $project->getFormatedDate('created_at')}}</td>
              <td>{{ $project->getFormatedDate('updated_at')}}</td>
              <td>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{route('admin.projects.show', $project)}}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>

                    <a href="{{route('admin.projects.edit', $project)}}" class="btn btn-sm btn-warning"> <i class="fas fa-pencil"></i></a>
                    <form action="{{route('admin.projects.drop', $project)}}" method="POST" class="delete-form">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-can"></i></button>
                    </form>

                    <form action="{{route('admin.projects.restore', $project)}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-arrows-rotate"></i></button>
                       </form>

                 </td> 
                </tr>
                </div>

            @empty

            <tr>
                <td colspan="7">
                    <h3 class="text-center">Non ci sono progetti</h3>
                </td>
            </tr>

            @endforelse
        </tbody>
      </table>
@endsection

@section('scripts')
      @vite('resources/js/delete_confermation.js')
@endsection
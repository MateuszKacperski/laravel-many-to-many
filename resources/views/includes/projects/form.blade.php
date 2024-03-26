@if ($project->exists)
    <form action="{{route('admin.projects.update', $project)}}" enctype="multipart/form-data" method="POST">
    @method('PUT')
@else
    <form action="{{route('admin.projects.store')}}" enctype="multipart/form-data" method="POST">
@endif

    @csrf
    <div class="rov">
        <div class="col-6">
            <div class="mb-3">
                <label for="title" class="form-label">Titolo</label>
                <input type="text" class="form-control @error('title') is-invalid @elseif(old('title', '')) is-valid @enderror" id="title" name="title" placeholder="Titolo" value="{{old('title', $project->title)}}">
                @error('title')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @else
                <div class="form-text">
                    Inserisci il titolo del post
                </div>
                @enderror
              </div>
        </div>
              <div class="col-6">
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" value="{{Str::slug(old('title', $project->title))}}" disabled>
                </div>
              </div>
        <div class="col-12">
            <div class="mb-3">
                <label for="content" class="form-label">Contenuto Progetto</label>
                <textarea class="form-control @error('content') is-invalid @elseif(old('content', '')) is-valid @enderror" id="content" rows="10" name="content">
                    {{old('content', $project->content)}}
                </textarea>
                @error('content')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @else
                <div class="form-text">
                    Inserisci il contenuto
                </div>
                @enderror
              </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
            <label for="type_id" class="form-label">Seleziona Tipo</label>
            <select class="form-select @error('type_id') is_invalid @elseif(old('type_id', '')) is_valid @enderror" id="type_id" name="type_id">
                <option value="">Nessuno</option>
                @foreach ($types as $type)
                    <option value="{{$type->id}}" @if (old('type_id', $project->type?->id) == $type->id) selected @endif>{{$type->label}}</option>
                @endforeach
              </select>
              @error('type_id')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>
        <div class="col-5">
            <div class="mb-3">
                <label for="image" class="form-label">Immagine</label>
                <input type="file" class="form-control @error('image') is-invalid @elseif(old('image', '')) is-valid @enderror" id="image" name="image" placeholder="http:// o https://"
                value="{{old('image', $project->image)}}">
              </div>
              @error('image')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @else
              <div class="form-text">
                  Carica un file immagine
              </div>
              @enderror
        </div>
        <div class="col-1">
            <div class="mb-3">

                <div class="input-group">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon1">Button</button>
                    <input type="text" class="form-control">
                  </div>

            <img src="{{old('image', $project->image) ? asset('storage/' . $project_img)
            : 'https://marcolanci.it/boolean/assets/placeholder.png'}}" class="img-fluid" alt="immagine Progetto" id="preview">
           
        
        
        
        
        
        
        </div>
        </div>
        <div class="col-12 d-flex justify-content-end">
            <div class="form-check">
                <input class="form-check-input" type="checkbox"  id="is_published" name="is_published" value="1" @if(old('is_published', $project->is_published)) checked @endif>
                <label class="form-check-label" for="is_published">
                  Publicato
                </label>
              </div>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{route('admin.projects.index')}}" class="btn btn-primary">Torna Indietro</a>
    
        
    <div class="d-flex align-items-center gap-2">
        <button type="reset" class="btn btn-secondary"><i class="fas fa-eraser me-2"></i>Svuota i campi</button>
        <button type="submit" class="btn btn-success"><i class="fas fa-floppy-disk me-2"></i>Salva</button>
    </div>
</div>
</form>
@section('scripts')
@vite('resources/js/image_preview.js')
<script>
    const titleField = document.getElementById('title');
    const slugField = document.getElementById('slug');

    titleField.addEventListener('blur', () => {
        slugField.value = titleField.value.trim().toLoverCase().split(' ').join('-');
    })
</script>
@endsection
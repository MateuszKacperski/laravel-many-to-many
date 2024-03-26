<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tecnology;
use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter');
        $query = Project::orderByDesc('updated_at')->orderByDesc('created_at');
        if($filter){
            $value = $filter === 'published';
            $query->whereIsPublished($value);
        }
        $projects = $query->paginate(10)->withQueryString();
        return view('admin.projects.index', compact('projects', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        $types = Type::selected('label', 'id')->get();
        $tecnologies = Tecnology::selected('label', 'id')->get();
        return view('admin.projects.create', compact('project', 'types', 'tecnologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|min:5|max:50|unique:projects',
            'content' => 'required|string',
            'image' => 'nullable|image',
            'is_published' => 'nullable|boolean',
            'type_id' => 'nullabe|exists:types,id',
            'tecnologies' => 'nullable|exist:tecnologies,id'
        ],[
            'title.required' => 'Il titolo e obligatorio',
            'content.reqwuire' => 'La descrizione e obligatoria',
            'title.min' => 'Il titolo e troppo corto',
            'title.max' => 'Il titolo e troppo lungo ',
            'title.unique' => 'Il titolo deve essere univoco',
            'image.image' => 'Il file inserito non e un immagine',
            'is_published.boolean' => 'Il valore del campo publicazione non e valido',
            'type_id.exists' => 'Tipo non valido',
            'tecnologies.exists' => 'Tecnologie selezionate non valide'
        ]);

        $data = $request->all();

        $project = new Project();

        $project->fill($data);

        $project->slug = Str::slug($project->title);

        $project->is_published = Arr::exists($data, 'is_published');

        // controllo se arriva un file
        if(Arr::exists($data, 'image')){
            $extension = $data['image']->extension();  //restituisce l`estensiopne senza il punto esempio png
            //Lo salvo e prendo l`url
           $img_url = Storage::putFileAs('project_images', $data['image'], "$project->slug.$extension");
           $project->image = $img_url;
        }
   


        $project->save();

        if(Arr::exists($data, 'tecnologies')){
            $project->tecnologies()->attach($data ['tecnologies']);
        }
       

        return to_route('admin.projects.show', $project->id)->with('messager', 'Post creato con sucesso')->wtih('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {

        $prev_tecnologies = $project->tecnologies->pluck('id')->toArray();


        $tecnologies = Tecnology::selected('label', 'id')->get();
        $types = Type::selected('label', 'id')->get();
        return view('admin.projects.edit', compact('project', 'types', 'tecnologies', 'prev_tecnologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
 
        $data = $request->validate([
           'title' => ['required', 'string', 'min:5', 'max:50', Rule::unique('projects')->ignore($project->id)],
            'content' => 'required|string',
            'image' => 'nullable|image',
            'is_published' => 'nullable|boolean',
            'type_id' => 'nullabe|exists:types,id',
            'tecnologies' => 'nullable|exist:tecnologies,id'
        ],[
            'title.required' => 'Il titolo e obligatorio',
            'content.reqwuire' => 'La descrizione e obligatoria',
            'title.min' => 'Il titolo e troppo corto',
            'title.max' => 'Il titolo e troppo lungo ',
            'title.unique' => 'Il titolo deve essere univoco',
            'image.image' => 'Il file inserito non e un immagine',
            'is_published.boolean' => 'Il valore del campo publicazione non e valido',
            'type_id.exists' => 'Tipo non valido',
            'tecnologies.exists' => 'Tecnologie selezionate non valide'
        ]);

        $data = $request->all();



        
        $project->slug = Str::slug($project->title);

        $project->is_published = Arr::exists($data, 'is_published');

        if(Arr::exists($data, 'image')){
            //Controllo se aveva gia un immagine  e lo cancello
            if($project->image) Storage::delete($project->image);
            //Lo salvo e prendo l`url
           $img_url = Storage::putFile('project_images', $data['image']);
           $project->image = $img_url;
        }
        
        $project->update($data);

        if(Arr::exists($data, 'tecnologies')) $project->tecnologies()->sync($data ['tecnologies']);
        elseif(!Arr::exists($data, 'tecnologies') && count($project->tecnologies))$project->tecnology()->detach();
        

        return to_route('admin.projects.show', $project)->with('message', 'Progetto creato con sucesso')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.projects.index')
        ->with('toast-button-type', 'success')
        ->with('toast-message', 'Eliminato con sucesso')
        ->with('toast-label', config('app.name'))
        ->with('toast-method', 'PATCH')
        ->with('toast-route', route('admin.projects.restore', $project->id))
        ->with('toast-button-label', 'Anulla');
    }

    public function trash(){
        $projects = Project::onlyTrashed()->get();
        return view('admin.projects.trash', compact('projects'));
    }
    public function restore(Project $project){
        $project->restore();
        return to_route('admin.projects.index')->with('type', 'success')->with('message', 'Progetto ripristinato con sucesso');
    }
    public function drop(Project $project){

        if($project->has('tecnologies')) $project->tecnologies()->detach();
        if($project->image) Storage::delete($project->image);
        $project->forceDelete();
        return to_route('admin.projects.trash')->with('type', 'warning')->with('message', 'Eliminato definitivamente');
    }
}
    

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;// trait
use Livewire\WithPagination;// trait
use Illuminate\Support\Facades\Storage;// manejar imagenes
class Categories extends Component
{
    public $name, $search, $image, $selected_id, $pageTitle, $componentName, $customFileName;
    private $pagination = 5;

    use WithFileUploads;
    use WithPagination;

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorías';
    }


    public function  paginationView(){
        return 'vendor.livewire.bootstrap';
    }


    public function render()
    {
        if(strlen($this->search) > 0)
            $data = Category::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Category::orderBy('id', 'desc')->paginate($this->pagination);


        return view('livewire.category.categories', ['categories' => $data])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    //metedo para editar las categorias
    public function Edit($id){
        $record = Category::find($id, ['id','name','image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');

    }


    public function Store(){
        $rules = [
            'name' => 'required|unique:categories|min:3'
        ];

        $messages = [
            'name.required' => 'EL NOMBRE DE LA CATEGORIA ES REQUERIDO',
            'name.unique' => 'YA EXISTE EL NOMBRE DE LA CATEGORIA',
            'name.min' => 'EL NOMBRE DE LA CATEGORIA DEBE TENER AL MENOS 3 CARACTERES'
        ];
        $this->validate($rules, $messages);

        $category = Category::create([
            'name' => $this->name
        ]);

        $customFileName;
        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categorias', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }

        $this->resetUI();
        $this->emit('category-added', 'Categoria Registrada');

    }

    //metodo para actualizar una categoria
    public function Update()
    {
        $rules = [
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}"
        ];
        $messages = [
            'name.required' => 'NOMBRE DE LA CATEGORIA REQUERIDO',
            'name.min' => 'EL NOMBRE DE LA CATEGORIA DEBE TENER AL MENOS 3 CARACTERES',
            'name.unique' => 'EL NOMBRE DE LA CATEGORIA YA EXISTE'
        ];

        $this->validate($rules, $messages);

        $category = Category::find($this->selected_id);
        $category->update([
            'name' => $this->name
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categorias', $customFileName);
            $imageName = $category->image;

            $category->image = $customFileName;
            $category->save();

            if($imageName != null)
            {
                if(file_exists('storage/categorias' . $imageName))
                {
                    unlink('storage/categorias' . $imageName);
                }
            }            
        }
        $this->resetUI();
        $this->emit('category-updated', 'Categoria Actualizada');
    }


    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Category $category){

        $imageName = $category->image;
        $category->delete();
        if($imageName != null) {
            unlink('storage/categorias/' . $imageName);
        }

        $this->resetUI();
        $this->emit('category-deleted', 'Categoria Eliminada');

    }


    public function resetUI(){
        $this->name ='';
        $this->image = null;
        $this->search ='';
        $this->selected_id = 0;

    }
}

<?php

namespace App\Http\Livewire\Carrers;

use Livewire\Component;
use App\Carrera;
use Illuminate\Support\Facades\DB;
use App\Students;

class CarrersComponent extends Component
{
    public $carreraId;
    public $racer_name;
    public $description;
    public $carrera, $view_id, $view_carrera_racer_name, $view_carrera_description;
    public $availableStudents = [];
    public $studentIds = '';


    //modal views *Desactivado*
    public function viewCarrersDetails($carreraId)
    {
        $this->carrera = Carrera::find($carreraId);

        //dd($carreraId);
        $this->view_id = $this->carrera->id;
        $this->view_carrera_racer_name = $this->carrera->racer_name;
        $this->view_carrera_description = $this->carrera->description;
    }

    public function closeViewCarreraModal()
    {
        $this->view_id = '';
        $this->view_carrera_racer_name = '';
        $this->view_carrera_description = '';
    }

    //modal editar
    public function editCarrera($carreraId)
    {
        $this->carrera = Carrera::find($carreraId);

        if ($this->carrera) {
            $this->racer_name = $this->carrera->racer_name;
            $this->description = $this->carrera->description;
        } else {
            // Manejar el caso en que la carrera no se encontró
            // Por ejemplo, puedes mostrar un mensaje de error
            session()->flash('message', 'Error');
        }
    }

    public function editCarreraData()
    {
        $this->validate([
            'racer_name' => 'required',
            'description' => 'required',
        ]);

        $this->carrera->racer_name = $this->racer_name;
        $this->carrera->description = $this->description;

        $this->carrera->save();

        session()->flash('message', 'Actualizado correctamente');

        // Ocultar el modal después de actualizar correctamente
        $this->dispatchBrowserEvent('close-modal');
    }

    public $carrers;
    public function mount()
    {
        $this->carrers = DB::table('careers')
            ->select('careers.*', DB::raw('(SELECT COUNT(*) FROM students WHERE careers.id = students.code) as count'))
            ->get();
    }

    public function render()
    {
        $carrers = Carrera::withCount('students')->paginate(5);

        return view('livewire.carrers.carrers-component', [
            'carrers' => $carrers,
        ])->layout('livewire.layouts.base');
    }
}

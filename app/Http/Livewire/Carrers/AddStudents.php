<?php

namespace App\Http\Livewire\Carrers;

use App\Carrera;
use App\Students;
use Livewire\Component;

class AddStudents extends Component
{
    public $selectedStudents;
    public $availableStudents;
    public $student;
    
    public function mount()
    {
        $this->availableStudents = Students::all();
    }
    public function edit($studentId)
    {
        $this->student = Students::find($studentId);
    }
    public function update()
    {
        // Verificar si el código existe en la tabla "careers"
        //$career = Carrera::where('code', $this->selectedStudents)->first();
        $this->student->code = $this->selectedStudents;
        $this->student->save();
        $this->dispatchBrowserEvent('closeModal');
    }
    public function render()
    {
        return view('livewire.carrers.add-students');
    }
}

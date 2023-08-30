<?php

namespace App\Http\Livewire\Students;

use App\Students;
use App\Carrera;
use Livewire\Component;

class StudentsComponent extends Component
{
    public $studentId;
    public $student;
    public $student_id;
    public $name;
    public $email;
    public $phone;
    public $carrer;
    public $carrers;
    public $selectedStudents;
    public $student_edit_id;
    public $student_delete_id;
    public $view_student_id;
    public $view_student_name;
    public $view_student_email;
    public $view_student_phone;
    public $view_student_carrera;
    public $searchPhone = '', $searchEmail = '', $searchName = '', $searchCarrera = '';

    //Validacion update
    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'student_id' => 'required|unique:students,student_id' . $this->student_edit_id . '', // students = table name
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ]);
    }

    public function mount()
    {
        $this->carrers = Carrera::all();
    }

    // Definir mensajes de validación personalizados
    protected $messages = [
        'student_id.required' => 'El ID del estudiante es obligatorio.',
        'student_id.unique' => 'El ID del estudiante ya está en uso.',
        'name.required' => 'El nombre del estudiante es obligatorio.',
        'email.required' => 'El email del estudiante es obligatorio.',
        'email.email' => 'El email debe ser válido.',
        'phone.required' => 'El número de teléfono es obligatorio.',
        'phone.numeric' => 'El número de teléfono debe ser numérico.',
        'phone.digits' => 'El número de teléfono debe tener :digits dígitos.',
        'attributes' => [
            'phone' => 'teléfono',
        ],
        'custom' => [
            'phone' => [
                'digits' => 'El :attribute debe tener 10 dígitos.',
            ],
        ]
    ];

    //Guardar
    public function storeStudentData()
    {
        //on form submit validation
        $this->validate([
            'student_id' => 'required|digits:3|unique:students', // students = table name
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
        ]);

        //Agregar informacion estudiante
        $student = new Students();
        $student->student_id = $this->student_id;
        $student->name = $this->name;
        $student->email = $this->email;
        $student->phone = $this->phone;

        $student->save();

        session()->flash('message', 'Creado correctamente');

        $this->student_id = '';
        $this->name = '';
        $this->email = '';
        $this->phone = '';

        //ocultar model despues de crearlo correctamente
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
        $this->student_id = '';
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        //$this->student_edit_id = '';
    }

    //editar
    public function editStudents($studentId)
    {
        $this->student = Students::find($studentId);

        $this->student_id = $this->student->student_id;
        $this->name = $this->student->name;
        $this->email = $this->student->email;
        $this->phone = $this->student->phone;

        //$this->dispatchBrowserEvent('show-edit-students-modal');
    }

    public function editStudentData()
    {
        // Validación específica para la edición
        $this->validate([
            'student_id' => 'required|numeric|digits:3|unique:students,student_id,' . $this->student->id,
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10', // Se requieren 10 dígitos
        ]);

        $this->student->student_id = $this->student_id;
        $this->student->name = $this->name;
        $this->student->email = $this->email;
        $this->student->phone = $this->phone;

        $this->student->save();

        session()->flash('message', 'Actualizado correctamente');

        //ocultar modal después de actualizar correctamente
        $this->dispatchBrowserEvent('close-modal');
    }

    //Delete Confirmation
    protected $listeners = ['deleteConfirmation'];

    public function deleteConfirmation($studentId)
    {
        $this->studentId = $studentId;
        $this->dispatchBrowserEvent('open-delete-modal');
    }

    public function deleteStudentData()
    {
        $student = Students::find($this->studentId);

        if ($student) {
            $student->delete();
            session()->flash('message', 'Estudiante eliminado correctamente.');
            $this->emit('studentDeleted');
        }
    }

    //Vista
    public function viewStudentsDetails($studentId)
    {
        $student = Students::find($studentId);

        if ($student) {
            $carrera = $student->carrera;

            $this->view_student_id = $student->student_id;
            $this->view_student_name = $student->name;
            $this->view_student_email = $student->email;
            $this->view_student_phone = $student->phone;
            $this->view_student_carrera = $carrera; // Agrega la propiedad para la carrera
        }
    }

    public function closeViewStudentModal()
    {
        $this->view_student_id = '';
        $this->view_student_name = '';
        $this->view_student_email = '';
        $this->view_student_phone = '';
        $this->view_student_carrera = '';
    }

    //añadir carrera
    public function addCarrer($carrerId)
    {
        $this->carrer = Students::find($carrerId);
    }

    public function update()
    {
        $this->carrer->code = $this->selectedStudents;
        $this->carrer->save();

        session()->flash('message', 'Estudiante creado correctamente.');

        // Emitir evento para cerrar el modal
        $this->emit('closeAddCarrerModal');
    }

    //Buscar
    public function search()
    {
        $query = Students::query();

        if (!empty($this->searchName)) {
            $query->where('name', 'LIKE', '%' . $this->searchName . '%');
        }

        if (!empty($this->searchEmail)) {
            $query->orWhere('email', 'LIKE', '%' . $this->searchEmail . '%');
        }

        if (!empty($this->searchPhone)) {
            $query->orWhere('phone', 'LIKE', '%' . $this->searchPhone . '%');
        }

        if (!empty($this->searchCarrera)) {
            $query->orWhereHas('carrera', function ($q) {
                $q->where('racer_name', 'LIKE', '%' . $this->searchCarrera . '%');
            });
        }

        return $query->paginate(10);
    }

    public function render()
    {
        //trae a todos los students
        $students = $this->search();

        return view('livewire.students.students-component', ['students' => $students])->layout('livewire.layouts.base');
    }
}

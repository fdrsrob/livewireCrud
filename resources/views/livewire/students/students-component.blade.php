<div class="p-3 mb-2 bg-dark text-black">
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="float: left;"><strong>Estudiantes</strong></h5>
                            <button class="btn btn-sm btn-primary" style="float: right;" data-toggle="modal" data-target="#addStudentModal">
                                <i class="bi bi-person-add"> Agregar Nuevo Estudiante</i>
                            </button>
                        </div>

                        <div class="card-body">
                            @if(session()->has('message'))
                            <div class="alert alert-success text-center">{{ session('message')}}</div>
                            @endif

                            <div class="col-md-12">
                                <div class="row">
                                    <!-- NOMBRE -->
                                    <div class="col-md-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Nombre</span>
                                            </div>
                                            <div class="input-group-prepend">
                                                <input type="text" class="form-control" wire:model="searchName" placeholder="Nombre">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- EMAIL -->
                                    <div class="col-md-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Email</span>
                                            </div>
                                            <div class="input-group-prepend">
                                                <input type="text" class="form-control" wire:model="searchEmail" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- TELEFONO -->
                                    <div class="col-md-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Teléfono</span>
                                            </div>
                                            <div class="input-group-prepend">
                                                <input type="text" class="form-control" wire:model="searchPhone" placeholder="Teléfono">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- CARRERA -->
                                    <div class="col-md-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Carrera</span>
                                            </div>
                                            <div class="input-group-prepend">
                                                <input type="text" class="form-control" wire:model="searchCarrera" placeholder="Carrera">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <button class="btn btn-primary mr-2" type="button">
                                            <i class="bi bi-search"> Buscar</i>
                                        </button>
                                        <button class="btn btn-secondary" onclick="window.location='{{ route('wolf.index') }}'">Ir a Carreras</button>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>EMAIL</th>
                                        <th>TELEFONO</th>
                                        <th>CARRERA</th>
                                        <th style="text-align: center;">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $student)
                                    <tr>
                                        <td>{{$student->student_id}}</td>
                                        <td>{{$student->name}}</td>
                                        <td>{{$student->email}}</td>
                                        <td>{{$student->phone}}</td>
                                        <td class="text-center">{{$student->carrera->racer_name ?? '-'}}</td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#viewStudentModal" wire:click="viewStudentsDetails({{ $student->id }})">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editStudentModal" wire:click="editStudents({{ $student->id }})">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteStudentModal" wire:click="deleteConfirmation({{ $student->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#addCarrer" wire:click="addCarrer({{ $student->id }})">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center;">No se encontraron Estudiantes</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Añadir -->
        <div wire:ignore.self class="modal fade" id="addCarrer" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog p-3 mb-2 bg-dark text-black">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Nuevo Estudiante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="update">
                            <!-- ID -->
                            <div class="select-contact">
                                <label class="form-label" for="selectedStudents">{{ __('Seleccione Estudiantes') }}</label>
                                <select id="selectedStudents" name="selectedStudents" wire:model="selectedStudents" class="form-control">
                                    @foreach($carrers as $carrer)
                                    <option value="{{ $carrer->id }}">{{ $carrer->racer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--  -->
                            <div class="form-group row">
                                <label for="" class="col-3"></label>
                                <div class="col-9">
                                    <button type="submit" class="btn btn-sm btn-primary" wire:click="update">Crear Estudiante</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Crear -->
        <div wire:ignore.self class="modal fade" id="addStudentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog p-3 mb-2 bg-dark text-black">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Nuevo Estudiante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="storeStudentData">

                            <!-- ID -->
                            <div class="form-group row">

                                <label for="student_id" class="col-3">ID Estudiante</label>
                                <div class="col-9">
                                    <input type="number" id="student_id" class="form-control" wire:model="student_id">
                                    @error('student_id')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- NAME -->
                            <div class="form-group row">
                                <label for="name" class="col-3">Nombre</label>
                                <div class="col-9">
                                    <input type="text" id="name" class="form-control" wire:model="name">
                                    @error('name')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- EMAIL -->
                            <div class="form-group row">
                                <label for="email" class="col-3">Email</label>
                                <div class="col-9">
                                    <input type="email" id="email" class="form-control" wire:model="email">
                                    @error('email')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- PHONE -->
                            <div class="form-group row">
                                <label for="phone" class="col-3">Telefono</label>
                                <div class="col-9">
                                    <input type="number" id="phone" class="form-control" wire:model="phone">
                                    @error('phone')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!--  -->
                            <div class="form-group row">
                                <label for="" class="col-3"></label>
                                <div class="col-9">
                                    <button type="submit" class="btn btn-sm btn-primary">Crear Estudiante</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div wire:ignore.self class="modal fade" id="editStudentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog p-3 mb-2 bg-dark text-black">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Editar Estudiante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="editStudentData">

                            <!-- ID -->
                            <div class="form-group row">

                                <label for="student_id" class="col-3">ID Estudiante</label>
                                <div class="col-9">
                                    <input type="number" id="student_id" class="form-control" wire:model="student_id">
                                    @error('student_id')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- NAME -->
                            <div class="form-group row">
                                <label for="name" class="col-3">Nombre</label>
                                <div class="col-9">
                                    <input type="text" id="name" class="form-control" wire:model="name">
                                    @error('name')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- EMAIL -->
                            <div class="form-group row">
                                <label for="email" class="col-3">Email</label>
                                <div class="col-9">
                                    <input type="email" id="email" class="form-control" wire:model="email">
                                    @error('email')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- PHONE -->
                            <div class="form-group row">
                                <label for="phone" class="col-3">Telefono</label>
                                <div class="col-9">
                                    <input type="number" id="phone" class="form-control" wire:model="phone">
                                    @error('phone')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- BOTON -->
                            <div class="form-group row">
                                <label for="" class="col-3"></label>
                                <div class="col-9">
                                    <button type="submit" class="btn btn-sm btn-primary" wire:loading.class="disable" wire:loading.attr="disable" wire:target="editStudentData" wire:click="editStudentData">Editar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div wire:ignore.self class="modal fade" id="deleteStudentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Confirmar eliminación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <h6>¿Estás seguro de que deseas eliminar a este estudiante?</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="close">Cancelar</button>
                        <button class="btn btn-sm btn-danger" wire:click="deleteStudentData" data-bs-dismiss="modal">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal View -->
        <div wire:ignore.self class="modal fade" id="viewStudentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog p-3 mb-2 bg-dark text-black">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Informacion de Estudiante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeViewStudentModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $view_student_id }}</td>
                                </tr>

                                <tr>
                                    <th>Nombre</th>
                                    <td>{{ $view_student_name }}</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>{{ $view_student_email }}</td>
                                </tr>

                                <tr>
                                    <th>Telefono</th>
                                    <td>{{ $view_student_phone }}</td>
                                </tr>

                                <tr>
                                    <th>Carrera</th>
                                    <td>{{ $view_student_carrera->racer_name ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        //scripts para ocultar
        window.addEventListener('close-modal', event => {
            $('#addStudentModal').modal('hide');
            $('#editStudentModal').modal('hide');
        })

        //script editar
        window.addEventListener('show-edit-students-modal', event => {
            $('#editStudentModal').modal('show');
        })

        //script ver
        window.addEventListener('show-view-student-modal', event => {
            $('#viewStudentModal').modal('show');
        })

        //script añadir
        document.addEventListener('livewire:load', function() {
            Livewire.on('closeAddCarrerModal', function() {
                $('#addCarrer').modal('hide');
            });
        });

        //script eliminar
        document.addEventListener('livewire:load', function() {
            Livewire.on('open-delete-modal', function() {
                $('#deleteStudentModal').modal('show');
            });

            Livewire.on('studentDeleted', function() {
                $('#deleteStudentModal').modal('hide');
            });
        });
    </script>
    @endpush
</div>
<div>
    <div wire:ignore.self class="modal fade" id="addStudentsModal" tabindex="-1" role="dialog" aria-labelledby="addStudentsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentsModalLabel">Añadir Estudiantes a la Carrera</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="addStudentsToCarrera">
                    <div class="modal-body">

                        <div class="select-contact">
                            <label class="form-label" for="selectedStudents">{{ __('Seleccione Estudiantes') }}</label>
                            <select id="selectedStudents" name="selectedStudents" wire:model="selectedStudents" class="form-control">
                                @foreach($availableStudents as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{$selectedStudents}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" wire:click="update">Agregar Estudiantes</button>
                    </div>
                    @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                </form>

            </div>
        </div>
    </div>
</div>
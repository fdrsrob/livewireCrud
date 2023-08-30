<div class="p-3 mb-2 bg-dark text-black">
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="float: left;"><strong>Carreras Universitarias</strong></h5>
                            <a href="{{ route('index') }}" class="btn btn-primary float-right">
                                <i class="bi bi-back">  Volver</i>
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>DESCRIPCION</th>
                                        <th>CANTIDAD</th>
                                        <th style="text-align: center;">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($carrers as $carrera)
                                    <tr>
                                        <td>{{$carrera->id}}</td>
                                        <td>{{$carrera->racer_name}}</td>
                                        <td>{{$carrera->description}}</td>
                                        <td>{{$carrera->count}}</td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#editCarreraModal" wire:click="editCarrera({{ $carrera->id }})">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center;"><span>No se encontraron carreras</span></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal View -->
        <!-- <div wire:ignore.self class="modal fade" id="viewCarreraModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog p-3 mb-2 bg-dark text-black">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Informacion de Estudiante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeViewCarreraModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $view_id }}</td>
                                </tr>

                                <tr>
                                    <th>Nombre</th>
                                    <td>{{ $view_carrera_racer_name }}</td>
                                </tr>

                                <tr>
                                    <th>Descripcion</th>
                                    <td>{{ $view_carrera_description }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Modal Edit -->
        <div wire:ignore.self class="modal fade" id="editCarreraModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog p-3 mb-2 bg-dark text-black">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Editar Carrera</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="editCarreraData">

                            <!-- NAME -->
                            <div class="form-group row">
                                <label for="racer_name" class="col-3">Nombre</label>
                                <div class="col-9">
                                    <input type="text" id="racer_name" class="form-control" wire:model="racer_name">
                                    @error('racer_name')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- DESCRIPCION -->
                            <div class="form-group row">
                                <label for="description" class="col-3">descripcion</label>
                                <div class="col-9">
                                    <input type="text" id="description" class="form-control" wire:model="description">
                                    @error('description')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- BOTON -->
                            <div class="form-group row">
                                <label for="" class="col-3"></label>
                                <div class="col-9">
                                    <button type="submit" class="btn btn-sm btn-primary" wire:loading.class="disable" wire:loading.attr="disable" wire:target="editCarreraData" wire:click="editCarreraData">Editar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#editCarreraModal').modal('hide');
        })
        window.addEventListener('show-edit-carrera-modal', event => {
            $('#editCarreraModal').modal('show');
        })

        window.addEventListener('show-view-carrera-modal', event => {
            $('#viewCarreraModal').modal('show');
        });

        $(function() {
            window.initContactsCreate = () => {
                // Select2
                $('.select-contact .single-select').select2({
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                    dropdownParent: $('.select-contact')
                });
            }
            $('.select-contact .single-select').on('change', function(e) {
                livewire.emit('ContactsCreateChange', $(this).val(), $(this).attr('wire:model.defer'));
            });
            window.livewire.on('ContactsCreateHydrate', () => {
                initContactsCreate();
            });
            livewire.emit('ContactsCreateChange', '', '');
        });
    </script>
    @endpush
</div>
<div>


    <div class="row">
        <x-spinner />

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-name">Department Main</h4>
                    <div class="row card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h2 class="m-0 font-weight-bold text-primary">Department Main List</h2>

                        {{-- <button wire:click="new_department()" class="btn btn-primary mr-2"> Submit</button> --}}

                        <a wire:click.prevent="new_department()" class="btn btn-primary float-right"
                            style="margin-top: 6px; margin-right: 6px;">Add department</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        # ID
                                    </th>
                                    <th>
                                        NAME
                                    </th>
                                    <th>
                                        STATUS
                                    </th>

                                    <th>
                                        FACULTY

                                    </th>
                                    <th>
                                        ACTIONS
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                {{-- @json($departments) --}}
                                @if (!empty($departments))
                                @foreach ($departments as $department )
                                <tr>
                                    <td>{{ $department->id }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>
                                        @php
                                        $status_toggle_icon = $department->status == 1 ? 'mdi-toggle-switch
                                        text-primary'
                                        : 'mdi-toggle-switch-off';
                                        @endphp
                                        <i wire:click="change_department_status({{ $department->id }},{{ $department->status }})"
                                            style="font-size: 30px" class="mdi {{ $status_toggle_icon }} "></i>

                                    </td>

                                    <td>{{ $department->get_department_faculty->name }}</td>
                                    <td>
                                        <a wire:click.prevent="edit_department({{ $department->id }})"
                                            style="font-size: 20px" class=" mdi mdi-pencil-box-outline"></a>



                                        <a style="font-size: 20px" class="mdi mdi-close-box-outline"
                                            wire:click.prevent="delete_department({{ $department->id }})"></a>
                                    </td>

                                </tr>

                                @endforeach

                                @endif


                            </tbody>

                        </table>
                        <div class="mt-3 d-flex justify-content-end">
                            {{ $departments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal 1-->
    <div wire:ignore.self class="modal fade" id="add_department_modal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-name" id="add_department_modal">DEPARTMENT MANAGEMENT
                    </h5>
                    <i style="font-size:20px" class="mdi mdi-close" type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="hide_modal"></i>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    --}}
                </div>
                <div class="modal-body">

   {{--  @include('admin.layout.global-errors')  --}}



                    <form wire:submit.prevent={{ $addNewDepartment ? 'submit_add_new_department'
                        : 'update_department ' }} method="POST">

                        <div class="form-group">
                            <label>Department Name </label>
                            <input type="text" wire:model.defer="inputs.name" class="form-control form-control-lg
                            @error('name') is-invalid @enderror" placeholder="Dept. Computer Science" aria-label="Username">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror


                        </div>
                        <div class="form-group">
                            <label for="exampleSelectGender">Department's Faculty</label>
                            <select class="form-control @error('faculty_id')
                            bg-danger is-invalid

                            @enderror" id="exampleSelectGender" wire:model.defer="inputs.faculty_id">
                                @if(!empty($faculties))
                                <option  value="">Choose Department's Faculty </option>

                                @forelse ( $faculties as $faculty )
                                <option value="{{ $faculty->id }}">{{$faculty->name}}</option>


                                @empty
                                <option value="">NO departments FOUND,TRY ADDING SOME</option>


                                @endforelse
                                @endif


                                @error('faculty_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </select>
                            @error('faculty_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="ml-1 form-group row">
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" wire:model.defer="inputs.status" class="form-check-input"
                                            name="membershipRadios" id="membershipRadios1" value="1" />
                                        Active
                                        <i class="input-helper"></i></label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" wire:model.defer="inputs.status" class="form-check-input"
                                            name="membershipRadios" id="membershipRadios2" value="0" checked />
                                        Inactive
                                        <i class="input-helper"></i></label>
                                </div>
                            </div>



                        </div>

                        <button type="submit" class="btn btn-outline-primary mx-auto d-block w-100">{{ $btn_text
                            }}</button>

                    </form>



                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
        </div>

        {{-- end of modal 1 --}}


    </div>

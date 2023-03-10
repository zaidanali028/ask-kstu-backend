<div>


    <div class="row">
        <x-spinner />

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Announcement Main</h4>
                    <div class="row card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h2 class="m-0 font-weight-bold text-primary">Announcement Main List</h2>

                        {{-- <button wire:click="new_announcement()" class="btn btn-primary mr-2"> Submit</button> --}}

                        <a wire:click.prevent="new_announcement()" class="btn btn-primary float-right"
                            style="margin-top: 6px; margin-right: 6px;">Add Announcement</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        # ID
                                    </th>
                                    <th>
                                        TITLE
                                    </th>
                                    <th>
                                        STATUS
                                    </th>
                                    <th>
                                        VIEWS
                                    </th>
                                    <th>
                                        LIKES
                                    </th>
                                    <th>
                                        DIS-LIKES
                                    </th>
                                    <th>
                                        CATEGORY

                                    </th>
                                    <th>
                                        ACTIONS
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                {{-- @json($announcements) --}}
                                @if (!empty($announcements))
                                @foreach ($announcements as $announcement )
                                <tr>
                                    <td>{{ $announcement->id }}</td>
                                    <td>{{ $announcement->title }}</td>
                                    <td>
                                        @php
                                        $status_toggle_icon = $announcement->status == 1 ? 'mdi-toggle-switch
                                        text-primary'
                                        : 'mdi-toggle-switch-off';
                                        @endphp
                                        <i wire:click="change_announcement_status({{ $announcement->id }},{{ $announcement->status }})"
                                            style="font-size: 30px" class="mdi {{ $status_toggle_icon }} "></i>

                                    </td>
                                    <td>{{ $announcement->views }}</td>
                                    <td>{{ $announcement->likes }}</td>
                                    <td>{{ $announcement->dislikes }}</td>
                                    <td>{{ $announcement->get_announcement_category->name }}</td>
                                    <td>
                                        <a wire:click.prevent="edit_announcement({{ $announcement->id }})"
                                            style="font-size: 20px" class=" mdi mdi-pencil-box-outline"></a>



                                        <a style="font-size: 20px" class="mdi mdi-close-box-outline"
                                            wire:click.prevent="delete_announcement({{ $announcement->id }})"></a>
                                    </td>

                                </tr>

                                @endforeach

                                @endif


                            </tbody>

                        </table>
                        <div class="mt-3 d-flex justify-content-end">
                            {{ $announcements->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal 1-->
    <div wire:ignore.self class="modal fade" id="add_announcement_modal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="add_announcement_modal">ANNOUNCEMENT MANAGEMENT
                    </h5>
                    <i style="font-size:20px" class="mdi mdi-close" type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></i>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    --}}
                </div>
                <div class="modal-body">

   {{--  @include('admin.layout.global-errors')  --}}



                    <form wire:submit.prevent={{ $addNewAnnouncement ? 'submit_add_new_announcement'
                        : 'update_announcement ' }} method="POST">

                        <div class="form-group">
                            <label>Announcement Title </label>
                            <input type="text" wire:model.defer="inputs.title" class="form-control form-control-lg
                            @error('title') is-invalid @enderror" placeholder="Graduation 2024" aria-label="Username">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror


                        </div>
                        <div class="form-group">
                            <label for="exampleSelectGender">Announcement Category</label>
                            <select class="form-control @error('category_id')
                            bg-danger is-invalid

                            @enderror" id="exampleSelectGender" wire:model.defer="inputs.category_id">
                                @if(!empty($categories))
                                <option  value="">CHOOSE ANNOUNCEMENT'S CATEGORY </option>

                                @forelse ( $categories as $cateory )
                                <option value="{{ $cateory->id }}">{{$cateory->name}}</option>


                                @empty
                                <option>NO CATEGORIES FOUND,TRY ADDING SOME</option>


                                @endforelse
                                @endif


                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Announcement Featured Image </label>

                            <input type="file"  id="img_file" wire:model.defer="inputs.featured_image" class="
                            @error('featured_image')
                            bg-danger
                            @enderror
                            form-control-file border border-primary rounded mb-4"/>
                            @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if(!empty($inputs['featured_image']) &&is_object($inputs['featured_image']))
                            <button class="close" style=" right:20px;top:230px;
                               position: absolute; ">
                                <span class="text-dark display-6"  wire:click.prevent="clear_temp_img()"
                                   >&times;</span>
                            </button>
                            <img src="{{ $inputs['featured_image']->isPreviewable() ? $inputs['featured_image']->temporaryUrl() : '/storage/err.png' }}"
                                class="card-img-top rounded" alt="...">
                            @elseif(!empty($inputs['featured_image']) &&is_string($inputs['featured_image']))
                            <button class="close" style=" right:30px;top:230px;
                               position: absolute; ">
                                <span class="text-dark display-6"  wire:click.prevent="clear_db_img()"
                                   >&times;</span>
                            </button>
                            <img src="{{ '/storage/' . $announcement_images . '/' .$inputs['featured_image'] }}"
                                class="card-img-top rounded" alt="...">

                            @else
                            <img src="https://via.placeholder.com/300x200" class="card-img-top rounded"
                                alt="...">


                            @endif

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

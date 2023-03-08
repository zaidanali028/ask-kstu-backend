<div>
    <x-spinner />

    <div class="container">
        <ul class="nav nav-tabs" role="tablist">
            @forelse ($categories as $category=>$category_data )

            <li class="nav-item " wire:ignore wire:click="tab_clicked({{ $category }})">
                <a class="nav-link  @if ($loop->first)

                        active

                    @endif" data-toggle="tab" href="#{{ $category }}" role="tab">{{ $category_data->name }}</a>
            </li>

            @empty
            <li>No Data To Show!</li>
            @endforelse


        </ul>

        <div class="tab-content  ">

            <div class="row mt-3 mb-5">
                <!-- Tab panes -->
                @forelse ($categories as $category=>$category_data )
                @if( $current_tab==$category)
                @forelse ($category_data->paginated_announcements() as $announcement )
                {{-- @json($category_data->paginated_announcements())) --}}
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h5 class="text-center text-capitalize d-flex justify-content-start"> {{
                                        Str::limit($announcement->title , $limit,
                                        '...') }}
                                    </h5>

                                </div>


                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="card mt-3">
                                <div class="card-body">



                                    <button class="btn btn-outline-primary"
                                        wire:click.prevent="get_key_moments({{  $announcement->id}},{{ $announcement->id }})">Add
                                        Key
                                        Moment(s)</button>



                                </div>


                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="card mt-1">
                        <div class="card-body">
                            <div class="row">
                               <style>
                                .font-gen{
                                    font-size:20px;


                                    }
                               </style>
                                <div class="col-md-4 d-flex justify-content-start">
                                    <i class="fas fa-thumbs-up mr-2 text-success font-gen"></i>
                                    {{-- <span>Like</span> --}}
                                    <span class="badge  w-25 h-100 b badge-pill badge-success font-gen">{{ $announcement->likes
                                        }}</span>
                                </div>
                                <div class="col-md-4  d-flex justify-content-center">
                                    <i class="fas fa-eye mr-2 text-primary font-gen"></i>
                                    {{-- <span>Views</span> --}}
                                    <span class="badge w-25 h-100 badge-pill badge-primary font-gen">{{ $announcement->views
                                        }}</span>
                                </div>
                                <div class="col-md-4  d-flex justify-content-end">
                                    <i class="fas fa-thumbs-down mr-2 text-danger font-gen"></i>
                                    {{-- <span>Dislike</span> --}}
                                    <span class="badge badge-pill badge-danger w-25 h-100 font-gen">{{ $announcement->dislikes
                                        }}</span>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="ml-2 mt-3 d-flex
                    justify-content-end">
                        {{-- kvngthr!v3 --}}
                        {{ $category_data->paginated_announcements()
                        ->links() }}
                    </div>
                </div>
                @empty
                <p>Data Currently Empty</p>
                @endforelse



                @endif


                @empty
                <p>No Data To Show!</p>
                @endforelse
            </div>

        </div>


        <!-- Modal 1-->
        <div wire:ignore.self class="modal fade" id="announcement_key_moments" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="announcement_key_moments">CATEGORY MANAGEMENT
                        </h5>
                        <i style="font-size:20px" class="mdi mdi-close" type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Close"></i>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        --}}
                    </div>
                    <div class="modal-body">
                        @include('admin.layout.global-errors')

                        <h4>{{ $current_announcement_name }}</h4>
                        <hr>
                        {{-- <div class="row"> --}}
                            <button class="btn btn-outline-primary w-100 "
                                wire:click.prevent="add_announcement_keyMoment()">Add A New Key Moment</button>

                            @if(!empty($announcement_key_moments))

                            @forelse ($announcement_key_moments as $index=>$key_moment )
                            @php $key_moment_img=$this->get_key_moment_attr($index) @endphp
                            {{-- @json($key_moment_img) --}}
                            <div class="col-sm-12 mt-4">
                                <div class="card">

                                    @if(is_object($key_moment_img))
                                    <button class="close" style=" right:50px;top:30px;
                                       position: absolute; ">
                                        <span class="text-dark display-6"  wire:click.prevent="remove_moment_img_temp({{ $index }})"
                                           >&times;</span>
                                    </button>
                                    <img src="{{ $key_moment_img->isPreviewable() ? $key_moment_img->temporaryUrl() : '/storage/err.png' }}"
                                        class="card-img-top rounded" alt="...">
                                    @elseif(is_string($key_moment->image))
                                    <button class="close" style=" right:50px;top:30px;
                                       position: absolute; ">
                                        <span class="text-dark display-6"  wire:click.prevent="remove_moment_img_temp({{ $index }})"
                                           >&times;</span>
                                    </button>
                                    <img src="{{ '/storage/' . $moment_img_path . '/' . $key_moment->image }}"
                                        class="card-img-top rounded" alt="...">

                                    @else
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top rounded"
                                        alt="...">


                                    @endif
                                    <hr>
                                    <input type="file" wire:model.defer="temp_pic_{{ $index }}" class="form-control-file border border-primary rounded mt-1
                                        @error('temp_pic_'. $index)
                                        bg-danger
                                        @enderror
                                        " id="image-upload">
                                    <div class="invalid-feedback">
                                        @error('temp_pic_'. $index)
                                        {{ $message }}
                                        @enderror </div>

                                    <hr>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="subtitleInput">Announcement Subtitle</label>


                                            <input type="text"
                                                wire:model.defer="announcement_key_moments.{{ $index }}.image_sub_title"
                                                class="form-control
                                            @error('announcement_key_moments.'. $index .'.image_sub_title') is-invalid @enderror

                                            " id="subtitleInput">
                                            <div class="invalid-feedback">
                                                @error('announcement_key_moments.'. $index .'.image_sub_title')
                                                {{ $message }}
                                                @enderror </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="descriptionTextarea">Announcement Description</label>
                                            <textarea class="form-control
                                            @error('announcement_key_moments.'. $index .'.image_description') is-invalid @enderror

                                            " id="descriptionTextarea"
                                                wire:model.defer="announcement_key_moments.{{ $index }}.image_description"
                                                rows="3"></textarea>
                                            <div class="invalid-feedback">
                                                @error('announcement_key_moments.'. $index .'.image_description')
                                                {{ $message }}
                                                @enderror </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            @empty
                            <p>No key moments for this announcement</p>

                            @endforelse
                            <button class="btn btn-primary w-100 mt-3" wire:click='add_new_announcement()'>Submit
                                Key Moment(s)</button>

                            @endif

                            {{--
                        </div> --}}




                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
            </div>

            {{-- end of modal 1 --}}
        </div>




        {{-- end of conainer --}}
    </div>
</div>
</div>
</div>

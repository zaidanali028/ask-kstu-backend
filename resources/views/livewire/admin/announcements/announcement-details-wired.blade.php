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

        <div class="row mt-3">
            <!-- Tab panes -->
                @forelse ($categories as $category=>$category_data )
                @if( $current_tab==$category)
                @forelse ($category_data->paginated_announcements() as $announcement )
                {{-- @json($category_data->paginated_announcements())) --}}
                <div class="col-md-4">
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="text-center text-capitalize">{{ $announcement->title }}</h5>
                            <ul class="list-group">

                                <button class="btn btn-outline-primary mt-2"
                                    wire:click.prevent="get_key_moments({{  $announcement->id}},{{ $announcement->id }})">Add  Key
                                    Moment(s)</button>

                            </ul>
                            {{-- <h5 class="card-title">Card 1</h5> --}}
                            {{-- <p class="card-text">Some quick example text to build on the card title and make up the
                                bulk of the card's content.</p> --}}
                        </div>


                    </div>
                    <div class="card mt-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <i class="fas fa-thumbs-up"></i>
                                    {{-- <span>Like</span> --}}
                                    <span class="badge badge-pill badge-success">{{ $announcement->likes }}</span>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-eye"></i>
                                    {{-- <span>Views</span> --}}
                                    <span class="badge badge-pill badge-primary">{{ $announcement->views }}</span>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-thumbs-down"></i>
                                    {{-- <span>Dislike</span> --}}
                                    <span class="badge badge-pill badge-danger">{{ $announcement->dislikes }}</span>
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
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        --}}
                    </div>
                    <div class="modal-body">
                        {{--  @include('admin.layout.global-errors')  --}}

                        <h4>{{ $current_announcement_name }}</h4>
                        <hr>
                        {{--  <div class="row">  --}}
                            <button class="btn btn-outline-primary w-100 "
                                wire:click.prevent="add_announcement_keyMoment()">Add A New Key Moment</button>

                            @if(!empty($announcement_key_moments))

                            @forelse ($announcement_key_moments as $index=>$key_moment )

                            <div class="col-sm-12 mt-4">
                                <div class="card">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top rounded"
                                        alt="...">
                                              <hr>
                                        <input type="file" wire:model.defer="announcement_key_moments.{{ $index }}.image"  class="form-control-file border border-primary rounded mt-1" id="image-upload">
                                        <div class="invalid-feedback">
                                            @error('announcement_key_moments.'. $index .'.image')
                                            {{ $message }}
                                        @enderror </div>

                                    <hr>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="subtitleInput">Announcement Subtitle</label>


                                            <input type="text" wire:model.defer="announcement_key_moments.{{ $index }}.image_sub_title" class="form-control
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

                                            " id="descriptionTextarea" wire:model.defer="announcement_key_moments.{{ $index }}.image_description"  rows="3"></textarea>
                                            <div class="invalid-feedback">
                                                @error('announcement_key_moments.'. $index .'.image_description')
                                                {{ $message }}
                                            @enderror </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <button class="btn btn-primary w-100 mt-3" wire:click.prevent='add_new_announcement'>Submit Key Moment(s)</button>

                            @empty
                            <p>No key moments for this announcement</p>

                            @endforelse

                            @endif

                        {{--  </div>  --}}




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

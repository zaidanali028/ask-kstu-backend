<div>


        <x-spinner />

        <div class="container">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                @forelse ($categories as $category=>$category_data )

                <li class="nav-item " wire:ignore wire:click="tab_clicked({{ $category }})" >
                    <a  class="nav-link  @if ($loop->first)

                        active

                    @endif" data-toggle="tab" href="#{{ $category }}" role="tab">{{ $category_data->name }}</a>
                  </li>

                @empty
                  <li>No Data To Show!</li>
                @endforelse


            </ul>

            <!-- Tab panes -->
                                    <div class="tab-content ">
                                        @forelse ($categories as $category=>$category_data )
                                      @if( $current_tab==$category)
                                        <div class="row mt-3">
                                        @forelse ($category_data->paginated_announcements() as $announcement )
                                        {{--  @json($category_data->paginated_announcements()))  --}}
                                        <div class="col-md-4">
                                            <div class="card mt-3">
                                              <div class="card-body"> <h5 class="text-center text-capitalize">{{ $announcement->title }}</h5>
                                                  <ul class="list-group">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                      Key Moment 1
                                                      <div>
                                                        <a href="#" class="edit"><i class="fas fa-edit"></i></a>
                                                        <a href="#" class="delete"><i class="fas fa-trash-alt"></i></a>
                                                      </div>
                                                    </li>
                                                    <button class="btn btn-outline-primary mt-2">Add Another Key Moment</button>

                                                  </ul>
                                                {{--  <h5 class="card-title">Card 1</h5>  --}}
                                                {{--  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>  --}}
                                              </div>


                                            </div>
                                            <div class="card mt-1">
                                              <div class="card-body">
                                                  <div class="row">
                                                      <div class="col-md-4">
                                                          <i class="fas fa-thumbs-up"></i>
                                                          {{--  <span>Like</span>  --}}
                                                          <span class="badge badge-pill badge-success">{{ $announcement->likes }}</span>
                                                      </div>
                                                      <div class="col-md-4">
                                                          <i class="fas fa-eye"></i>
                                                          {{--  <span>Views</span>  --}}
                                                          <span class="badge badge-pill badge-primary">{{ $announcement->views }}</span>
                                                      </div>
                                                      <div class="col-md-4">
                                                          <i class="fas fa-thumbs-down"></i>
                                                          {{--  <span>Dislike</span>  --}}
                                                          <span class="badge badge-pill badge-danger">{{ $announcement->dislikes }}</span>
                                                      </div>

                                                  </div>
                                              </div>

                                            </div>

                                          </div>
                                        
                                         </div>
                                         <div class="row">
                                            <div class="ml-2 mt-3 d-flex justify-content-end">
                                                {{ $category_data->paginated_announcements()->links() }}
                                            </div>
                                         </div>
                                            @empty
                                            <p>Data Currently Empty</p>
                                            @endforelse



                                        @endif
                                </div>
                                </div>


                                        @empty
                                        <div>No Data To Show!</div>
                                        @endforelse



          </div>



</div>
</div>







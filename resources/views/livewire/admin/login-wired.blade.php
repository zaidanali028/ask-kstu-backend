<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
        <x-spinner />


        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block">
                            <img src="{{asset('admin/img/Students-rafiki.svg')}}" class="w-100 h-100" alt="...">

                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">ASK-KSTU ADMIN PANEL</h1>
                                </div>
                                @if(Session::has('error_msg'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{Session::get('error_msg')}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                                {{--  @if(Session::has('error_msg'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{Session::get('error_msg')}}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif


                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach

                                    </ul>
                                </div>
                                @endif  --}}
                                <form class="forms-sample" wire:submit.prevent="process_login">
                                    {{-- <form class="user"> --}}
                                        <div class="form-group">
                                            <input wire:model.defer="inputs.email" class="form-control form-control-user
                                   @error('email') is-invalid @enderror
                                   " id="exampleInputEmail" aria-describedby="emailHelp" type="email"
                                                placeholder="Enter Email Address...">

                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input wire:model.defer="inputs.password" type="password"
                                                class="form-control form-control-user  @error('password') is-invalid @enderror" id="exampleInputPassword"
                                                placeholder="Password">

                                                @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">

                                            Login
                                        </button>
                                        <hr>
                                        {{-- <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a> --}}
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        {{-- <a class="small" href="register.html">Create an Account!</a> --}}
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

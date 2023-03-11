@extends('admin.layout.layout')
@section('main-content')
<div id="content">

    <!-- Topbar -->
   @include('admin.layout.header')
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container">

        <livewire:admin.school.departments-wired/>


    </div>
    <!-- /.container-fluid -->

</div>
@endsection

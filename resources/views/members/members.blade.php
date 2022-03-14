@extends('admin.layout')
@section('content')
@include('sweetalert::alert')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Members</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin')}}">Home</a></li>
                        <li class="breadcrumb-item active">Members</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">

            <div class="card bg-light text-dark ">
                <div class="card-header bg-light">
                    <h2 class="text-primary">Add Member</h2>
                </div>
                
                <div class="card-body">

                    <form method="post" action="{{route('post_member')}}">
                        @csrf
                        <h5>PERSONAL INFO</h5>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 mb-3 mb-sm-0">
                                <input type="text" name="Name" class="form-control form-control-user" placeholder="Full Name">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="Email" class="form-control form-control-user" placeholder="Email">
                            </div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 mb-3 mb-sm-0">
                                <input type="text" name="Address" class="form-control form-control-user" placeholder="Address">
                            </div>
                            <div class="col-sm-5 mb-3 mb-sm-0">
                                <input type="text" name="Mobile" class="form-control form-control-user" placeholder="Mobile">
                            </div>


                        </div>
                        <br>

                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 mb-3 mb-sm-0">
                                <input type="text" name="IdNumber" class="form-control form-control-user" placeholder="ID Number">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="GroupCode" class="form-control form-control-user" placeholder="Group Name">
                            </div>
                        </div>
                      
                            <h5>NEXT OF KIN DETAILS</h5>
                            <hr/>
                       
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 mb-2 mb-sm-0">
                                <input type="text" name="KinName" class="form-control form-control-user" placeholder="Next of Kin Full Name">
                            </div>

                            <div class="col-sm-5">
                                <input type="text" name="KinMobile" class="form-control form-control-user" id="exampleLastName" placeholder="Next of Kin Mobile">
                            </div>
                        </div>
                </div>


                <button type="submit" class="btn btn-block btn-primary">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>

</div>


</div>

@endsection
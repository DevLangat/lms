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
                    <h5 class="text-primary">Add Member</h5>
                </div>

                <div class="card-body">

                    <form method="post" action="{{route('post_member')}}">
                        @csrf                       
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Name" class="form-control" placeholder="Enter Full Name">
                                <label>Full Name</label>
                            </div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Email" class="form-control" placeholder="Enter Email Address">
                                <label>Email Address</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Address" class="form-control" placeholder="Enter Address">
                                <label>Physical Address</label>
                            </div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Mobile" class="form-control" placeholder="Enter Mobile">
                                <label>Mobile</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="IdNumber" class="form-control" placeholder="Enter ID Number">
                                <label>National ID Number</label>
                            </div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="GroupCode" class="form-control" placeholder="Enter Group Code">
                                <label>Group Code</label>
                            </div>
                        </div>                       

                        <h5>Next of Kin Details</h5>
                        <hr />
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="KinName" class="form-control" placeholder="Enter Kin Name">
                                <label>Next of Kin Name</label>
                            </div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="KinMobile" class="form-control" placeholder="Enter Kin Mobile">
                                <label>Next of Kin Mobile</label>
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
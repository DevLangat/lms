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
                    <h3>Company</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin')}}">Home</a></li>
                        <li class="breadcrumb-item active">Company</li>
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
                    <h2 class="text-primary">Company Details</h2>

                </div>
                      <br>         
                    <form method="post" action="{{route('post_company')}}">
                        @csrf
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
                                <input type="text" name="Telephone" class="form-control form-control-user" placeholder="Telephone">
                            </div>


                        </div>
                        <br>
                        <div class="form-group row">
                        <div class="col-sm-1"></div>
                            <div class="col-sm-5 mb-3 mb-sm-0">
                                <input type="text" name="ContactPerson" class="form-control form-control-user" placeholder="ContactPerson">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="PinNumber" class="form-control form-control-user" id="exampleLastName" placeholder="PinNumber">
                            </div>
                        </div>
                        <div class="form-group row">
                        <div class="col-sm-1"></div>
                            <div class="col-sm-5 mb-3 mb-sm-0">
                                <input type="text" name="Branch" class="form-control form-control-user" placeholder="Branch">
                            </div>

                        </div>


                        <button type="submit" class="btn btn-block btn-primary">SUBMIT</button>
                    </form>
                
            </div>
        </div>
        <div class="col-md-1"></div>

    </div>


</div>

@endsection
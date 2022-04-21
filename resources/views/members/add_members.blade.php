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
                    <h3>Customer</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin')}}">Home</a></li>
                        <li class="breadcrumb-item active">Cuctomer</li>
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
                    <h5 class="text-primary">Add Customer</h5>
                </div>

                <div class="card-body">

                    <form method="post" action="{{route('post_member')}}">
                        @csrf  
                        'Customer_SSN','Customer_Name','Customer_Street','Customer_City                     
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Customer_Name" class="form-control" placeholder="Enter Full Name">
                                <label>Full Name</label>
                            </div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Customer_SSN" class="form-control" placeholder="Enter Security Number">
                                <label>Security Number</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Customer_Street" class="form-control" placeholder="Enter Customer Street">
                                <label>Customer Street</label>
                            </div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Customer_City" class="form-control" placeholder="Enter Customer City">
                                <label>Customer City</label>
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
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
                    <h2 class="text-primary">Loan Application </h2>
                </div>

                <div class="card-body">

                    <form method="post" action="{{route('AddLoan')}}">
                        @csrf
                        <h5>CLIENT INFORMATION</h5>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <input type="text" name="IDNo" class="form-control form-control-user" placeholder="National ID No">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="Name" class="form-control form-control-user" placeholder="Full Names">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="Deposits" class="form-control form-control-user" placeholder="Deposits">
                            </div>
                        </div>
                        <br>

                        <h5>LOAN DETAILS</h5>
                        <hr />
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <input type="dropdown" name="Loancode" class="form-control form-control-user" placeholder="Loan Type">
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <input type="text" name="AmountApplied" class="form-control form-control-user" placeholder="Enter Amount to Apply">
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <input type="text" name="ApplicationDate" class="form-control form-control-user" placeholder="Date Of Application">
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <input type="text" name="Rperiod" class="form-control form-control-user" placeholder="Repayment Period">
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <input type="text" name="ApplicationDate" class="form-control form-control-user" placeholder="Date Of Application">
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
                        <div class="form-group form-floating  label-floating ">
                           
                            <label class="control-label">Assignment Type <p></p></label>
                            <select class="form-control" name="assignment_type" required="" aria-required="true">
                                <option disabled="" selected=""></option>
                                <option value="Test"> Test</option>
                                <option value="MATHEMATICS TEST"> MATHEMATICS TEST</option>
                            </select>
                            <span class="material-input"></span>
                        </div>
                        <h5>NEXT OF KIN DETAILS</h5>
                        <hr />

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
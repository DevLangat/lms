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
                    <h3>Deposits</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('admin')}}">Home</a></li>
                        <li class="breadcrumb-item active">Deposits</li>
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
                    <h5 class="text-primary">Post Deposits Receipts</h5>
                </div>

                <div class="card-body">

                    <form method="post" action="{{route('post_deposit')}}">
                        @csrf                       
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="MemberNo" class="form-control" placeholder="Enter MemberNo">
                                <label>MemberNo</label>
                            </div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Names" class="form-control" placeholder="Full Names">
                                <label>Full Names</label>
                            </div>
                        </div>
                      
                        
                        <h5>Transaction Details</h5>
                        <hr />
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 msharescodeb-sm-0">
                                <input type="dropdown" name="sharescode" class="form-control" placeholder="Choose Deposit Type">
                                <label>Deposit Type</label>

                                {{-- <label for="deposit">Select Deposit Type:</label>
                                <select name="deposit" class="form-control" style="width:250px">
                                    <option value="">--- Select Deposit Type ---</option>
                                    @foreach ($deposits as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select> --}}

                            </div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Balance" class="form-control" placeholder="Deposit Balance">
                                <label>Deposit Balance</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Amount" class="form-control" placeholder="Enter Deposit Amount" required>
                                <label>Deposit Amount</label>
                            </div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="date" name="TransactionDate" class="form-control" placeholder="Choose Date">
                                <label>Transaction Date</label>
                            </div>
                        </div>                       


                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="ReceiptNo" class="form-control" placeholder="Enter Receipt">
                                <label>Receipt Number</label>
                            </div>
                            <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Remarks" class="form-control" placeholder="Enter Remarks">
                                <label>Transaction Remarks</label>
                            </div>
                          {{--   <div class="col-sm-5 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="TransBy" class="form-control" placeholder="Enter User">
                                <label>User Details</label>
                            </div> --}}
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
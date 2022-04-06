@extends('admin.layout')
@section('content')
@include('sweetalert::alert')
<div class="content-wrapper" style="min-height: 1635.56px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Loan Approval</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Approve Loan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Loanee/Members Detais</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-info mr-1"></i> General Infomation</strong>
              
                <p class="text-muted">
                  Name:  {{$member->Name}} <br>                
                  National ID: {{$member->MemberNo}} <br> 
                  GroupCode : {{$member->GroupCode}} <br>                
                                  
                </p>
                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">
                    
                    Address: {{$member->Address}} <br>
                   
                </p>

                <hr>
              

                <strong><i class="fas fa-book mr-1"></i> Next of Kin</strong>

                <p class="text-muted">
                Name : {{$member->KinName}} <br>
                Mobile : {{$member->KinMobile}}
                </p>

                <hr>

                <strong><i class="fa fa-phone mr-1"></i> Contact</strong>

                <p class="text-muted">
                Mobile : {{$member->Mobile}} <br> 
                Email : {{$member->Email}} 
                </p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">        
                <h3>Loan Details </h3>
                
              </div><!-- /.card-header -->
              <div class="card-body">
               
                    <!-- Post -->
                    <form method="POST" action="{{route('loan/approve')}}">
                        @csrf
                    <div>
                      <div class="row">
                      <input type="text" name="Approved" value="{{$showloan->Approved}}"  class="form-control" readonly hidden="true" >
                      <input type="text" name="MemberNo" value="{{$member->MemberNo}}"  class="form-control" readonly hidden="true" >
                      <input type="text" name="IntRate" value="{{$showloan->IntRate}}"  class="form-control" readonly hidden="true" >
                        
                          <div class="row">
                            <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Loanno" value="{{$showloan->Loanno}}"  class="form-control" readonly >
                                <label>Loan Code</label>
                            </div>
                            <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="AmountApplied" value="{{$showloan->AmountApplied}}"  class="form-control" readonly >
                                <label>Amount Applied</label>
                            </div>
                            <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Rperiod" value="{{$showloan->Rperiod}}"  class="form-control" readonly >
                                <label>Repayment Period</label>
                            </div>
                            <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="ApplicationDate" value="{{$showloan->ApplicationDate}}"  class="form-control" readonly >
                                <label>Application Date</label>
                            </div>
                                                         
                          </div>
                         
                          <div class="card mt-4">
                            <div class="card-header p-2">        
                           
                              <h2>Approve Loan</h2>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                   
                                      <div class="row">
                                  <div class="col-md-6 form-floating mb-3 mt-3 mb-sm-0">
                                      <input type="text" name="ApprovedAmount"   class="form-control"  required >
                                      <label>Amount to Approve</label>
                                  </div> 
                                  <div class="col-md-6 form-floating mb-3 mt-3 mb-sm-0">
                                      <input type="date" name="ApprovedOn"   class="form-control"  required >
                                      <label>Approval Date</label>
                                  </div>
                                  <div>
                                      <br>
                                  <button type="submit" class="btn btn-block btn-primary">SUBMIT</button>
                                  </div>
                                 
                                    </form> 
                                    <form method="POST" action="{{route('loan/reject')}}">
                                      @csrf
                                    <div>
                                      <br>
                                      <input type="text" name="Loanno" value="{{$showloan->Loanno}}"  class="form-control" readonly hidden="true"  >
                                  <button type="submit" class="btn btn-block btn-danger">Reject</button>
                                  </div>
                                  </form>
                                </div>
                            </div>  
                          </div>            
                          </div>
                        
                       
                      
                      </div>
                      <br>
                     
                    </div>
                  
                  
                  <!-- /.tab-pane -->
              
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
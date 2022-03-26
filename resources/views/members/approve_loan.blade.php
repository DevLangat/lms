@extends('admin.layout')
@section('content')
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
         
                <ul class="nav nav-tabs">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">LOANS</a></li>                  
                </ul>
                <td>{{$showloan->MemberNo}}</td>
                <td>{{$showloan->Names}}</td>
                <td>{{$showloan->Loanno}}</td>
                <td>{{$showloan->AmountApplied}}</td>
                <td>{{$showloan->ApprovedAmount}}</td>
                <td>{{$showloan->RepayAmount}}</td>
                <td>{{$showloan->Approved}}</td>
                <td>{{$showloan->ApplicationDate}}</td>
                <td>{{$showloan->Rperiod}}</td>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane fade in active" id="activity">
                    <!-- Post -->
                    <div class="post">
                      <div class="row">
                        <div class="col-md-4">
                          <h3>LOANS</h3>
                          <div class="row">
                              <div class="col sm-3"><h3>Loan Code: </h3> <b><h3>{{$showloan->Loanno}}</h3></b></div>
                              <div class="col sm-3"><h3>Amount Applied: </h3> <b><h3>{{$showloan->AmountApplied}}</h3></b></div>
                              <div class="col sm-3"><h3>Application Date: </h3> <b><h3>{{$showloan->ApplicationDate}}</h3></b></div>                             
                              <div class="col sm-3"><h3>Laon Type: </h3> <b><h3>{{$showloan->Loantype}}</h3></b></div>                             
                          </div>
                          <div class="row">
                              <form>
                            <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Loantype" id="loantype"  class="form-control" readonly required >
                                <label>Amount to Approve</label>
                            </div> 
                            <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Loantype" id="loantype"  class="form-control" readonly required >
                                <label>Remarks</label>
                            </div>
                            <button type="submit" class="btn btn-block btn-primary">SUBMIT</button>
                              </form> 
                          </div>
                        
                        </div>
                      
                      </div>
                      <br>
                     
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane fade" id="lbalance">
                    <div class="row">
                      <div class="col-md-4">
                        <h3>Result Slip</h3>
                        
                      </div>
                      <div class="col-md-4">
                        <h3>ID/Birth Certificate</h3>
                       
                      </div>
                      <div class="col-md-4">
                        <h3>Bank Slip</h3>
                        <!-- <a href="{{url('download/bank_slip/'.$member->bank_slip)}}">{{$member->bank_slip}} <span><i class="fa fa-download"></i></span></a> -->
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane fade" id="repayment">
                   Page 3
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
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
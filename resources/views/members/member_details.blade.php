@extends('admin.layout')
@section('content')
<div class="content-wrapper" style="min-height: 1635.56px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Member Profile</li>
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
                <h3 class="card-title">About Me</h3>
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
                  <li class="nav-item"><a class="nav-link" href="#lbalance" data-toggle="tab"> LOANS BALANCE</a></li>
                  <li class="nav-item"><a class="nav-link" href="#repayment" data-toggle="tab">REPAYMENT</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane fade in active" id="activity">
                    <!-- Post -->
                    <div class="post">
                      <div class="row">
                        <div class="col-md-4">
                          <h3>LOANS</h3>
                          <!-- {{$member->selection1}} -->
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
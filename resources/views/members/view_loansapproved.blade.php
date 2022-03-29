@extends('admin.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3>LOAN APPLIED</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin')}}">Home</a></li>
            <li class="breadcrumb-item active">Approved Loans</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Member No.</th>
                    <th>Names</th>
                    <th>Loanno</th>
                    <th>Amount Applied</th>
                    <th>Amount Approved </th>
                    <th>Repay Rate </th>
                    <th>Is Approved</th>
                    <th>Application Date</th>  
                    <th>Repayment Period</th> 
                    <th> Actions</th>                
                  </tr>
                </thead>
                <tbody>

                  @foreach ($showloans ?? '' as $showloan)
                  <tr>
                    <td>{{$showloan->MemberNo}}</td>
                    <td>{{$showloan->Names}}</td>
                    <td>{{$showloan->Loanno}}</td>
                    <td>{{$showloan->AmountApplied}}</td>
                    <td>{{$showloan->ApprovedAmount}}</td>
                    <td>{{$showloan->RepayAmount}}</td>
                    <td>{{$showloan->Approved}}</td>
                    <td>{{$showloan->ApplicationDate}}</td>
                    <td>{{$showloan->Rperiod}}</td>                   
                    <td>
                     
                    
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Member No.</th>
                    <th>Names</th>
                    <th>Loanno</th>
                    <th>Amount Applied</th>
                    <th>Amount Approved </th>
                    <th>Repay Rate </th>
                    <th>Is Approved</th>
                    <th>Application Date</th>  
                    <th>Repayment Period</th> 
                    <th> Actions</th>    
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
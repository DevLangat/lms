@extends('admin.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3>All Loan Interests</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin')}}">Home</a></li>
            <li class="breadcrumb-item active">All Loan Interests</li>
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
                    <th>Amount Approved </th>
                    <th>InterestAmount </th>
                    <th>ApprovedBy</th> 
                    <th> Actions</th>                
                  </tr>
                </thead>
                <tbody>

                  @foreach ($showinterests ?? '' as $showinterests)
                  <tr>
                    <td>{{$showinterests->MemberNo}}</td>
                    <td>{{$showinterests->Names}}</td>
                    <td>{{$showinterests->Loanno}}</td>                    
                    <td>{{$showinterests->ApprovedAmount}}</td>
                    <td>{{$showinterests->InterestAmount}}</td>
                    <td>{{$showinterests->ApprovedBy}}</td>                            
                    <td>
                      {{-- ['Loanno','MemberNo','ApprovedAmount','InterestAmount','ApprovedBy'] --}}
                      {{-- <a href="{{url('loan_details')."/".$showloan->id}}" title="View Details"><span class="right badge badge-info"><i class="fa fa-eye"></i></span></a> --}}
                    
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Member No.</th>
                    <th>Names</th>
                    <th>Loanno</th>                     
                    <th>Amount Approved </th>
                    <th>InterestAmount </th>
                    <th>ApprovedBy</th>                     
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
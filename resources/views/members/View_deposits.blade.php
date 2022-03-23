@extends('admin.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3>Deposits Transactions</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin')}}">Home</a></li>
            <li class="breadcrumb-item active">All DEPOSITS</li>
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
                    <th>Receipt No</th>
                    <th>Amount </th>
                    <th>Deposit Type</th>
                    <th>Transaction Date</th>
                   
                  </tr>
                </thead>
                <tbody>

                  @foreach ($deposits ?? '' as $deposits)
                  <tr>
                    <td>{{$deposits->MemberNo}}</td>
                    <td>{{$deposits->Names}}</td>
                    <td>{{$deposits->ReceiptNo}}</td>
                    <td>{{$deposits->Amount}}</td>
                    <td>{{$deposits->Sharetype}}</td>
                    <td>{{$deposits->TransactionDate}}</td>
                                 
                    <td>
                      <a href="{{url('Deposit_Details')."/".$deposits->id}}" title="View Details"><span class="right badge badge-info"><i class="fa fa-eye"></i></span></a>
                      <!-- <a href="{{url('delete_deposit/'.$deposits->id)}}" title="Approve member"><span class="right badge badge-success"><i class="fa fa-check"></i></span></a>
                                 <a href="" title="Review member"><span class="right badge badge-warning"><i class="fas fa-copy"></i></span></a>
                                -->
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Member No.</th>
                    <th>Names</th>
                    <th>Receipt No</th>
                    <th>Amount </th>
                    <th>Deposit Type</th>
                    <th>Transaction Date</th>
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
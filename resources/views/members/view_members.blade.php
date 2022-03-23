@extends('admin.layout')
@section('content')
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
            <li class="breadcrumb-item active">All Members</li>
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
                    <th>National ID.</th>
                    <th>GroupCode</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Kin Name</th>
                    <th>Kin Mobile</th>                  
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach ($members ?? '' as $member)
                  <tr>
                    <td>{{$member->MemberNo}}</td>
                    <td>{{$member->GroupCode}}</td>
                    <td>{{$member->Name}}</td>
                    <td>{{$member->Mobile}}</td>
                    <td>{{$member->Email}}</td>
                    <td>{{$member->KinName}}</td>
                    <td>{{$member->KinMobile}}</td>                   
                    <td>
                      <a href="{{url('members_details')."/".$member->id}}" title="View Details"><span class="right badge badge-info"><i class="fa fa-eye"></i></span></a>
                     
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>National ID.</th>
                    <th>GroupCode</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Kin Name</th>
                    <th>Kin Mobile</th>
                    <th>Actions</th>
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
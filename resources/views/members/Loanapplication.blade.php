@extends('admin.layout')
@section('content')
@include('sweetalert::alert')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    
    <div class="row ">
        <div class="col-md-1"></div>
          
        <div class="col-md-10">

            <div class="card bg-light text-dark mt-2 ">
                <div class="card-header bg-light">
                    <h2 class="text-primary">Loan Application </h2>
                </div>

                <div class="card-body">
                    <p>CLIENT INFORMATION</p>
                        <hr> 
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                    <div class="col-sm-3  mb-3 mt-3 mb-sm-0">        
        
                        <input type="text" name="IDNo" id="IDNo" class="form-control" placeholder="Enter Member ID" required  > 
                        
                    </div>
                    <div class="col-sm-2"> <button id="getdata" class="btn btn-primary mt-3" onclick="submitdata()" >Get Member </button>  </div>
                    <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">        
        
                        <input type="text" id="MaxAmount" readonly class="form-control" >
                        <label>Maximum Loan Limit</label>
                                                      
                       
                    </div>      
                </div>
                    <script>
  
                        function submitdata(){
                          var userid = Number($('#IDNo').val().trim());
                      
                             if(userid > 0){
                      
                               // AJAX POST request
                               $.ajax({
                                  url: "{{url('api/getUserbyid')}}",
                                  type: 'post',
                                  data: { userid: userid},
                                  dataType: 'json',
                                  success: function(response){                      
                                   document.getElementById("Name").value = response.member['Name'];  
                                   document.getElementById("IDNumber").value = response.member['MemberNo']; 
                                   document.getElementById("Deposits").value = response.deposit;                                 
                                   document.getElementById("MaxAmount").value =response.loanlimit;
                                   document.getElementById("MaxAmountForm").value =response.loanlimit;
                                   document.getElementById("IDNo").value = ""; 
                                  }
                               });
                             }
                        }
                        
                      </script>
                    <form method="post" action="{{route('post_loanapplication')}}">
                        @csrf
                                  
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">        
        
                                <input type="text" name="MemberNo" id="IDNumber"  readonly class="form-control" required >
                                <label>ID Number</label>
                                                              
                               
                            </div>  
                            <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Name" class="form-control" id="Name" readonly  required>
                                <label>Member Name</label>
                            </div>
                            <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="number" name="Deposits" id="Deposits" class="form-control" readonly required>
                                <label>Deposit</label>
                            </div>
                        </div>
                        <br>
                        <input type="number" name="LoanLimit" id="MaxAmountForm"  class="form-control" hidden="true" >  
                        <h5>LOAN DETAILS</h5>
                        <hr />
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            
                            <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">
                               
                                <select class="form-control" name="LoanCode" id="Loancode" onchange="change_loantype();"> 
                                <option disabled="" selected=""></option>
                                @foreach ($loantypes ?? '' as $loantype)
                                <option value="{{$loantype->LoanCode}}">{{$loantype->LoanType}} </option>
                                @endforeach
                                </select>
                                <label>Loan Type</label>
                                <script>
                                    function change_loantype() {     
                                        var loancode = $('#Loancode').val().trim();                                   
                                  
                                        // AJAX POST request
                                        $.ajax({
                                        url: "{{url('api/getLoantypes')}}",
                                        type: 'post',
                                        data: { loancode: loancode},
                                        dataType: 'json',
                                        success: function(response){                      
                                            document.getElementById("IntRate").value = response.loantype['Ratio']; 
                                            document.getElementById("loantype").value = response.loantype['LoanType']; 
                                             
                                            //document.getElementById("IDNumber").value = response.member['IdNumber'];  
                                        }
                                        });
                                                                
                                                                            
                                       
                                    }
                                    
                                  </script>
                              </div>
                            <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="IntRate" id="IntRate" class="form-control" readonly  required>
                                <label>Interest</label>
                            </div>
                            <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">
                                <input type="text" name="Loantype" id="loantype"  class="form-control" readonly required >
                                <label>Loan Type</label>
                            </div>                           
                           
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                        <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">                           
                                
                            <select class="form-control" name="Rperiod"  aria-required="true">
                                <option value="0">Please Select Your Period</option>
                                <option value="1"> 1 Month</option>
                                <option value="2"> 2 Months</option>
                                <option value="3"> 3 Months</option>
                                <option value="4"> 4 Months</option>
                                <option value="5"> 5 Months</option>
                                <option value="6"> 6 Months</option>
                                <option value="7"> 7 Months</option>
                                <option value="8"> 8 Months</option>
                                <option value="9"> 9 Months</option>
                                <option value="10"> 10 Months</option>
                                <option value="11"> 11 Months</option>
                                <option value="12"> 12 Months</option>
                            </select>
                            <label >Repayment Period </label>
                        </div>
                        <div class="col-sm-3 form-floating mb-3 mt-3 mb-sm-0">
                            <input type="text" name="AmountApplied" class="form-control" placeholder="Amount Applied" required>
                            <label>Amount Applied</label>
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
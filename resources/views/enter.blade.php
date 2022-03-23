<script>
  function change_member() {     
      var loancode = Number($('#Loancode').val().trim());  
  if(loancode > 0){

      // AJAX POST request
      $.ajax({
      url: "{{url('api/getLoantypes')}}",
      type: 'post',
      data: { loancode: loancode},
      dataType: 'json',
      success: function(response){                      
          document.getElementById("IntRate").value = response.loantype['Ratio'];  
          //document.getElementById("IDNumber").value = response.member['IdNumber'];  
      }
      });
  }                             
                                          
     
  }
</script>
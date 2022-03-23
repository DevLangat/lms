
<script type="text/javascript">     

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
               document.getElementById("IDNumber").value = response.member['IdNumber'];  
              }
           });
         }
    } 
  </script>
 

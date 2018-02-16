<link rel="stylesheet" href="../view/css/style.css">
<form class="content_upload_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="size" value="1000000">
    <?=$message?>
    <div>
        <input type="file" name="image">
    </div>
    <div>
        <textarea name="description" rows="4" cols="40" placeholder="Say something about your pics"></textarea>
    </div>
    <div>
        <input type="submit" name="upload_pic" value="Upload Image">
    </div>
</form>

<script>
$(document).ready(function(){
     $('#insert').click(function(){
          var image_name = $('#image').val();
          if(image_name == '')
          {
               alert("Please Select Image");
               return false;
          }
          else
          {
               var extension = $('#image').val().split('.').pop().toLowerCase();
               if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
               {
                    alert('Invalid Image File');
                    $('#image').val('');
                    return false;
               }
          }
     });
});
</script>

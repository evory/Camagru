<link rel="stylesheet" href="../view/css/style.css">
<form class="content_upload_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="size" value="1000000">
    <?=$message?>
    <div>
        <input type="file" name="image">
    </div>
    <div>
        <input type="submit" name="upload_pic" value="Upload Image">
    </div>
</form>

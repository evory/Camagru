<link rel="stylesheet" href="../view/css/style.css">
<?=$message ?>
		<div class="all-middle-content">
			<div class="sidebar">
				<div class="sidebar_title">
					<h3>Snap</h3>
				</div>
				<canvas class="sidebar_canvas">

				</canvas>
				<div class="sidebar_seeall">
					<a href="#">see all...</a>
				</div>
			</div>
			<div class="content">
				<div class="content_camera">
					<video autoplay id="webcam" width="400" height="300"></video>
					<img id="photo" src="http://placekitten.com/g/400/300" alt="Photo">
					<canvas id="snapshot" width="400" height="300"></canvas>
				</div>
				<div class="content_upload">
				</div>
					<input class="content_capture_btn" id="snapButton" type="button" value="Snap"/>
					<a href="home/upload_pic">upload file</a>
				<div class="content_stickers">
				</div>
			</div>
		</div>

<script type="text/javascript">
	(function() {
		var video = document.getElementById('webcam'),
		canvas = document.getElementById('snapshot'),
		photo = document.getElementById('photo'),
		context = canvas.getContext('2d'),
		vendorUrl = window.URL || window.webkitUrl;

		navigator.getMedia = navigator.getUserMedia ||
							 navigator.webkitGetUserMedia ||
							 navigator.mozGetUserMedia ||
							 navigator.msGetUserMedia;
		navigator.getMedia({
			video: true,
			audio: false
		}, function(stream) {
			video.src = vendorUrl.createObjectURL(stream);
			video.play();
		}, function(error) {
			// an error occured
			// error.code
		});
		document.getElementById('snapButton').addEventListener('click', function(){
			context.drawImage(video, 0, 0, 400, 300);

			// GRAB PHOTO HERE

			photo.setAttribute('src', canvas.toDataURL('image/png'));
			var photo64 = photo.getAttribute('src');
			$.post('controllers/home.php', {variable: photodata64});
		})
	})();
</script>

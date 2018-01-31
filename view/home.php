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
					<video autoplay="true" id="videoElement">
						<script>
						var video = document.querySelector("#videoElement");

						navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

						if (navigator.getUserMedia) {
							navigator.getUserMedia({video: true}, handleVideo, videoError);
						}

						function handleVideo(stream) {
							video.src = window.URL.createObjectURL(stream);
						}

						function videoError(e) {
							// do something
						}
						</script>
					</video>
				</div>
				<button type="submit" class="content_capture_btn">
					SNAP
				</button>
				<div class="content_stickers">
				</div>
			</div>
		</div>

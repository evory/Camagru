		<div class="all-middle-content">
			<div class="sidebar">
				<div class="sidebar_title">
					<?=$message ?>
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
				</div>
				<div class="content_upload">
					<form class="content_upload_form" action="/" method="post" enctype="multipart/form-data">
						<input type="hidden" name="size" value="1000000">
						<div>
							<input type="file" name="image">
						</div>
						<div>
							<textarea name="description" rows="4" cols="40" placeholder="Say something about yout pics"></textarea>
						</div>
						<div>
							<input type="submit" name="upload" value="Upload Image">
						</div>
					</form>
				</div>
				<input class="content_capture_btn" type="button" value="Snap" onclick="onclick();" />
				<div class="content_stickers">
				</div>
			</div>
		</div>

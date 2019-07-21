<div class="row">
	<div class="col-2"></div>
	<div class="col-8">
		<div class="card my-5">
			<div class="card-header">
				Setting database
			</div>
			<div class="card-body">
				<li>Rename file <b>application/config/database.sample.php</b> menjadi <b>application/config/database.php</b></li>
				<?php if(!empty($error)): ?>
				<li>
				Atur koneksi database pada file <b>application/config/database.php</b>, isi bagian - bagian configurasi dengan benar :<br>
				</li>
				<?= $error; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col-2"></div>
</div>
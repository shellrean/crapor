<div class="row">
	<div class="col-2"></div>
	<div class="col-8">
		<div class="card my-5">
			<div class="card-header">
				User administrator
			</div>
            <form action="<?= base_url('install/index/4') ?>" method="post">
			<div class="card-body">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username" value="<?= set_value('username') ?>">
                    <?= form_error('username','<small class="form-text text-danger">','</small>') ?>
                </div>

                <div class="form-group">
                    <label>Nama lengkap</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Masukkan nama lengkap" value="<?= set_value('name') ?>">
                    <?= form_error('name','<small class="form-text text-danger">','</small>') ?>
                </div>    
                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password1" id="password1" placeholder="Masukkan password" >
                        <?= form_error('password1','<small class="form-text text-danger">','</small>') ?>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirm password</label>
                        <input type="password" class="form-control" name="password2" id="password2" placeholder="Masukkan password">
                    </div>
                    </div>
                </div>
			</div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-sm btn-success btn-icon-split">
                    <span class="icon text-white-50">
                    <i class="fas fa-fw fa-angle-double-right"></i>
                    </span>
                    <span class="text">Berikutnya</span>
                </button>
            </div>
            </form>
		</div>
	</div>
	<div class="col-2"></div>
</div>
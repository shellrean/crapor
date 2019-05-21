<div class="row">
	<div class="col-2"></div>
	<div class="col-8">
		<div class="card my-5">
			<div class="card-header">
				Setting data sekolah
			</div>
			<div class="card-body">
            <form action="<?= base_url('install/index/3') ?>" method="post">
                <div class="fom-group">
                    <label>Nama sekolah</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama sekolah">
                </div>
                <div class="fom-group">
                    <label>NPSN/NSS</label>
                    <input type="text" name="nss" class="form-control" placeholder="NPSN/NSS">
                </div>
                <div class="fom-group">
                    <label>NPSN</label>
                    <input type="text" name="npsn" class="form-control" placeholder="NPSN/NSS">
                </div>
                <div class="fom-group">
                    <label>Alamat sekolah</label>
                    <input type="text" name="alamat_sekolah" class="form-control" placeholder="Alamat sekolah">
                </div>
                <div class="fom-group">
                    <label>Kode pos</label>
                    <input type="text" name="kode_pos" class="form-control" placeholder="Kode pos">
                </div>
                <div class="fom-group">
                    <label>Telp</label>
                    <input type="text" name="telp" class="form-control" placeholder="No telp" >
                </div>
                <div class="fom-group">
                    <label>Faks</label>
                    <input type="text" name="faks" class="form-control" placeholder="No faks" >
                </div>
                <div class="fom-group">
                    <label>Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control" placeholder="Kecamatan" >
                </div>
                <div class="fom-group">
                    <label>Kabupaten/Kota</label>
                    <input type="text" name="kota" class="form-control" placeholder="Kabupaten/Kota" >
                </div>
                <div class="fom-group">
                    <label>Provinsi</label>
                    <input type="text" name="provinsi" class="form-control" placeholder="Provinsi">
                </div>
                <div class="fom-group">
                    <label>Website</label>
                    <input type="text" name="website" class="form-control" placeholder="Website">
                </div>
                <div class="fom-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Email" >
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
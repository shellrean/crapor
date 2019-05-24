<table class="table table-striped">
			<tr>
				<th>Nama</th>
				<td><?php echo (isset($siswa)) ? $siswa->nama: ''; ?></td>
				<th>Nomor Telepon</th>
				<td><?php echo (isset($siswa)) ? $siswa->telp: ''; ?></td>
			</tr>
			<tr>
				<th>NISN</th>
				<td><?php echo (isset($siswa)) ? $siswa->nisn: ''; ?></td>
				<th>Email</th>
				<td><?php echo (isset($siswa->email)) ? $email : ''; ?></td>
			</tr>
			<tr>
				<th>Nomor Induk</th>
				<td><?php echo (isset($siswa)) ? $siswa->nis: ''; ?></td>
				<th>Nama Ayah</th>
				<td><?php echo (isset($siswa)) ? $siswa->nama_ayah: ''; ?></td>
			</tr>
			<tr>
				<th>Jenis Kelamin</th>
				<td><?php echo (isset($siswa)) ? ($siswa->jk == 'L') ? 'Laki-laki' : 'Perempuan' : ''; ?></td>
				<th>Pekerjaan Ayah</th>
				<td><?php echo (isset($siswa)) ? $siswa->kerja_ayah: ''; ?></td>
			</tr>
			<tr>
				<th>Agama</th>
				<td>
					<?php 
					echo (isset($siswa)) ? $siswa->agama : ''; 
					?>
				</td>
				<th>Nama Ibu</th>
				<td><?php echo (isset($siswa)) ? $siswa->nama_ibu: ''; ?></td>
			</tr>
			<tr>
				<th>Status dalam Keluarga</th>
				<td><?php echo (isset($siswa)) ? $siswa->status: ''; ?></td>
				<th>Sekolah Asal</th>
				<td><?php echo (isset($siswa)) ? $siswa->sekolah_asal: ''; ?></td>
			</tr>
			<tr>
				<th>Anak Ke</th>
				<td><?php echo (isset($siswa)) ? $siswa->anak_ke: ''; ?></td>
				<th>Diterima tanggal</th>
				<td>
					<?php 
					$diterima = date_create($siswa->diterima);
					echo date_format($diterima,'d-m-Y'); ?>
				</td>
			</tr>
			<tr>
				<th>Alamat</th>
				<td><?php echo (isset($siswa)) ? $siswa->alamat: ''; ?></td>
				<th>Diterima dikelas</th>
				<td><?php echo (isset($siswa)) ? $siswa->diterima_kelas: ''; ?></td>
			</tr>
			<tr>
				<th>RT/RW</th>
				<td><?php echo (isset($siswa)) ? $siswa->rt: ''; ?>/<?php echo (isset($siswa)) ? $siswa->rw: ''; ?></td>
				<th>Nama Wali</th>
				<td><?php echo (isset($siswa)) ? $siswa->nama_wali: ''; ?></td>
			</tr>
			<tr>
				<th>Desa/Kelurahan</th>
				<td><?php echo (isset($siswa)) ? $siswa->desa_kelurahan: ''; ?></td>
				<th>Alamat Wali</th>
				<td><?php echo (isset($siswa)) ? $siswa->alamat_wali: ''; ?></td>
			</tr>
			<tr>
				<th>Kecamatan</th>
				<td><?php echo (isset($siswa)) ? $siswa->kecamatan: ''; ?></td>
				<th>Pekerjaan Ibu</th>
				<td><?php echo (isset($siswa)) ? $siswa->kerja_ibu: ''; ?></td>
			</tr>
			<tr>
				<th>Kodepos</th>
				<td><?php echo (isset($siswa)) ? $siswa->kode_pos: ''; ?></td>
				<th>Pekerjaan Wali</th>
				<td><?php echo (isset($siswa)) ? $siswa->kerja_wali: ''; ?></td>
			</tr>
		</table>
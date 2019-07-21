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
				<th>Nama Ayah</th>
				<td><?php echo (isset($siswa)) ? $siswa->nama_ayah: ''; ?></td>
			</tr>
			<tr>
				<th>Nomor Induk</th>
				<td><?php echo (isset($siswa)) ? $siswa->nis: ''; ?></td>
        <th>Pekerjaan Ayah</th>
				<td><?php echo (isset($siswa)) ? $siswa->pekerjaan_ayah: ''; ?></td>
			</tr>
			<tr>
				<th>Jenis Kelamin</th>
				<td><?php echo (isset($siswa)) ? ($siswa->jk == 'L') ? 'Laki-laki' : 'Perempuan' : ''; ?></td>
				<th>Nama Ibu</th>
				<td><?php echo (isset($siswa)) ? $siswa->nama_ibu: ''; ?></td>
			</tr>
			<tr>
				<th>Agama</th>
				<td>
					<?php 
					echo (isset($siswa)) ? $siswa->agama : ''; 
					?>
				</td>
				<th>Pekerjaan Ibu</th>
				<td><?php echo (isset($siswa)) ? $siswa->pekerjaan_ibu: ''; ?></td>
			</tr>
			<tr>
				<th>Status dalam Keluarga</th>
				<td><?php echo (isset($siswa)) ? $siswa->status_keluarga: ''; ?></td>
				<th>Sekolah Asal</th>
				<td><?php echo (isset($siswa)) ? $siswa->asal_sekolah: ''; ?></td>
			</tr>
			<tr>
				<th>Anak Ke</th>
				<td><?php echo (isset($siswa)) ? $siswa->anak_ke: ''; ?></td>
				<th>Diterima tanggal</th>
				<td>
					<?= $siswa->tgl_diterima ?>
				</td>
			</tr>
			<tr>
				<th>Alamat</th>
				<td><?php echo (isset($siswa)) ? $siswa->alamat: ''; ?></td>
				<th>Diterima dikelas</th>
				<td><?php echo (isset($siswa)) ? $siswa->kelas_diterima: ''; ?></td>
			</tr>
		</table>
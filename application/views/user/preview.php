<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header">
        <a href="<?= base_url('user') ?>" class="btn btn-sm btn-warning btn-icon-split">
          <span class="icon text-white-50">
            <i class="fas fa-fw fa-angle-double-left"></i> 
          </span>
          <span class="text">Kembali</span>
        </a>
      </div>
      <div class="card-body">
        
    <?php
      if(isset($upload_error)){
        echo "<div style='color: red;'>".$upload_error."</div>";
        die;
      }
    ?>
    
    <form method='post' action='<?= base_url("user/import") ?>'>

      <table class='table table-bordered'>
        <tr>
            <th colspan='23'>Preview Data</th>
        </tr>
        <tr>
            <th>Username</th>
            <th>Nama lengkap</th>
            <th>Password</th>
        </tr>
                                
        <?php $numrow = 1; $kosong=0; foreach($sheet as $row){ 

          /* Ambil data pada excel sesuai Kolom */
          $username = $row['A'];
          $name = $row['B'];
          $password = password_hash($row['C'],PASSWORD_DEFAULT);
                                    
          /* Cek jika semua data tidak diisi */
          if(empty($nusernameis) && empty($name) && empty($password))
          continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
                                    
        /* ---------------------------------------------------
         * Cek $numrow apakah lebih dari 1
         * Artinya karena baris pertama adalah nama-nama kolom
         * Jadi dilewat saja, tidak usah diimport
         * ---------------------------------------------------
         */
        if($numrow > 1){
            /* Validasi apakah semua data telah diisi */
            $name_td = ( ! empty($name)) ? "" : " style='background: #E07171;'";
            $username_td = ( ! empty($username))? "" : " style='background: #E07171;'";
            $password_td = ( ! empty($password))? "" : " style='background: #E07171;'";

            /* Jika salah satu data ada yang kosong */
            if(empty($username) or empty($name) or empty($password)){
              $kosong++; /* Tambah 1 variabel $kosong */
            }
                                        
            echo "<tr>";
            echo "<td".$username_td.">".$username."</td>";
            echo "<td".$name_td.">".$name."</td>";
            echo "<td".$password_td.">".$password."</td>";
            echo "</tr>";
        }
        $numrow++; /* Tambah 1 setiap kali looping */
        }
                                
        echo "</table>";
                                
        /* -----------------------------------------------------
         * Cek apakah variabel kosong lebih dari 0
         * Jika lebih dari 0, berarti ada data yang masih kosong
         * -----------------------------------------------------
         */
        if($kosong > 0){
        ?>
        <?php
        }else{ // Jika semua data sudah diisi

          // Buat sebuah tombol untuk mengimport data ke database
          echo '
          </div>
          <div class="card-footer text-muted">
            <button type="submit" class="btn btn-sm btn-success btn-icon-split">
              <span class="icon text-white-50">
                <i class="far fa-save"></i>
              </span>
              <span class="text">Import data & simpan</span>
            </button>
          </div>
          ';
            
        } ?>
        </form>
        </div>
    </section>

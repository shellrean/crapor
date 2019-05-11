<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          Activity
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                          <th>Waktu</th>
                          <td>Aktifitas</td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($activity as $a): ?>
                      <tr>
                        <td><?= $a->time ?> </td>
                        <td><?= $a->desc ?></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
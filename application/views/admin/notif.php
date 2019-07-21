<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="card mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('panel/create_notif') ?>" class="btn btn-sm btn-info btn-icon-split">
            <span class="icon text-white-50">
              <i class="far fa-plus-square"></i>
            </span>
            <span class="text">Tambah notifikasi</span>
          </a>
      
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Title</th>
                            <td>Description</td>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach($notifs as $n): ?>
                        <tr>
                          <td>
                            <div class="icon-circle <?= $n->bg ?>">
                              <i class="<?= $n->icon ?> text-white"></i>
                            </div>
                          </td>
                          <td><?= $n->title ?></td>
                          <td><?= $n->notif ?></td>
                          <td></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
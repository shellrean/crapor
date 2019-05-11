<div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <a href="<?= base_url('user') ?>" class="btn btn-sm btn-warning btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-fw fa-angle-double-left"></i> 
        </span>
        <span class="text">Kembali</span>
      </a>
    </div>
    <form method="post" enctype="multipart/form-data">
    <div class="card-body">
      <div class="form-group">
        <input type="file" name="file" id="fileupload">
      </div>
      <div class="progress">
        <div class="progress-bar progress-bar-striped bg-info" id="progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100">
        <span id="status"></span>
      </div>
      </div>
    </div>

    <div class="card-footer text-muted">
    </div>
    </form>
  </div>
</div>
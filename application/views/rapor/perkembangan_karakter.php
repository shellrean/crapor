 <div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <a href="<?= base_url('rapor/format_karakter') ?>" class="btn btn-sm btn-success btn-icon-split">
        <span class="icon text-white-50">
          <i class="fas fa-fw fa-cloud-download-alt"></i> 
        </span>
        <span class="text">Download format</span>
      </a>
      <a href="<?= base_url('rapor/karakter_reset') ?>" class="btn btn-sm btn-warning btn-icon-split" id="reset">
        <span class="icon text-white-50">
          <i class="fas fa-fw fa-sync"></i> 
        </span>
        <span class="text">Reset Data</span>
      </a>
    </div>
    <form method="post" enctype="multipart/form-data">
    <div class="card-body">
      <div class="form-group">
        <input type="hidden" id="url" value="<?= base_url('rapor/import_karakter') ?>">
        <input type="file" name="import_karakter" id="fileupload">
      </div>
      <div class="progress"> 
        <div class="progress-bar progress-bar-striped bg-info" id="progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100">
      </div>
      </div>
    </div>
    </form> 
  </div>
</div>
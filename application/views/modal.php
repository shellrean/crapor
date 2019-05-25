<div class="modal-dialog <?= isset($modal_s) ? $modal_s : 'modal-lg'; ?>">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title"><?= isset($modal_title) ? $modal_title : 'Modal Title'; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
      <?= $content_view; ?>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      <?= isset($modal_footer) ? $modal_footer : ''; ?>
    </div>
  </div>
</div>
 
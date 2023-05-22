<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Driving License & Details</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Document Type</label>
                <input type="text" class="form-control" id="document_type" value="<?= $documents ? $documents->document_type : '' ?>" readonly="">
            </div>
            <div class="form-group">
                <label>Document Number</label>
                <input type="text" class="form-control" id="document_number" value="<?= $documents ? $documents->document_number : '' ?>" readonly="">
            </div>
            <div class="form-group">
                <label>Front Photo</label>
                <div class="form-group">
                    <?php
                    $front_photo = $documents ? $documents->front_photo : '';
                    ?>
                    <img src="<?= getImage('user_documents', $front_photo) ?>" height="200" width="200">
                </div>
                <?php /*
                  <div class="row text-center">
                  <div class="col-md-6">
                  <label>Front Photo</label>
                  <div class="form-group">
                  <?php
                  $front_photo = $documents ? $documents->front_photo : '';
                  ?>
                  <img src="<?= getImage('user_documents', $front_photo) ?>" height="200" width="200">
                  </div>
                  </div>
                  <div class="col-md-6">
                  <label>Back Photo</label>
                  <div class="form-group">
                  <?php
                  $back_photo = $documents ? $documents->back_photo : '';
                  ?>
                  <img src="<?= getImage('user_documents', $back_photo) ?>" height="200" width="200">
                  </div>
                  </div>
                  </div> */ ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
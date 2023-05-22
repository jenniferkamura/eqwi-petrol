<div class="modal-dialog modal-lg" style="width: 70%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Invoice Detail
                <span>
                    &nbsp; <a class="label label-primary" href="javascript:void(0);" onclick="print_invoice('<?= $order_id ?>')">Print Invoice</a>
                </span>
            </h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="">
                        <div class="box-body">
                            <div class="row">
                                <?php
                                echo $invoice_detail;
                                ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-body">
            <br/>
            <page id="invoice_html" backtop="30mm" backbottom="20mm" backleft="5mm" backright="5mm"> 
                <page_header>
                    <table style="width: 100%;text-align: center;font-weight: bold;font-size: 20px;">
                        <tr>
                            <td>Invoice</td>
                        </tr>
                    </table>
                    <br/>
                </page_header>
                <table style="width: 100%;border-collapse: collapse;border: 0;vertical-align: top;">
                    <thead>
                        <tr>
                            <td style="width:33%;border: 1px solid #d3d3d3;vertical-align: top;padding: 5px;" colspan="2">
                                <b><?= $address_data['shipping_info'] && $address_data['shipping_info']->station_name ? $address_data['shipping_info']->station_name : '' ?></b><br/>
                                <?= $address_data['shipping_info'] && $address_data['shipping_info']->address ? $address_data['shipping_info']->address : '' ?><br/>
                                Contact Person: <?= $address_data['shipping_info'] && $address_data['shipping_info']->contact_person ? $address_data['shipping_info']->contact_person : '' ?><br/>
                                Mo: <?= $address_data['shipping_info'] && $address_data['shipping_info']->contact_number ? $address_data['shipping_info']->contact_number : '' ?>
                            </td>
                            <td style="width:33%;border: 1px solid #d3d3d3;vertical-align: top;padding: 5px;" colspan="2">                                
                                <b>Eqwipetrol</b><br/>
                                <?= $address_data['billing_info'] && $address_data['billing_info']->address ? $address_data['billing_info']->address : '' ?><br/>                                
                                <?= $address_data['billing_info'] && $address_data['billing_info']->contact_no ? $address_data['billing_info']->contact_no : '' ?>                                
                            </td>
                            <td style="width:34%;border: 1px solid #d3d3d3;padding: 0;">
                                <table style="width: 100%;vertical-align: top;border-collapse: collapse;">
                                    <tr>
                                        <td style="border-bottom: 1px solid #d3d3d3;width: 100%;padding: 2px;">&nbsp;Order Number : <b><?= $order_data && $order_data->order_id ? $order_data->order_id : '' ?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #d3d3d3;width: 100%;padding: 2px;border-left: 0;border-right: 0;">&nbsp;Order Date : <b><?= $order_data && $order_data->order_date ? date('d/m/Y', strtotime($order_data->order_date)) : '' ?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #d3d3d3;width: 100%;padding: 2px;border-left: 0;border-right: 0;">&nbsp;Invoice Number : <b><?= $transaction && $transaction->receipt_no ? $transaction->receipt_no : '' ?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="border-top: 1px solid #d3d3d3;width: 100%;padding: 2px;">&nbsp;Bill Number : <b><?= $transaction && $transaction->payment_ref_id ? $transaction->payment_ref_id : '' ?></b></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:100%;border: 1px solid #d3d3d3;padding: 0;" colspan="5">
                                <table style="width: 100%;vertical-align: top;border-collapse: collapse;">
                                    <tr>
                                        <th style="width: 10%;border: 1px solid #d3d3d3;padding: 3px;text-align: center;">Sr</th>
                                        <th style="width: 40%;border: 1px solid #d3d3d3;padding: 3px;text-align: center;">Item</th>
                                        <th style="width: 10%;border: 1px solid #d3d3d3;padding: 3px;text-align: center;">Qty</th>
                                        <th style="width: 20%;border: 1px solid #d3d3d3;padding: 3px;text-align: center;">Price</th>
                                        <th style="width: 20%;border: 1px solid #d3d3d3;padding: 3px;text-align: center;">Total</th>
                                    </tr>
                                    <?php
                                    /* if ($invoice_detail && $invoice_detail->Items) {
                                      $sr = 1;
                                      foreach ($invoice_detail->Items as $products) {
                                      $total = round($products->Quantity * $products->UnitPrice, 2);
                                      ?>
                                      <tr>
                                      <td style="width: 10%;border: 1px solid #d3d3d3;padding: 3px;text-align: center;"><?= $sr++ ?></td>
                                      <td style="width: 40%;border: 1px solid #d3d3d3;padding: 3px;"><?= $products->ItemName ?></td>
                                      <td style="width: 10%;border: 1px solid #d3d3d3;padding: 3px;text-align: center;"><?= $products->Quantity ?></td>
                                      <td style="width: 20%;border: 1px solid #d3d3d3;padding: 3px;text-align: center;"><?= $invoice_detail->Currency . ' ' . number_format($products->UnitPrice, 2) ?></td>
                                      <td style="width: 20%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;"><?= $invoice_detail->Currency . ' ' . number_format($total, 2) ?></td>
                                      </tr>
                                      <?php
                                      }
                                      ?>
                                      <tr>
                                      <td style="width:80%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;font-weight: bold;" colspan="4">Total Amount</td>
                                      <td style="width:20%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;font-weight: bold;"><?= $invoice_detail->Currency . ' ' . number_format($invoice_detail->Amount, 2) ?></td>
                                      </tr>
                                      <?php
                                      } */

                                    if ($invoice_detail) {
                                        $sr = 1;
                                        foreach ($invoice_detail as $products) {
                                            ?> 
                                            <tr>
                                                <td style="width: 10%;border: 1px solid #d3d3d3;padding: 3px;text-align: center;"><?= $sr++ ?></td>
                                                <td style="width: 40%;border: 1px solid #d3d3d3;padding: 3px;"><?= $products->name ?></td>
                                                <td style="width: 10%;border: 1px solid #d3d3d3;padding: 3px;text-align: center;"><?= $products->qty ?></td>
                                                <td style="width: 20%;border: 1px solid #d3d3d3;padding: 3px;text-align: center;"><?= $invoice_detail->currency . ' ' . number_format($products->price, 2) ?></td>
                                                <td style="width: 20%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;"><?= $invoice_detail->currency . ' ' . number_format($products->total_price, 2) ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td style="width:80%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;font-weight: bold;" colspan="4">Total Amount</td>
                                            <td style="width:20%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;font-weight: bold;"><?= $order_data->currency . ' ' . number_format($order_data->amount, 2) ?></td>
                                        </tr>
                                        <?php if (isset($order_data) && round($order_data->discount)) { ?>
                                            <tr>
                                                <td style="width:80%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;font-weight: bold;" colspan="4">Discount</td>
                                                <td style="width:20%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;font-weight: bold;"><?= $order_data->currency . ' ' . number_format($order_data->discount, 2) ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td style="width:80%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;font-weight: bold;" colspan="4">Shipping Charge</td>
                                            <td style="width:20%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;font-weight: bold;"><?= $order_data->currency . ' ' . number_format($order_data->shipping_charge, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:80%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;font-weight: bold;" colspan="4">Tax</td>
                                            <td style="width:20%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;font-weight: bold;"><?= $order_data->currency . ' ' . number_format($order_data->tax, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:80%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;font-weight: bold;" colspan="4">Grand Total</td>
                                            <td style="width:20%;border: 1px solid #d3d3d3;padding: 3px;text-align: right;font-weight: bold;"><?= $order_data->currency . ' ' . number_format($order_data->total_amount, 2) ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </page>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

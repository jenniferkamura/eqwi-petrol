<?php
$currency_code = $this->common_model->getSiteSettingByTitle('currency_symbol');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
        <title>Pay Now</title>
    </head>
    <body>
        <div class="flex justify-center items-center min-h-screen">
            <div class="w-full max-w-2xl">

            </div>
        </div>
        <script type="text/javascript" src="https://checkout-v3-test.jambopay.co.ke/sdk/checkout-staging-sdk.js"></script>
        
        <script type="text/javascript">
            //a function that launches the checkout on form submit
            startCheckout();

            function startCheckout() {

                const has_jp_logo = '';//getElementById('has_jp_logo').checked
                const callback_typ = '';//getElementById('callback_type').value

                //create the checkout ddetails. the items can also be injected from the backend.
                const checkoutDetails = {
                    OrderId: '<?= $transaction->transaction_id ?>',
                    CustomerEmail: '<?= $transaction->email ?>',
                    Currency: 'KES',
                    CustomerPhone: '<?= $transaction->mobile ?>',
                    OrderAmount: '<?= $transaction->amount ?>',
                    BusinessEmail: '<?= $client_email ?>',
                    ClientKey: '<?= $client_key ?>',
                    CancelledUrl: '<?= base_url('payment/cancel') ?>',
                    CallBackUrl: '<?= base_url('payment/success') ?>',
                    Description: 'Purchase',
                    SupportEmail: '',
                    SupportPhone: '',
                    UseJPLogo: 'yes',
                    StoreName: '<?= $transaction->name ?>',
                    SystemCallback: true
                };
 
                jambopayCheckout(checkoutDetails, callback_func);
                /*if (callback_typ === 'function') {
                 //call this function if you dont need the callback submit
                 //and want to handle it on your own using javascript. Suitable for
                 //those having single page applications
                 jambopayCheckout(checkoutDetails, callback_func)
                 } else {
                 //Call this if you desire to have the transaction information
                 //posted to your callback url. This form post leads to a page refresh/redirect
                 jambopayCheckout(checkoutDetails)
                 }*/
                return false;
            }

            /**
             * 
             * A function to be called when the transaction callback information is received.
             * This function is suitable if you do not need to have 
             */
            function callback_func(data) {
                console.log('Callback successful!', data);
                //send it to your backend as you wish :)
                /*
                const frm = document.createElement("form");
                for (const ke in data) {
                    if(ke !== 'callback'){
                        const input = document.createElement("input");
                        input.type = "text";
                        input.name = ke;
                        input.setAttribute('value',data[ke])
                        frm.appendChild(input);
                    }

                }
                document.body.appendChild(frm);
                frm.method = "POST";
                frm.action = data.callback;
                frm.submit();*/
            }


        </script>

    </body>
</html>
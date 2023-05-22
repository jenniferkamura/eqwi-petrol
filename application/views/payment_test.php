<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

    <style>
        .fixedSectionSize {
            min-width: 500px;
            min-height: 500px;
        }
        .toggle-container {
            display:flex;
            align-items: center;
            margin:10px 0;
            width:200px;
        }
        .toggle-checkbox {
            visibility:hidden;
        }
        .label{
            position:relative;
            background-color:#d0d0d0;
            border-radius: 50px;
            cursor:pointer;
            display:inline-block;
            margin:0 15px 0;
            width:130px;
            height:30px;
        }
        .toggle-checkbox:checked+ .label{
            background-color: #1079ff;
        }
        .ball{
            background-color:white;
            height:25px;
            width:25px;
            border-radius: 50%;
            position:absolute;
            top:3px;
            left:3px;
            align-items: center;
            justify-content: center;
            animation:slideOff 0.3s linear forwards;
        }

        .toggle-checkbox:checked+.label .ball{
            animation:slideOn 0.3s linear forwards;
        }

        @keyframes slideOn{
            0%{
                transform:translateX(0) scale(1);
            }
            50%{
                transform:translateX(20px) scale(1.2);
            }
            100%{
                transform:translateX(40px) scale(1);
            }
        }
        @keyframes slideOff{
            0%{
                transform:translateX(40px) scale(1);
            }
            50%{
                transform:translateX(20px) scale(1.2);
            }
            100%{
                transform:translateX(0px) scale(1);
            }
        }
        .select_chev{
            position:absolute;
            top: 5px;
            right: 10px;
        }
    </style>
    <title>Pay Now</title>
</head>
<body>
<div class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-2xl">
        <div class="text-lfet text-2xl">
            <h2>Merchant Website checkout Form</h2>
        </div>
        <form onsubmit="return startCheckout(event)" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-wrap items-center">
            <div class="mb-4 mr-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="order_id">
                    Order ID
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="order_id" type="text">
            </div>
            <div class="flex items-center justify-between mt-2">
                <button onclick="createOrderID()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                    Generate Order ID
                </button>
            </div>
            <div class="mb-6 mr-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="customer_phone">
                    Customer Phone
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="customer_phone" type="number">
            </div>
            <div class="mb-6 mr-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="customer_email">
                    Customer Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="customer_email" type="email">
            </div>

            <div class="mb-6 mr-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="order_amount">
                    Order Amount
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="order_amount" type="number">
            </div>
            <div class="mb-6 mr-4 w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" type="text">
            </div>
            <div class="mb-6 mr-4 w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="store_name">
                    Store Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="store_name" type="text">
            </div>
            <div class="mb-6 mr-4 w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="business_email">
                    Business Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="business_email" type="email">
            </div>
            <div class="mb-6 mr-4 w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="business_email">
                    ClientKey
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="client_key" type="text">
            </div>

            <div class="mb-6 mr-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="support_email">
                    Support Email
                </label>
                <input placeholder="leave blank to use jambopay email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="support_email" type="email">
            </div>
            <div class="mb-6 mr-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="support_phone">
                    Support PhoneNumber
                </label>
                <input placeholder="leave blank to use jambopay support number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="support_phone" type="number">
            </div>
            <div class="mb-6 mr-4">
                <label for="callback_type" class="block text-gray-700 text-sm font-bold mb-2">Use redirect or attach a callback function</label>
               <div class="relative">
                <select id="callback_type" class="bg-transparent shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="url">Callback Urls</option>
                    <option value="function">Callback Function</option>
                </select>
                   <div class="select_chev" >
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                       </svg>
                   </div>

               </div>
            </div>
            <div class="mb-6 mr-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="callback_url">
                    Callback Url
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="callback_url" type="text">
            </div>
            <div class="mb-6 mr-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="cancel_url">
                    Cancel Url
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="cancel_url" type="text">
            </div>
            <div class="mb-6 mr-4">
                <div class="toggle-container flex">
                    <input id="has_jp_logo" class="toggle-checkbox" checked type="checkbox" value="" >
                    <label for="has_jp_logo" class="label">
                        <div class="ball"></div>
                    </label>
                    <div>Has Jambopay logo</div>
                </div>
            </div>
            <div class="flex items-center justify-between w-full">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Pay Now
                </button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="https://checkout-v3-test.jambopay.co.ke/sdk/checkout-staging-sdk.js"></script>

<script type="text/javascript">
    //for example. In real life don't call setupDummyData
    setupDummyData()
    //a function that launches the checkout on form submit
    function startCheckout(event){
        event.preventDefault()

        const has_jp_logo = document.getElementById('has_jp_logo').checked
        const callback_typ = document.getElementById('callback_type').value

        //create the checkout ddetails. the items can also be injected from the backend.
        const checkoutDetails = {
            OrderId: document.getElementById('order_id').value.toString(),
            CustomerEmail: document.getElementById('customer_email').value.trim(),
            Currency: 'KES',
            CustomerPhone: document.getElementById('customer_phone').value.trim(),
            OrderAmount: document.getElementById('order_amount').value.trim(),
            BusinessEmail:  document.getElementById('business_email').value.trim(),
            ClientKey: document.getElementById('client_key').value.trim(),
            CancelledUrl: document.getElementById('cancel_url').value.trim(),
            CallBackUrl:  document.getElementById('callback_url').value.trim(),
            Description:  document.getElementById('description').value.trim(),
            SupportEmail:  document.getElementById('support_email').value.trim(),
            SupportPhone:  document.getElementById('support_phone').value.trim(),
            UseJPLogo:has_jp_logo ? 'yes' : 'no',
            StoreName:document.getElementById('store_name').value.trim(),
        }
        
        
        if(callback_typ === 'function'){
            //call this function if you dont need the callback submit
            //and want to handle it on your own using javascript. Suitable for
            //those having single page applications
            jambopayCheckout(checkoutDetails,callback_func)
        }else{
            //Call this if you desire to have the transaction information
            //posted to your callback url. This form post leads to a page refresh/redirect
            jambopayCheckout(checkoutDetails)
        }


        return false
    }

    /**
     * 
     * A function to be called when the transaction callback information is received.
     * This function is suitable if you do not need to have 
     */
    function callback_func(data){
        console.log('Callback successful!',data);
        //send it to your backend as you wish :)
    }


</script>

</body>
</html>
<head>
    <meta charset="utf-8">
    <script src="https://js.braintreegateway.com/web/dropin/1.26.0/js/dropin.min.js"></script>
</head>
<body>
    <!-- Step one: add an empty container to your page -->
    <form id="payment-form" action="{{route ('payment') }}" method="post">
        @csrf
        <label for="amount">
            <span class="input-label">Amount</span>
            <div class="input-wrapper amount-wrapper">
                <input id="amount" name="amount" type="tel" min="1" placeholder="Amount" value="10">
            </div>
        </label>

        {{-- <div id="dropin-container">
        </div> --}}
        <div class="bt-drop-in-wrapper">
            <div id="bt-dropin"></div>
        </div>

        <input type="submit" />
        <input type="hidden" id="nonce" name="payment_method_nonce"/>
    </form>



    {{-- <form method="post" id="payment-form" action="{{route ('payment') }}">
        @csrf
        <section>
            <label for="amount">
                <span class="input-label">Amount</span>
                <div class="input-wrapper amount-wrapper">
                    <input id="amount" name="amount" type="tel" min="1" placeholder="Amount" value="10">
                </div>
            </label>

            <div class="bt-drop-in-wrapper">
                <div id="bt-dropin"></div>
            </div>
        </section>

        <input id="nonce" name="payment_method_nonce" type="hidden" />
        <button class="button" type="submit"><span>Test Transaction</span></button>
    </form> --}}

    
  
    <script type="text/javascript">
        const form = document.getElementById('payment-form');
        // console.log({{ $clientToken }});

        braintree.dropin.create({
            authorization: "@php echo($clientToken) @endphp",
            // container: document.getElementById('dropin-container'),
            selector: '#bt-dropin',
            paypal: {
                flow: 'vault'
            }

            // ...plus remaining configuration
        }, (error, dropinInstance) => {
            if (error) console.error(error);
            
            form.addEventListener('submit', event => {
                event.preventDefault();
                
                dropinInstance.requestPaymentMethod((error, payload) => {
                    if (error) console.error(error);
                    
                    document.getElementById('nonce').value = payload.nonce;
                    form.submit();
                
                });
            });
        });
            
    </script>
</body>




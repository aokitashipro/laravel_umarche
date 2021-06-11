<p>決済ページへリダイレクトします。</p> 
<script src="https://js.stripe.com/v3/"></script>
<script>
  const publicKey = '{{ $publicKey }}'
  const stripe = Stripe(publicKey)

  window.onload = function() {         
    stripe.redirectToCheckout({             
      sessionId: '{{ $session->id }}'         
      }).then(function (result) {             
        window.location.href = '{{ route('user.cart.index') }}';         
        });
  } 

</script>
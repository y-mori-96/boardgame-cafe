<p>決済ページへリダイレクトします。</p>
<script src="https://js.stripe.com/v3/"></script>

<script>
     const publicKey = '{{ $publicKey }}'
     const stripe = Stripe(publicKey)
    
     window.onload = function() {
          stripe.redirectToCheckout({
               sessionId: '{{ $session->id }}'
          }).then(function (result) {
               window.location.href = '{{ route('cart.cancel') }}';
          });
     }
</script>

<!--支払いが成功しました     4242 4242 4242 4242-->
<!--支払いには認証が必要です 4000 0025 0000 3155-->
<!--支払いが拒否されました   4000 0000 0000 9995-->
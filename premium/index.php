<?php

include($_SERVER["DOCUMENT_ROOT"] . "/functions.php");

include($_SERVER["DOCUMENT_ROOT"] . "/views/header.php");

?>



<div class="container" style="margin: 0 auto; padding-bottom:50px;">
  <div id="paypal-button-container-P-4MK04181FA8484949MNR4RSI"></div>
  <script src="https://www.paypal.com/sdk/js?client-id=AZ9_3ez6llkVnbuf3HT8xu4iL42WYJtKCwzVBs0fb0OMloX6gx2QCYITrvZ8v2Pvnl7TiJUFgZ_NJ-Kx&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
  <script>
    paypal.Buttons({
        style: {
            shape: 'rect',
            color: 'gold',
            layout: 'vertical',
            label: 'subscribe'
        },
        createSubscription: function(data, actions) {
          return actions.subscription.create({
            /* Creates the subscription */
            plan_id: 'P-4MK04181FA8484949MNR4RSI'
          });
        },
        onApprove: function(data, actions) {
          alert(data.subscriptionID); // You can add optional success message for the subscriber here
        }
    }).render('#paypal-button-container-P-4MK04181FA8484949MNR4RSI'); // Renders the PayPal button
  </script>

</div>

<?php 
    include($_SERVER["DOCUMENT_ROOT"] ."/views/footer.php");
?>
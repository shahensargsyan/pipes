{{ header }}

<h2>Order successfully!</h2>

<p>Hi {{ customer_name }},</p>
<p>Thank you for purchasing our products, we will contact you via phone <strong>{{ customer_phone }}</strong> to confirm order!</p>

<br />

<h3>Order information: </h3>

<p>Order<strong># {{ order_id }}  {{ order_date }}</strong></p>

{{ product_list }}

It usually takes up to 2 business days to prepare an order for the dispatch. Once your order has been shipped, you will receive an email confirmation.

Best Regards,
Garden Hose Pro Team

<h3>Customer information</h3>

{{ footer }}

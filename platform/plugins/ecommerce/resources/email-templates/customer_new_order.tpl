{{ header }}

<h2>Thank you for your order</h2>

<p>Hi {{ customer_name }},</p>
<p>Thank you for your order! We hope you enjoyed shopping with us. We've received your order #{{ order_id }}, and will begin working on it right away.</p>

<br />

<h3>Order information: </h3>

<p>Order<strong># {{ order_id }}  {{ order_date }}</strong></p>

{{ product_list }}

<h3>Billing address</h3>
<p>{{ customer_name }}</p>
<p>{{ customer_address }}</p>
<p>{{ customer_phone }}</p>

<br />
<h3>Shipping address</h3>
<p>{{ customer_name }}</p>
<p>{{ customer_address }}</p>
<p>{{ customer_phone }}</p>


It usually takes up to 2 business days to prepare an order for the dispatch. Once your order has been shipped, you will receive an email confirmation.

Best Regards,
Garden Hose Pro Team

{{ footer }}

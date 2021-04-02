{{ header }}

<h2>Your Garden Hose Pro order has been shipped</h2>

<p>Hi  {{ customer_name }},</p>

<p>Your order was shipped today. Please check the form for details: </p>

[Order #{{ order_id }}] (October 22, 2020)
<br />

<h3>Order information: </h3>

<p>Order number: <strong>#{{ order_id }}</strong></p>

{{ product_list }}

<br />

{{ footer }}

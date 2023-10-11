<!DOCTYPE html>
<html>
<head>
    <title>Your Safelink Networking Device Activation Key</title>
</head>
<body>
<p>Dear {{ $mailData['customer_name'] }}</p>

<p>We extend our heartfelt gratitude for choosing Safelink as your networking solutions provider! We are thrilled to provide you with the activation key that will unlock the full capabilities of your Safelink networking device.</p>

<p>Here are the pertinent details regarding your recent purchase:</p>


<ul class="list-arrow">
   <li>Company Name: Safelink</li>
   <li>Product: {{ $mailData['product_name'] }}</li>
   <li>Purchase Date: {{ $mailData['product_purchase_date'] }}</li>
   <li>Safelink ID: {{ $mailData['safelink_id'] }}</li>
   <li>Safelink Name: {{ $mailData['safelink_name'] }}</li>
   <li>Purchaser Organization: {{ $mailData['company_name'] }}</li>
   <li>Billing Address: {{ $mailData['address'] }}</li>
</ul>

<p>Without any delay, here's your unique Activation Key:</p>

<h3>{{ $mailData['node_key'] }}</h3>

<p>
    This key, comprising 16 alphanumeric characters, is pivotal for activating your networking device. Safeguard this key diligently and avoid sharing it with others. Should you encounter any queries or encounter challenges during the activation process, our dedicated customer support team is ready to assist you. Simply reach out to them at support.safe-link.net for prompt and efficient help.
</p>

<p>
    At Safelink, we're genuinely committed to providing top-notch networking solutions, and we're confident that our devices will excel in meeting your requirements. If you have any further queries or require additional information, please don't hesitate to contact us.
</p>

<p>
    Thank you once again for choosing Safelink as your networking partner. We eagerly anticipate being a part of your networking journey.
</p>

<p>Best regards,</p>
<p>SafeLink Team</p>
</body>
</html>

@extends('layouts.home')

@section('title', 'Delivery Policy')

@section('content')
<style>
    .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.95;
        }
        
        </style>

                <div class="header">
        <h1>Delivery Policy</h1>
        <!-- <p>Your satisfaction is our priority. Easy returns within 30 days.</p> -->
    </div>

                <div class="policy-content">
                    <section class="policy-section mb-5">
                        <h2 class="h3 mb-3">Delivery Areas</h2>
                        <p>We currently deliver to the following regions:</p>
                        <ul>
                            <li>All major cities within Bangladesh</li>
                            <li>Selected rural and suburban areas</li>
                            <li>International shipping available for select countries</li>
                        </ul>
                        <p>Please enter your postal code at checkout to verify if delivery is available in your area.</p>
                    </section>

                    <section class="policy-section mb-5">
                        <h2 class="h3 mb-3">Delivery Timeframes</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Delivery Type</th>
                                        <th>Estimated Time</th>
                                        <th>Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Standard Delivery</td>
                                        <td>3-5 business days</td>
                                        <td>৳50 - ৳100</td>
                                    </tr>
                                    <tr>
                                        <td>Express Delivery</td>
                                        <td>1-2 business days</td>
                                        <td>৳150 - ৳250</td>
                                    </tr>
                                    <tr>
                                        <td>Same Day Delivery</td>
                                        <td>Within 24 hours</td>
                                        <td>৳300+</td>
                                    </tr>
                                    <tr>
                                        <td>International Shipping</td>
                                        <td>7-14 business days</td>
                                        <td>Calculated at checkout</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-muted small">* Delivery times may vary during peak seasons or due to unforeseen circumstances.</p>
                    </section>

                    <section class="policy-section mb-5">
                        <h2 class="h3 mb-3">Shipping Charges</h2>
                        <p>Shipping charges are calculated based on:</p>
                        <ul>
                            <li>Delivery location and distance</li>
                            <li>Order weight and dimensions</li>
                            <li>Selected delivery speed</li>
                        </ul>
                        <div class="alert alert-success">
                            <strong>Free Shipping:</strong> Available on orders over ৳1,000 for standard delivery within major cities.
                        </div>
                    </section>

                    <!-- <section class="policy-section mb-5">
                        <h2 class="h3 mb-3">Order Processing</h2>
                        <p>Orders are processed within 1-2 business days after payment confirmation. You will receive:</p>
                        <ol>
                            <li>Order confirmation email immediately after purchase</li>
                            <li>Shipping confirmation with tracking number once dispatched</li>
                            <li>Delivery updates via SMS and email</li>
                        </ol>
                    </section> -->

                    <!-- <section class="policy-section mb-5">
                        <h2 class="h3 mb-3">Tracking Your Order</h2>
                        <p>Once your order is shipped, you can track it using:</p>
                        <ul>
                            <li>The tracking link provided in your shipping confirmation email</li>
                            <li>Your account dashboard on our website</li>
                            <li>Our customer service team</li>
                        </ul>
                    </section> -->

                    <!-- <section class="policy-section mb-5">
                        <h2 class="h3 mb-3">Delivery Attempts</h2>
                        <p>Our delivery partners will make up to 3 attempts to deliver your order:</p>
                        <ul>
                            <li>First attempt on the scheduled delivery date</li>
                            <li>Second attempt within the next business day</li>
                            <li>Final attempt as per customer's convenience</li>
                        </ul>
                        <p>If delivery cannot be completed after 3 attempts, the order will be returned to our warehouse, and you will be contacted for further instructions.</p>
                    </section>

                    <section class="policy-section mb-5">
                        <h2 class="h3 mb-3">Delivery Instructions</h2>
                        <p>To ensure smooth delivery:</p>
                        <ul>
                            <li>Provide accurate and complete delivery address</li>
                            <li>Include contact number for delivery coordination</li>
                            <li>Specify any special delivery instructions during checkout</li>
                            <li>Ensure someone is available to receive the package</li>
                        </ul>
                    </section> -->

                    <!-- <section class="policy-section mb-5">
                        <h2 class="h3 mb-3">Damaged or Missing Items</h2>
                        <p>If your order arrives damaged or with missing items:</p>
                        <ol>
                            <li>Do not accept the delivery if packaging is severely damaged</li>
                            <li>Take photos of the damage or missing items</li>
                            <li>Contact our customer service within 48 hours</li>
                            <li>We will arrange for replacement or refund as per our return policy</li>
                        </ol>
                    </section>

                    <section class="policy-section mb-5">
                        <h2 class="h3 mb-3">Holidays and Peak Seasons</h2>
                        <p>During holidays and peak shopping seasons (Eid, New Year, etc.), delivery times may be extended by 2-3 business days. We recommend placing orders early during these periods.</p>
                    </section>

                    <section class="policy-section mb-5">
                        <h2 class="h3 mb-3">Contact Us</h2>
                        <p>For any delivery-related queries, please contact us:</p>
                        <div class="contact-info">
                            <p><strong>Email:</strong> <a href="mailto:support@example.com">support@example.com</a></p>
                            <p><strong>Phone:</strong> +880 1XXX-XXXXXX</p>
                            <p><strong>Hours:</strong> Saturday - Thursday, 9:00 AM - 6:00 PM</p>
                        </div>
                    </section> -->
                </div>

                <!-- <div class="text-center mt-5">
                    <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                    <a href="{{ route('contact.show') }}" class="btn btn-outline-secondary ms-2">Contact Support</a>
                </div> -->
            </div>
        </div>
    </div>
</div>


@endsection
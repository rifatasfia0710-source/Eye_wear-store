@extends('layouts.home')

@section('title', 'return')
@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }

        .header {
            background: linear-gradient(135deg, #dce3ff 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
            margin-top: 30px;
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

        .container {
            max-width: 1000px;
            margin: -30px auto 60px;
            padding: 0 20px;
        }

        .content-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
            padding: 40px;
            margin-bottom: 30px;
        }

        .highlight-box {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            border-left: 4px solid #667eea;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
        }

        .highlight-box h3 {
            color: #4155eeff;
            margin-bottom: 15px;
            font-size: 1.3em;
        }

        .highlight-box ul {
            margin-left: 20px;
        }

        .highlight-box li {
            margin: 8px 0;
        }

        h2 {
            color: #2d3748;
            margin: 30px 0 20px;
            font-size: 1.8em;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        h3 {
            color: #4a5568;
            margin: 25px 0 15px;
            font-size: 1.3em;
        }

        p {
            margin-bottom: 15px;
            color: #4a5568;
        }

        ul, ol {
            margin: 15px 0 15px 30px;
        }

        li {
            margin: 10px 0;
            color: #4a5568;
        }

        .process-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }

        .step {
            background: #f7fafc;
            padding: 25px;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .step:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(102, 126, 234, 0.15);
        }

        .step-number {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 15px;
        }

        .step h4 {
            color: #2d3748;
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .step p {
            font-size: 0.95em;
            margin: 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin: 25px 0;
        }

        .info-card {
            background: #f7fafc;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .info-card h4 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            margin-top: 40px;
        }

        .cta-section h3 {
            color: white;
            margin-bottom: 15px;
            font-size: 1.5em;
        }

        .cta-section p {
            color: white;
            opacity: 0.95;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin: 5px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .important-note {
            background: #fff5f5;
            border-left: 4px solid #f56565;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }

        .important-note strong {
            color: #c53030;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2em;
            }

            .content-card {
                padding: 25px;
            }

            .process-steps {
                grid-template-columns: 1fr;
            }

            h2 {
                font-size: 1.5em;
            }
        }
    </style>

    <div class="header">
        <h1>Returns & Exchanges</h1>
        <p>Your satisfaction is our priority. Easy returns within 30 days.</p>
    </div>

    <div class="container">
        <div class="content-card">
            <div class="highlight-box">
                <h3>🎯 Our Return Promise</h3>
                <ul>
                    <li><strong>30-Day Return Window</strong> - Return or exchange within 30 days of delivery</li>
                    <li><strong>Free Return Shipping</strong> - We cover return shipping costs for defective items</li>
                    <li><strong>100% Satisfaction Guarantee</strong> - If you're not happy, we'll make it right</li>
                    <li><strong>Quick Refunds</strong> - Refunds processed within 5-7 business days</li>
                </ul>
            </div>

            <h2>Return Policy Overview</h2>
            <p>At our eyewear store, we want you to love your new glasses or sunglasses. If for any reason you're not completely satisfied with your purchase, we accept returns and exchanges within 30 days of delivery.</p>

            <h2>Eligibility for Returns</h2>
            
            <h3>Items We Accept for Return:</h3>
            <ul>
                <li>Unworn frames and sunglasses in original condition</li>
                <li>Prescription glasses with incorrect prescriptions (our error)</li>
                <li>Defective or damaged items received</li>
                <li>Items that don't match the product description</li>
                <li>Unopened accessories in original packaging</li>
            </ul>

            <div class="important-note">
                <strong>Please Note:</strong> For hygiene and safety reasons, prescription glasses cannot be returned unless there was an error in manufacturing or prescription fulfillment on our part.
            </div>

            <h3>Items We Cannot Accept:</h3>
            <ul>
                <li>Worn, damaged, or altered eyewear</li>
                <li>Items without original packaging and accessories</li>
                <li>Prescription lenses (unless manufacturing error)</li>
                <li>Custom or personalized items</li>
                <li>Items purchased from unauthorized retailers</li>
            </ul>

            <!-- <h2>How to Return Your Items</h2>
            
            <div class="process-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h4>Initiate Return</h4>
                    <p>Log into your account and go to "My Orders". Select the item you wish to return and click "Request Return".</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h4>Get Return Label</h4>
                    <p>We'll email you a prepaid return shipping label within 24 hours. Print it and attach it to your package.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h4>Pack Your Item</h4>
                    <p>Place the item in its original packaging with all accessories, cases, and cleaning cloths included.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h4>Ship It Back</h4>
                    <p>Drop off your package at any authorized shipping location. Keep your tracking number for reference.</p>
                </div>
            </div>

            <h2>Exchanges</h2>
            <p>Want a different size, color, or style? We make exchanges easy! Simply initiate a return for the item you want to exchange and place a new order for your preferred product. Once we receive your return, we'll process your refund and you'll have your new eyewear on the way.</p>

            <div class="info-grid">
                <div class="info-card">
                    <h4>💳 Refund Timeline</h4>
                    <p>Refunds are processed within 5-7 business days after we receive your return. The amount will be credited to your original payment method.</p>
                </div>
                <div class="info-card">
                    <h4>🚚 Return Shipping</h4>
                    <p>Return shipping is free for defective items or our errors. For standard returns, a $7.99 shipping fee will be deducted from your refund.</p>
                </div>
                <div class="info-card">
                    <h4>🔄 Exchange Processing</h4>
                    <p>Exchanges are treated as returns + new orders to ensure you get your preferred item as quickly as possible.</p>
                </div>
            </div>

            <h2>Damaged or Defective Items</h2>
            <p>If you receive damaged or defective eyewear, please contact us immediately. We'll arrange for a free return and send you a replacement at no additional cost. Please include photos of the damage when submitting your return request.</p>

            <h3>What to Do:</h3>
            <ol>
                <li>Contact our customer service within 48 hours of delivery</li>
                <li>Provide your order number and photos of the damage</li>
                <li>We'll send a prepaid return label immediately</li>
                <li>Your replacement will be shipped as soon as we receive the damaged item</li>
            </ol>

            <h2>Prescription Glasses Returns</h2>
            <p>We take great care in fulfilling prescription orders accurately. If there's an error in your prescription glasses due to our mistake, we'll remake them at no charge or provide a full refund.</p>

            <div class="highlight-box">
                <h3>Prescription Verification Required:</h3>
                <ul>
                    <li>Please verify your prescription with your eye doctor before requesting a return</li>
                    <li>Submit a copy of your current prescription for verification</li>
                    <li>We'll review the order and determine if the error was on our end</li>
                    <li>If confirmed, we'll provide a free remake or full refund including shipping</li>
                </ul>
            </div>

            <h2>International Returns</h2>
            <p>International customers can return items within 30 days of delivery. However, customers are responsible for return shipping costs and any customs fees. Refunds will be issued in the original currency of purchase.</p> -->

            <!-- <h2>Special Circumstances</h2>
            
            <h3>Late Delivery Claims:</h3>
            <p>If your order arrives after the 30-day return window due to shipping delays beyond your control, please contact us. We'll work with you to find a solution.</p>

            <h3>Gift Returns:</h3>
            <p>Items purchased as gifts can be returned by the recipient. The refund will be issued as store credit unless the original purchaser requests a refund to the original payment method.</p> -->

            <h2>Contact Us</h2>
            <p>If you have any questions about our return policy or need assistance with a return, our customer service team is here to help:</p>

            <div class="info-grid">
                <div class="info-card">
                    <h4>📧 Email</h4>
                    <p>returns@youreyewearstore.com<br>Response within 24 hours</p>
                </div>
                <div class="info-card">
                    <h4>📞 Phone</h4>
                    <p>1-800-EYEWEAR (393-9327)<br>Mon-Fri: 9AM-6PM EST</p>
                </div>
                <div class="info-card">
                    <h4>💬 Live Chat</h4>
                    <p>Available on our website<br>Mon-Sat: 9AM-8PM EST</p>
                </div>
            </div>
        </div>

        <div class="cta-section">
            <h3>Need to Start a Return?</h3>
            <p>Log into your account to initiate a return or contact our customer service team for assistance.</p>
            <a href="/account/orders" class="btn">My Orders</a>
            <a href="/contact" class="btn">Contact Support</a>
        </div>
    </div>
@endsection
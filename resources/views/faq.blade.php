@extends('layouts.home')

@section('title', 'About Us - Premium Eyewear')

@section('content')

<style>
/* FAQ styling */
.faq-answer {
    max-height: 0;
    overflow: hidden;
    padding: 0 15px;
    background-color: #f9f9f9;
    border-left: 3px solid #667eea;
    margin-bottom: 10px;
    transition: max-height 0.3s ease, padding 0.3s ease;
}

.faq-answer.active {
    max-height: 500px; /* large enough for content */
    padding: 10px 15px;
}

.faq-question {
    cursor: pointer;
    padding: 10px 15px;
    background-color: #e2e8f0;
    border-radius: 5px;
    margin-bottom: 5px;
    transition: background 0.3s;
}

.faq-question:hover {
    background-color: #cbd5e1;
}

.search-box {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    border: 1px solid #cbd5e1;
    border-radius: 5px;
    padding: 5px 10px;
}

.search-box svg {
    width: 20px;
    height: 20px;
    margin-right: 10px;
    color: #667eea;
}

.search-box input {
    border: none;
    outline: none;
    width: 100%;
    padding: 5px;
}
</style>

<div class="header mb-6">
    <h1 class="text-3xl font-semibold mb-2">Frequently Asked Questions</h1>
    <p>Find answers to common questions about our eyewear</p>
</div>

<div class="faq-container">
    <div class="search-box">
        <svg fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
        </svg>
        <input type="text" id="searchInput" placeholder="Search for answers...">
    </div>

    <div class="faq-section">

        <!-- Example category -->
        <!-- <div class="category mb-6">
            <h2 class="category-title text-xl font-semibold mb-3">🛍️ Ordering & Payment</h2>
            
            <div class="faq-item">
                <div class="faq-question">How do I place an order?</div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Simply browse our collection, select your favorite frames, choose your prescription type (if needed), and add to cart. Proceed to checkout, enter your shipping details and payment information, and confirm your order. You'll receive an email confirmation immediately.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">What payment methods do you accept?</div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        We accept all major credit cards (Visa, MasterCard, American Express), PayPal, Apple Pay, Google Pay, and Shop Pay. All transactions are secured with SSL encryption for your safety.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">Can I modify or cancel my order?</div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Orders can be modified or cancelled within 2 hours of placement. Please contact our customer service immediately at support@eyewearstore.com or call us. Once the order is processed, we cannot make changes.
                    </div>
                </div>
            </div>
            <div class="category">
                <h2 class="category-title">🔄 Returns & Exchanges</h2>
                
                <div class="faq-item">
                    <div class="faq-question">What is your return policy?</div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            We offer a 30-day return policy for unworn, undamaged glasses in original packaging. Prescription glasses have a 14-day return window. If you're not completely satisfied, contact us to initiate a return for a full refund or exchange.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">Can I exchange my glasses for a different style?</div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            Absolutely! You can exchange your glasses for any other style within 30 days. Simply return your current pair and place a new order. We'll refund the original purchase once we receive the return.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">What if my prescription is wrong?</div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            If there's an error in how we made your prescription lenses, we'll remake them at no cost within 30 days. If the prescription you provided was incorrect, we can remake the lenses at a discounted rate. Please contact our customer service team.
                        </div>
                    </div>
                </div>
            </div>

            <div class="category">
                <h2 class="category-title">🤔 Product Information</h2>
                
                <div class="faq-item">
                    <div class="faq-question">How do I know my frame size?</div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            Frame measurements are listed on each product page (lens width, bridge width, temple length). You can also check the inside of your current glasses for size numbers. We provide a virtual try-on feature and sizing guide to help you choose the perfect fit.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">Are your glasses suitable for sports?</div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            We offer specific sports eyewear collections with impact-resistant lenses and secure fit designs. For high-impact sports, we recommend our polycarbonate lens option, which is extremely durable and lightweight.
                        </div>
                    </div>
                </div>
        </div> -->


        <!-- Example category -->
        <div class="category mb-6">
            <h2 class="category-title text-xl font-semibold mb-3">🛍️ Ordering & Payment</h2>
            
            <div class="faq-item">
                <div class="faq-question">How do I place an order?</div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Simply browse our collection, select your favorite frames...
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">What payment methods do you accept?</div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        We accept all major credit cards...
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">Can I modify or cancel my order?</div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Orders can be modified or cancelled within 2 hours...
                    </div>
                </div>
            </div>
        </div> <!-- closes Ordering & Payment category -->

        <div class="category mb-6">
            <h2 class="category-title">🔄 Returns & Exchanges</h2>
            
            <div class="faq-item">
                <div class="faq-question">What is your return policy?</div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        We offer a 30-day return policy...
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">Can I exchange my glasses for a different style?</div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Absolutely! You can exchange your glasses...
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">What if my prescription is wrong?</div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        If there's an error in how we made your prescription lenses...
                    </div>
                </div>
            </div>
        </div> <!-- closes Returns & Exchanges category -->

        <div class="category mb-6">
            <h2 class="category-title">🤔 Product Information</h2>
            
            <div class="faq-item">
                <div class="faq-question">How do I know my frame size?</div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Frame measurements are listed on each product page...
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">Are your glasses suitable for sports?</div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        We offer specific sports eyewear collections...
                    </div>
                </div>
            </div>
        </div> <!-- closes Product Information category -->

    </div> <!-- closes faq-section -->
</div> <!-- closes faq-container -->

        <!-- Add other categories like Prescriptions, Shipping, Returns, Product Info similarly -->
        <!-- Copy your existing content for other categories here -->

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const faqItems = document.querySelectorAll('.faq-item');

    // Toggle FAQ answer
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');

        question.addEventListener('click', () => {
            // Close all other answers
            faqItems.forEach(i => i.querySelector('.faq-answer').classList.remove('active'));

            // Toggle current
            answer.classList.toggle('active');
        });
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        faqItems.forEach(item => {
            const questionText = item.querySelector('.faq-question').innerText.toLowerCase();
            const answerText = item.querySelector('.faq-answer-content').innerText.toLowerCase();

            if (questionText.includes(query) || answerText.includes(query)) {
                item.style.display = '';
                item.querySelector('.faq-answer').classList.add('active'); // show answer
            } else {
                item.style.display = 'none';
                item.querySelector('.faq-answer').classList.remove('active');
            }
        });
    });
});
</script>

@endsection

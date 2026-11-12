<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Faq\Models\Faq;
use Botble\Faq\Models\FaqCategory;

class FaqSeeder extends BaseSeeder
{
    public function run(): void
    {
        Faq::query()->truncate();
        FaqCategory::query()->truncate();

        $categories = [
            'Ordering Process',
            'Product Returns',
            'Product Availability',
        ];

        foreach ($categories as $index => $category) {
            FaqCategory::query()->create([
                'name' => $category,
                'order' => $index,
            ]);
        }

        $faqs = [
            [
                'question' => 'How do I place an order?',
                'answer' => 'To place an order, navigate to the product page, select the desired options, and click the "Add to Cart" button.',
            ],
            [
                'question' => 'What are the shipping options?',
                'answer' => 'We offer standard and expedited shipping options. Shipping costs and delivery times vary based on your location and chosen shipping method.',
            ],
            [
                'question' => 'How can I return a product?',
                'answer' => 'If you are not satisfied with your purchase, you can initiate a return within 30 days of receiving the product. Contact our customer service for further instructions.',
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept major credit cards, PayPal, and other secure payment methods.',
            ],
            [
                'question' => 'How can I update my account information?',
                'answer' => 'Log in to your account and go to the "Account Settings" page to update your information, including your password and shipping address.',
            ],
            [
                'question' => 'Are there any ongoing promotions or discounts?',
                'answer' => 'Check our "Promotions" page for information on current discounts, special offers, and ongoing promotions.',
            ],
            [
                'question' => 'Is the product in stock?',
                'answer' => 'Product availability is indicated on each product page. If a product is out of stock, you may choose to be notified when it becomes available.',
            ],
            [
                'question' => 'How is my personal information secured?',
                'answer' => 'We take the security and privacy of your information seriously. Our website uses encryption technology to protect your personal data.',
            ],
            [
                'question' => 'How do I get technical support?',
                'answer' => 'For technical issues or assistance, contact our customer support team through the "Contact Us" page, and we will help you resolve any problems.',
            ],
            [
                'question' => 'Do you offer international shipping?',
                'answer' => 'Yes, we offer international shipping to many countries. Shipping costs and delivery times vary based on the destination.',
            ],
            [
                'question' => 'Can I purchase a gift card?',
                'answer' => 'Yes, we offer gift cards of varying denominations. Gift cards can be purchased on our website and make for a great gift for friends and family.',
            ],
            [
                'question' => 'What is the warranty on your products?',
                'answer' => 'Our products come with a standard warranty. Check the product documentation or contact our customer service for details on specific product warranties.',
            ],
        ];

        $categoryIds = FaqCategory::query()->pluck('id');

        foreach ($faqs as $faq) {
            Faq::query()->create(array_merge($faq, [
                'category_id' => $categoryIds->random(),
            ]));
        }
    }
}

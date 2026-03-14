<?php

return [

    // account-deleted
    'account_deleted' => [
        'badge'          => 'Account Removed',
        'goodbye'        => 'Goodbye, ',
        'subtitle'       => 'Your ' . config('app.name') . ' account has been permanently deleted.',
        'deleted_account'=> 'Deleted Account',
        'account_email'  => 'Account Email',
        'what_it_means'  => 'What This Means',
        'data_removed'   => 'All your personal data has been permanently removed from our systems.',
        'no_login'       => 'You will no longer be able to log in with this account.',
        'warning'        => "<strong>Didn't request this?</strong> If you believe this deletion was a mistake, please contact our support team immediately.",
        'thank_you'      => 'Thank you for being part of ' . config('app.name') . '.',
        'see_you'        => 'We hope to see you again someday. Take care! 💜',
        'all_rights'     => 'All rights reserved.',
    ],

    // google-welcome
    'google_welcome' => [
        'badge'          => 'Google Sign-In',
        'welcome'        => 'Welcome, ',
        'subtitle'       => "You've signed in with Google.\nYour " . config('app.name') . ' account is ready.',
        'your_account'   => 'Your Account',
        'email_label'    => 'Email',
        'sign_in_method' => 'Sign-In Method',
        'sign_in_info'   => 'You can sign in at any time using your Google account. No password is needed.',
        'need_help'      => 'Need help or have questions?',
        'need_help_body' => 'Reply to this email and our team will be happy to assist you.',
        'all_rights'     => 'All rights reserved.',
    ],

    // order-confirmation
    'order_confirmation' => [
        'badge'           => 'Order Confirmation',
        'heading'         => 'Thank you for your order!',
        'hi'              => 'Hi',
        'greeting'        => ', your order has been received and is being processed.',
        'order_number'    => 'Order Number',
        'customer'        => 'Customer',
        'billing_address' => 'Billing Address',
        'shipping_address'=> 'Shipping Address',
        'order_summary'   => 'Order Summary',
        'col_product'     => 'Product',
        'col_qty'         => 'Qty',
        'col_price'       => 'Price',
        'col_total'       => 'Total',
        'order_total'     => 'Order Total',
        'order_notes'     => 'Order Notes',
        'questions'       => 'Questions about your order?',
        'questions_body'  => "Simply reply to this email and we'll be happy to help.",
        'all_rights'      => 'All rights reserved.',
    ],

    // registration-welcome
    'registration_welcome' => [
        'badge'          => 'New Account',
        'heading'        => 'Welcome to ' . config('app.name') . '!',
        'subtitle'       => "We're thrilled to have you on board. Your account is all set and ready to go.",
        'account_details'=> 'Your Account Details',
        'email_username' => 'Email / Username',
        'need_help'      => 'Need help getting started?',
        'need_help_body' => 'Reply to this email and our team will be happy to assist you.',
        'all_rights'     => 'All rights reserved.',
    ],

];

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    // Cross-domain auth messages
    'cross_domain_success' => 'Successfully logged in to your workspace.',
    'cross_domain_invalid_token' => 'Invalid authentication token. Please try logging in again.',
    'cross_domain_token_expired' => 'Authentication token has expired. Please try logging in again.',
    'cross_domain_invalid_domain' => 'Invalid domain for this authentication. Please try logging in again.',
    'cross_domain_user_not_found' => 'User not found in this workspace. Please contact your administrator.',
    'redirecting_to_workspace' => 'Redirecting to your workspace...',

    // Login page
    'login_title' => 'Login to your account',
    'email_label' => 'Email address',
    'email_placeholder' => 'your@email.com',
    'password_label' => 'Password',
    'password_placeholder' => 'Your password',
    'forgot_password' => 'Forgot password?',
    'remember_me' => 'Remember me',
    'sign_in' => 'Sign in',
    'no_account' => "Don't have account yet?",
    'sign_up' => 'Sign up',

    // Register page
    'register_title' => 'Create new account',
    'name_label' => 'Name',
    'name_placeholder' => 'Enter your name',
    'company_label' => 'Company / Organization',
    'company_placeholder' => 'Your company name (optional)',
    'password_confirmation_label' => 'Confirm Password',
    'password_confirmation_placeholder' => 'Confirm your password',
    'agree_terms' => 'I agree to the',
    'terms_and_policy' => 'terms and policy',
    'create_account' => 'Create new account',
    'already_have_account' => 'Already have account?',

    // Forgot Password page
    'forgot_password_title' => 'Forgot password',
    'forgot_password_description' => "Enter your email address and we'll send you a password reset link that will allow you to choose a new one.",
    'send_reset_link' => 'Send password reset link',
    'remember_password' => 'Remember your password?',

    // Reset Password page
    'reset_password_title' => 'Reset password',
    'reset_password_description' => 'Enter your new password below.',
    'new_password_label' => 'New password',
    'new_password_placeholder' => 'Your new password',
    'confirm_password_placeholder' => 'Confirm your new password',
    'reset_password_button' => 'Reset password',

    // Confirm Password page
    'confirm_password_title' => 'Confirm password',
    'confirm_password_description' => 'This is a secure area of the application. Please confirm your password before continuing.',
    'confirm_button' => 'Confirm',

    // Verify Email page
    'verify_email_title' => 'Verify your email',
    'verify_email_description' => "Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.",
    'verification_link_sent' => 'A new verification link has been sent to the email address you provided during registration.',
    'resend_verification' => 'Resend Verification Email',
    'log_out' => 'Log Out',
];

<?php

/**
 * theme-my-login register page
 * https://docs.thememylogin.com/article/95-templates
 */

if (is_user_logged_in()) {
    wp_redirect(home_url());
}

$context = Timber::get_context();

$context["page"] = Timber::get_post();
$context["show_section_social"] = false;

Timber::render("pages/user/login.twig", $context);

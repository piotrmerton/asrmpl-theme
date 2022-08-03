<?php

/**
 * theme-my-login register page
 * https://docs.thememylogin.com/article/95-templates
 */

$context = Timber::get_context();

$context["page"] = Timber::get_post();
$context["show_section_social"] = false;

Timber::render("pages/user/profile.twig", $context);

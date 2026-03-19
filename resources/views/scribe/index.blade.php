<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>JussiLog API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "https://backend-laravel.dev.jussialanen.com";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.8.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.8.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-ai-agent" class="tocify-header">
                <li class="tocify-item level-1" data-unique="ai-agent">
                    <a href="#ai-agent">AI Agent</a>
                </li>
                                    <ul id="tocify-subheader-ai-agent" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="ai-agent-POSTapi-agent-resume-ask">
                                <a href="#ai-agent-POSTapi-agent-resume-ask">Ask a question about the authenticated user's primary resume.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-admin-thumbnails" class="tocify-header">
                <li class="tocify-item level-1" data-unique="admin-thumbnails">
                    <a href="#admin-thumbnails">Admin – Thumbnails</a>
                </li>
                                    <ul id="tocify-subheader-admin-thumbnails" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="admin-thumbnails-POSTapi-admin-thumbnails-regenerate">
                                <a href="#admin-thumbnails-POSTapi-admin-thumbnails-regenerate">Regenerate thumbnail images for products and/or resumes.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="admin-thumbnails-DELETEapi-admin-thumbnails">
                                <a href="#admin-thumbnails-DELETEapi-admin-thumbnails">Delete all thumbnail images for products and/or resumes (originals are kept).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="admin-thumbnails-POSTapi-admin-thumbnails-products--id--regenerate">
                                <a href="#admin-thumbnails-POSTapi-admin-thumbnails-products--id--regenerate">Regenerate thumbnails for a single product.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="admin-thumbnails-DELETEapi-admin-thumbnails-products--id-">
                                <a href="#admin-thumbnails-DELETEapi-admin-thumbnails-products--id-">Purge thumbnails for a single product.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="admin-thumbnails-POSTapi-admin-thumbnails-resumes--id--regenerate">
                                <a href="#admin-thumbnails-POSTapi-admin-thumbnails-resumes--id--regenerate">Regenerate thumbnails for a single resume.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="admin-thumbnails-DELETEapi-admin-thumbnails-resumes--id-">
                                <a href="#admin-thumbnails-DELETEapi-admin-thumbnails-resumes--id-">Purge thumbnails for a single resume.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-auth" class="tocify-header">
                <li class="tocify-item level-1" data-unique="auth">
                    <a href="#auth">Auth</a>
                </li>
                                    <ul id="tocify-subheader-auth" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="auth-GETapi-user">
                                <a href="#auth-GETapi-user">Get the authenticated user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-GETapi-me">
                                <a href="#auth-GETapi-me">Get the authenticated user with metadata.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-POSTapi-register">
                                <a href="#auth-POSTapi-register">Register a new user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-POSTapi-login">
                                <a href="#auth-POSTapi-login">Login.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-POSTapi-auth-google">
                                <a href="#auth-POSTapi-auth-google">Login or register using Google ID token.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-POSTapi-lost-password">
                                <a href="#auth-POSTapi-lost-password">Send reset password email.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-POSTapi-reset-password">
                                <a href="#auth-POSTapi-reset-password">Reset password with token.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-POSTapi-logout">
                                <a href="#auth-POSTapi-logout">Logout the authenticated user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-GETapi-check-auth">
                                <a href="#auth-GETapi-check-auth">Check authentication status.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-blog" class="tocify-header">
                <li class="tocify-item level-1" data-unique="blog">
                    <a href="#blog">Blog</a>
                </li>
                                    <ul id="tocify-subheader-blog" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="blog-GETapi-blogs">
                                <a href="#blog-GETapi-blogs">List published blog posts (public).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="blog-GETapi-blogs--idOrSlug-">
                                <a href="#blog-GETapi-blogs--idOrSlug-">Show a single published blog post (public).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="blog-GETapi-admin-blogs">
                                <a href="#blog-GETapi-admin-blogs">List all blog posts for admin (including hidden).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="blog-POSTapi-blogs">
                                <a href="#blog-POSTapi-blogs">Create a blog post.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="blog-PUTapi-blogs--id-">
                                <a href="#blog-PUTapi-blogs--id-">Update a blog post.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="blog-DELETEapi-blogs--id-">
                                <a href="#blog-DELETEapi-blogs--id-">Delete a blog post.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-blog-categories" class="tocify-header">
                <li class="tocify-item level-1" data-unique="blog-categories">
                    <a href="#blog-categories">Blog Categories</a>
                </li>
                                    <ul id="tocify-subheader-blog-categories" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="blog-categories-GETapi-blog-categories">
                                <a href="#blog-categories-GETapi-blog-categories">List all blog categories.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="blog-categories-POSTapi-blog-categories">
                                <a href="#blog-categories-POSTapi-blog-categories">Create a blog category.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="blog-categories-PUTapi-blog-categories--id-">
                                <a href="#blog-categories-PUTapi-blog-categories--id-">Update a blog category.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="blog-categories-DELETEapi-blog-categories--id-">
                                <a href="#blog-categories-DELETEapi-blog-categories--id-">Delete a blog category.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-PATCHapi-users-update-role">
                                <a href="#endpoints-PATCHapi-users-update-role">Update a user's role by identifier (id, username or email).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-resumes--id--preview-pdf-render">
                                <a href="#endpoints-GETapi-resumes--id--preview-pdf-render">Render a resume as an inline PDF via a signed URL (no auth token required).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-resumes--id--preview-html-render">
                                <a href="#endpoints-GETapi-resumes--id--preview-html-render">Render a resume as inline HTML via a signed URL (no auth token required).</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-health" class="tocify-header">
                <li class="tocify-item level-1" data-unique="health">
                    <a href="#health">Health</a>
                </li>
                                    <ul id="tocify-subheader-health" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="health-GETapi-hello">
                                <a href="#health-GETapi-hello">Health check.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-invoices" class="tocify-header">
                <li class="tocify-item level-1" data-unique="invoices">
                    <a href="#invoices">Invoices</a>
                </li>
                                    <ul id="tocify-subheader-invoices" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="invoices-GETapi-my-invoices">
                                <a href="#invoices-GETapi-my-invoices">List invoices for the authenticated user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoices-GETapi-invoices-options">
                                <a href="#invoices-GETapi-invoices-options">Return available invoice statuses and item types with translated labels.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoices-POSTapi-invoices-export-pdf">
                                <a href="#invoices-POSTapi-invoices-export-pdf">Export a preview invoice as PDF (no auth, no database save).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoices-POSTapi-invoices-export-html">
                                <a href="#invoices-POSTapi-invoices-export-html">Export a preview invoice as HTML (no auth, no database save).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoices-POSTapi-invoices-export-email">
                                <a href="#invoices-POSTapi-invoices-export-email">Send a preview invoice by email (no auth, no database save).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoices-POSTapi-invoices--id--send">
                                <a href="#invoices-POSTapi-invoices--id--send">Send an invoice by email.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoices-GETapi-invoices">
                                <a href="#invoices-GETapi-invoices">List invoices.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoices-GETapi-invoices--id-">
                                <a href="#invoices-GETapi-invoices--id-">Get an invoice.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoices-GETapi-invoices--id--pdf">
                                <a href="#invoices-GETapi-invoices--id--pdf">Download invoice as PDF.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoices-GETapi-invoices--id--html">
                                <a href="#invoices-GETapi-invoices--id--html">Download a stored invoice as HTML.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoices-POSTapi-invoices">
                                <a href="#invoices-POSTapi-invoices">Create an invoice.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoices-PUTapi-invoices--id-">
                                <a href="#invoices-PUTapi-invoices--id-">Update an invoice.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="invoices-DELETEapi-invoices--id-">
                                <a href="#invoices-DELETEapi-invoices--id-">Delete an invoice.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-orders" class="tocify-header">
                <li class="tocify-item level-1" data-unique="orders">
                    <a href="#orders">Orders</a>
                </li>
                                    <ul id="tocify-subheader-orders" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="orders-GETapi-orders">
                                <a href="#orders-GETapi-orders">Display a listing of orders.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="orders-POSTapi-orders">
                                <a href="#orders-POSTapi-orders">Store a newly created order.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="orders-GETapi-orders--id-">
                                <a href="#orders-GETapi-orders--id-">Display the specified order.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="orders-PUTapi-orders--id-">
                                <a href="#orders-PUTapi-orders--id-">Update the specified order.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="orders-DELETEapi-orders--id-">
                                <a href="#orders-DELETEapi-orders--id-">Remove the specified order.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="orders-GETapi-my-orders">
                                <a href="#orders-GETapi-my-orders">Display a listing of orders for the authenticated user.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-products" class="tocify-header">
                <li class="tocify-item level-1" data-unique="products">
                    <a href="#products">Products</a>
                </li>
                                    <ul id="tocify-subheader-products" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="products-GETapi-products">
                                <a href="#products-GETapi-products">List products.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="products-POSTapi-products">
                                <a href="#products-POSTapi-products">Create a product.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="products-GETapi-products--id-">
                                <a href="#products-GETapi-products--id-">Get a product.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="products-PUTapi-products--id-">
                                <a href="#products-PUTapi-products--id-">Update a product.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="products-DELETEapi-products--id-">
                                <a href="#products-DELETEapi-products--id-">Delete a product.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-resume-sections" class="tocify-header">
                <li class="tocify-item level-1" data-unique="resume-sections">
                    <a href="#resume-sections">Resume Sections</a>
                </li>
                                    <ul id="tocify-subheader-resume-sections" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="resume-sections-GETapi-resumes--resumeId---section-">
                                <a href="#resume-sections-GETapi-resumes--resumeId---section-">List all items in a resume section.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resume-sections-POSTapi-resumes--resumeId---section-">
                                <a href="#resume-sections-POSTapi-resumes--resumeId---section-">Add an item to a resume section.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resume-sections-PUTapi-resumes--resumeId---section---itemId-">
                                <a href="#resume-sections-PUTapi-resumes--resumeId---section---itemId-">Update an item in a resume section.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resume-sections-DELETEapi-resumes--resumeId---section---itemId-">
                                <a href="#resume-sections-DELETEapi-resumes--resumeId---section---itemId-">Delete an item from a resume section.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-resumes" class="tocify-header">
                <li class="tocify-item level-1" data-unique="resumes">
                    <a href="#resumes">Resumes</a>
                </li>
                                    <ul id="tocify-subheader-resumes" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="resumes-GETapi-resumes-export-options">
                                <a href="#resumes-GETapi-resumes-export-options">Return available themes, templates, and languages for PDF/HTML export.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-POSTapi-resumes-export-pdf">
                                <a href="#resumes-POSTapi-resumes-export-pdf">Export a resume as a PDF from a JSON payload (no stored resume required).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-POSTapi-resumes-export-html">
                                <a href="#resumes-POSTapi-resumes-export-html">Export a resume as an HTML file from a JSON payload (no stored resume required).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-POSTapi-resumes-preview-pdf">
                                <a href="#resumes-POSTapi-resumes-preview-pdf">Preview a resume as an inline PDF from a JSON payload (no stored resume required).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-POSTapi-resumes-preview-html">
                                <a href="#resumes-POSTapi-resumes-preview-html">Preview a resume as inline HTML from a JSON payload (no stored resume required).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-GETapi-resumes-current">
                                <a href="#resumes-GETapi-resumes-current">Get the primary resume.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-GETapi-resumes-current-main">
                                <a href="#resumes-GETapi-resumes-current-main">Get the main (primary) resume for public display.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-GETapi-resumes--id--public">
                                <a href="#resumes-GETapi-resumes--id--public">Display a specific public resume (no token required).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-GETapi-resumes">
                                <a href="#resumes-GETapi-resumes">Display all resumes for the authenticated user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-POSTapi-resumes">
                                <a href="#resumes-POSTapi-resumes">Create a new resume with all sections in one request.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-GETapi-resumes--id-">
                                <a href="#resumes-GETapi-resumes--id-">Display a specific resume with all its sections.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-PUTapi-resumes--id-">
                                <a href="#resumes-PUTapi-resumes--id-">Update a resume and sync provided sections.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-POSTapi-resumes--id-">
                                <a href="#resumes-POSTapi-resumes--id-">Update a resume and sync provided sections.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-DELETEapi-resumes--id-">
                                <a href="#resumes-DELETEapi-resumes--id-">Delete a resume and all its sections.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-GETapi-resumes--id--export-pdf">
                                <a href="#resumes-GETapi-resumes--id--export-pdf">Export a resume as a PDF file.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-GETapi-resumes--id--export-html">
                                <a href="#resumes-GETapi-resumes--id--export-html">Export a resume as an HTML file.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-GETapi-resumes--id--export-json">
                                <a href="#resumes-GETapi-resumes--id--export-json">Export a resume as a downloadable JSON backup file.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-GETapi-resumes--id--preview-pdf">
                                <a href="#resumes-GETapi-resumes--id--preview-pdf">Preview a resume as an inline PDF (opens in browser, no download).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-GETapi-resumes--id--preview-html">
                                <a href="#resumes-GETapi-resumes--id--preview-html">Preview a resume as inline HTML (renders in browser, no download).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-GETapi-resumes--id--preview-signed-url">
                                <a href="#resumes-GETapi-resumes--id--preview-signed-url">Generate short-lived signed preview URLs for PDF and HTML (no token needed to open them).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-POSTapi-resumes-import-json">
                                <a href="#resumes-POSTapi-resumes-import-json">Import a resume from a previously exported JSON backup file.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resumes-POSTapi-resumes--id--import-json">
                                <a href="#resumes-POSTapi-resumes--id--import-json">Import a resume from a previously exported JSON backup file.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-settings" class="tocify-header">
                <li class="tocify-item level-1" data-unique="settings">
                    <a href="#settings">Settings</a>
                </li>
                                    <ul id="tocify-subheader-settings" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="settings-GETapi-settings-languages">
                                <a href="#settings-GETapi-settings-languages">Return the list of supported languages with translated labels.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="settings-GETapi-settings-countries">
                                <a href="#settings-GETapi-settings-countries">Return the list of world countries with translated labels.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="settings-GETapi-settings-countries--code-">
                                <a href="#settings-GETapi-settings-countries--code-">Return a single country by its ISO 3166-1 alpha-2 code.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-tax-rates" class="tocify-header">
                <li class="tocify-item level-1" data-unique="tax-rates">
                    <a href="#tax-rates">Tax Rates</a>
                </li>
                                    <ul id="tocify-subheader-tax-rates" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="tax-rates-GETapi-settings-taxrates">
                                <a href="#tax-rates-GETapi-settings-taxrates">Return all available tax rates with translated country names.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="tax-rates-GETapi-settings-taxrates--code-">
                                <a href="#tax-rates-GETapi-settings-taxrates--code-">Return the tax rate for a specific country code.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-uploads" class="tocify-header">
                <li class="tocify-item level-1" data-unique="uploads">
                    <a href="#uploads">Uploads</a>
                </li>
                                    <ul id="tocify-subheader-uploads" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="uploads-POSTapi-upload-test">
                                <a href="#uploads-POSTapi-upload-test">Upload test file.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-users" class="tocify-header">
                <li class="tocify-item level-1" data-unique="users">
                    <a href="#users">Users</a>
                </li>
                                    <ul id="tocify-subheader-users" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="users-GETapi-users-roles">
                                <a href="#users-GETapi-users-roles">Get all available roles.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="users-GETapi-users">
                                <a href="#users-GETapi-users">List users.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="users-POSTapi-users">
                                <a href="#users-POSTapi-users">Create a new user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="users-GETapi-users--id-">
                                <a href="#users-GETapi-users--id-">Get a single user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="users-PUTapi-users--id-">
                                <a href="#users-PUTapi-users--id-">Update a user.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="users-DELETEapi-users--id-">
                                <a href="#users-DELETEapi-users--id-">Delete a user.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-visitors" class="tocify-header">
                <li class="tocify-item level-1" data-unique="visitors">
                    <a href="#visitors">Visitors</a>
                </li>
                                    <ul id="tocify-subheader-visitors" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="visitors-POSTapi-visitors-track">
                                <a href="#visitors-POSTapi-visitors-track">Track a site visit.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="visitors-GETapi-visitors-today">
                                <a href="#visitors-GETapi-visitors-today">Count unique visitors for today.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="visitors-GETapi-visitors-total">
                                <a href="#visitors-GETapi-visitors-total">Count unique visitors of all time.</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: March 19, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>REST API documentation for Jussilog endpoints.</p>
<aside>
    <strong>Base URL</strong>: <code>https://backend-laravel.dev.jussialanen.com</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_AUTH_TOKEN}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>Authenticate with a Sanctum bearer token via the Authorization header, for example: <code>Authorization: Bearer {token}</code>.</p>

        <h1 id="ai-agent">AI Agent</h1>

    

                                <h2 id="ai-agent-POSTapi-agent-resume-ask">Ask a question about the authenticated user&#039;s primary resume.</h2>

<p>
</p>



<span id="example-requests-POSTapi-agent-resume-ask">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/agent/resume/ask" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"question\": \"What are the main skills on this resume?\",
    \"language\": \"fi\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/agent/resume/ask"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "question": "What are the main skills on this resume?",
    "language": "fi"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-agent-resume-ask">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;answer&quot;: &quot;The main skills listed on this resume are...&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;No primary resume found for this user.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;The question field is required.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (502):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;AI agent error: ...&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-agent-resume-ask" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-agent-resume-ask"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-agent-resume-ask"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-agent-resume-ask" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-agent-resume-ask">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-agent-resume-ask" data-method="POST"
      data-path="api/agent/resume/ask"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-agent-resume-ask', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-agent-resume-ask"
                    onclick="tryItOut('POSTapi-agent-resume-ask');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-agent-resume-ask"
                    onclick="cancelTryOut('POSTapi-agent-resume-ask');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-agent-resume-ask"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/agent/resume/ask</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-agent-resume-ask"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-agent-resume-ask"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>question</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="question"                data-endpoint="POSTapi-agent-resume-ask"
               value="What are the main skills on this resume?"
               data-component="body">
    <br>
<p>The question to ask about the resume. Example: <code>What are the main skills on this resume?</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>language</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="language"                data-endpoint="POSTapi-agent-resume-ask"
               value="fi"
               data-component="body">
    <br>
<p>optional Response language: <code>en</code> for English, <code>fi</code> for Finnish. Omit to auto-detect from the question. Example: <code>fi</code></p>
        </div>
        </form>

                <h1 id="admin-thumbnails">Admin – Thumbnails</h1>

    

                                <h2 id="admin-thumbnails-POSTapi-admin-thumbnails-regenerate">Regenerate thumbnail images for products and/or resumes.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-admin-thumbnails-regenerate">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/admin/thumbnails/regenerate?type=all" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/admin/thumbnails/regenerate"
);

const params = {
    "type": "all",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-admin-thumbnails-regenerate">
</span>
<span id="execution-results-POSTapi-admin-thumbnails-regenerate" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-admin-thumbnails-regenerate"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-admin-thumbnails-regenerate"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-admin-thumbnails-regenerate" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-admin-thumbnails-regenerate">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-admin-thumbnails-regenerate" data-method="POST"
      data-path="api/admin/thumbnails/regenerate"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-admin-thumbnails-regenerate', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-admin-thumbnails-regenerate"
                    onclick="tryItOut('POSTapi-admin-thumbnails-regenerate');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-admin-thumbnails-regenerate"
                    onclick="cancelTryOut('POSTapi-admin-thumbnails-regenerate');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-admin-thumbnails-regenerate"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/admin/thumbnails/regenerate</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-admin-thumbnails-regenerate"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-admin-thumbnails-regenerate"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-admin-thumbnails-regenerate"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="POSTapi-admin-thumbnails-regenerate"
               value="all"
               data-component="query">
    <br>
<p>Which model to process: products, resumes, or all (default). Example: <code>all</code></p>
            </div>
                </form>

                    <h2 id="admin-thumbnails-DELETEapi-admin-thumbnails">Delete all thumbnail images for products and/or resumes (originals are kept).</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-admin-thumbnails">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "https://backend-laravel.dev.jussialanen.com/api/admin/thumbnails?type=all" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/admin/thumbnails"
);

const params = {
    "type": "all",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-admin-thumbnails">
</span>
<span id="execution-results-DELETEapi-admin-thumbnails" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-admin-thumbnails"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-admin-thumbnails"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-admin-thumbnails" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-admin-thumbnails">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-admin-thumbnails" data-method="DELETE"
      data-path="api/admin/thumbnails"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-admin-thumbnails', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-admin-thumbnails"
                    onclick="tryItOut('DELETEapi-admin-thumbnails');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-admin-thumbnails"
                    onclick="cancelTryOut('DELETEapi-admin-thumbnails');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-admin-thumbnails"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/admin/thumbnails</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-admin-thumbnails"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-admin-thumbnails"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-admin-thumbnails"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="DELETEapi-admin-thumbnails"
               value="all"
               data-component="query">
    <br>
<p>Which model to purge: products, resumes, or all (default). Example: <code>all</code></p>
            </div>
                </form>

                    <h2 id="admin-thumbnails-POSTapi-admin-thumbnails-products--id--regenerate">Regenerate thumbnails for a single product.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-admin-thumbnails-products--id--regenerate">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/admin/thumbnails/products/1/regenerate" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/admin/thumbnails/products/1/regenerate"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-admin-thumbnails-products--id--regenerate">
</span>
<span id="execution-results-POSTapi-admin-thumbnails-products--id--regenerate" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-admin-thumbnails-products--id--regenerate"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-admin-thumbnails-products--id--regenerate"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-admin-thumbnails-products--id--regenerate" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-admin-thumbnails-products--id--regenerate">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-admin-thumbnails-products--id--regenerate" data-method="POST"
      data-path="api/admin/thumbnails/products/{id}/regenerate"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-admin-thumbnails-products--id--regenerate', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-admin-thumbnails-products--id--regenerate"
                    onclick="tryItOut('POSTapi-admin-thumbnails-products--id--regenerate');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-admin-thumbnails-products--id--regenerate"
                    onclick="cancelTryOut('POSTapi-admin-thumbnails-products--id--regenerate');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-admin-thumbnails-products--id--regenerate"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/admin/thumbnails/products/{id}/regenerate</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-admin-thumbnails-products--id--regenerate"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-admin-thumbnails-products--id--regenerate"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-admin-thumbnails-products--id--regenerate"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-admin-thumbnails-products--id--regenerate"
               value="1"
               data-component="url">
    <br>
<p>Product ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="admin-thumbnails-DELETEapi-admin-thumbnails-products--id-">Purge thumbnails for a single product.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-admin-thumbnails-products--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "https://backend-laravel.dev.jussialanen.com/api/admin/thumbnails/products/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/admin/thumbnails/products/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-admin-thumbnails-products--id-">
</span>
<span id="execution-results-DELETEapi-admin-thumbnails-products--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-admin-thumbnails-products--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-admin-thumbnails-products--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-admin-thumbnails-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-admin-thumbnails-products--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-admin-thumbnails-products--id-" data-method="DELETE"
      data-path="api/admin/thumbnails/products/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-admin-thumbnails-products--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-admin-thumbnails-products--id-"
                    onclick="tryItOut('DELETEapi-admin-thumbnails-products--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-admin-thumbnails-products--id-"
                    onclick="cancelTryOut('DELETEapi-admin-thumbnails-products--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-admin-thumbnails-products--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/admin/thumbnails/products/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-admin-thumbnails-products--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-admin-thumbnails-products--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-admin-thumbnails-products--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-admin-thumbnails-products--id-"
               value="1"
               data-component="url">
    <br>
<p>Product ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="admin-thumbnails-POSTapi-admin-thumbnails-resumes--id--regenerate">Regenerate thumbnails for a single resume.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-admin-thumbnails-resumes--id--regenerate">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/admin/thumbnails/resumes/1/regenerate" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/admin/thumbnails/resumes/1/regenerate"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-admin-thumbnails-resumes--id--regenerate">
</span>
<span id="execution-results-POSTapi-admin-thumbnails-resumes--id--regenerate" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-admin-thumbnails-resumes--id--regenerate"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-admin-thumbnails-resumes--id--regenerate"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-admin-thumbnails-resumes--id--regenerate" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-admin-thumbnails-resumes--id--regenerate">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-admin-thumbnails-resumes--id--regenerate" data-method="POST"
      data-path="api/admin/thumbnails/resumes/{id}/regenerate"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-admin-thumbnails-resumes--id--regenerate', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-admin-thumbnails-resumes--id--regenerate"
                    onclick="tryItOut('POSTapi-admin-thumbnails-resumes--id--regenerate');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-admin-thumbnails-resumes--id--regenerate"
                    onclick="cancelTryOut('POSTapi-admin-thumbnails-resumes--id--regenerate');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-admin-thumbnails-resumes--id--regenerate"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/admin/thumbnails/resumes/{id}/regenerate</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-admin-thumbnails-resumes--id--regenerate"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-admin-thumbnails-resumes--id--regenerate"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-admin-thumbnails-resumes--id--regenerate"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-admin-thumbnails-resumes--id--regenerate"
               value="1"
               data-component="url">
    <br>
<p>Resume ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="admin-thumbnails-DELETEapi-admin-thumbnails-resumes--id-">Purge thumbnails for a single resume.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-admin-thumbnails-resumes--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "https://backend-laravel.dev.jussialanen.com/api/admin/thumbnails/resumes/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/admin/thumbnails/resumes/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-admin-thumbnails-resumes--id-">
</span>
<span id="execution-results-DELETEapi-admin-thumbnails-resumes--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-admin-thumbnails-resumes--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-admin-thumbnails-resumes--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-admin-thumbnails-resumes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-admin-thumbnails-resumes--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-admin-thumbnails-resumes--id-" data-method="DELETE"
      data-path="api/admin/thumbnails/resumes/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-admin-thumbnails-resumes--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-admin-thumbnails-resumes--id-"
                    onclick="tryItOut('DELETEapi-admin-thumbnails-resumes--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-admin-thumbnails-resumes--id-"
                    onclick="cancelTryOut('DELETEapi-admin-thumbnails-resumes--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-admin-thumbnails-resumes--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/admin/thumbnails/resumes/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-admin-thumbnails-resumes--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-admin-thumbnails-resumes--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-admin-thumbnails-resumes--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-admin-thumbnails-resumes--id-"
               value="1"
               data-component="url">
    <br>
<p>Resume ID. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="auth">Auth</h1>

    

                                <h2 id="auth-GETapi-user">Get the authenticated user.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/user" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/user"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-user" data-method="GET"
      data-path="api/user"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user"
                    onclick="tryItOut('GETapi-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user"
                    onclick="cancelTryOut('GETapi-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-user"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="auth-GETapi-me">Get the authenticated user with metadata.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-me">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/me" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/me"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-me">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-me" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-me"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-me"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-me" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-me">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-me" data-method="GET"
      data-path="api/me"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-me', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-me"
                    onclick="tryItOut('GETapi-me');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-me"
                    onclick="cancelTryOut('GETapi-me');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-me"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/me</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-me"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-me"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-me"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="auth-POSTapi-register">Register a new user.</h2>

<p>
</p>



<span id="example-requests-POSTapi-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"first_name\": \"Jussi\",
    \"last_name\": \"Palanen\",
    \"username\": \"jussi\",
    \"email\": \"jussi@example.com\",
    \"password\": \"strongpassword\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "Jussi",
    "last_name": "Palanen",
    "username": "jussi",
    "email": "jussi@example.com",
    "password": "strongpassword"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-register">
</span>
<span id="execution-results-POSTapi-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-register" data-method="POST"
      data-path="api/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-register"
                    onclick="tryItOut('POSTapi-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-register"
                    onclick="cancelTryOut('POSTapi-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="first_name"                data-endpoint="POSTapi-register"
               value="Jussi"
               data-component="body">
    <br>
<p>First name. Example: <code>Jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="last_name"                data-endpoint="POSTapi-register"
               value="Palanen"
               data-component="body">
    <br>
<p>Last name. Example: <code>Palanen</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>username</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="username"                data-endpoint="POSTapi-register"
               value="jussi"
               data-component="body">
    <br>
<p>Username. Example: <code>jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-register"
               value="jussi@example.com"
               data-component="body">
    <br>
<p>Email address. Example: <code>jussi@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-register"
               value="strongpassword"
               data-component="body">
    <br>
<p>Password. Example: <code>strongpassword</code></p>
        </div>
        </form>

                    <h2 id="auth-POSTapi-login">Login.</h2>

<p>
</p>



<span id="example-requests-POSTapi-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"username\": \"jussi\",
    \"password\": \"strongpassword\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "username": "jussi",
    "password": "strongpassword"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-login">
</span>
<span id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-login" data-method="POST"
      data-path="api/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-login"
                    onclick="tryItOut('POSTapi-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-login"
                    onclick="cancelTryOut('POSTapi-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>username</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="username"                data-endpoint="POSTapi-login"
               value="jussi"
               data-component="body">
    <br>
<p>Username or email. Example: <code>jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-login"
               value="strongpassword"
               data-component="body">
    <br>
<p>Password. Example: <code>strongpassword</code></p>
        </div>
        </form>

                    <h2 id="auth-POSTapi-auth-google">Login or register using Google ID token.</h2>

<p>
</p>



<span id="example-requests-POSTapi-auth-google">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/auth/google" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"id_token\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/auth/google"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "id_token": "consequatur"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-google">
</span>
<span id="execution-results-POSTapi-auth-google" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-google"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-google"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-google" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-google">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-google" data-method="POST"
      data-path="api/auth/google"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-google', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-google"
                    onclick="tryItOut('POSTapi-auth-google');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-google"
                    onclick="cancelTryOut('POSTapi-auth-google');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-google"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/google</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-google"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-google"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>id_token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id_token"                data-endpoint="POSTapi-auth-google"
               value="consequatur"
               data-component="body">
    <br>
<p>Google ID token from frontend Google Sign-In flow. Example: <code>consequatur</code></p>
        </div>
        </form>

                    <h2 id="auth-POSTapi-lost-password">Send reset password email.</h2>

<p>
</p>



<span id="example-requests-POSTapi-lost-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/lost-password" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"jussi@example.com\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/lost-password"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "jussi@example.com"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-lost-password">
</span>
<span id="execution-results-POSTapi-lost-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-lost-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-lost-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-lost-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-lost-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-lost-password" data-method="POST"
      data-path="api/lost-password"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-lost-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-lost-password"
                    onclick="tryItOut('POSTapi-lost-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-lost-password"
                    onclick="cancelTryOut('POSTapi-lost-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-lost-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/lost-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-lost-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-lost-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-lost-password"
               value="jussi@example.com"
               data-component="body">
    <br>
<p>Email address. Example: <code>jussi@example.com</code></p>
        </div>
        </form>

                    <h2 id="auth-POSTapi-reset-password">Reset password with token.</h2>

<p>
</p>



<span id="example-requests-POSTapi-reset-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/reset-password" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"jussi@example.com\",
    \"token\": \"consequatur\",
    \"password\": \"newpassword\",
    \"password_confirmation\": \"newpassword\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/reset-password"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "jussi@example.com",
    "token": "consequatur",
    "password": "newpassword",
    "password_confirmation": "newpassword"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-reset-password">
</span>
<span id="execution-results-POSTapi-reset-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-reset-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-reset-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-reset-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-reset-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-reset-password" data-method="POST"
      data-path="api/reset-password"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-reset-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-reset-password"
                    onclick="tryItOut('POSTapi-reset-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-reset-password"
                    onclick="cancelTryOut('POSTapi-reset-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-reset-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/reset-password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-reset-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-reset-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-reset-password"
               value="jussi@example.com"
               data-component="body">
    <br>
<p>Email address. Example: <code>jussi@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="token"                data-endpoint="POSTapi-reset-password"
               value="consequatur"
               data-component="body">
    <br>
<p>Reset token Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-reset-password"
               value="newpassword"
               data-component="body">
    <br>
<p>New password. Example: <code>newpassword</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password_confirmation</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password_confirmation"                data-endpoint="POSTapi-reset-password"
               value="newpassword"
               data-component="body">
    <br>
<p>Password confirmation. Example: <code>newpassword</code></p>
        </div>
        </form>

                    <h2 id="auth-POSTapi-logout">Logout the authenticated user.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/logout" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/logout"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-logout">
</span>
<span id="execution-results-POSTapi-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-logout" data-method="POST"
      data-path="api/logout"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-logout"
                    onclick="tryItOut('POSTapi-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-logout"
                    onclick="cancelTryOut('POSTapi-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-logout"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="auth-GETapi-check-auth">Check authentication status.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-check-auth">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/check-auth" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/check-auth"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-check-auth">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-check-auth" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-check-auth"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-check-auth"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-check-auth" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-check-auth">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-check-auth" data-method="GET"
      data-path="api/check-auth"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-check-auth', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-check-auth"
                    onclick="tryItOut('GETapi-check-auth');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-check-auth"
                    onclick="cancelTryOut('GETapi-check-auth');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-check-auth"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/check-auth</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-check-auth"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-check-auth"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-check-auth"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="blog">Blog</h1>

    

                                <h2 id="blog-GETapi-blogs">List published blog posts (public).</h2>

<p>
</p>



<span id="example-requests-GETapi-blogs">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/blogs" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/blogs"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-blogs">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 45
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 4,
            &quot;user_id&quot;: 1,
            &quot;blog_category_id&quot;: 1,
            &quot;title&quot;: &quot;Welcome to the Blog&quot;,
            &quot;slug&quot;: &quot;welcome-to-the-blog&quot;,
            &quot;excerpt&quot;: &quot;This is the first blog post.&quot;,
            &quot;content&quot;: &quot;&lt;p&gt;Welcome! This is an example blog post created by the seeder.&lt;/p&gt;&quot;,
            &quot;featured_image&quot;: null,
            &quot;featured_image_sizes&quot;: null,
            &quot;tags&quot;: null,
            &quot;visibility&quot;: true,
            &quot;created_at&quot;: &quot;2026-03-19T11:56:10.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-03-19T11:56:10.000000Z&quot;,
            &quot;author&quot;: {
                &quot;id&quot;: 1,
                &quot;first_name&quot;: &quot;Super&quot;,
                &quot;last_name&quot;: &quot;Admin&quot;,
                &quot;name&quot;: &quot;superadmin&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Default&quot;,
                &quot;slug&quot;: &quot;default&quot;
            }
        },
        {
            &quot;id&quot;: 3,
            &quot;user_id&quot;: 1,
            &quot;blog_category_id&quot;: 1,
            &quot;title&quot;: &quot;sdasdsadasdsa&quot;,
            &quot;slug&quot;: &quot;sdasdsadasdsa&quot;,
            &quot;excerpt&quot;: &quot;dasdasdas&quot;,
            &quot;content&quot;: &quot;&lt;p&gt;Until recently, the prevailing view assumed &lt;em&gt;lorem ipsum&lt;/em&gt; was born as a nonsense text. &ldquo;It&rsquo;s not Latin, though it looks like it, and it actually says nothing,&rdquo; Before &amp;amp; After magazine &lt;a target=\&quot;_blank\&quot; rel=\&quot;noopener noreferrer nofollow\&quot; class=\&quot;underline hover:text-accent\&quot; href=\&quot;https://www.straightdope.com/columns/read/2290/what-does-the-filler-text-lorem-ipsum-mean/\&quot;&gt;answered a curious reader&lt;/a&gt;, &ldquo;Its &lsquo;words&rsquo; loosely approximate the frequency with which letters occur in English, which is why at a glance it looks pretty real.&rdquo;&lt;/p&gt;&lt;p&gt;As Cicero would put it, &ldquo;Um, not so fast.&rdquo;&lt;/p&gt;&lt;p&gt;The placeholder text, beginning with the line &ldquo;Lorem ipsum dolor sit amet, consectetur adipiscing elit&rdquo;, looks like Latin because in its youth, centuries ago, it was Latin.&lt;/p&gt;&lt;p&gt;Richard McClintock, a Latin scholar from Hampden-Sydney College, is &lt;a target=\&quot;_blank\&quot; rel=\&quot;noopener noreferrer nofollow\&quot; class=\&quot;underline hover:text-accent\&quot; href=\&quot;https://en.wikipedia.org/wiki/Lorem_ipsum\&quot;&gt;credited&lt;/a&gt; with discovering the source behind the ubiquitous filler text. In seeing a sample of lorem ipsum, his interest was piqued by consectetur&mdash;a genuine, albeit rare, Latin word. Consulting a Latin dictionary led McClintock to a passage from De Finibus Bonorum et Malorum (&ldquo;On the Extremes of Good and Evil&rdquo;), a first-century B.C. text from the Roman philosopher Cicero.&lt;/p&gt;&lt;p&gt;In particular, the garbled words of &lt;em&gt;lorem ipsum&lt;/em&gt; bear an unmistakable resemblance to sections 1.10.32&ndash;33 of Cicero&rsquo;s work, with the most notable passage excerpted below:&lt;/p&gt;&lt;blockquote&gt;&lt;p&gt;&ldquo;Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.&rdquo;&lt;/p&gt;&lt;/blockquote&gt;&lt;p&gt;A 1914 English translation by &lt;a target=\&quot;_blank\&quot; rel=\&quot;noopener noreferrer nofollow\&quot; class=\&quot;underline hover:text-accent\&quot; href=\&quot;https://en.wikipedia.org/wiki/Lorem_ipsum#English_translation\&quot;&gt;Harris Rackham&lt;/a&gt; reads:&lt;/p&gt;&lt;blockquote&gt;&lt;p&gt;&ldquo;Nor is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but occasionally circumstances occur in which toil and pain can procure him some great pleasure.&rdquo;&lt;/p&gt;&lt;/blockquote&gt;&lt;p&gt;McClintock&rsquo;s eye for detail certainly helped narrow the whereabouts of lorem ipsum&rsquo;s origin, however, the &ldquo;how and when&rdquo; still remain something of a mystery, with competing theories and timelines.&lt;/p&gt;&quot;,
            &quot;featured_image&quot;: &quot;blogs/3/featured_image_1773787684.jpg&quot;,
            &quot;featured_image_sizes&quot;: {
                &quot;large&quot;: &quot;blogs/3/1773787684_large.jpg&quot;,
                &quot;thumb&quot;: &quot;blogs/3/1773787684_thumb.jpg&quot;,
                &quot;medium&quot;: &quot;blogs/3/1773787684_medium.jpg&quot;
            },
            &quot;tags&quot;: [
                &quot;asd&quot;
            ],
            &quot;visibility&quot;: true,
            &quot;created_at&quot;: &quot;2026-03-17T15:11:50.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-03-17T22:56:40.000000Z&quot;,
            &quot;author&quot;: {
                &quot;id&quot;: 1,
                &quot;first_name&quot;: &quot;Super&quot;,
                &quot;last_name&quot;: &quot;Admin&quot;,
                &quot;name&quot;: &quot;superadmin&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Default&quot;,
                &quot;slug&quot;: &quot;default&quot;
            }
        }
    ],
    &quot;first_page_url&quot;: &quot;http://localhost:8000/api/blogs?page=1&quot;,
    &quot;from&quot;: 1,
    &quot;last_page&quot;: 1,
    &quot;last_page_url&quot;: &quot;http://localhost:8000/api/blogs?page=1&quot;,
    &quot;links&quot;: [
        {
            &quot;url&quot;: null,
            &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
            &quot;active&quot;: false
        },
        {
            &quot;url&quot;: &quot;http://localhost:8000/api/blogs?page=1&quot;,
            &quot;label&quot;: &quot;1&quot;,
            &quot;active&quot;: true
        },
        {
            &quot;url&quot;: null,
            &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
            &quot;active&quot;: false
        }
    ],
    &quot;next_page_url&quot;: null,
    &quot;path&quot;: &quot;http://localhost:8000/api/blogs&quot;,
    &quot;per_page&quot;: 15,
    &quot;prev_page_url&quot;: null,
    &quot;to&quot;: 2,
    &quot;total&quot;: 2
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-blogs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-blogs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-blogs"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-blogs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-blogs">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-blogs" data-method="GET"
      data-path="api/blogs"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-blogs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-blogs"
                    onclick="tryItOut('GETapi-blogs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-blogs"
                    onclick="cancelTryOut('GETapi-blogs');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-blogs"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/blogs</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-blogs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-blogs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="blog-GETapi-blogs--idOrSlug-">Show a single published blog post (public).</h2>

<p>
</p>



<span id="example-requests-GETapi-blogs--idOrSlug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/blogs/3" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/blogs/3"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-blogs--idOrSlug-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 44
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 3,
    &quot;user_id&quot;: 1,
    &quot;blog_category_id&quot;: 1,
    &quot;title&quot;: &quot;sdasdsadasdsa&quot;,
    &quot;slug&quot;: &quot;sdasdsadasdsa&quot;,
    &quot;excerpt&quot;: &quot;dasdasdas&quot;,
    &quot;content&quot;: &quot;&lt;p&gt;Until recently, the prevailing view assumed &lt;em&gt;lorem ipsum&lt;/em&gt; was born as a nonsense text. &ldquo;It&rsquo;s not Latin, though it looks like it, and it actually says nothing,&rdquo; Before &amp;amp; After magazine &lt;a target=\&quot;_blank\&quot; rel=\&quot;noopener noreferrer nofollow\&quot; class=\&quot;underline hover:text-accent\&quot; href=\&quot;https://www.straightdope.com/columns/read/2290/what-does-the-filler-text-lorem-ipsum-mean/\&quot;&gt;answered a curious reader&lt;/a&gt;, &ldquo;Its &lsquo;words&rsquo; loosely approximate the frequency with which letters occur in English, which is why at a glance it looks pretty real.&rdquo;&lt;/p&gt;&lt;p&gt;As Cicero would put it, &ldquo;Um, not so fast.&rdquo;&lt;/p&gt;&lt;p&gt;The placeholder text, beginning with the line &ldquo;Lorem ipsum dolor sit amet, consectetur adipiscing elit&rdquo;, looks like Latin because in its youth, centuries ago, it was Latin.&lt;/p&gt;&lt;p&gt;Richard McClintock, a Latin scholar from Hampden-Sydney College, is &lt;a target=\&quot;_blank\&quot; rel=\&quot;noopener noreferrer nofollow\&quot; class=\&quot;underline hover:text-accent\&quot; href=\&quot;https://en.wikipedia.org/wiki/Lorem_ipsum\&quot;&gt;credited&lt;/a&gt; with discovering the source behind the ubiquitous filler text. In seeing a sample of lorem ipsum, his interest was piqued by consectetur&mdash;a genuine, albeit rare, Latin word. Consulting a Latin dictionary led McClintock to a passage from De Finibus Bonorum et Malorum (&ldquo;On the Extremes of Good and Evil&rdquo;), a first-century B.C. text from the Roman philosopher Cicero.&lt;/p&gt;&lt;p&gt;In particular, the garbled words of &lt;em&gt;lorem ipsum&lt;/em&gt; bear an unmistakable resemblance to sections 1.10.32&ndash;33 of Cicero&rsquo;s work, with the most notable passage excerpted below:&lt;/p&gt;&lt;blockquote&gt;&lt;p&gt;&ldquo;Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.&rdquo;&lt;/p&gt;&lt;/blockquote&gt;&lt;p&gt;A 1914 English translation by &lt;a target=\&quot;_blank\&quot; rel=\&quot;noopener noreferrer nofollow\&quot; class=\&quot;underline hover:text-accent\&quot; href=\&quot;https://en.wikipedia.org/wiki/Lorem_ipsum#English_translation\&quot;&gt;Harris Rackham&lt;/a&gt; reads:&lt;/p&gt;&lt;blockquote&gt;&lt;p&gt;&ldquo;Nor is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but occasionally circumstances occur in which toil and pain can procure him some great pleasure.&rdquo;&lt;/p&gt;&lt;/blockquote&gt;&lt;p&gt;McClintock&rsquo;s eye for detail certainly helped narrow the whereabouts of lorem ipsum&rsquo;s origin, however, the &ldquo;how and when&rdquo; still remain something of a mystery, with competing theories and timelines.&lt;/p&gt;&quot;,
    &quot;featured_image&quot;: &quot;blogs/3/featured_image_1773787684.jpg&quot;,
    &quot;featured_image_sizes&quot;: {
        &quot;large&quot;: &quot;blogs/3/1773787684_large.jpg&quot;,
        &quot;thumb&quot;: &quot;blogs/3/1773787684_thumb.jpg&quot;,
        &quot;medium&quot;: &quot;blogs/3/1773787684_medium.jpg&quot;
    },
    &quot;tags&quot;: [
        &quot;asd&quot;
    ],
    &quot;visibility&quot;: true,
    &quot;created_at&quot;: &quot;2026-03-17T15:11:50.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2026-03-17T22:56:40.000000Z&quot;,
    &quot;author&quot;: {
        &quot;id&quot;: 1,
        &quot;first_name&quot;: &quot;Super&quot;,
        &quot;last_name&quot;: &quot;Admin&quot;,
        &quot;name&quot;: &quot;superadmin&quot;
    },
    &quot;category&quot;: {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;Default&quot;,
        &quot;slug&quot;: &quot;default&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-blogs--idOrSlug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-blogs--idOrSlug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-blogs--idOrSlug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-blogs--idOrSlug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-blogs--idOrSlug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-blogs--idOrSlug-" data-method="GET"
      data-path="api/blogs/{idOrSlug}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-blogs--idOrSlug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-blogs--idOrSlug-"
                    onclick="tryItOut('GETapi-blogs--idOrSlug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-blogs--idOrSlug-"
                    onclick="cancelTryOut('GETapi-blogs--idOrSlug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-blogs--idOrSlug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/blogs/{idOrSlug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-blogs--idOrSlug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-blogs--idOrSlug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>idOrSlug</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="idOrSlug"                data-endpoint="GETapi-blogs--idOrSlug-"
               value="3"
               data-component="url">
    <br>
<p>Example: <code>3</code></p>
            </div>
                    </form>

                    <h2 id="blog-GETapi-admin-blogs">List all blog posts for admin (including hidden).</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-admin-blogs">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/admin/blogs" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/admin/blogs"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-admin-blogs">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-admin-blogs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-admin-blogs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-admin-blogs"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-admin-blogs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-admin-blogs">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-admin-blogs" data-method="GET"
      data-path="api/admin/blogs"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-admin-blogs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-admin-blogs"
                    onclick="tryItOut('GETapi-admin-blogs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-admin-blogs"
                    onclick="cancelTryOut('GETapi-admin-blogs');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-admin-blogs"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/admin/blogs</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-admin-blogs"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-admin-blogs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-admin-blogs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="blog-POSTapi-blogs">Create a blog post.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-blogs">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/blogs" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "title=vmqeopfuudtdsufvyvddq"\
    --form "excerpt=consequatur"\
    --form "content=consequatur"\
    --form "blog_category_id=17"\
    --form "tags[]=mqeopfuudtdsufvyvddqa"\
    --form "visibility=1"\
    --form "featured_image=@/tmp/phpcIKfpf" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/blogs"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('title', 'vmqeopfuudtdsufvyvddq');
body.append('excerpt', 'consequatur');
body.append('content', 'consequatur');
body.append('blog_category_id', '17');
body.append('tags[]', 'mqeopfuudtdsufvyvddqa');
body.append('visibility', '1');
body.append('featured_image', document.querySelector('input[name="featured_image"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-blogs">
</span>
<span id="execution-results-POSTapi-blogs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-blogs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-blogs"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-blogs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-blogs">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-blogs" data-method="POST"
      data-path="api/blogs"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-blogs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-blogs"
                    onclick="tryItOut('POSTapi-blogs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-blogs"
                    onclick="cancelTryOut('POSTapi-blogs');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-blogs"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/blogs</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-blogs"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-blogs"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-blogs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="POSTapi-blogs"
               value="vmqeopfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>vmqeopfuudtdsufvyvddq</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>excerpt</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="excerpt"                data-endpoint="POSTapi-blogs"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>content</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="content"                data-endpoint="POSTapi-blogs"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>blog_category_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="blog_category_id"                data-endpoint="POSTapi-blogs"
               value="17"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the blog_categories table. Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>featured_image</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="featured_image"                data-endpoint="POSTapi-blogs"
               value=""
               data-component="body">
    <br>
<p>Must be a file. Must be an image. Must not be greater than 5120 kilobytes. Example: <code>/tmp/phpcIKfpf</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>tags</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="tags[0]"                data-endpoint="POSTapi-blogs"
               data-component="body">
        <input type="text" style="display: none"
               name="tags[1]"                data-endpoint="POSTapi-blogs"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>visibility</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-blogs" style="display: none">
            <input type="radio" name="visibility"
                   value="true"
                   data-endpoint="POSTapi-blogs"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-blogs" style="display: none">
            <input type="radio" name="visibility"
                   value="false"
                   data-endpoint="POSTapi-blogs"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
        </form>

                    <h2 id="blog-PUTapi-blogs--id-">Update a blog post.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-PUTapi-blogs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "https://backend-laravel.dev.jussialanen.com/api/blogs/3" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "title=vmqeopfuudtdsufvyvddq"\
    --form "excerpt=consequatur"\
    --form "content=consequatur"\
    --form "blog_category_id=17"\
    --form "tags[]=mqeopfuudtdsufvyvddqa"\
    --form "visibility=1"\
    --form "featured_image=@/tmp/phpAmhhNg" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/blogs/3"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('title', 'vmqeopfuudtdsufvyvddq');
body.append('excerpt', 'consequatur');
body.append('content', 'consequatur');
body.append('blog_category_id', '17');
body.append('tags[]', 'mqeopfuudtdsufvyvddqa');
body.append('visibility', '1');
body.append('featured_image', document.querySelector('input[name="featured_image"]').files[0]);

fetch(url, {
    method: "PUT",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-blogs--id-">
</span>
<span id="execution-results-PUTapi-blogs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-blogs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-blogs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-blogs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-blogs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-blogs--id-" data-method="PUT"
      data-path="api/blogs/{id}"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-blogs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-blogs--id-"
                    onclick="tryItOut('PUTapi-blogs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-blogs--id-"
                    onclick="cancelTryOut('PUTapi-blogs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-blogs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/blogs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-blogs--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-blogs--id-"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-blogs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-blogs--id-"
               value="3"
               data-component="url">
    <br>
<p>The ID of the blog. Example: <code>3</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="PUTapi-blogs--id-"
               value="vmqeopfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>vmqeopfuudtdsufvyvddq</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>excerpt</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="excerpt"                data-endpoint="PUTapi-blogs--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>content</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="content"                data-endpoint="PUTapi-blogs--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>blog_category_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="blog_category_id"                data-endpoint="PUTapi-blogs--id-"
               value="17"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the blog_categories table. Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>featured_image</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="featured_image"                data-endpoint="PUTapi-blogs--id-"
               value=""
               data-component="body">
    <br>
<p>Must be a file. Must be an image. Must not be greater than 5120 kilobytes. Example: <code>/tmp/phpAmhhNg</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>tags</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="tags[0]"                data-endpoint="PUTapi-blogs--id-"
               data-component="body">
        <input type="text" style="display: none"
               name="tags[1]"                data-endpoint="PUTapi-blogs--id-"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>visibility</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-blogs--id-" style="display: none">
            <input type="radio" name="visibility"
                   value="true"
                   data-endpoint="PUTapi-blogs--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-blogs--id-" style="display: none">
            <input type="radio" name="visibility"
                   value="false"
                   data-endpoint="PUTapi-blogs--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
        </form>

                    <h2 id="blog-DELETEapi-blogs--id-">Delete a blog post.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-blogs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "https://backend-laravel.dev.jussialanen.com/api/blogs/3" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/blogs/3"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-blogs--id-">
</span>
<span id="execution-results-DELETEapi-blogs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-blogs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-blogs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-blogs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-blogs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-blogs--id-" data-method="DELETE"
      data-path="api/blogs/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-blogs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-blogs--id-"
                    onclick="tryItOut('DELETEapi-blogs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-blogs--id-"
                    onclick="cancelTryOut('DELETEapi-blogs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-blogs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/blogs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-blogs--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-blogs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-blogs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-blogs--id-"
               value="3"
               data-component="url">
    <br>
<p>The ID of the blog. Example: <code>3</code></p>
            </div>
                    </form>

                <h1 id="blog-categories">Blog Categories</h1>

    

                                <h2 id="blog-categories-GETapi-blog-categories">List all blog categories.</h2>

<p>
</p>



<span id="example-requests-GETapi-blog-categories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/blog-categories" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/blog-categories"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-blog-categories">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 43
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;id&quot;: 2,
        &quot;name&quot;: &quot;adsdsadsdasdsa&quot;,
        &quot;slug&quot;: &quot;adsdsadsdasdsa&quot;,
        &quot;created_at&quot;: &quot;2026-03-17T15:13:05.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2026-03-17T15:13:05.000000Z&quot;
    },
    {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;Default&quot;,
        &quot;slug&quot;: &quot;default&quot;,
        &quot;created_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-blog-categories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-blog-categories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-blog-categories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-blog-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-blog-categories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-blog-categories" data-method="GET"
      data-path="api/blog-categories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-blog-categories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-blog-categories"
                    onclick="tryItOut('GETapi-blog-categories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-blog-categories"
                    onclick="cancelTryOut('GETapi-blog-categories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-blog-categories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/blog-categories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-blog-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-blog-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="blog-categories-POSTapi-blog-categories">Create a blog category.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-blog-categories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/blog-categories" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"vmqeopfuudtdsufvyvddq\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/blog-categories"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "vmqeopfuudtdsufvyvddq"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-blog-categories">
</span>
<span id="execution-results-POSTapi-blog-categories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-blog-categories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-blog-categories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-blog-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-blog-categories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-blog-categories" data-method="POST"
      data-path="api/blog-categories"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-blog-categories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-blog-categories"
                    onclick="tryItOut('POSTapi-blog-categories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-blog-categories"
                    onclick="cancelTryOut('POSTapi-blog-categories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-blog-categories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/blog-categories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-blog-categories"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-blog-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-blog-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-blog-categories"
               value="vmqeopfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>vmqeopfuudtdsufvyvddq</code></p>
        </div>
        </form>

                    <h2 id="blog-categories-PUTapi-blog-categories--id-">Update a blog category.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-PUTapi-blog-categories--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "https://backend-laravel.dev.jussialanen.com/api/blog-categories/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/blog-categories/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "PUT",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-blog-categories--id-">
</span>
<span id="execution-results-PUTapi-blog-categories--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-blog-categories--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-blog-categories--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-blog-categories--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-blog-categories--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-blog-categories--id-" data-method="PUT"
      data-path="api/blog-categories/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-blog-categories--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-blog-categories--id-"
                    onclick="tryItOut('PUTapi-blog-categories--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-blog-categories--id-"
                    onclick="cancelTryOut('PUTapi-blog-categories--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-blog-categories--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/blog-categories/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-blog-categories--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-blog-categories--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-blog-categories--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-blog-categories--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the blog category. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PUTapi-blog-categories--id-"
               value=""
               data-component="body">
    <br>

        </div>
        </form>

                    <h2 id="blog-categories-DELETEapi-blog-categories--id-">Delete a blog category.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-blog-categories--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "https://backend-laravel.dev.jussialanen.com/api/blog-categories/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/blog-categories/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-blog-categories--id-">
</span>
<span id="execution-results-DELETEapi-blog-categories--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-blog-categories--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-blog-categories--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-blog-categories--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-blog-categories--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-blog-categories--id-" data-method="DELETE"
      data-path="api/blog-categories/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-blog-categories--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-blog-categories--id-"
                    onclick="tryItOut('DELETEapi-blog-categories--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-blog-categories--id-"
                    onclick="cancelTryOut('DELETEapi-blog-categories--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-blog-categories--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/blog-categories/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-blog-categories--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-blog-categories--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-blog-categories--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-blog-categories--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the blog category. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-PATCHapi-users-update-role">Update a user&#039;s role by identifier (id, username or email).</h2>

<p>
</p>



<span id="example-requests-PATCHapi-users-update-role">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "https://backend-laravel.dev.jussialanen.com/api/users/update-role" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"role\": \"consequatur\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/users/update-role"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "role": "consequatur"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-users-update-role">
</span>
<span id="execution-results-PATCHapi-users-update-role" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-users-update-role"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-users-update-role"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-users-update-role" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-users-update-role">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-users-update-role" data-method="PATCH"
      data-path="api/users/update-role"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-users-update-role', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-users-update-role"
                    onclick="tryItOut('PATCHapi-users-update-role');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-users-update-role"
                    onclick="cancelTryOut('PATCHapi-users-update-role');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-users-update-role"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/users/update-role</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-users-update-role"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-users-update-role"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>role</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="role"                data-endpoint="PATCHapi-users-update-role"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-resumes--id--preview-pdf-render">Render a resume as an inline PDF via a signed URL (no auth token required).</h2>

<p>
</p>

<p>Obtain the URL from the signed-url endpoint first.</p>

<span id="example-requests-GETapi-resumes--id--preview-pdf-render">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/consequatur/preview/pdf/render" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/consequatur/preview/pdf/render"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes--id--preview-pdf-render">
            <blockquote>
            <p>Example response (403):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 42
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invalid signature.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes--id--preview-pdf-render" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes--id--preview-pdf-render"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes--id--preview-pdf-render"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes--id--preview-pdf-render" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes--id--preview-pdf-render">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes--id--preview-pdf-render" data-method="GET"
      data-path="api/resumes/{id}/preview/pdf/render"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes--id--preview-pdf-render', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes--id--preview-pdf-render"
                    onclick="tryItOut('GETapi-resumes--id--preview-pdf-render');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes--id--preview-pdf-render"
                    onclick="cancelTryOut('GETapi-resumes--id--preview-pdf-render');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes--id--preview-pdf-render"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/{id}/preview/pdf/render</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes--id--preview-pdf-render"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes--id--preview-pdf-render"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-resumes--id--preview-pdf-render"
               value="consequatur"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>consequatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-resumes--id--preview-html-render">Render a resume as inline HTML via a signed URL (no auth token required).</h2>

<p>
</p>

<p>Obtain the URL from the signed-url endpoint first.</p>

<span id="example-requests-GETapi-resumes--id--preview-html-render">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/consequatur/preview/html/render" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/consequatur/preview/html/render"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes--id--preview-html-render">
            <blockquote>
            <p>Example response (403):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 41
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invalid signature.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes--id--preview-html-render" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes--id--preview-html-render"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes--id--preview-html-render"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes--id--preview-html-render" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes--id--preview-html-render">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes--id--preview-html-render" data-method="GET"
      data-path="api/resumes/{id}/preview/html/render"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes--id--preview-html-render', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes--id--preview-html-render"
                    onclick="tryItOut('GETapi-resumes--id--preview-html-render');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes--id--preview-html-render"
                    onclick="cancelTryOut('GETapi-resumes--id--preview-html-render');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes--id--preview-html-render"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/{id}/preview/html/render</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes--id--preview-html-render"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes--id--preview-html-render"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-resumes--id--preview-html-render"
               value="consequatur"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>consequatur</code></p>
            </div>
                    </form>

                <h1 id="health">Health</h1>

    

                                <h2 id="health-GETapi-hello">Health check.</h2>

<p>
</p>



<span id="example-requests-GETapi-hello">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/hello" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/hello"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-hello">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">content-type: text/html; charset=UTF-8
cache-control: no-cache, private
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">Hello world from Laravel! This is a test route to check if the API is working.</code>
 </pre>
    </span>
<span id="execution-results-GETapi-hello" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-hello"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-hello"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-hello" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-hello">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-hello" data-method="GET"
      data-path="api/hello"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-hello', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-hello"
                    onclick="tryItOut('GETapi-hello');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-hello"
                    onclick="cancelTryOut('GETapi-hello');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-hello"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/hello</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-hello"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-hello"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="invoices">Invoices</h1>

    

                                <h2 id="invoices-GETapi-my-invoices">List invoices for the authenticated user.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns a paginated list of invoices belonging to the currently authenticated user.</p>

<span id="example-requests-GETapi-my-invoices">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/my-invoices?per_page=10&amp;page=1&amp;status=paid&amp;sort_by=created_at&amp;sort_dir=desc" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/my-invoices"
);

const params = {
    "per_page": "10",
    "page": "1",
    "status": "paid",
    "sort_by": "created_at",
    "sort_dir": "desc",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-my-invoices">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-my-invoices" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-my-invoices"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-my-invoices"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-my-invoices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-my-invoices">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-my-invoices" data-method="GET"
      data-path="api/my-invoices"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-my-invoices', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-my-invoices"
                    onclick="tryItOut('GETapi-my-invoices');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-my-invoices"
                    onclick="cancelTryOut('GETapi-my-invoices');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-my-invoices"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/my-invoices</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-my-invoices"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-my-invoices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-my-invoices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-my-invoices"
               value="10"
               data-component="query">
    <br>
<p>Items per page (1–100). Example: <code>10</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-my-invoices"
               value="1"
               data-component="query">
    <br>
<p>Page number. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="GETapi-my-invoices"
               value="paid"
               data-component="query">
    <br>
<p>Filter by status (draft, issued, paid, cancelled). Example: <code>paid</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-my-invoices"
               value="created_at"
               data-component="query">
    <br>
<p>Sort field (id, invoice_number, subtotal, total, status, issued_at, paid_at, created_at). Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_dir</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_dir"                data-endpoint="GETapi-my-invoices"
               value="desc"
               data-component="query">
    <br>
<p>Sort direction (asc, desc). Example: <code>desc</code></p>
            </div>
                </form>

                    <h2 id="invoices-GETapi-invoices-options">Return available invoice statuses and item types with translated labels.</h2>

<p>
</p>



<span id="example-requests-GETapi-invoices-options">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/invoices/options?lang=fi" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/invoices/options"
);

const params = {
    "lang": "fi",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-invoices-options">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 54
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;statuses&quot;: [
        {
            &quot;value&quot;: &quot;draft&quot;,
            &quot;label&quot;: &quot;Luonnos&quot;,
            &quot;color&quot;: &quot;gray&quot;
        },
        {
            &quot;value&quot;: &quot;issued&quot;,
            &quot;label&quot;: &quot;L&auml;hetetty&quot;,
            &quot;color&quot;: &quot;blue&quot;
        },
        {
            &quot;value&quot;: &quot;unpaid&quot;,
            &quot;label&quot;: &quot;Maksamatta&quot;,
            &quot;color&quot;: &quot;orange&quot;
        },
        {
            &quot;value&quot;: &quot;overdue&quot;,
            &quot;label&quot;: &quot;Er&auml;&auml;ntynyt&quot;,
            &quot;color&quot;: &quot;red&quot;
        },
        {
            &quot;value&quot;: &quot;paid&quot;,
            &quot;label&quot;: &quot;Maksettu&quot;,
            &quot;color&quot;: &quot;green&quot;
        },
        {
            &quot;value&quot;: &quot;cancelled&quot;,
            &quot;label&quot;: &quot;Peruutettu&quot;,
            &quot;color&quot;: &quot;gray&quot;
        }
    ],
    &quot;item_types&quot;: [
        {
            &quot;value&quot;: &quot;product&quot;,
            &quot;label&quot;: &quot;Tuote&quot;
        },
        {
            &quot;value&quot;: &quot;shipping&quot;,
            &quot;label&quot;: &quot;Toimitus&quot;
        },
        {
            &quot;value&quot;: &quot;discount&quot;,
            &quot;label&quot;: &quot;Alennus&quot;
        },
        {
            &quot;value&quot;: &quot;fee&quot;,
            &quot;label&quot;: &quot;Maksu&quot;
        },
        {
            &quot;value&quot;: &quot;other&quot;,
            &quot;label&quot;: &quot;Muu&quot;
        },
        {
            &quot;value&quot;: &quot;adjustment&quot;,
            &quot;label&quot;: &quot;S&auml;&auml;t&ouml;&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-invoices-options" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-invoices-options"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-invoices-options"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-invoices-options" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-invoices-options">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-invoices-options" data-method="GET"
      data-path="api/invoices/options"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-invoices-options', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-invoices-options"
                    onclick="tryItOut('GETapi-invoices-options');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-invoices-options"
                    onclick="cancelTryOut('GETapi-invoices-options');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-invoices-options"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/invoices/options</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-invoices-options"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-invoices-options"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>lang</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lang"                data-endpoint="GETapi-invoices-options"
               value="fi"
               data-component="query">
    <br>
<p>Language code (en, fi). Defaults to en. Example: <code>fi</code></p>
            </div>
                </form>

                    <h2 id="invoices-POSTapi-invoices-export-pdf">Export a preview invoice as PDF (no auth, no database save).</h2>

<p>
</p>

<p>Builds a transient invoice from the request body and returns it as a downloadable PDF.</p>

<span id="example-requests-POSTapi-invoices-export-pdf">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/invoices/export/pdf" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"invoice_number\": \"INV-2026-00001\",
    \"customer_first_name\": \"Jussi\",
    \"customer_last_name\": \"Palanen\",
    \"customer_email\": \"jussi@example.com\",
    \"customer_phone\": \"+358401234567\",
    \"billing_address\": [],
    \"subtotal\": 99,
    \"total\": 122.76,
    \"status\": \"draft\",
    \"notes\": \"Thank you for your business.\",
    \"items\": [
        \"consequatur\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/invoices/export/pdf"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "invoice_number": "INV-2026-00001",
    "customer_first_name": "Jussi",
    "customer_last_name": "Palanen",
    "customer_email": "jussi@example.com",
    "customer_phone": "+358401234567",
    "billing_address": [],
    "subtotal": 99,
    "total": 122.76,
    "status": "draft",
    "notes": "Thank you for your business.",
    "items": [
        "consequatur"
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-invoices-export-pdf">
            <blockquote>
            <p>Example response (200, PDF file):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;binary&quot;: &quot;application/pdf&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;The items.0.type field is required.&quot;,
    &quot;errors&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-invoices-export-pdf" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-invoices-export-pdf"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-invoices-export-pdf"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-invoices-export-pdf" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-invoices-export-pdf">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-invoices-export-pdf" data-method="POST"
      data-path="api/invoices/export/pdf"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-invoices-export-pdf', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-invoices-export-pdf"
                    onclick="tryItOut('POSTapi-invoices-export-pdf');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-invoices-export-pdf"
                    onclick="cancelTryOut('POSTapi-invoices-export-pdf');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-invoices-export-pdf"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/invoices/export/pdf</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-invoices-export-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-invoices-export-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>invoice_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="invoice_number"                data-endpoint="POSTapi-invoices-export-pdf"
               value="INV-2026-00001"
               data-component="body">
    <br>
<p>Invoice number shown on the document. Example: <code>INV-2026-00001</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_first_name"                data-endpoint="POSTapi-invoices-export-pdf"
               value="Jussi"
               data-component="body">
    <br>
<p>Customer first name. Example: <code>Jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_last_name"                data-endpoint="POSTapi-invoices-export-pdf"
               value="Palanen"
               data-component="body">
    <br>
<p>Customer last name. Example: <code>Palanen</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_email"                data-endpoint="POSTapi-invoices-export-pdf"
               value="jussi@example.com"
               data-component="body">
    <br>
<p>Customer email. Example: <code>jussi@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_phone"                data-endpoint="POSTapi-invoices-export-pdf"
               value="+358401234567"
               data-component="body">
    <br>
<p>Customer phone. Example: <code>+358401234567</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>billing_address</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="billing_address"                data-endpoint="POSTapi-invoices-export-pdf"
               value=""
               data-component="body">
    <br>
<p>Billing address (street, city, postal_code, country).</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>subtotal</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="subtotal"                data-endpoint="POSTapi-invoices-export-pdf"
               value="99"
               data-component="body">
    <br>
<p>Invoice subtotal. Example: <code>99</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>total</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="total"                data-endpoint="POSTapi-invoices-export-pdf"
               value="122.76"
               data-component="body">
    <br>
<p>Invoice total. Example: <code>122.76</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="POSTapi-invoices-export-pdf"
               value="draft"
               data-component="body">
    <br>
<p>Invoice status (draft, issued, paid, cancelled). Example: <code>draft</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="notes"                data-endpoint="POSTapi-invoices-export-pdf"
               value="Thank you for your business."
               data-component="body">
    <br>
<p>Optional notes. Example: <code>Thank you for your business.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>items</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Invoice line items.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="items.0.type"                data-endpoint="POSTapi-invoices-export-pdf"
               value="product"
               data-component="body">
    <br>
<p>Item type (product, shipping, discount, adjustment). Example: <code>product</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="items.0.description"                data-endpoint="POSTapi-invoices-export-pdf"
               value="Example Product"
               data-component="body">
    <br>
<p>Item description. Example: <code>Example Product</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.quantity"                data-endpoint="POSTapi-invoices-export-pdf"
               value="2"
               data-component="body">
    <br>
<p>Quantity. Example: <code>2</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>unit_price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.unit_price"                data-endpoint="POSTapi-invoices-export-pdf"
               value="49.5"
               data-component="body">
    <br>
<p>Unit price. Example: <code>49.5</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>tax_rate</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.tax_rate"                data-endpoint="POSTapi-invoices-export-pdf"
               value="0.24"
               data-component="body">
    <br>
<p>Tax rate (0–1). Example: <code>0.24</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>total</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.total"                data-endpoint="POSTapi-invoices-export-pdf"
               value="99"
               data-component="body">
    <br>
<p>Line total. Example: <code>99</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="invoices-POSTapi-invoices-export-html">Export a preview invoice as HTML (no auth, no database save).</h2>

<p>
</p>

<p>Builds a transient invoice from the request body and returns it as an HTML file.</p>

<span id="example-requests-POSTapi-invoices-export-html">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/invoices/export/html" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"invoice_number\": \"INV-2026-00001\",
    \"customer_first_name\": \"Jussi\",
    \"customer_last_name\": \"Palanen\",
    \"customer_email\": \"jussi@example.com\",
    \"customer_phone\": \"+358401234567\",
    \"billing_address\": [],
    \"subtotal\": 99,
    \"total\": 122.76,
    \"status\": \"draft\",
    \"notes\": \"Thank you for your business.\",
    \"items\": [
        \"consequatur\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/invoices/export/html"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "invoice_number": "INV-2026-00001",
    "customer_first_name": "Jussi",
    "customer_last_name": "Palanen",
    "customer_email": "jussi@example.com",
    "customer_phone": "+358401234567",
    "billing_address": [],
    "subtotal": 99,
    "total": 122.76,
    "status": "draft",
    "notes": "Thank you for your business.",
    "items": [
        "consequatur"
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-invoices-export-html">
            <blockquote>
            <p>Example response (200, HTML file):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;binary&quot;: &quot;text/html&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;The items.0.type field is required.&quot;,
    &quot;errors&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-invoices-export-html" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-invoices-export-html"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-invoices-export-html"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-invoices-export-html" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-invoices-export-html">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-invoices-export-html" data-method="POST"
      data-path="api/invoices/export/html"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-invoices-export-html', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-invoices-export-html"
                    onclick="tryItOut('POSTapi-invoices-export-html');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-invoices-export-html"
                    onclick="cancelTryOut('POSTapi-invoices-export-html');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-invoices-export-html"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/invoices/export/html</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-invoices-export-html"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-invoices-export-html"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>invoice_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="invoice_number"                data-endpoint="POSTapi-invoices-export-html"
               value="INV-2026-00001"
               data-component="body">
    <br>
<p>Invoice number shown on the document. Example: <code>INV-2026-00001</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_first_name"                data-endpoint="POSTapi-invoices-export-html"
               value="Jussi"
               data-component="body">
    <br>
<p>Customer first name. Example: <code>Jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_last_name"                data-endpoint="POSTapi-invoices-export-html"
               value="Palanen"
               data-component="body">
    <br>
<p>Customer last name. Example: <code>Palanen</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_email"                data-endpoint="POSTapi-invoices-export-html"
               value="jussi@example.com"
               data-component="body">
    <br>
<p>Customer email. Example: <code>jussi@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_phone"                data-endpoint="POSTapi-invoices-export-html"
               value="+358401234567"
               data-component="body">
    <br>
<p>Customer phone. Example: <code>+358401234567</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>billing_address</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="billing_address"                data-endpoint="POSTapi-invoices-export-html"
               value=""
               data-component="body">
    <br>
<p>Billing address (street, city, postal_code, country).</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>subtotal</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="subtotal"                data-endpoint="POSTapi-invoices-export-html"
               value="99"
               data-component="body">
    <br>
<p>Invoice subtotal. Example: <code>99</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>total</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="total"                data-endpoint="POSTapi-invoices-export-html"
               value="122.76"
               data-component="body">
    <br>
<p>Invoice total. Example: <code>122.76</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="POSTapi-invoices-export-html"
               value="draft"
               data-component="body">
    <br>
<p>Invoice status (draft, issued, paid, cancelled). Example: <code>draft</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="notes"                data-endpoint="POSTapi-invoices-export-html"
               value="Thank you for your business."
               data-component="body">
    <br>
<p>Optional notes. Example: <code>Thank you for your business.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>items</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Invoice line items.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="items.0.type"                data-endpoint="POSTapi-invoices-export-html"
               value="product"
               data-component="body">
    <br>
<p>Item type (product, shipping, discount, adjustment). Example: <code>product</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="items.0.description"                data-endpoint="POSTapi-invoices-export-html"
               value="Example Product"
               data-component="body">
    <br>
<p>Item description. Example: <code>Example Product</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.quantity"                data-endpoint="POSTapi-invoices-export-html"
               value="2"
               data-component="body">
    <br>
<p>Quantity. Example: <code>2</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>unit_price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.unit_price"                data-endpoint="POSTapi-invoices-export-html"
               value="49.5"
               data-component="body">
    <br>
<p>Unit price. Example: <code>49.5</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>tax_rate</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.tax_rate"                data-endpoint="POSTapi-invoices-export-html"
               value="0.24"
               data-component="body">
    <br>
<p>Tax rate (0–1). Example: <code>0.24</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>total</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.total"                data-endpoint="POSTapi-invoices-export-html"
               value="99"
               data-component="body">
    <br>
<p>Line total. Example: <code>99</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="invoices-POSTapi-invoices-export-email">Send a preview invoice by email (no auth, no database save).</h2>

<p>
</p>

<p>Builds a transient invoice from the request body and sends it to <code>to_email</code>.
If <code>to_email</code> is omitted, falls back to <code>customer_email</code> in the payload.</p>

<span id="example-requests-POSTapi-invoices-export-email">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/invoices/export/email" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"to_email\": \"someone@example.com\",
    \"invoice_number\": \"INV-2026-00001\",
    \"customer_first_name\": \"Jussi\",
    \"customer_last_name\": \"Palanen\",
    \"customer_email\": \"jussi@example.com\",
    \"customer_phone\": \"+358401234567\",
    \"billing_address\": [],
    \"subtotal\": 99,
    \"total\": 122.76,
    \"status\": \"draft\",
    \"notes\": \"Thank you for your business.\",
    \"items\": [
        \"consequatur\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/invoices/export/email"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "to_email": "someone@example.com",
    "invoice_number": "INV-2026-00001",
    "customer_first_name": "Jussi",
    "customer_last_name": "Palanen",
    "customer_email": "jussi@example.com",
    "customer_phone": "+358401234567",
    "billing_address": [],
    "subtotal": 99,
    "total": 122.76,
    "status": "draft",
    "notes": "Thank you for your business.",
    "items": [
        "consequatur"
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-invoices-export-email">
            <blockquote>
            <p>Example response (200, Sent):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice sent to someone@example.com&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;The to email field is required.&quot;,
    &quot;errors&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-invoices-export-email" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-invoices-export-email"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-invoices-export-email"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-invoices-export-email" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-invoices-export-email">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-invoices-export-email" data-method="POST"
      data-path="api/invoices/export/email"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-invoices-export-email', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-invoices-export-email"
                    onclick="tryItOut('POSTapi-invoices-export-email');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-invoices-export-email"
                    onclick="cancelTryOut('POSTapi-invoices-export-email');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-invoices-export-email"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/invoices/export/email</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-invoices-export-email"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-invoices-export-email"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>to_email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="to_email"                data-endpoint="POSTapi-invoices-export-email"
               value="someone@example.com"
               data-component="body">
    <br>
<p>Recipient email address. Example: <code>someone@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>invoice_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="invoice_number"                data-endpoint="POSTapi-invoices-export-email"
               value="INV-2026-00001"
               data-component="body">
    <br>
<p>Invoice number shown on the document. Example: <code>INV-2026-00001</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_first_name"                data-endpoint="POSTapi-invoices-export-email"
               value="Jussi"
               data-component="body">
    <br>
<p>Customer first name. Example: <code>Jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_last_name"                data-endpoint="POSTapi-invoices-export-email"
               value="Palanen"
               data-component="body">
    <br>
<p>Customer last name. Example: <code>Palanen</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_email"                data-endpoint="POSTapi-invoices-export-email"
               value="jussi@example.com"
               data-component="body">
    <br>
<p>Customer email shown on the document. Example: <code>jussi@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_phone"                data-endpoint="POSTapi-invoices-export-email"
               value="+358401234567"
               data-component="body">
    <br>
<p>Customer phone. Example: <code>+358401234567</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>billing_address</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="billing_address"                data-endpoint="POSTapi-invoices-export-email"
               value=""
               data-component="body">
    <br>
<p>Billing address (street, city, postal_code, country).</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>subtotal</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="subtotal"                data-endpoint="POSTapi-invoices-export-email"
               value="99"
               data-component="body">
    <br>
<p>Invoice subtotal. Example: <code>99</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>total</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="total"                data-endpoint="POSTapi-invoices-export-email"
               value="122.76"
               data-component="body">
    <br>
<p>Invoice total. Example: <code>122.76</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="POSTapi-invoices-export-email"
               value="draft"
               data-component="body">
    <br>
<p>Invoice status (draft, issued, paid, cancelled). Example: <code>draft</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="notes"                data-endpoint="POSTapi-invoices-export-email"
               value="Thank you for your business."
               data-component="body">
    <br>
<p>Optional notes. Example: <code>Thank you for your business.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>items</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Invoice line items.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="items.0.type"                data-endpoint="POSTapi-invoices-export-email"
               value="product"
               data-component="body">
    <br>
<p>Item type (product, shipping, discount, adjustment). Example: <code>product</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="items.0.description"                data-endpoint="POSTapi-invoices-export-email"
               value="Example Product"
               data-component="body">
    <br>
<p>Item description. Example: <code>Example Product</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.quantity"                data-endpoint="POSTapi-invoices-export-email"
               value="2"
               data-component="body">
    <br>
<p>Quantity. Example: <code>2</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>unit_price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.unit_price"                data-endpoint="POSTapi-invoices-export-email"
               value="49.5"
               data-component="body">
    <br>
<p>Unit price. Example: <code>49.5</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>tax_rate</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.tax_rate"                data-endpoint="POSTapi-invoices-export-email"
               value="0.24"
               data-component="body">
    <br>
<p>Tax rate (0–1). Example: <code>0.24</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>total</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.total"                data-endpoint="POSTapi-invoices-export-email"
               value="99"
               data-component="body">
    <br>
<p>Line total. Example: <code>99</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="invoices-POSTapi-invoices--id--send">Send an invoice by email.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Sends the invoice as a PDF attachment to the customer email or to a specific email address if provided.</p>

<span id="example-requests-POSTapi-invoices--id--send">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/invoices/1/send" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"someone@example.com\",
    \"lang\": \"en\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/invoices/1/send"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "someone@example.com",
    "lang": "en"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-invoices--id--send">
            <blockquote>
            <p>Example response (200, Sent):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice sent to someone@example.com&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (403, Forbidden):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Forbidden.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice not found&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;The email field must be a valid email address.&quot;,
    &quot;errors&quot;: {}
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-invoices--id--send" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-invoices--id--send"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-invoices--id--send"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-invoices--id--send" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-invoices--id--send">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-invoices--id--send" data-method="POST"
      data-path="api/invoices/{id}/send"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-invoices--id--send', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-invoices--id--send"
                    onclick="tryItOut('POSTapi-invoices--id--send');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-invoices--id--send"
                    onclick="cancelTryOut('POSTapi-invoices--id--send');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-invoices--id--send"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/invoices/{id}/send</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-invoices--id--send"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-invoices--id--send"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-invoices--id--send"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-invoices--id--send"
               value="1"
               data-component="url">
    <br>
<p>The invoice ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-invoices--id--send"
               value="someone@example.com"
               data-component="body">
    <br>
<p>Optional recipient email. Defaults to the invoice's customer email. Example: <code>someone@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>lang</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lang"                data-endpoint="POSTapi-invoices--id--send"
               value="en"
               data-component="body">
    <br>
<p>Example: <code>en</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>en</code></li> <li><code>fi</code></li></ul>
        </div>
        </form>

                    <h2 id="invoices-GETapi-invoices">List invoices.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns a paginated list of invoices. Results can be filtered by order, user and status.</p>

<span id="example-requests-GETapi-invoices">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/invoices?per_page=25&amp;page=2&amp;order_id=5&amp;user_id=3&amp;status=issued&amp;sort_by=created_at&amp;sort_dir=desc" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/invoices"
);

const params = {
    "per_page": "25",
    "page": "2",
    "order_id": "5",
    "user_id": "3",
    "status": "issued",
    "sort_by": "created_at",
    "sort_dir": "desc",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-invoices">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 1,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;order_id&quot;: 1,
            &quot;user_id&quot;: 2,
            &quot;invoice_number&quot;: &quot;INV-2026-00001&quot;,
            &quot;customer_first_name&quot;: &quot;Jussi&quot;,
            &quot;customer_last_name&quot;: &quot;Palanen&quot;,
            &quot;customer_email&quot;: &quot;jussi@example.com&quot;,
            &quot;customer_phone&quot;: &quot;+358401234567&quot;,
            &quot;billing_address&quot;: {
                &quot;street&quot;: &quot;Mannerheimintie 1&quot;,
                &quot;city&quot;: &quot;Helsinki&quot;,
                &quot;postal_code&quot;: &quot;00100&quot;,
                &quot;country&quot;: &quot;FI&quot;
            },
            &quot;subtotal&quot;: &quot;99.00&quot;,
            &quot;total&quot;: &quot;99.00&quot;,
            &quot;status&quot;: &quot;issued&quot;,
            &quot;issued_at&quot;: &quot;2026-03-10T20:00:00.000000Z&quot;,
            &quot;paid_at&quot;: null,
            &quot;notes&quot;: null,
            &quot;created_at&quot;: &quot;2026-03-10T19:00:00.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-03-10T20:00:00.000000Z&quot;
        }
    ],
    &quot;per_page&quot;: 25,
    &quot;total&quot;: 1
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-invoices" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-invoices"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-invoices"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-invoices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-invoices">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-invoices" data-method="GET"
      data-path="api/invoices"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-invoices', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-invoices"
                    onclick="tryItOut('GETapi-invoices');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-invoices"
                    onclick="cancelTryOut('GETapi-invoices');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-invoices"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/invoices</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-invoices"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-invoices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-invoices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-invoices"
               value="25"
               data-component="query">
    <br>
<p>Items per page (1–100). Example: <code>25</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-invoices"
               value="2"
               data-component="query">
    <br>
<p>Page number. Example: <code>2</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>order_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="order_id"                data-endpoint="GETapi-invoices"
               value="5"
               data-component="query">
    <br>
<p>Filter by order ID. Example: <code>5</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user_id"                data-endpoint="GETapi-invoices"
               value="3"
               data-component="query">
    <br>
<p>Filter by user ID. Example: <code>3</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="GETapi-invoices"
               value="issued"
               data-component="query">
    <br>
<p>Filter by status (draft, issued, paid, cancelled). Example: <code>issued</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-invoices"
               value="created_at"
               data-component="query">
    <br>
<p>Sort field (id, invoice_number, subtotal, total, status, issued_at, paid_at, created_at). Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_dir</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_dir"                data-endpoint="GETapi-invoices"
               value="desc"
               data-component="query">
    <br>
<p>Sort direction (asc, desc). Example: <code>desc</code></p>
            </div>
                </form>

                    <h2 id="invoices-GETapi-invoices--id-">Get an invoice.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns a single invoice with its items, associated order and user.</p>

<span id="example-requests-GETapi-invoices--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/invoices/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/invoices/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-invoices--id-">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;order_id&quot;: 1,
    &quot;user_id&quot;: 2,
    &quot;invoice_number&quot;: &quot;INV-2026-00001&quot;,
    &quot;status&quot;: &quot;issued&quot;,
    &quot;items&quot;: [],
    &quot;created_at&quot;: &quot;2026-03-10T19:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2026-03-10T20:00:00.000000Z&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (403, Forbidden):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Forbidden.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-invoices--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-invoices--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-invoices--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-invoices--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-invoices--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-invoices--id-" data-method="GET"
      data-path="api/invoices/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-invoices--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-invoices--id-"
                    onclick="tryItOut('GETapi-invoices--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-invoices--id-"
                    onclick="cancelTryOut('GETapi-invoices--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-invoices--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/invoices/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-invoices--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-invoices--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-invoices--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-invoices--id-"
               value="1"
               data-component="url">
    <br>
<p>The invoice ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="invoices-GETapi-invoices--id--pdf">Download invoice as PDF.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns a PDF file of the invoice.</p>

<span id="example-requests-GETapi-invoices--id--pdf">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/invoices/1/pdf" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/invoices/1/pdf"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-invoices--id--pdf">
            <blockquote>
            <p>Example response (200, PDF file):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;binary&quot;: &quot;application/pdf&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (403, Forbidden):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Forbidden.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-invoices--id--pdf" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-invoices--id--pdf"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-invoices--id--pdf"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-invoices--id--pdf" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-invoices--id--pdf">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-invoices--id--pdf" data-method="GET"
      data-path="api/invoices/{id}/pdf"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-invoices--id--pdf', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-invoices--id--pdf"
                    onclick="tryItOut('GETapi-invoices--id--pdf');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-invoices--id--pdf"
                    onclick="cancelTryOut('GETapi-invoices--id--pdf');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-invoices--id--pdf"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/invoices/{id}/pdf</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-invoices--id--pdf"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-invoices--id--pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-invoices--id--pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-invoices--id--pdf"
               value="1"
               data-component="url">
    <br>
<p>The invoice ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="invoices-GETapi-invoices--id--html">Download a stored invoice as HTML.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-invoices--id--html">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/invoices/1/html" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/invoices/1/html"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-invoices--id--html">
            <blockquote>
            <p>Example response (200, HTML file):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;binary&quot;: &quot;text/html&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (403, Forbidden):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Forbidden.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-invoices--id--html" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-invoices--id--html"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-invoices--id--html"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-invoices--id--html" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-invoices--id--html">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-invoices--id--html" data-method="GET"
      data-path="api/invoices/{id}/html"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-invoices--id--html', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-invoices--id--html"
                    onclick="tryItOut('GETapi-invoices--id--html');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-invoices--id--html"
                    onclick="cancelTryOut('GETapi-invoices--id--html');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-invoices--id--html"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/invoices/{id}/html</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-invoices--id--html"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-invoices--id--html"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-invoices--id--html"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-invoices--id--html"
               value="1"
               data-component="url">
    <br>
<p>The invoice ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="invoices-POSTapi-invoices">Create an invoice.</h2>

<p>
</p>

<p>Creates a new invoice for the given order and automatically generates invoice items from the order's line items.</p>

<span id="example-requests-POSTapi-invoices">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/invoices" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"order_id\": 1,
    \"due_date\": \"2026-03-19T22:06:19\",
    \"notes\": \"Net 30\",
    \"status\": \"draft\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/invoices"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "order_id": 1,
    "due_date": "2026-03-19T22:06:19",
    "notes": "Net 30",
    "status": "draft"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-invoices">
            <blockquote>
            <p>Example response (201, Created):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;order_id&quot;: 1,
    &quot;user_id&quot;: 2,
    &quot;invoice_number&quot;: &quot;INV-2026-00001&quot;,
    &quot;customer_first_name&quot;: &quot;Jussi&quot;,
    &quot;customer_last_name&quot;: &quot;Palanen&quot;,
    &quot;customer_email&quot;: &quot;jussi@example.com&quot;,
    &quot;customer_phone&quot;: &quot;+358401234567&quot;,
    &quot;billing_address&quot;: {
        &quot;street&quot;: &quot;Mannerheimintie 1&quot;,
        &quot;city&quot;: &quot;Helsinki&quot;,
        &quot;postal_code&quot;: &quot;00100&quot;,
        &quot;country&quot;: &quot;FI&quot;
    },
    &quot;subtotal&quot;: &quot;99.00&quot;,
    &quot;total&quot;: &quot;99.00&quot;,
    &quot;status&quot;: &quot;draft&quot;,
    &quot;issued_at&quot;: null,
    &quot;paid_at&quot;: null,
    &quot;notes&quot;: &quot;Net 30&quot;,
    &quot;items&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;invoice_id&quot;: 1,
            &quot;order_item_id&quot;: 3,
            &quot;type&quot;: &quot;product&quot;,
            &quot;description&quot;: &quot;Example Product&quot;,
            &quot;quantity&quot;: 2,
            &quot;unit_price&quot;: &quot;49.50&quot;,
            &quot;tax_rate&quot;: &quot;0.0000&quot;,
            &quot;total&quot;: &quot;99.00&quot;
        }
    ],
    &quot;created_at&quot;: &quot;2026-03-10T19:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2026-03-10T19:00:00.000000Z&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;The order id field is required.&quot;,
    &quot;errors&quot;: {
        &quot;order_id&quot;: [
            &quot;The order id field is required.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-invoices" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-invoices"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-invoices"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-invoices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-invoices">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-invoices" data-method="POST"
      data-path="api/invoices"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-invoices', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-invoices"
                    onclick="tryItOut('POSTapi-invoices');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-invoices"
                    onclick="cancelTryOut('POSTapi-invoices');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-invoices"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/invoices</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-invoices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-invoices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>order_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="order_id"                data-endpoint="POSTapi-invoices"
               value="1"
               data-component="body">
    <br>
<p>The ID of the order to invoice. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>due_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="due_date"                data-endpoint="POSTapi-invoices"
               value="2026-03-19T22:06:19"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-03-19T22:06:19</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="notes"                data-endpoint="POSTapi-invoices"
               value="Net 30"
               data-component="body">
    <br>
<p>Optional free-text notes. Example: <code>Net 30</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="POSTapi-invoices"
               value="draft"
               data-component="body">
    <br>
<p>Invoice status on creation (draft, issued, paid, cancelled). Defaults to draft. Example: <code>draft</code></p>
        </div>
        </form>

                    <h2 id="invoices-PUTapi-invoices--id-">Update an invoice.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Updates an existing invoice. Automatically sets <code>issued_at</code> when status changes to <code>issued</code>, and <code>paid_at</code> when status changes to <code>paid</code>.</p>

<span id="example-requests-PUTapi-invoices--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "https://backend-laravel.dev.jussialanen.com/api/invoices/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"status\": \"issued\",
    \"customer_first_name\": \"Jussi\",
    \"customer_last_name\": \"Palanen\",
    \"customer_email\": \"jussi@example.com\",
    \"customer_phone\": \"+358401234567\",
    \"billing_address\": [],
    \"subtotal\": 153.47,
    \"total\": 153.47,
    \"due_date\": \"2026-03-19T22:06:19\",
    \"notes\": \"Net 30\",
    \"items\": [
        {
            \"id\": 1,
            \"type\": \"product\",
            \"description\": \"Wireless Headphones\",
            \"quantity\": 2,
            \"unit_price\": 79.99,
            \"tax_rate\": 0.24,
            \"total\": 159.98
        }
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/invoices/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "status": "issued",
    "customer_first_name": "Jussi",
    "customer_last_name": "Palanen",
    "customer_email": "jussi@example.com",
    "customer_phone": "+358401234567",
    "billing_address": [],
    "subtotal": 153.47,
    "total": 153.47,
    "due_date": "2026-03-19T22:06:19",
    "notes": "Net 30",
    "items": [
        {
            "id": 1,
            "type": "product",
            "description": "Wireless Headphones",
            "quantity": 2,
            "unit_price": 79.99,
            "tax_rate": 0.24,
            "total": 159.98
        }
    ]
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-invoices--id-">
            <blockquote>
            <p>Example response (200, Success):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;order_id&quot;: 1,
    &quot;user_id&quot;: 2,
    &quot;invoice_number&quot;: &quot;INV-2026-00001&quot;,
    &quot;customer_first_name&quot;: &quot;Jussi&quot;,
    &quot;customer_last_name&quot;: &quot;Palanen&quot;,
    &quot;customer_email&quot;: &quot;jussi@example.com&quot;,
    &quot;customer_phone&quot;: &quot;+358401234567&quot;,
    &quot;billing_address&quot;: {
        &quot;street&quot;: &quot;Mannerheimintie 1&quot;,
        &quot;city&quot;: &quot;Helsinki&quot;,
        &quot;postal_code&quot;: &quot;00100&quot;,
        &quot;country&quot;: &quot;FI&quot;
    },
    &quot;subtotal&quot;: &quot;99.00&quot;,
    &quot;total&quot;: &quot;99.00&quot;,
    &quot;status&quot;: &quot;issued&quot;,
    &quot;issued_at&quot;: &quot;2026-03-10T20:00:00.000000Z&quot;,
    &quot;paid_at&quot;: null,
    &quot;notes&quot;: &quot;Net 30&quot;,
    &quot;items&quot;: [],
    &quot;created_at&quot;: &quot;2026-03-10T19:00:00.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2026-03-10T20:00:00.000000Z&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice not found&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Validation error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;The status field must be one of draft, issued, paid, cancelled.&quot;,
    &quot;errors&quot;: {
        &quot;status&quot;: [
            &quot;The status field must be one of draft, issued, paid, cancelled.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-invoices--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-invoices--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-invoices--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-invoices--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-invoices--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-invoices--id-" data-method="PUT"
      data-path="api/invoices/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-invoices--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-invoices--id-"
                    onclick="tryItOut('PUTapi-invoices--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-invoices--id-"
                    onclick="cancelTryOut('PUTapi-invoices--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-invoices--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/invoices/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-invoices--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-invoices--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-invoices--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-invoices--id-"
               value="1"
               data-component="url">
    <br>
<p>The invoice ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="PUTapi-invoices--id-"
               value="issued"
               data-component="body">
    <br>
<p>Invoice status (draft, issued, paid, cancelled). Example: <code>issued</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_first_name"                data-endpoint="PUTapi-invoices--id-"
               value="Jussi"
               data-component="body">
    <br>
<p>Customer first name. Example: <code>Jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_last_name"                data-endpoint="PUTapi-invoices--id-"
               value="Palanen"
               data-component="body">
    <br>
<p>Customer last name. Example: <code>Palanen</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_email"                data-endpoint="PUTapi-invoices--id-"
               value="jussi@example.com"
               data-component="body">
    <br>
<p>Customer email address. Example: <code>jussi@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_phone"                data-endpoint="PUTapi-invoices--id-"
               value="+358401234567"
               data-component="body">
    <br>
<p>Customer phone number. Example: <code>+358401234567</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>billing_address</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="billing_address"                data-endpoint="PUTapi-invoices--id-"
               value=""
               data-component="body">
    <br>
<p>Billing address object.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>subtotal</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="subtotal"                data-endpoint="PUTapi-invoices--id-"
               value="153.47"
               data-component="body">
    <br>
<p>Subtotal amount. Example: <code>153.47</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>total</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="total"                data-endpoint="PUTapi-invoices--id-"
               value="153.47"
               data-component="body">
    <br>
<p>Total amount. Example: <code>153.47</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>due_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="due_date"                data-endpoint="PUTapi-invoices--id-"
               value="2026-03-19T22:06:19"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-03-19T22:06:19</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="notes"                data-endpoint="PUTapi-invoices--id-"
               value="Net 30"
               data-component="body">
    <br>
<p>Free-text notes. Example: <code>Net 30</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>items</code></b>&nbsp;&nbsp;
<small>object[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Optional array of invoice items to sync. Items with <code>id</code> are updated, items without <code>id</code> are created, existing items omitted from the array are deleted.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.id"                data-endpoint="PUTapi-invoices--id-"
               value="1"
               data-component="body">
    <br>
<p>Existing item ID to update. Omit to create a new item. Example: <code>1</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="items.0.type"                data-endpoint="PUTapi-invoices--id-"
               value="product"
               data-component="body">
    <br>
<p>Item type (product, shipping, discount, adjustment). Example: <code>product</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="items.0.description"                data-endpoint="PUTapi-invoices--id-"
               value="Wireless Headphones"
               data-component="body">
    <br>
<p>Item description. Example: <code>Wireless Headphones</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.quantity"                data-endpoint="PUTapi-invoices--id-"
               value="2"
               data-component="body">
    <br>
<p>Quantity. Example: <code>2</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>unit_price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.unit_price"                data-endpoint="PUTapi-invoices--id-"
               value="79.99"
               data-component="body">
    <br>
<p>Unit price. Example: <code>79.99</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>tax_rate</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.tax_rate"                data-endpoint="PUTapi-invoices--id-"
               value="0.24"
               data-component="body">
    <br>
<p>Tax rate as decimal (e.g. 0.24 = 24%). Example: <code>0.24</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>total</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.total"                data-endpoint="PUTapi-invoices--id-"
               value="159.98"
               data-component="body">
    <br>
<p>Line total. Example: <code>159.98</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="invoices-DELETEapi-invoices--id-">Delete an invoice.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Permanently deletes an invoice and all its associated items.</p>

<span id="example-requests-DELETEapi-invoices--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "https://backend-laravel.dev.jussialanen.com/api/invoices/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/invoices/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-invoices--id-">
            <blockquote>
            <p>Example response (200, Deleted):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice deleted&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (403, Forbidden):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Forbidden.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404, Not found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invoice not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-invoices--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-invoices--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-invoices--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-invoices--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-invoices--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-invoices--id-" data-method="DELETE"
      data-path="api/invoices/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-invoices--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-invoices--id-"
                    onclick="tryItOut('DELETEapi-invoices--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-invoices--id-"
                    onclick="cancelTryOut('DELETEapi-invoices--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-invoices--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/invoices/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-invoices--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-invoices--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-invoices--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-invoices--id-"
               value="1"
               data-component="url">
    <br>
<p>The invoice ID. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="orders">Orders</h1>

    

                                <h2 id="orders-GETapi-orders">Display a listing of orders.</h2>

<p>
</p>



<span id="example-requests-GETapi-orders">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/orders?per_page=25&amp;page=2&amp;user_id=5&amp;customer_id=5&amp;status=pending&amp;sort_by=created_at&amp;sort_dir=desc" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/orders"
);

const params = {
    "per_page": "25",
    "page": "2",
    "user_id": "5",
    "customer_id": "5",
    "status": "pending",
    "sort_by": "created_at",
    "sort_dir": "desc",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-orders">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 56
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 2,
    &quot;data&quot;: [],
    &quot;first_page_url&quot;: &quot;http://localhost:8000/api/orders?page=1&quot;,
    &quot;from&quot;: null,
    &quot;last_page&quot;: 1,
    &quot;last_page_url&quot;: &quot;http://localhost:8000/api/orders?page=1&quot;,
    &quot;links&quot;: [
        {
            &quot;url&quot;: &quot;http://localhost:8000/api/orders?page=1&quot;,
            &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
            &quot;active&quot;: false
        },
        {
            &quot;url&quot;: &quot;http://localhost:8000/api/orders?page=1&quot;,
            &quot;label&quot;: &quot;1&quot;,
            &quot;active&quot;: false
        },
        {
            &quot;url&quot;: null,
            &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
            &quot;active&quot;: false
        }
    ],
    &quot;next_page_url&quot;: null,
    &quot;path&quot;: &quot;http://localhost:8000/api/orders&quot;,
    &quot;per_page&quot;: 25,
    &quot;prev_page_url&quot;: &quot;http://localhost:8000/api/orders?page=1&quot;,
    &quot;to&quot;: null,
    &quot;total&quot;: 0
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-orders" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-orders"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-orders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-orders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-orders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-orders" data-method="GET"
      data-path="api/orders"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-orders', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-orders"
                    onclick="tryItOut('GETapi-orders');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-orders"
                    onclick="cancelTryOut('GETapi-orders');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-orders"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/orders</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-orders"
               value="25"
               data-component="query">
    <br>
<p>Items per page. Example: <code>25</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-orders"
               value="2"
               data-component="query">
    <br>
<p>Page number. Example: <code>2</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user_id"                data-endpoint="GETapi-orders"
               value="5"
               data-component="query">
    <br>
<p>Filter by user ID. Example: <code>5</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customer_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="customer_id"                data-endpoint="GETapi-orders"
               value="5"
               data-component="query">
    <br>
<p>Legacy filter by user ID. Example: <code>5</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="GETapi-orders"
               value="pending"
               data-component="query">
    <br>
<p>Filter by status. Example: <code>pending</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-orders"
               value="created_at"
               data-component="query">
    <br>
<p>Sort field. Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_dir</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_dir"                data-endpoint="GETapi-orders"
               value="desc"
               data-component="query">
    <br>
<p>Sort direction. Example: <code>desc</code></p>
            </div>
                </form>

                    <h2 id="orders-POSTapi-orders">Store a newly created order.</h2>

<p>
</p>



<span id="example-requests-POSTapi-orders">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/orders" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"customer_first_name\": \"Jussi\",
    \"customer_last_name\": \"Palanen\",
    \"customer_email\": \"jussi@example.com\",
    \"customer_phone\": \"+358401234567\",
    \"shipping_address\": [],
    \"billing_address\": [],
    \"notes\": \"consequatur\",
    \"lang\": \"fi\",
    \"items\": [
        \"consequatur\"
    ],
    \"user_id\": 5
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/orders"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "customer_first_name": "Jussi",
    "customer_last_name": "Palanen",
    "customer_email": "jussi@example.com",
    "customer_phone": "+358401234567",
    "shipping_address": [],
    "billing_address": [],
    "notes": "consequatur",
    "lang": "fi",
    "items": [
        "consequatur"
    ],
    "user_id": 5
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-orders">
</span>
<span id="execution-results-POSTapi-orders" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-orders"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-orders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-orders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-orders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-orders" data-method="POST"
      data-path="api/orders"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-orders', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-orders"
                    onclick="tryItOut('POSTapi-orders');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-orders"
                    onclick="cancelTryOut('POSTapi-orders');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-orders"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/orders</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_first_name"                data-endpoint="POSTapi-orders"
               value="Jussi"
               data-component="body">
    <br>
<p>First name. Example: <code>Jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_last_name"                data-endpoint="POSTapi-orders"
               value="Palanen"
               data-component="body">
    <br>
<p>Last name. Example: <code>Palanen</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_email"                data-endpoint="POSTapi-orders"
               value="jussi@example.com"
               data-component="body">
    <br>
<p>Email address. Example: <code>jussi@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_phone"                data-endpoint="POSTapi-orders"
               value="+358401234567"
               data-component="body">
    <br>
<p>Phone number. Example: <code>+358401234567</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>shipping_address</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="shipping_address"                data-endpoint="POSTapi-orders"
               value=""
               data-component="body">
    <br>
<p>Shipping address object.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>billing_address</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="billing_address"                data-endpoint="POSTapi-orders"
               value=""
               data-component="body">
    <br>
<p>Billing address object.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="notes"                data-endpoint="POSTapi-orders"
               value="consequatur"
               data-component="body">
    <br>
<p>Order notes. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>lang</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lang"                data-endpoint="POSTapi-orders"
               value="fi"
               data-component="body">
    <br>
<p>Language code for order emails (en or fi). Defaults to en. Example: <code>fi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>items</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
 &nbsp;
<br>
<p>Order items array.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.product_id"                data-endpoint="POSTapi-orders"
               value="17"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the products table. Example: <code>17</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.quantity"                data-endpoint="POSTapi-orders"
               value="45"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>45</code></p>
                    </div>
                                                                <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>*</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.*.product_id"                data-endpoint="POSTapi-orders"
               value="1"
               data-component="body">
    <br>
<p>Product ID. Example: <code>1</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.*.quantity"                data-endpoint="POSTapi-orders"
               value="2"
               data-component="body">
    <br>
<p>Quantity. Example: <code>2</code></p>
                    </div>
                                    </details>
        </div>
                                        </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user_id"                data-endpoint="POSTapi-orders"
               value="5"
               data-component="body">
    <br>
<p>Optional user ID. Example: <code>5</code></p>
        </div>
        </form>

                    <h2 id="orders-GETapi-orders--id-">Display the specified order.</h2>

<p>
</p>



<span id="example-requests-GETapi-orders--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/orders/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/orders/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-orders--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 55
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;user_id&quot;: 1,
    &quot;customer_first_name&quot;: &quot;Jussi&quot;,
    &quot;customer_last_name&quot;: &quot;Palanen&quot;,
    &quot;customer_email&quot;: &quot;jussi@example.com&quot;,
    &quot;customer_phone&quot;: &quot;+358401234567&quot;,
    &quot;order_number&quot;: &quot;ORD-2026-00001&quot;,
    &quot;status&quot;: &quot;completed&quot;,
    &quot;total_amount&quot;: &quot;89.97&quot;,
    &quot;shipping_address&quot;: {
        &quot;city&quot;: &quot;Helsinki&quot;,
        &quot;street&quot;: &quot;Mannerheimintie 1&quot;,
        &quot;country&quot;: &quot;FI&quot;,
        &quot;postal_code&quot;: &quot;00100&quot;
    },
    &quot;billing_address&quot;: {
        &quot;city&quot;: &quot;Helsinki&quot;,
        &quot;street&quot;: &quot;Mannerheimintie 1&quot;,
        &quot;country&quot;: &quot;FI&quot;,
        &quot;postal_code&quot;: &quot;00100&quot;
    },
    &quot;notes&quot;: null,
    &quot;lang&quot;: &quot;en&quot;,
    &quot;created_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
    &quot;user&quot;: {
        &quot;id&quot;: 1,
        &quot;first_name&quot;: &quot;Super&quot;,
        &quot;last_name&quot;: &quot;Admin&quot;,
        &quot;username&quot;: &quot;superadmin&quot;,
        &quot;name&quot;: &quot;superadmin&quot;,
        &quot;email&quot;: &quot;juzapala+superadmin@gmail.com&quot;,
        &quot;google_id&quot;: null,
        &quot;avatar&quot;: null,
        &quot;email_verified_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
        &quot;created_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
        &quot;updated_at&quot;: &quot;2026-03-19T17:41:28.000000Z&quot;
    },
    &quot;items&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;order_id&quot;: 1,
            &quot;product_id&quot;: 13,
            &quot;product_title&quot;: &quot;Wireless Headphones&quot;,
            &quot;quantity&quot;: 1,
            &quot;unit_price&quot;: &quot;79.99&quot;,
            &quot;sale_price&quot;: null,
            &quot;subtotal&quot;: &quot;79.99&quot;,
            &quot;created_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
            &quot;featured_image&quot;: null,
            &quot;images&quot;: [],
            &quot;featured_image_url&quot;: null,
            &quot;images_urls&quot;: [],
            &quot;product&quot;: {
                &quot;id&quot;: 13,
                &quot;title&quot;: &quot;Wireless Headphones&quot;,
                &quot;description&quot;: &quot;Example product for seeding&quot;,
                &quot;price&quot;: &quot;79.99&quot;,
                &quot;sale_price&quot;: null,
                &quot;tax_code&quot;: null,
                &quot;tax_rate&quot;: null,
                &quot;quantity&quot;: 0,
                &quot;featured_image&quot;: null,
                &quot;featured_image_sizes&quot;: null,
                &quot;images&quot;: null,
                &quot;images_sizes&quot;: null,
                &quot;visibility&quot;: true,
                &quot;created_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
                &quot;featured_image_url&quot;: null,
                &quot;featured_image_sizes_urls&quot;: [],
                &quot;images_urls&quot;: [],
                &quot;images_sizes_urls&quot;: []
            }
        },
        {
            &quot;id&quot;: 2,
            &quot;order_id&quot;: 1,
            &quot;product_id&quot;: 14,
            &quot;product_title&quot;: &quot;USB-C Cable&quot;,
            &quot;quantity&quot;: 2,
            &quot;unit_price&quot;: &quot;4.99&quot;,
            &quot;sale_price&quot;: null,
            &quot;subtotal&quot;: &quot;9.98&quot;,
            &quot;created_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
            &quot;featured_image&quot;: null,
            &quot;images&quot;: [],
            &quot;featured_image_url&quot;: null,
            &quot;images_urls&quot;: [],
            &quot;product&quot;: {
                &quot;id&quot;: 14,
                &quot;title&quot;: &quot;USB-C Cable&quot;,
                &quot;description&quot;: &quot;Example product for seeding&quot;,
                &quot;price&quot;: &quot;4.99&quot;,
                &quot;sale_price&quot;: null,
                &quot;tax_code&quot;: null,
                &quot;tax_rate&quot;: null,
                &quot;quantity&quot;: 0,
                &quot;featured_image&quot;: null,
                &quot;featured_image_sizes&quot;: null,
                &quot;images&quot;: null,
                &quot;images_sizes&quot;: null,
                &quot;visibility&quot;: true,
                &quot;created_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
                &quot;featured_image_url&quot;: null,
                &quot;featured_image_sizes_urls&quot;: [],
                &quot;images_urls&quot;: [],
                &quot;images_sizes_urls&quot;: []
            }
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-orders--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-orders--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-orders--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-orders--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-orders--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-orders--id-" data-method="GET"
      data-path="api/orders/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-orders--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-orders--id-"
                    onclick="tryItOut('GETapi-orders--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-orders--id-"
                    onclick="cancelTryOut('GETapi-orders--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-orders--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/orders/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-orders--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-orders--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-orders--id-"
               value="1"
               data-component="url">
    <br>
<p>Order ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="orders-PUTapi-orders--id-">Update the specified order.</h2>

<p>
</p>



<span id="example-requests-PUTapi-orders--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "https://backend-laravel.dev.jussialanen.com/api/orders/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"status\": \"processing\",
    \"customer_first_name\": \"Jussi\",
    \"customer_last_name\": \"Palanen\",
    \"customer_email\": \"jussi@example.com\",
    \"customer_phone\": \"+358401234567\",
    \"shipping_address\": [],
    \"billing_address\": [],
    \"notes\": \"consequatur\",
    \"items\": [
        \"consequatur\"
    ],
    \"send_status_email\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/orders/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "status": "processing",
    "customer_first_name": "Jussi",
    "customer_last_name": "Palanen",
    "customer_email": "jussi@example.com",
    "customer_phone": "+358401234567",
    "shipping_address": [],
    "billing_address": [],
    "notes": "consequatur",
    "items": [
        "consequatur"
    ],
    "send_status_email": false
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-orders--id-">
</span>
<span id="execution-results-PUTapi-orders--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-orders--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-orders--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-orders--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-orders--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-orders--id-" data-method="PUT"
      data-path="api/orders/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-orders--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-orders--id-"
                    onclick="tryItOut('PUTapi-orders--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-orders--id-"
                    onclick="cancelTryOut('PUTapi-orders--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-orders--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/orders/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-orders--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-orders--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-orders--id-"
               value="1"
               data-component="url">
    <br>
<p>Order ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="PUTapi-orders--id-"
               value="processing"
               data-component="body">
    <br>
<p>Order status. Example: <code>processing</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_first_name"                data-endpoint="PUTapi-orders--id-"
               value="Jussi"
               data-component="body">
    <br>
<p>First name. Example: <code>Jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_last_name"                data-endpoint="PUTapi-orders--id-"
               value="Palanen"
               data-component="body">
    <br>
<p>Last name. Example: <code>Palanen</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_email"                data-endpoint="PUTapi-orders--id-"
               value="jussi@example.com"
               data-component="body">
    <br>
<p>Email address. Example: <code>jussi@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_phone"                data-endpoint="PUTapi-orders--id-"
               value="+358401234567"
               data-component="body">
    <br>
<p>Phone number. Example: <code>+358401234567</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>shipping_address</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="shipping_address"                data-endpoint="PUTapi-orders--id-"
               value=""
               data-component="body">
    <br>
<p>Shipping address object.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>billing_address</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="billing_address"                data-endpoint="PUTapi-orders--id-"
               value=""
               data-component="body">
    <br>
<p>Billing address object.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="notes"                data-endpoint="PUTapi-orders--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>Order notes. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>items</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Order items array.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.product_id"                data-endpoint="PUTapi-orders--id-"
               value="17"
               data-component="body">
    <br>
<p>This field is required when <code>items</code> is present. The <code>id</code> of an existing record in the products table. Example: <code>17</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.quantity"                data-endpoint="PUTapi-orders--id-"
               value="45"
               data-component="body">
    <br>
<p>This field is required when <code>items</code> is present. Must be at least 1. Example: <code>45</code></p>
                    </div>
                                                                <div style=" margin-left: 14px; clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>*</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.*.product_id"                data-endpoint="PUTapi-orders--id-"
               value="1"
               data-component="body">
    <br>
<p>Product ID. Example: <code>1</code></p>
                    </div>
                                                                <div style="margin-left: 28px; clear: unset;">
                        <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.*.quantity"                data-endpoint="PUTapi-orders--id-"
               value="2"
               data-component="body">
    <br>
<p>Quantity. Example: <code>2</code></p>
                    </div>
                                    </details>
        </div>
                                        </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>send_status_email</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-orders--id-" style="display: none">
            <input type="radio" name="send_status_email"
                   value="true"
                   data-endpoint="PUTapi-orders--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-orders--id-" style="display: none">
            <input type="radio" name="send_status_email"
                   value="false"
                   data-endpoint="PUTapi-orders--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Whether to send the status change email. Defaults to true. Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="orders-DELETEapi-orders--id-">Remove the specified order.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-orders--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "https://backend-laravel.dev.jussialanen.com/api/orders/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/orders/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-orders--id-">
</span>
<span id="execution-results-DELETEapi-orders--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-orders--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-orders--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-orders--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-orders--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-orders--id-" data-method="DELETE"
      data-path="api/orders/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-orders--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-orders--id-"
                    onclick="tryItOut('DELETEapi-orders--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-orders--id-"
                    onclick="cancelTryOut('DELETEapi-orders--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-orders--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/orders/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-orders--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-orders--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-orders--id-"
               value="1"
               data-component="url">
    <br>
<p>Order ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="orders-GETapi-my-orders">Display a listing of orders for the authenticated user.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-my-orders">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/my-orders?per_page=25&amp;page=2&amp;status=pending&amp;sort_by=created_at&amp;sort_dir=desc" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/my-orders"
);

const params = {
    "per_page": "25",
    "page": "2",
    "status": "pending",
    "sort_by": "created_at",
    "sort_dir": "desc",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-my-orders">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-my-orders" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-my-orders"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-my-orders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-my-orders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-my-orders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-my-orders" data-method="GET"
      data-path="api/my-orders"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-my-orders', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-my-orders"
                    onclick="tryItOut('GETapi-my-orders');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-my-orders"
                    onclick="cancelTryOut('GETapi-my-orders');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-my-orders"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/my-orders</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-my-orders"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-my-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-my-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-my-orders"
               value="25"
               data-component="query">
    <br>
<p>Items per page. Example: <code>25</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-my-orders"
               value="2"
               data-component="query">
    <br>
<p>Page number. Example: <code>2</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="GETapi-my-orders"
               value="pending"
               data-component="query">
    <br>
<p>Filter by status. Example: <code>pending</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-my-orders"
               value="created_at"
               data-component="query">
    <br>
<p>Sort field. Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_dir</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_dir"                data-endpoint="GETapi-my-orders"
               value="desc"
               data-component="query">
    <br>
<p>Sort direction. Example: <code>desc</code></p>
            </div>
                </form>

                <h1 id="products">Products</h1>

    

                                <h2 id="products-GETapi-products">List products.</h2>

<p>
</p>



<span id="example-requests-GETapi-products">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/products?per_page=25&amp;page=2&amp;search=headphones&amp;ids=1%2C2%2C3&amp;sort_by=created_at&amp;sort_dir=desc" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/products"
);

const params = {
    "per_page": "25",
    "page": "2",
    "search": "headphones",
    "ids": "1,2,3",
    "sort_by": "created_at",
    "sort_dir": "desc",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-products">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 58
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;current_page&quot;: 2,
    &quot;data&quot;: [],
    &quot;first_page_url&quot;: &quot;http://localhost:8000/api/products?page=1&quot;,
    &quot;from&quot;: null,
    &quot;last_page&quot;: 1,
    &quot;last_page_url&quot;: &quot;http://localhost:8000/api/products?page=1&quot;,
    &quot;links&quot;: [
        {
            &quot;url&quot;: &quot;http://localhost:8000/api/products?page=1&quot;,
            &quot;label&quot;: &quot;&amp;laquo; Previous&quot;,
            &quot;active&quot;: false
        },
        {
            &quot;url&quot;: &quot;http://localhost:8000/api/products?page=1&quot;,
            &quot;label&quot;: &quot;1&quot;,
            &quot;active&quot;: false
        },
        {
            &quot;url&quot;: null,
            &quot;label&quot;: &quot;Next &amp;raquo;&quot;,
            &quot;active&quot;: false
        }
    ],
    &quot;next_page_url&quot;: null,
    &quot;path&quot;: &quot;http://localhost:8000/api/products&quot;,
    &quot;per_page&quot;: 25,
    &quot;prev_page_url&quot;: &quot;http://localhost:8000/api/products?page=1&quot;,
    &quot;to&quot;: null,
    &quot;total&quot;: 0
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-products" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-products"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-products"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-products" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-products">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-products" data-method="GET"
      data-path="api/products"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-products', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-products"
                    onclick="tryItOut('GETapi-products');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-products"
                    onclick="cancelTryOut('GETapi-products');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-products"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/products</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-products"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-products"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-products"
               value="25"
               data-component="query">
    <br>
<p>Items per page. Example: <code>25</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-products"
               value="2"
               data-component="query">
    <br>
<p>Page number. Example: <code>2</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-products"
               value="headphones"
               data-component="query">
    <br>
<p>Search by title or description. Example: <code>headphones</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>ids</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ids"                data-endpoint="GETapi-products"
               value="1,2,3"
               data-component="query">
    <br>
<p>Comma-separated product IDs. Example: <code>1,2,3</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-products"
               value="created_at"
               data-component="query">
    <br>
<p>Sort field. Example: <code>created_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_dir</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_dir"                data-endpoint="GETapi-products"
               value="desc"
               data-component="query">
    <br>
<p>Sort direction. Example: <code>desc</code></p>
            </div>
                </form>

                    <h2 id="products-POSTapi-products">Create a product.</h2>

<p>
</p>



<span id="example-requests-POSTapi-products">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/products" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "user_id=17"\
    --form "id=1001"\
    --form "title=Wireless Headphones"\
    --form "description=Premium noise-cancelling headphones"\
    --form "price=299.99"\
    --form "sale_price=249.99"\
    --form "tax_code=CN"\
    --form "tax_rate=1"\
    --form "quantity=50"\
    --form "visibility=1"\
    --form "featured_image=@/tmp/phpoeOAfD" \
    --form "images[]=@/tmp/phpnBgheD" \
    --form "images[]=@/tmp/phpNGHEfD" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/products"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('user_id', '17');
body.append('id', '1001');
body.append('title', 'Wireless Headphones');
body.append('description', 'Premium noise-cancelling headphones');
body.append('price', '299.99');
body.append('sale_price', '249.99');
body.append('tax_code', 'CN');
body.append('tax_rate', '1');
body.append('quantity', '50');
body.append('visibility', '1');
body.append('featured_image', document.querySelector('input[name="featured_image"]').files[0]);
body.append('images[]', document.querySelector('input[name="images[]"]').files[0]);
body.append('images[]', document.querySelector('input[name="images[]"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-products">
</span>
<span id="execution-results-POSTapi-products" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-products"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-products"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-products" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-products">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-products" data-method="POST"
      data-path="api/products"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-products', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-products"
                    onclick="tryItOut('POSTapi-products');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-products"
                    onclick="cancelTryOut('POSTapi-products');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-products"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/products</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-products"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-products"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user_id"                data-endpoint="POSTapi-products"
               value="17"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the users table. Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-products"
               value="1001"
               data-component="body">
    <br>
<p>Optional custom ID. Example: <code>1001</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="POSTapi-products"
               value="Wireless Headphones"
               data-component="body">
    <br>
<p>Product title. Example: <code>Wireless Headphones</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="POSTapi-products"
               value="Premium noise-cancelling headphones"
               data-component="body">
    <br>
<p>Product description. Example: <code>Premium noise-cancelling headphones</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="price"                data-endpoint="POSTapi-products"
               value="299.99"
               data-component="body">
    <br>
<p>Price. Example: <code>299.99</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>sale_price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="sale_price"                data-endpoint="POSTapi-products"
               value="249.99"
               data-component="body">
    <br>
<p>Sale price. Example: <code>249.99</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>tax_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="tax_code"                data-endpoint="POSTapi-products"
               value="CN"
               data-component="body">
    <br>
<p>Example: <code>CN</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>ZERO</code></li> <li><code>AT</code></li> <li><code>BE</code></li> <li><code>BG</code></li> <li><code>HR</code></li> <li><code>CY</code></li> <li><code>CZ</code></li> <li><code>DK</code></li> <li><code>EE</code></li> <li><code>FI</code></li> <li><code>FR</code></li> <li><code>DE</code></li> <li><code>GR</code></li> <li><code>HU</code></li> <li><code>IE</code></li> <li><code>IT</code></li> <li><code>LV</code></li> <li><code>LT</code></li> <li><code>LU</code></li> <li><code>MT</code></li> <li><code>NL</code></li> <li><code>PL</code></li> <li><code>PT</code></li> <li><code>RO</code></li> <li><code>SK</code></li> <li><code>SI</code></li> <li><code>ES</code></li> <li><code>SE</code></li> <li><code>UK</code></li> <li><code>NO</code></li> <li><code>CH</code></li> <li><code>AR</code></li> <li><code>BR</code></li> <li><code>CA</code></li> <li><code>MX</code></li> <li><code>AU</code></li> <li><code>CN</code></li> <li><code>ID</code></li> <li><code>IN</code></li> <li><code>JP</code></li> <li><code>KR</code></li> <li><code>NZ</code></li> <li><code>PH</code></li> <li><code>SG</code></li> <li><code>TH</code></li> <li><code>AE</code></li> <li><code>IL</code></li> <li><code>SA</code></li> <li><code>EG</code></li> <li><code>GH</code></li> <li><code>KE</code></li> <li><code>NG</code></li> <li><code>ZA</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>tax_rate</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="tax_rate"                data-endpoint="POSTapi-products"
               value="1"
               data-component="body">
    <br>
<p>tax_rate is a snapshot; if omitted but tax_code is given, resolve from TaxRateController. Must be at least 0. Must not be greater than 1. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantity"                data-endpoint="POSTapi-products"
               value="50"
               data-component="body">
    <br>
<p>Quantity in stock. Example: <code>50</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>featured_image</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="featured_image"                data-endpoint="POSTapi-products"
               value=""
               data-component="body">
    <br>
<p>Featured image file. Example: <code>/tmp/phpoeOAfD</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>visibility</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-products" style="display: none">
            <input type="radio" name="visibility"
                   value="true"
                   data-endpoint="POSTapi-products"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-products" style="display: none">
            <input type="radio" name="visibility"
                   value="false"
                   data-endpoint="POSTapi-products"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Visibility flag. Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>images</code></b>&nbsp;&nbsp;
<small>file[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="images[0]"                data-endpoint="POSTapi-products"
               data-component="body">
        <input type="file" style="display: none"
               name="images[1]"                data-endpoint="POSTapi-products"
               data-component="body">
    <br>
<p>Must be a file. Must be an image. Must not be greater than 5120 kilobytes.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>images[]</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="images.0"                data-endpoint="POSTapi-products"
               value=""
               data-component="body">
    <br>
<p>Additional image files. Example: <code>/tmp/phpNGHEfD</code></p>
        </div>
        </form>

                    <h2 id="products-GETapi-products--id-">Get a product.</h2>

<p>
</p>



<span id="example-requests-GETapi-products--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/products/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/products/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-products--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 57
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;title&quot;: &quot;sapiente quia fugit&quot;,
    &quot;description&quot;: &quot;Nemo aut natus consectetur quam magni omnis aut. Ea culpa rerum veritatis praesentium voluptatem. Dolores distinctio aperiam ea earum iusto. Voluptas pariatur eveniet veniam minus est quod voluptatem placeat.\n\nIncidunt pariatur delectus voluptatem est voluptas consequuntur et occaecati. Eos nulla eligendi ducimus consectetur soluta numquam inventore qui. Voluptas consequatur deserunt possimus optio dicta. Ut et et modi aut.\n\nSed voluptas magnam impedit. Perspiciatis excepturi ipsam ut sed voluptatum repudiandae molestiae et. Fugit dolore maxime aut voluptatem magnam sed.&quot;,
    &quot;price&quot;: &quot;330.00&quot;,
    &quot;sale_price&quot;: null,
    &quot;tax_code&quot;: &quot;FI&quot;,
    &quot;tax_rate&quot;: &quot;0.2550&quot;,
    &quot;quantity&quot;: 78,
    &quot;featured_image&quot;: null,
    &quot;featured_image_sizes&quot;: null,
    &quot;images&quot;: [],
    &quot;images_sizes&quot;: null,
    &quot;visibility&quot;: true,
    &quot;created_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
    &quot;updated_at&quot;: &quot;2026-03-17T14:01:15.000000Z&quot;,
    &quot;featured_image_url&quot;: null,
    &quot;featured_image_sizes_urls&quot;: [],
    &quot;images_urls&quot;: [],
    &quot;images_sizes_urls&quot;: []
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-products--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-products--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-products--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-products--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-products--id-" data-method="GET"
      data-path="api/products/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-products--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-products--id-"
                    onclick="tryItOut('GETapi-products--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-products--id-"
                    onclick="cancelTryOut('GETapi-products--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-products--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/products/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-products--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-products--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-products--id-"
               value="1"
               data-component="url">
    <br>
<p>Product ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="products-PUTapi-products--id-">Update a product.</h2>

<p>
</p>



<span id="example-requests-PUTapi-products--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "https://backend-laravel.dev.jussialanen.com/api/products/1" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "user_id=17"\
    --form "title=Wireless Headphones"\
    --form "description=Premium noise-cancelling headphones"\
    --form "price=299.99"\
    --form "sale_price=249.99"\
    --form "tax_code=CN"\
    --form "tax_rate=1"\
    --form "quantity=50"\
    --form "visibility=1"\
    --form "delete_images[]=consequatur"\
    --form "delete_featured_image="\
    --form "delete_images[]=products/1/image.png"\
    --form "featured_image=@/tmp/phpgEkCfE" \
    --form "images[]=@/tmp/phpmgGjeE" \
    --form "images[]=@/tmp/phpdcLHfE" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/products/1"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('user_id', '17');
body.append('title', 'Wireless Headphones');
body.append('description', 'Premium noise-cancelling headphones');
body.append('price', '299.99');
body.append('sale_price', '249.99');
body.append('tax_code', 'CN');
body.append('tax_rate', '1');
body.append('quantity', '50');
body.append('visibility', '1');
body.append('delete_images[]', 'consequatur');
body.append('delete_featured_image', '');
body.append('delete_images[]', 'products/1/image.png');
body.append('featured_image', document.querySelector('input[name="featured_image"]').files[0]);
body.append('images[]', document.querySelector('input[name="images[]"]').files[0]);
body.append('images[]', document.querySelector('input[name="images[]"]').files[0]);

fetch(url, {
    method: "PUT",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-products--id-">
</span>
<span id="execution-results-PUTapi-products--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-products--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-products--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-products--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-products--id-" data-method="PUT"
      data-path="api/products/{id}"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-products--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-products--id-"
                    onclick="tryItOut('PUTapi-products--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-products--id-"
                    onclick="cancelTryOut('PUTapi-products--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-products--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/products/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-products--id-"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-products--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-products--id-"
               value="1"
               data-component="url">
    <br>
<p>Product ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user_id"                data-endpoint="PUTapi-products--id-"
               value="17"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the users table. Example: <code>17</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="PUTapi-products--id-"
               value="Wireless Headphones"
               data-component="body">
    <br>
<p>Product title. Example: <code>Wireless Headphones</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="PUTapi-products--id-"
               value="Premium noise-cancelling headphones"
               data-component="body">
    <br>
<p>Product description. Example: <code>Premium noise-cancelling headphones</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="price"                data-endpoint="PUTapi-products--id-"
               value="299.99"
               data-component="body">
    <br>
<p>Price. Example: <code>299.99</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>sale_price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="sale_price"                data-endpoint="PUTapi-products--id-"
               value="249.99"
               data-component="body">
    <br>
<p>Sale price. Example: <code>249.99</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>tax_code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="tax_code"                data-endpoint="PUTapi-products--id-"
               value="CN"
               data-component="body">
    <br>
<p>Example: <code>CN</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>ZERO</code></li> <li><code>AT</code></li> <li><code>BE</code></li> <li><code>BG</code></li> <li><code>HR</code></li> <li><code>CY</code></li> <li><code>CZ</code></li> <li><code>DK</code></li> <li><code>EE</code></li> <li><code>FI</code></li> <li><code>FR</code></li> <li><code>DE</code></li> <li><code>GR</code></li> <li><code>HU</code></li> <li><code>IE</code></li> <li><code>IT</code></li> <li><code>LV</code></li> <li><code>LT</code></li> <li><code>LU</code></li> <li><code>MT</code></li> <li><code>NL</code></li> <li><code>PL</code></li> <li><code>PT</code></li> <li><code>RO</code></li> <li><code>SK</code></li> <li><code>SI</code></li> <li><code>ES</code></li> <li><code>SE</code></li> <li><code>UK</code></li> <li><code>NO</code></li> <li><code>CH</code></li> <li><code>AR</code></li> <li><code>BR</code></li> <li><code>CA</code></li> <li><code>MX</code></li> <li><code>AU</code></li> <li><code>CN</code></li> <li><code>ID</code></li> <li><code>IN</code></li> <li><code>JP</code></li> <li><code>KR</code></li> <li><code>NZ</code></li> <li><code>PH</code></li> <li><code>SG</code></li> <li><code>TH</code></li> <li><code>AE</code></li> <li><code>IL</code></li> <li><code>SA</code></li> <li><code>EG</code></li> <li><code>GH</code></li> <li><code>KE</code></li> <li><code>NG</code></li> <li><code>ZA</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>tax_rate</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="tax_rate"                data-endpoint="PUTapi-products--id-"
               value="1"
               data-component="body">
    <br>
<p>tax_rate is a snapshot; if omitted but tax_code is given, resolve from TaxRateController. Must be at least 0. Must not be greater than 1. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="quantity"                data-endpoint="PUTapi-products--id-"
               value="50"
               data-component="body">
    <br>
<p>Quantity in stock. Example: <code>50</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>featured_image</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="featured_image"                data-endpoint="PUTapi-products--id-"
               value=""
               data-component="body">
    <br>
<p>Featured image file. Example: <code>/tmp/phpgEkCfE</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>visibility</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-products--id-" style="display: none">
            <input type="radio" name="visibility"
                   value="true"
                   data-endpoint="PUTapi-products--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-products--id-" style="display: none">
            <input type="radio" name="visibility"
                   value="false"
                   data-endpoint="PUTapi-products--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Visibility flag. Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>delete_images</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="delete_images[0]"                data-endpoint="PUTapi-products--id-"
               data-component="body">
        <input type="text" style="display: none"
               name="delete_images[1]"                data-endpoint="PUTapi-products--id-"
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>delete_featured_image</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-products--id-" style="display: none">
            <input type="radio" name="delete_featured_image"
                   value="true"
                   data-endpoint="PUTapi-products--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-products--id-" style="display: none">
            <input type="radio" name="delete_featured_image"
                   value="false"
                   data-endpoint="PUTapi-products--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Delete featured image. Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>images</code></b>&nbsp;&nbsp;
<small>file[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="images[0]"                data-endpoint="PUTapi-products--id-"
               data-component="body">
        <input type="file" style="display: none"
               name="images[1]"                data-endpoint="PUTapi-products--id-"
               data-component="body">
    <br>
<p>Must be a file. Must be an image. Must not be greater than 5120 kilobytes.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>images[]</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="images.0"                data-endpoint="PUTapi-products--id-"
               value=""
               data-component="body">
    <br>
<p>Additional image files. Example: <code>/tmp/phpdcLHfE</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>delete_images[]</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="delete_images.0"                data-endpoint="PUTapi-products--id-"
               value="products/1/image.png"
               data-component="body">
    <br>
<p>Image paths to delete. Example: <code>products/1/image.png</code></p>
        </div>
        </form>

                    <h2 id="products-DELETEapi-products--id-">Delete a product.</h2>

<p>
</p>



<span id="example-requests-DELETEapi-products--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "https://backend-laravel.dev.jussialanen.com/api/products/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/products/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-products--id-">
</span>
<span id="execution-results-DELETEapi-products--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-products--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-products--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-products--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-products--id-" data-method="DELETE"
      data-path="api/products/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-products--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-products--id-"
                    onclick="tryItOut('DELETEapi-products--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-products--id-"
                    onclick="cancelTryOut('DELETEapi-products--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-products--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/products/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-products--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-products--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-products--id-"
               value="1"
               data-component="url">
    <br>
<p>Product ID. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="resume-sections">Resume Sections</h1>

    

                                <h2 id="resume-sections-GETapi-resumes--resumeId---section-">List all items in a resume section.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-resumes--resumeId---section-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/1/work-experiences" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/1/work-experiences"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes--resumeId---section-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes--resumeId---section-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes--resumeId---section-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes--resumeId---section-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes--resumeId---section-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes--resumeId---section-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes--resumeId---section-" data-method="GET"
      data-path="api/resumes/{resumeId}/{section}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes--resumeId---section-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes--resumeId---section-"
                    onclick="tryItOut('GETapi-resumes--resumeId---section-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes--resumeId---section-"
                    onclick="cancelTryOut('GETapi-resumes--resumeId---section-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes--resumeId---section-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/{resumeId}/{section}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-resumes--resumeId---section-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes--resumeId---section-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes--resumeId---section-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resumeId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resumeId"                data-endpoint="GETapi-resumes--resumeId---section-"
               value="1"
               data-component="url">
    <br>
<p>Resume ID. Example: <code>1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>section</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="section"                data-endpoint="GETapi-resumes--resumeId---section-"
               value="work-experiences"
               data-component="url">
    <br>
<p>Section slug. Example: <code>work-experiences</code></p>
            </div>
                    </form>

                    <h2 id="resume-sections-POSTapi-resumes--resumeId---section-">Add an item to a resume section.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-resumes--resumeId---section-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/resumes/1/work-experiences

Skill proficiency levels (section: skills):
- 1 `beginner`      — Just starting out
- 2 `basic`         — Can handle simple tasks
- 3 `intermediate`  — Works independently on common tasks
- 4 `advanced`      — Handles complex scenarios confidently
- 5 `expert`        — Deep mastery

Spoken-language proficiency levels (section: languages):
- 1 `elementary`             — Basic words and phrases
- 2 `limited_working`        — Can handle routine communication
- 3 `professional_working`   — Effective in most work situations
- 4 `full_professional`      — Precise in demanding contexts
- 5 `native_bilingual`       — Native or bilingual fluency" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/1/work-experiences

Skill proficiency levels (section: skills):
- 1 `beginner`      — Just starting out
- 2 `basic`         — Can handle simple tasks
- 3 `intermediate`  — Works independently on common tasks
- 4 `advanced`      — Handles complex scenarios confidently
- 5 `expert`        — Deep mastery

Spoken-language proficiency levels (section: languages):
- 1 `elementary`             — Basic words and phrases
- 2 `limited_working`        — Can handle routine communication
- 3 `professional_working`   — Effective in most work situations
- 4 `full_professional`      — Precise in demanding contexts
- 5 `native_bilingual`       — Native or bilingual fluency"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-resumes--resumeId---section-">
</span>
<span id="execution-results-POSTapi-resumes--resumeId---section-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-resumes--resumeId---section-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-resumes--resumeId---section-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-resumes--resumeId---section-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-resumes--resumeId---section-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-resumes--resumeId---section-" data-method="POST"
      data-path="api/resumes/{resumeId}/{section}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-resumes--resumeId---section-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-resumes--resumeId---section-"
                    onclick="tryItOut('POSTapi-resumes--resumeId---section-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-resumes--resumeId---section-"
                    onclick="cancelTryOut('POSTapi-resumes--resumeId---section-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-resumes--resumeId---section-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/resumes/{resumeId}/{section}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-resumes--resumeId---section-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-resumes--resumeId---section-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-resumes--resumeId---section-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resumeId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resumeId"                data-endpoint="POSTapi-resumes--resumeId---section-"
               value="1"
               data-component="url">
    <br>
<p>Resume ID. Example: <code>1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>section</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="section"                data-endpoint="POSTapi-resumes--resumeId---section-"
               value="work-experiences

Skill proficiency levels (section: skills):
- 1 `beginner`      — Just starting out
- 2 `basic`         — Can handle simple tasks
- 3 `intermediate`  — Works independently on common tasks
- 4 `advanced`      — Handles complex scenarios confidently
- 5 `expert`        — Deep mastery

Spoken-language proficiency levels (section: languages):
- 1 `elementary`             — Basic words and phrases
- 2 `limited_working`        — Can handle routine communication
- 3 `professional_working`   — Effective in most work situations
- 4 `full_professional`      — Precise in demanding contexts
- 5 `native_bilingual`       — Native or bilingual fluency"
               data-component="url">
    <br>
<p>Section slug. Example: `work-experiences</p>
<p>Skill proficiency levels (section: skills):</p>
<ul>
<li>1 <code>beginner</code>      — Just starting out</li>
<li>2 <code>basic</code>         — Can handle simple tasks</li>
<li>3 <code>intermediate</code>  — Works independently on common tasks</li>
<li>4 <code>advanced</code>      — Handles complex scenarios confidently</li>
<li>5 <code>expert</code>        — Deep mastery</li>
</ul>
<p>Spoken-language proficiency levels (section: languages):</p>
<ul>
<li>1 <code>elementary</code>             — Basic words and phrases</li>
<li>2 <code>limited_working</code>        — Can handle routine communication</li>
<li>3 <code>professional_working</code>   — Effective in most work situations</li>
<li>4 <code>full_professional</code>      — Precise in demanding contexts</li>
<li>5 <code>native_bilingual</code>       — Native or bilingual fluency`</li>
</ul>
            </div>
                    </form>

                    <h2 id="resume-sections-PUTapi-resumes--resumeId---section---itemId-">Update an item in a resume section.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-PUTapi-resumes--resumeId---section---itemId-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "https://backend-laravel.dev.jussialanen.com/api/resumes/1/work-experiences/3" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/1/work-experiences/3"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "PUT",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-resumes--resumeId---section---itemId-">
</span>
<span id="execution-results-PUTapi-resumes--resumeId---section---itemId-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-resumes--resumeId---section---itemId-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-resumes--resumeId---section---itemId-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-resumes--resumeId---section---itemId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-resumes--resumeId---section---itemId-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-resumes--resumeId---section---itemId-" data-method="PUT"
      data-path="api/resumes/{resumeId}/{section}/{itemId}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-resumes--resumeId---section---itemId-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-resumes--resumeId---section---itemId-"
                    onclick="tryItOut('PUTapi-resumes--resumeId---section---itemId-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-resumes--resumeId---section---itemId-"
                    onclick="cancelTryOut('PUTapi-resumes--resumeId---section---itemId-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-resumes--resumeId---section---itemId-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/resumes/{resumeId}/{section}/{itemId}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-resumes--resumeId---section---itemId-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-resumes--resumeId---section---itemId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-resumes--resumeId---section---itemId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resumeId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resumeId"                data-endpoint="PUTapi-resumes--resumeId---section---itemId-"
               value="1"
               data-component="url">
    <br>
<p>Resume ID. Example: <code>1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>section</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="section"                data-endpoint="PUTapi-resumes--resumeId---section---itemId-"
               value="work-experiences"
               data-component="url">
    <br>
<p>Section slug. Example: <code>work-experiences</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>itemId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="itemId"                data-endpoint="PUTapi-resumes--resumeId---section---itemId-"
               value="3"
               data-component="url">
    <br>
<p>Item ID. Example: <code>3</code></p>
            </div>
                    </form>

                    <h2 id="resume-sections-DELETEapi-resumes--resumeId---section---itemId-">Delete an item from a resume section.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-resumes--resumeId---section---itemId-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "https://backend-laravel.dev.jussialanen.com/api/resumes/1/work-experiences/3" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/1/work-experiences/3"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-resumes--resumeId---section---itemId-">
</span>
<span id="execution-results-DELETEapi-resumes--resumeId---section---itemId-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-resumes--resumeId---section---itemId-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-resumes--resumeId---section---itemId-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-resumes--resumeId---section---itemId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-resumes--resumeId---section---itemId-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-resumes--resumeId---section---itemId-" data-method="DELETE"
      data-path="api/resumes/{resumeId}/{section}/{itemId}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-resumes--resumeId---section---itemId-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-resumes--resumeId---section---itemId-"
                    onclick="tryItOut('DELETEapi-resumes--resumeId---section---itemId-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-resumes--resumeId---section---itemId-"
                    onclick="cancelTryOut('DELETEapi-resumes--resumeId---section---itemId-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-resumes--resumeId---section---itemId-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/resumes/{resumeId}/{section}/{itemId}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-resumes--resumeId---section---itemId-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-resumes--resumeId---section---itemId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-resumes--resumeId---section---itemId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resumeId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resumeId"                data-endpoint="DELETEapi-resumes--resumeId---section---itemId-"
               value="1"
               data-component="url">
    <br>
<p>Resume ID. Example: <code>1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>section</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="section"                data-endpoint="DELETEapi-resumes--resumeId---section---itemId-"
               value="work-experiences"
               data-component="url">
    <br>
<p>Section slug. Example: <code>work-experiences</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>itemId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="itemId"                data-endpoint="DELETEapi-resumes--resumeId---section---itemId-"
               value="3"
               data-component="url">
    <br>
<p>Item ID. Example: <code>3</code></p>
            </div>
                    </form>

                <h1 id="resumes">Resumes</h1>

    

                                <h2 id="resumes-GETapi-resumes-export-options">Return available themes, templates, and languages for PDF/HTML export.</h2>

<p>
</p>

<p>Pass <code>?lang=fi</code> to receive translated labels (default: <code>en</code>).</p>

<span id="example-requests-GETapi-resumes-export-options">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/export/options" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/export/options"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes-export-options">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 40
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;themes&quot;: [
        {
            &quot;value&quot;: &quot;green&quot;,
            &quot;label&quot;: &quot;Green&quot;
        },
        {
            &quot;value&quot;: &quot;blue&quot;,
            &quot;label&quot;: &quot;Blue&quot;
        },
        {
            &quot;value&quot;: &quot;red&quot;,
            &quot;label&quot;: &quot;Red&quot;
        },
        {
            &quot;value&quot;: &quot;yellow&quot;,
            &quot;label&quot;: &quot;Yellow&quot;
        },
        {
            &quot;value&quot;: &quot;cyan&quot;,
            &quot;label&quot;: &quot;Cyan&quot;
        },
        {
            &quot;value&quot;: &quot;orange&quot;,
            &quot;label&quot;: &quot;Orange&quot;
        },
        {
            &quot;value&quot;: &quot;violet&quot;,
            &quot;label&quot;: &quot;Violet&quot;
        },
        {
            &quot;value&quot;: &quot;black&quot;,
            &quot;label&quot;: &quot;Black&quot;
        },
        {
            &quot;value&quot;: &quot;white&quot;,
            &quot;label&quot;: &quot;White&quot;
        },
        {
            &quot;value&quot;: &quot;grey&quot;,
            &quot;label&quot;: &quot;Grey&quot;
        },
        {
            &quot;value&quot;: &quot;midnight&quot;,
            &quot;label&quot;: &quot;Midnight&quot;
        },
        {
            &quot;value&quot;: &quot;gold&quot;,
            &quot;label&quot;: &quot;Gold&quot;
        },
        {
            &quot;value&quot;: &quot;aurora&quot;,
            &quot;label&quot;: &quot;Aurora&quot;
        },
        {
            &quot;value&quot;: &quot;ember&quot;,
            &quot;label&quot;: &quot;Ember&quot;
        },
        {
            &quot;value&quot;: &quot;amethyst&quot;,
            &quot;label&quot;: &quot;Amethyst&quot;
        }
    ],
    &quot;templates&quot;: [
        {
            &quot;value&quot;: &quot;default&quot;,
            &quot;label&quot;: &quot;Classic&quot;
        },
        {
            &quot;value&quot;: &quot;dark&quot;,
            &quot;label&quot;: &quot;Dark&quot;
        }
    ],
    &quot;template_themes&quot;: {
        &quot;default&quot;: [
            {
                &quot;value&quot;: &quot;green&quot;,
                &quot;accent&quot;: &quot;#14532d&quot;,
                &quot;bg&quot;: &quot;#ffffff&quot;
            },
            {
                &quot;value&quot;: &quot;blue&quot;,
                &quot;accent&quot;: &quot;#1e3a5f&quot;,
                &quot;bg&quot;: &quot;#ffffff&quot;
            },
            {
                &quot;value&quot;: &quot;red&quot;,
                &quot;accent&quot;: &quot;#7f1d1d&quot;,
                &quot;bg&quot;: &quot;#ffffff&quot;
            },
            {
                &quot;value&quot;: &quot;yellow&quot;,
                &quot;accent&quot;: &quot;#78350f&quot;,
                &quot;bg&quot;: &quot;#ffffff&quot;
            },
            {
                &quot;value&quot;: &quot;cyan&quot;,
                &quot;accent&quot;: &quot;#164e63&quot;,
                &quot;bg&quot;: &quot;#ffffff&quot;
            },
            {
                &quot;value&quot;: &quot;orange&quot;,
                &quot;accent&quot;: &quot;#7c2d12&quot;,
                &quot;bg&quot;: &quot;#ffffff&quot;
            },
            {
                &quot;value&quot;: &quot;violet&quot;,
                &quot;accent&quot;: &quot;#4c1d95&quot;,
                &quot;bg&quot;: &quot;#ffffff&quot;
            },
            {
                &quot;value&quot;: &quot;black&quot;,
                &quot;accent&quot;: &quot;#111827&quot;,
                &quot;bg&quot;: &quot;#ffffff&quot;
            },
            {
                &quot;value&quot;: &quot;white&quot;,
                &quot;accent&quot;: &quot;#0f172a&quot;,
                &quot;bg&quot;: &quot;#f1f5f9&quot;
            },
            {
                &quot;value&quot;: &quot;grey&quot;,
                &quot;accent&quot;: &quot;#374151&quot;,
                &quot;bg&quot;: &quot;#ffffff&quot;
            }
        ],
        &quot;dark&quot;: [
            {
                &quot;value&quot;: &quot;midnight&quot;,
                &quot;accent&quot;: &quot;#58a6ff&quot;,
                &quot;bg&quot;: &quot;#0d1117&quot;
            },
            {
                &quot;value&quot;: &quot;gold&quot;,
                &quot;accent&quot;: &quot;#d4a843&quot;,
                &quot;bg&quot;: &quot;#0f0d08&quot;
            },
            {
                &quot;value&quot;: &quot;aurora&quot;,
                &quot;accent&quot;: &quot;#2dd4bf&quot;,
                &quot;bg&quot;: &quot;#091518&quot;
            },
            {
                &quot;value&quot;: &quot;ember&quot;,
                &quot;accent&quot;: &quot;#fb923c&quot;,
                &quot;bg&quot;: &quot;#100a07&quot;
            },
            {
                &quot;value&quot;: &quot;amethyst&quot;,
                &quot;accent&quot;: &quot;#a78bfa&quot;,
                &quot;bg&quot;: &quot;#0d0b14&quot;
            }
        ]
    },
    &quot;languages&quot;: [
        {
            &quot;value&quot;: &quot;en&quot;,
            &quot;label&quot;: &quot;English&quot;
        },
        {
            &quot;value&quot;: &quot;fi&quot;,
            &quot;label&quot;: &quot;Finnish&quot;
        }
    ],
    &quot;skill_categories&quot;: [
        {
            &quot;value&quot;: &quot;programming_languages&quot;,
            &quot;label&quot;: &quot;Programming Languages&quot;
        },
        {
            &quot;value&quot;: &quot;scripting_languages&quot;,
            &quot;label&quot;: &quot;Scripting Languages&quot;
        },
        {
            &quot;value&quot;: &quot;markup_languages&quot;,
            &quot;label&quot;: &quot;Markup Languages&quot;
        },
        {
            &quot;value&quot;: &quot;query_languages&quot;,
            &quot;label&quot;: &quot;Query Languages&quot;
        },
        {
            &quot;value&quot;: &quot;frontend_technologies&quot;,
            &quot;label&quot;: &quot;Frontend Technologies&quot;
        },
        {
            &quot;value&quot;: &quot;backend_technologies&quot;,
            &quot;label&quot;: &quot;Backend Technologies&quot;
        },
        {
            &quot;value&quot;: &quot;full_stack_development&quot;,
            &quot;label&quot;: &quot;Full Stack Development&quot;
        },
        {
            &quot;value&quot;: &quot;frameworks&quot;,
            &quot;label&quot;: &quot;Frameworks&quot;
        },
        {
            &quot;value&quot;: &quot;libraries&quot;,
            &quot;label&quot;: &quot;Libraries&quot;
        },
        {
            &quot;value&quot;: &quot;ui_ux_design&quot;,
            &quot;label&quot;: &quot;UI/UX Design&quot;
        },
        {
            &quot;value&quot;: &quot;responsive_design&quot;,
            &quot;label&quot;: &quot;Responsive Design&quot;
        },
        {
            &quot;value&quot;: &quot;mobile_development&quot;,
            &quot;label&quot;: &quot;Mobile Development&quot;
        },
        {
            &quot;value&quot;: &quot;desktop_development&quot;,
            &quot;label&quot;: &quot;Desktop Development&quot;
        },
        {
            &quot;value&quot;: &quot;game_development&quot;,
            &quot;label&quot;: &quot;Game Development&quot;
        },
        {
            &quot;value&quot;: &quot;embedded_systems&quot;,
            &quot;label&quot;: &quot;Embedded Systems&quot;
        },
        {
            &quot;value&quot;: &quot;databases&quot;,
            &quot;label&quot;: &quot;Databases&quot;
        },
        {
            &quot;value&quot;: &quot;database_design&quot;,
            &quot;label&quot;: &quot;Database Design&quot;
        },
        {
            &quot;value&quot;: &quot;database_administration&quot;,
            &quot;label&quot;: &quot;Database Administration&quot;
        },
        {
            &quot;value&quot;: &quot;orm_data_access&quot;,
            &quot;label&quot;: &quot;ORM &amp; Data Access&quot;
        },
        {
            &quot;value&quot;: &quot;api_development&quot;,
            &quot;label&quot;: &quot;API Development&quot;
        },
        {
            &quot;value&quot;: &quot;web_services&quot;,
            &quot;label&quot;: &quot;Web Services&quot;
        },
        {
            &quot;value&quot;: &quot;graphql&quot;,
            &quot;label&quot;: &quot;GraphQL&quot;
        },
        {
            &quot;value&quot;: &quot;microservices&quot;,
            &quot;label&quot;: &quot;Microservices&quot;
        },
        {
            &quot;value&quot;: &quot;event_driven_architecture&quot;,
            &quot;label&quot;: &quot;Event-Driven Architecture&quot;
        },
        {
            &quot;value&quot;: &quot;devops&quot;,
            &quot;label&quot;: &quot;DevOps&quot;
        },
        {
            &quot;value&quot;: &quot;cloud_platforms&quot;,
            &quot;label&quot;: &quot;Cloud Platforms&quot;
        },
        {
            &quot;value&quot;: &quot;serverless&quot;,
            &quot;label&quot;: &quot;Serverless&quot;
        },
        {
            &quot;value&quot;: &quot;containerization&quot;,
            &quot;label&quot;: &quot;Containerization&quot;
        },
        {
            &quot;value&quot;: &quot;ci_cd&quot;,
            &quot;label&quot;: &quot;CI/CD&quot;
        },
        {
            &quot;value&quot;: &quot;infrastructure_as_code&quot;,
            &quot;label&quot;: &quot;Infrastructure as Code&quot;
        },
        {
            &quot;value&quot;: &quot;configuration_management&quot;,
            &quot;label&quot;: &quot;Configuration Management&quot;
        },
        {
            &quot;value&quot;: &quot;version_control&quot;,
            &quot;label&quot;: &quot;Version Control&quot;
        },
        {
            &quot;value&quot;: &quot;testing_qa&quot;,
            &quot;label&quot;: &quot;Testing &amp; QA&quot;
        },
        {
            &quot;value&quot;: &quot;test_automation&quot;,
            &quot;label&quot;: &quot;Test Automation&quot;
        },
        {
            &quot;value&quot;: &quot;security&quot;,
            &quot;label&quot;: &quot;Security&quot;
        },
        {
            &quot;value&quot;: &quot;authentication_authorization&quot;,
            &quot;label&quot;: &quot;Authentication &amp; Authorization&quot;
        },
        {
            &quot;value&quot;: &quot;networking&quot;,
            &quot;label&quot;: &quot;Networking&quot;
        },
        {
            &quot;value&quot;: &quot;performance_optimization&quot;,
            &quot;label&quot;: &quot;Performance Optimization&quot;
        },
        {
            &quot;value&quot;: &quot;architecture_design_patterns&quot;,
            &quot;label&quot;: &quot;Architecture &amp; Design Patterns&quot;
        },
        {
            &quot;value&quot;: &quot;system_design&quot;,
            &quot;label&quot;: &quot;System Design&quot;
        },
        {
            &quot;value&quot;: &quot;distributed_systems&quot;,
            &quot;label&quot;: &quot;Distributed Systems&quot;
        },
        {
            &quot;value&quot;: &quot;data_engineering&quot;,
            &quot;label&quot;: &quot;Data Engineering&quot;
        },
        {
            &quot;value&quot;: &quot;big_data&quot;,
            &quot;label&quot;: &quot;Big Data&quot;
        },
        {
            &quot;value&quot;: &quot;machine_learning_ai&quot;,
            &quot;label&quot;: &quot;Machine Learning &amp; AI&quot;
        },
        {
            &quot;value&quot;: &quot;monitoring_logging&quot;,
            &quot;label&quot;: &quot;Monitoring &amp; Logging&quot;
        },
        {
            &quot;value&quot;: &quot;development_tools&quot;,
            &quot;label&quot;: &quot;Development Tools&quot;
        },
        {
            &quot;value&quot;: &quot;operating_systems&quot;,
            &quot;label&quot;: &quot;Operating Systems&quot;
        },
        {
            &quot;value&quot;: &quot;project_management&quot;,
            &quot;label&quot;: &quot;Project Management&quot;
        },
        {
            &quot;value&quot;: &quot;agile_methodologies&quot;,
            &quot;label&quot;: &quot;Agile &amp; Methodologies&quot;
        },
        {
            &quot;value&quot;: &quot;soft_skills&quot;,
            &quot;label&quot;: &quot;Soft Skills&quot;
        },
        {
            &quot;value&quot;: &quot;other&quot;,
            &quot;label&quot;: &quot;Other&quot;
        }
    ],
    &quot;skill_proficiencies&quot;: [
        {
            &quot;value&quot;: &quot;beginner&quot;,
            &quot;label&quot;: &quot;Beginner&quot;
        },
        {
            &quot;value&quot;: &quot;basic&quot;,
            &quot;label&quot;: &quot;Basic&quot;
        },
        {
            &quot;value&quot;: &quot;intermediate&quot;,
            &quot;label&quot;: &quot;Intermediate&quot;
        },
        {
            &quot;value&quot;: &quot;advanced&quot;,
            &quot;label&quot;: &quot;Advanced&quot;
        },
        {
            &quot;value&quot;: &quot;expert&quot;,
            &quot;label&quot;: &quot;Expert&quot;
        }
    ],
    &quot;language_proficiencies&quot;: [
        {
            &quot;value&quot;: &quot;native_bilingual&quot;,
            &quot;label&quot;: &quot;Native or Bilingual Proficiency&quot;
        },
        {
            &quot;value&quot;: &quot;full_professional&quot;,
            &quot;label&quot;: &quot;Full Professional Proficiency&quot;
        },
        {
            &quot;value&quot;: &quot;professional_working&quot;,
            &quot;label&quot;: &quot;Professional Working Proficiency&quot;
        },
        {
            &quot;value&quot;: &quot;limited_working&quot;,
            &quot;label&quot;: &quot;Limited Working Proficiency&quot;
        },
        {
            &quot;value&quot;: &quot;elementary&quot;,
            &quot;label&quot;: &quot;Elementary Proficiency&quot;
        }
    ],
    &quot;spoken_languages&quot;: [
        {
            &quot;value&quot;: &quot;af&quot;,
            &quot;label&quot;: &quot;Afrikaans&quot;
        },
        {
            &quot;value&quot;: &quot;sq&quot;,
            &quot;label&quot;: &quot;Albanian&quot;
        },
        {
            &quot;value&quot;: &quot;ar&quot;,
            &quot;label&quot;: &quot;Arabic&quot;
        },
        {
            &quot;value&quot;: &quot;hy&quot;,
            &quot;label&quot;: &quot;Armenian&quot;
        },
        {
            &quot;value&quot;: &quot;az&quot;,
            &quot;label&quot;: &quot;Azerbaijani&quot;
        },
        {
            &quot;value&quot;: &quot;be&quot;,
            &quot;label&quot;: &quot;Belarusian&quot;
        },
        {
            &quot;value&quot;: &quot;bn&quot;,
            &quot;label&quot;: &quot;Bengali&quot;
        },
        {
            &quot;value&quot;: &quot;bs&quot;,
            &quot;label&quot;: &quot;Bosnian&quot;
        },
        {
            &quot;value&quot;: &quot;bg&quot;,
            &quot;label&quot;: &quot;Bulgarian&quot;
        },
        {
            &quot;value&quot;: &quot;ca&quot;,
            &quot;label&quot;: &quot;Catalan&quot;
        },
        {
            &quot;value&quot;: &quot;zh&quot;,
            &quot;label&quot;: &quot;Chinese&quot;
        },
        {
            &quot;value&quot;: &quot;hr&quot;,
            &quot;label&quot;: &quot;Croatian&quot;
        },
        {
            &quot;value&quot;: &quot;cs&quot;,
            &quot;label&quot;: &quot;Czech&quot;
        },
        {
            &quot;value&quot;: &quot;da&quot;,
            &quot;label&quot;: &quot;Danish&quot;
        },
        {
            &quot;value&quot;: &quot;nl&quot;,
            &quot;label&quot;: &quot;Dutch&quot;
        },
        {
            &quot;value&quot;: &quot;en&quot;,
            &quot;label&quot;: &quot;English&quot;
        },
        {
            &quot;value&quot;: &quot;et&quot;,
            &quot;label&quot;: &quot;Estonian&quot;
        },
        {
            &quot;value&quot;: &quot;fi&quot;,
            &quot;label&quot;: &quot;Finnish&quot;
        },
        {
            &quot;value&quot;: &quot;fr&quot;,
            &quot;label&quot;: &quot;French&quot;
        },
        {
            &quot;value&quot;: &quot;ka&quot;,
            &quot;label&quot;: &quot;Georgian&quot;
        },
        {
            &quot;value&quot;: &quot;de&quot;,
            &quot;label&quot;: &quot;German&quot;
        },
        {
            &quot;value&quot;: &quot;el&quot;,
            &quot;label&quot;: &quot;Greek&quot;
        },
        {
            &quot;value&quot;: &quot;he&quot;,
            &quot;label&quot;: &quot;Hebrew&quot;
        },
        {
            &quot;value&quot;: &quot;hi&quot;,
            &quot;label&quot;: &quot;Hindi&quot;
        },
        {
            &quot;value&quot;: &quot;hu&quot;,
            &quot;label&quot;: &quot;Hungarian&quot;
        },
        {
            &quot;value&quot;: &quot;is&quot;,
            &quot;label&quot;: &quot;Icelandic&quot;
        },
        {
            &quot;value&quot;: &quot;id&quot;,
            &quot;label&quot;: &quot;Indonesian&quot;
        },
        {
            &quot;value&quot;: &quot;it&quot;,
            &quot;label&quot;: &quot;Italian&quot;
        },
        {
            &quot;value&quot;: &quot;ja&quot;,
            &quot;label&quot;: &quot;Japanese&quot;
        },
        {
            &quot;value&quot;: &quot;kk&quot;,
            &quot;label&quot;: &quot;Kazakh&quot;
        },
        {
            &quot;value&quot;: &quot;ko&quot;,
            &quot;label&quot;: &quot;Korean&quot;
        },
        {
            &quot;value&quot;: &quot;lv&quot;,
            &quot;label&quot;: &quot;Latvian&quot;
        },
        {
            &quot;value&quot;: &quot;lt&quot;,
            &quot;label&quot;: &quot;Lithuanian&quot;
        },
        {
            &quot;value&quot;: &quot;mk&quot;,
            &quot;label&quot;: &quot;Macedonian&quot;
        },
        {
            &quot;value&quot;: &quot;ms&quot;,
            &quot;label&quot;: &quot;Malay&quot;
        },
        {
            &quot;value&quot;: &quot;mt&quot;,
            &quot;label&quot;: &quot;Maltese&quot;
        },
        {
            &quot;value&quot;: &quot;no&quot;,
            &quot;label&quot;: &quot;Norwegian&quot;
        },
        {
            &quot;value&quot;: &quot;fa&quot;,
            &quot;label&quot;: &quot;Persian&quot;
        },
        {
            &quot;value&quot;: &quot;pl&quot;,
            &quot;label&quot;: &quot;Polish&quot;
        },
        {
            &quot;value&quot;: &quot;pt&quot;,
            &quot;label&quot;: &quot;Portuguese&quot;
        },
        {
            &quot;value&quot;: &quot;ro&quot;,
            &quot;label&quot;: &quot;Romanian&quot;
        },
        {
            &quot;value&quot;: &quot;ru&quot;,
            &quot;label&quot;: &quot;Russian&quot;
        },
        {
            &quot;value&quot;: &quot;sr&quot;,
            &quot;label&quot;: &quot;Serbian&quot;
        },
        {
            &quot;value&quot;: &quot;sk&quot;,
            &quot;label&quot;: &quot;Slovak&quot;
        },
        {
            &quot;value&quot;: &quot;sl&quot;,
            &quot;label&quot;: &quot;Slovenian&quot;
        },
        {
            &quot;value&quot;: &quot;es&quot;,
            &quot;label&quot;: &quot;Spanish&quot;
        },
        {
            &quot;value&quot;: &quot;sv&quot;,
            &quot;label&quot;: &quot;Swedish&quot;
        },
        {
            &quot;value&quot;: &quot;th&quot;,
            &quot;label&quot;: &quot;Thai&quot;
        },
        {
            &quot;value&quot;: &quot;tr&quot;,
            &quot;label&quot;: &quot;Turkish&quot;
        },
        {
            &quot;value&quot;: &quot;uk&quot;,
            &quot;label&quot;: &quot;Ukrainian&quot;
        },
        {
            &quot;value&quot;: &quot;ur&quot;,
            &quot;label&quot;: &quot;Urdu&quot;
        },
        {
            &quot;value&quot;: &quot;vi&quot;,
            &quot;label&quot;: &quot;Vietnamese&quot;
        },
        {
            &quot;value&quot;: &quot;cy&quot;,
            &quot;label&quot;: &quot;Welsh&quot;
        },
        {
            &quot;value&quot;: &quot;other&quot;,
            &quot;label&quot;: &quot;Other&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes-export-options" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes-export-options"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes-export-options"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes-export-options" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes-export-options">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes-export-options" data-method="GET"
      data-path="api/resumes/export/options"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes-export-options', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes-export-options"
                    onclick="tryItOut('GETapi-resumes-export-options');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes-export-options"
                    onclick="cancelTryOut('GETapi-resumes-export-options');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes-export-options"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/export/options</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes-export-options"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes-export-options"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="resumes-POSTapi-resumes-export-pdf">Export a resume as a PDF from a JSON payload (no stored resume required).</h2>

<p>
</p>

<p>The photo can be supplied as a base64-encoded string in <code>photo</code>.
The result is identical to the authenticated export but nothing is written to the database.</p>

<span id="example-requests-POSTapi-resumes-export-pdf">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/resumes/export/pdf" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/export/pdf"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-resumes-export-pdf">
</span>
<span id="execution-results-POSTapi-resumes-export-pdf" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-resumes-export-pdf"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-resumes-export-pdf"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-resumes-export-pdf" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-resumes-export-pdf">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-resumes-export-pdf" data-method="POST"
      data-path="api/resumes/export/pdf"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-resumes-export-pdf', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-resumes-export-pdf"
                    onclick="tryItOut('POSTapi-resumes-export-pdf');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-resumes-export-pdf"
                    onclick="cancelTryOut('POSTapi-resumes-export-pdf');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-resumes-export-pdf"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/resumes/export/pdf</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-resumes-export-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-resumes-export-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="resumes-POSTapi-resumes-export-html">Export a resume as an HTML file from a JSON payload (no stored resume required).</h2>

<p>
</p>

<p>The photo can be supplied as a base64-encoded string in <code>photo</code>.</p>

<span id="example-requests-POSTapi-resumes-export-html">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/resumes/export/html" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/export/html"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-resumes-export-html">
</span>
<span id="execution-results-POSTapi-resumes-export-html" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-resumes-export-html"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-resumes-export-html"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-resumes-export-html" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-resumes-export-html">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-resumes-export-html" data-method="POST"
      data-path="api/resumes/export/html"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-resumes-export-html', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-resumes-export-html"
                    onclick="tryItOut('POSTapi-resumes-export-html');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-resumes-export-html"
                    onclick="cancelTryOut('POSTapi-resumes-export-html');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-resumes-export-html"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/resumes/export/html</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-resumes-export-html"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-resumes-export-html"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="resumes-POSTapi-resumes-preview-pdf">Preview a resume as an inline PDF from a JSON payload (no stored resume required).</h2>

<p>
</p>

<p>The photo can be supplied as a base64-encoded string in <code>photo</code>.
Returns the PDF inline (for iframe / browser preview), not as a download.</p>

<span id="example-requests-POSTapi-resumes-preview-pdf">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/resumes/preview/pdf" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/preview/pdf"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-resumes-preview-pdf">
</span>
<span id="execution-results-POSTapi-resumes-preview-pdf" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-resumes-preview-pdf"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-resumes-preview-pdf"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-resumes-preview-pdf" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-resumes-preview-pdf">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-resumes-preview-pdf" data-method="POST"
      data-path="api/resumes/preview/pdf"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-resumes-preview-pdf', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-resumes-preview-pdf"
                    onclick="tryItOut('POSTapi-resumes-preview-pdf');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-resumes-preview-pdf"
                    onclick="cancelTryOut('POSTapi-resumes-preview-pdf');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-resumes-preview-pdf"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/resumes/preview/pdf</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-resumes-preview-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-resumes-preview-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="resumes-POSTapi-resumes-preview-html">Preview a resume as inline HTML from a JSON payload (no stored resume required).</h2>

<p>
</p>

<p>The photo can be supplied as a base64-encoded string in <code>photo</code>.
Returns HTML inline (for iframe / browser preview), not as a download.</p>

<span id="example-requests-POSTapi-resumes-preview-html">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/resumes/preview/html" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/preview/html"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-resumes-preview-html">
</span>
<span id="execution-results-POSTapi-resumes-preview-html" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-resumes-preview-html"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-resumes-preview-html"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-resumes-preview-html" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-resumes-preview-html">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-resumes-preview-html" data-method="POST"
      data-path="api/resumes/preview/html"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-resumes-preview-html', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-resumes-preview-html"
                    onclick="tryItOut('POSTapi-resumes-preview-html');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-resumes-preview-html"
                    onclick="cancelTryOut('POSTapi-resumes-preview-html');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-resumes-preview-html"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/resumes/preview/html</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-resumes-preview-html"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-resumes-preview-html"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="resumes-GETapi-resumes-current">Get the primary resume.</h2>

<p>
</p>

<p>Accessible either with a valid Sanctum token (returns the authenticated
user's primary resume) or without a token by supplying <code>owner</code> (username)
query parameter; if the resume has a code set, <code>code</code> must also match.</p>

<span id="example-requests-GETapi-resumes-current">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/current?owner=johndoe&amp;code=mycode" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/current"
);

const params = {
    "owner": "johndoe",
    "code": "mycode",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes-current">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 39
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Resume not found.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes-current" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes-current"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes-current"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes-current" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes-current">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes-current" data-method="GET"
      data-path="api/resumes/current"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes-current', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes-current"
                    onclick="tryItOut('GETapi-resumes-current');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes-current"
                    onclick="cancelTryOut('GETapi-resumes-current');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes-current"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/current</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes-current"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes-current"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>owner</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="owner"                data-endpoint="GETapi-resumes-current"
               value="johndoe"
               data-component="query">
    <br>
<p>Username of the resume owner (required for public access). Example: <code>johndoe</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-resumes-current"
               value="mycode"
               data-component="query">
    <br>
<p>Resume access code (required when the resume has one). Example: <code>mycode</code></p>
            </div>
                </form>

                    <h2 id="resumes-GETapi-resumes-current-main">Get the main (primary) resume for public display.</h2>

<p>
</p>

<p>The resume must be set to public (<code>is_public = true</code>).
Supports two lookup modes:</p>
<ul>
<li>By resume ID (<code>?id=&lt;n&gt;</code>)</li>
<li>By owner username (<code>?owner=&lt;username&gt;</code>)</li>
</ul>
<p>If the resume has a code set, the <code>code</code> query parameter must match.</p>

<span id="example-requests-GETapi-resumes-current-main">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/current/main?id=1&amp;owner=johndoe&amp;code=mycode" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/current/main"
);

const params = {
    "id": "1",
    "owner": "johndoe",
    "code": "mycode",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes-current-main">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 38
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Resume not found.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes-current-main" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes-current-main"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes-current-main"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes-current-main" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes-current-main">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes-current-main" data-method="GET"
      data-path="api/resumes/current/main"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes-current-main', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes-current-main"
                    onclick="tryItOut('GETapi-resumes-current-main');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes-current-main"
                    onclick="cancelTryOut('GETapi-resumes-current-main');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes-current-main"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/current/main</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes-current-main"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes-current-main"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-resumes-current-main"
               value="1"
               data-component="query">
    <br>
<p>Resume ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>owner</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="owner"                data-endpoint="GETapi-resumes-current-main"
               value="johndoe"
               data-component="query">
    <br>
<p>Username of the resume owner. Example: <code>johndoe</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-resumes-current-main"
               value="mycode"
               data-component="query">
    <br>
<p>Access code (required when the resume has one). Example: <code>mycode</code></p>
            </div>
                </form>

                    <h2 id="resumes-GETapi-resumes--id--public">Display a specific public resume (no token required).</h2>

<p>
</p>

<p>The resume must be set to public (<code>is_public = true</code>).
If the resume has a code set, the <code>code</code> query parameter must match.</p>

<span id="example-requests-GETapi-resumes--id--public">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/1/public?code=mycode" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/1/public"
);

const params = {
    "code": "mycode",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes--id--public">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 37
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Resume not found.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes--id--public" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes--id--public"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes--id--public"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes--id--public" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes--id--public">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes--id--public" data-method="GET"
      data-path="api/resumes/{id}/public"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes--id--public', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes--id--public"
                    onclick="tryItOut('GETapi-resumes--id--public');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes--id--public"
                    onclick="cancelTryOut('GETapi-resumes--id--public');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes--id--public"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/{id}/public</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes--id--public"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes--id--public"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-resumes--id--public"
               value="1"
               data-component="url">
    <br>
<p>The resume ID. Example: <code>1</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-resumes--id--public"
               value="mycode"
               data-component="query">
    <br>
<p>Access code (required when the resume has one). Example: <code>mycode</code></p>
            </div>
                </form>

                    <h2 id="resumes-GETapi-resumes">Display all resumes for the authenticated user.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-resumes">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes?per_page=10&amp;sort_by=updated_at&amp;sort_dir=desc" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes"
);

const params = {
    "per_page": "10",
    "sort_by": "updated_at",
    "sort_dir": "desc",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes" data-method="GET"
      data-path="api/resumes"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes"
                    onclick="tryItOut('GETapi-resumes');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes"
                    onclick="cancelTryOut('GETapi-resumes');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-resumes"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-resumes"
               value="10"
               data-component="query">
    <br>
<p>Number of results per page (1-100). Defaults to 10. Example: <code>10</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-resumes"
               value="updated_at"
               data-component="query">
    <br>
<p>Field to sort by (id, title, created_at, updated_at). Defaults to updated_at. Example: <code>updated_at</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_dir</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="sort_dir"                data-endpoint="GETapi-resumes"
               value="desc"
               data-component="query">
    <br>
<p>Sort direction (asc, desc). Defaults to desc. Example: <code>desc</code></p>
            </div>
                </form>

                    <h2 id="resumes-POSTapi-resumes">Create a new resume with all sections in one request.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-resumes">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/resumes" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"title\": \"\\\"Software Engineer CV\\\"\",
    \"full_name\": \"Jussi Palanen\",
    \"email\": \"jussi@example.com\",
    \"phone\": \"+358401234567\",
    \"location\": \"Helsinki, Finland\",
    \"linkedin_url\": \"http:\\/\\/kunze.biz\\/iste-laborum-eius-est-dolor.html\",
    \"portfolio_url\": \"http:\\/\\/kunze.biz\\/iste-laborum-eius-est-dolor.html\",
    \"github_url\": \"http:\\/\\/kunze.biz\\/iste-laborum-eius-est-dolor.html\",
    \"photo\": \"consequatur\",
    \"summary\": \"consequatur\",
    \"language\": \"fi\",
    \"is_primary\": true,
    \"is_public\": false,
    \"code\": \"opfuudtdsufvyvddqamni\",
    \"show_skill_levels\": true,
    \"show_language_levels\": false,
    \"work_experiences\": [
        \"consequatur\"
    ],
    \"educations\": [
        \"consequatur\"
    ],
    \"skills\": [
        \"consequatur\"
    ],
    \"projects\": [
        \"consequatur\"
    ],
    \"certifications\": [
        \"consequatur\"
    ],
    \"languages\": [
        \"consequatur\"
    ],
    \"awards\": [
        \"consequatur\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "title": "\"Software Engineer CV\"",
    "full_name": "Jussi Palanen",
    "email": "jussi@example.com",
    "phone": "+358401234567",
    "location": "Helsinki, Finland",
    "linkedin_url": "http:\/\/kunze.biz\/iste-laborum-eius-est-dolor.html",
    "portfolio_url": "http:\/\/kunze.biz\/iste-laborum-eius-est-dolor.html",
    "github_url": "http:\/\/kunze.biz\/iste-laborum-eius-est-dolor.html",
    "photo": "consequatur",
    "summary": "consequatur",
    "language": "fi",
    "is_primary": true,
    "is_public": false,
    "code": "opfuudtdsufvyvddqamni",
    "show_skill_levels": true,
    "show_language_levels": false,
    "work_experiences": [
        "consequatur"
    ],
    "educations": [
        "consequatur"
    ],
    "skills": [
        "consequatur"
    ],
    "projects": [
        "consequatur"
    ],
    "certifications": [
        "consequatur"
    ],
    "languages": [
        "consequatur"
    ],
    "awards": [
        "consequatur"
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-resumes">
</span>
<span id="execution-results-POSTapi-resumes" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-resumes"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-resumes"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-resumes" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-resumes">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-resumes" data-method="POST"
      data-path="api/resumes"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-resumes', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-resumes"
                    onclick="tryItOut('POSTapi-resumes');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-resumes"
                    onclick="cancelTryOut('POSTapi-resumes');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-resumes"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/resumes</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-resumes"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-resumes"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-resumes"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="POSTapi-resumes"
               value=""Software Engineer CV""
               data-component="body">
    <br>
<p>Resume label. Example: <code>"Software Engineer CV"</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>full_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="full_name"                data-endpoint="POSTapi-resumes"
               value="Jussi Palanen"
               data-component="body">
    <br>
<p>Full name. Example: <code>Jussi Palanen</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-resumes"
               value="jussi@example.com"
               data-component="body">
    <br>
<p>Email address. Example: <code>jussi@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-resumes"
               value="+358401234567"
               data-component="body">
    <br>
<p>Phone number. Example: <code>+358401234567</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>location</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="location"                data-endpoint="POSTapi-resumes"
               value="Helsinki, Finland"
               data-component="body">
    <br>
<p>Location. Example: <code>Helsinki, Finland</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>linkedin_url</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="linkedin_url"                data-endpoint="POSTapi-resumes"
               value="http://kunze.biz/iste-laborum-eius-est-dolor.html"
               data-component="body">
    <br>
<p>LinkedIn profile URL. Example: <code>http://kunze.biz/iste-laborum-eius-est-dolor.html</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>portfolio_url</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="portfolio_url"                data-endpoint="POSTapi-resumes"
               value="http://kunze.biz/iste-laborum-eius-est-dolor.html"
               data-component="body">
    <br>
<p>Portfolio or website URL. Example: <code>http://kunze.biz/iste-laborum-eius-est-dolor.html</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>github_url</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="github_url"                data-endpoint="POSTapi-resumes"
               value="http://kunze.biz/iste-laborum-eius-est-dolor.html"
               data-component="body">
    <br>
<p>GitHub profile URL. Example: <code>http://kunze.biz/iste-laborum-eius-est-dolor.html</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>photo</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="photo"                data-endpoint="POSTapi-resumes"
               value="consequatur"
               data-component="body">
    <br>
<p>Path to uploaded professional photo. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>summary</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="summary"                data-endpoint="POSTapi-resumes"
               value="consequatur"
               data-component="body">
    <br>
<p>Professional summary / objective paragraph. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>language</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="language"                data-endpoint="POSTapi-resumes"
               value="fi"
               data-component="body">
    <br>
<p>Example: <code>fi</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>en</code></li> <li><code>fi</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>template</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="template"                data-endpoint="POSTapi-resumes"
               value=""
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>theme</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="theme"                data-endpoint="POSTapi-resumes"
               value=""
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_primary</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-resumes" style="display: none">
            <input type="radio" name="is_primary"
                   value="true"
                   data-endpoint="POSTapi-resumes"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-resumes" style="display: none">
            <input type="radio" name="is_primary"
                   value="false"
                   data-endpoint="POSTapi-resumes"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_public</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-resumes" style="display: none">
            <input type="radio" name="is_public"
                   value="true"
                   data-endpoint="POSTapi-resumes"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-resumes" style="display: none">
            <input type="radio" name="is_public"
                   value="false"
                   data-endpoint="POSTapi-resumes"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="POSTapi-resumes"
               value="opfuudtdsufvyvddqamni"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>opfuudtdsufvyvddqamni</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>show_skill_levels</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-resumes" style="display: none">
            <input type="radio" name="show_skill_levels"
                   value="true"
                   data-endpoint="POSTapi-resumes"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-resumes" style="display: none">
            <input type="radio" name="show_skill_levels"
                   value="false"
                   data-endpoint="POSTapi-resumes"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>show_language_levels</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-resumes" style="display: none">
            <input type="radio" name="show_language_levels"
                   value="true"
                   data-endpoint="POSTapi-resumes"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-resumes" style="display: none">
            <input type="radio" name="show_language_levels"
                   value="false"
                   data-endpoint="POSTapi-resumes"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>work_experiences</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="work_experiences[0]"                data-endpoint="POSTapi-resumes"
               data-component="body">
        <input type="text" style="display: none"
               name="work_experiences[1]"                data-endpoint="POSTapi-resumes"
               data-component="body">
    <br>
<p>Optional work experience entries.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>educations</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="educations[0]"                data-endpoint="POSTapi-resumes"
               data-component="body">
        <input type="text" style="display: none"
               name="educations[1]"                data-endpoint="POSTapi-resumes"
               data-component="body">
    <br>
<p>Optional education entries.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>skills</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Optional skill entries.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>proficiency</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="skills.0.proficiency"                data-endpoint="POSTapi-resumes"
               value="consequatur"
               data-component="body">
    <br>
<p>Skill level: <code>beginner</code> (1), <code>basic</code> (2), <code>intermediate</code> (3), <code>advanced</code> (4), <code>expert</code> (5). Example: <code>consequatur</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>projects</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="projects[0]"                data-endpoint="POSTapi-resumes"
               data-component="body">
        <input type="text" style="display: none"
               name="projects[1]"                data-endpoint="POSTapi-resumes"
               data-component="body">
    <br>
<p>Optional project entries.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>certifications</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="certifications[0]"                data-endpoint="POSTapi-resumes"
               data-component="body">
        <input type="text" style="display: none"
               name="certifications[1]"                data-endpoint="POSTapi-resumes"
               data-component="body">
    <br>
<p>Optional certification entries.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>languages</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>
<p>Optional language entries.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>proficiency</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="languages.0.proficiency"                data-endpoint="POSTapi-resumes"
               value="consequatur"
               data-component="body">
    <br>
<p>Spoken-language level: <code>elementary</code> (1), <code>limited_working</code> (2), <code>professional_working</code> (3), <code>full_professional</code> (4), <code>native_bilingual</code> (5). Example: <code>consequatur</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>awards</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="awards[0]"                data-endpoint="POSTapi-resumes"
               data-component="body">
        <input type="text" style="display: none"
               name="awards[1]"                data-endpoint="POSTapi-resumes"
               data-component="body">
    <br>
<p>Optional award entries.</p>
        </div>
        </form>

                    <h2 id="resumes-GETapi-resumes--id-">Display a specific resume with all its sections.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-resumes--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/6" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes--id-" data-method="GET"
      data-path="api/resumes/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes--id-"
                    onclick="tryItOut('GETapi-resumes--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes--id-"
                    onclick="cancelTryOut('GETapi-resumes--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-resumes--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-resumes--id-"
               value="6"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>6</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resume</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resume"                data-endpoint="GETapi-resumes--id-"
               value="1"
               data-component="url">
    <br>
<p>The resume ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="resumes-PUTapi-resumes--id-">Update a resume and sync provided sections.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-PUTapi-resumes--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "title=vmqeopfuudtdsufvyvddq"\
    --form "full_name=amniihfqcoynlazghdtqt"\
    --form "email=andreanne00@example.org"\
    --form "phone=wbpilpmufinllwloauydl"\
    --form "location=smsjuryvojcybzvrbyick"\
    --form "linkedin_url=https://lemke.com/voluptatem-dignissimos-error-sit-labore-quos-ea-rerum-repudiandae.html"\
    --form "portfolio_url=http://greenfelder.com/consequatur-delectus-autem-nam-sunt-provident-quia-et"\
    --form "github_url=http://www.mueller.org/"\
    --form "summary=consequatur"\
    --form "language=fi"\
    --form "is_primary=1"\
    --form "is_public="\
    --form "code=opfuudtdsufvyvddqamni"\
    --form "show_skill_levels=1"\
    --form "show_language_levels="\
    --form "photo=@/tmp/phpcAllCo" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('title', 'vmqeopfuudtdsufvyvddq');
body.append('full_name', 'amniihfqcoynlazghdtqt');
body.append('email', 'andreanne00@example.org');
body.append('phone', 'wbpilpmufinllwloauydl');
body.append('location', 'smsjuryvojcybzvrbyick');
body.append('linkedin_url', 'https://lemke.com/voluptatem-dignissimos-error-sit-labore-quos-ea-rerum-repudiandae.html');
body.append('portfolio_url', 'http://greenfelder.com/consequatur-delectus-autem-nam-sunt-provident-quia-et');
body.append('github_url', 'http://www.mueller.org/');
body.append('summary', 'consequatur');
body.append('language', 'fi');
body.append('is_primary', '1');
body.append('is_public', '');
body.append('code', 'opfuudtdsufvyvddqamni');
body.append('show_skill_levels', '1');
body.append('show_language_levels', '');
body.append('photo', document.querySelector('input[name="photo"]').files[0]);

fetch(url, {
    method: "PUT",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-resumes--id-">
</span>
<span id="execution-results-PUTapi-resumes--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-resumes--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-resumes--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-resumes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-resumes--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-resumes--id-" data-method="PUT"
      data-path="api/resumes/{id}"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-resumes--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-resumes--id-"
                    onclick="tryItOut('PUTapi-resumes--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-resumes--id-"
                    onclick="cancelTryOut('PUTapi-resumes--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-resumes--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/resumes/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-resumes--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-resumes--id-"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-resumes--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-resumes--id-"
               value="6"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>6</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resume</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resume"                data-endpoint="PUTapi-resumes--id-"
               value="1"
               data-component="url">
    <br>
<p>The resume ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="PUTapi-resumes--id-"
               value="vmqeopfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>vmqeopfuudtdsufvyvddq</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>full_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="full_name"                data-endpoint="PUTapi-resumes--id-"
               value="amniihfqcoynlazghdtqt"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>amniihfqcoynlazghdtqt</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="PUTapi-resumes--id-"
               value="andreanne00@example.org"
               data-component="body">
    <br>
<p>Must be a valid email address. Must not be greater than 255 characters. Example: <code>andreanne00@example.org</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="PUTapi-resumes--id-"
               value="wbpilpmufinllwloauydl"
               data-component="body">
    <br>
<p>Must not be greater than 50 characters. Example: <code>wbpilpmufinllwloauydl</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>location</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="location"                data-endpoint="PUTapi-resumes--id-"
               value="smsjuryvojcybzvrbyick"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>smsjuryvojcybzvrbyick</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>linkedin_url</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="linkedin_url"                data-endpoint="PUTapi-resumes--id-"
               value="https://lemke.com/voluptatem-dignissimos-error-sit-labore-quos-ea-rerum-repudiandae.html"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 500 characters. Example: <code>https://lemke.com/voluptatem-dignissimos-error-sit-labore-quos-ea-rerum-repudiandae.html</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>portfolio_url</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="portfolio_url"                data-endpoint="PUTapi-resumes--id-"
               value="http://greenfelder.com/consequatur-delectus-autem-nam-sunt-provident-quia-et"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 500 characters. Example: <code>http://greenfelder.com/consequatur-delectus-autem-nam-sunt-provident-quia-et</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>github_url</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="github_url"                data-endpoint="PUTapi-resumes--id-"
               value="http://www.mueller.org/"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 500 characters. Example: <code>http://www.mueller.org/</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>photo</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="photo"                data-endpoint="PUTapi-resumes--id-"
               value=""
               data-component="body">
    <br>
<p>Must be a file. Must be an image. Must not be greater than 5120 kilobytes. Example: <code>/tmp/phpcAllCo</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>summary</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="summary"                data-endpoint="PUTapi-resumes--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>max 5MB. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>language</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="language"                data-endpoint="PUTapi-resumes--id-"
               value="fi"
               data-component="body">
    <br>
<p>Example: <code>fi</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>en</code></li> <li><code>fi</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>template</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="template"                data-endpoint="PUTapi-resumes--id-"
               value=""
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>theme</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="theme"                data-endpoint="PUTapi-resumes--id-"
               value=""
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_primary</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-resumes--id-" style="display: none">
            <input type="radio" name="is_primary"
                   value="true"
                   data-endpoint="PUTapi-resumes--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-resumes--id-" style="display: none">
            <input type="radio" name="is_primary"
                   value="false"
                   data-endpoint="PUTapi-resumes--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_public</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-resumes--id-" style="display: none">
            <input type="radio" name="is_public"
                   value="true"
                   data-endpoint="PUTapi-resumes--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-resumes--id-" style="display: none">
            <input type="radio" name="is_public"
                   value="false"
                   data-endpoint="PUTapi-resumes--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="PUTapi-resumes--id-"
               value="opfuudtdsufvyvddqamni"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>opfuudtdsufvyvddqamni</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>show_skill_levels</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-resumes--id-" style="display: none">
            <input type="radio" name="show_skill_levels"
                   value="true"
                   data-endpoint="PUTapi-resumes--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-resumes--id-" style="display: none">
            <input type="radio" name="show_skill_levels"
                   value="false"
                   data-endpoint="PUTapi-resumes--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>show_language_levels</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-resumes--id-" style="display: none">
            <input type="radio" name="show_language_levels"
                   value="true"
                   data-endpoint="PUTapi-resumes--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-resumes--id-" style="display: none">
            <input type="radio" name="show_language_levels"
                   value="false"
                   data-endpoint="PUTapi-resumes--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>skills</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>proficiency</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="skills.0.proficiency"                data-endpoint="PUTapi-resumes--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>Skill level: <code>beginner</code> (1), <code>basic</code> (2), <code>intermediate</code> (3), <code>advanced</code> (4), <code>expert</code> (5). Example: <code>consequatur</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>languages</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>proficiency</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="languages.0.proficiency"                data-endpoint="PUTapi-resumes--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>Spoken-language level: <code>elementary</code> (1), <code>limited_working</code> (2), <code>professional_working</code> (3), <code>full_professional</code> (4), <code>native_bilingual</code> (5). Example: <code>consequatur</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="resumes-POSTapi-resumes--id-">Update a resume and sync provided sections.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-resumes--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "title=vmqeopfuudtdsufvyvddq"\
    --form "full_name=amniihfqcoynlazghdtqt"\
    --form "email=andreanne00@example.org"\
    --form "phone=wbpilpmufinllwloauydl"\
    --form "location=smsjuryvojcybzvrbyick"\
    --form "linkedin_url=https://lemke.com/voluptatem-dignissimos-error-sit-labore-quos-ea-rerum-repudiandae.html"\
    --form "portfolio_url=http://greenfelder.com/consequatur-delectus-autem-nam-sunt-provident-quia-et"\
    --form "github_url=http://www.mueller.org/"\
    --form "summary=consequatur"\
    --form "language=fi"\
    --form "is_primary=1"\
    --form "is_public="\
    --form "code=opfuudtdsufvyvddqamni"\
    --form "show_skill_levels=1"\
    --form "show_language_levels="\
    --form "photo=@/tmp/phpKNLFPo" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('title', 'vmqeopfuudtdsufvyvddq');
body.append('full_name', 'amniihfqcoynlazghdtqt');
body.append('email', 'andreanne00@example.org');
body.append('phone', 'wbpilpmufinllwloauydl');
body.append('location', 'smsjuryvojcybzvrbyick');
body.append('linkedin_url', 'https://lemke.com/voluptatem-dignissimos-error-sit-labore-quos-ea-rerum-repudiandae.html');
body.append('portfolio_url', 'http://greenfelder.com/consequatur-delectus-autem-nam-sunt-provident-quia-et');
body.append('github_url', 'http://www.mueller.org/');
body.append('summary', 'consequatur');
body.append('language', 'fi');
body.append('is_primary', '1');
body.append('is_public', '');
body.append('code', 'opfuudtdsufvyvddqamni');
body.append('show_skill_levels', '1');
body.append('show_language_levels', '');
body.append('photo', document.querySelector('input[name="photo"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-resumes--id-">
</span>
<span id="execution-results-POSTapi-resumes--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-resumes--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-resumes--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-resumes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-resumes--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-resumes--id-" data-method="POST"
      data-path="api/resumes/{id}"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-resumes--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-resumes--id-"
                    onclick="tryItOut('POSTapi-resumes--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-resumes--id-"
                    onclick="cancelTryOut('POSTapi-resumes--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-resumes--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/resumes/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-resumes--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-resumes--id-"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-resumes--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-resumes--id-"
               value="6"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>6</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resume</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resume"                data-endpoint="POSTapi-resumes--id-"
               value="1"
               data-component="url">
    <br>
<p>The resume ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="POSTapi-resumes--id-"
               value="vmqeopfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>vmqeopfuudtdsufvyvddq</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>full_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="full_name"                data-endpoint="POSTapi-resumes--id-"
               value="amniihfqcoynlazghdtqt"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>amniihfqcoynlazghdtqt</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-resumes--id-"
               value="andreanne00@example.org"
               data-component="body">
    <br>
<p>Must be a valid email address. Must not be greater than 255 characters. Example: <code>andreanne00@example.org</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-resumes--id-"
               value="wbpilpmufinllwloauydl"
               data-component="body">
    <br>
<p>Must not be greater than 50 characters. Example: <code>wbpilpmufinllwloauydl</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>location</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="location"                data-endpoint="POSTapi-resumes--id-"
               value="smsjuryvojcybzvrbyick"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>smsjuryvojcybzvrbyick</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>linkedin_url</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="linkedin_url"                data-endpoint="POSTapi-resumes--id-"
               value="https://lemke.com/voluptatem-dignissimos-error-sit-labore-quos-ea-rerum-repudiandae.html"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 500 characters. Example: <code>https://lemke.com/voluptatem-dignissimos-error-sit-labore-quos-ea-rerum-repudiandae.html</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>portfolio_url</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="portfolio_url"                data-endpoint="POSTapi-resumes--id-"
               value="http://greenfelder.com/consequatur-delectus-autem-nam-sunt-provident-quia-et"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 500 characters. Example: <code>http://greenfelder.com/consequatur-delectus-autem-nam-sunt-provident-quia-et</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>github_url</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="github_url"                data-endpoint="POSTapi-resumes--id-"
               value="http://www.mueller.org/"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 500 characters. Example: <code>http://www.mueller.org/</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>photo</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="photo"                data-endpoint="POSTapi-resumes--id-"
               value=""
               data-component="body">
    <br>
<p>Must be a file. Must be an image. Must not be greater than 5120 kilobytes. Example: <code>/tmp/phpKNLFPo</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>summary</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="summary"                data-endpoint="POSTapi-resumes--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>max 5MB. Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>language</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="language"                data-endpoint="POSTapi-resumes--id-"
               value="fi"
               data-component="body">
    <br>
<p>Example: <code>fi</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>en</code></li> <li><code>fi</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>template</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="template"                data-endpoint="POSTapi-resumes--id-"
               value=""
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>theme</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="theme"                data-endpoint="POSTapi-resumes--id-"
               value=""
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_primary</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-resumes--id-" style="display: none">
            <input type="radio" name="is_primary"
                   value="true"
                   data-endpoint="POSTapi-resumes--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-resumes--id-" style="display: none">
            <input type="radio" name="is_primary"
                   value="false"
                   data-endpoint="POSTapi-resumes--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_public</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-resumes--id-" style="display: none">
            <input type="radio" name="is_public"
                   value="true"
                   data-endpoint="POSTapi-resumes--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-resumes--id-" style="display: none">
            <input type="radio" name="is_public"
                   value="false"
                   data-endpoint="POSTapi-resumes--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="POSTapi-resumes--id-"
               value="opfuudtdsufvyvddqamni"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>opfuudtdsufvyvddqamni</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>show_skill_levels</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-resumes--id-" style="display: none">
            <input type="radio" name="show_skill_levels"
                   value="true"
                   data-endpoint="POSTapi-resumes--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-resumes--id-" style="display: none">
            <input type="radio" name="show_skill_levels"
                   value="false"
                   data-endpoint="POSTapi-resumes--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>show_language_levels</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="POSTapi-resumes--id-" style="display: none">
            <input type="radio" name="show_language_levels"
                   value="true"
                   data-endpoint="POSTapi-resumes--id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-resumes--id-" style="display: none">
            <input type="radio" name="show_language_levels"
                   value="false"
                   data-endpoint="POSTapi-resumes--id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>skills</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>proficiency</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="skills.0.proficiency"                data-endpoint="POSTapi-resumes--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>Skill level: <code>beginner</code> (1), <code>basic</code> (2), <code>intermediate</code> (3), <code>advanced</code> (4), <code>expert</code> (5). Example: <code>consequatur</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>languages</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>proficiency</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="languages.0.proficiency"                data-endpoint="POSTapi-resumes--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>Spoken-language level: <code>elementary</code> (1), <code>limited_working</code> (2), <code>professional_working</code> (3), <code>full_professional</code> (4), <code>native_bilingual</code> (5). Example: <code>consequatur</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="resumes-DELETEapi-resumes--id-">Delete a resume and all its sections.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-resumes--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-resumes--id-">
</span>
<span id="execution-results-DELETEapi-resumes--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-resumes--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-resumes--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-resumes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-resumes--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-resumes--id-" data-method="DELETE"
      data-path="api/resumes/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-resumes--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-resumes--id-"
                    onclick="tryItOut('DELETEapi-resumes--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-resumes--id-"
                    onclick="cancelTryOut('DELETEapi-resumes--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-resumes--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/resumes/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-resumes--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-resumes--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-resumes--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-resumes--id-"
               value="6"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>6</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resume</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resume"                data-endpoint="DELETEapi-resumes--id-"
               value="1"
               data-component="url">
    <br>
<p>The resume ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="resumes-GETapi-resumes--id--export-pdf">Export a resume as a PDF file.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-resumes--id--export-pdf">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/6/export/pdf" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6/export/pdf"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes--id--export-pdf">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes--id--export-pdf" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes--id--export-pdf"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes--id--export-pdf"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes--id--export-pdf" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes--id--export-pdf">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes--id--export-pdf" data-method="GET"
      data-path="api/resumes/{id}/export/pdf"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes--id--export-pdf', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes--id--export-pdf"
                    onclick="tryItOut('GETapi-resumes--id--export-pdf');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes--id--export-pdf"
                    onclick="cancelTryOut('GETapi-resumes--id--export-pdf');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes--id--export-pdf"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/{id}/export/pdf</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-resumes--id--export-pdf"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes--id--export-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes--id--export-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-resumes--id--export-pdf"
               value="6"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>6</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resume</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resume"                data-endpoint="GETapi-resumes--id--export-pdf"
               value="1"
               data-component="url">
    <br>
<p>The resume ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="resumes-GETapi-resumes--id--export-html">Export a resume as an HTML file.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-resumes--id--export-html">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/6/export/html" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6/export/html"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes--id--export-html">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes--id--export-html" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes--id--export-html"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes--id--export-html"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes--id--export-html" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes--id--export-html">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes--id--export-html" data-method="GET"
      data-path="api/resumes/{id}/export/html"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes--id--export-html', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes--id--export-html"
                    onclick="tryItOut('GETapi-resumes--id--export-html');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes--id--export-html"
                    onclick="cancelTryOut('GETapi-resumes--id--export-html');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes--id--export-html"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/{id}/export/html</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-resumes--id--export-html"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes--id--export-html"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes--id--export-html"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-resumes--id--export-html"
               value="6"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>6</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resume</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resume"                data-endpoint="GETapi-resumes--id--export-html"
               value="1"
               data-component="url">
    <br>
<p>The resume ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="resumes-GETapi-resumes--id--export-json">Export a resume as a downloadable JSON backup file.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>The photo is not included. All section items are exported without internal IDs.</p>

<span id="example-requests-GETapi-resumes--id--export-json">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/6/export/json" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6/export/json"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes--id--export-json">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes--id--export-json" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes--id--export-json"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes--id--export-json"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes--id--export-json" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes--id--export-json">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes--id--export-json" data-method="GET"
      data-path="api/resumes/{id}/export/json"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes--id--export-json', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes--id--export-json"
                    onclick="tryItOut('GETapi-resumes--id--export-json');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes--id--export-json"
                    onclick="cancelTryOut('GETapi-resumes--id--export-json');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes--id--export-json"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/{id}/export/json</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-resumes--id--export-json"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes--id--export-json"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes--id--export-json"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-resumes--id--export-json"
               value="6"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>6</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resume</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resume"                data-endpoint="GETapi-resumes--id--export-json"
               value="1"
               data-component="url">
    <br>
<p>The resume ID. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="resumes-GETapi-resumes--id--preview-pdf">Preview a resume as an inline PDF (opens in browser, no download).</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-resumes--id--preview-pdf">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/6/preview/pdf?theme=blue&amp;lang=en&amp;template=default&amp;show_skill_levels=1&amp;show_language_levels=1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6/preview/pdf"
);

const params = {
    "theme": "blue",
    "lang": "en",
    "template": "default",
    "show_skill_levels": "1",
    "show_language_levels": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes--id--preview-pdf">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes--id--preview-pdf" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes--id--preview-pdf"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes--id--preview-pdf"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes--id--preview-pdf" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes--id--preview-pdf">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes--id--preview-pdf" data-method="GET"
      data-path="api/resumes/{id}/preview/pdf"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes--id--preview-pdf', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes--id--preview-pdf"
                    onclick="tryItOut('GETapi-resumes--id--preview-pdf');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes--id--preview-pdf"
                    onclick="cancelTryOut('GETapi-resumes--id--preview-pdf');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes--id--preview-pdf"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/{id}/preview/pdf</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-resumes--id--preview-pdf"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes--id--preview-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes--id--preview-pdf"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-resumes--id--preview-pdf"
               value="6"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>6</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resume</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resume"                data-endpoint="GETapi-resumes--id--preview-pdf"
               value="1"
               data-component="url">
    <br>
<p>The resume ID. Example: <code>1</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>theme</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="theme"                data-endpoint="GETapi-resumes--id--preview-pdf"
               value="blue"
               data-component="query">
    <br>
<p>Theme name. Example: <code>blue</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>lang</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lang"                data-endpoint="GETapi-resumes--id--preview-pdf"
               value="en"
               data-component="query">
    <br>
<p>Language code (en, fi). Example: <code>en</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>template</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="template"                data-endpoint="GETapi-resumes--id--preview-pdf"
               value="default"
               data-component="query">
    <br>
<p>Template name. Example: <code>default</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>show_skill_levels</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-resumes--id--preview-pdf" style="display: none">
            <input type="radio" name="show_skill_levels"
                   value="1"
                   data-endpoint="GETapi-resumes--id--preview-pdf"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-resumes--id--preview-pdf" style="display: none">
            <input type="radio" name="show_skill_levels"
                   value="0"
                   data-endpoint="GETapi-resumes--id--preview-pdf"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Show skill level bars. Example: <code>true</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>show_language_levels</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-resumes--id--preview-pdf" style="display: none">
            <input type="radio" name="show_language_levels"
                   value="1"
                   data-endpoint="GETapi-resumes--id--preview-pdf"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-resumes--id--preview-pdf" style="display: none">
            <input type="radio" name="show_language_levels"
                   value="0"
                   data-endpoint="GETapi-resumes--id--preview-pdf"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Show language level dots. Example: <code>true</code></p>
            </div>
                </form>

                    <h2 id="resumes-GETapi-resumes--id--preview-html">Preview a resume as inline HTML (renders in browser, no download).</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-resumes--id--preview-html">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/6/preview/html?theme=blue&amp;lang=en&amp;template=default&amp;show_skill_levels=1&amp;show_language_levels=1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6/preview/html"
);

const params = {
    "theme": "blue",
    "lang": "en",
    "template": "default",
    "show_skill_levels": "1",
    "show_language_levels": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes--id--preview-html">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes--id--preview-html" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes--id--preview-html"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes--id--preview-html"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes--id--preview-html" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes--id--preview-html">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes--id--preview-html" data-method="GET"
      data-path="api/resumes/{id}/preview/html"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes--id--preview-html', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes--id--preview-html"
                    onclick="tryItOut('GETapi-resumes--id--preview-html');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes--id--preview-html"
                    onclick="cancelTryOut('GETapi-resumes--id--preview-html');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes--id--preview-html"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/{id}/preview/html</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-resumes--id--preview-html"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes--id--preview-html"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes--id--preview-html"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-resumes--id--preview-html"
               value="6"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>6</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resume</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resume"                data-endpoint="GETapi-resumes--id--preview-html"
               value="1"
               data-component="url">
    <br>
<p>The resume ID. Example: <code>1</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>theme</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="theme"                data-endpoint="GETapi-resumes--id--preview-html"
               value="blue"
               data-component="query">
    <br>
<p>Theme name. Example: <code>blue</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>lang</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lang"                data-endpoint="GETapi-resumes--id--preview-html"
               value="en"
               data-component="query">
    <br>
<p>Language code (en, fi). Example: <code>en</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>template</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="template"                data-endpoint="GETapi-resumes--id--preview-html"
               value="default"
               data-component="query">
    <br>
<p>Template name. Example: <code>default</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>show_skill_levels</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-resumes--id--preview-html" style="display: none">
            <input type="radio" name="show_skill_levels"
                   value="1"
                   data-endpoint="GETapi-resumes--id--preview-html"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-resumes--id--preview-html" style="display: none">
            <input type="radio" name="show_skill_levels"
                   value="0"
                   data-endpoint="GETapi-resumes--id--preview-html"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Show skill level bars. Example: <code>true</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>show_language_levels</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-resumes--id--preview-html" style="display: none">
            <input type="radio" name="show_language_levels"
                   value="1"
                   data-endpoint="GETapi-resumes--id--preview-html"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-resumes--id--preview-html" style="display: none">
            <input type="radio" name="show_language_levels"
                   value="0"
                   data-endpoint="GETapi-resumes--id--preview-html"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Show language level dots. Example: <code>true</code></p>
            </div>
                </form>

                    <h2 id="resumes-GETapi-resumes--id--preview-signed-url">Generate short-lived signed preview URLs for PDF and HTML (no token needed to open them).</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-resumes--id--preview-signed-url">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/resumes/6/preview/signed-url?theme=blue&amp;lang=en&amp;template=default&amp;show_skill_levels=1&amp;show_language_levels=1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6/preview/signed-url"
);

const params = {
    "theme": "blue",
    "lang": "en",
    "template": "default",
    "show_skill_levels": "1",
    "show_language_levels": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-resumes--id--preview-signed-url">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-resumes--id--preview-signed-url" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-resumes--id--preview-signed-url"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-resumes--id--preview-signed-url"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-resumes--id--preview-signed-url" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-resumes--id--preview-signed-url">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-resumes--id--preview-signed-url" data-method="GET"
      data-path="api/resumes/{id}/preview/signed-url"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-resumes--id--preview-signed-url', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-resumes--id--preview-signed-url"
                    onclick="tryItOut('GETapi-resumes--id--preview-signed-url');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-resumes--id--preview-signed-url"
                    onclick="cancelTryOut('GETapi-resumes--id--preview-signed-url');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-resumes--id--preview-signed-url"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/resumes/{id}/preview/signed-url</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-resumes--id--preview-signed-url"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-resumes--id--preview-signed-url"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-resumes--id--preview-signed-url"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-resumes--id--preview-signed-url"
               value="6"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>6</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resume</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resume"                data-endpoint="GETapi-resumes--id--preview-signed-url"
               value="1"
               data-component="url">
    <br>
<p>The resume ID. Example: <code>1</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>theme</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="theme"                data-endpoint="GETapi-resumes--id--preview-signed-url"
               value="blue"
               data-component="query">
    <br>
<p>Theme name. Example: <code>blue</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>lang</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lang"                data-endpoint="GETapi-resumes--id--preview-signed-url"
               value="en"
               data-component="query">
    <br>
<p>Language code (en, fi). Example: <code>en</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>template</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="template"                data-endpoint="GETapi-resumes--id--preview-signed-url"
               value="default"
               data-component="query">
    <br>
<p>Template name. Example: <code>default</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>show_skill_levels</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-resumes--id--preview-signed-url" style="display: none">
            <input type="radio" name="show_skill_levels"
                   value="1"
                   data-endpoint="GETapi-resumes--id--preview-signed-url"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-resumes--id--preview-signed-url" style="display: none">
            <input type="radio" name="show_skill_levels"
                   value="0"
                   data-endpoint="GETapi-resumes--id--preview-signed-url"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Show skill level bars. Example: <code>true</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>show_language_levels</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <label data-endpoint="GETapi-resumes--id--preview-signed-url" style="display: none">
            <input type="radio" name="show_language_levels"
                   value="1"
                   data-endpoint="GETapi-resumes--id--preview-signed-url"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-resumes--id--preview-signed-url" style="display: none">
            <input type="radio" name="show_language_levels"
                   value="0"
                   data-endpoint="GETapi-resumes--id--preview-signed-url"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Show language level dots. Example: <code>true</code></p>
            </div>
                </form>

                    <h2 id="resumes-POSTapi-resumes-import-json">Import a resume from a previously exported JSON backup file.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Creates a new resume for the authenticated user. The photo is not restored.</p>

<span id="example-requests-POSTapi-resumes-import-json">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/resumes/import/json" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "file=@/tmp/phppOENnA" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/import/json"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('file', document.querySelector('input[name="file"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-resumes-import-json">
</span>
<span id="execution-results-POSTapi-resumes-import-json" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-resumes-import-json"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-resumes-import-json"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-resumes-import-json" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-resumes-import-json">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-resumes-import-json" data-method="POST"
      data-path="api/resumes/import/json"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-resumes-import-json', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-resumes-import-json"
                    onclick="tryItOut('POSTapi-resumes-import-json');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-resumes-import-json"
                    onclick="cancelTryOut('POSTapi-resumes-import-json');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-resumes-import-json"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/resumes/import/json</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-resumes-import-json"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-resumes-import-json"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-resumes-import-json"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>file</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="file"                data-endpoint="POSTapi-resumes-import-json"
               value=""
               data-component="body">
    <br>
<p>The JSON backup file produced by the export endpoint. Example: <code>/tmp/phppOENnA</code></p>
        </div>
        </form>

                    <h2 id="resumes-POSTapi-resumes--id--import-json">Import a resume from a previously exported JSON backup file.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Creates a new resume for the authenticated user. The photo is not restored.</p>

<span id="example-requests-POSTapi-resumes--id--import-json">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6/import/json" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "file=@/tmp/phpjmgdFB" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/resumes/6/import/json"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('file', document.querySelector('input[name="file"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-resumes--id--import-json">
</span>
<span id="execution-results-POSTapi-resumes--id--import-json" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-resumes--id--import-json"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-resumes--id--import-json"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-resumes--id--import-json" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-resumes--id--import-json">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-resumes--id--import-json" data-method="POST"
      data-path="api/resumes/{id}/import/json"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-resumes--id--import-json', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-resumes--id--import-json"
                    onclick="tryItOut('POSTapi-resumes--id--import-json');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-resumes--id--import-json"
                    onclick="cancelTryOut('POSTapi-resumes--id--import-json');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-resumes--id--import-json"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/resumes/{id}/import/json</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-resumes--id--import-json"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-resumes--id--import-json"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-resumes--id--import-json"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-resumes--id--import-json"
               value="6"
               data-component="url">
    <br>
<p>The ID of the resume. Example: <code>6</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>file</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="file"                data-endpoint="POSTapi-resumes--id--import-json"
               value=""
               data-component="body">
    <br>
<p>The JSON backup file produced by the export endpoint. Example: <code>/tmp/phpjmgdFB</code></p>
        </div>
        </form>

                <h1 id="settings">Settings</h1>

    

                                <h2 id="settings-GETapi-settings-languages">Return the list of supported languages with translated labels.</h2>

<p>
</p>

<p>Pass <code>?lang=fi</code> to receive labels in Finnish (default: <code>en</code>).</p>

<span id="example-requests-GETapi-settings-languages">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/settings/languages" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/settings/languages"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-settings-languages">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 50
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;value&quot;: &quot;en&quot;,
        &quot;label&quot;: &quot;English&quot;
    },
    {
        &quot;value&quot;: &quot;fi&quot;,
        &quot;label&quot;: &quot;Finnish&quot;
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-settings-languages" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-settings-languages"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-settings-languages"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-settings-languages" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-settings-languages">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-settings-languages" data-method="GET"
      data-path="api/settings/languages"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-settings-languages', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-settings-languages"
                    onclick="tryItOut('GETapi-settings-languages');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-settings-languages"
                    onclick="cancelTryOut('GETapi-settings-languages');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-settings-languages"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/settings/languages</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-settings-languages"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-settings-languages"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="settings-GETapi-settings-countries">Return the list of world countries with translated labels.</h2>

<p>
</p>

<p>Pass <code>?lang=fi</code> to receive labels in Finnish (default: <code>en</code>).</p>

<span id="example-requests-GETapi-settings-countries">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/settings/countries" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/settings/countries"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-settings-countries">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 49
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;value&quot;: &quot;AF&quot;,
        &quot;label&quot;: &quot;Afghanistan&quot;
    },
    {
        &quot;value&quot;: &quot;AL&quot;,
        &quot;label&quot;: &quot;Albania&quot;
    },
    {
        &quot;value&quot;: &quot;DZ&quot;,
        &quot;label&quot;: &quot;Algeria&quot;
    },
    {
        &quot;value&quot;: &quot;AD&quot;,
        &quot;label&quot;: &quot;Andorra&quot;
    },
    {
        &quot;value&quot;: &quot;AO&quot;,
        &quot;label&quot;: &quot;Angola&quot;
    },
    {
        &quot;value&quot;: &quot;AG&quot;,
        &quot;label&quot;: &quot;Antigua and Barbuda&quot;
    },
    {
        &quot;value&quot;: &quot;AR&quot;,
        &quot;label&quot;: &quot;Argentina&quot;
    },
    {
        &quot;value&quot;: &quot;AM&quot;,
        &quot;label&quot;: &quot;Armenia&quot;
    },
    {
        &quot;value&quot;: &quot;AU&quot;,
        &quot;label&quot;: &quot;Australia&quot;
    },
    {
        &quot;value&quot;: &quot;AT&quot;,
        &quot;label&quot;: &quot;Austria&quot;
    },
    {
        &quot;value&quot;: &quot;AZ&quot;,
        &quot;label&quot;: &quot;Azerbaijan&quot;
    },
    {
        &quot;value&quot;: &quot;BS&quot;,
        &quot;label&quot;: &quot;Bahamas&quot;
    },
    {
        &quot;value&quot;: &quot;BH&quot;,
        &quot;label&quot;: &quot;Bahrain&quot;
    },
    {
        &quot;value&quot;: &quot;BD&quot;,
        &quot;label&quot;: &quot;Bangladesh&quot;
    },
    {
        &quot;value&quot;: &quot;BB&quot;,
        &quot;label&quot;: &quot;Barbados&quot;
    },
    {
        &quot;value&quot;: &quot;BY&quot;,
        &quot;label&quot;: &quot;Belarus&quot;
    },
    {
        &quot;value&quot;: &quot;BE&quot;,
        &quot;label&quot;: &quot;Belgium&quot;
    },
    {
        &quot;value&quot;: &quot;BZ&quot;,
        &quot;label&quot;: &quot;Belize&quot;
    },
    {
        &quot;value&quot;: &quot;BJ&quot;,
        &quot;label&quot;: &quot;Benin&quot;
    },
    {
        &quot;value&quot;: &quot;BT&quot;,
        &quot;label&quot;: &quot;Bhutan&quot;
    },
    {
        &quot;value&quot;: &quot;BO&quot;,
        &quot;label&quot;: &quot;Bolivia&quot;
    },
    {
        &quot;value&quot;: &quot;BA&quot;,
        &quot;label&quot;: &quot;Bosnia and Herzegovina&quot;
    },
    {
        &quot;value&quot;: &quot;BW&quot;,
        &quot;label&quot;: &quot;Botswana&quot;
    },
    {
        &quot;value&quot;: &quot;BR&quot;,
        &quot;label&quot;: &quot;Brazil&quot;
    },
    {
        &quot;value&quot;: &quot;BN&quot;,
        &quot;label&quot;: &quot;Brunei&quot;
    },
    {
        &quot;value&quot;: &quot;BG&quot;,
        &quot;label&quot;: &quot;Bulgaria&quot;
    },
    {
        &quot;value&quot;: &quot;BF&quot;,
        &quot;label&quot;: &quot;Burkina Faso&quot;
    },
    {
        &quot;value&quot;: &quot;BI&quot;,
        &quot;label&quot;: &quot;Burundi&quot;
    },
    {
        &quot;value&quot;: &quot;CV&quot;,
        &quot;label&quot;: &quot;Cabo Verde&quot;
    },
    {
        &quot;value&quot;: &quot;KH&quot;,
        &quot;label&quot;: &quot;Cambodia&quot;
    },
    {
        &quot;value&quot;: &quot;CM&quot;,
        &quot;label&quot;: &quot;Cameroon&quot;
    },
    {
        &quot;value&quot;: &quot;CA&quot;,
        &quot;label&quot;: &quot;Canada&quot;
    },
    {
        &quot;value&quot;: &quot;CF&quot;,
        &quot;label&quot;: &quot;Central African Republic&quot;
    },
    {
        &quot;value&quot;: &quot;TD&quot;,
        &quot;label&quot;: &quot;Chad&quot;
    },
    {
        &quot;value&quot;: &quot;CL&quot;,
        &quot;label&quot;: &quot;Chile&quot;
    },
    {
        &quot;value&quot;: &quot;CN&quot;,
        &quot;label&quot;: &quot;China&quot;
    },
    {
        &quot;value&quot;: &quot;CO&quot;,
        &quot;label&quot;: &quot;Colombia&quot;
    },
    {
        &quot;value&quot;: &quot;KM&quot;,
        &quot;label&quot;: &quot;Comoros&quot;
    },
    {
        &quot;value&quot;: &quot;CG&quot;,
        &quot;label&quot;: &quot;Congo&quot;
    },
    {
        &quot;value&quot;: &quot;CD&quot;,
        &quot;label&quot;: &quot;Congo, Democratic Republic of the&quot;
    },
    {
        &quot;value&quot;: &quot;CR&quot;,
        &quot;label&quot;: &quot;Costa Rica&quot;
    },
    {
        &quot;value&quot;: &quot;HR&quot;,
        &quot;label&quot;: &quot;Croatia&quot;
    },
    {
        &quot;value&quot;: &quot;CU&quot;,
        &quot;label&quot;: &quot;Cuba&quot;
    },
    {
        &quot;value&quot;: &quot;CY&quot;,
        &quot;label&quot;: &quot;Cyprus&quot;
    },
    {
        &quot;value&quot;: &quot;CZ&quot;,
        &quot;label&quot;: &quot;Czech Republic&quot;
    },
    {
        &quot;value&quot;: &quot;DK&quot;,
        &quot;label&quot;: &quot;Denmark&quot;
    },
    {
        &quot;value&quot;: &quot;DJ&quot;,
        &quot;label&quot;: &quot;Djibouti&quot;
    },
    {
        &quot;value&quot;: &quot;DM&quot;,
        &quot;label&quot;: &quot;Dominica&quot;
    },
    {
        &quot;value&quot;: &quot;DO&quot;,
        &quot;label&quot;: &quot;Dominican Republic&quot;
    },
    {
        &quot;value&quot;: &quot;EC&quot;,
        &quot;label&quot;: &quot;Ecuador&quot;
    },
    {
        &quot;value&quot;: &quot;EG&quot;,
        &quot;label&quot;: &quot;Egypt&quot;
    },
    {
        &quot;value&quot;: &quot;SV&quot;,
        &quot;label&quot;: &quot;El Salvador&quot;
    },
    {
        &quot;value&quot;: &quot;GQ&quot;,
        &quot;label&quot;: &quot;Equatorial Guinea&quot;
    },
    {
        &quot;value&quot;: &quot;ER&quot;,
        &quot;label&quot;: &quot;Eritrea&quot;
    },
    {
        &quot;value&quot;: &quot;EE&quot;,
        &quot;label&quot;: &quot;Estonia&quot;
    },
    {
        &quot;value&quot;: &quot;SZ&quot;,
        &quot;label&quot;: &quot;Eswatini&quot;
    },
    {
        &quot;value&quot;: &quot;ET&quot;,
        &quot;label&quot;: &quot;Ethiopia&quot;
    },
    {
        &quot;value&quot;: &quot;FJ&quot;,
        &quot;label&quot;: &quot;Fiji&quot;
    },
    {
        &quot;value&quot;: &quot;FI&quot;,
        &quot;label&quot;: &quot;Finland&quot;
    },
    {
        &quot;value&quot;: &quot;FR&quot;,
        &quot;label&quot;: &quot;France&quot;
    },
    {
        &quot;value&quot;: &quot;GA&quot;,
        &quot;label&quot;: &quot;Gabon&quot;
    },
    {
        &quot;value&quot;: &quot;GM&quot;,
        &quot;label&quot;: &quot;Gambia&quot;
    },
    {
        &quot;value&quot;: &quot;GE&quot;,
        &quot;label&quot;: &quot;Georgia&quot;
    },
    {
        &quot;value&quot;: &quot;DE&quot;,
        &quot;label&quot;: &quot;Germany&quot;
    },
    {
        &quot;value&quot;: &quot;GH&quot;,
        &quot;label&quot;: &quot;Ghana&quot;
    },
    {
        &quot;value&quot;: &quot;GR&quot;,
        &quot;label&quot;: &quot;Greece&quot;
    },
    {
        &quot;value&quot;: &quot;GD&quot;,
        &quot;label&quot;: &quot;Grenada&quot;
    },
    {
        &quot;value&quot;: &quot;GT&quot;,
        &quot;label&quot;: &quot;Guatemala&quot;
    },
    {
        &quot;value&quot;: &quot;GN&quot;,
        &quot;label&quot;: &quot;Guinea&quot;
    },
    {
        &quot;value&quot;: &quot;GW&quot;,
        &quot;label&quot;: &quot;Guinea-Bissau&quot;
    },
    {
        &quot;value&quot;: &quot;GY&quot;,
        &quot;label&quot;: &quot;Guyana&quot;
    },
    {
        &quot;value&quot;: &quot;HT&quot;,
        &quot;label&quot;: &quot;Haiti&quot;
    },
    {
        &quot;value&quot;: &quot;HN&quot;,
        &quot;label&quot;: &quot;Honduras&quot;
    },
    {
        &quot;value&quot;: &quot;HU&quot;,
        &quot;label&quot;: &quot;Hungary&quot;
    },
    {
        &quot;value&quot;: &quot;IS&quot;,
        &quot;label&quot;: &quot;Iceland&quot;
    },
    {
        &quot;value&quot;: &quot;IN&quot;,
        &quot;label&quot;: &quot;India&quot;
    },
    {
        &quot;value&quot;: &quot;ID&quot;,
        &quot;label&quot;: &quot;Indonesia&quot;
    },
    {
        &quot;value&quot;: &quot;IR&quot;,
        &quot;label&quot;: &quot;Iran&quot;
    },
    {
        &quot;value&quot;: &quot;IQ&quot;,
        &quot;label&quot;: &quot;Iraq&quot;
    },
    {
        &quot;value&quot;: &quot;IE&quot;,
        &quot;label&quot;: &quot;Ireland&quot;
    },
    {
        &quot;value&quot;: &quot;IL&quot;,
        &quot;label&quot;: &quot;Israel&quot;
    },
    {
        &quot;value&quot;: &quot;IT&quot;,
        &quot;label&quot;: &quot;Italy&quot;
    },
    {
        &quot;value&quot;: &quot;JM&quot;,
        &quot;label&quot;: &quot;Jamaica&quot;
    },
    {
        &quot;value&quot;: &quot;JP&quot;,
        &quot;label&quot;: &quot;Japan&quot;
    },
    {
        &quot;value&quot;: &quot;JO&quot;,
        &quot;label&quot;: &quot;Jordan&quot;
    },
    {
        &quot;value&quot;: &quot;KZ&quot;,
        &quot;label&quot;: &quot;Kazakhstan&quot;
    },
    {
        &quot;value&quot;: &quot;KE&quot;,
        &quot;label&quot;: &quot;Kenya&quot;
    },
    {
        &quot;value&quot;: &quot;KI&quot;,
        &quot;label&quot;: &quot;Kiribati&quot;
    },
    {
        &quot;value&quot;: &quot;XK&quot;,
        &quot;label&quot;: &quot;Kosovo&quot;
    },
    {
        &quot;value&quot;: &quot;KW&quot;,
        &quot;label&quot;: &quot;Kuwait&quot;
    },
    {
        &quot;value&quot;: &quot;KG&quot;,
        &quot;label&quot;: &quot;Kyrgyzstan&quot;
    },
    {
        &quot;value&quot;: &quot;LA&quot;,
        &quot;label&quot;: &quot;Laos&quot;
    },
    {
        &quot;value&quot;: &quot;LV&quot;,
        &quot;label&quot;: &quot;Latvia&quot;
    },
    {
        &quot;value&quot;: &quot;LB&quot;,
        &quot;label&quot;: &quot;Lebanon&quot;
    },
    {
        &quot;value&quot;: &quot;LS&quot;,
        &quot;label&quot;: &quot;Lesotho&quot;
    },
    {
        &quot;value&quot;: &quot;LR&quot;,
        &quot;label&quot;: &quot;Liberia&quot;
    },
    {
        &quot;value&quot;: &quot;LY&quot;,
        &quot;label&quot;: &quot;Libya&quot;
    },
    {
        &quot;value&quot;: &quot;LI&quot;,
        &quot;label&quot;: &quot;Liechtenstein&quot;
    },
    {
        &quot;value&quot;: &quot;LT&quot;,
        &quot;label&quot;: &quot;Lithuania&quot;
    },
    {
        &quot;value&quot;: &quot;LU&quot;,
        &quot;label&quot;: &quot;Luxembourg&quot;
    },
    {
        &quot;value&quot;: &quot;MG&quot;,
        &quot;label&quot;: &quot;Madagascar&quot;
    },
    {
        &quot;value&quot;: &quot;MW&quot;,
        &quot;label&quot;: &quot;Malawi&quot;
    },
    {
        &quot;value&quot;: &quot;MY&quot;,
        &quot;label&quot;: &quot;Malaysia&quot;
    },
    {
        &quot;value&quot;: &quot;MV&quot;,
        &quot;label&quot;: &quot;Maldives&quot;
    },
    {
        &quot;value&quot;: &quot;ML&quot;,
        &quot;label&quot;: &quot;Mali&quot;
    },
    {
        &quot;value&quot;: &quot;MT&quot;,
        &quot;label&quot;: &quot;Malta&quot;
    },
    {
        &quot;value&quot;: &quot;MH&quot;,
        &quot;label&quot;: &quot;Marshall Islands&quot;
    },
    {
        &quot;value&quot;: &quot;MR&quot;,
        &quot;label&quot;: &quot;Mauritania&quot;
    },
    {
        &quot;value&quot;: &quot;MU&quot;,
        &quot;label&quot;: &quot;Mauritius&quot;
    },
    {
        &quot;value&quot;: &quot;MX&quot;,
        &quot;label&quot;: &quot;Mexico&quot;
    },
    {
        &quot;value&quot;: &quot;FM&quot;,
        &quot;label&quot;: &quot;Micronesia&quot;
    },
    {
        &quot;value&quot;: &quot;MD&quot;,
        &quot;label&quot;: &quot;Moldova&quot;
    },
    {
        &quot;value&quot;: &quot;MC&quot;,
        &quot;label&quot;: &quot;Monaco&quot;
    },
    {
        &quot;value&quot;: &quot;MN&quot;,
        &quot;label&quot;: &quot;Mongolia&quot;
    },
    {
        &quot;value&quot;: &quot;ME&quot;,
        &quot;label&quot;: &quot;Montenegro&quot;
    },
    {
        &quot;value&quot;: &quot;MA&quot;,
        &quot;label&quot;: &quot;Morocco&quot;
    },
    {
        &quot;value&quot;: &quot;MZ&quot;,
        &quot;label&quot;: &quot;Mozambique&quot;
    },
    {
        &quot;value&quot;: &quot;MM&quot;,
        &quot;label&quot;: &quot;Myanmar&quot;
    },
    {
        &quot;value&quot;: &quot;NA&quot;,
        &quot;label&quot;: &quot;Namibia&quot;
    },
    {
        &quot;value&quot;: &quot;NR&quot;,
        &quot;label&quot;: &quot;Nauru&quot;
    },
    {
        &quot;value&quot;: &quot;NP&quot;,
        &quot;label&quot;: &quot;Nepal&quot;
    },
    {
        &quot;value&quot;: &quot;NL&quot;,
        &quot;label&quot;: &quot;Netherlands&quot;
    },
    {
        &quot;value&quot;: &quot;NZ&quot;,
        &quot;label&quot;: &quot;New Zealand&quot;
    },
    {
        &quot;value&quot;: &quot;NI&quot;,
        &quot;label&quot;: &quot;Nicaragua&quot;
    },
    {
        &quot;value&quot;: &quot;NE&quot;,
        &quot;label&quot;: &quot;Niger&quot;
    },
    {
        &quot;value&quot;: &quot;NG&quot;,
        &quot;label&quot;: &quot;Nigeria&quot;
    },
    {
        &quot;value&quot;: &quot;KP&quot;,
        &quot;label&quot;: &quot;North Korea&quot;
    },
    {
        &quot;value&quot;: &quot;MK&quot;,
        &quot;label&quot;: &quot;North Macedonia&quot;
    },
    {
        &quot;value&quot;: &quot;NO&quot;,
        &quot;label&quot;: &quot;Norway&quot;
    },
    {
        &quot;value&quot;: &quot;OM&quot;,
        &quot;label&quot;: &quot;Oman&quot;
    },
    {
        &quot;value&quot;: &quot;PK&quot;,
        &quot;label&quot;: &quot;Pakistan&quot;
    },
    {
        &quot;value&quot;: &quot;PW&quot;,
        &quot;label&quot;: &quot;Palau&quot;
    },
    {
        &quot;value&quot;: &quot;PS&quot;,
        &quot;label&quot;: &quot;Palestine&quot;
    },
    {
        &quot;value&quot;: &quot;PA&quot;,
        &quot;label&quot;: &quot;Panama&quot;
    },
    {
        &quot;value&quot;: &quot;PG&quot;,
        &quot;label&quot;: &quot;Papua New Guinea&quot;
    },
    {
        &quot;value&quot;: &quot;PY&quot;,
        &quot;label&quot;: &quot;Paraguay&quot;
    },
    {
        &quot;value&quot;: &quot;PE&quot;,
        &quot;label&quot;: &quot;Peru&quot;
    },
    {
        &quot;value&quot;: &quot;PH&quot;,
        &quot;label&quot;: &quot;Philippines&quot;
    },
    {
        &quot;value&quot;: &quot;PL&quot;,
        &quot;label&quot;: &quot;Poland&quot;
    },
    {
        &quot;value&quot;: &quot;PT&quot;,
        &quot;label&quot;: &quot;Portugal&quot;
    },
    {
        &quot;value&quot;: &quot;QA&quot;,
        &quot;label&quot;: &quot;Qatar&quot;
    },
    {
        &quot;value&quot;: &quot;RO&quot;,
        &quot;label&quot;: &quot;Romania&quot;
    },
    {
        &quot;value&quot;: &quot;RU&quot;,
        &quot;label&quot;: &quot;Russia&quot;
    },
    {
        &quot;value&quot;: &quot;RW&quot;,
        &quot;label&quot;: &quot;Rwanda&quot;
    },
    {
        &quot;value&quot;: &quot;KN&quot;,
        &quot;label&quot;: &quot;Saint Kitts and Nevis&quot;
    },
    {
        &quot;value&quot;: &quot;LC&quot;,
        &quot;label&quot;: &quot;Saint Lucia&quot;
    },
    {
        &quot;value&quot;: &quot;VC&quot;,
        &quot;label&quot;: &quot;Saint Vincent and the Grenadines&quot;
    },
    {
        &quot;value&quot;: &quot;WS&quot;,
        &quot;label&quot;: &quot;Samoa&quot;
    },
    {
        &quot;value&quot;: &quot;SM&quot;,
        &quot;label&quot;: &quot;San Marino&quot;
    },
    {
        &quot;value&quot;: &quot;ST&quot;,
        &quot;label&quot;: &quot;S&atilde;o Tom&eacute; and Pr&iacute;ncipe&quot;
    },
    {
        &quot;value&quot;: &quot;SA&quot;,
        &quot;label&quot;: &quot;Saudi Arabia&quot;
    },
    {
        &quot;value&quot;: &quot;SN&quot;,
        &quot;label&quot;: &quot;Senegal&quot;
    },
    {
        &quot;value&quot;: &quot;RS&quot;,
        &quot;label&quot;: &quot;Serbia&quot;
    },
    {
        &quot;value&quot;: &quot;SC&quot;,
        &quot;label&quot;: &quot;Seychelles&quot;
    },
    {
        &quot;value&quot;: &quot;SL&quot;,
        &quot;label&quot;: &quot;Sierra Leone&quot;
    },
    {
        &quot;value&quot;: &quot;SG&quot;,
        &quot;label&quot;: &quot;Singapore&quot;
    },
    {
        &quot;value&quot;: &quot;SK&quot;,
        &quot;label&quot;: &quot;Slovakia&quot;
    },
    {
        &quot;value&quot;: &quot;SI&quot;,
        &quot;label&quot;: &quot;Slovenia&quot;
    },
    {
        &quot;value&quot;: &quot;SB&quot;,
        &quot;label&quot;: &quot;Solomon Islands&quot;
    },
    {
        &quot;value&quot;: &quot;SO&quot;,
        &quot;label&quot;: &quot;Somalia&quot;
    },
    {
        &quot;value&quot;: &quot;ZA&quot;,
        &quot;label&quot;: &quot;South Africa&quot;
    },
    {
        &quot;value&quot;: &quot;KR&quot;,
        &quot;label&quot;: &quot;South Korea&quot;
    },
    {
        &quot;value&quot;: &quot;SS&quot;,
        &quot;label&quot;: &quot;South Sudan&quot;
    },
    {
        &quot;value&quot;: &quot;ES&quot;,
        &quot;label&quot;: &quot;Spain&quot;
    },
    {
        &quot;value&quot;: &quot;LK&quot;,
        &quot;label&quot;: &quot;Sri Lanka&quot;
    },
    {
        &quot;value&quot;: &quot;SD&quot;,
        &quot;label&quot;: &quot;Sudan&quot;
    },
    {
        &quot;value&quot;: &quot;SR&quot;,
        &quot;label&quot;: &quot;Suriname&quot;
    },
    {
        &quot;value&quot;: &quot;SE&quot;,
        &quot;label&quot;: &quot;Sweden&quot;
    },
    {
        &quot;value&quot;: &quot;CH&quot;,
        &quot;label&quot;: &quot;Switzerland&quot;
    },
    {
        &quot;value&quot;: &quot;SY&quot;,
        &quot;label&quot;: &quot;Syria&quot;
    },
    {
        &quot;value&quot;: &quot;TW&quot;,
        &quot;label&quot;: &quot;Taiwan&quot;
    },
    {
        &quot;value&quot;: &quot;TJ&quot;,
        &quot;label&quot;: &quot;Tajikistan&quot;
    },
    {
        &quot;value&quot;: &quot;TZ&quot;,
        &quot;label&quot;: &quot;Tanzania&quot;
    },
    {
        &quot;value&quot;: &quot;TH&quot;,
        &quot;label&quot;: &quot;Thailand&quot;
    },
    {
        &quot;value&quot;: &quot;TL&quot;,
        &quot;label&quot;: &quot;Timor-Leste&quot;
    },
    {
        &quot;value&quot;: &quot;TG&quot;,
        &quot;label&quot;: &quot;Togo&quot;
    },
    {
        &quot;value&quot;: &quot;TO&quot;,
        &quot;label&quot;: &quot;Tonga&quot;
    },
    {
        &quot;value&quot;: &quot;TT&quot;,
        &quot;label&quot;: &quot;Trinidad and Tobago&quot;
    },
    {
        &quot;value&quot;: &quot;TN&quot;,
        &quot;label&quot;: &quot;Tunisia&quot;
    },
    {
        &quot;value&quot;: &quot;TR&quot;,
        &quot;label&quot;: &quot;Turkey&quot;
    },
    {
        &quot;value&quot;: &quot;TM&quot;,
        &quot;label&quot;: &quot;Turkmenistan&quot;
    },
    {
        &quot;value&quot;: &quot;TV&quot;,
        &quot;label&quot;: &quot;Tuvalu&quot;
    },
    {
        &quot;value&quot;: &quot;UG&quot;,
        &quot;label&quot;: &quot;Uganda&quot;
    },
    {
        &quot;value&quot;: &quot;UA&quot;,
        &quot;label&quot;: &quot;Ukraine&quot;
    },
    {
        &quot;value&quot;: &quot;AE&quot;,
        &quot;label&quot;: &quot;United Arab Emirates&quot;
    },
    {
        &quot;value&quot;: &quot;GB&quot;,
        &quot;label&quot;: &quot;United Kingdom&quot;
    },
    {
        &quot;value&quot;: &quot;US&quot;,
        &quot;label&quot;: &quot;United States&quot;
    },
    {
        &quot;value&quot;: &quot;UY&quot;,
        &quot;label&quot;: &quot;Uruguay&quot;
    },
    {
        &quot;value&quot;: &quot;UZ&quot;,
        &quot;label&quot;: &quot;Uzbekistan&quot;
    },
    {
        &quot;value&quot;: &quot;VU&quot;,
        &quot;label&quot;: &quot;Vanuatu&quot;
    },
    {
        &quot;value&quot;: &quot;VA&quot;,
        &quot;label&quot;: &quot;Vatican City&quot;
    },
    {
        &quot;value&quot;: &quot;VE&quot;,
        &quot;label&quot;: &quot;Venezuela&quot;
    },
    {
        &quot;value&quot;: &quot;VN&quot;,
        &quot;label&quot;: &quot;Vietnam&quot;
    },
    {
        &quot;value&quot;: &quot;YE&quot;,
        &quot;label&quot;: &quot;Yemen&quot;
    },
    {
        &quot;value&quot;: &quot;ZM&quot;,
        &quot;label&quot;: &quot;Zambia&quot;
    },
    {
        &quot;value&quot;: &quot;ZW&quot;,
        &quot;label&quot;: &quot;Zimbabwe&quot;
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-settings-countries" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-settings-countries"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-settings-countries"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-settings-countries" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-settings-countries">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-settings-countries" data-method="GET"
      data-path="api/settings/countries"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-settings-countries', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-settings-countries"
                    onclick="tryItOut('GETapi-settings-countries');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-settings-countries"
                    onclick="cancelTryOut('GETapi-settings-countries');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-settings-countries"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/settings/countries</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-settings-countries"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-settings-countries"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="settings-GETapi-settings-countries--code-">Return a single country by its ISO 3166-1 alpha-2 code.</h2>

<p>
</p>

<p>Pass <code>?lang=fi</code> to receive the label in Finnish (default: <code>en</code>).</p>

<span id="example-requests-GETapi-settings-countries--code-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/settings/countries/FI" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/settings/countries/FI"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-settings-countries--code-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 48
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;value&quot;: &quot;FI&quot;,
    &quot;label&quot;: &quot;Finland&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-settings-countries--code-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-settings-countries--code-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-settings-countries--code-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-settings-countries--code-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-settings-countries--code-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-settings-countries--code-" data-method="GET"
      data-path="api/settings/countries/{code}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-settings-countries--code-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-settings-countries--code-"
                    onclick="tryItOut('GETapi-settings-countries--code-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-settings-countries--code-"
                    onclick="cancelTryOut('GETapi-settings-countries--code-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-settings-countries--code-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/settings/countries/{code}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-settings-countries--code-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-settings-countries--code-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-settings-countries--code-"
               value="FI"
               data-component="url">
    <br>
<p>The ISO 3166-1 alpha-2 country code. Example: <code>FI</code></p>
            </div>
                    </form>

                <h1 id="tax-rates">Tax Rates</h1>

    

                                <h2 id="tax-rates-GETapi-settings-taxrates">Return all available tax rates with translated country names.</h2>

<p>
</p>



<span id="example-requests-GETapi-settings-taxrates">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/settings/taxrates?lang=fi" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/settings/taxrates"
);

const params = {
    "lang": "fi",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-settings-taxrates">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 36
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;code&quot;: &quot;ZERO&quot;,
        &quot;label&quot;: &quot;Veroton (0%)&quot;,
        &quot;rate&quot;: 0
    },
    {
        &quot;code&quot;: &quot;AT&quot;,
        &quot;label&quot;: &quot;It&auml;valta&quot;,
        &quot;rate&quot;: 0.2
    },
    {
        &quot;code&quot;: &quot;BE&quot;,
        &quot;label&quot;: &quot;Belgia&quot;,
        &quot;rate&quot;: 0.21
    },
    {
        &quot;code&quot;: &quot;BG&quot;,
        &quot;label&quot;: &quot;Bulgaria&quot;,
        &quot;rate&quot;: 0.2
    },
    {
        &quot;code&quot;: &quot;HR&quot;,
        &quot;label&quot;: &quot;Kroatia&quot;,
        &quot;rate&quot;: 0.25
    },
    {
        &quot;code&quot;: &quot;CY&quot;,
        &quot;label&quot;: &quot;Kypros&quot;,
        &quot;rate&quot;: 0.19
    },
    {
        &quot;code&quot;: &quot;CZ&quot;,
        &quot;label&quot;: &quot;T&scaron;ekki&quot;,
        &quot;rate&quot;: 0.21
    },
    {
        &quot;code&quot;: &quot;DK&quot;,
        &quot;label&quot;: &quot;Tanska&quot;,
        &quot;rate&quot;: 0.25
    },
    {
        &quot;code&quot;: &quot;EE&quot;,
        &quot;label&quot;: &quot;Viro&quot;,
        &quot;rate&quot;: 0.24
    },
    {
        &quot;code&quot;: &quot;FI&quot;,
        &quot;label&quot;: &quot;Suomi&quot;,
        &quot;rate&quot;: 0.255
    },
    {
        &quot;code&quot;: &quot;FR&quot;,
        &quot;label&quot;: &quot;Ranska&quot;,
        &quot;rate&quot;: 0.2
    },
    {
        &quot;code&quot;: &quot;DE&quot;,
        &quot;label&quot;: &quot;Saksa&quot;,
        &quot;rate&quot;: 0.19
    },
    {
        &quot;code&quot;: &quot;GR&quot;,
        &quot;label&quot;: &quot;Kreikka&quot;,
        &quot;rate&quot;: 0.24
    },
    {
        &quot;code&quot;: &quot;HU&quot;,
        &quot;label&quot;: &quot;Unkari&quot;,
        &quot;rate&quot;: 0.27
    },
    {
        &quot;code&quot;: &quot;IE&quot;,
        &quot;label&quot;: &quot;Irlanti&quot;,
        &quot;rate&quot;: 0.23
    },
    {
        &quot;code&quot;: &quot;IT&quot;,
        &quot;label&quot;: &quot;Italia&quot;,
        &quot;rate&quot;: 0.22
    },
    {
        &quot;code&quot;: &quot;LV&quot;,
        &quot;label&quot;: &quot;Latvia&quot;,
        &quot;rate&quot;: 0.21
    },
    {
        &quot;code&quot;: &quot;LT&quot;,
        &quot;label&quot;: &quot;Liettua&quot;,
        &quot;rate&quot;: 0.21
    },
    {
        &quot;code&quot;: &quot;LU&quot;,
        &quot;label&quot;: &quot;Luxemburg&quot;,
        &quot;rate&quot;: 0.17
    },
    {
        &quot;code&quot;: &quot;MT&quot;,
        &quot;label&quot;: &quot;Malta&quot;,
        &quot;rate&quot;: 0.18
    },
    {
        &quot;code&quot;: &quot;NL&quot;,
        &quot;label&quot;: &quot;Alankomaat&quot;,
        &quot;rate&quot;: 0.21
    },
    {
        &quot;code&quot;: &quot;PL&quot;,
        &quot;label&quot;: &quot;Puola&quot;,
        &quot;rate&quot;: 0.23
    },
    {
        &quot;code&quot;: &quot;PT&quot;,
        &quot;label&quot;: &quot;Portugali&quot;,
        &quot;rate&quot;: 0.23
    },
    {
        &quot;code&quot;: &quot;RO&quot;,
        &quot;label&quot;: &quot;Romania&quot;,
        &quot;rate&quot;: 0.19
    },
    {
        &quot;code&quot;: &quot;SK&quot;,
        &quot;label&quot;: &quot;Slovakia&quot;,
        &quot;rate&quot;: 0.2
    },
    {
        &quot;code&quot;: &quot;SI&quot;,
        &quot;label&quot;: &quot;Slovenia&quot;,
        &quot;rate&quot;: 0.22
    },
    {
        &quot;code&quot;: &quot;ES&quot;,
        &quot;label&quot;: &quot;Espanja&quot;,
        &quot;rate&quot;: 0.21
    },
    {
        &quot;code&quot;: &quot;SE&quot;,
        &quot;label&quot;: &quot;Ruotsi&quot;,
        &quot;rate&quot;: 0.25
    },
    {
        &quot;code&quot;: &quot;UK&quot;,
        &quot;label&quot;: &quot;Yhdistynyt kuningaskunta&quot;,
        &quot;rate&quot;: 0.2
    },
    {
        &quot;code&quot;: &quot;NO&quot;,
        &quot;label&quot;: &quot;Norja&quot;,
        &quot;rate&quot;: 0.25
    },
    {
        &quot;code&quot;: &quot;CH&quot;,
        &quot;label&quot;: &quot;Sveitsi&quot;,
        &quot;rate&quot;: 0.081
    },
    {
        &quot;code&quot;: &quot;AR&quot;,
        &quot;label&quot;: &quot;Argentiina&quot;,
        &quot;rate&quot;: 0.21
    },
    {
        &quot;code&quot;: &quot;BR&quot;,
        &quot;label&quot;: &quot;Brasilia&quot;,
        &quot;rate&quot;: 0.17
    },
    {
        &quot;code&quot;: &quot;CA&quot;,
        &quot;label&quot;: &quot;Kanada&quot;,
        &quot;rate&quot;: 0.05
    },
    {
        &quot;code&quot;: &quot;MX&quot;,
        &quot;label&quot;: &quot;Meksiko&quot;,
        &quot;rate&quot;: 0.16
    },
    {
        &quot;code&quot;: &quot;AU&quot;,
        &quot;label&quot;: &quot;Australia&quot;,
        &quot;rate&quot;: 0.1
    },
    {
        &quot;code&quot;: &quot;CN&quot;,
        &quot;label&quot;: &quot;Kiina&quot;,
        &quot;rate&quot;: 0.13
    },
    {
        &quot;code&quot;: &quot;ID&quot;,
        &quot;label&quot;: &quot;Indonesia&quot;,
        &quot;rate&quot;: 0.11
    },
    {
        &quot;code&quot;: &quot;IN&quot;,
        &quot;label&quot;: &quot;Intia&quot;,
        &quot;rate&quot;: 0.18
    },
    {
        &quot;code&quot;: &quot;JP&quot;,
        &quot;label&quot;: &quot;Japani&quot;,
        &quot;rate&quot;: 0.1
    },
    {
        &quot;code&quot;: &quot;KR&quot;,
        &quot;label&quot;: &quot;Etel&auml;-Korea&quot;,
        &quot;rate&quot;: 0.1
    },
    {
        &quot;code&quot;: &quot;NZ&quot;,
        &quot;label&quot;: &quot;Uusi-Seelanti&quot;,
        &quot;rate&quot;: 0.15
    },
    {
        &quot;code&quot;: &quot;PH&quot;,
        &quot;label&quot;: &quot;Filippiinit&quot;,
        &quot;rate&quot;: 0.12
    },
    {
        &quot;code&quot;: &quot;SG&quot;,
        &quot;label&quot;: &quot;Singapore&quot;,
        &quot;rate&quot;: 0.09
    },
    {
        &quot;code&quot;: &quot;TH&quot;,
        &quot;label&quot;: &quot;Thaimaa&quot;,
        &quot;rate&quot;: 0.07
    },
    {
        &quot;code&quot;: &quot;AE&quot;,
        &quot;label&quot;: &quot;Yhdistyneet arabiemiirikunnat&quot;,
        &quot;rate&quot;: 0.05
    },
    {
        &quot;code&quot;: &quot;IL&quot;,
        &quot;label&quot;: &quot;Israel&quot;,
        &quot;rate&quot;: 0.17
    },
    {
        &quot;code&quot;: &quot;SA&quot;,
        &quot;label&quot;: &quot;Saudi-Arabia&quot;,
        &quot;rate&quot;: 0.15
    },
    {
        &quot;code&quot;: &quot;EG&quot;,
        &quot;label&quot;: &quot;Egypti&quot;,
        &quot;rate&quot;: 0.14
    },
    {
        &quot;code&quot;: &quot;GH&quot;,
        &quot;label&quot;: &quot;Ghana&quot;,
        &quot;rate&quot;: 0.15
    },
    {
        &quot;code&quot;: &quot;KE&quot;,
        &quot;label&quot;: &quot;Kenia&quot;,
        &quot;rate&quot;: 0.16
    },
    {
        &quot;code&quot;: &quot;NG&quot;,
        &quot;label&quot;: &quot;Nigeria&quot;,
        &quot;rate&quot;: 0.075
    },
    {
        &quot;code&quot;: &quot;ZA&quot;,
        &quot;label&quot;: &quot;Etel&auml;-Afrikka&quot;,
        &quot;rate&quot;: 0.15
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-settings-taxrates" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-settings-taxrates"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-settings-taxrates"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-settings-taxrates" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-settings-taxrates">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-settings-taxrates" data-method="GET"
      data-path="api/settings/taxrates"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-settings-taxrates', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-settings-taxrates"
                    onclick="tryItOut('GETapi-settings-taxrates');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-settings-taxrates"
                    onclick="cancelTryOut('GETapi-settings-taxrates');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-settings-taxrates"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/settings/taxrates</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-settings-taxrates"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-settings-taxrates"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>lang</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lang"                data-endpoint="GETapi-settings-taxrates"
               value="fi"
               data-component="query">
    <br>
<p>Language code for country name translation (en, fi). Defaults to en. Example: <code>fi</code></p>
            </div>
                </form>

                    <h2 id="tax-rates-GETapi-settings-taxrates--code-">Return the tax rate for a specific country code.</h2>

<p>
</p>



<span id="example-requests-GETapi-settings-taxrates--code-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/settings/taxrates/FI?lang=fi" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/settings/taxrates/FI"
);

const params = {
    "lang": "fi",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-settings-taxrates--code-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 35
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;code&quot;: &quot;FI&quot;,
    &quot;label&quot;: &quot;Suomi&quot;,
    &quot;rate&quot;: 0.255
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-settings-taxrates--code-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-settings-taxrates--code-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-settings-taxrates--code-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-settings-taxrates--code-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-settings-taxrates--code-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-settings-taxrates--code-" data-method="GET"
      data-path="api/settings/taxrates/{code}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-settings-taxrates--code-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-settings-taxrates--code-"
                    onclick="tryItOut('GETapi-settings-taxrates--code-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-settings-taxrates--code-"
                    onclick="cancelTryOut('GETapi-settings-taxrates--code-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-settings-taxrates--code-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/settings/taxrates/{code}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-settings-taxrates--code-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-settings-taxrates--code-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-settings-taxrates--code-"
               value="FI"
               data-component="url">
    <br>
<p>ISO 3166-1 alpha-2 country code (or ZERO). Example: <code>FI</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>lang</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="lang"                data-endpoint="GETapi-settings-taxrates--code-"
               value="fi"
               data-component="query">
    <br>
<p>Language code for country name translation (en, fi). Defaults to en. Example: <code>fi</code></p>
            </div>
                </form>

                <h1 id="uploads">Uploads</h1>

    

                                <h2 id="uploads-POSTapi-upload-test">Upload test file.</h2>

<p>
</p>



<span id="example-requests-POSTapi-upload-test">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/upload-test" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "file=@/tmp/phpenOobC" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/upload-test"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('file', document.querySelector('input[name="file"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-upload-test">
</span>
<span id="execution-results-POSTapi-upload-test" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-upload-test"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-upload-test"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-upload-test" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-upload-test">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-upload-test" data-method="POST"
      data-path="api/upload-test"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-upload-test', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-upload-test"
                    onclick="tryItOut('POSTapi-upload-test');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-upload-test"
                    onclick="cancelTryOut('POSTapi-upload-test');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-upload-test"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/upload-test</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-upload-test"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-upload-test"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>file</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="file"                data-endpoint="POSTapi-upload-test"
               value=""
               data-component="body">
    <br>
<p>Image file to upload. Example: <code>/tmp/phpenOobC</code></p>
        </div>
        </form>

                <h1 id="users">Users</h1>

    

                                <h2 id="users-GETapi-users-roles">Get all available roles.</h2>

<p>
</p>



<span id="example-requests-GETapi-users-roles">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/users/roles" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/users/roles"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-users-roles">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 53
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;id&quot;: 1,
        &quot;key&quot;: &quot;admin&quot;,
        &quot;label&quot;: &quot;Admin&quot;
    },
    {
        &quot;id&quot;: 3,
        &quot;key&quot;: &quot;customer&quot;,
        &quot;label&quot;: &quot;Customer&quot;
    },
    {
        &quot;id&quot;: 2,
        &quot;key&quot;: &quot;vendor&quot;,
        &quot;label&quot;: &quot;Vendor&quot;
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-users-roles" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-users-roles"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users-roles"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-users-roles" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users-roles">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-users-roles" data-method="GET"
      data-path="api/users/roles"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-users-roles', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-users-roles"
                    onclick="tryItOut('GETapi-users-roles');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-users-roles"
                    onclick="cancelTryOut('GETapi-users-roles');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-users-roles"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/users/roles</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-users-roles"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-users-roles"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="users-GETapi-users">List users.</h2>

<p>
</p>



<span id="example-requests-GETapi-users">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/users" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-users">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 52
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;id&quot;: 1,
        &quot;first_name&quot;: &quot;Super&quot;,
        &quot;last_name&quot;: &quot;Admin&quot;,
        &quot;username&quot;: &quot;superadmin&quot;,
        &quot;name&quot;: &quot;superadmin&quot;,
        &quot;email&quot;: &quot;juzapala+superadmin@gmail.com&quot;,
        &quot;roles&quot;: [
            &quot;admin&quot;
        ]
    },
    {
        &quot;id&quot;: 2,
        &quot;first_name&quot;: &quot;Jussi&quot;,
        &quot;last_name&quot;: &quot;Alanen&quot;,
        &quot;username&quot;: &quot;juzapala&quot;,
        &quot;name&quot;: &quot;Jussi Alanen&quot;,
        &quot;email&quot;: &quot;juzapala@gmail.com&quot;,
        &quot;roles&quot;: [
            &quot;customer&quot;
        ]
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-users" data-method="GET"
      data-path="api/users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-users"
                    onclick="tryItOut('GETapi-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-users"
                    onclick="cancelTryOut('GETapi-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-users"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/users</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="users-POSTapi-users">Create a new user.</h2>

<p>
</p>



<span id="example-requests-POSTapi-users">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/users" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"first_name\": \"Jussi\",
    \"last_name\": \"Palanen\",
    \"username\": \"jussi\",
    \"email\": \"jussi@example.com\",
    \"password\": \"strongpassword\",
    \"roles\": [
        \"admin\",
        \"vendor\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "Jussi",
    "last_name": "Palanen",
    "username": "jussi",
    "email": "jussi@example.com",
    "password": "strongpassword",
    "roles": [
        "admin",
        "vendor"
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-users">
</span>
<span id="execution-results-POSTapi-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-users" data-method="POST"
      data-path="api/users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-users"
                    onclick="tryItOut('POSTapi-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-users"
                    onclick="cancelTryOut('POSTapi-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-users"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/users</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="first_name"                data-endpoint="POSTapi-users"
               value="Jussi"
               data-component="body">
    <br>
<p>First name. Example: <code>Jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="last_name"                data-endpoint="POSTapi-users"
               value="Palanen"
               data-component="body">
    <br>
<p>Last name. Example: <code>Palanen</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>username</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="username"                data-endpoint="POSTapi-users"
               value="jussi"
               data-component="body">
    <br>
<p>Username. Example: <code>jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-users"
               value="jussi@example.com"
               data-component="body">
    <br>
<p>Email address. Example: <code>jussi@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-users"
               value="strongpassword"
               data-component="body">
    <br>
<p>Password. Example: <code>strongpassword</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>roles</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="roles[0]"                data-endpoint="POSTapi-users"
               data-component="body">
        <input type="text" style="display: none"
               name="roles[1]"                data-endpoint="POSTapi-users"
               data-component="body">
    <br>
<p>Role names to assign.</p>
        </div>
        </form>

                    <h2 id="users-GETapi-users--id-">Get a single user.</h2>

<p>
</p>



<span id="example-requests-GETapi-users--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/users/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/users/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-users--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 51
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;first_name&quot;: &quot;Super&quot;,
    &quot;last_name&quot;: &quot;Admin&quot;,
    &quot;username&quot;: &quot;superadmin&quot;,
    &quot;name&quot;: &quot;superadmin&quot;,
    &quot;email&quot;: &quot;juzapala+superadmin@gmail.com&quot;,
    &quot;roles&quot;: [
        &quot;admin&quot;
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-users--id-" data-method="GET"
      data-path="api/users/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-users--id-"
                    onclick="tryItOut('GETapi-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-users--id-"
                    onclick="cancelTryOut('GETapi-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-users--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/users/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-users--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the user. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="users-PUTapi-users--id-">Update a user.</h2>

<p>
</p>



<span id="example-requests-PUTapi-users--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "https://backend-laravel.dev.jussialanen.com/api/users/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"first_name\": \"Jussi\",
    \"last_name\": \"Palanen\",
    \"username\": \"jussi\",
    \"email\": \"jussi@example.com\",
    \"password\": \"newpassword\",
    \"current_password\": \"consequatur\",
    \"roles\": [
        \"admin\",
        \"vendor\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/users/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "first_name": "Jussi",
    "last_name": "Palanen",
    "username": "jussi",
    "email": "jussi@example.com",
    "password": "newpassword",
    "current_password": "consequatur",
    "roles": [
        "admin",
        "vendor"
    ]
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-users--id-">
</span>
<span id="execution-results-PUTapi-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-users--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-users--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-users--id-" data-method="PUT"
      data-path="api/users/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-users--id-"
                    onclick="tryItOut('PUTapi-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-users--id-"
                    onclick="cancelTryOut('PUTapi-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-users--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/users/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-users--id-"
               value="1"
               data-component="url">
    <br>
<p>User ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>first_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="first_name"                data-endpoint="PUTapi-users--id-"
               value="Jussi"
               data-component="body">
    <br>
<p>First name. Example: <code>Jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>last_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="last_name"                data-endpoint="PUTapi-users--id-"
               value="Palanen"
               data-component="body">
    <br>
<p>Last name. Example: <code>Palanen</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>username</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="username"                data-endpoint="PUTapi-users--id-"
               value="jussi"
               data-component="body">
    <br>
<p>Username. Example: <code>jussi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="PUTapi-users--id-"
               value="jussi@example.com"
               data-component="body">
    <br>
<p>Email address. Example: <code>jussi@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="PUTapi-users--id-"
               value="newpassword"
               data-component="body">
    <br>
<p>Password. Example: <code>newpassword</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>current_password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="current_password"                data-endpoint="PUTapi-users--id-"
               value="consequatur"
               data-component="body">
    <br>
<p>Required when updating your own password (non-admin). Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>roles</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="roles[0]"                data-endpoint="PUTapi-users--id-"
               data-component="body">
        <input type="text" style="display: none"
               name="roles[1]"                data-endpoint="PUTapi-users--id-"
               data-component="body">
    <br>
<p>Role names to assign.</p>
        </div>
        </form>

                    <h2 id="users-DELETEapi-users--id-">Delete a user.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Admins can delete any user. A regular user can only delete their own account
and must confirm with their current password (not required for OAuth-only accounts).</p>

<span id="example-requests-DELETEapi-users--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "https://backend-laravel.dev.jussialanen.com/api/users/1" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"password\": \"O[2UZ5ij-e\\/dl4m{o,\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/users/1"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "password": "O[2UZ5ij-e\/dl4m{o,"
};

fetch(url, {
    method: "DELETE",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-users--id-">
</span>
<span id="execution-results-DELETEapi-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-users--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-users--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-users--id-" data-method="DELETE"
      data-path="api/users/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-users--id-"
                    onclick="tryItOut('DELETEapi-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-users--id-"
                    onclick="cancelTryOut('DELETEapi-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-users--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/users/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-users--id-"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-users--id-"
               value="1"
               data-component="url">
    <br>
<p>User ID. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="DELETEapi-users--id-"
               value="O[2UZ5ij-e/dl4m{o,"
               data-component="body">
    <br>
<p>Current password (required when deleting own account and account has a password). Example: <code>O[2UZ5ij-e/dl4m{o,</code></p>
        </div>
        </form>

                <h1 id="visitors">Visitors</h1>

    

                                <h2 id="visitors-POSTapi-visitors-track">Track a site visit.</h2>

<p>
</p>



<span id="example-requests-POSTapi-visitors-track">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "https://backend-laravel.dev.jussialanen.com/api/visitors/track" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/visitors/track"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-visitors-track">
</span>
<span id="execution-results-POSTapi-visitors-track" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-visitors-track"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-visitors-track"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-visitors-track" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-visitors-track">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-visitors-track" data-method="POST"
      data-path="api/visitors/track"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-visitors-track', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-visitors-track"
                    onclick="tryItOut('POSTapi-visitors-track');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-visitors-track"
                    onclick="cancelTryOut('POSTapi-visitors-track');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-visitors-track"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/visitors/track</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-visitors-track"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-visitors-track"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="visitors-GETapi-visitors-today">Count unique visitors for today.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-visitors-today">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/visitors/today" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/visitors/today"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-visitors-today">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 47
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;visitors&quot;: 1
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-visitors-today" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-visitors-today"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-visitors-today"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-visitors-today" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-visitors-today">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-visitors-today" data-method="GET"
      data-path="api/visitors/today"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-visitors-today', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-visitors-today"
                    onclick="tryItOut('GETapi-visitors-today');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-visitors-today"
                    onclick="cancelTryOut('GETapi-visitors-today');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-visitors-today"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/visitors/today</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-visitors-today"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-visitors-today"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-visitors-today"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="visitors-GETapi-visitors-total">Count unique visitors of all time.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-visitors-total">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "https://backend-laravel.dev.jussialanen.com/api/visitors/total" \
    --header "Authorization: Bearer {YOUR_AUTH_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://backend-laravel.dev.jussialanen.com/api/visitors/total"
);

const headers = {
    "Authorization": "Bearer {YOUR_AUTH_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-visitors-total">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 46
x-robots-tag: noindex, nofollow, noarchive, nosnippet
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;visitors&quot;: 1
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-visitors-total" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-visitors-total"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-visitors-total"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-visitors-total" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-visitors-total">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-visitors-total" data-method="GET"
      data-path="api/visitors/total"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-visitors-total', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-visitors-total"
                    onclick="tryItOut('GETapi-visitors-total');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-visitors-total"
                    onclick="cancelTryOut('GETapi-visitors-total');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-visitors-total"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/visitors/total</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-visitors-total"
               value="Bearer {YOUR_AUTH_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_AUTH_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-visitors-total"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-visitors-total"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>

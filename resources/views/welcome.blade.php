<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Jussilog API</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <style>
            *, ::before, ::after { box-sizing: border-box; margin: 0; padding: 0; }

            body {
                font-family: Figtree, sans-serif;
                background-color: #0f172a;
                color: #e2e8f0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
            }

            .card {
                background-color: #1e293b;
                border: 1px solid #334155;
                border-radius: 1rem;
                padding: 2.5rem 2rem;
                max-width: 520px;
                width: 100%;
                text-align: center;
            }

            @media (min-width: 480px) {
                body { padding: 2rem; }
                .card { padding: 3rem 2.5rem; }
            }

            .logo {
                height: 3.5rem;
                width: auto;
                margin: 0 auto 1.75rem;
                display: block;
            }

            .title {
                font-size: 2rem;
                font-weight: 600;
                color: #f8fafc;
                margin-bottom: 0.4rem;
                letter-spacing: -0.01em;
            }

            .version {
                display: inline-block;
                font-size: 0.75rem;
                font-weight: 500;
                color: #94a3b8;
                background-color: #0f172a;
                border: 1px solid #334155;
                border-radius: 9999px;
                padding: 0.2rem 0.65rem;
                margin-bottom: 1.25rem;
            }

            .description {
                font-size: 0.95rem;
                color: #94a3b8;
                line-height: 1.65;
                margin-bottom: 2rem;
            }

            .links {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .link {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1rem 1.15rem;
                border-radius: 0.6rem;
                text-decoration: none;
                font-size: 0.9rem;
                font-weight: 500;
                transition: background-color 0.15s, border-color 0.15s;
                min-height: 52px;
                -webkit-tap-highlight-color: transparent;
            }

            /* API Docs — Laravel red */
            .link-docs {
                background-color: #FF2D20;
                color: #fff;
                border: 1px solid #FF2D20;
            }

            .link-docs:hover {
                background-color: #e0261b;
                border-color: #e0261b;
            }

            /* OpenAPI — indigo/blue */
            .link-openapi {
                background-color: #4f46e5;
                color: #fff;
                border: 1px solid #4f46e5;
            }

            .link-openapi:hover {
                background-color: #4338ca;
                border-color: #4338ca;
            }

            /* Postman — orange */
            .link-postman {
                background-color: #FF6C37;
                color: #fff;
                border: 1px solid #FF6C37;
            }

            .link-postman:hover {
                background-color: #e55a27;
                border-color: #e55a27;
            }

            .link-label {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .link-badge {
                font-size: 0.65rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                padding: 0.15rem 0.45rem;
                border-radius: 9999px;
                background-color: rgba(255,255,255,0.15);
                white-space: nowrap;
            }

            .arrow {
                opacity: 0.6;
                font-size: 0.85rem;
                flex-shrink: 0;
                margin-left: 0.5rem;
            }

            .divider {
                border: none;
                border-top: 1px solid #1e293b;
                margin: 0.25rem 0;
            }
        </style>
    </head>
    <body>
        <div class="card">
            <svg viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg" class="logo">
                <path d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7978 61.8897 14.8858V28.5615C61.8898 28.737 61.8434 28.9095 61.7554 29.0614C61.6675 29.2132 61.5409 29.3392 61.3887 29.4265L49.9104 36.0351V49.1337C49.9104 49.4902 49.7209 49.8192 49.4118 49.9987L25.4519 63.7916C25.3971 63.8227 25.3372 63.8427 25.2774 63.8639C25.255 63.8714 25.2338 63.8851 25.2101 63.8913C25.0426 63.9354 24.8666 63.9354 24.6991 63.8913C24.6716 63.8838 24.6467 63.8689 24.6205 63.8589C24.5657 63.8389 24.5084 63.8215 24.456 63.7916L0.501061 49.9987C0.348882 49.9113 0.222437 49.7853 0.134469 49.6334C0.0465019 49.4816 0.000120578 49.3092 0 49.1337L0 8.10652C0 8.01678 0.0124642 7.92953 0.0348998 7.84477C0.0423783 7.8161 0.0598282 7.78993 0.0697995 7.76126C0.0884958 7.70891 0.105946 7.65531 0.133367 7.6067C0.152063 7.5743 0.179485 7.54812 0.20192 7.51821C0.230588 7.47832 0.256763 7.43719 0.290416 7.40229C0.319084 7.37362 0.356476 7.35243 0.388883 7.32751C0.425029 7.29759 0.457436 7.26518 0.498568 7.2415L12.4779 0.345059C12.6296 0.257786 12.8015 0.211853 12.9765 0.211853C13.1515 0.211853 13.3234 0.257786 13.475 0.345059L25.4531 7.2415H25.4556C25.4955 7.26643 25.5292 7.29759 25.5653 7.32626C25.5977 7.35119 25.6339 7.37362 25.6625 7.40104C25.6974 7.43719 25.7224 7.47832 25.7523 7.51821C25.7735 7.54812 25.8021 7.5743 25.8196 7.6067C25.8483 7.65656 25.8645 7.70891 25.8844 7.76126C25.8944 7.78993 25.9118 7.8161 25.9193 7.84602C25.9423 7.93096 25.954 8.01853 25.9542 8.10652V33.7317L35.9355 27.9844V14.8846C35.9355 14.7973 35.948 14.7088 35.9704 14.6253C35.9792 14.5954 35.9954 14.5692 36.0053 14.5405C36.0253 14.4882 36.0427 14.4346 36.0702 14.386C36.0888 14.3536 36.1163 14.3274 36.1375 14.2975C36.1674 14.2576 36.1923 14.2165 36.2272 14.1816C36.2559 14.1529 36.292 14.1317 36.3244 14.1068C36.3618 14.0769 36.3942 14.0445 36.4341 14.0208L48.4147 7.12434C48.5663 7.03694 48.7383 6.99094 48.9133 6.99094C49.0883 6.99094 49.2602 7.03694 49.4118 7.12434L61.3899 14.0208C61.4323 14.0457 61.4647 14.0769 61.5021 14.1055C61.5333 14.1305 61.5694 14.1529 61.5981 14.1803C61.633 14.2165 61.6579 14.2576 61.6878 14.2975C61.7103 14.3274 61.7377 14.3536 61.7551 14.386C61.7838 14.4346 61.8 14.4882 61.8199 14.5405C61.8312 14.5692 61.8474 14.5954 61.8548 14.6253ZM59.893 27.9844V16.6121L55.7013 19.0252L49.9104 22.3593V33.7317L59.8942 27.9844H59.893ZM47.9149 48.5566V37.1768L42.2187 40.4299L25.953 49.7133V61.2003L47.9149 48.5566ZM1.99677 9.83281V48.5566L23.9562 61.199V49.7145L12.4841 43.2219L12.4804 43.2194L12.4754 43.2169C12.4368 43.1945 12.4044 43.1621 12.3682 43.1347C12.3371 43.1097 12.3009 43.0898 12.2735 43.0624L12.271 43.0586C12.2386 43.0275 12.2162 42.9888 12.1887 42.9539C12.1638 42.9203 12.1339 42.8916 12.114 42.8567L12.1127 42.853C12.0903 42.8156 12.0766 42.7707 12.0604 42.7283C12.0442 42.6909 12.023 42.656 12.013 42.6161C12.0005 42.5688 11.998 42.5177 11.9931 42.4691C11.9881 42.4317 11.9781 42.3943 11.9781 42.3569V15.5801L6.18848 12.2446L1.99677 9.83281ZM12.9777 2.36177L2.99764 8.10652L12.9752 13.8513L22.9541 8.10527L12.9752 2.36177H12.9777ZM18.1678 38.2138L23.9574 34.8809V9.83281L19.7657 12.2459L13.9749 15.5801V40.6281L18.1678 38.2138ZM48.9133 9.14105L38.9344 14.8858L48.9133 20.6305L58.8909 14.8846L48.9133 9.14105ZM47.9149 22.3593L42.124 19.0252L37.9323 16.6121V27.9844L43.7219 31.3174L47.9149 33.7317V22.3593ZM24.9533 47.987L39.59 39.631L46.9065 35.4555L36.9352 29.7145L25.4544 36.3242L14.9907 42.3482L24.9533 47.987Z" fill="#FF2D20"/>
            </svg>

            <h1 class="title">Jussilog API</h1>
            <span class="version">v{{ config('app.version', '1.1.2') }}</span>

            <p class="description">
                A RESTful backend API for managing resumes, projects, blog posts, invoices, and orders.
                Built with Laravel and deployed on Google Cloud Run.
            </p>

            <div class="links">
                <a href="/api/docs" class="link link-docs">
                    <span class="link-label">
                        API Documentation
                        <span class="link-badge">Interactive</span>
                    </span>
                    <span class="arrow">→</span>
                </a>
                <a href="/api/docs.openapi" class="link link-openapi">
                    <span class="link-label">
                        OpenAPI Spec
                        <span class="link-badge">YAML</span>
                    </span>
                    <span class="arrow">↓</span>
                </a>
                <a href="/api/docs.postman" class="link link-postman">
                    <span class="link-label">
                        Postman Collection
                        <span class="link-badge">JSON</span>
                    </span>
                    <span class="arrow">↓</span>
                </a>
            </div>
        </div>
    </body>
</html>

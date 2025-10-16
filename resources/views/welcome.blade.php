<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Technical Test Backend API</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .glass-container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 3rem 2.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            margin-bottom: 3rem;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.5rem;
            letter-spacing: -0.03em;
        }

        .subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 400;
        }

        .info-box {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
            border-left: 4px solid #fbbf24;
            color: #fff;
            font-size: 0.9rem;
        }

        .endpoint {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            margin-bottom: 0.75rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .endpoint:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }

        .endpoint-row {
            padding: 1.25rem 1.5rem;
            display: grid;
            grid-template-columns: 70px 1fr auto;
            gap: 1rem;
            align-items: center;
        }

        .method {
            font-weight: 700;
            font-size: 0.7rem;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            letter-spacing: 0.05em;
            text-align: center;
        }

        .method-post {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: #fff;
        }

        .method-get {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: #fff;
        }

        .endpoint-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .endpoint-name {
            font-weight: 600;
            font-size: 0.95rem;
            color: #1f2937;
        }

        .endpoint-url {
            font-family: 'Courier New', monospace;
            font-size: 0.75rem;
            color: #6b7280;
            word-break: break-all;
        }

        .badges {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
        }

        .badge {
            font-size: 0.65rem;
            padding: 0.3rem 0.65rem;
            border-radius: 6px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-key {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #fff;
        }

        .badge-token {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            color: #fff;
        }

        .badge-webhook {
            background: linear-gradient(135deg, #ec4899 0%, #d946ef 100%);
            color: #fff;
        }

        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.3);
            margin: 2rem 0;
        }

        .section-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
        }

        footer {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            body { padding: 1rem; }
            .glass-container { padding: 2rem 1.5rem; }
            h1 { font-size: 1.75rem; }
            .endpoint-row {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            .badges { margin-top: 0.5rem; }
        }
    </style>
</head>
<body>
    <div class="glass-container">
        <header>
            <h1>API Documentation</h1>
            <p class="subtitle">E-commerce Backend</p>
        </header>

        <div class="info-box">
            All endpoints require <strong>X-Access-Key</strong> header. Authenticated routes need <strong>Bearer Token</strong>.
        </div>

        <div class="endpoint">
            <div class="endpoint-row">
                <span class="method method-post">POST</span>
                <div class="endpoint-info">
                    <span class="endpoint-name">Register</span>
                    <span class="endpoint-url">/api/auth/register</span>
                </div>
                <div class="badges">
                    <span class="badge badge-key">KEY</span>
                </div>
            </div>
        </div>

        <div class="endpoint">
            <div class="endpoint-row">
                <span class="method method-post">POST</span>
                <div class="endpoint-info">
                    <span class="endpoint-name">Login</span>
                    <span class="endpoint-url">/api/auth/login</span>
                </div>
                <div class="badges">
                    <span class="badge badge-key">KEY</span>
                </div>
            </div>
        </div>

        <div class="endpoint">
            <div class="endpoint-row">
                <span class="method method-get">GET</span>
                <div class="endpoint-info">
                    <span class="endpoint-name">Products</span>
                    <span class="endpoint-url">/api/products</span>
                </div>
                <div class="badges">
                    <span class="badge badge-key">KEY</span>
                </div>
            </div>
        </div>

        <div class="endpoint">
            <div class="endpoint-row">
                <span class="method method-get">GET</span>
                <div class="endpoint-info">
                    <span class="endpoint-name">Detail Product</span>
                    <span class="endpoint-url">/api/products/{id}</span>
                </div>
                <div class="badges">
                    <span class="badge badge-key">KEY</span>
                </div>
            </div>
        </div>

        <div class="endpoint">
            <div class="endpoint-row">
                <span class="method method-post">POST</span>
                <div class="endpoint-info">
                    <span class="endpoint-name">Checkout</span>
                    <span class="endpoint-url">/api/checkout</span>
                </div>
                <div class="badges">
                    <span class="badge badge-key">KEY</span>
                    <span class="badge badge-token">AUTH</span>
                </div>
            </div>
        </div>

        <div class="endpoint">
            <div class="endpoint-row">
                <span class="method method-post">POST</span>
                <div class="endpoint-info">
                    <span class="endpoint-name">Payment Process</span>
                    <span class="endpoint-url">/api/payment/{order_number}</span>
                </div>
                <div class="badges">
                    <span class="badge badge-key">KEY</span>
                    <span class="badge badge-token">AUTH</span>
                </div>
            </div>
        </div>

        <div class="endpoint">
            <div class="endpoint-row">
                <span class="method method-get">GET</span>
                <div class="endpoint-info">
                    <span class="endpoint-name">Order History</span>
                    <span class="endpoint-url">/api/orders/history</span>
                </div>
                <div class="badges">
                    <span class="badge badge-key">KEY</span>
                    <span class="badge badge-token">AUTH</span>
                </div>
            </div>
        </div>

        <div class="endpoint">
            <div class="endpoint-row">
                <span class="method method-post">POST</span>
                <div class="endpoint-info">
                    <span class="endpoint-name">Logout</span>
                    <span class="endpoint-url">/api/auth/logout</span>
                </div>
                <div class="badges">
                    <span class="badge badge-key">KEY</span>
                    <span class="badge badge-token">AUTH</span>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="section-label">Webhook</div>

        <div class="endpoint">
            <div class="endpoint-row">
                <span class="method method-post">POST</span>
                <div class="endpoint-info">
                    <span class="endpoint-name">Payment Webhook</span>
                    <span class="endpoint-url">/api/webhook/payment</span>
                </div>
                <div class="badges">
                    <span class="badge badge-webhook">SIG</span>
                </div>
            </div>
        </div>

        <footer>
            <script>document.write(new Date().getFullYear())</script> · Backend Developer Technical Test
        </footer>
    </div>
</body>
</html>
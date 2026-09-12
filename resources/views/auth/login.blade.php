<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — කැදැල්ල Distributors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }

        html, body {
            height: 100%;
            background: #dce3ec;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        body::before {
        content: '';
        position: fixed;
        inset: 0;
        background:
            radial-gradient(ellipse at 20% 50%, rgba(45,106,159,0.08) 0%, transparent 60%),
            radial-gradient(ellipse at 80% 20%, rgba(45,106,159,0.05) 0%, transparent 50%);
        pointer-events: none;
        }

        /* ── FLOATING CARD ── */
        .login-card {
            display: flex;
            width: 880px;
            height: 590px;
            border-radius: 22px;
            overflow: hidden;
            box-shadow:
                0 40px 100px rgba(0,0,0,0.55),
                0 0 0 1px rgba(255,255,255,0.06);
            position: relative;
            z-index: 1;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            width: 50%;
            background: linear-gradient(175deg, #0a1628 0%, #0f2744 35%, #1a3c5e 75%, #1e4d78 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 38px 34px;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        /* Decorative circles */
        .deco-circle-1 {
            position: absolute;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: rgba(45,106,159,0.1);
            top: -60px; right: -60px;
            pointer-events: none;
        }
        .deco-circle-2 {
            position: absolute;
            width: 150px; height: 150px;
            border-radius: 50%;
            background: rgba(240,192,64,0.04);
            bottom: -40px; left: -40px;
            pointer-events: none;
        }
        .deco-circle-3 {
            position: absolute;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.02);
            bottom: 80px; right: 20px;
            pointer-events: none;
        }

        /* ── KD LOGO ── */
        .kd-logo-wrap {
            position: relative;
            z-index: 1;
            margin-bottom: 14px;
            margin-top: 4px;
        }
        .kd-logo-outer {
            width: 78px; height: 78px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            border: 2px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .kd-logo-inner {
            width: 62px; height: 62px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(240,192,64,0.18), rgba(240,192,64,0.08));
            border: 1.5px solid rgba(240,192,64,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .kd-logo-inner span {
            font-size: 27px;
            font-weight: 700;
            color: #f0c040;
            letter-spacing: -1.5px;
            font-family: 'Times New Roman', Times, serif;
        }

        /* ── BRAND NAME ── */
        .brand-section {
            text-align: center;
            position: relative;
            z-index: 1;
            margin-bottom: 16px;
        }
        .brand-sinhala {
            color: #f0c040;
            font-size: 26px;
            font-weight: 700;
            display: block;
            line-height: 1.3;
            margin-bottom: 8px;
            font-family: 'Times New Roman', Times, serif;
        }
        .brand-en {
            color: rgba(255,255,255,0.4);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* ── ABOUT NOTE ── */
        .about-note {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-left: 2.5px solid rgba(240,192,64,0.55);
            border-radius: 0 8px 8px 0;
            padding: 10px 12px;
            margin-bottom: 20px;
            text-align: left;
            position: relative;
            z-index: 1;
            width: 100%;
        }
        .about-note p {
            color: rgba(255,255,255,0.68);
            font-size: 11.5px;
            line-height: 1.65;
            font-weight: 400;
        }

        /* ── MODULES GRID ── */
        .modules-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            width: 100%;
            margin-bottom: 14px;
            position: relative;
            z-index: 1;
        }
        .module-item {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 8px;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }
        .module-item:hover { background: rgba(255,255,255,0.1); }
        .module-icon {
            width: 26px; height: 26px;
            background: rgba(240,192,64,0.12);
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #f0c040;
            flex-shrink: 0;
        }
        .module-name {
            color: rgba(255,255,255,0.78);
            font-size: 11.5px;
            font-weight: 500;
        }

        /* ── DIVIDER ── */
       .left-sep {
        width: 100%;
        border: none;
        border-top: 1px solid rgba(255,255,255,0.07);
        margin: 4px 0 10px;
        position: relative;
        z-index: 1;
        }

        /* ── INFO TAGS ── */
        .contact-strip {
            width: 100%;
            background: rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 10px;
            padding: 10px 14px;
            position: relative;
            z-index: 1;
            margin-top: auto;
        }
        .contact-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            color: rgba(255,255,255,0.6);
            font-size: 10px;
            font-weight: 500;
        }
        .contact-row i {
            color: #f0c040;
            font-size: 10px;
            width: 14px;
            text-align: center;
            flex-shrink: 0;
        }
        .contact-divider {
            border-top: 1px solid rgba(255,255,255,0.07);
            margin: 7px 0;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            width: 60%;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 36px 46px;
        }

        .login-box { width: 100%; max-width: 320px; }

        /* ── SIGN IN HEADER ── */
        .signin-header {
        margin-bottom: 10px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f4f8;
        text-align: center;
        }
        
        .signin-title {
            font-size: 26px;
            font-weight: 900;
            color: #0a1628;
            line-height: 1.2;
            margin-top:4px;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
            font-family: 'Times New Roman', Times, serif;
        }
        .signin-sub {
            font-size: 11px;
            color: #7a8a9c;
            font-weight: 500;
            margin-bottom: 4px;
        }

        /* ── ROLE SELECTOR ── */
        .role-label {
            font-size: 10px;
            font-weight: 700;
            color: #3a4a5c;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: block;
        }
        .role-selector {
            display: flex;
            gap: 8px;
            margin-bottom: 18px;
        }
        .role-btn {
            flex: 1;
            padding: 10px 8px;
            border: 1.5px solid #dde3ec;
            border-radius: 11px;
            background: #f7f9fc;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
            position: relative;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .role-btn input[type="radio"] { position:absolute; opacity:0; width:0; height:0; }
        .role-icon {
            width: 34px; height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 6px;
            font-size: 14px;
            transition: all 0.2s;
            background: #e8f0fb;
            color: #2d6a9f;
        }
        .role-name {
            font-size: 11px;
            font-weight: 700;
            color: #4a5568;
            display: block;
            transition: all 0.2s;
        }
        .role-desc {
            font-size: 9px;
            color: #6c798a;
            margin-top: 1px;
            display: block;
        }
        .role-btn.selected {
            border-color: #2d6a9f;
            background: #f0f6ff;
            box-shadow: 0 4px 16px rgba(45,106,159,0.2);
        }
        .role-btn.selected .role-name { color: #0f2744; }
        .role-btn.selected .role-icon {
            background: linear-gradient(135deg, #0f2744, #2d6a9f);
            color: white;
        }
        .role-btn:hover:not(.selected) {
            border-color: #b8cfe8;
            background: #f5f8fc;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* ── FORM DIVIDER ── */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 14px 0;
        }
        .form-divider::before,
        .form-divider::after { content:''; flex:1; height:1px; background:#edf0f5; }
        .form-divider span { font-size:10.5px; color:#94a3b8; font-weight:600; white-space:nowrap; }

        /* ── INPUTS ── */
        .field-label {
            font-size: 10px;
            font-weight: 700;
            color: #3a4a5c;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
            display: block;
        }
        .input-group-text {
            background: #f7f9fc;
            border: 1.5px solid #dde3ec;
            border-right: none !important;
            color: #7a8a9c;
            border-radius: 10px 0 0 10px !important;
            padding: 0 12px;
            transition: all 0.2s;
            font-size: 12px;
        }
        .form-control {
            border: 1.5px solid #dde3ec;
            border-left: none !important;
            border-radius: 0 10px 10px 0 !important;
            padding: 10px 12px;
            font-size: 12.5px;
            font-family: 'Poppins', sans-serif;
            color: #1a2535;
            font-weight: 500;
            transition: all 0.2s;
            background: white;
        }
        .form-control:focus { border-color: #2d6a9f !important; box-shadow: none; }
        .form-control::placeholder { color: #b0bec8; font-weight: 400; }
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control,
        .input-group:focus-within .eye-btn { border-color: #2d6a9f; }
        .eye-btn {
            background: #f7f9fc;
            border: 1.5px solid #dde3ec;
            border-left: none !important;
            border-radius: 0 10px 10px 0 !important;
            color: #7a8a9c;
            padding: 0 12px;
            cursor: pointer;
            transition: color 0.2s;
            font-size: 12px;
        }
        .eye-btn:hover { color: #2d6a9f; background: #f0f6ff; }

        /* ── BUTTON ── */
        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.25s;
            margin-top: 6px;
            color: white;
            letter-spacing: 0.3px;
            background: linear-gradient(135deg, #0a1628 0%, #0f2744 50%, #2d6a9f 100%);
            box-shadow: 0 4px 15px rgba(15,39,68,0.3);
        }
        .btn-login:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(15,39,68,0.4); }
        .btn-login:active { transform:translateY(0); }

        /* ── ERROR ── */
        .error-box {
            background: #fff5f5;
            border: 1.5px solid #fca5a5;
            border-radius: 10px;
            padding: 10px 13px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 12px;
            color: #c0392b;
            font-weight: 500;
        }

        /* ── FOOTER ── */
        .login-footer {
        text-align: center;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #f0f4f8;
        width: 100%;
        }
        .footer-copy {
            font-size: 10.5px;
            color: #94a3b8;
            font-weight: 400;
        }

        @media (max-width: 768px) {
            body { overflow: auto; align-items: flex-start; padding: 20px; }
            .login-card { flex-direction: column; width: 100%; height: auto; }
            .left-panel { width: 100%; }
            .right-panel { width: 100%; }
        }
    </style>
</head>
<body>

<div class="login-card">

    <!-- ── LEFT PANEL ── -->
    <div class="left-panel">
        <div class="deco-circle-1"></div>
        <div class="deco-circle-2"></div>
        <div class="deco-circle-3"></div>

        <!-- KD Logo -->
        <div class="kd-logo-wrap">
            <div class="kd-logo-outer">
                <div class="kd-logo-inner">
                    <span>KD</span>
                </div>
            </div>
        </div>

        <!-- Brand -->
        <div class="brand-section">
            <span class="brand-sinhala">කැදැල්ල Distributors</span>
        </div>

        <!-- About Note -->
        <div class="about-note">
            <p><p>Kedalla Distributors is a wholesale distributor of household plastic products — supplying cleaning items to retail shops.</p></p>
        </div>

        <!-- Modules Grid — 2 per row -->
        <div class="modules-grid">
            <div class="module-item">
                <div class="module-icon"><i class="fas fa-box"></i></div>
                <span class="module-name">Inventory</span>
            </div>
            <div class="module-item">
                <div class="module-icon"><i class="fas fa-store"></i></div>
                <span class="module-name">Shop Mgmt</span>
            </div>
            <div class="module-item">
                <div class="module-icon"><i class="fas fa-clipboard-list"></i></div>
                <span class="module-name">Orders</span>
            </div>
            <div class="module-item">
                <div class="module-icon"><i class="fas fa-truck"></i></div>
                <span class="module-name">Deliveries</span>
            </div>
            <div class="module-item">
                <div class="module-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                <span class="module-name">Invoices</span>
            </div>
            <div class="module-item">
                <div class="module-icon"><i class="fas fa-chart-bar"></i></div>
                <span class="module-name">Analytics</span>
            </div>
        </div>

        <!-- Contact Strip -->
<div class="contact-strip">
    <div class="contact-row">
        <i class="fas fa-map-marker-alt"></i>
        <span>Handessa, Kandy</span>
    </div>
    <div class="contact-divider"></div>
    <div class="contact-row">
        <i class="fas fa-phone-alt"></i>
        <span>077-3737422 &nbsp;·&nbsp; 077-3737202</span>
    </div>
</div>

    </div>

    <!-- ── RIGHT PANEL ── -->
    <div class="right-panel">
        <div class="login-box">

    <!-- Header -->
    <div class="signin-header">
        
        <div class="signin-title">
    <i class="fas fa-sign-in-alt me-2" style="font-size:20px;color:#2d6a9f;vertical-align:middle;"></i>Sign In
</div>
        <div class="signin-sub">Product Distribution Management System</div>
    </div>

            <!-- Error -->
            @if($errors->any())
            <div class="error-box">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="error-box">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" id="loginForm">
                @csrf

                <!-- Role -->
                <span class="role-label">Select Your Role</span>
                <div class="role-selector">
                    <label class="role-btn selected" id="adminBtn">
                        <input type="radio" name="role" value="admin" checked>
                        <div class="role-icon"><i class="fas fa-user-shield"></i></div>
                        <span class="role-name">Administrator</span>
                        <span class="role-desc">Full access</span>
                    </label>
                    <label class="role-btn" id="repBtn">
                        <input type="radio" name="role" value="salesrep">
                        <div class="role-icon"><i class="fas fa-user-tie"></i></div>
                        <span class="role-name">Sales Rep</span>
                        <span class="role-desc">Orders & products</span>
                    </label>
                </div>

                <div class="form-divider">
                    <span>Enter your credentials</span>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="field-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control"
                            placeholder="your@email.com"
                            value="{{ old('email') }}" required autocomplete="email">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <label class="field-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="passwordInput"
                            class="form-control" placeholder="••••••••"
                            required autocomplete="current-password">
                        <button class="eye-btn" type="button" id="togglePassword" tabindex="-1">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Button -->
                <button type="submit" class="btn-login" id="loginBtn">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    <span id="btnText">Sign In as Administrator</span>
                </button>

            </form>

            <!-- Footer -->
            <div class="login-footer">
                <span class="footer-copy">© 2026 Kedalla Distributors · All rights reserved.</span>
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const adminBtn = document.getElementById('adminBtn');
    const repBtn   = document.getElementById('repBtn');
    const loginBtn = document.getElementById('loginBtn');
    const btnText  = document.getElementById('btnText');

    adminBtn.addEventListener('click', function () {
        adminBtn.classList.add('selected');
        repBtn.classList.remove('selected');
        btnText.textContent = 'Sign In as Administrator';
    });

    repBtn.addEventListener('click', function () {
        repBtn.classList.add('selected');
        adminBtn.classList.remove('selected');
        btnText.textContent = 'Sign In as Sales Representative';
    });

    const togglePassword = document.getElementById('togglePassword');
    const passwordInput  = document.getElementById('passwordInput');
    const eyeIcon        = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
</script>
</body>
</html>
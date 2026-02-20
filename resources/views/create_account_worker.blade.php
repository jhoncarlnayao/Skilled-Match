<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join SkilledTrade | Worker Registration</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^3/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #FD5068;
            --brand-2: #FF7854;
            --brand-grad: linear-gradient(135deg, #FD5068 0%, #FF7854 100%);
        }
        * { box-sizing: border-box; }
        ::-webkit-scrollbar { display: none; }
        html { scrollbar-width: none; }
        body { font-family: 'DM Sans', sans-serif; min-height: 100vh; }
        h1, h2, h3, label, .sora { font-family: 'Sora', sans-serif; }
        .page-wrapper { display: grid; grid-template-columns: 1fr 1.6fr; min-height: 100vh; }
        .left-panel {
            background: linear-gradient(160deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 48px 44px; position: sticky; top: 0; height: 100vh; overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 80%, rgba(253,80,104,0.18) 0%, transparent 70%),
                radial-gradient(ellipse 40% 40% at 80% 20%, rgba(255,120,84,0.12) 0%, transparent 60%);
            pointer-events: none;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 300px; height: 300px;
            border-radius: 50%;
            border: 1px solid rgba(253,80,104,0.12);
        }
        .brand-tag {
            display: inline-flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12);
            border-radius: 100px; padding: 8px 16px 8px 10px; width: fit-content;
        }
        .brand-dot {
            width: 28px; height: 28px; background: var(--brand-grad);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
        }
        .right-panel { overflow-y: auto; padding: 48px 56px; display: flex; flex-direction: column; }
        .section-label { display: flex; align-items: center; gap: 10px; margin-bottom: 18px; }
        .section-label .num {
            width: 26px; height: 26px; background: var(--brand-grad); border-radius: 50%;
            font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700; color: white;
            display: flex; align-items: center; justify-content: center;
        }
        .section-label span.title {
            font-family: 'Sora', sans-serif; font-size: 11px; font-weight: 700;
            letter-spacing: 0.1em; text-transform: uppercase; color: #9ca3af;
        }
        .field-group { margin-bottom: 28px; }
        .field-label {
            display: block; font-size: 11px; font-weight: 600; letter-spacing: 0.07em;
            text-transform: uppercase; color: #6b7280; margin-bottom: 6px;
            font-family: 'Sora', sans-serif;
        }
        .field-input {
            width: 100%; padding: 13px 16px; border: 1.5px solid #e5e7eb; border-radius: 8px;
            font-size: 14px; font-family: 'DM Sans', sans-serif; color: #111827; background: #fafafa;
            transition: all 0.2s ease; outline: none;
        }
        .field-input:focus {
            border-color: var(--brand); background: #fff; box-shadow: 0 0 0 4px rgba(253,80,104,0.06);
        }
        .field-input::placeholder { color: #c4cdd8; }
        input[type="file"].field-input { padding: 10px 16px; cursor: pointer; color: #6b7280; }
        .form-divider {
            height: 1px; background: linear-gradient(90deg, transparent, #e5e7eb 20%, #e5e7eb 80%, transparent);
            margin: 8px 0 28px;
        }
        .submit-btn {
            width: 100%; padding: 16px; background: var(--brand-grad); color: white;
            font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 700; letter-spacing: 0.04em;
            border: none; border-radius: 10px; cursor: pointer; transition: all 0.25s ease;
            box-shadow: 0 8px 24px rgba(253,80,104,0.28); position: relative; overflow: hidden;
        }
        .submit-btn::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
        }
        .submit-btn:hover { transform: translateY(-1px); box-shadow: 0 12px 32px rgba(253,80,104,0.35); }
        .submit-btn:active { transform: scale(0.99); }
        .alert { border-radius: 10px; padding: 14px 16px; font-size: 13px; margin-bottom: 24px; }
        .alert-success { background: #f0fdf4; border-left: 4px solid #22c55e; color: #15803d; }
        .alert-error { background: #fff5f5; border-left: 4px solid var(--brand); color: #b91c1c; }
        @media (max-width: 900px) {
            .page-wrapper { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 32px 24px; }
        }
    </style>
</head>
<body>

<div class="page-wrapper">

    <!-- LEFT PANEL -->
    <aside class="left-panel">
        <div style="position: relative; z-index:1;">
            <a href="{{ url('/') }}">
                <div class="brand-tag mb-10">
                    <div class="brand-dot">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                    </div>
                    <span style="font-family:'Sora',sans-serif; font-size:13px; font-weight:700; color:rgba(255,255,255,0.9);">SkilledTrade</span>
                </div>
            </a>

            <h2 style="font-size:32px; font-weight:800; color:white; margin-bottom:16px;">
                Hire the right<br>
                <span style="background: var(--brand-grad); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">professional</span><br>
                every time.
            </h2>

            <p style="font-size:14px; color: rgba(255,255,255,0.5); line-height:1.7; margin-bottom:40px; font-family:'DM Sans',sans-serif; font-weight:300;">
                Connect with verified skilled tradespeople for any job, big or small.
            </p>
        </div>

        <p style="font-size:11px; color: rgba(255,255,255,0.2); position: relative; z-index: 1; font-family:'Sora',sans-serif;">
            © 2025 SkilledTrade. All rights reserved.
        </p>
    </aside>

    <!-- RIGHT PANEL / FORM -->
    <main class="right-panel">
        <div style="max-width:560px; width:100%; margin:0 auto;">
  <div style="margin-bottom: 24px;">
            <a href="javascript:history.back()" 
               class="inline-block px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-all">
                ← Back
            </a>
        </div>


            <!-- Header -->
        <div style="margin-bottom: 40px;">
    <p style="font-size: 12px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--brand); margin-bottom: 8px; font-family: 'Sora', sans-serif;">Join SkilledTrade</p>
    <h1 style="font-size: 28px; font-weight: 800; color: #111827; margin-bottom: 8px;">Create your worker account</h1>
    <p style="font-size: 14px; color: #9ca3af; line-height: 1.6;">
        Fill in your details below to showcase your skills and start connecting with clients looking for professionals like you.
    </p>
</div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success">✓ {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">
                    <ul style="padding-left:16px; margin:0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('worker.register') }}" enctype="multipart/form-data">
                @csrf

                <!-- Section 1: Personal Info -->
                <div class="field-group">
                    <div class="section-label">
                        <div class="num">1</div>
                        <span class="title">Personal Information</span>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px; margin-bottom:14px;">
                        <div>
                            <label class="field-label">First Name <span style="color:var(--brand)">*</span></label>
                            <input type="text" name="first_name" required placeholder="John" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Middle Name</label>
                            <input type="text" name="middle_name" placeholder="Quincy" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Last Name <span style="color:var(--brand)">*</span></label>
                            <input type="text" name="last_name" required placeholder="Doe" class="field-input">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div>
                            <label class="field-label">Birthdate</label>
                            <input type="date" name="birthdate" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Profile Picture</label>
                            <input type="file" name="profile_picture" accept="image/*" class="field-input">
                        </div>
                    </div>
                </div>

                <div class="form-divider"></div>

                <!-- Section 2: Account Credentials -->
                <div class="field-group">
                    <div class="section-label">
                        <div class="num">2</div>
                        <span class="title">Account Credentials</span>
                    </div>

                    <div style="margin-bottom:14px;">
                        <label class="field-label">Username <span style="color:var(--brand)">*</span></label>
                        <input type="text" name="username" required placeholder="worker123" class="field-input">
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div>
                            <label class="field-label">Password <span style="color:var(--brand)">*</span></label>
                            <input type="password" name="password" required placeholder="••••••••" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Confirm Password <span style="color:var(--brand)">*</span></label>
                            <input type="password" name="password_confirmation" required placeholder="••••••••" class="field-input">
                        </div>
                    </div>
                </div>

                <div class="form-divider"></div>

                <!-- Section 3: Contact Info -->
                <div class="field-group">
                    <div class="section-label">
                        <div class="num">3</div>
                        <span class="title">Contact & Trade Info</span>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
                        <div>
                            <label class="field-label">Phone Number <span style="color:var(--brand)">*</span></label>
                            <input type="tel" name="phone" required placeholder="+63 912 345 6789" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Email Address <span style="color:var(--brand)">*</span></label>
                            <input type="email" name="email" required placeholder="worker@email.com" class="field-input">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                        <div>
                            <label class="field-label">Trade Skill <span style="color:var(--brand)">*</span></label>
                            <select name="trade_id" required class="field-input appearance-none bg-white">
                                <option value="">Select Specialty</option>
                                @foreach($trades as $trade)
                                    <option value="{{ $trade->id }}">{{ $trade->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="field-label">Experience (Years)</label>
                            <input type="number" name="experience_years" min="0" placeholder="5" class="field-input">
                        </div>
                    </div>
                </div>

                <button type="submit" class="submit-btn mt-4">
                    Create My Profile →
                </button>

                <p style="text-align:center; margin-top:20px; font-size:13px; color:#9ca3af;">
                    Already have an account?
                    <a href="{{ route('login') }}" style="color:var(--brand); font-weight:600; text-decoration:none;">Sign in</a>
                </p>

            </form>
        </div>
    </main>

</div>
</body>
</html>
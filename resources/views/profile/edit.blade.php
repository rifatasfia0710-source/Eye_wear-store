@extends('layouts.customer')

@section('title', 'Profile Settings')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --ink:          #0f172a;
        --muted:        #64748b;
        --accent:       #6366f1;
        --accent-2:     #8b5cf6;
        --accent-light: #eef2ff;
        --accent-glow:  rgba(99,102,241,0.15);
        --surface:      #ffffff;
        --border:       #e2e8f0;
        --danger:       #ef4444;
        --success:      #10b981;
        --shadow:       0 4px 24px rgba(15,23,42,0.08);
    }

    /* ── Scope all styles inside dashboard-content ── */
    .dashboard-content {
        padding: 36px 40px 80px;
        min-height: 100vh;
        background: #f1f5f9;
    }

    /* Page heading */
    .pf-heading { margin-bottom: 28px; }
    .pf-heading .eyebrow {
        font-size: 11px; font-weight: 600; letter-spacing: 3px;
        text-transform: uppercase; color: var(--accent); margin-bottom: 5px;
    }
    .pf-heading h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(22px, 2.8vw, 32px);
        color: var(--ink); line-height: 1.2; margin: 0;
    }
    .pf-heading p { margin-top: 5px; color: var(--muted); font-size: 14px; }

    /* Alert */
    .pf-alert {
        display: flex; align-items: center; gap: 11px;
        background: #ecfdf5; border: 1px solid #6ee7b7;
        border-left: 4px solid var(--success);
        border-radius: 10px; padding: 12px 16px;
        color: #065f46; font-size: 13.5px; font-weight: 500;
        margin-bottom: 24px; animation: fadeSlide .4s ease;
        font-family: 'DM Sans', sans-serif;
    }
    .pf-alert::before {
        content: '✓'; width: 20px; height: 20px;
        background: var(--success); color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 800; flex-shrink: 0;
    }
    @keyframes fadeSlide {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ════ HORIZONTAL 2-COL LAYOUT ════ */
    .pf-layout {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 22px;
        align-items: start;
    }

    /* ── LEFT PANEL ── */
    .pf-left {
        display: flex; flex-direction: column; gap: 14px;
        position: sticky; top: 24px;
    }

    .avatar-card {
        background: linear-gradient(150deg, var(--accent) 0%, var(--accent-2) 100%);
        border-radius: 18px; padding: 28px 18px 22px;
        text-align: center; color: white;
        position: relative; overflow: hidden;
        box-shadow: 0 8px 28px rgba(99,102,241,0.38);
    }
    .avatar-card::before {
        content: ''; position: absolute; top: -36px; right: -36px;
        width: 110px; height: 110px;
        background: rgba(255,255,255,0.07); border-radius: 50%;
    }
    .avatar-card::after {
        content: ''; position: absolute; bottom: -24px; left: -24px;
        width: 88px; height: 88px;
        background: rgba(255,255,255,0.05); border-radius: 50%;
    }

    .avatar-ring {
        position: relative; display: inline-block;
        margin-bottom: 12px; cursor: pointer;
    }
    .avatar-ring img,
    .avatar-ring .avatar-initials {
        width: 96px; height: 96px; border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255,255,255,0.55);
        box-shadow: 0 6px 18px rgba(0,0,0,0.22);
        display: flex; align-items: center; justify-content: center;
    }
    .avatar-ring .avatar-initials {
        background: rgba(255,255,255,0.18);
        font-family: 'Playfair Display', serif;
        font-size: 34px; color: white; font-weight: 700;
    }
    .avatar-overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,0.42);
        border-radius: 50%; display: flex; align-items: center;
        justify-content: center; opacity: 0; transition: opacity .22s;
        font-size: 18px; color: white;
        border: 4px solid rgba(255,255,255,0.35);
    }
    .avatar-ring:hover .avatar-overlay { opacity: 1; }
    .avatar-file-input {
        position: absolute; inset: 0; opacity: 0;
        cursor: pointer; border-radius: 50%;
    }

    .avatar-card h3 {
        font-family: 'Playfair Display', serif;
        font-size: 17px; font-weight: 600;
        position: relative; z-index: 1; margin-bottom: 3px;
    }
    .avatar-card .ac-email {
        font-size: 12px; opacity: .75;
        position: relative; z-index: 1; word-break: break-all;
    }
    .avatar-hint {
        margin-top: 12px; font-size: 11px; opacity: .6;
        position: relative; z-index: 1; line-height: 1.5;
    }

    .info-tile {
        background: var(--surface); border-radius: 12px;
        padding: 14px 18px; border: 1px solid var(--border);
        box-shadow: var(--shadow);
    }
    .info-tile .t-label {
        font-size: 10.5px; font-weight: 600; letter-spacing: 2px;
        text-transform: uppercase; color: var(--muted); margin-bottom: 4px;
        font-family: 'DM Sans', sans-serif;
    }
    .info-tile .t-value {
        font-size: 13.5px; font-weight: 500; color: var(--ink);
        word-break: break-all; font-family: 'DM Sans', sans-serif;
    }

    /* ── RIGHT PANEL ── */
    .pf-right { display: flex; flex-direction: column; gap: 18px; }

    .form-card {
        background: var(--surface); border-radius: 18px;
        border: 1px solid var(--border); box-shadow: var(--shadow);
        overflow: hidden;
    }
    .fc-header {
        padding: 16px 22px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 12px;
        background: #fafbff;
    }
    .fc-icon {
        width: 34px; height: 34px; background: var(--accent-light);
        border-radius: 8px; display: flex; align-items: center;
        justify-content: center; color: var(--accent);
        font-size: 14px; flex-shrink: 0;
    }
    .fc-title { font-family: 'Playfair Display', serif; font-size: 15.5px; color: var(--ink); }
    .fc-sub   { font-size: 12px; color: var(--muted); margin-top: 1px; font-family: 'DM Sans', sans-serif; }

    .fc-body { padding: 22px; }

    .fields-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 16px;
    }

    .fg { display: flex; flex-direction: column; gap: 6px; }
    .fg label {
        font-size: 12px; font-weight: 600; color: var(--ink);
        letter-spacing: .3px; font-family: 'DM Sans', sans-serif;
    }
    .fg label .opt { color: var(--muted); font-weight: 400; }

    .iw { position: relative; }
    .iw .ii {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%); color: #94a3b8;
        font-size: 13px; pointer-events: none;
    }
    .iw input {
        width: 100%; padding: 10px 12px 10px 36px;
        border: 1.5px solid var(--border); border-radius: 9px;
        font-family: 'DM Sans', sans-serif; font-size: 13.5px;
        color: var(--ink); background: #fafcff;
        transition: border-color .2s, box-shadow .2s, background .2s;
        outline: none;
    }
    .iw input:focus {
        border-color: var(--accent); background: white;
        box-shadow: 0 0 0 3px var(--accent-glow);
    }
    .iw input::placeholder { color: #cbd5e1; }
    .iw input.is-error { border-color: var(--danger); background: #fff5f5; }

    .ferr {
        font-size: 11.5px; color: var(--danger);
        display: flex; align-items: center; gap: 4px;
        font-family: 'DM Sans', sans-serif;
    }

    .strength-bar { display: flex; gap: 3px; margin-top: 6px; }
    .strength-bar span {
        flex: 1; height: 3px; background: var(--border);
        border-radius: 99px; transition: background .3s;
    }
    .s-label {
        font-size: 11px; color: var(--muted); margin-top: 3px;
        font-family: 'DM Sans', sans-serif;
    }

    .fc-footer {
        display: flex; justify-content: flex-end;
        padding: 16px 22px; border-top: 1px solid var(--border);
        background: #fafbff;
    }
    .btn-save {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 26px;
        background: linear-gradient(135deg, var(--accent), var(--accent-2));
        color: white; border: none; border-radius: 9px;
        font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600;
        cursor: pointer; transition: transform .25s, box-shadow .25s;
        box-shadow: 0 4px 14px rgba(99,102,241,.4);
    }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 6px 22px rgba(99,102,241,.5); }
    .btn-save:active { transform: translateY(0); }

    /* Responsive */
    @media (max-width: 900px) {
        .pf-layout { grid-template-columns: 1fr; }
        .pf-left { position: static; flex-direction: row; flex-wrap: wrap; }
        .avatar-card { flex: 1 1 200px; }
        .info-tile   { flex: 1 1 130px; }
        .dashboard-content { padding: 24px 20px 60px; }
    }
    @media (max-width: 560px) {
        .fields-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
{{-- dashboard-content is REQUIRED — matches the margin-left:280px in layouts/customer.blade.php --}}
<div class="dashboard-content">

    <div class="pf-heading">
        <div class="eyebrow">Account</div>
        <h1>Profile Settings</h1>
        <p>Manage your personal information and security preferences.</p>
    </div>

    @if(session('success'))
        <div class="pf-alert">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="pf-layout">

            {{-- ══ LEFT ══ --}}
            <div class="pf-left">

                <div class="avatar-card">
                    <div class="avatar-ring">
                        @if($user->profile_image)
                            <img id="avatarPreview"
                                 src="{{ asset('uploads/profile/'.$user->profile_image) }}"
                                 alt="{{ $user->name }}">
                        @else
                            <div class="avatar-initials" id="avatarPreview">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="avatar-overlay"><i class="fas fa-camera"></i></div>
                        <input type="file" name="profile_image" class="avatar-file-input"
                               accept="image/*" onchange="previewAvatar(this)">
                    </div>
                    <h3 id="liveNameDisplay">{{ $user->name }}</h3>
                    <div class="ac-email">{{ $user->email }}</div>
                    <div class="avatar-hint">Click photo to change<br>JPG, PNG · max 2 MB</div>
                </div>

                @error('profile_image')
                    <p class="ferr" style="padding:0 2px;">
                        <i class="fas fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror

                <div class="info-tile">
                    <div class="t-label">Member since</div>
                    <div class="t-value">{{ $user->created_at->format('M Y') }}</div>
                </div>

                <div class="info-tile">
                    <div class="t-label">Account type</div>
                    <div class="t-value" style="text-transform:capitalize;">
                        {{ $user->role ?? 'Customer' }}
                    </div>
                </div>

            </div>
            {{-- /LEFT --}}

            {{-- ══ RIGHT ══ --}}
            <div class="pf-right">

                {{-- Personal Info card --}}
                <div class="form-card">
                    <div class="fc-header">
                        <div class="fc-icon"><i class="fas fa-user-pen"></i></div>
                        <div>
                            <div class="fc-title">Personal Information</div>
                            <div class="fc-sub">Update your name and email address</div>
                        </div>
                    </div>
                    <div class="fc-body">
                        <div class="fields-grid">

                            <div class="fg">
                                <label for="name">Full Name</label>
                                <div class="iw">
                                    <i class="fas fa-user ii"></i>
                                    <input type="text" id="name" name="name"
                                           value="{{ old('name', $user->name) }}"
                                           placeholder="Your full name"
                                           oninput="document.getElementById('liveNameDisplay').textContent=this.value||'{{ addslashes($user->name) }}'"
                                           class="{{ $errors->has('name') ? 'is-error' : '' }}">
                                </div>
                                @error('name')
                                    <p class="ferr"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="fg">
                                <label for="email">Email Address</label>
                                <div class="iw">
                                    <i class="fas fa-envelope ii"></i>
                                    <input type="email" id="email" name="email"
                                           value="{{ old('email', $user->email) }}"
                                           placeholder="you@example.com"
                                           class="{{ $errors->has('email') ? 'is-error' : '' }}">
                                </div>
                                @error('email')
                                    <p class="ferr"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Password card --}}
                <div class="form-card">
                    <div class="fc-header">
                        <div class="fc-icon"><i class="fas fa-lock"></i></div>
                        <div>
                            <div class="fc-title">Change Password</div>
                            <div class="fc-sub">Leave blank to keep your current password</div>
                        </div>
                    </div>
                    <div class="fc-body">
                        <div class="fields-grid">

                            <div class="fg">
                                <label for="password">New Password <span class="opt">(optional)</span></label>
                                <div class="iw">
                                    <i class="fas fa-key ii"></i>
                                    <input type="password" id="password" name="password"
                                           placeholder="Min. 8 characters"
                                           oninput="checkStrength(this.value)">
                                </div>
                                <div class="strength-bar">
                                    <span id="s1"></span><span id="s2"></span>
                                    <span id="s3"></span><span id="s4"></span>
                                </div>
                                <p class="s-label" id="strengthLabel"></p>
                            </div>

                            <div class="fg">
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="iw">
                                    <i class="fas fa-shield-halved ii"></i>
                                    <input type="password" id="password_confirmation"
                                           name="password_confirmation"
                                           placeholder="Repeat new password">
                                </div>
                                @error('password')
                                    <p class="ferr"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="fc-footer">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-floppy-disk"></i> Save Changes
                        </button>
                    </div>
                </div>

            </div>
            {{-- /RIGHT --}}

        </div>
    </form>

</div>

<script>
function previewAvatar(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const old = document.getElementById('avatarPreview');
        const img = document.createElement('img');
        img.id  = 'avatarPreview';
        img.src = e.target.result;
        img.style.cssText = 'width:96px;height:96px;border-radius:50%;object-fit:cover;border:4px solid rgba(255,255,255,.55);box-shadow:0 6px 18px rgba(0,0,0,.22);display:flex;align-items:center;justify-content:center;';
        old.replaceWith(img);
    };
    reader.readAsDataURL(input.files[0]);
}

function checkStrength(val) {
    const colors = ['#ef4444','#f97316','#eab308','#10b981'];
    const labels = ['Weak','Fair','Good','Strong'];
    let score = 0;
    if (val.length >= 8)           score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val))  score++;
    [s1,s2,s3,s4].forEach((b,i) => {
        b.style.background = i < score ? colors[score-1] : 'var(--border)';
    });
    const lbl = document.getElementById('strengthLabel');
    lbl.textContent = val.length ? (labels[score-1] ?? 'Very Weak') : '';
    lbl.style.color = score > 0 ? colors[score-1] : 'var(--muted)';
}
</script>
@endsection
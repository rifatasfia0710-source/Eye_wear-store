@extends('layouts.admin')

@section('title', 'Admin Settings')

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
        --warning:      #f59e0b;
        --bg:           #f1f5f9;
        --shadow:       0 4px 24px rgba(15,23,42,0.08);
    }

    body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--ink); }
    .dashboard-content { padding: 36px 40px 80px; min-height: 100vh; background: var(--bg); }

    .as-heading { margin-bottom: 28px; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
    .as-heading-left .eyebrow { font-size: 11px; font-weight: 600; letter-spacing: 3px; text-transform: uppercase; color: var(--accent); margin-bottom: 5px; }
    .as-heading-left h1 { font-family: 'Playfair Display', serif; font-size: clamp(22px, 2.8vw, 32px); color: var(--ink); line-height: 1.2; margin: 0; }
    .as-heading-left p { margin-top: 5px; color: var(--muted); font-size: 14px; }

    .as-alert { display: flex; align-items: center; gap: 11px; background: #ecfdf5; border: 1px solid #6ee7b7; border-left: 4px solid var(--success); border-radius: 10px; padding: 12px 16px; color: #065f46; font-size: 13.5px; font-weight: 500; margin-bottom: 24px; animation: fadeSlide .4s ease; }
    .as-alert::before { content: '✓'; width: 20px; height: 20px; background: var(--success); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; flex-shrink: 0; }
    .as-error { display: flex; align-items: center; gap: 11px; background: #fff5f5; border: 1px solid #fca5a5; border-left: 4px solid var(--danger); border-radius: 10px; padding: 12px 16px; color: #991b1b; font-size: 13.5px; font-weight: 500; margin-bottom: 24px; }
    @keyframes fadeSlide { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

    .as-layout { display: grid; grid-template-columns: 220px 1fr; gap: 22px; align-items: start; }

    .as-nav-panel { display: flex; flex-direction: column; gap: 8px; position: sticky; top: 24px; }
    .as-nav-header { background: linear-gradient(150deg, var(--accent) 0%, var(--accent-2) 100%); border-radius: 16px; padding: 22px 18px; color: white; position: relative; overflow: hidden; box-shadow: 0 8px 28px rgba(99,102,241,0.35); margin-bottom: 6px; }
    .as-nav-header::before { content: ''; position: absolute; top: -30px; right: -30px; width: 90px; height: 90px; background: rgba(255,255,255,0.08); border-radius: 50%; }
    .as-nav-header .nav-icon { width: 44px; height: 44px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 12px; position: relative; z-index: 1; }
    .as-nav-header h3 { font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 600; position: relative; z-index: 1; margin: 0 0 3px; }
    .as-nav-header p { font-size: 11.5px; opacity: .7; position: relative; z-index: 1; margin: 0; }

    .nav-tab-btn { display: flex; align-items: center; gap: 11px; padding: 13px 16px; background: var(--surface); border: 1.5px solid var(--border); border-radius: 12px; cursor: pointer; width: 100%; font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 500; color: var(--muted); transition: all .22s; text-align: left; box-shadow: var(--shadow); }
    .nav-tab-btn .ntb-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; background: #f1f5f9; color: var(--muted); transition: all .22s; }
    .nav-tab-btn:hover { border-color: var(--accent); color: var(--accent); transform: translateX(3px); }
    .nav-tab-btn:hover .ntb-icon { background: var(--accent-light); color: var(--accent); }
    .nav-tab-btn.active { background: var(--accent-light); border-color: var(--accent); color: var(--accent); font-weight: 600; }
    .nav-tab-btn.active .ntb-icon { background: var(--accent); color: white; }

    .as-right { display: flex; flex-direction: column; }
    .tab-panel { display: none; flex-direction: column; gap: 18px; }
    .tab-panel.active { display: flex; animation: panelIn .3s ease; }
    @keyframes panelIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

    .form-card { background: var(--surface); border-radius: 18px; border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
    .fc-header { padding: 16px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; background: #fafbff; }
    .fc-icon { width: 36px; height: 36px; background: var(--accent-light); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 15px; flex-shrink: 0; }
    .fc-icon.danger { background: #fff0f0; color: var(--danger); }
    .fc-icon.warn   { background: #fffbeb; color: var(--warning); }
    .fc-title { font-family: 'Playfair Display', serif; font-size: 15.5px; color: var(--ink); }
    .fc-sub   { font-size: 12px; color: var(--muted); margin-top: 1px; }
    .fc-body  { padding: 22px; }

    .fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .fields-grid.cols-1 { grid-template-columns: 1fr; }

    .fg { display: flex; flex-direction: column; gap: 6px; }
    .fg label { font-size: 12px; font-weight: 600; color: var(--ink); letter-spacing: .3px; }

    .iw { position: relative; }
    .iw .ii { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; pointer-events: none; }
    .iw input, .iw select {
        width: 100%; padding: 10px 12px 10px 36px;
        border: 1.5px solid var(--border); border-radius: 9px;
        font-family: 'DM Sans', sans-serif; font-size: 13.5px;
        color: var(--ink); background: #fafcff;
        transition: border-color .2s, box-shadow .2s; outline: none; appearance: none;
    }
    .iw select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2394a3b8' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px; }
    .iw select[multiple] { height: 96px; padding: 8px 12px; background-image: none; }
    .iw input[type="file"] { padding: 8px 12px; cursor: pointer; }
    .iw input:focus, .iw select:focus { border-color: var(--accent); background: white; box-shadow: 0 0 0 3px var(--accent-glow); }
    .iw input::placeholder { color: #cbd5e1; }

    .ferr { font-size: 11.5px; color: var(--danger); display: flex; align-items: center; gap: 4px; margin-top: 2px; }

    .toggle-list { display: flex; flex-direction: column; gap: 12px; }
    .toggle-item { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: #fafcff; border: 1.5px solid var(--border); border-radius: 11px; transition: border-color .2s; }
    .toggle-item:hover { border-color: var(--accent); }
    .toggle-item-info { display: flex; align-items: center; gap: 12px; }
    .toggle-item-icon { width: 34px; height: 34px; border-radius: 8px; background: var(--accent-light); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 14px; }
    .toggle-item-text strong { font-size: 13.5px; color: var(--ink); font-weight: 600; display: block; }
    .toggle-item-text span  { font-size: 12px; color: var(--muted); }

    .switch { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; inset: 0; background: #cbd5e1; border-radius: 99px; cursor: pointer; transition: .25s; }
    .slider::before { content: ''; position: absolute; width: 18px; height: 18px; border-radius: 50%; background: white; left: 3px; top: 3px; box-shadow: 0 1px 4px rgba(0,0,0,0.2); transition: .25s; }
    .switch input:checked + .slider { background: var(--accent); }
    .switch input:checked + .slider::before { transform: translateX(20px); }

    .fc-footer { display: flex; align-items: center; justify-content: flex-end; gap: 10px; padding: 16px 22px; border-top: 1px solid var(--border); background: #fafbff; }

    .btn-save { display: inline-flex; align-items: center; gap: 8px; padding: 11px 24px; background: linear-gradient(135deg, var(--accent), var(--accent-2)); color: white; border: none; border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 600; cursor: pointer; transition: transform .22s, box-shadow .22s; box-shadow: 0 4px 14px rgba(99,102,241,.4); }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99,102,241,.5); }

    .btn-danger { display: inline-flex; align-items: center; gap: 8px; padding: 11px 24px; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none; border-radius: 9px; font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 600; cursor: pointer; transition: transform .22s, box-shadow .22s; box-shadow: 0 4px 14px rgba(239,68,68,.35); }
    .btn-danger:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(239,68,68,.45); }

    .info-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; color: var(--muted); background: #f8fafc; border: 1px solid var(--border); border-radius: 99px; padding: 4px 12px; }

    @media (max-width: 860px) {
        .as-layout { grid-template-columns: 1fr; }
        .as-nav-panel { position: static; flex-direction: row; flex-wrap: wrap; }
        .as-nav-header { flex: 1 1 180px; }
        .nav-tab-btn { flex: 1 1 120px; }
        .dashboard-content { padding: 24px 18px 60px; }
    }
    @media (max-width: 600px) { .fields-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="dashboard-content">

    <div class="as-heading">
        <div class="as-heading-left">
            <div class="eyebrow">Configuration</div>
            <h1>Admin Settings</h1>
            <p>Manage system configuration and preferences.</p>
        </div>
        <div class="info-badge"><i class="fas fa-circle" style="color:#10b981;font-size:8px;"></i> System Online</div>
    </div>

    @if(session('success'))
        <div class="as-alert">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="as-error">
            <i class="fas fa-circle-exclamation"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="as-layout">

        {{-- ══ LEFT NAV ══ --}}
        <div class="as-nav-panel">
            <div class="as-nav-header">
                <div class="nav-icon"><i class="fas fa-cog"></i></div>
                <h3>Settings</h3>
                <p>System & account config</p>
            </div>
            <button class="nav-tab-btn active" data-tab="general">
                <div class="ntb-icon"><i class="fas fa-sliders"></i></div> General
            </button>
            <button class="nav-tab-btn" data-tab="profile">
                <div class="ntb-icon"><i class="fas fa-user-pen"></i></div> Admin Profile
            </button>
            <button class="nav-tab-btn" data-tab="security">
                <div class="ntb-icon"><i class="fas fa-lock"></i></div> Security
            </button>
            <!-- <button class="nav-tab-btn" data-tab="notifications">
                <div class="ntb-icon"><i class="fas fa-bell"></i></div> Notifications
            </button> -->
        </div>

        {{-- ══ RIGHT CONTENT ══ --}}
        <div class="as-right">

            {{-- ── GENERAL TAB ── --}}
            <div class="tab-panel active" id="general">

                {{-- Website Info Form --}}
                <form method="POST" action="{{ route('admin.settings.general') }}">
                    @csrf {{-- ✅ CSRF token --}}
                    <div class="form-card">
                        <div class="fc-header">
                            <div class="fc-icon"><i class="fas fa-globe"></i></div>
                            <div>
                                <div class="fc-title">Website Information</div>
                                <div class="fc-sub">Basic site identity and contact details</div>
                            </div>
                        </div>
                        <div class="fc-body">
                            <div class="fields-grid">
                                <div class="fg">
                                    <label>Site Name</label>
                                    <div class="iw"><i class="fas fa-store ii"></i>
                                        {{-- ✅ name attribute যোগ করা হয়েছে --}}
                                        <input type="text" name="site_name"
                                               value="{{ old('site_name', $settings['site_name'] ?? 'My E-Commerce Store') }}"
                                               placeholder="Site name">
                                    </div>
                                    @error('site_name') <p class="ferr"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                                </div>
                                <div class="fg">
                                    <label>Admin Email</label>
                                    <div class="iw"><i class="fas fa-envelope ii"></i>
                                        <input type="email" name="admin_email"
                                               value="{{ old('admin_email', $settings['admin_email'] ?? 'admin@example.com') }}"
                                               placeholder="admin@example.com">
                                    </div>
                                    @error('admin_email') <p class="ferr"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                                </div>
                                <div class="fg">
                                    <label>Currency</label>
                                    <div class="iw"><i class="fas fa-coins ii"></i>
                                        <select name="currency">
                                            <option value="BDT" {{ ($settings['currency'] ?? '') == 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                                            <option value="USD" {{ ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                            <option value="EUR" {{ ($settings['currency'] ?? '') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="fg">
                                    <label>Timezone</label>
                                    <div class="iw"><i class="fas fa-clock ii"></i>
                                        <select name="timezone">
                                            <option value="Asia/Dhaka"     {{ ($settings['timezone'] ?? '') == 'Asia/Dhaka'     ? 'selected' : '' }}>Asia/Dhaka</option>
                                            <option value="UTC"            {{ ($settings['timezone'] ?? '') == 'UTC'            ? 'selected' : '' }}>UTC</option>
                                            <option value="America/New_York" {{ ($settings['timezone'] ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fc-footer">
                            <button type="submit" class="btn-save"><i class="fas fa-floppy-disk"></i> Save Changes</button>
                        </div>
                    </div>
                </form>

                {{-- Shipping Form --}}
                <form method="POST" action="{{ route('admin.settings.general') }}">
                    @csrf
                    {{-- hidden field দিয়ে কোন form submit হচ্ছে বোঝাতে --}}
                    <input type="hidden" name="form_type" value="shipping">
                    <div class="form-card">
                        <div class="fc-header">
                            <div class="fc-icon warn"><i class="fas fa-truck"></i></div>
                            <div>
                                <div class="fc-title">Shipping Configuration</div>
                                <div class="fc-sub">Delivery costs, zones and payment methods</div>
                            </div>
                        </div>
                        <div class="fc-body">
                            <div class="fields-grid">
                                <div class="fg">
                                    <label>Default Shipping Cost (৳)</label>
                                    <div class="iw"><i class="fas fa-tag ii"></i>
                                        <input type="number" name="shipping_cost" min="0"
                                               value="{{ old('shipping_cost', $settings['shipping_cost'] ?? '60') }}"
                                               placeholder="0">
                                    </div>
                                </div>
                                <div class="fg">
                                    <label>Free Shipping Limit (৳)</label>
                                    <div class="iw"><i class="fas fa-gift ii"></i>
                                        <input type="number" name="free_shipping" min="0"
                                               value="{{ old('free_shipping', $settings['free_shipping'] ?? '1000') }}"
                                               placeholder="0">
                                    </div>
                                </div>
                                <div class="fg">
                                    <label>Cash on Delivery</label>
                                    <div class="iw"><i class="fas fa-money-bill ii"></i>
                                        <select name="cod_enabled">
                                            <option value="Enabled"  {{ ($settings['cod_enabled'] ?? '') == 'Enabled'  ? 'selected' : '' }}>Enabled</option>
                                            <option value="Disabled" {{ ($settings['cod_enabled'] ?? '') == 'Disabled' ? 'selected' : '' }}>Disabled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fc-footer">
                            <button type="submit" class="btn-save"><i class="fas fa-floppy-disk"></i> Save Shipping</button>
                        </div>
                    </div>
                </form>

            </div>{{-- /general --}}

            {{-- ── PROFILE TAB ── --}}
            <div class="tab-panel" id="profile">
                <form method="POST" action="{{ route('admin.settings.profile') }}" enctype="multipart/form-data">
                    @csrf {{-- ✅ CSRF token --}}
                    <div class="form-card">
                        <div class="fc-header">
                            <div class="fc-icon"><i class="fas fa-user-pen"></i></div>
                            <div>
                                <div class="fc-title">Admin Profile</div>
                                <div class="fc-sub">Update your name, email and photo</div>
                            </div>
                        </div>
                        <div class="fc-body">
                            <div class="fields-grid">
                                <div class="fg">
                                    <label>Full Name</label>
                                    <div class="iw"><i class="fas fa-user ii"></i>
                                        <input type="text" name="name"
                                               value="{{ old('name', $user->name) }}"
                                               placeholder="Full name">
                                    </div>
                                    @error('name') <p class="ferr"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                                </div>
                                <div class="fg">
                                    <label>Email Address</label>
                                    <div class="iw"><i class="fas fa-envelope ii"></i>
                                        <input type="email" name="email"
                                               value="{{ old('email', $user->email) }}"
                                               placeholder="admin@example.com">
                                    </div>
                                    @error('email') <p class="ferr"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                                </div>
                                <div class="fg" style="grid-column: 1 / -1;">
                                    <label>Profile Photo</label>
                                    @if($user->profile_image)
                                        <div style="margin-bottom:8px;">
                                            <img src="{{ asset('uploads/profile/'.$user->profile_image) }}"
                                                 style="width:60px;height:60px;border-radius:50%;object-fit:cover;border:2px solid var(--border);">
                                        </div>
                                    @endif
                                    <div class="iw"><i class="fas fa-image ii"></i>
                                        <input type="file" name="profile_image" accept="image/*">
                                    </div>
                                    @error('profile_image') <p class="ferr"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="fc-footer">
                            <button type="submit" class="btn-save"><i class="fas fa-floppy-disk"></i> Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>{{-- /profile --}}

            {{-- ── SECURITY TAB ── --}}
            <div class="tab-panel" id="security">
                <form method="POST" action="{{ route('admin.settings.security') }}">
                    @csrf {{-- ✅ CSRF token --}}
                    <div class="form-card">
                        <div class="fc-header">
                            <div class="fc-icon danger"><i class="fas fa-lock"></i></div>
                            <div>
                                <div class="fc-title">Change Password</div>
                                <div class="fc-sub">Update your admin account password</div>
                            </div>
                        </div>
                        <div class="fc-body">
                            <div class="fields-grid cols-1" style="max-width:460px;">
                                <div class="fg">
                                    <label>Current Password</label>
                                    <div class="iw"><i class="fas fa-lock ii"></i>
                                        <input type="password" name="current_password" placeholder="Enter current password">
                                    </div>
                                    @error('current_password') <p class="ferr"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                                </div>
                                <div class="fg">
                                    <label>New Password</label>
                                    <div class="iw"><i class="fas fa-key ii"></i>
                                        <input type="password" name="password"
                                               id="newPwd" placeholder="Min. 8 characters"
                                               oninput="checkStrength(this.value)">
                                    </div>
                                    <div style="display:flex;gap:4px;margin-top:6px;">
                                        <span id="s1" style="flex:1;height:3px;background:var(--border);border-radius:99px;transition:background .3s;"></span>
                                        <span id="s2" style="flex:1;height:3px;background:var(--border);border-radius:99px;transition:background .3s;"></span>
                                        <span id="s3" style="flex:1;height:3px;background:var(--border);border-radius:99px;transition:background .3s;"></span>
                                        <span id="s4" style="flex:1;height:3px;background:var(--border);border-radius:99px;transition:background .3s;"></span>
                                    </div>
                                    <p id="strengthLabel" style="font-size:11px;color:var(--muted);margin-top:3px;"></p>
                                    @error('password') <p class="ferr"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p> @enderror
                                </div>
                                <div class="fg">
                                    <label>Confirm New Password</label>
                                    <div class="iw"><i class="fas fa-shield-halved ii"></i>
                                        <input type="password" name="password_confirmation" placeholder="Repeat new password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fc-footer">
                            <button type="submit" class="btn-danger"><i class="fas fa-key"></i> Change Password</button>
                        </div>
                    </div>
                </form>
            </div>{{-- /security --}}

            {{-- ── NOTIFICATIONS TAB ── --}}
            <!-- <div class="tab-panel" id="notifications">
                <form method="POST" action="{{ route('admin.settings.notifications') }}">
                    @csrf {{-- ✅ CSRF token --}}
                    <div class="form-card">
                        <div class="fc-header">
                            <div class="fc-icon"><i class="fas fa-bell"></i></div>
                            <div>
                                <div class="fc-title">Notification Preferences</div>
                                <div class="fc-sub">Choose which alerts you want to receive</div>
                            </div>
                        </div>
                        <div class="fc-body">
                            <div class="toggle-list">
                                <div class="toggle-item">
                                    <div class="toggle-item-info">
                                        <div class="toggle-item-icon"><i class="fas fa-envelope"></i></div>
                                        <div class="toggle-item-text">
                                            <strong>Email Notifications</strong>
                                            <span>Receive updates via email</span>
                                        </div>
                                    </div>
                                    {{-- ✅ name attribute যোগ করা হয়েছে --}}
                                    <label class="switch">
                                        <input type="checkbox" name="notify_email" value="1"
                                               {{ ($settings['notify_email'] ?? '1') == '1' ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="toggle-item">
                                    <div class="toggle-item-info">
                                        <div class="toggle-item-icon"><i class="fas fa-shopping-bag"></i></div>
                                        <div class="toggle-item-text">
                                            <strong>New Order Alerts</strong>
                                            <span>Notified when a new order is placed</span>
                                        </div>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" name="notify_order" value="1"
                                               {{ ($settings['notify_order'] ?? '1') == '1' ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="toggle-item">
                                    <div class="toggle-item-info">
                                        <div class="toggle-item-icon"><i class="fas fa-box-open"></i></div>
                                        <div class="toggle-item-text">
                                            <strong>Low Stock Alerts</strong>
                                            <span>Alert when product stock is low</span>
                                        </div>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" name="notify_stock" value="1"
                                               {{ ($settings['notify_stock'] ?? '0') == '1' ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div class="toggle-item">
                                    <div class="toggle-item-info">
                                        <div class="toggle-item-icon"><i class="fas fa-user-plus"></i></div>
                                        <div class="toggle-item-text">
                                            <strong>New Customer Signup</strong>
                                            <span>Alert when a new customer registers</span>
                                        </div>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" name="notify_customer" value="1"
                                               {{ ($settings['notify_customer'] ?? '1') == '1' ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="fc-footer">
                            <button type="submit" class="btn-save"><i class="fas fa-floppy-disk"></i> Save Preferences</button>
                        </div>
                    </div>
                </form>
            </div>{{-- /notifications --}} -->

        </div>{{-- /as-right --}}
    </div>{{-- /as-layout --}}
</div>

<script>
// ── Tab switching — active tab URL hash এ save করা হচ্ছে ──
const tabs = document.querySelectorAll('.nav-tab-btn');
const panels = document.querySelectorAll('.tab-panel');

function activateTab(tabId) {
    tabs.forEach(b => b.classList.remove('active'));
    panels.forEach(p => p.classList.remove('active'));
    const btn = document.querySelector(`[data-tab="${tabId}"]`);
    const panel = document.getElementById(tabId);
    if (btn) btn.classList.add('active');
    if (panel) panel.classList.add('active');
}

tabs.forEach(btn => {
    btn.addEventListener('click', () => {
        activateTab(btn.dataset.tab);
        location.hash = btn.dataset.tab;
    });
});

// redirect এর পরে সঠিক tab খোলা
const hash = location.hash.replace('#', '');
if (hash && document.getElementById(hash)) {
    activateTab(hash);
} @if(session('active_tab'))
else { activateTab('{{ session('active_tab') }}'); }
@endif

// Password strength
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
    lbl.style.color  = score > 0 ? colors[score-1] : 'var(--muted)';
}
</script>
@endsection
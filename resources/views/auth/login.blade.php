<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Bouquetta</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --pink: #E91E63; --pink-dark: #C2185B; --pink-light: #FCE4EC; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #FCE4EC 0%, #fff 50%, #EDE7F6 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .auth-container { background: #fff; border-radius: 24px; box-shadow: 0 20px 60px rgba(233,30,99,.15); padding: 3rem 2.5rem; width: 100%; max-width: 420px; }
        .auth-logo { text-align: center; margin-bottom: 2rem; }
        .auth-logo h1 { font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--pink); }
        .auth-logo p { color: #888; font-size: .9rem; margin-top: .25rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: .85rem; font-weight: 600; color: #333; margin-bottom: .4rem; }
        input { width: 100%; padding: .8rem 1rem; border: 1.5px solid #e9ecef; border-radius: 10px; font-size: .9rem; font-family: inherit; transition: border-color .2s; }
        input:focus { outline: none; border-color: var(--pink); box-shadow: 0 0 0 3px rgba(233,30,99,.1); }
        .input-error { border-color: #dc3545 !important; }
        .error-msg { color: #dc3545; font-size: .8rem; margin-top: .3rem; }
        .btn-submit { width: 100%; padding: .9rem; background: var(--pink); color: #fff; border: none; border-radius: 50px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all .25s; margin-top: .5rem; }
        .btn-submit:hover { background: var(--pink-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(233,30,99,.35); }
        .auth-footer { text-align: center; margin-top: 1.5rem; font-size: .88rem; color: #666; }
        .auth-footer a { color: var(--pink); font-weight: 600; }
        .divider { text-align: center; color: #aaa; font-size: .85rem; margin: 1.5rem 0; position: relative; }
        .divider::before { content: ''; position: absolute; left: 0; top: 50%; width: 40%; height: 1px; background: #e9ecef; }
        .divider::after { content: ''; position: absolute; right: 0; top: 50%; width: 40%; height: 1px; background: #e9ecef; }
        .remember-row { display: flex; align-items: center; justify-content: space-between; }
        .check-label { display: flex; align-items: center; gap: .5rem; font-size: .85rem; cursor: pointer; }
        .check-label input[type=checkbox] { width: 16px; height: 16px; accent-color: var(--pink); }
        .alert-error { background: #f8d7da; color: #721c24; padding: .75rem 1rem; border-radius: 10px; font-size: .85rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
<div class="auth-container">
    <div class="auth-logo">
        <h1>🌸 Bouquetta</h1>
        <p>Masuk ke akun kamu</p>
    </div>

    @if($errors->has('email'))
        <div class="alert-error">{{ $errors->first('email') }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   placeholder="nama@email.com" autocomplete="email"
                   class="{{ $errors->has('email') ? 'input-error' : '' }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   placeholder="••••••••" autocomplete="current-password" required>
        </div>
        <div class="form-group remember-row">
            <label class="check-label">
                <input type="checkbox" name="remember" value="1"> Ingat saya
            </label>
        </div>
        <button type="submit" class="btn-submit">Masuk →</button>
    </form>

    <div class="divider">atau</div>
    <div class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>
    <div style="text-align:center;margin-top:1rem">
        <a href="{{ route('home') }}" style="color:#999;font-size:.85rem">← Kembali ke toko</a>
    </div>
</div>
</body>
</html>
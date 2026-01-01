<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Newsletters AI — preview</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <style>
            :root {
                --bg: #f7f9fc;
                --card: #ffffff;
                --muted: #4a5568;
                --primary: #0dd6c6;
                --primary-strong: #0cb0a7;
                --ink: #0e1628;
                --accent: #3e7bff;
                --border: #e3e8f0;
                --radius: 16px;
                --shadow: 0 20px 60px rgba(12, 19, 36, 0.12);
                --card-shadow: 0 12px 30px rgba(12, 19, 36, 0.12);
                --surface: radial-gradient(circle at 12% 10%, rgba(14, 214, 198, 0.12), transparent 25%),
                            radial-gradient(circle at 82% 0%, rgba(62, 123, 255, 0.12), transparent 30%),
                            radial-gradient(circle at 70% 70%, rgba(0, 0, 0, 0.04), transparent 30%),
                            var(--bg);
                --hero-start: rgba(255, 255, 255, 0.9);
                --hero-end: rgba(19, 35, 78, 0.18);
                --cta-start: rgba(124, 240, 214, 0.14);
                --cta-end: rgba(62, 123, 255, 0.12);
                --stat-bg: rgba(14, 22, 40, 0.05);
                --chip-bg: rgba(14, 22, 40, 0.06);
                --chip-border: rgba(14, 22, 40, 0.08);
                --chip-text: #223352;
                --btn-bg: #0f172a;
                --btn-fg: #f7f9fc;
                --tag-bg: rgba(62, 123, 255, 0.12);
                --tag-border: rgba(62, 123, 255, 0.35);
                --tag-text: #24314d;
                color: var(--ink);
                background: var(--bg);
                font-family: 'Instrument Sans', system-ui, -apple-system, sans-serif;
            }

            :root[data-theme="dark"],
            @media (prefers-color-scheme: dark) {
                :root:not([data-theme="light"]) {
                    --bg: #05060a;
                    --card: #0c0f16;
                    --muted: #a0a6b5;
                    --primary: #7cf0d6;
                    --primary-strong: #3de0b9;
                    --ink: #e6e9f2;
                    --accent: #7aa5ff;
                    --border: #151925;
                    --shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
                    --card-shadow: 0 12px 30px rgba(0, 0, 0, 0.24);
                    --surface: radial-gradient(circle at 10% 10%, rgba(124, 240, 214, 0.12), transparent 25%),
                                radial-gradient(circle at 80% 0%, rgba(122, 165, 255, 0.12), transparent 30%),
                                radial-gradient(circle at 70% 70%, rgba(255, 255, 255, 0.04), transparent 30%),
                                var(--bg);
                    --hero-start: rgba(124, 240, 214, 0.12);
                    --hero-end: rgba(10, 16, 25, 0.9);
                    --cta-start: rgba(124, 240, 214, 0.16);
                    --cta-end: rgba(10, 16, 25, 0.85);
                    --stat-bg: rgba(255, 255, 255, 0.04);
                    --chip-bg: #0d1118;
                    --chip-border: var(--border);
                    --chip-text: #e6e9f2;
                    --btn-bg: #0d1118;
                    --btn-fg: #e6e9f2;
                    --tag-bg: rgba(122, 165, 255, 0.12);
                    --tag-border: rgba(122, 165, 255, 0.3);
                    --tag-text: #dfe7ff;
                    color-scheme: dark;
                }
            }

            :root[data-theme="light"] {
                color-scheme: light;
            }

            * { box-sizing: border-box; }
            body {
                margin: 0;
                background: var(--surface);
                min-height: 100vh;
                color: var(--ink);
                transition: background 0.2s ease, color 0.2s ease;
            }

            a { color: inherit; text-decoration: none; }

            .page {
                max-width: 1200px;
                margin: 0 auto;
                padding: 32px 20px 64px;
            }

            header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
            }

            .brand {
                display: flex;
                align-items: center;
                gap: 10px;
                font-weight: 700;
                letter-spacing: -0.02em;
            }

            .logo {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: linear-gradient(135deg, #7cf0d6, #7aa5ff);
                display: grid;
                place-items: center;
                font-weight: 800;
                color: #04121e;
                box-shadow: var(--shadow);
            }

            nav { display: flex; gap: 14px; align-items: center; flex-wrap: wrap; }

            .link-muted { color: var(--muted); font-weight: 500; }

            .btn {
                padding: 11px 18px;
                border-radius: 12px;
                border: 1px solid var(--border);
                background: var(--btn-bg);
                color: var(--btn-fg);
                font-weight: 600;
                letter-spacing: -0.01em;
                transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
            }

            .btn.primary {
                background: linear-gradient(135deg, var(--primary), var(--accent));
                color: #031019;
                box-shadow: 0 10px 30px rgba(124, 240, 214, 0.3);
                border: none;
            }

            .btn:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3); }

            .theme-select {
                padding: 9px 10px;
                border-radius: 12px;
                border: 1px solid var(--border);
                background: var(--card);
                color: var(--ink);
                font-weight: 600;
                letter-spacing: -0.01em;
                min-width: 130px;
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            }

            .hero {
                margin-top: 48px;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 28px;
                align-items: center;
            }

            .headline {
                font-size: clamp(32px, 4vw, 52px);
                line-height: 1.05;
                letter-spacing: -0.03em;
                margin: 0 0 16px;
            }

            .lead { color: var(--muted); margin: 0 0 18px; font-size: 18px; }

            .meta-row { display: flex; gap: 12px; flex-wrap: wrap; margin: 22px 0 0; }

            .pill {
                padding: 8px 12px;
                border-radius: 999px;
                border: 1px solid var(--chip-border);
                background: var(--chip-bg);
                color: var(--chip-text);
                font-weight: 600;
                font-size: 13px;
            }

            .hero-card {
                background: linear-gradient(155deg, var(--hero-start), var(--hero-end));
                border: 1px solid var(--border);
                border-radius: 22px;
                padding: 22px;
                box-shadow: var(--shadow);
                position: relative;
                overflow: hidden;
            }

            .hero-card::after {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at 20% 20%, rgba(124, 240, 214, 0.18), transparent 40%),
                            radial-gradient(circle at 82% 12%, rgba(62, 123, 255, 0.18), transparent 45%);
                pointer-events: none;
            }

            .hero-card h3 { margin: 0 0 10px; font-size: 18px; letter-spacing: -0.01em; }
            .hero-card p { margin: 0 0 16px; color: var(--muted); }

            .mini-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                gap: 12px;
            }

            .stat {
                padding: 12px;
                background: var(--stat-bg);
                border-radius: 14px;
                border: 1px solid var(--border);
            }

            .stat .value { font-weight: 700; font-size: 18px; }
            .stat .label { color: var(--muted); font-size: 13px; }

            .section-title { margin: 56px 0 18px; font-size: 22px; letter-spacing: -0.01em; }

            .card-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                gap: 16px;
            }

            .card {
                background: var(--card);
                border: 1px solid var(--border);
                border-radius: 18px;
                padding: 18px;
                box-shadow: var(--card-shadow);
                display: grid;
                gap: 12px;
            }

            .card small { color: var(--muted); font-weight: 600; letter-spacing: 0.02em; }
            .card h4 { margin: 0; font-size: 18px; letter-spacing: -0.01em; }
            .card p { margin: 0; color: var(--muted); }

            .tag-row { display: flex; flex-wrap: wrap; gap: 8px; }

            .tag {
                padding: 6px 10px;
                border-radius: 999px;
                background: var(--tag-bg);
                border: 1px solid var(--tag-border);
                color: var(--tag-text);
                font-weight: 600;
                font-size: 13px;
            }

            .cta {
                margin-top: 48px;
                padding: 24px;
                border-radius: 18px;
                border: 1px solid var(--border);
                background: linear-gradient(120deg, var(--cta-start), var(--cta-end));
                display: grid;
                gap: 12px;
                align-items: center;
            }

            .cta strong { font-size: 20px; letter-spacing: -0.01em; }
            .cta p { margin: 0; color: var(--muted); }

            footer { margin-top: 40px; color: var(--muted); font-size: 13px; text-align: center; }

            @media (max-width: 640px) {
                header { flex-direction: column; align-items: flex-start; }
                nav { width: 100%; justify-content: flex-start; flex-wrap: wrap; }
            }
        </style>
        <script>
            (() => {
                const storageKey = 'flux.appearance';
                const selectId = 'theme-select';
                const media = window.matchMedia('(prefers-color-scheme: dark)');

                const systemTheme = () => (media.matches ? 'dark' : 'light');

                const applyTheme = (choice) => {
                    const theme = choice === 'system' ? systemTheme() : choice;

                    // Sync CSS variables
                    if (choice === 'system') {
                        document.documentElement.removeAttribute('data-theme');
                    } else {
                        document.documentElement.setAttribute('data-theme', theme);
                    }

                    // Sync class-based theming (Flux)
                    document.documentElement.classList.toggle('dark', theme === 'dark');

                    // If Flux is loaded, let it handle its own housekeeping too
                    if (window.Flux && typeof window.Flux.applyAppearance === 'function') {
                        window.Flux.applyAppearance(choice);
                    }

                    const select = document.getElementById(selectId);
                    if (select && select.value !== choice) {
                        select.value = choice;
                    }
                };

                const init = () => {
                    const saved = localStorage.getItem(storageKey) || 'system';
                    applyTheme(saved);

                    const select = document.getElementById(selectId);
                    if (!select) return;
                    select.value = saved;

                    select.addEventListener('change', (event) => {
                        const choice = event.target.value;
                        localStorage.setItem(storageKey, choice);
                        applyTheme(choice);
                    });

                    media.addEventListener('change', () => {
                        const current = localStorage.getItem(storageKey) || 'system';
                        if (current === 'system') {
                            applyTheme('system');
                        }
                    });
                };

                document.addEventListener('DOMContentLoaded', init);
            })();
        </script>
    </head>
    <body>
        <div class="page">
            <header>
                <div class="brand">
                    <div class="logo">AI</div>
                    <div>
                        <div>Newsletters AI</div>
                        <small style="color: var(--muted); font-weight: 600;">curadoria diária</small>
                    </div>
                </div>
                <select id="theme-select" class="theme-select" aria-label="Selecionar tema">
                    <option value="system">Sistema</option>
                    <option value="light">Claro</option>
                    <option value="dark">Escuro</option>
                </select>
                @if (Route::has('login'))
                    <nav>
                        <a href="#catalog" class="link-muted">Catálogo</a>
                        <a href="#categories" class="link-muted">Categorias</a>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn">Entrar</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn primary">Criar conta</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <section class="hero">
                <div>
                    <p class="pill">preview · clone newsletters.ai</p>
                    <h1 class="headline">Encontre newsletters incríveis de IA e produto em minutos.</h1>
                    <p class="lead">Curadoria humana, insights gerados por IA e prévias em tempo real para você decidir onde assinar. Zero ruído, só bons conteúdos.</p>
                    <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:10px;">
                        <a href="#catalog" class="btn primary">Explorar agora</a>
                        <a href="#cta" class="btn">Receber drops semanais</a>
                    </div>
                    <div class="meta-row">
                        <span class="pill">+120 curadorias</span>
                        <span class="pill">Atualizado diariamente</span>
                        <span class="pill">Preview gerado por IA</span>
                    </div>
                </div>

                <div class="hero-card">
                    <h3>Preview de hoje · AI Product Digest</h3>
                    <p>"Cinco lançamentos que valem sua caixa de entrada: agentes autônomos em produção, UX para copilots e pricing para add-ons de IA."</p>
                    <div class="mini-grid">
                        <div class="stat">
                            <div class="value">4.8★</div>
                            <div class="label">Leitores</div>
                        </div>
                        <div class="stat">
                            <div class="value">27k</div>
                            <div class="label">Assinantes</div>
                        </div>
                        <div class="stat">
                            <div class="value">Weekly</div>
                            <div class="label">Frequência</div>
                        </div>
                        <div class="stat">
                            <div class="value">PT/EN</div>
                            <div class="label">Idiomas</div>
                        </div>
                    </div>
                </div>
            </section>

            <h2 class="section-title" id="catalog">Destaques da semana</h2>
            <div class="card-grid">
                <div class="card">
                    <small>AI Strategy</small>
                    <h4>Signal & Noise</h4>
                    <p>Resumo executivo diário de lançamentos e frameworks para times de produto que adotam IA.</p>
                    <div class="tag-row">
                        <span class="tag">Produto</span>
                        <span class="tag">AI</span>
                        <span class="tag">B2B</span>
                    </div>
                </div>
                <div class="card">
                    <small>UX & Copy</small>
                    <h4>Prompt Patterns</h4>
                    <p>Casos práticos de UX para copilots, exemplos de prompts anotados e guidelines de tom.</p>
                    <div class="tag-row">
                        <span class="tag">UX</span>
                        <span class="tag">Conteúdo</span>
                        <span class="tag">IA aplicada</span>
                    </div>
                </div>
                <div class="card">
                    <small>Data & Ops</small>
                    <h4>Pipeline Weekly</h4>
                    <p>Playbooks de observabilidade, custos e rollout seguro para features de IA.</p>
                    <div class="tag-row">
                        <span class="tag">MLOps</span>
                        <span class="tag">Infra</span>
                        <span class="tag">Custos</span>
                    </div>
                </div>
            </div>

            <h2 class="section-title" id="categories">Categorias rápidas</h2>
            <div class="tag-row" style="margin-bottom: 12px;">
                <span class="tag">AI Produto</span>
                <span class="tag">Design</span>
                <span class="tag">Engenharia</span>
                <span class="tag">Growth</span>
                <span class="tag">News</span>
                <span class="tag">DevRel</span>
                <span class="tag">Startups</span>
                <span class="tag">Pesquisa</span>
            </div>

            <h2 class="section-title">Como funciona</h2>
            <div class="card-grid">
                <div class="card">
                    <h4>1. Curadoria humana</h4>
                    <p>Selecionamos newsletters que publicam com consistência, transparência de fontes e bom histórico.</p>
                </div>
                <div class="card">
                    <h4>2. Preview guiado por IA</h4>
                    <p>Resumo de edições recentes, tópicos cobertos, cadência e nível (iniciantes → avançado).</p>
                </div>
                <div class="card">
                    <h4>3. Match com seu perfil</h4>
                    <p>Filtros por idioma, frequência, área e densidade para você assinar com confiança.</p>
                </div>
            </div>

            <div class="cta" id="cta">
                <strong>Quer lançar a sua? Teste o editor e autosave agora.</strong>
                <p>O editor markdown com preview e autosave já está no ar. Crie uma note em 30 segundos.</p>
                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <a href="{{ route('notes.new') }}" class="btn primary">Nova note</a>
                    <a href="{{ route('dashboard') }}" class="btn">Ir para dashboard</a>
                </div>
            </div>

            <footer>Construído em Laravel + Livewire. Página inicial em modo preview.</footer>
        </div>
    </body>
    </html>

{{--
    resources/views/partials/manual-infographic.blade.php
    Included in welcome.blade.php via: @include('partials.manual-infographic')
--}}

<section id="manual" class="rka-manual">

    <div class="rka-manual__container">

        {{-- Header --}}
        <div class="rka-manual__header">
            <span class="rka-manual__eyebrow">Getting Started</span>
            <h2 class="rka-manual__title">User Manual</h2>
            <p class="rka-manual__subtitle">
                Everything you need to know to register, join competitions,
                submit artwork, and manage your creative journey.
            </p>
        </div>

        {{-- Infographic Steps --}}
        <div class="rka-manual__track">

            {{-- Step 1 --}}
            <div class="rka-manual__step" style="--accent: #8b5cf6; --accent-bg: #ede9fe; --accent-text: #5b21b6; --delay: 0ms;">
                <div class="rka-manual__connector" aria-hidden="true">
                    <div class="rka-manual__dot"></div>
                    <div class="rka-manual__line"></div>
                </div>
                <div class="rka-manual__card">
                    <div class="rka-manual__card-head">
                        <span class="rka-manual__num">01</span>
                        <div class="rka-manual__icon" aria-hidden="true">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="rka-manual__card-title">Create Your Account</h3>
                    <ol class="rka-manual__list">
                        <li>Click the <strong>Register</strong> button in the top navigation.</li>
                        <li>Select your role — Student, Teacher, or Caregiver.</li>
                        <li>Fill in all required personal information.</li>
                        <li>Set a password and submit the form.</li>
                    </ol>
                    <a href="{{ route('register') }}" class="rka-manual__cta">
                        Register now
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="rka-manual__step" style="--accent: #10b981; --accent-bg: #d1fae5; --accent-text: #065f46; --delay: 120ms;">
                <div class="rka-manual__connector" aria-hidden="true">
                    <div class="rka-manual__dot"></div>
                    <div class="rka-manual__line"></div>
                </div>
                <div class="rka-manual__card">
                    <div class="rka-manual__card-head">
                        <span class="rka-manual__num">02</span>
                        <div class="rka-manual__icon" aria-hidden="true">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="rka-manual__card-title">Join a Competition</h3>
                    <ol class="rka-manual__list">
                        <li>Log in and open your dashboard.</li>
                        <li>Browse the list of active competitions.</li>
                        <li>Read eligibility rules and deadlines carefully.</li>
                        <li>Click <strong>Join Competition</strong> to enrol.</li>
                    </ol>
                    <a href="{{ route('login') }}" class="rka-manual__cta">
                        Go to dashboard
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="rka-manual__step" style="--accent: #f59e0b; --accent-bg: #fef3c7; --accent-text: #92400e; --delay: 240ms;">
                <div class="rka-manual__connector" aria-hidden="true">
                    <div class="rka-manual__dot"></div>
                    <div class="rka-manual__line"></div>
                </div>
                <div class="rka-manual__card">
                    <div class="rka-manual__card-head">
                        <span class="rka-manual__num">03</span>
                        <div class="rka-manual__icon" aria-hidden="true">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="16 16 12 12 8 16"/>
                                <line x1="12" y1="12" x2="12" y2="21"/>
                                <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="rka-manual__card-title">Submit Your Artwork</h3>
                    <ol class="rka-manual__list">
                        <li>Open the competition you joined.</li>
                        <li>Click <strong>Upload Artwork</strong>.</li>
                        <li>Select a JPG or PNG file — max <strong>5 MB</strong>.</li>
                        <li>Add a title and short description.</li>
                        <li>Submit. Submissions lock after confirmation.</li>
                    </ol>
                </div>
            </div>

            {{-- Step 4 --}}
            <div class="rka-manual__step rka-manual__step--last" style="--accent: #ef4444; --accent-bg: #fee2e2; --accent-text: #991b1b; --delay: 360ms;">
                <div class="rka-manual__connector" aria-hidden="true">
                    <div class="rka-manual__dot"></div>
                </div>
                <div class="rka-manual__card">
                    <div class="rka-manual__card-head">
                        <span class="rka-manual__num">04</span>
                        <div class="rka-manual__icon" aria-hidden="true">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="6"/>
                                <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="rka-manual__card-title">Results &amp; Certificates</h3>
                    <ol class="rka-manual__list">
                        <li>Results are published after jury evaluation.</li>
                        <li>Scores and feedback appear in your dashboard.</li>
                        <li>Certificates are generated by your teacher once results are finalised.</li>
                    </ol>
                </div>
            </div>

        </div>

        {{-- Footer tip --}}
        <div class="rka-manual__tip">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <span>Need help? Contact your teacher or check the <a href="{{ route('home') }}#faq">FAQ section</a> below.
            </span>        
        </div>

    </div>
</section>

<style>
/* ─────────────────────────────────────────────
   Rang Kala Academy · User Manual Infographic
   File: resources/views/partials/manual-infographic.blade.php
   All classes are prefixed rka-manual__ to avoid
   any conflicts with existing Tailwind styles.
───────────────────────────────────────────── */

.rka-manual {
    position: relative;
    padding: 7rem 0;
    background: #fafafa;
    overflow: hidden;
}

/* Ambient blobs */
.rka-manual::before,
.rka-manual::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    z-index: 0;
    filter: blur(90px);
}
.rka-manual::before {
    width: 420px; height: 420px;
    top: -100px; left: -80px;
    background: #ede9fe;
    opacity: 0.55;
}
.rka-manual::after {
    width: 380px; height: 380px;
    bottom: -80px; right: -60px;
    background: #d1fae5;
    opacity: 0.45;
}

.rka-manual__container {
    position: relative;
    z-index: 1;
    max-width: 780px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* ── Header ── */
.rka-manual__header {
    text-align: center;
    margin-bottom: 4.5rem;
}

.rka-manual__eyebrow {
    display: inline-block;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #9ca3af;
    margin-bottom: 0.85rem;
}

.rka-manual__title {
    font-size: clamp(2rem, 5vw, 2.75rem);
    font-weight: 700;
    color: #111827;
    margin: 0 0 1rem;
    letter-spacing: -0.025em;
    line-height: 1.15;
}

.rka-manual__subtitle {
    font-size: 1.05rem;
    color: #6b7280;
    max-width: 500px;
    margin: 0 auto;
    line-height: 1.75;
}

/* ── Step track ── */
.rka-manual__track {
    display: flex;
    flex-direction: column;
    gap: 0;
}

/* ── Single step row ── */
.rka-manual__step {
    display: grid;
    grid-template-columns: 56px 1fr;
    gap: 0 1.5rem;
    /* Entrance animation */
    opacity: 0;
    transform: translateY(18px);
    animation: rka-in 0.5s ease forwards;
    animation-delay: var(--delay, 0ms);
}

@keyframes rka-in {
    to { opacity: 1; transform: translateY(0); }
}

/* ── Connector column (dot + line) ── */
.rka-manual__connector {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.rka-manual__dot {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--accent-bg);
    border: 2px solid var(--accent);
    flex-shrink: 0;
    margin-top: 1.75rem;
    position: relative;
    z-index: 1;
    transition: transform 0.2s ease;
}

.rka-manual__dot::after {
    content: '';
    position: absolute;
    inset: 5px;
    border-radius: 50%;
    background: var(--accent);
    opacity: 0.7;
}

.rka-manual__step:hover .rka-manual__dot {
    transform: scale(1.15);
}

.rka-manual__line {
    width: 2px;
    flex: 1;
    min-height: 24px;
    background: linear-gradient(to bottom, var(--accent) 0%, transparent 100%);
    opacity: 0.2;
    margin: 4px 0;
}

/* ── Card ── */
.rka-manual__card {
    background: #ffffff;
    border: 1px solid #f3f4f6;
    border-left: 3px solid var(--accent);
    border-radius: 1.25rem;
    padding: 1.75rem 1.75rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04), 0 6px 24px rgba(0,0,0,0.04);
    transition: box-shadow 0.25s ease, transform 0.25s ease;
}

.rka-manual__step:hover .rka-manual__card {
    box-shadow: 0 4px 28px rgba(0,0,0,0.09);
    transform: translateX(4px);
}

.rka-manual__card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.85rem;
}

.rka-manual__num {
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    color: var(--accent);
    background: var(--accent-bg);
    padding: 0.2rem 0.55rem;
    border-radius: 999px;
}

.rka-manual__icon {
    color: var(--accent);
    opacity: 0.35;
}

.rka-manual__card-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 0.9rem;
    letter-spacing: -0.01em;
}

/* ── Ordered list ── */
.rka-manual__list {
    list-style: none;
    padding: 0;
    margin: 0 0 1rem;
    counter-reset: rka-counter;
    display: flex;
    flex-direction: column;
    gap: 0.45rem;
}

.rka-manual__list li {
    counter-increment: rka-counter;
    display: flex;
    align-items: baseline;
    gap: 0.6rem;
    font-size: 0.9rem;
    color: #4b5563;
    line-height: 1.65;
}

.rka-manual__list li::before {
    content: counter(rka-counter);
    flex-shrink: 0;
    width: 19px;
    height: 19px;
    border-radius: 50%;
    background: var(--accent-bg);
    color: var(--accent-text);
    font-size: 0.65rem;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}

.rka-manual__list strong {
    font-weight: 600;
    color: #1f2937;
}

/* ── CTA link ── */
.rka-manual__cta {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    margin-top: 0.25rem;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--accent);
    text-decoration: none;
    letter-spacing: 0.01em;
    transition: gap 0.15s ease, opacity 0.15s ease;
}

.rka-manual__cta:hover {
    gap: 0.65rem;
    opacity: 0.8;
}

/* ── Tip bar ── */
.rka-manual__tip {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 2.5rem;
    padding: 0.9rem 1.5rem;
    background: #fff;
    border: 1px solid #f3f4f6;
    border-radius: 0.875rem;
    font-size: 0.875rem;
    color: #6b7280;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.rka-manual__tip svg {
    flex-shrink: 0;
    color: #9ca3af;
}

.rka-manual__tip a {
    color: #111827;
    font-weight: 600;
    text-decoration: underline;
    text-underline-offset: 2px;
    transition: color 0.15s;
}

.rka-manual__tip a:hover {
    color: #8b5cf6;
}

/* ── Responsive ── */
@media (max-width: 560px) {
    .rka-manual__step {
        grid-template-columns: 40px 1fr;
        gap: 0 1rem;
    }

    .rka-manual__dot {
        width: 28px;
        height: 28px;
        margin-top: 1.5rem;
    }

    .rka-manual__card {
        padding: 1.25rem 1.25rem 1rem;
    }

    .rka-manual__icon {
        display: none;
    }
}
</style>
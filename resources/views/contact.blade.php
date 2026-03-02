@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <div class="contact-page">

        {{-- ── Hero ──────────────────────────────────────── --}}
        <section class="contact-hero">
            <div class="contact-hero-glow"></div>
            <div class="contact-hero-inner">
                <div class="contact-hero-badge">
                    <i class="ri-mail-send-line"></i> Get in Touch
                </div>
                <h1 class="contact-hero-title">Let's <span class="text-orange">Talk</span></h1>
                <p class="contact-hero-sub">Have a question, feedback, or just want to say hello? We'd love to hear from
                    you.</p>
            </div>
        </section>

        {{-- ── Main Grid ─────────────────────────────────── --}}
        <section class="contact-main container mx-auto px-6">
            <div class="contact-grid">

                {{-- Left: Info Cards --}}
                <div class="contact-info">

                    <div class="info-card" data-aos="fade-right" data-aos-delay="0">
                        <div class="info-icon" style="background:rgba(255,107,0,0.1);border-color:rgba(255,107,0,0.25);">
                            <i class="ri-map-pin-2-fill" style="color:#FF6B00;"></i>
                        </div>
                        <div>
                            <div class="info-label">Our Location</div>
                            <div class="info-value">42 MG Road, Connaught Place<br>New Delhi, 110001, India</div>
                        </div>
                    </div>

                    <div class="info-card" data-aos="fade-right" data-aos-delay="80">
                        <div class="info-icon" style="background:rgba(59,130,246,0.1);border-color:rgba(59,130,246,0.25);">
                            <i class="ri-mail-fill" style="color:#3B82F6;"></i>
                        </div>
                        <div>
                            <div class="info-label">Email Us</div>
                            <div class="info-value"><a href="mailto:hello@orange.style"
                                    class="hover-orange">hello@orange.style</a></div>
                            <div class="info-sub">We reply within 24 hours</div>
                        </div>
                    </div>

                    <div class="info-card" data-aos="fade-right" data-aos-delay="160">
                        <div class="info-icon" style="background:rgba(16,185,129,0.1);border-color:rgba(16,185,129,0.25);">
                            <i class="ri-phone-fill" style="color:#10B981;"></i>
                        </div>
                        <div>
                            <div class="info-label">Call Us</div>
                            <div class="info-value"><a href="tel:+923001234567" class="hover-orange">+92 300 123 4567</a>
                            </div>
                            <div class="info-sub">Mon – Sat, 10am – 8pm</div>
                        </div>
                    </div>

                    {{-- Social --}}
                    <div class="info-social" data-aos="fade-right" data-aos-delay="240">
                        <div class="info-label" style="margin-bottom:14px;">Follow Us</div>
                        <div class="social-row">
                            <a href="https://instagram.com" target="_blank" class="social-btn" title="Instagram">
                                <i class="ri-instagram-line"></i>
                            </a>
                            <a href="https://twitter.com" target="_blank" class="social-btn" title="X / Twitter">
                                <i class="ri-twitter-x-line"></i>
                            </a>
                            <a href="https://facebook.com" target="_blank" class="social-btn" title="Facebook">
                                <i class="ri-facebook-fill"></i>
                            </a>
                            <a href="https://tiktok.com" target="_blank" class="social-btn" title="TikTok">
                                <i class="ri-tiktok-fill"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Right: Contact Form --}}
                <div class="contact-form-wrap" data-aos="fade-left">
                    <div class="contact-form-header">
                        <h2>Send a Message</h2>
                        <p>Fill in the form and we'll get back to you as soon as possible.</p>
                    </div>

                    <form id="contact-form" class="contact-form" onsubmit="handleContactSubmit(event)">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">First Name</label>
                                <input type="text" class="contact-input" placeholder="John" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="contact-input" placeholder="Doe" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="contact-input" placeholder="john@example.com" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <select class="contact-input contact-select" required>
                                <option value="" disabled selected>Select a topic…</option>
                                <option>Order & Shipping</option>
                                <option>Returns & Refunds</option>
                                <option>Product Inquiry</option>
                                <option>Collaboration</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea class="contact-input contact-textarea" rows="5" placeholder="Write your message here…"
                                required></textarea>
                        </div>

                        <button type="submit" class="contact-submit" id="contact-btn">
                            <i class="ri-send-plane-2-fill"></i>
                            <span>Send Message</span>
                        </button>
                    </form>
                </div>

            </div>
        </section>

    </div>
@endsection

@push('styles')
    <style>
        .contact-page {
            padding-bottom: 80px;
        }

        /* ── Hero ──────────────────── */
        .contact-hero {
            position: relative;
            text-align: center;
            padding: 120px 24px 80px;
            overflow: hidden;
        }

        .contact-hero-glow {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 350px;
            background: radial-gradient(ellipse at center, rgba(255, 107, 0, 0.18) 0%, transparent 70%);
            pointer-events: none;
        }

        .contact-hero-inner {
            position: relative;
            z-index: 1;
        }

        .contact-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 107, 0, 0.08);
            border: 1px solid rgba(255, 107, 0, 0.2);
            color: #FF6B00;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 24px;
        }

        .contact-hero-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(3rem, 8vw, 5.5rem);
            font-weight: 800;
            line-height: 1;
            color: #fff;
            margin-bottom: 20px;
        }

        .contact-hero-sub {
            font-size: 1rem;
            color: #888;
            max-width: 520px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* ── Main Grid ─────────────── */
        .contact-main {
            padding: 0 0 40px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 32px;
            align-items: start;
        }

        @media (max-width: 900px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ── Info Cards ───────────── */
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .info-card {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            transition: border-color 0.25s ease, background 0.25s ease;
        }

        .info-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 107, 0, 0.2);
        }

        .info-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border-radius: 12px;
            border: 1px solid;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .info-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #666;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 0.9rem;
            font-weight: 500;
            color: #ddd;
            line-height: 1.5;
        }

        .info-sub {
            font-size: 0.75rem;
            color: #666;
            margin-top: 2px;
        }

        .hover-orange {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s;
        }

        .hover-orange:hover {
            color: #FF6B00;
        }

        /* Social */
        .info-social {
            padding: 20px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
        }

        .social-row {
            display: flex;
            gap: 10px;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #888;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.22s ease;
        }

        .social-btn:hover {
            background: rgba(255, 107, 0, 0.12);
            border-color: rgba(255, 107, 0, 0.35);
            color: #FF6B00;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(255, 107, 0, 0.15);
        }

        /* ── Form ─────────────────── */
        .contact-form-wrap {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 24px;
            padding: 36px;
            backdrop-filter: blur(12px);
        }

        .contact-form-header {
            margin-bottom: 28px;
        }

        .contact-form-header h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
        }

        .contact-form-header p {
            font-size: 0.875rem;
            color: #777;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 500px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
            margin-bottom: 16px;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #666;
        }

        .contact-input {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.09);
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 0.875rem;
            color: #fff;
            font-family: 'Outfit', sans-serif;
            transition: border-color 0.22s ease, box-shadow 0.22s ease, background 0.22s ease;
            width: 100%;
            outline: none;
        }

        .contact-input::placeholder {
            color: #555;
        }

        .contact-input:focus {
            border-color: rgba(255, 107, 0, 0.5);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.08);
            background: rgba(255, 255, 255, 0.06);
        }

        .contact-select {
            cursor: pointer;
        }

        .contact-select option {
            background: #1a1a1a;
            color: #fff;
        }

        .contact-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .contact-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 13px 24px;
        background: linear-gradient(135deg, #FF6B00 0%, #FF8C00 100%);
        border: none;
        border-radius: 9999px;
        color: #fff;
        font-family: 'Syne', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 4px 20px rgba(255, 107, 0, 0.35), 0 0 0 0 rgba(255,107,0,0);
        margin-top: 4px;
        text-transform: uppercase;
    }

    .contact-submit:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 32px rgba(255, 107, 0, 0.5), 0 0 0 0 rgba(255,107,0,0);
        background: linear-gradient(135deg, #FF7A15 0%, #FF9500 100%);
    }

    .contact-submit:active {
        transform: translateY(0) scale(0.98);
        box-shadow: 0 3px 12px rgba(255, 107, 0, 0.3);
    }

    .contact-submit.loading {
        opacity: 0.7;
        pointer-events: none;
    }
    </style>
@endpush

@push('scripts')
    <script>
        function handleContactSubmit(e) {
            e.preventDefault();
            const btn = document.getElementById('contact-btn');
            btn.classList.add('loading');
            btn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i> <span>Sending…</span>';

            setTimeout(() => {
                btn.classList.remove('loading');
                btn.innerHTML = '<i class="ri-check-line"></i> <span>Message Sent!</span>';
                btn.style.background = 'linear-gradient(135deg, #10B981, #059669)';
                document.getElementById('contact-form').reset();

                setTimeout(() => {
                    btn.innerHTML = '<i class="ri-send-plane-2-fill"></i> <span>Send Message</span>';
                    btn.style.background = '';
                }, 3000);
            }, 1500);
        }
    </script>
@endpush
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Church Management System | Simplify Ministry & Admin</title>
  <meta name="description" content="Manage members, finances, and events with our all-in-one Church Management Software. Save time and grow your ministry." />
  <!-- Open Graph (optional) -->
  <meta property="og:title" content="Church Management System — Simplify Ministry & Admin">
  <meta property="og:description" content="All-in-one ChMS to manage members, giving, events and volunteers. Start a free trial.">
  <meta property="og:image" content="{{ asset('images/og-hero.png') }}"> <!-- placeholder -->
  @vite(['resources/css/app.css','resources/js/app.js'])

   {{-- Livewire --}}
    @livewireStyles

    {{-- WireUI --}}
    @wireUiStyles
</head>
<body class="antialiased bg-gray-50 text-gray-900">

  {{-- Header --}}
  <header class="bg-white/60 backdrop-blur-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
      <a href="/" class="flex items-center gap-3">
        <img src="{{ asset('images/Church Cross.jpg') }}" alt="ChurchMS logo" class="h-10 w-auto">
        <span class="font-semibold text-lg text-blue-800">ChurchMS</span>
      </a>

      <nav class="hidden md:flex items-center gap-6 text-sm">
        <a href="#features" class="hover:text-blue-700">Features</a>
        <a href="#pricing" class="hover:text-blue-700">Pricing</a>
        <a href="#faq" class="hover:text-blue-700">FAQ</a>
        <a href="#contact" class="hover:text-blue-700">Contact</a>
      </nav>

      <div class="flex items-center gap-3">
        <a href="#book-demo" class="text-sm px-3 py-2 rounded-md hover:bg-gray-100" aria-label="Book a demo">Book a demo</a>
        <a href="{{ route('register') }}" 
           class="ml-2 inline-flex items-center px-4 py-2 rounded-lg bg-yellow-400 text-blue-900 font-medium shadow-sm hover:bg-yellow-300"
           data-event="cta-hero-click"
           aria-label="Start free trial">
          Start Free Trial
        </a>
      </div>
    </div>
  </header>

  {{-- Hero --}}
  <main>
    <section id="hero" class="min-h-[72vh] flex items-center">
      <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
        <div class="order-2 md:order-1">
          <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight text-blue-900">
            Run your church with confidence — not spreadsheets.
          </h1>
          <p class="mt-4 text-lg text-gray-700 max-w-2xl">
            All-in-one Church Management System to simplify administration, grow engagement, and free your team to focus on ministry.
          </p>

          <ul class="mt-6 space-y-2 text-sm text-gray-600">
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-blue-700" aria-hidden><use href="#icon-check" /></svg>
              Save hours each week on admin and reporting.
            </li>
            <li class="flex items-center gap-3">
              <svg class="w-5 h-5 text-blue-700" aria-hidden><use href="#icon-check" /></svg>
              Keep your congregation connected across events and ministries.
            </li>
          </ul>

          <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('register') }}" 
               class="inline-flex items-center px-6 py-3 bg-yellow-400 text-blue-900 font-semibold rounded-lg shadow hover:bg-yellow-300"
               data-event="primary-cta"
               aria-label="Start free trial">
              Start Free Trial
            </a>

            <a href="#book-demo" 
               class="inline-flex items-center px-5 py-3 border border-transparent rounded-lg text-sm hover:bg-gray-100"
               data-event="secondary-cta"
               aria-label="Book a demo">
              Book a demo
            </a>
          </div>

          <div class="mt-6 flex items-center gap-4 text-xs text-gray-500">
            <!-- trust logos -->
                <span class="flex items-center gap-6">
      <!-- Placeholder Church Logo 1 -->
      <img src="{{ asset('images/photo2.jpg') }}" 
           alt="Church Logo 1" 
           class="h-16 rounded-lg shadow-sm grayscale hover:grayscale-0 transition" 
           loading="lazy">

      <!-- Placeholder Church Logo 2 -->
      <img src="{{ asset('images/photo3.jpg')  }}" 
           alt="Church Logo 2" 
           class="h-16 rounded-lg shadow-sm grayscale hover:grayscale-0 transition" 
           loading="lazy">

      <!-- Placeholder Church Logo 3 -->
      <img src="{{ asset('images/photo4.jpg') }}" 
           alt="Church Logo 3" 
           class="h-16 rounded-lg shadow-sm grayscale hover:grayscale-0 transition" 
           loading="lazy">
    </span>
            <span>Trusted by 500+ churches • 99.9% uptime</span>
          </div>
        </div>

        <div class="order-1 md:order-2">
          <!-- HERO VISUAL: replace with screenshot or short looping MP4/webm -->
          <div class="rounded-2xl shadow-xl overflow-hidden bg-white">
            
            <video src="{{ asset('video/hero-loop.mp4') }}" autoplay muted loop playsinline class="w-full"></video>
           
          </div>
        </div>
      </div>
    </section>

    {{-- Benefits / Outcomes --}}
    <section id="benefits" class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-2xl font-bold text-center text-blue-800">Outcomes your team will love</h2>
        <p class="mt-3 text-center text-gray-600 max-w-2xl mx-auto">Practical features that save time, protect data, and help your church grow.</p>

        <div class="mt-8 grid md:grid-cols-3 gap-6">
          <article class="p-6 rounded-2xl bg-gray-50 shadow-sm">
            <h3 class="font-semibold text-blue-700">Less admin, more ministry</h3>
            <p class="mt-2 text-sm text-gray-600">Automate reports, attendance and records so staff spend time on people — not paperwork.</p>
          </article>

          <article class="p-6 rounded-2xl bg-gray-50 shadow-sm">
            <h3 class="font-semibold text-blue-700">Stronger member engagement</h3>
            <p class="mt-2 text-sm text-gray-600">Segment your congregation, send targeted messages, and boost event attendance.</p>
          </article>

          <article class="p-6 rounded-2xl bg-gray-50 shadow-sm">
            <h3 class="font-semibold text-blue-700">Transparent stewardship</h3>
            <p class="mt-2 text-sm text-gray-600">Track giving, export statements, and create professional finance reports in seconds.</p>
          </article>
        </div>
      </div>
    </section>

    {{-- Feature Highlights --}}
    <section id="features" class="py-16 bg-gray-100">
      <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-2xl font-bold text-center text-blue-800">Features built for churches</h2>
        <p class="text-center text-gray-600 mt-2 max-w-2xl mx-auto">Everything a busy church needs — member management, giving, events and volunteers.</p>

        <ul class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <li class="p-6 bg-white rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-start gap-4">
              <div class="flex-none bg-blue-50 p-3 rounded-lg">
                <!-- Icon placeholder -->
                <svg class="w-6 h-6 text-blue-700" aria-hidden><use href="#icon-users"></use></svg>
              </div>
              <div>
                <h4 class="font-semibold text-blue-700">Member Directory</h4>
                <p class="mt-1 text-sm text-gray-600">Central profiles with contact details, groups, tags and access history.</p>
              </div>
            </div>
          </li>

          <li class="p-6 bg-white rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-start gap-4">
              <div class="flex-none bg-blue-50 p-3 rounded-lg">
                <svg class="w-6 h-6 text-blue-700" aria-hidden><use href="#icon-dollar"></use></svg>
              </div>
              <div>
                <h4 class="font-semibold text-blue-700">Finance & Giving</h4>
                <p class="mt-1 text-sm text-gray-600">Record contributions, issue giving statements, and export reports for accounting.</p>
              </div>
            </div>
          </li>

          <li class="p-6 bg-white rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-start gap-4">
              <div class="flex-none bg-blue-50 p-3 rounded-lg">
                <svg class="w-6 h-6 text-blue-700" aria-hidden><use href="#icon-calendar"></use></svg>
              </div>
              <div>
                <h4 class="font-semibold text-blue-700">Events & Volunteer Scheduling</h4>
                <p class="mt-1 text-sm text-gray-600">Create events, publish calendars, and assign volunteer teams easily.</p>
              </div>
            </div>
          </li>

          <li class="p-6 bg-white rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-start gap-4">
              <div class="flex-none bg-blue-50 p-3 rounded-lg">
                <svg class="w-6 h-6 text-blue-700" aria-hidden><use href="#icon-mail"></use></svg>
              </div>
              <div>
                <h4 class="font-semibold text-blue-700">Communication Tools</h4>
                <p class="mt-1 text-sm text-gray-600">Send email/SMS to groups, schedule reminders, and track opens.</p>
              </div>
            </div>
          </li>

          <li class="p-6 bg-white rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-start gap-4">
              <div class="flex-none bg-blue-50 p-3 rounded-lg">
                <svg class="w-6 h-6 text-blue-700" aria-hidden><use href="#icon-chart"></use></svg>
              </div>
              <div>
                <h4 class="font-semibold text-blue-700">Reports & Dashboards</h4>
                <p class="mt-1 text-sm text-gray-600">Real-time dashboards to track attendance, growth and giving trends.</p>
              </div>
            </div>
          </li>

          <li class="p-6 bg-white rounded-2xl shadow hover:shadow-lg transition">
            <div class="flex items-start gap-4">
              <div class="flex-none bg-blue-50 p-3 rounded-lg">
                <svg class="w-6 h-6 text-blue-700" aria-hidden><use href="#icon-phone"></use></svg>
              </div>
              <div>
                <h4 class="font-semibold text-blue-700">Mobile-Ready</h4>
                <p class="mt-1 text-sm text-gray-600">Volunteer and staff access on any device — manage church work on the go.</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </section>

    {{-- Social proof --}}
    <section id="social-proof" class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6 text-center">
        <h3 class="text-xl font-bold text-blue-800">Trusted by churches big and small</h3>

        <div class="mt-6 flex flex-wrap justify-center items-center gap-6">
          <!-- Placeholder logos -->
          <img src="{{ asset('images/photo1.jpg') }}" alt="Client 1" class="h-40" loading="lazy">
          <img src="{{ asset('images/photo1.jpg') }}" alt="Client 2" class="h-40" loading="lazy">
          <img src="{{ asset('images/photo1.jpg') }}" alt="Client 3" class="h-40" loading="lazy">
        </div>

        <blockquote class="mt-8 mx-auto max-w-2xl text-gray-700 italic">“This system has transformed how we serve our congregation — everything from tithes to volunteers is easier.”</blockquote>
        <p class="mt-3 font-semibold text-blue-700">— Pastor John, Grace Chapel</p>

        <div class="mt-6 flex justify-center gap-6 text-sm text-gray-500">
          <div><strong class="text-blue-800">500+</strong> churches</div>
          <div><strong class="text-blue-800">50k+</strong> members managed</div>
          <div><strong class="text-blue-800">99.9%</strong> uptime</div>
        </div>
      </div>
    </section>

    {{-- How it works --}}
    <section id="how-it-works" class="py-16 bg-gray-50">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h3 class="text-2xl font-bold text-blue-800">How it works</h3>
        <p class="text-gray-600 mt-2">Get set up in minutes and lead your church with clarity.</p>

        <div class="mt-8 grid md:grid-cols-3 gap-6 text-left">
          <div class="p-6 bg-white rounded-2xl shadow">
            <div class="text-sm font-semibold text-blue-700">1. Sign up</div>
            <p class="mt-2 text-sm text-gray-600">Create your account and choose a plan.</p>
          </div>
          <div class="p-6 bg-white rounded-2xl shadow">
            <div class="text-sm font-semibold text-blue-700">2. Import & organize</div>
            <p class="mt-2 text-sm text-gray-600">Upload member lists or connect with existing spreadsheets.</p>
          </div>
          <div class="p-6 bg-white rounded-2xl shadow">
            <div class="text-sm font-semibold text-blue-700">3. Lead with clarity</div>
            <p class="mt-2 text-sm text-gray-600">Use dashboards, reports and scheduling to simplify operations.</p>
          </div>
        </div>
      </div>
    </section>

    {{-- Pricing --}}
    <section id="pricing" class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6 text-center">
        <h3 class="text-2xl font-bold text-blue-800">Pricing</h3>
        <p class="mt-2 text-gray-600">Simple plans built for churches. Contact sales for multi-campus or custom needs.</p>

        <div class="mt-8 grid md:grid-cols-3 gap-6">
          <!-- Starter -->
          <div class="p-6 bg-gray-50 rounded-2xl shadow">
            <h4 class="text-lg font-semibold text-blue-700">Starter</h4>
            <p class="mt-1 text-sm text-gray-600">Small churches (under 200 members)</p>
            <div class="mt-4 text-3xl font-bold text-gray-900">$29<span class="text-sm font-medium text-gray-500">/mo</span></div>
            <ul class="mt-4 text-sm text-gray-600 space-y-2">
              <li>Member directory & tags</li>
              <li>Basic giving tracking</li>
              <li>Event scheduling</li>
            </ul>
            <a href="{{ route('register') }}" class="mt-6 inline-block w-full px-4 py-3 bg-yellow-400 text-blue-900 rounded-lg font-semibold"
               data-event="pricing-starter-cta">Start Free Trial</a>
          </div>

          <!-- Growth -->
          <div class="p-6 bg-white rounded-2xl shadow-lg border-2 border-blue-50">
            <h4 class="text-lg font-semibold text-blue-700">Growth</h4>
            <p class="mt-1 text-sm text-gray-600">Mid churches (200–1,000 members)</p>
            <div class="mt-4 text-3xl font-bold text-gray-900">$79<span class="text-sm font-medium text-gray-500">/mo</span></div>
            <ul class="mt-4 text-sm text-gray-600 space-y-2">
              <li>Everything in Starter</li>
              <li>Advanced reporting & exports</li>
              <li>Volunteer scheduling + SMS</li>
            </ul>
            <a href="#book-demo" class="mt-6 inline-block w-full px-4 py-3 bg-blue-700 text-white rounded-lg font-semibold"
               data-event="pricing-growth-cta">Book a Demo</a>
          </div>

          <!-- Impact -->
          <div class="p-6 bg-gray-50 rounded-2xl shadow">
            <h4 class="text-lg font-semibold text-blue-700">Impact</h4>
            <p class="mt-1 text-sm text-gray-600">Large churches & multi-campus</p>
            <div class="mt-4 text-sm text-gray-700">Contact Sales</div>
            <ul class="mt-4 text-sm text-gray-600 space-y-2">
              <li>Custom integrations</li>
              <li>Priority onboarding & support</li>
              <li>Unlimited ministries & campuses</li>
            </ul>
            <a href="#contact" class="mt-6 inline-block w-full px-4 py-3 bg-white border border-gray-200 rounded-lg font-semibold"
               data-event="pricing-impact-cta">Contact Sales</a>
          </div>
        </div>

        <p class="mt-6 text-xs text-gray-500">All plans billed monthly. Annual discounts available. Taxes may apply.</p>
      </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="py-16 bg-gray-50">
      <div class="max-w-4xl mx-auto px-6">
        <h3 class="text-2xl font-bold text-blue-800 text-center">Frequently asked questions</h3>

        <dl class="mt-6 space-y-4">
          <div>
            <dt class="font-medium text-gray-900">Is there a free trial?</dt>
            <dd class="mt-1 text-sm text-gray-600">Yes — 14 days full access. No card required for the trial.</dd>
          </div>

          <div>
            <dt class="font-medium text-gray-900">Can we import our data?</dt>
            <dd class="mt-1 text-sm text-gray-600">Yes — CSV import and guided onboarding are available.</dd>
          </div>

          <div>
            <dt class="font-medium text-gray-900">Is our data secure?</dt>
            <dd class="mt-1 text-sm text-gray-600">Yes — encrypted at rest/en route, regular backups, GDPR-ready controls.</dd>
          </div>

          <div>
            <dt class="font-medium text-gray-900">Do you offer training?</dt>
            <dd class="mt-1 text-sm text-gray-600">We provide webinars, documentation, and optional 1:1 onboarding packages.</dd>
          </div>

          <div>
            <dt class="font-medium text-gray-900">How do volunteers access schedules?</dt>
            <dd class="mt-1 text-sm text-gray-600">Volunteers receive secure links or can sign in with limited access accounts.</dd>
          </div>
        </dl>
      </div>
    </section>

    {{-- Final CTA --}}
    <section id="cta-final" class="py-16 bg-blue-700 text-white">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h3 class="text-2xl font-bold">Ready to transform your church?</h3>
        <p class="mt-2 text-gray-100">Start your free trial or book a demo with our team.</p>
        <div class="mt-6 flex justify-center gap-4">
          <a href="{{ route('register') }}" class="px-6 py-3 bg-yellow-400 text-blue-900 rounded-lg font-semibold" data-event="cta-final-trial">Start Free Trial</a>
          <a href="#book-demo" class="px-6 py-3 border border-white rounded-lg" data-event="cta-final-demo">Book a Demo</a>
        </div>
      </div>
    </section>

    {{-- Contact / Book Demo anchor (simple form modal or separate page recommended) --}}
    <section id="book-demo" class="py-12 bg-white">
      <div class="max-w-3xl mx-auto px-6">
        <h4 class="text-lg font-bold text-blue-800 text-center">Book a demo</h4>
        <p class="text-center text-gray-600 mt-2">Enter a few details and our team will reach out with available times.</p>

        <!-- Minimal conversion form (progressive profiling recommended) -->
        <form action="#" method="POST" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4" data-event="demo-form">
          @csrf
          <label class="sr-only">Church name</label>
          <input name="church_name" type="text" placeholder="Church name" required class="px-4 py-3 rounded-lg border w-full" aria-label="Church name">
          <label class="sr-only">Contact email</label>
          <input name="email" type="email" placeholder="Email address" required class="px-4 py-3 rounded-lg border w-full" aria-label="Email address">
          <label class="sr-only">Phone (optional)</label>
          <input name="phone" type="tel" placeholder="Phone (optional)" class="px-4 py-3 rounded-lg border w-full" aria-label="Phone">
          <label class="sr-only">Message (optional)</label>
          <input name="message" type="text" placeholder="Message (optional)" class="px-4 py-3 rounded-lg border w-full" aria-label="Message">
          <div class="md:col-span-2 flex items-center justify-between gap-4">
            <button type="submit" class="px-6 py-3 bg-blue-700 text-white rounded-lg font-semibold" aria-label="Request demo">Request demo</button>
            <small class="text-xs text-gray-500">We respect your privacy — your data is secure. Demo takes ~15 mins.</small>
          </div>
        </form>
      </div>
    </section>
  </main>

  {{-- Footer --}}
  <footer class="bg-gray-900 text-gray-400">
    <div class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-6">
      <div>
        <img src="{{ asset('images/Footer1.jpg') }}" alt="ChurchMS" class="h-8 mb-3">
        <p class="text-sm text-gray-400">All-in-one church management software to simplify admin and grow engagement.</p>
      </div>

      <div>
        <h5 class="font-semibold text-white">Product</h5>
        <ul class="mt-3 space-y-2 text-sm">
          <li><a href="#features" class="hover:underline">Features</a></li>
          <li><a href="#pricing" class="hover:underline">Pricing</a></li>
          <li><a href="#faq" class="hover:underline">FAQ</a></li>
        </ul>
      </div>

      <div>
        <h5 class="font-semibold text-white">Legal</h5>
        <ul class="mt-3 space-y-2 text-sm">
          <li><a href="/privacy" class="hover:underline">Privacy policy</a></li>
          <li><a href="/terms" class="hover:underline">Terms of service</a></li>
          <li><a href="/security" class="hover:underline">Security & compliance</a></li>
        </ul>
      </div>
    </div>

    <div class="border-t border-gray-800">
      <div class="max-w-7xl mx-auto px-6 py-4 text-xs text-gray-500 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>© {{ date('Y') }} ChurchMS. All rights reserved.</div>
        <div class="flex items-center gap-4">
          <!-- Security & compliance badges -->
          <img src="{{ asset('images/badge-ssl.svg') }}" alt="SSL secure" class="h-6" loading="lazy">
          <img src="{{ asset('images/badge-gdpr.svg') }}" alt="GDPR ready" class="h-6" loading="lazy">
        </div>
      </div>
    </div>
  </footer>

  {{-- Inline SVG icons (placeholders) --}}
  <svg class="hidden" aria-hidden>
    <symbol id="icon-check" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></symbol>
    <symbol id="icon-users" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M23 21v-2a4 4 0 0 0-3-3.87" stroke="currentColor" stroke-width="1.5" fill="none"/></symbol>
    <symbol id="icon-dollar" viewBox="0 0 24 24"><path d="M12 1v22" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" stroke="currentColor" stroke-width="1.5" fill="none"/></symbol>
    <symbol id="icon-calendar" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M16 3v4M8 3v4" stroke="currentColor" stroke-width="1.5" fill="none"/></symbol>
    <symbol id="icon-mail" viewBox="0 0 24 24"><path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.5" fill="none"/></symbol>
    <symbol id="icon-chart" viewBox="0 0 24 24"><path d="M3 3v18h18" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M7 13v6M12 9v10M17 5v14" stroke="currentColor" stroke-width="1.5" fill="none"/></symbol>
    <symbol id="icon-phone" viewBox="0 0 24 24"><path d="M22 16.92V21a1 1 0 0 1-1.12 1 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2 3.12 1 1 0 0 1 3 2h4.09a1 1 0 0 1 1 .76c.13.79.35 1.56.66 2.27a1 1 0 0 1-.24 1L7.91 8.09a14 14 0 0 0 6 6l1.06-1.06a1 1 0 0 1 1-.24c.71.31 1.48.53 2.27.66a1 1 0 0 1 .76 1V21z" stroke="currentColor" stroke-width="1.2" fill="none"/></symbol>
  </svg>

  <!-- Optional: small inline script to push simple tracking events (replace with GA/Pixel) -->
  <script>
    document.addEventListener('click', function (e) {
      var el = e.target.closest('[data-event]');
      if (!el) return;
      // send to analytics: data-event value and optional data-label
      var eventName = el.getAttribute('data-event');
      var label = el.getAttribute('data-label') || el.href || el.textContent.trim();
      // Example: window.dataLayer.push({ event: eventName, label: label }); // adapt for GA4
      console.log('analytics event:', eventName, label);
    });
  </script>
  @livewireScripts



</body>
</html>


/* ═══════════════════════════════════════════
   LUXURY WATCH - MAIN JAVASCRIPT
═══════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', function () {

    // ── Header sticky shadow ──
    const header = document.getElementById('siteHeader');
    if (header) {
        window.addEventListener('scroll', function () {
            header.style.boxShadow = window.scrollY > 20
                ? '0 2px 20px rgba(0,0,0,.1)' : '0 1px 0 #e8e8e8';
        });
    }

    // ── Search toggle ──
    const searchBtn = document.getElementById('searchToggleBtn');
    const searchBar = document.getElementById('searchBar');
    if (searchBtn && searchBar) {
        searchBtn.addEventListener('click', function () {
            searchBar.classList.toggle('open');
            if (searchBar.classList.contains('open')) {
                searchBar.querySelector('input')?.focus();
            }
        });
        document.addEventListener('click', function (e) {
            if (!header.contains(e.target)) searchBar.classList.remove('open');
        });
    }

    // ── User dropdown ──
    const userBtn = document.getElementById('userMenuBtn');
    const userDropdown = document.getElementById('userDropdown');
    if (userBtn && userDropdown) {
        userBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
        document.addEventListener('click', function () {
            userDropdown.classList.remove('show');
        });
    }

    // ── Mobile nav (simple toggle) ──
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mainNav = document.getElementById('mainNav');
    if (mobileBtn && mainNav) {
        mobileBtn.addEventListener('click', function () {
            if (mainNav.style.display === 'flex') {
                mainNav.style.display = 'none';
            } else {
                mainNav.style.cssText = 'display:flex;flex-direction:column;position:absolute;top:100%;left:0;right:0;background:#fff;padding:16px;box-shadow:0 8px 20px rgba(0,0,0,.1);z-index:200;gap:4px;';
            }
        });
    }

    // ── Auto-dismiss alert after 4s ──
    const alertMsg = document.getElementById('alertMsg');
    if (alertMsg) {
        setTimeout(function () {
            alertMsg.style.transition = 'opacity .5s';
            alertMsg.style.opacity = '0';
            setTimeout(() => alertMsg.remove(), 500);
        }, 4000);
    }

    // ── Newsletter form (fake submit) ──
    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const input = this.querySelector('input[type="email"]');
            const btn = this.querySelector('button');
            if (input && input.value) {
                btn.textContent = '✓ Đã đăng ký!';
                btn.style.background = '#22c55e';
                input.value = '';
                setTimeout(() => {
                    btn.textContent = 'Đăng ký';
                    btn.style.background = '';
                }, 3000);
            }
        });
    }

    // ── Payment method selection ──
    document.querySelectorAll('.payment-option input[type="radio"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('selected'));
            this.closest('.payment-option').classList.add('selected');
        });
    });
});

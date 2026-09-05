/**
 * BISa shared front-end behaviour.
 *
 * Replaces the per-layout inline <script> blocks that each role's shell used to
 * carry (four near-identical copies, including a click handler that navigated
 * via a `data-locs` attribute instead of using real links).
 */
(function () {
    'use strict';

    var THEME_KEY = 'bisa-theme';

    /* ---------------------------------------------------------------------
     * Theme
     * ------------------------------------------------------------------- */

    function storedTheme() {
        // Private-mode browsers and blocked site data both throw here.
        try {
            return window.localStorage.getItem(THEME_KEY);
        } catch (e) {
            return null;
        }
    }

    function storeTheme(theme) {
        try {
            window.localStorage.setItem(THEME_KEY, theme);
        } catch (e) {
            /* Not being able to remember the choice is not an error. */
        }
    }

    function applyTheme(theme) {
        if (theme === 'dark' || theme === 'light') {
            document.documentElement.setAttribute('data-theme', theme);
        } else {
            document.documentElement.removeAttribute('data-theme');
        }
    }

    function currentTheme() {
        var explicit = document.documentElement.getAttribute('data-theme');
        if (explicit) {
            return explicit;
        }

        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'dark'
            : 'light';
    }

    applyTheme(storedTheme());

    document.addEventListener('click', function (event) {
        var toggle = event.target.closest('[data-bisa-theme-toggle]');
        if (!toggle) {
            return;
        }

        var next = currentTheme() === 'dark' ? 'light' : 'dark';
        applyTheme(next);
        storeTheme(next);
    });

    /* ---------------------------------------------------------------------
     * Sidebar toggles
     *
     * These two behaviours were the only parts of the vendor's custom.min.js
     * this app actually used; the rest of that file drove a preloader, a search
     * box, a right-hand customiser panel and floating labels that do not exist
     * here. Reimplemented so the file no longer has to be loaded.
     * ------------------------------------------------------------------- */

    var SIDEBAR_KEY = 'bisa-sidebar';

    function wrapper() {
        return document.getElementById('main-wrapper');
    }

    function setMini(mini) {
        var el = wrapper();
        if (!el) {
            return;
        }

        el.classList.toggle('mini-sidebar', mini);
        el.setAttribute('data-sidebartype', mini ? 'mini-sidebar' : 'full');

        try {
            window.localStorage.setItem(SIDEBAR_KEY, mini ? 'mini' : 'full');
        } catch (e) {
            /* ignore */
        }
    }

    try {
        if (window.localStorage.getItem(SIDEBAR_KEY) === 'mini') {
            setMini(true);
        }
    } catch (e) {
        /* ignore */
    }

    document.addEventListener('click', function (event) {
        if (event.target.closest('.sidebartoggler')) {
            var el = wrapper();
            setMini(el ? !el.classList.contains('mini-sidebar') : true);
            return;
        }

        // Mobile: slide the sidebar in and out.
        if (event.target.closest('.nav-toggler')) {
            var root = wrapper();
            if (root) {
                root.classList.toggle('show-sidebar');
            }
        }
    });

    /* ---------------------------------------------------------------------
     * Auto-dismiss flash messages
     * ------------------------------------------------------------------- */

    window.setTimeout(function () {
        document.querySelectorAll('.alert-dismissible[role="alert"]').forEach(function (alert) {
            // Leave errors up; the user needs to read and act on those.
            if (alert.classList.contains('alert-danger')) {
                return;
            }
            alert.classList.remove('show');
            window.setTimeout(function () {
                alert.remove();
            }, 300);
        });
    }, 6000);

    /* ---------------------------------------------------------------------
     * Guard against double-submitting a form
     * ------------------------------------------------------------------- */

    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!(form instanceof HTMLFormElement) || form.hasAttribute('data-allow-resubmit')) {
            return;
        }

        // If an onsubmit confirm() said no, the event is already cancelled.
        if (event.defaultPrevented) {
            return;
        }

        var submit = form.querySelector('button[type="submit"], input[type="submit"]');
        if (submit) {
            window.setTimeout(function () {
                submit.disabled = true;
            }, 0);
        }
    });

    /* ---------------------------------------------------------------------
     * DataTables defaults
     * ------------------------------------------------------------------- */

    document.addEventListener('DOMContentLoaded', function () {
        if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.dataTable) {
            return;
        }

        window.jQuery.extend(true, window.jQuery.fn.dataTable.defaults, {
            pageLength: 10,
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ baris',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ baris',
                infoEmpty: 'Tidak ada data',
                zeroRecords: 'Tidak ada data yang cocok',
                emptyTable: 'Belum ada data',
                paginate: {
                    first: 'Awal',
                    last: 'Akhir',
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                }
            }
        });
    });
})();

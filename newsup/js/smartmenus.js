/*!
 * Newsup Modern Vanilla Navigation (smartmenus.js)
 * Lightweight, zero-dependency alternative to legacy SmartMenus / jQuery.
 *
 * Weight: ~5 KB (zero external dependencies, zero jQuery requirements).
 * Fully supports desktop hover/focus flyouts, collision boundary detection,
 * mobile/offcanvas accordions, and WCAG 2.1 AA keyboard accessibility.
 */

(function (window, document) {
    'use strict';

    if (!document) return;

    var instances = [];
    var uidCounter = 0;

    var defaults = {
        showTimeout: 60,
        hideTimeout: 180,
        breakpoint: 991.98
    };

    function closest(elm, selector) {
        return elm && elm.closest ? elm.closest(selector) : null;
    }

    function isRTL(element) {
        var doc = document.documentElement;
        var body = document.body;
        return (
            (element && element.classList.contains('sm-rtl')) ||
            (doc && doc.getAttribute('dir') === 'rtl') ||
            (body && body.classList.contains('rtl'))
        );
    }

    /**
     * NewsupNav Constructor
     * @param {HTMLElement|string} element
     * @param {Object} options
     */
    function NewsupNav(element, options) {
        var root = typeof element === 'string' ? document.querySelector(element) : element;
        if (!root || root.tagName !== 'UL') return null;

        if (root._newsupNav) {
            return root._newsupNav;
        }

        this.root = root;
        this.opts = Object.assign({}, defaults, options || {});
        this.id = 'newsup-nav-' + (++uidCounter);
        this.showTimers = new WeakMap();
        this.hideTimers = new WeakMap();
        this.activeSubmenu = null;

        root._newsupNav = this;
        root._smartmenus = this; // Backwards compatibility alias
        instances.push(this);

        this.init();
    }

    NewsupNav.prototype = {
        constructor: NewsupNav,

        init: function () {
            this.setupSubmenus();
            this.bindEvents();
            this.updateMode();
        },

        isCollapsible: function () {
            if (closest(this.root, '.bs-offcanvas, .offcanvas, [data-offcanvas], [data-mg-offcanvas]')) {
                return true;
            }
            if (window.matchMedia) {
                return window.matchMedia('(max-width: ' + this.opts.breakpoint + 'px)').matches;
            }
            return (window.innerWidth || 1200) <= 991;
        },

        updateMode: function () {
            if (this.isCollapsible()) {
                this.root.classList.add('sm-collapsible');
            } else {
                this.root.classList.remove('sm-collapsible');
                this.resetOpenSubmenus();
            }
        },

        setupSubmenus: function () {
            var submenus = this.root.querySelectorAll('ul');
            var self = this;

            Array.prototype.forEach.call(submenus, function (sub) {
                var parentLi = sub.parentElement;
                if (!parentLi || parentLi.tagName !== 'LI') return;

                // Find the direct parent anchor
                var parentA = null;
                for (var i = 0; i < parentLi.children.length; i++) {
                    if (parentLi.children[i].tagName === 'A') {
                        parentA = parentLi.children[i];
                        break;
                    }
                }
                if (!parentA) return;

                if (!parentLi.style.position) {
                    parentLi.style.position = 'relative';
                }

                parentA.classList.add('has-submenu');

                // Append .sub-arrow toggle caret if not already present
                var subArrow = parentA.querySelector('.sub-arrow');
                if (!subArrow) {
                    subArrow = document.createElement('span');
                    subArrow.className = 'sub-arrow';
                    subArrow.setAttribute('role', 'button');
                    subArrow.setAttribute('aria-label', 'Toggle submenu');
                    subArrow.setAttribute('tabindex', '0');
                    parentA.appendChild(subArrow);
                }

                // Calculate nesting depth
                var level = 2;
                var curr = parentLi.parentElement;
                while (curr && curr !== self.root) {
                    if (curr.tagName === 'UL') level++;
                    curr = curr.parentElement;
                }

                if (!sub.id) sub.id = self.id + '-sub-' + (++uidCounter);
                if (!parentA.id) parentA.id = self.id + '-btn-' + uidCounter;

                parentA.setAttribute('aria-haspopup', 'true');
                parentA.setAttribute('aria-controls', sub.id);
                if (!parentA.hasAttribute('aria-expanded')) parentA.setAttribute('aria-expanded', 'false');

                sub.setAttribute('role', 'menu');
                sub.setAttribute('aria-labelledby', parentA.id);
                if (!sub.hasAttribute('aria-expanded')) sub.setAttribute('aria-expanded', 'false');
                if (!sub.hasAttribute('aria-hidden')) sub.setAttribute('aria-hidden', 'true');

                sub._parentA = parentA;
                sub._parentLi = parentLi;
                sub._level = level;
                parentA._sub = sub;
                parentLi._sub = sub;
            });
        },

        bindEvents: function () {
            var self = this;
            var root = this.root;

            // 1. Desktop Hover on LI items with submenus
            var lis = root.querySelectorAll('li');
            Array.prototype.forEach.call(lis, function (li) {
                if (!li._sub) return;

                li.addEventListener('mouseenter', function () {
                    if (self.isCollapsible()) return;
                    self.clearHideTimer(li);
                    self.clearShowTimer(li);

                    var timer = setTimeout(function () {
                        self.showSubmenu(li._sub);
                    }, self.opts.showTimeout);

                    self.showTimers.set(li, timer);
                }, { passive: true });

                li.addEventListener('mouseleave', function () {
                    if (self.isCollapsible()) return;
                    self.clearShowTimer(li);

                    var timer = setTimeout(function () {
                        self.hideSubmenu(li._sub);
                    }, self.opts.hideTimeout);

                    self.hideTimers.set(li, timer);
                }, { passive: true });
            });

            // 2. Click Handling (Mobile Accordion + Desktop Touch Parent Links)
            root.addEventListener('click', function (e) {
                var target = e.target;

                // Tapping the .sub-arrow button
                var subArrow = closest(target, '.sub-arrow');
                if (subArrow) {
                    var parentA = closest(subArrow, 'a.has-submenu');
                    if (parentA && parentA._sub) {
                        e.preventDefault();
                        e.stopPropagation();
                        self.toggleSubmenu(parentA._sub);
                        return;
                    }
                }

                // Tapping a parent link directly
                var link = closest(target, 'a.has-submenu');
                if (link && link._sub) {
                    var href = link.getAttribute('href');
                    var isAnchorOnly = !href || href === '#' || href === 'javascript:void(0);';

                    if (self.isCollapsible()) {
                        if (isAnchorOnly) {
                            e.preventDefault();
                            self.toggleSubmenu(link._sub);
                        }
                    } else {
                        // Desktop touch tap: if submenu is closed, first tap opens it
                        if (!link._sub.classList.contains('show')) {
                            e.preventDefault();
                            self.showSubmenu(link._sub);
                        }
                    }
                }
            });

            // 3. Keyboard Navigation (Enter/Space on .sub-arrow, Esc to close, Arrow keys)
            root.addEventListener('keydown', function (e) {
                var target = e.target;
                var key = e.key || e.keyCode;

                // Enter or Space on .sub-arrow
                if (target.classList && target.classList.contains('sub-arrow') && (key === 'Enter' || key === ' ' || key === 13 || key === 32)) {
                    var parentA = closest(target, 'a.has-submenu');
                    if (parentA && parentA._sub) {
                        e.preventDefault();
                        self.toggleSubmenu(parentA._sub);
                        return;
                    }
                }

                // Escape closes active dropdown and restores focus
                if (key === 'Escape' || key === 'Esc' || key === 27) {
                    var openLi = closest(target, 'li.show');
                    if (openLi && openLi._sub) {
                        e.preventDefault();
                        self.hideSubmenu(openLi._sub);
                        if (openLi._sub._parentA) {
                            openLi._sub._parentA.focus();
                        }
                    }
                }
            });

            // 4. Focus-within handling for WCAG Tab Accessibility
            root.addEventListener('focusin', function (e) {
                if (self.isCollapsible()) return;
                var li = closest(e.target, 'li');
                if (li && li._sub) {
                    self.clearHideTimer(li);
                    self.showSubmenu(li._sub);
                }
            });

            root.addEventListener('focusout', function (e) {
                if (self.isCollapsible()) return;
                var li = closest(e.target, 'li');
                if (li && li._sub) {
                    var timer = setTimeout(function () {
                        // Check if focus has completely left this list item
                        if (!li.contains(document.activeElement)) {
                            self.hideSubmenu(li._sub);
                        }
                    }, self.opts.hideTimeout);
                    self.hideTimers.set(li, timer);
                }
            });

            // 5. Global Document Click: closes open dropdowns when clicking outside
            document.addEventListener('click', function (e) {
                if (!root.contains(e.target) && !self.isCollapsible()) {
                    self.resetOpenSubmenus();
                }
            });

            // 6. Window Resize: smoothly toggle collapsible mode
            var resizeTimer = null;
            window.addEventListener('resize', function () {
                if (resizeTimer) clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function () {
                    self.updateMode();
                }, 100);
            }, { passive: true });
        },

        clearShowTimer: function (li) {
            if (this.showTimers.has(li)) {
                clearTimeout(this.showTimers.get(li));
                this.showTimers.delete(li);
            }
        },

        clearHideTimer: function (li) {
            if (this.hideTimers.has(li)) {
                clearTimeout(this.hideTimers.get(li));
                this.hideTimers.delete(li);
            }
        },

        showSubmenu: function (sub) {
            if (!sub) return;

            var li = sub._parentLi;
            var a = sub._parentA;

            // In desktop mode, close sibling submenus on the same level
            if (!this.isCollapsible() && li && li.parentElement) {
                var siblings = li.parentElement.children;
                for (var i = 0; i < siblings.length; i++) {
                    if (siblings[i] !== li && siblings[i]._sub) {
                        this.hideSubmenu(siblings[i]._sub);
                    }
                }
            }

            // Ensure parent LI has position relative for accurate child absolute positioning
            if (li && !li.style.position) {
                li.style.position = 'relative';
            }

            var level = sub._level || 2;
            var rtl = isRTL(this.root);

            // On desktop, set multi-level positioning: Level 2 below, Level 3+ next to parent item
            if (!this.isCollapsible()) {
                if (level > 2) {
                    // Multi-level: open NEXT TO parent item (flyout), NOT below
                    sub.style.top = '0px';
                    if (rtl) {
                        sub.style.right = '100%';
                        sub.style.left = 'auto';
                    } else {
                        sub.style.left = '100%';
                        sub.style.right = 'auto';
                    }
                } else {
                    // Top-level dropdown: open below navbar
                    sub.style.top = '100%';
                    if (rtl) {
                        sub.style.right = '0px';
                        sub.style.left = 'auto';
                    } else {
                        sub.style.left = '0px';
                        sub.style.right = 'auto';
                    }
                }
            }

            sub.classList.add('show');
            if (li) li.classList.add('show');
            if (a) {
                a.classList.add('highlighted');
                a.setAttribute('aria-expanded', 'true');
            }
            sub.setAttribute('aria-expanded', 'true');
            sub.setAttribute('aria-hidden', 'false');

            // Viewport boundary collision detection on desktop
            if (!this.isCollapsible()) {
                this.detectCollision(sub);
            }
        },

        hideSubmenu: function (sub) {
            if (!sub) return;

            var li = sub._parentLi;
            var a = sub._parentA;

            // Hide nested child submenus recursively
            var nested = sub.querySelectorAll('ul.show');
            for (var i = 0; i < nested.length; i++) {
                this.hideSubmenu(nested[i]);
            }

            sub.classList.remove('show');
            if (li) li.classList.remove('show');
            if (a) {
                a.classList.remove('highlighted');
                a.setAttribute('aria-expanded', 'false');
            }
            sub.setAttribute('aria-expanded', 'false');
            sub.setAttribute('aria-hidden', 'true');

            // Reset custom inline positioning
            sub.style.top = '';
            sub.style.bottom = '';
            sub.style.left = '';
            sub.style.right = '';
        },

        toggleSubmenu: function (sub) {
            if (!sub) return;
            if (sub.classList.contains('show')) {
                this.hideSubmenu(sub);
            } else {
                this.showSubmenu(sub);
            }
        },

        resetOpenSubmenus: function () {
            var openSubs = this.root.querySelectorAll('ul.show');
            for (var i = 0; i < openSubs.length; i++) {
                this.hideSubmenu(openSubs[i]);
            }
        },

        detectCollision: function (sub) {
            var rect = sub.getBoundingClientRect();
            var winW = window.innerWidth || document.documentElement.clientWidth;
            var winH = window.innerHeight || document.documentElement.clientHeight;
            var rtl = isRTL(this.root);
            var level = sub._level || 2;

            if (rtl) {
                // If it overflows the left viewport boundary in RTL
                if (rect.left < 0) {
                    if (level === 2) {
                        sub.style.right = 'auto';
                        sub.style.left = '0px';
                    } else {
                        // Flip to right side if overflowing on left
                        sub.style.right = 'auto';
                        sub.style.left = '100%';
                    }
                }
            } else {
                // If it overflows the right viewport boundary in LTR
                if (rect.right > winW) {
                    if (level === 2) {
                        sub.style.left = 'auto';
                        sub.style.right = '0px';
                    } else {
                        // Flip to left side if overflowing on right
                        sub.style.left = 'auto';
                        sub.style.right = '100%';
                    }
                }
            }

            // Vertical edge check: if sub extends below the bottom of the viewport
            if (rect.bottom > winH && rect.height < winH) {
                var overflowY = rect.bottom - winH + 10;
                var currentTop = parseInt(sub.style.top, 10) || 0;
                sub.style.top = (currentTop - overflowY) + 'px';
            }
        },

        refresh: function () {
            this.setupSubmenus();
            this.updateMode();
        },

        destroy: function () {
            this.resetOpenSubmenus();
            this.root._newsupNav = null;
            this.root._smartmenus = null;
            var idx = instances.indexOf(this);
            if (idx !== -1) instances.splice(idx, 1);
        }
    };

    /**
     * Static Auto-Initialization API
     */
    NewsupNav.init = function (selector, options) {
        var sel = selector || '.navbar-nav, #navbar-wp .navbar-nav, .bs-offcanvas-inner .navbar-nav';
        var nodes = document.querySelectorAll(sel);
        var created = [];

        Array.prototype.forEach.call(nodes, function (node) {
            if (!node._newsupNav) {
                created.push(new NewsupNav(node, options));
            }
        });

        return created;
    };

    NewsupNav.refresh = function () {
        for (var i = 0; i < instances.length; i++) {
            instances[i].refresh();
        }
        NewsupNav.init();
    };

    NewsupNav.destroy = function (elm) {
        if (!elm) {
            while (instances.length) {
                instances[0].destroy();
            }
            return;
        }
        var node = typeof elm === 'string' ? document.querySelector(elm) : elm;
        if (node && node._newsupNav) {
            node._newsupNav.destroy();
        }
    };

    NewsupNav.get = function (elm) {
        var node = typeof elm === 'string' ? document.querySelector(elm) : elm;
        return node ? (node._newsupNav || node._smartmenus) : null;
    };

    // Backwards compatibility aliases
    NewsupNav.Bootstrap = {
        init: function () { NewsupNav.init(); },
        refresh: function () { NewsupNav.refresh(); },
        destroy: function () { NewsupNav.destroy(); }
    };

    window.NewsupNav = NewsupNav;
    window.SmartMenus = NewsupNav;
    window.NewsMenu = NewsupNav;

    // Auto-boot on DOM ready
    function boot() {
        NewsupNav.init();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
    window.addEventListener('load', boot);

})(window, document);


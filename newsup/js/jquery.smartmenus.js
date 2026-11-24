/**
 * Legacy SmartMenus stub - replaced by modern Vanilla JS smartmenus.js
 */
(function(window) {
    'use strict';
    if (window.NewsupNav) return;
    if (typeof document !== 'undefined') {
        var scripts = document.getElementsByTagName('script');
        var current = document.currentScript || scripts[scripts.length - 1];
        if (current && current.src) {
            var newSrc = current.src.replace('jquery.smartmenus.js', 'smartmenus.js');
            if (newSrc !== current.src) {
                var s = document.createElement('script');
                s.src = newSrc;
                s.defer = true;
                document.head.appendChild(s);
            }
        }
    }
})(typeof window !== 'undefined' ? window : this);

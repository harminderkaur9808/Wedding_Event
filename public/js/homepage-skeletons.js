/**
 * Section skeleton loaders: show shimmer while section content/images load.
 * Runs only on homepage (main contains .wm-reveal). Removes skeleton when
 * all images in the section have loaded or after max wait.
 */
(function () {
    var MAX_WAIT_MS = 4500;
    var NO_IMAGES_DELAY_MS = 100;

    function whenReady(section, done) {
        var imgs = section.querySelectorAll('img[src]');
        if (!imgs.length) {
            setTimeout(done, NO_IMAGES_DELAY_MS);
            return;
        }
        var pending = imgs.length;
        var resolved = false;
        function oneDone() {
            if (--pending <= 0 && !resolved) {
                resolved = true;
                done();
            }
        }
        imgs.forEach(function (img) {
            if (img.complete) {
                oneDone();
            } else {
                img.addEventListener('load', oneDone);
                img.addEventListener('error', oneDone);
            }
        });
        setTimeout(function () {
            if (!resolved) {
                resolved = true;
                done();
            }
        }, MAX_WAIT_MS);
    }

    function init() {
        var main = document.querySelector('main');
        if (!main) return;
        var sections = main.querySelectorAll('section.wm-section-loading');
        if (!sections.length) return;

        sections.forEach(function (section) {
            whenReady(section, function () {
                section.classList.remove('wm-section-loading');
                section.classList.add('wm-section-loaded');
            });
        });
    }

    function addLoadingClass() {
        var main = document.querySelector('main');
        if (!main) return;
        var sections = main.querySelectorAll('section');
        sections.forEach(function (section) {
            if (section.classList.contains('wedding-mele-our-story-section')) return;
            if (section.querySelector('.wm-reveal')) {
                section.classList.add('wm-section-loading');
            }
        });
        if (main.querySelectorAll('section.wm-section-loading').length) init();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', addLoadingClass);
    } else {
        addLoadingClass();
    }
})();

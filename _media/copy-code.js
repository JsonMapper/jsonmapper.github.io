/*
 * Copy-to-clipboard buttons for code blocks.
 *
 * Adapted from the assets/copy-code.js the Jekyll site used. HydePHP ships no
 * copy button of its own, so this was lost in the migration and is restored
 * here. Two changes from the original:
 *
 *  - It selects `#document-main-content pre` (docs) and `[data-copy-code] pre`
 *    (the landing page sample) rather than `article pre.highlight`,
 *    since `.highlight` was Rouge markup that Torchlight does not produce.
 *  - It injects its own styles, so the project does not need a stylesheet or a
 *    build step to bring back one button.
 *
 * The button is anchored to a wrapper around the code block rather than inside
 * it, and sits bottom right. Both matter: the original sat inside the element
 * that scrolls horizontally, so on narrow screens it covered the code and slid
 * away when you swiped. That was reported as an issue against the Jekyll site
 * and fixed the same way in PR #51, which this carries forward.
 */
(function () {
    'use strict';

    var copyIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z"/></svg>';
    var checkIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>';

    var styles = [
        '.code-copy-wrapper { position: relative; }',
        '.code-copy-button {',
        '  position: absolute; bottom: .5rem; right: .5rem;',
        '  display: inline-flex; align-items: center; justify-content: center;',
        '  width: 2rem; height: 2rem; padding: .25rem;',
        '  cursor: pointer; box-sizing: border-box;',
        '  color: #e5e7eb; background: rgba(15, 23, 42, .55);',
        '  border: 1px solid rgba(229, 231, 235, .4); border-radius: .5rem;',
        '  opacity: .5; transition: opacity .2s ease-in-out;',
        '}',
        '.code-copy-button svg { width: 1.15rem; height: 1.15rem; }',
        '.code-copy-wrapper:hover .code-copy-button,',
        '.code-copy-button:hover,',
        '.code-copy-button:focus-visible { opacity: 1; }',
        '.code-copy-button:hover { background: rgba(15, 23, 42, .8); }',
        '@media print { .code-copy-button { display: none; } }'
    ].join('\n');

    function injectStyles() {
        var style = document.createElement('style');
        style.textContent = styles;
        document.head.appendChild(style);
    }

    function addButton(pre) {
        var code = pre.querySelector('code');

        if (!code || pre.parentElement.classList.contains('code-copy-wrapper')) {
            return;
        }

        // Wrap so the button can be positioned without disturbing the <pre>,
        // whose own positioning Torchlight and the prose styles rely on.
        var wrapper = document.createElement('div');
        wrapper.className = 'code-copy-wrapper';
        pre.parentNode.insertBefore(wrapper, pre);
        wrapper.appendChild(pre);

        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'code-copy-button';
        button.setAttribute('aria-label', 'Copy code to clipboard');
        button.innerHTML = copyIcon;

        button.addEventListener('click', function () {
            var text = code.innerText.replace(/\s+$/, '');

            navigator.clipboard.writeText(text).then(function () {
                button.innerHTML = checkIcon;
                button.setAttribute('aria-label', 'Copied');

                setTimeout(function () {
                    button.blur();
                    button.innerHTML = copyIcon;
                    button.setAttribute('aria-label', 'Copy code to clipboard');
                }, 1200);
            });
        });

        wrapper.appendChild(button);
    }

    function init() {
        if (!navigator.clipboard) {
            return;
        }

        injectStyles();
        document.querySelectorAll('#document-main-content pre, [data-copy-code] pre').forEach(addButton);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

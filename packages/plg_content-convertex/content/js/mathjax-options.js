// Config of the MathJax
window.MathJax = {
    options: {
        ignoreHtmlClass: 'tex2jax_ignore',
        processHtmlClass: 'tex2jax_process',
        skipHtmlTags: [
            'script', 'noscript', 'style', 'textarea', 'pre',
            'code', 'annotation', 'annotation-xml'
        ],
        menuOptions: {
            settings: {
                texHints: true,        // put TeX-related attributes on MathML
                semantics: true,      // put original format in <semantic> tag in MathML
                zoom: 'Click',        // or 'Click' or 'DoubleClick' as zoom trigger
                zscale: '200%',        // zoom scaling factor
                renderer: 'SVG',     // or 'SVG'
                alt: false,            // true if ALT required for zooming
                cmd: false,            // true if CMD required for zooming
                ctrl: true,           // true if CTRL required for zooming
                shift: false,          // true if SHIFT required for zooming
                scale: 1,              // scaling factor for all math
                collapsible: false,    // true if complex math should be collapsible
                inTabOrder: true,      // true if tabbing includes math
            },
            annotationTypes: {
                TeX: ['TeX', 'LaTeX', 'application/x-tex'],
                ContentMathML: ['MathML-Content', 'application/mathml-content+xml']
            }
        }
    },
    loader: {
        load: ['input/tex-base', 'output/svg', '[tex]/noerrors', '[tex]/physics', '[tex]/colorV2']
    },
    tex: {
        packages: {'[+]': ['noerrors', 'physics', 'colorV2']}
    },
    svg: {
        matchFontHeight: true,
        displayAlign: 'center',
        fontCache: 'global'
    },
    startup: {
        ready: () => {
            console.log('MathJax is loaded, but not yet initialized');
            MathJax.startup.defaultReady();
            MathJax.startup.promise.then(() => {
                console.log('MathJax initial typesetting complete');
            });
        }
    }
};

// Dummy function for call another function before the page is completely loaded
function ready(fn) {
    if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading") {
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

// Function for reset display in the all latex class
function convertex() {
    let elements = document.querySelectorAll('.latex');
    Array.prototype.forEach.call(elements, function (item, index) {
        item.style.display = '';
    });
}

ready(convertex);
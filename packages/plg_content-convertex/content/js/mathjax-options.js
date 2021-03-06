// Config of the MathJax
window.MathJax = {
    options: {
        ignoreHtmlClass: 'tex2jax_ignore',
        processHtmlClass: 'tex2jax_process',
        skipHtmlTags: [
            'script', 'noscript', 'style', 'pre',
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
        packages: {'[+]': ['noerrors', 'physics', 'colorV2']},
        inlineMath: [              // start/end delimiter pairs for in-line math
            ['[tex]', '[/tex]']
        ],
        displayMath: [             // start/end delimiter pairs for display math
            ['[texD]', '[/texD]']
        ]
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
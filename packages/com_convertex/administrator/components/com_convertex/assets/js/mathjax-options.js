// Config of the MathJax
window.MathJax = {
    options: {
        ignoreHtmlClass: 'tex2jax_ignore',
        processHtmlClass: 'tex2jax_process',
        skipHtmlTags: [
            'script', 'noscript', 'style', 'textarea', 'pre',
            'code', 'annotation', 'annotation-xml'
        ],
        renderActions: {
            addMenu: [0, '', '']
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
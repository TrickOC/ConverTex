(function () {
    let script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg-full.js';
    script.async = true;
    document.head.appendChild(script);
    if (window.tinymce) {
        let options = document.createElement('script');
        options.src = 'plugins/content/convertex/js/mathjax-options.js';
        window.tinymce.activeEditor.getBody().parentElement.firstChild.appendChild(options);
        window.tinymce.activeEditor.getBody().parentElement.firstChild.appendChild(script);
    }
})();
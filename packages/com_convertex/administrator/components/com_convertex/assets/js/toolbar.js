const editex_toolbar = {
    basic_math: [
        delim = ["(", ")", "\\mid", "[", "]"],
        func = ["\\sqrt{x}", "\\sqrt[n]{x}", "\\frac{x}{y}", "\\binom{n}{k}", "^{n}", "_{n}"],
        rel_sym = ["&lt;", "&gt;", "\\leq", "\\geq", "=", "\\neq", "\\equiv", "\\approx", "\\simeq", "\\sim", "\\cong", "\\therefore"],
        gr_let = ["\\alpha", "\\beta", "\\theta", "\\kappa", "\\lambda", "\\Omega", "\\pi"]
    ],
    algebra: [
        delim = ["(", ")", "\\mid", "[", "]"],
        func = ["\\sqrt{x}", "\\sqrt[n]{x}", "\\frac{x}{y}", "\\binom{n}{k}", "^{n}", "_{n}", "\\ln", "\\log", "\\log_{x}", "f(n)=\\begin{cases}x=x+x\\\\y=y+y\\end{cases}"],
        rel_sym = ["&lt;", "&gt;", "\\leq", "\\geq", "=", "\\neq", "\\equiv", "\\approx", "\\simeq", "\\sim", "\\cong", "\\therefore"],
        gr_let = ["\\alpha", "\\beta", "\\theta", "\\kappa", "\\lambda", "\\Omega", "\\pi"],
    ],
    trigonometry: [
        delim = ["(", ")", "\\mid", "[", "]"]
    ],
    pre_calculus: [
        delim = ["(", ")", "\\mid", "[", "]"]
    ],
    calculus: [
        delim = ["(", ")", "\\mid", "[", "]"]
    ],
    statistics: [
        delim = ["(", ")", "\\mid", "[", "]"]
    ],
    finite_math: [
        delim = ["(", ")", "\\mid", "[", "]"]
    ],
    linear_algebra: [
        delim = ["(", ")", "\\mid", "[", "]"]
    ],
    chemistry: [
        delim = ["(", ")", "\\mid", "[", "]"]
    ],
    physics: [
        delim = ["(", ")", "\\mid", "[", "]"]
    ]
};


// Function for create the toolbar
function createToolbar(discipline, element) {
    element.hide();
    element.empty();
    editex_toolbar[discipline].each(function () {
        $("<div></div>")
            .addClass("btn-group")
            .addClass("btn-group-sm")
            .attr("role", "group")
            .attr("aria-label", this)
            .attr("id", "ct_toolbar_group_" + this)
            .appendTo(element);
        this.each(function () {
            typeset(() => {
                $("<button></button>")
                    .addClass("btn")
                    .addClass("btn-primary")
                    .attr("type", "button")
                    .attr("data-insert", this)
                    .text('[tex]' + this + '[/tex]')
                    .on("click", function () {
                        let editareaBox = $("#ct_editarea_box");
                        let text = this;
                        typeInTextarea(editareaBox, text);
                        refreshTexPreview($("#ct_preview_box span"), editareaBox.val());
                    })
                    .appendTo("#ct_toolbar_group_" + this.parent());
            });
        })
    });
    element.fadeIn();
}
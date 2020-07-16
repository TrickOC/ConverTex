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

// Dummy function for call another function before the page is completely loaded
function ready(fn) {
    if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading") {
        fn();
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

// Function for MathJax work in async ambient
function typeset(code) {
    MathJax.startup.promise = MathJax.startup.promise
        .then(() => {
            code();
            return MathJax.typesetPromise()
        })
        .catch((err) => console.log(`Typeset failed: ${err.message}`));
    return MathJax.startup.promise;
}

// Function for insert the final equation in the text of the editor
function insertEditex(insert) {
    const editor = $('#editor_name').val();
    window.parent.jInsertEditorText(`{tex}${insert}{/tex}`, editor);
    window.parent.SqueezeBox.close();
    return false;
}

// Function for insert text in the selection position
function typeInTextarea(element, newText) {
    let start = element.prop("selectionStart");
    let end = element.prop("selectionEnd");
    let text = element.val();
    let before = text.substring(0, start);
    let after = text.substring(end, text.length);
    element.val(before + newText + after);
    element[0].selectionStart = element[0].selectionEnd = start + newText.length;
    element.focus();
}

// Function for refresh content in the element
function refreshTexContent(element, val) {
    typeset(() => {
        element.html('\\[' + val + '\\]');
    });
}

function createToolbar(discipline, element) {
    $.ajax({
        type: "GET",
        url: "administrator/components/com_convertex/assets/latex/toolbar.xml",
        dataType: "xml",
        success: function (xml) {
            $(xml).find("[name='" + discipline + "']")
                .find("group").each(function () {
                $("<div></div>")
                    .addClass("btn-group")
                    .addClass("btn-group-sm")
                    .addClass("mr-1")
                    .attr("role", "group")
                    .attr("aria-label", $(this).attr("name"))
                    .append($(this).find("button").each(function () {
                        return $("<button></button>")
                            .addClass("btn")
                            .addClass("btn-secondary")
                            .attr("type", "button")
                            .attr("data-insert", $(this).attr("insert"))
                            .text('\\[' + $(this).text() + '\\]');
                    }))
                    .appendTo(element);
            });
            typeset(() => {
                element.fadeIn()
                if (!element.children().is("div")) {
                    $("<p></p>")
                        .addClass("alert").addClass("alert-danger")
                        .attr("role", "alert")
                        .text("ERRO in build the toolbar")
                        .appendTo(element);
                }
            });
        },
        error: function () {
            $("<p></p>")
                .addClass("alert").addClass("alert-danger")
                .attr("role", "alert")
                .text("ERRO in request XML")
                .appendTo(element);
        }
    });
}

// Main funtion of editor(editex)
function editex() {
    let discipline_selector = $("#ct_discipline .btn-group");
    let discipline_selected = discipline_selector.find(".active");
    let toolbar = $("#ct_toolbar :button");
    let toolbar_buttons = toolbar.find("button");
    let editareaBox = $("#ct_editarea_box");
    let previewBox = $("#ct_preview_box span");
    let insert = $("#ct_insert");

    discipline_selector.find(":button").text(discipline_selected.text());
    createToolbar(discipline_selected.data("discipline"), toolbar);

    discipline_selector.find('a').on("click", function () {
        if ($(this).attr("class").search("active") <= 0) {
            discipline_selector.find(".active").removeClass("active");
            $(this).addClass("active");
            discipline_selector.find(":button").text($(this).text());
            toolbar.fadeOut();
            toolbar.empty();
            createToolbar(discipline_selected.data("discipline"), toolbar);
        }
        return false;
    });

    // Set the event for click an button of the toolbar
    toolbar_buttons.on("click", function () {
        let text = $(this).attr("data-operator");
        typeInTextarea(editareaBox, text);
        refreshTexContent(previewBox, editareaBox.val());
    });

    // Set the events for editareabox
    editareaBox.on("keyup", refreshTexContent(previewBox, editareaBox.val()));
    editareaBox.on("change", refreshTexContent(previewBox, editareaBox.val()));

    insert.on("click", function () {
        insertEditex(editareaBox.val());
    });
}

// Call editex function before the page is loaded
ready(editex);
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
                $(function () {
                    editex();
                });
            });
        }
    }
};

function typeset(code) {
    MathJax.startup.promise = MathJax.startup.promise
        .then(() => {
            code();
            return MathJax.typesetPromise();
        })
        .catch((err) => console.log('Typeset failed: ' + err.message));
    return MathJax.startup.promise;
}

// Function for insert the final equation in the text of the editor
function insertEditex(insert) {
    const editor = $('#editor_name').val();
    window.parent.jInsertEditorText(`{tex}${insert}{/tex}`, editor);
    window.parent.SqueezeBox.close();
    return false;
}

// Function for refresh content in the element
function refreshTexPreview(element, val) {
    typeset(() => {
        element.text('\\[' + val + '\\]');
    });
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

// Function for create the toolbar
function createToolbar(discipline, element) {
    let url = (window.location.pathname.includes("administrator", 0)) ? "" : "administrator/";
    url += "components/com_convertex/assets/latex/toolbar.xml";
    $.ajax({
        type: "GET",
        url: url,
        dataType: "xml",
        success: function (xml) {
            let toolbar = "";
            $(xml).find("discipline").each(function () {
                if ($(this).attr("name") === discipline) {
                    toolbar = $(this);
                    return false;
                }
            });
            if (toolbar === "") {
                $("<p></p>")
                    .addClass("alert").addClass("alert-danger")
                    .attr("role", "alert")
                    .text("ERRO in build the toolbar for discipline " + discipline)
                    .appendTo(element);
            } else {
                toolbar.find("group").each(function () {
                    $("<div></div>")
                        .addClass("btn-group")
                        .addClass("btn-group-sm")
                        .attr("role", "group")
                        .attr("aria-label", $(this).attr("name"))
                        .attr("id", "ct_toolbar_group_" + $(this).attr("shortname"))
                        .appendTo(element);
                    $(this).find("item").each(function () {
                        typeset(() => {
                            $("<button></button>")
                                .addClass("btn")
                                .addClass("btn-primary")
                                .attr("type", "button")
                                .attr("data-insert", $(this).attr("insert"))
                                .text('\\[' + $(this).text() + '\\]')
                                .on("click", function () {
                                    let editareaBox = $("#ct_editarea_box");
                                    let text = $(this).data("insert");
                                    typeInTextarea(editareaBox, text);
                                    refreshTexPreview($("#ct_preview_box span"), editareaBox.val());
                                })
                                .appendTo("#ct_toolbar_group_" + $(this).parent().attr("shortname"));
                        });
                    })
                });
            }
            element.fadeIn();
        }
    });
}

function editex() {
    let discipline_selector = $("#ct_discipline .btn-group");
    let discipline_selected = discipline_selector.find(".active");
    let toolbar = $("#ct_toolbar");
    let editareaBox = $("#ct_editarea_box");
    let previewBox = $("#ct_preview_box span");
    let insert = $("#ct_insert");

    discipline_selector.find(":button").text(discipline_selected.text());
    toolbar.hide();
    createToolbar(discipline_selected.data("discipline"), toolbar);

    discipline_selector.find('a').on("click", function () {
        if (!$(this).hasClass("active")) {
            discipline_selected.removeClass("active");
            $(this).addClass("active");
            discipline_selected = $(this);
            discipline_selector.find(":button").text($(this).text());
            toolbar.hide();
            toolbar.empty();
            createToolbar(discipline_selected.data("discipline"), toolbar);
        }
        return false;
    });

    // Set the events for editareabox
    editareaBox.on("keyup", function () {
        refreshTexPreview(previewBox, editareaBox.val())
    });
    editareaBox.on("change", function () {
        refreshTexPreview(previewBox, editareaBox.val());
    });

    // Set the event for insert the formula in editor
    insert.on("click", function () {
        insertEditex(editareaBox.val());
    });
}
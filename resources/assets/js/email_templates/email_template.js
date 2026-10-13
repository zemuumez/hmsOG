"use strict";

let quillEmail;
let cursorPosition = 0;

document.addEventListener("DOMContentLoaded", function () {
    if (!document.getElementById("emailContentId")) {
        return;
    }

    quillEmail = new Quill("#emailContentId", {
        theme: "snow",
        placeholder: "Write email content...",
        modules: {
            toolbar: [
                [{ header: [1, 2, false] }],
                ["bold", "italic", "underline", "link"],
                [{ list: "ordered" }, { list: "bullet" }],
            ],
        },
    });

    quillEmail.on("selection-change", function (range) {
        if (range) {
            cursorPosition = range.index;
        }
    });

    quillEmail.on("text-change", function () {
        if (quillEmail.getText().trim().length === 0) {
            quillEmail.setContents([{ insert: "" }]);
        }

        let hiddenInput = document.getElementById("emailData");
        if (hiddenInput) {
            hiddenInput.value = quillEmail.root.innerHTML;
        }
    });

    let content = $(".emailContentData").val();

    if (content) {
        quillEmail.clipboard.dangerouslyPasteHTML(content);
    }
});

$(document).on("click", ".variable-item", function () {
    let variable = $(this).data("variable");

    if (!quillEmail) return;

    quillEmail.focus();

    quillEmail.setSelection(cursorPosition);

    quillEmail.insertText(cursorPosition, variable);

    quillEmail.setSelection(cursorPosition + variable.length);
});

listenSubmit("#editEmailTemplateForm", function (event) {
    let subject = $("#emailSubject").val()?.trim();
    let content = quillEmail.root.innerHTML;
    let plainText = quillEmail.getText().trim();

    if (!subject) {
        event.preventDefault();
        displayErrorMessage("Email subject is required");
        return false;
    }

    if (!plainText) {
        event.preventDefault();
        displayErrorMessage("Email content is required");
        return false;
    }

    $("#emailData").val(content);

    return true;
});

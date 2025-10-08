document.addEventListener("trix-initialize", function (event) {
    const editor = event.target;

    // Pastikan elemen trix editor valid dan toolbar tersedia
    if (!editor || !editor.editor || !editor.editor.toolbarElement) {
        console.warn(
            "Editor atau toolbar tidak ditemukan pada trix-initialize",
            editor
        );
        return;
    }

    const toolbar = editor.editor.toolbarElement;

    // 1. Hapus tombol-tombol yang tidak diinginkan dari toolbar
    const buttonsToRemove = [
        ".trix-button--icon-strike",
        ".trix-button--icon-link",
        ".trix-button--icon-quote",
        ".trix-button--icon-code",
        ".trix-button--icon-attach",
    ];

    buttonsToRemove.forEach((selector) => {
        const button = toolbar.querySelector(selector);
        if (button) button.parentNode.remove();
    });

    // 2. Nonaktifkan shortcut keyboard yang terkait dengan fitur yang dimatikan
    editor.addEventListener("keydown", function (e) {
        // Ctrl+Shift+S untuk strikethrough
        if (e.key === "S" && e.shiftKey && (e.ctrlKey || e.metaKey))
            e.preventDefault();

        // Ctrl+K untuk insert link
        if (e.key === "K" && (e.ctrlKey || e.metaKey)) e.preventDefault();
    });

    // 3. Blokir paste konten dengan tag terlarang
    editor.addEventListener("trix-paste", function (e) {
        const html = e.paste?.html || "";
        const forbiddenTags = [
            "<strike",
            "<del",
            "<blockquote",
            "<pre>",
            "<a href",
            "trix-attachment",
        ];
        if (forbiddenTags.some((tag) => html.includes(tag))) {
            e.preventDefault();
            alert("Formatting ini tidak diizinkan");
        }
    });

    // 4. Blokir upload file (drag & drop atau attachment langsung)
    editor.addEventListener("trix-file-accept", function (e) {
        e.preventDefault();
    });
});

// 5. Tambahkan style untuk menyembunyikan elemen dari formatting yang dilarang
document.addEventListener("DOMContentLoaded", function () {
    const style = document.createElement("style");
    style.textContent = `
    trix-editor del,
    trix-editor strike,
    trix-editor blockquote,
    trix-editor pre:not([class^="language-"]),
    trix-editor a[href],
    trix-editor .attachment {
      display: none !important;
    }
  `;
    document.head.appendChild(style);
});

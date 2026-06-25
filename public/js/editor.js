/* Reusable rich-text editor (TipTap / ProseMirror) for report bodies.
   Loaded as an ES module from the esm.sh CDN (the app has no build step).
   Mounts on every [data-editor] inside a .rte-field (which also holds a hidden
   .rte-input carrying the HTML for normal/fetch form submits).                */

import { Editor } from "https://esm.sh/@tiptap/core@2.11.7";
import StarterKit from "https://esm.sh/@tiptap/starter-kit@2.11.7";
import Underline from "https://esm.sh/@tiptap/extension-underline@2.11.7";
import Link from "https://esm.sh/@tiptap/extension-link@2.11.7";
import Image from "https://esm.sh/@tiptap/extension-image@2.11.7";
import TextAlign from "https://esm.sh/@tiptap/extension-text-align@2.11.7";
import Table from "https://esm.sh/@tiptap/extension-table@2.11.7";
import TableRow from "https://esm.sh/@tiptap/extension-table-row@2.11.7";
import TableHeader from "https://esm.sh/@tiptap/extension-table-header@2.11.7";
import TableCell from "https://esm.sh/@tiptap/extension-table-cell@2.11.7";

const ICON = (c) => `<i class="fa-solid ${c}"></i>`;

function uploadAndInsert(file, editor) {
  const fd = new FormData();
  fd.append("image", file);
  fetch("uploadImage", { method: "POST", headers: { "X-Requested-With": "XMLHttpRequest" }, body: fd })
    .then((r) => r.json())
    .then((d) => {
      if (d.ok && d.url) editor.chain().focus().setImage({ src: d.url, alt: file.name }).run();
      else alert("Image upload failed: " + (d.error || "unknown error"));
    })
    .catch(() => alert("Image upload failed."));
}

function mountField(host) {
  if (host.__rte) return host.__rte;
  const field = host.closest(".rte-field");
  const input = field ? field.querySelector(".rte-input") : null;
  const placeholder = host.getAttribute("data-placeholder") || "Write here…";

  host.innerHTML = "";
  const toolbar = document.createElement("div");
  toolbar.className = "rte-toolbar";
  toolbar.setAttribute("role", "toolbar");
  const content = document.createElement("div");
  content.className = "rte-content";
  host.appendChild(toolbar);
  host.appendChild(content);

  let editor;
  editor = new Editor({
    element: content,
    extensions: [
      StarterKit,
      Underline,
      Link.configure({ openOnClick: false, autolink: true, HTMLAttributes: { rel: "noopener nofollow", target: "_blank" } }),
      Image.configure({ inline: false, allowBase64: false }),
      TextAlign.configure({ types: ["heading", "paragraph"] }),
      Table.configure({ resizable: true }),
      TableRow, TableHeader, TableCell,
    ],
    content: input && input.value ? input.value : "",
    editorProps: {
      attributes: {
        class: "prose prose-invert prose-sm max-w-none focus:outline-none min-h-[7rem]",
        "data-placeholder": placeholder,
      },
      handlePaste(view, event) {
        const files = event.clipboardData && event.clipboardData.files;
        if (files && files.length) {
          for (const f of files) if (f.type.startsWith("image/")) { uploadAndInsert(f, editor); return true; }
        }
        return false;
      },
      handleDrop(view, event) {
        const files = event.dataTransfer && event.dataTransfer.files;
        if (files && files.length) {
          for (const f of files) if (f.type.startsWith("image/")) { uploadAndInsert(f, editor); event.preventDefault(); return true; }
        }
        return false;
      },
    },
    onUpdate: ({ editor }) => { if (input) input.value = editor.getHTML(); },
  });

  if (input) input.value = editor.getHTML();
  buildToolbar(toolbar, editor);
  host.__rte = editor;
  return editor;
}

function buildToolbar(toolbar, editor) {
  const buttons = []; // {el, isActive}
  const add = (html, label, onClick, isActive) => {
    const b = document.createElement("button");
    b.type = "button";
    b.className = "rte-btn";
    b.innerHTML = html;
    b.title = label;
    b.setAttribute("aria-label", label);
    b.addEventListener("click", (e) => { e.preventDefault(); onClick(); });
    toolbar.appendChild(b);
    if (isActive) buttons.push({ el: b, isActive });
  };
  const sep = () => { const s = document.createElement("span"); s.className = "rte-sep"; toolbar.appendChild(s); };
  const c = () => editor.chain().focus();

  add(ICON("fa-bold"), "Bold", () => c().toggleBold().run(), () => editor.isActive("bold"));
  add(ICON("fa-italic"), "Italic", () => c().toggleItalic().run(), () => editor.isActive("italic"));
  add(ICON("fa-underline"), "Underline", () => c().toggleUnderline().run(), () => editor.isActive("underline"));
  add(ICON("fa-strikethrough"), "Strikethrough", () => c().toggleStrike().run(), () => editor.isActive("strike"));
  sep();
  add("<span class='font-semibold text-xs'>H1</span>", "Heading 1", () => c().toggleHeading({ level: 1 }).run(), () => editor.isActive("heading", { level: 1 }));
  add("<span class='font-semibold text-xs'>H2</span>", "Heading 2", () => c().toggleHeading({ level: 2 }).run(), () => editor.isActive("heading", { level: 2 }));
  add("<span class='font-semibold text-xs'>H3</span>", "Heading 3", () => c().toggleHeading({ level: 3 }).run(), () => editor.isActive("heading", { level: 3 }));
  sep();
  add(ICON("fa-list-ul"), "Bullet list", () => c().toggleBulletList().run(), () => editor.isActive("bulletList"));
  add(ICON("fa-list-ol"), "Ordered list", () => c().toggleOrderedList().run(), () => editor.isActive("orderedList"));
  add(ICON("fa-quote-right"), "Blockquote", () => c().toggleBlockquote().run(), () => editor.isActive("blockquote"));
  add(ICON("fa-code"), "Inline code", () => c().toggleCode().run(), () => editor.isActive("code"));
  add("<span class='text-xs'>{ }</span>", "Code block", () => c().toggleCodeBlock().run(), () => editor.isActive("codeBlock"));
  sep();
  add(ICON("fa-align-left"), "Align left", () => c().setTextAlign("left").run(), () => editor.isActive({ textAlign: "left" }));
  add(ICON("fa-align-center"), "Align center", () => c().setTextAlign("center").run(), () => editor.isActive({ textAlign: "center" }));
  add(ICON("fa-align-right"), "Align right", () => c().setTextAlign("right").run(), () => editor.isActive({ textAlign: "right" }));
  sep();
  add(ICON("fa-link"), "Add / edit link", () => {
    const prev = editor.getAttributes("link").href || "";
    const url = window.prompt("Link URL (empty to remove):", prev);
    if (url === null) return;
    if (url === "") c().extendMarkRange("link").unsetLink().run();
    else c().extendMarkRange("link").setLink({ href: url }).run();
  }, () => editor.isActive("link"));
  add(ICON("fa-image"), "Insert image", () => {
    const inp = document.createElement("input");
    inp.type = "file"; inp.accept = "image/*";
    inp.addEventListener("change", () => { if (inp.files[0]) uploadAndInsert(inp.files[0], editor); });
    inp.click();
  });
  sep();
  add(ICON("fa-table"), "Insert table", () => c().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run());
  add(ICON("fa-plus") + ICON("fa-grip-lines-vertical"), "Add column", () => c().addColumnAfter().run());
  add(ICON("fa-minus") + ICON("fa-grip-lines-vertical"), "Delete column", () => c().deleteColumn().run());
  add(ICON("fa-plus") + ICON("fa-grip-lines"), "Add row", () => c().addRowAfter().run());
  add(ICON("fa-minus") + ICON("fa-grip-lines"), "Delete row", () => c().deleteRow().run());
  add(ICON("fa-table-cells") + "<span class='text-xs'>✕</span>", "Delete table", () => c().deleteTable().run());
  sep();
  add(ICON("fa-rotate-left"), "Undo", () => c().undo().run());
  add(ICON("fa-rotate-right"), "Redo", () => c().redo().run());

  const refresh = () => buttons.forEach((b) => b.el.classList.toggle("is-active", !!b.isActive()));
  editor.on("transaction", refresh);
  editor.on("selectionUpdate", refresh);
  refresh();
}

function mountIn(container) {
  (container || document).querySelectorAll("[data-editor]").forEach(mountField);
}

window.JournalEditor = { mountIn, mountField };
document.addEventListener("DOMContentLoaded", () => mountIn(document));

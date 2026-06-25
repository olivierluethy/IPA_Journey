<?php /* Shared <head> + dark design system. Set $pageTitle before including. */ ?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="images/favicon.ico">
<link rel="stylesheet" href="public/fontawesome/css/all.css">
<title><?= isset($pageTitle) ? $pageTitle : 'Journal Web-App' ?></title>

<script src="https://cdn.tailwindcss.com?plugins=typography"></script>
<script src="https://cdn.jsdelivr.net/npm/dompurify@3.0.11/dist/purify.min.js"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        colors: {
          base: '#0b0f17',
          surface: '#141a24',
          'surface-2': '#1b2230',
          border: '#283143',
          muted: '#94a3b8',
          accent: { DEFAULT: '#6366f1', hover: '#818cf8', soft: '#312e81' },
          danger: '#f87171',
          success: '#34d399',
        },
        boxShadow: { card: '0 1px 3px rgba(0,0,0,.4)', pop: '0 24px 60px rgba(0,0,0,.6)' },
        fontFamily: { sans: ['Inter', 'Arial', 'Helvetica', 'sans-serif'] },
      },
    },
  };
</script>

<style type="text/tailwindcss">
  @layer base {
    html { color-scheme: dark; }
    body { @apply bg-base text-slate-200 antialiased font-sans; }
    h1, h2, h3, h4 { @apply font-semibold text-slate-100; }
  }
  @layer components {
    /* Buttons — one shape, intentional colour roles */
    .btn { @apply inline-flex items-center justify-center gap-2 rounded-lg px-3.5 py-2 text-sm font-medium transition cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-accent/60 disabled:opacity-50; }
    .btn-primary { @apply bg-accent text-white hover:bg-accent-hover; }
    .btn-ghost   { @apply bg-surface-2 text-slate-300 border border-border hover:bg-white/10 hover:text-white; }
    .btn-danger  { @apply bg-surface-2 text-danger border border-border hover:bg-danger/10; }
    .btn-success { @apply bg-surface-2 text-success border border-border hover:bg-success/10; }
    .btn-icon    { @apply inline-flex items-center justify-center h-8 w-8 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-accent/60; }

    /* Surfaces */
    .card        { @apply bg-surface border border-border rounded-2xl shadow-card flex flex-col overflow-hidden; }
    .chip        { @apply inline-flex items-center rounded-full bg-accent/15 text-indigo-200 border border-accent/30 px-2.5 py-1 text-xs font-medium; }
    .meta        { @apply inline-flex items-center gap-1.5 text-xs text-slate-500; }

    /* Forms */
    .input, .textarea { @apply w-full rounded-lg bg-surface-2 border border-border px-3 py-2 text-slate-100 placeholder-slate-500 transition focus:outline-none focus:ring-2 focus:ring-accent/60 focus:border-accent; }
    .label { @apply block text-sm font-medium text-slate-400 mb-1.5; }

    /* Sidebar + nav */
    .sidebar-link { @apply block w-full text-left rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:text-white hover:bg-white/5 transition cursor-pointer; }
    .sidebar-link.active { @apply bg-accent/15 text-white; }

    /* Daily/Weekly toggle */
    .toggle { @apply inline-flex rounded-xl border border-border bg-surface p-1; }
    .toggle-btn { @apply rounded-lg px-4 py-1.5 text-sm font-medium text-slate-400 transition cursor-pointer; }
    .toggle-btn.is-active { @apply bg-accent text-white shadow; }

    /* Rich-text editor (TipTap) shell + toolbar */
    .rte { @apply rounded-lg border border-border bg-surface-2 overflow-hidden; }
    .rte-toolbar { @apply flex flex-wrap items-center gap-1 p-1.5 border-b border-border bg-surface; }
    .rte-btn { @apply h-8 min-w-[2rem] px-2 inline-flex items-center justify-center rounded-md text-slate-300 hover:bg-white/10 cursor-pointer text-sm transition; }
    .rte-btn.is-active { @apply bg-accent text-white; }
    .rte-sep { @apply w-px h-5 bg-border mx-1; }
    .rte-content { @apply max-h-80 overflow-y-auto px-3 py-2; }
  }
</style>

<style>
  /* Themed scrollbar (not expressible as Tailwind utilities) */
  .scroll-area { overflow-y: auto; }
  .scroll-area::-webkit-scrollbar { width: 8px; height: 8px; }
  .scroll-area::-webkit-scrollbar-track { background: transparent; }
  .scroll-area::-webkit-scrollbar-thumb { background: #334155; border-radius: 9999px; }
  .scroll-area::-webkit-scrollbar-thumb:hover { background: #475569; }
  .scroll-area { scrollbar-width: thin; scrollbar-color: #334155 transparent; }

  /* Unread notification items */
  #notifList .is-new { box-shadow: inset 2px 0 0 #6366f1; background: rgba(99,102,241,.08); }

  /* Read-only report bodies use Tailwind Typography (prose prose-invert); keep
     prose compact inside cards and let images/tables fit. */
  .report-html { max-width: none; }
  .report-html img { border-radius: 8px; }
  .report-html table { width: 100%; }

  /* --- Minimal ProseMirror/TipTap base CSS (sanctioned exception) --- */
  .ProseMirror { outline: none; min-height: 7rem; }
  .ProseMirror:focus { outline: none; }
  .ProseMirror p.is-editor-empty:first-child::before {
    content: attr(data-placeholder); color: #64748b; float: left; height: 0; pointer-events: none;
  }
  .ProseMirror img { max-width: 100%; height: auto; border-radius: 8px; }
  .ProseMirror img.ProseMirror-selectednode { outline: 2px solid #6366f1; }
  .ProseMirror table { border-collapse: collapse; width: 100%; table-layout: fixed; margin: .5rem 0; }
  .ProseMirror th, .ProseMirror td { border: 1px solid #334155; padding: .35rem .55rem; vertical-align: top; position: relative; }
  .ProseMirror th { background: #1b2230; font-weight: 600; }
  .ProseMirror .selectedCell:after {
    content: ""; position: absolute; inset: 0; background: rgba(99,102,241,.22); pointer-events: none;
  }
  .ProseMirror .column-resize-handle { position: absolute; right: -2px; top: 0; bottom: 0; width: 4px; background: #6366f1; pointer-events: none; }

  /* ---- FLIP "Full Size" modal (sanctioned custom CSS exception) ---- */
  #fsModal[hidden] { display: none; }
  #fsContent [data-fullsize] { display: none; }
  #fsContent > .report-card { width: 100%; }
  #fsModal { position: fixed; inset: 0; z-index: 60; display: flex; align-items: center; justify-content: center; padding: 1.5rem; }
  #fsBackdrop { position: absolute; inset: 0; background: rgba(2,6,23,.7); backdrop-filter: blur(4px); opacity: 0; transition: opacity .25s ease; }
  #fsModal.is-open #fsBackdrop { opacity: 1; }
  #fsDialog {
    position: relative; z-index: 1; width: min(820px, 100%); max-height: 88vh;
    transform-origin: top left; will-change: transform, opacity;
    /* springy easing so the bubble "jumps" to the middle */
    transition: transform .42s cubic-bezier(.34,1.56,.64,1), opacity .2s ease;
  }
  @media (prefers-reduced-motion: reduce) {
    #fsBackdrop { transition: opacity .15s linear; }
    #fsDialog { transition: opacity .15s linear; }
  }
</style>

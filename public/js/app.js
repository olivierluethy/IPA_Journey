/* Journal Web-App — shared front-end behaviour (dark redesign, round 2).
   - Mobile sidebar toggle
   - Home Daily/Weekly toggle
   - Safe HTML rendering of report bodies (DOMPurify allow-list)
   - "Full Size" FLIP modal (accessible, prefers-reduced-motion aware)
   - Inline editing for keywords and reports (no page navigation)
   - Unified filtering: segmented tabs + apprentice dropdown + content/temporal search
   - Supervisor notifications (newly released reports)                          */

(function () {
  "use strict";

  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  const SANITIZE_CFG = {
    ALLOWED_TAGS: ["p", "br", "strong", "b", "em", "i", "u", "s", "strike", "ul", "ol", "li", "a",
      "h1", "h2", "h3", "h4", "blockquote", "code", "pre", "hr",
      "img", "table", "thead", "tbody", "tfoot", "tr", "th", "td", "colgroup", "col"],
    ALLOWED_ATTR: ["href", "rel", "target", "title", "src", "alt", "colspan", "rowspan", "span", "style"],
  };
  function cleanHtml(s) {
    return window.DOMPurify ? window.DOMPurify.sanitize(s == null ? "" : String(s), SANITIZE_CFG) : "";
  }

  document.addEventListener("DOMContentLoaded", function () {
    sanitizeBodies();
    initSidebar();
    initHomeToggle();
    initFilters();
    initFullSizeModal();
    initInlineEditing();
    initNotifications();
    initCountdowns();
    initProfile();
  });

  /* --------------------- Submission countdowns ----------------------- */
  function initCountdowns() {
    const els = Array.prototype.slice.call(document.querySelectorAll("[data-countdown]"));
    if (!els.length) return;
    function fmt(ms) {
      if (ms <= 0) return "overdue";
      const mins = Math.floor(ms / 60000);
      const days = Math.floor(mins / 1440);
      const hours = Math.floor(mins / 60);
      if (days >= 2) return days + " days left";
      if (hours >= 1) return hours + (hours === 1 ? " hour left" : " hours left");
      return Math.max(1, mins) + (mins === 1 ? " minute left" : " minutes left");
    }
    function tick() {
      const now = Date.now();
      els.forEach(function (el) {
        const dl = parseInt(el.dataset.deadline || "0", 10);
        const left = dl - now;
        el.textContent = fmt(left);
        el.classList.remove("text-amber-400", "text-danger", "text-slate-300");
        if (left <= 0) el.classList.add("text-danger");
        else if (left < 2 * 3600000) el.classList.add("text-danger");
        else if (left < 24 * 3600000) el.classList.add("text-amber-400");
        else el.classList.add("text-slate-300");
      });
    }
    tick();
    setInterval(tick, 1000 * 30);
  }

  /* --------------- Overview: per-apprentice profile ------------------ */
  function initProfile() {
    const root = document.querySelector("[data-filter-root]");
    if (!root) return;
    const select = root.querySelector("[data-filter-select]");
    const profile = document.querySelector("[data-profile]");
    if (!select || !profile) return;

    function show(name) {
      if (!name || name === "all") { profile.style.display = "none"; return; }
      const all = document.querySelectorAll('[data-report-card][data-author="' + cssEsc(name) + '"]');
      let d = 0, w = 0;
      all.forEach((c) => (c.dataset.type === "daily" ? d++ : w++));
      const set = (sel, val) => { const e2 = profile.querySelector(sel); if (e2) e2.textContent = val; };
      set("[data-profile-name]", name);
      set("[data-profile-initials]", initials(name));
      set("[data-profile-daily]", d);
      set("[data-profile-weekly]", w);
      profile.style.display = "";
    }
    function select_(name) { select.value = name; select.dispatchEvent(new Event("change")); show(name); }

    select.addEventListener("change", () => show(select.value));
    document.addEventListener("click", function (e) {
      const a = e.target.closest("[data-apprentice]");
      if (a) { select_(a.getAttribute("data-name")); }
      const back = e.target.closest("[data-profile-back]");
      if (back) { select_("all"); }
    });

    // Deep link from the dashboard roster: overview#a=<name>
    if (location.hash.indexOf("#a=") === 0) {
      const name = decodeURIComponent(location.hash.slice(3));
      const opt = Array.prototype.some.call(select.options, (o) => o.value === name);
      if (opt) select_(name);
    }
  }
  function initials(name) {
    const p = name.trim().split(/\s+/);
    return ((p[0] || "")[0] || "").toUpperCase() + ((p[1] || "")[0] || "").toUpperCase();
  }
  function cssEsc(s) { return s.replace(/"/g, '\\"'); }

  /* ---------------- Safe HTML rendering of report bodies -------------- */
  // Bodies are emitted escaped by PHP (so nothing executes on load); here we
  // sanitize the raw markup and inject it as formatted, XSS-safe HTML.
  function sanitizeBodies() {
    document.querySelectorAll(".report-html").forEach(function (el) {
      if (el.dataset.sanitized) return;
      el.innerHTML = cleanHtml(el.textContent);
      el.dataset.sanitized = "1";
    });
  }

  /* ----------------------------- Sidebar ----------------------------- */
  function initSidebar() {
    const burger = document.getElementById("burger");
    const sidebar = document.getElementById("sidebar");
    const backdrop = document.getElementById("sidebarBackdrop");
    if (!burger || !sidebar) return;
    const open = () => { sidebar.classList.remove("-translate-x-full"); if (backdrop) backdrop.classList.remove("hidden"); };
    const close = () => { sidebar.classList.add("-translate-x-full"); if (backdrop) backdrop.classList.add("hidden"); };
    burger.addEventListener("click", () => (sidebar.classList.contains("-translate-x-full") ? open() : close()));
    if (backdrop) backdrop.addEventListener("click", close);
  }

  /* --------------------------- Home toggle --------------------------- */
  function initHomeToggle() {
    const buttons = document.querySelectorAll("[data-toggle]");
    if (!buttons.length) return;
    const daily = document.getElementById("dailyreports");
    const weekly = document.getElementById("weeklyreports");
    const noDaily = document.getElementById("noDailyMessage");
    const noWeekly = document.getElementById("noWeeklyMessage");
    function show(topic) {
      const isDaily = topic === "daily";
      buttons.forEach((b) => {
        const on = b.dataset.toggle === topic;
        b.classList.toggle("is-active", on);
        b.setAttribute("aria-selected", on ? "true" : "false");
      });
      if (daily) daily.style.display = isDaily ? "" : "none";
      if (noDaily) noDaily.style.display = isDaily ? "" : "none";
      if (weekly) weekly.style.display = isDaily ? "none" : "";
      if (noWeekly) noWeekly.style.display = isDaily ? "none" : "";
    }
    buttons.forEach((b) => b.addEventListener("click", () => show(b.dataset.toggle)));
    show("daily");
  }

  /* ---------------- Unified filtering (tabs + select + search) -------- */
  function initFilters() {
    document.querySelectorAll("[data-filter-root]").forEach(setupFilterRoot);
  }

  function setupFilterRoot(root) {
    const searchInput = root.querySelector("[data-search]");
    const select = root.querySelector("[data-filter-select]");
    const empty = root.querySelector("[data-empty]");
    const groups = root.querySelectorAll("[data-tabgroup]");

    // Remember original DOM order so we can restore it when the query clears.
    root.querySelectorAll("[data-search-item]").forEach((it, i) => { it.dataset.order = i; });

    const apply = debounce(() => applyFilters(root, searchInput, select, empty), 120);

    // Tab groups (segmented control, reused visual). Arrow-key a11y + session memory.
    groups.forEach(function (group) {
      const key = group.dataset.key;
      const btns = Array.prototype.slice.call(group.querySelectorAll("[data-tab]"));
      const storeKey = "tab:" + location.pathname + ":" + key;

      function setActive(val, focus) {
        btns.forEach((b) => {
          const on = b.dataset.value === val;
          b.classList.toggle("is-active", on);
          b.setAttribute("aria-selected", on ? "true" : "false");
          b.tabIndex = on ? 0 : -1;
          if (on && focus) b.focus();
        });
        try { sessionStorage.setItem(storeKey, val); } catch (e) {}
        applyFilters(root, searchInput, select, empty);
      }
      btns.forEach((b, i) => {
        b.setAttribute("role", "tab");
        b.addEventListener("click", () => setActive(b.dataset.value, false));
        b.addEventListener("keydown", (e) => {
          if (e.key !== "ArrowRight" && e.key !== "ArrowLeft") return;
          e.preventDefault();
          let idx = btns.indexOf(b) + (e.key === "ArrowRight" ? 1 : -1);
          if (idx < 0) idx = btns.length - 1;
          if (idx >= btns.length) idx = 0;
          setActive(btns[idx].dataset.value, true);
        });
      });
      let stored = null;
      try { stored = sessionStorage.getItem(storeKey); } catch (e) {}
      const valid = btns.some((b) => b.dataset.value === stored);
      setActive(valid ? stored : btns[0].dataset.value, false);
    });

    if (searchInput) searchInput.addEventListener("input", apply);
    if (select) select.addEventListener("change", apply);
    applyFilters(root, searchInput, select, empty);
  }

  function activeTabValues(root) {
    const values = {};
    root.querySelectorAll("[data-tabgroup]").forEach(function (group) {
      const active = group.querySelector('[data-tab][aria-selected="true"]') || group.querySelector("[data-tab]");
      values[group.dataset.key] = active ? active.dataset.value : "all";
    });
    return values;
  }

  // --- Fuzzy ranking (Levenshtein) ---------------------------------
  function levenshtein(a, b) {
    const m = a.length, n = b.length;
    if (!m) return n; if (!n) return m;
    let prev = new Array(n + 1);
    for (let j = 0; j <= n; j++) prev[j] = j;
    for (let i = 1; i <= m; i++) {
      let cur = [i];
      for (let j = 1; j <= n; j++) {
        const cost = a[i - 1] === b[j - 1] ? 0 : 1;
        cur[j] = Math.min(prev[j] + 1, cur[j - 1] + 1, prev[j - 1] + cost);
      }
      prev = cur;
    }
    return prev[n];
  }
  function tokenize(s) {
    return (s || "").toLowerCase().replace(/[^\p{L}\p{N}\s]/gu, " ").split(/\s+/).filter(Boolean);
  }
  function tokenSim(q, t) {
    if (!t) return 0;
    if (t === q) return 1;
    if (t.indexOf(q) === 0 || q.indexOf(t) === 0) return 0.95;     // prefix boost
    if (t.indexOf(q) > -1 || q.indexOf(t) > -1) return 0.85;        // substring boost
    return 1 - levenshtein(q, t) / Math.max(q.length, t.length);    // fuzzy
  }
  // Per-report relevance: best weighted field match per query token, averaged.
  function scoreItem(it, qTokens) {
    const fields = [
      { toks: tokenize(it.dataset.author), w: 1.6 },
      { toks: tokenize(it.dataset.topics), w: 1.6 },
      { toks: tokenize(it.textContent), w: 1.0 },
    ];
    let total = 0;
    qTokens.forEach((q) => {
      let best = 0;
      for (const f of fields) for (const ft of f.toks) { const s = tokenSim(q, ft) * f.w; if (s > best) best = s; }
      total += best;
    });
    return total / qTokens.length;
  }

  const FUZZY_THRESHOLD = 0.55;  // loose; below this we fall back to "closest matches"
  const CLOSEST_N = 6;

  function applyFilters(root, searchInput, select, empty) {
    const raw = (searchInput && searchInput.value ? searchInput.value : "").trim().toLowerCase();
    const parsed = parseDateQuery(raw);
    const tabs = activeTabValues(root);
    const author = select ? select.value : "all";
    const items = Array.prototype.slice.call(root.querySelectorAll("[data-search-item]"));
    const closestLabel = root.querySelector("[data-closest]");

    // 1) Hard pre-filters: tab(s), apprentice, parsed date range.
    const candidates = items.filter(function (it) {
      for (const key in tabs) { const v = tabs[key]; if (v && v !== "all" && it.dataset[key] !== v) return false; }
      if (author && author !== "all" && it.dataset.author !== author) return false;
      if (parsed.range) {
        const ms = it.dataset.date ? Date.parse(it.dataset.date + "T00:00:00") : NaN;
        if (isNaN(ms) || ms < parsed.range[0] || ms > parsed.range[1]) return false;
      }
      return true;
    });

    const hidden = items.filter((it) => candidates.indexOf(it) === -1);
    hidden.forEach((it) => (it.style.display = "none"));

    const qTokens = parsed.textTerms;
    let usedFallback = false;

    if (!qTokens.length) {
      // No text query → restore original order, show all candidates.
      candidates.sort((a, b) => (+a.dataset.order) - (+b.dataset.order));
      candidates.forEach((it) => { it.style.display = ""; reorder(it); });
    } else {
      // 2) Fuzzy rank candidates.
      const scored = candidates.map((it) => ({ it: it, s: scoreItem(it, qTokens) })).sort((a, b) => b.s - a.s);
      let shown = scored.filter((x) => x.s >= FUZZY_THRESHOLD);
      if (!shown.length && scored.length) { shown = scored.slice(0, CLOSEST_N); usedFallback = true; } // never empty
      const shownSet = new Set(shown.map((x) => x.it));
      shown.forEach((x) => { x.it.style.display = ""; reorder(x.it); });
      candidates.forEach((it) => { if (!shownSet.has(it)) it.style.display = "none"; });
    }

    if (closestLabel) closestLabel.style.display = usedFallback ? "" : "none";
    if (empty) empty.style.display = (candidates.length === 0) ? "" : "none";
  }

  // Re-append item to its parent so DOM order reflects relevance ranking.
  function reorder(it) { it.parentNode.appendChild(it); }

  /* ----------------------- Temporal query parsing -------------------- */
  const MONTHS = { jan: 0, feb: 1, mar: 2, apr: 3, may: 4, jun: 5, jul: 6, aug: 7, sep: 8, oct: 9, nov: 10, dec: 11 };
  function dayRange(y, m, d) { const s = new Date(y, m, d).getTime(); return [s, new Date(y, m, d + 1).getTime() - 1]; }
  function monthRange(y, m) { return [new Date(y, m, 1).getTime(), new Date(y, m + 1, 1).getTime() - 1]; }
  function yearRange(y) { return [new Date(y, 0, 1).getTime(), new Date(y + 1, 0, 1).getTime() - 1]; }

  // Returns { textTerms: [..], range: [startMs,endMs]|null }
  function parseDateQuery(q) {
    if (!q) return { textTerms: [], range: null };
    let range = null;
    let rest = q;

    function consume(re, fn) {
      if (range) return;
      const m = rest.match(re);
      if (m) { range = fn(m); rest = (rest.slice(0, m.index) + " " + rest.slice(m.index + m[0].length)).trim(); }
    }

    const now = new Date();
    const startOfDay = (dt) => new Date(dt.getFullYear(), dt.getMonth(), dt.getDate());
    // relative
    if (!range && /\btoday\b/.test(rest)) { const d = startOfDay(now); range = [d.getTime(), d.getTime() + 86399999]; rest = rest.replace(/\btoday\b/, "").trim(); }
    if (!range && /\byesterday\b/.test(rest)) { const d = startOfDay(now); range = [d.getTime() - 86400000, d.getTime() - 1]; rest = rest.replace(/\byesterday\b/, "").trim(); }
    if (!range && /\b(this|last) week\b/.test(rest)) {
      const m = rest.match(/\b(this|last) week\b/);
      const d = startOfDay(now); const dow = (d.getDay() + 6) % 7; // Monday=0
      let monday = new Date(d.getTime() - dow * 86400000);
      if (m[1] === "last") monday = new Date(monday.getTime() - 7 * 86400000);
      range = [monday.getTime(), monday.getTime() + 7 * 86400000 - 1];
      rest = rest.replace(m[0], "").trim();
    }
    if (!range && /\bthis month\b/.test(rest)) { range = monthRange(now.getFullYear(), now.getMonth()); rest = rest.replace(/\bthis month\b/, "").trim(); }
    // ISO yyyy-mm-dd
    consume(/\b(\d{4})-(\d{1,2})-(\d{1,2})\b/, (m) => dayRange(+m[1], +m[2] - 1, +m[3]));
    // dd.mm.yyyy
    consume(/\b(\d{1,2})\.(\d{1,2})\.(\d{4})\b/, (m) => dayRange(+m[3], +m[2] - 1, +m[1]));
    // d month yyyy  (e.g. 5 may 2026)
    consume(/\b(\d{1,2})\s+([a-z]{3,9})\s+(\d{4})\b/, (m) => {
      const mo = MONTHS[m[2].slice(0, 3)]; return mo == null ? null : dayRange(+m[3], mo, +m[1]);
    });
    // month yyyy
    consume(/\b([a-z]{3,9})\s+(\d{4})\b/, (m) => {
      const mo = MONTHS[m[1].slice(0, 3)]; return mo == null ? null : monthRange(+m[2], mo);
    });
    // bare year
    consume(/\b(\d{4})\b/, (m) => yearRange(+m[1]));

    // anything matched to null (invalid month) — treat as no range
    const textTerms = rest.split(/\s+/).filter(Boolean);
    return { textTerms: textTerms, range: range };
  }

  function debounce(fn, ms) {
    let t; return function () { clearTimeout(t); const a = arguments, c = this; t = setTimeout(() => fn.apply(c, a), ms); };
  }

  /* -------------------------- Full Size modal ------------------------ */
  let modal, dialog, lastTrigger, modalReturn = null;

  function buildModal() {
    modal = document.createElement("div");
    modal.id = "fsModal";
    modal.hidden = true;
    modal.setAttribute("role", "dialog");
    modal.setAttribute("aria-modal", "true");
    modal.setAttribute("aria-label", "Report full size view");
    modal.innerHTML =
      '<div id="fsBackdrop"></div>' +
      '<div id="fsDialog" class="relative w-full" style="max-width:820px">' +
      '  <button type="button" id="fsClose" class="btn-icon absolute top-3 right-3 z-10 bg-surface-2 border border-border" aria-label="Close full size"><i class="fa-solid fa-xmark"></i></button>' +
      '  <div id="fsContent" class="scroll-area" style="max-height:88vh"></div>' +
      "</div>";
    document.body.appendChild(modal);
    dialog = modal.querySelector("#fsDialog");
    modal.querySelector("#fsClose").addEventListener("click", closeModal);
    modal.querySelector("#fsBackdrop").addEventListener("click", closeModal);
    document.addEventListener("keydown", function (e) {
      if (modal.hidden) return;
      if (e.key === "Escape") closeModal();
      if (e.key === "Tab") trapFocus(e);
    });
  }

  function initFullSizeModal() {
    buildModal();
    document.addEventListener("click", function (e) {
      const btn = e.target.closest("[data-fullsize]");
      if (!btn || modal.hidden === false) return;
      const card = btn.closest("[data-report-card]");
      if (card) openModal(card, btn);
    });
  }

  // The actual card is MOVED into the modal (not cloned) so its live TipTap
  // editor keeps working; a placeholder holds its place in the grid.
  function openModal(card, trigger) {
    lastTrigger = trigger;
    const srcRect = card.getBoundingClientRect();
    const placeholder = document.createElement("div");
    placeholder.style.height = srcRect.height + "px";
    card.parentNode.insertBefore(placeholder, card);

    modalReturn = { card: card, placeholder: placeholder, bodies: [] };
    card.querySelectorAll("[data-card-body]").forEach((b) => {
      modalReturn.bodies.push([b, b.style.maxHeight]);
      b.style.maxHeight = "none";
      b.classList.remove("scroll-area");
    });

    const content = modal.querySelector("#fsContent");
    content.innerHTML = "";
    content.appendChild(card);

    modal.hidden = false;
    const target = dialog.getBoundingClientRect();
    flip(srcRect, target, false);
    modal.querySelector("#fsClose").focus();
  }

  function closeModal() {
    if (!modal || modal.hidden || !modalReturn) return;
    const ret = modalReturn;
    let done = false;
    function finish() {
      if (done) return;
      done = true;
      modal.hidden = true;
      modal.classList.remove("is-open");
      dialog.style.transform = ""; dialog.style.opacity = ""; dialog.style.borderRadius = ""; dialog.style.transition = "";
      dialog.removeEventListener("transitionend", finish);
      // Restore the card to the grid and re-apply inner-scroll caps.
      ret.placeholder.parentNode.replaceChild(ret.card, ret.placeholder);
      ret.bodies.forEach(([b, mh]) => { b.style.maxHeight = mh; b.classList.add("scroll-area"); });
      modal.querySelector("#fsContent").innerHTML = "";
      modalReturn = null;
      if (lastTrigger) lastTrigger.focus();
    }
    const dstRect = ret.placeholder.getBoundingClientRect();
    const target = dialog.getBoundingClientRect();
    if (reduceMotion || !dstRect.width) {
      modal.classList.remove("is-open"); dialog.style.opacity = "0"; setTimeout(finish, 160); return;
    }
    modal.classList.remove("is-open");
    dialog.addEventListener("transitionend", finish);
    setTimeout(finish, 500); // fallback if transitionend doesn't fire
    dialog.style.transform = `translate(${dstRect.left - target.left}px, ${dstRect.top - target.top}px) scale(${Math.max(0.05, dstRect.width / target.width)})`;
    dialog.style.opacity = "0.4";
    dialog.style.borderRadius = "9999px";
  }

  // Animate the dialog from a source rect onto its centered position.
  function flip(srcRect, target, reverse) {
    if (reduceMotion || !srcRect.width) {
      dialog.style.opacity = "0";
      requestAnimationFrame(() => { modal.classList.add("is-open"); dialog.style.opacity = "1"; });
      return;
    }
    const scale = Math.max(0.05, srcRect.width / target.width);
    dialog.style.transition = "none";
    dialog.style.transformOrigin = "top left";
    dialog.style.transform = `translate(${srcRect.left - target.left}px, ${srcRect.top - target.top}px) scale(${scale})`;
    dialog.style.opacity = "0.6";
    dialog.style.borderRadius = "9999px";
    void dialog.offsetWidth;
    requestAnimationFrame(() => {
      modal.classList.add("is-open");
      dialog.style.transition = "";
      dialog.style.transform = "translate(0,0) scale(1)";
      dialog.style.opacity = "1";
      dialog.style.borderRadius = "";
    });
  }

  function trapFocus(e) {
    const list = Array.prototype.filter.call(
      modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'),
      (el) => !el.disabled && el.offsetParent !== null
    );
    if (!list.length) return;
    const first = list[0], last = list[list.length - 1];
    if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
    else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
  }

  /* -------------------------- Inline editing ------------------------- */
  function initInlineEditing() {
    document.addEventListener("click", onInlineClick);
    document.addEventListener("submit", onInlineSubmit);
  }

  function onInlineClick(e) {
    const t = e.target;
    const kwEdit = t.closest("[data-kw-edit-btn]");
    if (kwEdit) { const chip = kwEdit.closest("[data-keyword]"); chip.querySelector("[data-kw-view]").classList.add("hidden"); const f = chip.querySelector("[data-kw-form]"); f.classList.remove("hidden"); f.querySelector("input").focus(); return; }
    const kwCancel = t.closest("[data-kw-cancel]");
    if (kwCancel) { const chip = kwCancel.closest("[data-keyword]"); chip.querySelector("[data-kw-form]").classList.add("hidden"); chip.querySelector("[data-kw-view]").classList.remove("hidden"); return; }
    const kwDelete = t.closest("[data-kw-delete]");
    if (kwDelete) { const chip = kwDelete.closest("[data-keyword]"); if (confirm("Delete this keyword?")) location.href = "deleteKeyword?id=" + chip.getAttribute("data-id"); return; }
    const kwAddToggle = t.closest("[data-kw-add-toggle]");
    if (kwAddToggle) { const row = document.querySelector("[data-kw-add-row]"); if (row) { row.classList.toggle("hidden"); if (!row.classList.contains("hidden")) row.querySelector("input").focus(); } return; }

    const repEdit = t.closest("[data-edit]");
    if (repEdit) { toggleReportEdit(repEdit.closest("[data-report-card]"), true); return; }
    const repCancel = t.closest("[data-cancel]");
    if (repCancel) { const card = repCancel.closest("[data-report-card]"); card.querySelector("[data-edit-form]").reset(); toggleReportEdit(card, false); return; }
  }

  function toggleReportEdit(card, editing) {
    const id = card.getAttribute("data-id"), type = card.getAttribute("data-type");
    document.querySelectorAll('[data-report-card][data-id="' + id + '"][data-type="' + type + '"]').forEach((c) => toggleReportEditEl(c, editing));
  }
  function toggleReportEditEl(c, editing) {
    const disp = c.querySelector("[data-display]"), form = c.querySelector("[data-edit-form]");
    if (disp) disp.classList.toggle("hidden", editing);
    if (form) form.classList.toggle("hidden", !editing);
  }

  function onInlineSubmit(e) {
    const form = e.target;
    if (form.matches("[data-kw-form]")) { e.preventDefault(); submitKeywordEdit(form); }
    else if (form.matches("[data-kw-add-form]")) { e.preventDefault(); submitKeywordAdd(form); }
    else if (form.matches("[data-edit-form]")) { e.preventDefault(); submitReportEdit(form); }
  }

  function postForm(action, formData) {
    return fetch(action, { method: "POST", headers: { "X-Requested-With": "XMLHttpRequest" }, body: formData })
      .then((r) => (r.ok ? r.json().catch(() => ({ ok: true })) : Promise.reject(r)));
  }

  function submitKeywordEdit(form) {
    const chip = form.closest("[data-keyword]");
    const value = form.querySelector("input").value.trim();
    if (!value) return;
    postForm(form.action, new FormData(form)).then(() => {
      chip.querySelector("[data-kw-label]").textContent = value;
      form.classList.add("hidden");
      chip.querySelector("[data-kw-view]").classList.remove("hidden");
    }).catch(() => alert("Could not save the keyword."));
  }

  function submitKeywordAdd(form) {
    const input = form.querySelector("input");
    const value = input.value.trim();
    if (!value) return;
    postForm(form.action, new FormData(form)).then((data) => {
      const tpl = document.getElementById("kwChipTemplate");
      const list = document.getElementById("keywordList");
      if (tpl && list && data && data.id) {
        const node = tpl.content.firstElementChild.cloneNode(true);
        node.setAttribute("data-id", data.id);
        node.querySelector("[data-kw-label]").textContent = value;
        node.querySelector("[data-kw-form]").action = "editKeyword?id=" + data.id;
        list.appendChild(node);
      } else { window.location.reload(); return; }
      input.value = "";
      form.closest("[data-kw-add-row]").classList.add("hidden");
      const empty = document.getElementById("keywordsEmpty"); if (empty) empty.remove();
    }).catch(() => alert("Could not add the keyword."));
  }

  function submitReportEdit(form) {
    const card = form.closest("[data-report-card]");
    const id = card.getAttribute("data-id"), type = card.getAttribute("data-type");
    postForm(form.action, new FormData(form)).then(() => {
      document.querySelectorAll('[data-report-card][data-id="' + id + '"][data-type="' + type + '"]').forEach((c) => {
        Array.prototype.forEach.call(form.elements, (el) => {
          if (!el.name) return;
          const field = el.name.replace("[]", "");
          const target = c.querySelector('[data-field="' + field + '"]');
          if (!target) return;
          if (el.tagName === "SELECT") target.innerHTML = el.options[el.selectedIndex].text;
          else if (target.classList.contains("report-html")) target.innerHTML = cleanHtml(el.value);
          else target.textContent = el.value;
        });
        toggleReportEditEl(c, false);
      });
    }).catch(() => alert("Could not save the report."));
  }

  /* --------------------------- Notifications ------------------------- */
  function initNotifications() {
    const bell = document.getElementById("notifBtn");
    if (!bell) return;
    const panel = document.getElementById("notifPanel");
    const badge = document.getElementById("notifBadge");
    const items = Array.prototype.slice.call(document.querySelectorAll("#notifList [data-notif]"));
    const key = "lastSeenReleases:" + (bell.dataset.uid || "anon");
    let lastSeen = parseInt(localStorage.getItem(key) || "0", 10);

    function refresh() {
      let n = 0;
      items.forEach((it) => {
        const isNew = parseInt(it.dataset.ts || "0", 10) > lastSeen;
        it.classList.toggle("is-new", isNew);
        if (isNew) n++;
      });
      if (n > 0) { badge.textContent = n; badge.classList.remove("hidden"); }
      else badge.classList.add("hidden");
    }
    function open() {
      panel.classList.remove("hidden");
      bell.setAttribute("aria-expanded", "true");
      lastSeen = Date.now();
      try { localStorage.setItem(key, String(lastSeen)); } catch (e) {}
      refresh();
    }
    function close() { panel.classList.add("hidden"); bell.setAttribute("aria-expanded", "false"); }

    bell.addEventListener("click", (e) => { e.stopPropagation(); panel.classList.contains("hidden") ? open() : close(); });
    document.addEventListener("click", (e) => { if (!panel.contains(e.target) && !bell.contains(e.target)) close(); });
    document.addEventListener("keydown", (e) => { if (e.key === "Escape") close(); });

    items.forEach((it) => it.addEventListener("click", function () {
      close();
      const card = document.querySelector('[data-report-card][data-id="' + it.dataset.id + '"][data-type="' + it.dataset.type + '"]');
      if (card) { const b = card.querySelector("[data-fullsize]"); if (b) b.click(); }
      else location.href = "overview";
    }));

    refresh();
  }
})();

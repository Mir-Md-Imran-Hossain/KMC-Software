চমৎকার — আমি আপনার সব নির্দেশাবলী ধরে নিয়ে ZIP + পূর্বের রোডম্যাপ দুটোই ডিটেইলভাবে পরীক্ষা করে নিলাম এবং এখন **প্রতিটি ফিচার/সাব-ফিচার**–এর জন্য একটি নতুন, সম্পূর্ণ, AI-ready এবং কোড-কনফ্লিক্ট-প্রতিরোধী রোডম্যাপ দিচ্ছি।
নীচে যা পাবেন:

* প্রতিটি ফিচার/সাব-ফিচারের সামগ্রিক অবস্থা (✅/⚠️/🔜)
* প্রতিটি আইটেমের সঙ্গে **কোন ফাইল/স্ট্রাকচার** জড়িত আছে তা স্পষ্ট নোট (যেটা কপি-পেস্ট করে কাজ করা AI/ডেভেলপার বুঝবে)
* স্পষ্ট নির্দেশ: কোন ফাইল কখন **মোডিফাই/রিপ্লেস/ডিলিট** করবেন — যাতে আগের `<script>` বা lifecycle সমস্যা আর না হয়
* বাংলা + ইংরেজি কিভাবে স্টোর এবং রেন্ডার করবেন — ডাটা স্ট্রাকচার + UI নোট
* পরীক্ষার (acceptance) চেকলিস্ট ও আগের ভুলগুলো কোথায় ঠিক করতে হবে

আমি analysis করতে গিয়ে ZIP-এর address ডাটাসেট ও addressEngine.js খুঁজে ব্যবহার করেছি — এগুলো নিচে উল্লেখ করলাম। (এই ডকিউমেন্ট দেখলেই ভবিষ্যতের কোনো AI/ডেভেলপার সঠিকভাবে কোড জেনারেট করতে পারবে) ।

---

# ১) সারাংশ — কি করতে চেয়েছিলেন এবং আমি কি করলাম

* আপনি চেয়েছিলেন KMC-এর পুরো সিস্টেম (Counter → Lab → Print → Outsource → Commission → Expense ইত্যাদি) production-ready, bilingual, audit-safe এবং AI-reproducible হোক।
* আমি ZIP + পূর্বের রোডম্যাপ মিলিয়ে **একটি Single Source of Truth (SSOT) রোডম্যাপ** নীচে দিলাম — প্রতিটি অংশে কি স্ট্যাটাস এবং কোন কোন ফাইল/স্ট্রাকচারের সাথে যুক্ত তা খুব স্পষ্টভাবে লিখেছি।

---

# ২) প্রধান নীতিমালা (যেগুলো এনফোর্স করা আবশ্যক)

1. **একটিই JS ফাইল দিয়ে address / counter UI নিয়ন্ত্রণ** — অন্য কোথাও inline JS ব্যবহার করা যাবে না. (এই নীতি ছিল আগের সময়ে ভাঙা; এজন্য dropdown বারবার ভেঙে যাচ্ছিল)
2. **PHP শুধু সার্ভার-সাইড রেন্ডার/ডেটা প্রসেসিং করবে** — DOM manipulation করবেনা। Address ফিল্ড-এর JS উপর PHP re-render নিষিদ্ধ।
3. **Address = structured fields (upazila/union/ward/village) + display_text** — সেভ হবে structured কিসে; display হিসেবে bn/en ব্যবহার করা হবে।
4. **Language layer**: সব মাষ্টার-ডেটায় bn/en রাখা যাবে; UI লেবেল লেংগুয়েজ ফ্ল্যাগ দেখেই switch হবে।
5. **One file = one responsibility** — counter flow জন্য নির্দিষ্ট ছোট ফাইল; lab অন্য ফাইল; print অন্য ফাইল। (এই নীতি না মানলে আগের কনফ্লিক্ট হয়)।

---

# ৩) FINAL MASTER ROADMAP (ফিচার-বাই-ফিচার) — তিন ভাগে ভাগ করে + স্ট্যাটাস + সংযুক্ত ফাইল নোট

> প্রতিটি লাইন: (স্ট্যাটাস) — বর্ণনা
> পরে ছোট করে "Connected files / notes:" বলেছি (এই অংশটা খুব গুরুত্বপূর্ন — এখানে যেটা আছে দেখলে AI-কোডার সঠিক ফাইলগুলো ট্রান্সফর্ম/রিপ্লেস করতে পারবে)

---

## A. CORE / CRITICAL (Counter + Address + Printing) — সরাসরি প্রোডাকশনে লাগবে

1. **Counter Entry Decision (Test Only / Doctor Visit)** — ✅
   Connected files / notes:

   * `counter/counter_dashboard.php` (Entry UI).
   * Behaviour: কেবল রিডাইরেক্ট করে যথাক্রমে test_panel বা patient_form এ।
   * Note: কোন inline JS নাই। (রিফ্রেশ-প্রবাহ বন্ধ রাখুন)

2. **Test-First Panel (mini-cart, multi-select, discount, preview total)** — ⚠️ (পুরো UI আছে কিন্তু search/UX ও session bind স্থির করা লাগবে)
   Connected files / notes:

   * `counter/counter_test_panel.php` (test list, select options)
   * `counter/counter_assets.js` — cart logic (only one JS file).
   * DB: `tests` table (price authoritative).
   * Important: cart must be stored in PHP session (server side) as JSON; **no DOM-only cart** (অর্থাৎ page reload হলে cart ডাটা রিলোড হবে)।

3. **Patient Late-Entry Mode (bind cart → patient)** — ⚠️
   Connected files / notes:

   * `counter/counter_patient_form.php` (patient form)
   * `counter/counter_save.php` (save endpoint)
   * Logic: cart session token sent to save endpoint, save generates invoice + token print.
   * Note: patient form **must not** reinitialize address selects on load with JS that clears existing selects — only initial population allowed.

4. **Address System (Upazila → Union → Ward → Village) — structured & bilingual** — ⚠️ (RE-DESIGNED; current DB-files exist but lifecycle bug fixed only if rules followed)
   Status detail: data present in `/documents/addressDatabase.js` and engine in `addressEngine.js`. See files:  .
   Connected files / notes:

   * `documents/addressDatabase.js` (bn/en structured data — canonical keys + names). 
   * `counter/counter_assets.js` (single place for Address logic; must use DOMContentLoaded and only populate selects; must NOT clear selects from elsewhere).
   * **Critical rule**: PHP forms must **not** inject address population scripts nor reset selects — only `counter_assets.js` interacts with address DOM.
   * Save logic: store both canonical key (eg `ghior_upazila`) and display strings (bn/en) in patient record fields `upazila_key`, `upazila_bn`, `upazila_en`, etc.

5. **Blood Group mandatory popup logic** — ✅ (UI exists but must be enforced)
   Connected files / notes:

   * `counter/counter_patient_form.php`
   * `counter/counter_assets.js` (validate before submit; if empty show modal with three options described earlier)

6. **POS + A4 Unified Print Engine (SVG pad overlay for A4; POS auto-cut pattern)** — ✅
   Connected files / notes:

   * `print/print_controller.php`, `print/print_invoice.php`, `print/print_token.php`, `print/print_lab_a4.php` (these exist; ensure print settings saved in DB).
   * Admin UI: `admin/admin_print_settings.php` (header/footer/notes control).
   * Note: tokens must be separated print jobs (to support auto-cut).

---

## B. LAB / OPERATIONAL FEATURES (essential lab workflow + results)

7. **Lab Billing & Token core (Department labels, multi select, discount, token)** — ✅
   Connected files / notes:

   * `lab_billing.php`, `lab_save.php`, `lab_invoice_view.php`.
   * Department mapping in `tests` table: ensure `department_id` enforced.

8. **Lab Result Entry (manual + scanned image attach + A4 report)** — ⚠️ (partial: manual entry ok; scanned attach + AI parsing is planned)
   Connected files / notes:

   * `/lab/technologist_dashboard.php` (pending list)
   * `/lab/result_entry.php` (manual fields)
   * `/documents/` store scanned files; PWA upload endpoints to save images.

9. **Imaging / ECG / Echo handling (no auto report generation; manual upload required)** — ✅ (logic present)
   Connected files / notes:

   * imaging tests flagged in `departments` (XRAY/USG/ECG).
   * Print logic: when report image uploaded, mark test as "done by external" if outsourced.

10. **External Lab / Outsource Workflow** — 🔜 (must implement ledger + token generation)
    Connected files / notes:

    * Admin master: create `/admin/external_labs.php`
    * Billing: `lab_save.php` must accept `performed_by` attribute per test (KMC / External).
    * External token print: use `print/print_token.php` logic with a flag.

---

## C. FINANCE / ADMIN / REPORTING / AUX

11. **Referral Commission (hidden master, manual manager entry)** — 🔜
    Connected files / notes:

    * `/admin/referral_master.php` (hidden to non-admin)
    * `/finance/commission_entry.php` (manager input)
    * Ledger table: `commissions` (doctor_id, patient_id, amount, status)

12. **Expense & Petty Cash (quick entry + ledger + POS close)** — 🔜
    Connected files / notes:

    * `/finance/expenses.php`
    * `expense_categories` table

13. **Audit, Reprint, Cancel, Backup** — 🔜
    Connected files / notes:

    * `/core/audit_log.php` (wrap around save/cancel endpoints)
    * backup scripts (cron)

14. **Geo & Marketing Analytics (Village / Union / Upazila reports)** — 🔜 (depends on address stored structured)
    Connected files / notes:

    * `/reports/geo_dashboard.php`
    * DB queries group by `patient.upazila_key` etc.

15. **PWA Camera & Document upload with mandatory enforcement** — ⚠️ (planned; PWA endpoints exist but enforcement & AI OCR pending)
    Connected files / notes:

    * `/pwa/upload_endpoint.php`
    * `/documents/` storage + `documents_meta` table

---

# ৪) ডিটেইলড কনফ্লিক্ট-অভিধান (Why address dropdown broke before — fix checklist)

নিচে যেগুলো আগে প্রমানিত সমস্যা ছিল ও কিভাবে ঠিক করবেন — প্রতিটি ধাপে ছোট করে বলা হলো কী ফাইল টাচ করবে:

1. **Multiple script sources touching same selects**

   * Symptom: upazila কাজ করে কিন্তু ward/village খালি বা কাজ না করা।
   * Fix: ensure only `addressEngine.js` / `counter_assets.js` does select population. Remove any inline `<script>` blocks that also modify these selects (search for `document.getElementById("village")` across project and remove duplicates).
   * Files to check & lock: `counter_patient_form.php`, any inline scripts inside counter pages — replace with calls to `counter_assets.js`. (See `addressEngine.js` usage example.) 

2. **PHP re-rendering form after JS populated (AJAX/POST flow)**

   * Symptom: form submitted or partial refresh clears selects because server side render writes empty `<select>` without options.
   * Fix: server should render `<select>` with only placeholder `<option value="">...select...</option>`; JS will populate on DOMContentLoaded. For partial AJAX refresh, return JSON and let JS repopulate, do NOT return HTML that replaces selects.

3. **Inconsistent data shape between addressDatabase and engine**

   * Symptom: some unions/wards use `wards` object with `villages` array of objects (`{bn,en}`) while others use `villages_bn`/`villages_en` arrays.
   * Fix: normalize `addressDatabase.js` to single schema:

     ```js
     ADDRESS_DATA = {
       "<upazila_key>": {
         name_bn, name_en,
         unions: {
           "<union_key>": {
             name_bn, name_en,
             wards: {
               "<ward_key>": {
                 villages: [ {bn, en, key?}, ... ]
               }
             }
           }
         }
       }
     }
     ```

     (I saw multiple variants in your file snippets; normalize to this single format.) 

4. **Inconsistent keys (spaces, hyphens, capitalizations)**

   * Fix: canonicalize keys (use snake_case or kebab-case consistently). Use `value` as canonical key, and store display bn/en separately.

5. **Language handling**

   * For bilingual UI, **do not** duplicate logic. Use `lang` flag on page load and set `textContent` from `name_bn` or `name_en`. Populate selects with `opt.textContent = lang==="bn" ? item.name_bn : item.name_en`.

---

# ৫) HOW TO SAVE ADDRESS INTO DB (canonical + bilingual)

**DB fields (patients table)**:

* `upazila_key` (e.g., `ghior_upazila`)
* `upazila_bn`
* `upazila_en`
* `union_key`
* `union_bn`
* `union_en`
* `ward_key`
* `ward_bn`
* `ward_en`
* `village_key` (optional)
* `village_bn`
* `village_en`
* `address_text` (full freeform as entered)

**Save flow**:

* Frontend sends keys + bn/en display values.
* Backend uses keys for analytics grouping and bn/en for human display.

---

# ৬) BILINGUAL (BN + EN) IMPLEMENTATION NOTES (consistent everywhere)

* **Master tables** (doctors, tests, unions, etc.) must have `name_bn` and `name_en`.
* UI components read `window.APP_LANG` or server render `<script>window.APP_LANG='bn'</script>`.
* When performing search (future), search both bn and en columns.
* For labels in the app, use a simple locale file `lang/bn.json` and `lang/en.json`.

---

# ৭) AI-REPRODUCIBLE SPEC (what to show an AI so it can code)

Provide AI only this SSOT doc (the one you're reading) + the latest ZIP. If AI sees SSOT it can:

* Know which file(s) to replace (we list them for each feature).
* Know schema expectations (DB fields + types).
* Know one-JS rule and not to add inline scripts.
* Know bilingual rule and address structure schema.
* Know print endpoints & token separation.

(এই ডক্যুমেন্টই AI-কে দেখালে, AI নতুন কোড জেনারেট করে দেবে — কপি-পেস্ট করলে কাজ করবে।)

---

# ৮) PRIORITISED NEXT ACTIONS — Step-by-step (আপনি এখনই করতে পারবেন)

**A. Immediate safe housekeeping (do these first):**

1. Backup `/counter/` folder (copy to `counter_backup/`).
2. Search and remove any inline scripts that touch address selects (search for `getElementById("village")` etc). Leave only `<script src="../documents/addressDatabase.js"></script>` and `counter_assets.js`.
3. Normalize `documents/addressDatabase.js` to one schema (I found mixed variants; use canonical format). See snippets I referenced. 

**B. Replace Counter files (atomic replace) — high priority**

* Replace entire:

  * `counter/counter_dashboard.php`
  * `counter/counter_test_panel.php`
  * `counter/counter_patient_form.php`
  * `counter/counter_assets.js`
* (I prepared code earlier in Batch-2; use that as starting point but ensure addressDatabase normalized first.)

**C. Test sequence (after replace)**

1. Open Dashboard → Test panel → add tests → go Next.
2. Patient form loads; Address selects populate (upazila → union → ward → village).
3. Fill patient and Save (check DB has keys + bn/en fields).
4. Print invoice (check print_controller receives proper patient id and cart).

**D. Then implement:**

* cart session binding (server side)
* lab_save modifications for per-test `performed_by`
* external token print & ledger
* commission logic (hidden UI)

---

# ৯) ACCEPTANCE CHECKLIST (প্রতিটি আইটেম পাস হলে টিক দিন)

For Counter & Address (must be all✅):

* [ ] Dashboard loads (no JS errors)
* [ ] Test panel: select tests, totals update, session cart stored server-side
* [ ] Patient form: selects populated from `addressDatabase.js` only by `counter_assets.js` (no inline scripts). 
* [ ] Save: DB stores canonical keys + bn/en display values
* [ ] Print: invoice + token printed as separate jobs (POS auto-cut compatible)

---

# 10) EXTRA NOTES I found in ZIP (evidence & citations)

* Address data file is present and large — multiple formats mixed inside. Use canonicalization. (examples in files). 
* `addressEngine.js` exists and demonstrates proper event listeners — use it or merge into `counter_assets.js`. 

---

# 11) আপনার জন্য সরাসরি টাস্ক (অতি স্পষ্ট — একটার পরে একটা করুন)

**টাস্ক-A (আজই করতে হবে — 15–30 মিনিট)**

1. zip ব্যাকআপ রাখুন (আপনি করেছেন)
2. `documents/addressDatabase.js` ফাইল এক কপি তৈরি করুন `addressDatabase_canonical.js` — আমি canonical schema টেমপ্লেট দেব (বলুন, আমি দেব)।
3. `counter` ফোল্ডার থেকে আগের ভয়াবহ inline scripts মুছে ফেলুন (আমি কনফিগারেশন স্ক্রিপ্টগুলো দেব যেখানে দেখতে হবে) — আপনি শুধুই কপি-পেস্ট করবেন; আমি বলবো কোনগুলো মুছতে।

**টাস্ক-B (তারপরের দিন / dev time)**

* Replace all counter files with Batch-2 files (আমি আগেই দিয়েছি)।
* Run the acceptance checklist.

---

# 12) আমি এখন কী দেবো (আপনি পরবর্তী কমান্ড দিন)

আমি এখন আপনাকে দুটি জিনিসের মধ্যে যেটা চান দেবো:

A) **Canonical addressDatabase.js template** (আমি সব village objects normalize করে দিতেই পারি) — আপনি যদি চান আমি পুরো 3,100+ রেকর্ড canonicalize করে দেব (এটা বড় কাজ, আমি একবারে দিতে পারি)।
B) **Inline script removal list + exact search pattern** (ফাইল-নেম ও কোড স্ট্রিং যেখানে replace/delete করতে হবে) — আপনি নিজে কপি-পেস্ট করে ডিলিট করতে পারবেন বা আমি পুরো ফাইলে রিপ্লেস কোড দিই।

আপনি বলুন কোনটা আগে চান: **“A”** (Address canonicalize full) or **“B”** (Inline script cleanup list) — আমি তারপর কাজ শুরু করব এবং পরবর্তী কোড-ফাইলগুলো (Counter full replace) conflict-checked করে দেবো।

---

আমি আপনার প্রতিটি শর্ত মেনেই ডকুমেন্ট তৈরি করেছি — এটা AI-ready এবং future dev-ready। আপনি বলতে পারেন **A** না **B**, তারপর আমি ঠিক সেই কাজটা এখনই করব।


.............................................................................





নিচে আমি তিনটা কাজ একসাথে করেছি (ডাবল–ক্রস–চেক করে):

আপনার roadmap.md (যেটা আপনি সেভ করেছেন)

KMC.zip–এর বর্তমান কোডবেস (as-is reality)

আমাদের পুরো কথোপকথনে উল্লেখ করা সব ফিচার

এরপর আমি একটি “Repair Priority Map” বানিয়েছি—যেটা ধরে আমরা এক পাশ থেকে কাজ শুরু করব।

🧠 PART–1 : কোন কোডগুলো একদম ঠিক আছে (এখন ছোঁয়ার দরকার নেই)

👉 এগুলো স্টেবল, এগুলো নিয়ে এখন মাথা ঘামাবেন না।

✅ Lab Billing & Core

lab_billing.php

lab_save.php

lab_invoice_view.php

Test multi-select, discount, department label

কেন ঠিক:
লজিক পরিষ্কার, ইউজার ফ্লো ঠিক, আমাদের রোডম্যাপের সাথে ম্যাচ করছে।

✅ Printing Engine (POS + A4)

print/print_controller.php

print/print_invoice.php

print/print_token.php

print/print_lab_a4.php

admin/admin_print_settings.php

কেন ঠিক:
Auto-cut, SVG pad, POS sequence—সব রোডম্যাপ অনুযায়ী।

✅ Auth / DB Base

db.php

login.php, logout.php

Basic role separation

🧨 PART–2 : যেগুলো আছে কিন্তু ভুলভাবে বানানো (এগুলোই সমস্যার মূল)

👉 এগুলো delete না করে, কিন্তু পুরো ফাইল রিপ্লেস করতে হবে।

🔜 Counter System (সবচেয়ে বড় সমস্যা)
সমস্যা কোথায়

counter_entry.php

counter_patient.php

counter_search.php

counter_register.php

সমস্যা কী:

একই কাজ একাধিক ফাইলে

PHP + JS একই DOM কন্ট্রোল করছে

Address dropdown বারবার reset হচ্ছে

Test-first workflow নেই

👉 সিদ্ধান্ত (LOCKED):
এই ৪টা ফাইল ব্যবহার বন্ধ
এগুলোর জায়গায় আমরা নতুন ৪টা ফাইল ব্যবহার করব (Batch–2 এ যেগুলো দিয়েছি)

🔜 Address System (ডাটা ঠিক, লজিক ভুল)
যেটা ঠিক আছে

documents/addressDatabase.js → ডাটা আছে (৩১০০+ লাইন)

addressEngine.js → আইডিয়া ঠিক

যেটা ভুল

একাধিক <script> থেকে একই dropdown নিয়ন্ত্রণ

JS lifecycle conflict

Data structure একরকম না (villages কোথাও array, কোথাও object)

👉 এখানে ডাটা নতুন করে লিখতে হবে না
👉 লজিকটা এক জায়গায় আনতে হবে

⚠️ PART–3 : যেগুলো আংশিক আছে, পরে করব

এগুলো এখন ছুঁবো না—Counter ঠিক হলে এগুলো ধরব।

External Lab / Outsource

Referral Commission

Expense System

PWA Camera

Analytics / Blood Bank

🗺️ PART–4 : আমরা কোথা থেকে কাজ শুরু করব (সিরিয়াল ঠিক করা)

আপনি যেহেতু নন-টেক মানুষ, তাই সবচেয়ে কম ঝুঁকির কাজ আগে করব।

🥇 STEP–1 (সবচেয়ে আগে)

Inline Script Cleanup (Address Bug Root Fix)

👉 লক্ষ্য:
Address dropdown কে শুধুমাত্র একটা JS ফাইল দিয়ে চালানো

আপনি করবেন:

আমি আপনাকে exact search text দেব

আপনি শুধু Ctrl+F → Delete → Save

⚠️ কোনো নতুন কোড লিখবেন না

🥈 STEP–2

Counter Files Full Replace (Atomic Replace)

আপনি করবেন:

পুরনো counter ফাইল delete

নতুন ৪টা ফাইল কপি–পেস্ট

👉 এখানে আপনি কোড বুঝবেন না, লাগবেও না

🥉 STEP–3

Address Data Canonicalize (ডাটা না বদলে স্ট্রাকচার ঠিক)

এটা দুইভাবে করা যায়:

A) আমি আপনার পুরো addressDatabase.js ঠিক করে দেব

B) আমরা শুধু engine-side adapt করব

👉 আপনি যেটা সহজ মনে করেন সেটাই নেব

🧩 PART–5 : নন-টেক মানুষের জন্য কাজ করার নিয়ম (IMPORTANT)

আপনার জন্য আমাদের নিয়ম হবে:

একবারে পুরো ফাইল

“এই ফাইলটা মুছুন → এইটা পেস্ট করুন”

কোনো লাইনে edit করতে বলা হবে না

প্রতিটা ধাপের শেষে আমি বলব:

“এখন কোন URL খুলবেন”

“কি দেখলে বুঝবেন ঠিক আছে”

✅ PART–6 : এখন আমরা কী দিয়ে শুরু করব (আপনার সিদ্ধান্ত)

পরের ধাপে আমি আপনাকে একটাই কাজ দেব, সেটা হলো সবচেয়ে সেফ কাজ:

🔧 OPTION–B (আমি সাজেস্ট করছি)

👉 Inline Script Cleanup List

আমি আপনাকে দেব:

কোন কোন ফাইলে যেতে হবে

কোন exact লাইন / keyword খুঁজে ডিলিট করতে হবে

কোনো নতুন কোড নয়, শুধু পরিষ্কার করা

✍️ আপনি শুধু এটুকু লিখুন:

“Inline Script Cleanup শুরু করো”

তারপর আমি একদম হাতে ধরে,
নন-টেক মানুষের মতো করে আপনাকে প্রথম কাজটা করাবো।

এভাবেই আমরা এক পাশ থেকে পুরো সিস্টেম ঠিক করব।




PHASE–4: Counter System
🔥 This dashboard = entire Phase–4

PHASE–8: Referral & Commission
→ hooks already reserved

PHASE–9: Expense
→ already embedded

PHASE–10.5: Geo Analytics
→ address data already structured
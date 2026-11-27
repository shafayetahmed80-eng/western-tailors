# Western Bespoke — থিম কমপ্যাটিবিলিটি ও আপডেট সুরক্ষা গাইড

এই ডকুমেন্টে **Western Bespoke** (`ninico` কাস্টমাইজড থিম, Botble CMS / Laravel 12)-এর নতুন **Luxury Deep Emerald & Antique Brass Atelier** ডিজাইনের সাথে সিস্টেমের সামঞ্জস্য, পরিবর্তনকৃত ফাইলের তালিকা এবং ভবিষ্যতে থিম বা Botble CMS আপডেট এলে নিরাপদ থাকার নির্দেশিকা সংরক্ষণ করা হয়েছে।

---

## ১. মূল সারসংক্ষেপ

- **থিম সিস্টেমের সাথে কনফ্লিক্ট:** **নেই।** নতুন হোমপেজ ও সাইটওয়াইড ডিজাইন Botble CMS-এর স্ট্যান্ডার্ড Shortcode, Theme Options, Blade Partial এবং Asset রেজিস্ট্রেশন মেনেই তৈরি।
- **সাধারণ আপডেট ও অ্যাডমিন ব্যবহার:** অ্যাডমিন প্যানেল থেকে প্রোডাক্ট, ক্যাটাগরি, পেজ, মেনু, অর্ডার, কনট্যাক্ট বা Theme Options পরিবর্তন করলে এবং সাধারণ Laravel/Composer প্যাকেজ আপডেট করলে **কোনো সমস্যা হবে না**।
- **Ninico থিম বা Botble Core আপডেট:** Botble-এর **1-Click System Updater** (`cms:update`) বা ম্যানুয়ালি `ninico` ফোল্ডার রিপ্লেস করলে কাস্টম এডিট করা থিম ফাইলগুলো **ওভাররাইট হওয়ার ঝুঁকি আছে**। তাই যেকোনো সিস্টেম/থিম আপডেট **Git ব্রাঞ্চ ও Pull Request ফ্লো** মেনে মার্জ করতে হবে।

---

## ২. থিম সিস্টেমের সাথে কেন কনফ্লিক্ট করে না?

| বিষয় | টেকনিক্যাল বাস্তবায়ন | প্রভাব ও সুবিধা |
| :--- | :--- | :--- |
| **মূল থিম Asset অক্ষত** | `platform/themes/ninico/config.php`-তে `theme.css` ও `theme.js`-এর সাথে আলাদা করে `atelier.css` ও `atelier.js` লোড করা হয়েছে | পূর্বের সব Botble ও Ninico কম্পোনেন্ট স্বাভাবিকভাবে কাজ করে |
| **আলাদা CSS ক্লাস ও টোকেন** | নতুন ডিজাইনে `.wb-*` প্রিফিক্স এবং `--wb-*` CSS ভ্যারিয়েবল ব্যবহার করা হয়েছে (`layouts/base.blade.php`) | Shop, Product Details, Cart, Checkout ও Checkout ফ্লোতে লেআউট ভাঙে না |
| **ডাবল Asset সংরক্ষণ** | `atelier.css` ও `atelier.js` সোর্স (`platform/themes/ninico/public/`) ও পাবলিক (`public/themes/ninico/`) দুই জায়গাতেই আছে | `php artisan cms:theme:assets:publish` চালালেও স্টাইল/স্ক্রিপ্ট হারিয়ে যায় না |
| **স্ট্যান্ডার্ড Botble Shortcode** | ৫টি নতুন শর্টকোড (`atelier-hero`, `atelier-archive`, `atelier-craft`, `atelier-masterpieces`, `atelier-concierge`) `functions/shortcodes.php`-এ নিবন্ধিত | পুরোনো শর্টকোড (`bespoke-trust-badges`, `bespoke-journey` ইত্যাদি) ডিলিট না করেই রাখা হয়েছে |
| **আলাদা AJAX রাউট** | `routes/web.php` এবং `NinicoController.php`-এ `public.ajax.atelier-fitting` ও `public.ajax.atelier-newsletter` যোগ করা হয়েছে | পূর্বের `products`, `cart`, `search-products` AJAX রাউট সম্পূর্ণ অপরিবর্তিত আছে |

### একটি ইচ্ছাকৃত ডিজাইন সীমাবদ্ধতা (জেনে রাখা ভালো)
- `platform/themes/ninico/partials/headers/index.blade.php` এখন সবসময় `headers.default` (অর্থাৎ নতুন Deep Emerald হেডার) রেন্ডার করে। তাই অ্যাডমিন প্যানেলের `Theme Options` বা পেজ সেটিংস থেকে `Header Style` পরিবর্তন করে `collapsed` বা `centered-logo` দিলে সেটি আর কার্যকর হবে না।

---

## ৩. আপডেটের ক্ষেত্রে ফাইলগুলোর ঝুঁকি বিন্যাস

### ক. নতুন যোগ করা ফাইল (আপডেটে সরাসরি ওভাররাইট হয় না)

| ক্যাটাগরি | ফাইলের পথ |
| :--- | :--- |
| **Atelier শর্টকোডসমূহ** | `platform/themes/ninico/partials/shortcodes/atelier-hero/index.blade.php`<br>`platform/themes/ninico/partials/shortcodes/atelier-archive/index.blade.php`<br>`platform/themes/ninico/partials/shortcodes/atelier-craft/index.blade.php`<br>`platform/themes/ninico/partials/shortcodes/atelier-masterpieces/index.blade.php`<br>`platform/themes/ninico/partials/shortcodes/atelier-concierge/index.blade.php` |
| **মডাল ও বটম শিট** | `platform/themes/ninico/partials/atelier-fitting-modal.blade.php`<br>`platform/themes/ninico/partials/atelier-film-modal.blade.php`<br>`platform/themes/ninico/partials/atelier-quickview-sheet.blade.php` |
| **CSS ও JavaScript** | `platform/themes/ninico/public/css/atelier.css`, `public/themes/ninico/css/atelier.css`<br>`platform/themes/ninico/public/js/atelier.js`, `public/themes/ninico/js/atelier.js` |
| **ডাটাবেস মাইগ্রেশন** | `database/migrations/2026_11_26_194500_upgrade_atelier_emerald_homepage_and_theme.php` |

### খ. পরিবর্তন করা মূল `ninico` ফাইল (থিম/কোর আপডেটে মার্জ প্রয়োজন)

| ক্যাটাগরি | ফাইলের পথ | সতর্কতা |
| :--- | :--- | :--- |
| **লেআউট ও থিম ফাংশন** | `platform/themes/ninico/layouts/base.blade.php`<br>`platform/themes/ninico/config.php`<br>`platform/themes/ninico/functions/shortcodes.php`<br>`platform/themes/ninico/functions/theme-options.php` | থিমের নতুন ভার্সন সরাসরি পেস্ট করলে বা 1-Click Updater চালালে ওভাররাইট হবে |
| **হেডার, নেভ ও ফুটার** | `platform/themes/ninico/partials/headers/index.blade.php`<br>`platform/themes/ninico/partials/headers/default.blade.php`<br>`platform/themes/ninico/partials/navbar.blade.php`<br>`platform/themes/ninico/partials/footer.blade.php`<br>`platform/themes/ninico/partials/navigation-bar.blade.php`<br>`platform/themes/ninico/partials/whatsapp-concierge.blade.php` | আপডেটের সময় Git diff দেখে পরিবর্তনগুলো বজায় রাখতে হবে |
| **প্রোডাক্ট ভিউ ও রাউট** | `platform/themes/ninico/views/ecommerce/product.blade.php`<br>`platform/themes/ninico/routes/web.php`<br>`platform/themes/ninico/src/Http/Controllers/NinicoController.php` | নতুন আপডেটের সাথে ৩-ওয়ে মার্জ (`git merge`) করে নিতে হবে |

---

## ৪. কেন লাইভ অ্যাডমিন থেকে 1-Click Updater চালানো উচিত নয়?

`platform/core/base/src/Commands/UpdateCommand.php` এবং `platform/core/base/src/Supports/Core.php` অনুযায়ী Botble CMS-এর 1-Click System Updater-এর আচরণ:
1. এটি ডাউনলোড করা আপডেট ZIP সরাসরি প্রজেক্ট রুটে এক্সট্র্যাক্ট করে `./platform/core`, `./platform/packages`, `./platform/plugins` এবং `./platform/themes`-এর ফাইলগুলো ওভাররাইট করে।
2. আপনার `ninico` ফোল্ডার সরাসরি Git-এ কাস্টমাইজড অবস্থায় থাকায় লাইভ সার্ভারে 1-Click Updater চালালে কাস্টম হেডার, ফুটার, শর্টকোড ও রাউট মুছে যেতে পারে।
3. তাছাড়া Hostinger-এর `update.sh` স্ক্রিপ্ট প্রোডাকশনে আনকমিটেড পরিবর্তন থাকলে অটোমেটিক ডিপ্লয়মেন্ট বন্ধ করে দেয় (কোড হারানো ঠেকাতে)।

---

## ৫. ভবিষ্যৎ আপডেটের নিরাপদ নির্দেশিকা

1. **কখনোই লাইভ সার্ভার থেকে সরাসরি আপডেট বা ফাইল এডিট করবেন না:**
   `AGENTS.md` নিয়ম অনুযায়ী প্রোডাকশনে শুধু `git pull`/GitHub Actions (`deploy.yml` → `update.sh`) দিয়ে আপডেট যাবে।
2. **থিম বা Botble আপডেট নেওয়ার সঠিক ধাপ:**
   - লোকালে `main` থেকে নতুন ব্রাঞ্চ খুলুন (যেমন `chore/update-botble-cms` বা `chore/update-ninico`)।
   - নতুন ভার্সনের ফাইল আপডেট করার পর `git diff` দেখে আমাদের কাস্টম পরিবর্তনগুলো (`base.blade.php`, `shortcodes.php`, `NinicoController.php`, হেডার/ফুটার ইত্যাদি) রক্ষা করে মার্জ করুন।
   - লোকাল ব্রাউজার ও PHP/Laravel চেক যাচাই করে Pull Request-এর মাধ্যমে `main`-এ মার্জ করুন।
3. **ভুলবশত ক্লিক ঠেকাতে ঐচ্ছিক সুরক্ষা:**
   `platform/core/base/config/general.php`-এ `enable_system_updater` এনভায়রনমেন্ট ভ্যারিয়েবল দ্বারা নিয়ন্ত্রিত। চাইলে প্রোডাকশন `.env`-এ নিচের লাইনটি যোগ করে অ্যাডমিন 1-Click Updater নিষ্ক্রিয় রাখা যায়:
   ```env
   CMS_ENABLE_SYSTEM_UPDATER=false
   ```
4. **দীর্ঘমেয়াদী ঐচ্ছিক উন্নয়ন (Child Theme):**
   ভবিষ্যতে যদি নিয়মিত অফিশিয়াল `ninico` থিম আপডেট নেওয়ার প্রয়োজন হয়, তবে কাস্টম ফাইলগুলো একটি Child Theme (`inherit` কনফিগ ব্যবহার করে) বা আলাদা থিম নামে সরিয়ে নেওয়া যাবে—তাহলে মূল `ninico` ফোল্ডারে কোনো কাস্টম এডিট থাকবে না।

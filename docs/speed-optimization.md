# Western Bespoke — লাইভ ওয়েবসাইট স্পিড অপটিমাইজেশন গাইড

এই ডকুমেন্টে **Western Bespoke** (Botble CMS / Laravel 12) ওয়েবসাইটের অ্যাডমিন প্যানেল থেকে স্পিড ও ক্যাশিং অপটিমাইজ করার সব অপশন, মেনু পাথ এবং ব্যবহারবিধি সংক্ষেপে দেওয়া হয়েছে।

---

## ১. মূল পেজ স্পিড অপটিমাইজেশন (`Optimize`)

- **অ্যাডমিন মেনু:** `Settings` → `Common` → `Optimize`
- **লাইভ URL:** `https://westernbespoke.com/admin/settings/optimize`
- **লোকাল URL:** `http://127.0.0.1:8000/admin/settings/optimize`

প্রথমে **`Enable optimize page speed?`** (`optimize_page_speed_enable`) অপশনটি চালু করলে নিচের ৭টি ফিল্টার সক্রিয় করা যাবে:

| অপশন (UI Label) | সেটিং কী (`settings`) | কাজ | প্রস্তাবিত ব্যবহার |
| :--- | :--- | :--- | :--- |
| **Collapse white space** | `optimize_collapse_white_space` | HTML আউটপুট থেকে অপ্রয়োজনীয় স্পেস ও ফাঁকা লাইন বাদ দিয়ে পেজ সাইজ কমায় | নিরাপদ — প্রথমেই চালু করুন |
| **Insert DNS prefetch** | `optimize_insert_dns_prefetch` | `<head>`-এ DNS prefetch ট্যাগ যোগ করে এক্সটার্নাল রিসোর্স দ্রুত রিজলভ করে | নিরাপদ — প্রথমেই চালু করুন |
| **Remove comments** | `optimize_remove_comments` | HTML, JS ও CSS কমেন্ট বাদ দিয়ে পেজ লোড সাইজ কমায় | নিরাপদ — প্রথমেই চালু করুন |
| **Elide attributes** | `optimize_elide_attributes` | যেসব HTML অ্যাট্রিবিউটের মান ডিফল্ট, সেগুলো বাদ দেয় | চালু করে সাইট চেক করুন |
| **Remove quotes** | `optimize_remove_quotes` | HTML অ্যাট্রিবিউটের অপ্রয়োজনীয় কোটেশন বাদ দেয় | চালু করে সাইট চেক করুন |
| **Inline CSS** | `optimize_inline_css` | ইনলাইন `style` অ্যাট্রিবিউটগুলোকে `<head>`-এ CSS ক্লাস হিসেবে নিয়ে যায় | লেআউট ঠিক আছে কি না দেখে চালু করুন |
| **Defer javascript** | `optimize_defer_javascript` | `<script src="...">` ট্যাগে `defer` যোগ করে রেন্ডারিং দ্রুত করে | চালু করার পর স্লাইডার, কার্ট, মেনু ও ফর্ম ভালোভাবে টেস্ট করুন |

> **টিপস:** `Defer javascript` চালু করলে কোনো নির্দিষ্ট `<script>`-এ সমস্যা হলে ওই স্ক্রিপ্ট ট্যাগে `data-pagespeed-no-defer` অ্যাট্রিবিউট যোগ করে সেটি এক্সক্লুড করা যায়।

---

## ২. সার্ভার ও কন্টেন্ট ক্যাশিং (`Cache`)

- **অ্যাডমিন মেনু:** `Settings` → `Common` → `Cache`
- **লাইভ URL:** `https://westernbespoke.com/admin/settings/cache`
- **লোকাল URL:** `http://127.0.0.1:8000/admin/settings/cache`

| অপশন (UI Label) | সেটিং কী (`settings`) | ডিফল্ট অবস্থা | বিবরণ ও পরামর্শ |
| :--- | :--- | :--- | :--- |
| **Cache front menu** | `cache_front_menu_enabled` | চালু (`true`) | ফ্রন্টএন্ড নেভিগেশন মেনু ক্যাশ করে |
| **Cache user avatar** | `cache_user_avatar_enabled` | চালু (`true`) | ইউজারের ডিফল্ট অ্যাভাটার ক্যাশ করে |
| **Cache installed plugins** | `plugin_cache_enabled` | চালু (`true`) | ইনস্টল করা প্লাগিনের তালিকা ৩০ মিনিটের জন্য ক্যাশ করে |
| **Cache sitemap** | `enable_cache_site_map` | চালু (`true`) | সাইটম্যাপ ক্যাশ করে (ডিফল্ট মেয়াদ `60` মিনিট) |
| **Cache shortcodes (UI blocks)** | `shortcode_cache_enabled` | বন্ধ (`false`) | হোমপেজ ও পেজের UI শর্টকোড ব্লক ক্যাশ করে (ডিফল্ট `1800` সেকেন্ড)। লাইভ সাইটে চালু করলে রেন্ডারিং দ্রুত হয় |
| **Cache widgets** | `widget_cache_enabled` | বন্ধ (`false`) | ফুটার ও সাইডবার উইজেট ক্যাশ করে (ডিফল্ট `1800` সেকেন্ড) |
| **Cache admin menu** | `cache_admin_menu_enable` | বন্ধ (`false`) | অ্যাডমিন মেনু ক্যাশ করে; নতুন প্লাগিন/মেনু কাস্টমাইজ না করলে লাইভে চালু রাখা যায় |

> **গুরুত্বপূর্ণ:** ফর্ম (যেমন Contact Form, Newsletter বা CSRF টোকেনযুক্ত এলিমেন্ট) স্বয়ংক্রিয়ভাবে শর্টকোড/উইজেট ক্যাশের বাইরে থাকে। কোনো ডায়নামিক JS শর্টকোড বা উইজেটে ক্যাশ বন্ধ রাখতে চাইলে সেটির কনফিগারেশনে `Enable caching: No` সেট করুন।

---

## ৩. মিডিয়া ও ইমেজ অপটিমাইজেশন (`Media`)

- **অ্যাডমিন মেনু:** `Settings` → `Common` → `Media`
- **লাইভ URL:** `https://westernbespoke.com/admin/settings/media`
- **লোকাল URL:** `http://127.0.0.1:8000/admin/settings/media`

নতুন প্রোডাক্ট বা ব্যানার ছবি আপলোডের সময় সাইজ কমাতে নিচের অপশনগুলো ব্যবহার করতে পারেন:

1. **Convert JPG, JPEG, PNG image to WebP:** নতুন আপলোড হওয়া JPG/JPEG/PNG ছবিগুলোকে হালকা **WebP** ফরম্যাটে রূপান্তর করে।
2. **Reduce large image size when uploading:** খুব বড় ছবি আপলোড হলে নির্ধারিত **`Image max width (px)`** ও **`Image max height (px)`** অনুযায়ী রিসাইজ করে।
3. **Enable thumbnail sizes:** বিভিন্ন সাইজের থাম্বনেইল তৈরি করে যাতে ছোট কার্ডে অপ্রয়োজনে ফুল-সাইজ ছবি লোড না হয়।
4. **CDN / Cloud Storage:** প্রয়োজনে এই একই পেজে BunnyCDN বা S3 কনফিগার করা যায়।

---

## ৪. ক্যাশ ম্যানেজমেন্ট (`Cache Management`)

- **অ্যাডমিন মেনু:** `Platform Administration` → `Cache Management`
- **লাইভ URL:** `https://westernbespoke.com/admin/system/cache`
- **লোকাল URL:** `http://127.0.0.1:8000/admin/system/cache`

স্পিড বা ক্যাশ সেটিংস পরিবর্তন করার পর সাইটে কোনো আপডেট সাথে সাথে না দেখালে এখান থেকে ক্যাশ ক্লিয়ার করুন।

---

## ৫. সার্ভার ও ডিপ্লয়মেন্ট লেভেল অপটিমাইজেশন

- **Laravel Production Caches:** প্রতি ডিপ্লয়ের সময় `update.sh` স্বয়ংক্রিয়ভাবে `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache` রান করে এবং `.lsphp_restart.txt` দিয়ে LiteSpeed PHP ওয়ার্কার রিলোড করে।
- **Hostinger LiteSpeed Cache:** Hostinger hPanel থেকে সাইটের জন্য **LiteSpeed Cache** চালু রাখলে সার্ভার-লেভেল পেজ ক্যাশিংয়ের মাধ্যমে TTFB আরও কমে।

---

## ৬. সংশ্লিষ্ট সোর্স ফাইল (রেফারেন্স)

- `platform/packages/optimize/src/Providers/OptimizeServiceProvider.php`
- `platform/packages/optimize/src/Forms/Settings/OptimizeSettingForm.php`
- `platform/packages/optimize/resources/views/partials/settings/forms/optimize-fields.blade.php`
- `platform/core/setting/src/PanelSections/SettingCommonPanelSection.php`
- `platform/core/setting/src/Forms/CacheSettingForm.php`
- `update.sh`

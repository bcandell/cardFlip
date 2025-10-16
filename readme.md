# 🧩 Course Catalog Block for WordPress

[![WordPress](https://img.shields.io/badge/WordPress-6.6%2B-blue?logo=wordpress)](https://wordpress.org/)
[![License: MIT](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-8892BF?logo=php)](https://www.php.net/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC?logo=tailwind-css)](https://tailwindcss.com/)

> A lightweight, server-rendered **ACF + Tailwind-powered Course Catalog block** for WordPress.  
> Built for clarity, performance, and accessibility — no AJAX, no frameworks, just clean PHP, HTML, and CSS.

---

## ✨ Features

✅ Server-side rendering with `WP_Query`  
✅ ACF-driven content structure (Summary, Details, Custom Link, Custom Taxonomies)  
✅ Fully escaped output and safe inline colors (`sanitize_hex_color()`)  
✅ Semantic, accessible markup (`role="list"`/`listitem`)  
✅ Optional JS flip/tabs interactivity (no dependencies)  
✅ Tailwind-friendly class structure or plain CSS styling  
✅ SEO-friendly and cacheable (no client-side fetching)

---

## 📂 Project Structure

course-catalog-block/
│
├── catalog.php      # Server-side rendering (core logic)
├── catalog.css      # Styles (plain or Tailwind)
├── catalog.js       # Optional interactivity (flip/tabs)
├── README.md        # You're reading it
└── .gitignore       # Git hygiene

---

## 🧱 Installation

1️⃣ Add files to your theme or plugin  
Place the folder inside your active theme or block directory:  
/wp-content/themes/your-theme/blocks/course-catalog/

2️⃣ Enqueue the assets  
Add this to your theme’s functions.php:

function enqueue_catalog_assets() {
    $dir = get_stylesheet_directory_uri() . '/blocks/course-catalog/';
    wp_enqueue_style( 'catalog', $dir . 'catalog.css', [], '1.0' );
    wp_enqueue_script( 'catalog', $dir . 'catalog.js', [], '1.1', true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_catalog_assets' );

3️⃣ Render the block  
get_template_part( 'blocks/course-catalog/catalog' );

---

## 🧩 ACF Field Structure

summary_text – WYSIWYG / Textarea – Short description  
additional_details – WYSIWYG – Extended info  
custom_link – Link – Link field with url + title  
custom_taxonomies – Repeater – Top-level taxonomy group  

taxonomy_text – Text – Taxonomy name  
terms – Repeater – List of term items  
term_name – Text – Term label  
term_tile_color – Color Picker – Tile background  
sub_terms – Repeater – Nested tags  
sub_term_name – Text – Sub-term label  
sub_term_tile_color – Color Picker – Tile background

---

## 🧠 Example Output

<section class="course-catalog flipBox" data-flip-container>
  <div class="course-grid" role="list">
    <article class="course-card" role="listitem">
      <h2>Algebra I</h2>
      <div class="summary-text">Intro to algebraic principles.</div>
      <div class="acf-taxonomy-tags">
        <span class="term-tag" style="background:#4671a5;">Math</span>
        <div class="sub-term-tags">
          <span class="sub-term-tag" style="background:#eee;">Grade 9</span>
        </div>
      </div>
      <p><a class="custom-link" href="#" target="_blank" rel="noopener noreferrer">Learn More</a></p>
    </article>
  </div>
</section>

---

## 🎨 Optional JavaScript (Flip / Tabs)

If you use catalog.js, include:

<section class="flipBox" data-flip-container>
  <button class="flipToggle" aria-pressed="false">Flip View</button>
  <button data-target="codeHTML">HTML</button>
  <button data-target="codeCSS">CSS</button>
</section>

---

## 🛡️ Security & Performance

- Uses WordPress native escaping: esc_html, esc_url, wp_kses_post, and sanitize_hex_color.  
- SEO-friendly: content rendered server-side.  
- No external libraries or page builders.  
- Optional pagination if the number of courses grows large.

---

## 📸 Screenshots

| Desktop | Mobile |
|----------|---------|
| ![Desktop Screenshot](docs/screenshot-desktop.png) | ![Mobile Screenshot](docs/screenshot-mobile.png) |

---

## 🧰 Development

git clone https://github.com/YOURUSERNAME/course-catalog-block.git  
cd course-catalog-block

git add .  
git commit -m "Initial commit: Course Catalog Block"  
git push origin main

---

## 🧾 .gitignore

node_modules/  
dist/  
*.map  
.DS_Store  
Thumbs.db  
*.log  
.idea/  
.vscode/  
wp-content/uploads/

---

## 🧠 Recommended Topics

wordpress, acf, tailwindcss, php, custom-block, frontend, block-theme, genesis, accessibility

---

## 📜 License

MIT © Brady Candell  
https://bradycandell.com

---

## 💬 Credits

Developed by Brady Candell  
WordPress Architect / Designer
https://bradycandell.com

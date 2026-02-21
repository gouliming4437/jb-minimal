# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What This Is

A classic PHP WordPress theme (not block/FSE) called **JB Minimal** — a minimal personal blog theme inspired by joshbradley.me. Zero build tools; all files are edit-and-deploy.

## Installing / Testing

Copy the entire directory into a WordPress installation's `wp-content/themes/jb-minimal/` and activate via Appearance → Themes. To package for upload:

```bash
zip -r jb-minimal.zip . --exclude "*.git*" --exclude "docs/*" --exclude "*.DS_Store"
```

There is no build step, test suite, or linter. Verification is done by loading the theme in a WordPress instance.

## Architecture

All theme logic lives in two files:

- **`style.css`** — Required WordPress theme metadata comment header + all styles (~480 lines). This single file contains every CSS rule; there are no partials or imports.
- **`functions.php`** — Everything else: theme setup hooks, style enqueue, WordPress Customizer registration, CSS variable output, helper functions (`jb_minimal_social_links()`, `jb_minimal_fallback_menu()`), the `[jb_archives]` shortcode, archive title filter, and nav class filter.

Template files follow the standard WordPress template hierarchy with no custom page templates or template parts.

## CSS Design System

Colors are CSS custom properties set as defaults in `style.css` and overridden at runtime by `jb_minimal_customizer_css()` (hooked to `wp_head`):

| Variable | Default | Usage |
|---|---|---|
| `--jb-text` | `#262626` | Body text, links |
| `--jb-heading` | `#171717` | Headings, active nav, borders on hover |
| `--jb-border` | `#e5e5e5` | Dividers, content left border, table borders |
| `--jb-link-hover` | `#000000` | Link hover state |
| `--jb-bg` | `#ffffff` | Page background |

Always use these variables (not hardcoded colors) for any new styles, so Customizer theming works.

## Customizer Settings (functions.php)

Settings are registered under `customize_register` and read via `get_theme_mod()`:

| `get_theme_mod()` key | Section | Default |
|---|---|---|
| `jb_text_color`, `jb_heading_color`, `jb_border_color` | Colors | Hex values |
| `jb_social_1_label` … `jb_social_5_label` | Social Links | `''` |
| `jb_social_1_url` … `jb_social_5_url` | Social Links | `''` |
| `jb_bio_text`, `jb_show_social_home` | Homepage | `''` / `true` |
| `jb_show_dates`, `jb_show_comments` | Blog | `true` |

## Key Patterns

- **Active nav highlighting**: Dual-layer — WordPress CSS classes (`.current-menu-item`, `.current_page_item`, etc.) handled in CSS + a small inline JS snippet in `header.php` that sets `aria-current="page"` for client-side accuracy.
- **Footnote heading**: `single.php` injects a `<h2>Reference</h2>` before footnote sections via inline JS targeting `.wp-block-footnotes`, `.footnotes`, or `[role="doc-endnotes"]`.
- **Archive shortcode**: `[jb_archives]` in `functions.php` groups posts by year. Supports `limit`, `category` (slug), and `year` attributes.
- **Style versioning**: `functions.php` uses `filemtime()` on `style.css` as the cache-bust version instead of the theme version string.
- **`front-page.php` branching**: When WordPress is configured to show a static front page, it renders that page's content; otherwise it renders the bio/social homepage layout.

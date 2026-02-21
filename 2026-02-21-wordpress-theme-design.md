# JB Minimal — WordPress Theme Design

## Overview

A classic PHP WordPress theme replicating the minimal design of joshbradley.me. General-purpose blog theme with WordPress Customizer integration for admin-friendliness. Vanilla CSS, zero build tools.

## Decisions

- **Theme type:** Classic PHP (not block/FSE)
- **Content type:** General-purpose blog (flexible sections via pages/categories)
- **Customization:** WordPress Customizer (colors, social links, bio, blog settings)
- **CSS approach:** Vanilla CSS (~300 lines), no build tools, no frameworks
- **Typography:** System font stack, no web fonts

## File Structure

```
jb-minimal/
├── style.css              # Theme metadata + all styles
├── functions.php          # Theme setup, Customizer, enqueues, shortcodes
├── header.php             # <html>, <head>, nav sidebar
├── footer.php             # Social links, closing tags
├── index.php              # Blog post listing (default)
├── single.php             # Single post view (with footnote "Reference" heading)
├── page.php               # Static page view
├── front-page.php         # Homepage (About page)
├── archive.php            # Category/tag/date archives (no title for categories/tags)
├── search.php             # Search results
├── 404.php                # Not found page
├── comments.php           # Comment template
├── README.md              # Theme documentation
└── screenshot.png         # Theme preview in admin
```

## Visual Design Spec

### Layout

- Two-column flex layout on desktop: thin left sidebar (nav) + content area
- Single-column stacked layout on mobile
- Content max-width: 672px (matches `max-w-2xl`)
- Left border accent on desktop separating nav from content

### Color Palette (Customizer-editable)

| Token       | Value     | Usage              |
|-------------|-----------|--------------------|
| text        | `#262626` | Body text           |
| heading     | `#171717` | Headings            |
| border      | `#e5e5e5` | Dividers, accents   |
| link-hover  | `#000000` | Link hover state    |
| background  | `#ffffff` | Page background     |

### Typography

- Font: system font stack (`-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif`)
- Base size: 14px
- Text alignment: justified with `hyphens: auto`
- Rendering: antialiased

### Navigation

- Desktop: vertical sidebar on the left with plain text links
- Mobile: horizontal bar at top
- Active page highlighted with darker color
- Smooth hover transitions

### Social Links (Customizer-editable)

- Small text at bottom of content area
- Fields: Twitter/X URL, GitHub URL, LinkedIn URL, RSS toggle

## Page Templates

### Homepage (`front-page.php`)

- Site title as `<h1>` with medium weight
- Bio/description paragraph (editable via Customizer)
- Horizontal rule divider
- Social links at bottom

### Blog Listing (`index.php`)

- Posts listed vertically
- Each entry: title + date, connected by a subtle top-border line
- Border darkens on hover
- Pagination at bottom

### Single Post (`single.php`)

- Post title as `<h1>`
- Date below title
- Post content with WordPress block support
- Automatic "Reference" heading injected before footnote sections (via client-side JS)
- Comments section (toggleable via Customizer)

### Static Page (`page.php`)

- Page title as `<h1>`
- Page content, clean and minimal

### Archive (`archive.php`)

- Category/tag archives: no title heading, just the post list (and description if set)
- Category descriptions styled in muted grey (`#a3a3a3`), matching inactive nav items
- Other archives (date, author): archive title displayed as heading
- Same post listing style as blog index

### Search (`search.php`)

- Search query displayed as heading
- Results in same listing style as blog index

### 404 (`404.php`)

- Simple "Page not found" message with link to homepage

## Content Element Styles

All Gutenberg block output styled for consistency:

| Element        | Styling                                              |
|----------------|------------------------------------------------------|
| Images         | Responsive (max-width: 100%), all alignment classes, captions in small neutral text |
| Tables         | Bordered (neutral-200), padded, mobile horizontal scroll, subtle alternating rows |
| Blockquotes    | Left border accent (neutral-900), serif italic font, footer attribution |
| Code blocks    | Monospace, subtle gray background, horizontal scroll |
| Lists          | Clean bullet/number styles, proper indentation       |
| Headings h2-h6 | Scaled sizes, medium weight, neutral-900             |
| Horizontal rules | Thin neutral-200 line with vertical margin         |
| Galleries      | CSS grid layout, responsive columns                  |

## Customizer Settings

| Section          | Settings                                            |
|------------------|-----------------------------------------------------|
| Site Identity    | Site title, tagline (bio text), logo (optional)     |
| Colors           | Text color, heading color, accent/border color, background |
| Social Links     | Twitter URL, GitHub URL, LinkedIn URL, RSS toggle   |
| Homepage         | Bio text (textarea), show/hide social links         |
| Blog             | Posts per page, show/hide dates, show/hide comments |

## Responsive Breakpoints

| Breakpoint    | Behavior                                           |
|---------------|----------------------------------------------------|
| < 640px       | Single column, nav as horizontal top bar, tight padding (16px) |
| 640px–767px   | Two-column layout begins, left border appears, padding 24px |
| 768px+        | Full desktop padding (48px left on content)        |

## Additional Features

### Archive Shortcode (`[jb_archives]`)

- Groups posts by year with `<h2>` year headings
- Each post shows title + full date (M j, Y)
- Supports attributes: `limit`, `category` (slug), `year`
- Clean archive title filter removes "Category:", "Tag:", "Author:" prefixes

### Footnotes

- Posts using `[^1]` footnote syntax get an automatic "Reference" heading before the footnotes section
- Detected via JS targeting `.wp-block-footnotes`, `.footnotes`, or `[role="doc-endnotes"]`

# JB Minimal

A minimal, clean WordPress theme inspired by [joshbradley.me](https://joshbradley.me).

## Features

- Minimal sidebar navigation with active page highlighting
- Customizer support for colors, social links, and layout settings
- Archive shortcode `[jb_archives]` with year grouping, category filtering, and post limits
- Categories as nav menu — clean display without "Category:" prefix
- Automatic "Reference" heading before footnote sections
- Responsive layout (sidebar collapses on mobile)
- Sidebar search
- Clean typography with system fonts

## Installation

1. Download or build `jb-minimal.zip`
2. In WordPress, go to **Appearance → Themes → Add New → Upload Theme**
3. Upload the zip file and activate

## Shortcode Usage

```
[jb_archives]                    — all posts grouped by year
[jb_archives limit="50"]         — limit total posts
[jb_archives category="news"]    — filter by category slug
[jb_archives year="2026"]        — single year only
```

## Customizer Options

- **Colors**: Text, heading, and border colors
- **Social Links**: Twitter/X, GitHub, LinkedIn, RSS
- **Homepage**: Bio text, social links toggle
- **Blog**: Show/hide post dates and comments

## Requirements

- WordPress 6.0+
- PHP 7.4+

## License

GPL v2 or later

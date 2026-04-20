# Changelog

All notable changes to this theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.3.0] - 2026-04-17

Rebrand from "Public Safety 2026" to "Seiler 2026" and restructure the theme
into `src/`. Genericize division-specific prose, add a WooCommerce My Account
FSE template, and do a broad mobile/tablet responsive overhaul.

### Changed

- **Theme identifier renamed** `public-safety-2026` → `seiler-2026` throughout:
  package name, slugs, text-domain, function prefixes, PHP namespace
  (`SeilerInstrument\Themes\Seiler2026`), pattern categories, block names.
- **Directory layout:** theme moved from repo root into `src/` to align with
  `@wordpress/scripts` conventions.
- **Content genericized** so the theme is division-agnostic — hero, features,
  CTA, testimonials, service-grid, feature-cards, contact-section, and
  partner-logos patterns no longer reference a specific industry vertical.

### Added

- **WooCommerce My Account FSE template** (`src/templates/page-my-account.html`)
  with scoped styling for navigation + content layout, active-state + hover
  styling, and a special column layout for the logged-out login view.
- **Mobile/tablet responsive styles** across nav overlay, search overlay,
  slider, footer, CTA banner, features pattern, and industry cards.
- **Submenu prefix** (`"> "`) in the mobile nav overlay to indicate nesting.
- **CSS section for WooCommerce My Account** under `.woocommerce-account`.
- **`render_block_core/post-excerpt` filter** that suppresses empty
  `<p class="wp-block-post-excerpt__excerpt"> </p>` output, working around
  a known Gutenberg regression
  ([#30571](https://github.com/WordPress/gutenberg/issues/30571)).

### Fixed

- **Webpack build recursion** (`src/build/build/build/…`) caused by wp-scripts
  auto-discovering its own output as block entries. Scope entry discovery via
  `WP_SRC_DIRECTORY` and pin `output.path` explicitly.
- **Duplicate `theme.css` enqueue** on the frontend — the canvas-only enqueue
  was leaking onto the public site.
- **Hardcoded skip-link** removed from the header template; WP core now
  injects its own via `the_block_template_skip_link()`.
- **Mobile nav overlay** rendering: items stack vertically with proper hover
  styling, submenus expand inline instead of floating as desktop dropdowns,
  focus outlines now respect `:focus-visible` so pointer taps don't leave
  lingering outlines, submenu background-hover animation suppressed.
- **Mobile/tablet search overlay** full-width up to 960px (was a centered
  floating panel at tablet widths).
- **Slider arrows** disabled at the block level with CSS fallback — touch
  devices use pagination dots only.
- **Footer** stacks at ≤980px with the since-group hidden, inline nav-link
  styles moved to CSS with clamped font-size, `txt-sep` separators convert
  to line breaks at ≤450px.
- **Page-header-sub** hides entirely when excerpt block is absent; reduced
  padding when excerpt element is present but empty.
- **Hero slider typography** restored to FSE-editable inline setting; mobile
  sizing handled by WordPress fluid typography.
- **Block validation errors** resolved in `hero-slider` pattern and `home`
  template (missing `"arrows": false` and `"level": 1` attributes).

## [0.2.x] and earlier

See git history — versions prior to this changelog's introduction.

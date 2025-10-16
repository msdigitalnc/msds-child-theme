# MSDS Divi Child Theme

## [1.1.1] - 2025-10-16
### Added
- No Header/Footer Page Template (`page-no-header-footer.php`) for clean landing and splash pages.
- Conditional Google Fonts Logic (commented, ready for activation) with transient caching and local font detection.
- Optional Font Upload Support (commented, for .ttf, .otf, .woff, .woff2).

### Changed
- Modernized Full Width Page Template (`page-fullwidth.php`):
  - Replaced deprecated thumbnail logic with `has_post_thumbnail()` and `the_post_thumbnail()`.
  - Simplified layout to match modern Divi standards.
  - Cleaned redundant container markup and applied consistent WordPress coding standards.
- functions.php:
  - Consolidated and documented Divi-specific enhancements.
  - Removed obsolete process comments for production clarity.

### Structure
```
/msds-divi-child/
├── functions.php
├── style.css
├── page-fullwidth.php
├── page-no-header-footer.php
├── readme.txt
├── screenshot.png
│
├── /assets/
│   ├── /css/
│   └── /js/
│
└── /fonts/
```

### Notes
- 404 and Search templates should be handled via the Divi Theme Builder.
- Include custom JS or CSS in `/assets/` when extending functionality.
- Local fonts placed in `/fonts/` can trigger automatic Google Font disabling.
- Versioned for clean deployment and Git tracking.

## [1.0.4] - Initial Release
- Established modern enqueue system with cache-busting.
- Added HTML5 theme supports and comment system deactivation.
- Included base Full Width Page template.

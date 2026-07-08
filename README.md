# LSU Purple — moodle-theme_lsupurple

LSU Purple is a Boost child theme for Moodle built by and for Louisiana State University. It restyles Moodle in LSU purple and gold, replaces the default course page with card based sections and clean activity rows, adds an accessible per user dark mode, forces custom menu items into the primary navigation's More menu, and loads the Source Sans 3 typeface site wide.

- **Component:** 'theme_lsupurple'
- **Parent theme:** 'theme_boost'
- **Requires:** Moodle 4.5 (2024100700) or later
- **License:** GNU GPL v3 or later
- **Copyright:** 2026 onwards Louisiana State University, Robert Russo

## Installation

### Via the web interface

1. Download the theme as a zip.
1. Log in as an administrator and go to *Site administration -> Plugins -> Install plugins*.
1. Upload the zip and follow the prompts to complete the install.
1. Go to *Site administration -> Appearance -> Themes* and select **LSU Purple**.

### Via the command line

1. Copy the theme into your Moodle directory so it lives at '/theme/lsupurple'. The folder name must be exactly 'lsupurple'.
1. Run the upgrade: 'php admin/cli/upgrade.php'.
1. Purge caches: 'php admin/cli/purge_caches.php'.
1. Select the theme under *Site administration -> Appearance -> Themes*.

After any update to the theme, purge all caches (*Site administration -> Development -> Purge caches*) so the compiled SCSS and the class autoloader refresh.

## Theme settings

Settings live at *Site administration -> Appearance -> Themes -> LSU Purple*, split across two tabs.

### General tab

| Setting | Default | What it does |
| --- | --- | --- |
| Unneeded blocks | 'navigation,settings,course_list,section_links' | Blocks hidden from the "Add a block" menu, same behavior as Boost. |
| Background image | none | Site wide background image, applied at 768px and wider. Overrides any preset background. |
| Login page background image | none | Background image for the login page only. |
| Brand color | '#3a1867' (LSU purple) | The primary color. Feeds Bootstrap's '$primary', link colors, and the theme's derived purple shades (a 9% and a 16% darkened variant are computed automatically). |
| Accent color | '#FDD023' (LSU gold) | The accent used for keylines, markers, the active edit toggle, and highlights. A darkened variant is computed automatically. |

### Advanced tab

| Setting | What it does |
| --- | --- |
| Raw initial SCSS | Injected before everything else compiles. Use it to override the design token variables listed below. |
| Raw SCSS | Appended after all theme styles, including dark mode. The final word in the cascade. |

## The More menu and custom menu items

Anything defined in *Site administration -> Appearance -> Advanced theme settings -> Custom menu items* ('$CFG->custommenuitems') appears **exclusively in the More dropdown** of the primary navigation, on every screen width. The standard items (Home, Dashboard, My courses, Site administration) stay in the navbar and still collapse responsively as usual.

How it works: 'classes/output/primary.php' extends '\core\navigation\output\primary' and flags every custom menu node (and its children) with 'forceintomoremenu' during the merge. Core's 'moremenu.js' then moves those nodes into the More dropdown unconditionally, the same mechanism secondary navigation uses. The mobile navigation drawer is untouched, so on phones the custom items still appear in the full vertical list.

## Design and layout

All styling compiles through SCSS on top of the Boost default preset. There are no flat stylesheets.

- **Full width layout.** The centered 'limitedwidth' column from Boost is removed. Content, course pages, and the header span the full viewport.
- **Header.** Purple gradient navbar with a gold keyline beneath it.
- **Course pages.** One card per course section, with activities rendered as full width rows inside the card.
- **Edit mode toggle.** Turns gold when editing is on, so editing state is unmistakable.
- **Secondary navigation.** Gold underline marks the active tab.
- **Blocks, drawers, and the course index.** Card styling with the theme's shadow scale, tinted purple hover states.
- **Buttons, forms, tables.** Branded controls; tables get a purple header with a gold rule beneath it.
- **Gradebook.** Purple tinted hover rows and readable headers.
- **User menu.** Restyled for readability and larger click targets.
- **Login page.** Quiet purple gradient backdrop with a gold tipped login card.
- **Footer and modals.** Matched to the palette.
- **Typography.** Source Sans 3 everywhere, with a system font stack fallback. The font is loaded as '<link>' tags in the page head (via the 'before_standard_head_html_generation' hook) rather than through SCSS, which keeps stylesheet compilation safe and lets browsers preconnect to Google Fonts. Note this means pages request 'fonts.googleapis.com' and 'fonts.gstatic.com'.
- **Activity icons.** Bundled 'monologo.svg' replacements under 'pix_plugins/mod/' restyle the icons for these third party modules so they match core's monochrome icon system: adaptivequiz, certificate, facetoface, hvp, library, livepoll, questionnaire, quizgame, turningptintegration.

### Design tokens

'scss/pre.scss' defines the token variables the rest of the theme consumes. Override any of them from the *Raw initial SCSS* setting. Highlights:

- Brand: '$brand-primary', '$brand-primary-dark', '$brand-primary-deep', '$brand-gold', '$brand-gold-dark'
- Ink scale: '$ink-heading', '$ink-body', '$ink-muted'
- Surfaces and lines: '$surface', '$surface-tint', '$line-soft', '$line-strong'
- Shadows: '$shadow-rest', '$shadow-raise', '$shadow-float'
- Radii: '$radius-card' (14px), '$radius-item' (10px), '$radius-control' (8px)
- Dark palette: '$dark-bg', '$dark-surface', '$dark-raised', '$dark-text', '$dark-link', and friends

## Dark mode

Dark mode is opt in, per user, and driven by a custom profile field.

### Setup

1. Go to *Site administration -> Users -> User profile fields*.
1. Create a field (checkbox recommended) with the short name **'darkmode'**.
1. Users toggle it in their profile. Values of '1', 'true', or 'yes' opt in.

When the field is set, 'lib.php' adds the 'lsudark' class to the body on every page and 'scss/dark.scss' takes over.

### What dark mode covers

The dark stylesheet compiles after everything else so its rules win the cascade. It restyles global surfaces, the header, drawers and the course index, cards and blocks, course layout, buttons, tabs, pagination, breadcrumbs, forms, tables, alerts, badges, dropdowns, modals, popovers, toasts, the messaging drawer, activity modules (forum, quiz, assignment, glossary, book), the gradebook, the calendar, editor chrome, the login page, and user generated content pasted in with hard coded inline colors.

Every text and background pairing in the dark palette is verified against **WCAG 2.x AAA** (7:1 normal text, 4.5:1 large text), and the verified contrast ratios are documented inline in 'scss/dark.scss'. If you change a palette value, re-check the ratios before shipping.

## How the theme overrides Boost

For maintainers, this is the complete list of what the theme touches.

| File | Purpose |
| --- | --- |
| 'config.php' | Declares the child theme. Parent 'boost', no flat stylesheets, SCSS callbacks, overridden renderer factory, edit switch, course index, FontAwesome icons. |
| 'lib.php' | SCSS assembly ('pre.scss' -> Boost default preset -> 'post.scss' -> 'dark.scss' -> raw SCSS settings), settings file serving for logo and background images, page init that adds the 'lsudark' body class, and the dark mode profile field reader. |
| 'layout/drawers.php' | A mirror of Boost's drawers layout with one change: it builds the primary navigation from this theme's 'primary' class so custom menu items are forced into the More menu. **When upgrading Moodle, diff this file against 'theme/boost/layout/drawers.php'.** All other layouts (login, embedded, secure, and so on) are inherited from Boost untouched. |
| 'classes/output/primary.php' | Extends core's primary navigation output to flag custom menu nodes with 'forceintomoremenu'. |
| 'classes/hook_callbacks.php' + 'db/hooks.php' | Registers the 'before_standard_head_html_generation' hook that injects the Source Sans 3 font links, only when this theme is active. |
| 'settings.php' | The two tab settings page described above. |
| 'scss/pre.scss' | Design tokens and the Bootstrap bridge, injected before Bootstrap compiles. |
| 'scss/post.scss' | All visual overrides, appended after the parent styles. |
| 'scss/dark.scss' | The AAA verified dark mode, compiled last. Deliberately avoids SCSS color functions, lists, and loops so it compiles on every scssphp version Moodle ships. |
| 'pix_plugins/mod/*/monologo.svg' | Replacement activity icons for the third party modules listed above. |
| 'lang/en/theme_lsupurple.php' | English language strings. |

SCSS compile order: 'pre.scss' -> admin brand and accent color settings -> raw initial SCSS setting -> Boost default preset -> 'post.scss' -> 'dark.scss' -> background image rules -> raw SCSS setting. Later always wins.

## Privacy

The theme does not store any personal data. Dark mode preference is read from a standard user profile field managed by Moodle core.

## Support

This theme is provided as is under the GPL. Report issues through the repository's issue tracker. When reporting, include your Moodle version, the theme version from 'version.php', and a screenshot where relevant.

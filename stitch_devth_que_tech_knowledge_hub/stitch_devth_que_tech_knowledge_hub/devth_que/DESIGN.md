---
name: DevThèque
colors:
  surface: '#faf8ff'
  surface-dim: '#d9d9e5'
  surface-bright: '#faf8ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f3f3fe'
  surface-container: '#ededf9'
  surface-container-high: '#e7e7f3'
  surface-container-highest: '#e1e2ed'
  on-surface: '#191b23'
  on-surface-variant: '#434655'
  inverse-surface: '#2e3039'
  inverse-on-surface: '#f0f0fb'
  outline: '#737686'
  outline-variant: '#c3c6d7'
  surface-tint: '#0053db'
  primary: '#004ac6'
  on-primary: '#ffffff'
  primary-container: '#2563eb'
  on-primary-container: '#eeefff'
  inverse-primary: '#b4c5ff'
  secondary: '#006b5f'
  on-secondary: '#ffffff'
  secondary-container: '#6df5e1'
  on-secondary-container: '#006f64'
  tertiary: '#4d556b'
  on-tertiary: '#ffffff'
  tertiary-container: '#656d84'
  on-tertiary-container: '#eef0ff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dbe1ff'
  primary-fixed-dim: '#b4c5ff'
  on-primary-fixed: '#00174b'
  on-primary-fixed-variant: '#003ea8'
  secondary-fixed: '#71f8e4'
  secondary-fixed-dim: '#4fdbc8'
  on-secondary-fixed: '#00201c'
  on-secondary-fixed-variant: '#005048'
  tertiary-fixed: '#dae2fd'
  tertiary-fixed-dim: '#bec6e0'
  on-tertiary-fixed: '#131b2e'
  on-tertiary-fixed-variant: '#3f465c'
  background: '#faf8ff'
  on-background: '#191b23'
  surface-variant: '#e1e2ed'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '800'
    lineHeight: 56px
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '800'
    lineHeight: 40px
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
    letterSpacing: -0.01em
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  code-sm:
    fontFamily: JetBrains Mono
    fontSize: 14px
    fontWeight: '450'
    lineHeight: 20px
  label-caps:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.05em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 8px
  container-max: 1280px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 32px
  stack-sm: 4px
  stack-md: 16px
  stack-lg: 40px
---

## Brand & Style
The design system is engineered for a high-density knowledge-sharing environment, balancing technical precision with an approachable, community-centric atmosphere. The brand personality is "The Expert Mentor": authoritative and reliable, yet encouraging and accessible.

The visual style follows a **Modern Corporate** aesthetic with a strong emphasis on **Minimalism**. It prioritizes extreme legibility and structural clarity. High amounts of whitespace (negative space) are used to prevent cognitive overload during long-form reading. To differentiate from "cold" enterprise software, the system employs generous corner radii and a vibrant accent palette to inject energy and a sense of "friendly tech."

## Colors
The palette is rooted in a functional hierarchy designed to guide the eye through complex technical content.

- **Primary (Electric Blue):** Used for primary actions, links, and active states. It signals "interaction" and "progress."
- **Secondary (Teal/Turquoise):** Reserved for accents, success states, and categorizing "New" or "Trending" content. It provides a refreshing contrast to the primary blue.
- **Neutral/Text (Dark Navy):** Used for typography to ensure maximum contrast against the light background while appearing softer and more modern than pure black.
- **Background (Light Gray):** A subtle, cool-toned gray that reduces screen glare and provides a clean canvas for card-based components.

## Typography
This design system utilizes **Inter** for all UI and prose elements due to its exceptional tall x-height and readability on digital screens. For technical snippets and metadata, **JetBrains Mono** is introduced to provide a distinct "developer-centric" feel.

Headlines use a tighter letter-spacing and heavier weights to create a strong visual anchor. Body text is optimized for long-form reading with a generous line-height (1.5x - 1.6x). On mobile devices, display type scales down aggressively to maintain layout integrity while preserving the bold font weight.

## Layout & Spacing
The system uses a **Fluid Grid** model based on an 8px square-grid rhythm. 

- **Desktop:** A 12-column grid with a maximum width of 1280px. Content is centered with 32px side margins.
- **Tablet:** An 8-column grid with 24px margins.
- **Mobile:** A 4-column grid with 16px margins. 

Vertical spacing (stacking) follows a mathematical progression to ensure consistent rhythm between sections. Use `stack-lg` for separating major content sections and `stack-md` for internal component spacing.

## Elevation & Depth
Depth is conveyed through **Tonal Layers** and extremely soft **Ambient Shadows**. This keeps the interface feeling light and "airy."

- **Level 0 (Background):** #f8fafc.
- **Level 1 (Cards/Sheets):** Pure White (#ffffff) with a 1px border of #e2e8f0. No shadow for static states.
- **Level 2 (Hover/Active):** Pure White with a soft, diffused shadow: `0 10px 15px -3px rgba(15, 23, 42, 0.08)`.
- **Level 3 (Modals/Popovers):** Pure White with a more pronounced shadow: `0 20px 25px -5px rgba(15, 23, 42, 0.12)`.

Avoid heavy blacks or harsh borders; use subtle shifts in background color to define boundaries.

## Shapes
The shape language is defined by a "Rounded" philosophy to reinforce the friendly and modern brand tone. 

- **Standard (0.5rem):** Used for input fields, small buttons, and list items.
- **Large (1rem):** Used for article cards and containers.
- **Extra Large (1.5rem):** Used for featured "hero" cards and large call-to-action blocks.
- **Pill:** Reserved exclusively for tags, chips, and status indicators.

## Components

- **Buttons:** Primary buttons use a solid blue fill with white text. Ghost buttons use a 1px border and blue text. All buttons have a minimum height of 44px for touch accessibility and 0.5rem corner radius.
- **Cards:** The primary container for content. Cards feature white backgrounds, subtle light-gray borders, and 1rem rounded corners. On hover, cards lift slightly using the Level 2 shadow.
- **Chips/Tags:** Used for "Tech Stacks" (e.g., #React, #NodeJS). Use the secondary teal color at 10% opacity for the background and 100% opacity for the text.
- **Input Fields:** Use a white background with a 1px border (#cbd5e1). On focus, the border changes to primary blue with a 3px soft blue outer glow (halo).
- **Code Blocks:** Encased in a dark navy (#0f172a) container with JetBrains Mono text. Syntax highlighting should use the secondary teal and other vibrant, high-contrast colors.
- **Lists:** Clean, border-bottom separated items with generous 16px vertical padding. Use primary blue for bullet points or icons.
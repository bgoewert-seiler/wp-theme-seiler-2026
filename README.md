# Seiler 2026 WordPress Theme

* **Author:** Seiler Instruments
* **Developer:** Brennan Goewert
* **Designer:** Garry Dennison
* **License URI:** https://www.gnu.org/licenses/gpl-2.0.html

A modern WordPress block theme designed for Seiler divisions. Features common design language, full site editing (FSE), custom block patterns, and integration with Splide Carousel for dynamic content displays.

## 📋 Requirements

* ***WordPress:** 6.1 or higher
* ***PHP:** 7.4 or higher
* ***Recommended Plugins:**
  * *Splide Carousel (for sliders and carousels)
  * *Gravity Forms (for contact forms)
  * *WooCommerce (optional, for e-commerce features)
  * *The Events Calendar (optional, for event management)

## 🎨 Getting Started

### 1. Install Recommended Plugins

After activating the theme, you'll see an admin notice recommending the Splide Carousel plugin. Click the link to install it for full carousel functionality.

### 2. Customize Your Site

Navigate to **Appearance → Editor** to access the Site Editor:

- **Styles** - Customize colors, typography, and spacing
- **Templates** - Modify page layouts (homepage, single post, archive, etc.)
- **Template Parts** - Edit header and footer
- **Patterns** - Browse and insert pre-designed block patterns

### 3. Set Up Your Homepage

1. Create a new page called "Home"
2. Click the **+** button to add blocks
3. Browse to the **Pattern** tab
4. Insert the provided patterns in this order for the complete homepage:
   - Hero Slider
   - Three Feature Columns
   - Industries Grid
   - Call to Action Banner
   - Testimonials
   - Partner Logos
   - Contact Section
5. Go to **Settings → Reading** and set "Home" as your homepage

### 4. Configure Navigation

1. Go to **Appearance → Editor**
2. Select **Navigation** from the left sidebar
3. Edit the menu items in the header template part
4. Update links and labels to match your site structure

## 📦 Block Patterns Included

### Hero Slider
Full-width hero section with background image, headline, and CTA buttons. Add multiple instances and use Splide Carousel to create an auto-rotating slider.

**Location:** Seiler - Hero Sections

### Three Feature Columns
Three-column feature section with icons, headings, and descriptions on a blue background.

**Location:** Seiler - Features

### Industries Grid
8-item grid showcasing different industry sectors with images and overlay headings.

**Location:** Seiler - Content Sections

### Call to Action Banner
Full-width promotional banner with heading, description, and call-to-action button.

**Location:** Seiler - Call to Action

### Partner Logos
Grid of partner logos with grayscale hover effects. Use Splide Carousel to create an auto-scrolling carousel.

**Location:** Seiler - Content Sections

### Testimonials
Three customer testimonial cards with quotes and attribution. Use Splide Carousel to create a testimonial slider.

**Location:** Seiler - Testimonials

### Contact Section
Two-column layout with contact form placeholder and quick links on a dark background.

**Location:** Seiler - Content Sections

## 🎨 Customization

### Colors

The theme includes a carefully selected color palette optimized for public safety organizations:

- **Primary Blue** (#0066B3) - Main brand color
- **Secondary Orange** (#FF8C00) - Accent and CTAs
- **Accent Gold** (#FFB800) - Highlights and special elements
- **Dark Gray** (#333333) - Text and dark backgrounds
- **Medium Gray** (#666666) - Secondary text
- **Light Gray** (#F5F5F5) - Backgrounds and dividers
- **White** (#FFFFFF) - Base background
- **Black** (#000000) - Optional use

**To customize colors:**
1. Go to **Appearance → Editor**
2. Click **Styles** in the top right
3. Select **Colors**
4. Modify the palette or add custom colors

### Typography

The theme uses a modern sans-serif font stack:

- **Primary:** Open Sans / Roboto
- **Fallback:** System fonts for optimal performance

**Font sizes:**
- Small: 14px
- Base: 16px
- Medium: 18px
- Large: 24px
- Extra Large: 32px
- 2X Large: 48px
- 3X Large: 60px

**To customize typography:**
1. Go to **Appearance → Editor**
2. Click **Styles**
3. Select **Typography**
4. Adjust font sizes, families, and weights

### Spacing

Custom spacing scale for consistent layouts:
- Small: 20px
- Medium: 40px
- Large: 60px
- Extra Large: 80px
- 2X Large: 120px

### Layout

- **Content Width:** 1200px
- **Wide Width:** 1400px

## 🔌 Plugin Integration

### Splide Carousel

The theme is designed to work with Splide Carousel for slider functionality:

1. Install the Splide Carousel plugin
2. Patterns with slider notes (Hero, Partners, Testimonials) can be enhanced
3. Refer to plugin documentation for carousel setup

### Contact Forms

The Contact Section pattern includes a placeholder for forms:

1. Install Contact Form 7, WPForms, or Gravity Forms
2. Create your contact form
3. Copy the shortcode
4. Edit the Contact Section pattern and replace the placeholder with your shortcode

### WooCommerce

The theme includes basic WooCommerce support:

1. Install and activate WooCommerce
2. The theme will automatically apply WooCommerce-compatible styles
3. The header includes a cart icon (visible when products exist)

## 📱 Responsive Design

The theme is fully responsive with breakpoints at:

- **Desktop:** 1024px and above
- **Tablet:** 768px - 1023px
- **Mobile:** 480px - 767px
- **Small Mobile:** Below 480px

All patterns and templates automatically adapt to screen size.

## 🎯 Template Hierarchy

The theme includes the following templates:

- **index.html** - Default fallback template
- **front-page.html** - Homepage template (static front page)
- **page.html** - Standard page template
- **single.html** - Single post template with comments
- **archive.html** - Archive/category/tag listing template
- **blank.html** - Blank canvas template (no header/footer)
- **full-width.html** - Full-width page template

## 🛠️ Development

### File Structure

```
wp-theme-seiler-2026/
├── assets/
│   ├── css/
│   │   └── theme.css          # Custom styles
│   ├── images/                # Placeholder images
│   └── js/
│       └── theme.js           # Theme JavaScript
├── parts/
│   ├── header.html            # Header template part
│   └── footer.html            # Footer template part
├── patterns/
│   ├── hero-slider.php
│   ├── features-three-col.php
│   ├── industries-grid.php
│   ├── cta-banner.php
│   ├── partner-logos.php
│   ├── testimonials.php
│   └── contact-section.php
├── templates/
│   ├── index.html
│   ├── front-page.html
│   ├── page.html
│   ├── single.html
│   ├── archive.html
│   ├── blank.html
│   └── full-width.html
├── functions.php              # Theme setup and functions
├── style.css                  # Theme metadata
├── theme.json                 # Design system configuration
└── README.md                  # This file
```

### Adding Custom Patterns

1. Create a new PHP file in the `/patterns/` directory
2. Add the pattern header comment with title, slug, and category
3. Write your block pattern HTML
4. The pattern will automatically appear in the block editor

### Modifying Styles

1. Edit `/assets/css/theme.css` for custom CSS
2. Modify `theme.json` for design tokens (colors, typography, spacing)
3. Changes will apply globally across the site

## What's Next?

After setting up your theme:

1. **Replace placeholder images** - Upload your own images and update patterns
2. **Add real content** - Replace sample text with your organization's content
3. **Configure plugins** - Set up Splide Carousel and contact forms
4. **Customize colors** - Adjust the color palette to match your brand
5. **Create pages** - Build out your site structure (About, Services, Contact, etc.)
6. **Set up navigation** - Configure your main menu and footer links
7. **Test thoroughly** - Check all pages on desktop, tablet, and mobile
8. **Optimize performance** - Install a caching plugin and optimize images
9. **Set up SEO** - Install an SEO plugin like Yoast or Rank Math
10. **Launch!** - Go live and share your new site

---

## TODO

- [ ] **Accessibility** - WCAG 2.1 Level AA compliant
- [ ] **Performance Optimization** - Lightweight and fast-loading
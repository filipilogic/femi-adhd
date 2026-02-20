---
name: figma-to-block
description: Converts Figma designs into WordPress ACF blocks following iLogic theme patterns. Use when working with Figma files, implementing designs, or creating blocks from design mockups.
---

# Figma to WordPress Block Conversion

## Workflow Overview

1. Access Figma design using MCP tools
2. Analyze layout and identify block pattern
3. Extract design tokens (colors, typography, spacing)
4. Map Figma components to WordPress blocks/components
5. Build block data structure with nested field keys
6. Create or modify blocks
7. Implement styling (including gradients, transforms, etc.)
8. Export and optimize composite images

## Step 1: Analyze Figma Design

### Identify Patterns

- **Hero sections** → Check `hero`, `hero-si`, `inner-hero-1`, `inner-hero-2`
- **Content sections** → Check `section` block
- **Image galleries** → Check `gallery`, `mini-gallery`
- **Interactive elements** → Check `accordion`, `tabs`, `timeline`
- **Content layouts** → Check `columns`, `content-and-sidebar`

### Decision Tree

```
Is this a unique design pattern?
├─ NO → Use existing block with ACF field modifications
└─ YES → Create new block following block creation workflow
```

## Step 2: Using Figma MCP Tools

### Access Figma Design

When given a Figma URL like `https://www.figma.com/design/fileKey/fileName?node-id=1234-5678`:

1. **Extract node ID**: Convert `1234-5678` to `1234:5678` (replace `-` with `:`)
2. **Call MCP tools**:
   ```javascript
   CallMcpTool: user-figma-desktop -> get_design_context
   CallMcpTool: user-figma-desktop -> get_screenshot
   ```

### Analyze Figma Output

The MCP tools return:

- **React/Tailwind code**: Shows structure and layout
- **Screenshot**: Visual reference
- **Design tokens**: Typography, colors, spacing in comments

**Extract key information**:

- Layout structure (flex, grid, columns)
- Typography (`font-['Rubik:Bold']`, `text-[42px]`)
- Spacing (`gap-[48px]`, `pt-[120px]`)
- Colors (`#1f9dd0`, gradients)
- Image assets (URLs provided)

### Prompts for Figma Conversion

Use the appropriate prompt based on your Figma design pattern:

---

#### Section Block Prompt

**Use for**:

- Two-column image + content (phone mockups, illustrations with text)
- Full-width text-only sections
- Centered content with custom width

```
Convert this Figma design to a WordPress ACF Section block:
[FIGMA_URL]

Requirements:
1. Use Figma MCP tools (get_design_context and get_screenshot)
2. Determine the appropriate layout type:
   - `ib-left` - Text LEFT, Image RIGHT
   - `ib-right` - Text RIGHT, Image LEFT
   - `ib-fullwidth` - Full-width text, no image
   - `ib-custom-width` - Custom content width with alignment
3. For ib-left/ib-right layouts:
   - Use `media` field (field_633822e95716d) for image - NOT inner_section_background
   - Set width split: `info-box-width-40` to `info-box-width-75`
   - Set stack behavior: `stack-mobile`, `stack-tablet`, or reverse variants
4. For ib-custom-width layouts:
   - Set `content_custom_width` (field_64afeac2c1b68): 0-100%
   - Set `content_align` (field_64afed91b6ede): content-align-left/center/right
5. If multiple overlapping images exist, export as ONE composite image
6. Extract exact spacing, typography, and colors from Figma output
7. Use WordPress flat block format (NOT nested JSON):
   - Human-readable field names: "title", "subtitle", "buttons_0_button"
   - Underscore metadata: "_title": "field_633cae4546452" (final key only)
   - No nested objects - all flat key-value pairs
   - See blocks/section/WORDPRESS-BLOCK-FORMAT-GUIDE.md for complete format reference
8. Use correct CSS class naming: .il_block_intro, .intro_title (single underscore)
9. Include SCSS for gradients, transforms, or custom styling
10. Set text alignment for RTL content (align-right)

Output:
- A single file containing complete <!-- wp:acf/section --> block code in WordPress flat format
- SCSS additions with correct class names if needed
- Image assets to export from Figma (as composite images where applicable)

CRITICAL: Use WordPress ACF flat format, not nested JSON. Reference the working example format.
```

---

#### Columns Block Prompt (Multi-Item Grid/Cards)

**Use for**: Feature cards, service grids, team members, any repeating card layout

```
Convert this Figma design to a WordPress ACF Columns block:
[FIGMA_URL]

Requirements:
1. Use Figma MCP tools (get_design_context and get_screenshot)
2. Count the number of columns/cards in the design
3. Use columns repeater (field_63760bb52814b) for individual cards
4. Set column count: cols-2, cols-3, cols-4, or cols-5
5. Set tablet/mobile counts: tab-cols-X, mob-cols-X
6. Extract exact spacing, typography, and colors from Figma output
7. Use Columns intro field prefix: field_637615ef54187_field_xxx
8. Use correct CSS class naming: .il_col.column, .il_col_text
9. Include SCSS for card styling (shadows, borders, rounded corners)
10. For card inner borders, use ::before with z-index: 0

Output:
- Complete <!-- wp:acf/columns --> block code with all ACF field values
- SCSS for card styling patterns if needed
- Image assets to export from Figma
```

---

## WordPress ACF Block Format - CRITICAL

WordPress ACF blocks require a specific flat format that differs from typical nested JSON.

### Format Rules

1. **Flat Structure**: No nested objects for field groups
2. **Field Pattern**: `"field_name": "value"` + `"_field_name": "field_key"`
3. **Metadata Uses Final Key Only**: Not the full nested path
4. **Clone Fields Are Flattened**: All fields at root level

### Example - WRONG (Nested):

```json
"field_6338223792cfe": {
  "_name": "section_intro",
  "field_6338223792cfe_field_6346f6d37f098_field_633cae4546452": "Title"
}
```

### Example - CORRECT (Flat):

```json
"title": "Title text",
"_title": "field_633cae4546452",
"heading_tag": "h2",
"_heading_tag": "field_63447fe3871ab"
```

### Before Title Field - Special Case

The `before_title` is a clone field that requires ALL sub-fields to be defined, even if empty:

**Required fields:**

- `before_title`: `""` (text, usually empty)
- `_before_title`: `"field_65358ae4adaf4"` (NOT field_65358cb8745ca)
- `before_title_font_size`: `"before-title-size-1"`
- `_before_title_font_size`: `"field_65358ae4b1785"`
- `before_title_font_weight`: `"before-title-weight-400"`
- `_before_title_font_weight`: `"field_65358ae4b5323"`
- `before_title_color`: `""`
- `_before_title_color`: `"field_65358ae4b8fd7"`
- `before_title_use_custom_style`: `"0"`
- `_before_title_use_custom_style`: `"field_65358ae4bcc70"`

**Common mistake:** Using `field_65358cb8745ca` (clone reference) instead of `field_65358ae4adaf4` (actual field) causes "Array to string conversion" errors.

### Complete Format Reference

See `blocks/section/WORDPRESS-BLOCK-FORMAT-GUIDE.md` for:

- Complete field mapping
- Repeater format
- Group field structure
- Validation checklist

---

## Step 3: Extract Design Tokens

### Colors

Extract from Figma:

- Primary colors
- Secondary colors
- Text colors
- Background colors
- Gradient values

**Implementation**:

- Add to theme options (ACF Options page)
- Or use CSS variables in block SCSS
- For gradients: Add custom SCSS with linear-gradient

### Typography

Extract from Figma MCP output:

- `font-['Rubik:Bold']` → `title-weight-700`
- `text-[42px]` → `title_font_size_ld: "4.2rem"`
- `text-[24px]` (mobile check) → `title_font_size_mt: "24px"`
- `leading-[1.1]` → line-height: 1.1

**Implementation**:

- Update `assets/src/sass/template-style/1-variables.scss`
- Use existing font size classes or create custom
- Convert px to rem for desktop (divide by 10)
- **IMPORTANT: Use pixels for mobile/tablet fonts** to avoid scaling issues
  - Titles: ~30px mobile, ~20px for smaller elements
  - Body text: ~16px mobile
  - Set via ACF field values (e.g., `title_font_size_mt: "20px"`)

### Spacing

Extract from Figma MCP output:

- `gap-[48px]` → 4.8rem margin/gap
- `pt-[120px]` → 12rem padding-top
- Always extract both desktop and mobile values

**Mobile Padding Rule**:

- Mobile paddings should generally be LARGER than desktop, not smaller
- **Minimum 10rem** for mobile/tablet block spacing (top/bottom custom padding)
- Example: Desktop 8rem block spacing → Mobile 10rem
- Example: Desktop 4.6rem block spacing → Mobile 10rem (use minimum)
- For inner padding: Desktop 3.2rem → Mobile 4rem
- This accounts for content stacking on mobile requiring more breathing room

**Title/Subtitle Margin Rule**:

- **Desktop**: Match the exact margins from Figma design
- **Mobile**: Be more liberal with margins - add extra breathing room for stacked content
- Mobile margins should typically be larger than or equal to desktop, never smaller
- Example: Figma shows 0.8rem gap → Desktop: `0.8rem`, Mobile: `1.5rem` or `2rem`
- Small margins like 0.6rem create cramped layouts on mobile - use at least 1.5rem

**Implementation**:

- Use existing margin/padding field objects
- Or create custom padding with CSS variables
- Desktop: `custom_padding_ld_padding_top`
- Mobile: `custom_padding_mt_padding_top`

## Step 4: Map Figma to Blocks

### Layout Pattern Recognition

**Two-Column Image + Content** → `acf/section` block with `ib-left` or `ib-right` layout

- Images on left/right, content on opposite side
- **Use `media` field for the image** (NOT inner_section_background)
- **Use `ib-left`** (image left, content right) or **`ib-right`** (image right, content left)
- **Use `info-box-width-XX`** to control the width split (40%, 45%, 50%, 55%, 60%, 65%, 70%, 75%)
- Example: Phone mockups with feature list

**Equal Multi-Column** → `acf/columns` block

- 2-4 equal-width columns
- Each column has own content
- Example: Features, services, team members

**Full-Width Hero** → `acf/hero` or `acf/hero-si`

- Large text with CTA
- Full background image/gradient
- Centered or aligned content

### Section Block Layout Options

The `acf/section` block has multiple built-in layouts:

**IMPORTANT**: "ib" stands for "Info Box" (text content), NOT image!

| Layout Value      | Description                  | Use Case                                 |
| ----------------- | ---------------------------- | ---------------------------------------- |
| `ib-left`         | Info Box LEFT, Image RIGHT   | Text on left, illustration on right      |
| `ib-right`        | Info Box RIGHT, Image LEFT   | Phone mockups on left, features on right |
| `ib-fullwidth`    | Full-width content, no image | Text-only sections                       |
| `ib-custom-width` | Custom content width %       | Advanced custom layouts                  |

**Quick Reference**:

- Want image on LEFT? → Use `ib-right`
- Want image on RIGHT? → Use `ib-left`

**Info Box Width Options** (for ib-left/ib-right):

- `info-box-width-40` to `info-box-width-75` (in 5% increments)
- Controls the content vs. image width split
- 50% = equal split, 40% = more image space, 75% = more content space

### Component Mapping

| Figma Component           | WordPress Component/Block                   |
| ------------------------- | ------------------------------------------- |
| Hero section              | `blocks/hero/` or `blocks/hero-si/`         |
| Text + Image (two-column) | `blocks/section/` with `ib-left`/`ib-right` |
| Image gallery             | `blocks/gallery/` or `blocks/mini-gallery/` |
| Accordion                 | `blocks/accordion/`                         |
| Tabs                      | `blocks/tabs/`                              |
| Columns layout            | `blocks/columns/`                           |
| Team grid                 | `blocks/team/`                              |
| Timeline                  | `blocks/timeline/`                          |

### Background & Image Placement - CRITICAL

**For Two-Column Image + Content Layouts:**
Use the **Media field** (`field_633822e95716d`), NOT inner_section_background!

- Set layout: `ib-left` or `ib-right`
- Set width: `info-box-width-50` (or 40, 45, 55, 60, 65, 70, 75)
- Add image to `media` field
- Add mobile image to `media_mobile` field (optional)

**Main Background** (`field_63494a0141bbd`)

- Full section background behind everything
- Textures, patterns, solid colors, gradients
- Covers entire block area
- Example: Gradient background, texture overlay, full-width image

**Inner Section Background** (`field_64b7c4da96557`)

- Decorative positioned elements within the section
- NOT for main two-column layouts
- Use for absolute positioned decorative elements
- Example: Floating shapes, decorative SVGs

**Rule**: For image + content side-by-side, use `media` field with `ib-left`/`ib-right` layout!

### Reusable Elements

- **Title + Subtitle + Text** → `components/intro`
- **Background** → `components/background`
- **Buttons** → `components/buttons`
- **Before title content** → `components/before-title`

## Step 5: Build Block Data Structure

### Understanding Nested Field Keys

ACF uses deeply nested field keys for grouped fields:

**Pattern**: `parent_group_field_child_group_field_actual_field`

**Example**:

```json
"field_6338223792cfe": {  // section_intro group
  "field_6338223792cfe_field_6346f6d37f098_field_633cae4546452": "Title text",
  // ↑ section_intro → title_group → title field
}
```

### Section Block Structure

For two-column image + content layouts using `acf/section`:

```json
{
  "field_6338223792cfe": {
    // section_intro group
    // Title
    "field_6338223792cfe_field_6346f6d37f098_field_633cae4546452": "Heading text",
    "field_6338223792cfe_field_6346f6d37f098_field_63447fe3871ab": "h2",
    "field_6338223792cfe_field_6346f6d37f098_field_64b00f292a45d": "title-size-2",
    "field_6338223792cfe_field_6346f6d37f098_field_64b455fa2d932": "1",
    "field_6338223792cfe_field_6346f6d37f098_field_64b457002d933": "4.2rem",
    "field_6338223792cfe_field_6346f6d37f098_field_64b457222d934": "24px",

    // Subtitle
    "field_6338223792cfe_field_64ae7d0cd8195_field_64ae7b8e72fe2": "Subtitle text",
    "field_6338223792cfe_field_64ae7d0cd8195_field_64b016f604510": "subtitle-size-1",
    "field_6338223792cfe_field_64ae7d0cd8195_field_64b5121b50892": "1",
    "field_6338223792cfe_field_64ae7d0cd8195_field_64b5123c50894": "2rem",

    // Text content
    "field_6338223792cfe_field_6346f7017f099": "<p>HTML content here</p>",
    "field_6338223792cfe_field_63c7cb8e8cc91": "align-right"
  },

  // Media (Image) - Use this for two-column layouts!
  "field_633822e95716d": "6448", // media - image ID
  "field_6602db211d619": "", // media_mobile - mobile image ID (optional)

  // Layout settings for two-column
  "field_63448568cb704": "ib-right", // layout: ib-left or ib-right
  "field_6338282d741de": "info-box-width-50", // choose_style: 40-75%
  "field_634486f33a083": "stack-mobile", // stack on mobile

  // Main background (behind everything)
  "field_63494a0141bbd": {
    "field_63494a0141bbd_field_63906c48a6adb": "1", // use_background
    "field_63494a0141bbd_field_6338240f11ade": "", // background_color
    "field_63494a0141bbd_field_6338240411add": "" // background_image
  },

  // Spacing
  "field_634d6f80709fc": {
    "field_634d6f80709fc_field_64b2e129e2cd4": "1", // use custom padding
    "field_634d6f80709fc_field_64b2e187e2cd6": {
      "field_64b2e18ce2cd7": "12rem", // padding-top desktop
      "field_64b2e1f4e2cd9": "12rem" // padding-bottom desktop
    },
    "field_634d6f80709fc_field_64b2ed3ce6b65": {
      "field_64b2ed3ce6b66": "10rem", // padding-top mobile
      "field_64b2ed3ce6b67": "10rem" // padding-bottom mobile
    }
  }
}
```

### Quick Reference: Common Field Keys

**Section Intro Fields**:

- Title: `field_6338223792cfe_field_6346f6d37f098_field_633cae4546452`
- Subtitle: `field_6338223792cfe_field_64ae7d0cd8195_field_64ae7b8e72fe2`
- Text: `field_6338223792cfe_field_6346f7017f099`
- Alignment: `field_6338223792cfe_field_63c7cb8e8cc91`

**Before Title Fields** (Section Intro):

- Before title text: `field_65358ae4adaf4` (NOT field_65358cb8745ca - that's the clone reference)
- Font size: `field_65358ae4b1785`
- Font weight: `field_65358ae4b5323`
- Color: `field_65358ae4b8fd7`
- Use custom: `field_65358ae4bcc70`

**Media (Image) Fields**:

- Media (desktop): `field_633822e95716d`
- Media Mobile: `field_6602db211d619`

**Layout Fields for Two-Column**:

- Layout type: `field_63448568cb704` (values: `ib-left`, `ib-right`, `ib-fullwidth`, `ib-custom-width`)
- Info box width: `field_6338282d741de` (values: `info-box-width-40` to `info-box-width-75`)
- Stack: `field_634486f33a083` (value: `stack-mobile`)

**Background Fields**:

- Main background: `field_63494a0141bbd`
- Inner background: `field_64b7c4da96557` (decorative elements only)

## Step 6: Create Block from Figma

### If Creating New Block

Follow the WordPress block creation workflow:

1. Create block directory
2. Create `block.json`
3. Register in `functions.php`
4. Create ACF field group matching Figma structure
5. Create PHP template
6. Create SCSS with Figma styles

### If Modifying Existing Block

1. Check if ACF fields need additions
2. Modify PHP template if structure changes
3. Update SCSS to match Figma design
4. Test responsive breakpoints

## Step 7: Implement Styling

### SCSS Structure

```scss
.il_block.il_your-block {
  // Base styles from Figma

  // Desktop styles (ld)
  padding: [Figma desktop padding];
  color: [Figma text color];

  // Mobile styles (mt)
  @include limbo-max {
    padding: [Figma mobile padding];
  }

  // Block-specific elements
  .il_your-block_element {
    // Styles matching Figma
  }
}
```

### Special Effects from Figma

**CRITICAL: Correct CSS Class Naming**

- Section intro container: `.il_block_intro` (single underscore)
- Title element: `.intro_title` (not `.il_block__title`)
- Subtitle element: `.intro_subtitle`
- Text element: `.intro_text`

**Gradient Text**:

```scss
.digital-section {
  .il_block_intro {
    .intro_title {
      background: linear-gradient(94.32deg, #1f9dd0 0.62%, #3e65f1 99.49%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
  }
}
```

**Rotated/Transformed Elements**:

```scss
.digital-section {
  .right img {
    transform: rotate(-5.91deg);
  }
}
```

**Opacity Effects**:

```scss
.digital-section {
  .right {
    opacity: 0.6;
  }
}
```

**Custom Gaps/Spacing**:

```scss
.digital-section {
  .intro_text {
    display: flex;
    flex-direction: column;
    gap: 3.1rem;
  }
}
```

### Responsive Breakpoints

- **Desktop (ld)**: Default styles
- **Mobile/Tablet (mt)**: Use `@include limbo-max` mixin

### CSS Variables

For dynamic values from ACF:

```scss
.il_block.il_your-block {
  padding-top: var(--b-block-space-top-ld);
  @include limbo-max {
    padding-top: var(--b-block-space-top-mt);
  }
}
```

## Figma-Specific Considerations

### Images - CRITICAL RULES

**Rule 1: Composite vs. Separate Images**

✅ **Use ONE composite image when:**

- Multiple overlapping elements (phones + background shape)
- Complex illustrations with decorative elements
- Mockups with shadows/effects

❌ **Don't use separate positioned elements unless:**

- Elements need to animate independently
- User specifically requests it
- Elements are truly independent (not part of one visual)

**Example**: Phone mockups with background shape = Export as ONE PNG, not 3 separate images

**Rule 2: Image Placement**

| Image Type          | Field Location           | ACF Field             | Use Case                                                         |
| ------------------- | ------------------------ | --------------------- | ---------------------------------------------------------------- |
| Two-column layout   | Media field              | `field_633822e95716d` | Main image in ib-left/ib-right layouts                           |
| Full background     | Main background          | `field_63494a0141bbd` | Textures, gradients, patterns covering full section              |
| Decorative elements | Inner section background | `field_64b7c4da96557` | Absolute positioned decorative elements (NOT main layout images) |

**Rule 3: Two-Column Layout Structure**

For image + content side-by-side:

```json
"field_633822e95716d": "6448",              // media - image ID
"field_6602db211d619": "",                   // media_mobile - optional
"field_63448568cb704": "ib-right",          // layout: ib-left or ib-right
"field_6338282d741de": "info-box-width-50", // width: 40-75%
"field_634486f33a083": "stack-mobile"       // stack on mobile
```

**Export Process**:

1. Select entire visual group in Figma
2. Export as PNG (with transparency) or JPG
3. Export @2x for retina displays
4. Optimize/compress before upload
5. Upload to WordPress Media Library
6. Use Media Library ID in block data

### Icons

- Export SVGs from Figma
- Save to `assets/icons/`
- Use inline SVG or background-image

### Spacing

- Figma uses pixels → Convert to rem (divide by 10)
- Example: 40px → 4rem
- Use CSS variables for ACF-controlled spacing

### Typography

- Match Figma font sizes exactly
- Use existing font size classes if available
- Create custom if needed:
  ```scss
  .custom-font-size {
    font-size: [Figma size]rem;
    @include limbo-max {
      font-size: [Figma mobile size]rem;
    }
  }
  ```

## Quality Checklist

- [ ] Design matches Figma (desktop)
- [ ] Design matches Figma (mobile)
- [ ] Spacing matches Figma values
- [ ] Typography matches Figma
- [ ] Colors match Figma
- [ ] Images are optimized
- [ ] Responsive breakpoints work
- [ ] ACF fields allow content editing
- [ ] Components are reused where possible

## Common Figma Patterns

### Card Layout

```php
// Use columns block or create custom
if ( have_rows('cards') ) {
    while ( have_rows('cards') ) {
        the_row();
        // Render card
    }
}
```

### Overlapping Elements

```scss
// Use CSS positioning
.il_block.il_your-block {
  position: relative;
  .overlapping-element {
    position: absolute;
    top: -2rem;
    right: 2rem;
  }
}
```

### Gradient Backgrounds

```php
// In background component or block
$gradient = get_field('use_gradient');
if( $gradient ) {
    $style = 'background: linear-gradient(...);';
}
```

## Common Mistakes to Avoid

### ❌ Wrong: Separate Positioned Elements for One Visual

```json
"field_64b7c4da96559_field_64ae8a31e2b03": [
  { "element": "background_shape_id" },
  { "element": "phone_mockup_1_id" },
  { "element": "phone_mockup_2_id" }
]
```

### ✅ Right: One Composite Image

```json
"field_633822e95716d": "complete_illustration_id"
```

### ❌ Wrong: Using Inner Section Background for Two-Column Layouts

```json
"field_64b7c4da96557": {
  "field_64b7c4da96559_field_63906c48a6adb": "1",
  "field_64b7c4da96559_field_64ae8a31e2b03": { "image": "..." }
}
```

### ✅ Right: Use Media Field with ib-left/ib-right Layout

```json
"field_633822e95716d": "6448",
"field_63448568cb704": "ib-right",
"field_6338282d741de": "info-box-width-50"
```

### ❌ Wrong: Using Nested JSON Structure

```json
{
  "name": "acf/section",
  "data": {
    "field_6338223792cfe": {
      "_name": "section_intro",
      "field_6338223792cfe_field_xxx": "value"
    }
  }
}
```

**Why wrong:** WordPress doesn't recognize nested objects. Block appears empty when imported.

### ✅ Right: Use Flat Format with Human-Readable Names

```json
{
  "name": "acf/section",
  "data": {
    "title": "value",
    "_title": "field_633cae4546452"
  }
}
```

### ❌ Wrong: Using Clone Reference Key for before_title

```json
"before_title": "",
"_before_title": "field_65358cb8745ca"  // WRONG - this is the clone reference
```

**Why wrong:** Using the clone group key instead of the actual field key causes WordPress to store nested JSON, resulting in "Array to string conversion" PHP errors.

### ✅ Right: Use Actual Field Key with All Sub-Fields

```json
"before_title": "",
"_before_title": "field_65358ae4adaf4",  // CORRECT - actual text field key
"before_title_font_size": "before-title-size-1",
"_before_title_font_size": "field_65358ae4b1785",
"before_title_font_weight": "before-title-weight-400",
"_before_title_font_weight": "field_65358ae4b5323",
"before_title_color": "",
"_before_title_color": "field_65358ae4b8fd7",
"before_title_use_custom_style": "0",
"_before_title_use_custom_style": "field_65358ae4bcc70"
```

### ❌ Wrong: CSS Class Naming

```scss
.il_block__intro .il_block__title {
}
```

### ✅ Right: CSS Class Naming

```scss
.il_block_intro .intro_title {
}
```

### ❌ Wrong: Adding font-family in SCSS

```scss
.doctor-quote {
  font-family: 'Rubik', sans-serif;
  font-style: italic;
}
```

### ✅ Right: Let theme handle font-family globally

```scss
.doctor-quote {
  font-style: italic;
  font-weight: 400;
}
```

### ❌ Wrong: Adding custom button styling in SCSS

```scss
.my-section {
  .buttons .il_btn {
    background: linear-gradient(...);
    box-shadow: 6px 5px 20.3px rgba(25, 106, 157, 0.3);
    border-radius: 0.8rem;
    font-size: 2.4rem;
  }
}
```

### ✅ Right: Use theme button classes via ACF fields

```json
// Set button colors in ACF block data - theme handles all button styling
"field_64af3738cf78f": "button-color-blue",
"field_64af37cacf790": "button-hover-color-blue"
// Available classes: button-color-blue, button-color-purple, button-color-white
// Hover classes: button-hover-color-blue, button-hover-color-purple, button-hover-color-white
```

### ❌ Wrong: Confusing ib-left/ib-right Layout Names

```json
// WRONG understanding: "ib-left" does NOT mean image on left
"field_63448568cb704": "ib-left"
```

### ✅ Right: Understanding Layout Names

```json
// "ib" = Info Box (text content), NOT image
// ib-right = Info Box on RIGHT, Image on LEFT
// ib-left = Info Box on LEFT, Image on RIGHT
"field_63448568cb704": "ib-right"  // Use this for image on LEFT
```

### ❌ Wrong: Missing text alignment for RTL content

```json
"field_6338223792cfe_field_63c7cb8e8cc91": ""
```

### ✅ Right: Always set alignment for Hebrew/RTL content

```json
"field_6338223792cfe_field_63c7cb8e8cc91": "align-right",
"field_6338223792cfe_field_63c7c882cbc4d": "text-theme-color"
```

### ❌ Wrong: Hardcoding styles that ACF controls

```scss
.doctor-quote-section {
  .il_section_inner {
    background: white;
    padding: 3.2rem;
  }
}
```

### ✅ Right: Only add styles ACF cannot control

```scss
.doctor-quote-section {
  .il_section_inner {
    // ACF handles: background, padding via inner_section_background and inner_section_spacing
    // Only add what ACF can't control:
    border-radius: 1.6rem;
    box-shadow: 4px -5px 10.3px 0px rgba(199, 217, 244, 0.3);
  }
}
```

## Troubleshooting Checklist

- [ ] Used WordPress flat format (NOT nested JSON)?
- [ ] Used correct before_title field key (field_65358ae4adaf4, not field_65358cb8745ca)?
- [ ] Included all before_title sub-fields with defaults?
- [ ] Metadata uses ONLY final field key (except deeply nested groups)?
- [ ] Used MCP tools to get design context?
- [ ] Exported composite images, not separate elements?
- [ ] Used `media` field (NOT inner_section_background) for two-column layouts?
- [ ] Set correct layout: `ib-right` for image LEFT, `ib-left` for image RIGHT?
- [ ] Set info box width: `info-box-width-XX`?
- [ ] Extracted both desktop AND mobile spacing?
- [ ] Converted px to rem (divide by 10)?
- [ ] Used pixels (not rem) for mobile font sizes in ACF fields?
- [ ] Used correct CSS class names (`.il_block_intro`, `.intro_title`)?
- [ ] Added custom SCSS for gradients/transforms with correct classes?
- [ ] Set proper z-index layering for card pseudo-elements?
- [ ] Tested responsive breakpoints?
- [ ] Considered RTL layout implications?
- [ ] Set text alignment for RTL content (`align-right`)?
- [ ] Avoided adding `font-family` in SCSS (theme handles globally)?
- [ ] Used theme button classes (`button-color-blue`, etc.) instead of custom button SCSS?
- [ ] Used ACF fields for background/padding instead of hardcoding in SCSS?
- [ ] Used `inner_section_background` for decorative elements within white card?
- [ ] Used `inner_section_spacing` for card padding instead of hardcoded SCSS?
- [ ] Set mobile block padding minimum 10rem (top/bottom)?
- [ ] Title/subtitle margins: matched Figma for desktop, more liberal for mobile (min 1.5rem)?

## RTL (Right-to-Left) Considerations

This theme serves Hebrew content and uses RTL direction. Key considerations:

### Flexbox in RTL

- Flexbox `row` direction is automatically reversed in RTL context
- `flex-start` becomes visually right, `flex-end` becomes visually left
- **Don't use** `direction: rtl` on individual elements if the page is already RTL - it can cause double-reversal issues

### CSS Positioning in RTL

- Physical properties (`left`, `right`) remain unchanged - `left: 0` still means physical left
- Use physical properties for absolute positioning, not logical properties
- For elements that should appear on the visual right in RTL, use `left` positioning
- For elements that should appear on the visual left in RTL, use `right` positioning

### Common RTL Patterns

**Floating icons outside cards:**

```scss
.card-icon {
  position: absolute;
  left: -4.3rem; // Positions visually on the RIGHT in RTL
  top: 50%;
  transform: translateY(-50%);
}
```

**Image overlapping cards from right side:**

```scss
.image-container {
  position: absolute;
  right: 0; // Physical right stays right
  z-index: 1;
}

.cards-container {
  margin-right: auto; // Pushes to LEFT in RTL context
  z-index: 2;
}
```

### Don't Override ACF Block Settings

- Don't set `max-width` in SCSS if the block has an ACF field for it (e.g., "Inner Columns Container Max Width")
- Use ACF settings fields to control values that editors should be able to modify
- Only add SCSS for styling that can't be controlled via ACF fields

## Tips

1. **Start with structure** - Build PHP template first
2. **Then add styling** - Match Figma pixel-perfect
3. **Test responsive** - Always check mobile view
4. **Reuse components** - Don't duplicate intro/background code
5. **Use ACF flexibly** - Allow content editors to customize
6. **Composite images** - Export complex visuals as one image
7. **Use media field for two-column** - Not inner_section_background!
8. **Correct CSS classes** - `.il_block_intro` and `.intro_title` (single underscore)
9. **ib-left vs ib-right** - Built-in layouts for image + content
10. **Info box width** - Control split with `info-box-width-XX` (40-75%)
11. **Mobile fonts use pixels** - Use px (not rem) for mobile font sizes in ACF fields to prevent scaling issues
12. **Card z-index layering** - When using `::before` for decorative borders, set `z-index: 0` on pseudo-element and `position: relative; z-index: 1;` on child content

## Common Pattern: Card-Style Columns

For columns with card styling (shadow, border, rounded corners):

**SCSS Structure**:

```scss
.your-section-class {
  .il_col.column {
    background: white;
    border-radius: 1.6rem;
    box-shadow: 0px 0px 16.1px 0px #dbebf3;
    padding: 1.5rem 1.4rem;
    position: relative;

    // Child elements need z-index for proper layering
    > img,
    > .before_title,
    > .intro_title,
    > .il_col_text,
    > .buttons {
      position: relative;
      z-index: 1;
    }

    // Inner border using pseudo-element
    &::before {
      content: '';
      position: absolute;
      inset: 1.5rem 1.4rem;
      border: 1px solid rgba(162, 187, 226, 0.5);
      border-radius: 1.6rem;
      z-index: 0; // Must be 0, not -1
    }
  }
}
```

**Key Points**:

- `::before` z-index must be `0` (not `-1`) to be visible
- Child elements need `position: relative; z-index: 1;`
- Don't add `background: white` to `::before` if only using for border

---

# Block Field Reference

This section provides comprehensive ACF field mappings, CSS classes, and structure documentation for the Section and Columns blocks.

## Section Block (`acf/section`)

**ACF Field Group**: `group_633822375a604` (Block: iLogic Section)  
**PHP Template**: `blocks/section/section.php`  
**SCSS**: `assets/src/sass/blocks/section.scss`

### Section Block - Complete ACF Field Reference

#### Content Tab

| Field Key             | Name            | Type  | Values/Options    | Description              |
| --------------------- | --------------- | ----- | ----------------- | ------------------------ |
| `field_6338223792cfe` | `section_intro` | clone | (Intro component) | Main intro content group |

**Intro Clone Fields** (nested under `field_6338223792cfe`):

| Field Key             | Name                    | Type       | Values                                                      | Description                  |
| --------------------- | ----------------------- | ---------- | ----------------------------------------------------------- | ---------------------------- |
| `field_64b0098c6aada` | `image_before_content`  | image      | ID                                                          | Image displayed before title |
| `field_65358cb8745ca` | `before_title`          | clone      | (Before Title)                                              | Content before title         |
| `field_6346f6d37f098` | `title`                 | clone      | (Title component)                                           | Title group                  |
| `field_64ae7d0cd8195` | `subtitle`              | clone      | (Subtitle component)                                        | Subtitle group               |
| `field_63c7c882cbc4d` | `intro_text_color`      | radio      | `text-theme-color`, `text-white`, `text-black`, `text-blue` | Text color                   |
| `field_63c7cb8e8cc91` | `intro_alignment`       | radio      | `align-left`, `align-center`, `align-right`                 | Content alignment            |
| `field_64b694fff387a` | `text_use_custom_style` | true_false | 0/1                                                         | Enable custom text styling   |
| `field_64b6957b7c2f2` | `text_margin_bottom_ld` | text       | CSS value                                                   | Text margin (desktop)        |
| `field_64b695a67c2f3` | `text_margin_bottom_mt` | text       | CSS value                                                   | Text margin (mobile)         |
| `field_64b152d2049c2` | `list_columns`          | radio      | `list-cols-1`, `list-cols-2`                                | List layout columns          |
| `field_6346f7017f099` | `intro_text`            | wysiwyg    | HTML                                                        | Main text content            |
| `field_64af241aef5c2` | `intro_buttons`         | clone      | (Buttons component)                                         | Buttons group                |
| `field_64b00cbb3e6c2` | `image_after_content`   | image      | ID                                                          | Image after content          |

#### Image Tab

| Field Key             | Name                      | Type       | Values    | Description                     |
| --------------------- | ------------------------- | ---------- | --------- | ------------------------------- |
| `field_633822e95716d` | `media`                   | image      | array     | Main image (two-column layouts) |
| `field_6602db211d619` | `media_mobile`            | image      | array     | Mobile-specific image           |
| `field_651d6f6200ea7` | `width_ld_sec_img`        | text       | CSS value | Image width (desktop)           |
| `field_651d6f9a00ea9` | `height_ld_sec_img`       | text       | CSS value | Image height (desktop)          |
| `field_651d6fbe00eaa` | `left_ld_sec_img`         | text       | CSS value | Image left position (desktop)   |
| `field_651d6fd300eab` | `right_ld_sec_img`        | text       | CSS value | Image right position (desktop)  |
| `field_651d6fd700ead` | `top_ld_sec_img`          | text       | CSS value | Image top position (desktop)    |
| `field_651d6fd500eac` | `bottom_ld_sec_img`       | text       | CSS value | Image bottom position (desktop) |
| `field_651d702896daf` | `width_mt_sec_img`        | text       | CSS value | Image width (mobile)            |
| `field_651d702d96db0` | `height_mt_sec_img`       | text       | CSS value | Image height (mobile)           |
| `field_651d703296db1` | `left_mt_sec_img`         | text       | CSS value | Image left position (mobile)    |
| `field_651d703896db2` | `right_mt_sec_img`        | text       | CSS value | Image right position (mobile)   |
| `field_651d703e96db3` | `top_mt_sec_img`          | text       | CSS value | Image top position (mobile)     |
| `field_651d704296db4` | `bottom_mt_sec_img`       | text       | CSS value | Image bottom position (mobile)  |
| `field_65ca0a9d7c9e6` | `image_opens_in_lightbox` | true_false | 0/1       | Enable lightbox                 |

#### Settings Tab

| Field Key             | Name                      | Type   | Values                                                                         | Description                           |
| --------------------- | ------------------------- | ------ | ------------------------------------------------------------------------------ | ------------------------------------- |
| `field_64d9f1f881910` | `inner_section_max_width` | text   | CSS value                                                                      | Max width of inner section            |
| `field_63448568cb704` | `layout`                  | radio  | `ib-fullwidth`, `ib-custom-width`, `ib-left`, `ib-right`                       | Layout type                           |
| `field_64afeac2c1b68` | `content_custom_width`    | number | 0-100                                                                          | Custom width % (when ib-custom-width) |
| `field_64afed91b6ede` | `content_align`           | radio  | `content-align-left`, `content-align-center`, `content-align-right`            | Content alignment (custom width)      |
| `field_6338282d741de` | `choose_style`            | radio  | `info-box-width-40` to `info-box-width-75`                                     | Info box width (5% increments)        |
| `field_634486f33a083` | `stack`                   | select | `stack-mobile`, `stack-tablet`, `stack-mobile-reverse`, `stack-tablet-reverse` | Mobile stacking behavior              |

#### Background Tab

| Field Key             | Name                             | Type  | Description                  |
| --------------------- | -------------------------------- | ----- | ---------------------------- |
| `field_63494a0141bbd` | `background`                     | clone | Main background (full block) |
| `field_64b7c4da96557` | `inner_section_background_group` | group | Inner section background     |
| `field_64b6812ec43f1` | `intro_background_group`         | group | Intro background             |

#### Spacing Tab

| Field Key             | Name                          | Type  | Description           |
| --------------------- | ----------------------------- | ----- | --------------------- |
| `field_634d6f80709fc` | `spacing`                     | clone | Block-level spacing   |
| `field_64b7c451c5b0a` | `inner_section_spacing_group` | group | Inner section spacing |
| `field_64b2f575da08b` | `intro_spacing_group`         | group | Intro spacing         |

#### Borders Tab

| Field Key             | Name                                       | Type   | Description               |
| --------------------- | ------------------------------------------ | ------ | ------------------------- |
| `field_64ac80041b276` | `image_border_top_left_radius`             | number | Image border radius (px)  |
| `field_64ac80541b277` | `image_border_top_right_radius`            | number | Image border radius (px)  |
| `field_64ac805f1b278` | `image_border_bottom_left_radius`          | number | Image border radius (px)  |
| `field_64ac80721b279` | `image_border_bottom_right_radius`         | number | Image border radius (px)  |
| `field_64b7c612f1750` | `inner_section_border_top_left_radius`     | number | Inner section radius (px) |
| `field_64b7c618f1751` | `inner_section_border_top_right_radius`    | number | Inner section radius (px) |
| `field_64b7c61df1752` | `inner_section_border_bottom_left_radius`  | number | Inner section radius (px) |
| `field_64b7c624f1753` | `inner_section_border_bottom_right_radius` | number | Inner section radius (px) |
| `field_64b429884ccf2` | `intro_border_top_left_radius`             | number | Intro border radius (px)  |
| `field_64b429a24ccf3` | `intro_border_top_right_radius`            | number | Intro border radius (px)  |
| `field_64b429af4ccf4` | `intro_border_bottom_left_radius`          | number | Intro border radius (px)  |
| `field_64b429c34ccf5` | `intro_border_bottom_right_radius`         | number | Intro border radius (px)  |

---

## Columns Block (`acf/columns`)

**ACF Field Group**: `group_63760bb564495` (Block: Info Box Columns)  
**PHP Template**: `blocks/columns/columns.php`  
**SCSS**: `assets/src/sass/blocks/columns.scss`

### Columns Block - Complete ACF Field Reference

#### Intro Tab

| Field Key             | Name                    | Type     | Description                           |
| --------------------- | ----------------------- | -------- | ------------------------------------- |
| `field_637615ef54187` | `columns_intro`         | clone    | Intro content (same as section_intro) |
| `field_67f50493d0883` | `buttons_after_columns` | repeater | Buttons displayed after all columns   |

**Buttons After Columns Repeater Sub-fields**:

| Field Key             | Name                 | Type   | Values                                                                             |
| --------------------- | -------------------- | ------ | ---------------------------------------------------------------------------------- |
| `field_67f50493d0884` | `button`             | link   | Link array                                                                         |
| `field_67f50493d0885` | `button_color`       | select | `button-color-blue`, `button-color-purple`, `button-color-white`                   |
| `field_67f50493d0886` | `button_hover_color` | select | `button-hover-color-blue`, `button-hover-color-purple`, `button-hover-color-white` |

#### Content Tab

| Field Key             | Name            | Type     | Description                 |
| --------------------- | --------------- | -------- | --------------------------- |
| `field_63760bb52814b` | `columns_block` | repeater | Individual columns (min: 2) |

**Columns Repeater Sub-fields**:

| Field Key             | Name           | Type    | Description          |
| --------------------- | -------------- | ------- | -------------------- |
| `field_63760cb08aafd` | `image`        | image   | Column image (ID)    |
| `field_653841e3fada6` | `before_title` | clone   | Before title content |
| `field_63760d518aaff` | `title`        | clone   | Title component      |
| `field_63761797017fa` | `text`         | wysiwyg | Column text content  |
| `field_63761779017f9` | `buttons`      | clone   | Column buttons       |

#### Settings Tab

| Field Key             | Name                                | Type       | Values                                        | Description                               |
| --------------------- | ----------------------------------- | ---------- | --------------------------------------------- | ----------------------------------------- |
| `field_63762db8cb5aa` | `columns_columns`                   | clone      | (Columns component)                           | Column count settings                     |
| `field_64d9f7550e7bc` | `inner_columns_container_max_width` | text       | CSS value                                     | Container max width                       |
| `field_650b741df145b` | `slider_on_mobile_and_tablet`       | true_false | 0/1                                           | Enable Flickity slider on smaller screens |
| `field_64afbf3a57939` | `column_alignment`                  | select     | `align-left`, `align-center`, `align-right`   | Column text alignment                     |
| `field_64afbf555793a` | `text_color`                        | select     | `text-theme-color`, `text-white`, `text-blue` | Column text color                         |
| `field_64afda28cbced` | `text_font_weight`                  | select     | `text-400`, `text-600`, `text-700`            | Column text weight                        |

**Columns Clone Sub-fields** (from `group_634fd64c175f9`):

| Field Key             | Name          | Type   | Values                                                 | Description          |
| --------------------- | ------------- | ------ | ------------------------------------------------------ | -------------------- |
| `field_634bf66c6e4e1` | `columns`     | select | `cols-2`, `cols-3`, `cols-4`, `cols-5`                 | Desktop column count |
| `field_634bfa7a07e68` | `tab_columns` | select | `tab-cols-1`, `tab-cols-2`, `tab-cols-3`, `tab-cols-4` | Tablet column count  |
| `field_634bfabd07e6a` | `mob_columns` | select | `mob-cols-1`, `mob-cols-2`, `mob-cols-3`               | Mobile column count  |

#### Background Tab

| Field Key             | Name                                 | Type  | Description          |
| --------------------- | ------------------------------------ | ----- | -------------------- |
| `field_637616cf54189` | `background`                         | clone | Main background      |
| `field_650cb7601330f` | `columns_container_background_group` | group | Container background |

#### Spacing Tab

| Field Key             | Name                                    | Type  | Description         |
| --------------------- | --------------------------------------- | ----- | ------------------- |
| `field_637616f65418a` | `spacing`                               | clone | Block-level spacing |
| `field_650cb7ec13311` | `inner_columns_container_spacing_group` | group | Container spacing   |

#### Borders Tab

| Field Key             | Name                                  | Type   | Description                  |
| --------------------- | ------------------------------------- | ------ | ---------------------------- |
| `field_650d6b83bde2a` | `col_cont_border_top_left_radius`     | number | Container border radius (px) |
| `field_650d6bf7bde2b` | `col_cont_border_top_right_radius`    | number | Container border radius (px) |
| `field_650d6f6bbde2c` | `col_cont_border_bottom_left_radius`  | number | Container border radius (px) |
| `field_650d6f89bde2d` | `col_cont_border_bottom_right_radius` | number | Container border radius (px) |

---

## Shared Component Field References

These reusable components are cloned into multiple blocks. Understanding their field keys is essential for nested field construction.

### Title Component (`group_633cae39110d7`)

**PHP**: `components/title.php`

| Field Key             | Name                     | Type         | Values                                                                                           | Description                |
| --------------------- | ------------------------ | ------------ | ------------------------------------------------------------------------------------------------ | -------------------------- |
| `field_633cae4546452` | `title`                  | text         | String                                                                                           | Title text                 |
| `field_63447fe3871ab` | `heading_tag`            | select       | `h1`, `h2`, `h3`, `h4`, `h5`, `h6`                                                               | HTML heading tag           |
| `field_64b00f292a45d` | `title_font_size`        | select       | `title-size-1` to `title-size-5`                                                                 | Preset font size           |
| `field_64b454b34aada` | `title_font_weight`      | select       | `title-weight-400`, `title-weight-600`, `title-weight-700`                                       | Font weight                |
| `field_6346ffc1d536b` | `title_color`            | select       | `title-style-1` (White), `title-style-2` (Blue), `title-style-3` (Green), `title-style-4` (Pink) | Title color                |
| `field_64b455fa2d932` | `title_use_custom_style` | true_false   | 0/1                                                                                              | Enable custom styling      |
| `field_634566faeea73` | `title_custom_color`     | color_picker | Hex color                                                                                        | Custom title color         |
| `field_64b457002d933` | `title_font_size_ld`     | text         | CSS value                                                                                        | Custom font size (desktop) |
| `field_64b457222d934` | `title_font_size_mt`     | text         | CSS value                                                                                        | Custom font size (mobile)  |
| `field_64b6824153c85` | `title_margin_bottom_ld` | text         | CSS value                                                                                        | Margin bottom (desktop)    |
| `field_64b685b453c86` | `title_margin_bottom_mt` | text         | CSS value                                                                                        | Margin bottom (mobile)     |

### Subtitle Component (`group_64ae7b8e5d8d2`)

**PHP**: `components/subtitle.php`

| Field Key             | Name                        | Type         | Values                                                                                                       | Description                |
| --------------------- | --------------------------- | ------------ | ------------------------------------------------------------------------------------------------------------ | -------------------------- |
| `field_64ae7b8e72fe2` | `subtitle`                  | text         | String                                                                                                       | Subtitle text              |
| `field_64b016f604510` | `subtitle_font_size`        | select       | `subtitle-size-1`, `subtitle-size-2`, `subtitle-size-3`                                                      | Preset font size           |
| `field_64b511a36efc8` | `subtitle_font_weight`      | select       | `subtitle-weight-400`, `subtitle-weight-500`, `subtitle-weight-600`, `subtitle-weight-700`                   | Font weight                |
| `field_64ae7b8e6b772` | `subtitle_color`            | select       | `subtitle-style-1` (White), `subtitle-style-2` (Blue), `subtitle-style-3` (Green), `subtitle-style-4` (Pink) | Subtitle color             |
| `field_64b5121b50892` | `subtitle_use_custom_style` | true_false   | 0/1                                                                                                          | Enable custom styling      |
| `field_64ae7b8e6f312` | `subtitle_custom_color`     | color_picker | Hex color                                                                                                    | Custom subtitle color      |
| `field_64b5123c50894` | `subtitle_font_size_ld`     | text         | CSS value                                                                                                    | Custom font size (desktop) |
| `field_64b5124750895` | `subtitle_font_size_mt`     | text         | CSS value                                                                                                    | Custom font size (mobile)  |
| `field_64b69150db8ba` | `subtitle_margin_bottom_ld` | text         | CSS value                                                                                                    | Margin bottom (desktop)    |
| `field_64b69165db8bb` | `subtitle_margin_bottom_mt` | text         | CSS value                                                                                                    | Margin bottom (mobile)     |

### Background Component (`group_634949d802e36`)

**PHP**: `components/background.php`

| Field Key             | Name                   | Type         | Values    | Description                  |
| --------------------- | ---------------------- | ------------ | --------- | ---------------------------- |
| `field_63906c48a6adb` | `use_background`       | true_false   | 0/1       | Enable background            |
| `field_6338240f11ade` | `background_color`     | color_picker | Hex color | Background color             |
| `field_64a7de5430724` | `blue_gradient`        | true_false   | 0/1       | Use blue gradient preset     |
| `field_6338240411add` | `background_image`     | image        | ID        | Desktop background image     |
| `field_63906f8e46e8d` | `background_image_mob` | image        | ID        | Mobile background image      |
| `field_64ae8a31e2b03` | `elements`             | repeater     | Array     | Background elements repeater |

**Elements Repeater Sub-fields**:

| Field Key             | Name                         | Type       | Description               |
| --------------------- | ---------------------------- | ---------- | ------------------------- |
| `field_64ae8a3ee2b04` | `element`                    | image      | Element image (array)     |
| `field_64ae8a52e2b05` | `width_ld`                   | text       | Width (desktop)           |
| `field_64ae8a68e2b06` | `height_ld`                  | text       | Height (desktop)          |
| `field_64ae8a70e2b07` | `left_ld`                    | text       | Left position (desktop)   |
| `field_64ae8a75e2b08` | `right_ld`                   | text       | Right position (desktop)  |
| `field_64ae8a7ee2b09` | `top_ld`                     | text       | Top position (desktop)    |
| `field_64ae8a83e2b0a` | `bottom_ld`                  | text       | Bottom position (desktop) |
| `field_6538dd224a52a` | `hide_on_laptop_and_desktop` | true_false | Hide on desktop           |
| `field_64b887f8eface` | `show_on_mobile_and_tablet`  | true_false | Show on mobile            |
| `field_64b88844efad0` | `width_mt`                   | text       | Width (mobile)            |
| `field_64b88879efad1` | `height_mt`                  | text       | Height (mobile)           |
| `field_64b88888efad2` | `left_mt`                    | text       | Left position (mobile)    |
| `field_64b8888befad5` | `right_mt`                   | text       | Right position (mobile)   |
| `field_64b8888aefad4` | `top_mt`                     | text       | Top position (mobile)     |
| `field_64b88889efad3` | `bottom_mt`                  | text       | Bottom position (mobile)  |

### Spacing Component (`group_63494c81e30ef`)

**Used for**: Block-level, inner section, intro, and container spacing

| Field Key             | Name                | Type       | Values                                                                                                    | Description           |
| --------------------- | ------------------- | ---------- | --------------------------------------------------------------------------------------------------------- | --------------------- |
| `field_63494c82c44a1` | `padding`           | select     | `block_space_1` (XS), `block_space_2` (S), `block_space_3` (M), `block_space_4` (L), `block_space_5` (XL) | Preset padding        |
| `field_63494d96c44a2` | `margin`            | select     | `margin-sm`, `margin-md`, `margin-lg`, `margin-xl`                                                        | Bottom margin         |
| `field_64b2e129e2cd4` | `custom_padding`    | true_false | 0/1                                                                                                       | Enable custom padding |
| `field_64b2e187e2cd6` | `custom_padding_ld` | group      | -                                                                                                         | Desktop padding group |
| `field_64b2ed3ce6b65` | `custom_padding_mt` | group      | -                                                                                                         | Mobile padding group  |

**Custom Padding Sub-fields (Desktop - `custom_padding_ld`)**:

| Field Key             | Name             | Description                |
| --------------------- | ---------------- | -------------------------- |
| `field_64b2e18ce2cd7` | `padding_top`    | Top padding (CSS value)    |
| `field_64b2e1f4e2cd9` | `padding_bottom` | Bottom padding (CSS value) |
| `field_64b2e1fee2cda` | `padding_left`   | Left padding (CSS value)   |
| `field_64b2e227e2cdb` | `padding_right`  | Right padding (CSS value)  |

**Custom Padding Sub-fields (Mobile - `custom_padding_mt`)**:

| Field Key             | Name             | Description                |
| --------------------- | ---------------- | -------------------------- |
| `field_64b2ed3ce6b66` | `padding_top`    | Top padding (CSS value)    |
| `field_64b2ed3ce6b67` | `padding_bottom` | Bottom padding (CSS value) |
| `field_64b2ed3ce6b68` | `padding_left`   | Left padding (CSS value)   |
| `field_64b2ed3ce6b69` | `padding_right`  | Right padding (CSS value)  |

### Buttons Component (`group_63499d76f1b93`)

**PHP**: `components/buttons.php`

| Field Key             | Name      | Type     | Description      |
| --------------------- | --------- | -------- | ---------------- |
| `field_634939bd22865` | `buttons` | repeater | Buttons repeater |

**Buttons Repeater Sub-fields**:

| Field Key             | Name                 | Type   | Values                                                                             | Description  |
| --------------------- | -------------------- | ------ | ---------------------------------------------------------------------------------- | ------------ |
| `field_634939c822866` | `button`             | link   | Link array (url, title, target)                                                    | Button link  |
| `field_64af3738cf78f` | `button_color`       | select | `button-color-blue`, `button-color-purple`, `button-color-white`                   | Button color |
| `field_64af37cacf790` | `button_hover_color` | select | `button-hover-color-blue`, `button-hover-color-purple`, `button-hover-color-white` | Hover color  |

### Intro Component (`group_6346f6d3b3fa8`)

**PHP**: `components/intro.php`

This component combines Title, Subtitle, Buttons, and text fields. When cloned into a block, it creates the `section_intro` or `columns_intro` group.

| Field Key             | Name                    | Type       | Description            |
| --------------------- | ----------------------- | ---------- | ---------------------- |
| `field_64b0098c6aada` | `image_before_content`  | image      | Image before title     |
| `field_65358cb8745ca` | `before_title`          | clone      | Before title component |
| `field_6346f6d37f098` | `title`                 | clone      | Title component        |
| `field_64ae7d0cd8195` | `subtitle`              | clone      | Subtitle component     |
| `field_63c7c882cbc4d` | `intro_text_color`      | radio      | Text color             |
| `field_63c7cb8e8cc91` | `intro_alignment`       | radio      | Alignment              |
| `field_64b694fff387a` | `text_use_custom_style` | true_false | Custom style toggle    |
| `field_64b6957b7c2f2` | `text_margin_bottom_ld` | text       | Text margin (desktop)  |
| `field_64b695a67c2f3` | `text_margin_bottom_mt` | text       | Text margin (mobile)   |
| `field_64b152d2049c2` | `list_columns`          | radio      | List layout            |
| `field_6346f7017f099` | `intro_text`            | wysiwyg    | Main text content      |
| `field_64af241aef5c2` | `intro_buttons`         | clone      | Buttons component      |
| `field_64b00cbb3e6c2` | `image_after_content`   | image      | Image after content    |

---

## CSS Class Reference

### Section Block Classes

**Source**: `blocks/section/section.php` + `assets/src/sass/blocks/section.scss`

#### Wrapper Classes

| Class               | Applied To | Source | Purpose                    |
| ------------------- | ---------- | ------ | -------------------------- |
| `.il_block`         | outer div  | PHP    | Base block class           |
| `.il_section`       | outer div  | PHP    | Section-specific class     |
| `.il_section_inner` | inner div  | PHP    | Inner wrapper with flexbox |
| `.container`        | inner div  | PHP    | Width constraint           |

#### Layout Classes

| Class              | Applied To          | ACF Field | Purpose                   |
| ------------------ | ------------------- | --------- | ------------------------- |
| `.ib-left`         | `.il_section_inner` | `layout`  | Image left, content right |
| `.ib-right`        | `.il_section_inner` | `layout`  | Image right, content left |
| `.ib-fullwidth`    | `.il_section_inner` | `layout`  | Full width, no image      |
| `.ib-custom-width` | `.il_section_inner` | `layout`  | Custom content width      |

#### Width Classes

| Class                | Applied To  | ACF Field      | Effect                 |
| -------------------- | ----------- | -------------- | ---------------------- |
| `.info-box-width-40` | `.il_block` | `choose_style` | Intro: 38%, Image: 58% |
| `.info-box-width-45` | `.il_block` | `choose_style` | Intro: 43%, Image: 53% |
| `.info-box-width-50` | `.il_block` | `choose_style` | Intro: 48%, Image: 48% |
| `.info-box-width-55` | `.il_block` | `choose_style` | Intro: 53%, Image: 43% |
| `.info-box-width-60` | `.il_block` | `choose_style` | Intro: 58%, Image: 38% |
| `.info-box-width-65` | `.il_block` | `choose_style` | Intro: 63%, Image: 33% |
| `.info-box-width-70` | `.il_block` | `choose_style` | Intro: 68%, Image: 28% |
| `.info-box-width-75` | `.il_block` | `choose_style` | Intro: 73%, Image: 23% |

#### Stack Classes (Responsive)

| Class                   | Applied To          | ACF Field | Behavior                   |
| ----------------------- | ------------------- | --------- | -------------------------- |
| `.stack-mobile`         | `.il_section_inner` | `stack`   | Stack at mobile breakpoint |
| `.stack-tablet`         | `.il_section_inner` | `stack`   | Stack at tablet breakpoint |
| `.stack-mobile-reverse` | `.il_section_inner` | `stack`   | Stack reversed at mobile   |
| `.stack-tablet-reverse` | `.il_section_inner` | `stack`   | Stack reversed at tablet   |

#### Content Alignment Classes

| Class                   | Applied To          | ACF Field       | Purpose                             |
| ----------------------- | ------------------- | --------------- | ----------------------------------- |
| `.content-align-left`   | `.il_section_inner` | `content_align` | Align content left (custom width)   |
| `.content-align-center` | `.il_section_inner` | `content_align` | Align content center (custom width) |
| `.content-align-right`  | `.il_section_inner` | `content_align` | Align content right (custom width)  |

#### Section Elements

| Class                    | Element          | Purpose                                    |
| ------------------------ | ---------------- | ------------------------------------------ |
| `.il_block_intro`        | Intro container  | Contains title, subtitle, text, buttons    |
| `.right`                 | Image container  | Contains media image in two-column layouts |
| `.il_block_bg`           | Background layer | Absolute positioned background             |
| `.sec_desk_img`          | Desktop image    | Desktop image class                        |
| `.sec_mob_img`           | Mobile image     | Mobile image class                         |
| `.hide_sec_desk_img_mob` | Desktop image    | Hide desktop image on mobile               |

### Columns Block Classes

**Source**: `blocks/columns/columns.php` + `assets/src/sass/blocks/columns.scss`

#### Wrapper Classes

| Class                   | Applied To      | Source | Purpose                       |
| ----------------------- | --------------- | ------ | ----------------------------- |
| `.il_block`             | outer div       | PHP    | Base block class              |
| `.il_columns`           | outer div       | PHP    | Columns-specific class        |
| `.il_columns_container` | inner div       | PHP    | Container with background     |
| `.container`            | inner div       | PHP    | Width constraint              |
| `.il_columns_inner`     | columns wrapper | PHP    | Flexbox container for columns |

#### Column Count Classes (Desktop)

| Class     | Applied To  | ACF Field | Effect    |
| --------- | ----------- | --------- | --------- |
| `.cols-2` | `.il_block` | `columns` | 2 columns |
| `.cols-3` | `.il_block` | `columns` | 3 columns |
| `.cols-4` | `.il_block` | `columns` | 4 columns |
| `.cols-5` | `.il_block` | `columns` | 5 columns |

#### Column Count Classes (Tablet)

| Class         | Applied To  | ACF Field     | Effect              |
| ------------- | ----------- | ------------- | ------------------- |
| `.tab-cols-1` | `.il_block` | `tab_columns` | 1 column on tablet  |
| `.tab-cols-2` | `.il_block` | `tab_columns` | 2 columns on tablet |
| `.tab-cols-3` | `.il_block` | `tab_columns` | 3 columns on tablet |
| `.tab-cols-4` | `.il_block` | `tab_columns` | 4 columns on tablet |

#### Column Count Classes (Mobile)

| Class         | Applied To  | ACF Field     | Effect              |
| ------------- | ----------- | ------------- | ------------------- |
| `.mob-cols-1` | `.il_block` | `mob_columns` | 1 column on mobile  |
| `.mob-cols-2` | `.il_block` | `mob_columns` | 2 columns on mobile |
| `.mob-cols-3` | `.il_block` | `mob_columns` | 3 columns on mobile |

#### Column Inner Classes

| Class               | Applied To          | ACF Field          | Purpose               |
| ------------------- | ------------------- | ------------------ | --------------------- |
| `.align-left`       | `.il_columns_inner` | `column_alignment` | Left text alignment   |
| `.align-center`     | `.il_columns_inner` | `column_alignment` | Center text alignment |
| `.align-right`      | `.il_columns_inner` | `column_alignment` | Right text alignment  |
| `.text-theme-color` | `.il_columns_inner` | `text_color`       | Theme color text      |
| `.text-white`       | `.il_columns_inner` | `text_color`       | White text            |
| `.text-blue`        | `.il_columns_inner` | `text_color`       | Blue text             |
| `.text-400`         | `.il_columns_inner` | `text_font_weight` | Regular weight        |
| `.text-600`         | `.il_columns_inner` | `text_font_weight` | Semi-bold weight      |
| `.text-700`         | `.il_columns_inner` | `text_font_weight` | Bold weight           |

#### Column Elements

| Class                    | Element         | Purpose                    |
| ------------------------ | --------------- | -------------------------- |
| `.column` / `.il_col`    | Column item     | Individual column wrapper  |
| `.il_col_text`           | Text container  | Text content within column |
| `.buttons`               | Buttons wrapper | Buttons container          |
| `.buttons-after-columns` | Buttons wrapper | Buttons after all columns  |

#### Special Classes

| Class                  | Applied To  | ACF Field                     | Purpose                                 |
| ---------------------- | ----------- | ----------------------------- | --------------------------------------- |
| `.flickity-on-smaller` | `.il_block` | `slider_on_mobile_and_tablet` | Enable Flickity slider on mobile/tablet |

### Shared Classes (Both Blocks)

#### Spacing Classes

| Class            | Source            | ACF Field | Purpose                   |
| ---------------- | ----------------- | --------- | ------------------------- |
| `.block_space_1` | Spacing component | `padding` | Extra small padding       |
| `.block_space_2` | Spacing component | `padding` | Small padding             |
| `.block_space_3` | Spacing component | `padding` | Medium padding            |
| `.block_space_4` | Spacing component | `padding` | Large padding             |
| `.block_space_5` | Spacing component | `padding` | Extra large padding       |
| `.margin-sm`     | Spacing component | `margin`  | Small margin bottom       |
| `.margin-md`     | Spacing component | `margin`  | Medium margin bottom      |
| `.margin-lg`     | Spacing component | `margin`  | Large margin bottom       |
| `.margin-xl`     | Spacing component | `margin`  | Extra large margin bottom |

#### Intro Classes

| Class             | Element         | Purpose              |
| ----------------- | --------------- | -------------------- |
| `.il_block_intro` | Intro container | Main intro wrapper   |
| `.intro_title`    | Title           | Title element        |
| `.intro_subtitle` | Subtitle        | Subtitle element     |
| `.intro_text`     | Text            | Text content element |
| `.buttons`        | Buttons wrapper | Buttons container    |
| `.il_btn`         | Button          | Individual button    |

#### Title Classes

| Class               | Source          | ACF Field           | Purpose          |
| ------------------- | --------------- | ------------------- | ---------------- |
| `.title-size-1`     | Title component | `title_font_size`   | Title size 1     |
| `.title-size-2`     | Title component | `title_font_size`   | Title size 2     |
| `.title-size-3`     | Title component | `title_font_size`   | Title size 3     |
| `.title-size-4`     | Title component | `title_font_size`   | Title size 4     |
| `.title-size-5`     | Title component | `title_font_size`   | Title size 5     |
| `.title-weight-400` | Title component | `title_font_weight` | Regular weight   |
| `.title-weight-600` | Title component | `title_font_weight` | Semi-bold weight |
| `.title-weight-700` | Title component | `title_font_weight` | Bold weight      |
| `.title-style-1`    | Title component | `title_color`       | White color      |
| `.title-style-2`    | Title component | `title_color`       | Blue color       |
| `.title-style-3`    | Title component | `title_color`       | Green color      |
| `.title-style-4`    | Title component | `title_color`       | Pink color       |

#### Subtitle Classes

| Class                  | Source             | ACF Field              | Purpose          |
| ---------------------- | ------------------ | ---------------------- | ---------------- |
| `.subtitle-size-1`     | Subtitle component | `subtitle_font_size`   | Subtitle size 1  |
| `.subtitle-size-2`     | Subtitle component | `subtitle_font_size`   | Subtitle size 2  |
| `.subtitle-size-3`     | Subtitle component | `subtitle_font_size`   | Subtitle size 3  |
| `.subtitle-weight-400` | Subtitle component | `subtitle_font_weight` | Regular weight   |
| `.subtitle-weight-500` | Subtitle component | `subtitle_font_weight` | Medium weight    |
| `.subtitle-weight-600` | Subtitle component | `subtitle_font_weight` | Semi-bold weight |
| `.subtitle-weight-700` | Subtitle component | `subtitle_font_weight` | Bold weight      |
| `.subtitle-style-1`    | Subtitle component | `subtitle_color`       | White color      |
| `.subtitle-style-2`    | Subtitle component | `subtitle_color`       | Blue color       |
| `.subtitle-style-3`    | Subtitle component | `subtitle_color`       | Green color      |
| `.subtitle-style-4`    | Subtitle component | `subtitle_color`       | Pink color       |

#### Button Classes

| Class                        | Source            | ACF Field            | Purpose           |
| ---------------------------- | ----------------- | -------------------- | ----------------- |
| `.il_btn`                    | Buttons component | -                    | Base button class |
| `.button-color-blue`         | Buttons component | `button_color`       | Blue button       |
| `.button-color-purple`       | Buttons component | `button_color`       | Purple button     |
| `.button-color-white`        | Buttons component | `button_color`       | White button      |
| `.button-hover-color-blue`   | Buttons component | `button_hover_color` | Blue hover        |
| `.button-hover-color-purple` | Buttons component | `button_hover_color` | Purple hover      |
| `.button-hover-color-white`  | Buttons component | `button_hover_color` | White hover       |

#### Background Classes

| Class               | Element              | Purpose                       |
| ------------------- | -------------------- | ----------------------------- |
| `.il_block_bg`      | Background container | Background wrapper            |
| `.desk_bg`          | Desktop background   | Desktop background image      |
| `.mob_bg`           | Mobile background    | Mobile background image       |
| `.hide_desk_bg_mob` | Desktop background   | Hide desktop bg on mobile     |
| `.bg_element`       | Background element   | Positioned background element |

---

## CSS Variables Reference

CSS variables are set dynamically from ACF fields via inline styles and consumed by SCSS.

### Section Block Variables

**Block-Level Spacing** (set on `.il_block.il_section`):

| Variable              | Source Field                       | Breakpoint    | Purpose              |
| --------------------- | ---------------------------------- | ------------- | -------------------- |
| `--b-space-top-ld`    | `custom_padding_ld.padding_top`    | Desktop       | Block padding top    |
| `--b-space-bottom-ld` | `custom_padding_ld.padding_bottom` | Desktop       | Block padding bottom |
| `--b-space-left-ld`   | `custom_padding_ld.padding_left`   | Desktop       | Block padding left   |
| `--b-space-right-ld`  | `custom_padding_ld.padding_right`  | Desktop       | Block padding right  |
| `--b-space-top-mt`    | `custom_padding_mt.padding_top`    | Mobile/Tablet | Block padding top    |
| `--b-space-bottom-mt` | `custom_padding_mt.padding_bottom` | Mobile/Tablet | Block padding bottom |
| `--b-space-left-mt`   | `custom_padding_mt.padding_left`   | Mobile/Tablet | Block padding left   |
| `--b-space-right-mt`  | `custom_padding_mt.padding_right`  | Mobile/Tablet | Block padding right  |

**Inner Section Spacing** (set on `.il_section_inner`):

| Variable                        | Source Field                   | Breakpoint    | Purpose                      |
| ------------------------------- | ------------------------------ | ------------- | ---------------------------- |
| `--b-inner-sec-space-top-ld`    | Inner section `padding_top`    | Desktop       | Inner section padding top    |
| `--b-inner-sec-space-bottom-ld` | Inner section `padding_bottom` | Desktop       | Inner section padding bottom |
| `--b-inner-sec-space-left-ld`   | Inner section `padding_left`   | Desktop       | Inner section padding left   |
| `--b-inner-sec-space-right-ld`  | Inner section `padding_right`  | Desktop       | Inner section padding right  |
| `--b-inner-sec-space-top-mt`    | Inner section `padding_top`    | Mobile/Tablet | Inner section padding top    |
| `--b-inner-sec-space-bottom-mt` | Inner section `padding_bottom` | Mobile/Tablet | Inner section padding bottom |
| `--b-inner-sec-space-left-mt`   | Inner section `padding_left`   | Mobile/Tablet | Inner section padding left   |
| `--b-inner-sec-space-right-mt`  | Inner section `padding_right`  | Mobile/Tablet | Inner section padding right  |

**Max Width** (set on `.il_section_inner`):

| Variable                | Source Field              | Purpose                                                   |
| ----------------------- | ------------------------- | --------------------------------------------------------- |
| `--custom-max-width-ld` | `inner_section_max_width` | Inner section max width (defaults to `var(--site-width)`) |

**Image Positioning** (set on `.right img` and `.bg_element`):

| Variable                 | Source Field                               | Breakpoint    | Purpose          |
| ------------------------ | ------------------------------------------ | ------------- | ---------------- |
| `--bg-e-width-lg`        | `width_ld_sec_img` or element `width_ld`   | Desktop       | Element width    |
| `--bg-e-height-lg`       | `height_ld_sec_img` or element `height_ld` | Desktop       | Element height   |
| `--bg-e-left-lg`         | `left_ld_sec_img` or element `left_ld`     | Desktop       | Left margin      |
| `--bg-e-right-lg`        | `right_ld_sec_img` or element `right_ld`   | Desktop       | Right margin     |
| `--bg-e-top-lg`          | `top_ld_sec_img` or element `top_ld`       | Desktop       | Top margin       |
| `--bg-e-bottom-lg`       | `bottom_ld_sec_img` or element `bottom_ld` | Desktop       | Bottom margin    |
| `--bg-e-width-mt`        | `width_mt_sec_img` or element `width_mt`   | Mobile/Tablet | Element width    |
| `--bg-e-height-mt`       | `height_mt_sec_img` or element `height_mt` | Mobile/Tablet | Element height   |
| `--bg-e-left-mt`         | `left_mt_sec_img` or element `left_mt`     | Mobile/Tablet | Left margin      |
| `--bg-e-right-mt`        | `right_mt_sec_img` or element `right_mt`   | Mobile/Tablet | Right margin     |
| `--bg-e-top-mt`          | `top_mt_sec_img` or element `top_mt`       | Mobile/Tablet | Top margin       |
| `--bg-e-bottom-mt`       | `bottom_mt_sec_img` or element `bottom_mt` | Mobile/Tablet | Bottom margin    |
| `--bg-e-display-desktop` | `hide_on_laptop_and_desktop`               | Desktop       | Display property |
| `--bg-e-display-mobile`  | `show_on_mobile_and_tablet`                | Mobile        | Display property |

### Columns Block Variables

**Block-Level Spacing** (set on `.il_block.il_columns`):

| Variable                      | Source Field                       | Breakpoint    | Purpose              |
| ----------------------------- | ---------------------------------- | ------------- | -------------------- |
| `--b-columns-space-top-ld`    | `custom_padding_ld.padding_top`    | Desktop       | Block padding top    |
| `--b-columns-space-bottom-ld` | `custom_padding_ld.padding_bottom` | Desktop       | Block padding bottom |
| `--b-columns-space-left-ld`   | `custom_padding_ld.padding_left`   | Desktop       | Block padding left   |
| `--b-columns-space-right-ld`  | `custom_padding_ld.padding_right`  | Desktop       | Block padding right  |
| `--b-columns-space-top-mt`    | `custom_padding_mt.padding_top`    | Mobile/Tablet | Block padding top    |
| `--b-columns-space-bottom-mt` | `custom_padding_mt.padding_bottom` | Mobile/Tablet | Block padding bottom |
| `--b-columns-space-left-mt`   | `custom_padding_mt.padding_left`   | Mobile/Tablet | Block padding left   |
| `--b-columns-space-right-mt`  | `custom_padding_mt.padding_right`  | Mobile/Tablet | Block padding right  |

**Container Spacing** (set on `.il_columns_container`):

| Variable                             | Source Field                     | Breakpoint    | Purpose                  |
| ------------------------------------ | -------------------------------- | ------------- | ------------------------ |
| `--b-col-inner-cont-space-top-ld`    | Inner container `padding_top`    | Desktop       | Container padding top    |
| `--b-col-inner-cont-space-bottom-ld` | Inner container `padding_bottom` | Desktop       | Container padding bottom |
| `--b-col-inner-cont-space-left-ld`   | Inner container `padding_left`   | Desktop       | Container padding left   |
| `--b-col-inner-cont-space-right-ld`  | Inner container `padding_right`  | Desktop       | Container padding right  |
| `--b-col-inner-cont-space-top-mt`    | Inner container `padding_top`    | Mobile/Tablet | Container padding top    |
| `--b-col-inner-cont-space-bottom-mt` | Inner container `padding_bottom` | Mobile/Tablet | Container padding bottom |
| `--b-col-inner-cont-space-left-mt`   | Inner container `padding_left`   | Mobile/Tablet | Container padding left   |
| `--b-col-inner-cont-space-right-mt`  | Inner container `padding_right`  | Mobile/Tablet | Container padding right  |

**Max Width** (set on `.il_columns_container`):

| Variable                | Source Field                        | Purpose                                               |
| ----------------------- | ----------------------------------- | ----------------------------------------------------- |
| `--custom-max-width-ld` | `inner_columns_container_max_width` | Container max width (defaults to `var(--site-width)`) |

### Intro Variables

**Text Margin** (set on `.intro_text`):

| Variable                  | Source Field            | Breakpoint    | Purpose            |
| ------------------------- | ----------------------- | ------------- | ------------------ |
| `--text_margin_bottom_ld` | `text_margin_bottom_ld` | Desktop       | Text bottom margin |
| `--text_margin_bottom_mt` | `text_margin_bottom_mt` | Mobile/Tablet | Text bottom margin |

**Title Custom Font Size** (set on `.intro_title`):

| Variable              | Source Field         | Breakpoint    | Purpose                |
| --------------------- | -------------------- | ------------- | ---------------------- |
| `--title-size-{n}-ld` | `title_font_size_ld` | Desktop       | Custom title font size |
| `--title-size-{n}-mt` | `title_font_size_mt` | Mobile/Tablet | Custom title font size |

**Title Margin** (set on `.intro_title`):

| Variable                   | Source Field             | Breakpoint    | Purpose             |
| -------------------------- | ------------------------ | ------------- | ------------------- |
| `--title_margin_bottom_ld` | `title_margin_bottom_ld` | Desktop       | Title bottom margin |
| `--title_margin_bottom_mt` | `title_margin_bottom_mt` | Mobile/Tablet | Title bottom margin |

### Responsive Breakpoint Mixins

These SCSS mixins are used throughout the theme for responsive styling:

| Mixin                | Purpose          | Use Case               |
| -------------------- | ---------------- | ---------------------- |
| `@include limbo-max` | Tablet and below | Mobile/tablet styles   |
| `@include limbo-min` | Tablet and above | Desktop styles         |
| `@include desk-min`  | Desktop only     | Desktop-only styles    |
| `@include desk-max`  | Below desktop    | Non-desktop styles     |
| `@include tab-max`   | Mobile only      | Mobile-specific styles |
| `@include mob-only`  | Mobile portrait  | Smallest screens       |

**Usage Example**:

```scss
.il_block.il_section {
  // Desktop styles (default)
  padding-top: var(--b-space-top-ld);

  // Mobile/Tablet styles
  @include limbo-max {
    padding-top: var(--b-space-top-mt);
  }
}
```

---

## HTML Structure Reference

### Section Block DOM Structure

```
<!-- Two-Column Layout (ib-left or ib-right) -->
<div class="il_block il_section {className} {choose_style} {margin} {padding}"
     style="--b-space-top-ld: X; --b-space-bottom-ld: X; ...">

  <!-- Background Component -->
  <div class="il_block_bg" style="background-color: X">
    <img class="desk_bg {hide_desk_bg_mob}" />
    <img class="mob_bg" />
    <img class="bg_element" style="--bg-e-width-lg: X; ..." />
  </div>

  <!-- Inner Section -->
  <div class="il_section_inner container {layout} {stack} {content_align}"
       style="--custom-max-width-ld: X; --b-inner-sec-space-top-ld: X; ...">

    <!-- Inner Section Background (decorative) -->
    <div class="il_block_bg">
      <!-- Same structure as main background -->
    </div>

    <!-- Intro Component -->
    <div class="il_block_intro {intro_alignment} {list_columns} {intro_padding}">

      <!-- Intro Background -->
      <div class="il_block_bg">...</div>

      <!-- Image Before Content -->
      <div class="image-before-content {alignment}">
        <img />
      </div>

      <!-- Before Title -->
      <div class="before_title">...</div>

      <!-- Title -->
      <h2 class="intro_title {title_color} {title_font_size} {title_font_weight}"
          style="color: X; --title-size-2-ld: X; ...">
        Title Text
      </h2>

      <!-- Subtitle -->
      <p class="intro_subtitle {subtitle_color} {subtitle_font_size} {subtitle_font_weight}">
        Subtitle Text
      </p>

      <!-- Text -->
      <div class="intro_text {text_color}"
           style="--text_margin_bottom_ld: X; ...">
        <p>Content text...</p>
      </div>

      <!-- Buttons -->
      <div class="buttons">
        <a class="il_btn {button_color} {button_hover_color}" href="...">
          Button Text
        </a>
      </div>

      <!-- Image After Content -->
      <div class="image_after_content {alignment}">
        <img />
      </div>
    </div>

    <!-- Right (Image Container) - Only for ib-left/ib-right layouts -->
    <div class="right">
      <img class="sec_desk_img {hide_sec_desk_img_mob}"
           style="--bg-e-width-lg: X; --bg-e-height-lg: X; ..."
           data-fancybox="image-single" />
      <img class="sec_mob_img"
           style="--bg-e-width-mt: X; ..." />
    </div>

  </div>
</div>
```

### Columns Block DOM Structure

```
<div class="il_block il_columns {className} {cols} {tab_cols} {mob_cols} {margin} {padding} {flickity-on-smaller}"
     style="--b-columns-space-top-ld: X; ...">

  <!-- Background Component -->
  <div class="il_block_bg" style="background-color: X">
    <img class="desk_bg {hide_desk_bg_mob}" />
    <img class="mob_bg" />
    <img class="bg_element" style="--bg-e-width-lg: X; ..." />
  </div>

  <!-- Columns Container -->
  <div class="il_columns_container container {container_padding}"
       style="--custom-max-width-ld: X; --b-col-inner-cont-space-top-ld: X; ...">

    <!-- Container Background -->
    <div class="il_block_bg">...</div>

    <!-- Intro Component (same as Section) -->
    <div class="il_block_intro {intro_alignment}">
      <h2 class="intro_title ...">Title</h2>
      <p class="intro_subtitle ...">Subtitle</p>
      <div class="intro_text ...">Text</div>
      <div class="buttons">...</div>
    </div>

    <!-- Columns Inner -->
    <div class="il_columns_inner {column_alignment} {text_color} {text_font_weight}">

      <!-- Column (repeater item) -->
      <div class="il_col column">
        <img />

        <!-- Before Title -->
        <div class="before_title">...</div>

        <!-- Title (nested) -->
        <h3 class="intro_title {title_color} {title_font_size} {title_font_weight}">
          Column Title
        </h3>

        <!-- Text -->
        <div class="il_col_text">
          <p>Column text content...</p>
        </div>

        <!-- Buttons -->
        <div class="buttons">
          <a class="il_btn {button_color} {button_hover_color}" href="...">
            Button
          </a>
        </div>
      </div>

      <!-- More columns... -->
      <div class="il_col column">...</div>
      <div class="il_col column">...</div>

    </div>

    <!-- Buttons After Columns -->
    <div class="buttons buttons-after-columns">
      <a class="il_btn {button_color} {button_hover_color}" href="...">
        Global Button
      </a>
    </div>

  </div>
</div>
```

### Key Element Relationships

**Section Block Flow**:

```
.il_block.il_section
└── .il_block_bg (main background)
└── .il_section_inner.container
    └── .il_block_bg (inner background)
    └── .il_block_intro
        └── .intro_title
        └── .intro_subtitle
        └── .intro_text
        └── .buttons > .il_btn
    └── .right (image container)
        └── img.sec_desk_img
        └── img.sec_mob_img
```

**Columns Block Flow**:

```
.il_block.il_columns
└── .il_block_bg (main background)
└── .il_columns_container.container
    └── .il_block_bg (container background)
    └── .il_block_intro
        └── (same as section intro)
    └── .il_columns_inner
        └── .il_col.column (repeated)
            └── img
            └── .intro_title
            └── .il_col_text
            └── .buttons > .il_btn
    └── .buttons-after-columns > .il_btn
```

---

## Nested Field Key Construction

Understanding how to construct nested field keys is critical for Figma-to-WordPress conversions.

### Key Construction Pattern

When ACF clones a field group, nested fields require compound keys:

```
{parent_clone_field}_{child_clone_field}_{actual_field}
```

### Section Block - Complete Nested Key Examples

#### Title Fields (3 levels deep)

**Path**: `section_intro` → `title` → `title field`

```
Parent Clone: field_6338223792cfe (section_intro)
    └── Child Clone: field_6346f6d37f098 (title)
        └── Actual Field: field_633cae4546452 (title text)

Full Key: field_6338223792cfe_field_6346f6d37f098_field_633cae4546452
```

**All Title Fields**:
| Field | Nested Key |
|-------|------------|
| Title text | `field_6338223792cfe_field_6346f6d37f098_field_633cae4546452` |
| Title tag | `field_6338223792cfe_field_6346f6d37f098_field_63447fe3871ab` |
| Title font size | `field_6338223792cfe_field_6346f6d37f098_field_64b00f292a45d` |
| Title font weight | `field_6338223792cfe_field_6346f6d37f098_field_64b454b34aada` |
| Title color | `field_6338223792cfe_field_6346f6d37f098_field_6346ffc1d536b` |
| Use custom style | `field_6338223792cfe_field_6346f6d37f098_field_64b455fa2d932` |
| Custom color | `field_6338223792cfe_field_6346f6d37f098_field_634566faeea73` |
| Font size (desktop) | `field_6338223792cfe_field_6346f6d37f098_field_64b457002d933` |
| Font size (mobile) | `field_6338223792cfe_field_6346f6d37f098_field_64b457222d934` |
| Margin bottom (desktop) | `field_6338223792cfe_field_6346f6d37f098_field_64b6824153c85` |
| Margin bottom (mobile) | `field_6338223792cfe_field_6346f6d37f098_field_64b685b453c86` |

#### Subtitle Fields (3 levels deep)

**Path**: `section_intro` → `subtitle` → `subtitle field`

```
Parent Clone: field_6338223792cfe (section_intro)
    └── Child Clone: field_64ae7d0cd8195 (subtitle)
        └── Actual Field: field_64ae7b8e72fe2 (subtitle text)

Full Key: field_6338223792cfe_field_64ae7d0cd8195_field_64ae7b8e72fe2
```

**All Subtitle Fields**:
| Field | Nested Key |
|-------|------------|
| Subtitle text | `field_6338223792cfe_field_64ae7d0cd8195_field_64ae7b8e72fe2` |
| Subtitle font size | `field_6338223792cfe_field_64ae7d0cd8195_field_64b016f604510` |
| Subtitle font weight | `field_6338223792cfe_field_64ae7d0cd8195_field_64b511a36efc8` |
| Subtitle color | `field_6338223792cfe_field_64ae7d0cd8195_field_64ae7b8e6b772` |
| Use custom style | `field_6338223792cfe_field_64ae7d0cd8195_field_64b5121b50892` |
| Custom color | `field_6338223792cfe_field_64ae7d0cd8195_field_64ae7b8e6f312` |
| Font size (desktop) | `field_6338223792cfe_field_64ae7d0cd8195_field_64b5123c50894` |
| Font size (mobile) | `field_6338223792cfe_field_64ae7d0cd8195_field_64b5124750895` |
| Margin bottom (desktop) | `field_6338223792cfe_field_64ae7d0cd8195_field_64b69150db8ba` |
| Margin bottom (mobile) | `field_6338223792cfe_field_64ae7d0cd8195_field_64b69165db8bb` |

#### Intro Direct Fields (2 levels deep)

**Path**: `section_intro` → `direct field`

| Field                   | Nested Key                                |
| ----------------------- | ----------------------------------------- |
| Intro text              | `field_6338223792cfe_field_6346f7017f099` |
| Text color              | `field_6338223792cfe_field_63c7c882cbc4d` |
| Alignment               | `field_6338223792cfe_field_63c7cb8e8cc91` |
| Image before content    | `field_6338223792cfe_field_64b0098c6aada` |
| Image after content     | `field_6338223792cfe_field_64b00cbb3e6c2` |
| Use custom style (text) | `field_6338223792cfe_field_64b694fff387a` |
| Text margin (desktop)   | `field_6338223792cfe_field_64b6957b7c2f2` |
| Text margin (mobile)    | `field_6338223792cfe_field_64b695a67c2f3` |
| List columns            | `field_6338223792cfe_field_64b152d2049c2` |

#### Background Fields (2 levels deep)

**Path**: `background` → `background field`

| Field             | Nested Key                                |
| ----------------- | ----------------------------------------- |
| Use background    | `field_63494a0141bbd_field_63906c48a6adb` |
| Background color  | `field_63494a0141bbd_field_6338240f11ade` |
| Blue gradient     | `field_63494a0141bbd_field_64a7de5430724` |
| Background image  | `field_63494a0141bbd_field_6338240411add` |
| Mobile background | `field_63494a0141bbd_field_63906f8e46e8d` |
| Elements repeater | `field_63494a0141bbd_field_64ae8a31e2b03` |

#### Spacing Fields (2-3 levels deep)

**Path**: `spacing` → `spacing field` or `spacing` → `custom_padding_ld` → `padding field`

| Field                  | Nested Key                                                    |
| ---------------------- | ------------------------------------------------------------- |
| Padding preset         | `field_634d6f80709fc_field_63494c82c44a1`                     |
| Margin                 | `field_634d6f80709fc_field_63494d96c44a2`                     |
| Custom padding toggle  | `field_634d6f80709fc_field_64b2e129e2cd4`                     |
| Desktop padding top    | `field_634d6f80709fc_field_64b2e187e2cd6_field_64b2e18ce2cd7` |
| Desktop padding bottom | `field_634d6f80709fc_field_64b2e187e2cd6_field_64b2e1f4e2cd9` |
| Desktop padding left   | `field_634d6f80709fc_field_64b2e187e2cd6_field_64b2e1fee2cda` |
| Desktop padding right  | `field_634d6f80709fc_field_64b2e187e2cd6_field_64b2e227e2cdb` |
| Mobile padding top     | `field_634d6f80709fc_field_64b2ed3ce6b65_field_64b2ed3ce6b66` |
| Mobile padding bottom  | `field_634d6f80709fc_field_64b2ed3ce6b65_field_64b2ed3ce6b67` |
| Mobile padding left    | `field_634d6f80709fc_field_64b2ed3ce6b65_field_64b2ed3ce6b68` |
| Mobile padding right   | `field_634d6f80709fc_field_64b2ed3ce6b65_field_64b2ed3ce6b69` |

### Complete Section Block JSON Example

```json
{
  "name": "acf/section",
  "data": {
    // === INTRO GROUP ===
    "field_6338223792cfe": {
      // Title
      "field_6338223792cfe_field_6346f6d37f098_field_633cae4546452": "Your Heading Text",
      "field_6338223792cfe_field_6346f6d37f098_field_63447fe3871ab": "h2",
      "field_6338223792cfe_field_6346f6d37f098_field_64b00f292a45d": "title-size-2",
      "field_6338223792cfe_field_6346f6d37f098_field_64b454b34aada": "title-weight-700",
      "field_6338223792cfe_field_6346f6d37f098_field_64b455fa2d932": "1",
      "field_6338223792cfe_field_6346f6d37f098_field_64b457002d933": "4.2rem",
      "field_6338223792cfe_field_6346f6d37f098_field_64b457222d934": "2.4rem",

      // Subtitle
      "field_6338223792cfe_field_64ae7d0cd8195_field_64ae7b8e72fe2": "Your subtitle text",
      "field_6338223792cfe_field_64ae7d0cd8195_field_64b016f604510": "subtitle-size-1",
      "field_6338223792cfe_field_64ae7d0cd8195_field_64b511a36efc8": "subtitle-weight-400",

      // Text & Alignment
      "field_6338223792cfe_field_6346f7017f099": "<p>Your paragraph content here.</p>",
      "field_6338223792cfe_field_63c7cb8e8cc91": "align-left",
      "field_6338223792cfe_field_63c7c882cbc4d": "text-theme-color"
    },

    // === MEDIA (Image for two-column) ===
    "field_633822e95716d": "1234",
    "field_6602db211d619": "",

    // === LAYOUT ===
    "field_63448568cb704": "ib-right",
    "field_6338282d741de": "info-box-width-50",
    "field_634486f33a083": "stack-mobile",

    // === BACKGROUND ===
    "field_63494a0141bbd": {
      "field_63494a0141bbd_field_63906c48a6adb": "0"
    },

    // === SPACING ===
    "field_634d6f80709fc": {
      "field_634d6f80709fc_field_64b2e129e2cd4": "1",
      "field_634d6f80709fc_field_64b2e187e2cd6": {
        "field_64b2e18ce2cd7": "12rem",
        "field_64b2e1f4e2cd9": "12rem"
      },
      "field_634d6f80709fc_field_64b2ed3ce6b65": {
        "field_64b2ed3ce6b66": "8rem",
        "field_64b2ed3ce6b67": "8rem"
      }
    }
  }
}
```

### Columns Block - Key Nested Fields

#### Columns Intro (same pattern as section_intro)

**Path**: `columns_intro` → `title` → `title field`

| Field         | Nested Key                                                    |
| ------------- | ------------------------------------------------------------- |
| Title text    | `field_637615ef54187_field_6346f6d37f098_field_633cae4546452` |
| Title tag     | `field_637615ef54187_field_6346f6d37f098_field_63447fe3871ab` |
| Subtitle text | `field_637615ef54187_field_64ae7d0cd8195_field_64ae7b8e72fe2` |
| Intro text    | `field_637615ef54187_field_6346f7017f099`                     |
| Alignment     | `field_637615ef54187_field_63c7cb8e8cc91`                     |

### Quick Reference Cheatsheet

**Section Block Prefixes**:

- Intro group: `field_6338223792cfe_`
- Title: `field_6338223792cfe_field_6346f6d37f098_`
- Subtitle: `field_6338223792cfe_field_64ae7d0cd8195_`
- Background: `field_63494a0141bbd_`
- Spacing: `field_634d6f80709fc_`

**Columns Block Prefixes**:

- Intro group: `field_637615ef54187_`
- Title: `field_637615ef54187_field_6346f6d37f098_`
- Subtitle: `field_637615ef54187_field_64ae7d0cd8195_`
- Background: `field_637616cf54189_`
- Spacing: `field_637616f65418a_`
- Columns repeater: `field_63760bb52814b_`

### Common Mistakes

**Wrong**: Using flat field names

```json
"title": "My Title"
```

**Right**: Using nested field keys

```json
"field_6338223792cfe_field_6346f6d37f098_field_633cae4546452": "My Title"
```

**Wrong**: Missing intermediate clone key

```json
"field_6338223792cfe_field_633cae4546452": "My Title"
```

**Right**: Including all levels

```json
"field_6338223792cfe_field_6346f6d37f098_field_633cae4546452": "My Title"
```
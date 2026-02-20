---
name: wordpress-block-creation
description: Creates WordPress ACF blocks following the iLogic theme patterns. Use when creating new blocks, modifying block structure, setting up ACF field groups, or building components from Figma designs.
---

# WordPress Block Creation

## Quick Start

When creating a new block:

1. Check if an existing block can be reused or modified
2. Create block directory structure
3. Create `block.json` with ACF configuration
4. Register block in `functions.php`
5. Create ACF field group in WordPress admin
6. Create PHP template following component patterns
7. Create SCSS file in `assets/src/sass/blocks/`
8. Add JavaScript if needed (auto-loads when block is used)

## Block Structure

Every block follows this structure:

```
blocks/block-name/
├── block.json          # Block registration
├── block-name.php     # Template file
└── block-name.js      # Optional JavaScript
```

## Step-by-Step Creation

### 1. Create Block Directory

Create directory: `blocks/your-block-name/`

### 2. Create block.json

```json
{
    "name": "acf/your-block-name",
    "title": "iLogic Your Block Title",
    "description": "Block description",
    "category": "ilogic-category",
    "icon": "icon-name",
    "keywords": ["keyword1", "keyword2"],
    "acf": {
        "mode": "auto",
        "renderTemplate": "your-block-name.php"
    },
    "supports": {
        "align": false,
        "anchor": true
    }
}
```

**Icon reference**: Use WordPress Dashicons (e.g., "image-rotate-right", "columns", "calendar")

### 3. Register Block

Add to `functions.php` in `register_acf_blocks()` function (around line 146):

```php
register_block_type( __DIR__ . '/blocks/your-block-name' );
```

### 4. Create ACF Field Group

1. Go to WordPress admin → Custom Fields → Add New
2. Set location rule: **Block** is equal to "iLogic Your Block Title"
3. Organize fields with tabs:
   - **Content** tab: Main content fields
   - **Settings** tab: Layout, spacing, styling options
4. Use clone fields for reusable components:
   - `group_6346f6d3b3fa8` - "Component: Intro" (most common)
5. Save → JSON auto-saves to `/acf-json/`

### 5. Create PHP Template

Follow this pattern:

```php
<?php
// 1. Get field objects
$margin = get_field_object('margin');
$custom_padding = get_field('custom_padding');
$padding = get_field_object('padding');

// 2. Build classes
$class = 'il_block il_your-block';
if ( ! empty( $block['className'] ) ) {
    $class .= ' ' . $block['className'];
}
if ( ! empty( $margin ) ) {
    $class .= ' ' . $margin['value'];
}
if ( ! empty( $padding ) ) {
    $class .= ' ' . $padding['value'];
}

// 3. Build custom styles (if needed)
$custom_style = '';
if( $custom_padding ) {
    // Handle custom padding with CSS variables
    // Pattern: --b-block-name-space-top-ld: value;
}

// 4. Anchor support
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// 5. Render
?>
<div <?php echo $anchor; ?> class="<?php echo $class; ?>" <?php if ( $custom_style ) echo 'style="' . $custom_style . '"'; ?>>
    <?php get_template_part('components/background'); ?>
    <div class="il_your-block_inner container">
        <?php get_template_part('components/intro'); ?>
        <!-- Your block-specific content -->
    </div>
</div>
```

### 6. Use Reusable Components

**Available components** (use `get_template_part()`):

- `components/intro` - Title, subtitle, text, buttons
- `components/background` - Background colors/images/elements
- `components/title` - Standalone title
- `components/subtitle` - Standalone subtitle
- `components/buttons` - Button groups
- `components/before-title` - Content before title
- `components/inner-section-background` - Inner section backgrounds

**Example**:
```php
<?php get_template_part('components/intro'); ?>
```

### 7. Create SCSS File

Create: `assets/src/sass/blocks/your-block-name.scss`

**Pattern**:
```scss
.il_block.il_your-block {
  padding-top: var(--b-space-top-ld);
  padding-bottom: var(--b-space-bottom-ld);
  padding-left: var(--b-space-left-ld);
  padding-right: var(--b-space-right-ld);
  
  @include limbo-max {
    padding-top: var(--b-space-top-mt);
    padding-bottom: var(--b-space-bottom-mt);
    padding-left: var(--b-space-left-mt);
    padding-right: var(--b-space-right-mt);
  }
  
  .il_your-block_inner {
    // Block-specific styles
  }
}
```

**Import in**: `assets/src/sass/frontend.scss`

### 8. Add JavaScript (Optional)

Create: `blocks/your-block-name/your-block-name.js`

**Auto-loading**: JavaScript automatically loads when block is used on a page (handled by `includes/blocks-js.php`)

## Spacing System

Blocks support responsive spacing:

- **Field objects**: `margin`, `padding` (predefined options)
- **Custom padding**: Uses CSS variables
- **Pattern**: `--b-block-name-space-{side}-{breakpoint}`
  - Sides: `top`, `bottom`, `left`, `right`
  - Breakpoints: `ld` (desktop), `mt` (mobile/tablet)

**Example custom padding**:
```php
if( $custom_padding ) {
    $paddings = '';
    if ( have_rows('custom_padding_ld')) {
        while (have_rows('custom_padding_ld')) {
            the_row();
            $padding_top = get_sub_field('padding_top');
            if( ! empty($padding_top) ) {
                $paddings .= ' --b-block-space-top-ld: ' . $padding_top . ';';
            }
            // Repeat for bottom, left, right
        }
    }
    // Repeat for custom_padding_mt
}
```

## ACF Field Organization

**Tab structure**:
1. **Content** tab: Main content fields
2. **Settings** tab: Layout, spacing, styling
3. **Styling** tab (if needed): Colors, typography

**Use clone fields** for:
- Intro component: `group_6346f6d3b3fa8`
- Title component: `group_633cae39110d7`
- Subtitle component: `group_64ae7b8e5d8d2`
- Before title: `group_65358ae4a7a00`

## Common Patterns

### Image with Responsive Sizing

```php
$image = get_field('media');
$image_mobile = get_field('media_mobile');
$size = 'full';

if ( $image || $image_mobile ) {
    $width_ld = get_field('width_ld') ?: $image['width'] / 10 . 'rem';
    $height_ld = get_field('height_ld') ?: $image['height'] / 10 . 'rem';
    $img_style = '--bg-e-width-lg: ' . $width_ld . '; --bg-e-height-lg: ' . $height_ld . ';';
    
    if ( $image ) {
        $img_class = 'desk_img';
        if( $image_mobile ) {
            $img_class .= ' hide_desk_img_mob';
        }
        echo wp_get_attachment_image( $image['id'], $size, false, [ 'class' => $img_class, 'style' => $img_style ] );
    }
    if ( $image_mobile ) {
        echo wp_get_attachment_image( $image_mobile['id'], $size, false, [ 'class' => 'mob_img', 'style' => $img_style ] );
    }
}
```

### Repeater Fields

```php
if ( have_rows('repeater_field_name') ) {
    while ( have_rows('repeater_field_name') ) {
        the_row();
        $sub_field = get_sub_field('sub_field_name');
        // Render repeater item
    }
}
```

## Best Practices

1. **Reuse components**: Use `get_template_part()` for common elements
2. **Consistent naming**: Use `il_block il_block-name` class pattern
3. **Responsive first**: Always handle `-ld` and `-mt` breakpoints
4. **CSS variables**: Use for dynamic values (spacing, colors)
5. **Container class**: Use `container` class for inner content
6. **Anchor support**: Always include anchor ID support
7. **Escape output**: Use `esc_attr()`, `esc_html()` for user input

## Reference Examples

- **Simple block**: `blocks/hero/hero.php`
- **Complex block**: `blocks/section/section.php`
- **With JavaScript**: `blocks/gallery/gallery.php` + `gallery.js`
- **Component usage**: See `components/intro.php` usage in any block

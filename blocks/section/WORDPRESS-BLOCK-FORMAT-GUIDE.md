# WordPress ACF Block Format Guide

## Understanding WordPress ACF Block Markup

WordPress ACF blocks use a specific flat JSON structure that differs from typical nested JSON. This guide explains the correct format.

## Core Format Rules

### 1. Flat Structure

ACF blocks use a **flat** key-value structure, NOT nested objects.

**❌ Wrong (Nested):**

```json
"field_6338223792cfe": {
  "field_6338223792cfe_field_6346f6d37f098_field_633cae4546452": "Title text"
}
```

**✅ Correct (Flat):**

```json
"title": "Title text",
"_title": "field_633cae4546452"
```

### 2. Field Name Pattern

Every field follows this pattern:

- **Field name** (human-readable): The actual value
- **Underscore field name** (metadata): The ACF field KEY (ONLY the final part)

**Example:**

```json
"heading_tag": "h2",
"_heading_tag": "field_63447fe3871ab"
```

- `heading_tag` = the value (`h2`)
- `_heading_tag` = the field KEY (just `field_63447fe3871ab`, not the full nested key)

### 3. Clone Fields

Clone fields (like `section_intro`, `title`, `subtitle`) are **flattened** into the main structure.

**Example - Title Clone:**

```json
"title": "Your title text",
"_title": "field_633cae4546452",
"heading_tag": "h2",
"_heading_tag": "field_63447fe3871ab",
"title_font_size": "title-size-2",
"_title_font_size": "field_64b00f292a45d"
```

**Note:** No parent group like `field_6338223792cfe_field_6346f6d37f098_field_xxx`. Just use the final field name.

### 4. Repeater Fields

Repeaters use indexed notation with a count field.

**Example - Buttons Repeater:**

```json
"buttons_0_button": {
  "title": "Button 1 text",
  "url": "#",
  "target": ""
},
"_buttons_0_button": "field_634939c822866",
"buttons_0_button_color": "button-color-white",
"_buttons_0_button_color": "field_64af3738cf78f",
"buttons_0_button_hover_color": "button-hover-color-white",
"_buttons_0_button_hover_color": "field_64af37cacf790",
"buttons": 1,
"_buttons": "field_634939bd22865"
```

**Key points:**

- Use `buttons_0_`, `buttons_1_`, `buttons_2_` for each item (zero-indexed)
- Add count field: `"buttons": 1` (number of items)
- Add count metadata: `"_buttons": "field_xxx"`

### 5. Group Fields

Group fields are flattened with underscore separators.

**Example - Custom Padding Desktop:**

```json
"custom_padding": "1",
"_custom_padding": "field_64b2e129e2cd4",
"custom_padding_ld_padding_top": "8.3rem",
"_custom_padding_ld_padding_top": "field_64b2e18ce2cd7",
"custom_padding_ld_padding_bottom": "8.3rem",
"_custom_padding_ld_padding_bottom": "field_64b2e1f4e2cd9",
"custom_padding_ld": "",
"_custom_padding_ld": "field_64b2e187e2cd6"
```

**Pattern:** `{parent_field}_{sub_field}_{sub_sub_field}`

### 6. Nested Groups

For deeply nested groups (e.g., inner_section_spacing_group → custom_padding_ld → padding_top):

```json
"inner_section_spacing_group_custom_padding_ld_padding_top": "",
"_inner_section_spacing_group_custom_padding_ld_padding_top": "field_64b7c451c5b0c_field_64b2e187e2cd6_field_64b2e18ce2cd7"
```

**Key metadata pattern:** Use the FULL nested key path with underscores for deeply nested fields.

## Complete Field Mapping Reference

### Title Fields (from Clone)

| Human Name               | Value Example    | Metadata Key          | Full ACF Key                                                            |
| ------------------------ | ---------------- | --------------------- | ----------------------------------------------------------------------- |
| `title`                  | `"My Title"`     | `field_633cae4546452` | (nested: `field_6338223792cfe_field_6346f6d37f098_field_633cae4546452`) |
| `heading_tag`            | `"h2"`           | `field_63447fe3871ab` | (nested: `field_6338223792cfe_field_6346f6d37f098_field_63447fe3871ab`) |
| `title_font_size`        | `"title-size-2"` | `field_64b00f292a45d` | (nested: `field_6338223792cfe_field_6346f6d37f098_field_64b00f292a45d`) |
| `title_use_custom_style` | `"1"`            | `field_64b455fa2d932` | (nested: `field_6338223792cfe_field_6346f6d37f098_field_64b455fa2d932`) |
| `title_font_size_ld`     | `"4.2rem"`       | `field_64b457002d933` | (nested: `field_6338223792cfe_field_6346f6d37f098_field_64b457002d933`) |
| `title_font_size_mt`     | `"24px"`         | `field_64b457222d934` | (nested: `field_6338223792cfe_field_6346f6d37f098_field_64b457222d934`) |

**Important:** In the block code, you only use the human name (e.g., `title`) and the final field key (e.g., `field_633cae4546452`). The nested path is NOT used in the block markup.

### Subtitle Fields (from Clone)

| Human Name                  | Metadata Key          |
| --------------------------- | --------------------- |
| `subtitle`                  | `field_64ae7b8e72fe2` |
| `subtitle_font_size`        | `field_64b016f604510` |
| `subtitle_use_custom_style` | `field_64b5121b50892` |
| `subtitle_font_size_ld`     | `field_64b5123c50894` |
| `subtitle_font_size_mt`     | `field_64b5124750895` |

### Content Settings

| Human Name         | Metadata Key          |
| ------------------ | --------------------- |
| `intro_text_color` | `field_63c7c882cbc4d` |
| `intro_alignment`  | `field_63c7cb8e8cc91` |
| `intro_text`       | `field_6346f7017f099` |

### Media (Image) Fields

| Human Name     | Metadata Key          |
| -------------- | --------------------- |
| `media`        | `field_633822e95716d` |
| `media_mobile` | `field_6602db211d619` |

### Layout Fields

| Human Name     | Value Options                                            | Metadata Key          |
| -------------- | -------------------------------------------------------- | --------------------- |
| `layout`       | `ib-left`, `ib-right`, `ib-fullwidth`, `ib-custom-width` | `field_63448568cb704` |
| `choose_style` | `info-box-width-40` to `info-box-width-75`               | `field_6338282d741de` |
| `stack`        | `stack-mobile`, `stack-tablet`, etc.                     | `field_634486f33a083` |

### Background Fields

| Human Name         | Metadata Key          |
| ------------------ | --------------------- |
| `use_background`   | `field_63906c48a6adb` |
| `background_color` | `field_6338240f11ade` |
| `blue_gradient`    | `field_64a7de5430724` |
| `background_image` | `field_6338240411add` |

### Spacing Fields

| Human Name                         | Metadata Key          |
| ---------------------------------- | --------------------- |
| `custom_padding`                   | `field_64b2e129e2cd4` |
| `custom_padding_ld_padding_top`    | `field_64b2e18ce2cd7` |
| `custom_padding_ld_padding_bottom` | `field_64b2e1f4e2cd9` |
| `custom_padding_mt_padding_top`    | `field_64b2ed3ce6b66` |
| `custom_padding_mt_padding_bottom` | `field_64b2ed3ce6b67` |

## Common Mistakes to Avoid

### ❌ Mistake 1: Using Nested Structure

```json
"field_6338223792cfe": {
  "_name": "section_intro",
  "field_6338223792cfe_field_6346f6d37f098_field_633cae4546452": "text"
}
```

**Why wrong:** WordPress doesn't recognize nested objects for ACF blocks.

**✅ Fix:**

```json
"title": "text",
"_title": "field_633cae4546452"
```

### ❌ Mistake 2: Using Full Nested Keys in Metadata

```json
"title": "text",
"_title": "field_6338223792cfe_field_6346f6d37f098_field_633cae4546452"
```

**Why wrong:** Metadata should only have the FINAL field key, not the full nested path.

**✅ Fix:**

```json
"title": "text",
"_title": "field_633cae4546452"
```

### ❌ Mistake 3: Forgetting Repeater Count

```json
"buttons_0_button": {...},
"buttons_1_button": {...}
```

**Why wrong:** Missing count field causes WordPress to not recognize the repeater items.

**✅ Fix:**

```json
"buttons_0_button": {...},
"buttons_1_button": {...},
"buttons": 2,
"_buttons": "field_634939bd22865"
```

### ❌ Mistake 4: Adding Documentation Fields

```json
"_name_field_633cae4546452": "title",
"title": "text"
```

**Why wrong:** `_name_xxx` fields are not part of WordPress ACF block format.

**✅ Fix:**

```json
"title": "text",
"_title": "field_633cae4546452"
```

## How to Find Field Keys

### Method 1: Export from WordPress

1. Go to WordPress Admin → Custom Fields → Field Groups
2. Click on the field group (e.g., "Block: iLogic Section")
3. Click "Export" tab
4. Select "Generate PHP code"
5. Field keys are shown as `'key' => 'field_xxx'`

### Method 2: From ACF JSON Files

1. Open `acf-json/group_633822375a604.json` (Section block)
2. Search for field name (e.g., `"name": "title"`)
3. The `key` property has the field key (e.g., `"key": "field_633cae4546452"`)

### Method 3: From Browser DevTools

1. Edit a block in WordPress
2. Open Browser DevTools → Network tab
3. Save the block
4. Check the request payload for field structure
5. Copy the format exactly

## Converting Nested to Flat

If you have nested field keys, here's how to convert:

**Nested key example:**

```
field_6338223792cfe_field_6346f6d37f098_field_633cae4546452
```

**Breaking it down:**

- `field_6338223792cfe` = section_intro (parent clone)
- `field_6346f6d37f098` = title (child clone)
- `field_633cae4546452` = title text field (actual field)

**Flat format:**

```json
"title": "Your text",
"_title": "field_633cae4546452"
```

**Rule:** Only use the LAST field key in the metadata, and use the human-readable name for the value field.

## Example: Complete Section Block

```json
{
  "name": "acf/section",
  "data": {
    "title": "My Title",
    "_title": "field_633cae4546452",
    "heading_tag": "h2",
    "_heading_tag": "field_63447fe3871ab",
    "subtitle": "My Subtitle",
    "_subtitle": "field_64ae7b8e72fe2",
    "intro_alignment": "align-right",
    "_intro_alignment": "field_63c7cb8e8cc91",
    "buttons_0_button": {
      "title": "Click me",
      "url": "#",
      "target": ""
    },
    "_buttons_0_button": "field_634939c822866",
    "buttons_0_button_color": "button-color-white",
    "_buttons_0_button_color": "field_64af3738cf78f",
    "buttons": 1,
    "_buttons": "field_634939bd22865",
    "media": "1234",
    "_media": "field_633822e95716d",
    "layout": "ib-right",
    "_layout": "field_63448568cb704",
    "use_background": "1",
    "_use_background": "field_63906c48a6adb",
    "blue_gradient": "1",
    "_blue_gradient": "field_64a7de5430724",
    "custom_padding": "1",
    "_custom_padding": "field_64b2e129e2cd4",
    "custom_padding_ld_padding_top": "10rem",
    "_custom_padding_ld_padding_top": "field_64b2e18ce2cd7"
  },
  "mode": "auto",
  "className": "my-custom-class"
}
```

## Validation Checklist

Before using block code, verify:

- [ ] No nested objects (all flat structure)
- [ ] Every field has both value and `_metadata` version
- [ ] Metadata uses ONLY the final field key (except for deeply nested groups)
- [ ] Repeaters have count field (`"buttons": 1`)
- [ ] No documentation fields (`_name_xxx`)
- [ ] Image IDs are numbers, not strings with quotes
- [ ] Boolean values use `"0"` or `"1"` as strings
- [ ] Custom values (fonts, padding) match ACF field format

## Resources

- ACF Block Format: https://www.advancedcustomfields.com/resources/blocks/
- Field Keys: Located in `acf-json/*.json` files
- Example blocks: Check existing blocks in WordPress Block Editor (Code view)

# Cursor Rules & Skills for iLogic WordPress Theme

This directory contains Cursor AI rules and skills to help with WordPress block development in the iLogic theme.

## Structure

```
.cursor/
├── rules/              # Coding standards and conventions
│   ├── theme-conventions.mdc          # Always applies - core conventions
│   ├── wordpress-block-standards.mdc  # PHP block template standards
│   ├── scss-standards.mdc             # SCSS coding standards
│   └── acf-field-organization.mdc     # ACF field group patterns
└── skills/             # Reusable workflows
    ├── wordpress-block-creation/      # Complete block creation workflow
    │   └── SKILL.md
    └── figma-to-block/                # Figma design to block conversion
        └── SKILL.md
```

## Rules

Rules are automatically applied based on file patterns or always (if `alwaysApply: true`).

### Available Rules

1. **theme-conventions.mdc** (Always applies)
   - Core theme architecture and conventions
   - Key directory structure
   - Naming patterns

2. **wordpress-block-standards.mdc** (Applies to `blocks/**/*.php`)
   - PHP template structure
   - Component usage patterns
   - Output escaping
   - Image handling

3. **scss-standards.mdc** (Applies to `assets/src/sass/**/*.scss`)
   - SCSS structure patterns
   - CSS variable usage
   - Responsive breakpoints
   - Class naming

4. **acf-field-organization.mdc** (Applies to `acf-json/**/*.json`)
   - Field group organization
   - Tab structure
   - Clone field usage
   - Naming conventions

## Skills

Skills are automatically discovered and used when relevant to the task.

### Available Skills

1. **wordpress-block-creation**
   - Complete workflow for creating new ACF blocks
   - Step-by-step instructions
   - Component usage patterns
   - Best practices

2. **figma-to-block**
   - Converting Figma designs to WordPress blocks
   - Design token extraction
   - Component mapping
   - Styling implementation

## Usage

### Creating a New Block

When you ask to create a new block, the agent will:
1. Use the `wordpress-block-creation` skill
2. Apply `wordpress-block-standards` rule
3. Follow theme conventions

### Working with Figma

When working with Figma designs:
1. Use the `figma-to-block` skill
2. Extract design tokens
3. Map to existing blocks or create new ones

### Editing Existing Blocks

When editing block PHP files:
- `wordpress-block-standards` rule applies automatically
- Follows component patterns
- Enforces output escaping

### Writing SCSS

When editing SCSS files:
- `scss-standards` rule applies automatically
- Enforces responsive patterns
- CSS variable usage

## How It Works

- **Rules**: Provide context and standards that apply to specific file types
- **Skills**: Provide step-by-step workflows for complex tasks
- **Auto-discovery**: Cursor automatically uses relevant rules and skills based on:
  - File patterns (for rules)
  - Task description (for skills)
  - Always-apply rules (always active)

## Customization

You can:
- Modify existing rules to match your preferences
- Add new rules for specific patterns
- Create new skills for custom workflows
- Adjust file patterns in rule frontmatter

## Best Practices

1. **Let the agent use skills automatically** - They're designed to trigger when needed
2. **Reference rules when needed** - Rules provide quick context
3. **Create project-specific skills** - Add workflows unique to your project
4. **Keep rules concise** - Under 500 lines for optimal performance

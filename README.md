# EXT:mai_canteen

Canteen meal plan records with daily menus, dietary flags, and weekly scheduling.

## Features

- **Menu Plan Management** — weekly lunch menu records with per-day dish entries
- **Allergen Labeling** — configurable allergen and additive flags per dish (comma-separated codes)
- **Dietary Flags** — vegetarian, vegan, gluten-free indicators per dish
- **Recurring Cycles** — weekly template records that serve as fallback menus
- **Frontend Display** — week-based view with week navigation (previous/next)
- **Print View** — printer-friendly weekly menu table layout

## Installation

Add to your TYPO3 site via the Configuration Set `maispace/mai-canteen` or include the TypoScript manually.

## Content Elements

| CType | Description |
|-------|-------------|
| `maispace_canteen_week` | Weekly interactive menu view with navigation |
| `maispace_canteen_print` | Printer-friendly weekly menu table |

## Database Tables

| Table | Description |
|-------|-------------|
| `tx_maicanteen_menuplan` | Weekly menu plan records |
| `tx_maicanteen_dish` | Individual dish records (child of MenuPlan) |

## Allergen Codes

Allergens and additives are stored as comma-separated codes following EU food labeling regulations (e.g. `A,C,G` for wheat, celery, milk).

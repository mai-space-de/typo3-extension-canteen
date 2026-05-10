# NextSteps.md — EXT:mai_canteen

## Current Status: 📋 Scaffolded

All PHP classes, TCA, TypoScript, FlexForms, and Fluid templates are in place.
The extension is registered and can be installed. No business logic is missing for the core feature set.

---

## 1. TYPO3 Integration

- [ ] **Register extension in root `composer.json`** — add `maispace/mai-canteen` to the `repositories` array and `require` block if not already auto-loaded via `packages/`
- [ ] **Run `ddev composer install`** inside the TYPO3 instance to wire the extension into the class loader
- [ ] **Run database compare** in the TYPO3 Install Tool to create `tx_maicanteen_menuplan` and `tx_maicanteen_dish` tables
- [ ] **Include TypoScript** — add the `maispace/mai-canteen` Configuration Set in the site's TypoScript configuration, or include `EXT:mai_canteen/Configuration/TypoScript/setup.typoscript` and `constants.typoscript` via the template record

---

## 2. Backend: Create Test Data

- [ ] Create a **Menu Plan** record for the current week (`week_start` = this Monday)
- [ ] Add several **Dish** child records across Mon–Fri with title, description, price, and dietary flags
- [ ] Create at least one **template** plan (`is_template = 1`) with a `template_week` value to verify the fallback logic in `MenuPlanController::weekAction`

---

## 3. Frontend: Validate Templates

- [ ] Insert the `maispace_canteen_week` content element on a test page
- [ ] Verify week navigation (previous / next) works correctly with `tx_maicanteen_week[offset]` argument
- [ ] Verify `menuPlan.dishesByDay` groups dishes correctly (Mon = 1 … Fri = 5)
- [ ] Insert `maispace_canteen_print` and trigger `window.print()` to check the print table layout
- [ ] Cross-check `de.locallang.xlf` translations render correctly in the German site language

---

## 4. Extbase Mapping Verification

- [ ] Confirm Extbase maps `week_start` / `week_end` (UNIX timestamps) to `\DateTimeImmutable` correctly — if not, add an explicit column map in a `ext_typoscript_setup.typoscript` override or switch the model property to `int` + add a getter that converts on demand
- [ ] Confirm the inline `dishes` relation is resolved via Extbase (the `tx_maicanteen_dish.menu_plan` foreign-field relation) — spot-check with `$menuPlan->getDishes()->count()`

---

## 5. Recurring Template Logic (Feature: "Recurring Cycles")

The scaffold wires template lookup by ISO week number. Remaining work:

- [ ] **Test**: create a template for week 2, navigate to that week in a future year and verify the fallback renders the template menu
- [ ] **Edge case**: `template_week = 0` should be treated as "no template assigned" — confirm the controller's `foreach` guard handles this
- [ ] **Optional**: add a backend wizard or scheduler task that auto-generates concrete `MenuPlan` records from templates at the start of each week

---

## 6. Unit Tests

- [ ] `MenuPlan::getDishesByDay()` — assert correct grouping and sort order
- [ ] `Dish::getAllergenList()` — assert comma-splitting, trimming, empty-string edge case
- [ ] `Dish::getAdditiveList()` — same as above
- [ ] `MenuPlanController::buildWeekDays()` — assert 5 entries, correct `isToday` flag, correct `\DateTimeImmutable` instances
- [ ] `MenuPlanRepository::findCurrentAndUpcoming()` — mock the query and assert the `monday this week` boundary

---

## 7. Accessibility & Print

- [ ] Verify dietary flag `<abbr>` / `<li>` elements have meaningful `title` attributes in all four site languages (de / en / uk / ar)
- [ ] Add `@media print` CSS in `mai_theme` (or a dedicated canteen SCSS partial) hiding `.mai-canteen__nav` and `.mai-canteen__print-header` browser chrome
- [ ] Test the print template on A4 paper size — ensure the five-column table does not overflow

---

## 8. Localisation (uk / ar)

- [ ] Add `uk.locallang.xlf` (Ukrainian) and `ar.locallang.xlf` (Arabic) under `Resources/Private/Language/Default/`
- [ ] Verify RTL layout does not break the five-column grid when `ar` locale is active

---

## 9. Promote to 🔨 In Progress

Update `Extensions.md` once items 1–4 above are verified and at least one unit test exists.

## 10. Promote to ✅ Implemented

Update `Extensions.md` once:
- All unit tests pass (`composer test:unit`)
- `composer lint:check` exits 0
- All five features in `FEATURES.md` are verified end-to-end in the browser
- Print view is validated in at least one browser

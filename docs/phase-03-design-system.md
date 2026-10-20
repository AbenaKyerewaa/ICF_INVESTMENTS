# Phase 3 — Design system and user experience

## Visual direction

ICF Investment uses a composed, professional banking-style aesthetic with a deep-navy foundation, one clear blue action color, generous whitespace, and soft bordered surfaces. It is deliberately calm and readable rather than imitating a real bank.

| Element | Decision |
| --- | --- |
| Primary color | ICF Blue `#2C6BED` for actions and focus |
| Foundation | ICF Navy `#0C1F3D` for navigation and key account surfaces |
| Background | Light neutral `#F6F8FC` |
| Success | Mint `#16A085`, paired with label/text rather than color alone |
| Type | System sans-serif stack with compact, high-weight headings |
| Shapes | 12–16 px card radius; 11–12 px button/input radius |
| Elevation | Soft `0 18px 45px rgba(12,31,61,.08)` surface shadow |

## Responsive navigation

- Desktop: sticky topbar plus a 268 px sticky sidebar.
- Tablet/mobile: topbar menu button opens an off-canvas-style sidebar.
- Content uses a constrained 82 rem maximum width and responsive horizontal padding.

## Reusable interface patterns

- `layouts.app`: demo strip, topbar, sidebar, content region, and footer.
- `x-flash-message`: dismissible success, error, warning, and status feedback.
- `.surface-card`: standard bordered/elevated surface.
- `.btn-icf-primary` and `.btn-icf-secondary`: primary and secondary actions.
- `.status-badge`: status pattern that includes a label and symbol, never color alone.
- Bootstrap alert, grid, and responsive utilities are the base primitives.

## State guidance

- Success: mint badge plus explicit success text.
- Warning: yellow alert surface plus descriptive copy.
- Error: Bootstrap danger alert with corrective next step.
- Loading: reserve component space and use text such as “Loading account activity…”.
- Empty: explain why the list is empty and present a clear next action.

## Demo boundary

The persistent top strip, landing copy, account preview, and footer all state that this is DEMO/SIMULATED. Future receipts, statements, and account screens must preserve this treatment.

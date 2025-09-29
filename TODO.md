# TODO: Implement Eye Icon Modal for Overwork Tables

## Tasks
- [x] Edit resources/views/view/users/overwork-data.blade.php: Add modal include, data attrs to eye button, JS for modal handling
- [x] Edit resources/views/view/users/overwork-accepted.blade.php: Add modal include, data attrs to eye button, JS for modal handling
- [x] Edit resources/views/view/users/overwork-pending.blade.php: Add modal include, data attrs to eye button, JS for modal handling
- [x] Edit resources/views/view/users/overwork-draft.blade.php: Add modal include, update eye button with data attrs and SVG, JS for modal handling

## Information Gathered
- All four overwork table views have similar structure with eye icon in Action column (non-functional).
- Modal component uses Alpine.js for show/hide via events.
- Preview will display Date, Task Description (full), Duration, Status with badge.
- Client-side population using data attributes on buttons.

## Dependent Files
- resources/views/view/users/overwork-data.blade.php
- resources/views/view/users/overwork-accepted.blade.php
- resources/views/view/users/overwork-pending.blade.php
- resources/views/view/users/overwork-draft.blade.php

## Followup Steps
- Test modal functionality in browser after edits.
- Verify data population and close behavior.

# TODO: Update Leave Tables to Use Consistent Modal System

## Tasks
- [x] Edit resources/views/view/users/leave-accepted.blade.php: Replace @include modal with <x-modal>, update JS for cleaner layout
- [x] Edit resources/views/view/users/leave-pending.blade.php: Replace @include modal with <x-modal>, update JS for cleaner layout
- [x] Edit resources/views/view/users/leave-draft.blade.php: Replace @include modal with <x-modal>, update JS for cleaner layout

## Information Gathered
- Leave tables were using @include('components.modal') which is inconsistent with overwork tables using <x-modal>.
- Updated to use <x-modal name="leave-preview-modal" maxWidth="lg"> for consistency.
- Updated modal content layout to use flexbox for better alignment and spacing.
- Updated JS to populate modal with structured divs instead of paragraphs.

## Dependent Files
- resources/views/view/users/leave-accepted.blade.php
- resources/views/view/users/leave-pending.blade.php
- resources/views/view/users/leave-draft.blade.php

## Followup Steps
- Test modal functionality in browser after edits.
- Verify data population and close behavior.

# TODO: Update Leave Modal Content to Include Leave Type

## Tasks
- [x] Edit resources/views/view/users/leave-accepted.blade.php: Add data-leave-type attribute to eye button, update JS body to include Leave Type field
- [x] Edit resources/views/view/users/leave-pending.blade.php: Add data-leave-type attribute to eye button, update JS body to include Leave Type field
- [x] Edit resources/views/view/users/leave-draft.blade.php: Add data-leave-type attribute to eye button, update JS body to include Leave Type field

## Information Gathered
- The modal content was missing the Leave Type field, which is displayed in the table.
- Added data-leave-type attribute to the eye preview buttons.
- Updated the JS body to include a new div for Leave Type using the new vertical layout style (flex flex-col items-start).

## Dependent Files
- resources/views/view/users/leave-accepted.blade.php
- resources/views/view/users/leave-pending.blade.php
- resources/views/view/users/leave-draft.blade.php

## Followup Steps
- Test modal functionality in browser after edits.
- Verify that Leave Type is now displayed in the modal preview.

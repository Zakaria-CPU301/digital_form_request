# Task: Update Evidence Display in Overwork Tables

## Overview
Modify the evidence column in overwork-related table views to display only the first image (or video if no image) compactly inline with the count of additional items. If multiple evidences exist, show the first one followed by a creative indicator like "+X more" in a styled badge on the same row for a neater, organized display. When clicking the preview button, show all evidences in the modal popup. This applies to four files. Changes are UI-only in Blade views.

## Steps
- [x] Step 1: Edit `resources/views/view/users/overwork-pending.blade.php`
  - Locate the evidence `<td class="py-4 px-6 font-semibold flex-col">`.
  - Replace the double `@foreach` loops with logic to:
    - Count total: `$totalEvidance = $r->evidance->count();`
    - Find first image: `$firstImage = $r->evidance->first(fn($e) => in_array(strtolower(pathinfo($e->path, PATHINFO_EXTENSION)), ['jpg', 'png', 'jpeg', 'webp']));`
    - If `$firstImage`, display: `<img src="{{ asset('storage/' . $firstImage->path) }}" alt="Evidence" width="50" class="inline-block mr-2 mb-2 rounded shadow-sm">`
    - Else, find first video: `$firstVideo = $r->evidance->first(fn($e) => in_array(strtolower(pathinfo($e->path, PATHINFO_EXTENSION)), ['mp4', 'mov', 'avi']));`
    - If `$firstVideo`, display: `<video src="{{ asset('storage/' . $firstVideo->path) }}" width="50" class="inline-block mr-2 mb-2 rounded shadow-sm" muted loop></video>`
    - If `$totalEvidance > 1`, append: `<div class="flex items-center text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full mt-1"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>{{ $totalEvidance - 1 }} more</div>`
    - If no evidence: Show "No evidence" in gray text.
  - Ensure the column remains flex-col for vertical alignment.

- [x] Step 2: Edit `resources/views/view/users/overwork-draft.blade.php`
  - Apply the same logic as Step 1 to the evidence `<td>`.

- [x] Step 3: Edit `resources/views/view/users/overwork-data.blade.php`
  - Apply the same logic as Step 1 to the evidence `<td>`.

- [x] Step 4: Edit `resources/views/view/users/overwork-accepted.blade.php`
  - Apply the same logic as Step 1 to the evidence `<td>`.

- [ ] Step 5: Verify changes
  - Run `php artisan serve`.
  - Navigate to overwork pages (e.g., pending, draft, data, accepted) and check tables.
  - Test with data having 0, 1, and multiple evidences (images/videos).
  - Update TODO.md by marking steps as [x] upon completion.

## Notes
- Prioritize images over videos for the first display.
- Creative styling: Rounded images/videos with subtle shadow; "more" indicator as a blue badge with plus icon for visual appeal.
- No changes to leave views, as they lack evidence columns.
- If issues arise (e.g., empty collection errors), add `@if($r->evidance)` checks.

<div class="flex flex-col gap-2 w-[450px]">
    <x-text-input class="font-medium shadow-none" type="hidden" name="user_id" id="" value="{{auth()->user()->id}}" />
    <x-input-label for="name" class="font-bold text-md">Name:</x-input-label>
    <h1 class="mb-1 border-2 py-1 px-2 rounded-md">{{auth()->user()->name}}</h1>
    <x-input-label for="position" class="font-bold text-md">Position:</x-input-label>
    <h1 class="mb-1 border-2 py-1 px-2 rounded-md">{{auth()->user()->position}}</h1>
    <x-input-label for="department" class="font-bold text-md">Department:</x-input-label>
    <h1 class="mb-1 border-2 py-1 px-2 rounded-md">{{auth()->user()->department}}</h1>
</div>
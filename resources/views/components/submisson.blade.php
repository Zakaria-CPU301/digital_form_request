<div class="flex flex-col">
    <x-text-input class="border-none font-medium shadow-none" type="hidden" name="user_id" id="" value="{{auth()->user()->id}}" />
    <label for="name" class="font-bold">Name:</label>
    <x-text-input class="border-none font-medium shadow-none" type="text" name="" id="" value="{{auth()->user()->name}}" disabled />
    <label for="position" class="font-bold">Position:</label>
    <x-text-input class="border-none font-medium shadow-none" type="text" name="" id="" value="{{auth()->user()->position}}" disabled />
    <label for="department" class="font-bold">Department</label>
    <x-text-input class="border-none font-medium shadow-none" type="text" name="" id="" value="{{auth()->user()->department}}" disabled />
</div>
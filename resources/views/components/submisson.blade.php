<div class="flex flex-col">
    <x-text-input type="hidden" name="user_id" id="" value="{{auth()->user()->id}}" />
    <x-text-input type="text" name="" id="" value="{{auth()->user()->name}}" disabled />
    <x-text-input type="text" name="" id="" value="{{auth()->user()->position}}" disabled />
    <x-text-input type="text" name="" id="" value="{{auth()->user()->departement}}" disabled />
    <x-text-input type="text" name="" id="" value="{{auth()->user()->phone_number}}" disabled />
</div>
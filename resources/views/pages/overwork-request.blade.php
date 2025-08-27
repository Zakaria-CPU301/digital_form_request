<x-request-layout>
{{-- @if ($errors->has('err'))
    <p>{{$errors->first('err')}}</p>
@endif --}}
<form action="{{route('overwork.insert')}}" method="post">
    <div class="flex">
        @csrf
        <x-submisson />
        
        {{-- overwork_request --}}
        <div class="flex flex-col">
            <x-text-input type="date" name="date" id="" />
            <x-text-input type="time" name="start" id="" />
            <x-text-input type="time" name="finish" id="" />
            <textarea name="desc" id="" class=""></textarea>
            <div class="flex justify-evenly">
                <button type="submit" name="action" value="draft">draft</button>
                <button type="submit" name="action" value="submit">submit</button>
            </div>
        </div>
    </div>
</form>
</x-request-layout>
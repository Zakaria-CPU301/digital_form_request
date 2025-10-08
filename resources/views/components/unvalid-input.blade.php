@props(['field'])

@error($field)
    <div style="color: red">{{ $message }}</div>
@enderror
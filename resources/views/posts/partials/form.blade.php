@error('title')
    <div style="color:red">{{ $message }}</div>
@enderror
<div><input type="text" name="title" value="{{ old('title', optional($post ?? null)->title) }}"></div>
@error('content')
    <div style="color:red">{{ $message }}</div>
@enderror
<div><textarea name="content">{{ old('content', optional($post ?? null)->content) }}</textarea></div>
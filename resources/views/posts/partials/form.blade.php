<div class="form-group">
    {{-- @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror --}}
    <div>
        <label for="title">Title</label>
        <input id="title" type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title', optional($post ?? null)->title) }}">
        <x-errors :errors="$errors->first('title')" />
    </div>
    {{-- @error('content')
        <div class="alert alert-danger my-3">
            {{ $message }}
        </div>
    @enderror --}}
    <div class="form-group">
        <label for="content">Content</label>
        <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" id="content" name="content">
            {{ old('content', optional($post ?? null)->content) }}
        </textarea>
        <x-errors :errors="$errors->first('content')" />
    </div>
</div>
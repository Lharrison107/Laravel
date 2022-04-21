<div class="form-group">
    {{-- @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror --}}
    <div>
        <label for="title">Title</label>
        <input id="title" type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title', optional($post ?? null)->title) }}">
        @if ($errors->has('title'))
            <span class="invalid-feeback text-danger">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
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
        @if ($errors->has('content'))
            <span class="invalid-feeback text-danger">
                <strong>{{ $errors->first('content') }}</strong>
            </span>
        @endif
    </div>
</div>
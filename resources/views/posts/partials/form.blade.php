
<div class="form-group">
    <strong>
        <label for="title">Title</label>
    </strong>
    <input id="title" type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title', optional($post ?? null)->title) }}">
    <x-errors :errors="$errors->first('title')" />
</div>

<div class="form-group">
    <strong>
        <label for="content">Content</label>
    </strong>
    <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" id="content" name="content">
        {{ old('content', optional($post ?? null)->content) }}
    </textarea>
    <x-errors :errors="$errors->first('content')" />
</div>

<div class="form-group">
    <strong>
        <label>Thumbnail</label>
    </strong>
    
</br>
    <input type="file" name="thumbnail" class="form-control-file"/>
</div>

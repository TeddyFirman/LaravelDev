<h1>Create Category</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('categories.store') }}">
    @csrf
    <div>

        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>




        <div class="form-group">
            <label for="status">Is Publish</label>
            <div class="form-check">
                <input type="radio" name="is_publish" value="1" class="form-check-input"
                    {{ old('is_publish') == '1' ? 'checked' : '' }}>
                <label class="form-check-label">True</label>
            </div>
            <div class="form-check">
                <input type="radio" name="is_publish" value="0" class="form-check-input"
                    {{ old('is_publish') == '0' ? 'checked' : '' }}>
                <label class="form-check-label">False</label>
            </div>
            @if ($errors->has('is_publish'))
                <div class="text-danger">{{ $errors->first('is_publish') }}</div>
            @endif
        </div>
    </div>

    <div>
        <button type="submit">Create Category</button>
    </div>
</form>

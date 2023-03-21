<h1>Edit Category</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



<form action="{{ route('categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label for="name">Category Name:</label>
        <input type="text" name="name" id="name" value="{{ $category->name }}">
        @error('name')
            <div>{{ $message }}</div>
        @enderror
    </div>

    {{-- <div>
        <label for="description">Category Description:</label>
        <textarea name="description" id="description">{{ old('description', $category->description) }}</textarea>
        @error('description')
            <div>{{ $message }}</div>
        @enderror
    </div> --}}

    <div class="form-group">
        <label for="status">Is Publish</label>
        <div class="form-check">
            <input type="radio" name="is_publish" value="1" class="form-check-input"
                {{ old('is_publish', $category->is_publish) == '1' ? 'checked' : '' }}>
            <label class="form-check-label">True</label>
        </div>
        <div class="form-check">
            <input type="radio" name="is_publish" value="0" class="form-check-input"
                {{ old('is_publish', $category->is_publish) == '0' ? 'checked' : '' }}>
            <label class="form-check-label">False</label>
        </div>
        @if ($errors->has('is_publish'))
            <div class="text-danger">{{ $errors->first('is_publish') }}</div>
        @endif
    </div>
    <button type="submit">Update</button>
</form>


{{-- <div class="container">
    <h1>Edit Category</h1>
    <form action="{{ route('category.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $category->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div> --}}

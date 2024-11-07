<style>
   /* General form styling */
form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Label styling */
form .col-form-label {
    font-weight: bold;
    color: #495057;
    text-align: left; /* Align labels to the left for better readability */
}

/* Input and textarea styling */
form .form-control {
    border-radius: 4px;
    border: 1px solid #ced4da;
    padding: 10px;
    transition: border-color 0.3s;
}

/* Focus state for input fields */
form .form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* File input styling */
form .input-group {
    display: flex;
    align-items: center;
}

.custom-file-input {
    border-radius: 4px;
    border: 1px solid #ced4da;
}

.custom-file-label {
    color: #495057;
    margin-left: 8px;
    font-size: 14px;
}

/* Error message styling */
.alert.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
    border-radius: 4px;
    font-size: 13px;
    margin-top: 5px;
}

/* Button styling */
form .btn-primary {
    width: auto;
    padding: 8px 20px; /* Smaller padding for a better button size */
    font-size: 14px; /* Slightly smaller font size */
    border-radius: 4px;
    font-weight: bold;
    background-color: #007bff;
    border: none;
    transition: background-color 0.3s;
    margin-top: 20px; /* Add space above the button */
}

form .btn-primary:hover {
    background-color: #0056b3;
}
</style>

<form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3 row">
        <label for="tittle" class="col-md-4 col-form-label text-md-end text-start">Title</label>
        <div class="col-md-6">
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3 row">
        <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
        <div class="col-md-6">
            <textarea class="form-control" id="description" rows="5" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3 row">
        <label for="input-file" class="col-md-4 col-form-label text-md-end text-start">File input</label>
        <div class="col-md-6">
            <div class="input-group">
                <input type="file" class="custom-file-input" id="input-file" name="picture">
                <label class="custom-file-label" for="input-file">Choose file</label>
            </div>
            @error('picture')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

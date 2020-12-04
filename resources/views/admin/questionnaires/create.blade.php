<div class="form-group row">
    <label class="col-lg-3 col-form-label">Question name:</label>
    <div class="col-lg-9">
        <input type="text" name="question_name" value="{{ old('question_name') }}" class="form-control">
        @error('question_name')
        <span class="text-danger" role="alert">
               <strong>{{ $message }}</strong>
          </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label class="col-lg-3 col-form-label">Question Image:</label>
    <div class="col-lg-9">
        <input type="file" accept="image/gif, image/jpeg, image/png" name="question_image"  class="form-control">
    </div>
</div>


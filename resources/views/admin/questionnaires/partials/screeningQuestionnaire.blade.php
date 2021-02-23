<tr>
    <td>

        <input type="text" name="question_name[]" value="{{ old('question_name') }}" class="form-control" required>
    </td>
    <td>
        <input type="file" accept="image/gif, image/jpeg, image/png" name="question_image[]"  class="form-control" required>
    </td>
    <td>
        <button type="button" class="btn bg-danger-light btn trash remove"><i class="far fa-trash-alt">X</i></button>
    </td>
</tr>

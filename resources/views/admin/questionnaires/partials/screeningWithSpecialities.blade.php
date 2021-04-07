<tr>
    <td>
        <input type="text" name="question_name[]" value="{{ old('question_name') }}" class="form-control" required>
    </td>
    <td>
        <input type="file" accept="image/gif, image/jpeg, image/png" name="question_image[]"  class="form-control" required>
    </td>
    <td>
        <select name="specialities[]" id="qSpecialities_{{$count}}" style="width: 100%" class="form-control select2-width" required multiple="multiple">
            @foreach($specialists as $speciality)
                <option  value="{{$speciality->id}}">{{$speciality->name}}</option>
            @endforeach
        </select>
    </td>
    <td>
        <button type="button" class="btn bg-danger-light btn trash remove"><i class="fe fe-trash"></i></button>
    </td>
</tr>

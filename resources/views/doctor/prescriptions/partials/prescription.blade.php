<tr>
    <td>
        <select name="doctor_products[]" id="doctor-product-prescription_{{$count}}" style="width: 100%" class="form-control select2-width" required>
            @foreach($doctorProducts as $doctorProduct)
                <option  value="{{$doctorProduct->id}}">{{$doctorProduct->product->product_code}} {{$doctorProduct->product->product_name}}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input class="form-control" min="1" type="number" name="quantity[]">
    </td>
    <td>
        <input class="form-control" type="text" name="days[]">
    </td>
    <td>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="morning_time[]"> Morning
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="afternoon_time[]"> Afternoon
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="evening_time[]"> Evening
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="night_time[]"> Night
            </label>
        </div>
    </td>
    <td>
        <button type="button" class="btn bg-danger-light trash remove"><i class="far fa-trash-alt"></i></button>
    </td>
</tr>

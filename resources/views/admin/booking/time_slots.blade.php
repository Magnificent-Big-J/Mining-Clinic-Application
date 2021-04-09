<label class="col-lg-3 col-form-label">Slots:<span class="text-danger">*</span></label>
<div class="col-lg-9">
    <div class="row">
        @foreach($timeSlots as $slot)
            <div class="col-md-3">
                <label>
                    <input type="radio" name="timeSlot" class="time-slot" value="{{$slot}}" required>
                    <img  src="https://via.placeholder.com/150/1F3063/FFFFFF&text={{$slot}}">
                </label>
            </div>
        @endforeach
    </div>
</div>

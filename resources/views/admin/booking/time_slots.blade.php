<label class="col-lg-3 col-form-label">Slots :</label>
<div class="col-lg-9">
    <div class="row">
        @foreach($timeSlots as $slot)
            <div class="col-md-3">
                <label>
                    <input type="radio" name="timeSlot" class="time-slot" value="{{$slot}}" required>
                    <img src="http://placehold.it/150x150/b0f/fff&text={{$slot}}">
                </label>
            </div>
        @endforeach
    </div>
</div>

@for($i = 1; $i< 10; $i++)
    <input type="radio" name="radio1" id="time-{{$i}}" value="free"><label class="free-label four time-slot-col" for="time-{{$i}}">Free {{$i}}</label>

@endfor

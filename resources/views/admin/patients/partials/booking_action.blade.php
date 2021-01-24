<form action="{{route('admin.booking')}}" method="post">
    @csrf
    <input type="hidden" name="patient" value="{{$patient->id}}">
    <button type="submit" class="btn btn-secondary btn-sm">Book Appointment</button>
</form>

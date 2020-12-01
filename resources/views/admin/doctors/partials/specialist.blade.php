
<ul>
    @foreach($row->specialists as $specialist)
        <li>{{$specialist->name}}</li>
    @endforeach
</ul>

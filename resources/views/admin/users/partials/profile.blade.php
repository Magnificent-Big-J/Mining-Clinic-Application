<h2 class="table-avatar">
    <a href="{{route('admin.doctors.show', $row->id)}}" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{$row->profile}}" alt="User Image"></a>
    <a href="{{route('admin.doctors.show', $row->id)}}">{{$row->full_names}}</a>
</h2>

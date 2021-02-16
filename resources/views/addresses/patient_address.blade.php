<div class="card">
    <div class="card-body">
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Patient AddressesInformation</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="card-title">Physical Address</h4>
                        @if ($patient->addresses->count() >= 1)
                            <p>{{$patient->addresses[0]->address_1}}</p>
                            <p>{{$patient->addresses[0]->address_2}}</p>
                            <p>{{$patient->addresses[0]->postal_code}}</p>
                            <p>{{$patient->addresses[0]->province->province_name}}</p>
                        @else
                            No Address record
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <h4 class="card-title">Postal Address</h4>
                        @if ($patient->addresses->count() == 2)

                            <p>{{$patient->addresses[1]->address_1}}</p>
                            <p>{{$patient->addresses[1]->address_2}}</p>
                            <p>{{$patient->addresses[1]->postal_code}}</p>
                            <p>{{$patient->addresses[1]->province->province_name}}</p>
                        @elseif($patient->addresses->count() >= 1)
                            Same as Physical Address
                        @else
                            No Address record
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

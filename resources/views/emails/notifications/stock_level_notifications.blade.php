
<h1>Dear {{$doctor->user->full_names}}</h1>,<br>

    Stock Level Notification, please see the below table<br>
    <table class="table">
        <thead>
            <tr>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Product Quantity</th>
                <th>Product Threshold(Level)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doctorProducts as $doctorProduct)
            <tr>
                <td>{{$doctorProduct->product->product_code}}</td><td>{{$doctorProduct->product->productCategory->name}}</td><td>{{$doctorProduct->quantity}}</td><td>{{$doctorProduct->threshold}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    Thanks,<br>
    {{ config('app.name') }}


<h1>Dear {{$full_names}}</h1>,<br>

    Stock Level Notification for {{$clinic->mining_name}} {{$clinic->clinic_name}}, please see the below table<br>
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
  @foreach($clinicProducts as $clinicProduct)
    <tr>
      <td>{{$clinicProduct->product->product_code}}</td><td>{{$clinicProduct->product->productCategory->name}}</td><td>{{$clinicProduct->quantity}}</td><td>{{$clinicProduct->threshold}}</td>
    </tr>
 @endforeach
 </tbody>
</table>

Thanks,<br>
{{ config('app.name') }}


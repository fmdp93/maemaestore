<table id="products_list" class="table {{ $table_striped }}">
  <thead>
      <tr>
          <th scope="col">#</th>
          <th scope="col">Item Code</th>
          <th scope="col">Name</th>
          <th scope="col">Quantity</th>
          <th scope="col">Stock Remaining</th>
          <th scope="col">Returns</th>
      </tr>
  </thead>
  <tbody>
      @php
          $count = 1;
      @endphp
      @foreach ($products->get() as $item)
          <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $item->item_code }}</td>
              <td>{{ $item->p_name }}</td>                                    
              <td>{{ $item->pt2p_quantity }}</td>
              <td>{{ $item->updated_quantity }}</td>
              <td>
                  @if(!empty($item->refunded_quantity))
                  {{ $item->refunded_quantity . "x - " .$item->remark }}</td>
                  @endif
          </tr>
      @endforeach
  </tbody>
</table>
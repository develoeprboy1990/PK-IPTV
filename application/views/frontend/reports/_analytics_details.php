<table class="table table-striped table-hover">
  <tbody>
    <tr>
      <th>Date:</th>
      <td><?=$details->date?></td>
    </tr>
    <tr>
      <th>Customer ID : </th>
      <td><?=$details->user_id?></td>
    </tr>
    
    <tr>
      <th>Client Name</th>
      <td><?=$details->client_name?></td>
    </tr>

    <tr>
      <th>Client CMS</th>
      <td><?=$details->client_cms?></td>
    </tr>

    <tr>
      <th>Client CRM</th>
      <td><?=$details->client_crm?></td>
    </tr>

     <tr>
      <th>Client Product</th>
      <td><?=$details->client_product?></td>
    </tr>

    <tr>
      <th>UI Name: </th>
      <td><?=$details->ui_name?></td>
    </tr>
    <tr>
      <th>UI Version:</th>
      <td><?=$details->ui_version?></td>
    </tr>
    <tr>
      <th>Location City</th>
      <td><?=$details->location_city?></td>
    </tr>
    <tr>
      <th>Location State</th>
      <td><?=$details->location_state?></td>
    </tr>
    <tr>
      <th>Location Country</th>
      <td><?=$details->location_country?></td>
    </tr>

    <tr>
      <th>Location Latitude</th>
      <td><?=$details->location_latitude?></td>
    </tr>

    <tr>
      <th>Location Longitude</th>
      <td><?=$details->location_longitude?></td>
    </tr>

    <tr>
      <th>Device Category</th>
      <td><?=$details->device_category?></td>
    </tr>

    <tr>
      <th>Device Type</th>
      <td><?=$details->device_type?></td>
    </tr>

    <tr>
      <th>Device Model</th>
      <td><?=$details->device_model?></td>
    </tr>

    <tr>
      <th>Network Speed</th>
      <td><?=$details->network_speed?></td>
    </tr>

    <tr>
      <th>Network Latency</th>
      <td><?=$details->network_latency?></td>
    </tr>

    <tr>
      <th>Action Type</th>
      <td><?=$details->action_type?></td>
    </tr>

    <tr>
      <th>Action From</th>
      <td><?=date('Y-m-d',$details->action_from)?></td>
    </tr>

    <tr>
      <th>Action To</th>
      <td><?=date('Y-m-d',$details->action_to)?></td>
    </tr>

  </tbody>
</table>


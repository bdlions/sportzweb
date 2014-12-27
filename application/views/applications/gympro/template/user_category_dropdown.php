
    <select id="client_list" name="client_list" class="form-control">        
        <option value="0" <?php echo($selected_client_id == 0) ? 'selected="selected"' : '' ;?> >Everyone</option>
        <optgroup class="user_category_dropdown_optgroup" label="Active" style="background-color: lightgreen">
            <?php foreach($client_list as $client_info){
             if($client_info['status_id'] == CLIENT_STATUS_ACTIVE_ID){?>
            <option class="user_category_dropdown_option" <?php echo($selected_client_id == $client_info['client_id']) ? 'selected="selected"' : '' ;?> value="<?php echo $client_info['client_id']?>"><?php echo $client_info['first_name'].' '.$client_info['last_name']?></option>
             <?php }} ?>
        </optgroup>
        <optgroup class="user_category_dropdown_optgroup" label="Inactive" style="background-color: lightgray">
            <?php foreach($client_list as $client_info){
             if($client_info['status_id'] == CLIENT_STATUS_INACTIVE_ID){?>
            <option class="user_category_dropdown_option" <?php echo($selected_client_id == $client_info['client_id']) ? 'selected="selected"' : '' ;?> value="<?php echo $client_info['client_id']?>"><?php echo $client_info['first_name'].' '.$client_info['last_name']?></option>
             <?php }} ?>
        </optgroup>
        <optgroup class="user_category_dropdown_optgroup" label="Potential" style="background-color: lightpink">
            <?php foreach($client_list as $client_info){
             if($client_info['status_id'] == CLIENT_STATUS_POTENTIAL_ID){?>
            <option class="user_category_dropdown_option" <?php echo($selected_client_id == $client_info['client_id']) ? 'selected="selected"' : '' ;?> value="<?php echo $client_info['client_id']?>"><?php echo $client_info['first_name'].' '.$client_info['last_name']?></option>
             <?php }} ?>
        </optgroup>
    </select>

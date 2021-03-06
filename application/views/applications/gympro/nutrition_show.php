<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    <div class="row top_margin">
        <?php
        if ($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) {
            $this->load->view("applications/gympro/template/sections/client_left_pane");
        } else {
            $this->load->view("applications/gympro/template/sections/pt_left_pane");
        }
        ?>
        <div class="col-md-9">
            <div class="pad_title">
                NUTRITION INFO
                <div class="col-md-3 pull-right">
<?php
if ($account_type_id != APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) {
    echo $nutrition_info['first_name'] . ' ' . $nutrition_info['last_name'];
}
?>
                </div>
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <div class="pad_body" style="padding-right: 0;">
<?php $count = 1; ?>
<?php foreach ($meal_list as $meal_group) { ?>
                    <div class="row form-group"></div>
                    Meal: <?php echo $count++; ?>
                    <div class="row form-group"></div>
                    <table class="table-bordered table-condensed" style="width: 100%">
                        <tr>
                            <th>Label</th>
                            <th>Quantity</th>
                            <th>Qty.Unit</th>
                            <th>Calories</th>
                            <th>Protein</th>
                            <th>Carbs</th>
                            <th>Fats</th>
                        </tr>

    <?php foreach ($meal_group as $meal_row) { ?>
                            <tr>
                                <td><?php echo $meal_row["label"] ?></td>

                                <td><?php echo $meal_row["quan"] ?></td>

                                <td><?php echo $meal_row["unit"] ?></td>

                                <td><?php echo $meal_row["cal"] ?></td>

                                <td><?php echo $meal_row["prot"] ?></td>

                                <td><?php echo $meal_row["carb"] ?></td>

                                <td><?php echo $meal_row["fats"] ?></td>
                            </tr>

                                <!--<script>  row_value_set("<?php echo $meal_row["label"] ?>", "<?php echo $meal_row["quan"] ?>", "<?php echo $meal_row["unit"] ?>", "<?php echo $meal_row["cal"] ?>", "<?php echo $meal_row["prot"] ?>", "<?php echo $meal_row["carb"] ?>", "<?php echo $meal_row["fats"] ?>") </script>-->
    <?php } ?>

                    </table>
                    <div class="row form-group"></div>
                    <?php } ?>
            </div>


        </div>
    </div>
</div>


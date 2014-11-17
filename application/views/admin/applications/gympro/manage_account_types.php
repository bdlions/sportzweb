<div class="panel panel-default">
    <div class="panel-heading">Manage account</div>
    <div class="panel-body">
        <?php if ($allow_write) { ?>
        <div class="row form-group">
            <div class ="col-md-3 pull-left">
                <button onclick="" class="form-control btn button-custom">Create Account Type</button>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>TITLE</th>
                            <th>PRICE</th>
                            <th>TOTAL USER</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_product_category_list">
                        <tr>
                            <td>ID</td>
                            <td>TITLE</td>
                            <td>PRICE</td>
                            <td>TOTAL USER</td>
                            <td>EDIT</td>
                            <td>DELETE</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
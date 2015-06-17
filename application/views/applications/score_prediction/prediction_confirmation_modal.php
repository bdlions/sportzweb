<div class="modal fade" id="confirmModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Confirm Vote...</h4>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to vote?</h3>
            </div>
            <div class="modal-footer">
                <button id="vote_id" onclick="post_vote()" type="button" class="btn btn-primary">Yes</button>
                <button id="vote_ignore_id" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <input id="match_id" name="match_id" type="hidden">
                <input id="match_status_id" name="match_status_id" type="hidden">
            </div>
        </div>
    </div>
</div>
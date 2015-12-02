<div class="row col-md-9 column upcoming-fixtures">
    <div class="row col-md-4">
        <a href="<?php echo base_url().'applications/xstream_banter'; ?>" >
            <img class="img-responsive" src="<?php echo base_url() ?>resources/images/xb_logo.png" />
        </a>        
    </div>
    <h3><?php echo $tournament_info['title'];?> <?php echo $current_date;?></h3>
    <?php foreach($match_list as $match){ ?>
        <div><a href="<?php echo base_url().'applications/xstream_banter/step4/'.$match['id']?>"><?php echo $match['team1_title']?> v <?php echo $match['team2_title']?> (<?php echo $match['time']?>)</a></div>
    <?php } ?>
</div>
<div class="col-md-3 column">
    
</div>
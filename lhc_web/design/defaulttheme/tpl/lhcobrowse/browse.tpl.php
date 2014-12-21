<div id="chrome">
	<div class="row">
		<div class="large-6 columns">
		
			<div class="row collapse">       
	          <div class="small-9 columns">
	           <input id="awesomebar" name="url" value="<?php echo htmlspecialchars($browse->url)?>" type="text">
	          </div>
	          <div class="small-3 columns">
	            	<a href="#" class="button prefix" onclick="return lhinst.addRemoteCommand('<?php echo $chat->id?>','lhc_cobrowse')"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('cobrowse/browse','Request screen share')?>" class="icon-eye"></i></a>
	          </div>
	        </div>
        
		</div>
		<div class="large-6 columns">
			<i title="" id="status-icon-sharing" class="left icon-eye<?php echo $browse->is_sharing == 0 ? ' eye-not-sharing' : ''?>"></i>
			<label id="last-message" class="inline right"><?php echo $browse->mtime > 0 && $browse->initialize != '' ? $browse->mtime_front : '' ?></label>
		</div>
	</div>
    
</div>
<script>
var lhcbrowserOpeator = new LHCCoBrowserOperator(window,document,{'chat_id':<?php echo $browse->chat_id?>, 'base':<?php echo json_encode($browse->url)?>, 'initialize' : <?php echo $browse->initialize != '' ? $browse->initialize : 'null'?>});
</script>
<div id="contentWrap">
        <iframe id="content" name="content" src="<?php echo erLhcoreClassDesign::baseurl('cobrowse/mirror')?>" frameborder="0"></iframe>
</div>
<?php 
/*
Plugin Name: Proliphic Badge
Plugin URI: http://www.proliphiq.com/
Description: Show off your credibility by topic and let your readers/community to rate you!
Author: Proliphiq
Version: 1.0
Author URI: http://www.proliphiq.com
*/
add_action('show_user_profile', 'my_show_extra_profile_fields');
add_action('edit_user_profile', 'my_show_extra_profile_fields');
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
function my_save_extra_profile_fields( $user_id ) 
				{
						$pro_id=$_POST['proliphiq'];
						$user_id=$_POST['user_id'];
						$tag_id=$_POST['tag_size'];
						$badge_size=$_POST['badgename_size'];
						$tag_size_name=$_POST['tag_size_name'];
					if(!$badge_size)
					{
						$badge_size=1;
					}
						$search_user_id="select * from prolophique where username='$user_id'";
						$res_search_user_id=mysql_query($search_user_id);
						$fetch_search_user_id=mysql_fetch_array($res_search_user_id);
					if($fetch_search_user_id)
					{
						$id=$fetch_search_user_id['id'];
						$sql_update_pro="UPDATE prolophique
						SET Proliphique_id='$pro_id', badge_size ='$badge_size',tag_id='$tag_id',tag_id_name='$tag_size_name'

						WHERE id=$id";
						mysql_query($sql_update_pro);
					}
					else
					{
					$sql="insert into prolophique(username,Proliphique_id,badge_size,tag_id,tag_id_name)values('$user_id','$pro_id','$badge_size','$tag_id','$tag_size_name')";

					mysql_query($sql);
					}
				}
function my_show_extra_profile_fields($user) 
			{ 
			?>
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
			<style>
			.pro_table
			{
			height:275px;
			width:1000px;
			}
			#badge_size
			{
			height: 60px;
			width:565px;
			}
			#filterby
			{
			margin-right: 232px;
			margin-top: -38px;
			float:right;
			}
			#badge_size input
			{
			float:right;
			margin-right:50px;
			 margin-top: -38px;
			 !position:relative; 
			 !left:350px
			}
			#badge_size h4
			{
			width:100px;
			
			}
			.table_name
			{
			
			width: 155px;
			}
			.table_content
			{
			    
				float: right;
				margin-top: -39px;
				width: 790px;
			
			}
			</style>
			<h3>Proliphiq Badge</h3>
			<div class="pro_table" id="pro_table">
			<?php global $current_user;
			get_currentuserinfo();
			$user_id = $current_user->ID;
			$otheruser = $_GET['user_id'];
			if (!(!isset($otheruser) || trim($otheruser)==='')){
				$user_id = $otheruser;
			}
			// See if the user has posted us some information
    		// If they did, this hidden field will be set to 'Y'
    		if( isset($_POST[ 'settings' ]) && $_POST[ 'settings' ] == 'settings' ) {
    			$user_id = 'settings';
    		}  
    		$hide_badge_size = true;		
			// see if user is coming on Settings page    		
    		if (strpos($_SERVER['REQUEST_URI'],'options-general.php') !== false) {
    			$user_id = 'settings';
    			$hide_badge_size = false;   			
			}
			$fetch_pro_info="select * from prolophique where username='$user_id'";
			$res_pro_info=mysql_query($fetch_pro_info);
			$fetch_pro_info=mysql_fetch_array($res_pro_info);			
			?>
			<div id="badge_size" style="display:none;" >			
			<?php 						
			if($_POST['save']=='save')
			{		
				?>		
			
			<h4>Badge Size</h4>
					<select name="filterby"  id="filterby" onchange="sortby(this)">
					<option value="1">small(178x32)</option>
					<option value="2">medium(200x48)</option>
					<option value="3">large(267x64)</option>							
					</select>
					<input type="submit"  class="button-primary" name="save" value="Save"/>
					<script>
						 var abh;
						 abh='<?php if($_POST['filterby']) { echo $_POST['filterby'];} else { echo $fetch_pro_info['badge_size']; }?>';
						 $('#filterby option').each(function ()
						 {
						  if($(this).attr('value')==abh)
						  {

						 $(this).attr('selected','slected');

						  }

						 });
					</script>
				<?php
					 }
				 else
				 {
					?>
				<h4>Badge Size</h4>
							<select name="filterby"  id="filterby" onchange="sortby(this)">
							<option value="1">small(178x32)</option>
							<option value="2">medium(200x48)</option>
							<option value="3">large(267x64)</option>					
							</select>
							<input type="submit"  class="button-primary" name="save" value="Save"/>
					<script>
						 var abh;
						 abh='<?php if($_POST['filterby']) { echo $_POST['filterby'];} else { echo $fetch_pro_info['badge_size']; }?>';
						 $('#filterby option').each(function ()
						 {
						  if($(this).attr('value')==abh)
						  {
						 $(this).attr('selected','slected');
						  }
						 });
					</script>	
					<?php
						}
						?>
						</div>		
			<div class="table_name"><label for="twitter"><h4>Proliphiq Screen Name</h4></label></div>
			<div class="table_content">
				<input type="text" name="proliphiq" id="proliphiq" value="<?php if($_POST['proliphiq']){  echo $_POST['proliphiq'];  } else { echo $fetch_pro_info['Proliphique_id']; }?>" class="regular-text" /><span class="get_screen" onmouseover="display_text();" onMouseout="hide_text();"><a href="" onClick="MyWindow=window.open('http://www.proliphiq.com','Proliphiq','toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes'); return false;">?</a></span><span id="hide_text" class="description" style="display:none;">You can find your Screen Name by going into your Profile Setting at www.Proliphiq.com</span> <br />
				<br/><span class="description">Please enter your Proliphiq Screen Name.</span>
			<div class="button_field">
				<input class="button-primary" type="button" name="save"  value="Get My Topics" id="saveProliphiqId" onclick="getjson();" />
			</div>
			
					<?php if($_POST['save']=='save')
						{   ?>		
						<div class="tag_name" id="tag_name" style="display:none;" >
						<h4>Topic</h4>
						<select id="cb" name="cb" onchange="tag_name(this)">	
						</select>
						</div>
					<?php } else {?>
					<div class="tag_name" id="tag_name" style="display:none;" >
					<h4>Topic</h4>
					<select id="cb" name="cb" onchange="tag_name(this)">
					</select>
					</div>
					<?php } ?>
					<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>"/>
					<input type="hidden" name="badgename_size" id="badgename_size" value="<?php  echo $fetch_pro_info['badge_size']; ?>"/>
					<input type="hidden" name="tag_size" id="tag_size" value="<?php  echo $fetch_pro_info['tag_id']; ?>"/>
					<input type="hidden" name="tag_size_name" id="tag_size_name" value="<?php  echo $fetch_pro_info['tag_id_name']; ?>"/>
					</div>
					</div>
		<script>
		var selected_tag='';
		selected_tag="<?php  if($_POST['cb']) { echo $_POST['cb'];   }else{ echo $fetch_pro_info['tag_id']; }?>";
		window.onload=getjson_onload();	 
		window.location.load=true;  
		function getjson()
		{
		<?php if(!$hide_badge_size)  {?>			
		document.getElementById('badge_size').style.display = 'block';		
		<?php } ?>
		var getjson_tag = document.getElementById("proliphiq").value;
		 $('#cb').children('option').remove();      
		var pro_url='http://www.proliphiq.com';
		var url=pro_url+"/proliphiq/badge/screenNameSearch?screenName="+getjson_tag+"";
		
		if ($.browser.msie && window.XDomainRequest) { // IE
	   var xdr = new XDomainRequest();
	   xdr.open("get",url);	 
	  xdr.onload = function () {
	   //parse response as JSON
	   var data = $.parseJSON(xdr.responseText);
	   if (data == null || typeof (data) == 'undefined')
	   {
	   //alert("We are unable to find your Proliphiq ID in the Proliphiq.com system.  Please go to http://proliphiq.com and look in your Profile Settings to ensure it is entered correctly.");
       	 //data = $.parseJSON(data.firstChild.textContent);
	   }
	   else
	   {
	   var pro_profile=data.proliphiqProfile;
	   if(data.proliphiqProfile != null)
		{
	document.getElementById('tag_name').style.display = 'block';
			var profile_id_tags=data.proliphiqProfile.tags;
			var profile_id_length=profile_id_tags.length;
			var first_tag_size;
			var first_tag_size_name;
			if (profile_id_length<1){
			<?php if(!$hide_badge_size)  {?>
			document.getElementById('showSettingsButton').style.display = 'block';
			<?php } ?>
				var x=document.getElementById("cb");
				var cbh = document.getElementById('cb');
				var cb = document.createElement('option');
				cbh.appendChild(cb);
				cb.name = "OVERALL";
				cb.value = "1";
				cb.appendChild(document.createTextNode("OVERALL"));		
			}
			for(var i=0;i<=profile_id_length;i++)
			{	
			var profile_id_tag_each=data.proliphiqProfile.tags[i].tagName;
			var profile_id_tagid_each=data.proliphiqProfile.tags[i].tagId;
			if (i==0){
			<?php if(!$hide_badge_size)  {?>
			document.getElementById('showSettingsButton').style.display = 'block';
			<?php } ?>
			var x=document.getElementById("cb");
			var cbh = document.getElementById('cb');
			var cb = document.createElement('option');		
			cbh.appendChild(cb);
			cb.name = "Select Topic";		
			cb.value = "1";
			cb.appendChild(document.createTextNode("Select Topic"));
			}	

			var x=document.getElementById("cb");
			var cbh = document.getElementById('cb');
			var cb = document.createElement('option');
			cbh.appendChild(cb);
			cb.name = profile_id_tag_each;
			cb.value = profile_id_tagid_each;
			cb.appendChild(document.createTextNode(profile_id_tag_each));
			$('#cb option').each(function ()
				 {	  
				  if($(this).attr('value')==selected_tag)
				  {
					$(this).attr('selected','slected');

				  }
				 });
			}
			}
		else
		{
		alert("We are unable to find your Proliphiq ID in the Proliphiq.com system.  Please go to http://proliphiq.com and look in your Profile Settings to ensure it is entered correctly.");
		}			
		}
	   };
	    xdr.send();
		}
		else
		{
		$.getJSON(url, function(data) {
		var pro_profile=data.proliphiqProfile;
		if(data.proliphiqProfile != null)
		{
			document.getElementById('tag_name').style.display = 'block';
			var profile_id_tags=data.proliphiqProfile.tags;
			var profile_id_length=profile_id_tags.length;
			var first_tag_size;
			var first_tag_size_name;
			if (profile_id_length<1){
			<?php if(!$hide_badge_size)  {?>
			document.getElementById('showSettingsButton').style.display = 'block';
			<?php } ?>
				var x=document.getElementById("cb");
				var cbh = document.getElementById('cb');
				var cb = document.createElement('option');
				cbh.appendChild(cb);
				cb.name = "OVERALL";
				cb.value = "1";
				cb.appendChild(document.createTextNode("OVERALL"));		
			}
			for(var i=0;i<=profile_id_length;i++)
			{	
			var profile_id_tag_each=data.proliphiqProfile.tags[i].tagName;
			var profile_id_tagid_each=data.proliphiqProfile.tags[i].tagId;
			if (i==0){
			<?php if(!$hide_badge_size)  {?>
			document.getElementById('showSettingsButton').style.display = 'block';
			<?php } ?>
			var x=document.getElementById("cb");
			var cbh = document.getElementById('cb');
			var cb = document.createElement('option');		
			cbh.appendChild(cb);
			cb.name = "Select Topic";		
			cb.value = "1";
			cb.appendChild(document.createTextNode("Select Topic"));
			}	

			var x=document.getElementById("cb");
			var cbh = document.getElementById('cb');
			var cb = document.createElement('option');
			cbh.appendChild(cb);
			cb.name = profile_id_tag_each;
			cb.value = profile_id_tagid_each;
			cb.appendChild(document.createTextNode(profile_id_tag_each));
			$('#cb option').each(function ()
				 {	  
				  if($(this).attr('value')==selected_tag)
				  {
					$(this).attr('selected','slected');

				  }
				 });
			}
		}
		else
		{
			alert("We are unable to find your Proliphiq ID in the Proliphiq.com system.  Please go to http://proliphiq.com and look in your Profile Settings to ensure it is entered correctly.");
		}
		});
		}
		}
		function getjson_onload()
		{

			<?php if(!$hide_badge_size)  {?>
			document.getElementById('badge_size').style.display = 'block';
			<?php } ?>
			
			var getjson_tag = document.getElementById("proliphiq").value;
			 $('#cb').children('option').remove();    
			var pro_url='http://www.proliphiq.com';
			var url=pro_url+"/proliphiq/badge/screenNameSearch?screenName="+getjson_tag+"";			
			if ($.browser.msie && window.XDomainRequest) 
			{ // IE
			   var xdr = new XDomainRequest();
			   xdr.open("get",url);	 
			  xdr.onload = function () 
			  {
		   //parse response as JSON
		   var data = $.parseJSON(xdr.responseText);
		   if (data == null || typeof (data) == 'undefined')
		   {
		   //alert("We are unable to find your Proliphiq ID in the Proliphiq.com system.  Please go to http://proliphiq.com and look in your Profile Settings to ensure it is entered correctly.");
			 //data = $.parseJSON(data.firstChild.textContent);
		   }
		else
			{
			   
				
				var pro_profile=data.proliphiqProfile;
				var profile_id_tags=data.proliphiqProfile.tags;
				var profile_id_length=profile_id_tags.length;
				var first_tag_size;
				var first_tag_size_name;


					if (profile_id_length<1){
					<?php if(!$hide_badge_size)  {?>
					document.getElementById('showSettingsButton').style.display = 'block';
					<?php } ?>
						
						var x=document.getElementById("cb");
						var cbh = document.getElementById('cb');
						var cb = document.createElement('option');
						cbh.appendChild(cb);
						cb.name = "OVERALL";
						cb.value = "1";
						cb.appendChild(document.createTextNode("OVERALL"));		
					}	
				for(var i=0;i<=profile_id_length;i++)
					{	
					document.getElementById('tag_name').style.display = 'block';

					var profile_id_tag_each=data.proliphiqProfile.tags[i].tagName;
					var profile_id_tagid_each=data.proliphiqProfile.tags[i].tagId;
					if (i==0){
					<?php if(!$hide_badge_size)  {?>
					document.getElementById('showSettingsButton').style.display = 'block';
					<?php } ?>
					var x=document.getElementById("cb");
						var cbh = document.getElementById('cb');
						var cb = document.createElement('option');
						cbh.appendChild(cb);
						cb.name = "Select Topic";
						cb.value = "1";
						cb.appendChild(document.createTextNode("Select Topic"));
						}	
						var cbh = document.getElementById('cb');
						var cb = document.createElement('option');
						cbh.appendChild(cb);
						cb.name = profile_id_tag_each;
						cb.value = profile_id_tagid_each;
						cb.appendChild(document.createTextNode(profile_id_tag_each));
						 $('#cb option').each(function ()
						 {	  
						  if($(this).attr('value')==selected_tag)
						  {
							$(this).attr('selected','slected');
						  }
						 });
					}
			   
			   
			   
			   
	   
			}
		};
	    xdr.send();
	}										
	else					
		{																
		$.getJSON(url, function(data) {
		
		var pro_profile=data.proliphiqProfile;
		var profile_id_tags=data.proliphiqProfile.tags;
		var profile_id_length=profile_id_tags.length;
		var first_tag_size;
		var first_tag_size_name;


			if (profile_id_length<1){
			<?php if(!$hide_badge_size)  {?>
			document.getElementById('showSettingsButton').style.display = 'block';
			<?php } ?>
				
				var x=document.getElementById("cb");
				var cbh = document.getElementById('cb');
				var cb = document.createElement('option');
				cbh.appendChild(cb);
				cb.name = "OVERALL";
				cb.value = "1";
				cb.appendChild(document.createTextNode("OVERALL"));		
			}	
		for(var i=0;i<=profile_id_length;i++)
			{	
			document.getElementById('tag_name').style.display = 'block';

			var profile_id_tag_each=data.proliphiqProfile.tags[i].tagName;
			var profile_id_tagid_each=data.proliphiqProfile.tags[i].tagId;
			if (i==0){
			<?php if(!$hide_badge_size)  {?>
			document.getElementById('showSettingsButton').style.display = 'block';
			<?php } ?>
			var x=document.getElementById("cb");
				var cbh = document.getElementById('cb');
				var cb = document.createElement('option');
				cbh.appendChild(cb);
				cb.name = "Select Topic";
				cb.value = "1";
				cb.appendChild(document.createTextNode("Select Topic"));
				}	
				var cbh = document.getElementById('cb');
				var cb = document.createElement('option');
				cbh.appendChild(cb);
				cb.name = profile_id_tag_each;
				cb.value = profile_id_tagid_each;
				cb.appendChild(document.createTextNode(profile_id_tag_each));
				 $('#cb option').each(function ()
				 {	  
				  if($(this).attr('value')==selected_tag)
				  {
					$(this).attr('selected','slected');
				  }
				 });
			}
		});
		}
		}
		
		function display_text()
		{
		document.getElementById("hide_text").style.display='block';
		}
		function hide_text()
		{
		document.getElementById("hide_text").style.display='none';
		}
		function sortby(id)
					{
						var e = document.getElementById("filterby");	
						var filterid = e.options[e.selectedIndex].value;
						document.getElementById("badgename_size").value=filterid;
					}
		function tag_name(id)
						{
						var tagname=document.getElementById("cb")
						var tag_id=tagname.options[tagname.selectedIndex].value;
						var tag_id_name=tagname.options[tagname.selectedIndex].name;
						document.getElementById("tag_size").value=tag_id;
					document.getElementById("tag_size_name").value=tag_id_name;
						}	
	</script>
<?php 
				if($_POST['save'])
				{
					$pro_id=$_POST['proliphiq'];
					$user_id=$_POST['user_id'];
				// See if the user has posted us some information
				// If they did, this hidden field will be set to 'Y'
							if( isset($_POST[ 'settings' ]) && $_POST[ 'settings' ] == 'settings' ) {
								$user_id = 'settings';
							}	
					// see if user is coming on Settings page    		
							if (strpos($_SERVER['REQUEST_URI'],'options-general.php') !== false) {
								$user_id = 'settings';
							}
					$tag_id=$_POST['tag_size'];
					$badge_size=$_POST['badgename_size'];
					$tag_size_name=$_POST['tag_size_name'];
				if(!$badge_size)
				{
					$badge_size=1;
				}
					$search_user_id="select * from prolophique where username='$user_id'";
					$res_search_user_id=mysql_query($search_user_id);
					$fetch_search_user_id=mysql_fetch_array($res_search_user_id);
				if($fetch_search_user_id)
				{
					$id=$fetch_search_user_id['id'];
					$sql_update_pro="UPDATE prolophique
					SET Proliphique_id='$pro_id', badge_size ='$badge_size',tag_id='$tag_id',tag_id_name='$tag_size_name'
					WHERE id=$id";
					mysql_query($sql_update_pro);
				}
				else
				{
				$sql="insert into prolophique(username,Proliphique_id,badge_size,tag_id,tag_id_name)values('$user_id','$pro_id','$badge_size','$tag_id','$tag_size_name')";
				mysql_query($sql);
				}
				}
				if ( !current_user_can( 'edit_user', $user_id ) )
						return false;
					update_usermeta( $user_id, 'proliphiq', $_POST['proliphiq'] );

			}
				
function my_plugin_create_table()

			{
				global $wpdb;
				if($wpdb->get_var("show tables like prolophique") != 'prolophique') 
				{
				$sql = "CREATE TABLE prolophique (
								`id` INT( 100 ) NOT NULL AUTO_INCREMENT ,
								`username` VARCHAR( 100 ) NOT NULL ,
								`Proliphique_id` VARCHAR( 100 ) NOT NULL ,
								`badge_size` VARCHAR( 100 ) NOT NULL ,
								`tag_id` VARCHAR( 100 ) NOT NULL ,
								`tag_id_name` VARCHAR( 100 ) NOT NULL ,
								PRIMARY KEY ( `id` )
								)";
					require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
					dbDelta($sql);
				}
			}
register_activation_hook( __FILE__, 'my_plugin_create_table' );
function pluginUninstall() 
		{
        global $wpdb;
        $table = $wpdb->prefix."prolophique";
		$wpdb->query("DROP TABLE `prolophique`");
		}
register_deactivation_hook( __FILE__, 'pluginUninstall' );

class Proliphic_widget extends WP_Widget

		{
			  function Proliphic_widget()
			  {
				$widget_ops = array('classname' => 'Proliphic_widget', 'description' => 'Show off your credibility by topic and let your readers/community to rate you!');
				$this->WP_Widget('Proliphic_widget', 'Proliphiq Badge', $widget_ops);

			  }
				/** @see WP_Widget::form */
				function form( $instance ) {
					if ( $instance ) {
						$title = esc_attr( $instance[ 'title' ] );
					}
					else {
						$title = __( 'Proliphiq Badge', 'text_domain' );
					}
				?>
				<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
				</p>
				<?php 
				}
			 function widget($args, $instance)
			  {
				extract($args, EXTR_SKIP);
				global $current_user;
				global $wpdb, $post, $wp_version;
				get_currentuserinfo();
				$c_post = $post->ID;
				$c_author_id = $post->post_author;
				$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
				if ($c_author_id!=null){
					$user_id = $c_author_id;
				}
				else
				{
					$user_id = $current_user->ID;
				}
				//this should run on the homepage / frontpage only! you can use more conditions here
				if(is_front_page() || is_home())
				{
					$user_id = 'settings';
				}
				$sql_pro_id="select Proliphique_id,badge_size,tag_id from prolophique where username ='$user_id'";
				$res_pro_id=mysql_query($sql_pro_id);
				$fetch_pro_id=mysql_fetch_array($res_pro_id);			
				$settings_res_pro_id=mysql_query("select Proliphique_id,badge_size,tag_id from prolophique where username ='settings'");
				$fetch_settings_pro_id=mysql_fetch_array($settings_res_pro_id);
				$proliphiq_user_id = $fetch_pro_id['Proliphique_id']; 	
			?>
			<input type="hidden" name="someVar" id="jsonid" value="<?php echo $proliphiq_user_id; ?>" />
			<input type="hidden" name="someVar" id="json_badge_id" value="<?php echo $fetch_settings_pro_id['badge_size']; ?>" />
			<input type="hidden" name="someVar" id="json_tag_id" value="<?php echo $fetch_pro_id['tag_id']; ?>" />
			<script type="text/javascript">
			var tagurl;
			$(document).ready(function(){
			
			var ID=document.getElementById('jsonid').value;
			var pro_url='http://www.proliphiq.com/';
			var badge_size_id=document.getElementById('json_badge_id').value;
			if ((badge_size_id==null)||(badge_size_id=='')){
				//default to small
				badge_size_id=1;
			}			
			var url=pro_url+"proliphiq/badge/screenNameSearch?screenName="+ID+"";
			
			if ($.browser.msie && window.XDomainRequest) 
			{ // IE
			   var xdr = new XDomainRequest();
			   xdr.open("get",url);
			  xdr.onload = function () {
			   //parse response as JSON
			   var data = $.parseJSON(xdr.responseText);
			  // alert(JSON);
			   if (data == null || typeof (data) == 'undefined')
			   {
				// data = $.parseJSON(data.firstChild.textContent);
			   }
			 var profile_id=data.proliphiqProfile.id;
			 $('#tag_id').val(profile_id);
					//document.getElementById('tag_id').value=profile_id;
					var tagname_id=document.getElementById('json_tag_id').value;
					tagurl=pro_url+'proliphiq/view/ratingCard.jsp?id='+profile_id+'_1_'+tagname_id;
					var img_src=pro_url+"phpqBadge/badge/"+profile_id+"_"+badge_size_id+"_1_"+tagname_id+"";
					$('.my_textbox').find('img').attr('src', img_src);
			   };
				xdr.send();
			}
		else
			{
			$.getJSON(url, function(data) {
			var profile_id=data.proliphiqProfile.id;
			document.getElementById('tag_id').value=profile_id;
			var tagname_id=document.getElementById('json_tag_id').value;
			tagurl=pro_url+'proliphiq/view/ratingCard.jsp?id='+profile_id+'_1_'+tagname_id;
			var img_src=pro_url+"phpqBadge/badge/"+profile_id+"_"+badge_size_id+"_1_"+tagname_id+"";
			$('.my_textbox').find('img').attr('src',img_src);
			});
			}
			});
	function openfunc()
			{
			window.open (tagurl,"Rate_this_Proliphiq_User",'width=870,height=541');
			}
			</script>
			<input type="hidden" name="tagid" id="tag_id" value="" />
			<?php
			if($proliphiq_user_id)
				{
				extract( $args );
				$title = apply_filters( 'widget_title', $instance['title'] );
				echo $before_widget;
				if ( !empty( $title ) ) { echo $before_title.$title.$after_title; }
				$html=" <div class='my_textbox ' style='cursor: pointer;margin: 10px 2px;padding:3px;'>";
				 $html.="<img src='' alt='' onclick='openfunc();' class='my_img_proliphiq'/>";            
				  $html.="</div>";
				$content .= $html;
				echo $content;  
				echo $after_widget; 
			  }
			}
		}
add_action( 'widgets_init', create_function('', 'return register_widget("Proliphic_widget");') ); 
// add the admin options page
add_action('admin_menu', 'plugin_admin_add_page');
function plugin_admin_add_page() 
		{
add_options_page('Proliphiq Badge Settings', 'Proliphiq Badge', 'manage_options', 'plugin', 'plugin_options_page');
		}
// display the admin options page
function plugin_options_page() 
			{
					//must check that the user has the required capability 
					if (!current_user_can('manage_options'))
					{
					  wp_die( __('You do not have sufficient permissions to access this page.') );
					}
				?>
				<div>
				<h2>Proliphiq Badge Settings</h2>
				Options relating to the Custom Plugin.
				<form action="" method="post">
				<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
				<?php
				global $current_user;
				$coming_from_settings = 'settings';
				my_show_extra_profile_fields($current_user);
				// See if the user has posted us some information
				// If they did, this hidden field will be set to 'Y'
							if( isset($_POST[ 'settings' ]) && $_POST[ 'settings' ] == 'settings' ) {
								my_save_extra_profile_fields($current_user);
							}
				?>
				<input type="hidden" name="settings" value="settings">
				<input type="submit" id="showSettingsButton" style="display:none;" class="button-primary" name="save" value="Save"/>
				</form></div>
			<?php
			}
function my_scripts_method() 
			{
				wp_deregister_script( 'jquery' );
				wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js');
				wp_enqueue_script( 'jquery' );
				}     
add_action('wp_enqueue_scripts', 'my_scripts_method');
?>
<?php
   /*
   Plugin Name: Logistics
   Description: a simple helper plugin for logistics
   Version: 1.2
   Author: binaryLabs
   Author URI: http://binarylabsolutions.com/
   License: GPL2
   */

add_option('logistics_data', json_encode(array("vehicles"=>array()) ) );


/** Step 1. */
function logistics_menu() {
	add_options_page( 'Logistics Options', 'Logistics', 'manage_options', 'logistics', 'logistics_options' );
}
   /** Step 2 (from text above). */
add_action( 'admin_menu', 'logistics_menu' );





function logistics_html() {
		// jQuery
	wp_enqueue_script('jquery');
	// This will enqueue the Media Uploader script
	wp_enqueue_media();

	?>
	<style type="text/css">
		.hidden {display: none;}
		.c-c > * , .c {display: inline-block;vertical-align: top;position: relative;box-sizing : border-box;}
		.ct {text-align: center;}
		.w-hp, .c-w-hp > * {padding-left: calc(50vw - 500px);padding-right: calc(50vw - 500px);}
		.w10,.c-w10 > * {width: 100%;}
		.w9,.c-w9 > * {width: 90%;}
		.w8 ,.c-w8 > *{width: 80%;}
		.w85 ,.c-w85 > *{width: 85%;}

		.w7,.c-w7 > * {width: 70%;}
		.w75,.c-w75 > * {width: 75%;}

		.w6,.c-w6 > * {width: 60%;}
		.w5,.c-w5 > * {width: 50%;}
		.w4,.c-w4 > * {width: 40%;}
		.w3 ,.c-w3 > *{width: 30%;}
		.w33,.c-w33 > * {width: 33.33%;}
		.w25,.c-w25 > * {width: 25%;}
		.w2,.c-w2 > * {width: 20%;}
		.w15,.c-w15 > * {width: 15%;}
		.w1,.c-w1 > * {width: 10%;}
		.box {background: white;border-radius: 3px; box-shadow: 0px 0px 2px gray;}
		h3 {font-size: 1.1em;}
		textarea {min-height: 170px;}
		li {list-style: none;}
	</style>
	<div>
		<div class="c-w5 c-c">
			<div>
				<h2>Logistics Form</h2>
				<span class="c w3">the short code for the form to show up on the frontend </span><span class="c w1"></span><strong>[logistics_form]</strong>
			</div>
			<div>
				<h2>Manage Truckes</h2>
				<p> add new turcks to the home page as you wish , </p>
				<div>
					<form action="/wp-admin/options-general.php?page=logistics&action=logistics_submits" method="post">
						<li><label class="w3 c">Truck Name</label><input type="text" name="truck_name"></li>
						<li><label class="w3 c">Truck image(png)</label><input class=" button" type="button" name="truck_png"  value="upload image"></li>
						<input type="hidden" name="truck_image" id="truck-upload"/>
						<input type="hidden" name="form_type" value="new"/>

						<li><input class="button button-primary button-large" type="submit" value="save"></li>
					</form>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function($){
					    $('[name="truck_png"]').click(function(e) {
					        e.preventDefault();
					        var image = wp.media({ 
					            title: 'Upload Image',
					            // mutiple: true if you want to upload multiple files at once
					            multiple: false
					        }).open()
					        .on('select', function(e){
					            // This will return the selected image from the Media Uploader, the result is an object
					            var uploaded_image = image.state().get('selection').first();
					            // We convert uploaded_image to a JSON object to make accessing it easier
					            // Output to the console uploaded_image
					            var image_url = uploaded_image.toJSON().url;
					            // Let's assign the url value to the input field
					            $('#truck-upload').val(image_url);
					            
					            var img = $('[name="truck_png"]').siblings("img");
					            img = ( img.length ) ? img : window.jQuery('[name="truck_png"]').parent().append("<img src='' width='70px' />").find("img");

					            img.attr("src" , image_url);
					        });
					    });
					});
				</script>
			</div><div><br/><br/><?php 

			$d = json_decode( get_option("logistics_data"),true );
			
			foreach ($d["vehicles"] as $k => $v) {
				?><div class="box c-c w7" style="display: flex;align-items: center;">
					<img src="<?php echo $v["image"]?>" class="w2" / ><span  class="w1"></span><span  class="w4"><?php echo $v["name"]?></span><?php 

						?><form action="/wp-admin/options-general.php?page=logistics&action=logistics_submits" method="post">
							<input type="hidden" name="form_type" value="delete"/>
							<input type="hidden" name="form_elem" value="<?php echo $k; ?>"/>

							<input class="button button-primary button-large" type="submit" value="delete">
						</form>
				</div><?php 
			}
			?></div>
			<div>
				<h2>Logistics Email</h2>
				<p>set the email where the customer query will be send</p>
				<form action="/wp-admin/options-general.php?page=logistics&action=logistics_submits" method="post">
					
					<input type="hidden" name="form_type" value="email"/><?php
					$email = ( isset($d["email"]) ) ? $d["email"] : "";
					?><input type="text" name="form_email" value="<?php echo $email; ?>"/>

					<input class="button button-primary button-large" type="submit" value="save email">
				</form>
			</div>

			<div>
				<h2>Logistics text data</h2>
				<p>set the text data that will be shown on the forntend</p>
				<form action="/wp-admin/options-general.php?page=logistics&action=logistics_submits" method="post">
						<div><h3> Section 1 : select truck</h3></div>
						<li><label class="w3 c">Heading</label><input type="text" name="text[0][heading]" value="<?php echo $d["text"][0]["heading"]  | ""; ?>"></li>
						<li><label class="w3 c">sub text</label><textarea class="w6"  name="text[0][sub]"><?php echo $d["text"][0]["sub"]  | ""; ?></textarea></li>
						


						<div><h3> Section 2 : select locations</h3></div>
						<li><label class="w3 c">Heading</label><input type="text" name="text[1][heading]" value="<?php echo $d["text"][1]["heading"]  | ""; ?>"></li>
						<li><label class="w3 c">sub text</label><textarea class="w6"  name="text[1][sub]"><?php echo $d["text"][1]["sub"]  | ""; ?></textarea></li>

						

						<div><h3> Section 3 : select pickup date</h3></div>
						<li><label class="w3 c">Heading</label><input type="text" name="text[2][heading]" value="<?php echo $d["text"][2]["heading"]  | ""; ?>"></li>
						<li><label class="w3 c">sub text</label><textarea class="w6"  name="text[2][sub]"><?php echo $d["text"][2]["sub"]  | ""; ?></textarea></li>


						<div><h3> Section 4 : base info</h3></div>
						<li><label class="w3 c">Heading</label><input type="text" name="text[3][heading]" value="<?php echo $d["text"][3]["heading"]  | ""; ?>"></li>
						<li><label class="w3 c">sub text</label><textarea class="w6"  name="text[3][sub]"><?php echo $d["text"][3]["sub"]  | ""; ?></textarea></li>


						<input type="hidden" name="form_type" value="text"/>
						<li><input class="button button-primary button-large" type="submit" value="save"></li>
					</form>
					
			</div><div >
					<p>set the text data that will be shown on the sucess and error page</p>
				<form action="/wp-admin/options-general.php?page=logistics&action=logistics_submits" method="post">
					<li class="w10 c-c"><label class="w2 c"><strong>Sucess Massage</strong></label><br/></li>
					
					<li class="w10 c-c"><label class="w2">Heading </label><input type="text" name="text[sucess][heading]" value="<?php echo $d["text"]["sucess"]["heading"]  | ""; ?>" class="w7"></li>

					<li class="w10 c-c"><label class="w2">inforamtion </label><textarea class="w7" type="text" name="text[sucess][sub]" ><?php echo $d["text"]['sucess']["sub"]  | ""; ?></textarea></li>

					<li class="w10 c-c"><label class="w2 c"><strong>Error Massage</strong></label><br/></li>
					
					<li class="w10 c-c"><label class="w2">Heading </label><input class="w7" type="text" name="text[error][heading]" value="<?php echo $d["text"]["error"]["heading"]  | ""; ?>"></li>
					<li class="w10 c-c"><label class="w2">inforamtion </label><textarea class="w7" type="text" name="text[error][sub]" ><?php echo $d["text"]['error']["sub"]  | ""; ?></textarea></li>

					<input type="hidden" name="form_type" value="text"/>
						<li><input class="button button-primary button-large" type="submit" value="save"></li>

				</form>

			</div>

		</div>
	</div>
	<?php
}





function logistics_form_add_subbmit($d) {
	$l = json_decode( get_option("logistics_data") , ture );
	$strfy = str_replace(" ", "-", $d["truck_name"]);
	$l["vehicles"][$strfy] = array("name" => $d["truck_name"] , "image" => $d["truck_image"]) ;
	update_option("logistics_data" , json_encode($l) );

}
function logistics_form_delete_subbmit($d) {
	$l = json_decode( get_option("logistics_data") , ture );
	unset($l["vehicles"][ $d["form_elem"] ]); 
	update_option("logistics_data" , json_encode($l) );
}
function logistics_form_email_subbmit($d) {
	$l = json_decode( get_option("logistics_data") , ture );
	
	$l["email"] =  $d["form_email"] ; 

	update_option("logistics_data" , json_encode($l) );
}
function logistics_form_text_subbmit($d) {
	$l = json_decode( get_option("logistics_data") , ture );
	foreach (  $d["text"] as $key => $value) {
		$l["text"][$key] =  $value ; 
	}
	
	update_option("logistics_data" , json_encode($l) );
}

/** Step 3. */
function logistics_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} 
	if ( isset($_POST["form_type"] ) ) {
		if ( $_POST["form_type"] == "new") 		logistics_form_add_subbmit($_POST);
		if ( $_POST["form_type"] == "delete") 	logistics_form_delete_subbmit($_POST);
		if ( $_POST["form_type"] == "email") 	logistics_form_email_subbmit($_POST);
		if ( $_POST["form_type"] == "text") 	logistics_form_text_subbmit($_POST);



	}
	

	logistics_html();
}
































/******************************************

window.hs = ( typeof window.hs == "undefined" ) ? {} : window.hs;
	window.hs.$ = window.jQuery;
	window.hs.data = {};
	window.hs.truckes = [<?php 
			
			foreach ($d["vehicles"] as $key => $v) {
				echo '{ "name" : "'.$v["name"].'", "thumbnail" : "'.$v["image"].'"},';
			}
		?>];

	(function($){
		$(document).ready(function(){
			var elem = $("#hs-interactive-form");
			// on which page we are
			if ( $("body").hasClass("home") ) {
				if ( $("#slider").length )
				elem.insertAfter( $("#slider") ).css("display" , "block");
			
			} else {
				elem.insertAfter( $(".btContent").children().last() ).css("display" , "block");
				
			}
			


			window.hs.slideNext = function () {
				var atv = $(".active-page") ;
				if ( atv.length ) {
					atv.animate({opacity: 0, position: "absolute",left: "-=150"}, 200, function() {
						atv.css("display", "none").removeClass("active-page");
						atv.next().css("display", "block")
						atv.next().animate({opacity: 1, left: "-=150"}, 500).addClass("active-page");
					});
				} else {
					atv = $(".slide-section").first();
					atv.css("display", "block")
					atv.animate({opacity: 1, left: "-=150"}, 500).addClass("active-page");
				}
				
			}

			window.hs.slidePrev = function () {
				var atv = window.jQuery(".active-page") ;
				if ( atv.length ) {
					atv.animate({opacity: 0, position: "absolute",left: "+=150"}, 200, function() {
						atv.css("display", "none").removeClass("active-page");
						atv.prev().css("display", "block")
						atv.prev().animate({opacity: 1, left: "+=150"}, 500).addClass("active-page");
					});
				} 
			}
			window.hs.autocomplete = {};

			$.each(window.hs.truckes, function(k,v){
				$id = v.name.split(' ').join('-').toLowerCase();
				elem.find(".select-trucks .container").append('<label for="truck_'+$id +'" ><img src="'+ v.thumbnail + '"><p>'+v.name+'</p><div class="hidden"><input id="truck_'+$id +'" name="truck" value="'+$id+'" type="radio" ></div></label>');
			});

			elem.find("[name='truck']").click(function(e){
				$(".slide-section.company-info .extra_added").remove()
				if ( $(this).val() == "reefer" ) {
					if ( !$(".slide-section.company-info .added_temprature").length )
						$(".slide-section.company-info ul").append('<li class="added_temprature extra_added"><label>Temperature</label><input type="number" name="temprature" placeholder="Fahrenheit Temperature Value"></li>')
				} else if (  $(this).val() == "flatbed" ) {
					if ( !$(".slide-section.company-info .added_traps").length )
						$(".slide-section.company-info ul").append('<li class="added_traps extra_added"><label>Tarps Required</label><input type="radio" name="Tarps" value="yes"> yes <input type="radio" name="Tarps" value="no"> No </li>')
				} 
				window.hs.slideNext();	
				
				
			});

			$(".add-inputs").find(".container").append("<ul></ul><div class='icons'><button type='button' class='button-add'  /><button type='button' class='button-sub'/></div>");
			
			window.hs.distance = function() {
				var lis = $(".locations-container li");
				// google maps calcualte distance
				$f = lis.first().find("input").val();
				$l =  lis.last().find("input").val();
				if ( !( $f && $l ) ) return ;

				var mids = [];
				if ( lis.length > 2 ) {
					lis.each(function(k,v) {
						if ( k == 0 || k == (lis.length-1) ) return 1;
						mids.push({
							location: $(v).find("input").val(),
        					stopover: true
						});
					})
				}
				

				
				if ( mids.length ) {
					$options = {
					    origin: $f,
					    destination: $l,
					    travelMode: 'DRIVING',
					    unitSystem: google.maps.UnitSystem.METRIC,
					    avoidHighways: false,
					    avoidTolls: false,
					}
					$options.waypoints = mids;
					$options.optimizeWaypoints= true;
					var directionsService = new google.maps.DirectionsService();

					directionsService.route($options, function(response, status) {
    					var total_distance = 0.0;
					    for (var i=0; i<response.routes[0].legs.length; i++) {
					        total_distance += response.routes[0].legs[i].distance.value;
					    }
					    console.log(total_distance);
					    var m = total_distance / 1609.34;
					    hs.$("#hs-interactive-form form").prepend("<input type='hidden' name='distance' value='"+m+"' />");

    				});

				} else {
					$options = {
					    origins: [$f],
					    destinations: [$l],
					    travelMode: 'DRIVING',
					    unitSystem: google.maps.UnitSystem.METRIC,
					    avoidHighways: false,
					    avoidTolls: false,
					}
					var service = new google.maps.DistanceMatrixService();
					service.getDistanceMatrix( $options , function callback(response, status) {
					 	if ( status == google.maps.DirectionsStatus.OK ) {
					 		var e = response.rows[0].elements[0];
					 		var m = e.distance.value / 1609.34;
					 		hs.$("#hs-interactive-form form").prepend("<input type='hidden' name='distance' value='"+m+"' />");
					 	}
					 	
					});
				}

				
				
			}

			$(".add-inputs").find("button").click(function(e){
				e.preventDefault();
				if ( $(this).hasClass("button-add") ) {

					$main =  $(this).parents(".add-inputs");
					$ul = $main.find("ul");

					var index = $ul.find("li").length;
					var name = $main.attr("data-type")+"["+ index +"]";

					$ul.append(
						"<li><span>"+(index+1) +". </span>"+"<input type='text' placeholder='add "+ $main.attr("data-type") +" location' required name='"+name +"'></li>"
						);
					
					var input = $('[name="' +name+ '"]' );	
					
					window.hs.autocomplete[name] = new google.maps.places.Autocomplete(input[0]);
					input.on("change paste blur" , function(){

						var ths = $(this);
						var geocoder = new google.maps.Geocoder();
						geocoder.geocode({'address': ths.val() }, function(results, status){

					        if (status === google.maps.GeocoderStatus.OK && results.length > 0) {
					        	ths.addClass("ok").removeClass("warning" ).removeClass("error");
					        } else if ( ths.val().length  ){
					        	ths.addClass("warning").removeClass("ok").removeClass("error");
					        } else {
					        	ths.addClass("error").removeClass("warning").removeClass("ok");
					        }
					        window.hs.distance();
					    });
					   
					});

					

				
				} else {
					$ul = $(this).parents(".add-inputs").find("ul");
					$ul.find("li").last().remove();
				}
				
			});
			$(".add-inputs").find("button.button-add").trigger("click");
		
			

			$(".next-location").click(function(e) {
				e.preventDefault();
				window.hs.data.distance;
				
				$(".pick-up-inputs").find("input").each(function(k,v) {
					if ( $(v).val().length == 0 ) {
						$(v).addClass("error");

					}
				});
				if ( $(".pick-up-inputs").find("input.error").length ) {
					return;
				}


				if ( $(".pick-up-inputs").find(".warning").length ) {
					if ( !confirm("unable to find location, still want to continue ") ) {
						return;
					};
				} 
				window.hs.slideNext();



			});
			setInterval(function() {
				window.jQuery("add-inputs  input[type='text']").each(function(k,v) {
					window.jQuery(v).trigger("keyup");
				})
			} , 2000);

			window.hs.slideNext();

			$(".next-slide").click(function(e){
				e.preventDefault();
				window.hs.slideNext();
			});
			$(".prev-slide").click(function(e){
				e.preventDefault();
				window.hs.slidePrev();
			});

			var d =  new Date();
			var d =  d.getFullYear()  + "/" + (d.getMonth()+1) + "/" + d.getDate();
			
			$("#pick_date").val(d).datetimepicker({
				inline:true,
				format:'Y/m/d',
				timepicker:false,
				minDate:'-1970/01/02',
				todayButton: 'false',
			});
			$("#deliver_date").val(d).datetimepicker({
				inline:true,
				format:'Y/m/d',
				timepicker:false,
				minDate:'-1970/01/02',
				todayButton: 'false',
			});

			jQuery('#hs-interactive-form form').submit( function() {            
		       
		        x = {};
		        x.hsForm = {};
				window.jQuery("#hs-interactive-form form").find("input").each(function(k,v){
					
					var name = hs.$(v).attr("name") || "";
					if (name.length) {
						if ( hs.$(v).attr("type") != "radio" ) {
							name = name.replace("[","_").replace("]","");
							x.hsForm[name] = window.jQuery(v).val();	
						} else {
							if(window.jQuery(v).prop("checked") )
								x.hsForm[name] = window.jQuery(v).filter("*:checked").val();
						}
						
					}
				   	
				});
				console.log(x);
				$.ajax({
		            url     : $(this).attr('action'),
		            type    : $(this).attr('method'),
		            data 	: x,
		            success : function( data ) {
		            			window.jQuery(".form-responce").addClass("sucess")
		                        window.hs.slideNext();
		                     },
		            error   : function( xhr, err ) {
		            			window.jQuery(".form-responce").addClass("error")
		                        window.hs.slideNext();
		                      }
		        });    
		        return false;
		    });

			
		})
	})(window.jQuery)
	


************************/



/*fornt end */



function logistics_form_function( $atts ){
	
	wp_enqueue_script('jquery');
	wp_enqueue_style( 'logistics-styles', plugins_url( 'assets/logistics.css', __FILE__ ) );
    $d = json_decode( get_option("logistics_data"),true );
   
	?><script type="text/javascript" src="<?php echo plugins_url( 'assets/logistics.js', __FILE__ ); ?>"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDEoQ5zG4ZA9VyzeoekC1VnzT_zfLU8A5E&libraries=places"></script>
<script type="text/javascript">
	
	window.hs = ( typeof window.hs == "undefined" ) ? {} : window.hs;
	window.hs.$ = window.jQuery;
	window.hs.data = {};
	window.hs.truckes = [<?php 
			
			foreach ($d["vehicles"] as $key => $v) {
				echo '{ "name" : "'.$v["name"].'", "thumbnail" : "'.$v["image"].'"},';
			}
		?>];
!function(e){e(document).ready(function(){var t=e("#hs-interactive-form");t.css("display","block"),window.hs.slideNext=function(){var t=e(".active-page");t.length?t.animate({opacity:0,position:"absolute",left:"-=150"},200,function(){t.css("display","none").removeClass("active-page"),t.next().css("display","block"),t.next().animate({opacity:1,left:"-=150"},500).addClass("active-page")}):(t=e(".slide-section").first(),t.css("display","block"),t.animate({opacity:1,left:"-=150"},500).addClass("active-page"))},window.hs.slidePrev=function(){var e=window.jQuery(".active-page");e.length&&e.animate({opacity:0,position:"absolute",left:"+=150"},200,function(){e.css("display","none").removeClass("active-page"),e.prev().css("display","block"),e.prev().animate({opacity:1,left:"+=150"},500).addClass("active-page")})},window.hs.autocomplete={},e.each(window.hs.truckes,function(e,i){$id=i.name.split(" ").join("-").toLowerCase(),t.find(".select-trucks .container").append('<label for="truck_'+$id+'" ><img src="'+i.thumbnail+'"><p>'+i.name+'</p><div class="hidden"><input id="truck_'+$id+'" name="truck" value="'+$id+'" type="radio" ></div></label>')}),t.find("[name='truck']").click(function(t){e(".slide-section.company-info .extra_added").remove(),"reefer"==e(this).val()?e(".slide-section.company-info .added_temprature").length||e(".slide-section.company-info ul").append('<li class="added_temprature extra_added"><label>Temperature</label><input type="number" name="temprature" placeholder="Fahrenheit Temperature Value"></li>'):"flatbed"==e(this).val()&&(e(".slide-section.company-info .added_traps").length||e(".slide-section.company-info ul").append('<li class="added_traps extra_added"><label>Tarps Required</label><input type="radio" name="Tarps" value="yes"> yes <input type="radio" name="Tarps" value="no"> No </li>')),window.hs.slideNext()}),e(".add-inputs").find(".container").append("<ul></ul><div class='icons'><button type='button' class='button-add'  /><button type='button' class='button-sub'/></div>"),window.hs.distance=function(){var t=e(".locations-container li");if($f=t.first().find("input").val(),$l=t.last().find("input").val(),$f&&$l){var i=[];if(t.length>2&&t.each(function(n,a){return 0==n||n==t.length-1?1:void i.push({location:e(a).find("input").val(),stopover:!0})}),i.length){$options={origin:$f,destination:$l,travelMode:"DRIVING",unitSystem:google.maps.UnitSystem.METRIC,avoidHighways:!1,avoidTolls:!1},$options.waypoints=i,$options.optimizeWaypoints=!0;var n=new google.maps.DirectionsService;n.route($options,function(e,t){for(var i=0,n=0;n<e.routes[0].legs.length;n++)i+=e.routes[0].legs[n].distance.value;console.log(i);var a=i/1609.34;hs.$("#hs-interactive-form form").prepend("<input type='hidden' name='distance' value='"+a+"' />")})}else{$options={origins:[$f],destinations:[$l],travelMode:"DRIVING",unitSystem:google.maps.UnitSystem.METRIC,avoidHighways:!1,avoidTolls:!1};var a=new google.maps.DistanceMatrixService;a.getDistanceMatrix($options,function(e,t){if(t==google.maps.DirectionsStatus.OK){var i=e.rows[0].elements[0],n=i.distance.value/1609.34;hs.$("#hs-interactive-form form").prepend("<input type='hidden' name='distance' value='"+n+"' />")}})}}},e(".add-inputs").find("button").click(function(t){if(t.preventDefault(),e(this).hasClass("button-add")){$main=e(this).parents(".add-inputs"),$ul=$main.find("ul");var i=$ul.find("li").length,n=$main.attr("data-type")+"["+i+"]";$ul.append("<li><span>"+(i+1)+". </span><input type='text' placeholder='add "+$main.attr("data-type")+" location' required name='"+n+"'></li>");var a=e('[name="'+n+'"]');window.hs.autocomplete[n]=new google.maps.places.Autocomplete(a[0]),a.on("change paste blur",function(){var t=e(this),i=new google.maps.Geocoder;i.geocode({address:t.val()},function(e,i){i===google.maps.GeocoderStatus.OK&&e.length>0?t.addClass("ok").removeClass("warning").removeClass("error"):t.val().length?t.addClass("warning").removeClass("ok").removeClass("error"):t.addClass("error").removeClass("warning").removeClass("ok"),window.hs.distance()})})}else $ul=e(this).parents(".add-inputs").find("ul"),$ul.find("li").last().remove()}),e(".add-inputs").find("button.button-add").trigger("click"),e(".next-location").click(function(t){t.preventDefault(),window.hs.data.distance,e(".pick-up-inputs").find("input").each(function(t,i){0==e(i).val().length&&e(i).addClass("error")}),e(".pick-up-inputs").find("input.error").length||(!e(".pick-up-inputs").find(".warning").length||confirm("unable to find location, still want to continue "))&&window.hs.slideNext()}),setInterval(function(){window.jQuery("add-inputs  input[type='text']").each(function(e,t){window.jQuery(t).trigger("keyup")})},2e3),window.hs.slideNext(),e(".next-slide").click(function(e){e.preventDefault(),window.hs.slideNext()}),e(".prev-slide").click(function(e){e.preventDefault(),window.hs.slidePrev()});var i=new Date,i=i.getFullYear()+"/"+(i.getMonth()+1)+"/"+i.getDate();e("#pick_date").val(i).datetimepicker({inline:!0,format:"Y/m/d",timepicker:!1,minDate:"-1970/01/02",todayButton:"false"}),e("#deliver_date").val(i).datetimepicker({inline:!0,format:"Y/m/d",timepicker:!1,minDate:"-1970/01/02",todayButton:"false"}),jQuery("#hs-interactive-form form").submit(function(){return x={},x.hsForm={},window.jQuery("#hs-interactive-form form").find("input").each(function(e,t){var i=hs.$(t).attr("name")||"";i.length&&("radio"!=hs.$(t).attr("type")?(i=i.replace("[","_").replace("]",""),x.hsForm[i]=window.jQuery(t).val()):window.jQuery(t).prop("checked")&&(x.hsForm[i]=window.jQuery(t).filter("*:checked").val()))}),console.log(x),e.ajax({url:e(this).attr("action"),type:e(this).attr("method"),data:x,success:function(e){window.jQuery(".form-responce").addClass("sucess"),window.hs.slideNext()},error:function(e,t){window.jQuery(".form-responce").addClass("error"),window.hs.slideNext()}}),!1})})}(window.jQuery);

</script><?php

?><div id="hs-interactive-form"><?php
	?><form method="post" method="post" action="/hs-api/"><?php
		?><div class="distance" style="display: none;"></div><?php

		?><div class="c-w-hp ct"><?php
			
			?><div class="slide-section select-trucks ct w-hp "><?php
				?><h3 class="s8 mauto"><?php echo $d["text"][0]["heading"]  | ""; ?></h3><?php
				?><p class="s8 mauto"><?php echo $d["text"][0]["sub"]  | ""; ?></p><?php
				?><div class="container c-c w8 mauto c-w33 c-s5"></div><?php
			?></div><?php

			?><div class="slide-section locations-container "><?php
				?><h3 class="s8 mauto"><?php echo $d["text"][1]["heading"]  | ""; ?></h3><?php
				?><p class="s8 mauto"><?php echo $d["text"][1]["sub"]  | ""; ?></p><?php

				?><div class="pick-up-inputs add-inputs " data-type="pickup"><?php
					?><h4>Pick up location</h4><?php
					?><div class="container  mauto w9 s7 c"></div><?php
				?></div><?php
				?><div class="drop-off-inputs add-inputs " data-type="delivery"><?php
					?><h4>Dropoff location</h4><?php
					?><div class="container  mauto w9 s7 c"></div><?php

				?></div><?php
				?><br/><?php
				?><div class="action-buttons"><?php
					
					?><button class="back-location prev-slide"> Back </button><?php
					?><button class="next-location"> Next </button><?php

				?></div><?php

			?></div><?php

			?><div class="slide-section"><?php
				?><h3 class="s8 mauto"><?php echo $d["text"][2]["heading"]  | ""; ?></h3><?php
				?><p class="s8 mauto"><?php echo $d["text"][2]["sub"]  | ""; ?></p><?php
				
				?><div class="c-c c-w5"><?php

					?><div><?php
						?><div>Pick up date</div><?php
						?><input name="pick_date" id="pick_date" /><?php
					?></div><?php

					?><div><?php
						?><div>drop off date</div><?php
						?><input name="deliver_date" id="deliver_date" /><?php
					?></div><?php
				?></div><?php

				
				?><br/><?php
				?><br/><?php
				?><div class="action-buttons"><?php
					
					?><button class="date-location prev-slide"> Back </button><?php
					?><button class="next-slide"> Next </button><?php

				?></div><?php
			?></div><?php




			?><div class="slide-section company-info"><?php
				?><h3 class="s8 mauto"><?php echo $d["text"][3]["heading"]  | ""; ?></h3><?php
				?><p class="s8 mauto"><?php echo $d["text"][3]["sub"]  | ""; ?></p><?php
				?><ul class="c-c c-w5 c-s10 w9 s7 mauto"><?php
					?><li><?php
						?><label>company</label><?php
						?><input name="company"  required /><?php
					?></li><li><?php
						?><label>Name</label><?php
						?><input name="name" required  /><?php
					?></li><li><?php
						?><label>Phone</label><?php
						?><input name="phone" type="tel"  required /><?php
					?></li><li><?php
						?><label>Email</label><?php
						?><input name="email" type="email" required /><?php
					?></li><?php

				?></ul><?php
				?><div class="action-buttons"><?php
					?><button class="date-location prev-slide"> Back </button><?php
					?><input type="submit" value="SIONOW"><?php
				?></div><?php
				
			?></div><?php

			?><div class="slide-section form-responce"><?php
				?><div class="sucess"><?php
					?><h3><?php echo $d["text"]["sucess"]["heading"]; ?></h3><?php
					?><p><?php echo $d["text"]["sucess"]["sub"]; ?></p><?php
				?></div><?php
				?><div class="error"><?php
					?><h3><?php echo $d["text"]["sucess"]["heading"]; ?></h3><?php
					?><p><?php echo $d["text"]["sucess"]["sub"]; ?></p><?php
				?></div><?php
				?><a href="/"> thanks you </a><?php
				

			?></div><?php
		?></div><?php
	?></form><?php
?></div><?php

}

add_shortcode( 'logistics_form', 'logistics_form_function' );
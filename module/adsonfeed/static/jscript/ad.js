$Behavior.adsOnFeed_ad = function()
{
	$('#type_id').change(function()
	{
		$('.js_add_hidden').hide();
		
		if (this.value == 2)
		{
			$('#type_image').show();
			$('#type_image_link').show();
		}
		else if (this.value == 1 || this.value == 3)
		{
			$('#type_html').show();
			$('#type_image_link').hide();
		}
	});
	
	if ($('#type_id').val() == 2)
	{
        $('.js_add_hidden').hide();
		$('#type_image').show();
		$('#type_image_link').show();		
	}
	else if ($('#type_id').val() == 1 || $('#type_id').val() == 3)
	{
        $('.js_add_hidden').hide();
		$('#type_html').show();
		$('#type_image_link').hide();		
	}
};

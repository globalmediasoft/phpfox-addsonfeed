<?php 
defined('PHPFOX') or exit('NO DICE!'); 
?>
<form method="post" enctype="multipart/form-data" action="">
    {if $bIsEdit}
        <div><input type="hidden" name="val[type_id]" value="{$aForms.type_id}" id="type_id" /></div>
        <div><input type="hidden" name="val[id]" value="{$aForms.ad_id}" /></div>
    {/if}
    <div class="table_header">
        {phrase var='adsonfeed.ads_detail'}
    </div>
    <div class="table">
        <div class="table_left">
            {phrase var='adsonfeed.title'}
        </div>
        <div class="table_right">
            <input type="text" value="{value type='input' id='name'}" name="val[name]" size="50">
        </div>
    </div>
    <div class="table">
        <div class="table_left">
            {phrase var='adsonfeed.type'}
        </div>
        <div class="table_right">
            <select name="val[type_id]" id="type_id">
                <option value="1"{value type='select' id='type_id' default='1'}>{phrase var='adsonfeed.html'}</option>
                <option value="2"{value type='select' id='type_id' default='2'}>{phrase var='adsonfeed.image'}</option>
                <option value="3"{value type='select' id='type_id' default='3'}>{phrase var='adsonfeed.dynamic_ads_html'}</option>
            </select>
        </div>
    </div>
    <div class="table js_add_hidden" id="type_html">
        <div class="table_left">
            {phrase var='adsonfeed.content'}
        </div>
        <div class="table_right">
            <textarea cols="50" rows="10" name="val[html_code]">{if $bIsEdit && isset($aForms.html_code)}{$aForms.html_code}{/if}</textarea>
        </div>
    </div>
    <div class="table js_add_hidden" id="type_image" style="display: none;">
        <div class="table_left">
            {phrase var='adsonfeed.content'}
        </div>
        <div class="table_right">
            {if $bIsEdit}
                <div id="js_ad_banner">
                    {img file=$aForms.image_path path='ad.url_image' server_id=$aForms.server_id max_width=400 max_height=300}
                    <div class="extra_info">
                        {phrase var='adsonfeed.click_here_to_change_this_banner_image'}
                    </div>
                </div>
            {/if}		
			<div id="js_ad_upload_banner"{if $bIsEdit} style="display:none;"{/if}>
				<input type="file" name="image" size="30" />
                {if $bIsEdit} - <a href="#" onclick="$('#js_ad_upload_banner').hide(); $('#js_ad_banner').show(); return false;">{phrase var='adsonfeed.cancel'}</a>{/if}
				<div class="extra_info">
					{phrase var='adsonfeed.you_can_upload_a_jpg_gif_or_png_file'}
				</div>		
			</div>
        </div>
    </div>
    <div class="table js_add_hidden" id="type_image_link" style="display: none;">
        <div class="table_left">
            {phrase var='adsonfeed.link'}
        </div>
        <div class="table_right">
            <input type="text" name="val[url_link]" value="{value type='input' id='url_link'}" id="url_link" size="40" />
        </div>
    </div>
    <div class="table_clear">
        <input type="submit" class="button" value="{phrase var='core.submit'}">
    </div>
</form>
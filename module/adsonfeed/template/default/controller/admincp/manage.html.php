<?php 

 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<form method="post" action="{url link='admincp.adsonfeed.manage'}">
	<div class="table_header">
		{phrase var='adsonfeed.ad_filter'}
	</div>	
    <div class="table">
        <div class="table_left">
            {phrase var='adsonfeed.search_for_text'}: 
        </div>
        <div class="table_right">
            {$aFilters.search}
        </div>
        <div class="clear"></div>
    </div>
	<div class="table">
		<div class="table_left">
			{phrase var='adsonfeed.display'}: 
		</div>
		<div class="table_right">
			{$aFilters.display}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table">
		<div class="table_left">
			{phrase var='adsonfeed.sort_by'}: 
		</div>
		<div class="table_right">
			{$aFilters.sort} {$aFilters.sort_by}
		</div>
		<div class="clear"></div>
	</div>
	<div class="table_clear">
		<input type="submit" name="search[submit]" value="{phrase var='core.submit'}" class="button" />
		<input type="submit" name="search[reset]" value="{phrase var='core.reset'}" class="button" />	
	</div>
</form>

<br />

{pager}

{if count($aAds)}
<div class="table_header">
	{phrase var='adsonfeed.ads'}
</div>
<form method="post" action="{url link='admincp.ad'}">	
	<table>
	<tr>
		<th style="width:20px;"></th>
		<th style="width:30px;">{phrase var='adsonfeed.id'}</th>
		<th>{phrase var='adsonfeed.title'}</th>
		<th>{phrase var='adsonfeed.type'}</th>
		<th>{phrase var='adsonfeed.created'}</th>
	</tr>	
	{foreach from=$aAds key=iKey item=aAd}
	<tr class="{if is_int($iKey/2)} tr{else}{/if}">
		<td class="t_center">
			<a href="#" class="js_drop_down_link" title="{phrase var='adsonfeed.manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
			<div class="link_menu">
				<ul>
					<li><a href="{url link='admincp.adsonfeed.add' id=$aAd.ad_id}">{phrase var='adsonfeed.edit'}</a></li>		
					<li><a href="{url link='admincp.ad' delete=$aAd.ad_id}" onclick="return confirm('{phrase var='admincp.are_you_sure' phpfox_squote=true}');">{phrase var='adsonfeed.delete'}</a></li>
				</ul>
			</div>		
		</td>		
		<td class="t_center"><a href="{url link='admincp.adsonfeed.add' id=$aAd.ad_id}">{$aAd.ad_id}</a></td>
		<td>{$aAd.name|clean|convert}</td>
		<td>{if $aAd.type_id == 1}{phrase var='adsonfeed.html'}{elseif $aAd.type_id == 2}{phrase var='adsonfeed.image'}{else}{phrase var='adsonfeed.dynamic_ads_html'}{/if}</td>
        <td>{$aAd.time_stamp|date:'core.global_update_time'}</td>
	</tr>
	{/foreach}
	</table>
	<div class="table_clear"></div>
</form>
{else}
<div class="extra_info">
{if $bIsSearch}
	{phrase var='adsonfeed.no_search_results_were_found'}
{else}
	{phrase var='adsonfeed.no_ads_have_been_created'}
	<ul class="action">
		<li><a href="{url link='admincp.adsonfeed.add'}">{phrase var='adsonfeed.add_a_new_ad'}</a></li>
	</ul>
{/if}
</div>
{/if}

{pager}
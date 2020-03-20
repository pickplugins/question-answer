<?php	


/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com


*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


$templates_data_html['answer_voteup'] = '<div style="background: #f5f5f5; color: #333; font-size: 14px; line-height: 20px; font-family: Arial, sans-serif;">
<div style="width: 600px; margin: 0 auto;">

<div class="header" style="border-bottom: 1px solid #ddd; padding: 20px 0; text-align: center;"><img src="{site_logo_url}"/></div>


<div class="content" style="padding: 10px 0 40px;">
<p style="font-size: 14px; line-height: 20px; color: #333; font-family: Arial, sans-serif;"><strong>{user_name}</strong> voted up on this answer.</p>
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="user_avatar" valign="top" width="80">
<div style="width: 60px; height: 60px; background: #ddd; text-align: center; word-wrap: break-word; margin-right:20px">{user_avatar}</div>
</td>
<td valign="top">
<p style="font-size: 14px; line-height: 20px; color: #333; font-family: Arial, sans-serif;">
<a style="text-decoration: none; color: #51b3ff;font-size:15px;" href="{answer_url}">{answer_title}</a><br />
{answer_content}</p>

</td>
</tr>
</tbody>
</table>
</div>


<div class="footer" style="border-top: 1px solid #ddd; padding: 20px 0; clear: both; text-align: center;"><small style="font-size: 11px;">{site_name} - {site_description}</small></div>
</div>
</div>';
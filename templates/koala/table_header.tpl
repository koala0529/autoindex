<div>{words:index of} {info:path_nav}</div>
{if:search_enabled}
<table><tbody>
  <tr>
   <td>
    <img src="{config:icon_path}search.png" width="16" height="16" alt="{words:search}" />
   </td>
  <td>
   {info:search_box}
  </td>
  </tr>
</tbody></table>
  {end if:search_enabled}
<table class="autoindex_table">
 <tr>
  <th class="autoindex_th">
   <a class="plain_link" href="{sort:filename}" title="{words:sort by} {words:file}">{words:file}</a>
  </th>
  {if:download_count}
  <th class="autoindex_th">
   <a class="plain_link" href="{sort:downloads}" title="{words:sort by} {words:downloads}">{words:downloads}</a>
  </th>
  {end if:download_count}
  <th class="autoindex_th">
   <a class="plain_link" href="{sort:size}" title="{words:sort by} {words:size}">{words:size}</a>
  </th>
  <th class="autoindex_th">
   <a class="plain_link" href="{sort:m_time}" title="{words:sort by} {words:date}">{words:date}</a>
  </th>
  {if:description_file}
  <th class="autoindex_th">
   <a class="plain_link" href="{sort:description}" title="{words:sort by} {words:description}">{words:description}</a>
  </th>
  {end if:description_file}
 </tr>
 



 

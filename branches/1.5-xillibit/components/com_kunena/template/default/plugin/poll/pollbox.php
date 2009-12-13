<?php
// Dont allow direct linking
defined( '_JEXEC' ) or die('Restricted access');

$app =& JFactory::getApplication();
$document =& JFactory::getDocument();
$id = intval(JRequest::getVar("id", ""));
$catsallowed = explode(',',$fbConfig->pollallowedcategories);
if (in_array($catid, $catsallowed)){

 $kunena_db = &JFactory::getDBO();
  $kunena_db->setQuery("SELECT * FROM #__fb_polls_datas AS a JOIN #__fb_polls AS b ON b.topicid=a.pollid WHERE a.pollid=$id");
  $kunena_db->query() or trigger_dberror('Unable to load poll.');
  $dataspollresult = $kunena_db->loadObjectList();  
  $kunena_db->setQuery("SELECT * FROM #__fb_polls_users WHERE userid=$kunena_my->id AND pollid=$id");
  $kunena_db->query() or trigger_dberror('Unable to load users poll.');
  $dataspollusers = $kunena_db->loadObjectList();  
  if(!isset($dataspollusers[0]->userid) && !isset($dataspollusers[0]->pollid)) {
    $dataspollusers[0]->userid = null;
    $dataspollusers[0]->pollid = null;    
  }   
  ?>  
  <div>
            <?php
            if (file_exists(KUNENA_ABSTMPLTPATH . '/fb_pathway.php')) {
                require_once (KUNENA_ABSTMPLTPATH . '/fb_pathway.php');
            }
            else {
                require_once (KUNENA_PATH_TEMPLATE_DEFAULT .DS. 'fb_pathway.php');
            }
            ?>
        </div>                           
  <div class="<?php echo $boardclass; ?>_bt_cvr1">
<div class="<?php echo $boardclass; ?>_bt_cvr2">
<div class="<?php echo $boardclass; ?>_bt_cvr3">
<div class="<?php echo $boardclass; ?>_bt_cvr4">
<div class="<?php echo $boardclass; ?>_bt_cvr5">
    <table class = "fb_blocktable" id = "fb_announcement" border = "0" cellspacing = "0" cellpadding = "0" width="100%">
        <thead>
            <tr>
                <th align="left">
                    <div class = "fb_title_cover fbm">
                        <span class = "fb_title fbl"><?php echo _KUNENA_POLL_NAME; ?> <?php echo stripslashes($dataspollresult[0]->title); ?></span>
                    </div>

                    <img id = "BoxSwitch_announcements__announcements_tbody" class = "hideshow" src = "<?php echo KUNENA_URLIMAGESPATH . 'shrink.gif' ; ?>" alt = ""/>
                </th>
            </tr>
        </thead>
        <tbody id = "announcements_tbody">          
                <tr class = "<?php echo $boardclass ;?>sectiontableentry2">
                    <td class = "td-1 fbm" align="left">
                        <div class = "anndesc">
                          <table border = "0" cellspacing = "0" cellpadding = "0" width="100%">
                          <?php for($i=0; $i < $dataspollresult[0]->options;$i++){ ?>
                            <tr><td><?php echo $dataspollresult[$i]->text; ?></td><td><img class = "jr-forum-stat-bar" src = "<?php echo KUNENA_JLIVEURL."components/com_kunena/template/default_ex/images/bar.gif"; ?>" height = "10" width = "<?php if(isset($dataspollresult[$i]->hits)) { echo ($dataspollresult[$i]->hits*25)/5; } else { echo "0"; }?>"/></td><td><?php if(isset($dataspollresult[$i]->hits)) { echo $dataspollresult[$i]->hits; } else { echo _KUNENA_POLL_NO_VOTE; } ?></td><td><?php if(isset($dataspollresult[$i]->hits)) { echo round(($dataspollresult[$i]->hits*100)/$dataspollresult[0]->voters,1)."%"; } else { echo "0%"; } ?></td></tr>
                          <?php }?>
                            <tr><td colspan="4"><?php if(empty($dataspollresult[0]->voters)){$dataspollresult[0]->voters = "0";} echo _KUNENA_POLL_VOTERS_TOTAL."<b>".$dataspollresult[0]->voters."</b>"; ?></td></tr>
                          
                          <?php if($dataspollusers[0]->userid == $kunena_my->id && $dataspollusers[0]->pollid == $id){ echo _KUNENA_POLL_SAVE_VOTE_ALREADY; }else { ?>
                          <?php if($kunena_my->id == "0") { ?><tr><td colspan="4"><?php echo _KUNENA_POLL_NOT_LOGGED; ?> </td></tr> <?php }else { ?> <tr><td colspan="4"><a href = "<?php echo CKunenaLink::GetPollURL($fbConfig, 'vote', $id, $catid);?>" /><?php echo _KUNENA_POLL_BUTTON_VOTE; ?></a><?php } } ?></td></tr>
                		</table>
                	 </div>	
        </tbody>
    </table>
    </div>
</div>
</div>
</div>
</div>
<?php } ?>
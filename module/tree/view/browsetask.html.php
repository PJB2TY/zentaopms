<?php
/**
 * The browse view file of tree module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id: browse.html.php 4796 2013-06-06 02:21:59Z zhujinyonging@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div id='featurebar'>
  <div class='heading'><i class='icon-cogs'></i> <?php echo $lang->tree->common;?>  </div>
</div>
<div class='row'>
  <div class='col-sm-6 col-md-4 col-lg-3'>
    <form class='form-condensed' method='post' target='hiddenwin' action='<?php echo $this->createLink('tree', 'updateOrder', "root={$root->id}&viewType=task");?>'>
      <div class='panel'>
        <div class='panel-heading'>
          <i class='icon-cog'></i> <strong><?php echo $title;?></strong>
        </div>
        <div class='panel-body'>
          <div id='main'><?php echo $modules;?></div>
          <div class='text-center'>
            <?php if(common::hasPriv('tree', 'updateorder')) echo html::submitButton($lang->tree->updateOrder);?>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class='col-sm-6 col-md-8 col-lg-9'>
    <form class='form-condensed' method='post' target='hiddenwin' action='<?php echo $this->createLink('tree', 'manageChild', "root={$root->id}&viewType=task");?>'>
      <div class='panel'>
        <div class='panel-heading'>
          <i class='icon-sitemap'></i> 
          <?php $manageChild = 'manageTaskChild';?>
          <?php echo $lang->tree->$manageChild;?>
        </div>
        <div class='panel-body'>
          <table class='table table-form'>
            <tr>
              <td class='parentModule'>
                <nobr>
                <?php
                echo html::a($this->createLink('tree', 'browsetask', "root={$root->id}&productID=$productID&viewType=task"), $root->name);
                echo $lang->arrow;
                foreach($parentModules as $module)
                {
                    echo html::a($this->createLink('tree', 'browsetask', "root={$root->id}&productID=$productID&moduleID=$module->id"), $module->name);
                    echo $lang->arrow;
                }
                ?>
                </nobr>
              </td>
              <td id='moduleBox'> 
                <?php
                $maxOrder = 0;
                if($newModule and !$productID)
                {
                    foreach($products as $product)
                    {
                        echo '<span>' . html::input("products[id$product->id]", $product->name, 'class=form-control disabled="true"') . '</span>';
                    }
                }
                foreach($sons as $sonModule)
                {
                    if($sonModule->order > $maxOrder) $maxOrder = $sonModule->order;
                    $disabled = $sonModule->type == 'task' ? '' : 'disabled';
                    echo "<div class='row-table' style='margin-bottom:5px;'>";
                    echo "<div class='col-table'>" . html::input("modules[id$sonModule->id]", $sonModule->name, "class='form-control' placeholder='{$lang->tree->name}' " . $disabled) . '</div>';
                    echo "<div class='col-table' style='width:70px'>" . html::input("shorts[id$sonModule->id]", $sonModule->short, "class='form-control' placeholder='{$lang->tree->short}' " . $disabled) . '</div>';
                    echo "</div>";
                }
                for($i = 0; $i < TREE::NEW_CHILD_COUNT ; $i ++)
                {
                    echo "<div class='row-table' style='margin-bottom:5px;'>";
                    echo "<div class='col-table'>" . html::input("modules[]", '', "class='form-control' placeholder='{$lang->tree->name}'") . '</div>';
                    echo "<div class='col-table' style='width:70px'>" . html::input("shorts[]", '', "class='form-control' placeholder='{$lang->tree->short}'") . '</div>';
                    echo html::hidden('branch[]', empty($module) ? 0 : $module->branch) . '</div>';
                }
                ?>
              </td>
            </tr>
            <tr>
              <td></td>
              <td colspan='2'>
                <?php 
                echo html::submitButton() . html::backButton();
                echo html::hidden('parentModuleID', $currentModuleID);
                echo html::hidden('maxOrder', $maxOrder);
                ?>      
                <input type='hidden' value='<?php echo $currentModuleID;?>' name='parentModuleID' />
              </td>
            </tr>
          </table>
        </div>
      </div>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>

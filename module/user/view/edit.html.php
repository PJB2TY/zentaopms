<?php
/**
 * The edit view of user module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id: edit.html.php 4728 2013-05-03 06:14:34Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php js::import($jsRoot . 'md5.js');?>
<div id="mainContent" class="main-content">
  <div class="center-block">
    <div class="main-header">
      <h2>
        <span class="label label-id"><?php echo $user->id;?></span>
        <strong><?php if(!common::printLink('user', 'view', "account=$user->account", $user->realname)) echo $user->realname;?> <small>(<?php echo $user->account;?>)</small></strong>
        <small><?php echo $lang->arrow . $lang->user->edit;?></small>
      </h2>
    </div>
    <form class="load-indicator main-form form-ajax" id="createForm" method="post" target='hiddenwin'>
      <table align='center' class="table table-form">
        <caption class='text-left text-muted'><?php echo $lang->user->basicInfo;?></caption>
        <tr>
          <th class='w-90px'><?php echo $lang->user->realname;?></th>
          <td class='w-p40'><?php echo html::input('realname', $user->realname, "class='form-control'");?></td>
          <th class='w-90px'><?php echo $lang->user->join;?></th>
          <td><?php echo html::input('join', formatTime($user->join), "class='form-control form-date'");?></td>  
        </tr>
        <tr>
          <th class='w-90px'><?php echo $lang->user->dept;?></th>
          <td class='w-p40'><?php echo html::select('dept', $depts, $user->dept, "class='form-control chosen'");?></td>
          <th><?php echo $lang->user->role;?></th>
          <td><?php echo html::select('role', $lang->user->roleList, $user->role, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->group->priv;?></th>
          <td colspan='3'><?php echo html::select('groups[]', $groups, $userGroups, 'size=3 multiple=multiple class="form-control chosen"');?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->gender;?></th>
          <td colspan="3"><?php echo html::radio('gender', (array)$lang->user->genderList, $user->gender);?></td>
        </tr>
      </table>
      <table align='center' class='table table-form'>
        <caption class='text-left text-muted'><?php echo $lang->user->accountInfo;?></caption>
        <tr>
          <th class='w-100px'><?php echo $lang->user->account;?></th>
          <td class='w-p40'><?php echo html::input('account', $user->account, "class='form-control'");?></td>
          <th class='w-90px'><?php echo $lang->user->email;?></th>
          <td>
            <?php echo html::input('email', $user->email, "class='form-control'");?>
            <input type='text' style="display:none"> <!-- Disable input account by browser automatically. -->
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->user->password;?></th>
          <td>
            <input type='password' style="display:none"> <!-- Disable input password by browser automatically. -->
            <span class='input-group'>
              <?php echo html::password('password1', '', "class='form-control disabled-ie-placeholder' onmouseup='checkPassword(this.value)' onkeyup='checkPassword(this.value)' placeholder='" . (!empty($config->safe->mode) ? $lang->user->placeholder->passwordStrength[$config->safe->mode] : '') . "'");?>
              <span class='input-group-addon' id='passwordStrength'></span>
            </span>
          </td>
          <th><?php echo $lang->user->password2;?></th>
          <td><?php echo html::password('password2', '', "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->commiter;?></th>
          <td><?php echo html::input('commiter', $user->commiter, "class='form-control'");?></td>
        </tr>
      </table>
      <table align='center' class='table table-form'>
        <caption class='text-left text-muted'><?php echo $lang->user->contactInfo;?></caption>
        <tr>
          <th class='w-90px'><?php echo $lang->user->mobile;?></th>
          <td class='w-p40'><?php echo html::input('mobile', $user->mobile, "class='form-control'");?></td>
          <th class='w-90px'><?php echo $lang->user->qq;?></th>
          <td><?php echo html::input('qq', $user->qq, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->gtalk;?></th>
          <td><?php echo html::input('gtalk', $user->gtalk, "class='form-control'");?></td>
          <th><?php echo $lang->user->skype;?></th>
          <td><?php echo html::input('skype', $user->skype, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->phone;?></th>
          <td><?php echo html::input('phone', $user->phone, "class='form-control'");?></td>
          <th><?php echo $lang->user->address;?></th>
          <td><?php echo html::input('address', $user->address, "class='form-control'");?></td>
        </tr>
        <tr>
          <?php if(!isset($config->user->showFields) or (strpos($config->user->showFields, 'wechat') !== false)):?>
          <th><?php echo $lang->user->wechat;?></th>
          <td><?php echo html::input('wechat', $user->wechat, "class='form-control'");?></td>
          <?php endif;?>
          <?php if(!isset($config->user->showFields) or (strpos($config->user->showFields, 'dingding') !== false)):?>
          <th><?php echo $lang->user->dingding;?></th>
          <td><?php echo html::input('dingding', $user->dingding, "class='form-control'");?></td>
          <?php endif;?>
        </tr>
        <tr>
          <?php if(!isset($config->user->showFields) or (strpos($config->user->showFields, 'slack') !== false)):?>
          <th><?php echo $lang->user->slack;?></th>
          <td><?php echo html::input('slack', $user->slack, "class='form-control'");?></td>
          <?php endif;?>
          <?php if(!isset($config->user->showFields) or (strpos($config->user->showFields, 'whatsapp') !== false)):?>
          <th><?php echo $lang->user->whatsapp;?></th>
          <td><?php echo html::input('whatsapp', $user->whatsapp, "class='form-control'");?></td>
          <?php endif;?>
        </tr>
        <tr>
          <th><?php echo $lang->user->zipcode;?></th>
          <td><?php echo html::input('zipcode', $user->zipcode, "class='form-control'");?></td>
        </tr>
      </table>
      <table align='center' class='table table-form'>
        <caption class='text-left text-muted'><?php echo $lang->user->verify;?></caption>
        <tr>
          <th class='w-verifyPassword'><?php echo $lang->user->verifyPassword;?></th>
          <td>
            <div class="required required-wrapper"></div>
            <?php echo html::password('verifyPassword', '', "class='form-control disabled-ie-placeholder' placeholder='{$lang->user->placeholder->verify}'");?>
          </td>
        </tr>
        <tr>
          <td colspan='2' class='text-center form-actions'>
            <?php echo html::submitButton();?>
            <?php echo html::backButton();?>
          </td>
        </tr>
      </table>
    </form>
    <?php echo html::hidden('verifyRand', $rand);?>
  </div>
</div>
<?php js::set('passwordStrengthList', $lang->user->passwordStrengthList)?>
<?php include '../../common/view/footer.html.php';?>

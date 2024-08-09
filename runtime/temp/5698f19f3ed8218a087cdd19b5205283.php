<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"D:\development\outwork-gambling\public/../application/index\view\user\moneymove.html";i:1723183193;}*/ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="user-scalable=no,width=device-width" />
    <meta name="baidu-site-verification" content="W8Wrhmg6wj" />
    <meta content="telephone=no" name="format-detection" />
    <meta content="1" name="jfz_login_status" />
    <link rel="stylesheet" type="text/css" href="/static/css/user.css?v=1.2" />
    <link
      rel="stylesheet"
      type="text/css"
      href="/static/css/common_user.css?v=1.2"
    />

    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <title><?php if(isset($title)): ?><?php echo $title; endif; ?></title>
    <script type="text/javascript"></script>
    <script src="/locales/trans.js"></script>
    <style>
      body {
        /* background: url("/static/images/xiafen/bg.png"); */
        background: #151e34;
      }
      .wx_cfb_entry_list thead tr {
        /* background: url("/static/images/xiafen/bg1.png"); */
        background: #202a41;
      }
      td,
      th {
        text-align: center;
      }
      .pagination {
        display: flex;
      }

      .pagination li {
        flex: 1;
      }

      .disabled {
      }

      .wx_cfb_entry_list {
        font-size: 1rem;
        /* background: #fff; */
        margin-top: 1rem;
      }

      table {
        border-collapse: collapse;
      }

      thead tr th {
        line-height: 3em;
        color: #ffffff;
        text-align: center;
      }
      .tab{
        width: 95%;
        margin: 1rem auto 0;
      }
      .tab tr td {
        line-height: 1.5em;
        border: 1px solid #e5e5e5;
        width: 20%;
        padding: 0.5rem 0;
      }

      .total-sum {
        line-height: 4rem;
        padding-left: 1.2rem;
        font-size: 1.2rem;
      }

      .total-sum em {
        /* color: #d12c25; */
      }
    </style>
   
  </head>
  <body>
    <div id="wrap">
      <div class="top-title">
        <a href="javascript:history.back(-1)" title="" data-translate-attr="title:moneymove_back"></a>
        <p data-translate="moneymove_title"><?php if(isset($title)): ?><?php echo $title; endif; ?></p>
      </div>
      <div class="wx_cfb_entry_list">
        <table align="center" width="100%" border="1" cellpadding="0" cellspacing="0">
          <thead>
            <tr align="left">
              <th width="100" data-translate="moneymove_type">类型</th>
              <th width="100" data-translate="moneymove_channel">渠道</th>
              <th width="100" data-translate="moneymove_amount">金额</th>
              <th width="100" data-translate="moneymove_application_time">申请时间</th>
              <th width="100" data-translate="moneymove_status">状态</th>
            </tr>
          </thead>
          <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
              <td>
                <?php if($vo['ctype'] == 1): ?>
                <span data-translate="moneymove_recharge">充值</span>
                <?php elseif($vo['ctype'] == 2): ?>
                <span data-translate="moneymove_withdraw">提现</span>
                <?php elseif($vo['ctype'] == 3): ?>
                <span data-translate="moneymove_admin_add">管理员加款</span>
                <?php elseif($vo['ctype'] == 4): ?>
                <span data-translate="moneymove_admin_deduct">管理员扣款</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if($vo['ctype'] == 2): if($vo['xf_qudao'] == 'wx'): ?>
                <span data-translate="moneymove_wechat">微信</span>
                <?php elseif($vo['xf_qudao'] == 'alipay'): ?>
                <span data-translate="moneymove_alipay">支付宝</span>
                <?php elseif($vo['xf_qudao'] == 'bank'): ?>
                <span data-translate="moneymove_bank">银行卡</span>
                <?php endif; else: if($vo['paytype'] == 0): ?>
                <span data-translate="moneymove_game_interface">游戏界面</span>
                <?php elseif($vo['paytype'] == 1): ?>
                <span data-translate="moneymove_wechat_transfer">微信转账</span>
                <?php elseif($vo['paytype'] == 2): ?>
                <span data-translate="moneymove_alipay_transfer">支付宝转账</span>
                <?php endif; endif; ?>
              </td>
              <td><?php echo $vo['money_m']; ?></td>
              <td><?php echo date("Y-m-d H:i:s",$vo['addtime']); ?></td>
              <td>
                <?php if($vo['status'] == 1): ?>
                <span data-translate="moneymove_success">成功</span>
                <?php elseif($vo['status'] == 2): ?>
                <span data-translate="moneymove_fail">失败</span>
                <?php else: ?>
                <span data-translate="moneymove_pending_review">等待审核</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5"><?php echo $list->render(); ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="total-sum">
        <span data-translate="moneymove_total_withdraw">总提现：</span>
        <em><?php echo $zcMyneys; ?></em>
        <span data-translate="moneymove_yuan">元</span>
      </div>
    </div>
  </body>
  
</html>

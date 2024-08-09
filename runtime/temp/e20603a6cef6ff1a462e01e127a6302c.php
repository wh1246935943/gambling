<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"/www/wwwroot/1.agrrdz.top/public/../application/index/view/user/moneymove.html";i:1711615466;}*/ ?>
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
        <a href="javascript:history.back(-1)" title=""></a>
        <p><?php if(isset($title)): ?><?php echo $title; endif; ?></p>
      </div>
      <div class="wx_cfb_entry_list">
        <table
          align="center"
          width="100%"
          border="1"
          cellpadding="0"
          cellspacing="0"
        >
          <thead>
            <tr align="left">
              <th width="100">类型</th>
              <th width="100">渠道</th>
              <th width="100">金额</th>
              <th width="100">申请时间</th>
              <th width="100">状态</th>
            </tr>
          </thead>
          <table class="tab">
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
              <td>
                <?php if($vo['ctype'] == 1): ?> 充值 <?php elseif($vo['ctype'] == 2): ?> 提现 <?php elseif($vo['ctype'] == 3): ?> 管理员加款 <?php elseif($vo['ctype'] == 4): ?> 管理员扣款
                <?php endif; ?>
              </td>
              <td>
                <?php if($vo['ctype'] == 2): if($vo['xf_qudao'] == 'wx'): ?> 微信 <?php elseif($vo['xf_qudao'] == 'alipay'): ?> 支付宝 <?php elseif($vo['xf_qudao'] == 'bank'): ?> 银行卡 <?php endif; else: if($vo['paytype'] == 0): ?> 游戏界面 <?php elseif($vo['paytype'] == 1): ?> 微信转账 <?php elseif($vo['paytype'] == 2): ?> 支付宝转账
                <?php endif; endif; ?>
              </td>
              <td><?php echo $vo['money_m']; ?></td>
              <td><?php echo date("Y-m-d H:i:s",$vo['addtime']); ?></td>
              <td>
                <?php if($vo['status'] == 1): ?> 成功 <?php elseif($vo['status'] == 2): ?> 失败 <?php else: ?>
                等待审核 <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </table>
          <tfoot>
            <tr>
              <td colspan="5"><?php echo $list->render(); ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="total-sum">总提现：<em><?php echo $zcMyneys; ?></em>元</div>
    </div>
  </body>
</html>

<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"D:\development\outwork-gambling\public/../application/index\view\user\moneygo.html";i:1723180696;}*/ ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <script src="/locales/trans.js"></script>
    <meta name="viewport" content="user-scalable=no,width=device-width" />
    <meta name="baidu-site-verification" content="W8Wrhmg6wj" />
    <meta content="telephone=no" name="format-detection">
    <meta content="1" name="jfz_login_status">
    <link rel="stylesheet" type="text/css" href="/static/css/user.css?v=1.2" />
    <link rel="stylesheet" type="text/css" href="/static/css/common_user.css?v=1.2">

    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <title><?php if(isset($title)): ?><?php echo $title; endif; ?></title>
    <script type="text/javascript"></script>

    </script>
    <style>
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

        .disabled {}

        .wx_cfb_entry_list {
            font-size: 1rem;
            background: #fff;
            margin-top: 1rem;
        }

        table {
            border-collapse: collapse;
        }

        thead tr th {
            background: #202a41;
            line-height: 3em;
            color: #FFFFFF;
            border: 1px solid #e5e5e5;
        }

        table tr td {
            border: 1px solid #e5e5e5;
            background: #202a41;
        }

        .total-sum {
            line-height: 4rem;
            padding-left: 1.2rem;
            font-size: 1rem;
            margin-bottom: 4rem;
            padding-bottom: 5rem;
        }

        .total-sum em {
            color: #d12c25;
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
            <table align="center" width="100%" border="1" cellpadding="0" cellspacing="0">
                <thead>
                    <tr align="left">
                        <th width="100" data-translate="moneygo_type">类型2</th>
                        <th width="100" data-translate="moneygo_channel">渠道</th>
                        <th width="100" data-translate="moneygo_amount">金额</th>
                        <th width="100" data-translate="moneygo_application_time">申请时间</th>
                        <th width="100" data-translate="moneygo_status">状态</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><?php if($vo['ctype'] == 1): ?> <span data-translate="moneygo_recharge">充值</span> <?php elseif($vo['ctype'] == 2): ?> <span data-translate="moneygo_withdraw">提现</span> <?php elseif($vo['ctype'] == 3): ?> <span data-translate="moneygo_admin_add">管理员加款</span> <?php elseif($vo['ctype'] == 4): ?> <span data-translate="moneygo_admin_deduct">管理员扣款</span> <?php endif; ?></td>
                        <td>
                            <?php if($vo['ctype'] == 2): if($vo['xf_qudao'] == 'wx'): ?> <span data-translate="moneygo_wechat">微信</span> <?php elseif($vo['xf_qudao'] == 'alipay'): ?> <span data-translate="moneygo_alipay">支付宝</span> <?php elseif($vo['xf_qudao'] == 'bank'): ?> <span data-translate="moneygo_bank">银行卡</span> <?php endif; else: if($vo['paytype'] == 0): ?> <span data-translate="moneygo_game_interface">游戏界面</span> <?php elseif($vo['paytype'] == 1): ?> <span data-translate="moneygo_wechat_transfer">微信转账</span> <?php elseif($vo['paytype'] == 2): ?> <span data-translate="moneygo_alipay_transfer">支付宝转账</span> <?php elseif($vo['paytype'] == 4): ?> <span data-translate="moneygo_commission_transfer">佣金转入</span> <?php endif; endif; ?>
                        </td>
                        <td><?php echo $vo['money_m']; ?></td>
                        <td><?php echo date("Y-m-d H:i:s",$vo['addtime']); ?></td>
                        <td><?php if($vo['status'] == 1): ?> <span data-translate="moneygo_success">成功</span> <?php elseif($vo['status'] == 2): ?> <span data-translate="moneygo_failed">失败</span> <?php else: ?> <span data-translate="moneygo_pending_review">等待审核</span> <?php endif; ?></td>
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
        <div class="total-sum"> <span data-translate="moneygo_total_recharge">总充值：</span><em><?php echo $zrMyneys; ?></em> <span data-translate="moneygo_yuan">元</span></div>
        
    </div>
   </body>
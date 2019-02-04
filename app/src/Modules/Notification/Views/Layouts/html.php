<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>MinexBank</title>
    <style>
        body, p, h1 {
            font-family: Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust:none;
        }
        table.table {
            width: 600px;
        }
        table.table.border {
            border: 1px solid #ededed;
        }
        table.table.table-padding {
            padding: 24px 24px 0;
        }
        table.table.table-park {
            padding: 24px 12px 0;
            text-align: center;
        }
        ul,li {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        ul.list {
            display: inline-block;
        }
        ul.list li {
            width: 120px;
            height: 120px;
            border-radius: 5px;
            background: #24e1ba;
            float: left;
            line-height: 42px;
            text-align: center;
            margin: 0 12px 36px;
            color:#ffffff;
        }
        ul.list li .park-rates {
            font-size: 30px;
            padding-top: 38px;
            display: block;
            -webkit-text-size-adjust:none;
        }
        ul.list li .park-name {
            font-size: 16px;
        }
        ul.list-social {
            text-align: center;
        }
        ul.list-social li {
            margin: 0 10px;
            display: inline-block;
        }
        td.footer-text {
            padding: 0 70px
        }
        a:hover {
            text-decoration: underline !important;
        }
        img {
            display: block;
        }
        @media only screen and (max-width: 480px) {
            table {
                position: relative;
            }
        }
        @media only screen and (max-width: 480px) {
            table.table,
            table[class="table"] {
                width: 320px!important;
            }
            td.footer-text,
            td[class="footer-text"]{
                padding: 0 10px
            }
        }
    </style>
</head>
<body bgcolor="#edeef0" style="margin: 0; padding: 0;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#edeef0" style="background-color: #edeef0;">
    <tr>
        <td bgcolor="#edeef0" width="100%">
            <table cellpadding="0" cellspacing="0" border="0" class="table" align="center">
                <tr style="height: 69px"></tr>
                <tr>
                    <td>
                        <a href="#" style="text-align: center; color: #24e1ba; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;" target="_blank">
                            <img alt="MinexBank" border="0" width="234" height="31" style="display:inline-block;" src="<?=\yii\helpers\Url::toRoute('/static/logo.png', true); ?>">
                        </a>
                    </td>
                </tr>
                <tr style="height: 24px"></tr>
            </table>
            <?= $content; ?>
            <table cellpadding="0" cellspacing="0" border="0" class="table border" align="center" style="overflow: hidden; border-radius: 5px;">
                <tr>
                    <td bgcolor="#ffffff">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-padding">
                            <tr style="height: 12px"></tr>
                            <tr>
                                <td>
                                    <span style="text-align: center; color: #6c6c6c; font-size: 16px; line-height: 1.25; -webkit-text-size-adjust:none; display: block;">Be sure you won’t miss other important news.</span>
                                    <span style="text-align: center; color: #6c6c6c; font-size: 16px; line-height: 1.25; -webkit-text-size-adjust:none; display: block;">Follow us</span>
                                </td>
                            </tr>
                            <tr><td style="height: 24px"></td></tr>
                            <tr>
                                <td>
                                    <ul class="list-social">
                                        <li>
                                            <a href="https://www.facebook.com/minexcoin/?fref=ts" style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;" target="_blank">
                                                <img alt="facebook" border="0" width="40" height="40" style="display:block;" src="<?=\yii\helpers\Url::toRoute('/static/facebook.png', true); ?>">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/minexcoin" style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;" target="_blank">
                                                <img alt="twitter" border="0" width="40" height="40" style="display:block;" src="<?=\yii\helpers\Url::toRoute('/static/twitter.png', true); ?>">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://medium.com/@minecoinorg" style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;" target="_blank">
                                                <img alt="medium" border="0" width="47" height="40" style="display:block;" src="<?=\yii\helpers\Url::toRoute('/static/medium.png', true); ?>">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://www.t.me/minexcoin" style="color: #333333; font: 10px Arial, sans-serif; line-height: 30px; -webkit-text-size-adjust:none; display: block;" target="_blank">
                                                <img alt="telegram" border="0" width="40" height="40" style="display:block;" src="<?=\yii\helpers\Url::toRoute('/static/telegram.png', true); ?>">
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr><td style="height: 24px"></td></tr>
                            <tr>
                                <td style="height: 2px; background: #ededed;"></td>
                            </tr>
                            <tr><td style="height: 24px"></td></tr>
                            <tr>
                                <td class="footer-text" style="text-align: center;">
                                        <span style="color: #6c6c6c; font-size: 10px; line-height: 16px; -webkit-text-size-adjust:none; display: block;">
                                            You are being contacted because you subscribed on MinexBank notifications. Please do not reply to this message. If you have any questions, please contact Customer Support at
                                            <a href="mailto:support@minexsystems.com" href="#" style="color: #29a8ff; font-size: 10px; line-height: 16px; -webkit-text-size-adjust:none; display: block;" target="_blank">support@minexsystems.com</a>
                                        </span>
                                </td>
                            </tr>
                            <tr><td style="height: 24px"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td style="height: 24px;"></td></tr>
</table>

</body>
</html>

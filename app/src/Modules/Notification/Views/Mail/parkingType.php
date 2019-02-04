<?php
use \yii\helpers\HtmlPurifier;
?>
<?php $this->beginContent('@app/Modules/Notification/Views/Layouts/html.php'); ?>
<table cellpadding="0" cellspacing="0" border="0" class="table border" align="center" style="overflow: hidden; border-radius: 5px;">
    <tr>
        <td bgcolor="#ffffff">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-padding">
                <tr>
                    <td>
                        <h1 style="font-size: 20px;margin:0;color:#6c6c6c;margin-bottom: 24px;margin-top:5px">
                            <strong>Dear client!</strong>
                        </h1>
                        <span style="color: #6c6c6c; font-size: 16px; line-height: 20px; -webkit-text-size-adjust:none; display: block;">
                                Parking rates were changed by MinexBank's algorithm.
                        </span>
                        <span style="color: #6c6c6c; font-size: 16px; line-height: 20px; -webkit-text-size-adjust:none; display: block;">
                                You can find it important for your parking strategy,
                        </span>
                        <span style="color: #6c6c6c; font-size: 16px; line-height: 20px; -webkit-text-size-adjust:none; display: block; margin-bottom: 24px;">
                                so please see current rates below.
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="height: 2px; background: #ededed;"></td>
                </tr>
            </table>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-padding table-park">
                <tr>
                    <td>
                        <?= HtmlPurifier::process($message); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="table" align="center">
    <tr style="height: 24px"></tr>
</table>
<?php $this->endContent(); ?>
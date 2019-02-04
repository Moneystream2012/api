<?php
use \yii\helpers\HtmlPurifier;
?>
<?php $this->beginContent('@app/Modules/Notification/Views/Layouts/html.php'); ?>
<table cellpadding="0" cellspacing="0" border="0" class="table border" align="center" style="overflow: hidden; border-radius: 5px;">
    <tr>
        <td bgcolor="#ffffff">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-padding">
                <tr>
                    <td style="color: #6c6c6c; font-size: 16px; line-height: 1.25; -webkit-text-size-adjust:none;">
                        <?= HtmlPurifier::process($message); ?>
                    </td>
                </tr>
                <tr style="height: 24px;">
                </tr>
            </table>
        </td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="table" align="center">
    <tr style="height: 24px"></tr>
</table>
<?php $this->endContent(); ?>
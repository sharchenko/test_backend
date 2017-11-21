<?php


namespace console\controllers;


use backend\models\Category;
use yii\console\Controller;

class MenuController extends Controller
{

    public function actionExport($name = null)
    {
        if (!$name) $name = 'menu_' . date('Y-m-d');
        $name .= '.pdf';

        $content = $this->renderFile(\Yii::getAlias("@backend/modules/admin/views/category/pdf.php"), [
            'models' => Category::find()
                ->with('dishes')
                ->all()
        ]);

        $fullPath = \Yii::getAlias("@backend/web/files/$name");

        if (file_put_contents($fullPath, $this->formatPdf($content))) {
            echo '=============================================' . PHP_EOL;
            echo "Доступно в $fullPath" . PHP_EOL;
        }
    }

    private function formatPdf($content)
    {
        $mpdf = new \mPDF();
        $mpdf->WriteHTML($content);
        return $mpdf->Output('', 'S');
    }
}
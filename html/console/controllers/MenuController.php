<?php


namespace console\controllers;


use app\models\Category;
use yii\console\Controller;

class MenuController extends Controller
{

    public function actionExport($name = null)
    {
        \Yii::setAlias('@app', dirname(dirname(__DIR__)) . '/app'); //TODO консольный контроллер переопределяет @app, на будущее исполльщовать другое пространство имен

        if (!$name) $name = 'menu_' . date('Y-m-d');
        $name .= '.pdf';

        $content = $this->renderFile(\Yii::getAlias("@app/modules/admin/views/category/pdf.php"), [
            'models' => Category::find()
                ->with('dishes')
                ->all()
        ]);

        $fullPath = \Yii::getAlias("@app/web/files/$name");

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
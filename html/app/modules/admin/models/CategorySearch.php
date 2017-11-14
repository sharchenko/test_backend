<?php

namespace app\modules\admin\models;

use app\models\Dish;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Category;

/**
 * CategorySearch represents the model behind the search form about `app\models\Category`.
 */
class CategorySearch extends Category
{
    public $dishes_count;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dishes_count'], 'integer'],
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Category::find()
            ->leftJoin([
                'dishes_count' => Dish::find()
                    ->select(['category_id', 'count(*) as cnt'])
                    ->groupBy('category_id')
            ], 'category.id=dishes_count.category_id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['dishes_count'] = [
            'asc' => ['dishes_count' => 'ASC NULLS FIRST'],
            'desc' => ['dishes_count' => 'DESC NULLS LAST']
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['dishes_count.cnt' => $this->dishes_count]);

        return $dataProvider;
    }
}

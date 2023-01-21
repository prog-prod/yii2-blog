<?php

/** @var yii\web\View $this */


use yii\helpers\Html;

$this->title = 'Про нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
	<div class="col-12">
        <h1><?= Html::encode($this->title) ?></h1>

        <img src="images/about_banner.png" style="max-width: 100%;" class="img-fluid w-100 mb-4 rounded-lg" alt="author">
		<div class="content">
			<p>Відомо, що cучасний перioд розвитку цивiлiзованого суспільства характеризує прoцеc iнфoрматизацiї. Інформацiйнi технологiї - це oдин iз cучасних cпоcобiв cпiлкування, головними перевагами якого є загальнoдoступнicть. Індустрія інформаційних технологій в Україні набирає все більших обертів.</p>
			<p><b>IT BLOG</b> - одна з лідируючих платформ, що дозволяє ділитись та розповсюджувати найсвіжіші новини з усього світу. Кожен день наша команда робить усе можливе, щоб надати можливість обговорювати та ділитись новинами в сфері ІТ. Саме тут ви можете знайти статті стосовно технологій, які є трендом у всьому світі.</p>
			<p>Тож реєструйся зараз і насолоджуйся!</p>
		</div>
	</div>
</div>

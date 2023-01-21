<?php

namespace app\commands;

use app\models\Article;
use app\models\Category;
use app\models\Comment;
use app\models\Tag;
use app\models\TagArticle;
use app\models\User;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\en_US\Text;
use yii\console\Controller;
use yii\console\ExitCode;
/**
 * This command fill database test data.
 * @param string $message the message to be echoed.
 * @return int Exit code
 */
class SeederController extends Controller
{

    private Generator $faker;
    private array $users = [];
    private int $minArticlesNumber = 10;
    private int $maxArticleNumber = 40;
    private array $authors = [
        [
            'username' => 'author 1',
            'email' => 'author1@example.com',
        ], [
            'username' => 'author 2',
            'email' => 'author2@example.com',
        ],
    ];

    private array $post_images = [
        'post-1.jpg',
        'post-2.jpg',
        'post-3.jpg',
        'post-4.jpg',
        'post-5.jpg',
        'post-6.jpg',
        'post-7.jpg',
        'post-8.jpg',
        'post-9.jpg',
        'post-10.jpg',
    ];
    private array $categories = [
        'Кібербезпека',
        'Електричні новини',
        'Інженерія',
        'Фінанси',
        'IT',
        'Управління мобільними пристроями',
        'Онбортування та вихід',
        'Проактивна ІТ-підтримка',
        'Розробка продукту',
        'Віддалена підтримка',
        'Технологічні тенденції',
        'Вирішення проблем',
    ];

    private array $tags = [
        'технічні новини',
        'нова технологія',
        'що таке технологія',
        'визначення технології',
        'наука і технології',
        'новітні технології',
        'останні новини технологій',
        'крута техніка',
        'технічний прогрес',
        'огляд технології',
        'сучасні технології',
        'технічні статті',
        'новини гаджетів',
        'наука технологія',
        'технічні сайти',
        'технічні оновлення',
    ];

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->faker = Factory::create();
        $this->faker->addProvider(new Text($this->faker));
    }

    /**
     * This command seed all
     * @return int Exit code
     * @throws \Throwable
     */
    public function actionSeedData(): int
    {

        if(empty(User::findAll(['role' => User::ROLE_ADMIN]))){
            $this->print('generating admin...');
            $this->actionCreateAdmin();
        }
        if(empty(Category::find()->all())){
            $this->print('generating categories...');
            $this->generateCategories();
        }
        if(empty(Tag::find()->all())){
            $this->print('generating tags...');
            $this->generateTags();
        }
        if(empty(Article::find()->all())){
            $this->print('generating articles...');
            $this->generateArticles();
        }

        if(empty(TagArticle::find()->all())){
            $this->print('generating tag articles...');
            $this->generateArticlesTags();
        }

        if(empty(Comment::find()->all())){
            $this->print('generating comments...');
            $this->generateComments();
        }

        return ExitCode::OK;
    }

    private function print($message) {
        echo  PHP_EOL."\033[32m$message\033[0m";
    }

    private function generateArticles()
    {
        $categories = Category::find()->all();
        $authors = User::findAll(['role' => User::ROLE_AUTHOR]);
        if (empty($authors)) {
            $this->createAuthors();
            $authors = User::findAll(['role' => User::ROLE_AUTHOR]);
        }
        $countArticles = $this->faker->numberBetween($this->minArticlesNumber,$this->maxArticleNumber);
       for ($i=0;$i<$countArticles;$i++) {
           $article = new Article();
           $article->user_id = $authors[array_rand($authors)]->id;
           $article->image = join(',', $this->faker->randomElements($this->post_images,$this->faker->numberBetween(0,4)));
           $article->category_id = $categories[array_rand($categories)]->id;
           $article->title = $this->faker->sentence($this->faker->numberBetween(3,7));
           $article->content = $this->faker->text(1000);
           $article->createdAt = date("Y-m-d H:i:s");
           $article->save(false);
       }

    }

    private function generateCategories()
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            foreach ($this->categories as $category) {
                $cat = new Category();
                $cat->name = $category;
                $cat->save(false);
            }
            $transaction->commit();
        } catch (\Throwable $ex) {
            $transaction->rollBack();
            throw $ex;
        }

    }

    private function generateTags()
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            foreach ($this->tags as $tag) {
                $t = new Tag();
                $t->name = $tag;
                $t->save(false);
            }
            $transaction->commit();
        } catch (\Throwable $ex) {
            $transaction->rollBack();
            throw $ex;
        }

    }

    /**
     * @param array $users
     */
    public function setUsers(array $users): void
    {
        $this->users = $users;
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    private function initActiveRecords($records, $classname): array
    {
        $return = [];
        for ($i = 0; $i < count($records); $i++) {
            $return[] = new $classname();
        }

        return $return;
    }

    /**
     * This command create the admin user
     * @return int Exit code
     */
    public function actionCreateAdmin(): int
    {
        $passw = \Yii::$app->params['adminPassword'];
        $username = \Yii::$app->params['adminUsername'];
        $email = \Yii::$app->params['adminEmail'];

        // create admin user
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->role = User::ROLE_ADMIN;
        $user->setPassword($passw);
        $user->generateAuthKey();

        if ($user->save()) {
            return ExitCode::OK;
        }

        return ExitCode::NOUSER;

    }

    private function createAuthors(): int
    {
        $passw = \Yii::$app->params['author_password'];

        foreach ($this->authors as $author) {
            // create admin user
            $user = new User();
            $user->username = $author['username'];
            $user->email = $author['email'];
            $user->role = User::ROLE_AUTHOR;
            $user->setPassword($passw);
            $user->generateAuthKey();

            $user->save(false);
        }

        return ExitCode::OK;

    }

    private function generateArticlesTags()
    {
        $tags = Tag::find()->all();
        $articles = Article::find()->all();

        foreach ($articles as $article) {
            foreach ($this->faker->randomElements($tags,3) as $tag) {
                $tag->link('articles', $article);
            }
        }
    }

    private function generateComments(){

        $articles = Article::find()->all();
        $articlesWithComments = $this->faker->randomElements($articles,$this->faker->numberBetween($this->minArticlesNumber, count($articles)));
        $this->setUsers(User::find()->all());

        foreach ($articlesWithComments as $article) {
            $user = $this->faker->randomElement($this->getUsers());
            $this->generateComment($user, $article);
        }
    }

    private function generateComment($user, $article)
    {
            $comment = new Comment();
            $comment->user_id = $user->id;
            $comment->article_id = $article->id;
            $generateAnswer = $this->faker->numberBetween(0,1);
            if($generateAnswer){
                $user = $this->faker->randomElement($this->getUsers());
                $comment->comment_id = $this->generateComment($user, $article);
            }

            $comment->text = $this->faker->sentences($this->faker->numberBetween(3,10),true);
            $comment->datetime = $this->faker->dateTime()->format('Y-m-d H:i:s');

            if($comment->save(false)) {
                return $comment->getPrimaryKey();
            }

            return null;
    }

}